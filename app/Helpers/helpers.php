<?php

use Carbon\Carbon;
use App\Models\Extra;
use App\Models\Menus;
use App\Models\Roles;
use App\Models\Users;
use App\Models\Modules;
use App\Models\RoleMenus;
use App\Models\Activating;
use App\Models\ChildMenus;
use App\Models\Permissions;
use App\Models\RoleModules;
use App\Models\RoleChildMenus;
use App\Models\RolePermissions;
use App\Models\HRIS\Tools\HROptions;
use App\Models\Library\General\Room;
use App\Models\HRIS\Setup\Department;
use App\Models\Library\General\Table;
use App\Models\HRIS\Database\Employee;
use App\Models\HRIS\Setup\Designation;
use Illuminate\Support\Facades\Config;
use App\Models\Library\General\Company;
use Illuminate\Support\Facades\Session;
use App\Models\Frontend\Order\OrderItem;
use App\Models\Library\General\Customer;
use App\Models\Frontend\Order\OrderProcess;
use App\Models\HRIS\Database\LeaveApplication;
use App\Models\Library\ProductManagement\Product;
use App\Models\Library\ProductManagement\ProductAdon;
use App\Models\Library\ProductManagement\ProductSize;
use App\Models\Library\ProductManagement\ProductOption;
use App\Models\Library\ProductManagement\ProductCategory;

function setActive($path, $active = 'active')
{
    if (is_array($path)) {
        foreach ($path as $k => $v) {
            $path[$k] = $v;
        }
    } else {
        $path = $path;
    }
    return call_user_func_array('Request::is', (array)$path) ? $active : '';
}

function getMonthName($monthNumber)
{
    return date("F", mktime(0, 0, 0, $monthNumber, 1));
}

function DeveloperCheck($userid = null)
{
    $userid = Sentinel::getUser()->id;
    if ($userid == 1 || Sentinel::inRole('superadmin')) {
        return 1;
    } else {
        return 0;
    }
}

function Access($type)
{
    $roleid = Sentinel::getRoles();
    if (sizeOf($roleid)) {
        $chk = DB::table('role_permissions')
            ->where('role_id', $roleid[0]->id)
            ->leftjoin('permissions', 'role_permissions.permission_id', '=', 'permissions.id')
            ->where('permissions.Slug', $type)
            ->first();
        if ($chk) {
            return 1;
        } else {
            return 0;
        }
    } else {
        return 0;
    }
}

function getURLData()
{
    $reqdata = Request::segments();
    $urldata = [];
    if ($reqdata) {
        if (sizeof($reqdata) >= 3) {
            $urldata['module'] = $reqdata[0];
            $urldata['menu'] = $reqdata[1];
            $urldata['cmenu'] = $reqdata[2];
        } elseif (sizeof($reqdata) >= 2) {
            $urldata['module'] = $reqdata[0];
            $urldata['menu'] = $reqdata[1];
            $urldata['cmenu'] = '';
        } elseif (sizeof($reqdata) >= 1) {
            $urldata['module'] = $reqdata[0];
            $urldata['menu'] = '';
            $urldata['cmenu'] = '';
        } else {
            $urldata['module'] = '';
            $urldata['menu'] = '';
            $urldata['cmenu'] = '';
        }
        return $urldata;
    } else {
        return 0;
    }
}

function getAccess($permission)
{
    $roleid = Sentinel::getRoles();
    if (sizeOf($roleid)) {
        $roleid = $roleid[0]->id;
        $urlinfo = getURLData();
        $moduleids = RoleModules::orderBy('id', 'ASC')->where('role_id', $roleid)->pluck('module_id');
        $menuids = RoleMenus::orderBy('id', 'ASC')->where('role_id', $roleid)->pluck('menu_id');
        $cmenuids = RoleChildMenus::orderBy('id', 'ASC')->where('role_id', $roleid)->pluck('childmenu_id');
        $permsids = RolePermissions::orderBy('id', 'ASC')->where('role_id', $roleid)->pluck('permission_id');

        $modulecount = Modules::orderBy('id', 'ASC')->where('C4S', 'Y')->whereIn('id', $moduleids)->where('Slug', $urlinfo['module'])->count();
        $moduleid = Modules::orderBy('id', 'ASC')->where('C4S', 'Y')->whereIn('id', $moduleids)->where('Slug', $urlinfo['module'])->pluck('id')->first();
        $menucount = Menus::orderBy('id', 'ASC')->where('C4S', 'Y')->whereIn('ModuleID', $moduleids)->where('ModuleID', $moduleid)->whereIn('id', $menuids)->where('Slug', $urlinfo['menu'])->count();
        $cmenuchk = Menus::orderBy('id', 'ASC')->where('C4S', 'Y')->where('Childable', 'Y')->whereIn('ModuleID', $moduleids)->where('ModuleID', $moduleid)->whereIn('id', $menuids)->where('Slug', $urlinfo['menu'])->count();
        $cmenucount = ChildMenus::orderBy('id', 'ASC')->where('C4S', 'Y')->whereIn('ModuleID', $moduleids)->whereIn('MenuID', $menuids)->whereIn('id', $cmenuids)->where('Slug', $urlinfo['cmenu'])->count();
        $permscount = Permissions::orderBy('id', 'ASC')->where('C4S', 'Y')->whereIn('id', $permsids)->where('Name', $permission)->count();
        //dd($modulecount, $menucount, $cmenuchk, $cmenucount, $permscount);
        if (DeveloperCheck()) {
            return 1;
        } elseif ($modulecount == 0 || $menucount == 0 || ($cmenuchk > 0 && $cmenucount == 0) || $permscount == 0) {
            return 0;
        } else {
            return 1;
        }
    } else {
        return 0;
    }
}

