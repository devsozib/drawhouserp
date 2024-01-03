<?php

namespace App\Http\Controllers\HRIS\Setup;

use Sentinel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\HRIS\Setup\Job;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\HRIS\Setup\Department;
use App\Models\HRIS\Database\EmpEntry;
use App\Models\HRIS\Setup\Designation;
use App\Models\Library\General\Company;
use Illuminate\Support\Facades\Validator;

class JobPostController extends Controller
{
    public function index()
    {
        if (getAccess('view')) {
            $items = Job::join('lib_company', 'hr_setup_jobs.company_id', '=', 'lib_company.id')
                ->join('hr_setup_department', 'hr_setup_jobs.dept_id', '=', 'hr_setup_department.id')
                ->join('hr_setup_designation', 'hr_setup_jobs.desg_id', '=', 'hr_setup_designation.id')
                ->select('hr_setup_jobs.*', 'lib_company.Name', 'hr_setup_department.Department', 'hr_setup_designation.Designation')
                ->orderBy('hr_setup_jobs.id', 'desc')
                ->get();

            return view('hris.setup.jobPost.index', compact('items'));
        } else {
            return redirect()->back()->with('warning', getNotify(5));
        }
    }

    public function create()
    {
        if (getAccess('create')) {
            $companies = Company::where('id',getHostInfo()['id'])->where('C4S', 'Y')->orderBy('id', 'ASC')->get();
            $depts = Department::whereRaw("FIND_IN_SET(?, company_id)", [getHostInfo()['id']])->where('C4S', 'Y')->orderBy('id', 'ASC')->get();
            $desgs = Designation::whereRaw("FIND_IN_SET(?, company_id)", [getHostInfo()['id']])->where('C4S', 'Y')->orderBy('id', 'ASC')->get();
            return view('hris.setup.jobPost.create', compact('companies', 'depts', 'desgs'));
        } else {
            return redirect()->back()->with('warning', getNotify(5));
        }
    }

    public function store(Request $request)
    {
        if (getAccess('create')) {
            $userid = Sentinel::getUser()->id;
            $attributes = $request->all();
            // return $attributes;
            $rules = [
                'company_id' => 'required',
                'dept_id' => 'required',
                'desg_id' => 'required',
                'location' => 'required',
                'vacancy' => 'required|numeric|min:1',
                'job_type' => 'required',
                'deadline' => 'required',
                'description' => 'required',
                'status' => 'required',
            ];

            $validation = Validator::make($attributes, $rules);
            if ($validation->fails()) {
                return redirect()->action('HRIS\Setup\JobPostController@create')->with(['error' => getNotify(4), 'error_code' => 'Add'])->withErrors($validation)->withInput();
            } else {
                $item = new Job();
                $item->company_id = $attributes['company_id'];
                $item->dept_id = $attributes['dept_id'];
                $item->desg_id = $attributes['desg_id'];
                $item->location = $attributes['location'];
                $item->vacancy = $attributes['vacancy'];
                $item->job_type = $attributes['job_type'];
                $deadline = Carbon::createFromFormat('Y-m-d', $attributes['deadline']);
                $item->deadline = $deadline;
                $item->description = $attributes['description'];
                $item->note = $attributes['note'];
                $item->created_by = $userid;
                $item->status = $attributes['status'];
                $item->save();
                \LogActivity::addToLog('Add Job Post ' . $attributes['desg_id']);
                return redirect()->action('HRIS\Setup\JobPostController@create')->with('success', getNotify(1));
            }
        } else {
            return redirect()->back()->with('warning', getNotify(5));
        }
    }

    public function edit($id)
    {

        if (getAccess('edit')) {
            $id = decrypt($id);
            $item = Job::findOrFail($id);
            $depts = Department::where('C4S', 'Y')->orderBy('id', 'ASC')->get();
            $desgs = Designation::where('C4S', 'Y')->orderBy('id', 'ASC')->get();
            $companies = Company::where('C4S', 'Y')->orderBy('id', 'ASC')->get();
            return view('hris.setup.jobPost.edit', compact('item', 'depts', 'desgs', 'companies'));
        } else {
            return redirect()->back()->with('warning', getNotify(5));
        }
    }

    public function update(Request $request, $id)
    {
        if (getAccess('create')) {
            $userid = Sentinel::getUser()->id;
            $attributes = $request->all();
            // return $attributes;
            $rules = [
                'company_id' => 'required',
                'dept_id' => 'required',
                'desg_id' => 'required',
                'location' => 'required',
                'vacancy' => 'required|numeric|min:1',
                'job_type' => 'required',
                'deadline' => 'required',
                'description' => 'required',
                'status' => 'required',
            ];
            $item = Job::findOrFail($id);

            $validation = Validator::make($attributes, $rules);
            if ($validation->fails()) {
                return redirect()->action('HRIS\Setup\JobPostController@edit')->with(['error' => getNotify(4), 'error_code' => 'Add'])->withErrors($validation)->withInput();
            } else {
                $item->company_id = $attributes['company_id'];
                $item->dept_id = $attributes['dept_id'];
                $item->desg_id = $attributes['desg_id'];
                $item->location = $attributes['location'];
                $item->vacancy = $attributes['vacancy'];
                $item->job_type = $attributes['job_type'];
                $deadline = Carbon::createFromFormat('Y-m-d', $attributes['deadline']);
                $item->deadline = $deadline;
                $item->description = $attributes['description'];
                $item->note = $attributes['note'];
                $item->updated_by = $userid;
                $item->status = $attributes['status'];
                $item->update();
                \LogActivity::addToLog('Update Job Post ' . $item->Designation);
                return redirect()->action('HRIS\Setup\JobPostController@index')->with('success', getNotify(2));
            }
        } else {
            return redirect()->back()->with('warning', getNotify(5));
        }
    }

