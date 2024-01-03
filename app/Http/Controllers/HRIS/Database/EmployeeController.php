<?php

namespace App\Http\Controllers\HRIS\Database;

use DB;
use PDF;
use Input;
use Redirect;
use Response;
use Sentinel;
use Validator;
use Svg\Tag\Rect;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Users;
use Illuminate\Http\Request;
use App\Models\HRIS\Setup\Sex;
use App\Models\HRIS\Setup\Bank;
use App\Models\HRIS\Setup\Shifts;
use App\Models\HRIS\Setup\Thanas;
use App\Models\HRIS\Setup\Degrees;
use App\Models\HRIS\Setup\Document;
use App\Http\Controllers\Controller;
use App\Models\HRIS\Setup\Districts;
use App\Models\HRIS\Setup\Religions;
use App\Models\HRIS\Tools\HROptions;
use App\Models\HRIS\Tools\PunchData;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use App\Models\HRIS\Database\EmpUser;
use App\Models\HRIS\Setup\Department;
use App\Models\HRIS\Database\EmpEntry;
use App\Models\HRIS\Database\Employee;
use App\Models\HRIS\Setup\Designation;
use App\Models\HRIS\Setup\HDException;
use App\Models\HRIS\Setup\ProcessList;
use App\Models\HRIS\Setup\TrainingType;
use App\Models\HRIS\Tools\ShiftingList;
use App\Models\Library\General\Company;
use App\Models\HRIS\Database\EmpGranter;
use App\Models\HRIS\Setup\MaritalStatus;
use App\Models\HRIS\Setup\Nationalities;
use App\Models\HRIS\Tools\ExceptionalHD;
use App\Models\HRIS\Tools\ProcessSalary;
use App\Models\HRIS\Tools\ServiceCharge;
use App\Models\HRIS\Database\EmpTraining;
use App\Models\HRIS\Setup\EducationBoard;
use App\Models\HRIS\Database\EmpEducation;
use App\Models\HRIS\Database\EmpInterview;
use App\Models\HRIS\Database\EmpReference;
use App\Models\HRIS\Database\SalaryChange;
use App\Models\HRIS\Setup\ReferenceSource;
use App\Models\HRIS\Database\EmpEmployment;
use App\Models\HRIS\Database\EmployeeBangla;
use App\Models\HRIS\Database\EmployeeSalary;
use App\Models\HRIS\Tools\ApprovePermission;
use App\Models\HRIS\Tools\ForwardPermission;
use App\Models\HRIS\Tools\ProcessAttendance;
use App\Models\HRIS\Database\EmployeeGranter;
use App\Models\HRIS\Database\EmployeeService;
use App\Models\HRIS\Database\EmployeeDocument;
use App\Models\HRIS\Database\EmployeePersonal;
use App\Models\HRIS\Database\EmployeeTraining;
use App\Models\HRIS\Tools\ExceptionalHolidays;
use App\Models\HRIS\Database\EmployeeAllowance;
use App\Models\HRIS\Database\EmployeeEducation;
use App\Models\HRIS\Database\EmployeeOperation;
use App\Models\HRIS\Database\EmployeeReference;
use App\Models\HRIS\Database\AttendanceApproval;
use App\Models\HRIS\Database\EmployeeExperience;
use App\Models\HRIS\Database\EmployeePerformance;
use App\Models\HRIS\Database\EmpInterviewFeedback;
use App\Models\HRIS\Database\EmployeePerformanceDetails;
use App\Models\HRIS\Setup\JobAppraisal;

class EmployeeController extends Controller
{
    public function index()
    {
        if (getAccess('view')) {
            $desglist = Designation::whereRaw('FIND_IN_SET(?, company_id)', [getHostInfo()['id']])->orderBy('id', 'ASC')->where('C4S', 'Y')->select(DB::raw("CONCAT(id,' | ',Designation) AS full_name, id"))->get();
           $deptlist = Department::whereRaw('FIND_IN_SET(?, company_id)', [getHostInfo()['id']])->orderBy('id', 'ASC')->where('C4S', 'Y')->select(DB::raw("CONCAT(id,' | ',Department) AS full_name, id"))->get();
            $shiftlist = Shifts::orderBy('id', 'ASC')->where('C4S', 'Y')->pluck('Shift', 'Shift');
            $districtlist = Districts::orderBy('id', 'ASC')->pluck('Name', 'id');
            $optionalparam = HROptions::orderBy('id', 'DESC')->first();

            $empentry = DB::table('hr_database_emp_users as user')
                ->join('hr_database_emp_entry as emp', 'emp.emp_user_id', '=', 'user.id')
                ->leftJoin('hr_setup_jobs as job', 'emp.job_id', '=', 'job.id')
                ->leftJoin('hr_setup_designation as job_dsg', 'job_dsg.id', '=', 'job.desg_id')
                ->leftJoin('hr_setup_designation as emp_dsg', 'emp_dsg.id', '=', 'emp.designation_id')
                ->leftJoin('hr_setup_department as dept', 'dept.id', '=', 'job.dept_id')
                ->where('emp.status', '2')
                ->where('emp.FileEntryDone', 'N')
                ->where('user.company_id', getHostInfo()['id'])
                ->select('emp.*', 'dept.id as DepartmentID')
                ->get();

            $deptids = collect($empentry)->unique('DepartmentID')->pluck('DepartmentID');
            $departments = DB::table('hr_setup_department')->orderBy('Department', 'ASC')->whereIn('id', $deptids)->get();
            $employees = DB::table('hr_database_employee_basic as emp')
                ->join('hr_setup_department as dept', 'dept.id', '=', 'emp.DepartmentID')
                ->join('hr_setup_designation as dsg', 'dsg.id', '=', 'emp.DesignationID')
                ->join('lib_company as comp', 'comp.id', '=', 'emp.company_id')
                ->select('emp.id as id', 'emp.EmployeeID', 'emp.Name', 'comp.name as concern', 'emp.C4S', 'dept.Department', 'dsg.Designation')
                ->orderBy('emp.created_at', 'desc')
                ->where('emp.company_id', getHostInfo()['id'])
                ->get();
            $typelist = [1 => 'Full Time', 2 => 'Part Time', 3 => 'Contractual', 4 => 'Virtual'];
            return view('hris.database.employee.index', compact('employees', 'typelist', 'desglist', 'deptlist', 'shiftlist', 'districtlist', 'optionalparam', 'empentry', 'departments', 'employees'));
        } else {
            return redirect()->back()->with('warning', getNotify(5));
        }
    }

