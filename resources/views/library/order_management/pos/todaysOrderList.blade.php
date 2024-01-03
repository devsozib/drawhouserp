
@foreach ($orders as $order)
<tr style="margin:0; padding: 0;">
    <td colspan="8" class="m-0 p-0">
        <div class="card" style="border: 2px solid #14b293; margin: 2px;">
            <div class="card-header p-0 m-0" id="section{{ $order->id }}" style="background-color: #14b293; color:#fff !important;">
                <table class="table m-0 p-0" style="margin:0; padding: 0;">
                    <tbody style="">
                        <tr style="">
                            @php
                                $col = 9;
                            @endphp
                            <td style="width:{{ 100/$col }}%; ">{{ salesTypes()[$order->sales_type]}}</td>
                            <td style="width:{{ 100/$col }}%; ">{{ $order->isDelivered == 1 ? 'Yes': 'No'}}</td>
                            <td style="width:{{ 100/$col }}%; ">{{ isset($tables[$order->table_id]) ? $tables[$order->table_id] : 'N\A'}}</td>
                            <td style="width:{{ 100/$col }}%; ">{{ isset($rooms[$order->table_id]) ? $rooms[$order->table_id] : 'N\A'}}</td>
                            <td style="width:{{ 100/$col }}%; ">{{ $order->guest_name }}</td>
                            <td style="width:{{ 100/$col }}%; ">{{ $order->paid_amount }}</td>
                            <td colspan="2" style="width:{{ (100/$col)*3 }}%; " align="right">
                                <button class="btn btn-sm btn-primary m-0 p-1" style="background-color: #007bff; border-color: #007bff;" data-toggle="collapse" data-target="#collapse{{ $order->id }}" aria-expanded="true" aria-controls="collapse{{ $order->id }}">
                                    Details
                                </button>

                                <a href="{{ route('pos_kot', $order->unique_order_id) }}" target="_blank" class="btn btn-sm btn-primary  m-0 p-1" style="background-color: {{ $order->kot_status == 1 ? '#ffa259;' : '#007bff;' }} border-color: #007bff;">KOT</a>
                                <a href="javascript:void()" onclick="makeInvoice('{{ route('pos_invoice', $order->unique_order_id) }}', '{{ $order->unique_order_id }}')" target="_blank" class="btn btn-sm btn-primary  m-0 p-1" style="background-color: {{ $order->invoice_status == 1 ? '#ffa259;' : '#007bff;' }} border-color: #007bff;">Invoice</a>

                                @if($order->invoice_status != 1 && $order->order_status != 2)
                                    <a id="updateOrderBtn{{ $order->unique_order_id }}" href="javascript:void(0)" data-dismiss="modal" onclick="updateOrder('{{ $order->unique_order_id }}')" class="btn btn-sm btn-primary  m-0 p-1" style="background-color: #007bff; border-color: #007bff;">Update</a>
                                @endif
                                <button class="btn btn-sm btn-primary  m-0 p-1" style="background-color: {{ $order->order_status == 2 ? '#ffa259;' : '#007bff;' }}; border-color: #007bff;" data-toggle="collapse" data-target="#collapse{{ $order->id }}bill" aria-expanded="true" aria-controls="collapse{{ $order->id }}bill" {{ $order->order_status==2 ? 'disabled' : ''}}>
                                    Get Bill
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            {{-- show --}}
            <div id="collapse{{ $order->id }}" class="collapse " aria-labelledby="section{{ $order->id }}" data-parent="#accordion">
                <div class="card-body">
                    <table class="table" style="">
                        <thead>
                            <tr >
                                <th>Sl</th>
                                <th>Product</th>
                                <th>Quantity</th>
                                <th>Options</th>
                                <th>Addons</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orderDetails[$order->unique_order_id] as $details)
                                <tr style="border-bottom: 2px solid #000000;">
                                    <th>{{ $loop->index }}</th>
                                    <td>{{ $products[$details->product_id] }}</td>
                                    <td>{{ $details->product_quantity }}</td>
                                    <td>

                                        @php
                                            $option_txt = "";
                                            foreach (explode(',',$details->product_option_ids) as $optionId){
                                                if($option_txt != "") $option_txt .= ', ';
                                                $option_txt .= $optionId != "" ? $options[$optionId] : '';
                                            }
                                        @endphp
                                        {{ $option_txt }}
                                    </td>
                                    <td>

                                        @php
                                            $addon_txt = "";
                                            foreach (explode(',',$details->product_addon_ids) as $addonId){
                                                if($addon_txt != "") $addon_txt .= ', ';
                                                $addon_txt .= $addonId != "" ? $addons[$addonId] : '';
                                            }
                                        @endphp
                                        {{ $addon_txt }}
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>

            <div id="collapse{{ $order->id }}bill" class="collapse " aria-labelledby="section{{ $order->id }}bill" data-parent="#accordion">
                <div class="card-body {{ $order->paid_amount < 1 ? 'd-none':'' }}">
                    <div data-items="1" id="paymentList{{ $order->id }}">
                        <div class="row justify-content-center">
                            <div class="col-6 col-md-4 col-xl-2">
                                <div class="col-2"></div>
                                <label for=""> Pay Mode </label>
                            </div>
                            <div class="col-6 col-md-4 col-xl-2">
                                <label for=""> Amount</label>
                            </div>

                        </div>
                        <div class="row justify-content-center" id="method1">
                            <div class="col-6 col-md-4 col-xl-2">
                                <select onchange="rearengSplitBillMethod({{ $order->id }})" data-key="{{ $order->id }}-1" name="paymentMethod{{ $order->id }}_1" id="paymentMethod{{ $order->id }}_1" class="splitMathod{{ $order->id }} text-capitalize xsm-text d-inline-block font-weight-bold t-pt-5 t-pb-5 form-control rounded-0 text-center">
                                    <option value="" selected="">-Select-</option>
                                    @foreach ($paymentMethods as $paymentMethod)
                                        <option value="{{ $paymentMethod->id }}">{{ $paymentMethod->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-6 col-md-5 col-xl-2">
                                <input onchange="paymentAmountEntry('{{ $order->id }}',this,'{{ $order->paid_amount }}')" data-key="{{ $order->id }}-1" class="splitBill{{ $order->id }}" type="number" style="width: 80%;" min="0" id="amount{{ $order->id }}-1" value="" placeholder="{{ $order->paid_amount }}">
                                <button class="btn btn-sm btn-primary d-none" onclick="removePaymentWayItem('method1', {{ $order->id }}, {{ $order->paid_amount }})">X</button>
                            </div>
                        </div>
                    </div>

                    <div class="row justify-content-center">
                        <div class="col-6 mt-2" align="center">
                            <button id="splitBillAddBtn{{ $order->id }}" class="btn btn-sm btn-success" onclick="addNewPaymentway({{ $order->id }},{{ $order->branch_id }}, {{ $order->paid_amount }})" disabled>Add New</button>
                            <button id="splitBillSaveBtn{{ $order->id }}" class="btn btn-sm btn-success" onclick="saveOrderBill({{ $order->id }}, {{ $order->paid_amount }},'{{ $order->unique_order_id }}')" disabled>Save</button>
                        </div>
                    </div>
                    <p style="text-align:center; margin:0;" class="d-none"><span>Or</span></p>
                    <div class="row justify-content-center d-none">
                        <div class="col-6" align="center">
                            <button class="btn btn-sm btn-primary" onclick="Complimentary('{{ $order->unique_order_id }}')">Complimentary</button>
                        </div>
                    </div>

                    <br><p style="margin: 0; padding: 0; text-align:center; color:red;">For Cash Payment</p>
                    <div class="row justify-content-center" >
                        <div class="col-6 col-md-4 col-xl-2" style="border-left: 1px solid red; border-top: 1px solid red; border-bottom: 1px solid red;">
                            <label for="" style="color:red; font-size: 10px;">Received</label>
                            <input id="cash_received{{ $order->id }}" type="text" style="width: 80%;border:none; color:red;" min="0" value="" placeholder="0" disabled>
                        </div>

                        <div class="col-6 col-md-4 col-xl-2" style="border-right: 1px solid red; border-top: 1px solid red; border-bottom: 1px solid red;">
                            <label for="" style="color:red; font-size: 10px;">Changed</label>
                            <input id="cash_chenged{{ $order->id }}" type="text" style="width: 80%; border:none; color:red;" min="0" value="" placeholder="0" disabled>
                        </div>
                    </div>
                </div>
                <div class="card-body {{ $order->paid_amount < 1 ? '':'d-none' }}">
                    <div class="row justify-content-center ">
                        <div class="col-6" align="center">
                            <h6>The will be Complimentary</h6>
                            <button class="btn btn-sm btn-primary" onclick="Complimentary('{{ $order->unique_order_id }}')">Confirm</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </td>
</tr>
@endforeach

