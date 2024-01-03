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
use App\Models\Menus;
use App\Models\ChildMenus;

class ChildMenusController extends Controller
{
    public function index(Request $request) {
        if (getAccess('view')) {
            $users = ChildMenus::orderBy('ModuleID','ASC')->orderBy('MenuID','ASC')->orderBy('id','ASC')->get();
            $modulelists = Modules::orderBy('id', 'ASC')->where('C4S','Y')->pluck('Name','id');
            $menulists = Menus::orderBy('id', 'ASC')->where('C4S','Y')->pluck('Name','id');
            return view('admin.childmenus.index', compact('users','modulelists','menulists'));
        } else {
            return redirect()->back()->with('warning', getNotify(5));
        }
    }

    public function store(Request $request) {
        if (getAccess('create')) {
            $userid = Sentinel::getUser()->id;
            $attributes = Input::all();  
            $rules = [
                'ModuleID' => 'required|numeric',
                'MenuID' => 'required|numeric',
                'Name' => 'required|max:40',
                'Slug' => 'required|max:40',
                'C4S' => 'required',
            ];
            $validation = Validator::make($attributes, $rules);
            if ($validation->fails()) {
                return redirect()->action('Admin\ChildMenusController@index')->with(['error'=>getNotify(4), 'error_code'=>'Add'])->withErrors($validation)->withInput();
            } else {
                $exists = ChildMenus::orderBy('id', 'ASC')->where('ModuleID', $attributes['ModuleID'])->where('MenuID', $attributes['MenuID'])->where('Slug', $attributes['Slug'])->pluck('id');
                if (sizeof($exists)) {
                    return redirect()->action('Admin\ChildMenusController@index')->with(['error'=>getNotify(6), 'error_code'=>'Add'])->withInput();
                } else {
                    $moduleurl = Modules::findOrFail($attributes['ModuleID'])->Slug;
                    $menuurl = Menus::findOrFail($attributes['MenuID'])->Slug;

                    $user = new ChildMenus();
                    $user->URL = $moduleurl.'/'.$menuurl.'/'.$attributes['Slug'];
                    $user->CreatedBy = $userid;
                    $user->fill($attributes)->save();

                    \LogActivity::addToLog('Add Child Menus '.$attributes['Name']);
                    return redirect()->action('Admin\ChildMenusController@index')->with('success',getNotify(1));
                }
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
                'ModuleID' => 'required|numeric',
                'MenuID' => 'required|numeric',
                'Name' => 'required|max:40',
                'Slug' => 'required|max:40',
                'C4S' => 'required',
            ];
            $validation = Validator::make($attributes, $rules);
            if ($validation->fails()) {
                return redirect()->action('Admin\ChildMenusController@index')->with(['error'=>getNotify(4), 'error_code'=>$id])->withErrors($validation)->withInput();
            } else {
                $exists = ChildMenus::orderBy('id', 'ASC')->where('ModuleID', $attributes['ModuleID'])->where('MenuID', $attributes['MenuID'])->where('Slug', $attributes['Slug'])->where('id','!=',$id)->pluck('id');
                if (sizeof($exists)) {
                    return redirect()->action('Admin\ChildMenusController@index')->with(['error'=>getNotify(6), 'error_code'=>$id])->withInput();
                } else {
                    $moduleurl = Modules::findOrFail($attributes['ModuleID'])->Slug;
                    $menuurl = Menus::findOrFail($attributes['MenuID'])->Slug;

                    $user = ChildMenus::findOrFail($id);
                    $user->URL = $moduleurl.'/'.$menuurl.'/'.$attributes['Slug'];
                    $user->CreatedBy = $userid;
                    $user->updated_at = Carbon::now();
                    $user->fill($attributes)->save();

                    \LogActivity::addToLog('Update Child Menus '.$attributes['Name']);
                    return redirect()->action('Admin\ChildMenusController@index')->with('success',getNotify(2));
                }
            }
        } else {
            return redirect()->back()->with('warning', getNotify(5));
        } 
    }

    public function destroy($id) {  
        if (getAccess('delete')) {
            $userid = Sentinel::getUser()->id; 
            $user = ChildMenus::find($id);
            $user->delete();

            \LogActivity::addToLog('Delete Child Menus '.$user['Name']);
            return redirect()->action('Admin\ChildMenusController@index')->with('success',getNotify(3)); 
        } else {
            return redirect()->back()->with('warning', getNotify(5));
        }         
    }
}
