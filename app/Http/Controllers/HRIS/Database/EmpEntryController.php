<?php

namespace App\Http\Controllers\HRIS\Database;

use App\Http\Controllers\Controller;
use App\Models\IPE\Setup\NotRecruitReason;
use App\Models\HR\Setup\Designation;
use App\Models\HR\Setup\Districts;
use App\Models\HR\Setup\Department;
use App\Models\HR\Database\Assessment;
use App\Models\HR\Database\EmpEntry;
use App\Models\PMIS\Database\Employee;
use Redirect;
use Sentinel;
use Input;
use Validator;
use Flash;
use PDF2;
use PDF;
use DB;
use Carbon\Carbon;

class EmpEntryController extends Controller
{

    public function index()
    {
        if (getAccess('view')) {
            $userid = Sentinel::getUser()->id;
            $time = Carbon::now()->format('Y-m-d');
            $desglist = Designation::orderBy('id', 'ASC')->where('C4S', 'Y')->select(DB::raw("CONCAT(id,' | ',Designation) AS full_name, id"))->pluck('full_name', 'id');
            $deptlist = Department::orderBy('id', 'ASC')->where('FinalUse', 'Y')->where('C4S', 'Y')->select(DB::raw("CONCAT(id,' | ',Department) AS full_name, id"))->pluck('full_name', 'id');
            $districtlist = Districts::orderBy('id', 'ASC')->where('C4S', 'Y')->pluck('Name', 'id');

            $pendingAssessment = DB::table('hr_database_emp_entry as entry')
                ->where('FinalStatus', 0)
                ->orderBy('DepartmentID', 'ASC')
                ->orderBy('EntryDate', 'DESC')
                ->orderBy('id', 'DESC')
                ->get();
            $deptids = collect($pendingAssessment)->unique('DepartmentID')->pluck('DepartmentID');
            $departments = DB::table('mer_department')->orderBy('Department', 'ASC')->whereIn('id', $deptids)->get();

            return view('hr.database.empentry.index', compact('menus', 'childmenus', 'uniquemenu', 'createpermission', 'deptlist', 'desglist', 'districtlist', 'empentry', 'pendingAssessment', 'departments'));
        } else {
            return redirect()->back()->with('warning', getNotify(5));
        }
    }

    public function departmentByDesignationGet($id)
    {
        $data = DB::table('pmis_database_employee_basic')
            ->where('DepartmentID', $id)
            ->leftJoin('pmis_setup_designation', 'pmis_database_employee_basic.DesignationID', '=', 'pmis_setup_designation.id')
            ->select(DB::raw("CONCAT(pmis_setup_designation.id,' | ',pmis_setup_designation.Designation) AS full_name, pmis_database_employee_basic.DesignationID"), 'pmis_database_employee_basic.DesignationID')
            ->groupBy('DesignationID')
            ->get();

        return $data;
    }

    public function store()
    {
        if (getAccess('create')) {
            $userid = Sentinel::getUser()->id;
            $attributes = Input::all();
            $empEntry = new EmpEntry();
            $rules = [
                'Name' => 'required|max:35',
                'DepartmentID' => 'required|numeric',
                'DesignationID' => 'required|numeric',
                'MDistrictID' => 'required|numeric',
                'MobileNo' => 'required|regex:/^(?:\01)?(?:\d{11})$/'
            ];
            if ($attributes['identification'] == 0) {
                $rules = $rules + [
                    'NationalIDNo' => 'regex:/[0-9]{10,17}/',
                ];
                $attributes['BirthCertificate'] = null;
            } else if ($attributes['identification'] == 1) {
                $rules = $rules + [
                    'BirthCertificate' => 'regex:/[0-9]{10,20}/',
                ];
                $attributes['NationalIDNo'] = null;
            } else {
                $attributes['BirthCertificate'] = null;
                $attributes['NationalIDNo'] = null;
            }

            $validation = Validator::make($attributes, $rules);
            if ($validation->fails()) {
                Flash::message('Selected fields are required...', 'danger');
                return Redirect::action('HR\Database\EmpEntryController@index')->withErrors($validation)->withInput();
            } else {
                $mobno = $attributes['MobileNo'];
                $nid = $attributes['NationalIDNo'];
                $bcert = $attributes['BirthCertificate'];

                $chknid = EmployeePersonalInfo::where('NationalIDNo', $nid)->Orwhere('MobileNo', $mobno)->first();
                if ($chknid) {
                    Flash::message('This is a Lefty Employee, You can not entry with provided information Again. Previous Employee ID: ' . $chknid->EmployeeID, 'danger')->important();
                    return Redirect::action('HR\Database\EmpEntryController@index')->withInput();
                }
                if (isset($attributes['IPAssessmentRequired'])) { // && $attributes['IPAssessmentRequired'] == 1
                    $attributes['IPAssessmentRequired'] = 1;
                    $DepartmentID = $attributes['DepartmentID'];
                    if (array_search($DepartmentID, $assessmentDepartmentID) === false) {
                        Flash::message("This software does not currently include this department assessment process.", 'danger');
                        return Redirect::action('HR\Database\EmpEntryController@index')->withInput();
                    }
                } else {
                    $attributes['IPAssessmentRequired'] = 0;
                }
                $checkDoubleEntry = EmpEntry::where('EntryDate', date("Y-m-d"))->where('MobileNo', $attributes['MobileNo'])->first();
                if ($checkDoubleEntry != null) {
                    Flash::message("This Phone Number is already added today...", 'danger');
                    return Redirect::action('HR\Database\EmpEntryController@index')->withInput();
                }

                $empEntry->EntryDate = date("Y-m-d");
                $empEntry->FinalDesignationID = $attributes['DesignationID'];
                $empEntry->CreatedBy = $userid;

                $empEntry->fill($attributes)->save();
                $id = $empEntry->id;
                \LogActivity::addToLog('Add New Employee Entry. ID ' . $id);

                Flash::message("Data Inserted Successfully.", 'success');
                return Redirect::action('HR\Database\EmpEntryController@show', $id)->with('message', 'Success');
            }
        } else {
            return redirect()->back()->with('warning', getNotify(5));
        }
    }

