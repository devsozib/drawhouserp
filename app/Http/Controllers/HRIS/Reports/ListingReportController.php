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
use App\Models\HRIS\Setup\Districts;
use App\Models\HRIS\Setup\Religions;
use App\Models\HRIS\Setup\Department;
use App\Models\HRIS\Database\Employee;
use App\Models\HRIS\Setup\Designation;
use App\Models\Library\General\Company;
use App\Models\HRIS\Setup\CategoryEmployee;
use App\Models\HRIS\Setup\DepartureReasons;

class ListingReportController extends Controller
{
    public function index() {
        if (getAccess('view')) {
            $deptlist = Department::orderBy('id', 'ASC')->where('C4S','Y')->get();
            $desglist = Designation::orderBy('id', 'ASC')->where('C4S','Y')->get();
            $districtlist = Districts::orderBy('id', 'ASC')->pluck('Name','id');
            $religionlist = Religions::orderBy('id', 'ASC')->pluck('Religion','ReligionID');
            $resonlist = DepartureReasons::orderBy('id', 'ASC')->where('C4S','Y')->pluck('Reason','ReasonID');

            return view('hris.reports.listing.index', compact('deptlist','desglist','districtlist','religionlist','resonlist'));             
        } else {
            return redirect()->back()->with('warning', getNotify(5));
        }
    }
    
