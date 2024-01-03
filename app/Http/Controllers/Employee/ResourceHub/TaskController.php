<?php

namespace App\Http\Controllers\Employee\ResourceHub;

use Sentinel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\HRIS\Database\Employee;
use App\Models\HRIS\Setup\Department;
use App\Models\HRIS\Setup\Task;
use App\Models\HRIS\Setup\TaskAssign;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
    public function index()
    {
        if (getAccess('view')) {
            $userid = Sentinel::getUser()->empid;
            $depts = Department::where('C4S', 'Y')->get();
            $tasks = Task::leftJoin('hr_setup_task_assigns', 'hr_setup_task_assigns.task_id', '=', 'hr_setup_tasks.id')
                ->select('hr_setup_tasks.*', 'hr_setup_tasks.id as TaskID', 'hr_setup_task_assigns.*')
                ->where('hr_setup_task_assigns.emp_id', '=', $userid)
                ->where('hr_setup_tasks.company_id',getHostInfo()['id'])
                ->get();
            
            foreach ($tasks as $item) {
                $getParticipants = TaskAssign::where('emp_id', $item->emp_id)->get();
                if ($item->seen == '0') {
                    foreach ($getParticipants as $parti) {
                        $parti->seen  = '1';
                        $parti->update();
                    }
                }
            }
            return view('employee.setup.task.index', compact('tasks'));
        } else {
            return redirect()->back()->with('warning', getNotify(5));
        }
    }
    public function taskStatusUpdate(Request $request)
    {
        $userid = '';
        if ($request->emp_id) {
            $userid = $request->emp_id;
        } else {
            $userid = Sentinel::getUser()->empid;
        }

        $taskId = $request->task_id;
        $employee_status = $request->employee_status;
        $manager_status = $request->manager_status;
        $form = $request->form;
        $taskStatus = TaskAssign::where('task_id', $taskId)->where('emp_id', $userid)->first();
        if ($form == 'employee') {
            $taskStatus->employee_status = $employee_status;
            $taskStatus->update();
        } else {
            $taskStatus->manager_status = $manager_status;
            $taskStatus->update();
        }
        return redirect()->back();
    }
}
