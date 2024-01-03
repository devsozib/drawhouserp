<?php

namespace App\Http\Controllers\Library\OrderManagement;

use Sentinel;
use Carbon\Carbon;

use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\HRIS\Database\Employee;
use App\Models\Library\General\Company;
use App\Models\Frontend\Order\OrderItem;
use App\Models\Library\General\Customer;
use App\Models\Frontend\Order\OrderProcess;
use App\Models\Frontend\Order\SplitPayment;
use App\Models\Library\General\PaymentMethod;
use App\Models\HRIS\Setup\TrainingParticipant;
use App\Models\Library\general\DiscountCategory;
use App\Models\HRIS\Database\EmployeePerformance;
use App\Models\Library\ProductManagement\Product;
use App\Models\Inventory\Procurement\PurchaseMain;
use App\Models\Library\ProductManagement\Ingredient;
use App\Models\Library\ProductManagement\ProductIng;
use App\Models\Inventory\Procurement\RequisitionItem;
use App\Models\Inventory\Procurement\RequisitionMain;
use App\Models\Library\ProductManagement\ProductAdon;
use App\Models\Library\ProductManagement\ProductSize;
use App\Models\Inventory\Procurement\PurchaseOrderItem;
use App\Models\Library\ProductManagement\ProductOption;
use App\Models\HRIS\Database\EmployeePerformanceDetails;
use App\Models\Library\ProductManagement\ProductAdonIng;
use App\Models\Library\ProductManagement\ProductOptnIng;
use App\Models\Library\ProductManagement\ProOptionTitle;


use App\Models\Library\ProductManagement\SubCatAddonIng;
use App\Models\Library\ProductManagement\ProductCategory;

use App\Models\Library\ProductManagement\IngredientCategory;
use App\Models\Library\ProductManagement\ProductSubCategory;
use App\Models\Library\ProductManagement\IngredientSubCategory;
use DB;

class OrderManagementController extends Controller
{
    public function posOrder(Request $request)
    {

        $companies = Company::get();

        \LogActivity::addToLog('View all orders');

        return view('library.order_management.orders', compact('companies'));
    }

    public function webOrder(Request $request)
    {
        return "web";
    }


    public function getPosOrder(Request $request)
    {
        // _print($request->all());
        // $request->all();
        // join('fr_order_items', 'fr_order_items.unique_order_id', '=', 'fr_order_process.unique_order_id')

        $orders = OrderProcess::join('lib_customers', 'lib_customers.id', '=', 'fr_order_process.client_id')
            ->leftjoin('hr_database_employee_basic', 'hr_database_employee_basic.EmployeeID', '=', 'fr_order_process.served_by')
            ->where('branch_id', $request->concern)
            ->whereDate('order_time', '>=', $request->start_date)
            ->whereDate('order_time', '<=', $request->end_date)
            ->select('fr_order_process.*', 'lib_customers.name as guest_name', 'hr_database_employee_basic.Name as employee_name')
            ->get();

        // _print($orders->toArray());

        $unique_order_ids = array();

        foreach ($orders as $order) {
            $unique_order_ids[] = $order->unique_order_id;
        }

        $orderDetails = OrderItem::whereIn('unique_order_id', $unique_order_ids)->get();
        //->select('product_option_ids','unique_order_id')

        $temp = array();
        foreach ($orderDetails as $details) {
            $temp[$details->unique_order_id][] = $details;
        }
        $orderDetails = $temp;

        $tables = lib_table();
        $products = lib_product();
        $options = lib_option();
        $addons = lib_addon();

        $paymentMethods = PaymentMethod::where('company_id', $request->concern)->get();

        \LogActivity::addToLog('Filter orders from all orders');

        return view('library.order_management.orderList', compact('orders', 'orderDetails', 'tables', 'products', 'options', 'addons', 'paymentMethods'));
    }

