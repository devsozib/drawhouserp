<?php

namespace App\Http\Controllers\Inventory\Procurement;

use DB;
use Input;
use Sentinel;
use Validator;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Inventory\Procurement\Inventory;
use Illuminate\Support\Collection;
use App\Models\Inventory\Procurement\PurchaseMain;
use App\Models\Library\General\Company;
use App\Models\Library\ProductManagement\Ingredient;
use App\Models\Inventory\WasteManagement\WasteIngredient;
use App\Models\Inventory\Procurement\PurchaseOrderItem;
use App\Models\Library\General\Supplier;

class PurchaseOrderController extends Controller
{
    public function index(Request $request)
    {
        if (getAccess('view')) {
            $comp_arr = Company::where('id',getHostInfo()['id'])->orderBy('id', 'ASC')->where('C4S', 'Y')->pluck('Name', 'id');

            // $requisitions = PurchaseMain::get();
            $requisitions = PurchaseMain::join('lib_company', 'lib_company.id', '=', 'inv_proc_isspurch_main.company_id')->select('inv_proc_isspurch_main.id', 'inv_proc_isspurch_main.company_id', 'inv_proc_isspurch_main.po_date', 'lib_company.Name as company_name','inv_proc_isspurch_main.status', DB::raw('DATE(inv_proc_isspurch_main.po_date) as date'))
                ->where('inv_proc_isspurch_main.company_id',getHostInfo()['id'])                
                ->orderBy('date','DESC')
                ->get()
                ->groupBy('po_date');

            return view('inventory.procurement.purchaseorder.index', compact('comp_arr', 'requisitions'));
        } else {
            return redirect()->back()->with('warning', getNotify(5));
        }
    }

    public function show(Request $request, $id)
    {
        $requisition =  PurchaseMain::join('lib_company', 'lib_company.id', '=', 'inv_proc_isspurch_main.company_id')->select('inv_proc_isspurch_main.id', 'inv_proc_isspurch_main.company_id', 'inv_proc_isspurch_main.po_date', 'lib_company.Name as company_name','inv_proc_isspurch_main.status', DB::raw('DATE(inv_proc_isspurch_main.po_date) as date'))           
            ->where('inv_proc_isspurch_main.id', $id)
            ->where('inv_proc_isspurch_main.company_id',getHostInfo()['id'])
            ->orderBy('date','DESC')
            ->first();
         $requisitions = PurchaseMain::join('lib_company', 'lib_company.id', '=', 'inv_proc_isspurch_main.company_id')->select('inv_proc_isspurch_main.id', 'inv_proc_isspurch_main.company_id', 'inv_proc_isspurch_main.po_date', 'lib_company.Name as company_name', DB::raw('DATE(inv_proc_isspurch_main.po_date) as date'))
            ->where('inv_proc_isspurch_main.company_id',getHostInfo()['id'])
            ->orderBy('date','DESC')
            ->get()
            ->groupBy('po_date');

        $companies = Company::where('id',getHostInfo()['id'])->orderBy('id', 'ASC')->where('C4S', 'Y')->get();
        $vendors = Supplier::orderBy('id', 'ASC')->where('status', '1')->get();
        $items = Ingredient::where('company_id',$requisition->company_id)->get();
        $purchItems = DB::table('inv_purchaseorder_items as purch_items')
            ->join('lib_ingredients as asset', 'purch_items.ing_id', '=', 'asset.id')
            ->join('lib_units', 'lib_units.id', '=', 'asset.unit_id')
            ->join('lib_suppliers', 'lib_suppliers.id', '=', 'purch_items.vendor_id')
            ->join('inv_proc_isspurch_main as requisitions', 'requisitions.id', '=', 'purch_items.purch_id')
            ->select('purch_items.*', 'asset.name as asset_name', 'lib_units.name as unit_name', 'requisitions.id as purch_id', 'lib_suppliers.name as vendor_name','requisitions.status')
            ->where('purch_items.purch_id', $id)
            ->orderBy('purch_items.created_at', 'DESC')
            ->get();
        return view('inventory.procurement.purchaseorder.show', compact('requisition', 'companies', 'vendors', 'items', 'requisitions', 'purchItems'));
    }
    public function store(Request $request)
    {
        if ($request->type == 'forReqAdd') {
            if (getAccess('create')) {
                $userid = Sentinel::getUser()->id;
                $attributes = Input::all();
                $rules = [
                    'company_id' => 'required|numeric',
                    'po_date' => 'required|date_format:Y-m-d',
                ];
                $validation = Validator::make($attributes, $rules);
                if ($validation->fails()) {
                    return redirect()->action('Inventory\Procurement\PurchaseOrderController@index')->with(['error' => getNotify(4), 'error_code' => 'Add'])->withErrors($validation)->withInput();
                } else {
                    // return $attributes;
                    $user = new PurchaseMain();
                    $user->created_by = $userid;
                    $user->fill($attributes)->save();

                    \LogActivity::addToLog('Add Purchase Order: ' . $user->id);
                    return redirect()->action('Inventory\Procurement\PurchaseOrderController@show', $user->id)->with('success', getNotify(1));
                }
            } else {
                return redirect()->back()->with('warning', getNotify(5));
            }
        }else if($request->type == 'pruchUpdate'){
            $userid = Sentinel::getUser()->id;
            $req_id = $request->req_id;
            $status = $request->status;
            $requestion = PurchaseMain::where('company_id',getHostInfo()['id'])->where('id',$req_id)->first();
            $requestion->status = $status;
            $requestion->updated_by = $userid;
            $requestion->update();
            return response()->json(['status' => 'success']);  
        } else {
            // return $request->all();
            $purch_id = intval($request->purch_id);
            $ingredient = intval($request->ingredient);
            $unit_price = floatval($request->ing_unit_price);
            $ing_qty = floatval($request->ing_qty);
            $vendor = intval($request->vendor);
            $remarks = $request->remarks;
            $userid = Sentinel::getUser()->id;
            $validator = Validator::make($request->all(), [
                'ingredient' => 'required',
                'ing_qty' => 'required',
                'ing_unit_price' => 'required',
                'vendor' => 'required',
            ]);

            $checkExistData = PurchaseOrderItem::where('purch_id', $purch_id)->where('ing_id', $ingredient)->first();
            if ($checkExistData) {
                return response()->json(['status' => 'exist']);
            } else {
                if ($validator->fails()) {
                    $errors = $validator->errors();
                    return response()->json(['errors' => $errors, 'status' => 'error']);
                } else {
                    $getPurchaseOrder = PurchaseMain::findOrFail($purch_id);
                    $issueItem = new PurchaseOrderItem();
                    $issueItem->purch_id = $purch_id;
                    $issueItem->ing_id = $ingredient;
                    $issueItem->ing_qty = $ing_qty;
                    $issueItem->ing_unit_price = $unit_price;
                    $issueItem->vendor_id = $vendor;
                    $issueItem->remarks = $remarks;
                    $issueItem->date = date('Y-m-d');
                    $issueItem->created_by = $userid;
                    $issueItem->save();
                    $getPurchaseOrder->status = 0;
                    $getPurchaseOrder->update();
                    \LogActivity::addToLog('Add Purchase Order Item: ' . $ingredient);
                    return response()->json(['status' => 'success']);
                }
            }
        }
    }

