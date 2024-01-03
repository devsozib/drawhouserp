<?php

namespace App\Http\Controllers\HRIS\Setup;

use DB;
use Input;
use Redirect;
use Response;
use Sentinel;
use Validator;
use Svg\Tag\Rect;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\HRIS\Setup\Department;
use App\Models\HRIS\Setup\JobAppraisal;

class JobAppraisalController extends Controller
{
    public function index()
    {
        if (getAccess('view')) {
            $items = JobAppraisal::join('hr_setup_department', 'hr_setup_job_appraisals.department', '=', 'hr_setup_department.id')->select('hr_setup_job_appraisals.*', 'hr_setup_department.Department')->get();
            $deptlist = Department::orderBy('id', 'ASC')->get();
            return view('hris.database.job_appraisal.index', compact('items', 'deptlist'));
        } else {
            return redirect()->back()->with('warning', getNotify(5));
        }
    }

    public function store(Request $request)
    {
        if (getAccess('create')) {
            $userid = Sentinel::getUser()->id;
            $attributes = Input::all();
            $rules = [
                'name' => 'required',
                'department' => 'required',
                'status' => 'required',
                'part' => 'required',
            ];
            $validation = Validator::make($attributes, $rules);
            if ($validation->fails()) {
                return redirect()->back()->with(['error' => getNotify(4), 'error_code' => 'Add'])->withErrors($validation)->withInput();
            } else {
                $job_appraisals = new JobAppraisal();
                $job_appraisals->name = $request->name;
                $job_appraisals->department = $request->department;
                $job_appraisals->status = $request->status;
                $job_appraisals->part = $request->part;
                $job_appraisals->save();
                \LogActivity::addToLog('Add Job appraisal' .  $request->name);
                return redirect()->back()->with('success', getNotify(1));
            }
        } else {
            return redirect()->back()->with('warning', getNotify(5));
        }
    }

    public function update(Request $request, $id)
    {
        if (getAccess('edit')) {
            $userid = Sentinel::getUser()->id;
            $attributes = $request->all();
            // return $attributes;
            $rules = [
                'name' => 'required',
                'department' => 'required',
                'status' => 'required',
                'part' => 'required',
            ];
            $validation = Validator::make($attributes, $rules);
            if ($validation->fails()) {
                return redirect()->back()->with(['error' => getNotify(4), 'error_code' => $id])->withErrors($validation)->withInput();
            } else {
                $job_appraisals = JobAppraisal::findOrFail($id);
                $job_appraisals->name = $request->name;
                $job_appraisals->department = $request->department;
                $job_appraisals->status = $request->status;
                $job_appraisals->part = $request->part;
                $job_appraisals->update();
                \LogActivity::addToLog('Update Job appraisal' .  $request->name);
                return redirect()->back()->with('success', getNotify(1));
            }
        } else {
            return redirect()->back()->with('warning', getNotify(5));
        }
    }

    public function destroy($id)
    {
        if (getAccess('delete')) {
            $userid = Sentinel::getUser()->id;
            $job_appraisals = JobAppraisal::findOrFail($id);
            $job_appraisals->delete();
            \LogActivity::addToLog('Delete ingredient ' . $job_appraisals->name);
            return redirect()->back()->with('success', getNotify(3));
        } else {
            return redirect()->back()->with('warning', getNotify(5));
        }
    }
}
