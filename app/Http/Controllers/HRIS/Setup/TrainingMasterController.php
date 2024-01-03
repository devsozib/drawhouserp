<?php

namespace App\Http\Controllers\HRIS\Setup;

use Sentinel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\HRIS\Database\Employee;
use App\Models\HRIS\Setup\Department;
use App\Models\HRIS\Setup\Training;
use App\Models\HRIS\Setup\TrainingParticipant;
use App\Models\Library\General\Company;
use Illuminate\Support\Facades\Validator;

class TrainingMasterController extends Controller
{
    public function index()
    {
        if (getAccess('view')) {
            $userid = Sentinel::getUser()->id; 
            $trainings = Training::where('company_id',getHostInfo()['id'])->where('created_by',$userid)->get();
            return view('hris.training.trainingmaster.index', compact('trainings'));
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
                'conduct' => 'required',
                'name' => 'required|max:255',
                't_date_time' => 'required',
                'tr_location' => 'required',
                't_hours' => 'required',
                'status' => 'required',
            ];
            $validation = Validator::make($attributes, $rules);
            if ($validation->fails()) {
                return redirect()->action('HRIS\Setup\TrainingMasterController@index')->with(['error' => getNotify(4), 'error_code' => 'Add'])->withErrors($validation)->withInput();
            } else {
                $training = new Training();
                $training->company_id = getHostInfo()['id'];
                $training->t_description = $request->t_description;
                $training->t_name = $request->name;
                $training->conduct = $request->conduct;
                $training->t_date_time = $request->t_date_time;
                $training->tr_location = $request->tr_location;
                $training->t_hours = $request->t_hours;
                $training->status = $request->status;
                $training->created_by =  $userid;;
                $training->save();
                \LogActivity::addToLog('Add Training ' . $attributes['name']);
                return redirect()->action('HRIS\Setup\TrainingMasterController@index')->with('success', getNotify(1));
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
                'conduct' => 'required',
                'name' => 'required|max:255',
                't_date_time' => 'required',
                'tr_location' => 'required',
                't_hours' => 'required',
                'status' => 'required',
            ];
            $validation = Validator::make($attributes, $rules);
            if ($validation->fails()) {
                return redirect()->action('HRIS\Setup\TrainingMasterController@index')->with(['error' => getNotify(4), 'error_code' => $id])->withErrors($validation)->withInput();
            } else {
                $training = Training::findOrFail($id);
                $training->company_id = getHostInfo()['id'];
                $training->t_description = $request->t_description;
                $training->t_name = $request->name;
                $training->conduct = $request->conduct;
                $training->t_date_time = $request->t_date_time;
                $training->tr_location = $request->tr_location;
                $training->t_hours = $request->t_hours;
                $training->status = $request->status;
                $training->updated_by = $userid;
                $training->update();
                \LogActivity::addToLog('Update Training ' . $attributes['name']);
                return redirect()->action('HRIS\Setup\TrainingMasterController@index')->with('success', getNotify(1));
            }
        } else {
            return redirect()->back()->with('warning', getNotify(5));
        }
    }
    public function destroy(string $id)
    {
        if (getAccess('delete')) {
            $training = Training::findOrFail($id);
            $training->delete();
            TrainingParticipant::where('training_id', $id)->delete();
            return redirect()->back()->with('success', getNotify(1));
        } else {
            return redirect()->back()->with('warning', getNotify(5));
        }
    }

    public function assignParticipant(Request $request, $id)
    {
        $department = '';
        if ($request->department) {
            $department = $request->department;
        } else {
            $department = '';
        }
        $companies = Company::where('id',getHostInfo()['id'])->where('C4S', 'Y')->get();
        $depts = Department::whereRaw("FIND_IN_SET(?, company_id)", [getHostInfo()['id']])->where('C4S', 'Y')->get();
        
        $training = Training::findOrFail($id);
        
        $assignedEmployees = TrainingParticipant::where('training_id', $id)->select('participant_id')->get();
        
        $employeesQuery = Employee::query();
        // Check if the $department variable is set and not empty, then apply the filter
        if ($department) {    
                          
            $employeesQuery->whereIn('DepartmentID', $department);
        }        
        // Select the specific columns you want from the Employee model
        
        $employees = $employeesQuery->where('company_id',getHostInfo()['id'])->select('EmployeeID', 'Name')->latest()->get();
        
        $existingEmployee = TrainingParticipant::where('training_id', $id)->count();
        $totalEmployees = Employee::where('company_id',getHostInfo()['id'])->count();
        $allEmployeesSelected = ($existingEmployee === $totalEmployees);
        return view('hris.training.trainingmaster.assign', compact('training', 'companies', 'depts', 'employees', 'assignedEmployees', 'allEmployeesSelected', 'existingEmployee', 'id', 'department'));
    }

    public function assignParticipantPost(Request $request)
    {
        $training = Training::findOrFail($request->training_id);
        $userid = Sentinel::getUser()->id;
        $attributes = $request->all();
        $rules = [
            'training_id' => 'required',
            'selectedEmployees' => 'required',
        ];
        $validation = Validator::make($attributes, $rules);

        if ($validation->fails()) {
            return redirect()->action('HRIS\Setup\TrainingMasterController@assignParticipant', $training->id)->with(['error' => getNotify(4)])->withErrors($validation)->withInput();
        } else {
            $selectedEmployees = $request->selectedEmployees;
            $trainingID = $request->training_id;
            $totalEmployees = Employee::where('DepartmentID', $training->dept_id)->where('company_id',getHostInfo()['id'])->count();
            // Get the existing assignments for the task
            $existingAssignments = TrainingParticipant::where('training_id', $trainingID)->get();
            $existingEmployee = TrainingParticipant::where('training_id', $trainingID)->count();

            // Check and process each selected employee
            foreach ($existingAssignments as $existingAssignment) {
                $empID = $existingAssignment->participant_id;

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
                $existingAssignment = TrainingParticipant::where('training_id', $trainingID)
                    ->where('participant_id', $emp)
                    ->first();
                if ($existingAssignment) {
                    // Employee already assigned, update the assignment if needed
                    // Your update logic goes here
                } else {
                    // Employee not yet assigned, create a new assignment
                    $trainingParticipant = new TrainingParticipant();
                    $trainingParticipant->training_id = $trainingID;
                    $trainingParticipant->participant_id = $emp;
                    $trainingParticipant->save();
                }
            }
         
            \LogActivity::addToLog('Add Task assign' . $training->name);
            // return redirect()->action('HRIS\Setup\TrainingMasterController@assignParticipant', $training->id)->with([
            //     'success' => getNotify(1),
            //     'allEmployeesSelected' => $allEmployeesSelected,
            //     'existingEmployee' => $existingEmployee
            // ]);
            return redirect()->action('HRIS\Setup\TrainingMasterController@index')->with('success', getNotify(1));
        }
    }

    public function trAttendence($id)
    {
        $training = Training::findOrFail($id);
        $assignedEmployees = TrainingParticipant::join('hr_database_employee_basic as emp', 'emp.EmployeeID', '=', 'hr_setup_training_participants.participant_id')->where('hr_setup_training_participants.training_id', $id)->where('hr_setup_training_participants.seen', '1')->select('emp.Name', 'emp.EmployeeID', 'hr_setup_training_participants.*')->get();
        return view('hris.training.trainingmaster.attendence', compact('training',  'assignedEmployees'));
    }
}
