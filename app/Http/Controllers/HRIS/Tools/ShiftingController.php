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

class ShiftingController extends Controller
{
    public function index()
    {
        if (getAccess('view')) {
            $shiftlist = Shifts::whereRaw('FIND_IN_SET(?, company_id)', [getHostInfo()['id']])->orderBy('id', 'ASC')->where('C4S', 'Y')->get();
            $companies = Company::where('id', getHostInfo()['id'])
            ->where('C4S', 'Y')
            ->orderBy('id', 'ASC')
            ->pluck('id', 'Name');
        
            return view('hris.tools.shifting.index', compact('shiftlist','companies'));
        } else {
            return redirect()->back()->with('warning', getNotify(5));
        }
    }

    public function store()
    {
        if (getAccess('create')) {
            $userid = Sentinel::getUser()->id;
            $attributes = Input::all();
            if ($attributes['form_id'] == 1) {
                $rules = [
                    'Year' => 'required|numeric',
                    'company_id'=>'required|numeric',
                ];
                $validation = Validator::make($attributes, $rules);
                if ($validation->fails()) {
                    return redirect()->back()->with('error', getNotify(4))->withErrors($validation)->withInput();
                } else {
                    $company = $attributes['company_id'];
                    $startdate = $attributes['Year'].'-01-01';
                    $end_date = Carbon::parse($startdate)->endOfYear()->format('Y-m-d');
                    $oldemployeeids = ShiftingList::orderBy('EmployeeID', 'ASC')->whereYear('Date', '=', $attributes['Year'])->where('company_id',$company)->distinct()->pluck('EmployeeID');
                    $employeeids = Employee::orderBy('EmployeeID', 'ASC')->whereNotIn('EmployeeID', $oldemployeeids)->where('company_id',$company)->where('ReasonID', 'N')->where('ShiftingDuty', 'N')->orWhere('LeavingDate', '>', $startdate)->whereNotIn('EmployeeID', $oldemployeeids)->where('company_id',$company)->where('ShiftingDuty', 'N')->select('EmployeeID', 'JoiningDate', 'ReferenceShift','company_id')->get();
                    $employeeids2 = Employee::orderBy('EmployeeID', 'ASC')->whereNotIn('EmployeeID', $oldemployeeids)->where('company_id',$company)->where('ReasonID', 'N')->where('ShiftingDuty', 'Y')->orWhere('LeavingDate', '>', $startdate)->whereNotIn('EmployeeID', $oldemployeeids)->where('company_id',$company)->where('ShiftingDuty', 'Y')->select('EmployeeID', 'JoiningDate', 'ReferenceShift','company_id')->get();

                    if (count($employeeids) || count($employeeids2)) {
                        foreach ($employeeids as $employeeid) {
                            $start_date = $employeeid->JoiningDate > $startdate ? $employeeid->JoiningDate : $startdate;
                            while (strtotime($start_date) <= strtotime($end_date)) {
                                $calendar = new ShiftingList();
                                $calendar->Date = $start_date;
                                $calendar->EmployeeID = $employeeid->EmployeeID;
                                $calendar->Shift = $employeeid->ReferenceShift;
                                $calendar->company_id = $employeeid->company_id;
                                $calendar->branch_id = $employeeid->company_id;
                                $calendar->CreatedBy = $userid;
                                $calendar->save();
                                $start_date = date("Y-m-d", strtotime("+1 day", strtotime($start_date)));
                            }
                        }
                        //for shifting duty
                        foreach ($employeeids2 as $employeeid) {
                            $start_date = $employeeid->JoiningDate > $startdate ? $employeeid->JoiningDate : $startdate;
                            $i = 1;
                            $shift2 = '';
                            while (strtotime($start_date) <= strtotime($end_date)) {
                                if ($i == 1) {
                                    $shift = ShiftingList::orderBy('Date', 'DESC')->where('EmployeeID', $employeeid->EmployeeID)->pluck('Shift')->first();
                                    if ($shift) {
                                        if (date('l', strtotime($start_date)) == 'Saturday') {
                                            if ($shift == 'M') {
                                                $shift2 = 'N';
                                            } elseif ($shift == 'N') {
                                                $shift2 = 'M';
                                            } else {
                                                $shift2 = $shift;
                                            }
                                        } else {
                                            $shift2 = $shift;
                                        }
                                    } else {
                                        $shift2 = $employeeid->ReferenceShift;
                                    }
                                } else {
                                    if (date('l', strtotime($start_date)) == 'Saturday') {
                                        $shift = $shift2;
                                        if ($shift == 'M') {
                                            $shift2 = 'N';
                                        } elseif ($shift == 'N') {
                                            $shift2 = 'M';
                                        } else {
                                            $shift2 = $shift;
                                        }
                                    } else {
                                        $shift2 = $shift2;
                                    }
                                }
                                $calendar = new ShiftingList();
                                $calendar->Date = $start_date;
                                $calendar->EmployeeID = $employeeid->EmployeeID;
                                $calendar->Shift = $shift2;
                                $calendar->company_id = $employeeid->company_id;
                                $calendar->branch_id = $employeeid->company_id;
                                $calendar->CreatedBy = $userid;
                                $calendar->save();
                                $start_date = date("Y-m-d", strtotime("+1 day", strtotime($start_date)));
                                $i++;
                            }
                        }
                        \LogActivity::addToLog('Add Generate Shifting For Employee');
                        return redirect()->back()->with('success', getNotify(1))->withInput();
                    } else {
                        return redirect()->back()->with('error', getNotify(8))->withInput();
                    }
                }
            } elseif ($attributes['form_id'] == 2) {
                $rules = [
                    'EmployeeID' => 'required|numeric',
                    'StartDate' => 'required|date_format:Y-m-d',
                    'EndDate' => 'required|date_format:Y-m-d',
                    'Shift' => 'required|max:1',
                ];
                $validation = Validator::make($attributes, $rules);
                if ($validation->fails()) {
                    return response()->json(array('errors' => getNotify(4)));
                } else {
                    $start_date = $attributes['StartDate'];
                    $end_date = $attributes['EndDate'];
                    $startyear = Carbon::parse($start_date)->year;
                    $startmonth = Carbon::parse($start_date)->month;
                    $chk = ShiftingList::orderBy('id', 'ASC')->whereYear('Date', '=', $startyear)->first();
                    $chksal = ProcessSalary::orderBy('id', 'ASC')->whereYear('Year', '=', $startyear)->whereMonth('Month', '=', $startmonth)->where('Confirmed', 'Y')->first();
                    if ($chk && $chksal == null) {
                        $employeeid = Employee::where('EmployeeID', $attributes['EmployeeID'])->where('ReasonID', 'N')->where('JoiningDate', '<=', $start_date)->orWhere('LeavingDate', '>', $start_date)->where('EmployeeID', $attributes['EmployeeID'])->where('JoiningDate', '<=', $start_date)->select('EmployeeID', 'ShiftingDuty','company_id')->first();
                        if ($employeeid) {
                            ShiftingList::where('EmployeeID', $attributes['EmployeeID'])->whereBetween('Date', [$start_date, $end_date])->delete();
                            if ($employeeid->ShiftingDuty == 'Y') {
                                if ($attributes['Shift'] && $attributes['ShiftTwo']) {
                                    $i = 1;
                                    while (strtotime($start_date) <= strtotime($end_date)) {
                                        if ($i == 1) {
                                            $shift2 = $attributes['Shift'];
                                        } else {
                                            if (date('l', strtotime($start_date)) == 'Saturday') {
                                                if ($shift2 == $attributes['Shift']) {
                                                    $shift2 = $attributes['ShiftTwo'];
                                                } else {
                                                    $shift2 = $attributes['Shift'];
                                                }
                                            } else {
                                                $shift2 = $shift2;
                                            }
                                        }
                                        $calendar = new ShiftingList();
                                        $calendar->EmployeeID = $employeeid->EmployeeID;
                                        $calendar->Date = $start_date;
                                        $calendar->Shift = $shift2;
                                        $calendar->company_id = $employeeid->company_id;
                                        $calendar->branch_id = $employeeid->company_id;
                                        $calendar->CreatedBy = $userid;
                                        $calendar->save();

                                        $start_date = date("Y-m-d", strtotime("+1 day", strtotime($start_date)));
                                        $i++;
                                    }
                                } else {
                                    $i = 1;
                                    while (strtotime($start_date) <= strtotime($end_date)) {
                                        if ($i == 1) {
                                            $shift2 = $attributes['Shift'];
                                        } else {
                                            if (date('l', strtotime($start_date)) == 'Saturday') {
                                                $shift = $shift2;
                                                if ($shift == 'M') {
                                                    $shift2 = 'N';
                                                } elseif ($shift == 'N') {
                                                    $shift2 = 'M';
                                                } else {
                                                    $shift2 = $shift;
                                                }
                                            } else {
                                                $shift2 = $shift2;
                                            }
                                        }
                                        $calendar = new ShiftingList();
                                        $calendar->EmployeeID = $employeeid->EmployeeID;
                                        $calendar->Date = $start_date;
                                        $calendar->Shift = $shift2;
                                        $calendar->company_id = $employeeid->company_id;
                                        $calendar->branch_id = $employeeid->company_id;
                                        $calendar->CreatedBy = $userid;
                                        $calendar->save();

                                        $start_date = date("Y-m-d", strtotime("+1 day", strtotime($start_date)));
                                        $i++;
                                    }
                                }
                            } else {
                                while (strtotime($start_date) <= strtotime($end_date)) {
                                    $calendar = new ShiftingList();
                                    $calendar->EmployeeID = $employeeid->EmployeeID;
                                    $calendar->Date = $start_date;
                                    $calendar->Shift = $attributes['Shift'];
                                    $calendar->company_id = $employeeid->company_id;
                                    $calendar->branch_id = $employeeid->company_id;
                                    $calendar->CreatedBy = $userid;
                                    $calendar->save();

                                    $start_date = date("Y-m-d", strtotime("+1 day", strtotime($start_date)));
                                }
                            }
                            \LogActivity::addToLog('Edit Shifting ' . $attributes['EmployeeID'] . ' & ' . $attributes['StartDate'] . ' From ' . $attributes['EndDate'] . ' & ' . $attributes['Shift']);
                            return response()->json(array('success' => 'Successfully updated with date range in Shift'));
                        } else {
                            return response()->json(array('errors' => 'Employee Not Found!'));
                        }
                    } else {
                        return response()->json(array('errors' => 'Please First Generate Shifting for Existing Employee or Salary Confirmed!'));
                    }
                }
            } else {
                return redirect()->back()->with('warning', getNotify(10));
            }
        } else {
            return redirect()->back()->with('warning', getNotify(5));
        }
    }