    public function show(Request $request, $id)
    {
        if (!getAccess('view')) {
            return redirect()->back()->with('warning', getNotify(5));
        } else {
            $optionalparam = HROptions::orderBy('id', 'DESC')->first();
            $uniqueemp = Employee::findOrFail($id);

            if ($request->get('tab') == 1) {
                $tab = 1;
                $desglist = Designation::whereRaw('FIND_IN_SET(?, company_id)', [getHostInfo()['id']])->orderBy('id', 'ASC')->where('C4S', 'Y')->select(DB::raw("CONCAT(id,' | ',Designation) AS full_name, id"))->pluck('full_name', 'id');
                $deptlist = Department::whereRaw('FIND_IN_SET(?, company_id)', [getHostInfo()['id']])->orderBy('id', 'ASC')->where('C4S', 'Y')->select(DB::raw("CONCAT(id,' | ',Department) AS full_name, id"))->pluck('full_name', 'id');
                $districtlist = Districts::orderBy('id', 'ASC')->pluck('Name', 'id');
                $thanalist = Thanas::orderBy('DistrictID', 'ASC')->orderBy('Name', 'ASC')->where('C4S', 'Y')->pluck('Name', 'id');
                $shiftlist = Shifts::orderBy('id', 'ASC')->where('C4S', 'Y')->pluck('Shift', 'Shift');
                $typelist = [1 => 'Full Time', 2 => 'Part Time', 3 => 'Contractual', 4 => 'Virtual'];
                return view('hris.database.employee.show', compact('tab', 'uniqueemp', 'desglist', 'deptlist', 'districtlist', 'shiftlist', 'optionalparam', 'thanalist', 'typelist'));
            } elseif ($request->get('tab') == 2) {
                $tab = 2;
                $uniquesalary = EmployeeSalary::where('EmployeeID', $uniqueemp->EmployeeID)->first();
                $year = Carbon::now()->year; $month = Carbon::now()->month;
                $serviceCharge = ServiceCharge::where("Year", $year)->where("Month", $month)->first();
                $monthlySerivceCharge = '0.00';
                if ($serviceCharge) {
                    $monthlySerivceCharge = $serviceCharge->amount * ($uniquesalary->ServiceChargePer / 100);
                } else {
                    $monthlySerivceCharge = '0.00';
                }
                $bankList = Bank::where('status','1')->pluck('Name', 'id');
                $empotherallowances = EmployeeAllowance::orderBy('id', 'ASC')->where('EmployeeID', $uniqueemp->EmployeeID)->get();
                return view('hris.database.employee.show', compact('tab', 'uniqueemp', 'optionalparam', 'uniquesalary', 'empotherallowances', 'monthlySerivceCharge','bankList'));
            } elseif ($request->get('tab') == 11) {
                $tab = 11;
                $granters = EmployeeGranter::orderBy('id', 'ASC')->where('EmployeeID', $uniqueemp->EmployeeID)->get();
                return view('hris.database.employee.show', compact('tab', 'uniqueemp', 'granters'));
            } elseif ($request->get('tab') == 3) {
                $tab = 3;
                $educations = EmployeeEducation::orderBy('id', 'ASC')->where('EmployeeID', $uniqueemp->EmployeeID)->get();
                $degreelist = Degrees::orderBy('id', 'ASC')->pluck('Degree', 'id');
                $boardlist = EducationBoard::orderBy('id', 'ASC')->pluck('Name', 'id');
                return view('hris.database.employee.show', compact('tab', 'uniqueemp', 'optionalparam', 'educations', 'degreelist', 'boardlist'));
            } elseif ($request->get('tab') == 4) {
                $tab = 4;
                $trainings = EmployeeTraining::orderBy('id', 'ASC')->where('EmployeeID', $uniqueemp->EmployeeID)->get();
                $traininglist = TrainingType::orderBy('id', 'ASC')->pluck('TrainingType', 'id');
                return view('hris.database.employee.show', compact('tab', 'uniqueemp', 'optionalparam', 'trainings', 'traininglist'));
            } elseif ($request->get('tab') == 5) {
                $tab = 5;
                $experiences = EmployeeExperience::orderBy('id', 'ASC')->where('EmployeeID', $uniqueemp->EmployeeID)->get();
                return view('hris.database.employee.show', compact('tab', 'uniqueemp', 'optionalparam', 'experiences'));
            } elseif ($request->get('tab') == 6) {
                $tab = 6;
                $empservices = EmployeeService::orderBy('id', 'ASC')->where('EmployeeID', $uniqueemp->EmployeeID)->get();
                return view('hris.database.employee.show', compact('tab', 'uniqueemp', 'optionalparam', 'empservices'));
            } elseif ($request->get('tab') == 7) {
                $tab = 7;
                $uniquereferences = EmployeeReference::where('EmployeeID', $uniqueemp->EmployeeID)->get();
                // $sourcelist = ReferenceSource::orderBy('id', 'ASC')->where('C4S', 'Y')->pluck('Source', 'id');
                return view('hris.database.employee.show', compact('tab', 'uniqueemp', 'optionalparam', 'uniquereferences'));
            } elseif ($request->get('tab') == 8) {
                $tab = 8;
                // $documentlists = Document::orderBy('id', 'ASC')->where('C4S', 'Y')->get();
                $empdocument = Employee::where('EmployeeID', $uniqueemp->EmployeeID)->select('cvfile', 'nidfile', 'vaccine_certificate')->first();
                return view('hris.database.employee.show', compact('tab', 'uniqueemp', 'optionalparam', 'empdocument'));
            } elseif ($request->get('tab') == 9) {
                $tab = 9;
                $uniquepersonal = EmployeePersonal::where('EmployeeID', $uniqueemp->EmployeeID)->first();
                $districtlist = Districts::orderBy('id', 'ASC')->pluck('Name', 'id');
                $thanalist = Thanas::orderBy('DistrictID', 'ASC')->orderBy('Name', 'ASC')->where('C4S', 'Y')->pluck('Name', 'id');
                $sexlist = Sex::orderBy('id', 'ASC')->pluck('Sex', 'SexCode');
                $degreelist = Degrees::orderBy('id', 'ASC')->pluck('Degree', 'id');
                $religionlist = Religions::orderBy('id', 'ASC')->pluck('Religion', 'ReligionID');
                $nationlist = Nationalities::orderBy('id', 'ASC')->pluck('Nationality', 'NationalityID');
                $maritallist = MaritalStatus::orderBy('id', 'ASC')->pluck('MaritalStatus', 'MaritalStatusID');

                $forids = ForwardPermission::where('EmployeeID', $uniqueemp->EmployeeID)->distinct()->pluck('UserID')->toArray();
                $appids = ApprovePermission::where('EmployeeID', $uniqueemp->EmployeeID)->distinct()->pluck('UserID')->toArray();
                // $userlist = Users::orderBy('id', 'ASC')->where('id', '!=', 3)->where('C4S', 'Y')->select(DB::raw("CONCAT(first_name,' ',last_name,' (',EmpID,')') AS full_name, id"))->pluck('full_name', 'id');
                $userlist = Users::whereRaw('FIND_IN_SET(?, company_id)', [getHostInfo()['id']])->pluck('fullname', 'id');

                return view('hris.database.employee.show', compact('tab', 'forids', 'appids', 'uniqueemp', 'optionalparam', 'uniquepersonal', 'districtlist', 'thanalist', 'sexlist', 'degreelist', 'religionlist', 'nationlist', 'maritallist', 'userlist'));
            } elseif ($request->get('tab') == 10) {
                $tab = 10;
                $uniquebangla = EmployeeBangla::where('EmployeeID', $uniqueemp->EmployeeID)->first();
                $districtlistb = Districts::orderBy('id', 'ASC')->pluck('NameB', 'id');
                $thanalistb = Thanas::orderBy('DistrictID', 'ASC')->orderBy('Name', 'ASC')->where('C4S', 'Y')->pluck('NameB', 'id');
                return view('hris.database.employee.show', compact('tab', 'uniqueemp', 'optionalparam', 'uniquebangla', 'districtlistb', 'thanalistb'));
            } elseif ($request->get('tab') == 12) {
                $tab = 12;
                return view('hris.database.employee.show', compact('tab', 'uniqueemp', 'optionalparam'));
            }
        }
    }

