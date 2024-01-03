<?php

namespace App\Http\Controllers\Employee\LeaveManagement;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\HRIS\Database\Employee;
use App\Models\HRIS\Database\EmployeePersonal;
use App\Models\HRIS\Setup\Department;
use App\Models\HRIS\Setup\Designation;
use App\Models\HRIS\Setup\LeaveDefinitions;
use App\Models\HRIS\Setup\LeaveReasons;
use App\Models\HRIS\Database\LeaveApplication;
use App\Models\HRIS\Database\LeaveIndividual;
use App\Models\HRIS\Tools\ForwardPermission;
use App\Models\HRIS\Tools\ApprovePermission;
use App\Models\HRIS\Tools\HROptions;
use App\Models\Users;
use Input;
use Validator;
use Flash;
use Carbon\Carbon;
use Redirect;
use Sentinel;
use DB;

class LeaveApplicationController extends Controller
{
    public function index(Request $request)
    {
        if (getAccess('view')) {
            $reasonlist = LeaveReasons::orderBy('id', 'ASC')->where('C4S', 'Y')->pluck('Reason', 'id');
            $lvlimits = LeaveDefinitions::orderBy('id', 'ASC')->where('C4S', 'Y')->get();
            $leavetypelist = $lvlimits->where('C4S', 'Y')->pluck('Description', 'TypeID');

            return view('employee.leave_management.index', compact('leavetypelist', 'reasonlist', 'lvlimits'));
        } else {
            return redirect()->back()->with('warning', getNotify(5));
        }
    }

    public function store(Request $request)
    {
        if (getAccess('create')) {
            $userid = Sentinel::getUser()->id;
            $attributes = Input::all();
            $rules = [
                'EmployeeID' => 'required|numeric',
                'LeaveTypeID' => 'required|max:3',
                'StartDate' => 'required|date',
                'EndDate' => 'required|date',
                'ReasonID' => 'required|numeric',
            ];
            $validation = Validator::make($attributes, $rules);
            if ($validation->fails()) {
                return redirect()->back()->with('error', getNotify(4))->withErrors($validation)->withInput();
            } else {
                $empchk = Employee::orderBy('id', 'ASC')->where('EmployeeID', $attributes['EmployeeID'])->first();
                if ($empchk) {
                    $start_date = $attributes['StartDate'];
                    $end_date = $attributes['EndDate'];
                    $lvempid = $attributes['EmployeeID'];
                    $today = Carbon::now()->format('Y-m-d');
                    $year = Carbon::parse($start_date)->year;
                    $month = Carbon::parse($start_date)->month;
                    $flag = 0;

                    $check = DB::select(DB::raw("SELECT * FROM hr_database_leave_individual WHERE EmployeeID = '$lvempid' AND ((StartDate BETWEEN '$start_date' AND '$end_date') OR (EndDate BETWEEN '$start_date' AND '$end_date') OR (StartDate < '$start_date' AND EndDate > '$end_date')) LIMIT 1"));
                    $check2 = DB::select(DB::raw("SELECT * FROM hr_database_leave_application WHERE EmployeeID = '$lvempid' AND IsDiscard = 'N' AND IsRejected = 'N' AND ((StartDate BETWEEN '$start_date' AND '$end_date') OR (EndDate BETWEEN '$start_date' AND '$end_date') OR (StartDate < '$start_date' AND EndDate > '$end_date')) LIMIT 1"));
                    $checksal = DB::table('payroll_tools_processsalary')->where('Year', $year)->where('Month', $month)->where('Confirmed', 'Y')->first();
                    $checkattn = DB::table('payroll_tools_processattendance')->where('EmployeeID', $lvempid)->whereBetween('WorkDate', [$start_date, $end_date])->where('StartPunch', '!=', '0000-00-00 00:00:00')->first();
                    if (($check || $check2 || $checksal || $checkattn || getPreventLVEntry($start_date))) {
                        if ($check || $check2 || $checksal || $checkattn) {
                            if ($checksal) {
                                $msg = 'Salary Process Already Confirmed';
                            } elseif ($checkattn) {
                                $msg = 'Attendance Data Already Exists';
                            } else {
                                $msg = getNotify(6);
                            }
                        } else {
                            $msg = 'Can Not Enter The Leave Previous Month After Date: ' . getPreventLVEntryMsg($start_date);
                        }
                        return redirect()->back()->with('warning', $msg)->withInput();
                    } else {
                        $appdate = $attributes['ApplicationDate'] . ' ' . Carbon::now()->format('H:i');
                        $days = $attributes['Days'];
                        $startyear = Carbon::parse($start_date)->year;
                        $endyear = Carbon::parse($end_date)->year;
                        $chkleavelimit = HROptions::orderBy('id', 'ASC')->pluck('CheckLeaveLimit')->first();

                        if ($chkleavelimit == 'N') {
                            if ($days > 0 && $startyear == $endyear) {
                                $flag = 1;
                            } else {
                                return redirect()->back()->with('warning', 'Please Provide The Correct Date Range')->withInput();
                            }
                        } else {
                            if ($days > 0 && $startyear == $endyear) {
                                $lvt = $attributes['LeaveTypeID'];
                                $bal = $attributes['B'.$attributes['LeaveTypeID']];
                                if ($days <= $bal) {
                                    $flag = 1;
                                } else {
                                    return redirect()->back()->with('warning', 'Your leave balance is less than your expectation or empty')->withInput();
                                }
                            } else {
                                return redirect()->back()->with('warning', 'Please Provide The Correct Date Range')->withInput();
                            }
                        }

                        if ($flag == 1) {
                            $lastids = LeaveApplication::orderBy('id', 'DESC')->pluck('FormID')->first();
                            if ($lastids == null) {
                                $lastid = 1;
                            } elseif (substr($lastids, 0, 2) == date("y")) {
                                $lastid = substr($lastids, 2, 6) + 1;
                            } else {
                                $lastid = 1;
                            }
                            $adjustedid = str_pad($lastid, 6, "0", STR_PAD_LEFT);
                            $formid = date("y") . $adjustedid;

                            $employee = new LeaveApplication();
                            $employee->FormID = $formid;
                            $employee->fill($attributes);
                            $employee->ApplicationDate = $appdate;
                            $employee->CreatedBy = $userid;
                            $employee->save();

                            //SendLeaveMsg($employee->FormID);

                            \LogActivity::addToLog('Add Leave Application Form ID ' . $employee->FormID . ' & Emp ID ' . $employee->EmployeeID . ' & From ' . $employee->StartDate . ' To ' . $employee->EndDate);
                            return redirect()->back()->with('success', getNotify(1));
                        } else {
                            return redirect()->back()->with('warning', getNotify(10))->withInput();
                        }
                    }
                } else {
                    return redirect()->back()->with('warning', getNotify(8))->withInput();
                }
            }
        } else {
            return redirect()->back()->with('warning', getNotify(5));
        }
    }
}
