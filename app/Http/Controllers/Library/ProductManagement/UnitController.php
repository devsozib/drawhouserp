<?php

namespace App\Http\Controllers\Library\ProductManagement;

use Illuminate\Http\Request;
use App\Models\Library\ProductManagement\Unit;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Sentinel;

class UnitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (getAccess('view')) {
            $units = Unit::orderBy('id', 'DESC')->get();
            return view('library.product_management.unit.index', compact('units'));
        } else {
            return redirect()->back()->with('warning', getNotify(5));
        }
    }


    public function store(Request $request)
    {
        if (getAccess('create')) {
            $userid = Sentinel::getUser()->id;
            $attributes = $request->all();
            $rules = [
                'name' => 'required',
                'multiplier' => 'required',
                'status' => 'required',
            ];
            $validation = Validator::make($attributes, $rules);
            if ($validation->fails()) {
                return redirect()->action('Library\ProductManagement\UnitController@index')->with(['error' => getNotify(4), 'error_code' => 'Add'])->withErrors($validation)->withInput();
            } else {
                $weight = new Unit;
                $weight->name = $attributes['name'];
                $weight->multiplier = $attributes['multiplier'];
                $weight->created_by = $userid;
                $weight->status = $attributes['status'];
                $weight->save();
                \LogActivity::addToLog('Add Unit ' . $attributes['name']);
                return redirect()->action('Library\ProductManagement\UnitController@index')->with('success', getNotify(1));
            }
        } else {
            return redirect()->back()->with('warning', getNotify(5));
        }
    }

    public function update(Request $request, $id)
    {
        if (getAccess('create')) {
            $userid = Sentinel::getUser()->id;
            $attributes = $request->all();
            $rules = [
                'name' => 'required',
                'multiplier' => 'required',
                'status' => 'required',
            ];
            $validation = Validator::make($attributes, $rules);
            if ($validation->fails()) {
                return redirect()->action('Library\ProductManagement\UnitController@index')->with(['error' => getNotify(4), 'error_code' => 'Add'])->withErrors($validation)->withInput();
            } else {
                $weight = Unit::findOrFail($id);
                $weight->name = $attributes['name'];
                $weight->multiplier = $attributes['multiplier'];
                $weight->updated_by = $userid;
                $weight->status = $attributes['status'];
                $weight->update();
                \LogActivity::addToLog('Update Unit ' . $attributes['name']);
                return redirect()->action('Library\ProductManagement\UnitController@index')->with('success', getNotify(1));
            }
        } else {
            return redirect()->back()->with('warning', getNotify(5));
        }
    }

    public function destroy($id)
    {
        if (getAccess('delete')) {
            $unit = Unit::find($id);
            $unit->delete();

            \LogActivity::addToLog('Delete Unit ' . $unit->name);
            return redirect()->action('Library\ProductManagement\UnitController@index')->with('success', getNotify(3));
        } else {
            return redirect()->back()->with('warning', getNotify(5));
        }
    }
}
