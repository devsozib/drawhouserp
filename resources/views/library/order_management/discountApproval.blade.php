@extends('layout.app')
@section('title', 'Library | Order Management')
@section('content')

    <div class="content-header" style="height: 100vh;">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-right">Discount Approval</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{!! url('library/dashboard') !!}">Library</a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Order management</a></li>
                        <li class="breadcrumb-item"><a href="{!! url('library/order_management/pos-order') !!}">Pos Order</a></li>
                    </ol>
                </div>
            </div>
        </div>

        <div class="content">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body" >
                            <h5>Customer profile</h5>
                           <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Sl</th>
                                            <th>Name</th>
                                            <th>Phone</th>
                                            <th>Discount Category</th>
                                            <th>Amount</th>
                                            <th>Not Approved</th>
                                            <th>Approved</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($customers as $customer)
                                            <tr id="customer{{ $customer->id }}">
                                                <td>{{ $loop->index + 1 }}</td>
                                                <td>{{ $customer->name }}</td>
                                                <td>{{ $customer->phone }}</td>
                                                <td>{{ $discountCategories[$customer->discount_category]->category_name }}</td>
                                                <td>{{ $discountCategories[$customer->discount_category]->amount }} {{ $discountCategories[$customer->discount_category]->discount_type == 2 ? '%' : '' }}</td>
                                                <td>
                                                    <a onclick="approvalStatus('customer', {{ $customer->id }}, 1)" href="javascript:void(0)" class="forwarding">
                                                        <img style="width:25px" id="forwarding-image-1" src="{{ asset('images/cross.png') }}" title="Forwarded" alt="Forwarded">
                                                    </a>
                                                </td>
                                                <td>
                                                    <a onclick="approvalStatus('customer', {{ $customer->id }}, 2)" href="javascript:void(0)" class="forwarding">
                                                        <img style="width:30px" id="forwarding-image-1" src="{{ asset('images/tick.png') }}" title="Forwarded" alt="Forwarded">
                                                    </a>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                           </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body" >
                    <h5>Order Discount</h5>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Sl</th>
                                    <th>Order ID</th>
                                    <th>Customer Name</th>
                                    <th>Customer Phone</th>
                                    <th>Total Bill</th>
                                    <th>Discount Category</th>
                                    <th>Amount</th>
                                    <th>Not Approved</th>
                                    <th>Approved</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($orders as $order)
                                    <tr id="order{{ $order->id }}">
                                        <td>{{ $loop->index + 1 }}</td>
                                        <td>{{ $order->unique_order_id }}</td>
                                        <td>{{ $order->name }}</td>
                                        <td>{{ $order->phone }}</td>
                                        <td>{{ $order->total_bill }}</td>
                                        <td>{{ $discountCategories[$order->discount_category]->category_name }}</td>
                                        <td>{{ $discountCategories[$order->discount_category]->amount }} {{ $discountCategories[$order->discount_category]->discount_type == 2 ? '%' : '' }}</td>
                                        <td>
                                            <a onclick="approvalStatus('order', {{ $order->id }}, 1)" href="javascript:void(0)" class="forwarding">
                                                <img style="width:25px" id="forwarding-image-1" src="{{ asset('images/cross.png') }}" title="Forwarded" alt="Forwarded">
                                            </a>
                                        </td>
                                        <td>
                                            <a onclick="approvalStatus('order', {{ $order->id }}, 2)" href="javascript:void(0)" class="forwarding">
                                                <img style="width:30px" id="forwarding-image-1" src="{{ asset('images/tick.png') }}" title="Forwarded" alt="Forwarded">
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>


        <script>
            function approvalStatus(type, id, status){
                if(status==1 && !confirm('Are you sure to reject discount approval?')){
                    return;
                }
                else if(status==2 && !confirm('Are you sure to accept discount approval?')){
                    return;
                }

                var _token =  '{{ csrf_token() }}';

                $.post('{{ route('update_discount_approval_status_by_ajax') }}', {type:type,id:id,status:status,_token:_token}, function(data){
                    var ele = document.getElementById(type+id);
                    ele.remove();
                    alert("Updated");
                });

            }
        </script>

@stop
