<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use App\Models\Frontend\Order\OrderItem;
use App\Models\Library\General\Customer;
use App\Models\Frontend\Order\OrderProcess;
use App\Models\Library\General\LibCustomerAddress;

class OrderController extends Controller
{
    public function index(Request $request)
    {

        // return cartItems();


        $data = $request->all();
        // _print($data,1);

        $functionToCall = $data['funName'];

        switch ($functionToCall) {
            case "perfectOrder":
                $this->processOrder($data);
                return redirect()->route('customer.profile');
                break;
            default:
                showProcessingWindow();
        }
    }

    public function processOrder($data)
    {

        // showProcessingWindow();

        $uniqueOrderId = $this->saveOrder($data);

        $paymentMethodId = $data['clientPaymentMethod'];

        if ($paymentMethodId == 2) {

            $orderProcess = OrderProcess::where('unique_order_id', $uniqueOrderId)->first();

            if (!$orderProcess) return;
            $orderProcess->payment_status = 1;
            $orderProcess->update();
            $this->sslCheckout($uniqueOrderId, $data);
        } else {
            $clientMobile = $data['clientMobile'];
            $customer = Customer::where('phone', $clientMobile)->first();
            if (!Auth::guard('customer')->check())
                Auth::guard('customer')->login($customer);
        }
    }

