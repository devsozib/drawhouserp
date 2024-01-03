<?php

namespace App\Http\Controllers\Library\General;

use Input;
use Sentinel;
use Validator;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use App\Models\Library\General\Company;
use App\Models\Library\General\Table;
use Illuminate\Http\Request;

class TableController extends Controller
{
    public function index(Request $request)
    {
        if (getAccess('view')) {
            // $users = Company::orderBy('id', 'ASC')->get();
            $users = Table::orderBy('id', 'ASC')->get();
            $comp_arr = Company::orderBy('id','ASC')->where('C4S','Y')->pluck('Name','id');
            return view('library.general.table.index', compact('users','comp_arr'));
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
                'company_id' => 'required',
                'name' => 'required|max:100|unique:lib_tables,name,NULL,id,company_id,' . $attributes['company_id'],
                'status' => 'required',
            ];
            $validation = Validator::make($attributes, $rules);
            if ($validation->fails()) {
                return redirect()->action('Library\General\TableController@index')->with(['error' => getNotify(4), 'error_code' => 'Add'])->withErrors($validation)->withInput();
            } else {
                $user = new Table();
                $user->created_by = $userid;
                $user->fill($attributes)->save();

                $comp = Company::findOrFail($attributes['company_id'])->Name;

                \LogActivity::addToLog('Add Table: '.$attributes['name'].' and Company: '.$comp);
                return redirect()->action('Library\General\TableController@index')->with('success', getNotify(1));
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
                'company_id' => 'required',
                'name' => 'required|max:100|unique:lib_tables,name,' . $id,
                'status' => 'required',
            ];
            $validation = Validator::make($attributes, $rules);
            if ($validation->fails()) {
                return redirect()->action('Library\General\TableController@index')->with(['error' => getNotify(4), 'error_code' => $id])->withErrors($validation)->withInput();
            } else {
                $user = Table::find($id);
                $user->created_by = $userid;
                $user->updated_at = Carbon::now();
                $user->fill($attributes)->save();

                $comp = Company::findOrFail($attributes['company_id'])->Name;

                \LogActivity::addToLog('Update Table: '.$attributes['name'].' and Company: '.$comp);
                return redirect()->action('Library\General\TableController@index')->with('success', getNotify(2));
            }
        } else {
            return redirect()->back()->with('warning', getNotify(5));
        }
    }

    public function destroy($id)
    {
        if (getAccess('delete')) {
            $userid = Sentinel::getUser()->id;
            $user = Table::find($id);
            $user->delete();

            \LogActivity::addToLog('Delete Table ' . $user['name']);
            return redirect()->action('Library\General\TableController@index')->with('success', getNotify(3));
        } else {
            return redirect()->back()->with('warning', getNotify(5));
        }
    }
}
