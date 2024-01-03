<?php

namespace App\Http\Controllers\Admin;

use DB;
use Image;
use Input;
use Session;
use Response;
use Sentinel;
use Validator;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Roles;
use App\Models\Users;
use App\Models\RoleUsers;
use App\Models\Activating;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\HRIS\Database\Employee;
use App\Models\Library\General\Company;
use Illuminate\Support\Facades\Storage;
use App\Models\HRIS\Database\EmployeeSalary;
use App\Models\HRIS\Database\EmployeePersonal;
use Cartalyst\Sentinel\Laravel\Facades\Activation;

class UserController extends Controller
{
    public function index(Request $request)
    {
        if (getAccess('view')) {
            /* $dupuid = DB::table('users')->groupBy('empid')->havingRaw('COUNT(empid) > 1')->distinct()->pluck('empid');
            $users = Users::orderBy('empid', 'ASC')->whereIn('empid',$dupuid)->leftjoin('hr_database_employee_basic as basic','users.empid','=','basic.EMployeeID')->select('Name','users.*')->get(); */

            //$users = Users::where('company_id',getHostInfo()['id'])->orderBy('id', 'ASC')->paginate(50);
            if (Sentinel::inRole('superadmin')) {
                $users = Users::orderBy('id', 'ASC')->paginate(100);
            } else {
                $users = Users::whereRaw('FIND_IN_SET(?, company_id)', [getHostInfo()['id']])->orderBy('id', 'ASC')->paginate(100);
            }
            //$users = Users::orderBy('id', 'ASC')->paginate(50);
            $rolelists = Roles::orderBy('id', 'ASC')->pluck('name', 'id');
            return view('admin.user.index', compact('users', 'rolelists'));
        } else {
            return redirect()->back()->with('warning', getNotify(5));
        }
    }

    public function create()
    {
        if (getAccess('create')) {
            $rolelists = Roles::orderBy('id', 'ASC')->where('id','!=',1)->where('C4S', 'Y')->pluck('name', 'id');
            return view('admin.user.create', compact('rolelists'));
        } else {
            return redirect()->back()->with('warning', getNotify(5));
        }
    }

    public function show($id)
    {
        if (getAccess('view')) {
            $user = Sentinel::findUserById($id);
            $rolelists = Roles::orderBy('id', 'ASC')->pluck('name', 'id');
            return view('admin.user.show', compact('user', 'rolelists'));
        } else {
            return redirect()->back()->with('warning', getNotify(5));
        }
    }

    public function edit($id)
    {
        if (getAccess('edit')) {
            if ($id == 1) {
                return redirect()->back()->with('warning', getNotify(5));
            }
            $user = Sentinel::findUserById($id);
            $rolelists = Roles::orderBy('id', 'ASC')->where('id','!=',1)->pluck('name', 'id');

            return view('admin.user.edit', compact('user', 'rolelists'));
        } else {
            return redirect()->back()->with('warning', getNotify(5));
        }
    }

