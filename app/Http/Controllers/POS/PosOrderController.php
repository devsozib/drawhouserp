<?php

namespace App\Http\Controllers\POS;

use DB;
use Sentinel;
use App\Models\Emp;
use App\Models\Designation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\HRIS\Database\Employee;

use App\Models\Library\General\Company;
use Illuminate\Support\Facades\Session;
use App\Models\Frontend\Order\OrderItem;

use App\Models\Library\General\Customer;
use App\Models\Frontend\Order\OrderProcess;
use App\Models\Frontend\Order\SplitPayment;
use App\Models\Library\ProductManagement\Product;
use App\Models\Library\ProductManagement\ProductAdon;

use App\Models\Library\ProductManagement\ProductSize;
use App\Models\Library\ProductManagement\ProductOption;
use App\Models\Library\ProductManagement\ProductCategory;

class PosOrderController extends Controller
{
    public function index(Request $request){


        if(false){
            $degs = Designation::get();
            $mapArr = array();
            foreach($degs as $deg){
                $mapArr[1][$deg->id] = $deg->id;
                $deg->company_id = 1;
                //$deg->update();
            }
            $emps = Emp::get();
            foreach($emps as $emp){
                if($emp->DesignationID != null && $emp->DesignationID !=0){
                    if(!isset($mapArr[$emp->company_id]))$mapArr[$emp->company_id] = [];
                    if(!isset($mapArr[$emp->company_id][$emp->DesignationID])){
                        $obj = Designation::find($emp->DesignationID);
                        $newObj = $obj->replicate();
                        $newObj->company_id = $emp->company_id;
                        //$newObj->save();
                        $mapArr[$emp->company_id][$emp->DesignationID] = $newObj->id;
                    }
                    $emp->DesignationID = $mapArr[$emp->company_id][$emp->DesignationID];
                   // $emp->update();
                }
            }
            return;
        }

        if(false){
            $poche = DB::table("poche")->get();
            foreach($poche as $row){
                $emmID = $row->EmployeeID;
                $newEmpId = '3'.$emmID;
                $erp = DB::table("erp")->where('EmployeeID', $newEmpId)->first();
                if($erp){
                    $data = collect($row)->except(['id', 'EmployeeID'])->toArray();
                    foreach ($data as $key => $value) {
                        $erp->$key = $value;
                    }
                    // $erp->save();
                    // _print($erp,1);
                }
            }
            return;
        }

        if(false){

            $COMPANY = 7;

            $categories = ProductCategory::where('company_id', 1)->get();
            foreach($categories as $category){
                $catObj = new ProductCategory;
                $catData = collect($category)->except(['id', 'company_id'])->toArray();
                foreach ($catData as $key => $value) {$catObj->$key = $value;}
                $catObj->company_id = $COMPANY;
                $catObj->save();
                $oldCat = $category->id;
                $newCat = $catObj->id;

                $products = Product::where('category_id', $oldCat)->get();
                foreach($products as $product){
                    $proObj = new Product;
                    $proData = collect($product)->except(['id', 'company_id', 'category_id'])->toArray();
                    foreach ($proData as $key => $value) {$proObj->$key = $value;}
                    $proObj->unique_id = $proObj->unique_id.$COMPANY;
                    $proObj->company_id = $COMPANY;
                    $proObj->category_id = $newCat;
                    $proObj->save();
                    $oldPro = $product->id;
                    $newPro = $proObj->id;

                    $sizes = ProductSize::where('product_id', $oldPro)->get();
                    foreach($sizes as $size){
                        $sizObj = new ProductSize;
                        $sizData = collect($size)->except(['id', 'product_id'])->toArray();
                        foreach ($sizData as $key => $value) {$sizObj->$key = $value;}
                        $sizObj->product_id = $newPro;
                        $sizObj->save();
                        $oldSiz = $size->id;
                        $newSiz = $sizObj->id;

                        $options = ProductOption::where('product_id', $oldPro)->where('product_size_id', $oldSiz)->get();

                        foreach($options as $option){
                            $optObj = new ProductOption;
                            $optData = collect($option)->except(['id', 'product_id', 'product_size_id'])->toArray();
                            foreach ($optData as $key => $value) {$optObj->$key = $value;}
                            $optObj->product_id = $newPro;
                            $optObj->product_size_id = $newSiz;
                            $optObj->save();
                            $oldOpt = $option->id;
                            $newOpt = $optObj->id;
                        }

                    }

                    $addons = ProductAdon::where('product_id', $oldPro)->get();
                    foreach($addons as $addon){
                        $adnObj = new ProductAdon;
                        $adnData = collect($addon)->except(['id', 'product_id'])->toArray();
                        foreach ($adnData as $key => $value) {$adnObj->$key = $value;}
                        $adnObj->product_id = $newPro;
                        $adnObj->save();
                        $oldAdn = $addon->id;
                        $newAdn = $adnObj->id;
                    }

                }
            }

            return;
        }






        $lib_categories = lib_category();

        $companies = Company::get();
        $company_id = getHostInfo()['id'];
        $user = Sentinel::getUser();
        $salesType = 1;

        return view('pos.index', compact('lib_categories','companies', 'user','company_id', 'salesType'));
    }

    public function wholeSales(Request $request){

        $lib_categories = lib_category();

        $companies = Company::get();
        $company_id = getHostInfo()['id'];
        $user = Sentinel::getUser();
        $salesType = 2;

        return view('pos.index', compact('lib_categories','companies', 'user','company_id', 'salesType'));
    }

    public function corporateSale(Request $request){
        $lib_categories = lib_category();

        $companies = Company::get();
        $company_id = getHostInfo()['id'];
        $user = Sentinel::getUser();
        $salesType = 3;

        return view('pos.index', compact('lib_categories','companies', 'user','company_id', 'salesType'));
    }

    public function saveSplitBill(Request $request){
        $data = $request->data;
        $ar = explode(',',$data);

        foreach($ar as $item){
            $paymentId = explode('-',$item)[0];
            $amount = explode('-',$item)[1];
            $splitPayment = new SplitPayment;
            $splitPayment->unique_order_id = $request->uniqueId;
            $splitPayment->payment_method = $paymentId;
            $splitPayment->amount = $amount;
            $splitPayment->save();
        }
        \LogActivity::addToLog('Save order bill '.$request->uniqueId);

        $order = OrderProcess::where('unique_order_id', $request->uniqueId)->first();
        $customer = Customer::where('id',$order->client_id)->first();
        $order->order_status = 2;
        if($customer && $customer->discount_approval == 2)
            $order->discount_approval = 2;
        $order->update();

        \LogActivity::addToLog('Complete Order '.$request->uniqueId);

        return "success";
    }
}
