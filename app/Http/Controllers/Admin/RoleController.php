<?php

namespace App\Http\Controllers\Admin;

use Input;
use Session;
use Sentinel;
use Response;
use Validator;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Users;
use App\Models\Roles;
use App\Models\Modules;
use App\Models\Menus;
use App\Models\ChildMenus;
use App\Models\Permissions;
use App\Models\RolePermissions;

class RoleController extends Controller
{
    public function index(Request $request)
    {
        if (getAccess('view')) {
            $roles = Roles::orderBy('id', 'ASC')->get();
            $users = Users::orderBy('id', 'ASC')->where('C4S', 'Y')->get();
            $roleperms = RolePermissions::orderBy('role_permissions.id', 'ASC')->join('permissions', 'role_permissions.permission_id', '=', 'permissions.id')->select('role_permissions.role_id', 'permissions.id', 'permissions.Name')->get();
            return view('admin.role.index', compact('users', 'roles', 'roleperms'));
        } else {
            return redirect()->back()->with('warning', getNotify(5));
        }
    }

    public function create()
    {
        if (getAccess('create')) {
            $permissions = Permissions::orderBy('id', 'ASC')->where('C4S', 'Y')->get();
            $modules = Modules::orderBy('id', 'ASC')->where('C4S', 'Y')->get();
            $allmenus = Menus::orderBy('id', 'ASC')->where('C4S', 'Y')->get();
            $childmenus = ChildMenus::orderBy('id', 'ASC')->where('C4S', 'Y')->get();

            return view('admin.role.create', compact('permissions', 'modules', 'allmenus', 'childmenus'));
        } else {
            return redirect()->back()->with('warning', getNotify(5));
        }
    }

    public function show($id)
    {
        if (getAccess('view')) {
            $user = Sentinel::findUserById($id);
            $rolelists = Roles::orderBy('id', 'ASC')->pluck('name', 'id');
            return view('admin.role.show', compact('user', 'rolelists'));
        } else {
            return redirect()->back()->with('warning', getNotify(5));
        }
    }

    public function edit($id)
    {
        if (getAccess('edit')) {
            $user = Roles::find($id);
            $permissions = Permissions::orderBy('id', 'ASC')->where('C4S', 'Y')->get();
            $modules = Modules::orderBy('id', 'ASC')->where('C4S', 'Y')->get();
            $allmenus = Menus::orderBy('id', 'ASC')->where('C4S', 'Y')->get();
            $childmenus = ChildMenus::orderBy('id', 'ASC')->where('C4S', 'Y')->get();
            return view('admin.role.edit', compact('user', 'permissions', 'modules', 'allmenus', 'childmenus'));
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
                'name' => 'required|max:100|unique:roles,name',
                'permission' => 'required',
                'module' => 'required',
                'menu' => 'required',
            ];
            $validation = Validator::make($attributes, $rules);
            if ($validation->fails()) {
                return redirect()->action('Admin\RoleController@create')->with('error', getNotify(4))->withErrors($validation)->withInput();
            } else {
                $role = new Roles();
                $role->CreatedBy = $userid;
                $role->fill($attributes)->save();
                $role_id = $role->id;

                $newrole = Roles::findOrFail($role_id);
                $newrole->permissions()->detach();
                $newrole->modules()->detach();
                $newrole->menus()->detach();
                $newrole->childmenus()->detach();

                for ($idx = 0; $idx < sizeOf($attributes['permission']); $idx++) {
                    $newrole->permissions()->attach(Permissions::where('id', $attributes['permission'][$idx])->first());
                }
                for ($idx = 0; $idx < sizeOf($attributes['module']); $idx++) {
                    $newrole->modules()->attach(Modules::where('id', $attributes['module'][$idx])->first());
                }
                for ($idx = 0; $idx < sizeOf($attributes['menu']); $idx++) {
                    $newrole->menus()->attach(Menus::where('id', $attributes['menu'][$idx])->first());
                }
                if (isset($attributes['childmenu'])) {
                    for ($idx = 0; $idx < sizeOf($attributes['childmenu']); $idx++) {
                        $newrole->childmenus()->attach(ChildMenus::where('id', $attributes['childmenu'][$idx])->first());
                    }
                }

                \LogActivity::addToLog('Add Role ' . $attributes['name']);
                return redirect()->back()->with('success', getNotify(1));
            }
        } else {
            return redirect()->back()->with('warning', getNotify(5));
        }
    }

    public function update(Request $request, $id)
    {
        if (getAccess('edit')) {
            if ($id == 1) {
                return redirect()->back()->with('warning', getNotify(5));
            }
            $userid = Sentinel::getUser()->id;
            $attributes = Input::all();
            $rules = [
                'name' => 'required|max:100|unique:roles,name,' . $id,
                'permission' => 'required',
                'module' => 'required',
                'menu' => 'required',
            ];
            $validation = Validator::make($attributes, $rules);
            if ($validation->fails()) {
                return redirect()->action('Admin\RoleController@edit', $id)->with('error', getNotify(4))->withErrors($validation)->withInput();
            } else {
                $role = Roles::findOrFail($id);
                $role->CreatedBy = $userid;
                $role->updated_at = Carbon::now();
                $role->fill($attributes)->save();

                $newrole = Roles::findOrFail($id);
                $newrole->permissions()->detach();
                $newrole->modules()->detach();
                $newrole->menus()->detach();
                $newrole->childmenus()->detach();

                for ($idx = 0; $idx < sizeOf($attributes['permission']); $idx++) {
                    $newrole->permissions()->attach(Permissions::where('id', $attributes['permission'][$idx])->first());
                }
                for ($idx = 0; $idx < sizeOf($attributes['module']); $idx++) {
                    $newrole->modules()->attach(Modules::where('id', $attributes['module'][$idx])->first());
                }
                for ($idx = 0; $idx < sizeOf($attributes['menu']); $idx++) {
                    $newrole->menus()->attach(Menus::where('id', $attributes['menu'][$idx])->first());
                }
                if (isset($attributes['childmenu'])) {
                    for ($idx = 0; $idx < sizeOf($attributes['childmenu']); $idx++) {
                        $newrole->childmenus()->attach(ChildMenus::where('id', $attributes['childmenu'][$idx])->first());
                    }
                }

                \LogActivity::addToLog('Update Role ' . $attributes['name']);
                return redirect()->back()->with('success', getNotify(2));
            }
        } else {
            return redirect()->back()->with('warning', getNotify(5));
        }
    }

    public function destroy($id)
    {
        if (getAccess('delete')) {
            $userid = Sentinel::getUser()->id;
            $roleid = Sentinel::findById($userid)->roles()->first()->id;
            if ($roleid == $id || $id == 1) {
                return redirect()->back()->with('warning', getNotify(5));
            }
            $role = Roles::findOrFail($id);
            $role->permissions()->detach();
            $role->modules()->detach();
            $role->menus()->detach();
            $role->childmenus()->detach();
            $role->delete();

            \LogActivity::addToLog('Delete Role ' . $role['name']);
            return redirect()->back()->with('success', getNotify(3));
        } else {
            return redirect()->back()->with('warning', getNotify(5));
        }
    }
}
