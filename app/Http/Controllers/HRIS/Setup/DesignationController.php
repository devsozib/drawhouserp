<?php

namespace App\Http\Controllers\HRIS\Setup;

use Input;
use Sentinel;
use Response;
use Validator;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\HRIS\Setup\Designation;

class DesignationController extends Controller
{
    public function index(Request $request)
    {
        if (getAccess('view')) {
            $users = Designation::whereRaw('FIND_IN_SET(?, company_id)', [getHostInfo()['id']])->orderBy('id', 'ASC')->get();
            return view('hris.setup.designation.index', compact('users'));
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
                'Designation' => 'required|max:100|unique:hr_setup_designation',
                'C4S' => 'required',
            ];
            $validation = Validator::make($attributes, $rules);
            if ($validation->fails()) {
                return redirect()->action('HRIS\Setup\DesignationController@index')->with(['error' => getNotify(4), 'error_code' => 'Add'])->withErrors($validation)->withInput();
            } else {
                $user = new Designation();
                $user->company_id = '1,2,3,4,5,6,7,8';
                $user->CreatedBy = $userid;
                $user->fill($attributes)->save();

                \LogActivity::addToLog('Add Designation ' . $attributes['Designation']);
                return redirect()->action('HRIS\Setup\DesignationController@index')->with('success', getNotify(1));
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
                'Designation' => 'required|max:100|unique:hr_setup_designation,Designation,' . $id,
                'C4S' => 'required',
            ];
            $validation = Validator::make($attributes, $rules);
            if ($validation->fails()) {
                return redirect()->action('HRIS\Setup\DesignationController@index')->with(['error' => getNotify(4), 'error_code' => $id])->withErrors($validation)->withInput();
            } else {
                $user = Designation::find($id);
                $user->CreatedBy = $userid;
                $user->updated_at = Carbon::now();
                $user->fill($attributes)->save();

                \LogActivity::addToLog('Update Designation ' . $attributes['Designation']);
                return redirect()->action('HRIS\Setup\DesignationController@index')->with('success', getNotify(2));
            }
        } else {
            return redirect()->back()->with('warning', getNotify(5));
        }
    }

    public function destroy($id)
    {
        if (getAccess('delete')) {
            $userid = Sentinel::getUser()->id;
            $user = Designation::find($id);
            $user->delete();

            \LogActivity::addToLog('Delete Designation ' . $user['Designation']);
            return redirect()->action('HRIS\Setup\DesignationController@index')->with('success', getNotify(3));
        } else {
            return redirect()->back()->with('warning', getNotify(5));
        }
    }
}
