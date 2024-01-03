<?php

namespace App\Http\Controllers\HRIS\Setup;

use Input;
use Sentinel;
use Response;
use Validator;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use App\Models\HRIS\Setup\HDException;
use Illuminate\Http\Request;

class HDExceptionController extends Controller
{
    public function index(Request $request)
    {
        if (getAccess('view')) {
            $users = HDException::orderBy('id', 'ASC')->get();
            return view('hris.setup.hdexceptions.index', compact('users'));
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
                'EmployeeID' => 'required|numeric',
                'WeeklyHoliday' => 'required',
                'C4S' => 'required',
            ];
            $validation = Validator::make($attributes, $rules);
            if ($validation->fails()) {
                return redirect()->back()->with(['error' => getNotify(4), 'error_code' => 'Add'])->withErrors($validation)->withInput();
            } else {
                $chk = HDException::where('EmployeeID',$attributes['EmployeeID'])->first();
                if ($chk) {
                    return redirect()->back()->with(['error' => getNotify(6), 'error_code' => 'Add'])->withInput();
                } else {
                    $user = new HDException();
                    $user->company_id = getEmpCompany($attributes['EmployeeID']);
                    $user->CreatedBy = $userid;
                    $user->fill($attributes)->save();

                    \LogActivity::addToLog('Add Holiday Exception ' . $attributes['EmployeeID']);
                    return redirect()->back()->with('success', getNotify(1));
                }
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
                'WeeklyHoliday' => 'required',
                'C4S' => 'required',
            ];
            $validation = Validator::make($attributes, $rules);
            if ($validation->fails()) {
                return redirect()->back()->with(['error' => getNotify(4), 'error_code' => $id])->withErrors($validation)->withInput();
            } else {
                $user = HDException::find($id);
                $chk = HDException::where('EmployeeID',$user->EmployeeID)->where('id','!=',$id)->first();
                if ($chk) {
                    return redirect()->back()->with(['error' => getNotify(6), 'error_code' => $id])->withInput();
                } else {
                    $user->CreatedBy = $userid;
                    $user->updated_at = Carbon::now();
                    $user->fill($attributes)->save();

                    \LogActivity::addToLog('Update HDException ' . $attributes['WeeklyHoliday']);
                    return redirect()->back()->with('success', getNotify(2));
                }
            }
        } else {
            return redirect()->back()->with('warning', getNotify(5));
        }
    }

    public function destroy($id)
    {
        if (getAccess('delete')) {
            $user = HDException::find($id);
            $user->delete();

            \LogActivity::addToLog('Delete HDException ' . $user['EmployeeID']);
            return redirect()->back()->with('success', getNotify(3));
        } else {
            return redirect()->back()->with('warning', getNotify(5));
        }
    }
}
