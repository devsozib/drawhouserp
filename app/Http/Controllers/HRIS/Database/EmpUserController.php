<?php

namespace App\Http\Controllers\HRIS\Database;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\HRIS\Database\EmpUser;
use App\Models\HRIS\Database\EmpEntry;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

use Sentinel;

class EmpUserController extends Controller
{
    public function showLoginForm(Request $request)
    {
        if (Auth::guard('empuser')->check()) {
            return redirect()->route('careers');
        }
        return view('hris.database.empuser.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        if (Auth::guard('empuser')->attempt($credentials)) {
            if ($request->session()->has('redirect_to_apply_job')) {
                $jobId = $request->session()->get('redirect_to_apply_job');
                return redirect()->route('apply.job', ['id' => $jobId]);
            } else if($request->session()->has('redirect_to_apply_job_manually')){
                return redirect()->route('apply.job.manually');
            } else {
                return redirect()->route('careers');
            }
        } else {
            return redirect()->back()->withErrors(['error' => 'Invalid credentials']);
        }
    }

    public function switchAccount(Request $request){
        $user = User::where('empid', $request->employee_id)->first();
        if($user){
            $user = Sentinel::findById($user->id);
            if($user){
                Sentinel::logout();
                Sentinel::login($user);
            }
        }
        return redirect()->route('pos.dashboard');
    }

    public function showRegistrationForm()
    {
        if (Auth::guard('empuser')->check()) {
            return redirect()->route('careers');
        }
        return view('hris.database.empuser.register');
    }

    public function register(Request $request)
    {
        $formdata = array(
            'name'             =>  $request->get('name'),
            'email'            =>  $request->get('email'),
            'password'         => $request->get('password'),
        );
        $rules = array(
            'name'              => 'required|min:6',
            'email'             => 'required|email|unique:hr_database_emp_users,email',
            'password'          => 'required|min:6',
        );
        $validation = Validator::make($formdata, $rules);
        if ($validation->fails()) {
            return redirect()->back()->with('error', getNotify(4))->withErrors($validation)->withInput();
        } else {
            $emp_user = EmpUser::create([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'company_id' => Auth::guard('empuser')->user()->company_id,
                'password' => bcrypt($request->input('password')),
                'status' => '1',
            ]);
            Auth::guard('empuser')->login($emp_user);
            if ($request->session()->has('redirect_to_apply_job')) {
                $jobId = $request->session()->get('redirect_to_apply_job');
                // Clear the "redirect_to_apply_job" value from the session
                $request->session()->forget('redirect_to_apply_job');
               
                // Redirect the user to the "apply-job" route with the job ID
                return redirect()->route('apply.job', ['id' => $jobId]);
            } else if($request->session()->has('redirect_to_apply_job_manually')){
                $request->session()->forget('redirect_to_apply_job_manually');
                return redirect()->route('apply.job.manually');
            } else {
                return redirect()->route('careers');
            }
        }
    }

    public function logout(Request $request)
    {
        Auth::guard('empuser')->logout();

        // $request->session()->invalidate();

        // $request->session()->regenerateToken();

        return redirect('/empuser/login');
    }
    public function profile($id)
    {
        $exists = EmpEntry::where('emp_user_id', $id)->exists();
        $empUserInfo = '';
        $appliedJobs = '';
        if ($exists) {
            $empUserInfo = DB::table('hr_database_emp_users as user')
                ->join('hr_database_emp_entry as emp', 'emp.emp_user_id', '=', 'user.id')
                ->leftJoin('hr_setup_jobs as job', 'emp.job_id', '=', 'job.id')
                ->leftJoin('hr_setup_designation as job_dsg', 'job_dsg.id', '=', 'job.desg_id') 
                ->leftJoin('hr_setup_designation as emp_dsg', 'emp_dsg.id', '=', 'emp.designation_id') 
                ->leftJoin('hr_setup_department as dept', 'dept.id', '=', 'job.dept_id')
                ->join('lib_company as concern', 'concern.id', '=', 'user.company_id')
                ->leftJoin('hr_setup_districts as prsnt_dis', 'prsnt_dis.id', '=', 'emp.prsnt_district_id')
                ->leftJoin('hr_setup_districts as par_dis', 'par_dis.id', '=', 'emp.par_district_id')
                ->leftJoin('hr_setup_thanas as prsnt_thna', 'prsnt_thna.id', '=', 'emp.prsnt_thana_id')
                ->leftJoin('hr_setup_thanas as par_thna', 'par_thna.id', '=', 'emp.par_thana_id')
                ->select('emp.id as emp_id', 'user.name', 'emp.MobileNo', 'user.email', 'emp.NationalIDNo', 'dept.Department', 'job_dsg.Designation as job_designation','emp_dsg.Designation as emp_designation', 'emp.experience', 'emp.especality', 'prsnt_dis.Name as prsnt_dis', 'par_dis.Name as par_dis', 'prsnt_thna.Name as prsnt_thana', 'emp.prsnt_post_office', 'emp.prsnt_local_add',  'par_thna.Name as par_thana', 'emp.par_post_office', 'emp.par_local_add', 'emp.gender', 'emp.d_o_b', 'emp.nationality', 'emp.cvfile', 'emp.nidfile', 'emp.status', 'emp.interview_status', 'emp.image')
                ->where('emp.emp_user_id', $id)
                ->first();
            $appliedJobs = DB::table('hr_database_emp_users as user')
                ->join('hr_database_emp_entry as emp', 'emp.emp_user_id', '=', 'user.id')
                ->leftJoin('hr_setup_jobs as job', 'emp.job_id', '=', 'job.id')
                ->leftJoin('hr_setup_designation as job_dsg', 'job_dsg.id', '=', 'job.desg_id') 
                ->leftJoin('hr_setup_designation as emp_dsg', 'emp_dsg.id', '=', 'emp.designation_id') 
                ->leftJoin('hr_setup_department as dept', 'dept.id', '=', 'job.dept_id')
                ->join('lib_company as concern', 'concern.id', '=', 'user.company_id')
                ->leftJoin('hr_setup_districts as prsnt_dis', 'prsnt_dis.id', '=', 'emp.prsnt_district_id')
                ->leftJoin('hr_setup_districts as par_dis', 'par_dis.id', '=', 'emp.par_district_id')
                ->leftJoin('hr_setup_thanas as prsnt_thna', 'prsnt_thna.id', '=', 'emp.prsnt_thana_id')
                ->leftJoin('hr_setup_thanas as par_thna', 'par_thna.id', '=', 'emp.par_thana_id')
                ->select('emp.id as emp_id', 'user.name', 'emp.MobileNo', 'user.email', 'emp.NationalIDNo', 'dept.Department', 'job_dsg.Designation as job_designation','emp_dsg.Designation as emp_designation', 'emp.experience', 'emp.especality', 'prsnt_dis.Name as prsnt_dis', 'par_dis.Name as par_dis', 'prsnt_thna.Name as prsnt_thana', 'emp.prsnt_post_office', 'emp.prsnt_local_add',  'par_thna.Name as par_thana', 'emp.par_post_office', 'emp.par_local_add', 'emp.gender', 'emp.d_o_b', 'emp.nationality', 'emp.cvfile', 'emp.nidfile', 'emp.status', 'emp.interview_status')
                ->where('emp.emp_user_id', $id)
                ->get();
            return view('hris.career.profile', compact('empUserInfo', 'appliedJobs'));
        } else {
            $empUser = EmpUser::where('id', $id)->where('status', '1')->first();
            return view('hris.career.profile', compact('empUser', 'empUserInfo'));
        }
    }
}
