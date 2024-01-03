<?php

namespace App\Http\Controllers\Library\General;

use Input;
use Sentinel;
use Validator;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use App\Models\Library\General\Company;
use App\Models\Library\General\PaymentMethod;
use Illuminate\Http\Request;

class PaymentMethodController extends Controller
{
    public function index(Request $request)
    {
        if (getAccess('view')) {
            // $users = Company::orderBy('id', 'ASC')->get();
            $users = PaymentMethod::orderBy('id', 'ASC')->get();
            $comp_arr = Company::orderBy('id', 'ASC')->where('C4S', 'Y')->pluck('Name', 'id');
            return view('library.general.payment_method.index', compact('users', 'comp_arr'));
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
                'name' => 'required|max:100|unique:lib_payment_method,name,NULL,id,company_id,' . $attributes['company_id'],
                'category_id' => 'required|numeric',
                'commission' => 'nullable|numeric',
                'status' => 'required',
            ];
            $validation = Validator::make($attributes, $rules);
            if ($validation->fails()) {
                return redirect()->action('Library\General\PaymentMethodController@index')->with(['error' => getNotify(4), 'error_code' => 'Add'])->withErrors($validation)->withInput();
            } else {
                $user = new PaymentMethod();
                $user->created_by = $userid;
                // return $attributes;
                $user->fill($attributes)->save();

                $comp = Company::findOrFail($attributes['company_id'])->Name;

                \LogActivity::addToLog('Add Payment Method: ' . $attributes['name'] . ' and Company: ' . $comp);
                return redirect()->action('Library\General\PaymentMethodController@index')->with('success', getNotify(1));
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
                'category_id' => 'required|numeric',
                'commission' => 'nullable|numeric',
                'status' => 'required',
            ];
            $validation = Validator::make($attributes, $rules);
            if ($validation->fails()) {
                return redirect()->action('Library\General\PaymentMethodController@index')->with(['error' => getNotify(4), 'error_code' => $id])->withErrors($validation)->withInput();
            } else {
                $user = PaymentMethod::find($id);
                $user->updated_by = $userid;
                $user->updated_at = Carbon::now();
                $user->fill($attributes)->save();

                $comp = Company::findOrFail($attributes['company_id'])->Name;

                \LogActivity::addToLog('Update Payment Method: ' . $attributes['name'] . ' and Company: ' . $comp);
                return redirect()->action('Library\General\PaymentMethodController@index')->with('success', getNotify(2));
            }
        } else {
            return redirect()->back()->with('warning', getNotify(5));
        }
    }

    public function destroy($id)
    {
        if (getAccess('delete')) {
            $userid = Sentinel::getUser()->id;
            $user = PaymentMethod::find($id);
            $user->delete();

            \LogActivity::addToLog('Delete Payment Method ' . $user['name']);
            return redirect()->action('Library\General\PaymentMethodController@index')->with('success', getNotify(3));
        } else {
            return redirect()->back()->with('warning', getNotify(5));
        }
    }
}
