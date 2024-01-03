<?php

namespace App\Http\Controllers\HRIS\Database;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Menus;
use App\Models\ChildMenus;
use App\Models\Permissions;
use App\Models\RoleAssignedChildMenus;
use App\Models\RoleAssignedMenus;
use App\Models\RoleAssignedPermissions;
use App\Models\HRIS\Database\Employee;
use App\Models\HRIS\Database\EmployeeExperience;
use Input;
use Validator;
use Flash;
use Carbon\Carbon;
use Redirect;
use Sentinel;

class ExperienceController extends Controller
{
    public function update($id)
    {
        if (getAccess('edit')) {
            $tab = 5;
            $attributes = Input::all();
            $userid = Sentinel::getUser()->id;
            $empeducation = EmployeeExperience::find($id);
            $eid = Employee::where('EmployeeID', $empeducation->EmployeeID)->pluck('id')->first();
            $rules = [
                'Designation' => 'required|max:100',
                'Organization' => 'max:100',
                'Duration' => 'max:30',
                'Description' => 'max:150',
            ];
            $validation = Validator::make($attributes, $rules);
            if ($validation->fails()) {
                return redirect()->action('HRIS\Database\EmployeeController@show', $eid . '?tab=' . $tab)->with(['error' => getNotify(4), 'error_code' => $id])->withErrors($validation)->withInput();
            } else {
                $empeducation->updated_at = Carbon::now();
                $empeducation->CreatedBy = $userid;
                $empeducation->fill($attributes)->update();

                \LogActivity::addToLog('Update Employee Experience Info ' . $empeducation->EmployeeID);
                return redirect()->action('HRIS\Database\EmployeeController@show', $eid . '?tab=' . $tab)->with('success', getNotify(2));
            }
        } else {
            return redirect()->back()->with('warning', getNotify(5));
        }
    }

    public function destroy($id)
    {
        if (getAccess('delete')) {
            $tab = 5;
            $empeducation = EmployeeExperience::find($id);
            $eid = Employee::where('EmployeeID', $empeducation->EmployeeID)->pluck('id')->first();
            $empeducation->delete();

            \LogActivity::addToLog('Delete Employee Experience Info ' . $empeducation->EmployeeID);
            return redirect()->action('HRIS\Database\EmployeeController@show', $eid . '?tab=' . $tab)->with('success', getNotify(3));
        } else {
            return redirect()->back()->with('warning', getNotify(5));
        }
    }
}
