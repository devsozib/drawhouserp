<?php

namespace App\Http\Controllers\Library\General;

use Input;
use Sentinel;
use Validator;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use App\Models\Library\General\Company;
use App\Models\Library\General\Room;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function index(Request $request)
    {
        if (getAccess('view')) {
            // $users = Company::orderBy('id', 'ASC')->get();
            $users = Room::orderBy('id', 'ASC')->get();
            $comp_arr = Company::orderBy('id','ASC')->where('C4S','Y')->pluck('Name','id');
            return view('library.general.room.index', compact('users','comp_arr'));
        } else {
            return redirect()->back()->with('warning', getNotify(5));
        }
    }

    public function store(Request $request)
    {
        if (getAccess('create')) {
            $userid = Sentinel::getUser()->id;
            $attributes = Input::all();
            $rules = [
                'company_id' => 'required',
                'room_no' => 'required|max:10|unique:lib_rooms,room_no,NULL,id,company_id,' . $attributes['company_id'],
                'status' => 'required',
            ];
            $validation = Validator::make($attributes, $rules);
            if ($validation->fails()) {
                return redirect()->action('Library\General\RoomController@index')->with(['error' => getNotify(4), 'error_code' => 'Add'])->withErrors($validation)->withInput();
            } else {
                $user = new Room();
                $user->created_by = $userid;
                $user->fill($attributes)->save();

                $comp = Company::findOrFail($attributes['company_id'])->Name;

                \LogActivity::addToLog('Add Room: '.$attributes['room_no'].' and Company: '.$comp);
                return redirect()->action('Library\General\RoomController@index')->with('success', getNotify(1));
            }
        } else {
            return redirect()->back()->with('warning', getNotify(5));
        }
    }

    public function update(Request $request, $id)
    {
        if (getAccess('edit')) {
            $userid = Sentinel::getUser()->id;
            $attributes = Input::all();
            $rules = [
                'company_id' => 'required',
                'room_no' => 'required|max:100|unique:lib_rooms,room_no,' . $id,
                'status' => 'required',
            ];
            $validation = Validator::make($attributes, $rules);
            if ($validation->fails()) {
                return redirect()->action('Library\General\RoomController@index')->with(['error' => getNotify(4), 'error_code' => $id])->withErrors($validation)->withInput();
            } else {
                $user = Room::find($id);
                $user->created_by = $userid;
                $user->updated_at = Carbon::now();
                $user->fill($attributes)->save();

                $comp = Company::findOrFail($attributes['company_id'])->Name;

                \LogActivity::addToLog('Update Room: '.$attributes['room_no'].' and Company: '.$comp);
                return redirect()->action('Library\General\RoomController@index')->with('success', getNotify(2));
            }
        } else {
            return redirect()->back()->with('warning', getNotify(5));
        }
    }

    public function destroy($id)
    {
        if (getAccess('delete')) {
            $userid = Sentinel::getUser()->id;
            $user = Table::find($id);
            $user->delete();

            \LogActivity::addToLog('Delete Room ' . $user['room_no']);
            return redirect()->action('Library\General\RoomController@index')->with('success', getNotify(3));
        } else {
            return redirect()->back()->with('warning', getNotify(5));
        }
    }
}
