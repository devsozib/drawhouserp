<?php

namespace App\Http\Controllers\HRIS\Tools;

use DB;
use Input;
use Redirect;
use Sentinel;
use Validator;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\HRIS\Setup\Shifts;
use App\Models\HRIS\Tools\Calendar;
use App\Http\Controllers\Controller;
use App\Models\HRIS\Tools\HROptions;
use App\Models\HRIS\Database\Employee;
use App\Models\HRIS\Setup\HDException;
use App\Models\HRIS\Tools\ShiftingList;
use App\Models\Library\General\Company;
use App\Models\HRIS\Tools\ExceptionalHD;
use App\Models\HRIS\Tools\ProcessSalary;

class ExceptionalHDController extends Controller
{
    public function index()
    {
        if (getAccess('view')) {
            $hdexps = HDException::orderBy('id','ASC')->where('C4S','Y')->pluck('EmployeeID','EmployeeID');
            return view('hris.tools.exceptionalhd.index', compact('hdexps'));
        } else {
            return redirect()->back()->with('warning', getNotify(5));
        }
    }

    public function store()
    {
        if (getAccess('create')) {
            $userid = Sentinel::getUser()->id;
            $attributes = Input::all();
            if(isset($attributes['forCreateExpHoliday']) && $attributes['forCreateExpHoliday'] == '1'){                
                $check = ExceptionalHD::where('EmployeeID', $attributes['EmployeeID'])->whereDate('WeeklyHolidayDate', $attributes['date'])->first();
                if (!$check) {
                    $exHd = new ExceptionalHD();
                    $exHd->company_id = getEmpCompany($attributes['EmployeeID']);
                    $exHd->EmployeeID = $attributes['EmployeeID'];
                    $exHd->WeeklyHolidayDate = $attributes['date'];
                    $exHd->CreatedBy = $userid;
                    $exHd->save();

                    $hdexp = HDException::where('EmployeeID',$attributes['EmployeeID'])->first();
                    if(!$hdexp) {
                        HDException::insert(['EmployeeID'=>$attributes['EmployeeID'], 'WeeklyHoliday'=>$attributes['date'], 'C4S'=>'Y', 'CreatedBy'=>$userid]);
                    }
                    ShiftingList::where('EmployeeID',$attributes['EmployeeID'])->where('Date',$attributes['date'])->update(['Holiday'=>'DO']);
                
                    \LogActivity::addToLog('Add Exceptional Holidays Info ' . $exHd->EmployeeID . ' & ' . $exHd->WeeklyHolidayDate);
                    $empl = DB::table('hr_tools_exceptionalholidays as excphd')
                        ->where('excphd.EmployeeID', $attributes['EmployeeID'])                  
                        ->leftJoin('hr_database_employee_basic as basic', 'excphd.EmployeeID', '=', 'basic.EmployeeID')
                        ->select('excphd.*','basic.Name')
                        ->orderBy('excphd.EmployeeID','ASC')
                        ->orderBy('excphd.WeeklyHolidayDate','ASC')
                        ->get();
                    return response()->json(array('success' => getNotify(1),'data' => $empl));
                } else {
                    return response()->json(array('errors' => getNotify(6), 'data' => $check));
                }
            }else {
                if ($attributes['form_id'] == 1) {
                    $rules = [
                        'Year' => 'required|numeric',
                    ];
                    $validation = Validator::make($attributes, $rules);
                    if ($validation->fails()) {
                        return redirect()->back()->with('error', getNotify(4))->withErrors($validation)->withInput();
                    } else {
                        $year = $attributes['Year']; $end_date = $year.'-12-31';
                        $oldemployeeids = ExceptionalHD::orderBy('EmployeeID', 'ASC')->whereYear('WeeklyHolidayDate', '=', $attributes['Year'])->distinct()->pluck('EmployeeID');
                        $employeeids = DB::table('hr_setup_holidayexceptions')
                            ->leftJoin('hr_database_employee_basic as basic', 'hr_setup_holidayexceptions.EmployeeID', '=', 'basic.EmployeeID')
                            ->select('basic.EmployeeID','basic.company_id','basic.JoiningDate','hr_setup_holidayexceptions.WeeklyHoliday')
                            ->whereNotIn('basic.EmployeeID', $oldemployeeids)
                            ->where('basic.ReasonID','N')
                            ->where('hr_setup_holidayexceptions.C4S','Y')
                            ->orderBy('basic.EmployeeID','ASC')
                            ->get();
                        if(count($employeeids)){
                            foreach ($employeeids as $employeeid) {
                                $start_date = $year.'-01-01';
                                if ($start_date <= $employeeid->JoiningDate) {
                                    $start_date = $employeeid->JoiningDate;
                                } else {
                                    $start_date = $end_date;
                                }
                                if ($start_date <= $employeeid->WeeklyHoliday) {
                                    $start_date = $employeeid->WeeklyHoliday;
                                }
                                while (strtotime($start_date) <= strtotime($end_date)) {
                                    if(date('l', strtotime($employeeid->WeeklyHoliday)) == date('l', strtotime($start_date))) {
                                        $calendar = new ExceptionalHD();
                                        $calendar->company_id = $employeeid->company_id;
                                        $calendar->EmployeeID = $employeeid->EmployeeID;
                                        $calendar->WeeklyHolidayDate = $start_date;
                                        $calendar->CreatedBy = $userid;
                                        $calendar->save();

                                        ShiftingList::where('EmployeeID',$employeeid->EmployeeID)->where('Date',$start_date)->update(['Holiday'=>'DO']);
                                    }
                                    $start_date = date ("Y-m-d", strtotime("+1 day", strtotime($start_date)));
                                }
                            }
                            
                            \LogActivity::addToLog('Add Generate Exceptional Holidays Information');
                            return redirect()->back()->with('success', getNotify(1));
                        }else{
                            return redirect()->back()->with('error', getNotify(8))->withInput();
                        }
                    }
                } elseif ($attributes['form_id'] == 2) {
                    $rules = [
                        'EmployeeID' => 'required|numeric',
                        'StartDate' => 'required|date_format:Y-m-d',
                        'EndDate' => 'required|date_format:Y-m-d',
                    ];
                    $validation = Validator::make($attributes, $rules);
                    if ($validation->fails()) {
                        return response()->json(array('errors' => getNotify(4)));
                    } else {
                        $start_date = $attributes['StartDate']; $end_date = $attributes['EndDate']; 
                        $startyear = Carbon::parse($start_date)->year; $startmonth = Carbon::parse($start_date)->month; 
                        $chk = ExceptionalHD::orderBy('id','ASC')->whereYear('WeeklyHolidayDate','=',$startyear)->first();
                        $chksal = ProcessSalary::orderBy('id','ASC')->where('Year',$startyear)->where('Month',$startmonth)->where('Confirmed','Y')->first();
                        if($chk && $chksal == null){
                            $employeeid = HDException::where('EmployeeID',$attributes['EmployeeID'])->where('C4S','Y')->first();
                            if($employeeid){
                                ExceptionalHD::where('EmployeeID',$attributes['EmployeeID'])->whereBetween('WeeklyHolidayDate',[$start_date,$end_date])->delete();
                                while (strtotime($start_date) <= strtotime($end_date)) {
                                    if (date('l', strtotime($employeeid->WeeklyHoliday)) == date('l', strtotime($start_date))) {
                                        $calendar = new ExceptionalHD();
                                        $calendar->company_id = getEmpCompany($attributes['EmployeeID']);
                                        $calendar->EmployeeID = $attributes['EmployeeID'];
                                        $calendar->WeeklyHolidayDate = $start_date;
                                        $calendar->CreatedBy = $userid;
                                        $calendar->save();

                                        ShiftingList::where('EmployeeID',$attributes['EmployeeID'])->where('Date',$start_date)->update(['Holiday'=>'DO']);
                                    }
                                    $start_date = date ("Y-m-d", strtotime("+1 day", strtotime($start_date)));
                                }
                                \LogActivity::addToLog('Edit Exceptional Holiday Information '.$attributes['EmployeeID']);
                                return response()->json(array('success' => getNotify(2)));
                            }else{
                                return response()->json(array('errors' => 'This ID is not listed in Holiday Exceptions'));
                            }
                        }else{
                            return response()->json(array('errors' => 'Please First Generate Exceptional Holiday for Existing Employee or Salary Confirmed'));
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

    public function update(Request $request, $id)
    {
        if (getAccess('edit')) {
            $userid = Sentinel::getUser()->id;
            $attributes = $request->all(); 
            $rules = [
                'WeeklyHolidayDate' => 'required|date_format:Y-m-d',
            ];
            $validation = Validator::make($attributes, $rules);
            if ($validation->fails()) {   
                return response()->json(array('errors' => getNotify(4)));
            } else { 
                $education = ExceptionalHD::find($id);
                $olddata = $education;
                if($education->WeeklyHolidayDate == $request->WeeklyHolidayDate){
                    return response()->json(array('errors' => getNotify(6)));
                } else {
                    $education->updated_at = Carbon::now();
                    $education->WeeklyHolidayDate = strip_tags($request->WeeklyHolidayDate);
                    $education->CreatedBy = $userid;
                    $education->save();

                    /* $hdexp = HDException::where('EmployeeID',$education->EmployeeID)->first();
                    if(!$hdexp) {
                        HDException::insert(['EmployeeID'=>$education->EmployeeID, 'WeeklyHoliday'=>$education->WeeklyHolidayDate, 'C4S'=>'Y', 'CreatedBy'=>$userid]);
                    } */
                    ShiftingList::where('EmployeeID',$education->EmployeeID)->where('Date',$olddata->WeeklyHolidayDate)->update(['Holiday'=>'N']);
                    ShiftingList::where('EmployeeID',$education->EmployeeID)->where('Date',$education->WeeklyHolidayDate)->update(['Holiday'=>'DO']);

                    \LogActivity::addToLog('Update Exceptional Holidays Info '.$education->EmployeeID.' & '.$education->WeeklyHolidayDate);
                    return response()->json(array('success' => getNotify(2)));
                }
            }
        } else {
            return redirect()->back()->with('warning', getNotify(5));
        }
    }

    public function destroy($id)
    {
        if (getAccess('delete')) {
            $excphd = ExceptionalHD::find($id);
            $excphd->delete();
            ShiftingList::where('EmployeeID',$$excphd->EmployeeID)->where('Date',$$excphd->WeeklyHolidayDate)->update(['Holiday'=>'N']);

            \LogActivity::addToLog('Delete Exceptional Holidays Info '.$excphd->EmployeeID.' & '.$excphd->WeeklyHolidayDate);
            return response()->json(array('success' => getNotify(3)));
        } else {
            return redirect()->back()->with('warning', getNotify(5));
        }
    }

    public function getExceptionalHD(Request $request){
        if ($request->emp_id > 0) {
            $empl = DB::table('hr_tools_exceptionalholidays as excphd')
                ->where('excphd.EmployeeID',$request->emp_id)
                ->whereBetween('excphd.WeeklyHolidayDate',[$request->start_date, $request->end_date])
                ->leftJoin('hr_database_employee_basic as basic', 'excphd.EmployeeID', '=', 'basic.EmployeeID')
                ->select('excphd.*','basic.Name')
                ->orderBy('excphd.EmployeeID','ASC')
                ->orderBy('excphd.WeeklyHolidayDate','ASC')
                ->get();
        } else {
            $empl = DB::table('hr_tools_exceptionalholidays as excphd')
                ->whereBetween('excphd.WeeklyHolidayDate',[$request->start_date, $request->end_date])
                ->leftJoin('hr_database_employee_basic as basic', 'excphd.EmployeeID', '=', 'basic.EmployeeID')
                ->select('excphd.*','basic.Name')
                ->orderBy('excphd.EmployeeID','ASC')
                ->orderBy('excphd.WeeklyHolidayDate','ASC')
                ->get();
        }
     
    	return response()->json($empl);
    }
}
