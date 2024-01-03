<?php

namespace App\Http\Controllers\HRIS\Applicant;

use Sentinel;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\HRIS\Setup\Job;
use App\Models\HRIS\Setup\Degrees;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\HRIS\Setup\Districts;
use App\Models\HRIS\Setup\Religions;
use Illuminate\Support\Facades\Auth;
use App\Models\HRIS\Database\Concern;
use App\Models\HRIS\Database\EmpUser;
use App\Models\HRIS\Setup\Department;
use App\Models\HRIS\Database\EmpEntry;
use App\Models\HRIS\Setup\Designation;
use App\Models\Library\General\Company;
use Illuminate\Support\Facades\Session;
use App\Models\HRIS\Database\EmpGranter;
use App\Models\HRIS\Database\EmpTraining;
use App\Models\HRIS\Setup\EducationBoard;
use App\Models\HRIS\Database\EmpEducation;
use App\Models\HRIS\Database\EmpInterview;
use App\Models\HRIS\Database\EmpReference;
use App\Models\HRIS\Database\EmpEmployment;
use App\Models\HRIS\Database\EmpInterviewFeedback;
use App\Models\Library\ProductManagement\IngredientCategory;

class InterviewController extends Controller
{
    public function careerIndex()
    {
        $jobs = Job::join('lib_company', 'hr_setup_jobs.company_id', '=', 'lib_company.id')
            ->join('hr_setup_department', 'hr_setup_jobs.dept_id', '=', 'hr_setup_department.id')
            ->join('hr_setup_designation', 'hr_setup_jobs.desg_id', '=', 'hr_setup_designation.id')
            ->select('hr_setup_jobs.*', 'lib_company.Name', 'hr_setup_department.Department', 'hr_setup_designation.Designation')
            ->get();
        return view('hris.career.career', compact('jobs'));
    }
    public function applyJob($jobId)
    {
        if (auth()->guard('empuser')->check()) {
            $id = decrypt($jobId);
            $districtlist = Districts::orderBy('id', 'ASC')->get();
            $degrees = Degrees::orderBy('id', 'ASC')->where('C4S', 'Y')->get();
            $boards = EducationBoard::orderBy('id', 'ASC')->where('C4S', 'Y')->get();
            $concerns = Company::where('C4S', 'Y')->get();
            $religionlist = Religions::orderBy('id', 'ASC')->get();
            $getImage = EmpEntry::where('emp_user_id', Auth::guard('empuser')->user()->id)->select('image')->first();
            $job = Job::join('lib_company', 'hr_setup_jobs.company_id', '=', 'lib_company.id')
                ->join('hr_setup_department', 'hr_setup_jobs.dept_id', '=', 'hr_setup_department.id')
                ->join('hr_setup_designation', 'hr_setup_jobs.desg_id', '=', 'hr_setup_designation.id')
                ->select('hr_setup_jobs.*', 'lib_company.Name', 'hr_setup_department.Department', 'hr_setup_designation.Designation')
                ->where('hr_setup_jobs.id', $id)
                ->first();
            return view('hris.career.index', compact('districtlist', 'degrees', 'boards', 'boards', 'religionlist', 'getImage', 'job', 'id'));
        } else {
            session(['redirect_to_apply_job' => $jobId]);
            return redirect()->route('empuser.login');
        }
    }
    // public function applyJob($id)
    // {

