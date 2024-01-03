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
use App\Models\HRIS\Tools\PunchData;
use App\Models\HRIS\Setup\Department;
use App\Models\HRIS\Database\Employee;
use App\Models\Library\General\Company;
use App\Models\HRIS\Database\Punishment;
use App\Models\HRIS\Tools\ProcessSalary;
use App\Models\HRIS\Tools\HolidayAllowance;
use App\Models\HRIS\Tools\ProcessAttendance;
use App\Models\HRIS\Database\AttendanceApproval;
use App\Models\HRIS\Database\OvertimeAdjustment;

class AttendanceProcessController extends Controller
{
    public function index(Request $request)
    {
        if (getAccess('view')) {
            $attandenceProcess = ProcessAttendance::join('hr_database_employee_basic as basic','basic.EmployeeID','=','payroll_tools_processattendance.EmployeeID')->select('basic.company_id',DB::raw("year(WorkDate) as  Year, month(WorkDate) as Month"))->whereIn('basic.company_id',getCompanyIds())->groupBy('basic.company_id','Year','Month');
            
            if($request->date){
                $date = $request->date.'-01';
                $attandenceProcess = $attandenceProcess->where('WorkDate', $request->date);
            }
            $attandenceProcess = $attandenceProcess->get();

            return view('hris.tools.attendanceprocess.index',compact('request','attandenceProcess'));
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
                'StartDate' => 'date',
                'Year' => 'numeric',
                'Month' => 'numeric',
                'company_id' => 'numeric',
            ];
            $validation = Validator::make($attributes, $rules);
            if ($validation->fails()) {
                return redirect()->back()->with('error', getNotify(4))->withErrors($validation)->withInput();
            } else {
                $company = $attributes['company_id'];
                $prodate = Carbon::now()->format('Y-m-d');
                $year = $attributes['Year']; $month = $attributes['Month'];
                $start_date = Carbon::parse($year.'-'.$month.'-01')->startOfMonth()->format('Y-m-d');
                $end_date = Carbon::parse($year.'-'.$month.'-01')->endOfMonth()->format('Y-m-d');

                if ($attributes['title'] == 1) {
                    if ($end_date <= $prodate) {
                        $end_date = $end_date;
                    }else{
                        $end_date = $prodate;
                    }
                    $chk = PunchData::whereYear('WorkDate', '=', $year)->whereMonth('WorkDate', '=', $month)->where('company_id',$company)->first();
                    $chk2 = ProcessAttendance::whereYear('WorkDate', '=', $year)->whereMonth('WorkDate', '=', $month)->where('company_id',$company)->first();
                    if ($chk == null && $chk2 == null) {
                        $start = $start_date;
                        if ($start <= $prodate && $prodate <= $end_date) {
                            $end = $prodate;
                        } else {
                            $end = $end_date;
                        }
                        $shiftdata = DB::table('hr_setup_shifts')->orderBy('Shift', 'ASC')->select('Shift', 'ShiftStartHour', 'ShiftStartMinute', 'ShiftEndHour', 'ShiftEndMinute', 'BreakDurationHours','BufferTime')->get();
                        $excepdutydata = DB::table('payroll_tools_exceptionalduty')->orderBy('EmployeeID', 'ASC')->where('Year', $year)->where('Month', $month)->where('C4S', 'Y')->get();
                        $employeeids = DB::table('hr_database_employee_basic')
                            ->where('ReasonID', 'N')
                            //->where('EmployeeID',16007)
                            ->where('JoiningDate', '<=', $end)
                            ->where('company_id',$company)
                            ->orWhere('LeavingDate', '>', $start)
                            ->where('JoiningDate', '<=', $end)
                            ->where('company_id',$company)
                            ->select('EmployeeID', 'company_id', 'ShiftingDuty', 'DepartmentID')
                            ->orderBy('EmployeeID', 'ASC')
                            ->get();
                        $vempids = collect($employeeids)->pluck('EmployeeID');
                        $lastid = PunchData::orderBy('id', 'DESC')->pluck('id')->first() + 1;
                        $splitemps = collect($employeeids)->chunk(350)->toArray();
                        foreach ($splitemps as $splitemp) {
                            $empids = collect($splitemp)->pluck('EmployeeID')->toArray();
                            $start = $start_date;
                            $nextday = Carbon::parse($end)->addDays(1)->format('Y-m-d');
                            $shiftingdata = DB::table('hr_tools_shiftinglist')->orderBy('EmployeeID', 'ASC')->orderBy('Date', 'ASC')->whereIn('EmployeeID', $empids)->whereBetween('Date', [$start, $nextday])->select('EmployeeID', 'Date', 'Shift','Holiday')->get();
                            while ($start <= $end) {
                                $punchstart = Carbon::parse($start)->startOfDay()->format('Y-m-d H:i:s');
                                $punchend = Carbon::parse($start)->addDays(1)->endOfDay()->format('Y-m-d H:i:s');
                                $punchinfo = DB::table('payroll_tools_readpunchrecords')->orderBy('EmployeeID', 'ASC')->orderBy('AttnDate', 'ASC')->whereIn('EmployeeID', $empids)->whereBetween('AttnDate', [$punchstart, $punchend])->select('EmployeeID', 'AttnDate')->get();
                                $shiftingdata2 = collect($shiftingdata)->where('Date', $start)->all();
                                $nextday2 = Carbon::parse($start)->addDays(1)->format('Y-m-d');
                                foreach ($splitemp as $employee) {
                                    $emp = $employee->EmployeeID;
                                    $startpunch = NULL;
                                    $endpunch = NULL;
                                    $empid = $emp;
                                    $shifting = collect($shiftingdata2)->where('EmployeeID', $emp)->pluck('Shift')->first();
                                    $shiftinfo = collect($shiftdata)->where('Shift', $shifting)->first();
                                    if ($shiftinfo == null) {
                                        $shiftinfo = collect($shiftdata)->where('Shift', 'G')->first();
                                    }
                                    $shift = $shiftinfo->Shift;
                                    $startdate = Carbon::parse($start)->startOfDay();

                                    $starthr = $startdate->copy()->addHours($shiftinfo->ShiftStartHour)->addMinutes($shiftinfo->ShiftStartMinute)->format('Y-m-d H:i:s');
                                    $endhr = $startdate->copy()->addHours($shiftinfo->ShiftEndHour)->addMinutes($shiftinfo->ShiftEndMinute)->format('Y-m-d H:i:s');

                                    //for custom schedule
                                    $excepduty = collect($excepdutydata)->where('EmployeeID', $empid)->first();
                                    if ($excepduty) {
                                        if ($shift == $excepduty->Shift) {
                                            $starthr = $startdate->copy()->addHours($shiftinfo->ShiftStartHour)->addMinutes($excepduty->StartMinute)->format('Y-m-d H:i:s');
                                            $endhr = $startdate->copy()->addHours($shiftinfo->ShiftEndHour)->addMinutes($excepduty->EndMinute)->format('Y-m-d H:i:s');
                                        } else {
                                            $starthr = $startdate->copy()->addHours($excepduty->StartHour)->addMinutes($excepduty->StartMinute)->format('Y-m-d H:i:s');
                                            $endhr = $startdate->copy()->addHours($excepduty->EndHour)->addMinutes($excepduty->EndMinute)->format('Y-m-d H:i:s');
                                        }
                                    }

                                    $startlimit = $startdate->copy()->addHours($shiftinfo->ShiftStartHour - 3)->format('Y-m-d H:i:s');
                                    $endlimit = $startdate->copy()->addHours($shiftinfo->ShiftEndHour + 6)->format('Y-m-d H:i:s');

                                    if ($employee->ShiftingDuty == 'Y') {
                                        if (Carbon::parse($startdate)->isFriday()) {
                                            $startlimit = $startdate->copy()->addHours($shiftinfo->ShiftStartHour - 2)->format('Y-m-d H:i:s');
                                            $endlimit = $startdate->copy()->addHours($shiftinfo->ShiftEndHour + 8)->format('Y-m-d H:i:s');
                                        }
                                    }

                                    $filteredone = collect($punchinfo)->filter(function ($item) use ($starthr, $startlimit, $emp) {
                                        return $item->EmployeeID == $emp && $item->AttnDate > $startlimit && $item->AttnDate <= $starthr;
                                    });
                                    $filteredtwo = collect($punchinfo)->filter(function ($item) use ($starthr, $endhr, $emp) {
                                        return $item->EmployeeID == $emp && $item->AttnDate > $starthr && $item->AttnDate < $endhr;
                                    });
                                    $filteredthree = collect($punchinfo)->filter(function ($item) use ($endhr, $endlimit, $emp) {
                                        return $item->EmployeeID == $emp && $item->AttnDate >= $endhr && $item->AttnDate <= $endlimit;
                                    });
                                    //dd($emp,$starthr, $endhr, $filteredone, $filteredtwo, $filteredthree, $punchinfo, $startlimit, $emp);

                                    if(count($filteredone)){
                                        $startpunch = $filteredone->max('AttnDate');
                                    }elseif(count($filteredtwo)){
                                        $startpunch = $filteredtwo->min('AttnDate');
                                    }elseif(count($filteredthree)){
                                        $startpunch = $filteredthree->min('AttnDate');
                                    }

                                    if ($employee->ShiftingDuty == 'N') {
                                        if (count($filteredthree)) {
                                            $endpunch = $filteredthree->max('AttnDate');
                                        } elseif (count($filteredtwo)) {
                                            $endpunch = $filteredtwo->max('AttnDate');
                                        } elseif (count($filteredone)) {
                                            $endpunch = $filteredone->max('AttnDate');
                                        }
                                    } elseif ($employee->ShiftingDuty == 'Y') {
                                        if (count($filteredthree)) {
                                            $endpunch = $filteredthree->min('AttnDate');
                                        } elseif (count($filteredtwo)) {
                                            $endpunch = $filteredtwo->max('AttnDate');
                                        } elseif (count($filteredone)) {
                                            $endpunch = $filteredone->max('AttnDate');
                                        }
                                    }
                                    //dd($starthr,$endhr,$startpunch,$endpunch,$punchinfo);

                                    $createdat = Carbon::now();
                                    if (empty($startpunch) || empty($endpunch)) {
                                        DB::insert("INSERT INTO payroll_tools_punchdata (id, EmployeeID, company_id, WorkDate, Shift, StartPunch, EndPunch, CreatedBy, created_at) VALUES ('$lastid','$emp','$company','$start','$shift',NULL,NULL,'$userid','$createdat')");
                                    } else {
                                        DB::insert("INSERT INTO payroll_tools_punchdata (id, EmployeeID, company_id, WorkDate, Shift, StartPunch, EndPunch, CreatedBy, created_at) VALUES ('$lastid','$emp','$company','$start','$shift','$startpunch','$endpunch','$userid','$createdat')");
                                    }

                                    $lastid++;
                                }
                                $start = date("Y-m-d", strtotime("+1 day", strtotime($start)));
                            }
                        }
                        \LogActivity::addToLog('Add Pre-Process For Attendance');

                        //process attendance
                        $startdt = Carbon::parse($attributes['Year'].'-'.$attributes['Month'])->startOfMonth()->format('Y-m-d');
                        $enddt = Carbon::parse($startdt)->endOfMonth()->format('Y-m-d');

                        $exphdemp = DB::table('hr_setup_holidayexceptions')->orderBy('EmployeeID', 'ASC')->where('C4S', 'Y')->pluck('EmployeeID');
                        $punchempids = DB::table('hr_database_employee_basic')->where('ReasonID', 'N')->whereNotIn('EmployeeID', $exphdemp)->where('JoiningDate', '<=', $enddt)->where('company_id',$company)->orWhere('LeavingDate', '>', $startdt)->whereNotIn('EmployeeID', $exphdemp)->where('JoiningDate', '<=', $enddt)->where('company_id',$company)->orderBy('EmployeeID', 'ASC')->pluck('EmployeeID');
                        $employees = DB::table('hr_database_employee_basic as basic')
                            ->whereIn('basic.EmployeeID', $punchempids)
                            //->where('basic.Salaried', 'Y')
                            ->leftJoin('hr_database_employee_salary as salary', 'basic.EmployeeID', '=', 'salary.EmployeeID')
                            ->leftJoin('hr_setup_designation', 'basic.DesignationID', '=', 'hr_setup_designation.id')
                            ->select('basic.EmployeeID', 'basic.company_id', 'basic.DepartmentID', 'hr_setup_designation.CategoryID', 'basic.JoiningDate', 'basic.LeavingDate', 'basic.ReasonID', 'basic.PunchCategoryID', 'basic.ShiftingDuty', 'salary.OTPayable', 'salary.Basic', 'salary.HolidayAllowance')
                            ->orderBy('basic.EmployeeID', 'ASC')
                            ->get();
                        $exphddata = DB::table('hr_tools_exceptionalholidays')->orderBy('EmployeeID', 'ASC')->orderBy('WeeklyHolidayDate', 'ASC')->whereIn('EmployeeID', $punchempids)->whereBetween('WeeklyHolidayDate', [$startdt, $enddt])->select('EmployeeID', 'WeeklyHolidayDate')->get();
                        $calhddata = DB::table('hr_tools_calendar')->orderBy('Date', 'ASC')->select('Date', 'Holiday', 'PublicHoliday')->whereBetween('Date', [$startdt, $enddt])->where('company_id',$company)->get();
                        $leavedata = DB::table('hr_database_leave_individual')->orderBy('EmployeeID', 'ASC')->orderBy('StartDate', 'ASC')->whereBetween('StartDate', [$startdt, $enddt])->orWhereBetween('EndDate', [$startdt, $enddt])->select('EmployeeID', 'StartDate', 'EndDate', 'LeaveTypeID')->get();
                        //$excepdutydata = DB::table('payroll_tools_exceptionalduty')->orderBy('EmployeeID', 'ASC')->where('Year', $year)->where('Month', $month)->where('C4S', 'Y')->get();
                        $lastid = ProcessAttendance::orderBy('id', 'DESC')->pluck('id')->first() + 1;

                        $splitemps = collect($employees)->chunk(350)->toArray();
                        foreach ($splitemps as $splitemp) {
                            $empids = collect($splitemp)->pluck('EmployeeID')->toArray();
                            $leavedata2 = collect($leavedata)->whereIn('EmployeeID', $empids)->all();
                            $punchrecords = DB::table('payroll_tools_punchdata')->orderBy('EmployeeID', 'ASC')->orderBy('WorkDate', 'ASC')->whereIn('EmployeeID', $empids)->whereBetween('WorkDate', [$startdt, $enddt])->select('EmployeeID', 'WorkDate', 'StartPunch', 'EndPunch', 'Shift')->get();
                            foreach ($splitemp as $employee) {
                                $empid = $employee->EmployeeID;
                                if ($employee->JoiningDate >= $startdt) {
                                    $start_date = $employee->JoiningDate;
                                } else {
                                    $start_date = $startdt;
                                }

                                if ($employee->LeavingDate > $startdt && $employee->LeavingDate <= $enddt) {
                                    $end_date = Carbon::parse($employee->LeavingDate)->subDays(1)->format('Y-m-d');
                                } else {
                                    $end_date = $enddt;
                                }
                                $punchrecord = collect($punchrecords)->where('EmployeeID', $empid)->all();
                                while ($start_date <= $end_date) {
                                    $calhd = collect($calhddata)->where('Date', $start_date)->first();
                                    $expcalhd = collect($exphddata)->filter(function ($item) use ($empid, $start_date) {
                                        return $item->EmployeeID == $empid && $item->WeeklyHolidayDate == $start_date;
                                    })->first();
                                    $leaveinfo = collect($leavedata2)->filter(function ($item) use ($empid, $start_date) {
                                        return $item->EmployeeID == $empid && $item->StartDate <= $start_date && $item->EndDate >= $start_date;
                                    })->pluck('LeaveTypeID')->first();
                                    $punchinfo = collect($punchrecord)->filter(function ($item) use ($start_date) {
                                        return $item->WorkDate == $start_date;
                                    })->first();
                                    if ($punchinfo) {
                                        $startpunch = $punchinfo->StartPunch;
                                        $endpunch = $punchinfo->EndPunch;
                                        $shiftinfo = collect($shiftdata)->where('Shift', $punchinfo->Shift)->first();
                                    } else {
                                        $startpunch = 0;
                                        $endpunch = 0;
                                        $shiftinfo = collect($shiftdata)->where('Shift', 'G')->first();
                                    }
                                    if ($shiftinfo == null) {
                                        $shiftinfo = collect($shiftdata)->where('Shift', 'G')->first();
                                    }
                                    $shift = $shiftinfo->Shift;
                                    $startdate = Carbon::parse($start_date)->startOfDay();
                                    $starthr = $startdate->copy()->addHours($shiftinfo->ShiftStartHour)->addMinute($shiftinfo->ShiftStartMinute)->format('Y-m-d H:i:s');
                                    $endhr = $startdate->copy()->addHours($shiftinfo->ShiftEndHour)->addMinute($shiftinfo->ShiftEndMinute)->format('Y-m-d H:i:s');
                                    $vstartpunch = roundHour($startpunch);
                                    $vendpunch = roundHour($endpunch);

                                    //for custom schedule
                                    $excepduty = collect($excepdutydata)->where('EmployeeID', $empid)->first();
                                    if ($excepduty) {
                                        if ($shift == $excepduty->Shift) {
                                            $starthr = $startdate->copy()->addHours($shiftinfo->ShiftStartHour)->addMinutes($excepduty->StartMinute)->format('Y-m-d H:i:s');
                                            $endhr = $startdate->copy()->addHours($shiftinfo->ShiftEndHour)->addMinutes($excepduty->EndMinute)->format('Y-m-d H:i:s');
                                        } else {
                                            $starthr = $startdate->copy()->addHours($excepduty->StartHour)->addMinutes($excepduty->StartMinute)->format('Y-m-d H:i:s');
                                            $endhr = $startdate->copy()->addHours($excepduty->EndHour)->addMinutes($excepduty->EndMinute)->format('Y-m-d H:i:s');
                                        }
                                    }

                                    $createdat = Carbon::now();
                                    if ($leaveinfo && $vstartpunch == 0 && $vendpunch == 0) {
                                        $wwh = $leaveinfo == 'LWP' ? 0 : 8;
                                        DB::insert("INSERT INTO payroll_tools_processattendance (id, EmployeeID, company_id, WorkDate, WageWorkHour, AttnType, Shift, CreatedBy, created_at) VALUES ('$lastid','$empid','$company','$start_date','$wwh','$leaveinfo','$shift','$userid','$createdat')");
                                    } elseif ($leaveinfo) {
                                        $wwh = $leaveinfo == 'LWP' ? 0 : 8;
                                        DB::insert("INSERT INTO payroll_tools_processattendance (id, EmployeeID, company_id, WorkDate, StartPunch, EndPunch, WageWorkHour, AttnType, Shift, CreatedBy, created_at) VALUES ('$lastid','$empid','$company','$start_date','$startpunch','$endpunch','$wwh','$leaveinfo','$shift','$userid','$createdat')");
                                    } elseif ($calhd && $calhd->PublicHoliday == 'Y') {
                                        DB::insert("INSERT INTO payroll_tools_processattendance (id, EmployeeID, company_id, WorkDate, WageWorkHour, AttnType, Shift, CreatedBy, created_at) VALUES ('$lastid','$empid','$company','$start_date',8,'HD','$shift','$userid','$createdat')");
                                    } elseif ($calhd && $calhd->Holiday == 'Y' && $vstartpunch == 0 && $vendpunch == 0) {
                                        DB::insert("INSERT INTO payroll_tools_processattendance (id, EmployeeID, company_id, WorkDate, WageWorkHour, AttnType, Shift, CreatedBy, created_at) VALUES ('$lastid','$empid','$company','$start_date',8,'HD','$shift','$userid','$createdat')");
                                    } elseif ($calhd && $calhd->Holiday == 'Y') {
                                        $chkothour = 0; $totalhour = 0;
                                        if ($startpunch > 0 && $endpunch > 0) {
                                            if ($employee->OTPayable == 'Y') {
                                                $othour = hourCalculateActual($startpunch, $endpunch);
                                                $chkothour = $othour > 8 ? $othour - 1 : $othour;
                                            }
                                        }
                                        $hdothour = $chkothour > 0 ? $chkothour : 0;
                                        $totalhour = hourCalculateActual($starthr, $endpunch);
                                        DB::insert("INSERT INTO payroll_tools_processattendance (id, EmployeeID, company_id, WorkDate, StartPunch, EndPunch, WageWorkHour, OTHour, TotalHour, AttnType, Shift, CreatedBy, created_at) VALUES ('$lastid','$empid','$company','$start_date','$startpunch','$endpunch',8,'$hdothour','$totalhour','HD','$shift','$userid','$createdat')");
                                    } elseif ($expcalhd && $vstartpunch == 0 && $vendpunch == 0) {
                                        DB::insert("INSERT INTO payroll_tools_processattendance (id, EmployeeID, company_id, WorkDate, WageWorkHour, AttnType, Shift, CreatedBy, created_at) VALUES ('$lastid','$empid','$company','$start_date',8,'HD','$shift','$userid','$createdat')");
                                    } elseif ($expcalhd) {
                                        $chkothour = 0; $totalhour = 0;
                                        if ($startpunch > 0 && $endpunch > 0) {
                                            if ($employee->OTPayable == 'Y') {
                                                $othour = hourCalculateActual($startpunch, $endpunch);
                                                $chkothour = $othour > 8 ? $othour - 1 : $othour;
                                            }
                                        }
                                        $hdothour = $chkothour > 0 ? $chkothour : 0;
                                        $totalhour = hourCalculateActual($starthr, $endpunch);
                                        DB::insert("INSERT INTO payroll_tools_processattendance (id, EmployeeID, company_id, WorkDate, StartPunch, EndPunch, WageWorkHour, OTHour, TotalHour, AttnType, Shift, CreatedBy, created_at) VALUES ('$lastid','$empid','$company','$start_date','$startpunch','$endpunch',8,'$hdothour','$totalhour','HD','$shift','$userid','$createdat')");
                                    } elseif ($employee->PunchCategoryID == 2 && $vstartpunch > 0 && $vendpunch > 0) {
                                        if ($startpunch <= $starthr && $endhr <= $endpunch) {
                                            $rwhorg = hourCalculateActual($starthr, $endhr);
                                        } elseif ($startpunch > $starthr && $endhr <= $endpunch) {
                                            $rwhorg = hourCalculateActual($startpunch, $endhr);
                                        } elseif ($startpunch <= $starthr && $endhr > $endpunch) {
                                            $rwhorg = hourCalculateActual($starthr, $endpunch);
                                        } elseif ($startpunch > $starthr && $endhr > $endpunch) {
                                            $rwhorg = hourCalculateActual($startpunch, $endpunch);
                                        } else {
                                            $rwhorg = 0;
                                        }
                                        $totalothr = $endhr < $endpunch ? ($endhr > $startpunch ? hourCalculateActual($endhr, $endpunch) : hourCalculateActual($startpunch, $endpunch)) : 0;
                                        $realhr = $rwhorg;
                                        $rwhfin = $realhr >= 8 ? 8 : ($realhr > 0 ? $realhr : 0);
                                        $totalhour = hourCalculateActual($starthr, $endpunch);
                                        $latemin = $starthr < $startpunch ? Carbon::parse($startpunch)->diffInMinutes($starthr) : 0;
                                        $late = $latemin > $shiftinfo->BufferTime ? 'Y' : 'N';
                                        $othour = $employee->OTPayable == 'Y' ? $totalothr : 0;
                                        $attntype = $startpunch < $endpunch ? 'PR' : 'AB';
                                        DB::insert("INSERT INTO payroll_tools_processattendance (id, EmployeeID, company_id, WorkDate, StartPunch, EndPunch, RealWorkHour, WageWorkHour, OTHour, TotalHour, AttnType, Shift, IsLate, LateMins, CreatedBy, created_at) VALUES ('$lastid','$empid','$company','$start_date','$startpunch','$endpunch','$rwhfin','$rwhfin','$othour','$totalhour','$attntype','$shift','$late','$latemin','$userid','$createdat')");
                                    } elseif ($employee->PunchCategoryID == 1 && ($startpunch > 0 || $endpunch > 0)) {
                                        DB::insert("INSERT INTO payroll_tools_processattendance (id, EmployeeID, company_id, WorkDate, StartPunch, EndPunch, RealWorkHour, WageWorkHour, AttnType, Shift, CreatedBy, created_at) VALUES ('$lastid','$empid','$company','$start_date','$startpunch','$endpunch','8','8','PR','$shift','$userid','$createdat')");
                                    } elseif ($employee->PunchCategoryID == 0) {
                                        DB::insert("INSERT INTO payroll_tools_processattendance (id, EmployeeID, company_id, WorkDate, RealWorkHour, WageWorkHour, AttnType, Shift, CreatedBy, created_at) VALUES ('$lastid','$empid','$company','$start_date','8','8','PR','$shift','$userid','$createdat')");
                                    } else {
                                        if (empty($startpunch) || empty($endpunch)) {
                                            DB::insert("INSERT INTO payroll_tools_processattendance (id, EmployeeID, company_id, WorkDate, StartPunch, EndPunch, AttnType, Shift, CreatedBy, created_at) VALUES ('$lastid','$empid','$company','$start_date',NULL,NULL,'AB','$shift','$userid','$createdat')");
                                        } else {
                                            DB::insert("INSERT INTO payroll_tools_processattendance (id, EmployeeID, company_id, WorkDate, StartPunch, EndPunch, AttnType, Shift, CreatedBy, created_at) VALUES ('$lastid','$empid','$company','$start_date','$startpunch','$endpunch','AB','$shift','$userid','$createdat')");
                                        }
                                    }

                                    $start_date = $startdate->copy()->addDays(1)->format('Y-m-d');
                                    $lastid++;
                                }
                            }
                        }

                        //execptional holiday
                        $punchempids2 = DB::table('hr_database_employee_basic')->where('ReasonID', 'N')->whereIn('EmployeeID', $exphdemp)->where('JoiningDate', '<=', $enddt)->where('company_id',$company)->orWhere('LeavingDate', '>', $startdt)->whereIn('EmployeeID', $exphdemp)->where('JoiningDate', '<=', $enddt)->where('company_id',$company)->orderBy('EmployeeID', 'ASC')->pluck('EmployeeID');
                        $expempids = DB::table('hr_database_employee_basic as basic')
                            ->whereIn('basic.EmployeeID', $punchempids2)
                            //->where('basic.Salaried', 'Y')
                            ->leftJoin('hr_database_employee_salary as salary', 'basic.EmployeeID', '=', 'salary.EmployeeID')
                            ->leftJoin('hr_setup_designation', 'basic.DesignationID', '=', 'hr_setup_designation.id')
                            ->select('basic.EmployeeID', 'basic.company_id', 'basic.DepartmentID', 'hr_setup_designation.CategoryID', 'basic.JoiningDate', 'basic.LeavingDate', 'basic.ReasonID', 'basic.PunchCategoryID', 'basic.ShiftingDuty', 'salary.OTPayable', 'salary.Basic', 'salary.HolidayAllowance')
                            ->orderBy('basic.EmployeeID', 'ASC')
                            ->get();
                        $exphddata = DB::table('hr_tools_exceptionalholidays')->orderBy('EmployeeID', 'ASC')->orderBy('WeeklyHolidayDate', 'ASC')->whereIn('EmployeeID', $punchempids2)->whereBetween('WeeklyHolidayDate', [$startdt, $enddt])->select('EmployeeID', 'WeeklyHolidayDate')->get();
                        $splitexpemps = collect($expempids)->chunk(350)->toArray();
                        foreach ($splitexpemps as $splitexpemp) {
                            $expempids = collect($splitexpemp)->pluck('EmployeeID')->toArray();
                            $leavedata2 = collect($leavedata)->whereIn('EmployeeID', $expempids)->all();
                            $punchrecords = DB::table('payroll_tools_punchdata')->orderBy('EmployeeID', 'ASC')->orderBy('WorkDate', 'ASC')->whereIn('EmployeeID', $expempids)->whereBetween('WorkDate', [$startdt, $enddt])->select('EmployeeID', 'WorkDate', 'StartPunch', 'EndPunch', 'Shift')->get();
                            foreach ($splitexpemp as $employee) {
                                $empid = $employee->EmployeeID;
                                if ($employee->JoiningDate >= $startdt) {
                                    $start_date = $employee->JoiningDate;
                                } else {
                                    $start_date = $startdt;
                                }
                                if ($employee->LeavingDate > $startdt && $employee->LeavingDate <= $enddt) {
                                    $end_date = Carbon::parse($employee->LeavingDate)->subDays(1)->format('Y-m-d');
                                } else {
                                    $end_date = $enddt;
                                }
                                $punchrecord = collect($punchrecords)->where('EmployeeID', $empid)->all();
                                while ($start_date <= $end_date) {
                                    $calhd = collect($calhddata)->where('Date', $start_date)->first();
                                    $expcalhd = collect($exphddata)->filter(function ($item) use ($empid, $start_date) {
                                        return $item->EmployeeID == $empid && $item->WeeklyHolidayDate == $start_date;
                                    })->first();
                                    $leaveinfo = collect($leavedata2)->filter(function ($item) use ($empid, $start_date) {
                                        return $item->EmployeeID == $empid && $item->StartDate <= $start_date && $item->EndDate >= $start_date;
                                    })->pluck('LeaveTypeID')->first();
                                    $punchinfo = collect($punchrecord)->filter(function ($item) use ($start_date) {
                                        return $item->WorkDate == $start_date;
                                    })->first();
                                    if ($punchinfo) {
                                        $startpunch = $punchinfo->StartPunch;
                                        $endpunch = $punchinfo->EndPunch;
                                        $shiftinfo = collect($shiftdata)->where('Shift', $punchinfo->Shift)->first();
                                    } else {
                                        $startpunch = 0;
                                        $endpunch = 0;
                                        $shiftinfo = collect($shiftdata)->where('Shift', 'G')->first();
                                    }
                                    if ($shiftinfo == null) {
                                        $shiftinfo = collect($shiftdata)->where('Shift', 'G')->first();
                                    }
                                    $shift = $shiftinfo->Shift;
                                    $startdate = Carbon::parse($start_date)->startOfDay();
                                    $excepduty2 = collect($excepdutydata)->where('EmployeeID', $empid)->first();
                                    if ($excepduty2) {
                                        $starthr = $startdate->copy()->addHours($excepduty2->StartHour)->addMinutes($excepduty2->StartMinute)->format('Y-m-d H:i:s');
                                        $endhr = $startdate->copy()->addHours($excepduty2->EndHour)->addMinutes($excepduty2->EndMinute)->format('Y-m-d H:i:s');
                                    } else {
                                        $starthr = $startdate->copy()->addHours($shiftinfo->ShiftStartHour)->addMinute($shiftinfo->ShiftStartMinute)->format('Y-m-d H:i:s');
                                        $endhr = $startdate->copy()->addHours($shiftinfo->ShiftEndHour)->addMinute($shiftinfo->ShiftEndMinute)->format('Y-m-d H:i:s');
                                    }
                                    $vstartpunch = roundHour($startpunch);
                                    $vendpunch = roundHour($endpunch);

                                    $createdat = Carbon::now();
                                    if ($leaveinfo && $vstartpunch == 0 && $vendpunch == 0) {
                                        $wwh = $leaveinfo == 'LWP' ? 0 : 8;
                                        DB::insert("INSERT INTO payroll_tools_processattendance (id, EmployeeID, company_id, WorkDate, WageWorkHour, AttnType, Shift, CreatedBy, created_at) VALUES ('$lastid','$empid','$company','$start_date','$wwh','$leaveinfo','$shift','$userid','$createdat')");
                                    } elseif ($leaveinfo) {
                                        $wwh = $leaveinfo == 'LWP' ? 0 : 8;
                                        DB::insert("INSERT INTO payroll_tools_processattendance (id, EmployeeID, company_id, WorkDate, StartPunch, EndPunch, WageWorkHour, AttnType, Shift, CreatedBy, created_at) VALUES ('$lastid','$empid','$company','$start_date','$startpunch','$endpunch','$wwh','$leaveinfo','$shift','$userid','$createdat')");
                                    } elseif ($calhd && $calhd->PublicHoliday == 'Y') {
                                        DB::insert("INSERT INTO payroll_tools_processattendance (id, EmployeeID, company_id, WorkDate, WageWorkHour, AttnType, Shift, CreatedBy, created_at) VALUES ('$lastid','$empid','$company','$start_date',8,'HD','$shift','$userid','$createdat')");
                                    } elseif ($expcalhd && $vstartpunch == 0 && $vendpunch == 0) {
                                        DB::insert("INSERT INTO payroll_tools_processattendance (id, EmployeeID, company_id, WorkDate, WageWorkHour, AttnType, Shift, CreatedBy, created_at) VALUES ('$lastid','$empid','$company','$start_date',8,'HD','$shift','$userid','$createdat')");
                                    } elseif ($expcalhd) {
                                        $chkothour = 0; $totalhour = 0;
                                        if ($startpunch > 0 && $endpunch > 0) {
                                            if ($employee->OTPayable == 'Y') {
                                                $othour = hourCalculateActual($startpunch, $endpunch);
                                                $chkothour = $othour > 8 ? $othour - 1 : $othour;
                                            }
                                        }
                                        $hdothour = $chkothour > 0 ? $chkothour : 0;
                                        $totalhour = hourCalculateActual($starthr, $endpunch);
                                        DB::insert("INSERT INTO payroll_tools_processattendance (id, EmployeeID, company_id, WorkDate, StartPunch, EndPunch, WageWorkHour, OTHour, TotalHour, AttnType, Shift, CreatedBy, created_at) VALUES ('$lastid','$empid','$company','$start_date','$startpunch','$endpunch',8,'$hdothour','$totalhour','HD','$shift','$userid','$createdat')");
                                    } elseif ($employee->PunchCategoryID == 2 && $vstartpunch > 0 && $vendpunch > 0) {
                                        if ($startpunch <= $starthr && $endhr <= $endpunch) {
                                            $rwhorg = hourCalculateActual($starthr, $endhr);
                                        } elseif ($startpunch > $starthr && $endhr <= $endpunch) {
                                            $rwhorg = hourCalculateActual($startpunch, $endhr);
                                        } elseif ($startpunch <= $starthr && $endhr > $endpunch) {
                                            $rwhorg = hourCalculateActual($starthr, $endpunch);
                                        } elseif ($startpunch > $starthr && $endhr > $endpunch) {
                                            $rwhorg = hourCalculateActual($startpunch, $endpunch);
                                        } else {
                                            $rwhorg = 0;
                                        }
                                        $totalothr = $endhr < $endpunch ? ($endhr > $startpunch ? hourCalculateActual($endhr, $endpunch) : hourCalculateActual($startpunch, $endpunch)) : 0;
                                        $realhr = $rwhorg;
                                        $rwhfin = $realhr >= 8 ? 8 : ($realhr > 0 ? $realhr : 0);
                                        $totalhour = hourCalculateActual($starthr, $endpunch);
                                        $latemin = $starthr < $startpunch ? Carbon::parse($startpunch)->diffInMinutes($starthr) : 0;
                                        $late = $latemin > $shiftinfo->BufferTime ? 'Y' : 'N';
                                        $othour = $employee->OTPayable == 'Y' ? $totalothr : 0;
                                        $attntype = $startpunch < $endpunch ? 'PR' : 'AB';
                                        DB::insert("INSERT INTO payroll_tools_processattendance (id, EmployeeID, company_id, WorkDate, StartPunch, EndPunch, RealWorkHour, WageWorkHour, OTHour, TotalHour, AttnType, Shift, IsLate, LateMins, CreatedBy, created_at) VALUES ('$lastid','$empid','$company','$start_date','$startpunch','$endpunch','$rwhfin','$rwhfin','$othour','$totalhour','$attntype','$shift','$late','$latemin','$userid','$createdat')");
                                    } elseif ($employee->PunchCategoryID == 1 && ($startpunch > 0 || $endpunch > 0)) {
                                        DB::insert("INSERT INTO payroll_tools_processattendance (id, EmployeeID, company_id, WorkDate, StartPunch, EndPunch, RealWorkHour, WageWorkHour, AttnType, Shift, CreatedBy, created_at) VALUES ('$lastid','$empid','$company','$start_date','$startpunch','$endpunch','8','8','PR','$shift','$userid','$createdat')");
                                    } elseif ($employee->PunchCategoryID == 0) {
                                        DB::insert("INSERT INTO payroll_tools_processattendance (id, EmployeeID, company_id, WorkDate, RealWorkHour, WageWorkHour, AttnType, Shift, CreatedBy, created_at) VALUES ('$lastid','$empid','$company','$start_date','8','8','PR','$shift','$userid','$createdat')");
                                    } else {
                                        if (empty($startpunch) || empty($endpunch)) {
                                            DB::insert("INSERT INTO payroll_tools_processattendance (id, EmployeeID, company_id, WorkDate, StartPunch, EndPunch, AttnType, Shift, CreatedBy, created_at) VALUES ('$lastid','$empid','$company','$start_date',NULL,NULL,'AB','$shift','$userid','$createdat')");
                                        } else {
                                            DB::insert("INSERT INTO payroll_tools_processattendance (id, EmployeeID, company_id, WorkDate, StartPunch, EndPunch, AttnType, Shift, CreatedBy, created_at) VALUES ('$lastid','$empid','$company','$start_date','$startpunch','$endpunch','AB','$shift','$userid','$createdat')");
                                        }
                                    }

                                    $start_date = $startdate->copy()->addDays(1)->format('Y-m-d');
                                    $lastid++;
                                }
                            }
                        }

                        //for Attendance, Punishment & OT Adjustment
                        $start_date = $startdt; $end_date = $enddt;
                        $otadjustments = OvertimeAdjustment::orderBy('EmployeeID', 'ASC')->whereIn('EmployeeID',$vempids)->whereBetween('OTDate', [$start_date, $end_date])->select('EmployeeID', 'OTDate', 'Hours')->get();
                        foreach ($otadjustments as $otadjustment) {
                            $chkid = ProcessAttendance::orderBy('id', 'ASC')->where('EmployeeID', $otadjustment->EmployeeID)->where('WorkDate', $otadjustment->OTDate)->pluck('id')->first();
                            if ($chkid) {
                                $otadjust = ProcessAttendance::find($chkid);
                                $otadjust->OTHour = $otadjust->OTHour + $otadjustment->Hours;
                                $otadjust->CreatedBy = $userid;
                                $otadjust->updated_at = Carbon::now();
                                $otadjust->save();
                            }
                        }
                        
                        $punishments = Punishment::orderBy('EmployeeID', 'ASC')->whereIn('EmployeeID',$vempids)->whereBetween('PMDate', [$start_date, $end_date])->select('EmployeeID', 'PMDate','Deduct_Type')->get();
                        foreach ($punishments as $punishment) {
                            $chkid = ProcessAttendance::orderBy('id', 'ASC')->where('EmployeeID', $punishment->EmployeeID)->where('WorkDate', $punishment->PMDate)->pluck('id')->first();
                            if ($chkid) {
                                if ($punishment->Deduct_Type == 1 || $punishment->Deduct_Type == 2) {
                                    $punish = ProcessAttendance::find($chkid);
                                    $punish->RealWorkHour = 0;
                                    $punish->WageWorkHour = 0;
                                    $punish->OTHour = 0;
                                    $punish->AttnType = 'AB';
                                    $punish->Deduct_Type = $punishment->Deduct_Type;
                                    $punish->CreatedBy = $userid;
                                    $punish->updated_at = Carbon::now();
                                    $punish->save();
                                } elseif ($punishment->Deduct_Type == 3) {
                                    $punish = ProcessAttendance::find($chkid);
                                    $punish->Deduct_Type = $punishment->Deduct_Type;
                                    $punish->CreatedBy = $userid;
                                    $punish->updated_at = Carbon::now();
                                    $punish->save();
                                }
                            }
                        }

                        $attnapprovals = AttendanceApproval::orderBy('EmployeeID', 'ASC')->whereIn('EmployeeID',$vempids)->whereBetween('effective_date', [$start_date, $end_date])->where('IsApproved','Y')->select('EmployeeID', 'effective_date','request_type','IsApproved')->get();
                        foreach ($attnapprovals as $attnapproval) {
                            $attndata = ProcessAttendance::orderBy('id', 'ASC')->where('EmployeeID', $attnapproval->EmployeeID)->where('WorkDate', $attnapproval->effective_date)->whereIn('AttnType', ['PR','AB'])->first();
                            if ($attndata) {
                                $attnapp = ProcessAttendance::find($attndata->id);
                                $shiftinfo = collect($shiftdata)->where('Shift', $attndata->Shift)->first();
                                $worktime = Carbon::parse($attnapp->WorkDate)->startOfDay();
                                $starthr = $worktime->copy()->addHours($shiftinfo->ShiftStartHour)->addMinute($shiftinfo->ShiftStartMinute)->format('Y-m-d H:i:s');
                                $endhr = $worktime->copy()->addHours($shiftinfo->ShiftEndHour)->addMinute($shiftinfo->ShiftEndMinute)->format('Y-m-d H:i:s');
                                if ($attnapproval->request_type == 1) {
                                    $startpunch = $starthr; $endpunch = $attnapp->EndPunch ? $attnapp->EndPunch : $starthr;
                                    $realhr = getRWH($starthr, $endhr, $startpunch, $endpunch);

                                    $attnapp->StartPunch = $startpunch;
                                    $attnapp->EndPunch = $endpunch;
                                    $attnapp->RealWorkHour = $realhr;
                                    $attnapp->WageWorkHour = 8;
                                    $attnapp->OTHour = 0;
                                    $attnapp->AttnType = 'PR';
                                    $attnapp->IsLate = 'N';
                                    $attnapp->CreatedBy = $userid;
                                    $attnapp->updated_at = Carbon::now();
                                    $attnapp->save();
                                } elseif ($attnapproval->request_type == 2) {
                                    $startpunch = $attnapp->StartPunch ? $attnapp->StartPunch : $endhr; $endpunch = $endhr;
                                    $realhr = getRWH($starthr, $endhr, $startpunch, $endpunch);
                                    $attnapp->StartPunch = $startpunch;
                                    $attnapp->EndPunch = $endpunch;
                                    $attnapp->RealWorkHour = $realhr;
                                    $attnapp->WageWorkHour = 8;
                                    $attnapp->OTHour = 0;
                                    $attnapp->AttnType = 'PR';
                                    $attnapp->CreatedBy = $userid;
                                    $attnapp->updated_at = Carbon::now();
                                    $attnapp->save();
                                } elseif ($attnapproval->request_type == 3) {
                                    $startpunch = $starthr; $endpunch = $endhr;
                                    $realhr = getRWH($starthr, $endhr, $startpunch, $endpunch);
                                    $attnapp->StartPunch = $startpunch;
                                    $attnapp->EndPunch = $endpunch;
                                    $attnapp->RealWorkHour = $realhr;
                                    $attnapp->WageWorkHour = 8;
                                    $attnapp->OTHour = 0;
                                    $attnapp->AttnType = 'PR';
                                    $attnapp->CreatedBy = $userid;
                                    $attnapp->updated_at = Carbon::now();
                                    $attnapp->save();
                                }
                            }
                        }

                        \LogActivity::addToLog('Add Process Attendance');
                        return redirect()->back()->with('success', getNotify(1))->withInput();
                    } else {
                        return redirect()->back()->with('warning', 'Process Attendance Already Exists')->withInput();
                    }
                } elseif ($attributes['title'] == 2) {
                    $chksalpro = ProcessSalary::orderBy('id', 'DESC')->where('Year', $year)->where('Month', $month)->where('company_id',$company)->where('Confirmed', 'Y')->first();
                    if ($chksalpro == null) {
                        PunchData::orderBy('EmployeeID', 'ASC')->whereYear('WorkDate', '=', $year)->whereMonth('WorkDate', '=', $month)->where('company_id',$company)->delete();
                        \LogActivity::addToLog('Delete Pre-Process');
                        ProcessAttendance::whereYear('WorkDate', '=', $year)->whereMonth('WorkDate', '=', $month)->where('company_id',$company)->delete();
                        \LogActivity::addToLog('Delete Process Attendance');
                        return redirect()->back()->with('success', getNotify(3))->withInput();
                    } else {
                        return redirect()->back()->with('warning', 'Undo/Revert Is Not Available Because Process Salary Already Confirmed')->withInput();
                    }
                }
            }
        } else {
            return redirect()->back()->with('warning', getNotify(5));
        }
    }
}
