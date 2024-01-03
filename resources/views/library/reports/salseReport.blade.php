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
                        <div class="card-body">
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
                                <div class="col-12 col-md-4 col-lg-2">
                                    <label for="start_date">Start Date</label><br>
                                    <input type="text" class="datepickerbs4v1 w-100" id="start_date" name="start_date" value="{{ date('Y-m-d') }}">
                                </div>
                                <div class="col-12 col-md-4 col-lg-2">
                                    <label for="end_date">End Date</label><br>
                                    <input type="text" class="datepickerbs4v1 w-100" id="end_date" name="end_date" value="{{ date('Y-m-d') }}">
                                </div>
                                <div class="col-12 col-md-4 col-lg-2 align-items-center">
                                    <label for="" style="display:block;"></label><br>
                                    <button class="btn btn-sm btn-primary" onclick="showOrders()">Show</button>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
{{--
            <div class="card">
                <div class="card-body" >
                    <div id="accordion">


                        <table class="table" style="">
                            <thead>
                              <tr>
                                @php
                                    $col = 6;
                                @endphp
                                <th scope="col" style="width:{{ 100/$col }}%;">Table</th>
                                <th scope="col" style="width:{{ 100/$col }}%;">Order Time</th>
                                <th scope="col" style="width:{{ 100/$col }}%;">Guest</th>
                                <th scope="col" style="width:{{ 100/$col }}%;">Serve By</th>
                                <th scope="col" style="width:{{ 100/$col }}%;">Total Amount</th>
                                <th scope="col" style="width:{{ 100/$col }}%;">Action</th>
                              </tr>
                            </thead>
                            <tbody id="tableRow">



                            </tbody>
                        </table>


                    </div>
                </div>
            </div> --}}

            {{-- <h1>Chart js</h1> --}}

            <div class="container-fluid" id="chart">

            </div>
        </div>




        <script>
            function showOrders(){

                var concern = $("#concern").val();
                var start_date = $("#start_date").val();
                var end_date = $("#end_date").val();

                if(!concern || !start_date || !end_date){
                    alert('enter concern and date range'); return;
                }

                $.get('{{ route('generate_sales_report_by_ajax') }}', {concern:concern,start_date:start_date,end_date:end_date}, function(data){
                    console.log(data);
                    $("#chart").html(data);
                    $('.js-example-basic-single').select2();
                });
            }

            function generateCategoryWisePaiChart(categoryId){
                // alert(categoryId);
                if(categoryId<0)return;
                var charts = document.getElementsByClassName('categoryWiseChart');
                for(var i = 0; i < charts.length; i++){
                    charts[i].style.display = 'none';
                }
                if( document.getElementById('categoryWiseChart'+categoryId))
                    document.getElementById('categoryWiseChart'+categoryId).style.display = '';

                var categoryList = document.getElementsByClassName('categoryList');
                for(var i = 0; i < categoryList.length; i++){
                    categoryList[i].style.backgroundColor = '#1452cac4';
                }
                document.getElementById('category'+categoryId).style.backgroundColor = '#03273ac2';
                document.getElementById('categoryName').innerHTML = document.getElementById('category'+categoryId).innerHTML;

            }
            function searchCategory(ele){
                var key = ele.value.trim().toLowerCase();
                var categoryList = document.getElementsByClassName('categoryList');

                for(var i = 0; i < categoryList.length; i++){
                    var categoryName = categoryList[i].innerHTML;
                    categoryName = categoryName.toLowerCase();

                    categoryList[i].style.display = 'none';
                    if (categoryName.includes(key)) {
                        categoryList[i].style.display = '';
                    }
                }
            }

        </script>



@stop
