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
                        <li class="breadcrumb-item"><a href="{!! url('library/expense_management/expenses') !!}">Expenses</a></li>
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
                        <h3 class="card-title text-center w-75">Expenses</h3>
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
                                            <h4 class="modal-title">Add Expenses</h4>
                                            <button type="button" class="close" data-dismiss="modal"
                                                aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        </div>
                                        <div class="modal-body">
                                            {!! Form::open([
                                                'action' => ['\App\Http\Controllers\Library\ExpenseManagement\ExpenseController@store', 'method' => 'Post'],
                                            ]) !!}
                                            @if (!empty(Session::get('error_code')) && Session::get('error_code') == 'Add')
                                                @include('layout/flash-message')
                                            @endif
                                            <div class="row" style="padding-left: 0px; padding-right: 0px;">
                                                <div class="col-md-4">
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

                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="expns_type_id">Expense Type Name</label>
                                                        <div class="controls">
                                                            {!! Form::select('expns_type_id', $exp_type_arr, null, [
                                                                'required',
                                                                'class' => 'form-control select2bs4',
                                                                'id' => 'expns_type_id',
                                                                'placeholder' => 'Select One',
                                                                'value' => Input::old('expns_type_id'),
                                                            ]) !!}
                                                        </div>
                                                    </div>
                                                </div>


                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="expns_time">Expense Date</label>
                                                        <div class="controls">
                                                            {!! Form::text('expns_time', null, [
                                                                'required',
                                                                'class' => 'form-control datepicker',
                                                                'id' => 'remarks',
                                                                'maxlength' => '200',
                                                                'placeholder' => 'Expense date',
                                                                'value' => Input::old('expns_time'),
                                                            ]) !!}
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="remarks">Expense Details</label>
                                                        <div class="controls">
                                                            {!! Form::textarea('remarks', null, [
                                                                'required',
                                                                'class' => 'form-control input',
                                                                'id' => 'remarks',
                                                                'rows' => 2,
                                                                'maxlength' => '200',
                                                                'placeholder' => 'Expense Details',
                                                                'value' => Input::old('remarks'),
                                                            ]) !!}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="amount">Expense Amount</label>
                                                        <div class="controls">
                                                            {!! Form::number('amount', null, [
                                                                'required',
                                                                'class' => 'form-control',
                                                                'id' => 'amount',
                                                                'min' => '0',
                                                                'max' => '999999',
                                                                // 'step' => '0.01',
                                                                'placeholder' => 'Expense Amount',
                                                                'value' => Input::old('amount'),
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
                                    <table class="table table-bordered table-striped datatbl" id="expense_typetbl">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Company Name</th>
                                                <th>Expense Type</th>
                                                <th>Expense Date</th>
                                                <th>Expense Amount</th>
                                                <th>Expense Reamrks</th>
                                                <th>Status</th>
                                                <th style="width: 120px;">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($expenses as $expense_type)
                                                <tr>
                                                    <td>{!! $expense_type->id !!}</td>
                                                    <td>{!! $comp_arr[$expense_type->company_id] !!}</td>
                                                    <td>{!! $exp_type_arr[$expense_type->expns_type_id] !!}</td>
                                                    <td>{!! $expense_type->expns_time !!}</td>
                                                    <td>{!! $expense_type->amount !!}</td>
                                                    <td>{!! $expense_type->remarks !!}</td>
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
                                                                        {!! Form::open(['url' => 'library/expense_management/expenses/' . $expense_type->id]) !!}
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
                                                                        {!! Form::open(['url' => 'library/expense_management/expenses/' . $expense_type->id]) !!}
                                                                        {!! Form::hidden('_method', 'PATCH') !!}
                                                                        @if (!empty(Session::get('error_code')) && Session::get('error_code') == $expense_type->id)
                                                                            @include('layout/flash-message')
                                                                        @endif
                                                                        <div class="row"
                                                                            style="padding-left: 0px; padding-right: 0px;">
                                                                            <div class="col-md-4">
                                                                                <div class="form-group">
                                                                                    <label for="company_id">Company
                                                                                        Name</label>
                                                                                    <div class="controls">
                                                                                        {!! Form::select('company_id', $comp_arr, $expense_type->company_id, [
                                                                                            'required',
                                                                                            'class' => 'form-control select2bs4',
                                                                                            'id' => 'company_id',
                                                                                            'placeholder' => 'Select One',
                                                                                            'value' => Input::old('company_id'),
                                                                                        ]) !!}
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <div class="col-md-4">
                                                                                <div class="form-group">
                                                                                    <label for="expns_type_id">Expense Type
                                                                                        Name</label>
                                                                                    <div class="controls">
                                                                                        {!! Form::select('expns_type_id', $exp_type_arr, $expense_type->expns_type_id, [
                                                                                            'required',
                                                                                            'class' => 'form-control select2bs4',
                                                                                            'id' => 'expns_type_id',
                                                                                            'placeholder' => 'Select One',
                                                                                            'value' => Input::old('expns_type_id'),
                                                                                        ]) !!}
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-4">
                                                                                <div class="form-group">
                                                                                    <label for="expns_time">Expense
                                                                                        Date</label>
                                                                                    <div class="controls">
                                                                                        {!! Form::text('expns_time',  $expense_type->expns_time, [
                                                                                            'required',
                                                                                            'class' => 'form-control datepicker',
                                                                                            'id' => 'remarks',
                                                                                            'maxlength' => '200',
                                                                                            'placeholder' => 'Expense date',
                                                                                            'value' => Input::old('expns_time'),
                                                                                        ]) !!}
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <div class="col-md-4">
                                                                                <div class="form-group">
                                                                                    <label for="remarks">Expense
                                                                                        Details</label>
                                                                                    <div class="controls">
                                                                                        {!! Form::textarea('remarks',$expense_type->remarks, [
                                                                                            'required',
                                                                                            'class' => 'form-control input',
                                                                                            'id' => 'remarks',
                                                                                            'rows' => 2,
                                                                                            'maxlength' => '200',
                                                                                            'placeholder' => 'Expense Details',
                                                                                            'value' => Input::old('remarks'),
                                                                                        ]) !!}
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-4">
                                                                                <div class="form-group">
                                                                                    <label for="amount">Expense
                                                                                        Amount</label>
                                                                                    <div class="controls">
                                                                                        {!! Form::number('amount', $expense_type->amount, [
                                                                                            'required',
                                                                                            'class' => 'form-control',
                                                                                            'id' => 'amount',
                                                                                            'min' => '0',
                                                                                            'max' => '999999',
                                                                                            // 'step' => '0.01',
                                                                                            'placeholder' => 'Expense Amount',
                                                                                            'value' => Input::old('amount'),
                                                                                        ]) !!}
                                                                                    </div>
                                                                                </div>
                                                                            </div>


                                                                            <div class="col-md-4">
                                                                                <div class="form-group">
                                                                                    <label for="status">Status</label>
                                                                                    <div class="controls">
                                                                                        {!! Form::select('status', getStatus(2), $expense_type->status, [
                                                                                            'required',
                                                                                            'class' => 'form-control',
                                                                                            'id' => 'status',
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
