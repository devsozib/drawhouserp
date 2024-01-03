<?php

namespace App\Http\Controllers\Employee\LearningDevelopment;

use Sentinel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\HRIS\Database\Employee;
use App\Models\HRIS\Setup\Department;
use App\Models\HRIS\Setup\Training;
use App\Models\HRIS\Setup\TrainingParticipant;
use App\Models\Library\General\Company;
use Illuminate\Support\Facades\Validator;

class TrainingMasterController extends Controller
{
    public function index()
    {
        if (getAccess('view')) {
            $userid = Sentinel::getUser()->empid;
            $trainings = Training::leftJoin('hr_setup_training_participants', 'hr_setup_training_participants.training_id', '=', 'hr_setup_trainings.id')
                ->select('hr_setup_trainings.*', 'hr_setup_training_participants.*')
                ->where('hr_setup_training_participants.participant_id', '=', $userid)
                ->get();
            foreach ($trainings as $item) {
                $getParticipants = TrainingParticipant::where('participant_id', $item->participant_id)->get();
                if ($item->seen == '0') {
                    foreach ($getParticipants as $parti) {
                        $parti->seen  = '1';
                        $parti->update();
                    }
                }
            }
            return view('employee.training.index', compact('trainings'));
        } else {
            return redirect()->back()->with('warning', getNotify(5));
        }
    }
}
