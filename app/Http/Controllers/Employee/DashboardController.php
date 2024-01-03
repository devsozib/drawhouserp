<?php

namespace App\Http\Controllers\Employee;

use Sentinel;
use App\Models\Users;
use App\Models\Feedback;
use Illuminate\Http\Request;
use App\Models\HRIS\Setup\Job;
use App\Models\HRIS\Setup\Task;
use App\Models\HRIS\Setup\Notes;
use App\Models\HRIS\Setup\Notice;
use App\Models\HRIS\Setup\Meeting;
use App\Models\HRIS\Setup\NoteTag;
use App\Models\HRIS\Setup\Training;
use App\Http\Controllers\Controller;
use App\Models\HRIS\Setup\TaskAssign;
use App\Models\HRIS\Database\Employee;
use App\Notifications\CustomNotification;
use App\Models\HRIS\Setup\TrainingParticipant;

class DashboardController extends Controller
{
    public function index()
    {
        $emp_id = Sentinel::getUser()->empid;
        $userID = Sentinel::getUser()->id;
        $totalMeetings = Meeting::where('company_id',getHostInfo()['id'])->count();
        $totalTrainings = Training::where('company_id',getHostInfo()['id'])->count();
        $totalTasks = Task::where('company_id',getHostInfo()['id'])->count();
        $totalJobs = Job::where('company_id',getHostInfo()['id'])->count();
        $totalAnnouncements = Notice::where('company_id',getHostInfo()['id'])->count();
        $users = Users::where('company_id',getHostInfo()['id'])->orderBy('id', 'ASC')->get();

        $taskAssignsIDs = TaskAssign::where('emp_id',  $emp_id)->pluck('task_id');
        $tasks = Task::whereIn('id', $taskAssignsIDs)->where('company_id',getHostInfo()['id'])->where('created_by',$userID)->latest()->take(5)->get();

        $meetings = Meeting::where('company_id',getHostInfo()['id'])->whereHas('participants', function ($query) use ($emp_id) {
            $query->where('participant_id', $emp_id);
        })
            ->with(['participants.participant', 'department'])
            ->orderByDesc('id')            
            ->get();
        $meetingData = [];
        foreach ($meetings as $meeting) {
            $participants = [];
            foreach ($meeting->participants as $participant) {
                // return $participant;
                // return $participant->participant_id;
                $participantName = Employee::where('EmployeeID', $participant->participant_id)->first();
                $participants[] = $participantName->Name;
            }
            $meetingData[] = [
                'id' => $meeting->id,
                'm_name' => $meeting->m_name,
                'date_time' => $meeting->date_time,
                'agenda' => $meeting->agenda,
                'status' => $meeting->status,
                'created_by' => $meeting->created_by,
                'updated_by' => $meeting->updated_by,
                'created_at' => $meeting->created_at,
                'updated_at' => $meeting->updated_at,
                'participants' => $participants,
                'department' => $meeting->department->Department
            ];
        }
        $meetingData;
        // Get all the training IDs where the participant is assigned
        $assignedTrainingIds = TrainingParticipant::where('participant_id',  $emp_id)
            ->pluck('training_id');
        $trainings = Training::where('company_id',getHostInfo()['id'])->whereIn('id', $assignedTrainingIds)->latest()->take(7)->get();
        $notices = Notice::where('company_id',getHostInfo()['id'])->latest()->take(7)->get();
        $notes = Notes::where('company_id',getHostInfo()['id'])->latest()->take(5)->where('user_id', $userID)->get();
        $taggedNotes = NoteTag::join('hr_setup_notes', 'hr_setup_notes.id', '=', 'hr_setup_note_tags.note_id')
            ->join('users as user', 'user.id', '=', 'hr_setup_notes.user_id')
            ->where('hr_setup_note_tags.emp_id', $emp_id)
            ->orderBy('hr_setup_notes.id', 'desc')
            ->take(5)
            ->get();
        $feedBack = Feedback::where('created_by',Sentinel::getUser()->empid)->count();
        return view('employee.dashboard', compact('users', 'notices', 'notes', 'tasks', 'totalJobs', 'meetingData', 'trainings', 'taggedNotes','feedBack'));
    }

    public function getFeedback(){
        $userID = Sentinel::getUser()->empid;
        $feedBacks = Feedback::where('created_by',$userID)->get();
        return view('employee.feedback.index',compact('feedBacks'));
    }
}