    //     $id;
    //     $branches = Company::orderBy('id', 'ASC')->where('C4S', 'Y')->get();
    //     $desglists = Designation::orderBy('id', 'ASC')->where('C4S', 'Y')->get();
    //     $deptlists = Department::orderBy('id', 'ASC')->where('C4S', 'Y')->get();
    //     $districtlist = Districts::orderBy('id', 'ASC')->get();
    //     $degrees = Degrees::orderBy('id', 'ASC')->where('C4S', 'Y')->get();
    //     $boards = EducationBoard::orderBy('id', 'ASC')->where('C4S', 'Y')->get();
    //     $concerns = Company::where('C4S', 'Y')->get();
    //     $religionlist = Religions::orderBy('id', 'ASC')->get();
    //     $getImage = EmpEntry::where('emp_user_id', Auth::guard('empuser')->user()->id)->select('image')->first();
    //     return view('hris.career.index', compact('desglists', 'concerns', 'deptlists', 'districtlist', 'degrees', 'boards', 'boards', 'religionlist', 'getImage'));
    // }
    public function applyPost(Request $request)
    {
        // return $request;
        // Personal Information
        $job_id =  $request->job_id;
        $experience =  $request->experience;
        $especality =  $request->especality;
        $name =  $request->name;
        $d_o_b =  $request->d_o_b;
        $gender =  $request->gender;
        $material_status =  $request->material_status;
        $nationality =  $request->nationality;
        $religion =  $request->religion;
        $n_id =  $request->n_id;
        $phone =  $request->phone;
        $email =  $request->email;
        // Address Info
        $prsnt_district =  $request->prsnt_district;
        $prsnt_thana =  $request->prsnt_thana;
        $prsnt_post_office =  $request->prsnt_post_office;
        $prsnt_local_add =  $request->prsnt_local_add;
        $par_district =  $request->par_district;
        $par_thana =  $request->par_thana;
        $par_post_office =  $request->par_post_office;
        $par_local_add =  $request->par_local_add;
        // Granter
        $g_name =  $request->g_name;
        $g_occupation =  $request->g_occupation;
        $g_organization =  $request->g_organization;
        $g_org_add =  $request->g_org_add;
        $g_phone =  $request->g_phone;
        $g_email =  $request->g_email;
        $g_relation =  $request->g_relation;
        // Education info
        $degrees =  $request->degree;
        $edu_institutes =  $request->edu_institute;
        $boards =  $request->board;
        $result_types =  $request->result_type;
        $obt_results = $request->obt_result;
        $passing_years =  $request->passing_year;
        // // Training Info
        $training_title =  $request->training_title;
        $tr_country =  $request->tr_country;
        $topic_coverd =  $request->topic_coverd;
        $training_year =  $request->training_year;
        $tr_institute =  $request->tr_institute;
        $tr_duration =  $request->tr_duration;
        $tr_location =  $request->tr_location;
        // Experience Info
        $exp_designation =  $request->exp_designation;
        $organization =  $request->organization;
        $responsibilities =  $request->responsibilities;
        $from_date =  $request->from_date;
        $to_date =  $request->to_date;
        //Reference
        $r_name =  $request->r_name;
        $r_occupation =  $request->r_occupation;
        $r_organization =  $request->r_organization;
        $r_org_add =  $request->r_org_add;
        $r_phone =  $request->r_phone;
        $r_email =  $request->r_email;
        $r_relation =  $request->r_relation;

        // Files

        $cvfileupload =  $request->cvfileupload;
        $nidfileupload =  $request->nidfileupload;
        $vac_certificate =  $request->vac_certificate;

        $checkEmp = EmpEntry::where('emp_user_id', Auth::guard('empuser')->user()->id)->where('job_id', $job_id)->first();
        if (!$checkEmp) {
            if ($cv = $request->file('cvfileupload')) {
                $destinationPath = 'public/employee/applicant_cv';
                $cv_name = $name . '-' . date('YmdHis') . "." . $cv->getClientOriginalExtension();
                $cv->move($destinationPath, $cv_name);
            }
            if ($vac_certificate = $request->file('vac_certificate')) {
                $destinationPath = 'public/employee/vaccine_certificate';
                $vac_name = $name . '-' . date('YmdHis') . "." . $vac_certificate->getClientOriginalExtension();
                $vac_certificate->move($destinationPath, $vac_name);
            }
            if ($nid = $request->file('nidfileupload')) {
                $destinationPath = 'public/employee/nid';
                $nid_name = $name . '-' . date('YmdHis') . "." . $nid->getClientOriginalExtension();
                $nid->move($destinationPath, $nid_name);
            }
            if ($image = $request->file('image')) {
                $destinationPath = 'public/employee/image';
                $image_name = $name . '-' . date('YmdHis') . "." . $image->getClientOriginalExtension();
                $image->move($destinationPath, $image_name);
            }
            $empEntry = new EmpEntry();
            $empEntry->emp_user_id = Auth::guard('empuser')->user()->id;
            $empEntry->job_id = $job_id;
            $empEntry->Name = $name;
            $empEntry->MobileNo = $phone;
            $empEntry->email = $email;
            $empEntry->material_status = $material_status;
            $empEntry->nationality = $nationality;
            $empEntry->religion = $religion;
            $empEntry->gender = $gender;
            $empEntry->d_o_b = $d_o_b;
            $empEntry->NationalIDNo = $n_id;
            $empEntry->experience = $experience;
            $empEntry->especality = $especality;
            $empEntry->prsnt_district_id = $prsnt_district;
            $empEntry->prsnt_thana_id = $prsnt_thana;
            $empEntry->prsnt_post_office = $prsnt_post_office;
            $empEntry->prsnt_local_add = $prsnt_local_add;
            $empEntry->par_district_id = $par_district;
            $empEntry->par_thana_id = $par_thana;
            $empEntry->par_post_office = $par_post_office;
            $empEntry->par_local_add = $par_local_add;
            $empEntry->cvfile = $cv_name;
            $empEntry->nidfile = $nid_name;
            $empEntry->image = $image_name;
            $empEntry->vaccine_certificate = $vac_certificate;
            $empEntry->apply_type = 'job_post';
            $empEntry->status = '0';
            $empEntry->save();
            //Insert Granter
            if ($request->g_name) {
                $g_nid = "";
                if ($granterNID = $request->file('g_nid')) {
                    $destinationPath = 'public/employee/granter_nid';
                    $g_nid = $name . '-' . date('YmdHis') . "." . $granterNID->getClientOriginalExtension();
                    $granterNID->move($destinationPath, $g_nid);
                }
                // return $g_nid;

                EmpGranter::create([
                    'emp_id' => $empEntry->id,
                    'g_name' => $g_name,
                    'g_occupation' => $g_occupation,
                    'g_organization' => $g_organization,
                    'g_org_add' => $g_org_add,
                    'g_phone' => $g_phone,
                    'g_email' => $g_email,
                    'g_relation' => $g_relation,
                    'g_nid' => $g_nid,
                ]);
            }

            //Insert Reference
            $rcount = count($r_name);
            if ($rcount > 0) {
                for ($i = 0; $i < $rcount; $i++) {
                    if (!empty($r_name[$i])) { // Check if r_name is not empty
                        $data = [
                            'emp_id' => $empEntry->id,
                            'r_name' => $r_name[$i],
                            'r_occupation' => $r_occupation[$i],
                            'r_phone' => $r_phone[$i],
                            'r_email' => $r_email[$i],
                            'r_relation' => $r_relation[$i],
                        ];

                        if ($r_organization[$i] !== null && $r_org_add[$i] !== null) {
                            $data['r_organization'] = $r_organization[$i];
                            $data['r_org_add'] = $r_org_add[$i];
                        }

                        EmpReference::create($data);
                    }
                }
            }

            //Insert Education
            $count = count($degrees);
            if ($count > 0) {
                for ($i = 0; $i < $count; $i++) {
                    $obt_result = $obt_results[$i];
                    if ($obt_result !== null) {
                        EmpEducation::create([
                            'emp_id' => $empEntry->id,
                            'degree_id' => $degrees[$i],
                            'edu_institute' => $edu_institutes[$i],
                            'board_id' => $boards[$i],
                            'result_type' => $result_types[$i],
                            'obt_result' => $obt_result,
                            'passing_yr' => $passing_years[$i],
                        ]);
                    }
                }
            }

            //Insert Training
            $countTr = count($training_title);
            if ($countTr > 0) {
                for ($i = 0; $i < $countTr; $i++) {
                    EmpTraining::create([
                        'emp_id' => $empEntry->id,
                        'tr_title' => $training_title[$i],
                        'tr_country' => $tr_country[$i],
                        'topic_coverd' => $topic_coverd[$i],
                        'training_year' => $training_year[$i],
                        'tr_institute' => $tr_institute[$i],
                        'tr_duration' => $tr_duration[$i],
                        'tr_location' => $tr_location[$i],
                    ]);
                }
            }

            //Insert Experience
            $countExp = count($exp_designation);
            if ($countExp > 0) {
                for ($i = 0; $i < $countExp; $i++) {
                    $to_date = $to_date[$i];
                    $toDateData = "";
                    if ($to_date != null) {
                        $toDateData = $to_date;
                    } else {
                        $toDateData = 'continuing';
                    }
                    EmpEmployment::create([
                        'emp_id' => $empEntry->id,
                        'exp_designation' => $exp_designation[$i],
                        'organization' => $organization[$i],
                        'responsibilities' => $responsibilities[$i],
                        'from_date' => $from_date[$i],
                        'to_date' => $toDateData,
                    ]);
                }
            }

            $applicant = DB::table('hr_database_emp_users as user')
                ->join('hr_database_emp_entry as emp', 'emp.emp_user_id', '=', 'user.id')
                ->leftJoin('hr_setup_jobs as job', 'emp.job_id', '=', 'job.id')
                ->leftJoin('hr_setup_designation as job_dsg', 'job_dsg.id', '=', 'job.desg_id') 
                ->leftJoin('hr_setup_designation as emp_dsg', 'emp_dsg.id', '=', 'emp.designation_id') 
                ->leftJoin('hr_setup_department as dept', 'dept.id', '=', 'job.dept_id')
                ->select('emp.id as emp_id', 'emp.Name', 'emp.MobileNo', 'emp.email',  'dept.Department',  'job_dsg.Designation as job_designation','emp_dsg.Designation as emp_designation')
                ->where('job.id', $job_id)
                ->first();

            $userid =  Auth::guard('empuser')->user()->id;
       

            $dataForConfirmation = [
                'candidateEmail' =>  $applicant->email??null,
                'candidateName' =>  $applicant->Name??null,
                'candidatePhone' =>  $applicant->MobileNo??null,
                'job_designation' => $applicant->job_designation??null,
                'emp_designation' => $applicant->emp_designation??null,
                'department' => $applicant->Department??null,           
            ];
           
            sendToConfirmation($applicant->email, $dataForConfirmation);
            session()->flash('success', 'Your job application was successful. Thank you');
            return redirect()->route('empuser.profile', $userid);
        } else {
            session()->flash('already_exists_message', 'You are already applied for this position');
            // Redirect back to the page with the form
            return redirect()->route('empuser.profile', Auth::guard('empuser')->user()->id);
        }
    }

