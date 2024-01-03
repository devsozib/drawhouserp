@extends('layout.app')
@section('title', 'Library | Company')
@section('content')
    @include('layout/datatable')

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Company</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{!! url('library/dashboard') !!}">Library</a></li>
                        <li class="breadcrumb-item"><a href="javascript::void(0)">General</a></li>
                        <li class="breadcrumb-item"><a href="{!! url('library/general/company') !!}">Company</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Index</li>
                    </ol>
                </div>
            </div>
        </div>

        <div class="content">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header with-border">
                            <h3 class="card-title text-center w-75">Company List</h3>
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
                                                <h4 class="modal-title">Add Company Information</h4>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            </div>
                                            <div class="modal-body">
                                                {!! Form::open([
                                                    'action' => ['\App\Http\Controllers\Library\General\CompanyController@store', 'method' => 'Post'],
                                                ]) !!}
                                                @if (!empty(Session::get('error_code')) && Session::get('error_code') == 'Add')
                                                    @include('layout/flash-message')
                                                @endif
                                                <div class="row" style="padding-left: 0px; padding-right: 0px;">
                                                    <!-- <div class="col-md-6">
                                                        <div class="form-group row">
                                                            <label for="Name" class="col-sm-3 col-form-label">Name</label>
                                                            <div class="col-sm-9">
                                                                {!! Form::text('Name', null, [
                                                                    'required',
                                                                    'class' => 'form-control',
                                                                    'id' => 'Name',
                                                                    'maxlength' => '100',
                                                                    'placeholder' => 'Name',
                                                                    'value' => Input::old('Name'),
                                                                ]) !!}
                                                            </div>
                                                        </div>
                                                    </div> -->
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="Name">Name</label>
                                                            <div class="controls">
                                                                {!! Form::text('Name', null, [
                                                                    'required',
                                                                    'class' => 'form-control',
                                                                    'id' => 'Name',
                                                                    'maxlength' => '100',
                                                                    'placeholder' => 'Name',
                                                                    'value' => Input::old('Name'),
                                                                ]) !!}
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="Address">Address</label>
                                                            <div class="controls">
                                                                {!! Form::text('Address', null, [
                                                                    'required',
                                                                    'class' => 'form-control',
                                                                    'id' => 'Address',
                                                                    'maxlength' => '100',
                                                                    'placeholder' => 'Address',
                                                                    'value' => Input::old('Address'),
                                                                ]) !!}
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="Email">Email</label>
                                                            <div class="controls">
                                                                {!! Form::email('Email', null, [
                                                                    'required',
                                                                    'class' => 'form-control',
                                                                    'id' => 'Email',
                                                                    'maxlength' => '100',
                                                                    'placeholder' => 'Email',
                                                                    'value' => Input::old('Email'),
                                                                ]) !!}
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="Phone">Phone</label>
                                                            <div class="controls">
                                                                {!! Form::text('Phone', null, [
                                                                    'required',
                                                                    'class' => 'form-control',
                                                                    'id' => 'Phone',
                                                                    'maxlength' => '11',
                                                                    'placeholder' => 'Phone',
                                                                    'value' => Input::old('Phone'),
                                                                ]) !!}
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="Owner">Owner</label>
                                                            <div class="controls">
                                                                {!! Form::text('Owner', null, [
                                                                    'required',
                                                                    'class' => 'form-control',
                                                                    'id' => 'Owner',
                                                                    'maxlength' => '100',
                                                                    'placeholder' => 'Owner',
                                                                    'value' => Input::old('Owner'),
                                                                ]) !!}
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="C4S">Status</label>
                                                            <div class="controls">
                                                                {!! Form::select('C4S', getStatus(1), null, [
                                                                    'required',
                                                                    'class' => 'form-control',
                                                                    'id' => 'C4S',
                                                                    'placeholder' => 'Select One',
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
                                                    <th>Name</th>
                                                    <th>Address</th>
                                                    <th>Email</th>
                                                    <th>Phone</th>
                                                    <th>Owner</th>
                                                    <th>Status</th>
                                                    <th style="width: 120px;">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($users as $user)
                                                    <tr>
                                                        <td>{!! $user->id !!}</td>
                                                        <td>{!! $user->Name !!}</td>
                                                        <td>{!! $user->Address !!}</td>
                                                        <td>{!! $user->Email !!}</td>
                                                        <td>{!! $user->Phone !!}</td>
                                                        <td>{!! $user->Owner !!}</td>
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
                                                                            Are you sure you want to delete this Company:
                                                                            <strong
                                                                                style="color: darkorange">{{ $user->Name }}</strong>
                                                                            ?
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            {!! Form::open(['url' => 'library/general/company/' . $user->id]) !!}
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
                                                                            <h4 class="modal-title">Edit Company
                                                                                Information,
                                                                                Name: {!! $user->Name !!}</h4>
                                                                            <button type="button" class="close"
                                                                                data-dismiss="modal"
                                                                                aria-label="Close"><span
                                                                                    aria-hidden="true">&times;</span></button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            {!! Form::open(['url' => 'library/general/company/' . $user->id]) !!}
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
                                                                                            {!! Form::text('Name', $user->Name, [
                                                                                                'required',
                                                                                                'class' => 'form-control',
                                                                                                'id' => 'Name',
                                                                                                'maxlength' => '100',
                                                                                                'placeholder' => 'Name',
                                                                                                'value' => Input::old('Name'),
                                                                                            ]) !!}
                                                                                        </div>
                                                                                    </div>
                                                                                </div> -->
                                                                                <div class="col-md-6">
                                                                                    <div class="form-group">
                                                                                        <label for="Name">Name</label>
                                                                                        <div class="controls">
                                                                                            {!! Form::text('Name', $user->Name, [
                                                                                                'required',
                                                                                                'class' => 'form-control',
                                                                                                'id' => 'Name',
                                                                                                'maxlength' => '100',
                                                                                                'placeholder' => 'Name',
                                                                                                'value' => Input::old('Name'),
                                                                                            ]) !!}
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-6">
                                                                                    <div class="form-group">
                                                                                        <label
                                                                                            for="Address">Address</label>
                                                                                        <div class="controls">
                                                                                            {!! Form::text('Address', $user->Address, [
                                                                                                'required',
                                                                                                'class' => 'form-control',
                                                                                                'id' => 'Address',
                                                                                                'maxlength' => '100',
                                                                                                'placeholder' => 'Address',
                                                                                                'value' => Input::old('Address'),
                                                                                            ]) !!}
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-6">
                                                                                    <div class="form-group">
                                                                                        <label for="Email">Email</label>
                                                                                        <div class="controls">
                                                                                            {!! Form::email('Email', $user->Email, [
                                                                                                'required',
                                                                                                'class' => 'form-control',
                                                                                                'id' => 'Email',
                                                                                                'maxlength' => '100',
                                                                                                'placeholder' => 'Email',
                                                                                                'value' => Input::old('Email'),
                                                                                            ]) !!}
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-6">
                                                                                    <div class="form-group">
                                                                                        <label for="Phone">Phone</label>
                                                                                        <div class="controls">
                                                                                            {!! Form::text('Phone', $user->Phone, [
                                                                                                'required',
                                                                                                'class' => 'form-control',
                                                                                                'id' => 'Phone',
                                                                                                'maxlength' => '50',
                                                                                                'placeholder' => 'Phone',
                                                                                                'value' => Input::old('Phone'),
                                                                                            ]) !!}
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-6">
                                                                                    <div class="form-group">
                                                                                        <label for="Owner">Owner</label>
                                                                                        <div class="controls">
                                                                                            {!! Form::text('Owner', $user->Owner, [
                                                                                                'required',
                                                                                                'class' => 'form-control',
                                                                                                'id' => 'Owner',
                                                                                                'maxlength' => '100',
                                                                                                'placeholder' => 'Owner',
                                                                                                'value' => Input::old('Owner'),
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
                                                                                                'placeholder' => 'Select One',
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
