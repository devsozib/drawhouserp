<?php

namespace App\Http\Controllers;

use DB;
use Log;
use Sentinel;
use App\Models\Users;
use App\Models\Activating;
use Illuminate\Http\Request;
use App\Models\HRIS\Database\EmpUser;
use App\Models\HRIS\Database\EmpEntry;
use App\Models\HRIS\Database\Employee;
use Illuminate\Support\Facades\Config;
use App\Models\HRIS\Database\EmpGranter;
use App\Models\HRIS\Database\EmpTraining;
use App\Models\HRIS\Database\EmpEducation;
use App\Models\HRIS\Database\EmpInterview;
use App\Models\HRIS\Database\EmpReference;
use App\Models\HRIS\Database\EmpEmployment;
use App\Models\HRIS\Database\EmployeeSalary;
use App\Models\HRIS\Database\EmployeePersonal;
use App\Models\HRIS\Database\EmployeeTraining;
use App\Models\HRIS\Database\EmployeeEducation;
use App\Models\HRIS\Database\EmployeeReference;
use App\Models\HRIS\Database\EmployeeExperience;
use App\Models\HRIS\Database\EmployeePerformance;
use App\Models\HRIS\Database\EmpInterviewFeedback;
use Cartalyst\Sentinel\Laravel\Facades\Activation;

