<?php

namespace App\Http\Controllers\HRIS\Reports;

use DB;
use PDF;
use Input;
use Redirect;
use Sentinel;
use Validator;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\HRIS\Setup\Department;
use App\Models\HRIS\Database\Employee;
use App\Models\HRIS\Setup\Designation;
use App\Models\Library\General\Company;
use App\Models\HRIS\Setup\CategoryEmployee;
use App\Models\HRIS\Tools\ProcessAttendance;

class AttendanceReportController extends Controller
{
    public function index()
    {
        if (getAccess('view')) {
            $deptlist = Department::orderBy('id', 'ASC')->where('C4S', 'Y')->get();
            $desglist = Designation::orderBy('id', 'ASC')->where('C4S', 'Y')->get();
            $categorylist = CategoryEmployee::orderBy('id', 'ASC')->pluck('Category', 'CategoryID');

            return view('hris.reports.attendance.index', compact('deptlist', 'desglist', 'categorylist'));
        } else {
            return redirect()->back()->with('warning', getNotify(5));
        }
    }

    public function preview()
    {
        if (getAccess('view')) {
            $userid = Sentinel::getUser()->id;
            $CreatedBy = $userid;
            $attributes = Input::all();
            $rules = [
                'title' => 'required|numeric',
                'viewmode' => 'required|numeric',
            ];
            $validation = Validator::make($attributes, $rules);
            if ($validation->fails()) {
                return redirect()->back()->with('error', getNotify(4))->withErrors($validation)->withInput();
            } else {
                $title = $attributes['title'];
                $viewmode = $attributes['viewmode'];
                if (isset($attributes['AllConcern']) == true) {
                    $comp_id = getCompanyIds();
                } else {
                    $comp_id = [$attributes['company_id']];
                }

                if ($title == 1) {
                    $rules = [
                        'DepartmentID' => 'required',
                        'DesignationID' => 'required',
                        'StartDate' => 'required|date',
                        'EndDate' => 'required|date',
                    ];
                    $validation = Validator::make($attributes, $rules);
                    if ($validation->fails()) {
                        return redirect()->back()->with('error', getNotify(4))->withErrors($validation)->withInput();
                    } else {
                        $start_date = $attributes['StartDate'];
                        $end_date = $attributes['EndDate'];                      
                        $empids = Employee::orderBy('EmployeeID', 'ASC')->whereIn('company_id',$comp_id)->whereBetween('EmployeeID', [$attributes['EmployeeF'], $attributes['EmployeeL']])->whereIn('DepartmentID', $attributes['DepartmentID'])->whereIn('DesignationID', $attributes['DesignationID'])->where('ReasonID', 'N')->where('JoiningDate', '<=', $end_date)->OrWhere('LeavingDate', '>', $start_date)->whereIn('company_id',$comp_id)->whereBetween('EmployeeID', [$attributes['EmployeeF'], $attributes['EmployeeL']])->whereIn('DepartmentID', $attributes['DepartmentID'])->whereIn('DesignationID', $attributes['DesignationID'])->where('JoiningDate', '<=', $end_date)->pluck('EmployeeID');
                        if (count($empids) > 0) {
                            $punchrecords = ProcessAttendance::orderBy('EmployeeID', 'ASC')->orderBy('WorkDate', 'ASC')->whereIn('EmployeeID', $empids)->whereBetween('WorkDate', [$start_date, $end_date])->get();
                            $punchempids = collect($punchrecords)->unique('EmployeeID')->sortBy('EmployeeID')->pluck('EmployeeID');
                            $employees = DB::table('hr_database_employee_basic as basic')
                                ->leftJoin('hr_setup_designation', 'basic.DesignationID', '=', 'hr_setup_designation.id')
                                ->leftJoin('hr_setup_department', 'basic.DepartmentID', '=', 'hr_setup_department.id')
                                ->select('basic.company_id', 'basic.EmployeeID', 'basic.Name', 'hr_setup_designation.Designation', 'hr_setup_department.Department', 'basic.Line', 'basic.DepartmentID', 'basic.DesignationID')
                                ->whereIn('basic.EmployeeID', $punchempids)
                                ->orderBy('basic.EmployeeID', 'ASC')
                                ->get();
                            $ppsize = 1;
                            $caption = 'Employees-wise Job Card';
                            $parameter = compact('title', 'employees', 'start_date', 'end_date', 'punchrecords', 'CreatedBy', 'ppsize','caption');
                            \LogActivity::addToLog('View '.$caption);

                            if ($viewmode == 1) {
                                return view('hris.reports.attendance.preview', $parameter);
                            } elseif ($viewmode == 2) {
                                $pdf = PDF::loadView('hris.reports.attendance.jobcard', $parameter)->setPaper('A4', 'portrait');
                                return $pdf->stream("$caption".".pdf"); 
                            }
                        } else {
                            return redirect()->back()->with('warning', 'Employee Data Not Found');
                        }
                    }
                } elseif ($title == 2) {
                    $rules = [
                        'DepartmentID' => 'required',
                        'DesignationID' => 'required',
                        'StartDate' => 'required|date',
                        'EndDate' => 'required|date',
                    ];
                    $validation = Validator::make($attributes, $rules);
                    if ($validation->fails()) {
                        return redirect()->back()->with('error', getNotify(4))->withErrors($validation)->withInput();
                    } else {
                        $start_date = $attributes['StartDate'];
                        $end_date = $attributes['EndDate'];                      
                        $empids = Employee::orderBy('EmployeeID', 'ASC')->whereIn('company_id',$comp_id)->whereBetween('EmployeeID', [$attributes['EmployeeF'], $attributes['EmployeeL']])->whereIn('DepartmentID', $attributes['DepartmentID'])->whereIn('DesignationID', $attributes['DesignationID'])->where('ReasonID', 'N')->where('JoiningDate', '<=', $end_date)->OrWhere('LeavingDate', '>', $start_date)->whereIn('company_id',$comp_id)->whereBetween('EmployeeID', [$attributes['EmployeeF'], $attributes['EmployeeL']])->whereIn('DepartmentID', $attributes['DepartmentID'])->whereIn('DesignationID', $attributes['DesignationID'])->where('JoiningDate', '<=', $end_date)->pluck('EmployeeID');
                        if (count($empids) > 0) {
                            $employees = DB::table('hr_database_employee_basic as basic')
                                ->leftJoin('payroll_tools_processattendance as attn', 'basic.EmployeeID', '=', 'attn.EmployeeID')
                                ->leftJoin('hr_setup_designation', 'basic.DesignationID', '=', 'hr_setup_designation.id')
                                ->leftJoin('hr_setup_department', 'basic.DepartmentID', '=', 'hr_setup_department.id')
                                ->select('basic.company_id','basic.EmployeeID','basic.Name','hr_setup_designation.Designation','hr_setup_department.Department','basic.Line','basic.DepartmentID','basic.DesignationID','attn.*')
                                ->whereIn('basic.EmployeeID',$empids)
                                ->whereBetween('WorkDate', [$start_date, $end_date])
                                ->whereNotNull('attn.StartPunch')
                                ->orderBy('basic.EmployeeID','ASC')
                                ->orderBy('WorkDate','ASC')
                                ->get();
                            $empdeptids = collect($employees)->unique('DepartmentID')->sortBy('DepartmentID')->pluck('DepartmentID');
                            $departments = Department::orderBy('id','ASC')->whereIn('id',$empdeptids)->get();
                            $ppsize = 1;
                            $caption = 'Department-wise Absence';
                            $parameter = compact('title', 'employees', 'start_date', 'end_date', 'departments', 'CreatedBy', 'ppsize','caption');
                            \LogActivity::addToLog('View '.$caption);

                            if ($viewmode == 1) {
                                return view('hris.reports.attendance.preview', $parameter);
                            } elseif ($viewmode == 2) {
                                $pdf = PDF::loadView('hris.reports.attendance.jobcard', $parameter)->setPaper('A4', 'portrait');
                                return $pdf->stream("$caption".".pdf"); 
                            }
                        } else {
                            return redirect()->back()->with('warning', 'Employee Data Not Found');
                        }
                    }
                } elseif ($title == 3) {
                    $rules = [
                        'DepartmentID' => 'required',
                        'DesignationID' => 'required',
                        'StartDate' => 'required|date',
                        'EndDate' => 'required|date',
                    ];
                    $validation = Validator::make($attributes, $rules);
                    if ($validation->fails()) {
                        return redirect()->back()->with('error', getNotify(4))->withErrors($validation)->withInput();
                    } else {
                        $start_date = $attributes['StartDate'];
                        $end_date = $attributes['EndDate'];                      
                        $empids = Employee::orderBy('EmployeeID', 'ASC')->whereIn('company_id',$comp_id)->whereBetween('EmployeeID', [$attributes['EmployeeF'], $attributes['EmployeeL']])->whereIn('DepartmentID', $attributes['DepartmentID'])->whereIn('DesignationID', $attributes['DesignationID'])->where('ReasonID', 'N')->where('JoiningDate', '<=', $end_date)->OrWhere('LeavingDate', '>', $start_date)->whereIn('company_id',$comp_id)->whereBetween('EmployeeID', [$attributes['EmployeeF'], $attributes['EmployeeL']])->whereIn('DepartmentID', $attributes['DepartmentID'])->whereIn('DesignationID', $attributes['DesignationID'])->where('JoiningDate', '<=', $end_date)->pluck('EmployeeID');
                        if (count($empids) > 0) {
                            $employees = DB::table('hr_database_employee_basic as basic')
                                ->leftJoin('payroll_tools_processattendance as attn', 'basic.EmployeeID', '=', 'attn.EmployeeID')
                                ->leftJoin('hr_setup_designation', 'basic.DesignationID', '=', 'hr_setup_designation.id')
                                ->leftJoin('hr_setup_department', 'basic.DepartmentID', '=', 'hr_setup_department.id')
                                ->select('basic.id','basic.EmployeeID','basic.Name','hr_setup_designation.Designation','hr_setup_department.Department','basic.Line','basic.DepartmentID','basic.DesignationID','attn.*')
                                ->whereIn('basic.EmployeeID',$empids)
                                ->whereBetween('WorkDate', [$start_date, $end_date])
                                ->whereNull('attn.StartPunch')
                                ->where('attn.AttnType','AB')
                                ->orderBy('basic.EmployeeID','ASC')
                                ->orderBy('WorkDate','ASC')
                                ->get();
                            $empdeptids = collect($employees)->unique('DepartmentID')->sortBy('DepartmentID')->pluck('DepartmentID');
                            $departments = Department::orderBy('id','ASC')->whereIn('id',$empdeptids)->get();
                            $ppsize = 1;
                            $caption = 'Department-wise Absence';
                            $parameter = compact('title', 'employees', 'start_date', 'end_date', 'departments', 'CreatedBy', 'ppsize','caption');
                            \LogActivity::addToLog('View '.$caption);

                            if ($viewmode == 1) {
                                return view('hris.reports.attendance.preview', $parameter);
                            } elseif ($viewmode == 2) {
                                $pdf = PDF::loadView('hris.reports.attendance.jobcard', $parameter)->setPaper('A4', 'portrait');
                                return $pdf->stream("$caption".".pdf"); 
                            }
                        } else {
                            return redirect()->back()->with('warning', 'Employee Data Not Found');
                        }
                    }
                } elseif ($title == 4) {
                    $rules = [
                        'DepartmentID' => 'required',
                        'DesignationID' => 'required',
                        'StartDate' => 'required|date',
                        'EndDate' => 'required|date',
                    ];
                    $validation = Validator::make($attributes, $rules);
                    if ($validation->fails()) {
                        return redirect()->back()->with('error', getNotify(4))->withErrors($validation)->withInput();
                    } else {
                        $start_date = $attributes['StartDate'];
                        $end_date = $attributes['EndDate'];                      
                        $empids = Employee::orderBy('EmployeeID', 'ASC')->whereIn('company_id',$comp_id)->whereBetween('EmployeeID', [$attributes['EmployeeF'], $attributes['EmployeeL']])->whereIn('DepartmentID', $attributes['DepartmentID'])->whereIn('DesignationID', $attributes['DesignationID'])->where('ReasonID', 'N')->where('JoiningDate', '<=', $end_date)->OrWhere('LeavingDate', '>', $start_date)->whereIn('company_id',$comp_id)->whereBetween('EmployeeID', [$attributes['EmployeeF'], $attributes['EmployeeL']])->whereIn('DepartmentID', $attributes['DepartmentID'])->whereIn('DesignationID', $attributes['DesignationID'])->where('JoiningDate', '<=', $end_date)->pluck('EmployeeID');
                        if (count($empids) > 0) {
                            $start_date = Carbon::parse($start_date)->startOfDay()->format('Y-m-d H:i:s');
                            $end_date = Carbon::parse($end_date)->endOfDay()->format('Y-m-d H:i:s');
                            $employees = DB::table('hr_database_employee_basic as basic')
                                ->leftJoin('payroll_tools_readpunchrecords as attn', 'basic.EmployeeID', '=', 'attn.EmployeeID')
                                ->leftJoin('hr_setup_designation', 'basic.DesignationID', '=', 'hr_setup_designation.id')
                                ->leftJoin('hr_setup_department', 'basic.DepartmentID', '=', 'hr_setup_department.id')
                                ->select('basic.id','basic.EmployeeID','basic.Name','hr_setup_designation.Designation','hr_setup_department.Department','basic.Line','basic.DepartmentID','basic.DesignationID','attn.*')
                                ->whereIn('basic.EmployeeID',$empids)
                                ->whereBetween('AttnDate', [$start_date, $end_date])
                                ->orderBy('basic.EmployeeID','ASC')
                                ->orderBy('AttnDate','ASC')
                                ->get();
                            $empdeptids = collect($employees)->unique('DepartmentID')->sortBy('DepartmentID')->pluck('DepartmentID');
                            $departments = Department::orderBy('id','ASC')->whereIn('id',$empdeptids)->get();
                            $ppsize = 1;
                            $caption = 'Employee-wise Punch';
                            $parameter = compact('title', 'employees', 'start_date', 'end_date', 'departments', 'CreatedBy', 'ppsize','caption');
                            \LogActivity::addToLog('View '.$caption);

                            if ($viewmode == 1) {
                                return view('hris.reports.attendance.preview', $parameter);
                            } elseif ($viewmode == 2) {
                                $pdf = PDF::loadView('hris.reports.attendance.jobcard', $parameter)->setPaper('A4', 'portrait');
                                return $pdf->stream("$caption".".pdf"); 
                            }
                        } else {
                            return redirect()->back()->with('warning', 'Employee Data Not Found');
                        }
                    }
                } else {
                    return redirect()->back()->with('warning', getNotify(10));
                }
            }
        } else {
            return redirect()->back()->with('warning', getNotify(5));
        }
    }
}
