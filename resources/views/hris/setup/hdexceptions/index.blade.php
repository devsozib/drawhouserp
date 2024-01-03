@extends('layout.app')
@section('title', 'HRIS | Holiday Exception')
@section('content')
    @include('layout/datatable')

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"></h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{!! url('hris/dashboard') !!}">HRIS</a></li>
                        <li class="breadcrumb-item"><a href="javascript::void(0)">Setup</a></li>
                        <li class="breadcrumb-item"><a href="{!! url('hris/setup/hdexceptions ') !!}">Holiday Exception</a></li>
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
                        <h3 class="card-title text-center w-75">Holiday Exception</h3>
                        @if ($create)
                            <div class="float-right"><a role="button" data-toggle="modal" data-target="#add-modal"
                                    class="btn-sm bg-gradient-success" title="Add"><i
                                        class="fas fa-plus"></i>&nbsp;Add</a></div>
                            @endif

                            <!--Add Form Here-->
                            <div class="modal fade" id="add-modal" role="dialog">
                                <div class="modal-dialog modal-lg ">
                                    <!-- Modal content-->
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title">Add Holiday Exception</h4>
                                            <button type="button" class="close" data-dismiss="modal"
                                                aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        </div>
                                        <div class="modal-body">
                                            {!! Form::open([
                                                'action' => ['\App\Http\Controllers\HRIS\Setup\HDExceptionController@store', 'method' => 'Post'],
                                            ]) !!}
                                            @if (!empty(Session::get('error_code')) && Session::get('error_code') == 'Add')
                                                @include('layout/flash-message')
                                            @endif
                                            <div class="row" style="padding-left: 0px; padding-right: 0px;">
                                               
                                                <div class="col-md-3">
                                                    <div class="form-group {!! $errors->has('EmployeeID') ? 'has-error' : '' !!}">
                                                        <label for="EmployeeID">Employee ID</label>
                                                        <div class="controls">
                                                            {!! Form::number('EmployeeID', null, [
                                                                'required',
                                                                'class' => 'form-control',
                                                                'id' => 'EmployeeID',
                                                                'min' => '100',
                                                                'max' => '999999',
                                                                'placeholder' => 'Employee ID',
                                                                'value' => Input::old('EmployeeID'),
                                                            ]) !!}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group {!! $errors->has('Name') ? 'has-error' : '' !!}">
                                                        <label for="Name">Name</label>
                                                        <div class="controls">
                                                            {!! Form::text('Name', null, [
                                                                'readonly',
                                                                'class' => 'form-control',
                                                                'id' => 'Name',
                                                                'placeholder' => 'Employee Name',
                                                                'value' => Input::old('Name'),
                                                            ]) !!}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="WeeklyHoliday">Select Date</label>
                                                        <div class="controls">
                                                            <input type="date" 
                                                                   class="form-control datepicker" 
                                                                   id="WeeklyHoliday" 
                                                                   name="WeeklyHoliday"
                                                                   required 
                                                                   value="{{ old('WeeklyHoliday') }}" 
                                                                   placeholder="Select Date">
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
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                        </div>
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
                    <div class="card-body" style="overflow-x: scroll;">
                        <div class="row">
                            <div class="col-lg-12">
                                <div style="min-height: 400px;">
                                    <table class="table table-bordered table-striped datatbl" id="usertbl">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Employee ID</th>
                                                <th>Name</th>
                                                <th>Date</th>
                                                <th>Status</th>
                                                <th style="width: 120px;">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($users as $user)
                                                <tr>
                                                    <td>{!! $user->id !!}</td>
                                                    <td>{!! $user->EmployeeID !!}</td>
                                                    <td>{!! getEmpName($user->EmployeeID)->Name !!}</td>
                                                    <td>{!! \Carbon\Carbon::parse($user->WeeklyHoliday)->format('d-m-Y, l') !!}</td>
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
                                                        <div class="modal fade" id="delete-modal{!! $user->id !!}"
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
                                                                        Are you sure you want to delete this Holiday Exception:
                                                                        <strong
                                                                            style="color: darkorange">{{ $user->EmployeeID }}</strong>
                                                                        ?
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        {!! Form::open(['url' => 'hris/setup/hdexceptions/' . $user->id]) !!}
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
                                                        <div class="modal fade" id="edit-modal{!! $user->id !!}"
                                                            role="dialog">
                                                            <div class="modal-dialog modal-lg ">
                                                                <!-- Modal content-->
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h4 class="modal-title">Edit Holiday Exception,
                                                                            Holiday Exception: {!! $user->WeeklyHoliday !!}</h4>
                                                                        <button type="button" class="close"
                                                                            data-dismiss="modal" aria-label="Close"><span
                                                                                aria-hidden="true">&times;</span></button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        {!! Form::open(['url' => 'hris/setup/hdexceptions/' . $user->id]) !!}
                                                                        {!! Form::hidden('_method', 'PATCH') !!}
                                                                        @if (!empty(Session::get('error_code')) && Session::get('error_code') == $user->id)
                                                                            @include('layout/flash-message')
                                                                        @endif
                                                                        <div class="row"
                                                                            style="padding-left: 0px; padding-right: 0px;">
                                                                            <div class="col-md-6">
                                                                                <div class="form-group {!! $errors->has('EmployeeID') ? 'has-error' : '' !!}">
                                                                                    <label for="EmployeeID">Employee ID</label>
                                                                                    <div class="controls">
                                                                                        {!! Form::number('EmployeeID', $user->EmployeeID, [
                                                                                            'readonly',
                                                                                            'class' => 'form-control',
                                                                                            'id' => 'EmployeeID',
                                                                                            'min' => '100',
                                                                                            'max' => '999999',
                                                                                            'placeholder' => 'Employee ID',
                                                                                            'value' => Input::old('EmployeeID'),
                                                                                        ]) !!}
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-6">
                                                                                <div class="form-group {!! $errors->has('Name') ? 'has-error' : '' !!}">
                                                                                    <label for="Name">Name</label>
                                                                                    <div class="controls">
                                                                                        {!! Form::text('Name', getEmpName($user->EmployeeID), [
                                                                                        'readonly',
                                                                                        'class' => 'form-control',
                                                                                        'id' => 'Name',
                                                                                        'placeholder' => 'Employee Name',
                                                                                        'value' => Input::old('Name'),
                                                                                    ]) !!}
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-6">
                                                                                <div class="form-group">
                                                                                    <label for="WeeklyHoliday">Select Date</label>
                                                                                    <div class="controls">
                                                                                        <div class="controls">
                                                                                            {!! Form::date('WeeklyHoliday', $user->WeeklyHoliday, [
                                                                                                'required',
                                                                                                'class' => 'form-control datepicker',
                                                                                                'id' => 'WeeklyHoliday',
                                                                                                'placeholder' => 'Select One',
                                                                                                'value' => Input::old('WeeklyHoliday'),
                                                                                            ]) !!}
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-6">
                                                                                <div class="form-group">
                                                                                    <label for="C4S">Status</label>
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
    <script>
        $('#EmployeeID').on("input", function(event) {
            event.preventDefault();
            var empID = $("#EmployeeID").val();
            if(empID.length >= 4){
                $.ajax({
                    type: "GET",
                    url: "{{ url('hris/database/getemployeeinfo') }}",
                    data: {
                        emp_id: empID,
                        st_date: '00-00-0000',
                    },
                    success: function(data) {
                        if (data) {
                            $("#Name").val(data.Name);
                            return;
                        } 
                    }
                });
            } else {
                $("#Name").val('');
            }
        });
   </script>
@stop

