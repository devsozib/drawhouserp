<?php

namespace App\Http\Controllers\HRIS\Database;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\HRIS\Database\Employee;
use App\Models\HRIS\Database\Punishment;
use App\Models\HRIS\Setup\Department;
use App\Models\HRIS\Setup\Designation;
use App\Models\HRIS\Setup\CategoryEmployee;
use App\Models\HRIS\Tools\HROptions;
use Input;
use Validator;
use Carbon\Carbon;
use Redirect;
use Sentinel;
use DB;

class PunishmentController extends Controller
{
    public function index() {
        if (getAccess('view')) {
            $deptlist = Department::orderBy('id', 'ASC')->where('id','!=',1)->where('C4S','Y')->pluck('Department','id');
            $categorylist = CategoryEmployee::orderBy('id', 'ASC')->pluck('Category','CategoryID');
            $deduct_type = [1=>'Both',2=>'Salary',3=>'Service Charge'];
            return view('hris.database.punishment.index', compact('deptlist','categorylist','deduct_type'));             
        } else {
            return redirect()->back()->with('warning', getNotify(5));
        }
    }

    public function update(Request $request){
        $id =  $request->recordId;
        $deduct_type =  $request->deductId;
        if (getAccess('create')) {
            $pun = Punishment::where('id',$id)->first();
            $pun->Deduct_Type = $deduct_type;
            $pun->update();
            return response()->json(array('success' => getNotify(2)));
        }else{
            return redirect()->back()->with('warning', getNotify(5));
        }
        
    }

    public function store(Request $request){
        if (getAccess('create')) {
            $userid = Sentinel::getUser()->id;
            $attributes = Input::all();
            $rules = [
                'EmployeeID' => 'required|numeric',
            ];            
            $validation = Validator::make($attributes, $rules);
            if ($validation->fails()) {               
                return response()->json(array('errors' => 'Validation Error!'));
            }else{
                foreach($request->PMDate as $date){
                    $chk = Punishment::where('EmployeeID',$request->EmployeeID)->where('PMDate',date('Y-m-d', strtotime($date)))->first();
                    if(isset($chk->id) && $chk->id>0){

                    }else{
                        $advanceloan = new Punishment();
                        $advanceloan->EmployeeID = $request->EmployeeID;
                        $advanceloan->PMDate = date('Y-m-d', strtotime($date));
                        $advanceloan->Deduct_Type = $request->Deduct_Type;
                        $advanceloan->CreatedBy = $userid;
                        $advanceloan->save(); 
                        \LogActivity::addToLog('Add Punishment '.$advanceloan->EmployeeID);
                    }
                }

                $HROptions = HROptions::orderBy('id','ASC')->first();
                $empl = DB::table('payroll_database_punishment as punsh')
                    ->leftJoin('hr_database_employee_basic as basic', 'punsh.EmployeeID', '=', 'basic.EmployeeID')
                    ->leftJoin('hr_setup_designation', 'basic.DesignationID', '=', 'hr_setup_designation.id')
                    ->select('basic.EmployeeID','basic.Name','hr_setup_designation.Designation','punsh.id','punsh.PMDate','punsh.Deduct_Type')
                    ->where('punsh.EmployeeID',$request->EmployeeID)
                    ->whereMonth('punsh.PMDate','=',$HROptions->Month)
                    ->whereYear('punsh.PMDate','=',$HROptions->Year)
                    ->orderBy('punsh.EmployeeID','ASC')
                    ->orderBy('punsh.PMDate','ASC')
                    ->get();
                return response()->json(array('success' => 'Punishment Successfully Added', 'empl' => $empl));
            }
        }else{
            return redirect()->back()->with('warning', getNotify(5));
        }
    }

    public function destroy($id){
        if (getAccess('delete')) {       
            $checked = explode(",",$id);
            $education = Punishment::whereIn('id',$checked)->delete();
            \LogActivity::addToLog('Delete Punishment '.$id);
            return response()->json(array('success' => 'Punishment Successfully Deleted'));
        }else{
            return redirect()->back()->with('warning', getNotify(5));
        }
    }

    public function getEmployee(Request $request){
        if($request->dept_all == 'true'){
            $empl = DB::table('hr_database_employee_basic as basic')
                ->leftJoin('hr_setup_designation', 'basic.DesignationID', '=', 'hr_setup_designation.id')
                ->select('basic.EmployeeID','basic.Name','hr_setup_designation.Designation')
                ->whereIn('basic.company_id',getCompanyIds())
                ->where('basic.ReasonID','N')
                ->orderBy('basic.EmployeeID','ASC')
                ->get();
            return response()->json($empl); 
        }elseif($request->dept_all == 'false'){
            $empl = DB::table('hr_database_employee_basic as basic')
                ->leftJoin('hr_setup_designation', 'basic.DesignationID', '=', 'hr_setup_designation.id')
                ->select('basic.EmployeeID','basic.Name','hr_setup_designation.Designation')
                ->whereIn('basic.company_id',getCompanyIds())
                ->where('basic.DepartmentID',$request->dept_id)
                ->where('basic.ReasonID','N')
                ->orderBy('basic.EmployeeID','ASC')
                ->get();
            return response()->json($empl);
        }
    }

    public function getEmployeePun(Request $request){
        $HROptions = HROptions::orderBy('id','ASC')->where('id',1)->first();
        $empl = DB::table('payroll_database_punishment as punsh')
            ->leftJoin('hr_database_employee_basic as basic', 'punsh.EmployeeID', '=', 'basic.EmployeeID')
            ->leftJoin('hr_setup_designation', 'basic.DesignationID', '=', 'hr_setup_designation.id')
            ->select('basic.EmployeeID','basic.Name','hr_setup_designation.Designation','punsh.id','punsh.PMDate','punsh.Deduct_Type')
            ->whereIn('basic.company_id',getCompanyIds())
            //->where('punsh.EmployeeID',$request->EmployeeID)
            ->whereMonth('punsh.PMDate','=',$HROptions->Month)
            ->whereYear('punsh.PMDate','=',$HROptions->Year)
            ->orderBy('punsh.EmployeeID','ASC')
            ->orderBy('punsh.PMDate','ASC')
            ->get(); 
        return response()->json($empl);
    }
}