    public function store(Request $request)
    {
        if (getAccess('create')) {
            $userid = Sentinel::getUser()->id;
            $formdata = array(
                'empid'             => $request->get('EmployeeID'),
                'user_type'         => $request->get('user_type'),
                'email'             => $request->get('email'),
                'email'             => $request->get('email'),
                'password'          => $request->get('password'),
                'confirm_password'  => $request->get('confirm_password'),
                'phone'             => $request->get('phone'),
                // 'lname'             => $request->get('lname'),
                'fullname'          => $request->get('fullname'),
                'roles'             => $request->get('roles'),
                'company'           => $request->get('company'),
            );
            $rules = array(
                'empid'             => 'required',
                'user_type'         => 'required',
                'fullname'          => 'required',
                'email'             => 'required|email|unique:users,email',              
                'password'          => 'required|min:6',
                'confirm_password'  => 'required|same:password',
                'roles'             => 'required',
            );
            //session()->put('success','Item Successfully Created.');
            $validation = Validator::make($formdata, $rules);
            if ($validation->fails()) {
                return redirect()->action('Admin\UserController@create')->with('error', getNotify(4))->withErrors($validation)->withInput();
            } else {
                $userCheck = User::where('empid', $request->get('EmployeeID'))->pluck('empid')->first();
                $chk = Employee::where('EmployeeID', $request->get('EmployeeID'))->pluck('EmployeeID')->first();

                if (!$userCheck) {
                    $createdat = Carbon::now();
                    $user = Sentinel::registerAndActivate(array(
                        'empid'         => $formdata['empid'],
                        'email'         => $formdata['email'],
                        'password'      => $formdata['password'],
                        'user_type'     => $formdata['user_type'],
                        'fullname'      => $formdata['fullname'],
                        'phone'         => $formdata['phone']??null,
                        'role_id'       => $formdata['roles'],
                        'company_id'    => $formdata['company'] ? implode(',', $formdata['company']) : '',
                        'CreatedBy'     => $userid,
                        'C4S'           => 'Y',
                        'activated'     => 1,
                        'created_at'    => $createdat,
                        'updated_at'    => $createdat
                    ));
                    $role = Sentinel::findRoleById($formdata['roles']);
                    $role->users()->attach($user);
                    if ($request->user_type == 'emp') {
                        if (!$chk) {
                            //Employee Insert Here
                            $employee = new Employee();
                            $employee->EmployeeID = $user->empid;
                            $employee->company_id = $user->company_id;
                            $employee->Name = $user->fullname;
                            $employee->Salaried = 'Y';
                            $employee->ReasonID = 'N';
                            $employee->save();

                            $employeesalary = new EmployeeSalary();
                            $employeesalary->EmployeeID = $employee->EmployeeID;
                            $employeesalary->CreatedBy = $userid;
                            $employeesalary->save();

                            $employeepersonal = new EmployeePersonal();
                            $employeepersonal->EmployeeID = $employee->EmployeeID;
                            $employeepersonal->Email = $formdata['email'];
                            $employeepersonal->CreatedBy = $userid;
                            $employeepersonal->save();
                        }
                    }

                    if ($formdata['company']) {
                        foreach ($formdata['company'] as $row) {
                            DB::insert("INSERT INTO user_company (user_id, company_id,created_at) VALUES ('$user->id','$row','$createdat')");
                        }
                    }
                    $getCreatedUser = DB::table('users as user')
                        ->leftJoin('hr_database_employee_basic as emp', 'emp.EmployeeID', '=', 'user.empid')
                        ->leftJoin('hr_setup_department as dept', 'dept.id', '=', 'emp.DepartmentID')
                        ->leftJoin('hr_setup_designation as dsg', 'dsg.id', '=', 'emp.DesignationID')
                        ->leftJoin('hr_database_employee_personal as personal', 'personal.EmployeeID', '=', 'user.empid')
                        ->select('emp.id as id', 'emp.Name', 'dept.Department', 'dsg.Designation', 'user.Email', 'personal.PhoneNo')
                        ->where('user.id', $userid)
                        ->first();
                    $data = [
                        'email' => $formdata['email'],
                        'getCreatedUserName' => $getCreatedUser->Name,
                        'getCreatedUserEmail' => $getCreatedUser->Email,
                        'getCreatedUserPhone' => $getCreatedUser->PhoneNo,
                    ];
                    // sendEmployeeCredential($data);
                    \LogActivity::addToLog('Add User ' . $formdata['email']);
                    return redirect()->action('Admin\UserController@index')->with('success', getNotify(1));
                } else {
                    return redirect()->back()->with('warning', getNotify(6));
                }
            }
        } else {
            return redirect()->back()->with('warning', getNotify(5));
        }
    }

