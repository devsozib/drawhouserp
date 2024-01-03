@extends('layout.app')
@section('title', 'HRIS | Leave Definitions')
@section('content')
@include('layout/datatable')

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Leave Definitions</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{!! url('hris/dashboard') !!}">HRIS</a></li>
                        <li class="breadcrumb-item"><a href="javascript::void(0)">Setup</a></li>
                        <li class="breadcrumb-item"><a href="{!! url('hris/setup/leave_definitions') !!}">Leave</a></li>
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
                            <h3 class="card-title text-center w-75">leave List</h3>
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
                                                <h4 class="modal-title">Add Leave Definitions</h4>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            </div>
                                            <div class="modal-body">
                                                {!! Form::open([
                                                    'action' => ['\App\Http\Controllers\HRIS\Setup\LeaveDefineController@store', 'method' => 'Post'],
                                                ]) !!}
                                                @if (!empty(Session::get('error_code')) && Session::get('error_code') == 'Add')
                                                    @include('layout/flash-message')
                                                @endif
                                                <div class="row" style="padding-left: 0px; padding-right: 0px;">
                                                    <!-- <div class="col-md-6">
                                                        <div class="form-group row">
                                                            <label for="Name" class="col-sm-3 col-form-label">Name</label>
                                                            <div class="col-sm-9">
                                                                {{-- {!! Form::text('Department', null, [
                                                                    'required',
                                                                    'class' => 'form-control',
                                                                    'id' => 'Department',
                                                                    'maxlength' => '100',
                                                                    'placeholder' => 'Department',
                                                                    'value' => Input::old('Department'),
                                                                ]) !!} --}}
                                                            </div>
                                                        </div>
                                                    </div> -->
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label for="TypeID">TypeID</label>
                                                            <div class="controls">
                                                                {!! Form::text('TypeID', null, [
                                                                    'required',
                                                                    'class' => 'form-control',
                                                                    'id' => 'TypeID',
                                                                    'maxlength' => '10',
                                                                    'placeholder' => 'TypeID',
                                                                    'value' => Input::old('TypeID'),
                                                                ]) !!}
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="Description">Description</label>
                                                            <div class="controls">
                                                                {!! Form::text('Description', null, [
                                                                    'required',
                                                                    'class' => 'form-control',
                                                                    'id' => 'Description',
                                                                    'maxlength' => '100',
                                                                    'placeholder' => 'Description',
                                                                    'value' => Input::old('Description'),
                                                                ]) !!}
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-5">
                                                        <div class="form-group">
                                                            <label for="DescriptionB">DescriptionB</label>
                                                            <div class="controls">
                                                                {!! Form::text('DescriptionB', null, [
                                                                    'required',
                                                                    'class' => 'form-control',
                                                                    'id' => 'DescriptionB',
                                                                    'maxlength' => '100',
                                                                    'placeholder' => 'DescriptionB',
                                                                    'value' => Input::old('DescriptionB'),
                                                                ]) !!}
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label for="YearlyMaxlimit">Yearly Max limit</label>
                                                            <div class="controls">
                                                                {!! Form::text('YearlyMaxlimit', null, [
                                                                    'required',
                                                                    'class' => 'form-control',
                                                                    'id' => 'YearlyMaxlimit',
                                                                    'maxlength' => '10',
                                                                    'placeholder' => 'YearlyMaxlimit',
                                                                    'value' => Input::old('YearlyMaxlimit'),
                                                                ]) !!}
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label for="C4S">Status</label>
                                                            <div class="controls">
                                                                {!! Form::select('C4S', getStatus(1), null, [
                                                                    'required',
                                                                    'class' => 'form-control',
                                                                    'id' => 'C4S',
                                                                    'value' => Input::old('C4S'),
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
                                        <table class="table table-bordered table-striped datatbl" id="usertbl">
                                            <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>TypeID</th>
                                                    <th>Description</th>
                                                    <th>DescriptionB</th>
                                                    <th>Yearly Max Limit</th>
                                                    <th>Status</th>
                                                    <th style="width: 120px;">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($users as $user)
                                                    <tr>
                                                        <td>{!! $user->id !!}</td>
                                                        <td>{!! $user->TypeID !!}</td>
                                                        <td>{!! $user->Description !!}</td>
                                                        <td>{!! $user->DescriptionB !!}</td>
                                                        <td>{!! $user->YearlyMaxlimit !!}</td>
                                                        <td>{!! getC4S($user->C4S) !!}</td>
                                                        <td>
                                                            @if ($edit)
                                                                <a role="button" data-toggle="modal"
                                                                    data-target="#edit-modal{{ $user->id }}"
                                                                    class="btn-sm bg-gradient-info" title="Edit"><i
                                                                        class="fas fa-edit"></i></a>
                                                            @endif
                                                            @if ($delete)
                                                                <a role="button" data-toggle="modal"
                                                                    data-target="#delete-modal{{ $user->id }}"
                                                                    class="btn-sm bg-gradient-danger" title="Delete"><i
                                                                        class="fas fa-times"></i></a>
                                                            @endif

                                                            <!--Delete-->
                                                            <div class="modal fade"
                                                                id="delete-modal{!! $user->id !!}" role="dialog">
                                                                <div class="modal-dialog modal-md">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h4 class="modal-title">Warning!!!</h4>
                                                                            <button type="button" class="close"
                                                                                data-dismiss="modal"
                                                                                aria-label="Close"><span
                                                                                    aria-hidden="true">&times;</span></button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            Are you sure you want to delete this Leave:
                                                                            <strong
                                                                                style="color: darkorange">{{ $user->Description }}</strong>
                                                                            ?
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            {!! Form::open(['url' => 'hris/setup/leave_definitions/' . $user->id]) !!}
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
                                                            <div class="modal fade"
                                                                id="edit-modal{!! $user->id !!}" role="dialog">
                                                                <div class="modal-dialog modal-lg ">
                                                                    <!-- Modal content-->
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h4 class="modal-title">Edit Leave Description,
                                                                                Description: {!! $user->Description !!}</h4>
                                                                            <button type="button" class="close"
                                                                                data-dismiss="modal"
                                                                                aria-label="Close"><span
                                                                                    aria-hidden="true">&times;</span></button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            {!! Form::open(['url' => 'hris/setup/leave_definitions/' . $user->id]) !!}
                                                                            {!! Form::hidden('_method', 'PATCH') !!}
                                                                            @if (!empty(Session::get('error_code')) && Session::get('error_code') == $user->id)
                                                                                @include('layout/flash-message')
                                                                            @endif
                                                                            <div class="row"
                                                                                style="padding-left: 0px; padding-right: 0px;">
                                                                                <!-- <div class="col-md-6">
                                                                                    <div class="form-group row">
                                                                                        <label for="Name" class="col-sm-3 col-form-label">Name</label>
                                                                                        <div class="col-sm-9">
                                                                                            {{-- {!! Form::text('Department', $user->Department, [
                                                                                                'required',
                                                                                                'class' => 'form-control',
                                                                                                'id' => 'Department',
                                                                                                'maxlength' => '100',
                                                                                                'placeholder' => 'Department',
                                                                                                'value' => Input::old('Department'),
                                                                                            ]) !!} --}}
                                                                                        </div>
                                                                                    </div>
                                                                                </div> -->
                                                                                <div class="col-md-3">
                                                                                    <div class="form-group">
                                                                                        <label for="TypeID">TypeID</label>
                                                                                        <div class="controls">
                                                                                            {!! Form::text('TypeID', $user->TypeID, [
                                                                                                'required',
                                                                                                'class' => 'form-control',
                                                                                                'id' => 'TypeID',
                                                                                                'maxlength' => '10',
                                                                                                'placeholder' => 'TypeID',
                                                                                                'value' => Input::old('TypeID'),
                                                                                            ]) !!}
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-4">
                                                                                    <div class="form-group">
                                                                                        <label for="Description">Description</label>
                                                                                        <div class="controls">
                                                                                            {!! Form::text('Description', $user->Description, [
                                                                                                'required',
                                                                                                'class' => 'form-control',
                                                                                                'id' => 'Description',
                                                                                                'maxlength' => '100',
                                                                                                'placeholder' => 'Description',
                                                                                                'value' => Input::old('Description'),
                                                                                            ]) !!}
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-5">
                                                                                    <div class="form-group">
                                                                                        <label for="DescriptionB">DescriptionB</label>
                                                                                        <div class="controls">
                                                                                            {!! Form::text('DescriptionB', $user->DescriptionB, [
                                                                                                'required',
                                                                                                'class' => 'form-control',
                                                                                                'id' => 'DescriptionB',
                                                                                                'maxlength' => '100',
                                                                                                'placeholder' => 'DescriptionB',
                                                                                                'value' => Input::old('DescriptionB'),
                                                                                            ]) !!}
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-3">
                                                                                    <div class="form-group">
                                                                                        <label for="YearlyMaxlimit">Yearly Max limit</label>
                                                                                        <div class="controls">
                                                                                            {!! Form::text('YearlyMaxlimit', $user->YearlyMaxlimit, [
                                                                                                'required',
                                                                                                'class' => 'form-control',
                                                                                                'id' => 'YearlyMaxlimit',
                                                                                                'maxlength' => '10',
                                                                                                'placeholder' => 'YearlyMaxlimit',
                                                                                                'value' => Input::old('YearlyMaxlimit'),
                                                                                            ]) !!}
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-3">
                                                                                    <div class="form-group">
                                                                                        <label for="C4S">Is
                                                                                            Active?</label>
                                                                                        <div class="controls">
                                                                                            {!! Form::select('C4S', getStatus(1), $user->C4S, [
                                                                                                'required',
                                                                                                'class' => 'form-control',
                                                                                                'id' => 'C4S',
                                                                                                'value' => Input::old('C4S'),
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
                                                            @if (!empty(Session::get('error_code')) && Session::get('error_code') == $user->id)
                                                                <script>
                                                                    $(function() {
                                                                        $('#edit-modal{{ $user->id }}').modal('show');
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
