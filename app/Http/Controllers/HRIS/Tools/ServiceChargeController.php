<?php

namespace App\Http\Controllers\HRIS\Tools;

use DB;
use Input;
use Redirect;
use Response;
use Sentinel;
use Validator;
use Svg\Tag\Rect;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Users;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\HRIS\Database\Employee;
use App\Models\Library\General\Company;
use App\Models\HRIS\Tools\ProcessSalary;
use App\Models\HRIS\Tools\ServiceCharge;
use App\Models\HRIS\Database\EmployeeSalary;

class ServiceChargeController extends Controller
{
    public function index()
    {
        if (getAccess('view')) {
            $charges = ServiceCharge::join('lib_company', 'lib_company.id', '=', 'hr_tools_service_charges.company_id')->where('hr_tools_service_charges.status', '1')->whereIn('hr_tools_service_charges.company_id',getCompanyIds())->select('hr_tools_service_charges.*', 'lib_company.Name')->get();
            return view('hris.tools.servicecharge.index', compact('charges'));
        } else {
            return redirect()->back()->with('warning', getNotify(5));
        }
    }

    public function store(Request $request)
    {
        if (getAccess('create')) {
            $attributes = Input::all();
            $userid = Sentinel::getUser()->id;
            $rules = [
                'company_id' => 'required|numeric',
                'Year' => 'required|numeric',
                'Month' => 'required|numeric',
                'amount' => 'required|numeric|between:0,99999999',
                'status' => 'required',
            ];
            $validation = Validator::make($attributes, $rules);
            if ($validation->fails()) {
                return redirect()->back()->with(['error' => getNotify(4), 'error_code' => 'Add'])->withErrors($validation)->withInput();
            } else {
                $year = $request->Year; $month = $request->Month; $company_id = $request->company_id;
                $chksalpro = ProcessSalary::orderBy('id', 'DESC')->where('Year', $year)->where('Month', $month)->where('company_id',$company_id)->where('Confirmed', 'Y')->first();
                $checkExisting = ServiceCharge::where('year', $year)->where('month', $month)->where('company_id', $company_id)->first();
                if ($checkExisting) {
                    return redirect()->back()->with('warning', getNotify(6));
                } elseif ($chksalpro) {
                    return redirect()->back()->with('warning', 'Insert Is Not Available Because Process Salary Already Confirmed')->withInput();
                } else {
                    $charge = new ServiceCharge();
                    $charge->company_id = $company_id;
                    $charge->year = $year;
                    $charge->month = $month;
                    $charge->amount = $request->amount;
                    $charge->status = $request->status;
                    $charge->created_by = $userid;
                    $charge->save();

                    $empids = Employee::where('company_id',$company_id)->where('ReasonID','N')->pluck('EmployeeID');
                    EmployeeSalary::whereIn('EmployeeID',$empids)->update(['ServiceCharge'=>$request->amount]);

                    \LogActivity::addToLog('Add Service Charge ' . $charge['id']);
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
            $attributes = Input::all();
            $userid = Sentinel::getUser()->id;
            $rules = [
                'company_id' => 'required|numeric',
                'Year' => 'required|numeric',
                'Month' => 'required|numeric',
                'amount' => 'required|numeric|between:0,99999999',
                'status' => 'required',
            ];
            $validation = Validator::make($attributes, $rules);
            if ($validation->fails()) {
                return redirect()->back()->with(['error' => getNotify(4), 'error_code' => $id])->withErrors($validation)->withInput();
            } else {
                $year = $request->Year; $month = $request->Month; $company_id = $request->company_id;
                $chksalpro = ProcessSalary::orderBy('id', 'DESC')->where('Year', $year)->where('Month', $month)->where('company_id',$company_id)->where('Confirmed', 'Y')->first();
                $checkExisting = ServiceCharge::where('year', $year)->where('month', $month)->where('company_id', $company_id)->where('id','!=',$id)->first();
                if ($checkExisting) {
                    return redirect()->back()->with('warning', getNotify(6));
                } elseif ($chksalpro) {
                    return redirect()->back()->with('warning', 'Update Is Not Available Because Process Salary Already Confirmed')->withInput();
                } else {
                    $charge = ServiceCharge::find($id);
                    $charge->company_id = $company_id;
                    $charge->year = $year;
                    $charge->month = $month;
                    $charge->amount = $request->amount;
                    $charge->status = $request->status;
                    $charge->created_by = $userid;
                    $charge->update();

                    $empids = Employee::where('company_id',$company_id)->where('ReasonID','N')->pluck('EmployeeID');
                    EmployeeSalary::whereIn('EmployeeID',$empids)->update(['ServiceCharge'=>$request->amount]);

                    \LogActivity::addToLog('Edit Service Charge ' . $charge['id']);
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
            $userid = Sentinel::getUser()->id;
            $charge = ServiceCharge::find($id);
            $chksalpro = ProcessSalary::orderBy('id', 'DESC')->where('Year', $charge->year)->where('Month', $charge->month)->where('company_id',$charge->company_id)->where('Confirmed', 'Y')->first();
            if ($chksalpro) {
                return redirect()->back()->with('warning', 'Delete Is Not Available Because Process Salary Already Confirmed')->withInput();
            } else {
                $charge->delete();

                \LogActivity::addToLog('Delete Service Charge ' . $charge['id']);
                return redirect()->back()->with('success', getNotify(3));
            }
        } else {
            return redirect()->back()->with('warning', getNotify(5));
        }
    }
}
