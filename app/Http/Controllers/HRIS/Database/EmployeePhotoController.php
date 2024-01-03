<?php

namespace App\Http\Controllers\HRIS\Database;

use DB;
use File;
use Image;
use Input;
use Redirect;
use Sentinel;
use Validator;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\HRIS\Database\Employee;

class EmployeePhotoController extends Controller
{
    public function index()
    {
        if (getAccess('view')) {
            return view('hris.database.employeephoto.index');
        } else {
            return redirect()->back()->with('warning', getNotify(5));
        }
    }

    public function store(Request $request)
    {
        if (getAccess('create')) {
            $time = date('Y-m-d H:i:s');
            $userid = Sentinel::getUser()->id;
            $attributes = Input::all();
            $rules = [
                'EmployeeID' => 'required|numeric',
                'image' => 'mimes:jpg,jpeg,png|max:190000',
                'sign' => 'mimes:jpg,jpeg,png|max:190000',
            ];
            $validation = Validator::make($attributes, $rules);
            if ($validation->fails()) {
                return redirect()->back()->with('error', getNotify(4))->withErrors($validation)->withInput();
            } else {
                $chkemp = Employee::where('EmployeeID', $attributes['EmployeeID'])->first();
                if ($chkemp) {
                    $empid = $attributes['EmployeeID'];
                    $filep = null; $files = null;
                    if (isset($attributes['image'])) {
                        $filep = $attributes['image'];
                    }if (isset($attributes['sign'])) {
                        $files = $attributes['sign'];
                    }
                    if ($filep) {
                        $destinationPathp = 'public/profiles/';
                        $fileNamepp = $empid .'.'. $filep->getClientOriginalExtension();
                        File::delete($destinationPathp . $fileNamepp);
                        $fileSizep = $filep->getSize();
                        $upload_successp = $filep->move($destinationPathp, $fileNamepp);
                        if ($upload_successp) {
                            Image::make($destinationPathp . $fileNamepp)
                                ->resize(531, 650)                             
                                ->save($destinationPathp . $fileNamepp);
                            DB::table('hr_database_employee_basic')->where('EmployeeID', $attributes['EmployeeID'])->update(array('PhotoName' => $fileNamepp, 'updated_at' => $time));
                            DB::table('users')->where('empid', $attributes['EmployeeID'])->update(array('profile_image' => $fileNamepp));
                        }
                        \LogActivity::addToLog('Edit Photo Information To ' . $empid);
                    }
                    if ($files) {
                        $destinationPaths = 'public/sign/';
                        $fileNameps = $empid .'.'. $files->getClientOriginalExtension();
                        File::delete($destinationPaths . $fileNameps);
                        $fileSizes = $files->getSize();
                        $upload_successs = $files->move($destinationPaths, $fileNameps);
                        if ($upload_successs) {
                            Image::make($destinationPaths . $fileNameps)
                                ->resize(300, 80)
                                ->save($destinationPaths . $fileNameps);
                            DB::table('hr_database_employee_basic')->where('EmployeeID', $attributes['EmployeeID'])->update(array('SignName' => $fileNameps, 'updated_at' => $time));
                        }
                        \LogActivity::addToLog('Edit Sign Information To ' . $empid);
                    }

                    return redirect()->back()->with('success', getNotify(1));
                } else {
                    return redirect()->back()->with('warning', 'Employee Data Not Found');
                }
            }
        } else {
            return redirect()->back()->with('warning', getNotify(5));
        }
    }

    public function getEmployeeInfo(Request $request)
    {
        $empl = DB::table('hr_database_employee_basic as basic')
            ->where('basic.EmployeeID', $request->emp_id)
            ->leftJoin('hr_setup_designation', 'basic.DesignationID', '=', 'hr_setup_designation.id')
            ->leftJoin('hr_setup_department', 'basic.DepartmentID', '=', 'hr_setup_department.id')
            ->select('basic.id', 'basic.Name', 'hr_setup_designation.Designation', 'hr_setup_department.Department', 'basic.JoiningDate','basic.PhotoName AS Photo','basic.SignName AS Sign')
            ->first();
        if ($empl) {
            return response()->json([$empl]);
        } else {
            return response()->json(0);
        }
    }
}