    public function store()
    {
        if (getAccess('create')) {
            $userid = Sentinel::getUser()->id;
            $attributes = Input::all();
            $rules = [
                'EmployeeID' => 'unique:hr_database_employee_basic',
                'Name' => 'required|max:35',
                // 'Salaried' => 'required|max:1',
                'DepartmentID' => 'required|numeric',
                'company_id' => 'required|numeric',
                'emp_type' => 'required|numeric',
                'DesignationID' => 'required|numeric',
                'Father' => 'required|max:35',
                'Mother' => 'required|max:35',
                'Spouse' => 'max:35',
                'JoiningDate' => 'required|date_format:Y-m-d',
                'ConfirmationDate' => 'date_format:Y-m-d',
                'PunchCategoryID' => 'required|numeric',
                'MDistrictID' => 'required|numeric',
                'MThanaID' => 'required|numeric',
                'MPOffice' => 'required|max:50',
                'MVillage' => 'required|max:50',
                'PDistrictID' => 'required|numeric',
                'PThanaID' => 'required|numeric',
                'PPOffice' => 'required|max:50',
                'PVillage' => 'required|max:50',
                'PresentAddressDuration' => 'max:30',
                'WhereBeforePresentAddress' => 'max:50',
                'ShiftingDuty' => 'max:1',
                'ReferenceShift' => 'required|max:1',
                'ShiftReferenceDate' => 'date_format:Y-m-d'
            ];
            $empEntryCheck  = "";
            $validation = Validator::make($attributes, $rules);
            if ($validation->fails()) {
                return redirect()->action('HRIS\Database\EmployeeController@index')->with('error', getNotify(4))->withErrors($validation)->withInput();
            } else {
                $EmpEntryID = $attributes['EmpEntryID'];
                if (isset($attributes['EmpEntryID'])) {
                    $empEntryCheck = EmpEntry::find($EmpEntryID);
                    if ($empEntryCheck != null) {
                        $chknid = EmployeePersonal::where('NationalIDNo', $empEntryCheck->NationalIDNo)->first();
                        if ($chknid) {
                            return redirect()->action('HRIS\Database\EmployeeController@index')->with('error', 'This NID information already exists ' . $chknid->EmployeeID)->withInput();
                        }
                        $chkmob = EmployeePersonal::where('MobileNo', $empEntryCheck->MobileNo)->first();
                        if ($chkmob) {
                            return redirect()->action('HRIS\Database\EmployeeController@index')->with('error', 'This mobile information already exists ' . $chkmob->EmployeeID)->withInput();
                        }
                    }
                }
                $employee_id = "";
                if ($attributes['EmployeeID']) {
                    $employee_id = $attributes['EmployeeID'];
                } else {
                    $lastids = Employee::latest()->first();
                    if ($lastids == null) {
                        $employee_id = 1;
                    } else {
                        $employee_id = $lastids->EmployeeID + 1;
                    }
                }
                $employee = new Employee();
                $employee->fill($attributes);
                $employee->EmployeeID =  $employee_id;
                $employee->Salaried =  'Y';
                $employee->Name = strtoupper($attributes['Name']);
                $employee->Father = strtoupper($attributes['Father']);
                $employee->Mother = strtoupper($attributes['Mother']);
                $employee->Spouse = strtoupper($attributes['Spouse']);
                $employee->JoiningDate = $attributes['JoiningDate'];
                $employee->ConfirmationDate = $attributes['ConfirmationDate'];
                $employee->ShiftReferenceDate = $attributes['ShiftReferenceDate'];
                if ($empEntryCheck != null) {
                    $employee->cvfile = $empEntryCheck->cvfile;
                    $employee->nidfile = $empEntryCheck->nidfile;
                    $employee->vaccine_certificate = $empEntryCheck->vaccine_certificate;
                    $employee->PhotoName = $empEntryCheck->image;
                }
                $employee->CreatedBy = $userid;
                $employee->save();

                $eid = $employee->id;
                $tab = 2;
                //from temporary data
                if ($empEntryCheck != null && $empEntryCheck->FinalStatus == 1 && $empEntryCheck->FileEntryDone == "N") {
                    $employee->EmpEntryID = $EmpEntryID;
                    $empEntryCheck->FileEntryDone = 'Y';
                    $empEntryCheck->updated_at = Carbon::now();
                    $empEntryCheck->save();
                } else {
                    $empEntryCheck = null;
                }

                $employeesalary = new EmployeeSalary();
                $employeesalary->EmployeeID = $employee->EmployeeID;
                $employeesalary->CreatedBy = $userid;
                if ($empEntryCheck != null) {
                    $optionalparam = HROptions::orderBy('id', 'DESC')->first();

                    $mfcallowance = ($optionalparam->MedicalAllowance + $optionalparam->FoodAllowance + $optionalparam->Conveyance);
                    $hrpb = $optionalparam->HouseRentPercentBasic;

                    $employeesalary->GrossSalary = $empEntryCheck->expected_salary;
                    $employeesalary->OtherAllowance = 0;
                    $employeesalary->MedicalAllowance = $optionalparam->MedicalAllowance;
                    $employeesalary->FoodAllowance = $optionalparam->FoodAllowance;
                    $employeesalary->Conveyance = $optionalparam->Conveyance;
                    $employeesalary->Basic = $basic = round(($empEntryCheck->expected_salary - $mfcallowance) / ((100 + $hrpb) / 100));
                    $employeesalary->HomeAllowance = round(($basic / 100) * $hrpb);
                }
                $employeesalary->save();

                $employeepersonal = new EmployeePersonal();
                $employeepersonal->EmployeeID = $employee->EmployeeID;
                if ($empEntryCheck != null) {
                    $employeepersonal->DistrictCode = $employee->PDistrictID;
                    $employeepersonal->ServiceBookOnDate = $employee->JoiningDate;
                    $employeepersonal->BirthDate = $empEntryCheck->d_o_b;
                    $employeepersonal->MaritalStatusID = $empEntryCheck->material_status;
                }
                $employeepersonal->CreatedBy = $userid;
                $employeepersonal->save();

                if ($empEntryCheck != null) {
                    $empEducations = EmpEducation::where('emp_id', $empEntryCheck->id)->get();
                    if (count($empEducations) > 0) {
                        foreach ($empEducations as $edu) {
                            $employeeEdcu = new EmployeeEducation();
                            $employeeEdcu->EmployeeID = $employee->EmployeeID;
                            $employeeEdcu->DegreeID = $edu->degree_id;
                            $employeeEdcu->Institute = $edu->edu_institute;
                            $employeeEdcu->BoardID = $edu->board_id;
                            $employeeEdcu->ResultType = $edu->result_type;
                            $employeeEdcu->ClassObtained = $edu->obt_result;
                            $employeeEdcu->Year = $edu->passing_yr;
                            $employeeEdcu->CreatedBy =  $userid;
                            $employeeEdcu->save();
                        }
                    }
                }

                if ($empEntryCheck != null) {
                    $empTrainings = EmpTraining::where('emp_id', $empEntryCheck->id)->get();
                    if (count($empTrainings) > 0) {
                        foreach ($empTrainings as $tr) {
                            $empTr = new EmployeeTraining();
                            $empTr->EmployeeID = $employee->EmployeeID;
                            $empTr->tr_title = $tr->tr_title;
                            $empTr->tr_country = $tr->tr_country;
                            $empTr->topic_coverd = $tr->topic_coverd;
                            $empTr->training_year = $tr->training_year;
                            $empTr->tr_institute = $tr->tr_institute;
                            $empTr->Duration = $tr->tr_duration;
                            $empTr->tr_location = $tr->tr_location;
                            $empTr->CreatedBy =  $userid;
                            $empTr->save();
                        }
                    }
                }

                if ($empEntryCheck != null) {
                    $empGranters = EmpGranter::where('emp_id', $empEntryCheck->id)->get();
                    if (count($empGranters) > 0) {
                        foreach ($empGranters as $granter) {
                            $empGR = new EmployeeGranter();
                            $empGR->EmployeeID = $employee->EmployeeID;
                            $empGR->g_name = $granter->g_name;
                            $empGR->g_occupation = $granter->g_occupation;
                            $empGR->g_organization = $granter->g_organization;
                            $empGR->g_org_add = $granter->g_org_add;
                            $empGR->g_phone = $granter->g_phone;
                            $empGR->g_email = $granter->g_email;
                            $empGR->g_relation = $granter->g_relation;
                            $empGR->g_nid = $granter->g_nid;
                            $empGR->g_relation = $granter->g_relation;
                            $empGR->created_by =  $userid;
                            $empGR->save();
                        }
                    }
                }

                if ($empEntryCheck != null) {
                    $empReferences = EmpReference::where('emp_id', $empEntryCheck->id)->get();
                    if (count($empReferences) > 0) {
                        foreach ($empReferences as $reference) {
                            $empRF = new EmployeeReference();
                            $empRF->EmployeeID = $employee->EmployeeID;
                            $empRF->r_name = $reference->r_name;
                            $empRF->r_occupation = $reference->r_occupation;
                            $empRF->r_organization = $reference->r_organization;
                            $empRF->r_org_add = $reference->r_org_add;
                            $empRF->r_phone = $reference->r_phone;
                            $empRF->r_email = $reference->r_email;
                            $empRF->r_relation = $reference->r_relation;
                            $empRF->CreatedBy =  $userid;
                            $empRF->save();
                        }
                    }
                }

                if ($empEntryCheck != null) {
                    $empExps = EmpEmployment::where('emp_id', $empEntryCheck->id)->get();
                    if (count($empExps) > 0) {
                        foreach ($empExps as $exp) {
                            $empEx = new EmployeeExperience();
                            $empEx->EmployeeID = $employee->EmployeeID;
                            $empEx->Designation = $exp->exp_designation;
                            $empEx->Organization = $exp->organization;
                            $empEx->responsibilities = $exp->responsibilities;
                            $empEx->from_date = $exp->from_date;
                            $empEx->to_date = $exp->to_date;
                            $empEx->CreatedBy =  $userid;
                            $empEx->save();
                        }
                    }
                }
                \LogActivity::addToLog('Add Employee ' . $employee->EmployeeID);
                return redirect()->action('HRIS\Database\EmployeeController@show', $eid . '?tab=' . $tab)->with('success', getNotify(1));
            }
        } else {
            return redirect()->back()->with('warning', getNotify(5));
        }
    }

