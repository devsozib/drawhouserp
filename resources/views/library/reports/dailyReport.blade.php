@extends('layout.app')
@section('title', 'Library | Order Management')
@section('content')

    <div class="content-header d-print-none">
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
    </div>
        <div class="content">
            <div class="row d-print-none">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <form class="d-flex">
                                <div class="input-group">

                                    <select class="form-control js-example-basic-single select2" name="concern" id="concern" disabled>
                                        <option value="">-- Select --</option>
                                        @foreach ($companies as $company)
                                            <option value="{{ $company->id }}" {{ $company_id == $company->id ? 'selected':'' }}>{{ $company->Name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="input-group ml-3">
                                    <input type="text" class="form-control datepickerbs4v1" id="start_date" name="start_date" value="{{ date('Y-m-d') }}">
                                </div>
                                <div class="input-group ml-3">
                                    <input type="text" class="form-control datepickerbs4v1" id="end_date" name="end_date" value="{{ date('Y-m-d') }}">
                                </div>
                                <div class="ml-3">
                                    <button type="button" onclick="showOrders()" class="btn btn-sm btn-primary">Show</button>
                                </div>
                            </form>
                        </div>


                    </div>
                </div>
            </div>

            <div class="container-fluid " style="margin-top: 10px;" id="chart">

            </div>
        </div>




    <script>
        $(document).ready(function(){
            showOrders();
        });
        function showOrders(){

            var concern = $("#concern").val();
            var start_date = $("#start_date").val();
            var end_date = $("#end_date").val();

            if(!concern || !start_date || !end_date){
                alert('enter concern and date range');
            }

            $.get('{{ route('generate_daily_sales_report_by_ajax') }}', {concern:concern,start_date:start_date,end_date:end_date}, function(data){
                console.log(data);
                $("#chart").html(data);
                if(start_date==end_date){
                    $("#report_type").html("(Daily Sales report)");
                    $("#date_range").html("Date: "+start_date);
                }else{
                    $("#report_type").html("(Sales report)");
                    $("#date_range").html("Date: "+start_date+' to '+end_date);
                }

            });
        }

    </script>



@stop
