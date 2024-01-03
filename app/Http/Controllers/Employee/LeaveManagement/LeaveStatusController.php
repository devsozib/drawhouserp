<?php

namespace App\Http\Controllers\Employee\LeaveManagement;

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
                ->orderBy('basic.DepartmentID', 'DESC')
                ->orderBy('basic.EmployeeID', 'DESC')
                ->orderBy('lvapp.id', 'DESC')
                ->get();

            return view('employee.leave_management.leavestatus.index', compact('leavetypelist', 'reasonlist', 'leavedatas'));
        } else {
            return redirect()->back()->with('warning', getNotify(5));
        }
    }
}
