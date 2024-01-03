@extends('layout.app')
@section('title', 'Inventory |Waste Asset')
@section('content')
    @include('layout/datatable')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Waste Management</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{!! url('inventory/dashboard') !!}">Inventory</a></li>
                        <li class="breadcrumb-item"><a href="javascript::void(0)">Asset Management</a></li>
                        <li class="breadcrumb-item"><a href="{!! url('inventory/waste_management/waste_asset') !!}">Waste Asset</a></li>
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
                        <h3 class="card-title text-center w-75">Waste Asset List</h3>
                        @if ($create)
                            <div class="float-right"><a role="button" data-toggle="modal" data-target="#add-modal"
                                    class="btn-sm bg-gradient-success" title="Add"><i
                                        class="fas fa-plus"></i>&nbsp;Add</a></div>

                            <!--Add Form Here-->
                            <div class="modal fade" id="add-modal" role="dialog">
                                <div class="modal-dialog modal-lg ">
                                    <!-- Modal content-->
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title">Add Waste Asset</h4>
                                            <button type="button" class="close" data-dismiss="modal"
                                                aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        </div>
                                        <div class="modal-body">                                       
                                            {!! Form::open([
                                                'action' => ['\App\Http\Controllers\Inventory\WasteManagement\WasteAssetController@store', 'method' => 'Post'],
                                            ]) !!}
                                            @if (!empty(Session::get('error_code')) && Session::get('error_code') == 'Add')
                                                @include('layout/flash-message')
                                            @endif
                                            <div class="row" style="padding-left: 0px; padding-right: 0px;">

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="company_id">Company Name</label>
                                                        <div class="controls">
                                                            {!! Form::select('company_id', $comp_arr, null, [
                                                                'required',
                                                                'class' => 'form-control select2bs4',
                                                                'id' => 'company_id',
                                                                'placeholder' => 'Select One',
                                                                'value' => Input::old('company_id'),
                                                            ]) !!}
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="asset_id">Asset Name</label>
                                                        <div class="controls">
                                                            {!! Form::select('asset_id',[], null, [
                                                                'required',
                                                                'class' => 'form-control select2bs4',
                                                                'id' => 'asset_id',                                                            
                                                                'value' => Input::old('asset_id'),
                                                            ]) !!}
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="quantity">Asset Quantity</label>
                                                        <div class="controls">
                                                            {!! Form::text('quantity', null, [
                                                                'required',
                                                                'class' => 'form-control',
                                                                'id' => 'quantity',
                                                                'min' => '0',
                                                                'max' => '999999',
                                                                // 'step' => '0.01',
                                                                'placeholder' => 'Asset Quantity',
                                                                'value' => Input::old('quantity'),
                                                            ]) !!}
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="date">Waste Date</label>
                                                        <div class="controls">
                                                            {!! Form::text('date', null, [
                                                                'required',
                                                                'class' => 'form-control datepicker',
                                                                'id' => 'date',
                                                                'maxlength' => '200',
                                                                'placeholder' => 'Waste date',
                                                                'value' => Input::old('date'),
                                                            ]) !!}
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="status">Status</label>
                                                        <div class="controls">
                                                            {!! Form::select('status', getStatus(2), null, [
                                                                'required',
                                                                'class' => 'form-control',
                                                                'id' => 'status',
                                                                // 'placeholder' => '',
                                                                'value' => Input::old('status'),
                                                            ]) !!}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            {!! Form::submit('Add', ['class' => 'btn btn-success']) !!}
                                            {!! Form::close() !!}
                                            <button type="button" class="btn btn-default"
                                                data-dismiss="modal">Cancel</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @if (!empty(Session::get('error_code')) && Session::get('error_code') == 'Add')
                                <script>
                                    $(function() {
                                        $('#add-modal').modal('show');
                                    });
                                </script>
                            @endif
                        @endif
                    </div>
                    <div class="card-body" style="overflow-x: scroll;">
                        <div class="row">
                            <div class="col-lg-12">
                                <div style="min-height: 400px;">
                                    <table class="table table-bordered table-striped datatbl" id="waste_typetbl">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Company Name</th>
                                                <th>Asset Name</th>
                                                <th>Quantity</th>
                                                <th>Date</th>
                                                <th>Status</th>
                                                <th style="width: 120px;">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($waste_ings as $waste_ing)
                                                <tr>
                                                    <td>{!! $waste_ing->id !!}</td>
                                                    <td>{!! $comp_arr[$waste_ing->company_id] !!}</td>
                                                    <td>{!! $waste_ing->asset_name !!} ({!! $waste_ing->unit_name !!})</td>
                                                    <td>{!! $waste_ing->quantity !!}</td>
                                                    <td>{!! date('d-m-Y',strtotime($waste_ing->date)) !!}</td>
                                                    <td>{!! getC4S($waste_ing->status) !!}</td>
                                                    <td>
                                                        @if ($edit)
                                                            <a role="button" data-toggle="modal"
                                                                data-target="#edit-modal{{ $waste_ing->id }}"
                                                                class="btn-sm bg-gradient-info" title="Edit"><i
                                                                    class="fas fa-edit"></i></a>
                                                        @endif
                                                        @if ($delete)
                                                            <a role="button" data-toggle="modal"
                                                                data-target="#delete-modal{{ $waste_ing->id }}"
                                                                class="btn-sm bg-gradient-danger" title="Delete"><i
                                                                    class="fas fa-times"></i></a>
                                                        @endif

                                                        <!--Delete-->
                                                        <div class="modal fade" id="delete-modal{!! $waste_ing->id !!}"
                                                            role="dialog">
                                                            <div class="modal-dialog modal-md">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h4 class="modal-title">Warning!!!</h4>
                                                                        <button type="button" class="close"
                                                                            data-dismiss="modal" aria-label="Close"><span
                                                                                aria-hidden="true">&times;</span></button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        Are you sure you want to delete this Waste
                                                                        Asset:
                                                                        <strong
                                                                            style="color: darkorange">{{ $waste_ing->asset_name }}</strong>
                                                                        ?
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        {!! Form::open(['url' => 'inventory/waste_management/waste_asset/' . $waste_ing->id]) !!}
                                                                        {!! Form::hidden('_method', 'DELETE') !!}
                                                                        {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
                                                                        {!! Form::close() !!}
                                                                        <button type="button" class="btn btn-default"
                                                                            data-dismiss="modal">Cancel</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <!--Edit Form Here-->
                                                        <div class="modal fade" id="edit-modal{!! $waste_ing->id !!}"
                                                            role="dialog">
                                                            <div class="modal-dialog modal-lg ">
                                                                <!-- Modal content-->
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h4 class="modal-title">Edit Waste Asset,
                                                                            Name: {!! $waste_ing->asset_id !!}</h4>
                                                                        <button type="button" class="close"
                                                                            data-dismiss="modal" aria-label="Close"><span
                                                                                aria-hidden="true">&times;</span></button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        {!! Form::open(['url' => 'inventory/waste_management/waste_asset/' . $waste_ing->id]) !!}
                                                                        {!! Form::hidden('_method', 'PATCH') !!}
                                                                        @if (!empty(Session::get('error_code')) && Session::get('error_code') == $waste_ing->id)
                                                                            @include('layout/flash-message')
                                                                        @endif
                                                                        <div class="row"
                                                                            style="padding-left: 0px; padding-right: 0px;">
                                                                            <div class="col-md-4">
                                                                                <div class="form-group">
                                                                                    <label for="company_id">Company
                                                                                        Name</label>
                                                                                    <div class="controls">
                                                                                        {!! Form::select('company_id', $comp_arr, $waste_ing->company_id, [
                                                                                            'required',
                                                                                            'class' => 'form-control select2bs4',
                                                                                            'id' => 'company_id'.$waste_ing->id,
                                                                                            'placeholder' => 'Select One',
                                                                                            'value' => Input::old('company_id'),
                                                                                        ]) !!}
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <div class="col-md-4">
                                                                                <div class="form-group">
                                                                                    <label for="asset_id">Asset
                                                                                        Name</label>
                                                                                    <div class="controls">
                                                                                        {!! Form::select('asset_id', [], $waste_ing->asset_id, [
                                                                                            'required',
                                                                                            'class' => 'form-control select2bs4',
                                                                                            'id' => 'asset_id'.$waste_ing->id,
                                                                                            'placeholder' => 'Select One',
                                                                                            'value' => Input::old('asset_id'),
                                                                                        ]) !!}
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-4">
                                                                                <div class="form-group">
                                                                                    <label for="date">Waste
                                                                                        Date</label>
                                                                                    <div class="controls">
                                                                                        {!! Form::text('date',  $waste_ing->date, [
                                                                                            'required',
                                                                                            'class' => 'form-control datepicker',
                                                                                            'id' => 'date'.$waste_ing->id,
                                                                                            'maxlength' => '200',
                                                                                            'placeholder' => 'Waste date',
                                                                                            'value' => Input::old('date'),
                                                                                        ]) !!}
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <div class="col-md-4">
                                                                                <div class="form-group">
                                                                                    <label for="quantity">Asset
                                                                                        Quantity</label>
                                                                                    <div class="controls">
                                                                                        {!! Form::text('quantity', $waste_ing->quantity, [
                                                                                            'required',
                                                                                            'class' => 'form-control',
                                                                                            'id' => 'quantity'.$waste_ing->id,
                                                                                            'min' => '0',
                                                                                            'max' => '999999',
                                                                                            // 'step' => '0.01',
                                                                                            'placeholder' => 'Asset quantity',
                                                                                            'value' => Input::old('quantity'),
                                                                                        ]) !!}
                                                                                    </div>
                                                                                </div>
                                                                            </div>


                                                                            <div class="col-md-4">
                                                                                <div class="form-group">
                                                                                    <label for="status">Status</label>
                                                                                    <div class="controls">
                                                                                        {!! Form::select('status', getStatus(2), $waste_ing->status, [
                                                                                            'required',
                                                                                            'class' => 'form-control',
                                                                                            'id' => 'status'.$waste_ing->id,
                                                                                            'placeholder' => 'Select One',
                                                                                            'value' => Input::old('status'),
                                                                                        ]) !!}
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        {!! Form::submit('Update', ['class' => 'btn btn-success']) !!}
                                                                        {!! Form::close() !!}
                                                                        <button type="button" class="btn btn-default"
                                                                            data-dismiss="modal">Cancel</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <script type="text/javascript">
                                                            function getAssetEdit() {
                                                                let company_id = $("#company_id{{$waste_ing->id}} option:selected").val();
                                                                if (company_id) {
                                                                    $.ajax({
                                                                        type:"GET",
                                                                        url:"{{url('getasset')}}",
                                                                        data:{
                                                                            company_id: company_id,
                                                                        },
                                                                        success:function(data) {
                                                                            if (data) {
                                                                                $("#asset_id{{$waste_ing->id}}").empty();
                                                                                $.each(data, function(key,value) {
                                                                                    if (value.id == '{{$waste_ing->asset_id}}') {
                                                                                        $("#asset_id{{$waste_ing->id}}").append('<option value="'+value.id+'" selected>'+value.name+" ("+value.unit_name+")"+'</option>');
                                                                                    } else {
                                                                                        $("#asset_id{{$waste_ing->id}}").append('<option value="'+value.id+'">'+value.name+" ("+value.unit_name+")"+'</option>');
                                                                                    }
                                                                                });
                                                                            } else {
                                                                               $("#asset_id{{$waste_ing->id}}").empty();
                                                                            }
                                                                        }
                                                                    });
                                                                }else{
                                                                    $("#asset_id{{$waste_ing->id}}").empty();
                                                                }
                                                            }
                                                            getAssetEdit();
                                                            $('#company_id{{$waste_ing->id}}').on("change", function (event) {
                                                                event.preventDefault();
                                                                getAssetEdit();
                                                            });
                                                        </script>
                                                        @if (!empty(Session::get('error_code')) && Session::get('error_code') == $waste_ing->id)
                                                            <script>
                                                                $(function() {
                                                                    $('#edit-modal{{ $waste_ing->id }}').modal('show');
                                                                });
                                                            </script>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
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
        function getAsset() {
            let company_id = $("#company_id option:selected").val();
            //console.log(company_id);
            if (company_id) {
                $.ajax({
                    type:"GET",
                    url:"{{url('getasset')}}",
                    data:{
                        company_id: company_id,
                    },
                    success:function(data) {
                        if (data) {
                            $("#asset_id").empty();
                            $.each(data, function(key,value) {
                                $("#asset_id").append('<option value="'+value.id+'">'+value.name+" ("+value.unit_name+")"+'</option>');
                            });
                        } else {
                           $("#asset_id").empty();
                        }
                    }
                });
            }else{
                $("#asset_id").empty();
            }
        }
        getAsset();
        $('#company_id').on("change", function (event) {
            event.preventDefault();
            getAsset();
        });
    </script>
    
@stop
