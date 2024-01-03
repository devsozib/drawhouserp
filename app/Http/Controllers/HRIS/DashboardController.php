<?php

namespace App\Http\Controllers\HRIS;

// use DB;
use Sentinel;
use Carbon\Carbon;
use App\Models\Users;
use Illuminate\Http\Request;
use App\Models\HRIS\Setup\Job;
use App\Models\HRIS\Setup\Task;
use App\Models\HRIS\Setup\Notes;
use App\Models\HRIS\Setup\Notice;
use App\Models\HRIS\Setup\Meeting;
use App\Models\HRIS\Setup\NoteTag;
use App\Models\HRIS\Setup\Training;
use App\Http\Controllers\Controller;
use App\Models\Feedback;
use App\Models\HRIS\Database\Employee;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $userid = Sentinel::getUser()->id;  
        $totalEmployees = Employee::where('company_id',getHostInfo()['id'])->count();
        $totalMeetings = Meeting::where('company_id',getHostInfo()['id'])->where('created_by',$userid)->count();
        $totalTrainings = Training::where('company_id',getHostInfo()['id'])->where('created_by',$userid)->count();
        $totalTasks = Task::where('company_id',getHostInfo()['id'])->where('created_by',$userid)->count();
        $totalJobs = Job::where('company_id',getHostInfo()['id'])->count();
        $totalAnnouncements = Notice::where('company_id',getHostInfo()['id'])->where('created_by',$userid)->count();
        $users = Users::orderBy('id', 'ASC')->get();
        $applicants = DB::table('hr_database_emp_users as user')
            ->join('hr_database_emp_entry as emp', 'emp.emp_user_id', '=', 'user.id')
            ->leftJoin('hr_setup_jobs as job', 'emp.job_id', '=', 'job.id')
            ->leftJoin('hr_setup_designation as job_dsg', 'job_dsg.id', '=', 'job.desg_id') 
            ->leftJoin('hr_setup_designation as emp_dsg', 'emp_dsg.id', '=', 'emp.designation_id') 
            ->leftJoin('hr_setup_department as dept', 'dept.id', '=', 'job.dept_id')
            ->leftJoin('lib_company as concern', 'concern.id', '=', 'job.company_id')
            ->select('emp.id as emp_id', 'emp.Name', 'concern.Name as concern_name', 'emp.MobileNo', 'emp.email', 'emp.NationalIDNo', 'emp.status', 'dept.Department', 'job_dsg.Designation as job_designation','emp_dsg.Designation as emp_designation')
            ->where('emp.status', '0')
            ->where('user.company_id',getHostInfo()['id'])
            ->orderBy('emp.created_at', 'desc')
            ->take(5)
            ->get();
        $tasks = Task::where('company_id',getHostInfo()['id'])->where('created_by',$userid)->latest()->take(5)->get();
        $meetings = Meeting::with(['participants.participant', 'department'])
            ->orderByDesc('id')
            ->where('created_by',$userid)
            ->where('company_id',getHostInfo()['id'])
            ->get();
        $meetingData = [];
        foreach ($meetings as $meeting) {
            $participants = [];
            foreach ($meeting->participants as $participant) {
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
        $notices = Notice::where('company_id',getHostInfo()['id'])->where('created_by',$userid)->latest()->take(7)->get();
        $notes = Notes::where('company_id',getHostInfo()['id'])->latest()->take(5)->where('user_id', $userid)->get();
        $emp_id = Sentinel::getUser()->empid;
        $taggedNotes = NoteTag::join('hr_setup_notes', 'hr_setup_notes.id', '=', 'hr_setup_note_tags.note_id')
            ->join('users as user', 'user.id', '=', 'hr_setup_notes.user_id')
            ->where('hr_setup_note_tags.emp_id', $emp_id)
            ->orderBy('hr_setup_notes.id', 'desc')
            ->take(5)
            ->get();
        $feedBack = Feedback::where('created_by', Sentinel::getUser()->empid)->count();

        return view('hris.dashboard', compact('users', 'totalEmployees', 'totalMeetings', 'totalTrainings', 'totalTasks', 'totalJobs', 'totalAnnouncements', 'applicants', 'tasks', 'meetingData', 'notices', 'notes', 'taggedNotes','feedBack'));
    }
    
    public function getFeedback(){
        $userID = Sentinel::getUser()->empid;
        $feedBacks = Feedback::where('created_by',$userID)->get();
        return view('hris.feedback.index',compact('feedBacks'));
    }
}