    public function getTodaysOrders(Request $request)
    {

        $today = date("Y-m-d");

        $orders = OrderProcess::join('lib_customers', 'lib_customers.id', '=', 'fr_order_process.client_id')
            ->leftjoin('hr_database_employee_basic', 'hr_database_employee_basic.EmployeeID', '=', 'fr_order_process.served_by')
            ->where('branch_id', $request->concern)->whereDate('order_time', '>=', $today)
            ->whereDate('order_time', '<=', $today)
            ->where('order_from', 'pos')
            ->where('sales_type', $request->salesType)
            ->select('fr_order_process.*', 'lib_customers.name as guest_name', 'hr_database_employee_basic.Name as employee_name')
            ->get();

        $unique_order_ids = array();

        foreach ($orders as $order) {
            $unique_order_ids[] = $order->unique_order_id;
        }

        $orderDetails = OrderItem::whereIn('unique_order_id', $unique_order_ids)->get();
        //->select('product_option_ids','unique_order_id')

        $temp = array();
        foreach ($orderDetails as $details) {
            $temp[$details->unique_order_id][] = $details;
        }
        $orderDetails = $temp;

        $tables = lib_table();
        $rooms = lib_room();
        $products = lib_product();
        $options = lib_option();
        $addons = lib_addon();
        $paymentMethods = PaymentMethod::where('company_id', $request->concern)->get();

        \LogActivity::addToLog("Filter today's orders");
        return view('library.order_management.pos.todaysOrderList', compact('orders', 'orderDetails', 'tables', 'rooms', 'products', 'options', 'addons', 'paymentMethods'));
    }


    public function makeKot(Request $request, $id)
    {

        $order = OrderProcess::where('unique_order_id', $id)->first();
        $order->kot_status = 1;
        $order->save();


        $orderDetails = OrderItem::where('unique_order_id', $id)->get();


        $tables = lib_table();
        $products = lib_product();
        $options = lib_option();
        $addons = lib_addon();
        $sizes = lib_size();

        \LogActivity::addToLog('Generate KOT');

        return view('library.order_management.pos.kot', compact('order', 'orderDetails', 'tables', 'products', 'options', 'addons', 'sizes'));
    }


    public function makeInvoice(Request $request, $id)
    {
        $order = OrderProcess::where('unique_order_id', $id)->first();
        $order->invoice_status = 1;
        $order->save();


        $orderDetails = OrderItem::where('unique_order_id', $id)->get();


        $tables = lib_table();
        $products = lib_product();
        $options = lib_option();
        $addons = lib_addon();
        $sizes = lib_size();

        \LogActivity::addToLog('Make invoice ' . $id);

        return view('library.order_management.pos.invoice', compact('order', 'orderDetails', 'tables', 'products', 'options', 'addons', 'sizes'));
    }

    public function kotOrder(Request $request)
    {
        $companies = Company::get();

        \LogActivity::addToLog('Get KOT orders list');
        return view('library.order_management.kotOrder', compact('companies'));
    }
    public function getkotOrder(Request $request)
    {

        $orders = OrderProcess::join('lib_customers', 'lib_customers.id', '=', 'fr_order_process.client_id')
            ->leftjoin('hr_database_employee_basic', 'hr_database_employee_basic.EmployeeID', '=', 'fr_order_process.served_by')
            ->where('branch_id', $request->concern)
            ->where(function ($query) {
                $query->where('kot_status', 1)
                    ->orWhere('cooking_status', 1);
            })
            ->where('cooking_status', '!=', 2)
            ->select('fr_order_process.*', 'lib_customers.name as guest_name', 'hr_database_employee_basic.Name as employee_name')
            ->get();


        $unique_order_ids = array();

        foreach ($orders as $order) {
            $unique_order_ids[] = $order->unique_order_id;
        }

        $orderDetails = OrderItem::whereIn('unique_order_id', $unique_order_ids)->get();
        //->select('product_option_ids','unique_order_id')

        $temp = array();
        foreach ($orderDetails as $details) {
            $temp[$details->unique_order_id][] = $details;
        }
        $orderDetails = $temp;

        $tables = lib_table();
        $products = lib_product();
        $options = lib_option();
        $addons = lib_addon();
        \LogActivity::addToLog('filter KOT orders');

        // return view('library.order_management.pos.orderList', compact('orders', 'orderDetails', 'tables', 'products', 'options', 'addons'));
        return view('library.order_management.kotOrderList', compact('orders', 'orderDetails', 'tables', 'products', 'options', 'addons'));
    }

    public function cookingStart(Request $request)
    {
        $value = 1;
        if ($request->flag == "false")  $value = 0;
        $order = OrderProcess::where("unique_order_id", $request->uniqueOrderId)->first();
        $order->cooking_status = $value;
        $order->update();
        \LogActivity::addToLog('Cooking started');
    }

