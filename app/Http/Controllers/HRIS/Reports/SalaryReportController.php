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
use App\Models\HRIS\Tools\ProcessSalary;
use App\Models\HRIS\Setup\CategoryEmployee;
use App\Models\HRIS\Tools\ProcessAttendance;

class SalaryReportController extends Controller
{
    public function index()
    {
        if (getAccess('view')) {
            $deptlist = Department::orderBy('id', 'ASC')->where('C4S', 'Y')->get();
            $desglist = Designation::orderBy('id', 'ASC')->where('C4S', 'Y')->get();
            $categorylist = CategoryEmployee::orderBy('id', 'ASC')->pluck('Category', 'CategoryID');

            return view('hris.reports.salary.index', compact('deptlist', 'desglist', 'categorylist'));
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
                        'Date' => 'required|date_format:Y-m-d',
                        'Year' => 'required|numeric',
                        'Month' => 'required|numeric',
                    ];
                    $validation = Validator::make($attributes, $rules);
                    if ($validation->fails()) {
                        return redirect()->back()->with('error', getNotify(4))->withErrors($validation)->withInput();
                    } else {
                        $date = $attributes['Date']; $year = $attributes['Year']; $month = $attributes['Month'];
                        $empids = ProcessSalary::orderBy('id','ASC')->where('Year',$year)->where('Month',$month)->where('ReasonID','N')->whereIn('company_id',$comp_id)->whereBetween('EmployeeID',[$attributes['EmployeeF'],$attributes['EmployeeL']])->whereIn('DepartmentID',$attributes['DepartmentID'])->whereIn('DesignationID',$attributes['DesignationID'])->pluck('id');
                        
                        if (count($empids) > 0) {
                            $employees = DB::table('payroll_tools_processsalary as psalary')
                                ->leftJoin('hr_database_employee_basic as basic', 'psalary.EmployeeID', '=', 'basic.EmployeeID')
                                ->leftJoin('hr_setup_designation', 'psalary.DesignationID', '=', 'hr_setup_designation.id')
                                ->leftJoin('hr_setup_department', 'psalary.DepartmentID', '=', 'hr_setup_department.id')
                                ->select('basic.company_id','basic.Name','basic.JoiningDate','hr_setup_designation.Designation','hr_setup_department.Department','psalary.*')
                                ->whereIn('psalary.id',$empids)
                                ->orderBy('psalary.EmployeeID','ASC')
                                ->get();
                            $empdeptids = collect($employees)->unique('DepartmentID')->sortBy('DepartmentID')->pluck('DepartmentID');
                            $departments = Department::orderBy('id','ASC')->whereIn('id',$empdeptids)->get();

                            $ppsize = 3;
                            $caption = 'Employees-wise Payroll Sheet';
                            $parameter = compact('title', 'employees','departments', 'year', 'month', 'date', 'CreatedBy', 'ppsize','caption');
                            \LogActivity::addToLog('View '.$caption);

                            if ($viewmode == 1) {
                                return view('hris.reports.salary.preview', $parameter);
                            } elseif ($viewmode == 2) {
                                $pdf = PDF::loadView('hris.reports.salary.pdf', $parameter)->setPaper('A3', 'landscape');
                                return $pdf->stream("$caption ".getMonthName($month).'-'."$year.pdf"); 
                            }
                        } else {
                            return redirect()->back()->with('warning', 'Employee Data Not Found');
                        }
                    }
                } elseif ($title == 2) {
                    $rules = [
                        'DepartmentID' => 'required',
                        'DesignationID' => 'required',
                        'Date' => 'required|date_format:Y-m-d',
                        'Year' => 'required|numeric',
                        'Month' => 'required|numeric',
                    ];
                    $validation = Validator::make($attributes, $rules);
                    if ($validation->fails()) {
                        return redirect()->back()->with('error', getNotify(4))->withErrors($validation)->withInput();
                    } else {
                        $date = $attributes['Date']; $year = $attributes['Year']; $month = $attributes['Month'];
                        $empids = ProcessSalary::orderBy('id','ASC')->where('Year',$year)->where('Month',$month)->where('ReasonID','N')->whereIn('company_id',$comp_id)->whereBetween('EmployeeID',[$attributes['EmployeeF'],$attributes['EmployeeL']])->whereIn('DepartmentID',$attributes['DepartmentID'])->whereIn('DesignationID',$attributes['DesignationID'])->pluck('id');
                        
                        if (count($empids) > 0) {
                            $employees = DB::table('payroll_tools_processsalary as psalary')
                                ->leftJoin('hr_database_employee_basic as basic', 'psalary.EmployeeID', '=', 'basic.EmployeeID')
                                ->leftJoin('hr_setup_designation', 'psalary.DesignationID', '=', 'hr_setup_designation.id')
                                ->leftJoin('hr_setup_department', 'psalary.DepartmentID', '=', 'hr_setup_department.id')
                                ->select('basic.company_id','basic.Name','basic.JoiningDate','hr_setup_designation.Designation','hr_setup_department.Department','psalary.*')
                                ->whereIn('psalary.id',$empids)
                                ->orderBy('psalary.EmployeeID','ASC')
                                ->get();
                            $empdeptids = collect($employees)->unique('DepartmentID')->sortBy('DepartmentID')->pluck('DepartmentID');
                            $departments = Department::orderBy('id','ASC')->whereIn('id',$empdeptids)->get();

                            $ppsize = 3;
                            $caption = 'Employees-wise Payroll Sheet';
                            $parameter = compact('title', 'employees','departments', 'year', 'month', 'date', 'CreatedBy', 'ppsize','caption');
                            \LogActivity::addToLog('View '.$caption);

                            if ($viewmode == 1) {
                                return view('hris.reports.salary.preview', $parameter);
                            } elseif ($viewmode == 2) {
                                $pdf = PDF::loadView('hris.reports.salary.pdf', $parameter)->setPaper('A4', 'landscape');
                                return $pdf->stream("$caption ".getMonthName($month).'-'."$year.pdf"); 
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
