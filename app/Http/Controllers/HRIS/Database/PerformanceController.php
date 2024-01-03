<?php

namespace App\Http\Controllers\HRIS\Database;

use Sentinel;
use Validator;
use App\Models\User;
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
            $userid = Sentinel::getUser()->id;
            $deptlist = Department::whereRaw('FIND_IN_SET(?, company_id)', [getHostInfo()['id']])->orderBy('id', 'ASC')->get();
            $concerns = Company::where('id',getHostInfo()['id'])->where('C4S', 'Y')->get();
            return view('hris.database.performance.index', compact('deptlist', 'concerns'));
        } else {
            return redirect()->back()->with('warning', getNotify(5));
        }
    }

    public function show($id){
        $emp = Employee::where('EmployeeID', $id)->select('Name')->first();
        $performances = EmployeePerformance::where('EmployeeID', $id)->latest()->get();
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
            $employee = User::where('id',$performance->created_by)->first();
            $performanceDetails[] = [
                'created_by' => $employee->empid,
                'performance' => $performance,
                'details' => $details,
                'lastTotalTopicRating' => $lastTotalTopicRating,
                'lastTotalAchiveTopicRating' => $lastTotalAchiveTopicRating,
            ];
        }
        return view('hris.database.performance.show', compact('emp', 'performanceDetails','performances'));
    }
    public function store(Request $request)
    {
        if (getAccess('create')) {
            $roleid = Sentinel::getRoles();
            $roleName = $roleid[0]['slug'];
            $attributes = $request->all();
            $rules = [
                'deparmentSelect' => 'required',
                'employee' => 'required',
                'perf_date' => 'required',
            ];
            $validation = Validator::make($attributes, $rules);
            if ($validation->fails()) {
                return redirect()->back()->with(['error' => getNotify(4), 'error_code' => 'Add'])->withErrors($validation)->withInput();
            } else {
                // Extract the month and year from the date to check
                $dateParts =  $request->perf_date;
                // Check if data for the same month and year already exists
                $dataExists = EmployeePerformance::where('date', $dateParts)
                    ->where('EmployeeID', $request->employee)
                    ->where('evaluate_by',$roleName)
                    ->exists();
             
             
                if (!$dataExists) {      
                    $performances = EmployeePerformance::where('EmployeeID', $request->employee)->where('date', $dateParts)->count(); 
                    $step = "";
                    if($performances > 0){
                        $step = $performances+1;
                    }else{
                        $step = 1; 
                    }           
                    $userid = Sentinel::getUser()->id;
                    $employee = $request->employee;
                    $perf_date = $request->perf_date;
                    $remarks = $request->remarks;
    
                    $empPerformance = new EmployeePerformance();
                    $empPerformance->EmployeeID = $employee;
                    $empPerformance->date = $perf_date;
                    $empPerformance->remarks = $remarks;
                    $empPerformance->evaluate_by = $roleName;
                    $empPerformance->step = $step;
                    $empPerformance->created_by =  $userid;
                    $empPerformance->save();

                    foreach ($request->except(['_token', 'deparmentSelect', 'employee']) as $inputName => $rating) {
                        if (strpos($inputName, 'rating-') === 0) {
                            $itemId = substr($inputName, strlen('rating-'));
                            if (!is_null($rating)) {
                                $perDetails = new EmployeePerformanceDetails();
                                $perDetails->performance_id = $empPerformance->id;
                                $perDetails->appraisal_id = $itemId;
                                $perDetails->rating = $rating;
                                $perDetails->created_by = $userid;
                                $perDetails->save();
                            }
                        }
                    }
                    return redirect()->back()->with('success', getNotify(1));
                } else {
                    return redirect()->back()->with('warning', getNotify(6));
                }
            }
        } else {
            return redirect()->back()->with('warning', getNotify(5));
        }
    }
}