class DBMigrationController extends Controller
{
    public function index()
    {
        // return  "okk";
        // $host = request()->getHost();
        // $d = Config::get("rmconf.$host") ?? Config::get("rmconf.default");
        // _print($d);
        // testMail();
        //sendMail();

        // ========================================== //

        DB::beginTransaction();
        try {
            $data_arr = array();
            $old_emp = Employee::pluck('EmployeeID');
            $users = DB::connection('mysql2')->table('users')->get();
            $lastid = Users::orderBy('id','DESC')->pluck('id')->first() + 1;
            foreach($users as $user) {
                $chk = Users::where('email',$user->email)->first();
                if(!$chk) {
                    $sdata = new Users();
                    $sdata->fill(collect($user)->toArray());
                    $sdata->id = $lastid;
                    $sdata->save();

                    $useract = Sentinel::findById($sdata->id);
                    Activation::create($useract);
                    Activating::where('user_id',$sdata->id)->update(['completed'=>1]);

                    $lastid++;
                }else{
                    $data_arr['Users'][] = $user->empid;
                }
            }

            $users = DB::connection('mysql2')->table('hr_database_employee_basic')->get();
            $lastid = Employee::orderBy('id','DESC')->pluck('id')->first() + 1;
            foreach($users as $user) {
                $chk = Employee::where('EmployeeID',$user->EmployeeID)->first();
                if(!$chk) {
                    $sdata = new Employee();
                    $sdata->fill(collect($user)->toArray());
                    $sdata->id = $lastid;
                    $sdata->save();

                    $lastid++;
                }else{
                    $data_arr['Employee'][] = $user->EmployeeID;
                }
            }

            $users = DB::connection('mysql2')->table('hr_database_employee_salary')->get();
            $lastid = EmployeeSalary::orderBy('id','DESC')->pluck('id')->first() + 1;
            foreach($users as $user) {
                $chk = EmployeeSalary::where('EmployeeID',$user->EmployeeID)->first();
                if(!$chk) {
                    $sdata = new EmployeeSalary();
                    $sdata->fill(collect($user)->toArray());
                    $sdata->id = $lastid;
                    $sdata->save();

                    $lastid++;
                }else{
                    $data_arr['EmployeeSalary'][] = $user->EmployeeID;
                }
            }

            $users = DB::connection('mysql2')->table('hr_database_employee_personal')->get();
            $lastid = EmployeePersonal::orderBy('id','DESC')->pluck('id')->first() + 1;
            foreach($users as $user) {
                $chk = EmployeePersonal::where('EmployeeID',$user->EmployeeID)->first();
                if(!$chk) {
                    $sdata = new EmployeePersonal();
                    $sdata->fill(collect($user)->toArray());
                    $sdata->id = $lastid;
                    $sdata->save();

                    $lastid++;
                }else{
                    $data_arr['EmployeePersonal'][] = $user->EmployeeID;
                }
            }

            $users = DB::connection('mysql2')->table('hr_database_employee_reference')->get();
            $lastid = EmployeeReference::orderBy('id','DESC')->pluck('id')->first() + 1;
            foreach($users as $user) {
                if(!in_array($user->EmployeeID,$old_emp->toArray())){

                    $sdata = new EmployeeReference();
                    $sdata->fill(collect($user)->toArray());
                    $sdata->id = $lastid;
                    $sdata->save();

                    $lastid++;
                }else{
                    $data_arr['EmployeeReference'][] = $user->EmployeeID;
                }
            }

            $users = DB::connection('mysql2')->table('hr_database_education')->get();
            $lastid = EmployeeEducation::orderBy('id','DESC')->pluck('id')->first() + 1;
            foreach($users as $user) {
                $chk = EmployeeEducation::where('EmployeeID',$user->EmployeeID)->first();

                if(!in_array($user->EmployeeID,$old_emp->toArray())){

                    $sdata = new EmployeeEducation();
                    $sdata->fill(collect($user)->toArray());
                    $sdata->id = $lastid;
                    $sdata->save();

                    $lastid++;
                }else{
                    $data_arr['EmployeeEducation'][] = $user->EmployeeID;
                }
            }

            $users = DB::connection('mysql2')->table('hr_database_experience')->get();
            $lastid = EmployeeExperience::orderBy('id','DESC')->pluck('id')->first() + 1;
            foreach($users as $user) {
                $chk = EmployeeExperience::where('EmployeeID',$user->EmployeeID)->first();
                if(!in_array($user->EmployeeID,$old_emp->toArray())){

                    $sdata = new EmployeeExperience();
                    $sdata->fill(collect($user)->toArray());
                    $sdata->id = $lastid;
                    $sdata->save();

                    $lastid++;
                }else{
                    $data_arr['EmployeeExperience'][] = $user->EmployeeID;
                }
            }

            $users = DB::connection('mysql2')->table('hr_database_training')->get();
            $lastid = EmployeeTraining::orderBy('id','DESC')->pluck('id')->first() + 1;
            foreach($users as $user) {
                $chk = EmployeeTraining::where('EmployeeID',$user->EmployeeID)->first();
                if(!in_array($user->EmployeeID,$old_emp->toArray())){

                    $sdata = new EmployeeTraining();
                    $sdata->fill(collect($user)->toArray());
                    $sdata->id = $lastid;
                    $sdata->save();

                    $lastid++;
                }else{
                    $data_arr['EmployeeTraining'][] = $user->EmployeeID;
                }
            }

            $users = DB::connection('mysql2')->table('hr_database_employee_performance')->get();
            $lastid = EmployeePerformance::orderBy('id','DESC')->pluck('id')->first() + 1;
            foreach($users as $user) {
                if(!in_array($user->emp_id,$old_emp->toArray())){

                    $sdata = new EmployeePerformance();

                    $sdata->fill(collect($user)->toArray());
                    $sdata->id = $lastid;
                    $sdata->save();

                    $lastid++;
                }else{
                    $data_arr['EmployeePerformance'][] = $user->emp_id;
                }
            }

            $users = DB::connection('mysql2')->table('hr_database_emp_education')->get();
            $lastid = EmpEducation::orderBy('id','DESC')->pluck('id')->first() + 1;
            foreach($users as $user) {
                if(!in_array($user->emp_id,$old_emp->toArray())){

                    $sdata = new EmpEducation();
                    $sdata->fill(collect($user)->toArray());
                    $sdata->id = $lastid;
                    $sdata->save();

                    $lastid++;
                }else{
                    $data_arr['EmpEducation'][] = $user->emp_id;
                }
            }

            $users = DB::connection('mysql2')->table('hr_database_emp_experience')->get();
            $lastid = EmpEmployment::orderBy('id','DESC')->pluck('id')->first() + 1;
            foreach($users as $user) {
                if(!in_array($user->emp_id,$old_emp->toArray())){

                    $sdata = new EmpEmployment();
                    $sdata->fill(collect($user)->toArray());
                    $sdata->id = $lastid;
                    $sdata->save();

                    $lastid++;
                }else{
                    $data_arr['EmpEmployment'][] = $user->emp_id;
                }
            }

            $users = DB::connection('mysql2')->table('hr_database_emp_entry')->get();
            $lastid = EmpEntry::orderBy('id','DESC')->pluck('id')->first() + 1;
            foreach($users as $user) {
                if(!in_array($user->EmployeeID,$old_emp->toArray())){

                    $sdata = new EmpEntry();
                    $sdata->fill(collect($user)->toArray());
                    $sdata->id = $lastid;
                    $sdata->save();

                    $lastid++;
                }else{
                    $data_arr['EmpEntry'][] = $user->EmployeeID;
                }
            }

            // $users = DB::connection('mysql2')->table('hr_database_emp_users')->get();
            // $lastid = EmpUser::orderBy('id','DESC')->pluck('id')->first() + 1;
            // foreach($users as $user) {
            //     // return $user;
            //     if(!in_array($user->EmployeeID,$old_emp->toArray())){

            //         $sdata = new EmpUser();
            //         $sdata->fill(collect($user)->toArray());
            //         $sdata->id = $lastid;
            //         $sdata->save();

            //         $lastid++;
            //     }else{
            //         $data_arr['EmpUser'][] = $user->EmployeeID;
            //     }
            // }

            $users = DB::connection('mysql2')->table('hr_database_emp_granter')->get();
            $lastid = EmpGranter::orderBy('id','DESC')->pluck('id')->first() + 1;
            foreach($users as $user) {
                if(!in_array($user->EmployeeID,$old_emp->toArray())){

                    $sdata = new EmpGranter();
                    $sdata->fill(collect($user)->toArray());
                    $sdata->id = $lastid;
                    $sdata->save();

                    $lastid++;
                }else{
                    $data_arr['EmpGranter'][] = $user->EmployeeID;
                }
            }

            $users = DB::connection('mysql2')->table('hr_database_emp_training')->get();
            $lastid = EmpTraining::orderBy('id','DESC')->pluck('id')->first() + 1;
            foreach($users as $user) {
                if(!in_array($user->emp_id,$old_emp->toArray())){

                    $sdata = new EmpTraining();
                    $sdata->fill(collect($user)->toArray());
                    $sdata->id = $lastid;
                    $sdata->save();

                    $lastid++;
                }else{
                    $data_arr['EmpTraining'][] = $user->emp_id;
                }
            }

            $users = DB::connection('mysql2')->table('hr_database_emp_reference')->get();
            $lastid = EmpReference::orderBy('id','DESC')->pluck('id')->first() + 1;
            foreach($users as $user) {
                if(!in_array($user->emp_id,$old_emp->toArray())){

                    $sdata = new EmpReference();
                    $sdata->fill(collect($user)->toArray());
                    $sdata->id = $lastid;
                    $sdata->save();

                    $lastid++;
                }else{
                    $data_arr['EmpReference'][] = $user->emp_id;
                }
            }

            $users = DB::connection('mysql2')->table('hr_database_emp_interview')->get();
            $lastid = EmpInterview::orderBy('id','DESC')->pluck('id')->first() + 1;
            foreach($users as $user) {
                if(!in_array($user->emp_id,$old_emp->toArray())){

                    $sdata = new EmpInterview();
                    $sdata->fill(collect($user)->toArray());
                    $sdata->id = $lastid;
                    $sdata->save();

                    $lastid++;
                }else{
                    $data_arr['EmpInterview'][] = $user->emp_id;
                }
            }

            $users = DB::connection('mysql2')->table('hr_database_emp_interview_feedback')->get();
            $lastid = EmpInterviewFeedback::orderBy('id','DESC')->pluck('id')->first() + 1;
            foreach($users as $user) {
                if(!in_array($user->emp_id,$old_emp->toArray())){
                    $sdata = new EmpInterviewFeedback();
                    $sdata->fill(collect($user)->toArray());
                    $sdata->id = $lastid;
                    $sdata->save();

                    $lastid++;
                }else{
                    $data_arr['EmpInterviewFeedback'][] = $user->emp_id;
                }
            }

            DB::commit();
            _print($data_arr);

            // $roleName =  Sentinel::getUser()->roles[0]->name ?? null;
            // if ($roleName == 'General') {
            //     return redirect()->route('employee.dashboard');
            // } else {
            //     return view('welcome')->with('active', 'welcome');
            // }


        } catch (\Exception $e) {
            DB::rollBack();
            return "EXCEPTION  =>>  ".$e->getMessage();
            Log::error('Transaction failed: ' . $e->getMessage());
        }

        // ========================================== //



    }
}

/*

$obj = new User;; // users
        $obj = new Employee;; // hr_database_employee_basic
        $obj = new EmployeeSalary;; // hr_database_employee_salary
        $obj = new EmployeePersonal;; // hr_database_employee_personal
        $obj = new EmployeeReference;; // hr_database_employee_reference
        $obj = new EmployeeEducation;; // hr_database_education
        $obj = new EmployeeExperience;; // hr_database_experience
        $obj = new EmployeeTraining;; // hr_database_training
        $obj = new EmployeePerformance;; // hr_database_employee_performance
        $obj = new EmpEducation;; // hr_database_emp_education
        $obj = new EmpEmployment;; // hr_database_emp_experience
        $obj = new EmpEntry;; // hr_database_emp_entry
        $obj = new EmpUser;; // hr_database_emp_users
        $obj = new EmpGranter;; // hr_database_emp_granter
        $obj = new EmpTraining;; // hr_database_emp_training
        $obj = new EmpReference;; // hr_database_emp_reference
        $obj = new EmpInterview;; // hr_database_emp_interview
        $obj = new EmpInterviewFeedback; // hr_database_emp_interview_feedback

        */



