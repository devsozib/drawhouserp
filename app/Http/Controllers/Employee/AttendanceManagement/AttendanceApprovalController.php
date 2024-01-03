<?php

namespace App\Http\Controllers\Employee\AttendanceManagement;

use Sentinel;
use Validator;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\HRIS\Database\AttendanceApproval;

class AttendanceApprovalController extends Controller
{

    public function attendanceApprovalForm(Request $request)
    {
        if (getAccess('view')) {
            $empid = Sentinel::getUser()->empid;
            $startdate = Carbon::now()->subDays(7)->startOfMonth()->format('Y-m-d');
            $enddate = Carbon::now()->endOfMonth()->format('Y-m-d');

            $attendanceApprovals = AttendanceApproval::join('hr_database_employee_basic', 'hr_database_employee_basic.EmployeeID', '=', 'hr_database_attn_approval.EmployeeID')
                ->leftJoin('hr_setup_designation', 'hr_database_employee_basic.DesignationID', '=', 'hr_setup_designation.id')
                ->whereBetween('effective_date', [$startdate, $enddate])
                ->whereIn('hr_database_attn_approval.company_id',getCompanyIds())
                ->select('hr_database_attn_approval.*','hr_database_employee_basic.Name','hr_setup_designation.Designation')
                ->get();

            if (!Sentinel::inRole('superadmin')) {
                $attendanceApprovals = $attendanceApprovals->where('hr_database_attn_approval.EmployeeID', $empid);
            }
            return view('employee.attendance_management.attendance_approval', compact('attendanceApprovals', 'empid'));
        } else {
            return redirect()->back()->with('warning', getNotify(5));
        }
    }

    public function store(Request $request)
    {
        if (getAccess('create')) {
            $rules = [
                'EmployeeID' => 'required|numeric',
                'typeOfRequest' => 'required|numeric',
                'effectiveDate' => 'required|date',
            ];
            $validation = Validator::make($request->all(), $rules);
            if ($validation->fails()) {
                return redirect()->back()->with('error', getNotify(4))->withErrors($validation)->withInput();
            } else {
                $attendanceApproval = new AttendanceApproval();
                $attendanceApproval->EmployeeID = $request->EmployeeID;
                $attendanceApproval->company_id = getHostInfo()['id'];
                $attendanceApproval->request_type = $request->typeOfRequest;
                $attendanceApproval->details = $request->details;
                $attendanceApproval->effective_date = $request->effectiveDate;
                $attendanceApproval->createdBy = Sentinel::getUser()->id;
                $attendanceApproval->save();

                \LogActivity::addToLog('Add Attendance Approval For '.$attendanceApproval->EmployeeID);
                return redirect()->back()->with('success', getNotify(1));
            }
        } else {
                return redirect()->back()->with('warning', getNotify(5));
        }
    }
}
