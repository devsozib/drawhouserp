<?php

namespace App\Http\Controllers\Inventory\Procurement;

use DB;
use App\Http\Controllers\Controller;
use App\Models\Inventory\Procurement\Inventory;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    public function index()
    {
        if (getAccess('view')) {
            $inventories = DB::table('inv_inventories as inv')
                ->join('lib_ingredients as asset', 'inv.item_id', '=', 'asset.id')
                ->join('lib_units', 'lib_units.id', '=', 'asset.unit_id')
                ->join('lib_company', 'lib_company.id', '=', 'asset.company_id')
                ->select('inv.*', 'asset.name as asset_name', 'lib_units.name as unit_name','lib_company.Name')
                ->where('inv.stock','>',0)
                ->get();
            return view('inventory.procurement.inventory.index', compact('inventories'));
        } else {
            return redirect()->back()->with('warning', getNotify(5));
        }
    }

    public function centralInventories(){
        $inventories = DB::table('inv_central_inventories as inv')
        ->join('lib_ingredients as asset', 'inv.ing_id', '=', 'asset.id')
        ->join('lib_units', 'lib_units.id', '=', 'asset.unit_id')
        ->select('inv.*', 'asset.name as asset_name', 'lib_units.name as unit_name')
        ->where('inv.stock','>',0)
        ->get();
        return view('inventory.procurement.central_inventory.index', compact('inventories'));
    }
}
