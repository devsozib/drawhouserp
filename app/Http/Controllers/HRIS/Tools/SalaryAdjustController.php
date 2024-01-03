<?php

namespace App\Http\Controllers\HRIS\Tools;

use DB;
use Input;
use Redirect;
use Response;
use Sentinel;
use Validator;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Users;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\HRIS\Setup\Department;
use App\Models\HRIS\Tools\SalaryAdjust;
use App\Models\Library\General\Company;
use App\Models\HRIS\Tools\ProcessSalary;
use App\Models\HRIS\Database\EmployeeSalary;

class SalaryAdjustController extends Controller
{
    public function index()
    {
        if (getAccess('view')) {
            $deptlist = Department::orderBy('id', 'ASC')->where('C4S','Y')->pluck('Department','id');
            return view('hris.tools.salaryadjust.index', compact('deptlist'));
        } else {
            return redirect()->back()->with('warning', getNotify(5));
        }
    }

    public function store(Request $request)
    {
        if (getAccess('create')) {
            $userid = Sentinel::getUser()->id;
            $attributes = $request->all();         
            $rules = [
                'company_id' => 'required|numeric',
                'Year' => 'required|numeric',
                'Month' => 'required|numeric',
            ];
            $validation = Validator::make($attributes, $rules);
            if ($validation->fails()) {   
                return response()->json(array('errors' => getNotify(4)));
            } else { 
            	foreach($request->EmployeeID as $employee){
                    $chk = SalaryAdjust::where('EmployeeID',$employee)->where('Year',$request->Year)->where('Month',$request->Month)->where('company_id',$request->company_id)->first();
                    if($chk){

                    } else {
                        $prosalinfo = ProcessSalary::where('EmployeeID',$employee)->where('Year',$request->Year)->where('Month',$request->Month)->select('GrossSalary','Basic')->first();
                        $empsalinfo = EmployeeSalary::where('EmployeeID',$employee)->select('GrossSalary','Basic')->first();
                        
                        $advanceloan = new SalaryAdjust();  
                        $advanceloan->Year = $request->Year;
                        $advanceloan->Month = $request->Month;
                        $advanceloan->company_id = getEmpCompany($employee);
                        $advanceloan->EmployeeID = $employee;
                        $advanceloan->GrossSalary = $prosalinfo ? $prosalinfo->GrossSalary : $empsalinfo->GrossSalary;
                        $advanceloan->Basic = $prosalinfo ? $prosalinfo->Basic : $empsalinfo->GrossSalary;
                        $advanceloan->CreatedBy = $userid;
                        $advanceloan->save();  
                        \LogActivity::addToLog('Add Salary Adjustment '.$advanceloan->EmployeeID);
                    }
                }

                if($request->dept_all == 'true'){
                    $empl = DB::table('hr_tools_salary_adjust as adjust')
                        ->leftJoin('hr_database_employee_basic as basic', 'adjust.EmployeeID', '=', 'basic.EmployeeID')
                        ->leftJoin('hr_setup_designation', 'basic.DesignationID', '=', 'hr_setup_designation.id')
                        ->leftJoin('hr_setup_department', 'basic.DepartmentID', '=', 'hr_setup_department.id')
                        ->select('basic.EmployeeID','basic.Name','hr_setup_designation.Designation','hr_setup_department.Department','adjust.*')
                        ->where('adjust.Year',$request->Year)
                        ->where('adjust.Month',$request->Month)
                        ->where('adjust.company_id',$request->company_id)
                        ->get();
                }elseif($request->dept_all == 'false'){        
                    $empl = DB::table('hr_tools_salary_adjust as adjust')
                        ->leftJoin('hr_database_employee_basic as basic', 'adjust.EmployeeID', '=', 'basic.EmployeeID')
                        ->leftJoin('hr_setup_designation', 'basic.DesignationID', '=', 'hr_setup_designation.id')
                        ->leftJoin('hr_setup_department', 'basic.DepartmentID', '=', 'hr_setup_department.id')
                        ->select('basic.EmployeeID','basic.Name','hr_setup_designation.Designation','hr_setup_department.Department','adjust.*')
                        ->where('basic.DepartmentID',$request->dept_id)
                        ->where('adjust.Year',$request->Year)
                        ->where('adjust.Month',$request->Month)
                        ->where('adjust.company_id',$request->company_id)
                        ->get();
                }

                return response()->json(array('success' => getNotify(1), 'empl' => $empl));
            }
        } else {
            return response()->json(array('errors' => getNotify(5)));
        }
    }

