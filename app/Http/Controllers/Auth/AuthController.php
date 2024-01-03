<?php

namespace App\Http\Controllers\Auth;

use Session;
use Sentinel;
use Validator;
use App\Models\User;
use App\Models\Menus;
use App\Models\Modules;
use App\Models\RoleMenus;
use App\Models\ChildMenus;
use App\Models\Permissions;
use App\Models\RoleModules;
use Illuminate\Http\Request;
use App\Models\RoleChildMenus;
use App\Models\RolePermissions;
use App\Http\Controllers\Controller;
use App\Models\HRIS\Tools\HROptions;
use Illuminate\Support\Facades\Config;

class AuthController extends Controller
{
    public function getLogin()
    {
        if(date('Y-m-d',strtotime(now())) > Config::get('rmconf.apps_date')){ abort(401); }
        if (!Sentinel::check()) {
            return view('auth.login');
        }
        return redirect()->route('welcome');
    }

    public function postLogin(Request $request)
    {
        $credentials = [
            'email'    => $request->email,
            'password' => $request->password,
        ];
        $rules = [
            'email' => 'required',
            'password' => 'required',
        ];
        $msgs = [
            'email.required' => 'Please Input Your :attribute',
            'password.required' => 'Please Input Your :attribute',
        ];
        $attr = [
            'email' => 'E-Mail Address',
            'password' => 'Password',
        ];
        //$validator = $request->validate($rules,$msgs);
        //$validation = Validator::make($credentials, $rules, $msgs, $attr);
        $validation = Validator::make($credentials, $rules);
        if ($validation->fails()) {
            $fmsg = 'Validation Error!';
            return redirect()->action('Auth\AuthController@getLogin')->with('warning', $fmsg)->withErrors($validation)->withInput();
        }
        try {
            // return $request;
            $result = Sentinel::authenticate($credentials);
            if ($result) {
                //acl

                $auth = Sentinel::getUser();
                $companies = explode(',', $auth->company_id);
                if($auth->role_id != 1 && !in_array(getHostInfo()['id'],$companies)){
                    Sentinel::logout();
                    $fmsg = 'Authentication Error!';
                    return redirect()->action('Auth\AuthController@getLogin')->with('info', $fmsg)->withInput();
                }


                $userid = Sentinel::getUser()->id;
                $userdata = Sentinel::findUserById($userid);
                //$userRoles = Sentinel::findById($userid)->roles()->first();
                $localip = $request->get('LocalIP');
                $request->session()->put('LocalIP', $localip);
                if (DeveloperCheck($userid)) {
                    $modules = Modules::orderBy('id', 'ASC')->where('C4S', 'Y')->get();
                    $menus = Menus::orderBy('id', 'ASC')->where('C4S', 'Y')->get();
                    $childmenus = ChildMenus::orderBy('id', 'ASC')->where('C4S', 'Y')->get();
                    $permissions = Permissions::orderBy('id', 'ASC')->where('C4S', 'Y')->get();
                    $request->session()->put('perms', $permissions);
                    $request->session()->put('view', 1);
                    $request->session()->put('create', 1);
                    $request->session()->put('edit', 1);
                    $request->session()->put('delete', 1);
                } else {
                    $assignmodulelist = RoleModules::orderBy('id', 'ASC')->where('role_id', $userdata->role_id)->pluck('module_id', 'id');
                    $assignedmenulist = RoleMenus::orderBy('id', 'ASC')->where('role_id', $userdata->role_id)->pluck('menu_id', 'id');
                    $assignedchildmenulist = RoleChildMenus::orderBy('id', 'ASC')->where('role_id', $userdata->role_id)->pluck('childmenu_id', 'id');
                    $permissionlist = RolePermissions::orderBy('id', 'ASC')->where('role_id', $userdata->role_id)->pluck('permission_id', 'id');
                    $modules = Modules::orderBy('id', 'ASC')->where('C4S', 'Y')->whereIn('id', $assignmodulelist)->get();
                    $menus = Menus::orderBy('id', 'ASC')->where('C4S', 'Y')->whereIn('id', $assignedmenulist)->get();
                    $childmenus = ChildMenus::orderBy('id', 'ASC')->where('C4S', 'Y')->whereIn('id', $assignedchildmenulist)->get();
                    $permissions = Permissions::orderBy('id', 'ASC')->where('C4S', 'Y')->whereIn('id', $permissionlist)->get();
                    $request->session()->put('perms', $permissions);
                    $request->session()->put('view', Access('view'));
                    $request->session()->put('create', Access('create'));
                    $request->session()->put('edit', Access('edit'));
                    $request->session()->put('delete', Access('delete'));
                }
                $request->session()->put('modules', $modules);
                $request->session()->put('menus', $menus);
                $request->session()->put('childmenus', $childmenus);
                $hroptions = HROptions::orderBy('id', 'DESC')->first();
                $request->session()->put('hroptions', $hroptions);
                //end acl

                \LogActivity::addToLog('Login User ' . $credentials['email']);
                $fmsg = 'Login Successful';
                // return Sentinel::getUser();
                $roleName =  Sentinel::getUser()->roles[0]->name ?? null;
                if ($roleName == 'General') {
                    return redirect()->route('employee.dashboard');
                } else {
                    return redirect()->action('WelcomeController@index')->with('success', $fmsg);
                }
            } else {
                $fmsg = 'Authentication Error!';
                return redirect()->action('Auth\AuthController@getLogin')->with('info', $fmsg)->withInput();
            }
        } catch (\Cartalyst\Sentinel\Checkpoints\NotActivatedException $e) {
            return back()->withErrors($e->getMessage());
        }
    }
    public function getRegistration()
    {
        if (!Sentinel::check()) {
            return view('auth.registration');
        }
        return redirect()->route('welcome');
    }
    public function postRegistration(Request $request)
    {
        // return $request;
        $credentials = [
            'email'    => $request->email,
            'password' => $request->password,
            'phone' => $request->phone,
            'EmployeeID' => $request->EmployeeID,
            'FName' => $request->FName,
            'Lname' => $request->Lname,
        ];
        $rules = [
            'EmployeeID' => 'required|unique:users,empid',
            'FName' => 'required|min:3',
            // 'Lname' => 'required|min:3',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|unique:users,phone',
            'password' => 'required|min:6',
        ];

        // $msgs = [
        //     'email.required' => 'Please Input Your :attribute',
        //     'password.required' => 'Please Input Your :attribute',
        //     'EmployeeID.required' => 'Please Input Your :attribute',
        //     'FName.required' => 'Please Input Your :attribute',
        //     'Lname.required' => 'Please Input Your :attribute',
        //     'phone.required' => 'Please Input Your :attribute',
        //     'password.min' => 'Your :attribute must be at least :min characters.',
        //     'unique' => 'The :attribute has already been taken.',
        //     // Add more custom messages as needed for your rules.
        // ];
        //$validator = $request->validate($rules,$msgs);
        //$validation = Validator::make($credentials, $rules, $msgs, $attr);
        $validation = Validator::make($credentials, $rules);
        if ($validation->fails()) {
            $fmsg = 'Validation Error!';
            return redirect()->action('Auth\AuthController@getRegistration')->with('warning', $fmsg)->withErrors($validation)->withInput();
        } else {
            $user = new User();
            $user->empid = $request->EmployeeID;
            $user->first_name = $request->FName;
            $user->last_name = $request->Lname;
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->C4S = 'Y';
            $user->password = bcrypt($request->password);
            $user->save();

            // Log in the user after registration
            auth()->login($user);

            return redirect()->route('employee.dashboard');
        }
    }
    public function getLogout()
    {
        Sentinel::logout(Sentinel::getUser());
        Session::flush();
        return redirect()->route('login');
    }
}
