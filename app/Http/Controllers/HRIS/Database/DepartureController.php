<?php

namespace App\Http\Controllers\HRIS\Database;

use DB;
use Input;
use Redirect;
use Sentinel;
use Validator;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\HRIS\Database\Employee;
use App\Models\HRIS\Database\AdvanceLoan;
use App\Models\HRIS\Setup\DepartureReasons;

class DepartureController extends Controller
{
    public function index()
    {
        if (getAccess('view')) {
            $resonlist = DepartureReasons::orderBy('id', 'ASC')->where('C4S', 'Y')->pluck('Reason', 'ReasonID');
            return view('hris.database.departure.index', compact('resonlist'));
        } else {
            return redirect()->back()->with('warning', getNotify(5));
        }
    }

    public function store(Request $request)
    {
        $time = date('Y-m-d H:i:s');
        if (getAccess('create')) {
            $userid = Sentinel::getUser()->id;
            $attributes = $request->all();
            $rules = [
                'EmployeeID' => 'required|numeric',
                'ReasonID' => 'required|max:2',
                'LeavingNotes' => 'max:500',
                'LeavingDate' => 'date',
                // 'MTReturnDate' => 'date',
                'DocPdf' => 'mimes:pdf',
            ];
            $validation = Validator::make($attributes, $rules);
            if ($validation->fails()) {
                return response()->json(array('errors' => 'Selected fields are required!'));
            } else {
                $empid = Employee::where('EmployeeID', $attributes['EmployeeID'])->pluck('id')->first();
                if ($empid) {
                    $employee = Employee::find($empid);
                    $reasonid = $employee->ReasonID;
                    $newreasonid = $attributes['ReasonID'];
                    $lvdate = $employee->LeavingDate;
                    $newlvdate = $attributes['LeavingDate'];
                    $salary = $employee->Salaried;
                    $newsalary = $attributes['Salaried'];
                    $destinationPath = $fileName = '';
                    // if (($reasonid == 'L' && $newreasonid == 'N') || ($reasonid == 'R' && $newreasonid == 'N')) {
                    //     $rules = [
                    //         'DocPdf' => 'required|mimes:pdf',
                    //     ];
                    //     $validation = Validator::make($attributes, $rules);
                    //     if ($validation->fails()) {
                    //         return response()->json(array('errors' => 'PDF File are required!'));
                    //     }
                    // }
                    // $file = null;
                    // if (isset($attributes['DocPdf'])) {
                    //     $file = $attributes['DocPdf'];
                    // }
                    // if ($file) {

                    //     $destinationPath = 'uploads/hris/departure/';
                    //     $fileName = str_pad($employee->EmployeeID, 6, "0", STR_PAD_LEFT) . '_regular_' . $time . '.pdf';
                    //     $fileSize = $file->getClientSize();
                    //     $upload_success = $file->move($destinationPath, $fileName);
                    //     if ($upload_success) {
                    //         $employee->PdfPath = $destinationPath;
                    //         $employee->PdfName = $fileName;
                    //         $employee->PdfSize = $fileSize;
                    //     }
                    // }

                    if (Sentinel::inRole('superadmin')) {
                        if ($reasonid == 'R' && !Sentinel::inRole('superadmin')) {
                            return response()->json(array('errors' => 'You are not permitted to update this data'));
                        } elseif ($newreasonid == 'N') {
                            $employee->Salaried = $attributes['Salaried'];
                            $employee->LeavingDate = Null;
                            $employee->ReasonID = 'N';
                            $employee->LeavingNotes = $attributes['LeavingNotes'];
                            if ($attributes['MTReturnDate'] > 0) {
                                $employee->MTReturnDate = $attributes['MTReturnDate'];
                            }
                            $employee->CreatedBy = $userid;
                            $employee->updated_at = $time;
                            $employee->update();
                            \LogActivity::addToLog('Edit Departure Information To ' . $employee->EmployeeID);

                            return response()->json(array('success' => 'Departure Information Successfully Updated'));
                        } else {
                            $monthfirst = Carbon::now()->subDays(5)->startOfMonth()->format('Y-m-d');
                            if ($employee->LeavingDate == $attributes['LeavingDate'] || $newreasonid == 'M') {
                                $employee->Salaried = $attributes['Salaried'];
                                $employee->LeavingDate = $attributes['LeavingDate'];
                                $employee->ReasonID = $newreasonid;
                                $employee->LeavingNotes = $attributes['LeavingNotes'];
                                if ($newreasonid == 'M') {
                                    $employee->MTReturnDate = $attributes['MTReturnDate'];
                                }
                                $employee->CreatedBy = $userid;
                                $employee->updated_at = $time;
                                $employee->update();
                                \LogActivity::addToLog('Edit Departure Information To ' . $employee->EmployeeID);
                                userActivating($employee->EmployeeID);

                                return response()->json(array('success' => 'Departure Information Successfully Updated'));
                            } elseif ($monthfirst <= $attributes['LeavingDate']) {
                                $employee->Salaried = $attributes['Salaried'];
                                $employee->LeavingDate = $attributes['LeavingDate'];
                                $employee->ReasonID = $newreasonid;
                                $employee->LeavingNotes = $attributes['LeavingNotes'];
                                $employee->CreatedBy = $userid;
                                $employee->updated_at = $time;
                                $employee->update();
                                \LogActivity::addToLog('Edit Departure Information To ' . $employee->EmployeeID);
                                userActivating($employee->EmployeeID);

                                return response()->json(array('success' => 'Departure Information Successfully Updated'));
                            } else {
                                return response()->json(array('errors' => 'Can Not Enter The Departure Date For Previous Month!'));
                            }
                        }
                    } elseif ($reasonid == 'R' || $reasonid == 'L') {
                        return response()->json(array('errors' => 'You are not permitted to update this data'));
                    } elseif ($newreasonid == 'N') {
                        $employee->Salaried = $attributes['Salaried'];
                        $employee->LeavingDate = Null;
                        $employee->ReasonID = 'N';
                        $employee->LeavingNotes = $attributes['LeavingNotes'];
                        if ($attributes['MTReturnDate'] > 0) {
                            $employee->MTReturnDate = $attributes['MTReturnDate'];
                        }
                        $employee->CreatedBy = $userid;
                        $employee->updated_at = $time;
                        $employee->update();
                        \LogActivity::addToLog('Edit Departure Information To ' . $employee->EmployeeID);

                        return response()->json(array('success' => 'Departure Information Successfully Updated'));
                    } else {
                        $monthfirst = Carbon::now()->subDays(5)->startOfMonth()->format('Y-m-d');
                        if ($employee->LeavingDate == $attributes['LeavingDate'] || $newreasonid == 'M') {
                            $employee->Salaried = $attributes['Salaried'];
                            $employee->LeavingDate = $attributes['LeavingDate'];
                            $employee->ReasonID = $newreasonid;
                            $employee->LeavingNotes = $attributes['LeavingNotes'];
                            if ($newreasonid == 'M') {
                                $employee->MTReturnDate = $attributes['MTReturnDate'];
                            }
                            $employee->CreatedBy = $userid;
                            $employee->updated_at = $time;
                            $employee->update();
                            userActivating($employee->EmployeeID);
                            \LogActivity::addToLog('Edit Departure Information To ' . $employee->EmployeeID);

                            return response()->json(array('success' => 'Departure Information Successfully Updated'));
                        } elseif ($monthfirst <= $attributes['LeavingDate']) {
                            $employee->Salaried = $attributes['Salaried'];
                            $employee->LeavingDate = $attributes['LeavingDate'];
                            $employee->ReasonID = $newreasonid;
                            $employee->LeavingNotes = $attributes['LeavingNotes'];
                            $employee->CreatedBy = $userid;
                            $employee->updated_at = $time;
                            $employee->update();
                            userActivating($employee->EmployeeID);
                            \LogActivity::addToLog('Edit Departure Information To ' . $employee->EmployeeID);

                            return response()->json(array('success' => 'Departure Information Successfully Updated'));
                        } else {
                            return response()->json(array('errors' => 'Can Not Enter The Departure Date For Previous Month!'));
                        }
                    }
                } else {
                    return response()->json(array('errors' => 'Employee Not Found!'));
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
            ->select('basic.id', 'basic.Name', 'hr_setup_designation.Designation', 'hr_setup_department.Department', 'basic.JoiningDate', 'basic.Salaried', 'basic.LeavingDate', 'basic.ReasonID', 'basic.LeavingNotes', 'basic.MTReturnDate','basic.PhotoName AS Photo')
            ->first();
        if ($empl) {
            $advamnt = AdvanceLoan::where('EmployeeID', $request->emp_id)->where('Closed', 'N')->sum('BalanceAmount');
            if ($empl->ReasonID != 'N') {
                $leavingdate = Carbon::parse($empl->LeavingDate);
                $year = Carbon::parse($empl->JoiningDate)->diff($leavingdate)->format('%y');
                $month = Carbon::parse($empl->JoiningDate)->diff($leavingdate)->format('%m');
                $day = Carbon::parse($empl->JoiningDate)->diff($leavingdate)->format('%d');
            } else {
                $today = Carbon::now()->addDays(1);
                $year = Carbon::parse($empl->JoiningDate)->diff($today)->format('%y');
                $month = Carbon::parse($empl->JoiningDate)->diff($today)->format('%m');
                $day = Carbon::parse($empl->JoiningDate)->diff($today)->format('%d');
            }

            return response()->json([$empl, $year, $month, $day, $advamnt]);
        } else {
            return response()->json(0);
        }
    }
}