    public function index()
    {
        if (getAccess('view')) {
            $userid = Sentinel::getUser()->id;
            $applicants = DB::table('hr_database_emp_users as user')
                ->leftJoin('hr_database_emp_entry as emp', 'emp.emp_user_id', '=', 'user.id')
                ->leftJoin('hr_setup_jobs as job', 'emp.job_id', '=', 'job.id')
                ->leftJoin('hr_setup_designation as job_dsg', 'job_dsg.id', '=', 'job.desg_id') 
                ->leftJoin('hr_setup_designation as emp_dsg', 'emp_dsg.id', '=', 'emp.designation_id') 
                ->leftJoin('hr_setup_department as dept', 'dept.id', '=', 'job.dept_id')
                ->leftJoin('hr_database_emp_interview as interview', 'interview.emp_id', '=', 'emp.id')
                ->join('lib_company as concern', 'concern.id', '=', 'user.company_id')
                ->select('emp.id as emp_id', 'emp.Name', 'concern.Name as concern_name', 'emp.MobileNo', 'emp.email', 'emp.NationalIDNo', 'emp.status', 'dept.Department', 'job_dsg.Designation as job_designation', 
                'emp_dsg.Designation as emp_designation')
                ->where('interview.interviewer_id', $userid)
                ->where('emp.status', '1')
                ->where('emp.FileEntryDone', 'N')
                ->get();
            return view('hris.database.interview.index', compact('applicants'));
        } else {
            return redirect()->back()->with('warning', getNotify(5));
        }
    }

