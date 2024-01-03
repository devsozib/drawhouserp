@extends('layout.app')
@section('title', 'Library | Company')
@section('content')
    @include('layout/datatable')

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"><small>Product Option Ingredient</small></h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{!! url('library/dashboard') !!}">Library</a></li>
                        <li class="breadcrumb-item"><a href="javascript::void(0)">Product Mangement</a></li>
                        <li class="breadcrumb-item"><a href="javascript::void(0)">Product Option Ingredient</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Index</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header with-border">
                        <h3 class="card-title text-center w-75">Add Option Ingredient
                            <span class="text-primary">{{ $product->name }}</span>
                        </h3>
                    </div>
                    <div class="card-body" style="overflow-x: scroll;">
                        <div class="row">
                            <div class="col-lg-12">
                                <form action="{{ route('prooptioning.store') }}" method="post"
                                    enctype="multipart/form-data">
                                    @if (!empty(Session::get('error_code')) && Session::get('error_code') == 'Add')
                                        @include('layout/flash-message')
                                    @endif
                                    @csrf
                                    {{-- {{ $errors }} --}}
                                    <div class="card-body">
                                        <input type="hidden" value="{{ $product->id }}" name="product_id">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="Name">Product Name</label>
                                                    <input type="text" value="{{ $product->name }}" readonly
                                                        class="form-control">
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="Name">Select Product Size</label>
                                                    </label>
                                                    <select name="sizeId" id="selectedSize"
                                                        onchange="getDataForProIng(this.value,{{ $product->id }})"
                                                        class="form-control">
                                                        <option value="" selected disabled hidden>--Select
                                                            One--</option>
                                                        @foreach ($sizes as $item)
                                                            <option value="{{ $item->id }}">{{ $item->size_name }}
                                                            </option>
                                                        @endforeach

                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="Name">Select Product Option Title</label>
                                                    </label>
                                                    <select name="option_title_id" id="optionTitles" class="form-control">
                                                        <option value="">--Select Option Title--</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="Name">Select Product Option</label>
                                                    </label>
                                                    <select name="option_id" id="proOptions" class="form-control ">
                                                        <option value="">--Select Option--</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="Name">Select Ingredient</label>
                                                    </label>
                                                    <select name="ingredient_id" id="ingredients"
                                                        class="form-control select2bs4">
                                                        <option value="">--Select Ingredient--</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="Name">Ingredient Amount</label>
                                                    <input type="number" name="amount" placeholder="Ingredient Amoun"
                                                        class="form-control" value="{{ old('amount') }}">
                                                </div>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-success float-right">Submit</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header with-border">
                        <h3 class="card-title w-75">Add Product Addon</h3>
                    </div>
                    <div class="card-body">
                        Are you want to add Product Addon for <span class="text-primary">{{ $product->name }}</span>
                        addons?<br />
                        <a href="{{ route('proaddon.indx', $product->id) }}" class="btn btn-primary mt-2">Click
                            Here</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header with-border">
                        <h3 class="card-title text-center w-75">Product Options Ingredients</h3>
                    </div>
                    <div class="card-body" style="overflow-x: scroll;">
                        <div class="row">
                            <div class="col-lg-12">
                                <div style="min-height: 400px;">
                                    <table class="table table-bordered table-striped datatbl" id="branchTable">
                                        <thead>
                                            <tr>
                                                <th>Sl No</th>
                                                <th>Ingredient Name</th>
                                                <th>Amount </th>
                                                <th>Unit</th>
                                                <th>Option</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        $('#start_date').dateTimePicker({
            mode: 'dateTime',
            format: 'yyyy-MM-dd HH:mm:ss'
        });
        $('#end_date').dateTimePicker({
            mode: 'dateTime',
            format: 'yyyy-MM-dd HH:mm:ss'
        });
        $('#u_start_date').dateTimePicker({
            mode: 'dateTime',
            format: 'yyyy-MM-dd HH:mm:ss'
        });
        $('#u_end_date').dateTimePicker({
            mode: 'dateTime',
            format: 'yyyy-MM-dd HH:mm:ss'
        });

        function getDataForProIng(id, productId) {
            var selectedSize = id;
            var productId = productId;
            if (selectedSize && productId) {
                $.ajax({
                    url: '{{ url('getprooptioningdata') }}',
                    type: 'GET',
                    // dataType: 'json',
                    data: {
                        'selectedSizeId': selectedSize,
                        'productId': productId
                    },
                    success: function(data) {
                        console.log(data);
                        $('#optionTitles').empty();
                        $('#optionTitles').append(
                            '<option selected value="">--Select Option Title--</option>');
                        $.each(data[0], function(index, ingItem) {
                            $('#optionTitles').append('<option value="' +
                                ingItem.id + '">' + ingItem.title + '</option>');
                        });

                        $('#proOptions').empty();
                        $('#proOptions').append(
                            '<option selected value="">--Select Option--</option>');
                        $.each(data[1], function(index, ingItem) {
                            $('#proOptions').append('<option value="' +
                                ingItem.id + '">' + ingItem.name + '</option>');
                        });

                        $('#ingredients').empty();
                        $('#ingredients').append(
                            '<option selected value="">--Select Ingredient--</option>');
                        $.each(data[2], function(index, ingItem) {
                            $('#ingredients').append('<option value="' +
                                ingItem.id + '">' + ingItem.name + '(' + ingItem
                                .unit_name + ')' +
                                '</option>');
                        });
                        $('#branchTable').html(data[3]);
                        if ($.fn.DataTable.isDataTable("#branchTable")) {
                            $('#branchTable').DataTable().clear().destroy();
                        }
                    }
                });
            } else {
                $('#optionTitles').empty();
                $('#optionTitles').append('<option value="">--Select Option Title--</option>');

                $('#proOptions').empty();
                $('#proOptions').append('<option value="">--Select Option--</option>');

                $('#ingredients').empty();
                $('#ingredients').append('<option value="">--Select Ingredient--</option>');
            }
        }
    </script>
@stop
