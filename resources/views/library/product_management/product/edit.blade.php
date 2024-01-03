@extends('layout.app')
@section('title', 'Library | Company')
@section('content')
    <style>
        .bootstrap-select .btn {
            white-space: normal !important;
            word-wrap: break-word;
            line-height: 18px;
            border: 1px solid #ced4da;
        }
    </style>
    @include('layout/datatable')

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Edit product</small></h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{!! url('library/dashboard') !!}">Library</a></li>
                        <li class="breadcrumb-item"><a href="javascript::void(0)">ProductMangement</a></li>
                        <li class="breadcrumb-item"><a href="javascript::void(0)">Edit Product</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Index</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header with-border">
                        <h3 class="card-title text-center w-75">Edit Product</h3>
                        @if ($view)
                            <div class="float-right"><a
                                    href="{{ action('\App\Http\Controllers\Library\ProductManagement\ProductController@index') }}"
                                    class="btn-sm bg-gradient-success" title="Add">Product List</a></div>
                        @endif
                    </div>
                    <div class="card-body" style="overflow-x: scroll;">
                        <div class="row">
                            <div class="col-lg-12">
                                <form
                                    action="{{ action('\App\Http\Controllers\Library\ProductManagement\ProductController@update', $product->id) }}"
                                    method="post" enctype="multipart/form-data">
                                    @if (!empty(Session::get('error_code')) && Session::get('error_code') == 'Add')
                                        @include('layout/flash-message')
                                    @endif
                                    @csrf
                                    @method('patch')
                                    {{-- {{ $errors }} --}}
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="sales_type">Sales Type</label>
                                                        <select name="sales_type[]" class="form-control selectpicker " style="border: 1px solid #ced4da;" multiple  data-live-search="true">
                                                            @foreach (salesTypes() as $key => $type)
                                                            <option value="{!! $key !!}" {{ (in_array($key, explode(',',$product->sales_type))) ? 'selected' : '' }}>{!! $type !!}</option>
                                                            @endforeach
                                                        </select>

                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="Name">Product Name</label>
                                                        <input type="text" value="{{ $product->name }}"
                                                            placeholder="Name" name="name" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="Name">Company</label>
                                                        <select name="company_id" id="pro_category_select"
                                                            class="form-control select2bs4">
                                                            <option value="" selected>--Select One--</option>
                                                            @foreach ($companies as $company)
                                                                <option
                                                                    {{ getHostInfo()['id'] == $company->id ? 'selected' : '' }}
                                                                    value="{{ $company->id }}">{{ $company->Name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="Name">Select A Category
                                                        </label>
                                                        <select name="pro_category_select" id="pro_category_select"
                                                            class="form-control select2bs4">
                                                            <option value="" selected>--Select One--</option>
                                                            @foreach ($categories as $category)
                                                                <option
                                                                    {{ $product->category_id == $category->id ? 'selected' : '' }}
                                                                    value="{{ $category->id }}">{{ $category->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="Name">Select A Sub Category
                                                        </label>
                                                        <select name="pro_sub_category_select" id="pro_sub_category_select"
                                                            class="form-control select2bs4">
                                                            @foreach ($subCategories as $item)
                                                                <option
                                                                    {{ $product->sub_category_id == $item->id ? 'selected' : '' }}
                                                                    value="{{ $item->id }}">{{ $item->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="C4S">Is Active?</label>
                                                        <div class="controls">
                                                            <select name="status" id="" class="form-control">
                                                                <option value="" selected disabled hidden>--Select
                                                                    One--</option>
                                                                <option {{ $product->status == 1 ? 'selected' : '' }}
                                                                    value="1">Active</option>
                                                                <option {{ $product->status == 0 ? 'selected' : '' }}
                                                                    value="0">Inactive</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="Name">Description</label>
                                                        <textarea name="description" class="form-control" id="addProductDescription" cols="30" rows="1"
                                                            spellcheck="true">{{ $product->description }}</textarea>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="Name">Product Image</label>
                                                        <input type="file" name="image" id="file-input"
                                                            class="form-control">
                                                    </div>
                                                </div>
                                                <div class="col-md-3" id="image_sec">
                                                    <div class="form-group">
                                                        <label for="Name">Product Image</label><br>
                                                        <img style="width:200px; border-radius:10px" id="image-preview"
                                                            src="{{ url('public/product_images/', $product->image) }}"
                                                            alt="Preview">
                                                    </div>
                                                </div>
                                            </div>
                                            <button type="submit" class="btn btn-success float-right">Update</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#pro_category_select').on('change', function() {
                var pro_category_id = $(this).val();
                if (pro_category_id) {
                    console.log(pro_category_id);
                    $.ajax({
                        url: '{{ url('getsubcatpro') }}',
                        type: 'GET',
                        dataType: 'json',
                        data: {
                            'pro_category_id': pro_category_id
                        },
                        success: function(data) {
                            $('#pro_sub_category_select').empty();
                            $('#pro_sub_category_select').append(
                                '<option selected value="">--Select Subcategory--</option>');
                            $.each(data, function(index, subcategory) {
                                $('#pro_sub_category_select').append('<option value="' +
                                    subcategory.id + '">' + subcategory.name +
                                    '</option>');
                            });
                        }
                    });
                } else {
                    $('#pro_sub_category_select').empty();
                    $('#pro_sub_category_select').append(
                        '<option value="">--Select Subcategory--</option>');
                }
            });
        });
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
