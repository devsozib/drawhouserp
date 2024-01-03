<?php

namespace App\Http\Controllers\HRIS\Database;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\HRIS\Database\Employee;
use App\Models\HRIS\Database\EmployeeReference;
use Input;
use Validator;
use Flash;
use Carbon\Carbon;
use Redirect;
use Sentinel;

class ReferenceController extends Controller
{
    public function update($id)
    {
        if (getAccess('edit')) {
            $tab = 7;
            $attributes = Input::all();
            $userid = Sentinel::getUser()->id;
            $empeRef = EmployeeReference::find($id);
            $eid = Employee::where('EmployeeID', $empeRef->EmployeeID)->pluck('id')->first();
            $rules = [
                'r_name' => 'required',
                'r_phone' => 'required',
                'r_email' => 'required',
                'r_relation' => 'required',
            ];
            $validation = Validator::make($attributes, $rules);
            if ($validation->fails()) {
                return redirect()->action('HRIS\Database\EmployeeController@show', $eid . '?tab=' . $tab)->with(['error' => getNotify(4), 'error_code' => $id])->withErrors($validation)->withInput();
            } else {
                $empeRef->updated_at = Carbon::now();
                $empeRef->CreatedBy = $userid;
                $empeRef->fill($attributes)->update();

                \LogActivity::addToLog('Update Employee Experience Info ' . $empeRef->EmployeeID);
                return redirect()->action('HRIS\Database\EmployeeController@show', $eid . '?tab=' . $tab)->with('success', getNotify(2));
            }
        } else {
            return redirect()->back()->with('warning', getNotify(5));
        }
    }
    public function destroy($id)
    {
        if (getAccess('delete')) {
            $tab = 7;
            $empeducation = EmployeeReference::find($id);
            $eid = Employee::where('EmployeeID', $empeducation->EmployeeID)->pluck('id')->first();
            $empeducation->delete();

            \LogActivity::addToLog('Delete Employee reference Info ' . $empeducation->EmployeeID);
            return redirect()->action('HRIS\Database\EmployeeController@show', $eid . '?tab=' . $tab)->with('success', getNotify(3));
        } else {
            return redirect()->back()->with('warning', getNotify(5));
        }
    }
}
