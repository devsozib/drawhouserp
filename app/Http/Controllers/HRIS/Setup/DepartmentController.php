<?php

namespace App\Http\Controllers\HRIS\Setup;

use Input;
use Sentinel;
use Response;
use Validator;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\HRIS\Setup\Department;

class DepartmentController extends Controller
{
    public function index(Request $request)
    {
        if (getAccess('view')) {
            $users =Department::whereRaw('FIND_IN_SET(?, company_id)', [getHostInfo()['id']])->where('C4S', 'Y')->orderBy('id', 'ASC')->get();
            return view('hris.setup.department.index', compact('users'));
        } else {
            return redirect()->back()->with('warning', getNotify(5));
        }
    }

    public function store(Request $request)
    {
        if (getAccess('create')) {
            $userid = Sentinel::getUser()->id;
            $attributes = Input::all();
            $rules = [
                'Department' => 'required|max:100|unique:hr_setup_department',
                'C4S' => 'required',
            ];
            $validation = Validator::make($attributes, $rules);
            if ($validation->fails()) {
                return redirect()->action('HRIS\Setup\DepartmentController@index')->with(['error' => getNotify(4), 'error_code' => 'Add'])->withErrors($validation)->withInput();
            } else {
                $user = new Department();
                $user->company_id = '1,2,3,4,5,6,7,8';
                $user->CreatedBy = $userid;
                $user->fill($attributes)->save();

                \LogActivity::addToLog('Add Department ' . $attributes['Department']);
                return redirect()->action('HRIS\Setup\DepartmentController@index')->with('success', getNotify(1));
            }
        } else {
            return redirect()->back()->with('warning', getNotify(5));
        }
    }

    public function update(Request $request, $id)
    {
        if (getAccess('edit')) {
            $userid = Sentinel::getUser()->id;
            $attributes = Input::all();
            $rules = [
                'Department' => 'required|max:100|unique:hr_setup_department,Department,' . $id,
                'C4S' => 'required',
            ];
            $validation = Validator::make($attributes, $rules);
            if ($validation->fails()) {
                return redirect()->action('HRIS\Setup\DepartmentController@index')->with(['error' => getNotify(4), 'error_code' => $id])->withErrors($validation)->withInput();
            } else {
                $user = Department::find($id);
                $user->CreatedBy = $userid;
                $user->updated_at = Carbon::now();
                $user->fill($attributes)->save();

                \LogActivity::addToLog('Update Department ' . $attributes['Department']);
                return redirect()->action('HRIS\Setup\DepartmentController@index')->with('success', getNotify(2));
            }
        } else {
            return redirect()->back()->with('warning', getNotify(5));
        }
    }

    public function destroy($id)
    {
        if (getAccess('delete')) {
            $userid = Sentinel::getUser()->id;
            $user = Department::find($id);
            $user->delete();

            \LogActivity::addToLog('Delete Department ' . $user['Department']);
            return redirect()->action('HRIS\Setup\DepartmentController@index')->with('success', getNotify(3));
        } else {
            return redirect()->back()->with('warning', getNotify(5));
        }
    }
}