    public function cookingEnd(Request $request)
    {
        $value = 2;
        if ($request->flag == "false")  $value = 1;
        $order = OrderProcess::where("unique_order_id", $request->uniqueOrderId)->first();
        $order->cooking_status = $value;
        if ($request->flag == "true") $order->ready_to_delivery = 1;
        $order->update();
        \LogActivity::addToLog('Cooking end');
    }

    public function readyToServe(Request $request)
    {
        $value = 1;
        if ($request->flag == "false")  $value = 0;
        $order = OrderProcess::where("unique_order_id", $request->uniqueOrderId)->first();
        $order->ready_to_delivery = $value;
        $order->update();
        \LogActivity::addToLog('Ready to serve');
    }

    public function delivered(Request $request)
    {
        $value = 2;
        if ($request->flag == "false")  $value = 1;
        $order = OrderProcess::where("unique_order_id", $request->uniqueOrderId)->first();
        $order->ready_to_delivery = $value;
        $order->update();
        \LogActivity::addToLog('Order delivered');
    }

    public function readyToDelivery(Request $request)
    {
        $companies = Company::get();
        \LogActivity::addToLog('View ready to delivery order ');

        return view('library.order_management.readyToDelivery', compact('companies'));
    }

    public function getReadyToDeliveryOrderList(Request $request)
    {
        $orders = OrderProcess::join('lib_customers', 'lib_customers.id', '=', 'fr_order_process.client_id')
            ->leftjoin('hr_database_employee_basic', 'hr_database_employee_basic.EmployeeID', '=', 'fr_order_process.served_by')
            ->where('branch_id', $request->concern)
            ->where('ready_to_delivery', '=', 1)
            ->select('fr_order_process.*', 'lib_customers.name as guest_name', 'hr_database_employee_basic.Name as employee_name')
            ->get();

        // _print($orders->toArray());

        $unique_order_ids = array();

        foreach ($orders as $order) {
            $unique_order_ids[] = $order->unique_order_id;
        }

        $orderDetails = OrderItem::whereIn('unique_order_id', $unique_order_ids)->get();
        //->select('product_option_ids','unique_order_id')

        $temp = array();
        foreach ($orderDetails as $details) {
            $temp[$details->unique_order_id][] = $details;
        }
        $orderDetails = $temp;

        $tables = lib_table();
        $products = lib_product();
        $options = lib_option();
        $addons = lib_addon();

        \LogActivity::addToLog('Filter ready to delivery orders');
        // return view('library.order_management.pos.orderList', compact('orders', 'orderDetails', 'tables', 'products', 'options', 'addons'));
        return view('library.order_management.readyToDeliveryList', compact('orders', 'orderDetails', 'tables', 'products', 'options', 'addons'));
    }


    public function salesReport(Request $request)
    {
        $companies = Company::get();
        \LogActivity::addToLog('View sales report');
        return view('library.reports.salseReport', compact('companies'));
    }

