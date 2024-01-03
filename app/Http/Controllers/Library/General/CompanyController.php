<?php

namespace App\Http\Controllers\Library\General;

use Input;
use Sentinel;
use Response;
use Validator;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Library\General\Company;

class CompanyController extends Controller
{
    public function index(Request $request)
    {
        if (getAccess('view')) {
            $users = Company::orderBy('id', 'ASC')->get();
            return view('library.general.company.index', compact('users'));
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
                'Name' => 'required|max:100|unique:lib_company',
                'Address' => 'required|max:100',
                'Email' => 'required|max:100|email',
                'Phone' => 'required|max:11',
                'Owner' => 'required|max:100',
                'C4S' => 'required',
            ];
            $validation = Validator::make($attributes, $rules);
            if ($validation->fails()) {
                return redirect()->action('Library\General\CompanyController@index')->with(['error' => getNotify(4), 'error_code' => 'Add'])->withErrors($validation)->withInput();
            } else {
                $user = new Company();
                $user->CreatedBy = $userid;
                $user->fill($attributes)->save();

                \LogActivity::addToLog('Add Company ' . $attributes['Name']);
                return redirect()->action('Library\General\CompanyController@index')->with('success', getNotify(1));
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
                'Name' => 'required|max:100|unique:lib_company,Name,' . $id,
                'Address' => 'required|max:100',
                'Email' => 'required|max:100|email',
                'Phone' => 'required|max:11',
                'Owner' => 'required|max:100',
                'C4S' => 'required',
            ];
            $validation = Validator::make($attributes, $rules);
            if ($validation->fails()) {
                return redirect()->action('Library\General\CompanyController@index')->with(['error' => getNotify(4), 'error_code' => $id])->withErrors($validation)->withInput();
            } else {
                $user = Company::find($id);
                $user->CreatedBy = $userid;
                $user->updated_at = Carbon::now();
                $user->fill($attributes)->save();

                \LogActivity::addToLog('Update Company ' . $attributes['Name']);
                return redirect()->action('Library\General\CompanyController@index')->with('success', getNotify(2));
            }
        } else {
            return redirect()->back()->with('warning', getNotify(5));
        }
    }

    public function destroy($id)
    {
        if (getAccess('delete')) {
            $userid = Sentinel::getUser()->id;
            $user = Company::find($id);
            $user->delete();

            \LogActivity::addToLog('Delete Company ' . $user['Name']);
            return redirect()->action('Library\General\CompanyController@index')->with('success', getNotify(3));
        } else {
            return redirect()->back()->with('warning', getNotify(5));
        }
    }
}
