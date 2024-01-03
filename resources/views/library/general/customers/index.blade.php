@extends('layout.app')
@section('title', 'Library | Customer')
@section('content')
    @include('layout/datatable')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Customer</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{!! url('library/dashboard') !!}">Library</a></li>
                        <li class="breadcrumb-item"><a href="javascript::void(0)">General</a></li>
                        <li class="breadcrumb-item"><a href="{!! url('library/general/customers') !!}">Customer</a></li>
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
                        <h3 class="card-title text-center w-75">Customer List</h3>
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
                                            <h4 class="modal-title">Add Customer Information</h4>
                                            <button type="button" class="close" data-dismiss="modal"
                                                aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        </div>
                                        <div class="modal-body">
                                            {!! Form::open([
                                                'action' => ['\App\Http\Controllers\Library\General\CustomerController@store', 'method' => 'Post'],
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
                                                        <label for="name">Name</label>
                                                        <div class="controls">
                                                            {!! Form::text('name', null, [
                                                                'class' => 'form-control',
                                                                'id' => 'name',
                                                                'maxlength' => '100',
                                                                'placeholder' => 'name',
                                                                'value' => Input::old('name'),
                                                            ]) !!}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="email">Email</label>
                                                        <div class="controls">
                                                            {!! Form::email('email', null, [
                                                                'class' => 'form-control',
                                                                'id' => 'email',
                                                                'maxlength' => '100',
                                                                'placeholder' => 'Email',
                                                                'value' => Input::old('email'),
                                                            ]) !!}
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="phone">Phone</label>
                                                        <div class="controls">
                                                            {!! Form::text('phone', null, [
                                                                'required',
                                                                'class' => 'form-control',
                                                                'id' => 'phone',
                                                                'maxlength' => '20',
                                                                'placeholder' => 'Phone',
                                                                'value' => Input::old('phone'),
                                                            ]) !!}
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="dob">Date of Birth</label>
                                                        <div class="controls">
                                                            {!! Form::text('dob', null, [
                                                                'class' => 'form-control datepicker',
                                                                'id' => 'dob',
                                                                'maxlength' => '100',
                                                                'placeholder' => 'Date of Birth',
                                                                'value' => Input::old('dob'),
                                                            ]) !!}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="mra">Marriage Anniversary</label>
                                                        <div class="controls">
                                                            {!! Form::text('mra', null, [
                                                                'class' => 'form-control datepicker',
                                                                'id' => 'mra',
                                                                'maxlength' => '100',
                                                                'placeholder' => 'Marriage Anniversary',
                                                                'value' => Input::old('mra'),
                                                            ]) !!}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="address">Address</label>
                                                        <div class="controls">
                                                            {!! Form::text('address', null, [
                                                                'class' => 'form-control',
                                                                'id' => 'address',
                                                                'maxlength' => '100',
                                                                'placeholder' => 'Address',
                                                                'value' => Input::old('address'),
                                                            ]) !!}
                                                        </div>
                                                    </div>
                                                </div>
                                                {{-- <div class="col-lg-4">
                                                    <div class="form-group">
                                                        <label for="password">Password</label>
                                                        <div class="controls">
                                                            {!! Form::password('password', [
                                                                'required',
                                                                'class' => 'form-control',
                                                                'id' => 'password',
                                                                'maxlength' => '100',
                                                                'placeholder' => 'Password',
                                                                'value' => Input::old('password'),
                                                            ]) !!}
                                                        </div>
                                                    </div>

                                                </div> --}}
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="status">Status</label>
                                                        <div class="controls">
                                                            {!! Form::select('status', getStatus(2), null, [
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
                                    <table class="table table-bordered table-striped datatbl" id="customertbl">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Phone</th>
                                                <th>Date of Birth</th>
                                                <th>Marriage Anniversary</th>
                                                <th>Address</th>
                                                <th>Status</th>
                                                <th style="width: 120px;">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($customers as $customer)
                                                <tr>
                                                    <td>{!! $customer->id !!}</td>
                                                    <td>{!! $customer->name !!}</td>
                                                    <td>{!! $customer->email !!}</td>
                                                    <td>{!! $customer->phone !!}</td>
                                                    <td>{!! $customer->dob !!}</td>
                                                    <td>{!! $customer->mra !!}</td>
                                                    <td>{!! $customer->address !!}</td>
                                                    <td>{!! getC4S($customer->status) !!}</td>
                                                    <td>
                                                        @if ($edit)
                                                            <a role="button" data-toggle="modal"
                                                                data-target="#edit-modal{{ $customer->id }}"
                                                                class="btn-sm bg-gradient-info" title="Edit"><i
                                                                    class="fas fa-edit"></i></a>
                                                        @endif
                                                        @if ($delete)
                                                            <a role="button" data-toggle="modal"
                                                                data-target="#delete-modal{{ $customer->id }}"
                                                                class="btn-sm bg-gradient-danger" title="Delete"><i
                                                                    class="fas fa-times"></i></a>
                                                        @endif
                                                        {{-- @if ($profile) --}}
                                                            <a href="{{ url('/customer_profile/' . $customer->id) }}" role="button" 
                                                                data-target="{{ $customer->id }}" class="btn-sm bg-gradient-success" title="Edit Profile"><i
                                                                    class=""></i>Profile</a>
                                                        {{-- @endif --}}

                                                        <!--Delete-->
                                                        <div class="modal fade" id="delete-modal{!! $customer->id !!}"
                                                            role="dialog">
                                                            <div class="modal-dialog modal-md">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h4 class="modal-title">Warning!!!</h4>
                                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        Are you sure you want to delete this Customer:
                                                                        <strong
                                                                            style="color: darkorange">{{ $customer->name }}</strong>
                                                                        ?
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        {!! Form::open(['url' => 'library/general/customers/' . $customer->id]) !!}
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
                                                        <div class="modal fade" id="edit-modal{!! $customer->id !!}"
                                                            role="dialog">
                                                            <div class="modal-dialog modal-lg">
                                                                <!-- Modal content-->
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h4 class="modal-title">Edit Customer Information, Name: {!! $customer->name !!}</h4>
                                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        {!! Form::open(['url' => 'library/general/customers/' . $customer->id]) !!}
                                                                        {!! Form::hidden('_method', 'PATCH') !!}
                                                                        @if (!empty(Session::get('error_code')) && Session::get('error_code') == $customer->id)
                                                                            @include('layout/flash-message')
                                                                        @endif
                                                                        <div class="row"
                                                                            style="padding-left: 0px; padding-right: 0px;">
                                                                            <div class="col-md-6">
                                                                                <div class="form-group">
                                                                                    <label for="name">Name</label>
                                                                                    <div class="controls">
                                                                                        {!! Form::text('name', $customer->name, [
                                                                                            'class' => 'form-control',
                                                                                            'id' => 'Name',
                                                                                            'maxlength' => '100',
                                                                                            'placeholder' => 'Name',
                                                                                            'value' => Input::old('name'),
                                                                                        ]) !!}
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <div class="col-md-6">
                                                                                <div class="form-group">
                                                                                    <label for="Email">Email</label>
                                                                                    <div class="controls">
                                                                                        {!! Form::email('email', $customer->email, [
                                                                                            'class' => 'form-control',
                                                                                            'id' => 'email',
                                                                                            'maxlength' => '100',
                                                                                            'placeholder' => 'Email',
                                                                                            'value' => Input::old('email'),
                                                                                        ]) !!}
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-4">
                                                                                <div class="form-group">
                                                                                    <label for="phone">Phone</label>
                                                                                    <div class="controls">
                                                                                        {!! Form::text('phone', $customer->phone, [
                                                                                            'class' => 'form-control',
                                                                                            'id' => 'phone',
                                                                                            'maxlength' => '50',
                                                                                            'placeholder' => 'Phone',
                                                                                            'value' => Input::old('phone'),
                                                                                        ]) !!}
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-4">
                                                                                <div class="form-group">
                                                                                    <label for="dob">Date of
                                                                                        Birth</label>
                                                                                    <div class="controls">
                                                                                        {!! Form::text('dob', $customer->dob, [
                                                                                            'class' => 'form-control datepicker',
                                                                                            'id' => 'dob',
                                                                                            'maxlength' => '10',
                                                                                            'placeholder' => 'Date of Birth',
                                                                                            'value' => Input::old('dob'),
                                                                                        ]) !!}
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-4">
                                                                                <div class="form-group">
                                                                                    <label for="mra">Marriage Anniversary</label>
                                                                                    <div class="controls">
                                                                                        {!! Form::text('mra', $customer->mra, [
                                                                                            'class' => 'form-control datepicker',
                                                                                            'id' => 'mra',
                                                                                            'maxlength' => '100',
                                                                                            'placeholder' => 'Marriage Anniversary',
                                                                                            'value' => Input::old('mra'),
                                                                                        ]) !!}
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-6">
                                                                                <div class="form-group">
                                                                                    <label for="address">Address</label>
                                                                                    <div class="controls">
                                                                                        {!! Form::text('address', $customer->address, [
                                                                                            'class' => 'form-control',
                                                                                            'id' => 'address',
                                                                                            'maxlength' => '100',
                                                                                            'placeholder' => 'Address',
                                                                                            'value' => Input::old('address'),
                                                                                        ]) !!}
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-3">
                                                                                <div class="form-group">
                                                                                    <label for="status">Status</label>
                                                                                    <div class="controls">
                                                                                        {!! Form::select('status', getStatus(2), $customer->status, [
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
                                                        @if (!empty(Session::get('error_code')) && Session::get('error_code') == $customer->id)
                                                            <script>
                                                                $(function() {
                                                                    $('#edit-modal{{ $customer->id }}').modal('show');
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