    public function generateReport(Request $request)
    {

        $start_date = Carbon::parse($request->start_date)->startOfDay()->format('Y-m-d H:i:s');
        $end_date = Carbon::parse($request->end_date)->endOfDay()->format('Y-m-d H:i:s');
        $orders = OrderProcess::join('lib_customers', 'lib_customers.id', '=', 'fr_order_process.client_id')
            ->leftjoin('hr_database_employee_basic', 'hr_database_employee_basic.EmployeeID', '=', 'fr_order_process.served_by')
            ->where('branch_id', $request->concern)
            ->where('order_status', 2)
            ->whereBetween('order_time', [$start_date, $end_date])
            // ->whereDate('order_time', '<=', $request->end_date)
            ->select('fr_order_process.*', 'lib_customers.name as guest_name', 'hr_database_employee_basic.Name as employee_name')
            ->get();

        // _print($orders->toArray());

        $posOrder = 0;
        $webOrder = 0;
        $dineIn = 0;
        $delivered = 0;
        $totalOrder = 0;
        $unique_order_ids = array();

        foreach ($orders as $order) {
            $totalOrder++;
            if ($order->order_from == 'pos') $posOrder++;
            if ($order->order_from == 'web') $webOrder++;

            if ($order->isDelivered == 0) $dineIn++;
            if ($order->isDelivered == 1) $delivered++;

            $unique_order_ids[] = $order->unique_order_id;
        }

        // $posOrder = $webOrder = 0;
        if ($totalOrder > 0) {
            $posOrder = ($posOrder / divisor($totalOrder)) * 100;
            $delivered = ($delivered / divisor($totalOrder)) * 100;
            $posOrder = number_format($posOrder, 2);
            $delivered = number_format($delivered, 2);

            $dineIn = ($dineIn / divisor($totalOrder)) * 100;
            $webOrder = ($webOrder / divisor($totalOrder)) * 100;
            $dineIn = number_format($dineIn, 2);
            $webOrder = number_format($webOrder, 2);
        }

        //dd($totalOrder, $posOrder, $webOrder);



        $orderDetails = OrderItem::whereIn('unique_order_id', $unique_order_ids)
            ->join('lib_products', 'lib_products.id', '=', 'fr_order_items.product_id')
            ->join('lib_product_categories', 'lib_product_categories.id', '=', 'lib_products.category_id')
            ->select('fr_order_items.*', 'lib_product_categories.id as category_id', 'lib_product_categories.name as category_name')
            ->get();




        $temp = array();
        $total = 0;
        $categoryWiseSales = array();
        $productWiseSales = array();
        $categoryWiseItem = array();
        $categoryWiseProductIds = array();
        foreach ($orderDetails as $details) {

            if (!isset($categoryWiseSales[$details->category_id])) $categoryWiseSales[$details->category_id] = 0;
            if (!isset($productWiseSales[$details->product_id])) $productWiseSales[$details->product_id] = 0;

            $categoryWiseSales[$details->category_id] += $details->product_quantity;
            $productWiseSales[$details->product_id] += $details->product_quantity;
            $categoryWiseProductIds[$details->category_id][] = $details->product_id;

            // $temp[$details->unique_order_id][] = $details;
            $categoryWiseItem[$details->category_id][] = $details;
            $total += $details->product_quantity;
        }

        foreach ($categoryWiseSales as $key => $val) {
            $categoryWiseSales[$key] = number_format((($val / divisor($total)) * 100), 2);
        }
        foreach ($productWiseSales as $key => $val) {
            $productWiseSales[$key] = number_format((($val / divisor($total)) * 100), 2);
        }


        arsort($categoryWiseSales);
        arsort($productWiseSales);

        $categoryColor = getRandomColor(count($categoryWiseSales));
        $productColor = getRandomColor(count($productWiseSales));
        $categoryWiseProductColor = array();

        foreach ($categoryWiseProductIds as $categoryId => $productIds) {
            $categoryWiseProductColor[$categoryId] = getRandomColor(count($productIds));
        }


        $tables = lib_table();
        $products = lib_product();
        $libCategories = lib_category();
        $options = lib_option();
        $addons = lib_addon();

        \LogActivity::addToLog('Generate sales report');

        $categories = return_library(ProductCategory::where('status', '1')->where('company_id', $request->concern)->get(), 'id', 'name');
        // $categories = return_library(ProductCategory::where('status', '1')->get(), 'id', 'name');
        // _print($categories,1);

        return view('library.reports.generateReport', compact('total', 'products',  'libCategories',  'categoryWiseSales', 'productWiseSales', 'categoryColor', 'productColor', 'posOrder', 'webOrder', 'categoryWiseItem', 'categories', 'categoryWiseProductIds', 'categoryWiseProductColor','delivered', 'dineIn'));
    }


    public function dailyReport(Request $request)
    {
        $companies = Company::get();
        $company_id = getHostInfo()['id'];
        \LogActivity::addToLog('View daily sales report');
        return view('library.reports.dailyReport', compact('companies', 'company_id'));
    }