    public function addEmployeeData(Request $request, $id)
    {
        if (getAccess('edit')) {
            $userid = Sentinel::getUser()->id;
            $attributes = Input::all();
            $time = Carbon::now();

            if ($request->get('form') == 1) {
                $tab = 1;
                $employee = Employee::find($id);
                $rules = [
                    'EmployeeID' => 'required|numeric|unique:hr_database_employee_basic,EmployeeID,' . $id,
                    'Name' => 'required|max:35',
                    'Salaried' => 'required|max:1',
                    'Line' => 'numeric|between:0,127',
                    'DepartmentID' => 'required|numeric',
                    'DesignationID' => 'required|numeric',
                    'company_id' => 'required|numeric',
                    'emp_type' => 'required|numeric',
                    'Father' => 'required|max:35',
                    'Mother' => 'required|max:35',
                    'Spouse' => 'max:35',
                    'JoiningDate' => 'required|date_format:Y-m-d',
                    'ConfirmationDate' => 'date_format:Y-m-d',
                    'PunchCategoryID' => 'required|numeric',
                    'MDistrictID' => 'required|numeric',
                    'MThanaID' => 'required|numeric',
                    'MPOffice' => 'required|max:50',
                    'MVillage' => 'required|max:50',
                    'PDistrictID' => 'required|numeric',
                    'PThanaID' => 'required|numeric',
                    'PPOffice' => 'required|max:50',
                    'PVillage' => 'required|max:50',
                    'PresentAddressDuration' => 'max:30',
                    'WhereBeforePresentAddress' => 'max:50',
                    'ShiftingDuty' => 'max:1',
                    'ReferenceShift' => 'required|max:1',
                    'ShiftReferenceDate' => 'date_format:Y-m-d',
                ];
                $validation = Validator::make($attributes, $rules);
                if ($validation->fails()) {
                    return redirect()->action('HRIS\Database\EmployeeController@show', $id . '?tab=' . $tab)->with('error', getNotify(4))->withErrors($validation)->withInput();
                } else {
                    $oldemp = $employee->EmployeeID;
                    $newemp = $attributes['EmployeeID'];
                    $employee->updated_at = Carbon::now();
                    $employee->fill($attributes);
                    $employee->Name = strtoupper($attributes['Name']);
                    $employee->Father = strtoupper($attributes['Father']);
                    $employee->Mother = strtoupper($attributes['Mother']);
                    $employee->Spouse = strtoupper($attributes['Spouse']);
                    $employee->JoiningDate = $attributes['JoiningDate'];
                    $employee->ConfirmationDate = $attributes['ConfirmationDate'];
                    $employee->ShiftReferenceDate = $attributes['ShiftReferenceDate'];
                    $employee->CreatedBy = $userid;

                    if ($oldemp != $newemp) {
                        $salchk = DB::table('payroll_tools_processsalary')->where('EmployeeID', $oldemp)->first();
                        if ($salchk) {
                            return redirect()->action('HRIS\Database\EmployeeController@show', $id . '?tab=' . $tab)->with('error', 'This Employee Already Salaried');
                        }
                        EmpEntry::where('EmployeeID', $oldemp)->update(['EmployeeID' => $newemp]);
                        Employee::where('EmployeeID', $oldemp)->update(['EmployeeID' => $newemp]);
                        EmployeeSalary::where('EmployeeID', $oldemp)->update(['EmployeeID' => $newemp]);
                        EmployeePersonal::where('EmployeeID', $oldemp)->update(['EmployeeID' => $newemp]);
                        EmployeeReference::where('EmployeeID', $oldemp)->update(['EmployeeID' => $newemp]);
                        EmployeeEducation::where('EmployeeID', $oldemp)->update(['EmployeeID' => $newemp]);
                        EmployeeExperience::where('EmployeeID', $oldemp)->update(['EmployeeID' => $newemp]);
                        EmployeeTraining::where('EmployeeID', $oldemp)->update(['EmployeeID' => $newemp]);
                        EmployeePerformance::where('EmployeeID', $oldemp)->update(['EmployeeID' => $newemp]);

                        ShiftingList::where('EmployeeID', $oldemp)->update(['EmployeeID' => $newemp]);
                        ExceptionalHD::where('EmployeeID', $oldemp)->update(['EmployeeID' => $newemp]);
                        HDException::where('EmployeeID', $oldemp)->update(['EmployeeID' => $newemp]);

                        \LogActivity::addToLog('Edit Employee ID ' . $oldemp . ' To ' . $newemp);
                    }
                    $employee->save();

                    $chkid2 = EmployeePersonal::where('EmployeeID', $newemp)->pluck('id')->first();
                    if ($chkid2) {
                        $employeepersonal = EmployeePersonal::find($chkid2);
                        $employeepersonal->DistrictCode = $employee->PDistrictID;
                        $employeepersonal->ServiceBookOnDate = $employee->JoiningDate;
                        $employeepersonal->CreatedBy = $userid;
                        $employeepersonal->save();
                    }
                    \LogActivity::addToLog('Edit Employee Basic Information To ' . $employee->EmployeeID);
                    return redirect()->action('HRIS\Database\EmployeeController@show', $id . '?tab=' . $tab)->with('success', getNotify(2));
                }
            } elseif ($request->get('form') == 2) {
                $tab = 2;
                $employee = Employee::find($id);
                $chkid = EmployeeSalary::where('EmployeeID', $employee->EmployeeID)->pluck('id')->first();
                $employeesalary = EmployeeSalary::find($chkid);

                $rules = [
                    'GrossSalary' => 'required|numeric|between:0,99999999',
                    'Basic' => 'required|numeric|between:0,99999999',
                    'MedicalAllowance' => 'required|numeric|between:0,99999999',
                    'HomeAllowance' => 'required|numeric|between:0,99999999',
                    'FoodAllowance' => 'required|numeric|between:0,99999999',
                    'ServiceCharge' => 'numeric|between:0,99999999',
                    'ServiceChargePer' => 'numeric|between:0,99999999',
                    'HousingAllowance' => 'numeric|between:0,99999999',
                    'Conveyance' => 'numeric|between:0,99999999',
                    'OTAllowanceFixed' => 'numeric|between:0,99999999',
                    // 'OtherAllowance' => 'numeric|between:0,99999999',
                    // 'AccountNo' => 'max:16',
                    // 'MobileBanking' => 'required|regex:/^(?:\01)?(?:\d{12})$/',
                    // 'MobileBanking' => 'required|regex:/^(?:\01)?(?:\d{11})[A-Z]{1}+$/',
                    // 'SalaryFromBank' => 'required|max:1',
                    // 'OTPayable' => 'required|max:1',
                    // 'OTAllowanceOnBasic' => 'numeric|between:0,99999999',
                ];

                if($request->SalaryFromBank == 'Y'){
                    if($request->Bank == null){
                        $rules['Bank'] = 'required';
                    }
                    if($request->AccountNo == null){
                        $rules['AccountNo'] = 'required|max:16';
                    }
                }

                // return $rules;
                $validation = Validator::make($attributes, $rules);
                if ($validation->fails()) {
                    return redirect()->action('HRIS\Database\EmployeeController@show', $id . '?tab=' . $tab)->with('error', getNotify(4))->withErrors($validation)->withInput();
                } else {
                    if ($employeesalary->GrossSalary != $attributes['GrossSalary']) {
                        $salarychange = new SalaryChange();
                        $salarychange->IncID = 1;
                        $salarychange->EmployeeID = $employeesalary->EmployeeID;
                        $salarychange->DateChanged = Carbon::now()->format('Y-m-d');
                        $salarychange->GrossSalary = $attributes['GrossSalary'];
                        $salarychange->Basic = $attributes['Basic'];
                        $salarychange->HomeAllowance = $attributes['HomeAllowance'];
                        $salarychange->MedicalAllowance = $attributes['MedicalAllowance'];
                        $salarychange->FoodAllowance = $attributes['FoodAllowance'];
                        $salarychange->Conveyance = $attributes['Conveyance'];
                        $salarychange->ServiceCharge = $attributes['ServiceCharge'];
                        $salarychange->ServiceChargePer = $attributes['ServiceChargePer'];
                        $salarychange->HousingAllowance = $attributes['HousingAllowance'];
                        $salarychange->CreatedBy = $userid;
                        $salarychange->update();
                    }

                    if(isset($request->Bank)){
                        $employeesalary->BankId = $attributes['Bank'];
                    }else{
                        $employeesalary->BankId = null;
                    }
                    if(isset($request->AccountNo)){
                        $employeesalary->AccountNo = $attributes['AccountNo'];
                    }else{
                        $employeesalary->AccountNo = null;
                    }

                    $employeesalary->updated_at = Carbon::now();
                    $employeesalary->CreatedBy = $userid;
                    $employeesalary->OTAllowanceFixed = $attributes['OTAllowanceFixed'];
                    $employeesalary->fill($attributes)->save();
                    \LogActivity::addToLog('Edit Employee Salary Info To ' . $employee->EmployeeID);
                    return redirect()->action('HRIS\Database\EmployeeController@show', $id . '?tab=' . $tab)->with('success', getNotify(2));
                }
            } elseif ($request->get('form') == 3) {
                $tab = 3;
                $education = new EmployeeEducation();
                $rules = [
                    'DegreeID' => 'required|numeric',
                    'Year' => 'numeric|digits:4',
                    'Institute' => 'required|max:150',
                    'BoardID' => 'required|numeric',
                    'ResultType' => 'required|max:1',
                    'Degree' => 'max:15',
                    'Grade' => 'max:15',
                    //'CGPA' => 'numeric|between:0,5'
                ];
                $validation = Validator::make($attributes, $rules);
                if ($validation->fails()) {
                    return redirect()->action('HRIS\Database\EmployeeController@show', $id . '?tab=' . $tab)->with('error', getNotify(4))->withErrors($validation)->withInput();
                } else {
                    $employee = Employee::find($id);
                    $education->EmployeeID = $employee->EmployeeID;
                    if ($attributes['ResultType'] == 'D') {
                        $education->ClassObtained = $attributes['Degree'];
                    } elseif ($attributes['ResultType'] == 'G') {
                        $education->ClassObtained = $attributes['Grade'];
                    } elseif ($attributes['ResultType'] == 'C') {
                        $education->ClassObtained = $attributes['CGPA'];
                    }
                    $education->CreatedBy = $userid;
                    $education->fill($attributes)->save();

                    \LogActivity::addToLog('Add Employee Education Info To ' . $employee->EmployeeID);
                    return redirect()->action('HRIS\Database\EmployeeController@show', $id . '?tab=' . $tab)->with('success', getNotify(1));
                }
            } elseif ($request->get('form') == 4) {
                // return $request->all();
                $tab = 4;
                $training = new EmployeeTraining();
                $rules = [
                    'tr_title' => 'required',
                    'tr_country' => 'required',
                    'training_year' => 'required',
                    'tr_institute' => 'required',
                    'Duration' => 'required',
                    'tr_location' => 'required',
                ];
                $validation = Validator::make($attributes, $rules);
                if ($validation->fails()) {
                    return redirect()->action('HRIS\Database\EmployeeController@show', $id . '?tab=' . $tab)->with('error', getNotify(4))->withErrors($validation)->withInput();
                } else {
                    $employee = Employee::find($id);
                    $training->EmployeeID = $employee->EmployeeID;
                    $training->CreatedBy = $userid;
                    $training->fill($attributes)->save();

                    \LogActivity::addToLog('Add Employee Training Info To ' . $employee->EmployeeID);
                    return redirect()->action('HRIS\Database\EmployeeController@show', $id . '?tab=' . $tab)->with('success', getNotify(1));
                }
            } elseif ($request->get('form') == 5) {
                $tab = 5;
                $experience = new EmployeeExperience();
                $rules = [
                    'Designation' => 'required|max:100',
                    'Organization' => 'max:100',
                    'Duration' => 'max:30',
                    'Description' => 'max:150',
                ];
                $validation = Validator::make($attributes, $rules);
                if ($validation->fails()) {
                    return redirect()->action('HRIS\Database\EmployeeController@show', $id . '?tab=' . $tab)->with('error', getNotify(4))->withErrors($validation)->withInput();
                } else {
                    $employee = Employee::find($id);
                    $experience->EmployeeID = $employee->EmployeeID;
                    $experience->CreatedBy = $userid;
                    $experience->fill($attributes)->save();

                    \LogActivity::addToLog('Add Employee Experience Info To ' . $employee->EmployeeID);
                    return redirect()->action('HRIS\Database\EmployeeController@show', $id . '?tab=' . $tab)->with('success', getNotify(2));
                }
            } elseif ($request->get('form') == 7) {
                $tab = 7;
                $employee = Employee::find($id);
                $chkid = EmployeeReference::where('EmployeeID', $employee->EmployeeID)->pluck('id')->first();
                $employeereference = new EmployeeReference();
                $rules = [
                    'r_name' => 'required',
                    'r_phone' => 'required',
                    'r_relation' => 'required',
                ];
                $validation = Validator::make($attributes, $rules);
                if ($validation->fails()) {
                    return redirect()->action('HRIS\Database\EmployeeController@show', $id . '?tab=' . $tab)->with('error', getNotify(4))->withErrors($validation)->withInput();
                } else {
                    $employeereference->EmployeeID = $employee->EmployeeID;
                    $employeereference->CreatedBy = $userid;
                    $employeereference->updated_at = Carbon::now();
                    $employeereference->fill($attributes)->save();

                    \LogActivity::addToLog('Edit Employee Reference Info To ' . $employee->EmployeeID);
                    return redirect()->action('HRIS\Database\EmployeeController@show', $id . '?tab=' . $tab)->with('success', getNotify(2));
                }
            } elseif ($request->get('form') == 8) {
                $employee = Employee::find($id);
                $tab = 8;
                $attributes = Input::all();
                $rules = [
                    'cv' => 'mimes:pdf|max:2048', // Adjust validation rules as needed
                    'nid' => 'mimes:pdf|max:2048',
                    'v_certificate' => 'mimes:pdf|max:2048',
                ];
                $validation = Validator::make($attributes, $rules);
                if ($validation->fails()) {
                    return redirect()->action('HRIS\Database\EmployeeController@show', $id . '?tab=' . $tab)->with('error', getNotify(4))->withErrors($validation)->withInput();
                } else {
                    $name = $employee->EmployeeID;
                    // return $attributes['cv'];
                    // if ($request->file('cv')) {

                    // }
                    // if ($request->file('nid')) {

                    // }

                    if ($cv = $request->file('cv')) {
                        if ($employee->cvfile) {
                            $cvFilePath = public_path('employee/applicant_cv/' . $employee->cvfile);
                            if (File::exists($cvFilePath)) {
                                File::delete($cvFilePath);
                            }
                        }
                        $destinationPath = 'public/employee/applicant_cv';
                        $cv_name = $name . '-' . date('YmdHis') . "." . $cv->getClientOriginalExtension();
                        $cv->move($destinationPath, $cv_name);
                    }

                    if ($nid = $request->file('nid')) {
                        if ($employee->nidfile) {
                            $nidFilePath = public_path('employee/nid/' . $employee->nidfile);
                            if (File::exists($nidFilePath)) {
                                File::delete($nidFilePath);
                            }
                        }
                        $destinationPath = 'public/employee/nid';
                        $nid_name = $name . '-' . date('YmdHis') . "." . $nid->getClientOriginalExtension();
                        $nid->move($destinationPath, $nid_name);
                    }

                    if ($vac_certificate = $request->file('v_certificate')) {
                        $vaccineFilePath = public_path('employee/vaccine_certificate/' . $employee->vaccine_certificate);
                        if (File::exists($vaccineFilePath)) {
                            File::delete($vaccineFilePath);
                        }
                        $destinationPath = 'public/employee/vaccine_certificate';
                        $vac_name = $name . '-' . date('YmdHis') . "." . $vac_certificate->getClientOriginalExtension();
                        $vac_certificate->move($destinationPath, $vac_name);
                    }


                    if($request->file('cv')){
                        $employee->cvfile =  $cv_name;
                    }
                    if ($request->file('nid')) {
                        $employee->nidfile = $nid_name;
                    }
                    if ($request->file('v_certificate')) {
                        $employee->vaccine_certificate = $vac_name;
                    }
                    $employee->save();
                    \LogActivity::addToLog('Add Employee Document Info To ' . $employee->EmployeeID);
                    return redirect()->action('HRIS\Database\EmployeeController@show', $id . '?tab=' . $tab)->with('success', getNotify(2));
                }
            } elseif ($request->get('form') == 9) {
                $tab = 9;
                $employee = Employee::find($id);
                $chkid = EmployeePersonal::where('EmployeeID', $employee->EmployeeID)->pluck('id')->first();
                $employeepersonal = EmployeePersonal::find($chkid);
                $rules = [
                    'BirthDate' => 'required|date_format:Y-m-d',
                    'DistrictCode' => 'required',
                    'Height' => 'max:10',
                    'Weight' => 'max:10',
                    'SexCode' => 'required',
                    'BloodGroup' => 'required',
                    'ReligionID' => 'required',
                    'MaritalStatusID' => 'required',
                    'NationalityID' => 'required',
                    'MobileNo' => 'regex:/^(?:\01)?(?:\d{11})$/',
                    'NationalIDNo' => 'regex:/[0-9]{10,17}/',
                    'BirthCertificate' => 'sometimes|nullable|regex:/[0-9]{10,20}/',
                    'Email' => 'email|max:50',
                    'ServiceBookNo' => 'max:20',
                    'ServiceBookOnDate' => 'date_format:Y-m-d',
                    // 'InApp' => 'required',
                    'NDistrictID' => 'sometimes|nullable|integer',
                    'NThanaID' => 'sometimes|nullable|integer',
                    'NPOffice' => 'max:50',
                    'NVillage' => 'max:50'
                ];
                $validation = Validator::make($attributes, $rules);
                if ($validation->fails()) {
                    return redirect()->action('HRIS\Database\EmployeeController@show', $id . '?tab=' . $tab)->with('error', getNotify(4))->withErrors($validation)->withInput();
                } else {
                    $EMPID = $employee->EmployeeID;

                    $forwards = Input::get('ForwardBy');
                    $approves = Input::get('ApproveBy');
                    if ($forwards && count($forwards)) {
                        ForwardPermission::where('EmployeeID', $EMPID)->delete();
                        foreach ($forwards as $forid) {
                            $employee1 = new ForwardPermission();
                            $employee1->UserID = $forid;
                            $employee1->EmployeeID = $EMPID;
                            $employee1->CreatedBy = $userid;
                            $employee1->save();

                            \LogActivity::addToLog('Add Forward User ID ' . $forid . ' & Emp ID ' . $EMPID);
                        }
                    }

                    if ($approves && count($approves)) {
                        ApprovePermission::where('EmployeeID', $EMPID)->delete();
                        foreach ($approves as $appid) {
                            $employe2 = new ApprovePermission();
                            $employe2->UserID = $appid;
                            $employe2->EmployeeID = $EMPID;
                            $employe2->CreatedBy = $userid;
                            $employe2->save();

                            \LogActivity::addToLog('Add Approve User ID ' . $appid . ' & Emp ID ' . $EMPID);
                        }
                    }


                    $forwardby = $forwards && count($forwards) ? implode(',', $forwards) : '';
                    $approveby = $approves && count($approves) ? implode(',', $approves) : '';
                    //unset($attributes['ForwardBy'],$attributes['ApproveBy']);

                    $employeepersonal->fill($attributes);
                    $employeepersonal->ForwardBy = $forwardby;
                    $employeepersonal->ApproveBy = $approveby;
                    $employeepersonal->BirthDate = $attributes['BirthDate'];
                    $employeepersonal->ServiceBookOnDate = $attributes['ServiceBookOnDate'];
                    $employeepersonal->CreatedBy = $userid;
                    $employeepersonal->updated_at = Carbon::now();
                    $employeepersonal->save();

                    \LogActivity::addToLog('Edit Employee Personal Info To ' . $employee->EmployeeID);
                    return redirect()->action('HRIS\Database\EmployeeController@show', $id . '?tab=' . $tab)->with('success', getNotify(2));
                }
            } elseif ($request->get('form') == 10) {
                $tab = 10;
                $employee = Employee::find($id);
                $chkid = EmployeeBangla::where('EmployeeID', $employee->EmployeeID)->pluck('id')->first();
                $employeebangla = EmployeeBangla::find($chkid);
                $rules = [
                    'NameB' => 'required|max:35',
                    'FatherB' => 'required|max:35',
                    'MotherB' => 'required|max:35',
                    'SpouseB' => 'max:35',
                    'MDistrictIDB' => 'required|numeric',
                    'MThanaIDB' => 'required|numeric',
                    'MPOfficeB' => 'required|max:50',
                    'MVillageB' => 'required|max:50',
                    'PDistrictIDB' => 'required|numeric',
                    'PThanaIDB' => 'required|numeric',
                    'PPOfficeB' => 'required|max:50',
                    'PVillageB' => 'required|max:50',
                    'IdentificationB' => 'max:50',
                    'Conduct' => 'max:50',
                    'NomineeB' => 'max:35',
                    'RelationB' => 'max:30',
                    'NDistrictIDB' => 'sometimes|nullable|integer',
                    'NThanaIDB' => 'sometimes|nullable|integer',
                    'NPOfficeB' => 'max:50',
                    'NVillageB' => 'max:50'
                ];
                $validation = Validator::make($attributes, $rules);
                if ($validation->fails()) {
                    return redirect()->action('HRIS\Database\EmployeeController@show', $id . '?tab=' . $tab)->with('error', getNotify(4))->withErrors($validation)->withInput();
                } else {
                    $employeebangla->CreatedBy = $userid;
                    $employeebangla->updated_at = Carbon::now();
                    $employeebangla->fill($attributes)->save();

                    $employee->MDistrictID = $employeebangla->MDistrictIDB;
                    $employee->MThanaID = $employeebangla->MThanaIDB;
                    $employee->PDistrictID = $employeebangla->PDistrictIDB;
                    $employee->PThanaID = $employeebangla->PThanaIDB;
                    $employee->CreatedBy = $userid;
                    $employee->save();

                    $chkid2 = EmployeePersonal::where('EmployeeID', $employee->EmployeeID)->pluck('id')->first();
                    $employeepersonal = new EmployeePersonal();
                    $employeepersonal = EmployeePersonal::find($chkid2);
                    $employeepersonal->DistrictCode = $employee->PDistrictID;
                    $employeepersonal->NDistrictID = $employeebangla->NDistrictIDB;
                    $employeepersonal->NThanaID = $employeebangla->NThanaIDB;
                    $employeepersonal->CreatedBy = $userid;
                    $employeepersonal->save();

                    \LogActivity::addToLog('Edit Employee Bangla Info To ' . $employee->EmployeeID);
                    return redirect()->action('HRIS\Database\EmployeeController@show', $id . '?tab=' . $tab)->with('success', getNotify(2));
                }
            } elseif ($request->get('form') == 11) {
                $tab = 11;
                $granter = new EmployeeGranter();
                $rules = [
                    'g_name' => 'required',
                    'g_phone' => 'required',
                    'g_occupation' => 'required',
                    'g_email' => 'required',
                    'g_relation' => 'required',
                    'g_nid' => 'required',
                ];

                $validation = Validator::make($attributes, $rules);
                if ($validation->fails()) {
                    return redirect()->action('HRIS\Database\EmployeeController@show', $id . '?tab=' . $tab)->with('error', getNotify(4))->withErrors($validation)->withInput();
                } else {
                    if ($granterNID = $request->file('g_nid')) {
                        $destinationPath = 'public/career/granter_nid';
                        $g_nid = $request->g_name . '-' . date('YmdHis') . "." . $granterNID->getClientOriginalExtension();
                        $granterNID->move($destinationPath, $g_nid);
                    }
                    $employee = Employee::find($id);
                    $granter->EmployeeID = $employee->EmployeeID;
                    $granter->g_nid = $g_nid;
                    $granter->created_by = $userid;
                    $granter->fill($attributes)->save();
                    \LogActivity::addToLog('Add Employee granter Info To ' . $employee->EmployeeID);
                    return redirect()->action('HRIS\Database\EmployeeController@show', $id . '?tab=' . $tab)->with('success', getNotify(1));
                }
            } elseif ($request->get('form') == 12) {
                $tab = 12;
                $userid = Sentinel::getUser()->id;
                $user = User::find($userid);
                $user->makeVisible(['password']);
                $password = $user->password;
                $rules = [
                    'old_password' => 'required',
                    'password' => 'required|min:6|confirmed',
                ];
                $validation = Validator::make($attributes, $rules);
                if ($validation->fails()) {
                    return redirect()->action('HRIS\Database\EmployeeController@show', $id . '?tab=' . $tab)->with('error', getNotify(4))->withErrors($validation)->withInput();
                } else {
                    if (Hash::check($request->old_password, $user->password)) {
                        $user->update([
                            'password' => Hash::make($request->password),
                        ]);
                        $user->makeHidden(['password']);
                        \LogActivity::addToLog('Change employee password of ' . $user->empid);
                        return redirect()->action('HRIS\Database\EmployeeController@show', $id . '?tab=' . $tab)->with('success', getNotify(2));
                    } else {
                        // return "ds";
                        return redirect()->back()->with('error', 'Old password does not match.');
                    }
                }
            }
        } else {
            return redirect()->back()->with('warning', getNotify(5));
        }
    }