    public function update(Request $request, $id)
    {
        if (getAccess('edit')) {
            $userid = Sentinel::getUser()->id;
            $attributes = Input::all();
            $shitData = ShiftingList::find($id);
            $type =  $request->type;
            $companyId = $request->company_id;
            $leaveType = $request->leaveType;
            if($type == 'companyUpdate'){                
                $shitData->updated_at = Carbon::now();
                $shitData->branch_id = $companyId;
                $shitData->save();
                \LogActivity::addToLog('Update Duty Property Info ' . $shitData->EmployeeID . ' & ' . $shitData->Date);
                return response()->json(array('success' => getNotify(2))); 
            }else if($type == "leaveTypeUpdate"){            
                $shitData->updated_at = Carbon::now();
                $shitData->Holiday = $leaveType;
                $shitData->save();
                if($shitData->Holiday == 'N'){
                    ExceptionalHD::where('EmployeeID',$shitData->EmployeeID)->where('WeeklyHolidayDate',$shitData->Date)->delete();
                }else{
                    /* $hdexp = HDException::where('EmployeeID',$shitData->EmployeeID)->first();
                    if(!$hdexp) {
                        HDException::insert(['EmployeeID'=>$shitData->EmployeeID, 'WeeklyHoliday'=>$shitData->Date, 'C4S'=>'Y', 'CreatedBy'=>$userid]);
                    } */
                    $exphd = ExceptionalHD::where('EmployeeID',$shitData->EmployeeID)->where('WeeklyHolidayDate',$shitData->Date)->first();
                    if(!$exphd) {
                        ExceptionalHD::insert(['EmployeeID'=>$shitData->EmployeeID, 'WeeklyHolidayDate'=>$shitData->Date, 'CreatedBy'=>$userid]);
                    }
                }
                \LogActivity::addToLog('Update Holiday Status ' . $shitData->EmployeeID . ' & ' . $shitData->Date);
                return response()->json(array('success' => getNotify(2)));                 
            }else{               
                $rules = [
                    'Shift' => 'required|max:1',                  
                ];
                $validation = Validator::make($attributes, $rules);
                if ($validation->fails()) {
                    return response()->json(array('errors' => getNotify(4)));
                } else {                  
                    $shift = strtoupper(strip_tags($request->Shift));                    
                    $shiftinfo = Shifts::where('Shift', $shift)->pluck('Shift')->first();
                    if ($shiftinfo) {
                        if ($shitData->Shift != $shiftinfo) {
                            $shitData->updated_at = Carbon::now();
                            $shitData->Shift = $shiftinfo;                        
                            $shitData->save();

                            \LogActivity::addToLog('Update Shift Info ' . $shitData->EmployeeID . ' & ' . $shitData->Date . ' & ' . $shitData->Shift);
                            return response()->json(array('success' => getNotify(2)));
                        } else {
                            return response()->json(array('errors' => getNotify(12)));
                        }
                    } else {
                        return response()->json(array('errors' => getNotify(8)));
                    }
                }
            }
        } else {
            return redirect()->back()->with('warning', getNotify(5));
        }
    }

