@extends('layout.app')
@section('title','Library | Company')
@section('content')
@include('layout/datatable')

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Asset Management<small></small></h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{!! url('library/dashboard') !!}">Library</a></li>
                    <li class="breadcrumb-item"><a href="javascript::void(0)">Asset Mangement</a></li>
                    <li class="breadcrumb-item"><a href="{!! url('library/general/asset-item') !!}">Add Asset Item</a></li>
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
                    <h3 class="card-title text-center w-75">Add Asset Item</h3>
                    @if($create)
                        <div class="float-right"><a href="{{action('\App\Http\Controllers\Library\General\AssetItemController@index') }}" class="btn-sm bg-gradient-success" title="Add">&nbsp;Asset List</a></div>
                    @endif
                </div>
                <div class="card-body" style="overflow-x: scroll;">
                    <div class="row">
                        <div class="col-lg-12">
                            <form action="{{action('\App\Http\Controllers\Library\General\AssetItemController@store') }}" method="post" enctype="multipart/form-data">
                                @if(!empty(Session::get('error_code')) && Session::get('error_code') == 'Add')
                                    @include('layout/flash-message')
                                @endif
                                @csrf
                                {{-- {{ $errors }} --}}
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="Name">Asset Item Name</label>
                                                        <input type="text" placeholder="Name" name="name" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="Name">Asset Default Weight Unit</label>
                                                        <select name="unit_id" id="" class="form-control select2bs4">
                                                            <option value="" selected disabled hidden>--Select One--</option>
                                                            @foreach($units as $unit)
                                                            <option value="{{ $unit->id }}">{{ $unit->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="Name">Select A Branch for the Asset</label>
                                                        <select name="company_id" id="" class="form-control select2bs4">
                                                            <option value="" selected disabled hidden>--Select One--</option>
                                                            @foreach($companies as $company)
                                                            <option value="{{ $company->id }}">{{ $company->Name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="Name">Select A Category
                                                            </label>
                                                        <select name="in_category_select" id="in_category_select" class="form-control select2bs4">
                                                            <option value="" selected>--Select One--</option>
                                                            @foreach($categories as $category)
                                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
            
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="C4S">Status</label>
                                                        <div class="controls">
                                                            <select name="status" id="" class="form-control">
                                                                <option value="" selected disabled hidden>--Select One--</option>
                                                                <option value="1">Active</option>
                                                                <option value="0">Inactive</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="Name">Asset Item Image</label>
                                                        <input type="file" name="image" id="file-input" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="col-md-3 d-none" id="image_sec">
                                                    <div class="form-group">
                                                        {{-- <label for="Name">Ingredient Image</label> --}}
                                                        <img style="width:200px; border-radius:10px" id="image-preview" src="#" alt="Preview">
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
                        $('#in_sub_category_select').append('<option selected value="">--Select Subcategory--</option>');
                        $.each(data, function(index, subcategory) {
                            $('#in_sub_category_select').append('<option value="' + subcategory.id + '">' + subcategory.name + '</option>');
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