    public function update(Request $request, $id)
    {
        if (getAccess('edit')) {
            $userid = Sentinel::getUser()->id;
            $attributes = $request->all();      
            $rules = [
                'Adjustment' => 'numeric',
                'Deduction' => 'numeric',
                'Remarks' => 'max:50',
            ];
            $validation = Validator::make($attributes, $rules);
            if ($validation->fails()) {   
                return response()->json(array('errors' => getNotify(4)));
            } else { 
                $netamnt = round($request->Adjustment-$request->Deduction); 

                $deductiontype = SalaryAdjust::find($id);     
                $deductiontype->Adjustment = $request->Adjustment;
                $deductiontype->Deduction = $request->Deduction;
                $deductiontype->NetAmount = $netamnt;
                $deductiontype->Remarks = $request->Remarks;
                $deductiontype->CreatedBy = $userid;
                $deductiontype->updated_at = Carbon::now();
                $deductiontype->save();  
                \LogActivity::addToLog('Update Salary Adjustment '.$deductiontype->EmployeeID);
                return response()->json(array('success' => getNotify(2)));
            }
        } else {
            return response()->json(array('errors' => getNotify(5)));
        }
    }


    public function destroy($id)
    {
        if (getAccess('delete')) {
            $checked = explode(",",$id);
        	$education = SalaryAdjust::whereIn('id',$checked)->delete();

            \LogActivity::addToLog('Delete Salary Adjustment ' . $id);
            return response()->json(array('success' => getNotify(3)));
        } else {
            return response()->json(array('errors' => getNotify(5)));
        }
    }

    public function getEmployee(Request $request){
    	if($request->dept_all == 'true'){
	        $empl = DB::table('hr_database_employee_basic')->orderBy('EmployeeID','ASC')->select('EmployeeID','Name')->where('ReasonID','N')->where('Salaried','Y')->where('company_id',$request->company_id)->get();
	    	return response()->json($empl);
	    }elseif($request->dept_all == 'false'){
	    	$empl = DB::table('hr_database_employee_basic')->orderBy('EmployeeID','ASC')->select('EmployeeID','Name')->where('DepartmentID',$request->dept_id)->where('ReasonID','N')->where('Salaried','Y')->where('company_id',$request->company_id)->get();
	    	return response()->json($empl);
	    }
    }

    public function getEmployeeSA(Request $request){
    	if($request->dept_all == 'true'){
	        $empl = DB::table('hr_tools_salary_adjust as adjust')
	            ->leftJoin('hr_database_employee_basic as basic', 'adjust.EmployeeID', '=', 'basic.EmployeeID')
	            ->leftJoin('hr_setup_designation', 'basic.DesignationID', '=', 'hr_setup_designation.id')
    			->leftJoin('hr_setup_department', 'basic.DepartmentID', '=', 'hr_setup_department.id')
	            ->select('basic.EmployeeID','basic.Name','hr_setup_designation.Designation','hr_setup_department.Department','adjust.*')
	            ->where('adjust.Year',$request->Year)
			    ->where('adjust.Month',$request->Month)
                ->where('adjust.company_id',$request->company_id)
                ->orderBy('adjust.EmployeeID','ASC')
	            ->get();
	    	return response()->json($empl);
	    }elseif($request->dept_all == 'false'){
	    	$empl = DB::table('hr_tools_salary_adjust as adjust')
	            ->leftJoin('hr_database_employee_basic as basic', 'adjust.EmployeeID', '=', 'basic.EmployeeID')
	            ->leftJoin('hr_setup_designation', 'basic.DesignationID', '=', 'hr_setup_designation.id')
    			->leftJoin('hr_setup_department', 'basic.DepartmentID', '=', 'hr_setup_department.id')
	            ->select('basic.EmployeeID','basic.Name','hr_setup_designation.Designation','hr_setup_department.Department','adjust.*')
	            ->where('basic.DepartmentID',$request->dept_id)
	            ->where('adjust.Year',$request->Year)
			    ->where('adjust.Month',$request->Month)
                ->where('adjust.company_id',$request->company_id)
			    ->orderBy('adjust.EmployeeID','ASC')
	            ->get();
	    	return response()->json($empl);
	    }
	        
    }
}