function userActivating($empid)
{
    $id = Users::where('empid', $empid)->pluck('id')->first();
    if ($id) {
        $user = Users::findOrFail($id);
        if ($user->C4S == 'Y') {
            $user->C4S = 'N';
            $activationid = Activating::orderBy('id', 'ASC')->where('user_id', $id)->pluck('id')->first();
            $activationdata = Activating::find($activationid);
            $activationdata->completed = false;
            $activationdata->completed_at = Carbon::now();
            $activationdata->update();
        } else {
            $userinfo = Sentinel::findById($id);
            $activationid = Activating::orderBy('id', 'ASC')->where('user_id', $id)->pluck('id')->first();
            $activationdata = Activating::find($activationid);
            if ($activationdata) {
                $activationdata->completed = true;
                $activationdata->completed_at = Carbon::now();
                $activationdata->update();
            } else {
                Sentinel::Activate($userinfo);
            }
            $user->C4S = 'Y';
        }
        $user->updated_at = Carbon::now();
        $user->update();

        $activationchangedid = Activating::orderBy('id', 'ASC')->where('user_id', $id)->pluck('id')->first();
        $activationchangeddata = Activating::find($activationchangedid);

        \LogActivity::addToLog('User Status Changed to ' . ($activationchangeddata->completed ? 'Active' : 'Deactive') . ' of ' . $user->email);
    }
}

function UserActiveOrNot($userID)
{
    $result = DB::table('activations')->orderBy('id', 'ASC')->where('user_id', $userID)->where('completed', 1)->count();
    if ($result) {
        return 1;
    } else {
        return 0;
    }
}

function getNotify($type)
{
    if ($type == 1) {
        $fmsg = 'Data Added Successfully';
    } elseif ($type == 2) {
        $fmsg = 'Data Updated Successfully';
    } elseif ($type == 3) {
        $fmsg = 'Data Deleted Successfully';
    } elseif ($type == 4) {
        $fmsg = 'Validation Error!';
    } elseif ($type == 5) {
        $fmsg = 'You Are Not Permitted';
    } elseif ($type == 6) {
        $fmsg = 'Provided Data Already Exists';
    } elseif ($type == 7) {
        $fmsg = 'No Information Found Matches Your Query';
    } elseif ($type == 8) {
        $fmsg = 'Data Not Found';
    } elseif ($type == 9) {
        $fmsg = 'Your given input is large than balance!';
    } elseif ($type == 10) {
        $fmsg = 'Operation Invalid!';
    } elseif ($type == 11) {
        $fmsg = 'Item add to cart success';
    } elseif ($type == 12) {
        $fmsg = 'No update required';
    } else {
        $fmsg = 'Message Code Error';
    }
    return $fmsg;
}

function getC4S($type)
{
    if ($type == 'Y') {
        $result = 'Yes';
    } elseif ($type == 'N') {
        $result = 'No';
    } elseif ($type == 1) {
        $result = 'Active';
    } elseif ($type == 0) {
        $result = 'Inactive';
    } else {
        $result = '';
    }
    return $result;
}

function getStatus($type)
{
    if ($type == 1) {
        $result = ['Y' => 'Yes', 'N' => 'No'];
    } elseif ($type == 2) {
        $result = [1 => 'Active', 0 => 'Inactive'];
    } else {
        $result = [];
    }
    return $result;
}

function getArrayData($datas, $key)
{
    $result = isset($datas[$key]) ? $datas[$key] : '';
    return $result;
}

function getUserInfo($id)
{
    $result = Users::where('id', $id)->select('*', 'fullname AS Name')->first();
    if ($result) {
        return $result;
    } else {
        return 0;
    }
}

function getProductSize($id)
{
    $productSizes = ProductSize::where('product_id', $id)->count();
    return $productSizes;
}

function getWorkingDay($date)
{
    $HolidayStatus = 0;
    $result = DB::table('hr_tools_calendar')->orderBy('id', 'ASC')->where('Date', $date)->where('Holiday', 'Y')->first();
    if ($result) {
        $date = date('Y-m-d', strtotime($date . '+1 days'));
        return getWorkingDay($date);
    } else {
        return $date;
    }
}

function getPreventLVEntry($start_date)
{
    $today = Carbon::now()->format('Y-m-d');
    $monthfirst = Carbon::now()->startOfMonth()->format('Y-m-d');
    $toldate = Carbon::now()->startOfMonth()->addDays(1)->format('Y-m-d');
    $restrictdate = getWorkingDay($toldate);
    $balchk = DB::table('hr_miscellaneous_options')->first();
    if ($balchk->CheckLeaveLimit == 'N') {
        return 0;
    } else {
        $userid = Sentinel::getUser()->id;
        if (Sentinel::inRole('superadmin')) {
            return 0;
        } else {
            return ($today > $restrictdate) ? ($start_date < $monthfirst ? 1 : 0) : 0;
        }
    }
}
function getPreventLVEntryMsg($start_date)
{
    $today = Carbon::now()->format('Y-m-d');
    $monthfirst = Carbon::now()->startOfMonth()->addDays(1)->format('Y-m-d');
    $restrictdate = Carbon::parse(getWorkingDay($monthfirst))->format('d-m-Y');
    return $restrictdate;
}
function getPreventLVForApp($start_date)
{
    $today = Carbon::now()->format('Y-m-d');
    $monthfirst = Carbon::now()->startOfMonth()->format('Y-m-d');
    $toldate = Carbon::now()->startOfMonth()->addDays(1)->format('Y-m-d');
    $restrictdate = getWorkingDay($toldate);
    $balchk = DB::table('hr_miscellaneous_options')->first();
    if ($balchk->CheckLeaveLimit == 'N') {
        return 0;
    } else {
        $userid = Sentinel::getUser()->id;
        $userRoles = Sentinel::findById($userid)->roles()->first();
        if ($userRoles->slug == 'superadmin' || $userid == 266) {
            return 0;
        } else {
            return ($today > $restrictdate) ? ($start_date < $monthfirst ? 1 : 0) : 0;
        }
    }
}
function getPreventLVForAppMsg($start_date)
{
    $today = Carbon::now()->format('Y-m-d');
    $monthfirst = Carbon::now()->startOfMonth()->addDays(1)->format('Y-m-d');
    $restrictdate = Carbon::parse(getWorkingDay($monthfirst))->format('d-m-Y');
    return $restrictdate;
}

function getForwarding($id)
{
    $result = LeaveApplication::orderBy('id', 'ASC')->where('id', $id)->where('IsForwarded', 'Y')->count();
    if ($result) {
        return 1;
    } else {
        return 0;
    }
}
function getApproval($id)
{
    $result = LeaveApplication::orderBy('id', 'ASC')->where('id', $id)->where('IsApproved', 'Y')->count();
    if ($result) {
        return 1;
    } else {
        return 0;
    }
}

