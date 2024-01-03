<?php

namespace App\Http\Controllers\Inventory\WasteManagement;

use DB;
use Input;
use Sentinel;
use Validator;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use App\Models\Inventory\WasteManagement\WasteAsset;
use App\Models\Library\General\AssetItem;
use App\Models\Library\General\Company;
use Illuminate\Http\Request;

class WasteAssetController extends Controller
{
    public function index(Request $request) {
        if (getAccess('view')) {
            $waste_ings = DB::table('inv_waste_asset as wsting')
                ->leftJoin('lib_ingredients as asset', 'wsting.asset_id', '=', 'asset.id')
                ->leftJoin('lib_units', 'lib_units.id', '=', 'asset.unit_id')
                ->select('wsting.*','asset.name as asset_name','lib_units.name as unit_name')
                ->get();
            $comp_arr = Company::orderBy('id','ASC')->where('C4S','Y')->pluck('Name','id');
            return view('inventory.waste_management.waste_asset.index', compact('waste_ings', 'comp_arr'));
        } else {
            return redirect()->back()->with('warning', getNotify(5));
        }
    }

    public function store(Request $request) {

        if (getAccess('create')) {
            $userid = Sentinel::getUser()->id;
             $attributes = Input::all();
            $rules = [
                'company_id' => 'required',
                'asset_id' => 'required',
                'quantity' => 'required',
                'date' => 'required',
                'status' => 'required',
            ];
            $validation = Validator::make($attributes, $rules);
            if($validation->fails()) {
                return redirect()->action('Inventory\WasteManagement\WasteAssetController@index')->with(['error'=>getNotify(4), 'error_code'=>$id])->withErrors($validation)->withInput();
            }else{
                // return $attributes;
                $user = new WasteAsset();
                $user->created_by = $userid;
                $user->fill($attributes)->save();

                $ing_waste = AssetItem::findOrFail($attributes['asset_id'])->name;

                \LogActivity::addToLog('Add Waste Asset: '.$ing_waste);
                return redirect()->action('Inventory\WasteManagement\WasteAssetController@index')->with('success',getNotify(1));
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
                'company_id' => 'required',
                'asset_id' => 'required',
                'quantity' => 'required',
                'date' => 'required',
                'status' => 'required',
            ];
            $validation = Validator::make($attributes, $rules);
            if($validation->fails()) {
                return redirect()->action('Inventory\WasteManagement\WasteAssetController@index')->with(['error'=>getNotify(4), 'error_code'=>$id])->withErrors($validation)->withInput();
            }else{
                $user = WasteAsset::find($id);
                $user->created_by = $userid;
                $user->updated_at = Carbon::now();
                $user->fill($attributes)->save();

                $ing_waste = AssetItem::findOrFail($attributes['asset_id'])->name;

                \LogActivity::addToLog('Add Waste Asset: '.$ing_waste);
                return redirect()->action('Inventory\WasteManagement\WasteAssetController@index')->with('success',getNotify(2));
            }
        } else {
            return redirect()->back()->with('warning', getNotify(5));
        }
    }

    public function destroy($id) {
        if (getAccess('delete')) {
            $userid = Sentinel::getUser()->id;
            $user = WasteAsset::find($id);
            $user->delete();
            

            \LogActivity::addToLog('Delete Waste Asset '.$user['deleted_by']);
            return redirect()->action('Inventory\WasteManagement\WasteAssetController@index')->with('success',getNotify(3));
        } else {
            return redirect()->back()->with('warning', getNotify(5));
        }
    }
}
