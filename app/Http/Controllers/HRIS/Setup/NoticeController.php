<?php

namespace App\Http\Controllers\HRIS\Setup;

use Sentinel;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\HRIS\Setup\Notice;
use App\Http\Controllers\Controller;
use App\Models\HRIS\Database\Employee;
use App\Models\HRIS\Setup\NoticeAssign;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class NoticeController extends Controller
{
    public function index()
    {
        if (getAccess('view')) {
            $userid = Sentinel::getUser()->id; 
            $notices = Notice::where('company_id',getHostInfo()['id'])->where('created_by',$userid)->latest()->get();
            return view('hris.setup.notice.index', compact('notices'));
        } else {
            return redirect()->back()->with('warning', getNotify(5));
        }
    }

    /**
     * Show the form for creating a new resource.
     */


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->all();
        if (getAccess('create')) {
            $userid = Sentinel::getUser()->id;
            $attributes = $request->all();
            $rules = [
                'content' => 'required',
                'name' => 'required|max:255',
                'n_date' => 'required',
                'showing_date' => 'required',
                'status' => 'required',
            ];
            $validation = Validator::make($attributes, $rules);
            if ($validation->fails()) {
                return redirect()->action('HRIS\Setup\NoticeController@index')->with(['error' => getNotify(4), 'error_code' => 'Add'])->withErrors($validation)->withInput();
            } else {
                $notice = new Notice();
                $notice->company_id = getHostInfo()['id'];
                $notice->notice = $request->content;
                $notice->name = $request->name;
                $notice->notice_date = $request->n_date;
                $notice->showing_date = $request->showing_date;
                $notice->remarks = $request->remarks;
                $notice->created_by =  $userid;
                $notice->status = $request->status;
                $notice->save();

                $employees = Employee::where('company_id',getHostInfo()['id'])->get();
                // $employees;
                foreach ($employees as $employee) {
                    $noticeAssign = new NoticeAssign();
                    $noticeAssign->notice_id = $notice->id;
                    $noticeAssign->emp_id = $employee->EmployeeID;
                    $noticeAssign->save();
                }
                \LogActivity::addToLog('Add Notice ' . $attributes['name']);
                return redirect()->action('HRIS\Setup\NoticeController@index')->with('success', getNotify(1));
            }
        } else {
            return redirect()->back()->with('warning', getNotify(5));
        }
    }
    public function getYourNotice()
    {
        $holidayDate = Carbon::now()->toDateString();
        $notice_has_persmissions = NoticeHasPermission::join('notices', 'notices.id', '=', 'notice_permissions.notice_id')
            ->where('notice_permissions.user_id', auth()->user()->id)
            ->where('notices.company_id',getHostInfo()['id'])
            ->where('showing_date', '<=', $holidayDate)
            ->where('notices.status', '1')
            ->select('notices.*')
            ->orderBy('created_at', 'desc')
            ->get();
        return view('backend.notice.show', compact('notice_has_persmissions'));
    }



    public function show(string $id)
    {
        $notice = Notice::join('users', 'users.id', '=', 'notices.created_by')
            ->select('notices.*', 'users.name as user_name')
            ->where('notices.id', $id)
            ->first();
        $noticeComments = NoticeHasPermission::join('users', 'users.id', '=', 'notice_permissions.user_id')
            ->select('notice_permissions.*', 'users.name')
            ->where('notice_permissions.comment', '!=', null)
            ->where('notice_permissions.notice_id', $id)
            ->get();
        $getPersmissionData = NoticeHasPermission::where('user_id', auth()->user()->id)->where('notice_id', $id)->first();
        $getPersmissionData->seen_status = '1';
        $getPersmissionData->update();
        return view('backend.notice.details', compact('notice', 'noticeComments'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $notice = Notice::findOrFail($id);
        $notice_has_persmissions = NoticeHasPermission::where('notice_id', $id)->get();
        $users = User::get();
        return view('backend.notice.edit', compact('notice', 'users', 'notice_has_persmissions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        if (getAccess('edit')) {
            $userid = Sentinel::getUser()->id;
            $attributes = $request->all();
            $rules = [
                'content' => 'required',
                'name' => 'required|max:255',
                'n_date' => 'required',
                'showing_date' => 'required',
                'status' => 'required',
            ];
            $validation = Validator::make($attributes, $rules);
            if ($validation->fails()) {
                return redirect()->action('HRIS\Setup\NoticeController@index')->with(['error' => getNotify(4), 'error_code' => $id])->withErrors($validation)->withInput();
            } else {
                $notice = Notice::findOrFail($id);
                $notice->company_id = getHostInfo()['id'];
                $notice->notice = $request->content;
                $notice->name = $request->name;
                $notice->notice_date = $request->n_date;
                $notice->showing_date = $request->showing_date;
                $notice->remarks = $request->remarks;
                $notice->updated_by =  $userid;
                $notice->status = $request->status;
                $notice->update();
                \LogActivity::addToLog('Update Notice ' . $attributes['name']);
                return redirect()->action('HRIS\Setup\NoticeController@index')->with('success', getNotify(1));
            }
        } else {
            return redirect()->back()->with('warning', getNotify(5));
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if (getAccess('delete')) {
            $notice = Notice::findOrFail($id);
            $notice->delete();
            NoticeAssign::where('notice_id', $id)->delete();
            return redirect()->back()->with('success', getNotify(1));
        } else {
            return redirect()->back()->with('warning', getNotify(5));
        }
    }

    public function noticeComment(Request $request)
    {
        $comment =  $request->comment;
        $id = $request->notice_id;

        $getPersmissionData = NoticeHasPermission::where('notice_id', $id)->where('user_id', auth()->user()->id)->first();
        $getPersmissionData->comment = $comment;
        $getPersmissionData->update();

        Session::flash('alert-type', 'success');
        Session::flash('message', 'Your Comment Sumbit Success');
        return redirect()->back();
    }
}
