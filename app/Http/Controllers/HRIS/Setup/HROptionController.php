<?php

namespace App\Http\Controllers\HRIS\Setup;

use Input;
use Sentinel;
use Response;
use Validator;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use App\Models\HRIS\Setup\Shifts;
use App\Models\HRIS\Tools\HROptions;
use Illuminate\Http\Request;

class HROptionController extends Controller
{
    public function index(Request $request)
    {
        if (getAccess('view')) {
            $users = HROptions::orderBy('id', 'ASC')->get();
            $shiftlist = Shifts::where('C4S','Y')->pluck('Shift_Name','Shift');
            return view('hris.setup.hr_options.index', compact('users','shiftlist'));
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
                'BasicPer' => 'required',
                'HRentPer' => 'required',
                'MedPer' => 'required',
                'ConvPer' => 'required',
                'JoiningToConfirm' => 'required',
                'DefaultShift' => 'required',
                'CheckLeaveLimit' => 'required',
                'EPhone' => 'required',
                'Year' => 'required',
                'Month' => 'required',
                'SinglePunchAbsent' => 'required',
            ];
            $validation = Validator::make($attributes, $rules);
            if ($validation->fails()) {
                return redirect()->action('HRIS\Setup\HROptionController@index')->with(['error' => getNotify(4), 'error_code' => $id])->withErrors($validation)->withInput();
            } else {
                $user = HROptions::find($id);
                $user->CreatedBy = $userid;
                $user->updated_at = Carbon::now();
                $user->fill($attributes)->save();

                \LogActivity::addToLog('Update HR Options ' . $attributes['BasicPer']);
                return redirect()->action('HRIS\Setup\HROptionController@index')->with('success', getNotify(2));
            }
        } else {
            return redirect()->back()->with('warning', getNotify(5));
        }
    }

}