    public function destroy($id)
    {
        if (getAccess('delete')) {
            $item = Job::findOrFail($id);
            $item->delete();
            \LogActivity::addToLog('Delete Job Post ' . $item->Designation);
            return redirect()->action('HRIS\Setup\JobPostController@index')->with('success', getNotify(3));
        } else {
            return redirect()->back()->with('warning', getNotify(5));
        }
    }

    public function show($id)
    {
        $id = decrypt($id);
        $job =  Job::join('lib_company', 'hr_setup_jobs.company_id', '=', 'lib_company.id')
            ->join('hr_setup_department', 'hr_setup_jobs.dept_id', '=', 'hr_setup_department.id')
            ->join('hr_setup_designation', 'hr_setup_jobs.desg_id', '=', 'hr_setup_designation.id')
            ->select('hr_setup_jobs.*', 'lib_company.Name', 'hr_setup_department.Department', 'hr_setup_designation.Designation')
            ->where('hr_setup_jobs.id', $id)
            ->first();
        return view('hris.career.job_details', compact('job'));
    }

    public function applyJobManually(){
        if (auth()->guard('empuser')->check()) {
            $desgs = Designation::whereRaw("FIND_IN_SET(?, company_id)", [getHostInfo()['id']])->where('C4S', 'Y')->orderBy('id', 'ASC')->get();
            return view('hris.career.applymanually',compact('desgs'));
        } else {
            session(['redirect_to_apply_job_manually' => '1']);
            return redirect()->route('empuser.login');
        }
        
    }

    public function applyJobManuallyPost(Request $request){
        $desgnation_id = $request->designation_id;
        $attributes = $request->all();
       
        $checkEmp = EmpEntry::where('emp_user_id', Auth::guard('empuser')->user()->id)->where('designation_id', $desgnation_id)->where('apply_type','manual')->first();
        if (!$checkEmp) {

            $rules = [
                'name'              => 'required',
                'email'             => 'required|email',
                'phone'             => 'required|regex:/^([0-9\s\-\+\(\)]*)$/',
                'designation_id'    => 'required',
                'NationalIDNo'      => 'required|regex:/^[0-9]{10}$/',
                'cv'                => 'required',
                'nid'               => 'required',
            ];
            $validation = Validator::make($attributes, $rules);
            if ($validation->fails()) {               
                return redirect()->back()->with(['error' => getNotify(4), 'error_code' => 'Add'])->withErrors($validation)->withInput();
            } else {
                $name =  Auth::guard('empuser')->user()->name;
                if ($cv = $request->file('cv')) {
                    $destinationPath = 'public/employee/applicant_cv';
                    $cv_name = $name . '-' . date('YmdHis') . "." . $cv->getClientOriginalExtension();
                    $cv->move($destinationPath, $cv_name);
                }           
                if ($nid = $request->file('nid')) {
                    $destinationPath = 'public/employee/nid';
                    $nid_name = $name . '-' . date('YmdHis') . "." . $nid->getClientOriginalExtension();
                    $nid->move($destinationPath, $nid_name);
                }
                if ($image = $request->file('image')) {
                    $destinationPath = 'public/employee/image';
                    $image_name = $name . '-' . date('YmdHis') . "." . $image->getClientOriginalExtension();
                    $image->move($destinationPath, $image_name);
                }else{
                    $image_name = null;
                }
                $empEntry = new EmpEntry();
                $empEntry->emp_user_id = Auth::guard('empuser')->user()->id;
                $empEntry->designation_id = $request->designation_id;               
                $empEntry->Name = $request->name;
                $empEntry->MobileNo =$request->phone;
                $empEntry->email = $request->email;       
                $empEntry->cvfile = $cv_name;
                $empEntry->nidfile = $nid_name;
                $empEntry->image = $image_name;
                $empEntry->NationalIDNo = $request->NationalIDNo;
                $empEntry->apply_type = 'manual';
                $empEntry->status = '0';
                $empEntry->save();
            }
            
            $userid =  Auth::guard('empuser')->user()->id;

            $applicant = DB::table('hr_database_emp_users as user')
            ->join('hr_database_emp_entry as emp', 'emp.emp_user_id', '=', 'user.id')
            ->join('hr_setup_designation as dsg', 'dsg.id', '=', 'emp.designation_id')            
            ->select('emp.id as emp_id', 'emp.Name', 'emp.MobileNo', 'emp.email', 'dsg.Designation')
            ->where('emp.designation_id', $request->designation_id)
            ->where('emp.emp_user_id', $userid)
            ->where('apply_type','manual')
            ->first();

            $dataForConfirmation = [
                'candidateEmail' =>  $applicant->email??null,
                'candidateName' =>  $applicant->Name??null,
                'candidatePhone' =>  $applicant->MobileNo??null,
                'designation' => $applicant->Designation??null,
                'department' => $applicant->Department??null,
            ];

            sendToConfirmation($request->email, $dataForConfirmation);
            session()->flash('success', 'Your job application was successful. Thank you');
            return redirect()->back();
        }else{            
            session()->flash('already_exists_message', 'You are already applied for this position');
            // Redirect back to the page with the form
            return redirect()->back();
        }
    }
}
