<?php

namespace App\Http\Controllers\HRIS\Database;

use DB;
use Input;
use Redirect;
use Sentinel;
use Validator;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\HRIS\Tools\HROptions;
use App\Models\HRIS\Setup\Department;
use App\Models\HRIS\Database\Employee;
use App\Models\HRIS\Setup\Designation;
use App\Models\HRIS\Database\AdvanceLoan;
use App\Models\HRIS\Database\EmployeeSalary;
use App\Models\HRIS\Database\IndividualIncrement;

class IncrementController extends Controller
{
    public function index() {
        if (getAccess('view')) {
            $inctypelists = DB::table('hr_setup_incrementtype')->orderBy('id','ASC')->pluck('IncType','id');
            return view('hris.database.increment.index', compact('inctypelists'));             
        } else {
            return redirect()->back()->with('warning', getNotify(5));
        }
    }

    public function getSearch() {
        if (getAccess('view')) {
            $query = Input::get('search');
            $id = Employee::orderBy('EmployeeID', 'ASC')->where('EmployeeID', $query)->pluck('id')->first();
            if ($id > 0) {
                return redirect()->action('HRIS\Database\IncrementController@show', $id);
            } else {
                return redirect()->action('HRIS\Database\IncrementController@index')->with('info', getNotify(7))->withInput();
            }
        } else {
            return redirect()->back()->with('warning', getNotify(5));
        }
    }