function roundMinute($time1)
{
    if ($time1 > 0) {
        $seconds = Carbon::parse($time1)->second;
        $time2 = $seconds >= 30 ? Carbon::parse($time1)->addMinutes(1)->format('Y-m-d H:i') : Carbon::parse($time1)->format('Y-m-d H:i');
        return Carbon::parse($time2)->format('Y-m-d H:i:s');
    } else {
        return 0;
    }
}
function roundHour($time1)
{
    if ($time1 > 0) {
        $minutes = Carbon::parse($time1)->minute;
        $hours = Carbon::parse($time1)->hour;
        $date = Carbon::parse($time1)->format('Y-m-d');
        $time2 = $minutes >= 45 ? Carbon::parse($date)->addHours($hours + 1)->format('Y-m-d H:i:s') : Carbon::parse($date)->addHours($hours)->format('Y-m-d H:i:s');
        return $time2;
    } else {
        return 0;
    }
}
function roundStartHour($time1)
{
    if ($time1 > 0) {
        $minutes = Carbon::parse($time1)->minute;
        $hours = Carbon::parse($time1)->hour;
        $date = Carbon::parse($time1)->format('Y-m-d');
        $time2 = $minutes >= 10 ? Carbon::parse($date)->addHours($hours + 1)->format('Y-m-d H:i:s') : Carbon::parse($date)->addHours($hours)->format('Y-m-d H:i:s');
        return $time2;
    } else {
        return 0;
    }
}
function roundEndHour($time1)
{
    if ($time1 > 0) {
        $minutes = Carbon::parse($time1)->minute;
        $hours = Carbon::parse($time1)->hour;
        $date = Carbon::parse($time1)->format('Y-m-d');
        $time2 = $minutes >= 55 ? Carbon::parse($date)->addHours($hours + 1)->format('Y-m-d H:i:s') : Carbon::parse($date)->addHours($hours)->format('Y-m-d H:i:s');
        return $time2;
    } else {
        return 0;
    }
}
function hourCalculate($time1, $time2)
{
    if ($time1 > 0 && $time2 > 0 && $time1 < $time2) {
        $hours = Carbon::parse($time2)->diffInHours($time1);
        return $hours;
    } else {
        return 0;
    }
}
function hourCalculateActual($time1, $time2)
{
    if ($time1 > 0 && $time2 > 0 && $time1 < $time2) {
        $time1 = Carbon::parse($time1);
        $time2 = Carbon::parse($time2);
        $minutes = $time2->diff($time1)->format('%i');
        $achours = $time2->diff($time1)->format('%H');
        $hours = ($minutes >= 45) ? ($achours + 1) : $achours;
        return $hours;
    } else {
        return 0;
    }
}


function getEmpDetails($empid) {
    $employees = DB::table('hr_database_employee_basic as basic')
        ->leftJoin('hr_setup_designation', 'basic.DesignationID', '=', 'hr_setup_designation.id')
        ->leftJoin('hr_setup_department', 'basic.DepartmentID', '=', 'hr_setup_department.id')
        ->select('basic.id', 'basic.company_id', 'basic.EmployeeID', 'basic.Name', 'hr_setup_designation.Designation', 'hr_setup_department.Department', 'basic.JoiningDate', 'basic.DepartmentID', 'basic.DesignationID')
        ->where('basic.EmployeeID', $empid)
        ->orderBy('basic.EmployeeID', 'ASC')
        ->first();
    return $employees;
}

function getEmpName($empid)
{
    $result = Employee::where('EmployeeID', $empid)->first(['Name']);
    return $result;
}

function getEmpCompany($empid) {
    $result = Employee::where('EmployeeID',$empid)->pluck('company_id')->first();
    return $result;
}

function getUserDetails($userid = null)
{
    $empid = Sentinel::findById($userid);
    return getEmpDetails($empid->empid);
}

