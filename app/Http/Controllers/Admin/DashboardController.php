<?php

namespace App\Http\Controllers\Admin;

use Sentinel;
use Carbon\Carbon;
use App\Models\Users;
use App\Models\Feedback;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index() {
        $users = Users::orderBy('id','ASC')->get();
        return view('admin.dashboard', compact('users'));
    }

    public function getFeedback(){
        $userID = Sentinel::getUser()->id;
        $feedBacks = Feedback::join('hr_database_employee_basic','hr_database_employee_basic.EmployeeID','=','feedbacks.created_by')
        ->join('lib_company','hr_database_employee_basic.company_id','=','lib_company.id')
        ->select('feedbacks.*','lib_company.Name','hr_database_employee_basic.Name as empname')
        ->get();
        return view('admin.feedback.index',compact('feedBacks'));
    }
}
