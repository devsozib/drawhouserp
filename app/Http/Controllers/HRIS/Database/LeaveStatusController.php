<?php

namespace App\Http\Controllers\HRIS\Database;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\HRIS\Database\Employee;
use App\Models\HRIS\Database\EmployeePersonal;
use App\Models\HRIS\Setup\Department;
use App\Models\HRIS\Setup\Designation;
use App\Models\HRIS\Setup\LeaveDefinitions;
use App\Models\HRIS\Setup\LeaveReasons;
use App\Models\HRIS\Database\LeaveApplication;
use App\Models\HRIS\Database\LeaveIndividual;
use App\Models\HRIS\Tools\ForwardPermission;
use App\Models\HRIS\Tools\ApprovePermission;
use App\Models\HRIS\Tools\HROptions;
use App\Models\Users;
use Input;
use Validator;
use Flash;
use Carbon\Carbon;
use Redirect;
use Sentinel;
use DB;

class LeaveStatusController extends Controller
{
    public function index(Request $request)
    {
        if (getAccess('view')) {
            $userid = Sentinel::getUser()->id;
            $leavetypelist = LeaveDefinitions::orderBy('id', 'ASC')->where('C4S', 'Y')->pluck('Description', 'TypeID');
            $reasonlist = LeaveReasons::orderBy('id', 'ASC')->where('C4S', 'Y')->pluck('Reason', 'id');
            $startdate = Carbon::now()->subDays(2)->startOfMonth()->format('Y-m-d');
            $enddate = Carbon::now()->addMonth(2)->endOfMonth()->format('Y-m-d');
            if (Sentinel::inRole('superadmin')) {
                $leaveid = LeaveApplication::orderBy('id', 'DESC')->whereBetween('StartDate', [$startdate, $enddate])->pluck('id');
            } else {
                $uempid = Sentinel::getUser()->empid;
                $forwardid = ForwardPermission::orderBy('EmployeeID', 'ASC')->where('UserID', $userid)->pluck('EmployeeID')->toArray();
                $approveid = ApprovePermission::orderBy('EmployeeID', 'ASC')->where('UserID', $userid)->pluck('EmployeeID')->toArray();
                $permids = array_merge($forwardid, $approveid);
                $leaveid = LeaveApplication::orderBy('id', 'DESC')->whereIn('EmployeeID', $permids)->whereBetween('StartDate', [$startdate, $enddate])->orWhere('EmployeeID', $uempid)->whereBetween('StartDate', [$startdate, $enddate])->pluck('id');
            }
            $leavedatas = DB::table('hr_database_leave_application as lvapp')
                ->whereIn('lvapp.id', $leaveid)
                ->leftJoin('hr_database_employee_basic as basic', 'basic.EmployeeID', '=', 'lvapp.EmployeeID')
                ->leftJoin('hr_setup_designation', 'basic.DesignationID', '=', 'hr_setup_designation.id')
                ->leftJoin('hr_setup_department', 'basic.DepartmentID', '=', 'hr_setup_department.id')
                ->select('lvapp.*', 'basic.EmployeeID', 'basic.Name', 'basic.JoiningDate', 'hr_setup_designation.Designation', 'hr_setup_department.Department')
                ->orderBy('basic.DepartmentID', 'ASC')
                ->orderBy('basic.EmployeeID', 'ASC')
                ->orderBy('lvapp.id', 'ASC')
                ->get();

            return view('hris.database.leavestatus.index', compact('leavetypelist', 'reasonlist', 'leavedatas'));
        } else {
            return redirect()->back()->with('warning', getNotify(5));
        }
    }

    public function getLeaveStatus(Request $request, $id)
    {
        if (getAccess('edit')) {
            $userid = Sentinel::getUser()->id;
            if ($request->form_id == 1) {
                $result = LeaveApplication::find($id);
                $result->IsForwarded = $result->IsForwarded == 'N' ? 'Y' : 'N';
                $result->ForwardedDate = Carbon::now()->format('Y-m-d');
                $result->ForwardedBy = $userid;
                $result->updated_at = Carbon::now();
                $result->save();
                \LogActivity::addToLog('Leave Forward For Employee '.$result->EmployeeID.' & Form ID '.$result->FormID);
                return response()->json(array('result' => 'success', 'changed' => ($result->IsForwarded == 'Y') ? 1 : 0));
            } elseif ($request->form_id == 2) {
                $result = LeaveApplication::find($id);
                $result->IsApproved = $result->IsApproved == 'N' ? 'Y' : 'N';
                $result->ApprovedDate = Carbon::now()->format('Y-m-d');
                $result->ApprovedBy = $userid;
                $result->updated_at = Carbon::now();
                $result->save();

                if ($result->IsApproved == 'Y') {
                    $lastids = LeaveIndividual::orderBy('id', 'DESC')->pluck('LeaveID')->first();
                    if ($lastids == null) {
                        $lastid = 1;
                    } elseif (substr($lastids, 2, 2) == date("y")) {
                        $lastid = substr($lastids, 4, 6) + 1;
                    } else {
                        $lastid = 1;
                    }
                    $adjustedid = str_pad($lastid, 6, "0", STR_PAD_LEFT);
                    $leaveid = 'LV' . date("y") . $adjustedid;

                    $employee = new LeaveIndividual();
                    $employee->LeaveID = $leaveid;
                    $employee->EmployeeID = $result->EmployeeID;
                    $employee->LeaveTypeID = $result->LeaveTypeID;
                    $employee->ApplicationDate = $result->ApplicationDate;
                    $employee->InputDate = $result->ApplicationDate;
                    $employee->StartDate = $result->StartDate;
                    $employee->EndDate = $result->EndDate;
                    $employee->FormID = $result->FormID;
                    $employee->CreatedBy = $userid;
                    $employee->save();
                } else {
                    $employee = LeaveIndividual::where('FormID', $result->FormID)->delete();
                }

                \LogActivity::addToLog('Leave Approve For Employee '.$result->EmployeeID.' & Form ID '.$result->FormID);
                return response()->json(array('result' => 'success', 'changed' => ($result->IsApproved == 'Y') ? 1 : 0));
            } else {
                return response()->json(array('result' => 'warning'));
            }
        }
    }
}