function getAttnType($attntype, $date = null)
{
    if ($attntype == 'HD') {
        if ($date) {
            $result = DB::table('hr_tools_calendar')->orderBy('id', 'ASC')->where('Date', $date)->where('PublicHoliday', 'Y')->first();
            return $result ? $result->Naration : 'Holiday';
        } else {
            return 'Holiday';
        }
    } elseif ($attntype == 'AB') {
        return 'Absent';
    } elseif ($attntype == 'PR') {
        return 'Present';
    } elseif ($attntype == 'CL') {
        return 'Annual Leave';
    } elseif ($attntype == 'ML') {
        return 'Sick Leave';
    } elseif ($attntype == 'EL') {
        return 'Earn Leave';
    } elseif ($attntype == 'MTL') {
        return 'Maternity Leave';
    } elseif ($attntype == 'LWP') {
        return 'Leave Without Pay';
    } elseif ($attntype == 'LV') {
        return 'Other Leave';
    } elseif ($attntype == 'LO') {
        return 'Lay Off';
    } elseif ($attntype == 'CM') {
        return 'Compensatory Leave';
    } else {
        return 'N/A';
    }
}
function sendToConfirmation($email, $data)
{
    $host = request()->getHost();
    $host = str_replace('.', '_', $host);

    $companyInfo = Config::get("rmconf.$host") ?? Config::get("rmconf.default");

    $companyName = $companyInfo['name'];
    $hrName = $companyInfo['hr_name'];
    $companyEmail = $companyInfo['hr_mail'];


    // switch ($host) {
    //     case Config::get('rmconf.lakeshorebakerydomain'):
    //         $companyName = Config::get('rmconf.lakeshorebakery');
    //         $companyEmail =  Config::get('rmconf.lakeshorebakeryemail');
    //         $hrName =  Config::get('rmconf.lakeshorebakeryhr');
    //         break;
    //     case Config::get('rmconf.drawhousedesigndomain'):
    //         $companyName = Config::get('rmconf.drawhousedesign');
    //         $companyEmail = Config::get('rmconf.drawhousedesignemail');
    //         $hrName =  Config::get('rmconf.drawhousedesignhr');
    //         break;
    //     case Config::get('rmconf.konacafedhakadomain'):
    //         $companyName = Config::get('rmconf.konacafedhaka');
    //         $companyEmail =  Config::get('rmconf.konacafedhakaemail');
    //         $hrName = Config::get('rmconf.konacafedhakahr');
    //         break;
    //     case Config::get('rmconf.pochegroupdomain'):
    //         $companyName =  Config::get('rmconf.pochegroup');
    //         $companyEmail =  Config::get('rmconf.pochegroupemail');
    //         $hrName = Config::get('rmconf.pochegrouphr');
    //         break;
    //     case Config::get('rmconf.lakeshoresuitesdomain'):
    //         $companyName =  Config::get('rmconf.lakeshoresuites');
    //         $companyEmail =  Config::get('rmconf.suitesemail');
    //         $hrName = Config::get('rmconf.suiteshr');
    //         break;
    //     case Config::get('rmconf.midorydomain'):
    //         $companyName =  Config::get('rmconf.midory');
    //         $companyEmail =  Config::get('rmconf.midoriemail');
    //         $hrName = Config::get('rmconf.midorihr');
    //         break;
    //     case Config::get('rmconf.lsheightsdomain'):
    //         $companyName =  Config::get('rmconf.lsheights');
    //         $companyEmail =  Config::get('rmconf.heightsmail');
    //         $hrName = Config::get('rmconf.heightshr');
    //         break;
    //     default:
    //         $companyName = Config::get('rmconf.lsgrand');
    //         $companyEmail = Config::get('rmconf.grandmail');
    //         $hrName =  Config::get('rmconf.grandhr');
    //         break;
    // }

    Mail::send('emails.confirmation', ['data' => $data], function ($m) use ($email, $companyEmail, $companyName, $hrName) {
        $m->from($companyEmail, $hrName); // Choose either 'Interview Invitation Form' or 'DrawHouse Ltd'
        $m->to($email)->subject('Confirmation mail');
    });
    // \LogActivity::addToLog('Send mail for interview invitation ' . $email);
}
function sendToApplicant($email, $data)
{
    $host = request()->getHost();
    $host = str_replace('.', '_', $host);
    $companyInfo = Config::get("rmconf.$host") ?? Config::get("rmconf.default");

    $companyName = $companyInfo['name'];
    $companyEmail = $companyInfo['hr_mail'];

    // switch ($host) {
    //     case 'hris.lakeshorebakery.com':
    //         $companyName = Config::get('rmconf.lakeshorebakery');
    //         $companyEmail =  Config::get('rmconf.lakeshorebakeryemail');
    //         break;
    //     case 'hris.drawhousedesign.com':
    //         $companyName = Config::get('rmconf.drawhousedesign');
    //         $companyEmail = Config::get('rmconf.drawhousedesignemail');
    //         break;
    //     case 'hris.konacafedhaka.com':
    //         $companyName = Config::get('rmconf.konacafedhaka');
    //         $companyEmail =  Config::get('rmconf.konacafedhakaemail');
    //         break;
    //     case 'hris.pochegroup.com':
    //         $companyName =  Config::get('rmconf.pochegroup');
    //         $companyEmail =  Config::get('rmconf.pochegroupemail');
    //         break;
    //     case 'hris.lakeshorebanani.com.bd':
    //         $companyName =  Config::get('rmconf.lakeshoresuites');
    //         $companyEmail =  Config::get('rmconf.suitesemail');
    //         break;
    //     case 'hris.themidoridhaka.com':
    //         $companyName =  Config::get('rmconf.midory');
    //         $companyEmail =  Config::get('rmconf.midoriemail');
    //         break;
    //     default:
    //         $companyName = Config::get('rmconf.drawhousedesign');
    //         $companyEmail = Config::get('rmconf.drawhousedesignemail');
    //         break;
    // }


    Mail::send('emails.applicant', ['data' => $data], function ($m) use ($email, $companyEmail, $companyName) {
        $m->from($companyEmail, 'Interview Invitation Form' . $companyName); // Choose either 'Interview Invitation Form' or 'DrawHouse Ltd'
        $m->to($email)->subject('Interview Mail');
    });
    // \LogActivity::addToLog('Send mail for interview invitation ' . $email);
}

function sendToInterviewer($email, $data)
{
    $host = request()->getHost();
    $host = str_replace('.', '_', $host);
    $companyInfo = Config::get("rmconf.$host") ?? Config::get("rmconf.default");

    $companyName = $companyInfo['name'];
    $companyEmail = $companyInfo['hr_mail'];

    // switch ($host) {
    //     case 'hris.lakeshorebakery.com':
    //         $companyName = Config::get('rmconf.lakeshorebakery');
    //         $companyEmail =  Config::get('rmconf.lakeshorebakeryemail');
    //         break;
    //     case 'hris.drawhousedesign.com':
    //         $companyName = Config::get('rmconf.drawhousedesign');
    //         $companyEmail = Config::get('rmconf.drawhousedesignemail');
    //         break;
    //     case 'hris.konacafedhaka.com':
    //         $companyName = Config::get('rmconf.konacafedhaka');
    //         $companyEmail =  Config::get('rmconf.konacafedhakaemail');
    //         break;
    //     case 'hris.pochegroup.com':
    //         $companyName =  Config::get('rmconf.pochegroup');
    //         $companyEmail =  Config::get('rmconf.pochegroupemail');
    //         break;
    //     case 'hris.lakeshorebanani.com.bd':
    //         $companyName =  Config::get('rmconf.lakeshoresuites');
    //         $companyEmail =  Config::get('rmconf.suitesemail');
    //         break;
    //     case 'hris.themidoridhaka.com':
    //         $companyName =  Config::get('rmconf.midory');
    //         $companyEmail =  Config::get('rmconf.midoriemail');
    //         break;
    //     default:
    //         $companyName = Config::get('rmconf.drawhousedesign');
    //         $companyEmail = Config::get('rmconf.drawhousedesignemail');
    //         break;
    // }


    Mail::send('emails.interviewer',  ['data' => $data], function ($m) use ($email, $companyEmail, $companyName) {
        $m->from($companyEmail, 'Interview session for ' . $companyName);
        $m->to($email)->subject('Interview Mail');
    });
    // \LogActivity::addToLog('Send mail to interviewer ' . $email);
}