    public function update(Request $request, $id)
    {
        if (getAccess('edit')) {
            $userid = Sentinel::getUser()->id;
            if ($id == 1) {
                return redirect()->back()->with('warning', getNotify(5));
            }
            if ($request->form_id == 1) {
                $attributes = $request->all();
                $user = Users::findOrFail($id);
                $rules = [
                    'password'         => 'required|min:6',
                    'confirm_password' => 'required|same:password'
                ];
                $validation = Validator::make($attributes, $rules);
                if ($validation->fails()) {
                    return redirect()->action('Admin\UserController@index')->with(['error' => getNotify(4), 'error_code' => $id])->withErrors($validation)->withInput();
                } else {
                    \LogActivity::addToLog('User ID: ' . $id . ' Reset Password to ' . $attributes['password']);
                    $user->forceFill([
                        'password' => bcrypt($attributes['password']),
                    ])->update();

                    $fuser = Sentinel::findUserById($id);
                    Sentinel::logout($fuser);
                    if ($id == $userid) {
                        Session::flush();
                    }
                    return redirect()->action('Admin\UserController@index')->with('success', getNotify(2));
                }
            } elseif ($request->form_id == 2) {
                $fuser = Sentinel::findUserById($id);
                Sentinel::logout($fuser);
                if ($id == $userid) {
                    Session::flush();
                }

                \LogActivity::addToLog('Log out User ID: ' . $id);
                return redirect()->action('Admin\UserController@index')->with('success', getNotify(2));
            } else {
                
                $formdata = array(
                    'empid'             => $request->get('EmployeeID'),
                    'email'             => $request->get('email'),
                    'user_type'         => $request->get('user_type'),     
                    //'password'          => ($request->get('password')) ?: null,
                    //'confirm_password'  => ($request->get('confirm_password')) ?: null,
                    'fullname'          => $request->get('fullname'),
                    'roles'             => $request->get('roles'),
                    'company'           => $request->get('company'),
                );
                $rules = array(
                    'empid'             => 'required',                    
                    'email'             => 'required|email|unique:users,email,' . $id,
                    'user_type'         => 'required',
                    'fullname'          => 'required',
                    //'password'          => 'required|min:6',
                    //'confirm_password'  => 'required|same:password',
                    'roles'             => 'required',
                );
                $validation = Validator::make($formdata, $rules);
                if ($validation->fails()) {
                    return redirect()->action('Admin\UserController@edit', $id)->with('error', getNotify(4))->withErrors($validation)->withInput();
                } else {
                    $createdat = Carbon::now();
                    $user = Sentinel::findById($id);
                    $user->empid = $formdata['empid'];
                    $user->user_type = $formdata['user_type'];
                    $user->email = $formdata['email'];
                    $user->fullname = $formdata['fullname'];                   
                    $user->role_id = $formdata['roles'];
                    $user->company_id = $formdata['company'] ? implode(',', $formdata['company']) : '';
                    $user->CreatedBy = $userid;
                    $user->updated_at = $createdat;

                    Sentinel::update($user, $formdata);

                    RoleUsers::where('user_id', $id)->delete();
                    $roleuser = new RoleUsers();
                    $roleuser->user_id = $id;
                    $roleuser->role_id = $formdata['roles'];
                    $roleuser->save();

                    if ($request->user_type == 'emp') {
                        $chk = Employee::where('EmployeeID', $user->empid)->pluck('EmployeeID')->first();
                        if (!$chk) {
                            //Employee Insert Here
                            $employee = new Employee();
                            $employee->EmployeeID = $user->empid;
                            $employee->Name = $user->fullname;
                            $employee->Salaried = 'Y';                       
                            $employee->save();

                            $employeesalary = new EmployeeSalary();
                            $employeesalary->EmployeeID = $employee->EmployeeID;
                            $employeesalary->CreatedBy = $userid;
                            $employeesalary->save();

                            $employeepersonal = new EmployeePersonal();
                            $employeepersonal->EmployeeID = $employee->EmployeeID;
                            $employeepersonal->Email = $formdata['email'];
                            $employeepersonal->CreatedBy = $userid;
                            $employeepersonal->save();
                        }
                    }
                    if ($formdata['company']) {
                        DB::delete("delete from user_company where user_id = $id");
                        foreach ($formdata['company'] as $row) {
                            DB::insert("INSERT INTO user_company (user_id, company_id,created_at) VALUES ('$user->id','$row','$createdat')");
                        }
                    }

                    \LogActivity::addToLog('Update User ' . $formdata['email']);
                    return redirect()->action('Admin\UserController@index')->with('success', getNotify(2));
                }
            }
        } else {
            return redirect()->back()->with('warning', getNotify(5));
        }
    }

