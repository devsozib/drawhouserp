

@php
    $totalPrice = 0;
    $text = "";
    if($tableOrRoom == 1) $text = "table ";
    if($tableOrRoom == 2) $text = "room ";
@endphp

    @if(count($items)>0 || $isUpdate)
        <h6>Selected product list for <b style="color: #f64e60;">{{ isset($tables[$table]) ? $text.$tables[$table] : 'delivery' }}</b></h6>
        <table class="table" style="font-size: 12px; width:100%;">
            <tbody>
            @foreach ($items as $key => $item)
                @php
                    $totalPrice += ($prices[$item['size']] * $item['quantity']);
                @endphp
                <tr >
                    <td style="margin:0; padding:0; border:2px solid #f64e60; border-bottom:none; ">
                        <table style="width:100%; border:none;">
                            <tr >
                                <th style="width:3%; border:none; text-align:center;">{{ $key+1 }}</th>
                                <td style="padding:8px; border:none; border-left:1px solid #000000;">
                                    <b>{{ $products[$item['product']] }}</b>
                                    <br>
                                    <span>Size: {{ $sizes[$item['size']] }} (<b style="color: #f64e60;">৳{{ $prices[$item['size']] }}</b>)</span>
                                </td>
                                <th style="width:3%; text-align:center; border:none; vertical-align: top;">
                                    <span onclick="removeItemFromtable({{ $key }})" class="text-center" style="cursor: pointer; background-color: #f64e60; color: #fff; border-radius: 50%; display: inline-block; width: 20px; height: 20px; text-align: center; line-height: 20px;">x</span>
                                </th>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr >
                    <td style="margin:0; padding:0; border:2px solid #f64e60; border-top:1px solid #000;">
                        <table style="width:100%; border:none;">
                            <tr >
                                @php
                                    if($item['option'] != null){
                                        $totalPrice += $option_prices[$item['option']] * $item['quantity'];
                                    }
                                @endphp
                                <td style="padding:8px; width:40%; border:none; vertical-align: top;">
                                    <b>Option:</b><br>
                                    <span>{{ $item['option'] != null ? $options[$item['option']].'('.$option_prices[$item['option']].')' : 'N/A' }}</span>
                                </td>
                                <td style="width:40%; border:none; border-left:1px solid #000; vertical-align: top;">
                                    <b>Addons:</b> <br>
                                    @php $ck = 0; @endphp
                                    @foreach (explode(',',$item['addons']) as $addon)
                                        @if( $addon)
                                        <span>{{ $addons[$addon].'('.$addon_prices[$addon].')' }}</span><br>
                                        @php
                                            $totalPrice += $addon_prices[$addon] * $item['quantity'];
                                            $ck = 1;
                                        @endphp
                                        @endif
                                    @endforeach
                                    {{ !$ck ? 'N/A' : ''  }}
                                </td>
                                <td style="20%; border:none; border-left:1px solid #000; text-align:center;">
                                    <input onchange="changeItemQuantity({{ $key }}, this)" min="1" type="number" style="width: 80%;" value="{{ $item['quantity'] }}">
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td style="border:none; height: 10px;"></td>
                </tr>
            @endforeach
            @php
                $grandTotal = $totalPrice;
                $serviceChargePercentage = getValueFromExtraTableByItemName("service_charge"); //$_REQUEST['seviceChargePercentage'];
                $taxPercentage = getValueFromExtraTableByItemName("VAT"); //$_REQUEST['taxPercentage'];
                $totalPrice = basePriceFromFinalBill($grandTotal, $serviceChargePercentage, $taxPercentage);
                $serviceCharge = totalServiceCharge($totalPrice, $serviceChargePercentage);
                $beforeVat = $totalPrice + $serviceCharge;
            @endphp
            </tbody>
        </table>

        <div class="col-12 text-center border-right">
            <div class="row g-0">
                <div class="col-3">
                    <span class="text-capitalize xsm-text d-inline-block font-weight-bold t-pt-5 t-pb-5">
                        Sub Total
                    </span>
                </div>

                <div class="col-3">
                    <span class="text-capitalize xsm-text d-inline-block font-weight-bold t-pt-5 t-pb-5">
                        Service Charge
                    </span>
                </div>

                <div class="col-3">
                    <span class="text-uppercase xsm-text d-inline-block font-weight-bold t-pt-5 t-pb-5">
                        VAT ({{ $taxPercentage }}%)
                    </span>
                </div>

                <div class="col-3">
                    <span class="text-uppercase xsm-text d-inline-block font-weight-bold t-pt-5 t-pb-5">
                        Grand Total
                    </span>
                </div>

                <div class="col-3">
                    <span class="text-capitalize xsm-text d-inline-block font-weight-bold t-pt-5 t-pb-5">
                        ৳<span id="sub_total_txt">{{ round($totalPrice, 2) }}</span>
                    </span>
                </div>
                <div class="col-3">
                    <span class="text-capitalize xsm-text d-inline-block font-weight-bold t-pt-5 t-pb-5">
                        ৳ <span id="service_charge_txt">{{ round($serviceCharge, 2) }}</span>
                    </span>
                </div>
                <div class="col-3">
                    <span class="text-capitalize xsm-text d-inline-block font-weight-bold t-pt-5 t-pb-5">
                        ৳ <span id="vat_txt">{{ round(totalTax($beforeVat, $taxPercentage), 2) }}</span>                                   </span>
                </div>
                <div class="col-3">
                    <span class="text-capitalize xsm-text d-inline-block font-weight-bold t-pt-5 t-pb-5">
                        ৳ <span id="grandTotal">{{ round($grandTotal, 2) }}</span>
                    </span>
                </div>
            </div>

            <div class="row g-0">
                <div class="col-6">
                    <span class="text-uppercase xsm-text d-inline-block font-weight-bold t-pt-5 t-pb-5">
                        Discount
                    </span>
                </div>
                <div class="col-6">
                    <span class="text-capitalize xsm-text d-inline-block font-weight-bold t-pt-5 t-pb-5">
                        Delivery Charge
                    </span>
                </div>

                <div class="col-4">
                    <select onchange="selectDiscountCategory(this)"  name="discountCategory" id="discountCategory" class="text-capitalize xsm-text d-inline-block font-weight-bold t-pt-5 t-pb-5 form-control rounded-0 text-center">
                        <option value="">--Select--</option>
                        @foreach ($discountCategories as $category)
                            <option value="{{ $category->id }}" data-type="{{ $category->discount_type }}" data-amount="{{ $category->amount }}">{{ $category->category_name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-2">
                    <input id="discountCategoryAmount" type="text" step="1" min="0" class="text-capitalize xsm-text d-inline-block font-weight-bold t-pt-5 t-pb-5 form-control rounded-0 text-center" value="0" disabled>
                </div>


                <div class="col-3 d-none">
                    <select onchange="discountAndDelivery()" name="discountType" id="discountType" class="text-capitalize xsm-text d-inline-block font-weight-bold t-pt-5 t-pb-5 form-control rounded-0 text-center">
                        @foreach (discountCategory() as $key => $cetegory)
                            <option value="{{ $key }}">{{ $cetegory }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-3 d-none">
                    <input type="number" step="1" min="0" class="text-capitalize xsm-text d-inline-block font-weight-bold t-pt-5 t-pb-5 form-control rounded-0 text-center" value="0" id="discountAmount"  oninput="discountAndDelivery(this.value)">
                </div>

                <div class="col-6">
                    <input onkeyup="discountAndDelivery()" type="number" style="width: 80%;"  class="text-center" min="0" id="deliveryCharge" value="">
                    {{-- <select name="payment_way" onchange="payment_way(this.value)" id="payment_way" class="text-capitalize xsm-text d-inline-block font-weight-bold t-pt-5 t-pb-5 form-control rounded-0 text-center">
                        <option value="one_way">One Way</option>
                        <option value="partial">Partial</option>
                    </select> --}}
                </div>


            </div>



            <div class="row mt-2" style="background-color: #f64e60;">
                <div class="col-6">
                    <span class="text-capitalize font-weight-bold text-light d-block t-pt-8 t-pb-10">
                        Total Bill
                    </span>
                </div>
                <div class="col-6 text-right">
                    <input type="hidden" name="totalBill" id="totalBill" value="0">
                    <input type="hidden" name="shownBillDis" id="shownBillDis">
                    <span class="text-capitalize font-weight-bold text-light d-block t-pt-8 t-pb-10">
                        ৳ <span id="shownBill">{{ round($grandTotal, 2) }}</span>
                    </span>
                </div>
            </div>

            <div class="row g-0 align-items-center t-mt-10">
                <div class="col-12">
                    <div class="d-flex justify-content-end align-items-center">
                        <div class="t-mr-8">
                            <button id="doneOrderBtn" type="button" class="btn {{ $isUpdate ? 'btn-warning' : 'btn-success' }}  sm-text text-uppercase font-weight-bold finishingButtons" onclick="doneOrder({{ $isUpdate }});">
                                {{ $isUpdate ? 'Update' : 'Done Order' }}
                            </button>

                            <button type="button" class="btn btn-primary sm-text text-uppercase font-weight-bold finishingButtons" onclick="cancelOrder();">
                                Cancel
                            </button>
                        </div>
                        {{-- <div class="t-mr-8">
                            <button type="button" class="btn btn-secondary sm-text text-uppercase font-weight-bold finishingButtons" onclick="finalFunctions('print');">
                                Print
                            </button>
                        </div>
                        <div>

                            <button type="button" class="btn btn-success sm-text text-uppercase font-weight-bold finishingButtons" onclick="finalySaveOrder();">
                                Save, Bill &amp; Clear
                            </button>
                        </div> --}}
                    </div>
                </div>
            </div>


        </div>
    @else
        <h6>Selected product list</b></h6>
    @endif
