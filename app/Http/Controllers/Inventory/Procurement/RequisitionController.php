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

class RequisitionController extends Controller
{
    public function index(Request $request)
    {
        if (getAccess('view')) {
            $comp_arr = Company::where('id',getHostInfo()['id'])->orderBy('id', 'ASC')->where('C4S', 'Y')->pluck('Name', 'id');
            // $requisitions = RequisitionMain::orderBy('requisition_date', 'DESC')->groupBy('requisition_date')->get();
            $requisitions = RequisitionMain::join('lib_company', 'lib_company.id', '=', 'inv_proc_requisition_main.company_id')->select('inv_proc_requisition_main.id', 'inv_proc_requisition_main.company_id', 'lib_company.Name as company_name', 'inv_proc_requisition_main.requisition_date','inv_proc_requisition_main.status', DB::raw('DATE(inv_proc_requisition_main.requisition_date) as date'))
                ->where('inv_proc_requisition_main.company_id',getHostInfo()['id'])
                ->orderBy('date','DESC')
                ->get()
                ->groupBy('date');

            return view('inventory.procurement.requisition.index', compact('comp_arr', 'requisitions'));
        } else {
            return redirect()->back()->with('warning', getNotify(5));
        }
    }

    public function show(Request $request, $id)
    {
        $requisition = RequisitionMain::join('lib_company', 'lib_company.id', '=', 'inv_proc_requisition_main.company_id')->select('inv_proc_requisition_main.id', 'inv_proc_requisition_main.company_id', 'lib_company.Name as company_name', 'inv_proc_requisition_main.requisition_date','inv_proc_requisition_main.status')->where('inv_proc_requisition_main.id', $id)->first();
        $requisitions = RequisitionMain::join('lib_company', 'lib_company.id', '=', 'inv_proc_requisition_main.company_id')->select('inv_proc_requisition_main.id', 'inv_proc_requisition_main.company_id', 'lib_company.Name as company_name', 'inv_proc_requisition_main.requisition_date', DB::raw('DATE(inv_proc_requisition_main.requisition_date) as date'))
            ->where('inv_proc_requisition_main.company_id',getHostInfo()['id'])
            ->orderBy('date','DESC')
            ->get()
            ->groupBy('date');
        $companies = Company::where('id',getHostInfo()['id'])->orderBy('id', 'ASC')->where('C4S', 'Y')->get();
        $items = Ingredient::where('company_id', $requisition->company_id)->get();
        $reqtems = DB::table('inv_requisition_items as req_items')
            ->join('lib_ingredients as asset', 'req_items.ing_id', '=', 'asset.id')
            ->join('lib_units', 'lib_units.id', '=', 'asset.unit_id')
            ->join('inv_proc_requisition_main as requisitions', 'requisitions.id', '=', 'req_items.req_id')
            ->select('req_items.*', 'asset.name as asset_name', 'lib_units.name as unit_name', 'requisitions.id as req_id','requisitions.status')
            ->where('req_items.req_id', $id)
            ->where('requisitions.company_id',getHostInfo()['id'])
            ->orderBy('req_items.created_at', 'DESC')
            ->get();
        return view('inventory.procurement.requisition.show', compact('requisition', 'companies', 'items', 'requisitions', 'reqtems'));
    }

