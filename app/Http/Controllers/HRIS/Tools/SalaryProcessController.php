<?php

namespace App\Http\Controllers\HRIS\Tools;

use DB;
use Input;
use Redirect;
use Sentinel;
use Validator;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\HRIS\Tools\HROptions;
use App\Models\HRIS\Database\Employee;
use App\Models\HRIS\Tools\SalaryAdjust;
use App\Models\Library\General\Company;
use App\Models\HRIS\Tools\ProcessSalary;
use App\Models\HRIS\Tools\ServiceCharge;
use App\Models\HRIS\Database\AdvanceLoan;
use App\Models\HRIS\Tools\ProcessAdvance;
use App\Models\HRIS\Setup\LeaveDefinitions;
use App\Models\HRIS\Tools\ProcessAttendance;

class SalaryProcessController extends Controller
{
    public function index(Request $request)
    {
        if (getAccess('view')) {
            $salaryProcess = ProcessSalary::groupBy('company_id','Year','Month')->whereIn('company_id',getCompanyIds())->select('company_id','Year','Month');                
            if($request->year_month){
                $carbonDate = Carbon::parse($request->year_month);
                $year = $carbonDate->year;
                $month = $carbonDate->month;
                $salaryProcess = $salaryProcess->where('Year', $year)->where('Month',$month);
            }
            $salaryProcess = $salaryProcess->get();
        
            return view('hris.tools.salaryprocess.index',compact('request','salaryProcess'));
        } else {
            return redirect()->back()->with('warning', getNotify(5));
        }
    }