    public function show($emp_id)
    {
        if (getAccess('view')) {
            $userid = Sentinel::getUser()->id;
            $feedback =  DB::table('hr_database_emp_interview_feedback as feedback')
            ->join('users', 'users.id', '=', 'feedback.interviewer_id')
            ->select('feedback.*', 'users.first_name', 'users.last_name')
            ->where('feedback.emp_id', $emp_id)
            ->latest()
            ->first();
            $applicant = DB::table('hr_database_emp_users as user')
                ->join('hr_database_emp_entry as emp', 'emp.emp_user_id', '=', 'user.id')
                ->leftJoin('hr_setup_jobs as job', 'emp.job_id', '=', 'job.id')
                ->leftJoin('hr_setup_designation as job_dsg', 'job_dsg.id', '=', 'job.desg_id') 
                ->leftJoin('hr_setup_designation as emp_dsg', 'emp_dsg.id', '=', 'emp.designation_id') 
                ->leftJoin('hr_setup_department as dept', 'dept.id', '=', 'job.dept_id')
                ->join('lib_company as concern', 'concern.id', '=', 'user.company_id')
                ->select('emp.id as emp_id', 'emp.Name', 'emp.MobileNo', 'emp.email', 'emp.NationalIDNo', 'emp.status', 'dept.Department',  'job_dsg.Designation as job_designation', 
                'emp_dsg.Designation as emp_designation' , 'expected_salary')
                ->where('emp.id', $emp_id)
                ->first();
            
            return view('hris.database.interview.interview', compact('applicant','feedback'));
        } else {
            return redirect()->back()->with('warning', getNotify(5));
        }
    }

