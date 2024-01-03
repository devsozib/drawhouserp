<?php

namespace App\Http\Controllers\HRIS\Applicant;

use DB;
use PDF;
use Input;
use Redirect;
use Response;
use Sentinel;
use Validator;
use Svg\Tag\Rect;
use Carbon\Carbon;
use App\Models\Users;
use Illuminate\Http\Request;
use App\Models\HRIS\Setup\Sex;
use App\Models\HRIS\Setup\Shifts;
use App\Models\HRIS\Setup\Thanas;
use App\Models\HRIS\Setup\Degrees;
use App\Models\HRIS\Setup\Document;
use App\Http\Controllers\Controller;
use App\Models\HRIS\Setup\Districts;
use App\Models\HRIS\Setup\Religions;
use App\Models\HRIS\Tools\HROptions;
use App\Models\HRIS\Setup\Department;
use App\Models\HRIS\Database\EmpEntry;
use App\Models\HRIS\Database\Employee;
use App\Models\HRIS\Setup\Designation;
use App\Models\HRIS\Setup\ProcessList;
use App\Models\HRIS\Setup\TrainingType;
use App\Models\HRIS\Setup\MaritalStatus;
use App\Models\HRIS\Setup\Nationalities;
use App\Models\HRIS\Setup\EducationBoard;
use App\Models\HRIS\Database\EmpEducation;
use App\Models\HRIS\Database\EmpInterview;
use App\Models\HRIS\Setup\ReferenceSource;
use App\Models\HRIS\Database\EmpEmployment;
use App\Models\HRIS\Database\EmployeeBangla;
use App\Models\HRIS\Database\EmployeeSalary;
use App\Models\HRIS\Tools\ApprovePermission;
use App\Models\HRIS\Tools\ForwardPermission;
use App\Models\HRIS\Database\EmployeeService;
use App\Models\HRIS\Database\EmployeeDocument;
use App\Models\HRIS\Database\EmployeePersonal;
use App\Models\HRIS\Database\EmployeeTraining;
use App\Models\HRIS\Database\EmployeeAllowance;
use App\Models\HRIS\Database\EmployeeEducation;
use App\Models\HRIS\Database\EmployeeOperation;
use App\Models\HRIS\Database\EmployeeReference;
use App\Models\HRIS\Database\EmployeeExperience;
use App\Models\HRIS\Database\EmpInterviewFeedback;
use Illuminate\Support\Facades\URL;
use PhpParser\Node\Expr\Empty_;

class ApplicantController extends Controller
{


    public function index()
    {
        if (getAccess('view')) {
            $applicants = DB::table('hr_database_emp_users as user')
            ->join('hr_database_emp_entry as emp', 'emp.emp_user_id', '=', 'user.id')
            ->leftJoin('hr_setup_jobs as job', 'emp.job_id', '=', 'job.id')
            ->leftJoin('hr_setup_designation as job_dsg', 'job_dsg.id', '=', 'job.desg_id') 
            ->leftJoin('hr_setup_designation as emp_dsg', 'emp_dsg.id', '=', 'emp.designation_id') 
            ->leftJoin('hr_setup_department as dept', 'dept.id', '=', 'job.dept_id')
            ->join('lib_company as concern', 'concern.id', '=', 'user.company_id')
            ->select(
                'emp.id as emp_id',
                'emp.Name',
                'concern.Name as concern_name',
                'emp.MobileNo',
                'emp.email',
                'emp.NationalIDNo',
                'emp.status',
                'dept.Department',
                'job_dsg.Designation as job_designation', 
                'emp_dsg.Designation as emp_designation' 
            )
            ->orderBy('emp.created_at', 'desc')
            ->where('emp.FileEntryDone', 'N')
            ->get();
            return view('hris.database.applicant.index', compact('applicants'));
        } else {
            return redirect()->back()->with('warning', getNotify(5));
        }
    }

