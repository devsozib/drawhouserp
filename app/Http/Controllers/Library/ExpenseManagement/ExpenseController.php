<?php

namespace App\Http\Controllers\Library\ExpenseManagement;

use Input;
use Sentinel;
use Response;
use Validator;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use App\Models\Library\General\Expense;
use App\Models\Library\General\ExpenseType;
use App\Models\Library\General\Company;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    public function index(Request $request) {
        if (getAccess('view')) {
            $expenses = Expense::orderBy('id','ASC')->get();
            $exp_type_arr = ExpenseType::orderBy('id','ASC')->where('status','1')->pluck('name','id');
            $comp_arr = Company::orderBy('id','ASC')->where('C4S','Y')->pluck('Name','id');
            return view('library.expense_management.expenses.index', compact('expenses','exp_type_arr','comp_arr'));
        } else {
            return redirect()->back()->with('warning', getNotify(5));
        }
    }

    public function store(Request $request) {

        if (getAccess('create')) {
            $userid = Sentinel::getUser()->id;
            $attributes = Input::all();
            $rules = [
                'company_id' => 'required',
                'expns_type_id' => 'required',
                'expns_time' => 'required',
                'remarks' => 'required',
                'amount' => 'required|max:999999',
                'status' => 'required',
            ];
            $validation = Validator::make($attributes, $rules);
            if($validation->fails()) {
                return redirect()->action('Library\ExpenseManagement\ExpenseController@index')->with(['error'=>getNotify(4), 'error_code'=>$id])->withErrors($validation)->withInput();
            }else{
                // return $attributes;
                $user = new Expense();
                $user->created_by = $userid;
                $user->fill($attributes)->save();
                
                $exp_type = ExpenseType::findOrFail($attributes['expns_type_id'])->name;
                $comp = Company::findOrFail($attributes['company_id'])->Name;

                \LogActivity::addToLog('Add Table: '.$exp_type.' and Company: '.$comp);
                return redirect()->action('Library\ExpenseManagement\ExpenseController@index')->with('success',getNotify(1));
            }
        } else {
            return redirect()->back()->with('warning', getNotify(5));
        }
    }

    public function update(Request $request,$id) {
        if (getAccess('edit')) {
            $userid = Sentinel::getUser()->id;
            $attributes = Input::all();
            $rules = [
                'company_id' => 'required',
                'expns_type_id' => 'required',
                'expns_time' => 'required',
                'remarks' => 'required',
                'amount' => 'required|max:999999',
                'status' => 'required',
            ];
            $validation = Validator::make($attributes, $rules);
            if($validation->fails()) {
                return redirect()->action('Library\ExpenseManagement\ExpenseController@index')->with(['error'=>getNotify(4), 'error_code'=>$id])->withErrors($validation)->withInput();
            }else{
                $user = Expense::find($id);
                $user->created_by = $userid;
                $user->updated_at = Carbon::now();
                $user->fill($attributes)->save();

                $exp_type = ExpenseType::findOrFail($attributes['expns_type_id'])->name;
                $comp = Company::findOrFail($attributes['company_id'])->Name;

                \LogActivity::addToLog('Add Expenses Type: '.$exp_type.' and Company: '.$comp);
                return redirect()->action('Library\ExpenseManagement\ExpenseController@index')->with('success',getNotify(2));
            }
        } else {
            return redirect()->back()->with('warning', getNotify(5));
        }
    }

    public function destroy($id) {
        if (getAccess('delete')) {
            $userid = Sentinel::getUser()->id;
            $user = Expense::find($id);
            $user->delete();
            

            \LogActivity::addToLog('Delete Expenses '.$user['deleted_by']);
            return redirect()->action('Library\ExpenseManagement\ExpenseController@index')->with('success',getNotify(3));
        } else {
            return redirect()->back()->with('warning', getNotify(5));
        }
    }
}