    public function store(Request $request)
    {
       
        if ($request->type == 'forReqAdd') {
            if (getAccess('create')) {
                $request->all();
                $userid = Sentinel::getUser()->id;
                $attributes = Input::all();
                $rules = [
                    'company_id' => 'required|numeric',
                    'requisition_date' => 'required|date_format:Y-m-d',
                ];
                $validation = Validator::make($attributes, $rules);
                if ($validation->fails()) {
                    return redirect()->action('Inventory\Procurement\RequisitionController@index')->with(['error' => getNotify(4), 'error_code' => 'Add'])->withErrors($validation)->withInput();
                } else {
                    // return $attributes;
                    $user = new RequisitionMain();
                    $user->created_by = $userid;
                    $user->fill($attributes)->save();

                    \LogActivity::addToLog('Add Issue Requisition: ' . $user->id);
                    return redirect()->action('Inventory\Procurement\RequisitionController@show', $user->id)->with('success', getNotify(1));
                }
            } else {
                return redirect()->back()->with('warning', getNotify(5));
            }
        }elseif($request->type == 'rcvQtyUpdate'){
             $userid = Sentinel::getUser()->id;
             $req_id =  $request->req_id;
             $ing_id =  $request->ing_id;
             $qty =  $request->qty;
             $item = RequisitionItem::where('req_id', $req_id)->where('ing_id', $ing_id)->first();
             $checkInventory = Inventory::where('item_id',$ing_id)->where('company_id',getHostInfo()['id'])->first();                                                 
                if($checkInventory){ 
                    $diffrent = 0;
                    if($item->rcv_qty < $qty){
                        $diffrent = $qty - $item->rcv_qty;
                        $checkInventory->stock += $diffrent;
                        $checkInventory->update();                        
                    }else{
                        $diffrent =  $item->rcv_qty - $qty;
                        if( $checkInventory->stock >= $diffrent){
                            $checkInventory->stock -= $diffrent;
                            $checkInventory->update();
                        }else{
                            return response()->json(['warning' => 'success']); 
                        }                       
                    } 
                    $item->rcv_qty = $qty;
                    $item->update();   
                    return response()->json(['status' => 'success']);                                                  
                }else{
                    $inventory = new Inventory();
                    $inventory->company_id = getHostInfo()['id'];
                    $inventory->item_id = $ing_id;
                    $inventory->stock = $qty;
                    $inventory->created_by =   $userid;
                    $inventory->save();
                    return response()->json(['status' => 'success']);        
                }                     
            }elseif($request->type == 'statusUpdate'){
                 $userid = Sentinel::getUser()->id;
                 $req_id = $request->req_id;
                 $status = $request->status;
                 $requestion = RequisitionMain::where('company_id',getHostInfo()['id'])->where('id',$req_id)->first();
                 $requestion->status = $status;
                 $requestion->updated_by = $userid;
                 $requestion->update();
                 return response()->json(['status' => 'success']);  
            } else {
                    $req_id = intval($request->req_id);
                    $ingredient = intval($request->ingredient);
                    $qty = intval($request->qty);
                    $remarks = $request->remarks;
                    $userid = Sentinel::getUser()->id;
                    $validator = Validator::make($request->all(), [
                        'ingredient' => 'required',
                        'qty' => 'required',
                    ]);
                    $checkExistData = RequisitionItem::where('req_id', $req_id)->where('ing_id', $ingredient)->first();
                    if ($checkExistData) {
                        return response()->json(['status' => 'exists']);
                    } else {
                        if ($validator->fails()) {
                            $errors = $validator->errors();
                            return response()->json(['errors' => $errors, 'status' => 'error']);
                        } else {
                            $getRequisition = RequisitionMain::findOrFail($req_id);
                            $issueItem = new RequisitionItem();
                            $issueItem->req_id = $req_id;
                            $issueItem->ing_id = $ingredient;
                            $issueItem->qty = $qty;
                            $issueItem->remarks = $remarks;
                            $issueItem->date = date('Y-m-d');
                            $issueItem->created_by = $userid;
                            $issueItem->save();
                            $getRequisition->status = 0;
                            $getRequisition->update();
                            \LogActivity::addToLog('Add Requisition Issue Item: ' . $ingredient);
                            return response()->json(['status' => 'success']);
                        }
                    }
                }
    }

    public function update(Request $request, $id)
    {
        if ($request->type == 'ItemEdit') {
            $req_id = intval($request->req_id);
            $qty = intval($request->qty);
            $remarks = $request->remarks;
            $userid = Sentinel::getUser()->id;
            $validator = Validator::make($request->all(), [
                'qty' => 'required',
            ]);
            if ($validator->fails()) {
                $errors = $validator->errors();
                return redirect()->back()->with(['error' => getNotify(4), 'error_code' => 'update'])->withErrors($errors)->withInput();
            } else {
                $issueItem = RequisitionItem::where('req_id', $req_id)->where('id', $id)->first();
                $issueItem->qty = $qty;
                $issueItem->remarks = $remarks;
                $issueItem->date = date('Y-m-d');
                $issueItem->update_by = $userid;
                $issueItem->update();
                \LogActivity::addToLog('Update Requisition Issue Item: ' . $id);
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
                $user = RequisitionItem::find($id);
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
                return redirect()->action('Inventory\Procurement\RequisitionController@index')->with('success', getNotify(3));
            } else {
                return redirect()->back()->with('warning', getNotify(5));
            }
        }
    }
}