function sendEmployeeCredential($data)
{
    $host = request()->getHost();
    $host = str_replace('.', '_', $host);
    $companyInfo = Config::get("rmconf.$host") ?? Config::get("rmconf.default");

    $companyName = $companyInfo['name'];
    $companyEmail = $companyInfo['hr_mail'];

    // switch ($host) {
    //     case 'hris.lakeshorebakery.com':
    //         $companyName = Config::get('rmconf.lakeshorebakery');
    //         $companyEmail =  Config::get('rmconf.lakeshorebakeryemail');
    //         break;
    //     case 'hris.drawhousedesign.com':
    //         $companyName = Config::get('rmconf.drawhousedesign');
    //         $companyEmail = Config::get('rmconf.drawhousedesignemail');
    //         break;
    //     case 'hris.konacafedhaka.com':
    //         $companyName = Config::get('rmconf.konacafedhaka');
    //         $companyEmail =  Config::get('rmconf.konacafedhakaemail');
    //         break;
    //     case 'hris.pochegroup.com':
    //         $companyName =  Config::get('rmconf.pochegroup');
    //         $companyEmail =  Config::get('rmconf.pochegroupemail');
    //         break;
    //     case 'hris.lakeshorebanani.com.bd':
    //         $companyName =  Config::get('rmconf.lakeshoresuites');
    //         $companyEmail =  Config::get('rmconf.suitesemail');
    //         break;
    //     case 'hris.themidoridhaka.com':
    //         $companyName =  Config::get('rmconf.midory');
    //         $companyEmail =  Config::get('rmconf.midoriemail');
    //         break;
    //     default:
    //         $companyName = Config::get('rmconf.drawhousedesign');
    //         $companyEmail = Config::get('rmconf.drawhousedesignemail');
    //         break;
    // }
    Mail::send('emails.employee',  ['data' => $data], function ($m) use ($data, $companyEmail, $companyName) {
        $m->from($companyEmail, 'Credentials of ' . $companyName);
        $m->to($data['email'])->subject('HRIS Access Information');
    });
    \LogActivity::addToLog('Send credential to ' . $data['email']);
}

function getDepartment($id)
{
    $result = Department::find($id);
    return $result ? $result->Department : 0;
}
function getDesignation($id)
{
    $result = Designation::find($id);
    return $result ? $result->Designation : 0;
}
function getIncType($id)
{
    $result = DB::table('hr_setup_incrementtype')->where('id', $id)->OrderBy('id', 'DESC')->first();
    return $result ? $result->IncType : 0;
}

function cartItems()
{
    // Retrieve cart data from the session
    $cartData = Session::get('cart');

    // Initialize an array to store the cart items with details
    $cartItemsWithDetails = [];

    if ($cartData) {
        foreach ($cartData as $cartItemKey => $cartItem) {
            $productId = $cartItem['productId'];

            // Retrieve product details by product ID
            $product = Product::find($productId);

            if ($product) {
                // Retrieve size details if productSizeId is available
                $size = null;
                if (!empty($cartItem['productSizeId'])) {
                    $size = ProductSize::find($cartItem['productSizeId']);
                }

                // Retrieve option details if productOptionIds are available
                $options = [];
                if (!empty($cartItem['productOptionIds'])) {
                    $optionIds = $cartItem['productOptionIds'];
                    $options = ProductOption::whereIn('id', $optionIds)->get();
                }

                foreach ($options as $option) {
                    // Check if the addon has special pricing
                    $currentDate = now();
                    if (
                        $option->offer_money_from !== null &&
                        $option->offer_money_to !== null &&
                        $currentDate >= $option->offer_money_from &&
                        $currentDate <= $option->offer_money_to
                    ) {
                        // If the current date is within the special price period, update the price
                        $option->offer_money = $option->offer_price;
                    }
                }

                $productPrice = "";
                if ($size) {
                    // Calculate the product price based on special price period
                    $currentDate = now(); // Get the current date and time
                    $productPrice = $size->selling_price; // Default to selling price

                    if (
                        $size->special_price_from !== null &&
                        $size->special_price_to !== null &&
                        $currentDate >= $size->special_price_from &&
                        $currentDate <= $size->special_price_to
                    ) {
                        // If the current date is within the special price period, use the special price
                        $productPrice = $size->special_price;
                    }
                }


                // Retrieve addon details if productAddonIds are available
                $addons = [];
                if (!empty($cartItem['productAddonIds'])) {
                    $addonIds = $cartItem['productAddonIds'];
                    $addons = ProductAdon::whereIn('id', $addonIds)->get();
                }

                foreach ($addons as $addon) {
                    // Check if the addon has special pricing
                    if (
                        $addon->offer_money_from !== null &&
                        $addon->offer_money_to !== null &&
                        $currentDate >= $addon->offer_money_from &&
                        $currentDate <= $addon->offer_money_to
                    ) {
                        // If the current date is within the special price period, update the price
                        $addon->offer_price = $addon->offer_money_added;
                    }
                }


                // Add the product details, size, options, addons, and price to the cart item
                $cartItemsWithDetails[$cartItemKey] = [
                    'product' => $product,
                    'product_id' => $product->id,
                    'product_name' => $product->name,
                    'size' => $size,
                    'product_size_id' => $size->id,
                    'size_name' => $size->size_name,
                    'options' => $options,
                    'addons' => $addons,
                    'quantity' => $cartItem['productQuantity'],
                    'price' => $productPrice,
                ];
            }
        }
    }

    return $cartItemsWithDetails;
}

function totalCartItem()
{
    $quantity = 0;
    foreach (cartItems() as $i => $value) {
        $quantity += $value['quantity'];
    }
    return $quantity;
}

function totalCartPrice()
{
    $totalPrice = 0;
    foreach (cartItems() as $i => $value) {
        $totalPrice += $value['price'];
    }
    return $totalPrice;
}

function basePriceFromFinalBill($totalBill, $servicePersentage, $taxPersentage)
{
    $withOutTax = ($totalBill / (1 + ($taxPersentage / 100)));
    $base = ($withOutTax / (1 + ($servicePersentage / 100)));

    return $base;
}

function totalServiceChargeFromFinalBill($totalBill, $servicePersentage, $taxPersentage)
{
    $withOutTax = ($totalBill / (1 + ($taxPersentage / 100)));
    $base = ($withOutTax / (1 + ($servicePersentage / 100)));
    $serviceCharge = $base * ($servicePersentage / 100);

    return $serviceCharge;
}

function totalServiceCharge($basicAmount, $persentage)
{
    $serviceCharge = $basicAmount * ($persentage / 100);
    return round($serviceCharge, 3);
}

function totalTax($beforeTax, $persentage)
{
    $taxAmount = $beforeTax * ($persentage / 100);
    return round($taxAmount, 3);
}