    public function saveOrder($data)
    {
        // return "come";
        $parts = explode('/', $data['clientDOB']);
        if (!(count($parts) < 3)) $data['clientDOB'] = date("Y-m-d", strtotime($parts[2] . '-' . $parts[1] . '-' . $parts[0]));

        if (!$data['clientId'] || $data['clientId'] == 0) {
            $customer = Customer::where('phone', trim($data['clientMobile']))->where('email', trim($data['clientEmail']))->first();

            if ($customer && $customer->password) {
                return redirect()->back()->withErrors(['login_error' => 'Already exist account with this credentials.']);
            } else {
                if ($customer) {
                    $customer->name = $data['clientName'];
                    $customer->email = $data['clientEmail'];
                    $customer->phone = $data['clientMobile'];
                    $customer->dob = $data['clientDOB'];
                    $customer->password = Hash::make($data['clientPassword']);
                    $customer->update();
                    $data['clientId'] =  $customer->id;
                } else {
                    $customer = new Customer;

                    $customer->name = $data['clientName'];
                    $customer->email = $data['clientEmail'];
                    $customer->phone = $data['clientMobile'];
                    $customer->dob = $data['clientDOB'];
                    $customer->password = Hash::make($data['clientPassword']);
                    $customer->save();
                    $data['clientId'] =  $customer->id;
                }
            }
        }

        $existAddressId = LibCustomerAddress::where('customer_id', $data['clientId'])->pluck('id');
        $existAddressId = make_key_value($existAddressId);


        $addressData = array();

        for ($i = 0; $i < count($data['temp_id']); $i++) {
            $addressData[$data['temp_id'][$i]] = [
                'update_id' => $data['address_id'][$i],
                'address' => $data['address'][$i],
                'specification' => $data['address_specification'][$i],
                'label' => $data['address_label'][$i],
            ];
        }
        foreach ($addressData as $key => $address) {
            if ($address['update_id'] != null && $address['update_id'] != "") {
                unset($existAddressId[$address['update_id']]);


                $lib_address = LibCustomerAddress::where('id', $address['update_id'])->first();
                $lib_address->address_label = $address['label'];
                $lib_address->local_address = $address['address'];
                $lib_address->address_specification = $address['specification'];
                $lib_address->update();
            } else {
                $lib_address = new LibCustomerAddress;
                $lib_address->customer_id = $data['clientId'];
                $lib_address->address_label = $address['label'];
                $lib_address->local_address = $address['address'];
                $lib_address->address_specification = $address['specification'];
                $lib_address->created_by = $data['clientId'];
                $lib_address->save();
                $addressData[$key]['update_id'] = $lib_address->id;
            }
        }





        $serviceChargePercentage = getValueFromExtraTableByItemName("service_charge");
        $taxPercentage = getValueFromExtraTableByItemName("VAT");


        $tableId = $data['tableId'];

        if ($tableId == 0) {
            $status = 1;
        } else {
            $status = 2;
        }
        // $branchId = $data['branchId']; selected_address_temp_id


        $uniqueOrderId = round(microtime(true) * 1000) . $data['clientId'];


        $deliveryAddress = $addressData[$data['selected_address_temp_id']]['update_id'];
        $totalItems = totalCartItem();
        $cartTotalBill = totalCartPrice();
        $basicTotalBill = basePriceFromFinalBill($cartTotalBill, $serviceChargePercentage, $taxPercentage);
        $serviceCharge = totalServiceChargeFromFinalBill($cartTotalBill, $serviceChargePercentage, $taxPercentage); //totalServiceCharge($basicTotalBill, $serviceChargePercentage);
        //$beforeTax = $basicTotalBill + $serviceCharge;
        $tax = totalVatFromFinalBill($cartTotalBill, $taxPercentage); //totalTax($beforeTax, $taxPercentage);
        if (isset($data['deliveryCharge'])) {
            $deliveryCharge = $data['deliveryCharge'];
        } else {
            $deliveryCharge = 0;
        }

        if (isset($data['discountAmount'])) {
            $discountAmount = $data['discountAmount'];
        } else {
            $discountAmount = 0;
        }


        $totalBill = (grandTotalFromBasicAmount($basicTotalBill, $serviceChargePercentage, $taxPercentage) + $deliveryCharge) - $discountAmount;
        $paidAmount = $totalBill; //$_REQUEST['paidAmount'];
        $paymentMethodId = $data['paymentMethod'];

        if (isset($data['orderRemarks'])) {
            $orderRemarks = $data['orderRemarks'];
        } else {
            $orderRemarks = "No Extra Requirements";
        }

        if ($paymentMethodId == "2") {
            $orderProcess = new OrderProcess;
            $orderProcess->order_from = "web";
            $orderProcess->table_id = $tableId;
            $orderProcess->branch_id = getHostInfo()['id'];
            // $orderProcess->sub_branch_id = $subBranchId;
            $orderProcess->client_id = $data['clientId'];
            $orderProcess->unique_order_id = $uniqueOrderId;
            $orderProcess->delivery_address = $deliveryAddress;
            $orderProcess->total_items = $totalItems;
            $orderProcess->basic_total_bill = $basicTotalBill;
            $orderProcess->service_charge = $serviceCharge;
            $orderProcess->tax = $tax;
            $orderProcess->delivery_charge = $deliveryCharge;
            $orderProcess->discount_amount = $discountAmount;
            $orderProcess->total_bill = $totalBill;
            $orderProcess->paid_amount = $paidAmount;
            $orderProcess->payment_method_id = $paymentMethodId;
            $orderProcess->remarks = $orderRemarks;
            $orderProcess->show_notification = '0';
            $orderProcess->show_common_notification = '0';
            $orderProcess->status = $status;
            $orderProcess->save();
        } else {
            $orderProcess = new OrderProcess;
            $orderProcess->table_id = $tableId;
            $orderProcess->order_from = "web";
            // $orderProcess->branch_id = $branchId;
            // $orderProcess->sub_branch_id = $subBranchId;
            $orderProcess->client_id = $data['clientId'];
            $orderProcess->unique_order_id = $uniqueOrderId;
            $orderProcess->delivery_address = $deliveryAddress;
            $orderProcess->total_items = $totalItems;
            $orderProcess->basic_total_bill = $basicTotalBill;
            $orderProcess->service_charge = $serviceCharge;
            $orderProcess->tax = $tax;
            $orderProcess->delivery_charge = $deliveryCharge;
            $orderProcess->discount_amount = $discountAmount;
            $orderProcess->total_bill = $totalBill;
            $orderProcess->paid_amount = $paidAmount;
            $orderProcess->payment_method_id = $paymentMethodId;
            $orderProcess->remarks = $orderRemarks;
            $orderProcess->status = $status;
            $orderProcess->save();
        }




        //print_r($_SESSION['cart']);

        if ($orderProcess) {

            foreach (cartItems() as $key => $value) {
                $productId = $value['product_id'];
                $productSizeId = $value['product_size_id'];
                $basePrice = getProductPriceFromSizeId($value['product_size_id']);

                $options = $value['options'];
                $addons = $value['addons'];
                $option_ids = array();
                $option_prices = array();
                $addon_ids = array();
                $addon_prices = array();

                foreach($options as $option){
                    $option_ids[] = $option->id;
                    $option_prices[] = getProductOptionPrice($option);
                }

                foreach($addons as $addon){
                    $addon_ids[] = $addon->id;
                    $addon_prices[] = getProductAddonPrice($addon);
                }

                // _print(cartItems());
                // _print($option_ids,1);
                // _print($option_prices,1);
                // _print($addon_ids,1);
                // _print($addon_prices);







                // $productOptionIds = $_SESSION['cart'][$key]['product_option_ids'];
                // $productOptionPrices = array();
                // foreach ($productOptionIds as $key2 => $value) {
                //     array_push($productOptionPrices, getProductOptionPriceFromOptionId($productOptionIds[$key2]));
                // }
                // $totalOptionPrice = array_sum($productOptionPrices);

                // $productAddonIds = $_SESSION['cart'][$key]['product_addon_ids'];
                // $productAddonPrices = array();
                // foreach ($productAddonIds as $key3 => $value) {
                //     array_push($productAddonPrices, getProductAddonPriceFromAddonId($productAddonIds[$key3]));
                // }
                // $totalProductAddonPrice = array_sum($productAddonPrices);

                // $subCategoryAddonIds = $_SESSION['cart'][$key]['sub_category_addon_ids'];
                // $subCategoryAddonPrices = array();
                // foreach ($subCategoryAddonIds as $key4 => $value) {
                //     array_push($subCategoryAddonPrices, getSubCategoryAddonPriceFromSubCategoryAddonId($productAddonIds[$key4]));
                // }
                // $totalSubCategoryAddonPrice = array_sum($subCategoryAddonPrices);



                $productUnitPrice = round($value['price'] / $value['quantity'], 2);
                $productQuantity = $value['quantity'];
                $productTotalPrice = $value['price'];
                // $perUnitProductionCost = round(getProductionCostPerUnitOfSessionProductFromId($value['product_id']), 3);
                // $totalProductionCost = round(($perUnitProductionCost * $productQuantity), 3);

                // $productOptionIds2 = serialize($productOptionIds);
                // $productOptionPrices2 = serialize($productOptionPrices);
                // $productAddonIds2 = serialize($productAddonIds);
                // $productAddonPrices2 = serialize($productAddonPrices);
                // $subCategoryAddonIds2 = serialize($subCategoryAddonIds);
                // $subCategoryAddonPrices2 = serialize($subCategoryAddonPrices);

                // $sql = "INSERT INTO `order_items` (`branch_id`, `sub_branch_id`, `unique_order_id`, `product_id`, `product_size_id`, `base_price`, `product_option_ids`, `product_option_prices`, `total_option_price`, `product_addon_ids`, `product_addon_prices`, `total_addon_price`, `sub_category_addon_ids`, `sub_category_addon_prices`, `total_sub_category_addon_price`, `product_unit_price`, `product_quantity`, `product_total_price`, `per_unit_production_cost`, `total_production_cost`, `created_by`) VALUES ('$branchId', '$subBranchId', '$uniqueOrderId', '$productId', '$productSizeId', '$basePrice', '$productOptionIds2', '$productOptionPrices2', '$totalOptionPrice', '$productAddonIds2', '$productAddonPrices2', '$totalProductAddonPrice', '$subCategoryAddonIds2', '$subCategoryAddonPrices2', '$totalSubCategoryAddonPrice', '$productUnitPrice', '$productQuantity', '$productTotalPrice', '$perUnitProductionCost', '$totalProductionCost', '$clientId')";

                // $con->query($sql);

                $orderItem = new OrderItem;
                $orderItem->unique_order_id = $uniqueOrderId;
                $orderItem->product_id = $productId;
                $orderItem->product_size_id = $productSizeId;
                $orderItem->base_price = $basePrice;
                $orderItem->product_quantity = $productQuantity;
                $orderItem->product_total_price = $productTotalPrice;
                $orderItem->product_unit_price = $productUnitPrice;
                $orderItem->product_option_ids = implode(',',$option_ids);
                $orderItem->product_option_prices = implode(',',$option_prices);
                $orderItem->total_option_price = array_sum($option_prices);
                $orderItem->product_addon_ids = implode(',',$addon_ids);
                $orderItem->product_addon_prices = implode(',',$addon_prices);
                $orderItem->total_addon_price = array_sum($addon_prices);
                $orderItem->save();
            }
        }

        // if ($tableId == 0) {
        //     updateOrderProcess($branchId, $subBranchId, $uniqueOrderId, '2', '0');
        // }



        return $uniqueOrderId;
    }

