<?php

namespace App\Http\Controllers\HRIS\Database;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\HRIS\Database\Employee;
use App\Models\HRIS\Database\EmployeeEducation;
use App\Models\HRIS\Setup\EducationBoard;
use Input;
use Validator;
use Flash;
use Carbon\Carbon;
use Redirect;
use Sentinel;

class EducationController extends Controller
{
    public function update($id)
    {
        if (getAccess('edit')) {
            $tab = 3;
            $userid = Sentinel::getUser()->id;
            $attributes = Input::all();
            $education = EmployeeEducation::find($id);
            $eid = Employee::where('EmployeeID', $education->EmployeeID)->pluck('id')->first();
            $rules = [
                'DegreeID' => 'required|numeric',
                'Institute' => 'required|max:150',
                'BoardID' => 'required',
                'ResultType' => 'required',
                'Year' => 'numeric|digits:4',
            ];
            $validation = Validator::make($attributes, $rules);
            if ($validation->fails()) {
                return redirect()->action('HRIS\Database\EmployeeController@show', $eid . '?tab=' . $tab)->with(['error' => getNotify(4), 'error_code' => $id])->withErrors($validation)->withInput();
            } else {
                if ($attributes['ResultType'] == 'D') {
                    $education->ClassObtained = $attributes['Degree'];
                } elseif ($attributes['ResultType'] == 'G') {
                    $education->ClassObtained = $attributes['Grade'];
                } elseif ($attributes['ResultType'] == 'C') {
                    $education->ClassObtained = $attributes['CGPA'];
                }
                elseif ($attributes['ResultType'] == 'O') {
                    $education->ClassObtained = $attributes['Other'];
                }
                $education->updated_at = Carbon::now();
                $education->CreatedBy = $userid;
                $education->fill($attributes)->save();

                \LogActivity::addToLog('Update Employee Education Info ' . $education->EmployeeID);
                return redirect()->action('HRIS\Database\EmployeeController@show', $eid . '?tab=' . $tab)->with('success', getNotify(2));
            }
        } else {
            return redirect()->back()->with('warning', getNotify(5));
        }
    }

    public function destroy($id)
    {
        if (getAccess('delete')) {
            $tab = 3;
            $education = EmployeeEducation::find($id);
            $eid = Employee::where('EmployeeID', $education->EmployeeID)->pluck('id')->first();
            $education->delete();

            \LogActivity::addToLog('Delete Employee Education Info ' . $education->EmployeeID);
            return redirect()->action('HRIS\Database\EmployeeController@show', $eid . '?tab=' . $tab)->with('success', getNotify(3));
        } else {
            return redirect()->back()->with('warning', getNotify(5));
        }
    }
}
