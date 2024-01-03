<?php

namespace App\Http\Controllers\Library\ExpenseManagement;

use Input;
use Sentinel;
use Response;
use Validator;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use App\Models\Library\General\ExpenseType;
use Illuminate\Http\Request;

class ExpenseTypeController extends Controller
{
    public function index(Request $request) {
        if (getAccess('view')) {
            $expense_types = ExpenseType::orderBy('id','ASC')->get();
            return view('library.expense_management.expense_type.index', compact('expense_types'));
        } else {
            return redirect()->back()->with('warning', getNotify(5));
        }
    }

    public function store(Request $request) {

        if (getAccess('create')) {
            $userid = Sentinel::getUser()->id;
             $attributes = Input::all();
            $rules = [
                'name' => 'required | unique:lib_expense_type,name',
                'status' => 'required',
            ];
            $validation = Validator::make($attributes, $rules);
            if($validation->fails()) {
                return redirect()->action('Library\ExpenseManagement\ExpenseTypeController@index')->with(['error'=>getNotify(4), 'error_code'=>'Add'])->withErrors($validation)->withInput();
            }else{
                // return $attributes;
                $user = new ExpenseType();
                $user->created_by = $userid;
                $user->fill($attributes)->save();
                \LogActivity::addToLog('Add Expense Type '.$attributes['name']);
                return redirect()->action('Library\ExpenseManagement\ExpenseTypeController@index')->with('success',getNotify(1));
            }
        } else {
            return redirect()->back()->with('warning', getNotify(5));
        }
    }

    public function update(Request $request,$id) {
        if (getAccess('edit')) {
            $userid = Sentinel::getUser()->id;
            $attributes = Input::all();
            $expense =ExpenseType::find($id);
            $name="";
            if($expense->name == $request->name){   
            $rules = [
                'status' => 'required',
            ];
            $name = $expense->name;
        }else {
            $rules = [
                'name' => 'required|unique',
                'status' => 'required',
            ];
            $name = $request->name;
        }
            $validation = Validator::make($attributes, $rules);
            if($validation->fails()) {
                return redirect()->action('Library\ExpenseManagement\ExpenseTypeController@index')->with(['error'=>getNotify(4), 'error_code'=>$id])->withErrors($validation)->withInput();
            }else{
                $user = ExpenseType::find($id);
                $user->updated_by = $userid;
                $user->updated_at = Carbon::now();
                $user->fill($attributes)->save();

                \LogActivity::addToLog('Update Expense Type '.$attributes['name']);
                return redirect()->action('Library\ExpenseManagement\ExpenseTypeController@index')->with('success',getNotify(2));
            }
        } else {
            return redirect()->back()->with('warning', getNotify(5));
        }
    }

    public function destroy($id) {
        if (getAccess('delete')) {
            $userid = Sentinel::getUser()->id;
            $user = ExpenseType::find($id);
            $user->delete();

            \LogActivity::addToLog('Delete Expense Type '.$user['name']);
            return redirect()->action('Library\ExpenseManagement\ExpenseTypeController@index')->with('success',getNotify(3));
        } else {
            return redirect()->back()->with('warning', getNotify(5));
        }
    }
}