    public function show(Request $request, $id)
    {
        if (!getAccess('view')) {
            return redirect()->back()->with('warning', getNotify(5));
        } else {
            $type = "";
            if ($request->get('applicant')) {
                $type = $request->get('applicant');
            } else {
                $type = "create";
            }
            if ($type  == 'show') {                
                $applicant = DB::table('hr_database_emp_users as user')
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
                    ->select('emp.id as emp_id', 'emp.Name', 'emp.MobileNo', 'emp.email', 'emp.NationalIDNo', 'dept.Department',  'job_dsg.Designation as job_designation','emp_dsg.Designation as emp_designation', 'emp.experience', 'emp.especality', 'prsnt_dis.Name as prsnt_dis', 'par_dis.Name as par_dis', 'prsnt_thna.Name as prsnt_thana', 'emp.prsnt_post_office', 'emp.prsnt_local_add',  'par_thna.Name as par_thana', 'emp.par_post_office', 'emp.par_local_add', 'emp.gender', 'emp.d_o_b', 'emp.nationality', 'emp.cvfile', 'emp.nidfile', 'emp.status', 'emp.interview_status', 'emp.image', 'emp.expected_salary', 'emp.job_id','emp.apply_type')
                    ->where('emp.id', $id)
                    ->orderBy('emp.id', 'desc')
                    ->first();
                $education = DB::table('hr_database_emp_education as edu')
                    ->join('hr_setup_degrees as degrees', 'degrees.id', '=', 'edu.degree_id')
                    ->join('hr_setup_educationboard as board', 'board.id', '=', 'edu.board_id')
                    ->select('edu.edu_institute', 'degrees.Degree', 'edu.result_type', 'edu.obt_result', 'edu.passing_yr', 'board.Name')
                    ->where('edu.emp_id', $id)
                    ->get();

                $experiences = DB::table('hr_database_emp_experience as exp')
                    ->where('exp.emp_id', $id)
                    ->get();
                $refercences = DB::table('hr_database_emp_reference as ref')
                    ->where('ref.emp_id', $id)
                    ->get();
                $granters = DB::table('hr_database_emp_granter as granter')
                    ->where('granter.emp_id', $id)
                    ->get();
                $feedbacks =  DB::table('hr_database_emp_interview_feedback as feedback')
                    ->join('users', 'users.id', '=', 'feedback.interviewer_id')
                    ->select('feedback.*', 'users.first_name', 'users.last_name')
                    ->where('feedback.emp_id', $id)
                    ->get();
                //For First
                $selectedFirstInterviews = EmpInterview::where('emp_id', $id)
                    ->where('interview_step', 'first')
                    ->select('interviewer_id', 'datetime', 'location')
                    ->get();
                $selectedFirstInterviewers = $selectedFirstInterviews->pluck('interviewer_id')->toArray();
                $selectedFirstDatetime = $selectedFirstInterviews->pluck('datetime')->toArray();
                $selectedFirstLocation = $selectedFirstInterviews->pluck('location')->toArray();
                //For third
                $selectedThirdInterviews = EmpInterview::where('emp_id', $id)
                    ->where('interview_step', 'third')
                    ->select('interviewer_id', 'datetime', 'location')
                    ->get();
                $selectedThirdInterviewers = $selectedThirdInterviews->pluck('interviewer_id')->toArray();
                $selectedThirdDatetime = $selectedThirdInterviews->pluck('datetime')->toArray();
                $selectedThirdLocation = $selectedThirdInterviews->pluck('location')->toArray();
                //For Second
                $selectedSecondInterviews = EmpInterview::where('emp_id', $id)
                    ->where('interview_step', 'second')
                    ->select('interviewer_id', 'datetime', 'location')
                    ->get();
                $selectedSecondInterviewers = $selectedSecondInterviews->pluck('interviewer_id')->toArray();
                $selectedSecondDatetime = $selectedSecondInterviews->pluck('datetime')->toArray();
                $selectedSecondLocation = $selectedSecondInterviews->pluck('location')->toArray();
                
                 $checkEmp = EmployeePersonal::join('hr_database_employee_basic','hr_database_employee_basic.EmployeeID','=','hr_database_employee_personal.EmployeeID')->where('hr_database_employee_personal.NationalIDNo',$applicant->NationalIDNo)->select('hr_database_employee_basic.company_id','hr_database_employee_basic.EmployeeID')->first();

                return view('hris.database.applicant.show', compact('applicant', 'education', 'experiences', 'refercences', 'granters', 'feedbacks', 'selectedFirstInterviewers', 'selectedFirstDatetime', 'selectedSecondInterviewers', 'selectedSecondDatetime', 'selectedThirdInterviewers', 'selectedThirdDatetime', 'selectedFirstLocation', 'selectedThirdLocation', 'selectedSecondLocation','checkEmp'));
            } else {
                $optionalparam = HROptions::orderBy('id', 'DESC')->first();
                if ($request->get('tab') == 1) {
                    $tab = 1;
                    $desglist = Designation::orderBy('id', 'ASC')->where('C4S', 'Y')->get();
                    $deptlist = Department::orderBy('id', 'ASC')->where('FinalUse', 'Y')->where('C4S', 'Y')->get();
                    $shiftlist = Shifts::orderBy('id', 'ASC')->where('C4S', 'Y')->pluck('Shift', 'Shift');
                    $districtlist = Districts::orderBy('id', 'ASC')->get();
                    $thanalist = Thanas::orderBy('DistrictID', 'ASC')->orderBy('Name', 'ASC')->where('C4S', 'Y')->pluck('Name', 'id');
                    return view('hris.database.applicant.create', compact('tab', 'districtlist', 'thanalist', 'desglist', 'deptlist', 'shiftlist'));
                } elseif ($request->get('tab') == 2) {
                    $tab = 2;
                    $educations = EmployeeEducation::orderBy('id', 'ASC')->where('EmployeeID')->get();
                    $degreelist = Degrees::orderBy('id', 'ASC')->pluck('Degree', 'id');
                    $boardlist = EducationBoard::orderBy('id', 'ASC')->pluck('Name', 'id');
                    return view('hris.database.applicant.create', compact('tab', 'optionalparam', 'educations', 'degreelist', 'boardlist'));
                } elseif ($request->get('tab') == 3) {
                    $tab = 3;
                    $experiences = EmployeeExperience::orderBy('id', 'ASC')->where('EmployeeID')->get();
                    return view('hris.database.applicant.create', compact('tab', 'optionalparam', 'experiences'));
                }
            }
        }
    }
    public function create()
    {
    }

