<?php

namespace App\Http\Controllers\HRIS\Setup;

use Input;
use Sentinel;
use Response;
use Validator;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use App\Models\HRIS\Setup\LeaveDefinitions;
use Illuminate\Http\Request;

class LeaveDefineController extends Controller
{
    public function index(Request $request)
    {
        if (getAccess('view')) {
            $users = LeaveDefinitions::orderBy('id', 'ASC')->get();
            return view('hris.setup.leave_definitions.index', compact('users'));
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
                'TypeID' => 'required|unique:hr_setup_leavedefinitions',
                'Description' => 'required|unique:hr_setup_leavedefinitions',
                'DescriptionB' => 'required|unique:hr_setup_leavedefinitions',
                'YearlyMaxlimit' => 'required',
                'C4S' => 'required',
            ];
            $validation = Validator::make($attributes, $rules);
            if ($validation->fails()) {
                return redirect()->action('HRIS\Setup\LeaveDefineController@index')->with(['error' => getNotify(4), 'error_code' => 'Add'])->withErrors($validation)->withInput();
            } else {
                $user = new LeaveDefinitions();
                $user->CreatedBy = $userid;
                $user->fill($attributes)->save();

                \LogActivity::addToLog('Add leave ' . $attributes['Description']);
                return redirect()->action('HRIS\Setup\LeaveDefineController@index')->with('success', getNotify(1));
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
                'TypeID' => 'required',
                'Description' => 'required',
                'DescriptionB' => 'required',
                'YearlyMaxlimit' => 'required',
                'C4S' => 'required',
            ];
            $validation = Validator::make($attributes, $rules);
            if ($validation->fails()) {
                return redirect()->action('HRIS\Setup\LeaveDefineController@index')->with(['error' => getNotify(4), 'error_code' => $id])->withErrors($validation)->withInput();
            } else {
                $user = LeaveDefinitions::find($id);
                $user->CreatedBy = $userid;
                $user->updated_at = Carbon::now();
                $user->fill($attributes)->save();

                \LogActivity::addToLog('Update Leave ' . $attributes['Description']);
                return redirect()->action('HRIS\Setup\LeaveDefineController@index')->with('success', getNotify(2));
            }
        } else {
            return redirect()->back()->with('warning', getNotify(5));
        }
    }

    public function destroy($id)
    {
        if (getAccess('delete')) {
            $userid = Sentinel::getUser()->id;
            $user = LeaveDefinitions::find($id);
            $user->delete();

            \LogActivity::addToLog('Delete Leave ' . $user['Description']);
            return redirect()->action('HRIS\Setup\LeaveDefineController@index')->with('success', getNotify(3));
        } else {
            return redirect()->back()->with('warning', getNotify(5));
        }
    }
}