    public function update(Request $request, $id)
    {
        // return $request;
        if ($request->type == 'ItemEdit') {
            $purch_id = intval($request->purch_id);
            $qty = intval($request->ing_qty);
            $unit_price = intval($request->ing_unit_price);
            $vendor = intval($request->vendor);
            $remarks = $request->remarks;
            $userid = Sentinel::getUser()->id;
            $validator = Validator::make($request->all(), [
                'ing_qty' => 'required',
                'ing_unit_price' => 'required',
                'vendor' => 'required',
            ]);
            $issueItem = PurchaseOrderItem::where('purch_id', $purch_id)->where('id', $id)->first();
            if ($validator->fails()) {
                // return "error";
                $errors = $validator->errors();
                return redirect()->back()->with(['error' => getNotify(4), 'error_code' => $issueItem->id])->withErrors($errors)->withInput();
            } else {
                // return "ok";
                $issueItem->ing_qty = $qty;
                $issueItem->ing_unit_price = $unit_price;
                $issueItem->vendor_id = $vendor;
                $issueItem->remarks = $remarks;
                $issueItem->date = date('Y-m-d');
                $issueItem->updated_by = $userid;
                $issueItem->update();
                \LogActivity::addToLog('Update Purchase Order Item: ' . $id);
                return redirect()->back()->with('success', getNotify(2));
            }
        } else {
            //Update Requisition Code here
        }
    }

    public function destroy(Request $request, $id)
    {

        if ($request->type == 'item_del') {
            if (getAccess('delete')) {
                $userid = Sentinel::getUser()->id;
                $user = PurchaseOrderItem::find($id);
                $user->delete();
                \LogActivity::addToLog('Delete Waste Ingredient ' . $user['deleted_by']);
                return redirect()->back()->with('success', getNotify(3));
            } else {
                return redirect()->back()->with('warning', getNotify(5));
            }
        } else {
            if (getAccess('delete')) {
                $userid = Sentinel::getUser()->id;
                $user = WasteIngredient::find($id);
                $user->delete();

                \LogActivity::addToLog('Delete Waste Ingredient ' . $user['deleted_by']);
                return redirect()->action('Inventory\Procurement\PurchaseOrderController@index')->with('success', getNotify(3));
            } else {
                return redirect()->back()->with('warning', getNotify(5));
            }
        }
    }
}
