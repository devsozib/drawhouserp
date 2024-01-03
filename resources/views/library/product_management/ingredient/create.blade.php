@extends('layout.app')
@section('title', 'Library | Company')
@section('content')
    @include('layout/datatable')

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Add Ingredient</small></h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{!! url('library/dashboard') !!}">Library</a></li>
                        <li class="breadcrumb-item"><a href="javascript::void(0)">ProductMangement</a></li>
                        <li class="breadcrumb-item"><a href="{!! url('library/general/company') !!}">Add Ingredient</a></li>
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
                        <h3 class="card-title  w-75">Add Ingredient</h3>
                        @if ($create)
                            <div class="float-right"><a
                                    href="{{ action('\App\Http\Controllers\Library\ProductManagement\IngredientController@index') }}"
                                    class="btn-sm bg-gradient-success" title="Add">&nbsp;Ingrdient List</a></div>
                        @endif
                    </div>
                    <div class="card-body" style="overflow-x: scroll;">
                        <div class="row">
                            <div class="col-lg-12">
                                <form
                                    action="{{ action('\App\Http\Controllers\Library\ProductManagement\IngredientController@store') }}"
                                    method="post" enctype="multipart/form-data">
                                    @if (!empty(Session::get('error_code')) && Session::get('error_code') == 'Add')
                                        @include('layout/flash-message')
                                    @endif
                                    @csrf
                                    {{-- {{ $errors }} --}}
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="Name">Ingredient Name</label>
                                                        <select name="ing_id" id="" class="form-control select2Txt">
                                                            <option value="" selected disabled hidden>--Select One--</option>
                                                            @foreach ($ingredientNotForYou as $item)
                                                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="Name">Ingredient Unit</label>
                                                        <select name="unit_id" id=""
                                                            class="form-control select2bs4">
                                                            <option value="" selected disabled hidden>--Select One--
                                                            </option>
                                                            @foreach ($units as $unit)
                                                                <option value="{{ $unit->id }}">{{ $unit->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="Name">Select Company</label>
                                                        <select onchange="getCategory(this.value)" name="company_id"
                                                            id="" class="form-control select2bs4">
                                                            <option value="" selected disabled hidden>--Select One--
                                                            </option>
                                                            @foreach ($companies as $company)
                                                                <option  {{ $company->id == getHostInfo()['id']?'selected':'' }} value="{{ $company->id }}">{{ $company->Name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="Name">Select Category
                                                        </label>
                                                        <select name="in_category_select" id="in_category_select"
                                                            class="form-control select2bs4">
                                                            <option value="" selected>--Select One--</option>
                                                            @foreach ($categories as $category)
                                                                <option value="{{ $category->id }}">{{ $category->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="Name">Select Sub Category
                                                        </label>
                                                        <select name="in_sub_category_select" id="in_sub_category_select"
                                                            class="form-control select2bs4">
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
                                                                <option value="1">Active</option>
                                                                <option value="0">Inactive</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="Name">Ingredient Image</label>
                                                        <input type="file" name="image" id="file-input"
                                                            class="form-control">
                                                    </div>
                                                </div>
                                                <div class="col-md-3 d-none" id="image_sec">
                                                    <div class="form-group">
                                                        {{-- <label for="Name">Ingredient Image</label> --}}
                                                        <img style="width:200px; border-radius:10px" id="image-preview"
                                                            src="#" alt="Preview">
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
        </div>
    </div>
    <script type="text/javascript">
        function getCategory(id) {
            if (id) {
                $.ajax({
                    url: '{{ url('getCategory') }}',
                    type: 'GET',
                    data: {
                        'company_id': id
                    },
                    success: function(data) {
                        console.log(data);
                        $('#in_category_select').empty();
                        $('#in_category_select').append(
                            '<option selected value="">--Select Category-- </option>');
                        $.each(data, function(index, cat) {
                            $('#in_category_select').append('<option value = "' +
                                cat.id + '">' + cat.name + '</option>');
                        });
                    }
                });
            } else {
                $('#category').empty();
                $('#category').append('<option value=""> --Select Category-- </option>');
            }
        }

        $(document).ready(function() {
            $('#in_category_select').on('change', function() {
                var in_category_id = $(this).val();
                if (in_category_id) {

                    $.ajax({
                        url: '{{ url('getsubcating') }}',
                        type: 'GET',
                        dataType: 'json',
                        data: {
                            'in_category_id': in_category_id
                        },
                        success: function(data) {
                            $('#in_sub_category_select').empty();
                            $('#in_sub_category_select').append(
                                '<option selected value="">--Select Subcategory--</option>');
                            $.each(data, function(index, subcategory) {
                                $('#in_sub_category_select').append('<option value="' +
                                    subcategory.id + '">' +
                                    subcategory.name +
                                    '</option>');
                            });
                        }
                    });
                } else {
                    $('#in_sub_category_select').empty();
                    $('#in_sub_category_select').append('<option value="">--Select Subcategory--</option>');
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