    public function destroy($id)
    {
        if (getAccess('delete')) {
            $userid = Sentinel::getUser()->id;
            $user = Sentinel::findById($id);
            if ($userid == $id || $id == 1) {
                return redirect()->back()->with('warning', getNotify(5));
            }
            //$userRoles = Sentinel::findById($id)->roles()->first();
            $roleModel = Sentinel::findRoleById($user->role_id);
            $roleModel->users()->detach($user);

            $fuser = Sentinel::findUserById($id);
            Sentinel::logout($fuser);
            if ($id == $userid) {
                Session::flush();
            }
            Activation::remove($user);
            $user->delete();

            \LogActivity::addToLog('Delete User ' . $user['email']);
            return redirect()->action('Admin\UserController@index')->with('success', getNotify(3));
        } else {
            return redirect()->back()->with('warning', getNotify(5));
        }
    }

    public function ToggleActivating($id)
    {
        if (getAccess('edit')) {
            $userid = Sentinel::getUser()->id;
            if ($userid == $id || $id == 1) {
                return response()->json(array('result' => 'warning'));
            }
            $user = Users::findOrFail($id);
            if ($user->C4S == 'Y') {
                $user->C4S = 'N';
                $actid = Activating::orderBy('id', 'ASC')->where('user_id', $id)->pluck('id')->first();
                $actdata = Activating::find($actid);
                $actdata->completed = ($actdata->completed) ? false : true;
                $actdata->completed_at = Carbon::now();
                $actdata->update();
            } else {
                $userinfo = Sentinel::findById($id);
                $actid = Activating::orderBy('id', 'ASC')->where('user_id', $id)->pluck('id')->first();
                $actdata = Activating::find($actid);
                if ($actdata) {
                    $actdata->completed = ($actdata->completed) ? false : true;
                    $actdata->completed_at = Carbon::now();
                    $actdata->update();
                } else {
                    Sentinel::Activate($userinfo);
                }
                $user->C4S = 'Y';
            }
            $user->updated_at = Carbon::now();
            $user->update();

            $actchangedid = Activating::orderBy('id', 'ASC')->where('user_id', $id)->pluck('id')->first();
            $actchangeddata = Activating::find($actchangedid);

            \LogActivity::addToLog('User Status Changed to ' . ($actchangeddata->completed ? 'Active' : 'Deactive') . ' of ' . $user->email);
            return response()->json(array('result' => 'success', 'changed' => ($actchangeddata->completed) ? 1 : 0));
        } else {
            return response()->json(array('result' => 'warning'));
        }
    }

    public function profile()
    {
        $id = Sentinel::getUser()->id;
        $user = DB::table('users as user')->leftJoin('hr_database_employee_basic as emp', 'emp.EmployeeID', 'user.empid')
            ->leftJoin('hr_database_employee_salary as salary', 'salary.EmployeeID', 'user.empid')
            ->leftJoin('hr_setup_districts as prsnt_dis', 'prsnt_dis.id', '=', 'emp.MDistrictID')
            ->leftJoin('hr_setup_districts as par_dis', 'par_dis.id', '=', 'emp.PDistrictID')
            ->leftJoin('hr_setup_thanas as prsnt_thna', 'prsnt_thna.id', '=', 'emp.MThanaID')
            ->leftJoin('hr_setup_thanas as par_thna', 'par_thna.id', '=', 'emp.PThanaID')
            ->select('user.*', 'emp.*', 'prsnt_dis.Name as prsntDis', 'par_dis.Name as parDis', 'prsnt_thna.Name as prnsThana', 'par_thna.Name as parThana')
            ->where('user.id', $id)->first();

        $educations = DB::table('hr_database_education as edu')
            ->leftJoin('hr_setup_degrees as degrees', 'degrees.id', '=', 'edu.DegreeID')
            ->leftJoin('hr_setup_educationboard as board', 'board.id', '=', 'edu.BoardID')
            ->select('edu.Institute', 'degrees.Degree', 'edu.ResultType', 'edu.ClassObtained', 'edu.year', 'board.Name', 'edu.InstituteB')
            ->where('edu.EmployeeID',   $user->empid)
            ->get();
        $experiences = DB::table('hr_database_experience as exp')
            ->where('exp.EmployeeID',   $user->empid)
            ->get();
        $trainings = DB::table('hr_database_training as training')
            ->where('training.EmployeeID',   $user->empid)
            ->get();
        $references = DB::table('hr_database_employee_reference as reference')
            ->where('reference.EmployeeID',   $user->empid)
            ->get();
        $personal = DB::table('hr_database_employee_personal as personal')
            ->where('personal.EmployeeID',   $user->empid)
            ->first();
        return view('admin.user.profile', compact('user', 'educations', 'experiences', 'trainings', 'references', 'personal'));
    }

