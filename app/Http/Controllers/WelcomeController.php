<?php

namespace App\Http\Controllers;

use Sentinel;
use App\Models\Users;
use Illuminate\Http\Request;
use App\Models\HRIS\Database\EmpUser;
use App\Models\HRIS\Database\EmpEntry;
use App\Models\HRIS\Database\Employee;
use Illuminate\Support\Facades\Config;
use App\Models\HRIS\Database\EmployeeSalary;
use App\Models\HRIS\Database\EmployeePersonal;
use Cartalyst\Sentinel\Laravel\Facades\Activation;

class WelcomeController extends Controller
{
    public function index()
    {
        if(Sentinel::getUser()->id == 1){
            /*$usrid = Users::pluck('empid');
            $empids = Employee::whereNotIn('EmployeeID', $usrid)->pluck('EmployeeID');
            dd($empids);*/
            
            /* $oldemp = 1042; 
            $comp = 4;
            $newemp = (int)$comp.$oldemp;
            Users::where('empid', $oldemp)->update(['empid' => $newemp]);
            Employee::where('EmployeeID', $oldemp)->update(['EmployeeID' => $newemp,'company_id'=>$comp]);
            EmployeeSalary::where('EmployeeID', $oldemp)->update(['EmployeeID' => $newemp]);
            EmployeePersonal::where('EmployeeID', $oldemp)->update(['EmployeeID' => $newemp]); */
            //sendMail();

            /* $emp = Employee::pluck('EmployeeID');
            $result = EmployeeSalary::whereNotIn('EmployeeID', $emp)->pluck('EmployeeID');
            dd($result); */


            /* for ($i = 1; $i < count($request->en_answer); $i++) {
                $answers[] = [
                    'user_id' => Sentinel::getUser()->id,
                    'en_answer' => $request->en_answer[$i],
                    'question_id' => $request->question_id[$i]
                ];
            }
            EnAnswer::insert($answers); */
        }
        $roleName =  Sentinel::getUser()->roles[0]->name ?? null;
        if ($roleName == 'General') {
            return redirect()->route('employee.dashboard');
        } else {
            return view('welcome')->with('active', 'welcome');
        }
    }
}