    public function store(){
        if (getAccess('create')) {
            $userid = Sentinel::getUser()->id;
            $hroptions = HROptions::orderBy('id','ASC')->first();
            $attributes = Input::all();
            if($attributes['formid'] == 1){
                $empid = Employee::where('EmployeeID',$attributes['EmployeeID'])->pluck('id')->first();
                $empsalid = Employee::where('EmployeeID',$attributes['EmployeeID'])->pluck('id')->first();
                $employeebasic = Employee::find($empid);
                $employeesalary = EmployeeSalary::find($empsalid);
                $rules = [
                    'EmployeeID' => 'required|numeric',
                    'IncrementDate' => 'required|date',
                    'EffectiveDate' => 'required|date',
                    'ArrearDate' => 'required|date',
                    'IncSource' => 'required|numeric',
                    'PayType' => 'required|numeric',
                    'IncrementAmnt' => 'required|numeric',
                    'IncType' => 'required|numeric',
                    'Remarks' => 'max:50',
                ];           
                $validation = Validator::make($attributes, $rules);
                if ($validation->fails()) {               
                    return redirect()->back()->with('error',getNotify(4))->withErrors($validation)->withInput();
                }else{
                    $check = IndividualIncrement::where('EmployeeID',$attributes['EmployeeID'])->whereIn('IncType',[1,2])->where('IncrementDate',$attributes['IncrementDate'])->first();
                    if($check){
                        return redirect()->back()->with('warning',getNotify(6))->withInput();
                    }else{
                        $indvinc = new IndividualIncrement();
                        $indvinc->EmployeeID = $employeebasic->EmployeeID;
                        $indvinc->DepartmentID = $employeebasic->DepartmentID;
                        $indvinc->DesignationID = $employeebasic->DesignationID;
                        $indvinc->NewDepartmentID = $attributes['NewDepartmentID'];
                        $indvinc->NewDesignationID = $attributes['NewDesignationID'];
                        $indvinc->IncrementDate = $attributes['IncrementDate'];
                        $indvinc->EffectiveDate = $attributes['EffectiveDate'];
                        $indvinc->ArrearDate = $attributes['ArrearDate'];
                        $indvinc->GrossSalary = $employeesalary->GrossSalary;
                        $indvinc->Basic = $employeesalary->Basic;
                        $indvinc->HomeAllowance = $employeesalary->HomeAllowance;
                        $indvinc->MedicalAllowance = $employeesalary->MedicalAllowance;
                        $indvinc->Conveyance = $employeesalary->Conveyance;
                        $indvinc->FoodAllowance = $employeesalary->FoodAllowance;
                        $indvinc->HousingAllowance = $employeesalary->HousingAllowance;
                        $indvinc->OtherAllowance = $employeesalary->OtherAllowance;
                        $indvinc->IncSource = $attributes['IncSource'];
                        $indvinc->PayType = $attributes['PayType'];
                        $indvinc->IncrementAmnt = $attributes['IncrementAmnt'];
                        $indvinc->IncType = $attributes['IncType'];
                        $indvinc->Remarks = $attributes['Remarks'];
                        $indvinc->CreatedBy = $userid;
                        $indvinc->save();

                        \LogActivity::addToLog('Add Employee Increment '.$attributes['EmployeeID']);
                        return redirect()->back()->with('success',getNotify(1));
                    }
                }
            }elseif($attributes['formid'] == 2){
                dd('This page is underconstruction');
                $startdate = Carbon::parse($attributes['EffectiveDate'])->format('Y-m-d'); $enddate = Carbon::parse($attributes['IncrementDate'])->format('Y-m-d'); $emperrdata = null;
                //$startdate = '2021-04-01'; $enddate = '2021-05-31'; $emperrdata = null;
                if($attributes['IncType'] == 1){
                    $rules = [
                        'incfile' => 'required',
                        'IncrementDate' => 'required|date',
                        'EffectiveDate' => 'required|date',
                        'ArrearDate' => 'required|date',
                        'IncrementPercentBasic' => 'required_without_all:IncrementPercentGross,IncrementAmountGross|between:0,50',
                        'IncrementPercentGross' => 'required_without_all:IncrementPercentBasic,IncrementAmountGross|between:0,50',
                        'IncrementAmountGross' => 'required_without_all:IncrementPercentBasic,IncrementPercentGross|between:0,99999',
                        'IncType' => 'numeric',
                        'Remarks' => 'max:50',
                    ];            
                    $validation = Validator::make($attributes, $rules);
                    if ($validation->fails()) {               
                        return redirect()->back()->with('error',getNotify(4))->withErrors($validation)->withInput();
                    }else{
                        $file = File::get($attributes['incfile']);
                        $punchs = explode("\n", $file);
                        if(count($punchs) > 0){
                            $i = 0;
                            foreach($punchs as $data){
                                $temp = explode("|", $data);
                                if(count($temp) == 2){
                                    $amount = 0; $incpb = 0; $incpg = 0;
                                    if($attributes['IncrementPercentBasic'] > 0){
                                        $empid = $temp[0]; $incpb = $temp[1];
                                    }elseif($attributes['IncrementPercentGross'] > 0){
                                        $empid = $temp[0]; $incpg = $temp[1];
                                    }elseif($attributes['IncrementAmountGross'] > 0){
                                        $empid = $temp[0]; $amount = $temp[1];
                                    }else{
                                        $empid = 0;
                                    }
                                    
                                    $employee = DB::table('pmis_database_employee_basic')
                                        ->leftJoin('pmis_database_employee_salary', 'pmis_database_employee_basic.EmployeeID', '=', 'pmis_database_employee_salary.EmployeeID')
                                        ->select('pmis_database_employee_basic.EmployeeID','pmis_database_employee_basic.DepartmentID','pmis_database_employee_basic.DesignationID','pmis_database_employee_basic.Line','pmis_database_employee_basic.DepartmentID','pmis_database_employee_basic.DesignationID','pmis_database_employee_salary.GrossSalary','pmis_database_employee_salary.Basic','pmis_database_employee_salary.MedicalAllowance','pmis_database_employee_salary.HomeAllowance','pmis_database_employee_salary.FoodAllowance','pmis_database_employee_salary.Conveyance')
                                        ->where('pmis_database_employee_basic.EmployeeID',$empid)
                                        ->where('ReasonID','N')
                                        ->where('JoiningDate','<=',$enddate)
                                        ->orWhere('LeavingDate','>',$startdate)
                                        ->where('JoiningDate','<=',$enddate)
                                        ->where('pmis_database_employee_basic.EmployeeID',$empid)
                                        ->first();
                                    if($employee){
                                        $check = IndividualIncrement::where('EmployeeID',$employee->EmployeeID)->whereIn('IncType',[1,2])->where('IncrementDate',$attributes['IncrementDate'])->first();
                                        if($check == null){
                                            $indvinc = new IndividualIncrement();
                                            $indvinc->EmployeeID = $employee->EmployeeID;
                                            $indvinc->Line = $employee->Line;
                                            $indvinc->DepartmentID = $employee->DepartmentID;
                                            $indvinc->DesignationID = $employee->DesignationID;
                                            $indvinc->NewDepartmentID = $employee->DepartmentID;
                                            $indvinc->NewDesignationID = $employee->DesignationID;
                                            $indvinc->IncrementDate = $attributes['IncrementDate'];
                                            $indvinc->EffectiveDate = $attributes['EffectiveDate'];
                                            $indvinc->ArrearDate = $attributes['ArrearDate'];
                                            $indvinc->GrossSalary = $employee->GrossSalary;
                                            $indvinc->Basic = $employee->Basic;
                                            $indvinc->HomeAllowance = $employee->HomeAllowance;
                                            $indvinc->MedicalAllowance = $employee->MedicalAllowance;
                                            $indvinc->FoodAllowance = $employee->FoodAllowance;
                                            $indvinc->Conveyance = $employee->Conveyance;
                                            $indvinc->IncrementPercentBasic = $incpb;
                                            $indvinc->IncrementPercentGross = $incpg;
                                            $indvinc->IncrementAmountGross = $amount;
                                            $indvinc->IncType = $attributes['IncType'];
                                            $indvinc->Remarks = $attributes['Remarks'];
                                            $indvinc->CreatedBy = $userid;
                                            $indvinc->save();
                                            \LogActivity::addToLog('Add Increment From Text File To ID: '.$employee->EmployeeID);
                                        }else{
                                            \LogActivity::addToLog('Failed Increment To ID: '.$employee->EmployeeID);
                                            $i++; $emperrdata = $emperrdata.'<br>'.$empid;
                                        }
                                    }else{
                                        \LogActivity::addToLog('Failed Increment To ID: '.$empid);
                                        $i++; $emperrdata = $emperrdata.'<br>'.$empid;
                                    }
                                }
                            }                     
                            \LogActivity::addToLog('Add Increment From Text File');
                            if($i == 0){
                                return redirect()->back()->with('success',getNotify(1));
                            }else{
                                return redirect()->back()->with('warning','Increment Information Successfully Added and Failed Increment '.$i.' & Employee ID: '.$emperrdata);
                            }
                        }else{
                            return redirect()->back()->with('warning','No Data Records Found In Given Text File. Please Try Again With Valid Text Data');
                        }
                    }
                }elseif($attributes['IncType'] == 2){
                    $rules = [
                        'incfile' => 'required',
                        'IncrementDate' => 'required|date',
                        'EffectiveDate' => 'required|date',
                        'ArrearDate' => 'required|date',
                        'IncrementPercentBasic' => 'required_without_all:IncrementPercentGross,IncrementAmountGross|between:0,50',
                        'IncrementPercentGross' => 'required_without_all:IncrementPercentBasic,IncrementAmountGross|between:0,50',
                        'IncrementAmountGross' => 'required_without_all:IncrementPercentBasic,IncrementPercentGross|between:0,99999',
                        'IncType' => 'numeric',
                        'Remarks' => 'max:50',
                    ];            
                    $validation = Validator::make($attributes, $rules);
                    if ($validation->fails()) {               
                        return redirect()->back()->with('error',getNotify(4))->withErrors($validation)->withInput();
                    }else{
                        $file = File::get($attributes['incfile']);
                        $punchs = explode("\n", $file);
                        if(count($punchs) > 0){
                            $i = 0;
                            foreach($punchs as $data){
                                $temp = explode("|", $data);
                                if(count($temp) == 4){
                                    $amount = 0; $incpb = 0; $incpg = 0;
                                    if($attributes['IncrementPercentBasic'] > 0){
                                        $empid = $temp[0]; $deptid = $temp[1]; $desgid = $temp[2]; $incpb = $temp[3];
                                    }elseif($attributes['IncrementPercentGross'] > 0){
                                        $empid = $temp[0]; $deptid = $temp[1]; $desgid = $temp[2]; $incpg = $temp[3];
                                    }elseif($attributes['IncrementAmountGross'] > 0){
                                        $empid = $temp[0]; $deptid = $temp[1]; $desgid = $temp[2]; $amount = $temp[3];
                                    }else{
                                        $empid = 0;
                                    }
                                    
                                    $employee = DB::table('pmis_database_employee_basic')
                                        ->leftJoin('pmis_database_employee_salary', 'pmis_database_employee_basic.EmployeeID', '=', 'pmis_database_employee_salary.EmployeeID')
                                        ->select('pmis_database_employee_basic.EmployeeID','pmis_database_employee_basic.DepartmentID','pmis_database_employee_basic.DesignationID','pmis_database_employee_basic.Line','pmis_database_employee_basic.DepartmentID','pmis_database_employee_basic.DesignationID','pmis_database_employee_salary.GrossSalary','pmis_database_employee_salary.Basic','pmis_database_employee_salary.MedicalAllowance','pmis_database_employee_salary.HomeAllowance','pmis_database_employee_salary.FoodAllowance','pmis_database_employee_salary.Conveyance')
                                        ->where('pmis_database_employee_basic.EmployeeID',$empid)
                                        ->where('ReasonID','N')
                                        ->where('JoiningDate','<=',$enddate)
                                        ->orWhere('LeavingDate','>',$startdate)
                                        ->where('JoiningDate','<=',$enddate)
                                        ->where('pmis_database_employee_basic.EmployeeID',$empid)
                                        ->first();
                                    if($employee){
                                        $check = IndividualIncrement::where('EmployeeID',$employee->EmployeeID)->whereIn('IncType',[1,2])->where('IncrementDate',$attributes['IncrementDate'])->first();
                                        if($check == null){
                                            $indvinc = new IndividualIncrement();
                                            $indvinc->EmployeeID = $employee->EmployeeID;
                                            $indvinc->Line = $employee->Line;
                                            $indvinc->DepartmentID = $employee->DepartmentID;
                                            $indvinc->DesignationID = $employee->DesignationID;
                                            $indvinc->NewDepartmentID = $deptid;
                                            $indvinc->NewDesignationID = $desgid;
                                            $indvinc->IncrementDate = $attributes['IncrementDate'];
                                            $indvinc->EffectiveDate = $attributes['EffectiveDate'];
                                            $indvinc->ArrearDate = $attributes['ArrearDate'];
                                            $indvinc->GrossSalary = $employee->GrossSalary;
                                            $indvinc->Basic = $employee->Basic;
                                            $indvinc->HomeAllowance = $employee->HomeAllowance;
                                            $indvinc->MedicalAllowance = $employee->MedicalAllowance;
                                            $indvinc->FoodAllowance = $employee->FoodAllowance;
                                            $indvinc->Conveyance = $employee->Conveyance;
                                            $indvinc->IncrementPercentBasic = $incpb;
                                            $indvinc->IncrementPercentGross = $incpg;
                                            $indvinc->IncrementAmountGross = $amount;
                                            $indvinc->IncType = $attributes['IncType'];
                                            $indvinc->Remarks = $attributes['Remarks'];
                                            $indvinc->CreatedBy = $userid;
                                            $indvinc->save();
                                            \LogActivity::addToLog('Add Increment With Promotion From Text File To ID: '.$employee->EmployeeID);
                                        }else{
                                            \LogActivity::addToLog('Failed Increment With Promotion To ID: '.$employee->EmployeeID);
                                            $i++; $emperrdata = $emperrdata.'<br>'.$empid;
                                        }
                                    }else{
                                        \LogActivity::addToLog('Failed Increment With Promotion To ID: '.$empid);
                                        $i++; $emperrdata = $emperrdata.'<br>'.$empid;
                                    }
                                }
                            }                     
                            \LogActivity::addToLog('Add Increment With Promotion From Text File');
                            if($i == 0){
                                return redirect()->back()->with('success',getNotify(1));
                            }else{
                                return redirect()->back()->with('warning','Increment Information Successfully Added and Failed Increment '.$i.' & Employee ID: '.$emperrdata);
                            }
                        }else{
                            return redirect()->back()->with('warning','No Data Records Found In Given Text File. Please Try Again With Valid Text Data');
                        }
                    }
                }elseif($attributes['IncType'] == 3){
                    $rules = [
                        'incfile' => 'required',
                        'IncrementDate' => 'required|date',
                        'EffectiveDate' => 'required|date',
                        'ArrearDate' => 'required|date',
                        'IncType' => 'numeric',
                        'Remarks' => 'max:50',
                    ];            
                    $validation = Validator::make($attributes, $rules);
                    if ($validation->fails()) {               
                        return redirect()->back()->with('error',getNotify(4))->withErrors($validation)->withInput();
                    }else{
                        $file = File::get($attributes['incfile']);
                        $punchs = explode("\n", $file);
                        if(count($punchs) > 0){
                            $i = 0;
                            foreach($punchs as $data){
                                $temp = explode("|", $data);
                                if(count($temp) == 3){
                                    $empid = $temp[0]; $deptid = $temp[1]; $desgid = $temp[2];
                                    $employee = DB::table('pmis_database_employee_basic')
                                        ->leftJoin('pmis_database_employee_salary', 'pmis_database_employee_basic.EmployeeID', '=', 'pmis_database_employee_salary.EmployeeID')
                                        ->select('pmis_database_employee_basic.EmployeeID','pmis_database_employee_basic.DepartmentID','pmis_database_employee_basic.DesignationID','pmis_database_employee_basic.Line','pmis_database_employee_basic.DepartmentID','pmis_database_employee_basic.DesignationID','pmis_database_employee_salary.GrossSalary','pmis_database_employee_salary.Basic','pmis_database_employee_salary.MedicalAllowance','pmis_database_employee_salary.HomeAllowance','pmis_database_employee_salary.FoodAllowance','pmis_database_employee_salary.Conveyance')
                                        ->where('pmis_database_employee_basic.EmployeeID',$empid)
                                        ->where('ReasonID','N')
                                        ->where('JoiningDate','<=',$enddate)
                                        ->orWhere('LeavingDate','>',$startdate)
                                        ->where('JoiningDate','<=',$enddate)
                                        ->where('pmis_database_employee_basic.EmployeeID',$empid)
                                        ->first();
                                    if($employee){
                                        $check = IndividualIncrement::where('EmployeeID',$employee->EmployeeID)->whereIn('IncType',[1,2])->where('IncrementDate',$attributes['IncrementDate'])->first();
                                        if($check == null){
                                            $indvinc = new IndividualIncrement();
                                            $indvinc->EmployeeID = $employee->EmployeeID;
                                            $indvinc->Line = $employee->Line;
                                            $indvinc->DepartmentID = $employee->DepartmentID;
                                            $indvinc->DesignationID = $employee->DesignationID;
                                            $indvinc->NewDepartmentID = $deptid;
                                            $indvinc->NewDesignationID = $desgid;
                                            $indvinc->IncrementDate = $attributes['IncrementDate'];
                                            $indvinc->EffectiveDate = $attributes['EffectiveDate'];
                                            $indvinc->ArrearDate = $attributes['ArrearDate'];
                                            $indvinc->GrossSalary = $employee->GrossSalary;
                                            $indvinc->Basic = $employee->Basic;
                                            $indvinc->HomeAllowance = $employee->HomeAllowance;
                                            $indvinc->MedicalAllowance = $employee->MedicalAllowance;
                                            $indvinc->FoodAllowance = $employee->FoodAllowance;
                                            $indvinc->Conveyance = $employee->Conveyance;
                                            $indvinc->IncType = $attributes['IncType'];
                                            $indvinc->Remarks = $attributes['Remarks'];
                                            $indvinc->CreatedBy = $userid;
                                            $indvinc->save();
                                            \LogActivity::addToLog('Add Promotion From Text File To ID: '.$employee->EmployeeID);
                                        }else{
                                            \LogActivity::addToLog('Failed Promotion To ID: '.$employee->EmployeeID);
                                            $i++; $emperrdata = $emperrdata.'<br>'.$empid;
                                        }
                                    }else{
                                        \LogActivity::addToLog('Failed Increment To ID: '.$empid);
                                        $i++; $emperrdata = $emperrdata.'<br>'.$empid;
                                    }
                                }
                            }                     
                            \LogActivity::addToLog('Add Promotion From Text File');
                            if($i == 0){
                                return redirect()->back()->with('success',getNotify(1));
                            }else{
                                return redirect()->back()->with('warning','Increment Information Successfully Added and Failed Increment '.$i.' & Employee ID: '.$emperrdata);
                            }
                        }else{
                            return redirect()->back()->with('warning','No Data Records Found In Given Text File. Please Try Again With Valid Text Data');
                        }
                    }
                }elseif($attributes['IncType'] == 4){
                    $rules = [
                        'incfile' => 'required',
                        'IncrementDate' => 'required|date',
                        'EffectiveDate' => 'required|date',
                        'ArrearDate' => 'required|date',
                        'IncrementPercentBasic' => 'required_without_all:IncrementPercentGross,IncrementAmountGross|between:0,50',
                        'IncrementPercentGross' => 'required_without_all:IncrementPercentBasic,IncrementAmountGross|between:0,50',
                        'IncrementAmountGross' => 'required_without_all:IncrementPercentBasic,IncrementPercentGross|between:0,99999',
                        'IncType' => 'numeric',
                        'Remarks' => 'max:50',
                    ];            
                    $validation = Validator::make($attributes, $rules);
                    if ($validation->fails()) {               
                        return redirect()->back()->with('error',getNotify(4))->withErrors($validation)->withInput();
                    }else{
                        $file = File::get($attributes['incfile']);
                        $punchs = explode("\n", $file);
                        if(count($punchs) > 0){
                            $i = 0;
                            foreach($punchs as $data){
                                $temp = explode("|", $data);
                                if(count($temp) == 2){
                                    $amount = 0; $incpb = 0; $incpg = 0;
                                    if($attributes['IncrementPercentBasic'] > 0){
                                        $empid = $temp[0]; $incpb = $temp[1];
                                    }elseif($attributes['IncrementPercentGross'] > 0){
                                        $empid = $temp[0]; $incpg = $temp[1];
                                    }elseif($attributes['IncrementAmountGross'] > 0){
                                        $empid = $temp[0]; $amount = $temp[1];
                                    }else{
                                        $empid = 0;
                                    }
                                    
                                    $employee = DB::table('pmis_database_employee_basic')
                                        ->leftJoin('pmis_database_employee_salary', 'pmis_database_employee_basic.EmployeeID', '=', 'pmis_database_employee_salary.EmployeeID')
                                        ->select('pmis_database_employee_basic.EmployeeID','pmis_database_employee_basic.DepartmentID','pmis_database_employee_basic.DesignationID','pmis_database_employee_basic.Line','pmis_database_employee_basic.DepartmentID','pmis_database_employee_basic.DesignationID','pmis_database_employee_salary.GrossSalary','pmis_database_employee_salary.Basic','pmis_database_employee_salary.MedicalAllowance','pmis_database_employee_salary.HomeAllowance','pmis_database_employee_salary.FoodAllowance','pmis_database_employee_salary.Conveyance')
                                        ->where('pmis_database_employee_basic.EmployeeID',$empid)
                                        ->where('ReasonID','N')
                                        ->where('JoiningDate','<=',$enddate)
                                        ->orWhere('LeavingDate','>',$startdate)
                                        ->where('JoiningDate','<=',$enddate)
                                        ->where('pmis_database_employee_basic.EmployeeID',$empid)
                                        ->first();
                                    if($employee){
                                        $check = IndividualIncrement::where('EmployeeID',$employee->EmployeeID)->whereIn('IncType',[1,2])->where('IncrementDate',$attributes['IncrementDate'])->first();
                                        if($check == null){
                                            $indvinc = new IndividualIncrement();
                                            $indvinc->EmployeeID = $employee->EmployeeID;
                                            $indvinc->Line = $employee->Line;
                                            $indvinc->DepartmentID = $employee->DepartmentID;
                                            $indvinc->DesignationID = $employee->DesignationID;
                                            $indvinc->NewDepartmentID = $employee->DepartmentID;
                                            $indvinc->NewDesignationID = $employee->DesignationID;
                                            $indvinc->IncrementDate = $attributes['IncrementDate'];
                                            $indvinc->EffectiveDate = $attributes['EffectiveDate'];
                                            $indvinc->ArrearDate = $attributes['ArrearDate'];
                                            $indvinc->GrossSalary = $employee->GrossSalary;
                                            $indvinc->Basic = $employee->Basic;
                                            $indvinc->HomeAllowance = $employee->HomeAllowance;
                                            $indvinc->MedicalAllowance = $employee->MedicalAllowance;
                                            $indvinc->FoodAllowance = $employee->FoodAllowance;
                                            $indvinc->Conveyance = $employee->Conveyance;
                                            $indvinc->IncrementPercentBasic = $incpb;
                                            $indvinc->IncrementPercentGross = $incpg;
                                            $indvinc->IncrementAmountGross = $amount;
                                            $indvinc->IncType = $attributes['IncType'];
                                            $indvinc->Remarks = $attributes['Remarks'];
                                            $indvinc->CreatedBy = $userid;
                                            $indvinc->save();
                                            \LogActivity::addToLog('Add Adjustment From Text File To ID: '.$employee->EmployeeID);
                                        }else{
                                            \LogActivity::addToLog('Failed Adjustment To ID: '.$employee->EmployeeID);
                                            $i++; $emperrdata = $emperrdata.'<br>'.$empid;
                                        }
                                    }else{
                                        \LogActivity::addToLog('Failed Increment To ID: '.$empid);
                                        $i++; $emperrdata = $emperrdata.'<br>'.$empid;
                                    }
                                }
                            }                     
                            \LogActivity::addToLog('Add Adjustment From Text File');
                            if($i == 0){
                                return redirect()->back()->with('success',getNotify(1));
                            }else{
                                return redirect()->back()->with('warning','Increment Information Successfully Added and Failed Increment '.$i.' & Employee ID: '.$emperrdata);
                            }
                        }else{
                            return redirect()->back()->with('warning','No Data Records Found In Given Text File. Please Try Again With Valid Text Data');
                        }
                    }
                }elseif($attributes['IncType'] == 6){
                    $rules = [
                        'incfile' => 'required',
                        'IncrementDate' => 'required|date',
                        'EffectiveDate' => 'required|date',
                        'ArrearDate' => 'required|date',
                        'IncrementPercentBasic' => 'required_without_all:IncrementPercentGross,IncrementAmountGross|between:0,50',
                        'IncrementPercentGross' => 'required_without_all:IncrementPercentBasic,IncrementAmountGross|between:0,50',
                        'IncrementAmountGross' => 'required_without_all:IncrementPercentBasic,IncrementPercentGross|between:0,99999',
                        'IncType' => 'numeric',
                        'Remarks' => 'max:50',
                    ];            
                    $validation = Validator::make($attributes, $rules);
                    if ($validation->fails()) {               
                        return redirect()->back()->with('error',getNotify(4))->withErrors($validation)->withInput();
                    }else{
                        $file = File::get($attributes['incfile']);
                        $punchs = explode("\n", $file);
                        if(count($punchs) > 0){
                            $i = 0;
                            foreach($punchs as $data){
                                $temp = explode("|", $data);
                                if(count($temp) == 4){
                                    $amount = 0; $incpb = 0; $incpg = 0;
                                    if($attributes['IncrementPercentBasic'] > 0){
                                        $empid = $temp[0]; $deptid = $temp[1]; $desgid = $temp[2]; $incpb = $temp[3];
                                    }elseif($attributes['IncrementPercentGross'] > 0){
                                        $empid = $temp[0]; $deptid = $temp[1]; $desgid = $temp[2]; $incpg = $temp[3];
                                    }elseif($attributes['IncrementAmountGross'] > 0){
                                        $empid = $temp[0]; $deptid = $temp[1]; $desgid = $temp[2]; $amount = $temp[3];
                                    }else{
                                        $empid = 0;
                                    }
                                    
                                    $employee = DB::table('pmis_database_employee_basic')
                                        ->leftJoin('pmis_database_employee_salary', 'pmis_database_employee_basic.EmployeeID', '=', 'pmis_database_employee_salary.EmployeeID')
                                        ->select('pmis_database_employee_basic.EmployeeID','pmis_database_employee_basic.DepartmentID','pmis_database_employee_basic.DesignationID','pmis_database_employee_basic.Line','pmis_database_employee_basic.DepartmentID','pmis_database_employee_basic.DesignationID','pmis_database_employee_salary.GrossSalary','pmis_database_employee_salary.Basic','pmis_database_employee_salary.MedicalAllowance','pmis_database_employee_salary.HomeAllowance','pmis_database_employee_salary.FoodAllowance','pmis_database_employee_salary.Conveyance')
                                        ->where('pmis_database_employee_basic.EmployeeID',$empid)
                                        ->where('ReasonID','N')
                                        ->where('JoiningDate','<=',$enddate)
                                        ->orWhere('LeavingDate','>',$startdate)
                                        ->where('JoiningDate','<=',$enddate)
                                        ->where('pmis_database_employee_basic.EmployeeID',$empid)
                                        ->first();
                                    if($employee){
                                        $check = IndividualIncrement::where('EmployeeID',$employee->EmployeeID)->whereIn('IncType',[1,2])->where('IncrementDate',$attributes['IncrementDate'])->first();
                                        if($check == null){
                                            $indvinc = new IndividualIncrement();
                                            $indvinc->EmployeeID = $employee->EmployeeID;
                                            $indvinc->Line = $employee->Line;
                                            $indvinc->DepartmentID = $employee->DepartmentID;
                                            $indvinc->DesignationID = $employee->DesignationID;
                                            $indvinc->NewDepartmentID = $deptid;
                                            $indvinc->NewDesignationID = $desgid;
                                            $indvinc->IncrementDate = $attributes['IncrementDate'];
                                            $indvinc->EffectiveDate = $attributes['EffectiveDate'];
                                            $indvinc->ArrearDate = $attributes['ArrearDate'];
                                            $indvinc->GrossSalary = $employee->GrossSalary;
                                            $indvinc->Basic = $employee->Basic;
                                            $indvinc->HomeAllowance = $employee->HomeAllowance;
                                            $indvinc->MedicalAllowance = $employee->MedicalAllowance;
                                            $indvinc->FoodAllowance = $employee->FoodAllowance;
                                            $indvinc->Conveyance = $employee->Conveyance;
                                            $indvinc->IncrementPercentBasic = $incpb;
                                            $indvinc->IncrementPercentGross = $incpg;
                                            $indvinc->IncrementAmountGross = $amount;
                                            $indvinc->IncType = $attributes['IncType'];
                                            $indvinc->Remarks = $attributes['Remarks'];
                                            $indvinc->CreatedBy = $userid;
                                            $indvinc->save();
                                            \LogActivity::addToLog('Add Adjustment With Promotion From Text File To ID: '.$employee->EmployeeID);
                                        }else{
                                            \LogActivity::addToLog('Failed Adjustment With Promotion To ID: '.$employee->EmployeeID);
                                            $i++; $emperrdata = $emperrdata.'<br>'.$empid;
                                        }
                                    }else{
                                        \LogActivity::addToLog('Failed Adjustment With Promotion To ID: '.$empid);
                                        $i++; $emperrdata = $emperrdata.'<br>'.$empid;
                                    }
                                }
                            }                     
                            \LogActivity::addToLog('Add Adjustment With Promotion From Text File');
                            if($i == 0){
                                return redirect()->back()->with('success',getNotify(1));
                            }else{
                                return redirect()->back()->with('warning','Increment Information Successfully Added and Failed Increment '.$i.' & Employee ID: '.$emperrdata);
                            }
                        }else{
                            return redirect()->back()->with('warning','No Data Records Found In Given Text File. Please Try Again With Valid Text Data');
                        }
                    }
                }elseif($attributes['IncType'] == 7){
                    $rules = [
                        'incfile' => 'required',
                        'IncrementDate' => 'required|date',
                        'EffectiveDate' => 'required|date',
                        'ArrearDate' => 'required|date',
                        'IncType' => 'numeric',
                        'Remarks' => 'max:50',
                    ];            
                    $validation = Validator::make($attributes, $rules);
                    if ($validation->fails()) {               
                        return redirect()->back()->with('error',getNotify(4))->withErrors($validation)->withInput();
                    }else{
                        $file = File::get($attributes['incfile']);
                        $punchs = explode("\n", $file);
                        if(count($punchs) > 0){
                            $i = 0;
                            foreach($punchs as $data){
                                $temp = explode("|", $data);
                                if(count($temp) == 3){
                                    $empid = $temp[0]; $desgid = $temp[1]; $desgname = $temp[2];
                                    $employee = DB::table('pmis_database_employee_basic')
                                        ->leftJoin('pmis_database_employee_salary', 'pmis_database_employee_basic.EmployeeID', '=', 'pmis_database_employee_salary.EmployeeID')
                                        ->select('pmis_database_employee_basic.EmployeeID','pmis_database_employee_basic.DepartmentID','pmis_database_employee_basic.DesignationID','pmis_database_employee_basic.Line','pmis_database_employee_basic.DepartmentID','pmis_database_employee_basic.DesignationID','pmis_database_employee_salary.GrossSalary','pmis_database_employee_salary.Basic','pmis_database_employee_salary.MedicalAllowance','pmis_database_employee_salary.HomeAllowance','pmis_database_employee_salary.FoodAllowance','pmis_database_employee_salary.Conveyance')
                                        ->where('pmis_database_employee_basic.EmployeeID',$empid)
                                        ->where('ReasonID','N')
                                        ->where('JoiningDate','<=',$enddate)
                                        ->orWhere('LeavingDate','>',$startdate)
                                        ->where('JoiningDate','<=',$enddate)
                                        ->where('pmis_database_employee_basic.EmployeeID',$empid)
                                        ->first();
                                    if($employee){
                                        if(empty($desgid)){
                                            $desgchk = Designation::where('Designation',$desgname)->first();
                                        }else{
                                            $desgchk = '';
                                        }
                                        if($desgid){
                                            $desgid = $desgid;
                                        }elseif($desgchk){
                                            $desgid = $desgchk->id;
                                        }else{
                                            $desgdata = Designation::find($employee->DesignationID);
                                            $designation = new Designation();
                                            $designation->fill($desgdata->toArray());
                                            $designation->Designation = $desgname;
                                            $designation->DesignationB = '';
                                            $designation->save();
                                            \LogActivity::addToLog('Add Designation '.$designation->Designation);
                                            
                                            $desgid = $designation->id;
                                        }
                                        $check = IndividualIncrement::where('EmployeeID',$employee->EmployeeID)->whereIn('IncType',[1,2])->where('IncrementDate',$attributes['IncrementDate'])->first();
                                        if($check == null){
                                            $indvinc = new IndividualIncrement();
                                            $indvinc->EmployeeID = $employee->EmployeeID;
                                            $indvinc->Line = $employee->Line;
                                            $indvinc->DepartmentID = $employee->DepartmentID;
                                            $indvinc->DesignationID = $employee->DesignationID;
                                            $indvinc->NewDepartmentID = $employee->DepartmentID;
                                            $indvinc->NewDesignationID = $desgid;
                                            $indvinc->IncrementDate = $attributes['IncrementDate'];
                                            $indvinc->EffectiveDate = $attributes['EffectiveDate'];
                                            $indvinc->ArrearDate = $attributes['ArrearDate'];
                                            $indvinc->GrossSalary = $employee->GrossSalary;
                                            $indvinc->Basic = $employee->Basic;
                                            $indvinc->HomeAllowance = $employee->HomeAllowance;
                                            $indvinc->MedicalAllowance = $employee->MedicalAllowance;
                                            $indvinc->FoodAllowance = $employee->FoodAllowance;
                                            $indvinc->Conveyance = $employee->Conveyance;
                                            $indvinc->IncType = $attributes['IncType'];
                                            $indvinc->Remarks = $attributes['Remarks'];
                                            $indvinc->CreatedBy = $userid;
                                            $indvinc->save();
                                            \LogActivity::addToLog('Add Promotion From Text File To ID: '.$employee->EmployeeID);
                                        }else{
                                            \LogActivity::addToLog('Failed Promotion To ID: '.$employee->EmployeeID);
                                            $i++; $emperrdata = $emperrdata.'<br>'.$empid;
                                        }
                                    }else{
                                        \LogActivity::addToLog('Failed Increment To ID: '.$empid);
                                        $i++; $emperrdata = $emperrdata.'<br>'.$empid;
                                    }
                                }
                            }                     
                            \LogActivity::addToLog('Add Promotion From Text File');
                            if($i == 0){
                                return redirect()->back()->with('success',getNotify(1));
                            }else{
                                return redirect()->back()->with('warning','Increment Information Successfully Added and Failed Increment '.$i.' & Employee ID: '.$emperrdata);
                            }
                        }else{
                            return redirect()->back()->with('warning','No Data Records Found In Given Text File. Please Try Again With Valid Text Data');
                        }
                    }
                }
            }
        }else{
            return redirect()->back()->with('warning', getNotify(5));
        }
    }

