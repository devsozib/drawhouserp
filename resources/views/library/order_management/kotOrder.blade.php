@extends('layout.app')
@section('title', 'Library | Order Management')
@section('content')

    <div class="content-header" style="height: 100vh;">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-right">Orders</h1>
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
                            <div class="row mb-3">
                                <div class="col-12 col-md-4 col-lg-2">
                                    <label for="concern">Concern</label>
                                    <select class="js-example-basic-single select2" name="concern" id="concern" >
                                        <option value="">-- Select --</option>
                                        @foreach ($companies as $company)
                                            <option value="{{ $company->id  }}">{{ $company->Name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-12 col-md-4 col-lg-2 align-items-center">
                                    <label for=""></label>
                                    <button class="btn btn-sm btn-primary" onclick="showOrders()">Show</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body" >
                    <div id="accordion">


                        <table class="table" style="">
                            <thead>
                              <tr>
                                @php
                                    $col = 9;
                                @endphp
                                <th scope="col" style="width:{{ 100/$col }}%;">Table</th>
                                <th scope="col" style="width:{{ 100/$col }}%;">Order Time</th>
                                <th scope="col" style="width:{{ 100/$col }}%;">Guest</th>
                                <th scope="col" style="width:{{ 100/$col }}%;">Serve By</th>
                                <th scope="col" style="width:{{ 100/$col }}%;">Total Amount</th>
                                <th scope="col" style="width:{{ 100/$col }}%;">Status</th>
                                <th scope="col" style="width:{{ 100/$col }}%;">Cooking Start</th>
                                <th scope="col" style="width:{{ 100/$col }}%;">Cooking End</th>
                                <th scope="col" style="width:{{ 100/$col }}%;">Action</th>
                              </tr>
                            </thead>
                            <tbody id="tableRow">



                            </tbody>
                        </table>


                    </div>
                </div>
            </div>

        </div>


        <script>
            function showOrders(){

                var concern = $("#concern").val();
                // var start_date = $("#start_date").val();
                // var end_date = $("#end_date").val();

                if(!concern){
                    alert('enter concern');
                }

                $.get('{{ route('get_kot_order_by_ajax') }}', {concern:concern}, function(data){
                    console.log(data);
                    $("#tableRow").html(data);
                });
            }

            function cookingStart(uniqueOrderId){
                var flag = true;
                $.get('{{ route('cooking_start_by_ajax') }}', {uniqueOrderId:uniqueOrderId,flag:flag}, function(data){
                    showOrders();
                });
            }

            function cookingEnd(uniqueOrderId){
                var flag = true;
                $.get('{{ route('cooking_end_by_ajax') }}', {uniqueOrderId:uniqueOrderId,flag:flag}, function(data){
                    showOrders();
                });
            }

        </script>

@stop