    public function getSearch()
    {
        if (getAccess('view')) {
            $tab = Input::get('TabNo');
            $tabNo = '';
            if ($tab) {
                $tabNo = $tab;
            } else {
                $tabNo = 1;
            }
            $query = Input::get('search');
            $id = Employee::orderBy('EmployeeID', 'ASC')->where('EmployeeID', $query)->pluck('id')->first();
            if ($id > 0) {
                return redirect()->action('HRIS\Database\EmployeeController@show', $id . '?tab=' . $tabNo);
            } else {
                return redirect()->action('HRIS\Database\EmployeeController@index')->with('info', getNotify(7))->withInput();
            }
        } else {
            return redirect()->back()->with('warning', getNotify(5));
        }
    }

    public function getSubGrade(Request $request)
    {
        $subgrade = Designation::where("id", $request->desg_id)->pluck('Grade')->first();
        return response()->json($subgrade);
    }

    public function getThana(Request $request)
    {
        if ($request->type == 'forForntend') {
            $tahana = DB::table('hr_setup_thanas')->where("DistrictID", $request->dist_id)->get();
            return response()->json($tahana);
        } else {
            $tahana = DB::table('hr_setup_thanas')->where("DistrictID", $request->dist_id)->pluck("Name", "id");
            return response()->json($tahana);
        }
    }

