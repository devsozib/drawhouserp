@extends('layout.app')
@section('title', 'Library | Company')
@section('content')
    @include('layout/datatable')

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"><small>Product Option</small></h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{!! url('library/dashboard') !!}">Library</a></li>
                        <li class="breadcrumb-item"><a href="javascript::void(0)">Product Mangement</a></li>
                        <li class="breadcrumb-item"><a href="javascript::void(0)">Product Option</a></li>
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
                        <h3 class="card-title text-center w-75">Add Option
                            <span class="text-primary">{{ $product->name }}</span>
                        </h3>
                    </div>
                    <div class="card-body" style="overflow-x: scroll;">
                        <div class="row">
                            <div class="col-lg-12">
                                <form action="{{ route('prooption.store') }}" method="post" enctype="multipart/form-data">
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
                                                        onchange="getProOptionTitle(this.value,{{ $product->id }})"
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
                                                    <select  onchange="getProOptions(this.value,{{ $product->id }})" name="option_title_id" id="optionTitles" class="form-control">
                                                        <option value="">--Select Option Title--</option>
                                                    </select>
                                                </div>
                                            </div>


                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="Name">Option Name</label>
                                                    <input type="text" name="name" placeholder="Option name"
                                                        class="form-control" value="{{ old('name') }}">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="Name">Extra Price
                                                    </label>
                                                    <input type="number" placeholder="Extra Price" name="ex_price"
                                                        class="form-control" value="{{ old('ex_price') }}">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="Name">Offer Price
                                                    </label>
                                                    <input type="number" placeholder="Offer Price" name="off_price"
                                                        class="form-control" value="{{ old('off_price') }}">
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="Name">Offer Start
                                                        Date
                                                    </label>
                                                    <input type="text" name="start_date" placeholder="Start Date"
                                                        id="u_start_date" class="form-control"
                                                        value="{{ old('start_date') }}">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="Name">Offer End
                                                        Date
                                                    </label>
                                                    <input type="text" placeholder="End Date" name="end_date"
                                                        id="u_end_date" class="form-control" value="{{ old('end_date') }}">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="C4S">Status</label>
                                                    <div class="controls">
                                                        <select name="status" id="" class="form-control">
                                                            <option value="" selected disabled hidden>--Select
                                                                One--</option>
                                                            <option value="1">Active</option>
                                                            <option value="0">Inactive</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="Name">Addon Image
                                                    </label>
                                                    <input type="file" class="form-control" name="image"
                                                        id="file-input">
                                                </div>
                                            </div>
                                            <div class="col-md-4 d-none" id="image_sec">
                                                <div class="form-group">
                                                    {{-- <label for="Name">Ingredient Image</label> --}}
                                                    <img style="width:200px; border-radius:10px" id="image-preview"
                                                        src="#" alt="Preview">
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
                        <h3 class="card-title w-75">Add Product Option Ingredient</h3>
                    </div>
                    <div class="card-body">
                        Are you want to add product option ingredient for <span
                            class="text-primary">{{ $product->name }}</span>
                        addons?<br />
                        <a href="{{ route('prooptioning.indx', $product->id) }}" class="btn btn-primary mt-2">Click
                            Here</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header with-border">
                        <h3 class="card-title text-center w-75">Product Options</h3>
                    </div>
                    <div class="card-body" style="overflow-x: scroll;">
                        <div class="row">
                            <div class="col-lg-12">
                                <div style="min-height: 400px;">
                                    <table class="table table-bordered table-striped datatbl" id="branchTable">
                                        <thead>
                                            <tr>
                                                <th>Sl No</th>
                                                <th>Image</th>
                                                <th>Option Name</th>
                                                <th>Title Name</th>
                                                <th>Extra Price</th>
                                                <th>Offer Price</th>
                                                <th>Offer Price Starts</th>
                                                <th>Offer Price Ends</th>
                                                <th>Status</th>
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

        function getProOptionTitle(id, productId) {
        var selectedSize = id;
        var productId = productId;
        if (selectedSize && productId) {
            $.ajax({
                url: '{{ url('getprooptiontitle') }}',
                type: 'GET',
                // dataType: 'json',
                data: {
                    'selectedSizeId': selectedSize,
                    'productId': productId
                },
                success: function(data) {
                    console.log(data[0]);
                    $('#optionTitles').empty();
                    $('#optionTitles').append(
                        '<option selected value="">--Select Option Title--</option>');
                    $.each(data[0], function(index, ingItem) {
                        $('#optionTitles').append('<option value="' +
                            ingItem.id + '">' + ingItem.title + '</option>');
                    });                       
                }
            });
        } else {
            $('#optionTitles').empty();
            $('#optionTitles').append('<option value="">--Select Option Title--</option>');
        }
    }

    //Get Product OPtion
    function getProOptions(title_id, productId) {
        var title_id = title_id;
        var productId = productId;
        if (title_id && productId) {
            $.ajax({
                url: '{{ url('getprooptions') }}',
                type: 'GET',
                // dataType: 'json',
                data: {
                    'option_title_id': title_id,
                    'productId': productId
                },
                success: function(data) {
                    console.log(data);              
                    $('#branchTable').html(data);
                    if ($.fn.DataTable.isDataTable("#branchTable")) {
                        $('#branchTable').DataTable().clear().destroy();
                    }                     
                }
            });
            } else {
                
            }
        }
        $('#file-input').change(function() {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#image_sec').removeClass('d-none');
                $('#image-preview').attr('src', e.target.result);
            }
            reader.readAsDataURL(this.files[0]);
        })
    </script>
@stop