    public function preview(){
        if (getAccess('view')) {
            $userid = Sentinel::getUser()->id;
            $CreatedBy = $userid;
            $attributes = Input::all();
            $rules = [
                'title' => 'required|numeric',
                'viewmode' => 'required|numeric',
                'Date' => 'required|date_format:Y-m-d',
            ];            
            $validation = Validator::make($attributes, $rules);
            if ($validation->fails()) {               
                return redirect()->back()->with('error',getNotify(4))->withErrors($validation)->withInput();
            }else{
                $title = $attributes['title'];
                $viewmode = $attributes['viewmode'];
                $date = $attributes['Date'];
                if (isset($attributes['AllConcern']) == true) {
                    $comp_id = getCompanyIds();
                } else {
                    $comp_id = [$attributes['company_id']];
                }

                if ($title == 1) {
                    $rules = [
                        'DepartmentID' => 'required',
                        'DesignationID' => 'required',
                    ];
                    $validation = Validator::make($attributes, $rules);
                    if ($validation->fails()) {
                        return redirect()->back()->with('error',getNotify(4))->withErrors($validation)->withInput();
                    }else{
                        $empids = Employee::orderBy('EmployeeID','ASC')->whereIn('company_id',$comp_id)->whereBetween('EmployeeID',[$attributes['EmployeeF'],$attributes['EmployeeL']])->whereIn('DepartmentID',$attributes['DepartmentID'])->whereIn('DesignationID',$attributes['DesignationID'])->where('ReasonID','N')->where('JoiningDate','<=',$date)->OrWhere('LeavingDate','>',$date)->whereIn('company_id',$comp_id)->whereBetween('EmployeeID',[$attributes['EmployeeF'],$attributes['EmployeeL']])->whereIn('DepartmentID',$attributes['DepartmentID'])->whereIn('DesignationID',$attributes['DesignationID'])->where('JoiningDate','<=',$date)->pluck('EmployeeID');
                        
                        if(count($empids) > 0){
                            $employees = DB::table('hr_database_employee_basic as basic')
                                ->leftJoin('hr_setup_designation', 'basic.DesignationID', '=', 'hr_setup_designation.id')
                                ->leftJoin('hr_setup_department', 'basic.DepartmentID', '=', 'hr_setup_department.id')
                                ->select('basic.company_id','basic.EmployeeID','basic.Name','hr_setup_designation.Designation','hr_setup_department.Department','basic.JoiningDate','basic.Line','basic.DepartmentID','basic.DesignationID')
                                ->whereIn('basic.EmployeeID',$empids)
                                ->orderBy('basic.EmployeeID','ASC')
                                ->get();
                            $empdeptids = collect($employees)->unique('DepartmentID')->sortBy('DepartmentID')->pluck('DepartmentID');
                            $departments = Department::orderBy('id','ASC')->whereIn('id',$empdeptids)->get();
                            $ppsize = 1;
                            $caption = 'Department-wise Listing of Employees';
                            $parameter = compact('title','employees','departments','date','CreatedBy','ppsize','caption');
                            \LogActivity::addToLog('View '.$caption);

                            if($viewmode==1){
                                return view('hris.reports.listing.preview', $parameter);  
                            }elseif($viewmode==2){
                                $pdf = PDF::loadView('hris.reports.listing.pdf', $parameter)->setPaper('A4', 'portrait');                
                                return $pdf->stream("$caption".".pdf");
                            } 
                        }else {
                            return redirect()->back()->with('warning','Employee Data Not Found');
                        }
                    }
                } elseif ($title == 2) {
                    $rules = [
                        'DepartmentID' => 'required',
                        'DesignationID' => 'required',
                    ];
                    $validation = Validator::make($attributes, $rules);
                    if ($validation->fails()) {
                        return redirect()->back()->with('error',getNotify(4))->withErrors($validation)->withInput();
                    }else{
                        $empids = Employee::orderBy('EmployeeID','ASC')->whereIn('company_id',$comp_id)->whereBetween('EmployeeID',[$attributes['EmployeeF'],$attributes['EmployeeL']])->whereIn('DepartmentID',$attributes['DepartmentID'])->whereIn('DesignationID',$attributes['DesignationID'])->where('ReasonID','N')->where('JoiningDate','<=',$date)->OrWhere('LeavingDate','>',$date)->whereIn('company_id',$comp_id)->whereBetween('EmployeeID',[$attributes['EmployeeF'],$attributes['EmployeeL']])->whereIn('DepartmentID',$attributes['DepartmentID'])->whereIn('DesignationID',$attributes['DesignationID'])->where('JoiningDate','<=',$date)->pluck('EmployeeID');
                        
                        if(count($empids) > 0){
                            $employees = DB::table('hr_database_employee_basic as basic')
                                ->leftJoin('hr_setup_designation', 'basic.DesignationID', '=', 'hr_setup_designation.id')
                                ->leftJoin('hr_setup_department', 'basic.DepartmentID', '=', 'hr_setup_department.id')
                                ->select('basic.company_id','basic.EmployeeID','basic.Name','hr_setup_designation.Designation','hr_setup_department.Department','basic.JoiningDate','basic.Line','basic.DepartmentID','basic.DesignationID')
                                ->whereIn('basic.EmployeeID',$empids)
                                ->orderBy('basic.EmployeeID','ASC')
                                ->get();
                            $empdeptids = collect($employees)->unique('DesignationID')->sortBy('DesignationID')->pluck('DesignationID');
                            $departments = Designation::orderBy('id','ASC')->whereIn('id',$empdeptids)->get();
                            $ppsize = 1;
                            $caption = 'Designation-wise Listing of Employees';
                            $parameter = compact('title','employees','departments','date','CreatedBy','ppsize','caption');
                            \LogActivity::addToLog('View '.$caption);

                            if($viewmode==1){
                                return view('hris.reports.listing.preview', $parameter);  
                            }elseif($viewmode==2){
                                $pdf = PDF::loadView('hris.reports.listing.pdf', $parameter)->setPaper('A4', 'portrait');                
                                return $pdf->stream("$caption".".pdf");
                            } 
                        }else {
                            return redirect()->back()->with('warning','Employee Data Not Found');
                        }
                    }
                } elseif ($title == 3) {
                    $rules = [
                        'DepartmentID' => 'required',
                        'DesignationID' => 'required',
                    ];
                    $validation = Validator::make($attributes, $rules);
                    if ($validation->fails()) {
                        return redirect()->back()->with('error',getNotify(4))->withErrors($validation)->withInput();
                    }else{
                        $empids = Employee::orderBy('EmployeeID','ASC')->whereIn('company_id',$comp_id)->whereBetween('EmployeeID',[$attributes['EmployeeF'],$attributes['EmployeeL']])->whereIn('DepartmentID',$attributes['DepartmentID'])->whereIn('DesignationID',$attributes['DesignationID'])->where('ReasonID','N')->where('JoiningDate','<=',$date)->OrWhere('LeavingDate','>',$date)->whereIn('company_id',$comp_id)->whereBetween('EmployeeID',[$attributes['EmployeeF'],$attributes['EmployeeL']])->whereIn('DepartmentID',$attributes['DepartmentID'])->whereIn('DesignationID',$attributes['DesignationID'])->where('JoiningDate','<=',$date)->pluck('EmployeeID');
                        
                        if(count($empids) > 0){
                            $employees = DB::table('hr_database_employee_basic as basic')
                                ->leftJoin('hr_setup_designation', 'basic.DesignationID', '=', 'hr_setup_designation.id')
                                ->leftJoin('hr_setup_department', 'basic.DepartmentID', '=', 'hr_setup_department.id')
                                ->leftJoin('hr_database_employee_salary as salary', 'basic.EmployeeID', '=', 'salary.EmployeeID')
                                ->select('basic.company_id','basic.EmployeeID','basic.Name','hr_setup_designation.Designation','hr_setup_department.Department','basic.JoiningDate','basic.Line','basic.DepartmentID','basic.DesignationID','salary.GrossSalary','salary.Basic','salary.MedicalAllowance','salary.HomeAllowance','salary.Conveyance','salary.HousingAllowance','salary.FoodAllowance','salary.OtherAllowance','salary.ServiceCharge','salary.ServiceChargePer')
                                ->whereIn('basic.EmployeeID',$empids)
                                ->orderBy('basic.EmployeeID','ASC')
                                ->get();
                            $empdeptids = collect($employees)->unique('DepartmentID')->sortBy('DepartmentID')->pluck('DepartmentID');
                            $departments = Department::orderBy('id','ASC')->whereIn('id',$empdeptids)->get();
                            $ppsize = 2;
                            $caption = 'Department-wise Listing of Employees (With Salary)';
                            $parameter = compact('title','employees','departments','date','CreatedBy','ppsize','caption');
                            \LogActivity::addToLog('View '.$caption);

                            if($viewmode==1){
                                return view('hris.reports.listing.preview', $parameter);  
                            }elseif($viewmode==2){
                                $pdf = PDF::loadView('hris.reports.listing.pdf', $parameter)->setPaper('A4', 'landscape');                
                                return $pdf->stream("$caption".".pdf");
                            } 
                        }else {
                            return redirect()->back()->with('warning','Employee Data Not Found');
                        }
                    }
                } else {
                    return redirect()->back()->with('warning',getNotify(10));
                }
            }
        }else{
            return redirect()->back()->with('warning', getNotify(5));
        }
    }

}