    public function empentryinfo($id)
    {
        $empentry = DB::table('hr_database_emp_entry')->where('id', $id)->first();

        return ["status" => "", "data" => $empentry];
    }

    public function show($id)
    {
        if (getAccess('view')) {
            $desglist = Designation::orderBy('id', 'ASC')->where('C4S', 'Y')->select(DB::raw("CONCAT(id,' | ',Designation) AS full_name, id"))->pluck('full_name', 'id');
            $deptlist = Department::orderBy('Department', 'ASC')->where('FinalUse', 'Y')->where('C4S', 'Y')->select(DB::raw("CONCAT(id,' | ',Department) AS full_name, id"))->pluck('full_name', 'id');
            $districtlist = Districts::orderBy('id', 'ASC')->where('C4S', 'Y')->pluck('Name', 'id');
            $notrecruitreason = NotRecruitReason::orderBy('id', 'ASC')->where('C4S', 'Y')->pluck('Name', 'id');

            $pendingAssessment = DB::table('hr_database_emp_entry as entry')
                ->where('FinalStatus', 0)
                ->select('entry.*')
                ->orderBy('DepartmentID', 'ASC')
                ->orderBy('EntryDate', 'DESC')
                ->orderBy('id', 'DESC')
                ->get();

            $deptids = collect($pendingAssessment)->unique('DepartmentID')->pluck('DepartmentID');
            $departments = DB::table('mer_department')->orderBy('Department', 'ASC')->whereIn('id', $deptids)->get();
            return view('hr.database.empentry.show', compact('menus', 'childmenus', 'uniquemenu', 'editpermission', 'deletepermission', 'deptlist', 'desglist', 'districtlist', 'pendingAssessment', 'empEntry', 'departments', 'notrecruitreason'));
        } else {
            return redirect()->back()->with('warning', getNotify(5));
        }
    }

    public function pdf($id)
    {
        if (getAccess('view')) {
            $empEntry = DB::table('hr_database_emp_entry')
                ->where('hr_database_emp_entry.id', $id)
                ->leftJoin('mer_department', 'hr_database_emp_entry.DepartmentID', '=', 'mer_department.id')
                ->leftJoin('pmis_setup_designation', 'hr_database_emp_entry.DesignationID', '=', 'pmis_setup_designation.id')
                ->leftJoin('hr_setup_districts', 'hr_database_emp_entry.MDistrictID', '=', 'hr_setup_districts.id')
                ->select('hr_database_emp_entry.*', 'mer_department.Department', 'pmis_setup_designation.Designation', 'pmis_setup_designation.Designation', 'hr_setup_districts.Name as District')
                ->first();

            $mobno = $empEntry->MobileNo;
            $nid = $empEntry->NationalIDNo;
            $bcert = $empEntry->BirthCertificate;

            if ($mobno && $nid) {
                $duplicate = EmpEntry::orderBy('id', 'ASC')->where('id', '!=', $id)->where('MobileNo', $mobno)->Orwhere('NationalIDNo', $nid)->where('NationalIDNo', '!=', null)->where('id', '!=', $id)->count();
            } elseif ($mobno && $bcert) {
                $duplicate = EmpEntry::orderBy('id', 'ASC')->where('id', '!=', $id)->where('MobileNo', $mobno)->Orwhere('BirthCertificate', $bcert)->where('BirthCertificate', '!=', null)->where('id', '!=', $id)->count();
            } else {
                $duplicate = EmpEntry::orderBy('id', 'ASC')->where('id', '!=', $id)->where('MobileNo', $mobno)->count();
            }

            $parameter = array();
            $parameter['empEntry'] = $empEntry;
            $parameter['duplicate'] = $duplicate;
            $parameter['userid'] = $userid;
            $customPaper = array(0, 0, 218, 150);

            $pdf = PDF::loadView('hr.database.empentry.pdf', $parameter)->setPaper($customPaper, 'portrait');
            return $pdf->stream("Applicant ID Card For ID-$empEntry->id.pdf");
        } else {
            return redirect()->back()->with('warning', getNotify(5));
        }
    }