    public function store(Request $request)
    {
        if (getAccess('create')) {
            // return $request;
            // Personal Information
            $department =  $request->department;
            $designation =  $request->designation;
            $experience =  $request->experience;
            $especality =  $request->especality;
            $name =  $request->name;
            $d_o_b =  $request->d_o_b;
            $gender =  $request->gender;
            $material_status =  $request->material_status;
            $nationality =  $request->nationality;
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
            // Education info
            $degrees =  $request->degree;
            $edu_institutes =  $request->edu_institute;
            $boards =  $request->board;
            $result_types =  $request->result_type;
            $obt_results = $request->obt_result;
            $passing_years =  $request->passing_year;
            // // Training Info
            // $training_title =  $request->training_title;
            // $tr_country =  $request->tr_country;
            // $topic_coverd =  $request->topic_coverd;
            // $training_year =  $request->training_year;
            // $tr_institute =  $request->tr_institute;
            // $tr_duration =  $request->tr_duration;
            // $tr_location =  $request->tr_location;
            // Experience Info
            $exp_designation =  $request->exp_designation;
            $organization =  $request->organization;
            $responsibilities =  $request->responsibilities;
            $from_date =  $request->from_date;
            $to_date =  $request->to_date;
            $refercence =  $request->refercence;

            // Files

            $cvfileupload =  $request->cvfileupload;
            $nidfileupload =  $request->nidfileupload;

            $checkEmp = EmpEntry::where('MobileNo', $phone)->where('NationalIDNo', $n_id)->where('DepartmentID', $department)->where('DesignationID', $designation)->where('email', $email)->first();

            if (!$checkEmp) {
                if ($request->tab == 1) {
                    $request->validate([
                        'cvfileupload' => 'required|mimes:pdf|max:2048', // Validate the uploaded file as PDF with a maximum size of 2MB
                        'nidfileupload' => 'required|mimes:pdf|max:2048', // Validate the uploaded file as PDF with a maximum size of 2MB
                    ]);
                    if ($cv = $request->file('cvfileupload')) {
                        $destinationPath = 'public/career/applicant_cv';
                        $cv_name = $name . '-' . date('YmdHis') . "." . $cv->getClientOriginalExtension();
                        $cv->move($destinationPath, $cv_name);
                    }
                    if ($nid = $request->file('nidfileupload')) {
                        $destinationPath = 'public/career/nid';
                        $nid_name = $name . '-' . date('YmdHis') . "." . $nid->getClientOriginalExtension();
                        $nid->move($destinationPath, $nid_name);
                    }
                    $empEntry = new EmpEntry();
                    $empEntry->Name = $name;
                    $empEntry->MobileNo = $phone;
                    $empEntry->email = $email;
                    $empEntry->material_status = $material_status;
                    $empEntry->nationality = $nationality;
                    $empEntry->gender = $gender;
                    $empEntry->d_o_b = $d_o_b;
                    $empEntry->NationalIDNo = $n_id;
                    $empEntry->DepartmentID = $department;
                    $empEntry->DesignationID = $designation;
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
                    $empEntry->status = '0';
                    $empEntry->reference_by = $refercence;
                    $empEntry->save();
                    session()->flash('success', 'Personal Information Submitted');
                    $emp_id = $empEntry->id;
                    $tab = 2;
                    $data = [
                        'emp_id' => $emp_id,
                        'tab' => $tab,
                    ];

                    $url = 'hris/applicant/new-applicant/1?tab=2&' . http_build_query($data);
                    return redirect()->to($url);
                } else if ($request->tab == 1) {
                    // //Insert Education
                    // $count = count($degrees);
                    // for ($i = 0; $i < $count; $i++) {
                    //     $obt_result = $obt_results[$i];
                    //     if ($obt_result !== null) {
                    //         EmpEducation::create([
                    //             'emp_id' => $empEntry->id,
                    //             'degree_id' => $degrees[$i],
                    //             'edu_institute' => $edu_institutes[$i],
                    //             'board_id' => $boards[$i],
                    //             'result_type' => $result_types[$i],
                    //             'obt_result' => $obt_result,
                    //             'passing_yr' => $passing_years[$i],
                    //         ]);
                    //     }
                    // }
                }


                // //Insert Experience
                // $countExp = count($exp_designation);
                // for ($i = 0; $i < $countExp; $i++) {
                //     $to_date = $to_date[$i];
                //     $toDateData = "";
                //     if ($to_date != null) {
                //         $toDateData = $to_date;
                //     } else {
                //         $toDateData = 'continuing';
                //     }
                //     EmpEmployment::create([
                //         'emp_id' => $empEntry->id,
                //         'exp_designation' => $exp_designation[$i],
                //         'organization' => $organization[$i],
                //         'responsibilities' => $responsibilities[$i],
                //         'from_date' => $from_date[$i],
                //         'to_date' => $toDateData,
                //     ]);
                // }

            } else {
                session()->flash('already_exists_message', 'You are already applied for this position');
                // Redirect back to the page with the form
                return redirect()->back();
            }
        } else {
            return redirect()->back()->with('warning', getNotify(5));
        }
    }

