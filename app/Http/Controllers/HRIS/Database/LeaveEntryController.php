<?php

namespace App\Http\Controllers\HRIS\Database;

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

class LeaveEntryController extends Controller
{
    public function index(Request $request)
    {
        if (getAccess('view')) {
            $reasonlist = LeaveReasons::orderBy('id', 'ASC')->where('C4S', 'Y')->pluck('Reason', 'id');
            $lvlimits = LeaveDefinitions::orderBy('id', 'ASC')->where('C4S', 'Y')->get();
            $leavetypelist = $lvlimits->where('C4S', 'Y')->pluck('Description', 'TypeID');

            return view('hris.database.leaveentry.index', compact('leavetypelist', 'reasonlist', 'lvlimits'));
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
                if($empchk){
                    $start_date = $attributes['StartDate'];
                    $end_date = $attributes['EndDate'];
                    $lvempid = $attributes['EmployeeID'];
                    $year = Carbon::parse($start_date)->year; 
                    $month = Carbon::parse($start_date)->month;
                        
                    $check = DB::select(DB::raw("SELECT * FROM hr_database_leave_individual WHERE EmployeeID = '$lvempid' AND ((StartDate BETWEEN '$start_date' AND '$end_date') OR (EndDate BETWEEN '$start_date' AND '$end_date') OR (StartDate < '$start_date' AND EndDate > '$end_date')) LIMIT 1"));
                    $checksal = DB::table('payroll_tools_processsalary')->where('Year',$year)->where('Month',$month)->where('Confirmed','Y')->first();
                    if($check || $checksal){
                        if($checksal){
                            Flash::message('Salary Process Already Confirmed','danger');
                            return redirect()->back()->with('warning', 'Salary Process Already Confirmed')->withInput();
                        }else{
                            return redirect()->back()->with('warning', getNotify(6))->withInput();
                        }
                    }else{
                        $startyear = Carbon::parse($start_date)->year;
                        $endyear = Carbon::parse($end_date)->year;
                        $days = $attributes['Days'];
                        if($days > 0 && $startyear == $endyear){
                            $lastids = LeaveIndividual::orderBy('id','DESC')->pluck('LeaveID')->first();
                            if($lastids == null){
                                $lastid = 1;
                            }elseif(substr($lastids,2,2) == date("y")){
                                $lastid = substr($lastids,4,6)+1;
                            }else{
                                $lastid = 1;
                            }
                            $adjustedid = str_pad($lastid, 6, "0", STR_PAD_LEFT);            
                            $leaveid = 'LV'.date("y").$adjustedid; 
                                
                            $employee = new LeaveIndividual();
                            $employee->LeaveID = $leaveid;
                            $employee->EmployeeID = $attributes['EmployeeID'];
                            $employee->LeaveTypeID = $attributes['LeaveTypeID'];
                            $employee->ApplicationDate = $attributes['ApplicationDate'];
                            $employee->InputDate = $attributes['ApplicationDate'];
                            $employee->StartDate = $start_date;
                            $employee->EndDate = $end_date;
                            $employee->Notes = 'From Leave Entry';
                            $employee->CreatedBy = $userid;
                            $employee->save();

                            \LogActivity::addToLog('Add Leave Entry Leave ID ' . $employee->LeaveID . ' & Emp ID ' . $employee->EmployeeID . ' & From ' . $employee->StartDate . ' To ' . $employee->EndDate);
                            return redirect()->back()->with('success', getNotify(1));
                        }else{
                            return redirect()->back()->with('warning', 'Please Provide The Correct Date Range')->withInput();
                        }
                    }
                }else{
                    return redirect()->back()->with('warning', getNotify(8))->withInput();
                }
            }
        } else {
            return redirect()->back()->with('warning', getNotify(5));
        }
    }
}
