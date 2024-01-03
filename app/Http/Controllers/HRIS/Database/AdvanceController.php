<?php

namespace App\Http\Controllers\HRIS\Database;

use DB;
use Input;
use Redirect;
use Sentinel;
use Validator;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\HRIS\Database\Employee;
use App\Models\HRIS\Database\AdvanceLoan;
use App\Models\HRIS\Database\EmployeeSalary;

class AdvanceController extends Controller
{
    public function index()
    {
        if (getAccess('view')) {
            $advanceemp = DB::table('payroll_database_advance')
                ->where('payroll_database_advance.Closed', 'N')
                ->leftJoin('hr_database_employee_basic as basic', 'payroll_database_advance.EmployeeID', '=', 'basic.EmployeeID')
                ->leftJoin('hr_setup_designation', 'basic.DesignationID', '=', 'hr_setup_designation.id')
                ->leftJoin('hr_setup_department', 'basic.DepartmentID', '=', 'hr_setup_department.id')
                ->select('basic.Name', 'hr_setup_designation.Designation', 'hr_setup_department.Department', 'payroll_database_advance.*')
                ->orderBy('payroll_database_advance.id', 'DESC')
                ->get();
            return view('hris.database.advance.index', compact('advanceemp'));
        } else {
            return redirect()->back()->with('warning', getNotify(5));
        }
    }

    public function store()
    {
        if (getAccess('create')) {
            $userid = Sentinel::getUser()->id;
            $attributes = Input::all();
            $rules = [
                'EmployeeID' => 'required|numeric',
                'AdvanceDate' => 'required|date',
                'AdvanceAmount' => 'required|numeric',
                'ISize' => 'required|numeric',
                'AdvanceType' => 'required|numeric',
                'BalanceAmount' => 'numeric',
                'RefundStartFrom' => 'required|date',
                'Closed' => 'max:1',
                'Remarks' => 'max:20',
            ];
            $validation = Validator::make($attributes, $rules);
            if ($validation->fails()) {
                return redirect()->back()->with('error', getNotify(4))->withErrors($validation)->withInput();
            } else {
                $rfnddate = Carbon::parse($attributes['RefundStartFrom'])->startOfMonth()->format('Y-m-d');
                $enddate = Carbon::parse($attributes['RefundStartFrom'])->endOfMonth()->format('Y-m-d');
                $empchk = Employee::where('EmployeeID', $attributes['EmployeeID'])->where('ReasonID', 'N')->where('Salaried', 'Y')->where('JoiningDate', '<=', $enddate)->orWhere('LeavingDate', '>', $rfnddate)->where('EmployeeID', $attributes['EmployeeID'])->where('Salaried', 'Y')->where('JoiningDate', '<=', $enddate)->first();
                $empsal = EmployeeSalary::where('EmployeeID', $attributes['EmployeeID'])->pluck('GrossSalary')->first();
                if ($empsal && $empchk) {
                    if ($empsal > $attributes['ISize'] || $attributes['AdvanceAmount'] > $attributes['ISize']) {
                        $lastids = AdvanceLoan::orderBy('id', 'DESC')->first();
                        if ($lastids == null) {
                            $lastid = 1;
                        } elseif (substr($lastids->AdvanceID, 2, 2) == date("y")) {
                            $lastid = substr($lastids->AdvanceID, 4, 4) + 1;
                        } else {
                            $lastid = 1;
                        }
                        $adjustedid = str_pad($lastid, 4, "0", STR_PAD_LEFT);
                        $advanceid = 'AD' . date("y") . $adjustedid;

                        $advanceloan = new AdvanceLoan();
                        $advanceloan->fill($attributes);
                        $advanceloan->AdvanceID = $advanceid;
                        $advanceloan->CreatedBy = $userid;
                        $advanceloan->save();

                        \LogActivity::addToLog('Add Advance ' . $advanceid);
                        return redirect()->back()->with('success', getNotify(1));
                    } else {
                        return redirect()->back()->with('warning', 'Installment Amount Can Not Exceed Advance Amount Or Gross Salary');
                    }
                } else {
                    return redirect()->back()->with('warning', 'Employee Data Not Found');
                }
            }
        } else {
            return redirect()->back()->with('warning', getNotify(5));
        }
    }

