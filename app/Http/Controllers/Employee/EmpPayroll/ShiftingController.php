<?php

namespace App\Http\Controllers\Employee\EmpPayroll;

use DB;
use Input;
use Redirect;
use Sentinel;
use Validator;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\HRIS\Setup\Shifts;
use App\Models\HRIS\Tools\Calendar;
use App\Http\Controllers\Controller;
use App\Models\HRIS\Tools\HROptions;
use App\Models\HRIS\Database\Employee;
use App\Models\HRIS\Tools\ShiftingList;
use App\Models\HRIS\Tools\ProcessSalary;
use App\Models\Library\General\Company;

class ShiftingController extends Controller
{
    public function index()
    {
        if (getAccess('view')) {
            $hroptions = HROptions::orderBy('id', 'DESC')->first();
            $calendars = Calendar::orderBy('id', 'ASC')->whereYear('Date', '=', $hroptions->Year)->get();
            $shiftlist = Shifts::orderBy('id', 'ASC')->where('C4S', 'Y')->get();
            return view('employee.emppayroll.shifting.index', compact('calendars', 'shiftlist'));
        } else {
            return redirect()->back()->with('warning', getNotify(5));
        }
    }

   
}