    public function editProfile()
    {
        $id = Sentinel::getUser()->empid;
        $empid = Employee::where('EmployeeID', $id)->pluck('id')->first();

        $tab = Input::get('TabNo');
        $tabNo = '';

        if ($tab) {     
            $tabNo = $tab;
        } else {       
            $tabNo = 1;
        }
        if ($empid) {
            return redirect()->action('HRIS\Database\EmployeeController@show', $empid . '?tab=' . $tabNo);
        } else {
            return redirect()->action('HRIS\Database\EmployeeController@index')->with('info', getNotify(7))->withInput();
        }
    }

    public function uploadProfileImage(Request $request)
    {
        $time = date('Y-m-d H:i:s');
        $userid = Sentinel::getUser()->empid;
        if ($request->hasFile('profileImage')) {
            $image = $request->file('profileImage');
            $newImageName = $userid . '.' . $image->getClientOriginalExtension();

            $imgPath = 'public/profiles/';
            $newImagePath = $imgPath . $newImageName;

            // Delete the previous image if it exists
            $user = User::where('empid', $userid)->first();
            if ($user->profile_image) {
                // Delete the old image from the public folder
                $oldImagePath = $imgPath . $user->profile_image;
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }

            $fileSize = $image->getSize();
            // Move the new image to the public folder
            $image->move($imgPath, $newImageName);
            Image::make($newImagePath)
                ->resize(531, 650)
                ->save($newImagePath);

            // Update user's profile image URL in the database
            $user->profile_image = $newImageName;
            $user->save();

            DB::table('hr_database_employee_basic')->where('EmployeeID', $userid)->update(array('PhotoName' => $newImageName, 'updated_at' => $time));

            return response()->json([
                'success' => true,
                'newImageUrl' => asset('profiles/' . $newImageName)
            ]);
        }

        return response()->json(['success' => false]);
    }

    public function uploadProfileImageold(Request $request)
    {
        $time = date('Y-m-d H:i:s');
        $userid = Sentinel::getUser()->empid;
        if ($request->hasFile('profileImage')) {
            $image = $request->file('profileImage');
            $newImageName = $userid . '.' . $image->getClientOriginalExtension();

            $destinationPathp = 'public/profiles/';
            $fileNamepp = $userid . $filep->getClientOriginalExtension();
            File::delete($destinationPathp . $fileNamepp);
            $fileSizep = $filep->getSize();
            $upload_successp = $filep->move($destinationPathp, $fileNamepp);

            // Process and resize the image using Intervention Image
            $image = Image::make($image)->resize(531, 650)->save($image);

            // Save the image to the public directory
            $image->save(public_path('profiles/' . $newImageName));

            // Update user's profile image URL in the database
            $user = User::where('empid', $userid)->first();
            $user->profile_image = $newImageName;
            $user->save();

            DB::table('hr_database_employee_basic')->where('EmployeeID', $userid)->update(array('PhotoName' => $fileNamepp, 'updated_at' => $time));

            return response()->json([
                'success' => true,
                'newImageUrl' => asset('profiles/' . $newImageName)
            ]);
        }

        return response()->json(['success' => false]);
    }
}