    public function getThanaBn(Request $request)
    {
        $tahana = DB::table('hr_setup_thanas')->where("DistrictID", $request->dist_idbn)->pluck("NameB", "id");
        return response()->json($tahana);
    }

    public function getEmployee(Request $request)
    {
        $employee = DB::table('hr_database_employee_basic')->where("EmployeeID", $request->emp_id)->pluck("Name");
        return response()->json($employee);
    }

    public function getEmployeeList(Request $request)
    {
        if (getAccess('view')) {
            $concern_id =  $request->concern_id;
            $department_id =  $request->department_id;
            $concernI = Company::where('id', $request->concern_id)->first();
            $departmentID = Department::where('id', $request->department_id)->first();
            $concerns = Company::where('C4S', 'Y')->get();
            $departments = Department::where('C4S', 'Y')->get();
            $employees = DB::table('hr_database_employee_basic as emp')
                ->where('ReasonID','N')
                ->where('emp.company_id',getHostInfo()['id'])
                ->leftJoin('hr_setup_department as dept', 'dept.id', '=', 'emp.DepartmentID')
                ->leftJoin('hr_setup_designation as dsg', 'dsg.id', '=', 'emp.DesignationID')
                ->leftJoin('lib_company as comp', 'comp.id', '=', 'emp.company_id')
                ->select('emp.id as id', 'emp.EmployeeID', 'emp.Name', 'comp.Name as concern', 'emp.C4S', 'dept.Department', 'dsg.Designation')
                ->orderBy('emp.created_at', 'desc')
                ->get();

            // if ($concern_id !== null && $department_id !== null) {
            //     $employeesQuery->where('emp.company_id', $concern_id)
            //         ->where('emp.DepartmentID', $department_id);
            // } elseif ($concern_id !== null) {
            //     $employeesQuery->where('emp.company_id', $concern_id);
            // } elseif ($department_id !== null) {
            //     $employeesQuery->where('emp.DepartmentID', $department_id);
            // }
            //$employees = $employeesQuery;

            return view('hris.database.employee.empolyee', compact('employees', 'concerns', 'departments', 'concernI', 'department_id', 'concern_id'));
        } else {
            return redirect()->back()->with('warning', getNotify(5));
        }
    }