    public function getShifting(Request $request)
    {
        $empl = DB::table('hr_tools_shiftinglist as shift')
            ->where('shift.Date', $request->d_date)
            ->where('shift.company_id',getHostInfo()['id'])
            ->leftJoin('hr_database_employee_basic as basic', 'shift.EmployeeID', '=', 'basic.EmployeeID')
            ->select('shift.*', 'basic.Name', 'basic.JoiningDate')
            ->orderBy('basic.EmployeeID', 'ASC')
            ->orderBy('shift.Date', 'ASC')
            ->get();
        return response()->json($empl);
    }

    public function getShiftingTwo(Request $request)
    {
        $type = $request->type;
        if($type == 'personal'){
            $shiftlist = Shifts::whereRaw('FIND_IN_SET(?, company_id)', [getHostInfo()['id']])->orderBy('id', 'ASC')->where('C4S', 'Y')->get();
            $companies = Company::where('id',getHostInfo()['id'])->get();
            $hdTypes = ['N','DO','DDO','PH'];
            $empID = Sentinel::getUser()->empid;
            $empl = DB::table('hr_tools_shiftinglist as shift')
                ->where('shift.EmployeeID', $empID)
                ->where('shift.company_id',getHostInfo()['id'])
                ->whereBetween('shift.Date', [$request->start_date, $request->end_date])                  
                ->leftJoin('hr_database_employee_basic as basic', 'shift.EmployeeID', '=', 'basic.EmployeeID')
                ->select('shift.*', 'basic.Name', 'basic.JoiningDate')
                ->orderBy('basic.EmployeeID', 'ASC')
                ->orderBy('shift.Date', 'ASC')
                ->get();           
            return response()->json([$empl,$companies,$shiftlist,$hdTypes]);
        }else{
            $companies = Company::whereIn('id',getCompanyIds())->get();
            $shiftlist = Shifts::whereRaw('FIND_IN_SET(?, company_id)', [getHostInfo()['id']])->orderBy('id', 'ASC')->where('C4S', 'Y')->get();
            $hdTypes = ['N','DO','DDO','PH'];
            if ($request->emp_id && $request->Shift) {
                $empl = DB::table('hr_tools_shiftinglist as shift')
                    ->where('shift.EmployeeID', $request->emp_id)
                    ->where('shift.company_id',getHostInfo()['id'])
                    ->whereBetween('shift.Date', [$request->start_date, $request->end_date])
                    ->where('shift.Shift', $request->Shift)
                    ->leftJoin('hr_database_employee_basic as basic', 'shift.EmployeeID', '=', 'basic.EmployeeID')
                    ->select('shift.*', 'basic.Name', 'basic.JoiningDate')
                    ->orderBy('basic.EmployeeID', 'ASC')
                    ->orderBy('shift.Date', 'ASC')
                    ->get();
            } elseif ($request->emp_id && !$request->Shift) {
                $empl = DB::table('hr_tools_shiftinglist as shift')
                    ->where('shift.EmployeeID', $request->emp_id)
                    ->where('shift.company_id',getHostInfo()['id'])
                    ->whereBetween('shift.Date', [$request->start_date, $request->end_date])
                    ->leftJoin('hr_database_employee_basic as basic', 'shift.EmployeeID', '=', 'basic.EmployeeID')
                    ->select('shift.*', 'basic.Name', 'basic.JoiningDate')
                    ->orderBy('basic.EmployeeID', 'ASC')
                    ->orderBy('shift.Date', 'ASC')
                    ->get();
            } elseif (!$request->emp_id && $request->Shift) {
                $empl = DB::table('hr_tools_shiftinglist as shift')
                    ->where('shift.company_id',getHostInfo()['id'])
                    ->whereBetween('shift.Date', [$request->start_date, $request->end_date])
                    ->where('shift.Shift', $request->Shift)
                    ->leftJoin('hr_database_employee_basic as basic', 'shift.EmployeeID', '=', 'basic.EmployeeID')
                    ->select('shift.*', 'basic.Name', 'basic.JoiningDate')
                    ->orderBy('basic.EmployeeID', 'ASC')
                    ->orderBy('shift.Date', 'ASC')
                    ->get();
            } else {
                $empl = DB::table('hr_tools_shiftinglist as shift')
                    ->where('shift.company_id',getHostInfo()['id'])
                    ->whereBetween('shift.Date', [$request->start_date, $request->end_date])
                    ->leftJoin('hr_database_employee_basic as basic', 'shift.EmployeeID', '=', 'basic.EmployeeID')
                    ->select('shift.*', 'basic.Name', 'basic.JoiningDate')
                    ->orderBy('basic.EmployeeID', 'ASC')
                    ->orderBy('shift.Date', 'ASC')
                    ->get();
            }
            
            return response()->json([$empl,$companies,$hdTypes,$shiftlist]);
        }
      
    }
}