    public function selectedCandidate(Request $request)
    {
        $date = null;
        if ($request->date) {
            $date =   $request->date;
        } else {
            $date = null;
        }
        $taskAssignsIDs = EmpInterview::whereDate('datetime',  $date)
            ->pluck('emp_id');
        $slCandidates = DB::table('hr_database_emp_users as user')
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
            ->select('emp.id as emp_id', 'emp.Name', 'emp.MobileNo', 'concern.Name as concern_name', 'emp.email', 'emp.NationalIDNo', 'dept.Department', 'job_dsg.Designation as job_designation','emp_dsg.Designation as emp_designation', 'emp.experience', 'emp.especality', 'prsnt_dis.Name as prsnt_dis', 'par_dis.Name as par_dis', 'prsnt_thna.Name as prsnt_thana', 'emp.prsnt_post_office', 'emp.prsnt_local_add',  'par_thna.Name as par_thana', 'emp.par_post_office', 'emp.par_local_add', 'emp.gender', 'emp.d_o_b', 'emp.nationality', 'emp.cvfile', 'emp.nidfile', 'emp.status', 'emp.interview_status', 'emp.image')
            ->where('emp.status', '1')
            ->orderBy('emp.id', 'desc');
        if ($date != null) {
            $slCandidates->whereIn('emp.id', $taskAssignsIDs);
        }
        $slCandidates = $slCandidates->get();
        return view('hris.database.applicant.sl_candidate', compact('slCandidates', 'date'));
    }

    public function printShortlistedCandidates()
    {
        $currentDate = Carbon::now()->format('Y-m-d');

        // Retrieve shortlisted candidates for the current day
        $slCandidates = DB::table('hr_database_emp_users as user')
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
            ->select('emp.id as emp_id', 'emp.Name', 'emp.MobileNo', 'concern.Name as concern_name', 'emp.email', 'emp.NationalIDNo', 'dept.Department',  'job_dsg.Designation as job_designation','emp_dsg.Designation as emp_designation', 'emp.experience', 'emp.especality', 'prsnt_dis.Name as prsnt_dis', 'par_dis.Name as par_dis', 'prsnt_thna.Name as prsnt_thana', 'emp.prsnt_post_office', 'emp.prsnt_local_add',  'par_thna.Name as par_thana', 'emp.par_post_office', 'emp.par_local_add', 'emp.gender', 'emp.d_o_b', 'emp.nationality', 'emp.cvfile', 'emp.nidfile', 'emp.status', 'emp.interview_status', 'emp.image')
            ->where('emp.status', '1')
            ->whereDate('interview.datetime', $currentDate)
            ->orderBy('emp.id', 'desc')
            ->get();

        // Generate the PDF using the print_candidates.blade.php view and the retrieved data
        $pdf = PDF::loadView('hris.database.applicant.print_candidates', ['slCandidates' => $slCandidates]);

        // You can customize the PDF filename and options if needed
        // return $pdf->download('shortlisted_candidates.pdf');
        return $pdf->stream('shortlisted_candidates.pdf');

        // If you want to open the PDF directly in the browser, use the following line instead
        // return $pdf->stream('shortlisted_candidates.pdf');
    }
}
