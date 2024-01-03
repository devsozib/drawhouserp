<?php

namespace App\Http\Controllers\HRIS\Setup;

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
        // return getHostInfo();
        if (getAccess('view')) {  
            $userid = Sentinel::getUser()->id;         
            $tasks = Task::where('company_id',getHostInfo()['id'])->where('created_by',$userid)->get();
            return view('hris.setup.task.index', compact('tasks'));
        } else {
            return redirect()->back()->with('warning', getNotify(5));
        }
    }

    public function store(Request $request)
    {
        if (getAccess('create')) {
            $request->all();
            $userid = Sentinel::getUser()->id;
            $attributes = $request->all();
            $rules = [               
                't_description' => 'required',
                'name' => 'required|max:255',
                't_due_date' => 'required',
                'task_priority' => 'required',
                'status' => 'required',
            ];
            $validation = Validator::make($attributes, $rules);
            if ($validation->fails()) {
                return redirect()->action('HRIS\Setup\TaskController@index')->with(['error' => getNotify(4), 'error_code' => 'Add'])->withErrors($validation)->withInput();
            } else {
                $notice = new Task();
                $notice->company_id = getHostInfo()['id'];
                $notice->t_description = $request->t_description;
                $notice->name = $request->name;
                $notice->t_due_date = $request->t_due_date;
                $notice->t_priority = $request->task_priority;
                $notice->t_status = $request->status;
                $notice->created_by =  $userid;
                $notice->save();
                \LogActivity::addToLog('Add Task ' . $attributes['name']);
                return redirect()->action('HRIS\Setup\TaskController@index')->with('success', getNotify(1));
            }
        } else {
            return redirect()->back()->with('warning', getNotify(5));
        }
    }

    public function update(Request $request, $id)
    {
        if (getAccess('create')) {
            $request->all();
            $userid = Sentinel::getUser()->id;
            $attributes = $request->all();
            $rules = [            
                't_description' => 'required',
                'name' => 'required|max:255',
                't_due_date' => 'required',
                'task_priority' => 'required',
                'status' => 'required',
            ];
            $validation = Validator::make($attributes, $rules);
            if ($validation->fails()) {
                return redirect()->action('HRIS\Setup\TaskController@index')->with(['error' => getNotify(4), 'error_code' => $id])->withErrors($validation)->withInput();
            } else {
                $notice = Task::findOrFail($id);               
                $notice->t_description = $request->t_description;
                $notice->name = $request->name;
                $notice->t_due_date = $request->t_due_date;
                $notice->t_priority = $request->task_priority;
                $notice->t_status = $request->status;
                $notice->updated_by =  $userid;
                $notice->update();
                \LogActivity::addToLog('Update Task ' . $attributes['name']);
                return redirect()->action('HRIS\Setup\TaskController@index')->with('success', getNotify(1));
            }
        } else {
            return redirect()->back()->with('warning', getNotify(5));
        }
    }
    public function destroy(string $id)
    {
        if (getAccess('delete')) {
            $notice = Task::findOrFail($id);
            $notice->delete();
            // TaskAssign::where('task_id', $id)->delete();
            TaskAssign::where('task_id', $id)->delete();
            return redirect()->back()->with('success', getNotify(1));
        } else {
            return redirect()->back()->with('warning', getNotify(5));
        }
    }

    public function assignTask($id)
    {
        $task = Task::findOrFail($id);
        $assignedEmployees = TaskAssign::where('task_id', $id)->select('emp_id', 'employee_status')->get();
        $employees = Employee::where('company_id', getHostInfo()['id'])->where('C4S','Y')->select('EmployeeID', 'Name')->get();

        $assignments = TaskAssign::join('hr_database_employee_basic as basic', 'basic.EmployeeID', 'hr_setup_task_assigns.emp_id')->where('task_id', $id)->select('basic.Name', 'basic.EmployeeID', 'hr_setup_task_assigns.employee_status', 'hr_setup_task_assigns.manager_status', 'hr_setup_task_assigns.id', 'hr_setup_task_assigns.task_id', 'hr_setup_task_assigns.emp_id')->get();

        $existingEmployee = TaskAssign::where('task_id', $id)->count();
        $totalEmployees = Employee::where('company_id',getHostInfo()['id'])->count();
        $allEmployeesSelected = ($existingEmployee === $totalEmployees);
        return view('hris.setup.task.assign', compact('task', 'employees', 'assignedEmployees', 'allEmployeesSelected', 'existingEmployee', 'assignments'));
    }

    public function assignTaskPost(Request $request)
    {
        $task = Task::findOrFail($request->task_id);
        $userid = Sentinel::getUser()->id;
        $attributes = $request->all();
        $rules = [
            'task_id' => 'required',
            // 'selectedEmployees' => 'required',
        ];
        $validation = Validator::make($attributes, $rules);

        if ($validation->fails()) {
            return redirect()->action('HRIS\Setup\TaskController@assignTask', $task->id)->with(['error' => getNotify(4)])->withErrors($validation)->withInput();
        } else {
            $selectedEmployees = $request->selectedEmployees;
            $taskID = $request->task_id;
            $totalEmployees = Employee::where('company_id', getHostInfo()['id'])->count();
            // Get the existing assignments for the task
            $existingAssignments = TaskAssign::where('task_id', $taskID)->get();
            $existingEmployee = TaskAssign::where('task_id', $taskID)->count();

            if($selectedEmployees){
                // Check and process each selected employee
                foreach ($existingAssignments as $existingAssignment) {
                    $empID = $existingAssignment->emp_id;

                    if (in_array($empID, $selectedEmployees)) {
                        // The employee is still selected, no action required
                        continue;
                    } else {
                        // The employee is unselected, delete the assignment
                        $existingAssignment->delete();
                    }                    
                }
                
                // Check and process any new selected employees
                foreach ($selectedEmployees as $emp) {
                    $existingAssignment = TaskAssign::where('task_id', $taskID)
                        ->where('emp_id', $emp)
                        ->first();
                    if ($existingAssignment) {
                        // Employee already assigned, update the assignment if needed
                        // Your update logic goes here
                    } else {
                        // Employee not yet assigned, create a new assignment
                        $taskAssign = new TaskAssign();
                        $taskAssign->task_id = $taskID;
                        $taskAssign->emp_id = $emp;
                        $taskAssign->save();
                    }
                }
            }else{
                TaskAssign::where('task_id', $taskID)->delete();
            }
           

            $allEmployeesSelected = ($existingEmployee === $totalEmployees);
            \LogActivity::addToLog('Add Task assign' . $task->name);
            // return redirect()->action('HRIS\Setup\TaskController@assignTask', $task->id)->with([
            //     'success' => getNotify(1),
            //     'allEmployeesSelected' => $allEmployeesSelected,
            //     'existingEmployee' => $existingEmployee
            // ]);
            return redirect()->action('HRIS\Setup\TaskController@index')->with('success', getNotify(1));
        }
    }
}
