<?php

namespace App\Http\Controllers\HRIS\Tools;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\HRIS\Database\Employee;
use App\Models\HRIS\Tools\ProcessBonus;
use App\Models\HRIS\Tools\HROptions;
use Input;
use Validator;
use Carbon\Carbon;
use Redirect;
use Sentinel;
use DB;

class BonusProcessController extends Controller
{
    public function index() {
        if (getAccess('view')) {
            $processdatas = ProcessBonus::where('Year',getOptions()->Year)->whereIn('company_id',getCompanyIds())->select('company_id','Year','TypeID','SalaryType')->groupBy('company_id','Year','TypeID','SalaryType')->get();
            return view('hris.tools.bonusprocess.index', compact('processdatas'));             
        } else {
            return redirect()->back()->with('warning', getNotify(5));
        }
    }

    public function store(){
        if (getAccess('create')) {
            $userid = Sentinel::getUser()->id;
            $attributes = Input::all();
            $rules = [
                'title' => 'required|numeric',
                'TypeID' => 'required|numeric',
                'Year' => 'required|numeric',
                'company_id' => 'required|numeric',
                'SalaryType' => 'required|numeric',
                'BaseDate' => 'required|date_format:Y-m-d',
            ];            
            $validation = Validator::make($attributes, $rules);
            if ($validation->fails()) {               
                return redirect()->back()->with('error',getNotify(4))->withErrors($validation)->withInput();
            }else{
                if($attributes['title'] == 1){
                    $chk = ProcessBonus::orderBy('id','DESC')->where('Year',$attributes['Year'])->where('TypeID',$attributes['TypeID'])->where('company_id',$attributes['company_id'])->first();
                    $prevchk = ProcessBonus::where('Confirmed','N')->where('company_id',$attributes['company_id'])->first();
                    if($chk == null){
                        if($prevchk == null){
                            $start_date = Carbon::parse($attributes['BaseDate'])->subMonth(1)->startOfMonth()->format('Y-m-d');
                            $end_date = $attributes['BaseDate'];
                            $employees = DB::table('hr_database_employee_basic as basic')
                                ->leftJoin('hr_database_employee_salary as salary', 'basic.EmployeeID', '=', 'salary.EmployeeID')
                                ->leftJoin('hr_setup_designation', 'basic.DesignationID', '=', 'hr_setup_designation.id')
                                ->select('basic.EmployeeID','basic.DesignationID','basic.DepartmentID','hr_setup_designation.CategoryID','basic.JoiningDate','basic.ReasonID','basic.LeavingDate','salary.Basic','salary.GrossSalary','salary.SalaryFromBank','salary.AccountNo','salary.MobileBanking')
                                ->where('basic.company_id',$attributes['company_id'])
                                ->where('basic.ReasonID','N')
                                ->where('basic.Salaried','Y')
                                ->where('basic.JoiningDate','<=',$end_date)
                                ->orWhere('basic.LeavingDate','>',$start_date)
                                ->where('basic.company_id',$attributes['company_id'])
                                ->where('basic.Salaried','Y')
                                ->where('basic.JoiningDate','<=',$end_date)
                                ->orderBy('basic.EmployeeID','ASC')
                                ->get();
                            
                            $lastid = ProcessBonus::orderBy('id','DESC')->pluck('id')->first()+1;
                            foreach($employees as $employee) {
                                $joindate = Carbon::parse($employee->JoiningDate)->format('Y-m-d');
                                $basedate = Carbon::parse($attributes['BaseDate'])->format('Y-m-d');
                                $sixmonth = Carbon::parse($basedate)->subMonths(6)->addDays(1)->format('Y-m-d');
                                $ninemonth = Carbon::parse($basedate)->subMonths(12)->addDays(1)->format('Y-m-d');
                
                                if($joindate <= $basedate && $joindate > $sixmonth){
                                    $bonuspercent = 0;
                                }elseif($joindate <= $sixmonth && $joindate > $ninemonth){
                                    $bonuspercent = 50;
                                }elseif($joindate <= $ninemonth){
                                    $bonuspercent = 100;
                                }else{
                                    $bonuspercent = 0;
                                }

                                $netamnt = $attributes['SalaryType'] == 2 ? round(($employee->GrossSalary/100)*$bonuspercent) : round(($employee->Basic/100)*$bonuspercent);
                                
                                $procesbonus = new ProcessBonus();
                                $procesbonus->id = $lastid;
                                $procesbonus->TypeID = $attributes['TypeID'];
                                $procesbonus->Year = $attributes['Year'];
                                $procesbonus->company_id = $attributes['company_id'];
                                $procesbonus->BaseDate = $attributes['BaseDate'];
                                $procesbonus->SalaryType = $attributes['SalaryType'];
                                $procesbonus->EmployeeID = $employee->EmployeeID;
                                $procesbonus->DesignationID = $employee->DesignationID;
                                $procesbonus->DepartmentID = $employee->DepartmentID;
                                $procesbonus->CategoryID = $employee->CategoryID;
                                $procesbonus->ReasonID = $employee->ReasonID;
                                $procesbonus->LeavingDate = $employee->LeavingDate;
                                $procesbonus->GrossSalary = $employee->GrossSalary;
                                $procesbonus->Basic = $employee->Basic;
                                $procesbonus->Amount = $netamnt;
                                $procesbonus->CreatedBy = $userid;
                                $procesbonus->save();
                                
                                $lastid++;
                            }
                            
                            \LogActivity::addToLog('Add Process Bonus');
                            return redirect()->back()->with('success',getNotify(1))->withInput();
                        }else{
                            return redirect()->back()->with('warning','Please Confirm Previous Process Bonus')->withInput();
            		    }
                    }else{
                        return redirect()->back()->with('warning','Process Bonus Already Exists')->withInput();
                    }
                }elseif($attributes['title'] == 2){
                    $chk = ProcessBonus::orderBy('id','DESC')->where('Year',$attributes['Year'])->where('TypeID',$attributes['TypeID'])->where('company_id',$attributes['company_id'])->where('Confirmed','Y')->first();
                    if($chk == null){
                        ProcessBonus::where('Year',$attributes['Year'])->where('TypeID',$attributes['TypeID'])->where('company_id',$attributes['company_id'])->where('Confirmed','N')->delete();
                        \LogActivity::addToLog('Delete Process Bonus');
                        return redirect()->back()->with('success',getNotify(3))->withInput();
                    }else{
                        return redirect()->back()->with('warning','Undo/Revert Is Not Available Because Process Bonus Already Confirmed')->withInput();
                    }
                }elseif($attributes['title'] == 3){
                    $chk = ProcessBonus::orderBy('id','DESC')->where('Year',$attributes['Year'])->where('TypeID',$attributes['TypeID'])->where('company_id',$attributes['company_id'])->where('Confirmed','Y')->first();
                    if($chk == null){
                        ProcessBonus::where('Year',$attributes['Year'])->where('TypeID',$attributes['TypeID'])->where('company_id',$attributes['company_id'])->update(['Confirmed' => 'Y','CreatedBy' => $userid]);
                        \LogActivity::addToLog('Update Process Bonus');
                        return redirect()->back()->with('success',getNotify(2))->withInput();
                    }else{
                        return redirect()->back()->with('warning','Process Bonus Already Confirmed')->withInput();
                    }
                }
            }
        }else{
            return redirect()->back()->with('warning', getNotify(5));
        }
    }
}
