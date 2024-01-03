<?php

namespace App\Http\Controllers\HRIS\Setup;

use Input;
use Sentinel;
use Response;
use Validator;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use App\Models\HRIS\Setup\Degrees;
use Illuminate\Http\Request;

class DegreeController extends Controller
{
    public function index(Request $request)
    {
        if (getAccess('view')) {
            $users = Degrees::orderBy('id', 'ASC')->get();
            return view('hris.setup.degree.index', compact('users'));
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
                'Degree' => 'required|max:200|unique:hr_setup_degrees',
                'C4S' => 'required',
            ];
            $validation = Validator::make($attributes, $rules);
            if ($validation->fails()) {
                return redirect()->action('HRIS\Setup\DegreeController@index')->with(['error' => getNotify(4), 'error_code' => 'Add'])->withErrors($validation)->withInput();
            } else {
                $user = new Degrees();
                $user->CreatedBy = $userid;
                $user->fill($attributes)->save();

                \LogActivity::addToLog('Add Degree ' . $attributes['Degree']);
                return redirect()->action('HRIS\Setup\DegreeController@index')->with('success', getNotify(1));
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
                'Degree' => 'required|max:100|unique:hr_setup_degrees,Degree,' . $id,
                'C4S' => 'required',
            ];
            $validation = Validator::make($attributes, $rules);
            if ($validation->fails()) {
                return redirect()->action('HRIS\Setup\DegreeController@index')->with(['error' => getNotify(4), 'error_code' => $id])->withErrors($validation)->withInput();
            } else {
                $user = Degrees::find($id);
                $user->CreatedBy = $userid;
                $user->updated_at = Carbon::now();
                $user->fill($attributes)->save();

                \LogActivity::addToLog('Update Degree ' . $attributes['Degree']);
                return redirect()->action('HRIS\Setup\DegreeController@index')->with('success', getNotify(2));
            }
        } else {
            return redirect()->back()->with('warning', getNotify(5));
        }
    }

    public function destroy($id)
    {
        if (getAccess('delete')) {
            $userid = Sentinel::getUser()->id;
            $user = Degrees::find($id);
            $user->delete();

            \LogActivity::addToLog('Delete Degree ' . $user['Degree']);
            return redirect()->action('HRIS\Setup\DegreeController@index')->with('success', getNotify(3));
        } else {
            return redirect()->back()->with('warning', getNotify(5));
        }
    }
}