    public function show(Request $request, $id)
    {
        if (getAccess('view')) {
            $uniqueloan = DB::table('payroll_database_advance')
                ->where('payroll_database_advance.id', $id)
                ->where('payroll_database_advance.Closed', 'N')
                ->leftJoin('hr_database_employee_basic as basic', 'payroll_database_advance.EmployeeID', '=', 'basic.EmployeeID')
                ->leftJoin('hr_setup_designation', 'basic.DesignationID', '=', 'hr_setup_designation.id')
                ->leftJoin('hr_setup_department', 'basic.DepartmentID', '=', 'hr_setup_department.id')
                ->select('basic.Name', 'hr_setup_designation.Designation', 'hr_setup_department.Department', 'payroll_database_advance.*')
                ->first();
            $advanceemp = DB::table('payroll_database_advance')
                ->where('payroll_database_advance.Closed', 'N')
                ->leftJoin('hr_database_employee_basic as basic', 'payroll_database_advance.EmployeeID', '=', 'basic.EmployeeID')
                ->leftJoin('hr_setup_designation', 'basic.DesignationID', '=', 'hr_setup_designation.id')
                ->leftJoin('hr_setup_department', 'basic.DepartmentID', '=', 'hr_setup_department.id')
                ->select('basic.Name', 'hr_setup_designation.Designation', 'hr_setup_department.Department', 'payroll_database_advance.*')
                ->orderBy('payroll_database_advance.id', 'DESC')
                ->get();
            $empsal = EmployeeSalary::where('EmployeeID', $uniqueloan->EmployeeID)->pluck('GrossSalary')->first();

            return view('hris.database.advance.show', compact('uniqueloan', 'advanceemp', 'empsal'));
        } else {
            return redirect()->back()->with('warning', getNotify(5));
        }
    }

    public function update($id)
    {
        if (getAccess('edit')) {
            $userid = Sentinel::getUser()->id;
            $attributes = Input::all();
            $advanceloan = AdvanceLoan::find($id);
            $rules = [
                'EmployeeID' => 'required|numeric',
                'AdvanceDate' => 'required|date',
                'AdvanceAmount' => 'required|numeric',
                'ISize' => 'required|numeric',
                'AdvanceType' => 'required|numeric',
                'BalanceAmount' => 'numeric',
                'RefundStartFrom' => 'required|date',
                'Closed' => 'max:1',
                'Remarks' => 'max:20',
            ];
            $validation = Validator::make($attributes, $rules);
            if ($validation->fails()) {
                return redirect()->back()->with('error', getNotify(4))->withErrors($validation)->withInput();
            } else {
                $empsal = EmployeeSalary::where('EmployeeID', $attributes['EmployeeID'])->pluck('GrossSalary')->first();
                if ($empsal) {
                    if ($empsal > $attributes['ISize'] || $attributes['AdvanceAmount'] > $attributes['ISize']) {
                        if ($attributes['CashRefund'] > 0) {
                            $balance = $attributes['BalanceAmount'] - $attributes['CashRefund'];
                        } else {
                            $balance = $attributes['BalanceAmount'];
                        }
                        $closed = $balance <= 0 ? 'Y' : 'N';

                        $advanceloan->fill($attributes);
                        $advanceloan->BalanceAmount = $balance;
                        $advanceloan->Closed = $closed;
                        $advanceloan->CreatedBy = $userid;
                        $advanceloan->updated_at = Carbon::now();
                        $advanceloan->save();

                        \LogActivity::addToLog('Update Advance ' . $advanceloan->AdvanceID);
                        if ($closed == 'N') {
                            return redirect()->action('HRIS\Database\AdvanceController@show', $id)->with('success', getNotify(1));
                        } else {
                            return redirect()->action('HRIS\Database\AdvanceController@index')->with('success', getNotify(1));
                        }
                    } else {
                        return redirect()->back()->with('warning', 'Installment Amount Can Not Exceed Advance Amount Or Gross Salary');
                    }
                } else {
                    return redirect()->back()->with('warning', 'Employee Data Not Found');
                }
            }
        } else {
            return redirect()->back()->with('warning', getNotify(5));
        }
    }

    public function destroy($id)
    {
        if (getAccess('delete')) {
            $advanceloan = AdvanceLoan::find($id);
            $advanceloan->delete();
            \LogActivity::addToLog('Delete Advance ' . $advanceloan->AdvanceID);
            return redirect()->back()->with('success', getNotify(1));
        } else {
            return redirect()->back()->with('warning', getNotify(5));
        }
    }

    public function getEmployeeInfo(Request $request)
    {
        $empl = DB::table('hr_database_employee_basic as basic')
            ->where('basic.EmployeeID', $request->emp_id)
            ->where('basic.Salaried', 'Y')
            ->leftJoin('hr_database_employee_salary', 'basic.EmployeeID', '=', 'hr_database_employee_salary.EmployeeID')
            ->leftJoin('hr_setup_designation', 'basic.DesignationID', '=', 'hr_setup_designation.id')
            ->leftJoin('hr_setup_department', 'basic.DepartmentID', '=', 'hr_setup_department.id')
            ->select('basic.id', 'basic.EmployeeID', 'basic.Name', 'hr_setup_designation.Designation', 'hr_setup_department.Department', 'basic.JoiningDate', 'hr_database_employee_salary.GrossSalary')
            ->orderBy('basic.EmployeeID', 'ASC')
            ->first();
        return response()->json($empl);
    }

}
