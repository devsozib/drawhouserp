<?php

namespace App\Http\Controllers\Library\General;

use Input;
use Sentinel;
use Response;
use Validator;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Library\General\Customer;

class CustomerController extends Controller
{
    public function index(Request $request) {
        if (getAccess('view')) {
            $customers = Customer::orderBy('id','ASC')->get();
            return view('library.general.customers.index', compact('customers'));
        } else {
            return redirect()->back()->with('warning', getNotify(5));
        }
    }
    public function profile(Request $request) {
        if (getAccess('view')) {
            $customers = Customer::orderBy('id','ASC')->get();
            return view('library.general.customers.customer_profile', compact('customers'));
        } else {
            return redirect()->back()->with('warning', getNotify(5));
        }
    }

    public function store(Request $request) {       
        if (getAccess('create')) {        
            $userid = Sentinel::getUser()->id;
            $attributes = Input::all();
            $rules = [
                // 'name' => 'required',
                // 'email' => 'required|max:255|unique:lib_customers,email',
                'phone' => 'required|numeric|min:11',
                // 'dob' => 'required|max:10',
                // 'mra' => 'required|max:10',
                // 'address' => 'required',
                // 'password' => 'required|min:8',
                'status' => 'required',
            ];
            $validation = Validator::make($attributes, $rules);
            if($validation->fails()) {
                return redirect()->action('Library\General\CustomerController@index')->with(['error'=>getNotify(4), 'error_code'=>"Add"])->withErrors($validation)->withInput();
            }else{
                // return $attributes;
                $user = new Customer();
                $user->created_by = $userid;
                $user->fill($attributes)->save();
                \LogActivity::addToLog('Add Customer '.$attributes['name']);
                return redirect()->action('Library\General\CustomerController@index')->with('success',getNotify(1));
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
                // 'name' => 'required',
                // 'email' => 'required|email|unique:lib_customers,email,'.$id,
                'phone' => 'required|numeric|min:11',
                // 'dob' => 'required|max:10',
                // 'mra' => 'required|max:10',
                // 'address' => 'required',
                'status' => 'required',
            ];
            $validation = Validator::make($attributes, $rules);
            if($validation->fails()) {
                return redirect()->action('Library\General\CustomerController@index')->with(['error'=>getNotify(4), 'error_code'=>$id])->withErrors($validation)->withInput();
            }else{
                $user = Customer::find($id);
                $user->updated_by = $userid;
                $user->updated_at = Carbon::now();
                $user->fill($attributes)->save();

                \LogActivity::addToLog('Update Customer '.$attributes['name']);
                return redirect()->action('Library\General\CustomerController@index')->with('success',getNotify(2));
            }
        } else {
            return redirect()->back()->with('warning', getNotify(5));
        }
    }

    public function destroy($id) {
        if (getAccess('delete')) {
            $userid = Sentinel::getUser()->id;
            $user = Customer::find($id);
            $user->delete();

            \LogActivity::addToLog('Delete Customer '.$user['name']);
            return redirect()->action('Library\General\CustomerController@index')->with('success',getNotify(3));
        } else {
            return redirect()->back()->with('warning', getNotify(5));
        }
    }
}
