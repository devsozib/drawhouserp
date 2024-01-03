<?php

namespace App\Http\Controllers\HRIS\Database;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\HRIS\Database\Employee;
use App\Models\HRIS\Database\EmployeeTraining;
use Input;
use Validator;
use Flash;
use Carbon\Carbon;
use Redirect;
use Sentinel;

class TrainingController extends Controller
{
    public function update($id)
    {
        if (getAccess('edit')) {
            $tab = 4;
            $userid = Sentinel::getUser()->id;
            $attributes = Input::all();
            $empeducation = EmployeeTraining::find($id);
            $eid = Employee::where('EmployeeID', $empeducation->EmployeeID)->pluck('id')->first();
            $rules = [
                'TrainingTypeID' => 'required|numeric',
                'Instructor' => 'max:30',
                'Grade' => 'max:30',
                'Duration' => 'max:30',
            ];
            $validation = Validator::make($attributes, $rules);
            if ($validation->fails()) {
                return redirect()->action('HRIS\Database\EmployeeController@show', $eid . '?tab=' . $tab)->with(['error' => getNotify(4), 'error_code' => $id])->withErrors($validation)->withInput();
            } else {
                $empeducation->updated_at = Carbon::now();
                $empeducation->CreatedBy = $userid;
                $empeducation->fill($attributes)->save();

                \LogActivity::addToLog('Update Employee Training Info ' . $empeducation->EmployeeID);
                return redirect()->action('HRIS\Database\EmployeeController@show', $eid . '?tab=' . $tab)->with('success', getNotify(2));
            }
        } else {
            return redirect()->back()->with('warning', getNotify(5));
        }
    }

    public function destroy($id)
    {
        if (getAccess('delete')) {
            $tab = 4;
            $empeducation = EmployeeTraining::find($id);
            $eid = Employee::where('EmployeeID', $empeducation->EmployeeID)->pluck('id')->first();
            $empeducation->delete();

            \LogActivity::addToLog('Delete Employee Training Info ' . $empeducation->EmployeeID);
            return redirect()->action('HRIS\Database\EmployeeController@show', $eid . '?tab=' . $tab)->with('success', getNotify(3));
        } else {
            return redirect()->back()->with('warning', getNotify(5));
        }
    }
}
