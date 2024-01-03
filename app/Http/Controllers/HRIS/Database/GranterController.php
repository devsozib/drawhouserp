<?php

namespace App\Http\Controllers\HRIS\Database;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\HRIS\Database\Employee;
use App\Models\HRIS\Database\EmployeeGranter;
use Input;
use Validator;
use Flash;
use Carbon\Carbon;
use Redirect;
use Sentinel;

class GranterController extends Controller
{
    public function update($id)
    {
        if (getAccess('edit')) {
            $tab = 11;
            $attributes = Input::all();
            $userid = Sentinel::getUser()->id;
            $empeGran = EmployeeGranter::find($id);
            $eid = Employee::where('EmployeeID', $empeGran->EmployeeID)->pluck('id')->first();
            $rules = [
                'g_name' => 'required',
                'g_phone' => 'required',
                'g_email' => 'required',
                'g_relation' => 'required',
                'g_nid' => 'required',
            ];
            $validation = Validator::make($attributes, $rules);
            if ($validation->fails()) {
                return redirect()->action('HRIS\Database\EmployeeController@show', $eid . '?tab=' . $tab)->with(['error' => getNotify(4), 'error_code' => $id])->withErrors($validation)->withInput();
            } else {
                $empeGran->updated_at = Carbon::now();
                $empeGran->created_by = $userid;
                $empeGran->fill($attributes)->update();

                \LogActivity::addToLog('Update Employee granter Info ' . $empeGran->EmployeeID);
                return redirect()->action('HRIS\Database\EmployeeController@show', $eid . '?tab=' . $tab)->with('success', getNotify(2));
            }
        } else {
            return redirect()->back()->with('warning', getNotify(5));
        }
    }
    public function destroy($id)
    {
        if (getAccess('delete')) {
            $tab = 11;
            $empeducation = EmployeeGranter::find($id);
            unlink(public_path('career/granter_nid/' . $empeducation->g_nid));
            $eid = Employee::where('EmployeeID', $empeducation->EmployeeID)->pluck('id')->first();
            $empeducation->delete();
            \LogActivity::addToLog('Delete Employee granter Info ' . $empeducation->EmployeeID);
            return redirect()->action('HRIS\Database\EmployeeController@show', $eid . '?tab=' . $tab)->with('success', getNotify(3));
        } else {
            return redirect()->back()->with('warning', getNotify(5));
        }
    }
}