    public function getBEmployeeList()
    {
        $today = Carbon::now()->format('m-d'); // Get today's date in MM-DD format
        $b_employees = Employee::join('hr_database_employee_personal as personal', 'personal.EmployeeID', '=', 'hr_database_employee_basic.EmployeeID')
            ->whereRaw("DATE_FORMAT(personal.BirthDate, '%m-%d') = '{$today}'")
            ->where('ReasonID','N')
            ->select('hr_database_employee_basic.Name', 'hr_database_employee_basic.EmployeeID', 'personal.BirthDate')
            ->get();

        return view('hris.database.employee.b_employee', compact('b_employees'));
    }

    public function destroy($id) {
        if (getAccess('delete')) {
            $user = User::where('empid', $id)->first();
            if ($user) {
                // Define a list of  models related to the Employee model
                $checkSalary = ProcessSalary::where('EmployeeID',$id)->where('Confirmed')->first();
                if(!$checkSalary){
                    $relatedModels = [
                        Employee::class,
                        EmployeeSalary::class,
                        EmployeePersonal::class,
                        EmployeeReference::class,
                        EmployeeEducation::class,
                        EmployeeExperience::class,
                        EmployeeTraining::class,
                        ShiftingList::class,
                        ExceptionalHD::class,
                        HDException::class,
                        EmployeePerformance::class,
                        PunchData::class,
                        ProcessAttendance::class,
                    ];
                    // Iterate through the related models and delete records if they exist
                    foreach ($relatedModels as $model) {
                        $records = $model::where('EmployeeID', $id)->get();
                        if ($records->count() > 0) {
                            foreach ($records as $item) {
                                $item->delete();
                            }
                        }
                    }
                    return redirect()->back()->with('warning', getNotify(3));
                }else{
                    return redirect()->back()->with('warning', getNotify(10));
                }

            }
        } else {
            return redirect()->back()->with('warning', getNotify(5));
        }
    }

