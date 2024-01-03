@extends('layout.app')
@section('title', 'Library | Company')
@section('content')
    @include('layout/datatable')

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"><small>Product Addon Ingredients of <span
                                class="text-primary">{{ $product->name }}</span></small>
                    </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{!! url('library/dashboard') !!}">Library</a></li>
                        <li class="breadcrumb-item"><a href="javascript::void(0)">Product Mangement</a></li>
                        <li class="breadcrumb-item"><a href="javascript::void(0)">Product Addon Ingredients</a>
                        </li>
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
                        <h3 class="card-title text-center w-75">Add Product Addon ingredient</h3>
                    </div>
                    <div class="card-body" style="overflow-x: scroll;">
                        <div class="row">
                            <div class="col-lg-12">
                                <form action="{{ route('proaddoning.store') }}" method="post"
                                    enctype="multipart/form-data">
                                    @if (!empty(Session::get('error_code')) && Session::get('error_code') == 'Add')
                                        @include('layout/flash-message')
                                    @endif
                                    @csrf
                                    {{-- {{ $errors }} --}}
                                    <div class="card">
                                        <div class="card-body">
                                            <input type="hidden" value="{{ $product->id }}" name="product_id">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="Name">Product Name</label>
                                                        <input type="text" value="{{ $product->name }}" readonly
                                                            class="form-control">
                                                    </div>
                                                </div>

                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="Name">Select Product Addon</label>
                                                        </label>
                                                        <select name="addonId" id="selectedAddon" class="form-control">
                                                            <option value="" selected disabled hidden>--Select
                                                                One--</option>
                                                            @foreach ($productAddons as $item)
                                                                <option value="{{ $item->id }}">{{ $item->name }}
                                                                </option>
                                                            @endforeach

                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="Name">Select An Ingredient</label>
                                                        </label>
                                                        <select name="ingredient_id" id="ingredientItems"
                                                            class="form-control select2bs4">
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="Name">Ingredient Amount</label>
                                                        </label>
                                                        <input type="number" name="amount" class="form-control">
                                                    </div>
                                                </div>


                                            </div>
                                            <button type="submit" class="btn btn-success float-right">Submit</button>
                                        </div>
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
                        <h3 class="card-title w-75">Finished?</h3>
                    </div>
                    <div class="card-body">
                        <br />
                        <a href="{{ route('products.index') }}" class="btn btn-primary mt-2">Products</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header with-border">
                        <h3 class="card-title text-center w-75">Product Addons Ingredient List</h3>
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
        $(document).ready(function() {
            $('#selectedAddon').on('change', function() {
                var selectedAddonId = $(this).val();
                if (selectedAddonId) {
                    $.ajax({
                        url: '{{ url('productaddoning') }}',
                        type: 'GET',
                        // dataType: 'json',
                        data: {
                            'selectedAddonId': selectedAddonId
                        },
                        success: function(data) {
                            // console.log(data);
                            $('#ingredientItems').empty();
                            $('#ingredientItems').append(
                                '<option selected value="">--Select Ingredient--</option>');
                            $.each(data[0], function(index, ingItem) {
                                $('#ingredientItems').append('<option value="' +
                                    ingItem.id + '">' + ingItem.name + '(' + ingItem
                                    .unit_name + ')' +
                                    '</option>');
                            });
                            $('#branchTable').html(data[1]);
                            if ($.fn.DataTable.isDataTable("#branchTable")) {
                                $('#branchTable').DataTable().clear().destroy();
                            }
                        }
                    });
                } else {
                    $('#ingredientItems').empty();
                    $('#ingredientItems').append('<option value="">--Select Ingredient--</option>');
                }
            });
        });
    </script>
@stop
