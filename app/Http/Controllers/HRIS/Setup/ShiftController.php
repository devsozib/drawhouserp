<?php

namespace App\Http\Controllers\HRIS\Setup;

use Input;
use Sentinel;
use Response;
use Validator;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use App\Models\HRIS\Setup\Shifts;
use Illuminate\Http\Request;

class ShiftController extends Controller
{
    public function index(Request $request)
    {
        if (getAccess('view')) {
            $users = Shifts::whereRaw('FIND_IN_SET(?, company_id)', [getHostInfo()['id']])->orderBy('id', 'ASC')->get();
            return view('hris.setup.shift.index', compact('users'));
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
                'Shift' => 'required|unique:hr_setup_shifts,Shift,',
                'Shift_Name' => 'required|max:100|unique:hr_setup_shifts,Shift_Name,',
                'ShiftStartHour' => 'required',
                'ShiftStartMinute' => 'required',
                'ShiftEndHour' => 'required',
                'ShiftEndMinute' => 'required',
                'C4S' => 'required',
            ];
            $validation = Validator::make($attributes, $rules);
            if ($validation->fails()) {
                return redirect()->action('HRIS\Setup\ShiftController@index')->with(['error' => getNotify(4), 'error_code' => 'Add'])->withErrors($validation)->withInput();
            } else {
                $user = new Shifts();
                $user->company_id = '1,2,3,4,5,6,7,8';
                $user->CreatedBy = $userid;
                $user->fill($attributes)->save();

                \LogActivity::addToLog('Add Shift ' . $attributes['Shift_Name']);
                return redirect()->action('HRIS\Setup\ShiftController@index')->with('success', getNotify(1));
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
                'Shift' => 'required|unique:hr_setup_shifts,Shift,' . $id,
                'Shift_Name' => 'required|max:100|unique:hr_setup_shifts,Shift_Name,' . $id,
                'ShiftStartHour' => 'required',
                'ShiftStartMinute' => 'required',
                'ShiftEndHour' => 'required',
                'ShiftEndMinute' => 'required',
                'C4S' => 'required',
            ];
            $validation = Validator::make($attributes, $rules);
            if ($validation->fails()) {
                return redirect()->action('HRIS\Setup\ShiftController@index')->with(['error' => getNotify(4), 'error_code' => $id])->withErrors($validation)->withInput();
            } else {
                $user = Shifts::find($id);
                $user->company_id = '1,2,3,4,5,6,7,8';
                $user->CreatedBy = $userid;
                $user->updated_at = Carbon::now();
                $user->fill($attributes)->save();

                \LogActivity::addToLog('Update Shift ' . $attributes['Shift_Name']);
                return redirect()->action('HRIS\Setup\ShiftController@index')->with('success', getNotify(2));
            }
        } else {
            return redirect()->back()->with('warning', getNotify(5));
        }
    }

    public function destroy($id)
    {
        if (getAccess('delete')) {
            $userid = Sentinel::getUser()->id;
            $user = Shifts::find($id);
            $user->delete();

            \LogActivity::addToLog('Delete Shift ' . $user['Shift_Name']);
            return redirect()->action('HRIS\Setup\ShiftController@index')->with('success', getNotify(3));
        } else {
            return redirect()->back()->with('warning', getNotify(5));
        }
    }
}