    public function show(Request $request, $id){
        if (getAccess('view')) {
            $uniqueincrement = DB::table('hr_database_employee_basic as basic')
                ->leftJoin('hr_setup_designation', 'basic.DesignationID', '=', 'hr_setup_designation.id')
                ->leftJoin('hr_setup_department', 'basic.DepartmentID', '=', 'hr_setup_department.id')
                ->leftJoin('hr_database_employee_salary as salary', 'basic.EmployeeID', '=', 'salary.EmployeeID')
                ->select('basic.id','basic.EmployeeID','basic.Name','hr_setup_designation.Designation','hr_setup_department.Department','basic.JoiningDate','basic.Line','basic.DepartmentID','basic.DesignationID','salary.GrossSalary','salary.Basic','salary.MedicalAllowance','salary.HomeAllowance','salary.FoodAllowance','salary.Conveyance','salary.OtherAllowance','salary.OTPayable','salary.AttendanceBonus','salary.HousingAllowance')
                ->where('basic.id',$id)
                ->first();

            $indvincs = IndividualIncrement::orderBy('id','ASC')->where('EmployeeID',$uniqueincrement->EmployeeID)->get();
            $desglist = Designation::orderBy('id','ASC')->where('C4S','Y')->pluck('Designation','id');
            $deptlist = Department::orderBy('Department', 'ASC')->where('C4S','Y')->select(DB::raw("CONCAT(id,' | ',Department) AS full_name, id"))->pluck('full_name','id');
            $inctypelists = DB::table('hr_setup_incrementtype')->orderBy('id','ASC')->pluck('IncType','id');

            return view('hris.database.increment.show', compact('uniqueincrement','desglist','deptlist','indvincs','inctypelists'));       
        } else {
            return redirect()->back()->with('warning', getNotify(5));
        }
    }