function getAllDataOfPaymentMethodTable($specialQuery = "")
{
    global $con;

    $result = array();

    $query = $con->query("select * from payment_method WHERE status > 0 $specialQuery");


    while ($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
        array_push($result, $row);
    }

    return $result;
    //print_r($result);
}

function totalVatFromFinalBill($totalBill, $taxPersentage)
{
    $withOutTax = ($totalBill / (1 + ($taxPersentage / 100)));
    $vat = $totalBill - $withOutTax;

    return $vat;
}

function grandTotalFromBasicAmount($basicAmount, $servicePersentage, $taxPersentage)
{
    $serviceCharge = $basicAmount * ($servicePersentage / 100);
    $beforeTax = $basicAmount + $serviceCharge;
    $taxAmount = $beforeTax * ($taxPersentage / 100);
    $grandTotal = $basicAmount + $serviceCharge + $taxAmount;

    return round($grandTotal, 3);
}

function getValueFromExtraTableByItemName($itemName)
{
    $extra = Extra::where('item_name', $itemName)->first();
    return $extra->item_value;
}


function getProductPriceFromSizeId($sizeId)
{
    $size = ProductSize::find($sizeId);

    $currentDate = date("Y-m-d H:i:s");

    if (!$size) return 0;

    if ($size->special_price_from < $currentDate && $size->special_price_to > $currentDate) {
        return $size->special_price;
    } else {
        return $size->selling_price;
    }
}


function getOrderProcessDetailsFromUniqueOrderId($uniqueOrderId)
{
    $orderProcess = OrderProcess::where('unique_order_id', $uniqueOrderId)->first();
    return $orderProcess ? $orderProcess->toArray() : array();
}

function getProductDetailsFromId($id)
{
    $product = Product::find($id);
    return $product ? $product->toarray() : array();
}

function getProductCategoryDetailsFromId($id)
{
    $category = ProductCategory::find($id);
    return $category ? $category->toArray() : array();
}

function getClientDetailsFromUniqueOrderId($uniqueOrderId, $specialQuery = "")
{
    $orderProcess = getOrderProcessDetailsFromUniqueOrderId($uniqueOrderId);

    $customer = Customer::find($orderProcess['client_id']);
    return $customer ? $customer->toArray() : array();
}

function getProductAddonPrice($addon)
{

    if (gettype($addon) == "object") {
        $addon = $addon->toArray();
    } else if (gettype($addon) != "array") {
        $addon = ProductAdon::find($addon);
        $addon = $addon->toArray();
    }
    $currentDate = date("Y-m-d H:i:s");
    if ($addon['offer_money_from'] < $currentDate && $addon['offer_money_to'] > $currentDate) {
        return $addon['offer_money_added'];
    } else {
        return $addon['extra_money_added'];
    }
}

function getProductOptionPrice($option)
{

    if (gettype($option) == "object") {
        $option = $option->toArray();
    } else if (gettype($option) != "array") {
        $option = ProductOption::find($option);
        $option = $option->toArray();
    }
    $currentDate = date("Y-m-d H:i:s");
    if ($option['offer_money_from'] < $currentDate && $option['offer_money_to'] > $currentDate) {
        return $option['offer_price'];
    } else {
        return $option['extra_price'];
    }
}

function getOptionsNameByIds($ids)
{
    $optionsName = ProductOption::whereIn('id', explode(',', $ids))->pluck('name')->toArray();
    return implode(',', $optionsName);
}

function getAddonsNameByIds($ids)
{
    $addonsName = ProductAdon::whereIn('id', explode(',', $ids))->pluck('name')->toArray();
    return implode(',', $addonsName);
}

