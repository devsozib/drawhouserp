<?php

namespace App\Http\Controllers\Inventory\Procurement;

use DB;
use Sentinel;
use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Library\General\Company;
use App\Models\Inventory\Procurement\PurchaseMain;
use App\Models\Inventory\Procurement\PurchaseOrderItem;

class PurOrderRcvController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (getAccess('view')) {
            $company_id = '';         
            $purch_id='';
            $comp_arr = Company::where('id',getHostInfo()['id'])->orderBy('id', 'ASC')->where('C4S', 'Y')->get();
            $ingitemInfos = [];
            $gateUpdateItems = [];
            return view('inventory.procurement.purorderrcv.index', compact('comp_arr', 'company_id', 'ingitemInfos', 'gateUpdateItems','purch_id'));
        } else {
            return redirect()->back()->with('warning', getNotify(5));
        }
    }
    public function getPurchItems(Request $request)
    {
        // return getAccess('view');
        // if (getAccess('view')) {
        $comp_arr = Company::orderBy('id', 'ASC')->where('C4S', 'Y')->get();
        $company_id = $request->company;
        $purch_id   = $request->purch_id;
        $ingitemInfos =  DB::table('inv_purchaseorder_items as purch_items')
            ->join('lib_ingredients as asset', 'purch_items.ing_id', '=', 'asset.id')
            ->join('lib_units', 'lib_units.id', '=', 'asset.unit_id')
            ->select('purch_items.*', 'asset.name as asset_name', 'lib_units.name as unit_name')
            ->whereColumn('purch_items.ing_qty', '!=', 'purch_items.gate_rcv_qty')
            ->where('purch_items.purch_id', $purch_id)
            ->get();

        $gateUpdateItems = DB::table('inv_purchaseorder_items as purch_items')
            ->join('lib_ingredients as asset', 'purch_items.ing_id', '=', 'asset.id')
            ->join('lib_units', 'lib_units.id', '=', 'asset.unit_id')
            ->select('purch_items.*', 'asset.name as asset_name', 'lib_units.name as unit_name')
            ->where('purch_items.purch_id', $purch_id)
            ->where('purch_items.gate_rcv_qty', '>', 0)
            ->orderBy('purch_items.created_at', 'DESC')
            ->get();

        return view('inventory.procurement.purorderrcv.index', compact('ingitemInfos', 'comp_arr', 'company_id', 'purch_id', 'gateUpdateItems'));
        // } else {
        //     return redirect()->back()->with('warning', getNotify(5));
        // }
    }

    public function gatecheckUpdate(Request $request)
    {
        // if (getAccess('edit')) {
        $type =  $request->type;
        if ($type == 'itemUpdate') {
            $purch_id =  $request->purch_id;
            $item_id =  $request->item_id;
            $rcv_qty =  $request->rcv_qty;
            $item = PurchaseOrderItem::where('purch_id', $purch_id)->where('id', $item_id)->first();
            $item->gate_rcv_qty = $rcv_qty;
            $item->update();
            return redirect()->back()->with('success', getNotify(2));
        } else {
            $purch_id = intval($request->puch_id);
            $ingredient = intval($request->ing_id);
            $rcv_qty = intval($request->rcv_qty);
            $userid = Sentinel::getUser()->id;
            $checkExistData = PurchaseOrderItem::where('purch_id', $purch_id)->where('ing_id', $ingredient)->first();
            if ($checkExistData) {
                if ($checkExistData->gate_rcv_qty <= 0) {
                    $purchMain = PurchaseMain::where('id', $purch_id)->first();
                    $checkExistData->gate_rcv_qty = $rcv_qty;
                    $checkExistData->updated_by = $userid;
                    $checkExistData->update();
                    $purchMain->status = 0;
                    $purchMain->update();
                    \LogActivity::addToLog('Update item after check qty: ' . $ingredient);
                    return response()->json(['status' => 'success']);
                } else {
                    return response()->json(['status' => 'warnForEdit']);
                }
            }
        }
        // } else {
        //     return redirect()->back()->with('warning', getNotify(5));
        // }
    }
    public function create()
    {
    }


    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        //
    }


    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
