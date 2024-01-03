<?php

namespace App\Http\Controllers\HRIS\Tools;

use Input;
use Redirect;
use Sentinel;
use Validator;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\HRIS\Tools\Calendar;
use App\Http\Controllers\Controller;
use App\Models\HRIS\Tools\HROptions;
use App\Models\Library\General\Company;
use App\Models\HRIS\Tools\CalenderEvents;

class CalendarController extends Controller
{
    public function index(Request $request)
    {
        if (getAccess('view')) {
            $hroptions = HROptions::orderBy('id', 'DESC')->first();
            $calendars = Calendar::orderBy('id', 'ASC')->whereYear('Date', '=', $hroptions->Year);
    
            if ($request->company != 'all') {
                $calendars = $calendars->where('company_id', $request->company);
            }
            $calendars = $calendars->get();
    
            return view('hris.tools.calendar.index', compact('calendars','request'));
        } else {
            return redirect()->back()->with('warning', getNotify(5));
        }
    }

    public function store(Request $request)
    {        
        if (getAccess('create')) {
            $userid = Sentinel::getUser()->id;
            $attributes = Input::all();
            if (isset($request->eventCreate) && $request->eventCreate == 'yes') {
                $rules = [
                    'title' => 'required',
                    'start' => 'required',
                    'end' => 'required',
                    'description' => 'required',
                    'className' => 'required',
                    'icon' => 'required',
                    'allDay' => 'required',
                ];
                $validation = Validator::make($attributes, $rules);
                if ($validation->fails()) {
                    return redirect()->back()->with('error', getNotify(4))->withErrors($validation)->withInput();
                } else {
                    $event = new CalenderEvents();
                    $event->title = $request->title;
                    $event->start = $request->start;
                    $event->end = $request->end;
                    $event->description = $request->description;
                    $event->className = $request->className;
                    $event->icon = $request->icon;
                    $event->allDay = $request->allDay;
                    $event->created_by = $userid;
                    $event->save();
                    \LogActivity::addToLog('Add calender events');
                    return redirect()->back()->with('success', getNotify(1));
                }
            } elseif ($request->addCalender == '1'){                   
                $date = Carbon::parse($request->date);
                $year = $date->year;
                $month = $date->month;
                $rules = [
                    'company'=>'required',
                    'name' => 'required',
                    'date' => 'required',
                    'p_holiday' => 'required',
                ];
                $validation = Validator::make($attributes, $rules);
                if ($validation->fails()) {
                    return response()->json(array('success' => getNotify(4)));
                } else {   
                    $chk = Calendar::whereDate('Date', '=', $request->date)->first();
                    $lastid = Calendar::orderBy('id', 'DESC')->pluck('id')->first() + 1;
                    if($chk == null){                        
                        $calendar = new Calendar();
                        $calendar->id =  $lastid;
                        $calendar->company_id =  $request->company;
                        $calendar->Holiday = 'Y';                        
                        $calendar->Date = $request->date;                        
                        $calendar->Year = $year;
                        $calendar->Month = $month;
                        $calendar->PublicHoliday = $attributes['p_holiday'];
                        $calendar->Naration = $attributes['name'];                     
                        $calendar->CreatedBy = $userid;
                        $calendar->save();
                        \LogActivity::addToLog('Add holiday Information');
                        return response()->json(array('success' => getNotify(1)));
                    }else{
                        return response()->json(array('errors' => getNotify(6)));
                    }
                }
            } else {
                $rules = [
                    'company' => 'required',
                    'Year' => 'required|numeric',
                ];
                $validation = Validator::make($attributes, $rules);
                if ($validation->fails()) {
                    return redirect()->back()->with('error', getNotify(4))->withErrors($validation)->withInput();
                } else {
                    date_default_timezone_set('Asia/Dhaka');
                    $year = $attributes['Year'];
                    $company_id = $request->company;      
                    //$start_date = $year . '-01-01';
                    $end_date = $year . '-12-31';
                    $chk = Calendar::whereYear('Date', '=', $year)->where('company_id',$company_id )->first();
                    $lastid = Calendar::orderBy('id', 'DESC')->pluck('id')->first() + 1;                  
                    if ($chk == null) {                                         
                            $start_date = $year . '-01-01';
                            while (strtotime($start_date) <= strtotime($end_date)) {
                                $flag = 0;
                                if ($start_date == date('Y-m-d', strtotime($year . '-02-21'))) {
                                    $naration = 'Int. Mother Language Day';
                                    $holiday = 'Y';
                                    $publicholiday = 'Y';
                                    $flag = 1;
                                } elseif ($start_date == date('Y-m-d', strtotime($year . '-03-26'))) {
                                    $naration = 'Independence Day';
                                    $holiday = 'Y';
                                    $publicholiday = 'Y';
                                    $flag = 1;
                                } elseif ($start_date == date('Y-m-d', strtotime($year . '-04-14'))) {
                                    $naration = 'Bengali New Year';
                                    $holiday = 'Y';
                                    $publicholiday = 'Y';
                                    $flag = 1;
                                } elseif ($start_date == date('Y-m-d', strtotime($year . '-05-01'))) {
                                    $naration = 'May Day';
                                    $holiday = 'Y';
                                    $publicholiday = 'Y';
                                    $flag = 1;
                                } elseif ($start_date == date('Y-m-d', strtotime($year . '-08-15'))) {
                                    $naration = 'National Mourning Day';
                                    $holiday = 'Y';
                                    $publicholiday = 'Y';
                                    $flag = 1;
                                } elseif ($start_date == date('Y-m-d', strtotime($year . '-12-16'))) {
                                    $naration = 'Victory day';
                                    $holiday = 'Y';
                                    $publicholiday = 'Y';
                                    $flag = 1;
                                } elseif (date('l', strtotime($start_date)) == 'Friday') {
                                    $naration = 'Weekly Holiday';
                                    $holiday = 'Y';
                                    $publicholiday = 'N';
                                    $flag = 1;
                                } else {
                                    $naration = 'Working Day';
                                    $holiday = 'N';
                                    $publicholiday = 'N';
                                    $flag = 0;
                                }

                                if($flag){
                                    $calendar = new Calendar();
                                    $calendar->id = $lastid;
                                    $calendar->company_id = $company_id;
                                    $calendar->Date = $start_date;
                                    $calendar->Year = date('Y', strtotime($start_date));
                                    $calendar->Month = date('m', strtotime($start_date));
                                    $calendar->Holiday = $holiday;
                                    $calendar->PublicHoliday = $publicholiday;
                                    $calendar->Naration = $naration;
                                    $calendar->CreatedBy = $userid;
                                    $calendar->save();
                                    $lastid++;
                                }
                                $start_date = date("Y-m-d", strtotime("+1 day", strtotime($start_date)));
                            }
                    
                        \LogActivity::addToLog('Add Calendar Information');
                        return redirect()->back()->with('success', getNotify(1));
                    } else {
                        return redirect()->back()->with('warning', getNotify(6));
                    }
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
            $attributes = Input::all();
            $calendar = Calendar::find($id);
            $rules = [
                'Holiday' => 'required|max:1',
                'PublicHoliday' => 'required|max:1',
                'Naration' => 'required|max:50',
            ];
            $validation = Validator::make($attributes, $rules);
            if ($validation->fails()) {
                return response()->json(array('errors' => getNotify(4)));
            } else {
                if ($attributes['PublicHoliday'] == 'Y') {
                    $holiday = 'Y';
                } else {
                    $holiday = $attributes['Holiday'];
                }
                $calendar->Holiday = $holiday;
                $calendar->PublicHoliday = $attributes['PublicHoliday'];
                $calendar->Naration = $attributes['Naration'];
                $calendar->updated_at = Carbon::now();
                $calendar->CreatedBy = $userid;
                $calendar->save();

                \LogActivity::addToLog('Edit Calendar Information ' . $calendar->Date);
                return response()->json(array('success' => getNotify(2)));
            }
        } else {
            return redirect()->back()->with('warning', getNotify(5));
        }
    }
    public function getEvents()
    {
        // Dummy data for the demo
        $events = CalenderEvents::all();
        return response()->json($events);
    }
}
