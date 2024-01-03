
@foreach ($orders as $order)
<tr >
    <td colspan="8" class="m-0 p-0">
        <div class="card" style="border: 2px solid #14b293; margin: 2px;">
            <div class="card-header p-0 m-0" id="section{{ $order->id }}" style="background-color: #14b293; color:#fff;">
                <table class="table" style="">
                    <tbody>
                        <tr>
                            @php
                                $col = 8;
                            @endphp
                            <td style="width:{{ 100/$col }}%;">{{ isset($tables[$order->table_id]) ? $tables[$order->table_id] : 'Delivery' }}</td>
                            <td style="width:{{ 100/$col }}%;">{{ $order->order_time }}</td>
                            <td style="width:{{ 100/$col }}%;">{{ $order->guest_name }}</td>
                            <td style="width:{{ 100/$col }}%;">{{ $order->employee_name }}</td>
                            <td style="width:{{ 100/$col }}%;">{{ $order->paid_amount }}</td>
                            <td style="width:{{ 100/$col }}%;">{{ $order->order_status }}</td>
                            <td style="width:{{ 100/$col }}%;">
                                <input onclick="deliveried({{ $order->unique_order_id }})" type="checkbox" class="btn btn-sm btn-primary  m-0 p-1" style="height: 30px; width: 30px;">
                            </td>
                            <td style="width:{{ 100/$col }}%;">
                                    <button class="btn btn-sm btn-primary" data-toggle="collapse" data-target="#collapse{{ $order->id }}" aria-expanded="true" aria-controls="collapse{{ $order->id }}">
                                        Details
                                    </button>
                                {{-- <a href="{{ route('pos_kot', $order->unique_order_id) }}" target="_blank" class="btn btn-sm btn-primary  m-0 p-1" >KOT</a>
                                <a href="{{ route('pos_invoice', $order->unique_order_id) }}" target="_blank" class="btn btn-sm btn-primary  m-0 p-1" >Invoice</a> --}}
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
        </div>
    </td>
</tr>
@endforeach