    public function store(Request $request)
    {
        if (getAccess('create')) {
            // return $request;
            // $validatedData = $request->validate([
            //     'current_salary' => 'required|numeric',
            //     'expected_salary' => 'required|numeric',
            //     'reason_for_leave' => 'required|string',
            //     'date' => 'required|date',
            //     'interview_place' => 'required|string',
            //     // Add validation rules for other fields as needed
            //     'appearance' => 'required|in:1,2,3,4,5',
            //     'attitude_cooperation' => 'required|in:1,2,3,4,5',
            //     'expression_communication' => 'required|in:1,2,3,4,5',
            //     'job_knowledge' => 'required|in:1,2,3,4,5',
            //     'initiative_decision_making' => 'required|in:1,2,3,4,5',
            //     'dependability_leadership' => 'required|in:1,2,3,4,5',
            // ]);
            $emp_id = $request->emp_id;
            $userid = Sentinel::getUser()->id;
            $feedback = $request->content;
            //for assign interviewe
            $for =  $request->for;
            $step =  $request->step;
            $chkInterviewStep = EmpInterview::where('interviewer_id', $userid)->where('emp_id', $emp_id)->select('interview_step')->first();
            if (!$for == 'assign_interviewer') {
                // return $request;
                $empEntry = EmpEntry::where('id', $emp_id)->first();
                $intStepStatus = '';
                if ($chkInterviewStep->interview_step == 'first') {
                    $intStepStatus = '1';
                } else if ($chkInterviewStep->interview_step == 'second') {
                    $intStepStatus = '2';
                } else {
                    $intStepStatus = '3';
                }
                if ($empEntry->expected_salary == null) {
                    $expected_salary = $request->expected_salary;
                    $empEntry->expected_salary = $expected_salary;
                    $empEntry->update();
                }
                $empEntry->interview_status = $intStepStatus;
                $empEntry->update();


                $epmIntFeedback = new EmpInterviewFeedback();
                $epmIntFeedback->emp_id = $emp_id;
                $epmIntFeedback->interviewer_id = $userid;
                $epmIntFeedback->feedback = $feedback;
                $epmIntFeedback->current_salary = $request['current_salary'];
                $epmIntFeedback->reason_for_leave = $request['reason_for_leave'];
                $epmIntFeedback->interview_date = $request['date'];
                $epmIntFeedback->interview_place = $request['interview_place'];
                $epmIntFeedback->notice_period = $request['notice_period'];
                $epmIntFeedback->recommendation = $request['recommendation'];
                $epmIntFeedback->appearance = $request['appearance'];
                $epmIntFeedback->attitude_cooperation = $request['attitude_cooperation'];
                $epmIntFeedback->expression_communication = $request['expression_communication'];
                $epmIntFeedback->job_knowledge = $request['job_knowledge'];
                $epmIntFeedback->initiative_decision_making = $request['initiative_decision_making'];
                $epmIntFeedback->dependability_leadership = $request['dependability_leadership'];
                $epmIntFeedback->save();


                Session::flash('success', 'Your feedback has been submitted.');
                return redirect()->back();
            } else {

                $interviewers = [];
                $datetime = "";
                if ($request->step == 'first') {
                    $interviewers = $request->interviewers;
                    $datetime = $request->datetime;
                } else if ($request->step == 'second') {
                    $interviewers = $request->interviewers_second;
                    $datetime = $request->datetime_second;
                } else {
                    $interviewers = $request->interviewers_third;
                    $datetime = $request->datetime_third;
                }

                // Remove existing interviewers for the current step
                EmpInterview::where('emp_id', $emp_id)
                    ->where('interview_step', $step)
                    ->delete();

                // Insert/update the interviewers for the current step

                $applicant = DB::table('hr_database_emp_users as user')
                    ->join('hr_database_emp_entry as emp', 'emp.emp_user_id', '=', 'user.id')
                    ->leftJoin('hr_setup_jobs as job', 'emp.job_id', '=', 'job.id')
                    ->leftJoin('hr_setup_designation as job_dsg', 'job_dsg.id', '=', 'job.desg_id') 
                    ->leftJoin('hr_setup_designation as emp_dsg', 'emp_dsg.id', '=', 'emp.designation_id') 
                    ->leftJoin('hr_setup_department as dept', 'dept.id', '=', 'job.dept_id')
                    ->join('lib_company as concern', 'concern.id', '=', 'user.company_id')
                    ->select('emp.id as emp_id', 'emp.Name', 'emp.MobileNo', 'job_dsg.Designation as job_designation','emp_dsg.Designation as emp_designation', 'emp.email', 'emp.NationalIDNo', 'dept.Department')
                    ->where('emp.id', $emp_id)
                    ->where('job.id', $request->job_id)
                    ->first();

                $getCreatedUser = DB::table('users as user')
                    ->leftJoin('hr_database_employee_basic as emp', 'emp.EmployeeID', '=', 'user.empid')
                    ->leftJoin('hr_setup_department as dept', 'dept.id', '=', 'emp.DepartmentID')
                    ->leftJoin('hr_setup_designation as dsg', 'dsg.id', '=', 'emp.DesignationID')
                    ->leftJoin('hr_database_employee_personal as personal', 'personal.EmployeeID', '=', 'user.empid')
                    ->select('emp.id as id','user.first_name','user.last_name', 'dept.Department', 'dsg.Designation', 'user.Email', 'personal.PhoneNo')
                    ->where('user.id', $userid)
                    ->first();                           
                foreach ($interviewers as $interviewer) {
                    $user = User::where('id', $interviewer)->first();
                    $empInterview = new EmpInterview();
                    $empInterview->emp_id = $emp_id;
                    $empInterview->interviewer_id = $interviewer;
                    $empInterview->datetime = $datetime;
                    $empInterview->location = $request->location;
                    $empInterview->interview_step = $step;
                    $empInterview->created_by = $userid;
                    $empInterview->save();

                    $dataForInterViewer = [
                        'datetime' => $datetime,
                        'location' => $request->location,
                        'details' => $applicant,
                        'interviewerName' => $user->first_name . ' ' . $user->last_name,
                        'candidateName' =>  $applicant->Name,
                        'candidatePhone' =>  $applicant->MobileNo,
                        'job_designation' => $applicant->job_designation,
                        'emp_designation' => $applicant->emp_designation,
                        'department' => $applicant->Department,
                        'getCreatedUserName' => $getCreatedUser!=null?$getCreatedUser->first_name.' '.$getCreatedUser->last_name:null,
                        'getCreatedUserDesg' => $getCreatedUser->Designation??null,
                        'getCreatedUserDept' => $getCreatedUser->Department??null,
                        'getCreatedUserEmail' => $getCreatedUser->Email??null,
                        'getCreatedUserPhone' => $getCreatedUser->PhoneNo??null,
                    ];
                    // sendToInterviewer($user->email, $dataForInterViewer);
                }

                $dataForApplicant = [
                    'job_designation' => $applicant->job_designation,
                    'emp_designation' => $applicant->emp_designation,
                    'datetime' =>  $datetime,
                    'location' =>  $request->location,
                    'candidateName' =>  $applicant->Name,
                    'candidatePhone' =>  $applicant->MobileNo,                    
                    'getCreatedUserName' => $getCreatedUser!=null?$getCreatedUser->first_name.' '.$getCreatedUser->last_name:null,
                    'getCreatedUserDesg' => $getCreatedUser->Designation??null,
                    'getCreatedUserDept' => $getCreatedUser->Department??null,
                    'getCreatedUserEmail' => $getCreatedUser->Email??null,
                    'getCreatedUserPhone' => $getCreatedUser->PhoneNo??null,

                ];

                // sendToApplicant($applicant->email, $dataForApplicant);
                Session::flash('success', 'Interviewer assign success');
                return redirect()->back();
            }
        } else {
            return redirect()->back()->with('warning', getNotify(5));
        }
    }
}
