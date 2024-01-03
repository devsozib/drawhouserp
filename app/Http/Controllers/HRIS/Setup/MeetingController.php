<?php

namespace App\Http\Controllers\HRIS\Setup;

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
    // public function index()
    // {
    //     if (getAccess('view')) {
    //         $departmentData = Department::where('C4S', 'Y')->orderBy('id', 'ASC')->get();
    //         $participantsData = EmpUser::where('status', '1')->orderBy('id', 'DESC')->get();
    //         $meetings = Meeting::with('participants.participant')->orderByDesc('id')->get();

    //         $meetingData = [];

    //         foreach ($meetings as $meeting) {
    //             $participants = [];

    //             foreach ($meeting->participants as $participant) {
    //                 $participantName = EmpUser::find($participant->participant_id)->name;
    //                 $participants[] = $participantName;
    //             }
    //             $meetingData[] = [
    //                 'id' => $meeting->id,
    //                 'm_name' => $meeting->m_name,
    //                 'date_time' => $meeting->date_time,
    //                 'agenda' => $meeting->agenda,
    //                 'status' => $meeting->status,
    //                 'created_by' => $meeting->created_by,
    //                 'updated_by' => $meeting->updated_by,
    //                 'created_at' => $meeting->created_at,
    //                 'updated_at' => $meeting->updated_at,
    //                 'participants' => $participants,
    //                 'dept_id' => $participants,
    //             ];
    //         }
    //         // return $meetingData;
    //         return view('hris.setup.meeting.index', compact('meetingData', 'participantsData'));
    //     } else {
    //         return redirect()->back()->with('warning', getNotify(5));
    //     }
    // }

    public function index()
    {
        if (getAccess('view')) {
            $userid = Sentinel::getUser()->id;   
            $departmentData = Department::whereRaw('FIND_IN_SET(?, company_id)', [getHostInfo()['id']])->where('C4S', 'Y')->orderBy('id', 'ASC')->get();
            $participantsData = Employee::where('company_id',getHostInfo()['id'])->orderBy('id', 'DESC')->get();
            $meetings = Meeting::with(['participants.participant', 'department'])
                ->orderByDesc('id')
                ->where('company_id',getHostInfo()['id'])
                ->where('created_by',$userid)
                ->get();
            $meetingData = [];
            foreach ($meetings as $meeting) {
                $participants = [];
                foreach ($meeting->participants as $participant) {
                    // return $participant->participant_id;
                    $participantName = Employee::where('company_id',getHostInfo()['id'])->where('EmployeeID', $participant->participant_id)->first();
                    $participants[] = $participantName->Name;
                }
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
                    'participants' => $participants,
                    'department' => $meeting->department->Department
                ];
            }

            // return $meetingData;
            return view('hris.setup.meeting.index', compact('meetingData', 'participantsData', 'departmentData'));
        } else {
            return redirect()->back()->with('warning', getNotify(5));
        }
    }
    public function edit($id)
    {
        if (getAccess('edit')) {
            $departmentData = Department::whereRaw('FIND_IN_SET(?, company_id)', [getHostInfo()['id']])->where('C4S', 'Y')->orderBy('id', 'ASC')->get();
            $employees = Employee::where('company_id',getHostInfo()['id'])->select('EmployeeID', 'Name')->get();
            $meeting = Meeting::where('id', $id)->with('participants.participant')->orderByDesc('id')->first();
            return view('hris.setup.meeting.edit', compact('meeting', 'employees', 'departmentData'));
        } else {
            return redirect()->back()->with('warning', getNotify(5));
        }
    }
    public function store(Request $request)
    {
        if (getAccess('create')) {
            $userid = Sentinel::getUser()->id;
            $attributes = $request->all();
            $rules = [
                'name' => 'required',
                'dept_id' => 'required',
                'm_date_time' => 'required',
                'dept_id' => 'required',
                'participant_ids' => 'required',            
                'agenda' => 'required',
                'location'  => 'required',
                'status' => 'required',
            ];
            $validation = Validator::make($attributes, $rules);

            if ($validation->fails()) {
                return redirect()->action('HRIS\Setup\MeetingController@index')->with(['error' => getNotify(4), 'error_code' => 'Add'])->withErrors($validation)->withInput();
            } else {
                //Meeting data insert
                $meeting = new Meeting();
                $meeting->company_id = getHostInfo()['id'];
                $meeting->dept_id = $request->dept_id;
                $meeting->m_name = $request->name;
                $meeting->date_time = $request->m_date_time;
                $meeting->agenda = $request->agenda;
                $meeting->location = $request->location;
                $meeting->status = $request->status;
                $meeting->created_by = $userid;
                $meeting->save();
                //Perticipants insert
                $participantIds = $request->input('participant_ids');
                foreach ($participantIds as $id) {
                    $meetingPer = new MeetingParticipant();
                    $meetingPer->meeting_id = $meeting->id;
                    $meetingPer->participant_id = $id;
                    $meetingPer->save();
                }
                \LogActivity::addToLog('Add Meeting ' . $attributes['name']);
                return redirect()->action('HRIS\Setup\MeetingController@index')->with('success', getNotify(1));
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
                'name' => 'required',
                'dept_id' => 'required',
                'm_date_time' => 'required',
                'dept_id' => 'required',
                'participant_ids' => 'required',
                'agenda' => 'required',
                'location'  => 'required',
                'status' => 'required',
            ];
            $validation = Validator::make($attributes, $rules);
            if ($validation->fails()) {
                return redirect()->action('HRIS\Setup\MeetingController@index')->withErrors($validation)->withInput();
            } else {
                // Retrieve the meeting
                $meeting = Meeting::findOrFail($id);

                // Retrieve the currently selected participants from the form submission
                $selectedParticipants = $request->input('participant_ids', []);

                // Get the existing participant IDs associated with the meeting
                $existingParticipants = $meeting->participants->pluck('participant_id')->toArray();

                // Determine new participants to insert
                $newParticipants = array_diff($selectedParticipants, $existingParticipants);

                // Determine participants to remove
                $removedParticipants = array_diff($existingParticipants, $selectedParticipants);

                // Insert new participants
                foreach ($newParticipants as $participantId) {
                    $meeting->participants()->create([
                        'participant_id' => $participantId,
                    ]);
                }

                // Remove unselected participants
                $meeting->participants()->whereIn('participant_id', $removedParticipants)->delete();

                // Update meeting attributes
                $meeting->dept_id = $request->input('dept_id');
                $meeting->m_name = $request->input('name');
                $meeting->date_time = $request->input('m_date_time');
                $meeting->agenda = $request->input('agenda');
                $meeting->location = $request->input('location');
                $meeting->status = $request->input('status');
                $meeting->created_by = $userid;

                // Save the updated meeting
                $meeting->save();

                \LogActivity::addToLog('Update Meeting ' . $attributes['name']);
                return redirect()->action('HRIS\Setup\MeetingController@index')->with('success', getNotify(1));
            }
        } else {
            return redirect()->back()->with('warning', getNotify(5));
        }
    }



    public function destroy($id)
    {
        if (getAccess('delete')) {
            $userid = Sentinel::getUser()->id;
            $meeting = Meeting::find($id);
            $meeting->deleted_by = $userid;
            $meeting->delete();
            MeetingParticipant::where('meeting_id', $id)->delete();
            \LogActivity::addToLog('Delete Meeting ' . $meeting->name);
            return redirect()->action('HRIS\Setup\MeetingController@index')->with('success', getNotify(3));
        } else {
            return redirect()->back()->with('warning', getNotify(5));
        }
    }

    public function meetingAttendence($id){
        $meeting = Meeting::findOrFail($id);
        $assignedEmployees = MeetingParticipant::join('hr_database_employee_basic as emp', 'emp.EmployeeID', '=', 'hr_setup_meeting_participants.participant_id')->where('hr_setup_meeting_participants.meeting_id', $id)->where('hr_setup_meeting_participants.seen', '1')->select('emp.Name', 'emp.EmployeeID', 'hr_setup_meeting_participants.*')->get();
        return view('hris.setup.meeting.attendence', compact('meeting',  'assignedEmployees'));
    }
}