    public function update($id){
        if (getAccess('edit')) {
            $userid = Sentinel::getUser()->id;
            $attributes = Input::all(); 
            $indvinc = IndividualIncrement::find($id);
            $empid = Employee::where('EmployeeID',$indvinc->EmployeeID)->pluck('id')->first();  
            $empsalid = Employee::where('EmployeeID',$indvinc->EmployeeID)->pluck('id')->first();
            $employeebasic = Employee::find($empid);
            $employeesalary = EmployeeSalary::find($empsalid);       
            $rules = [
                'EmployeeID' => 'required|numeric',
                'IncrementDate' => 'required|date',
                'EffectiveDate' => 'required|date',
                'ArrearDate' => 'required|date',
                'IncSource' => 'required|numeric',
                'PayType' => 'required|numeric',
                'IncrementAmnt' => 'required|numeric',
                'IncType' => 'required|numeric',
                'Remarks' => 'max:50',
            ];
            $validation = Validator::make($attributes, $rules);
            if ($validation->fails()) {   
                return redirect()->back()->with('error',getNotify(4))->withErrors($validation)->withInput();
            } else { 
                $check = IndividualIncrement::where('EmployeeID',$indvinc->EmployeeID)->where('id','!=',$id)->whereIn('IncType',[1,2])->where('IncrementDate',$attributes['IncrementDate'])->first();
                if($check){
                    return redirect()->back()->with('warning',getNotify(6))->withInput();
                }else{
                    $indvinc->EmployeeID = $employeebasic->EmployeeID;
                    $indvinc->DepartmentID = $employeebasic->DepartmentID;
                    $indvinc->DesignationID = $employeebasic->DesignationID;
                    $indvinc->Line = $employeebasic->Line;
                    $indvinc->NewDepartmentID = $attributes['NewDepartmentID'];
                    $indvinc->NewDesignationID = $attributes['NewDesignationID'];
                    $indvinc->IncrementDate = $attributes['IncrementDate'];
                    $indvinc->EffectiveDate = $attributes['EffectiveDate'];
                    $indvinc->ArrearDate = $attributes['ArrearDate'];
                    $indvinc->GrossSalary = $employeesalary->GrossSalary;
                    $indvinc->Basic = $employeesalary->Basic;
                    $indvinc->HomeAllowance = $employeesalary->HomeAllowance;
                    $indvinc->MedicalAllowance = $employeesalary->MedicalAllowance;
                    $indvinc->Conveyance = $employeesalary->Conveyance;
                    $indvinc->FoodAllowance = $employeesalary->FoodAllowance;
                    $indvinc->HousingAllowance = $employeesalary->HousingAllowance;
                    $indvinc->OtherAllowance = $employeesalary->OtherAllowance;
                    $indvinc->IncSource = $attributes['IncSource'];
                    $indvinc->PayType = $attributes['PayType'];
                    $indvinc->IncrementAmnt = $attributes['IncrementAmnt'];
                    $indvinc->IncType = $attributes['IncType'];
                    $indvinc->Remarks = $attributes['Remarks'];
                    $indvinc->CreatedBy = $userid;
                    $indvinc->updated_at = Carbon::now();
                    $indvinc->save();
                    
                    \LogActivity::addToLog('Edit Employee Increment '.$indvinc->EmployeeID);
                    return redirect()->back()->with('success',getNotify(2));
                }
            }
        }else{
            return redirect()->back()->with('warning', getNotify(5));
        }
    }

    public function destroy($id){
        if (getAccess('delete')) {
            $indvinc = IndividualIncrement::find($id);            
            $indvinc->delete();      
            \LogActivity::addToLog('Delete Employee Increment '.$indvinc->EmployeeID);
            return redirect()->back()->with('success',getNotify(1));
        }else{
            return redirect()->back()->with('warning', getNotify(5));
        }
    }

    public function getEmployeeInfo(Request $request){
        $empl = DB::table('hr_database_employee_basic as basic')
            ->where('basic.EmployeeID',$request->emp_id)
            ->where('basic.Salaried','Y')
            ->leftJoin('hr_database_employee_salary', 'basic.EmployeeID', '=', 'hr_database_employee_salary.EmployeeID')
            ->leftJoin('hr_setup_designation', 'basic.DesignationID', '=', 'hr_setup_designation.id')
            ->leftJoin('hr_setup_department', 'basic.DepartmentID', '=', 'hr_setup_department.id')
            ->select('basic.id','basic.EmployeeID','basic.Name','hr_setup_designation.Designation','hr_setup_department.Department','basic.JoiningDate','hr_database_employee_salary.GrossSalary')
            ->orderBy('basic.EmployeeID','ASC')
            ->first();
        return response()->json($empl); 
    }

}