    public function getSearch()
    {
        if (getAccess('view')) {
            $query = Input::get('search');
            $empEntry = EmpEntry::find($query);
            if ($empEntry != null) {
                return Redirect::action('HR\Database\EmpEntryController@show', $empEntry->id);
            } else {
                Flash::error('No Information Found Matches Your Query', 'danger');
                return Redirect::action('HR\Database\EmpEntryController@index')->with('message', 'Danger');
            }
        } else {
            return redirect()->back()->with('warning', getNotify(5));
        }
    }

    public function destroy($id)
    {
        if (getAccess('view')) {
            $empEntry = EmpEntry::find($id);

            if ($empEntry->FileEntryDone != "N") {
                Flash::error("This Applicant is now Employee. You can not Delete now...");
                return Redirect::action('HR\Database\EmpEntryController@show', $id)->with('message', 'Danger');
            }
            $empEntry->delete();

            Flash::message('Data Successfully Deleted..', 'success');
            \LogActivity::addToLog('Delete Employee Entry ID: ' . $id);
            return Redirect::action('HR\Database\EmpEntryController@index')->with('message', 'Success');
        } else {
            return redirect()->back()->with('warning', getNotify(5));
        }
    }

    public function update($id)
    {
        if (getAccess('edit')) {
            $userid = Sentinel::getUser()->id;
            $attributes = Input::all();
            $empEntry = EmpEntry::find($id);

            if ($userid == 1) {
                $exdeptid = $empEntry->DepartmentID;
                $newdeptid = $attributes['DepartmentID'];

                if ($exdeptid != $newdeptid && $empEntry->EmployeeID == 0) {
                    DB::table('hr_database_emp_entry')->where('id', $id)->where('DepartmentID', $exdeptid)->update(['DepartmentID' => $newdeptid]);
                    DB::table('hr_database_assessment')->where('EmpEntryID', $id)->where('DepartmentID', $exdeptid)->update(['DepartmentID' => $newdeptid]);

                    return response()->json(array('success' => 'Department Successfully Changed.'));
                }
            }


            if (isset($attributes['Form']) && $attributes['Form'] == 4) {
                $rules = [
                    'EmployeeID' => 'required|numeric',
                    'FinalDesignationID' => 'required|numeric',
                ];
                $validation = Validator::make($attributes, $rules);
                if ($validation->fails()) {
                    return response()->json(array('errors' => 'Validation Error..'));
                } else {
                    if ($empEntry->FileEntryDone != "N") {
                        return response()->json(array('errors' => "This Applicant is now Employee.<br/>You can not change now..."));
                    }
                    if ($empEntry->FinalStatus != 1) {
                        return response()->json(array('errors' => "You can change when this applicant selected.."));
                    }
                    $check = Employee::where('EmployeeID', $attributes['EmployeeID'])->first();
                    if ($check != null) {
                        return response()->json(array('errors' => "This Employee ID already use.."));
                    }
                    $check = EmpEntry::where('EmployeeID', $attributes['EmployeeID'])->where('id', '!=', $id)->first();
                    if ($check != null) {
                        return response()->json(array('errors' => "This Employee ID already used, Applicant Card#: " . $check->id));
                    }

                    $rectype = $attributes['RecTypeID'];
                    if ($rectype == 'R') {
                        $replaceid = $attributes['ReplaceID'];
                    } else {
                        $replaceid = 0;
                    }

                    $empEntry->FinalDesignationID = $attributes['FinalDesignationID'];
                    $empEntry->EmployeeID = $attributes['EmployeeID'];
                    $empEntry->RecTypeID = $rectype;
                    $empEntry->ReplaceID = $replaceid;
                    $empEntry->updated_at = Carbon::now();
                    $empEntry->update();
                    \LogActivity::addToLog('Update Applicant Information ' . $empEntry->id);

                    return response()->json(array('success' => 'Employee ID added Successfully.'));
                }
            } elseif (isset($attributes['Form']) && $attributes['Form'] == 5) {
                $rules = [
                    'Absent' => 'required',
                ];
                $validation = Validator::make($attributes, $rules);
                if ($validation->fails()) {
                    return response()->json(array('errors' => 'Validation Error..'));
                } else {
                    if ($empEntry->FileEntryDone != "N") {
                        return response()->json(array('errors' => "This Applicant is now Employee.<br/>You can not change now..."));
                    }
                    if ($empEntry->FinalStatus != 1) {
                        return response()->json(array('errors' => "You can change when this applicant selected.."));
                    }

                    $empEntry->Absent = $attributes['Absent'];
                    $empEntry->updated_at = Carbon::now();
                    $empEntry->update();
                    \LogActivity::addToLog('Update Applicant Information ' . $empEntry->id);

                    return response()->json(array('success' => 'Data added Successfully.'));
                }
            }


            $rules = [
                'Name' => 'required|max:35',
                'DepartmentID' => 'required|numeric',
                'DesignationID' => 'required|numeric',
                'MDistrictID' => 'required|numeric',
                'MobileNo' => 'required|regex:/^(?:\01)?(?:\d{11})$/',
            ];

            if ($attributes['identification'] == 0) {
                $rules = $rules + [
                    'NationalIDNo' => 'regex:/[0-9]{10,17}/',
                ];
                $attributes['BirthCertificate'] = "";
            }
            if ($attributes['identification'] == 1) {
                $rules = $rules + [
                    'BirthCertificate' => 'regex:/[0-9]{10,20}/',
                ];
                $attributes['NationalIDNo'] = "";
            }

            if (isset($attributes['FinalStatus']) && $attributes['FinalStatus'] == 1) {
                $rules = $rules + [
                    'JoiningDate' => 'required|date_format:Y-m-d',
                    'InitialSalary' => 'required|numeric|between:0,150000',
                    'OtherAllowance' => 'numeric|between:0,9999',
                ];
            } else if (isset($attributes['FinalStatus']) && $attributes['FinalStatus'] == 3) {
                $rules = $rules + [
                    'DetermineSalary' => 'required|numeric|between:5000,150000',
                    'DemandSalary' => 'required|numeric|between:5000,150000',
                    'NotRecruitReasonID' => 'required|numeric',
                ];
            }

            if (isset($attributes['FinalStatus']) && $attributes['FinalStatus'] != 0) {
                $rules = $rules + [
                    'InterviewBy' => 'required|numeric',
                ];
            }

            $validation = Validator::make($attributes, $rules);
            if ($validation->fails()) {
                return response()->json(array('errors' => 'Validation Error..'));
            } else {
                if (isset($attributes['FinalStatus']) && ($attributes['FinalStatus'] == 2) && empty($attributes['Remarks'])) {
                    return response()->json(array('errors' => 'You must add remark...'));
                }

                if ($empEntry->FileEntryDone != "N") {
                    return response()->json(array('errors' => "This Applicant is now Employee.<br/>You can not change now..."));
                }

                if (isset($attributes['InterviewBy']) && (isset($attributes['FinalStatus']) && $attributes['FinalStatus'] != 0)) {
                    $check = Employee::where('EmployeeID', $attributes['InterviewBy'])->first();
                    if ($check == null) {
                        return response()->json(array('errors' => 'Interviewer ID not match.'));
                    }
                }

                $attributes['JoiningDate'] = "";
                $attributes['InitialSalary'] = "";
                $attributes['OtherAllowance'] = "";
                $attributes['NegotiateApplyDate'] = "";
                $attributes['NegotiateSalary'] = "";
                $attributes['DetermineSalary'] = "";
                $attributes['DemandSalary'] = "";
                $attributes['NotRecruitReasonID'] = "";

                $attributes['InitialSalary'] = $attributes['InitialSalary'];
                $attributes['DetermineSalary'] = $attributes['InitialSalary'];

                if (isset($attributes['DesignationID'])) {
                    $empEntry->FinalDesignationID = $attributes['DesignationID'];
                }

                $empEntry->updated_at = Carbon::now();
                $empEntry->fill($attributes)->update();
                \LogActivity::addToLog('Update Employee Entry Information' . $empEntry->id);

                return response()->json(array('success' => 'Data Updated Successfully.'));
            }
        } else {
            return response()->json(array('errors' => 'You Are Not Permitted 2'));
        }
    }
}
