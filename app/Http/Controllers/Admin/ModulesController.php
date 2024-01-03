<?php

namespace App\Http\Controllers\Admin;

use Input;
use Sentinel;
use Response;
use Validator;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Users;
use App\Models\Roles;
use App\Models\Activating;
use App\Models\Modules;

class ModulesController extends Controller
{
    public function index(Request $request) {
        if (getAccess('view')) {
            $users = Modules::orderBy('id','ASC')->get();
            return view('admin.modules.index', compact('users'));
        } else {
            return redirect()->back()->with('warning', getNotify(5));
        }
    }

    public function store(Request $request) {
        if (getAccess('create')) {
            $userid = Sentinel::getUser()->id;
            $attributes = Input::all();  
            $rules = [
                'Slug' => 'required|max:50|unique:modules',
                'Name' => 'required|max:30',
                'C4S' => 'required',
            ];
            $validation = Validator::make($attributes, $rules);
            if($validation->fails()) {
                return redirect()->action('Admin\ModulesController@index')->with(['error'=>getNotify(4), 'error_code'=>'Add'])->withErrors($validation)->withInput();
            }else{
                $user = new Modules();
                $user->CreatedBy = $userid;
                $user->fill($attributes)->save();

                \LogActivity::addToLog('Add Module '.$attributes['Name']);
                return redirect()->action('Admin\ModulesController@index')->with('success',getNotify(1));
            }
        } else {
            return redirect()->back()->with('warning', getNotify(5));
        } 
    }

    public function update(Request $request,$id) {
        if (getAccess('edit')) {
            $userid = Sentinel::getUser()->id;
            $attributes = Input::all();
            $rules = [
                'Slug' => 'required|max:50|unique:modules,Slug,'.$id,
                'Name' => 'required|max:30',
                'C4S' => 'required',
            ];
            $validation = Validator::make($attributes, $rules);
            if($validation->fails()) {
                return redirect()->action('Admin\ModulesController@index')->with(['error'=>getNotify(4), 'error_code'=>$id])->withErrors($validation)->withInput();
            }else{
                $user = Modules::find($id);
                $user->CreatedBy = $userid;
                $user->updated_at = Carbon::now();
                $user->fill($attributes)->save();

                \LogActivity::addToLog('Update Module '.$attributes['Name']);
                return redirect()->action('Admin\ModulesController@index')->with('success',getNotify(2));
            }
        } else {
            return redirect()->back()->with('warning', getNotify(5));
        } 
    }

    public function destroy($id) {  
        if (getAccess('delete')) {
            $userid = Sentinel::getUser()->id; 
            $user = Modules::find($id);
            $user->delete();

            \LogActivity::addToLog('Delete Module '.$user['Name']);
            return redirect()->action('Admin\ModulesController@index')->with('success',getNotify(3)); 
        } else {
            return redirect()->back()->with('warning', getNotify(5));
        }         
    }
}
