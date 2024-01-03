<?php

namespace App\Http\Controllers\Employee\ResourceHub;

use Sentinel;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\HRIS\Setup\Notice;
use App\Http\Controllers\Controller;
use App\Models\HRIS\Setup\NoticeAssign;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class NoticeController extends Controller
{
    public function index()
    {
        if (getAccess('view')) {
            $today = Carbon::now()->toDateString();
            $notices = Notice::leftJoin('hr_setup_notice_participants as par', 'par.notice_id', '=', 'hr_setup_notices.id')->where('hr_setup_notices.showing_date', '<=', $today)->select('hr_setup_notices.*', 'par.*')->orderBy('hr_setup_notices.created_at', 'desc')->get();
            foreach ($notices as $item) {
                $getParticipants = NoticeAssign::where('emp_id', $item->emp_id)->get();
                if ($item->seen == '0') {
                    foreach ($getParticipants as $parti) {
                        $parti->seen  = '1';
                        $parti->update();
                    }
                }
            }
            return view('employee.setup.notice.index', compact('notices'));
        } else {
            return redirect()->back()->with('warning', getNotify(5));
        }
    }
}
