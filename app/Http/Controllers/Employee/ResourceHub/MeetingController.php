<?php

namespace App\Http\Controllers\Employee\ResourceHub;

use Sentinel;
use Validator;
use Illuminate\Http\Request;
use App\Models\HRIS\Setup\Meeting;
use App\Http\Controllers\Controller;
use App\Models\HRIS\Database\EmpUser;
use App\Models\HRIS\Setup\Department;
use App\Models\HRIS\Database\Employee;
use App\Models\HRIS\Setup\MeetingParticipant;

class MeetingController extends Controller
{
    public function index()
    {
        if (getAccess('view')) {
           $userid = Sentinel::getUser()->empid;
           $meetings = Meeting::join('hr_setup_meeting_participants as par', 'par.meeting_id', '=', 'hr_setup_meeting.id')
                ->select('hr_setup_meeting.*', 'par.*')
                ->where('par.participant_id', '=', $userid)
                ->orderByDesc('hr_setup_meeting.id')
                ->get();

            $meetingData = [];
            foreach ($meetings as $meeting) {               
                $meetingData[] = [
                    'id' => $meeting->id,
                    'm_name' => $meeting->m_name,
                    'date_time' => $meeting->date_time,
                    'agenda' => $meeting->agenda,
                    'location' => $meeting->location,
                    'status' => $meeting->status,
                    'created_by' => $meeting->created_by,
                    'updated_by' => $meeting->updated_by,
                    'created_at' => $meeting->created_at,
                    'updated_at' => $meeting->updated_at,
                    'department' => $meeting->department->Department
                ];
            }

            foreach ($meetings as $item) {
                $getParticipants = MeetingParticipant::where('participant_id', $item->participant_id)->get();
                if ($item->seen == '0') {
                    foreach ($getParticipants as $parti) {
                        $parti->seen  = '1';
                        $parti->update();
                    }
                }
            }
            return view('employee.setup.meeting.index', compact('meetingData'));
        } else {
            return redirect()->back()->with('warning', getNotify(5));
        }
    }
}
