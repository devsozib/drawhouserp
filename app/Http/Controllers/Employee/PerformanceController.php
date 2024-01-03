<?php

namespace App\Http\Controllers\Employee;

use Sentinel;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\HRIS\Database\Concern;
use App\Models\HRIS\Setup\Department;
use App\Models\HRIS\Database\Employee;
use App\Models\HRIS\Setup\JobAppraisal;
use App\Models\Library\General\Company;
use Illuminate\Support\Facades\Session;
use App\Models\HRIS\Database\EmployeePerformance;
use App\Models\HRIS\Database\EmployeePerformanceDetails;

class PerformanceController extends Controller
{
    public function index()
    {
        if (getAccess('view')) {
            $emp_id = Sentinel::getUser()->empid;
            $emp = Employee::where('EmployeeID', $emp_id)->select('Name')->first();
            $performances = EmployeePerformance::where('EmployeeID', $emp_id)->latest()->get();
            $performanceDetails = [];
            $lastTotalTopicRating = "";
            $lastTotalAchiveTopicRating = "";
            
            foreach ($performances as $performance) {
                $details = EmployeePerformanceDetails::join('hr_setup_job_appraisals as topic', 'topic.id', '=', 'hr_database_employee_perfor_details.appraisal_id')
                    ->where('hr_database_employee_perfor_details.performance_id', $performance->id)
                    ->select('hr_database_employee_perfor_details.*', 'topic.name')
                    ->get();
                
                $lastTotalTopicRating = EmployeePerformanceDetails::where('performance_id', $performance->id)->count() * 5;
                $lastTotalAchiveTopicRating = EmployeePerformanceDetails::where('performance_id', $performance->id)->sum('rating');                
                $performanceDetails[] = [               
                    'performance' => $performance,
                    'details' => $details,
                    'lastTotalTopicRating' => $lastTotalTopicRating,
                    'lastTotalAchiveTopicRating' => $lastTotalAchiveTopicRating,
                ];
            }
            // return $performanceDetails;
            return view('employee.performance.index', compact('performanceDetails', 'lastTotalTopicRating', 'lastTotalAchiveTopicRating','performance'));
        } else {
            return redirect()->back()->with('warning', getNotify(5));
        }
    }
}