    public function attendanceApprovalRequestList(Request $request)
    {
        if (getAccess('view')) {
            $userid = Sentinel::getUser()->id;
            $empid = Sentinel::getUser()->empid;
            $startdate = Carbon::now()->subDays(7)->startOfMonth()->format('Y-m-d');
            $enddate = Carbon::now()->endOfMonth()->format('Y-m-d');
            if (Sentinel::inRole('superadmin')) {
                $leaveid = AttendanceApproval::orderBy('id', 'DESC')->whereBetween('effective_date', [$startdate, $enddate])->pluck('id');
            } else {
                $uempid = Sentinel::getUser()->empid;
                $forwardid = ForwardPermission::orderBy('EmployeeID', 'ASC')->where('UserID', $userid)->pluck('EmployeeID')->toArray();
                $approveid = ApprovePermission::orderBy('EmployeeID', 'ASC')->where('UserID', $userid)->pluck('EmployeeID')->toArray();
                $permids = array_merge($forwardid, $approveid);
                $leaveid = AttendanceApproval::orderBy('id', 'DESC')->whereIn('EmployeeID', $permids)->whereBetween('effective_date', [$startdate, $enddate])->orWhere('EmployeeID', $uempid)->whereBetween('effective_date', [$startdate, $enddate])->pluck('id');
            }
            $attendanceApprovals = AttendanceApproval::join('hr_database_employee_basic', 'hr_database_employee_basic.EmployeeID', '=', 'hr_database_attn_approval.EmployeeID')
            ->leftJoin('hr_setup_designation', 'hr_database_employee_basic.DesignationID', '=', 'hr_setup_designation.id')
            ->where('hr_database_attn_approval.company_id', getHostInfo()['id'])
            ->whereIn('hr_database_attn_approval.id', $leaveid)
            ->select('hr_database_attn_approval.*','hr_database_employee_basic.Name','hr_setup_designation.Designation')
            ->get();
            // return $attendanceApprovals;
            return view('hris.database.attendance.index', compact('attendanceApprovals', 'empid'));
        } else {
            return redirect()->back()->with('warning', getNotify(5));
        }
    }

    public function getHistory()
    {
        if (getAccess('view')) {
            $query = Input::get('search');
            $employee = Employee::orderBy('EmployeeID', 'ASC')->where('EmployeeID', $query)->first();
            $interiviewEvaluations = EmpInterviewFeedback::where('emp_id',$employee->EmpEntryID)->get();
            $attributes = [
                'appearance',
                'attitude_cooperation',
                'expression_communication',
                'job_knowledge',
                'initiative_decision_making',
                'dependability_leadership',
            ];
            // Calculate averages for each attribute
            $averages = [];
            foreach ($attributes as $attribute) {
                // Extract values for the current attribute
                $attributeValues = collect($interiviewEvaluations)->pluck($attribute)->reject(function ($value) {
                    return $value === null;
                });

                // Calculate the average for the current attribute
                $average = $attributeValues->count() > 0 ? $attributeValues->average() : 0;

                // Store the average in the $averages array
                $averages[$attribute] = $average;
            }

            $performance = EmployeePerformance::where('EmployeeID', $query)->get();
            $performanceDetails = [];
            $lastTotalTopicRating = "";
            $lastTotalAchiveTopicRating = "";

            if ($performance->isNotEmpty()) { // Check if the collection is not empty
                foreach ($performance as $item) {
                    $performanceDetails[] = EmployeePerformanceDetails::join('hr_setup_job_appraisals as topic', 'topic.id', '=', 'hr_database_employee_perfor_details.appraisal_id')
                        ->where('hr_database_employee_perfor_details.performance_id', $item->id)
                        ->select('hr_database_employee_perfor_details.*', 'topic.name')
                        ->get();
                }
            }

             $performanceDetails;
            // Initialize an array to store the ratings for each appraisal topic
            $appraisalAverages = [];

            // Join the hr_setup_job_appraisals table to get topic names
            foreach ($performanceDetails as $performanceGroup) {
                foreach ($performanceGroup as $performanceRecord) {
                    $appraisalId = $performanceRecord['appraisal_id'];
                    $rating = $performanceRecord['rating'];

                    // If the appraisal_id is not in the averages array, initialize it
                    if (!isset($appraisalAverages[$appraisalId])) {
                        $appraisalAverages[$appraisalId] = ['total' => 0, 'count' => 0, 'topic_name' => null];
                    }

                    // Add the rating to the total for the appraisal_id
                    $appraisalAverages[$appraisalId]['total'] += $rating;
                    // Increment the count for the appraisal_id
                    $appraisalAverages[$appraisalId]['count']++;

                    // If the topic name is not already retrieved, fetch it from the database
                    if ($appraisalAverages[$appraisalId]['topic_name'] === null) {
                        $topic = JobAppraisal::find($appraisalId); // Adjust the model name as needed
                        $appraisalAverages[$appraisalId]['topic_name'] = $topic ? $topic->name : null;
                    }
                }
            }

            // Calculate the average for each appraisal topic
            foreach ($appraisalAverages as &$average) {
                // Check if count is greater than 0 to avoid division by zero
                if ($average['count'] > 0) {
                    $average['average'] = $average['total'] / $average['count'];
                } else {
                    $average['average'] = 0; // Default to 0 if count is 0
                }
            }

            $totalTask = [];



            $ppsize = 1;
            $userid = Sentinel::getUser()->id;
            $CreatedBy = $userid;
            $caption = 'History of '.$employee->Name;
            $parameter = compact('employee','ppsize','CreatedBy','averages','interiviewEvaluations','appraisalAverages');
            $pdf = PDF::loadView('hris.reports.employee.index', $parameter)->setPaper('A4', 'portrait');
            return $pdf->stream("$caption".".pdf");
        } else {
            return redirect()->back()->with('warning', getNotify(5));
        }
    }
}
