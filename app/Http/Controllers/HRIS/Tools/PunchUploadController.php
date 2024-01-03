<?php

namespace App\Http\Controllers\HRIS\Tools;

use DB;
use File;
use Input;
use Redirect;
use Sentinel;
use Validator;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\HRIS\Tools\HROptions;
use App\Models\HRIS\Database\Employee;
use App\Models\HRIS\Tools\ProcessSalary;
use App\Models\HRIS\Tools\ReadPunchRecords;

class PunchUploadController extends Controller
{
    public function index()
    {
        if (getAccess('view')) {
            return view('hris.tools.punchupload.index');
        } else {
            return redirect()->back()->with('warning', getNotify(5));
        }
    }

    public function store()
    {
        if (getAccess('create')) {
            $userid = Sentinel::getUser()->id;
            $attributes = Input::all();

            if (isset($attributes['undo'])) {
                dd('page under construction');
                $rules = [
                    'StartDate' => 'required|date',
                    'EndDate' => 'required|date',
                ];
                $validation = Validator::make($attributes, $rules);
                if ($validation->fails()) {
                    return redirect()->back()->with('error', getNotify(4))->withErrors($validation)->withInput();
                } else {
                    $start_date = $attributes['StartDate'];
                    $end_date = $attributes['EndDate'];
                    $year = Carbon::parse($start_date)->year;
                    $month = Carbon::parse($start_date)->month;
                    $chksalpro = ProcessSalary::orderBy('id', 'DESC')->where('Year', $year)->where('company_id',getHostInfo()['id'])->where('Month', $month)->where('Confirmed', 'Y')->first();
                    if ($chksalpro == null) {
                        $punchstart = Carbon::parse($start_date)->startOfDay()->format('Y-m-d H:i:s');
                        $punchend = Carbon::parse($end_date)->endOfDay()->format('Y-m-d H:i:s');
                        
                        $empids = Employee::where('company_id',getHostInfo()['id'])->pluck('EmployeeID');
                        ReadPunchRecords::orderBy('EmployeeID', 'ASC')->whereIn('EmployeeID',$empids)->whereBetween('AttnDate', [$punchstart, $punchend])->delete();

                        \LogActivity::addToLog('Undo Read Punch Records ' . $start_date . ' & ' . $end_date);
                        return redirect()->back()->with('success', getNotify(3))->withInput();
                    } else {
                        return redirect()->back()->with('warning', 'Salary Process Already Done')->withInput();
                    }
                }
            } elseif (isset($attributes['syncpunch'])) {
                dd('page under construction');
                $rules = [
                    'StartDate' => 'required|date',
                    'EndDate' => 'required|date',
                ];
                $validation = Validator::make($attributes, $rules);
                if ($validation->fails()) {
                    return redirect()->back()->with('error', getNotify(4))->withErrors($validation)->withInput();
                } else {
                    $start_date = $attributes['StartDate']; $end_date = $attributes['EndDate'];
                    $year = Carbon::parse($start_date)->year; $month = Carbon::parse($start_date)->month;
                    $chksalpro = ProcessSalary::orderBy('id', 'DESC')->where('Year', $year)->where('Month', $month)->where('company_id',getHostInfo()['id'])->where('Confirmed', 'Y')->first();
                    if ($chksalpro == null) {
                        $punchs = DB::connection('mysql2')->table('timesheet')->whereBetween('date',[$start_date,$end_date])->where('sync','N')->get();
                        if (sizeOf($punchs) >= 1) {
                            $lastid = ReadPunchRecords::orderBy('id', 'DESC')->pluck('id')->first() + 1;
                            foreach ($punchs as $data) {
                                $employee = $data->user_id;
                                $dttime = $data->date.' '.$data->time;
                                $datetime = $dttime ? date("Y-m-d H:i:s", strtotime(roundMinute($dttime))) : null;
                                $pstate = ''; $ptype = 1; $extid = $data->id; $mcsl = $data->sn;
                                if ($employee) {
                                    $createdat = Carbon::now();
                                    DB::insert("INSERT INTO payroll_tools_readpunchrecords (id, EmployeeID, AttnDate, PState, PunchType, created_at,extid,mcsl) VALUES ('$lastid','$employee','$datetime','$pstate','$ptype','$createdat','$extid','$mcsl')");
                                    DB::connection('mysql2')->table('timesheet')->where('id',$extid)->update(['sync'=>'Y']);
                                    $lastid++;
                                }
                            }
                            \LogActivity::addToLog('Sync Read Punch Records ' . $start_date . ' & ' . $end_date);
                            return redirect()->back()->with('success', getNotify(1))->withInput();
                        } else {
                            return redirect()->back()->with('warning', 'No Punch Records Found In Attendance Server. Please Try Again With Valid Date')->withInput();
                        }
                    } else {
                        return redirect()->back()->with('warning', 'Salary Process Already Done')->withInput();
                    }
                }
            } elseif (isset($attributes['read'])) {
                $rules = [
                    'StartDate' => 'required|date',
                    'EndDate' => 'required|date',
                    'punchfile' => 'required',
                ];
                $validation = Validator::make($attributes, $rules);
                if ($validation->fails()) {
                    return redirect()->back()->with('error', getNotify(4))->withErrors($validation)->withInput();
                } else {
                    $start_date = $attributes['StartDate'];
                    $end_date = $attributes['EndDate'];
                    $year = Carbon::parse($start_date)->year;
                    $month = Carbon::parse($start_date)->month;

                    $chksalpro = ProcessSalary::orderBy('id', 'DESC')->where('Year', $year)->where('Month', $month)->where('company_id',getHostInfo()['id'])->where('Confirmed', 'Y')->first();
                    if ($chksalpro == null) {
                        $punchstart = Carbon::parse($start_date)->startOfDay()->format('Y-m-d H:i:s');
                        $punchend = Carbon::parse($end_date)->endOfDay()->format('Y-m-d H:i:s');
                        $file = File::get($attributes['punchfile']);
                        $punchs = explode("\r\n", $file);

                        if (count($punchs) >= 1) {
                            $lastid = ReadPunchRecords::orderBy('id', 'DESC')->pluck('id')->first() + 1;
                            foreach ($punchs as $data) {
                                $temp = explode("|", $data);
                                if (count($temp) == 4) {
                                    $employee = (int)$temp[0];
                                    $date = date("Y-m-d H:i:s", strtotime(roundMinute($temp[1])));
                                    $pstate = $temp[2];
                                    $ptype = (int)$temp[3];
                                    if ($employee && $punchstart <= $date && $date <= $punchend) {
                                        $createdat = Carbon::now();
                                        DB::insert("INSERT INTO payroll_tools_readpunchrecords (id, EmployeeID, AttnDate, PState, PunchType, created_at) VALUES ('$lastid','$employee','$date','$pstate','$ptype','$createdat')");
                                        $lastid++;
                                    }
                                }
                            }

                            //custom code
                            if($userid == 1){
                                //designation
                                /* foreach ($punchs as $data) {
                                    $temp = explode("|", $data);
                                    if (count($temp) == 1) {
                                        $dept = $temp[0];
                                        if ($dept) {
                                            $createdat = Carbon::now();
                                            DB::insert("INSERT INTO hr_setup_designation (Designation, C4S, CreatedBy, created_at) VALUES ('$dept','Y','$userid','$createdat')");
                                        }
                                    }
                                } */
                            }

                            \LogActivity::addToLog('Add Read Punch Records ' . $start_date . ' & ' . $end_date);
                            return redirect()->back()->with('success', getNotify(1))->withInput();
                        } else {
                            return redirect()->back()->with('warning', 'No Punch Records Found In Given Text File. Please Try Again With Valid Text Data')->withInput();
                        }
                    } else {
                        return redirect()->back()->with('warning', 'Salary Process Already Done')->withInput();
                    }
                }
            }
        } else {
            return redirect()->back()->with('warning', getNotify(5));
        }
    }
}