    public function store()
    {
        if (getAccess('create')) {
            $userid = Sentinel::getUser()->id;
            $attributes = Input::all();
            $rules = [
                'title' => 'required|numeric',
                'company_id'=>'required|numeric',
                'Year' => 'required|numeric',
                'Month' => 'required|numeric',
            ];
            $validation = Validator::make($attributes, $rules);
            if ($validation->fails()) {
                return redirect()->back()->with('error', getNotify(4))->withErrors($validation)->withInput();
            } else {
                $year = $attributes['Year'];
                $month = $attributes['Month'];
                $company = $attributes['company_id'];
                $start_date = Carbon::parse($year. '-' .$month)->startOfMonth()->format('Y-m-d');
                $end_date = Carbon::parse($year. '-' .$month)->endOfMonth()->format('Y-m-d');

                if ($attributes['title'] == 1) {
                    $chk = ProcessSalary::orderBy('id', 'DESC')->where('Year', $year)->where('Month', $month)->where('company_id', $company)->first();
                    $chkadv = ProcessAdvance::where('Year',$year)->where('Month',$month)->where('company_id',$company)->first();
                    if ($chk == null && $chkadv == null) {
                        $employeeids = DB::table('hr_database_employee_basic')->orderBy('EmployeeID','ASC')->where('ReasonID','N')->where('Salaried','Y')->where('JoiningDate','<=',$end_date)->where('company_id',$company)->orWhere('LeavingDate','>',$start_date)->where('Salaried','Y')->where('JoiningDate','<=',$end_date)->where('company_id',$company)->pluck('EmployeeID');
                        $advanceloans = AdvanceLoan::orderBy('id','ASC')->whereIn('EmployeeID',$employeeids)->where('RefundStartFrom','<=',$end_date)->where('BalanceAmount','>',0)->where('Closed','N')->get();
                        foreach ($advanceloans as $advanceloan) {
                            $advprocess = new ProcessAdvance();
                            $advprocess->AdvanceID = $advanceloan->id;
                            $advprocess->FAdvanceID = $advanceloan->AdvanceID;
                            $advprocess->EmployeeID = $advanceloan->EmployeeID;
                            $advprocess->company_id = getEmpCompany($advanceloan->EmployeeID);
                            $advprocess->Year = $year;
                            $advprocess->Month = $month;
                            $advprocess->Amount = $advanceloan->ISize < $advanceloan->BalanceAmount ? $advanceloan->ISize : $advanceloan->BalanceAmount;
                            $advprocess->CreatedBy = $userid;
                            $advprocess->save();
                        }
                        \LogActivity::addToLog('Add Process Advance');

                        $employees = DB::table('hr_database_employee_basic as basic')
                            ->where('basic.ReasonID', 'N')
                            ->where('basic.Salaried', 'Y')
                            ->where('basic.company_id',$company)
                            ->where('basic.JoiningDate', '<=', $end_date)
                            ->orWhere('basic.LeavingDate', '>', $start_date)
                            ->where('basic.Salaried', 'Y')                            
                            ->where('basic.company_id',$company)
                            ->where('basic.JoiningDate', '<=', $end_date)
                            ->leftJoin('hr_database_employee_salary', 'basic.EmployeeID', '=', 'hr_database_employee_salary.EmployeeID')
                            ->leftJoin('hr_setup_designation', 'basic.DesignationID', '=', 'hr_setup_designation.id')
                            ->select('basic.EmployeeID', 'basic.DesignationID', 'basic.DepartmentID', 'hr_setup_designation.Grade', 'hr_setup_designation.CategoryID', 'basic.JoiningDate', 'basic.ShiftingDuty', 'basic.LeavingDate', 'basic.ReasonID','basic.company_id', 'hr_database_employee_salary.*')
                            ->orderBy('basic.EmployeeID', 'ASC')
                            ->get();
                        $advancedata = DB::table('payroll_tools_processadvance as proadv')
                            ->where('proadv.Year', $year)
                            ->where('proadv.Month', $month)
                            ->where('company_id',$company)
                            ->leftJoin('payroll_database_advance', 'proadv.AdvanceID', '=', 'payroll_database_advance.id')
                            ->select('proadv.EmployeeID', 'proadv.Amount', 'payroll_database_advance.AdvanceAmount')
                            ->orderBy('payroll_database_advance.EmployeeID', 'ASC')
                            ->get();
                        $lvtypes = LeaveDefinitions::orderBy('id', 'ASC')->where('C4S', 'Y')->pluck('TypeID');
                        $pr_arr = ['PR','HD','AL','SL','PTL','MTL','CML','ML','EXL','BL','DO','DDO','PH'];
                        $hroptions = HROptions::orderBy('id','ASC')->first();
                        $bper = $hroptions->BasicPer;
                        $sc_amnt = ServiceCharge::where('year', $year)->where('month', $month)->where('company_id',$company)->pluck('amount')->first();
                        $adjust_data = SalaryAdjust::where('year', $year)->where('month', $month)->get();

                        $lastid = ProcessSalary::orderBy('id', 'DESC')->pluck('id')->first() + 1;
                        $splitemps = collect($employees)->chunk(250)->toArray();
                        foreach ($splitemps as $splitemp) {
                            $empids = collect($splitemp)->pluck('EmployeeID');
                            $attndata = ProcessAttendance::orderBy('id', 'ASC')->whereIn('EmployeeID', $empids)->whereYear('WorkDate', '=', $year)->whereMonth('WorkDate', '=', $month)->get();
                            foreach ($splitemp as $employee) {
                                $empid = $employee->EmployeeID;
                                $leavingdate = Carbon::parse($employee->LeavingDate)->subDays(1)->format('Y-m-d');
                                $joiningdate = $employee->JoiningDate;

                                if ($joiningdate > $start_date && $joiningdate <= $end_date && $employee->LeavingDate <= $end_date && $employee->LeavingDate > 0) {
                                    $startdate = $joiningdate;
                                    $enddate = $leavingdate;
                                    $attn = collect($attndata)->filter(function ($item) use ($empid, $startdate, $enddate) {
                                        return $item->EmployeeID == $empid && $item->WorkDate >= $startdate && $item->WorkDate <= $enddate;
                                    })->sortBy('WorkDate')->all();
                                } elseif ($joiningdate > $start_date && $joiningdate <= $end_date) {
                                    $startdate = $joiningdate;
                                    $enddate = $end_date;
                                    $attn = collect($attndata)->filter(function ($item) use ($empid, $startdate, $enddate) {
                                        return $item->EmployeeID == $empid && $item->WorkDate >= $startdate && $item->WorkDate <= $enddate;
                                    })->sortBy('WorkDate')->all();
                                } elseif ($employee->LeavingDate <= $end_date && $employee->LeavingDate > 0) {
                                    $startdate = $start_date;
                                    $enddate = $leavingdate;
                                    $attn = collect($attndata)->filter(function ($item) use ($empid, $startdate, $enddate) {
                                        return $item->EmployeeID == $empid && $item->WorkDate >= $startdate && $item->WorkDate <= $enddate;
                                    })->sortBy('WorkDate')->all();
                                } else {
                                    $startdate = $start_date; $enddate = $end_date;
                                    if ($joiningdate > $end_date) {
                                        $attn = [];
                                    } else {
                                        $attn = collect($attndata)->filter(function ($item) use ($empid, $startdate, $enddate) {
                                            return $item->EmployeeID == $empid && $item->WorkDate >= $startdate && $item->WorkDate <= $enddate;
                                        })->sortBy('WorkDate')->all();
                                    }
                                }
                                if (count($attn) > 0) {
                                    $prdays = collect($attn)->whereIn('AttnType', $pr_arr)->count();
                                    $abdays = collect($attn)->whereIn('AttnType', ['AB', 'LWP'])->count();

                                    $lvdays = collect($attn)->whereIn('AttnType', $lvtypes)->count();
                                    $realab = collect($attn)->where('AttnType', 'AB')->count();

                                    $monthdays = Carbon::parse($start_date)->daysInMonth;
                                    //$daysinmonth = 30;
                                    $daysinmonth = $monthdays;
                                    $totaldays = count($attn);
                                    $gwh = collect($attn)->whereIn('AttnType', $pr_arr)->sum('WageWorkHour');
                                    $latededuction = 0;
                                    
                                    /* $latedays = collect($attn)->filter(function ($value, $key) {
                                        return $value->IsLate == 'Y' && $value->AttnType != 'HD';
                                    })->count();
                                    $latededuct = floor($latedays/3);
                                    if ($latededuct >= 1) {
                                        $latededuction = round(($employee->Basic / $daysinmonth) * $latededuct);
                                    } else {
                                        $latededuction = 0;
                                    } */

                                    $totalothour = collect($attn)->sum('OTHour');
                                    $othr = 0;
                                    if ($totalothour > 0) {
                                        foreach ($attn as $attnot) {
                                            if ($attnot->AttnType == 'HD') {
                                                $othr += 0;
                                            } elseif ($attnot->OTHour > 2) {
                                                $othr += 2;
                                            } else {
                                                $othr += $attnot->OTHour;
                                            }
                                        }
                                    }
                                    $advamount = collect($advancedata)->where('EmployeeID', $empid)->sum('AdvanceAmount');
                                    $advrefund = collect($advancedata)->where('EmployeeID', $empid)->sum('Amount');

                                    $othour = $employee->OTPayable == 'Y' ? $othr : 0;
                                    $otrate = $employee->OTAllowanceFixed;
                                    $otamount = round($otrate * $othour);
                                    $totalotamount = round($otrate * $totalothour);

                                    $basicabdeduct = round(($employee->Basic / $daysinmonth) * $abdays);
                                    //$service_charge = $sc_amnt ? round(($sc_amnt/100)*$employee->ServiceChargePer) : round(($employee->ServiceCharge/100)*$employee->ServiceChargePer);
                                    $service_charge = round(($employee->ServiceCharge/100)*$employee->ServiceChargePer);

                                    $scdeduct = collect($attn)->whereIn('Deduct_Type', [1,3])->count();
                                    $scdeductamnt = round(($service_charge / $monthdays) * $scdeduct);
                                    $scpay = $service_charge - $scdeductamnt;

                                    $hadeductamnt = round(($employee->HousingAllowance / $monthdays) * $abdays);
                                    $hapay = $employee->HousingAllowance - $hadeductamnt;

                                    if ($joiningdate >= $start_date || $employee->LeavingDate > 0) {
                                        $grosspay = ($employee->GrossSalary / $monthdays) * $totaldays;
                                        $bpayable = round(($grosspay/100) * $bper) - $basicabdeduct;
                                        $bpay = $bpayable > 0 ? $bpayable : 0;
                                        $grpay = round($grosspay - $basicabdeduct);
                                    } else {
                                        $bpayable = round($employee->Basic - $basicabdeduct);
                                        $bpay = $bpayable > 0 ? $bpayable : 0;
                                        $grpay = round($employee->GrossSalary - $basicabdeduct);
                                    }
                                    $adjust = $adjust_data->where('EmployeeID',$employee->EmployeeID)->pluck('Adjustment')->first();
                                    $deduct = $adjust_data->where('EmployeeID',$employee->EmployeeID)->pluck('Deduction')->first();
                                    $deduction = $advrefund + $employee->Tax + $deduct + $latededuction;
                                    $netpayable = ($grpay + $otamount + $adjust + $scpay + $hapay + $employee->OtherAllowance) - $deduction;
                                    $totalnetpayable = ($grpay + $totalotamount + $adjust + $scpay + $hapay + $employee->OtherAllowance) - $deduction;
                                    $totaldeduction = $deduction + $basicabdeduct + $scdeductamnt + $hadeductamnt;

                                    $processsalary = new ProcessSalary();
                                    $processsalary->id = $lastid;
                                    $processsalary->Year = $year;
                                    $processsalary->Month = $month;
                                    $processsalary->company_id = $employee->company_id ? $employee->company_id : 0;
                                    $processsalary->EmployeeID = $employee->EmployeeID;
                                    $processsalary->DepartmentID = $employee->DepartmentID;
                                    $processsalary->DesignationID = $employee->DesignationID;
                                    $processsalary->CategoryID = $employee->CategoryID;
                                    $processsalary->Grade = $employee->Grade;
                                    $processsalary->ReasonID = $employee->ReasonID;
                                    $processsalary->LeavingDate = $employee->LeavingDate;
                                    $processsalary->OTPayable = $employee->OTPayable;
                                    $processsalary->SalaryFromBank = $employee->SalaryFromBank;
                                    $processsalary->AccountNo = $employee->AccountNo;
                                    $processsalary->MobileBanking = $employee->MobileBanking;
                                    $processsalary->Days = $prdays;
                                    $processsalary->ABDays = $realab;
                                    $processsalary->LVDays = $lvdays;
                                    $processsalary->GWH = $gwh;
                                    $processsalary->GrossSalary = $employee->GrossSalary;
                                    $processsalary->Basic = $employee->Basic;
                                    $processsalary->HomeAllowance = $employee->HomeAllowance;
                                    $processsalary->MedicalAllowance = $employee->MedicalAllowance;
                                    $processsalary->FoodAllowance = $employee->FoodAllowance;
                                    $processsalary->Conveyance = $employee->Conveyance;
                                    $processsalary->HousingAllowance = $employee->HousingAllowance;
                                    $processsalary->OtherAllowance = $employee->OtherAllowance;
                                    $processsalary->ServiceCharge = $service_charge;
                                    $processsalary->OTRate = $otrate;
                                    $processsalary->OTHour = $othour;
                                    $processsalary->OTAmount = $otamount;
                                    $processsalary->TotalOTHour = $totalothour;
                                    $processsalary->TotalOTAmount = $totalotamount;
                                    $processsalary->IncomeTax = $employee->Tax;
                                    $processsalary->AdvanceAmount = $advamount;
                                    $processsalary->AdvanceRefund = $advrefund;
                                    $processsalary->LOP = 0;
                                    $processsalary->ABDeduction = $basicabdeduct;
                                    $processsalary->LateDeduction = $latededuction;
                                    $processsalary->AdjustAmount = $adjust ? $adjust : 0;
                                    $processsalary->BasicPayable = $bpay;
                                    $processsalary->SCPayable = $scpay;
                                    $processsalary->HAPayable = $hapay;
                                    $processsalary->GrossPayable = $grpay;
                                    $processsalary->TotalDeduction = $totaldeduction;
                                    $processsalary->NetPayable = $netpayable;
                                    $processsalary->TotalNetPayable = $totalnetpayable;
                                    $processsalary->CreatedBy = $userid;
                                    $processsalary->save();

                                    $lastid++;
                                }/*else{
                                    \LogActivity::addToLog('Failed Process Salary For '.$employee->EmployeeID);
                                }*/
                            }
                        }

                        \LogActivity::addToLog('Add Process Salary');
                        return redirect()->back()->with('success', getNotify(1))->withInput();
                    } else {
                        return redirect()->back()->with('warning', 'Process Salary Already Exists')->withInput();
                    }
                } elseif ($attributes['title'] == 2) {
                    $chk = ProcessSalary::orderBy('id', 'DESC')->where('Year', $year)->where('Month', $month)->where('company_id',$company)->where('Confirmed', 'Y')->first();
                    $chkadv = ProcessAdvance::where('Year',$year)->where('Month',$month)->where('company_id',$company)->where('Refunded','Y')->first();
                    if ($chk == null && $chkadv == null) {
                        ProcessAdvance::where('Year',$year)->where('Month',$month)->where('company_id',$company)->where('Refunded','N')->delete();
    	        		\LogActivity::addToLog('Delete Process Advance');
                        ProcessSalary::where('Year', $year)->where('Month', $month)->where('company_id',$company)->where('Confirmed', 'N')->delete();
                        \LogActivity::addToLog('Delete Process Salary');
                        return redirect()->back()->with('success', getNotify(3))->withInput();
                    } else {
                        return redirect()->back()->with('warning', 'Undo/Revert Is Not Available Because Process Salary Already Confirmed')->withInput();
                    }
                } elseif ($attributes['title'] == 3) {
                    $chk = ProcessSalary::orderBy('id', 'DESC')->where('Year', $year)->where('Month', $month)->where('company_id',$company)->where('Confirmed', 'Y')->first();
                    $chkadv = ProcessAdvance::where('Year',$year)->where('Month',$month)->where('company_id',$company)->where('Refunded','Y')->first();
                    if ($chk == null && $chkadv == null) {
                        ProcessSalary::where('Year', $year)->where('Month', $month)->where('company_id',$company)->update(['Confirmed' => 'Y', 'CreatedBy' => $userid]);
                        \LogActivity::addToLog('Update Process Salary');

                        $advproids = ProcessAdvance::orderBy('id','ASC')->where('Year',$year)->where('Month',$month)->where('company_id',$company)->where('Refunded','N')->get();
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
                        return redirect()->back()->with('success', getNotify(2))->withInput();
                    } else {
                        return redirect()->back()->with('warning', 'Process Salary Already Confirmed')->withInput();
                    }
                }
            }
        } else {
            return redirect()->back()->with('warning', getNotify(5));
        }
    }
}