    public function generateDailyReport(Request $request)
    {
        // return OrderProcess::where('order_status', 2)->where('sales_type',2)->get();

        // $start_date = Carbon::parse($request->start_date)->startOfDay()->format('Y-m-d H:i:s');
        // $end_date = Carbon::parse($request->end_date)->startOfDay()->format('Y-m-d H:i:s');
        $start_date = date('Y-m-d 00:00:00', strtotime($request->start_date));
        $end_date = date('Y-m-d 23:59:59', strtotime($request->end_date));
        $orders = OrderProcess::where('branch_id', $request->concern);
        if ($start_date == $end_date)
            $orders = $orders->whereDate('order_time', '=', $start_date);
        else {
            // $orders = $orders->where('order_time', '>=',$start_date)->where('order_time', '<=',$end_date);
            $orders = $orders->whereBetween('order_time', [$start_date, $end_date]);
        }

        $orders = $orders->where('order_status', 2)->get();

        $orderIds = array();
        $complimentaryOrderIds = array();
        $discount = 0;
        $onlineSales = 0;
        $dineInSales = 0;
        $complimentary = 0;
        $retail = 0;
        $wholesale = 0;
        $corporate = 0;

        foreach ($orders as $order) {
            if ($order->isComplimentary == 1) {
                $complimentaryOrderIds[] = $order->unique_order_id;
                $complimentary += $order->paid_amount;
            } else {
                $orderIds[] = $order->unique_order_id;
                $discount += $order->discount_amount;
                if ($order->isDelivered == 1) {
                    $onlineSales += $order->paid_amount;
                } else {
                    $dineInSales += $order->paid_amount;
                }

                if ($order->sales_type == 1) $retail += $order->paid_amount;
                if ($order->sales_type == 2) $wholesale += $order->paid_amount;
                if ($order->sales_type == 3) $corporate += $order->paid_amount;
            }
        }


        $payments = SplitPayment::join('lib_payment_method', 'lib_payment_method.id', '=', 'fn_order_split_bill.payment_method')
            ->whereIn('unique_order_id', $orderIds)
            ->select('fn_order_split_bill.*', 'lib_payment_method.id', 'lib_payment_method.name', 'lib_payment_method.category_id')
            ->get();

        $methodCategoryWiseSales = array();
        $methodWiseSales = array();

        foreach ($payments as $payment) {
            if (!isset($methodCategoryWiseSales[$payment->category_id])) {
                $methodCategoryWiseSales[$payment->category_id]['method'] = [];
                $methodCategoryWiseSales[$payment->category_id]['amount'] = 0;
                $methodCategoryWiseSales[$payment->category_id]['name'] = paymentMethodCategory()[$payment->category_id];
            }
            if (!isset($methodWiseSales[$payment->payment_method])) {
                $methodWiseSales[$payment->payment_method]['amount'] = 0;
                $methodWiseSales[$payment->payment_method]['name'] = $payment->name;
            }
            $methodCategoryWiseSales[$payment->category_id]['method'][$payment->payment_method] = $payment->payment_method;
            $methodCategoryWiseSales[$payment->category_id]['amount'] += $payment->amount;
            $methodWiseSales[$payment->payment_method]['amount'] += $payment->amount;
        }
        $totalSales = $onlineSales + $dineInSales;

        \LogActivity::addToLog('Generate daily sales report');
        return view('library.reports.generateDailyReport', compact('retail', 'wholesale', 'corporate', 'discount', 'onlineSales', 'dineInSales', 'complimentary', 'methodCategoryWiseSales', 'methodWiseSales', 'totalSales'));
    }

    public function discountApproval(Request $request)
    {
        $orders = OrderProcess::join('lib_customers', 'lib_customers.id', '=', 'fr_order_process.client_id')
            ->where('fr_order_process.order_status', 2)
            ->where('fr_order_process.discount_category', '!=', 0)
            ->where('fr_order_process.discount_approval', 0)
            ->select('fr_order_process.*', 'lib_customers.name', 'lib_customers.phone')
            ->get();

        $discount_category_ids = array();
        foreach ($orders as $order) {
            $discount_category_ids[$order->discount_category] = $order->discount_category;
        }

        $rows = Customer::where('discount_category', '!=', 0)->where('discount_approval', 0)->get();
        $customers = array();
        foreach ($rows as $customer) {
            $customers[$customer->id] = $customer;
            $discount_category_ids[$customer->discount_category] = $customer->discount_category;
        }
        // $rows = DiscountCategory::whereIn('id', $discount_category_ids)->get();
        $rows = DB::table('lib_discount_category')->whereIn('id', $discount_category_ids)->get();
        $discountCategories = array();
        foreach ($rows as $discount) {
            $discountCategories[$discount->id] = $discount;
        }
        return view('library.order_management.discountApproval', compact('discountCategories', 'orders', 'customers'));
    }

    public function updateDiscountApproval(Request $request)
    {
        // return $request->all();
        if ($request->type == 'customer') {
            $customer = Customer::where('id', $request->id)->first();
            $customer->discount_approval = $request->status;
            $customer->update();
            \LogActivity::addToLog('Update discount approval for customer ' . $request->id);
        }
        if ($request->type == 'order') {
            $order = OrderProcess::where('id', $request->id)->first();
            $order->discount_approval = $request->status;
            $order->update();
            \LogActivity::addToLog('Update discount approval for order ' . $request->id);
        }
    }
}