function showProcessingWindow()
{
    ?>
        <!DOCTYPE html>
        <html lang="en">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Adding to Cart</title>
            <style>
                @import url("https://fonts.googleapis.com/css?family=Amatic+SC");

                body {
                    background-color: #ffde6b;
                    height: 100vh;
                    width: 100vw;
                    overflow: hidden;
                }

                h1 {
                    position: relative;
                    margin: 0 auto;
                    top: 25vh;
                    width: 100vw;
                    text-align: center;
                    font-family: 'Amatic SC';
                    font-size: 6vh;
                    color: #333;
                    opacity: .75;
                    animation: pulse 2.5s linear infinite;
                }

                h1 .custom {
                    position: relative;
                    margin: 0 auto;
                    top: 25vh;
                    width: 100vw;
                    text-align: center;
                    font-family: 'Amatic SC';
                    font-size: 6vh;
                    color: #333;
                    opacity: .75;
                }

                #cooking {
                    position: relative;
                    margin: 0 auto;
                    top: 0;
                    width: 75vh;
                    height: 75vh;
                    overflow: hidden;
                }

                #cooking .bubble {
                    position: absolute;
                    border-radius: 100%;
                    box-shadow: 0 0 0.25vh #4d4d4d;
                    opacity: 0;
                }

                #cooking .bubble:nth-child(1) {
                    margin-top: 2.5vh;
                    left: 58%;
                    width: 2.5vh;
                    height: 2.5vh;
                    background-color: #454545;
                    animation: bubble 2s cubic-bezier(0.53, 0.16, 0.39, 0.96) infinite;
                }

                #cooking .bubble:nth-child(2) {
                    margin-top: 3vh;
                    left: 52%;
                    width: 2vh;
                    height: 2vh;
                    background-color: #3d3d3d;
                    animation: bubble 2s ease-in-out .35s infinite;
                }

                #cooking .bubble:nth-child(3) {
                    margin-top: 1.8vh;
                    left: 50%;
                    width: 1.5vh;
                    height: 1.5vh;
                    background-color: #333;
                    animation: bubble 1.5s cubic-bezier(0.53, 0.16, 0.39, 0.96) 0.55s infinite;
                }

                #cooking .bubble:nth-child(4) {
                    margin-top: 2.7vh;
                    left: 56%;
                    width: 1.2vh;
                    height: 1.2vh;
                    background-color: #2b2b2b;
                    animation: bubble 1.8s cubic-bezier(0.53, 0.16, 0.39, 0.96) 0.9s infinite;
                }

                #cooking .bubble:nth-child(5) {
                    margin-top: 2.7vh;
                    left: 63%;
                    width: 1.1vh;
                    height: 1.1vh;
                    background-color: #242424;
                    animation: bubble 1.6s ease-in-out 1s infinite;
                }

                #cooking #area {
                    position: absolute;
                    bottom: 0;
                    right: 0;
                    width: 50%;
                    height: 50%;
                    background-color: transparent;
                    transform-origin: 15% 60%;
                    animation: flip 2.1s ease-in-out infinite;
                }

                #cooking #area #sides {
                    position: absolute;
                    width: 100%;
                    height: 100%;
                    transform-origin: 15% 60%;
                    animation: switchSide 2.1s ease-in-out infinite;
                }

                #cooking #area #sides #handle {
                    position: absolute;
                    bottom: 18%;
                    right: 80%;
                    width: 35%;
                    height: 20%;
                    background-color: transparent;
                    border-top: 1vh solid #333;
                    border-left: 1vh solid transparent;
                    border-radius: 100%;
                    transform: rotate(20deg) rotateX(0deg) scale(1.3, 0.9);
                }

                #cooking #area #sides #pan {
                    position: absolute;
                    bottom: 20%;
                    right: 30%;
                    width: 50%;
                    height: 8%;
                    background-color: #333;
                    border-radius: 0 0 1.4em 1.4em;
                    transform-origin: -15% 0;
                }

                #cooking #area #pancake {
                    position: absolute;
                    top: 24%;
                    width: 100%;
                    height: 100%;
                    transform: rotateX(85deg);
                    animation: jump 2.1s ease-in-out infinite;
                }

                #cooking #area #pancake #pastry {
                    position: absolute;
                    bottom: 26%;
                    right: 37%;
                    width: 40%;
                    height: 45%;
                    background-color: #333;
                    box-shadow: 0 0 3px 0 #333;
                    border-radius: 100%;
                    transform-origin: -20% 0;
                    animation: fly 2.1s ease-in-out infinite;
                }

                @keyframes jump {
                    0% {
                        top: 24%;
                        transform: rotateX(85deg);
                    }

                    25% {
                        top: 10%;
                        transform: rotateX(0deg);
                    }

                    50% {
                        top: 30%;
                        transform: rotateX(85deg);
                    }

                    75% {
                        transform: rotateX(0deg);
                    }

                    100% {
                        transform: rotateX(85deg);
                    }
                }

                @keyframes flip {
                    0% {
                        transform: rotate(0deg);
                    }

                    5% {
                        transform: rotate(-27deg);
                    }

                    30%,
                    50% {
                        transform: rotate(0deg);
                    }

                    55% {
                        transform: rotate(27deg);
                    }

                    83.3% {
                        transform: rotate(0deg);
                    }

                    100% {
                        transform: rotate(0deg);
                    }
                }

                @keyframes switchSide {
                    0% {
                        transform: rotateY(0deg);
                    }

                    50% {
                        transform: rotateY(180deg);
                    }

                    100% {
                        transform: rotateY(0deg);
                    }
                }

                @keyframes fly {
                    0% {
                        bottom: 26%;
                        transform: rotate(0deg);
                    }

                    10% {
                        bottom: 40%;
                    }

                    50% {
                        bottom: 26%;
                        transform: rotate(-190deg);
                    }

                    80% {
                        bottom: 40%;
                    }

                    100% {
                        bottom: 26%;
                        transform: rotate(0deg);
                    }
                }

                @keyframes bubble {
                    0% {
                        transform: scale(0.15, 0.15);
                        top: 80%;
                        opacity: 0;
                    }

                    50% {
                        transform: scale(1.1, 1.1);
                        opacity: 1;
                    }

                    100% {
                        transform: scale(0.33, 0.33);
                        top: 60%;
                        opacity: 0;
                    }
                }

                @keyframes pulse {
                    0% {
                        transform: scale(1, 1);
                        opacity: .25;
                    }

                    50% {
                        transform: scale(1.2, 1);
                        opacity: 1;
                    }

                    100% {
                        transform: scale(1, 1);
                        opacity: .25;
                    }
                }
            </style>
        </head>

        <body>

            <h1>Things Being Cooked !</h1>
            <h1 class="custom">This Is Not Your Place, Redirecting to your Page</h1>


            <div id="cooking">
                <div class="bubble"></div>
                <div class="bubble"></div>
                <div class="bubble"></div>
                <div class="bubble"></div>
                <div class="bubble"></div>
                <div id="area">
                    <div id="sides">
                        <div id="pan"></div>
                        <div id="handle"></div>
                    </div>
                    <div id="pancake">
                        <div id="pastry"></div>
                    </div>
                </div>
            </div>

            <script>
                setTimeout(function() {
                    window.history.back();
                }, 5000);
            </script>
        </body>

        </html>
    <?php
}

function make_key_value($data)
{
    $temp = array();
    foreach ($data as $val) $temp[$val] = $val;
    return $temp;
}


function return_library($object, $key_col, $value_col)
{
    $data = array();
    foreach ($object as $item)
        $data[$item->$key_col] = $item->$value_col;
    return $data;
}

function lib_size()
{
    return return_library(ProductSize::get(), 'id', 'size_name');
}

function lib_regular_prize()
{
    return return_library(ProductSize::where('size_name', 'Regular')->get(), 'product_id', 'selling_price');
}

function lib_product()
{
    return return_library(Product::get(), 'id', 'name');
}

function lib_price()
{
    return return_library(ProductSize::get(), 'id', 'selling_price');
}
function lib_wholesale_price()
{
    return return_library(ProductSize::get(), 'id', 'wholesale_price');
}
function lib_corporate_price()
{
    return return_library(ProductSize::get(), 'id', 'corporate_price');
}

function lib_option()
{
    return return_library(ProductOption::where('status', '1')->get(), 'id', 'name');
}

function lib_addon()
{
    return return_library(ProductAdon::where('status', '1')->get(), 'id', 'name');
}

function lib_category()
{
    return return_library(ProductCategory::where('status', '1')->get(), 'id', 'name');
}

function lib_table()
{
    return return_library(Table::where('status', '1')->get(), 'id', 'name');
}
function lib_room()
{
    return return_library(Room::where('status', '1')->get(), 'id', 'room_no');
}


function _print($data, $exit = 0)
{
    echo "<pre>";
    print_r($data);
    echo "</pre>";
    if (!$exit) exit;
}

