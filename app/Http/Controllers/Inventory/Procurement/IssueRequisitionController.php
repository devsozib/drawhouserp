<?php

namespace App\Http\Controllers\Inventory\Procurement;

use DB;
use Input;
use Sentinel;
use Validator;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Inventory\Procurement\CentralInventory;
use App\Models\Inventory\Procurement\Inventory;
use App\Models\Library\General\Company;
use App\Models\Library\ProductManagement\Ingredient;
use App\Models\Inventory\WasteManagement\WasteIngredient;
use App\Models\Inventory\Procurement\RequisitionMain;
use App\Models\Inventory\Procurement\RequisitionItem;

class IssueRequisitionController extends Controller
{
    public function index(Request $request)
    {
        if (getAccess('view')) {
            $company_id = '';
            $req_id='';
            $comp_arr = Company::where('id',getHostInfo()['id'])->orderBy('id', 'ASC')->where('C4S', 'Y')->get();
            $requisitions = RequisitionMain::select('id', 'company_id', 'requisition_date', DB::raw('DATE(requisition_date) as date'))
                ->where('inv_proc_requisition_main.company_id', getHostInfo()['id'])
                ->where(function ($query) {
                    $query->where('inv_proc_requisition_main.status', '1')
                        ->whereNot('inv_proc_requisition_main.status', '3');
                })
                ->orWhere('inv_proc_requisition_main.status', '2')
                ->orderBy('date', 'DESC')
                ->get()
                ->groupBy('date');
            $requisitionsItems = [];
            return view('inventory.procurement.issuerequisition.index', compact('requisitions', 'comp_arr', 'company_id', 'requisitionsItems','req_id'));
        } else {
            return redirect()->back()->with('warning', getNotify(5));
        }
    }

    public function show(Request $request, $id)
    {
    }
    public function store(Request $request)
    {
    }

    public function update(Request $request, $id)
    {
    }

    public function destroy(Request $request, $id)
    {
    }

    public function getData(Request $request)
    { 
        $comp_arr = Company::where('id',getHostInfo()['id'])->orderBy('id', 'ASC')->where('C4S', 'Y')->get();
        $company_id = $request->company;
        $req_id   = $request->req_id;
        $requisitionsItems =  DB::table('inv_requisition_items as req_items')
            ->join('lib_ingredients as asset', 'req_items.ing_id', '=', 'asset.id')
            ->join('lib_units', 'lib_units.id', '=', 'asset.unit_id')
            ->leftJoin('inv_central_inventories as inv', 'inv.ing_id', '=', 'req_items.ing_id')
            ->join('inv_proc_requisition_main as requisitions', 'requisitions.id', '=', 'req_items.req_id')
            ->select('req_items.*', 'asset.name as asset_name', 'lib_units.name as unit_name', 'requisitions.id as req_id', 'inv.stock')
            ->where('req_items.req_id', $req_id)
            ->where('requisitions.company_id', getHostInfo()['id'])
            ->whereColumn('req_items.qty', '!=', 'req_items.issue_qty')
            ->get();
        
        return view('inventory.procurement.issuerequisition.index', compact('requisitionsItems', 'comp_arr', 'company_id','req_id'));
    }

    public function IssueReqItems(Request $request)
    {
        $itemIds = $request->input('item_id');
        $issue_qty = $request->input('issue_qty');
        // dd([$itemIds,$issue_qty]);
        $data = [];

        foreach ($itemIds as $index => $itemId) {
            $value = isset($issue_qty[$index]) ? $issue_qty[$index] : null;

            if ($value !== null && $value !== '') {
                $data[$itemId] = $value;
            }
        }
        $errorMessage = [];
        foreach ($data as $itemId => $value) {
            $item = RequisitionItem::find($itemId);
            if ($item) {
                $inventory = CentralInventory::where('ing_id', $item->ing_id)->first();
                $totalIssueQty = $item->issue_qty + $value;
                $lastNeedQty = $item->qty - $item->issue_qty;
                if ($item && $item->issue_qty != null) {
                    if ($item && $item->qty >= $totalIssueQty) {
                        if ($inventory) {
                            if ($inventory->stock >= $value) {
                                $inventory->stock -= $value;
                                $inventory->update();
                                $item->issue_qty += $value;
                                $item->update();
                            } else {
                                $errorMessage[$itemId] = 'Qty not available';
                            }
                        } else {
                            $errorMessage[$itemId] = 'Inventory not found';
                        }
                    } else {
                        $errorMessage[$itemId] = 'You need ' . $lastNeedQty;
                    }
                } else {
                    if ($item && $item->qty >= $value) {
                        if ($inventory) {
                            if ($inventory->stock >= $value) {
                                $inventory->stock -= $value;
                                $inventory->update();
                                $item->issue_qty += $value;
                                $item->update();
                            } else {
                                $errorMessage[$itemId] = 'Qty not available';
                            }
                        } else {
                            $errorMessage[$itemId] = 'Inventory not found';
                        }
                    } else {
                        $errorMessage[$itemId] = 'You need ' . $item->qty;
                    }
                }
            }
        }
        if (!empty($errorMessage)) {
            return redirect()->back()->withErrors($errorMessage);
        } else {
            return redirect()->back();
        }
    }
}
