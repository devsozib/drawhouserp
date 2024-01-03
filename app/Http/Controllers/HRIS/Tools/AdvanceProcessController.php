<?php

namespace App\Http\Controllers\HRIS\Tools;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\HRIS\Database\Employee;
use App\Models\HRIS\Database\AdvanceLoan;
use App\Models\HRIS\Tools\ProcessAdvance;
use Input;
use Validator;
use Carbon\Carbon;
use Redirect;
use Sentinel;
use DB;

class AdvanceProcessController extends Controller
{
    public function index() {
        if (getAccess('view')) {
            return view('hris.tools.advanceprocess.index');             
        } else {
            return redirect()->back()->with('warning', getNotify(5));
        }
    }

    public function store(){
        if (getAccess('create')) {
            dd('This page is underconstruction');
            $userid = Sentinel::getUser()->id;
            $attributes = Input::all();
            $rules = [
                'title' => 'required|numeric',
                'Year' => 'required|numeric',
                'Month' => 'required|numeric',
            ];            
            $validation = Validator::make($attributes, $rules);
            if ($validation->fails()) {               
                return redirect()->back()->with('error',getNotify(4))->withErrors($validation)->withInput();
            }else{
                $year = $attributes['Year'];
                $month = $attributes['Month'];
                $start_date = Carbon::parse($year.'-'.$month)->startOfMonth()->format('Y-m-d');
            	$end_date = Carbon::parse($year.'-'.$month)->endOfMonth()->format('Y-m-d');
            	if($attributes['title'] == 1){
            		$chk = ProcessAdvance::where('Year',$year)->where('Month',$month)->first();
            		$prevchk = ProcessAdvance::where('Refunded','N')->first();
            		if($chk == null){
            		    if($prevchk == null){
                            $employeeids = DB::table('hr_database_employee_basic')->orderBy('EmployeeID','ASC')->where('ReasonID','N')->where('Salaried','Y')->where('JoiningDate','<=',$end_date)->orWhere('LeavingDate','>',$start_date)->where('Salaried','Y')->where('JoiningDate','<=',$end_date)->pluck('EmployeeID');
    	            		$advanceloans = AdvanceLoan::orderBy('id','ASC')->whereIn('EmployeeID',$employeeids)->where('RefundStartFrom','<=',$end_date)->where('BalanceAmount','>',0)->where('Closed','N')->get();
    	            		$lastid = ProcessAdvance::orderBy('id','DESC')->pluck('id')->first()+1;
    		        		foreach ($advanceloans as $advanceloan) {
    		        			$advprocess = new ProcessAdvance();
    		            		$advprocess->id = $lastid;
    		            		$advprocess->AdvanceID = $advanceloan->id;
    		            		$advprocess->FAdvanceID = $advanceloan->AdvanceID;
    		            		$advprocess->EmployeeID = $advanceloan->EmployeeID;
    		            		$advprocess->Year = $year;
    		            	    $advprocess->Month = $month;
    		            		$advprocess->Amount = $advanceloan->ISize < $advanceloan->BalanceAmount ? $advanceloan->ISize : $advanceloan->BalanceAmount;
    		            		$advprocess->CreatedBy = $userid;
    		            		$advprocess->save();
    		            		
    		            		$lastid++;
    		        		}
    		        		\LogActivity::addToLog('Add Process Advance');
                            return redirect()->back()->with('success',getNotify(1))->withInput();
            		    }else{
                            return redirect()->back()->with('warning','Please Confirm Previous Process Advance')->withInput();
            		    }
    	            }else{
                        return redirect()->back()->with('warning','Process Advance Already Exists')->withInput();
		            }
            	}elseif($attributes['title'] == 2){
                    $chk = ProcessAdvance::where('Year',$year)->where('Month',$month)->where('Refunded','Y')->first();
                    if($chk == null){
    	        		ProcessAdvance::where('Year',$year)->where('Month',$month)->where('Refunded','N')->delete();
    	        		\LogActivity::addToLog('Delete Process Advance');
                        return redirect()->back()->with('success',getNotify(3))->withInput();
                    }else{
                        return redirect()->back()->with('warning','Undo/Revert Is Not Available Because Process Advance Already Confirmed')->withInput();
                    }
            	}elseif($attributes['title'] == 3){
            		$chk = ProcessAdvance::where('Year',$year)->where('Month',$month)->where('Refunded','Y')->first();
            		if($chk == null){
                        $advproids = ProcessAdvance::orderBy('id','ASC')->where('Year',$year)->where('Month',$month)->where('Refunded','N')->get();
                        foreach ($advproids as $advproid) {
                            $advprocess = ProcessAdvance::find($advproid->id);
                            $advprocess->Refunded = 'Y';
                            $advprocess->CreatedBy = $userid;
                            $advprocess->updated_at = Carbon::now();
                            $advprocess->save();

                            $advprocessupdate = AdvanceLoan::find($advprocess->AdvanceID);
                            $prevbalamnt = $advprocessupdate->BalanceAmount;
                            $advprocessupdate->BalanceAmount = $advprocessupdate->BalanceAmount - $advproid->Amount;
                            $advprocessupdate->Closed = ($prevbalamnt - $advproid->Amount) <= 0 ? 'Y' : 'N';
                            $advprocessupdate->updated_at = Carbon::now();
                            $advprocessupdate->save();
                        }
		        		\LogActivity::addToLog('Update Process Advance');
                        return redirect()->back()->with('success',getNotify(2))->withInput();
		            }else{
                        return redirect()->back()->with('warning','Process Advance Already Confirmed')->withInput();
		            }
            	}
            }
        }else{
            return redirect()->back()->with('warning', getNotify(5));
        }
    }
}