function testMail()
{
    $companyEmail = 'hr@drawhousedesign.com';
    $email = ['rebeluits@gmail.com', '2021100010008@seu.edu.bd'];

    // Define the data you want to send in the email
    $data = [
        'companyEmail' => $companyEmail,
        'email' => $email,
    ];

    Mail::send('emails.testmail', $data, function ($m) use ($data) {
        $m->from($data['companyEmail'], 'test mail ');

        foreach ($data['email'] as $recipient) {
            $m->to($recipient);
        }

        $m->subject('Interview Mail');
    });
}

function getCompanyList($type = null)
{
    if (DeveloperCheck() || Sentinel::inRole('superadmin') || $type == 1) {
        $complists = Company::orderBy('id', 'ASC')->where('C4S', 'Y')->pluck('Name', 'id');
    } elseif ($type == 2) {
        $compid = Sentinel::getUser()->company_id;
        $complists = Company::orderBy('id', 'ASC')->whereIn('id', [$compid])->where('C4S', 'Y')->pluck('Name', 'id');
    }  else {
        $compid = getHostInfo()['id'];
        $complists = Company::orderBy('id', 'ASC')->whereIn('id', [$compid])->where('C4S', 'Y')->pluck('Name', 'id');
    }
    return $complists;
}

function getCompanyIds($type = null)
{
    if (DeveloperCheck() || Sentinel::inRole('superadmin') || $type == 1) {
        $complists = Company::orderBy('id', 'ASC')->where('C4S', 'Y')->pluck('id');
    } elseif ($type == 2) {
        $compid = Sentinel::getUser()->company_id;
        $complists = Company::orderBy('id', 'ASC')->whereIn('id', [$compid])->where('C4S', 'Y')->pluck('id');
    } else {
        $compid = getHostInfo()['id'];
        $complists = Company::orderBy('id', 'ASC')->whereIn('id', [$compid])->where('C4S', 'Y')->pluck('id');
    }
    return $complists;
}

function getCompanyName($id = null)
{
    $result = Company::find($id);
    return $result ? $result : 0;

}

function getRemDomain()
{
    $result = 'https://hris.drawhousedesign.com';
    return $result;
}

function sendMail()
{
    Mail::send('emails.testmail', [], function ($m) {
        $m->from('hr@drawhousedesign.com', 'Test mail ');
        $m->to('rebeluits@gmail.com')->cc(['shuvro.cse.bsmrstu@gmail.com', 'mdsajibhassan01993@gmail.com'])->subject('Test mail');
    });
}

function getHostInfo()
{
    $host = str_replace('.', '_', request()->getHost());
    $result = Config::get("rmconf.$host") ?? Config::get("rmconf.default");
    return $result;
}

function generateRandomColor()
{
    return '#' . str_pad(dechex(mt_rand(0, 255)), 2, '0', STR_PAD_LEFT)
        . str_pad(dechex(mt_rand(0, 255)), 2, '0', STR_PAD_LEFT)
        . str_pad(dechex(mt_rand(0, 255)), 2, '0', STR_PAD_LEFT);
}
function getRandomColor($n)
{
    $uniqueColors = array();

    while (count($uniqueColors) < $n) {
        $color = generateRandomColor();
        if (!in_array($color, $uniqueColors)) {
            $uniqueColors[] = $color;
        }
    }
    return $uniqueColors;
}

function format($date, $formate)
{
    $formattedDate = Carbon::parse($date)->format($formate);
    return $formattedDate;
}

function numberFormat($number, $digit)
{
    $formatedNumber = number_format($number,$digit);
    $intNumber = (int)$formatedNumber;
    if($intNumber<$formatedNumber) return $formatedNumber;
    else return $intNumber;
}

function divisor($n){
    return $n == 0 ? 1 : $n;
}

function getOptions(){
    $result = HROptions::orderBy('id','DESC')->first();
    return $result ? $result : 0;
}

function abnormalAttendanceType()
{
    return [
        1 => 'IN (Late or punch missed at morning)',
        2 => 'OUT (Early Leave or punch missed at night)',
        3 => "BOTH (Didn't came office but work outside or punch missed at morning and night)",
    ];
}

function paymentMethodCategory()
{
    return [
        0 => "No Category",
        1 => 'Cash',
        2 => 'Card',
        3 => "Food App",
        4 => "Payment App",
        5 => "Management",
        6 => "Complementary",
    ];
}

function discountCategory()
{
    return [
        1 => 'Direct',
        2 => 'Percentage',
    ];
}

function salesTypes(){
    return[
        1 => 'Retail',
        2 => 'Wholesale',
        3 => 'Corporate',
    ];
}

function getUsersRoleWise($roles){
    // return $roles;
    return Users::join('roles','roles.id','=','users.role_id')->whereIn('roles.id',$roles)->select('users.id as user_id','users.fullname','users.first_name','users.last_name')->where('users.C4S', 'Y')->get();
}

function userWiseCompanies($companies){
    return Company::whereIn('id',$companies)->where('C4S', 'Y')->get();
}
function getAdvType() {
    return [
        1 => 'Advance',
        2 => 'Loan',
    ];
}
function getIncSource() {
    return [
        1 => 'Gross',
        2 => 'Basic',
        3 => 'Housing Allow',
    ];
}
function getPayType() {
    return [
        1 => 'Amount',
        2 => 'Percent %',
    ];
}

function dineinPlace() {
    return [
        1 => 'Table',
        2 => 'Room',
    ];
}

function getRWH($starthr, $endhr, $startpunch, $endpunch) {
    if ($startpunch <= $starthr && $endhr <= $endpunch) {
        $rwhorg = hourCalculateActual($starthr, $endhr);
    } elseif ($startpunch > $starthr && $endhr <= $endpunch) {
        $rwhorg = hourCalculateActual($startpunch, $endhr);
    } elseif ($startpunch <= $starthr && $endhr > $endpunch) {
        $rwhorg = hourCalculateActual($starthr, $endpunch);
    } elseif ($startpunch > $starthr && $endhr > $endpunch) {
        $rwhorg = hourCalculateActual($startpunch, $endpunch);
    } else {
        $rwhorg = 0;
    }
    $realhr = $rwhorg >= 8 ? 8 : ($rwhorg > 0 ? $rwhorg : 0);
    return $realhr;
}