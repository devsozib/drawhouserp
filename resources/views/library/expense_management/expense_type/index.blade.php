@extends('layout.app')
@section('title', 'Library |Expense Type')
@section('content')
    @include('layout/datatable')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Expense Management</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{!! url('library/dashboard') !!}">Library</a></li>
                        <li class="breadcrumb-item"><a href="javascript::void(0)">Expense Management</a></li>
                        <li class="breadcrumb-item"><a href="{!! url('library/expense_management/expense_type') !!}">Expense Type</a></li>
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
                        <h3 class="card-title text-center w-75">Expense Type List</h3>
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
                                            <h4 class="modal-title">Add Expense Type</h4>
                                            <button type="button" class="close" data-dismiss="modal"
                                                aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        </div>
                                        <div class="modal-body">
                                            {!! Form::open([
                                                'action' => ['\App\Http\Controllers\Library\ExpenseManagement\ExpenseTypeController@store', 'method' => 'Post'],
                                            ]) !!}
                                            @if (!empty(Session::get('error_code')) && Session::get('error_code') == 'Add')
                                                @include('layout/flash-message')
                                            @endif
                                            <div class="row" style="padding-left: 0px; padding-right: 0px;">
                                                <!-- <div class="col-md-6">
                                                            <div class="form-group row">
                                                                <label for="Name" class="col-sm-3 col-form-label">Name</label>
                                                                <div class="col-sm-9">
                                                                    {{-- {!! Form::text('name', null, [
                                                                        'required',
                                                                        'class' => 'form-control',
                                                                        'id' => 'name',
                                                                        'maxlength' => '100',
                                                                        'placeholder' => 'Expense Type Name',
                                                                        'value' => Input::old('name'),
                                                                    ]) !!} --}}
                                                                </div>
                                                            </div>
                                                        </div> -->
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="name">Name</label>
                                                        <div class="controls">
                                                            {!! Form::text('name', null, [
                                                                'required',
                                                                'class' => 'form-control',
                                                                'id' => 'name',
                                                                'maxlength' => '100',
                                                                'placeholder' => 'Expense Type Name',
                                                                'value' => Input::old('name'),
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
                                                                // 'placeholder' => 'Select One',
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
                                    <table class="table table-bordered table-striped datatbl" id="expense_typetbl">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Name</th>
                                                <th>Status</th>
                                                <th style="width: 120px;">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($expense_types as $expense_type)
                                                <tr>
                                                    <td>{!! $expense_type->id !!}</td>
                                                    <td>{!! $expense_type->name !!}</td>
                                                    <td>{!! getC4S($expense_type->status) !!}</td>
                                                    <td>
                                                        @if ($edit)
                                                            <a role="button" data-toggle="modal"
                                                                data-target="#edit-modal{{ $expense_type->id }}"
                                                                class="btn-sm bg-gradient-info" title="Edit"><i
                                                                    class="fas fa-edit"></i></a>
                                                        @endif
                                                        @if ($delete)
                                                            <a role="button" data-toggle="modal"
                                                                data-target="#delete-modal{{ $expense_type->id }}"
                                                                class="btn-sm bg-gradient-danger" title="Delete"><i
                                                                    class="fas fa-times"></i></a>
                                                        @endif

                                                        <!--Delete-->
                                                        <div class="modal fade" id="delete-modal{!! $expense_type->id !!}"
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
                                                                        Are you sure you want to delete this Expense Type:
                                                                        <strong
                                                                            style="color: darkorange">{{ $expense_type->name }}</strong>
                                                                        ?
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        {!! Form::open(['url' => 'library/expense_management/expense_type/' . $expense_type->id]) !!}
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
                                                        <div class="modal fade" id="edit-modal{!! $expense_type->id !!}"
                                                            role="dialog">
                                                            <div class="modal-dialog modal-lg ">
                                                                <!-- Modal content-->
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h4 class="modal-title">Edit Expense Type,
                                                                            Name: {!! $expense_type->name !!}</h4>
                                                                        <button type="button" class="close"
                                                                            data-dismiss="modal" aria-label="Close"><span
                                                                                aria-hidden="true">&times;</span></button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        {!! Form::open(['url' => 'library/expense_management/expense_type/' . $expense_type->id]) !!}
                                                                        {!! Form::hidden('_method', 'PATCH') !!}
                                                                        @if (!empty(Session::get('error_code')) && Session::get('error_code') == $expense_type->id)
                                                                            @include('layout/flash-message')
                                                                        @endif
                                                                        <div class="row"
                                                                            style="padding-left: 0px; padding-right: 0px;">
                                                                            <!-- <div class="col-md-6">
                                                                                        <div class="form-group row">
                                                                                            <label for="Name" class="col-sm-3 col-form-label">Name</label>
                                                                                            <div class="col-sm-9">
                                                                                                {{-- {!! Form::text('name', $expense_type->name, [
                                                                                                    'required',
                                                                                                    'class' => 'form-control',
                                                                                                    'id' => 'name',
                                                                                                    'maxlength' => '100',
                                                                                                    'placeholder' => 'Expense Type Name',
                                                                                                    'value' => Input::old('name'),
                                                                                                ]) !!} --}}
                                                                                            </div>
                                                                                        </div>
                                                                                    </div> -->
                                                                            <div class="col-md-6">
                                                                                <div class="form-group">
                                                                                    <label for="name">Name</label>
                                                                                    <div class="controls">
                                                                                        {!! Form::text('name', $expense_type->name, [
                                                                                            'required',
                                                                                            'class' => 'form-control',
                                                                                            'id' => 'Name',
                                                                                            'maxlength' => '100',
                                                                                            'placeholder' => 'Expense Type Name',
                                                                                            'value' => Input::old('name'),
                                                                                        ]) !!}
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <div class="col-md-3">
                                                                                <div class="form-group">
                                                                                    <label for="status">Status</label>
                                                                                    <div class="controls">
                                                                                        {!! Form::select('status', ['1' => 'Yes', '0' => 'No'], $expense_type->status, [
                                                                                            'required',
                                                                                            'class' => 'form-control',
                                                                                            'id' => 'status',
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
                                                        @if (!empty(Session::get('error_code')) && Session::get('error_code') == $expense_type->id)
                                                            <script>
                                                                $(function() {
                                                                    $('#edit-modal{{ $expense_type->id }}').modal('show');
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

@stop