    public function sslCheckout($uniqueOrderId, $data)
    {
        // $orderProcessTableDetails = getOrderProcessDetailsFromUniqueOrderId($uniqueOrderId);
        /* PHP */
        $post_data = array();
        $post_data['store_id'] = "konacafebdlive";
        $post_data['store_passwd'] = "602CEC70B0BA227938";
        $post_data['currency'] = "BDT";
        $post_data['tran_id'] = "SSLCZ_TEST_" . $uniqueOrderId;
        $post_data['success_url'] = route('online_payment_success', $uniqueOrderId); //"http://localhost/new_sslcz_gw/success.php";
        $post_data['fail_url'] = "http://konacafebd.com/erp/ssl/fail.php";
        $post_data['cancel_url'] = "http://konacafebd.com/erp/ssl/cancel.php";
        # $post_data['multi_card_name'] = "mastercard,visacard,amexcard";  # DISABLE TO DISPLAY ALL AVAILABLE


        # PRODUCT INFORMATION

        $serviceChargePercentage = getValueFromExtraTableByItemName("service_charge"); //$_REQUEST['seviceChargePercentage'];
        $taxPercentage = getValueFromExtraTableByItemName("VAT"); //$_REQUEST['taxPercentage'];


        $totalItems = totalCartItem();
        $cartTotalBill = totalCartPrice();
        $basicTotalBill = basePriceFromFinalBill($cartTotalBill, $serviceChargePercentage, $taxPercentage);
        $serviceCharge = totalServiceChargeFromFinalBill($cartTotalBill, $serviceChargePercentage, $taxPercentage); //totalServiceCharge($basicTotalBill, $serviceChargePercentage);
        //$beforeTax = $basicTotalBill + $serviceCharge;
        $tax = totalVatFromFinalBill($cartTotalBill, $taxPercentage); //totalTax($beforeTax, $taxPercentage);

        $deliveryCharge = $discountAmount = 0;

        if (isset($data['deliveryCharge']))
            $deliveryCharge = $data['deliveryCharge'];

        if (isset($data['discountAmount']))
            $discountAmount = $data['discountAmount'];

        $totalBill = (grandTotalFromBasicAmount($basicTotalBill, $serviceChargePercentage, $taxPercentage) + $deliveryCharge) - $discountAmount;

        $productNameForSsl = "";
        $productCategoryForSsl = "";
        foreach (cartItems() as $key => $value) {
            $productId = $value['product_id'];
            $productDetailsSsl = getProductDetailsFromId($productId);
            $productCategoryDetailsSsl = getProductCategoryDetailsFromId($productDetailsSsl['category_id']);

            if ($productNameForSsl != "") $productNameForSsl .= ", ";
            if ($productCategoryForSsl != "") $productCategoryForSsl .= " - ";
            $productNameForSsl .= $productDetailsSsl['name'];
            $productCategoryForSsl .= $productCategoryDetailsSsl['name'];
        }

        $post_data['product_name'] = $productNameForSsl;
        $post_data['product_category'] = $productCategoryForSsl;
        $post_data['product_profile'] = "Food Item";
        $post_data['total_amount'] = $totalBill;
        // $post_data['total_amount'] = 10;

        # EMI INFO
        $post_data['emi_option'] = "0"; // 1 for enabling emi option
        $post_data['emi_max_inst_option'] = "9";
        $post_data['emi_selected_inst'] = "9";

        # CUSTOMER INFORMATION
        $clientDetails = getClientDetailsFromUniqueOrderId($uniqueOrderId);

        // _print( $clientDetails,1);



        $post_data['cus_name'] = $clientDetails['name'];
        $post_data['cus_email'] = $clientDetails['email'];
        $post_data['cus_add1'] = $clientDetails['address'];
        $post_data['cus_add2'] = "";
        $post_data['cus_city'] = "";
        $post_data['cus_state'] = "";
        $post_data['cus_postcode'] = "";
        $post_data['cus_country'] = "Bangladesh";
        $post_data['cus_phone'] = $clientDetails['phone'];
        $post_data['cus_fax'] = "";

        # SHIPMENT INFORMATION
        $post_data['shipping_method'] = "NO";
        $post_data['ship_name'] = "Store Test";
        $post_data['ship_add1 '] = "Dhaka";
        $post_data['ship_add2'] = "Dhaka";
        $post_data['ship_city'] = "Dhaka";
        $post_data['ship_state'] = "Dhaka";
        $post_data['ship_postcode'] = "1000";
        $post_data['ship_country'] = "Bangladesh";


        # OPTIONAL PARAMETERS
        $post_data['value_a'] = $uniqueOrderId;
        $post_data['value_b '] = "ref002";
        $post_data['value_c'] = "ref003";
        $post_data['value_d'] = "ref004";

        # CART PARAMETERS
        $cart = array();
        $cartDetails = cartItems();
        foreach ($cartDetails as $key => $value) {
            $newItem = array(
                "product" => $cartDetails[$key]['product_name'],
                "quantity" => $cartDetails[$key]['quantity'],
                "amount" => $cartDetails[$key]['price']
            );
            array_push($cart, $newItem);
        }

        $post_data['cart'] = json_encode($cart);

        // $post_data['cart'] = json_encode(array(
        //     array("product" => "DHK TO BRS AC A1", "quantity" => "", "amount" => "200.00"),
        //     array("product" => "DHK TO BRS AC A2", "amount" => "200.00"),
        //     array("product" => "DHK TO BRS AC A3", "amount" => "200.00"),
        //     array("product" => "DHK TO BRS AC A4", "amount" => "200.00")
        // ));
        $post_data['product_amount'] = $totalBill;
        $post_data['vat'] = $tax;
        $post_data['discount_amount'] = $discountAmount;
        $post_data['convenience_fee'] = $deliveryCharge;


        # REQUEST SEND TO SSLCOMMERZ
        $direct_api_url = "https://securepay.sslcommerz.com/gwprocess/v4/api.php";

        $handle = curl_init();
        curl_setopt($handle, CURLOPT_URL, $direct_api_url);
        curl_setopt($handle, CURLOPT_TIMEOUT, 30);
        curl_setopt($handle, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($handle, CURLOPT_POST, 1);
        curl_setopt($handle, CURLOPT_POSTFIELDS, $post_data);
        curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, true); # KEEP IT FALSE IF YOU RUN FROM LOCAL PC


        $content = curl_exec($handle);

        $code = curl_getinfo($handle, CURLINFO_HTTP_CODE);

        if ($code == 200 && !(curl_errno($handle))) {
            curl_close($handle);
            $sslcommerzResponse = $content;
        } else {
            curl_close($handle);
            echo "FAILED TO CONNECT WITH SSLCOMMERZ API";
            exit;
        }

        # PARSE THE JSON RESPONSE
        $sslcz = json_decode($sslcommerzResponse, true);

        //print_r($sslcz);

        if (isset($sslcz['GatewayPageURL']) && $sslcz['GatewayPageURL'] != "") {
            # THERE ARE MANY WAYS TO REDIRECT - Javascript, Meta Tag or Php Header Redirect or Other
            # echo "<script>window.location.href = '". $sslcz['GatewayPageURL'] ."';</script>";
            echo "<meta http-equiv='refresh' content='0;url=" . $sslcz['GatewayPageURL'] . "'>";
            # header("Location: ". $sslcz['GatewayPageURL']);
            exit;
        } else {
            echo "JSON Data parsing error!";
        }
    }

    public function orderDetails($order_id){
        $orderitems = OrderItem::where('unique_order_id', $order_id)->get();

        return view("frontend.order_details", compact('orderitems'));
    }

    public function onlinePaymentSuccess(Request $request, $orderId){
        $orderProcess = OrderProcess::where('unique_order_id', $orderId)->first();
        $orderProcess->order_status = 2;
        $orderProcess->save();
        return "payment Successful";
    }
}
