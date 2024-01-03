@extends('layout.app')
@section('title','Library | Company')
@section('content')
@include('layout/datatable')

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0"><small>- Edit Asset Item</small></h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{!! url('library/dashboard') !!}">Library</a></li>
                    <li class="breadcrumb-item"><a href="javascript::void(0)">Asset Item</a></li>
                    <li class="breadcrumb-item"><a href="{!! url('library/general/asset-item') !!}">Edit Asset Item</a></li>
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
                    <h3 class="card-title text-center w-75">Edit Asset Item</h3>
                    @if($create)
                        <div class="float-right"><a href="{{action('\App\Http\Controllers\Library\General\AssetItemController@index') }}" class="btn-sm bg-gradient-success" title="Add"><i class="fas fa-plus"></i>&nbsp;Asset List</a></div>
                    @endif
                </div>
                <div class="card-body" style="overflow-x: scroll;">
                    <div class="row">
                        <div class="col-lg-12">
                            <form action="{{action('\App\Http\Controllers\Library\General\AssetItemController@update',$assetitem->id) }}" method="post" enctype="multipart/form-data">
                                @if(!empty(Session::get('error_code')) && Session::get('error_code') == 'Add')
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
                                                        <label for="Name">Asset Item Name</label>
                                                        <input type="text" value="{{ $assetitem->name }}" placeholder="Name" name="name" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="Name">Asset Default Weight Unit</label>
                                                        <select name="unit_id" id="" class="form-control select2bs4">
                                                            <option value="" selected disabled hidden>--Select One--</option>
                                                            @foreach($units as $unit)
                                                            <option {{ $assetitem->unit_id==$unit->id?'selected':'' }} value="{{ $unit->id }}">{{ $unit->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="Name">Select A Branch for the Asset Item</label>
                                                        <select name="company_id" id="" class="form-control select2bs4">
                                                            <option value="" selected disabled hidden>--Select One--</option>
                                                            @foreach($companies as $company)
                                                            <option {{ $assetitem->company_id==$company->id?'selected':'' }} value="{{ $company->id }}">{{ $company->Name }}</option>
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
                                                            <option {{ $assetitem->category_id==$category->id?'selected':'' }} value="{{ $category->id }}">{{ $category->name }}</option>
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
                                                                <option {{ $assetitem->status==1?'selected':'' }} value="1">Active</option>
                                                                <option {{ $assetitem->status==0?'selected':'' }} value="0">Inactive</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="Name">Asset Item Image</label>
                                                        <input type="file" name="image"  id="file-input" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="col-md-3" id="image_sec">
                                                    <div class="form-group">
                                                        {{-- <label for="Name">Ingredient Image</label> --}}
                                                        <img style="width:200px; border-radius:10px"  id="image-preview" src="{{ url('public/assetItem_images/',$assetitem->image) }}" alt="Preview">
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


@stop
