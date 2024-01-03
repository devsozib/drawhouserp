<?php

namespace App\Http\Controllers\Inventory\Procurement;

use DB;
use Input;
use Sentinel;
use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Inventory\Procurement\CentralInventory;
use App\Models\Inventory\Procurement\Inventory;
use App\Models\Library\General\Company;
use App\Models\Inventory\Procurement\PurchaseMain;
use App\Models\Inventory\Procurement\PurchaseOrderItem;

class ReceivedByStoreController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (getAccess('view')) {
            $comp_arr = Company::where('id',getHostInfo()['id'])->orderBy('id', 'ASC')->where('C4S', 'Y')->get();
            $company_id = '';
            $purch_id = '';
            $ingitemInfos = [];
            $gateUpdateItems = [];
            return view('inventory.procurement.itemrcvbystore.index', compact('comp_arr', 'company_id', 'ingitemInfos', 'gateUpdateItems', 'purch_id'));
        } else {
            return redirect()->back()->with('warning', getNotify(5));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function getPurchItemsAfterCheck(Request $request)
    {
        $comp_arr = Company::orderBy('id', 'ASC')->where('C4S', 'Y')->get();
        $company_id = $request->company;
        $purch_id   = $request->purch_id;
        $ingitemInfos =  DB::table('inv_purchaseorder_items as purch_items')
            ->join('lib_ingredients as asset', 'purch_items.ing_id', '=', 'asset.id')
            ->join('lib_units', 'lib_units.id', '=', 'asset.unit_id')
            ->select('purch_items.*', 'asset.name as asset_name', 'lib_units.name as unit_name')
            ->whereColumn('purch_items.gate_rcv_qty', '!=', 'purch_items.store_rcv_qty')
            ->where('purch_items.gate_rcv_qty', '>', 0)
            ->where('purch_items.purch_id', $purch_id)
            ->get();

        $gateUpdateItems = DB::table('inv_purchaseorder_items as purch_items')
            ->join('lib_ingredients as asset', 'purch_items.ing_id', '=', 'asset.id')
            ->join('lib_units', 'lib_units.id', '=', 'asset.unit_id')
            ->select('purch_items.*', 'asset.name as asset_name', 'lib_units.name as unit_name')
            ->where('purch_items.purch_id', $purch_id)
            ->where('purch_items.store_rcv_qty', '>', 0)
            ->where('purch_items.gate_rcv_qty', '>', 0)
            ->orderBy('purch_items.created_at', 'DESC')
            ->get();

        return view('inventory.procurement.itemrcvbystore.index', compact('ingitemInfos', 'comp_arr', 'company_id', 'purch_id', 'gateUpdateItems'));
    }



    public function storecheckUpdate(Request $request)
    {
        // if (getAccess('edit')) {
        $type =  $request->type;
        if ($type == 'itemUpdate') {
            $purch_id =  $request->purch_id;
            $item_id =  $request->item_id;
            $ing_id =  $request->ing_id;
            $store_rcv_qty =  $request->store_rcv_qty;
            $item = PurchaseOrderItem::where('purch_id', $purch_id)->where('id', $item_id)->first();
            $centralInventory = CentralInventory::where('ing_id', $ing_id)->first();
            // $avgPrice = ($item->ing_unit_price*$store_rcv_qty)/divisor($store_rcv_qty);
            // return $item->ing_unit_price;
           
            if ($item->store_rcv_qty > $store_rcv_qty) {               

                $lastQty = $centralInventory->stock;
                $avgPrice = $centralInventory->avg_price;
                $totalPrice = $lastQty * $avgPrice;
                // _print($avgPrice,1);
                // _print(1200/7);


                $lastPuchaseQty = $item->store_rcv_qty;
                $lastPuchasePrice = $item->ing_unit_price;
                $lastToalPrice = $lastPuchaseQty*$lastPuchasePrice;


                $finalPriceAfterMinus = $totalPrice - $lastToalPrice;

                


                $newQty = $lastPuchaseQty - $store_rcv_qty;   
                $newQty = $newQty < 0 ? 0 : $newQty;              

                $finalStockNewQty = $lastQty - $lastPuchaseQty + $store_rcv_qty;
                // _print($finalStockNewQty);
                if($finalStockNewQty < 0) return redirect()->back()->with('error', getNotify(10)); 
                $finaltotalPrice = $finalPriceAfterMinus + ($store_rcv_qty * $lastPuchasePrice);
                
                $finalAvgPrice = $finaltotalPrice / divisor($finalStockNewQty);
         

                $centralInventory->stock = $finalStockNewQty;
                $centralInventory->avg_price = $finalAvgPrice;
                $centralInventory->update();
                $item->store_rcv_qty = $store_rcv_qty;
                $item->update();            
                return redirect()->back()->with('success', getNotify(2));
            } else {   

                $lastQty = $centralInventory->stock;
                $avgPrice = $centralInventory->avg_price;
                $totalPrice = $lastQty * $avgPrice;
                
                $lastPuchaseQty = $item->store_rcv_qty;
                $lastPuchasePrice = $item->ing_unit_price;

                $newQty = $store_rcv_qty - $lastPuchaseQty;
                $itemTotalprice = $lastPuchasePrice * $newQty;

                $finalStockNewQty = $lastQty  + $newQty;
                $finaltotalPrice = $totalPrice +  $itemTotalprice;
                $finalAvgPrice = $finaltotalPrice / divisor($finalStockNewQty);

                $centralInventory->stock = $finalStockNewQty;
                $centralInventory->avg_price = $finalAvgPrice;
                $centralInventory->update();
                $item->store_rcv_qty = $store_rcv_qty;
                $item->update();
                return redirect()->back()->with('success', getNotify(2));
            }
        } else {
            $purch_id   = intval($request->puch_id);
            $ingredient = intval($request->ing_id);
            $ingredient = intval($request->ing_id);
            $s_qty      = intval($request->s_qty);
            $userid     = Sentinel::getUser()->id;
            $checkExistData = PurchaseOrderItem::where('purch_id', $purch_id)->where('ing_id', $ingredient)->first();

            if ($checkExistData->store_rcv_qty > 0) {
                return response()->json(['status' => 'warnForEdit']);
            } else {
                $centralInventory = CentralInventory::where('ing_id', $ingredient)->first();
                
                $checkExistData->store_rcv_qty = $s_qty;
                $checkExistData->updated_by = $userid;
               $checkExistData->update();
                
                if (!$centralInventory) {
                    $avgPrice = (double)($checkExistData->ing_unit_price*$checkExistData->store_rcv_qty)/divisor($s_qty);
                    $item = new CentralInventory();
                    $item->ing_id = $ingredient;
                    $item->stock = $s_qty;
                    $item->avg_price = $avgPrice;
                    $item->save();
                } else {                  
                    $avgPrice = (($centralInventory->stock*$centralInventory->avg_price) + ($checkExistData->ing_unit_price*$s_qty))/divisor($centralInventory->stock+$s_qty);
                    $centralInventory->stock += $s_qty;
                    $centralInventory->avg_price = $avgPrice;
                    $centralInventory->update();
                }
                $purchMain = PurchaseMain::where('id', $purch_id)->first();
                $purchMain->status = 1;
                $purchMain->update();
                \LogActivity::addToLog('Update item after check qty: ' . $ingredient);
                return response()->json(['status' => 'success']);
            }
        }
    }
}
