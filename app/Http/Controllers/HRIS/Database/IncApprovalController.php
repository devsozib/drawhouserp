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
use App\Models\HRIS\Database\SalaryChange;
use App\Models\HRIS\Database\EmployeeSalary;
use App\Models\HRIS\Database\IndividualIncrement;

class IncApprovalController extends Controller
{
    public function index() {
        if (getAccess('view')) {
            $date = Carbon::now()->subDays(8)->startOfMonth()->format('Y-m-d');
            $enfincs = IndividualIncrement::orderBy('id', 'ASC')->where('EffectiveDate','<=',$date)->where('Enforce','N')->get();
            return view('hris.database.incapproval.index', compact('enfincs'));             
        } else {
            return redirect()->back()->with('warning', getNotify(5));
        }
    }

    public function store(){
        if (getAccess('create')) {
            $userid = Sentinel::getUser()->id;
            $hroptions = HROptions::orderBy('id','ASC')->first();
            $attributes = Input::all();

            if(isset($attributes['delete'])){
                if (getAccess('delete')) {
                    if(isset($attributes['IncID'])){
                        IndividualIncrement::whereIn('id',$attributes['IncID'])->delete();
                        return redirect()->back()->with('success',getNotify(3));
                    }else{
                        return redirect()->back()->with('warning','Please Select Employee For Delete Increment Information');
                    }
                }else{
                    return redirect()->back()->with('warning', getNotify(5));
                }
             
        	}else{
                $rules = [
                    'IncID' => 'required',
                ];            
                $validation = Validator::make($attributes, $rules);
                if ($validation->fails()) {               
                    return redirect()->back()->with('error',getNotify(4))->withErrors($validation)->withInput();
                }else{
                    $sl = 0;
                    $hroptions = HROptions::orderBy('id','ASC')->first();
                    $bper = $hroptions->BasicPer;
                    $hrper = $hroptions->HRentPer;
                    $medper = $hroptions->MedPer;
                    $convper = $hroptions->ConvPer;
    	        	foreach($attributes['IncID'] as $IncID){
    	        		$indvinc = IndividualIncrement::find($IncID);
    
    	        		$empbasinfo = Employee::where('EmployeeID',$indvinc->EmployeeID)->first();
    	        		$empsalinfo = EmployeeSalary::where('EmployeeID',$indvinc->EmployeeID)->first();
                        $hallow = $indvinc->HousingAllowance;
                        $incamnt = $indvinc->IncrementAmnt;
                        if ($indvinc->IncSource == 1) {
                            $amntgr = $indvinc->PayType == 1 ? round($indvinc->GrossSalary + $incamnt) : round(($indvinc->GrossSalary/100) * $incamnt);
                            if ($indvinc->IncType == 5) {
                                $amntgr = (-$amntgr);
                            }
                            $gross = round($indvinc->GrossSalary + $amntgr);
                            $basic = round(($gross/100) * $bper);
                            $hr = round(($gross/100) * $hrper);
                            $med = round(($gross/100) * $medper);
                            $conv = round(($gross/100) * $convper);
                        } elseif ($indvinc->IncSource == 2) {
                            $amntba = $indvinc->PayType == 1 ? round($indvinc->Basic + $incamnt) : round(($indvinc->Basic/100) * $incamnt);
                            $basic = $indvinc->Basic + $amntba;
                            $gross = round($basic * (100/$bper));
                            $hr = round(($gross/100) * $hrper);
                            $med = round(($gross/100) * $medper);
                            $conv = round(($gross/100) * $convper);
                        } elseif ($indvinc->IncSource == 3) {
                            $amntha = $indvinc->PayType == 1 ? round($indvinc->HousingAllowance + $incamnt) : round(($indvinc->HousingAllowance/100) * $incamnt);
                            $hallow = $indvinc->HousingAllowance + $amntha;
                            $gross = round($indvinc->GrossSalary); 
                            $basic = round(($gross/100) * $bper);
                            $hr = round(($gross/100) * $hrper);
                            $med = round(($gross/100) * $medper);
                            $conv = round(($gross/100) * $convper);
                        } else {
                            $gross = round($indvinc->GrossSalary); 
                            $basic = round(($gross/100) * $bper);
                            $hr = round(($gross/100) * $hrper);
                            $med = round(($gross/100) * $medper);
                            $conv = round(($gross/100) * $convper);
                        }
    					
    		        	$employeebasic = Employee::find($empbasinfo->id);
    		        	$employeebasic->DepartmentID = $indvinc->NewDepartmentID;
    		        	$employeebasic->DesignationID = $indvinc->NewDesignationID;
    		        	$employeebasic->save();
    		        	
    		        	$employeesalary = EmployeeSalary::find($empsalinfo->id);
    		        	$employeesalary->GrossSalary = $gross;
    		        	$employeesalary->Basic = $basic;
    		        	$employeesalary->HomeAllowance = $hr;
    		        	$employeesalary->MedicalAllowance = $med;
    		        	$employeesalary->Conveyance = $conv;
    		        	$employeesalary->HousingAllowance = $hallow;
    		        	$employeesalary->OldGrossSalary = $empsalinfo->GrossSalary;
    		        	$employeesalary->OldBasic = $empsalinfo->Basic;
    		        	$employeesalary->OldHomeAllowance = $empsalinfo->HomeAllowance;
    		        	$employeesalary->OldMedicalAllowance = $empsalinfo->MedicalAllowance;
    		        	$employeesalary->OldConveyance = $empsalinfo->Conveyance;
    		        	$employeesalary->OldFoodAllowance = $empsalinfo->FoodAllowance;
    		        	$employeesalary->OldHousingAllowance = $empsalinfo->OldHousingAllowance;
    		        	$employeesalary->save();
    
    		        	$salarychange = new SalaryChange();
    		        	$salarychange->IncID = $indvinc->id;
    		        	$salarychange->EmployeeID = $indvinc->EmployeeID;
    		        	$salarychange->DateChanged = $indvinc->EffectiveDate;
    		        	$salarychange->GrossSalary = $gross;
    		        	$salarychange->Basic = $basic;
    		        	$salarychange->HomeAllowance = $hr;
    		        	$salarychange->MedicalAllowance = $med;
    		        	$salarychange->Conveyance = $conv;
    		        	$salarychange->HousingAllowance = $hallow;
    		        	$salarychange->FoodAllowance = $empsalinfo->FoodAllowance;
    	            	$salarychange->CreatedBy = $userid;
    		        	$salarychange->save();
    
    		        	$indvinc->Enforce = 'Y';
    	            	$indvinc->CreatedBy = $userid;
    	            	$indvinc->updated_at = Carbon::now();
    	                $indvinc->save();
    
    	                \LogActivity::addToLog('Add Increment Approval '.$indvinc->EmployeeID);
    	                $sl++;
                    }
    
                    return redirect()->back()->with('success', getNotify(1));
                }
            }
        }else{
            return redirect()->back()->with('warning', getNotify(5));
        }
    }

    public function update($id){
        dd('This page is underconstruction');
        if (getAccess('edit')) {
            $userid = Sentinel::getUser()->id;
            $attributes = Input::all(); 
            $education = IndividualIncrement::find($id); 
            $rules = [ 
                'IncrementPercentBasic' => 'numeric',
                'IncrementPercentGross' => 'numeric',
                'IncrementAmountGross' => 'numeric',
            ];
            $validation = Validator::make($attributes, $rules);
            if ($validation->fails()) {   
                return response()->json(array('errors' => 'Validation Error!'));
            } else {
                $education->IncrementPercentBasic = $basicpt;
                $education->IncrementPercentGross = $grosspt;
                $education->IncrementAmountGross = $grossamnt;
                $education->updated_at = Carbon::now();                
                $education->save();  
                \LogActivity::addToLog('Update Increment Info '.$education->EmployeeID);
                return response()->json(array('success' => 'Increment Information Successfully Updated'));
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
