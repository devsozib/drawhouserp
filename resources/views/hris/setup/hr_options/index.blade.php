@extends('layout.app')
@section('title', 'HRIS | Department')
@section('content')
@include('layout/datatable')

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    {{-- <h1 class="m-0">HR Options</h1> --}}
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{!! url('hris/dashboard') !!}">HRIS</a></li>
                        <li class="breadcrumb-item"><a href="javascript::void(0)">Setup</a></li>
                        <li class="breadcrumb-item"><a href="{!! url('hris/setup/hr_options') !!}">HR Options</a></li>
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
                            <h3 class="card-title text-center w-75">HR Options</h3>
                            {{-- @if ($create)
                                <div class="float-right"><a role="button" data-toggle="modal" data-target="#add-modal"
                                        class="btn-sm bg-gradient-success" title="Add"><i
                                            class="fas fa-plus"></i>&nbsp;Add</a></div>

                                <!--Add Form Here-->
                                <div class="modal fade" id="add-modal" role="dialog">
                                    <div class="modal-dialog modal-lg ">
                                        <!-- Modal content-->
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title">Add Department</h4>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            </div>
                                            <div class="modal-body">
                                                {!! Form::open([
                                                    'action' => ['\App\Http\Controllers\HRIS\Setup\DepartmentController@store', 'method' => 'Post'],
                                                ]) !!}
                                                @if (!empty(Session::get('error_code')) && Session::get('error_code') == 'Add')
                                                    @include('layout/flash-message')
                                                @endif
                                                <div class="row" style="padding-left: 0px; padding-right: 0px;">
                                                    <!-- <div class="col-md-6">
                                                        <div class="form-group row">
                                                            <label for="Name" class="col-sm-3 col-form-label">Name</label>
                                                            <div class="col-sm-9">
                                                                {!! Form::text('Department', null, [
                                                                    'required',
                                                                    'class' => 'form-control',
                                                                    'id' => 'Department',
                                                                    'maxlength' => '100',
                                                                    'placeholder' => 'Department',
                                                                    'value' => Input::old('Department'),
                                                                ]) !!}
                                                            </div>
                                                        </div>
                                                    </div> -->
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="Department">Department</label>
                                                            <div class="controls">
                                                                {!! Form::text('Department', null, [
                                                                    'required',
                                                                    'class' => 'form-control',
                                                                    'id' => 'Department',
                                                                    'maxlength' => '100',
                                                                    'placeholder' => 'Department',
                                                                    'value' => Input::old('Department'),
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
                            @endif --}}
                        </div>
                        <div class="card-body" style="overflow-x: scroll;">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div style="min-height: 400px;">
                                        <table class="table table-bordered table-striped datatbl" id="usertbl">
                                            <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Basic (%)</th>
                                                    <th>HRent (%)</th>
                                                    <th>Med (%)</th>
                                                    <th>Conv (%)</th>
                                                    <th>Join to Confirm</th>
                                                    <th>Default Shift</th>
                                                    <th>Check Leave Limit</th>
                                                    <th>Year</th>
                                                    <th>Month</th>
                                                    <th>E-Phone</th>
                                                    <th>Single Punch Absent</th>
                                                    <th style="width: 120px;">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($users as $user)
                                                    <tr>
                                                        <td>{!! $user->id !!}</td>
                                                        <td>{!! $user->BasicPer !!}</td>
                                                        <td>{!! $user->HRentPer !!}</td>
                                                        <td>{!! $user->MedPer !!}</td>
                                                        <td>{!! $user->ConvPer !!}</td>
                                                        <td>{!! $user->JoiningToConfirm !!}</td>
                                                        <td>{!! $shiftlist[$user->DefaultShift] !!}</td>
                                                        <td>{!! getStatus(1)[$user->CheckLeaveLimit] !!}</td>
                                                        <td>{!! $user->Year !!}</td>
                                                        <td>{!! getMonthName($user->Month) !!}</td>
                                                        <td>{!! $user->EPhone !!}</td>
                                                        <td>{!! getStatus(1)[$user->SinglePunchAbsent] !!}</td>
                                                        <td>
                                                            @if ($edit)
                                                                <a role="button" data-toggle="modal"
                                                                    data-target="#edit-modal{{ $user->id }}"
                                                                    class="btn-sm bg-gradient-info" title="Edit"><i
                                                                        class="fas fa-edit"></i></a>
                                                            @endif

                                                            <!--Edit Form Here-->
                                                            <div class="modal fade"
                                                                id="edit-modal{!! $user->id !!}" role="dialog">
                                                                <div class="modal-dialog modal-lg ">
                                                                    <!-- Modal content-->
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h4 class="modal-title">Edit HR Options</h4>
                                                                            <button type="button" class="close"
                                                                                data-dismiss="modal"
                                                                                aria-label="Close"><span
                                                                                    aria-hidden="true">&times;</span></button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            {!! Form::open(['url' => 'hris/setup/hr_options/' . $user->id]) !!}
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
                                                                                        <label for="BasicPer">Basic (%)</label>
                                                                                        <div class="controls">
                                                                                            {!! Form::number('BasicPer', $user->BasicPer, [
                                                                                                'required',
                                                                                                'class' => 'form-control',
                                                                                                'id' => 'BasicPer',
                                                                                                'maxlength' => '100',
                                                                                                'placeholder' => 'BasicPer',
                                                                                                'value' => Input::old('BasicPer'),
                                                                                            ]) !!}
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-3">
                                                                                    <div class="form-group">
                                                                                        <label for="HRentPer">HRent (%)</label>
                                                                                        <div class="controls">
                                                                                            {!! Form::number('HRentPer', $user->HRentPer, [
                                                                                                'required',
                                                                                                'class' => 'form-control',
                                                                                                'id' => 'HRentPer',
                                                                                                'maxlength' => '100',
                                                                                                'placeholder' => 'HRentPer',
                                                                                                'value' => Input::old('HRentPer'),
                                                                                            ]) !!}
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-3">
                                                                                    <div class="form-group">
                                                                                        <label for="MedPer">Med (%)</label>
                                                                                        <div class="controls">
                                                                                            {!! Form::number('MedPer', $user->MedPer, [
                                                                                                'required',
                                                                                                'class' => 'form-control',
                                                                                                'id' => 'MedPer',
                                                                                                'maxlength' => '100',
                                                                                                'placeholder' => 'MedPer',
                                                                                                'value' => Input::old('MedPer'),
                                                                                            ]) !!}
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-3">
                                                                                    <div class="form-group">
                                                                                        <label for="ConvPer">Conv (%)</label>
                                                                                        <div class="controls">
                                                                                            {!! Form::number('ConvPer', $user->ConvPer, [
                                                                                                'required',
                                                                                                'class' => 'form-control',
                                                                                                'id' => 'ConvPer',
                                                                                                'maxlength' => '100',
                                                                                                'placeholder' => 'ConvPer',
                                                                                                'value' => Input::old('ConvPer'),
                                                                                            ]) !!}
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-3">
                                                                                    <div class="form-group">
                                                                                        <label for="JoiningToConfirm">Join to Confirm</label>
                                                                                        <div class="controls">
                                                                                            {!! Form::number('JoiningToConfirm', $user->JoiningToConfirm, [
                                                                                                'required',
                                                                                                'class' => 'form-control',
                                                                                                'id' => 'JoiningToConfirm',
                                                                                                'maxlength' => '100',
                                                                                                'placeholder' => 'JoiningToConfirm',
                                                                                                'value' => Input::old('JoiningToConfirm'),
                                                                                            ]) !!}
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-3">
                                                                                    <div class="form-group">
                                                                                        <label for="DefaultShift">Default Shift</label>
                                                                                        <div class="controls">
                                                                                            {!! Form::select('DefaultShift', $shiftlist, $user->DefaultShift, [
                                                                                                'required',
                                                                                                'class' => 'form-control',
                                                                                                'id' => 'DefaultShift',
                                                                                                'maxlength' => '1',
                                                                                                'placeholder' => 'Select One',
                                                                                                'value' => Input::old('DefaultShift'),
                                                                                            ]) !!}
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-3">
                                                                                    <div class="form-group">
                                                                                        <label for="CheckLeaveLimit">Check Leave Limit</label>
                                                                                        <div class="controls">
                                                                                            {!! Form::select('CheckLeaveLimit', getStatus(1), $user->CheckLeaveLimit, [
                                                                                                'required',
                                                                                                'class' => 'form-control',
                                                                                                'id' => 'CheckLeaveLimit',
                                                                                                'maxlength' => '1',
                                                                                                'placeholder' => 'Select One',
                                                                                                'value' => Input::old('CheckLeaveLimit'),
                                                                                            ]) !!}
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-3">
                                                                                    <div class="form-group">
                                                                                        <label for="EPhone">E-Phone</label>
                                                                                        <div class="controls">
                                                                                            {!! Form::number('EPhone', $user->EPhone, [
                                                                                                'required',
                                                                                                'class' => 'form-control',
                                                                                                'id' => 'EPhone',
                                                                                                'maxlength' => '100',
                                                                                                'placeholder' => 'EPhone',
                                                                                                'value' => Input::old('EPhone'),
                                                                                            ]) !!}
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-3">
                                                                                    <div class="form-group">
                                                                                        <label for="Year">Year</label>
                                                                                        <div class="controls">
                                                                                            {!! Form::number('Year', $user->Year, [
                                                                                                'required',
                                                                                                'class' => 'form-control',
                                                                                                'id' => 'Year',
                                                                                                'maxlength' => '100',
                                                                                                'placeholder' => 'Year',
                                                                                                'value' => Input::old('Year'),
                                                                                            ]) !!}
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-3">
                                                                                    <div class="form-group">
                                                                                        <label for="Month">Month</label>
                                                                                        <div class="controls">
                                                                                            {!! Form::selectMonth('Month', $user->Month, [
                                                                                                'required',
                                                                                                'class' => 'form-control',
                                                                                                'id' => 'Month',
                                                                                                'placeholder' => 'Select Month',
                                                                                                'value' => Input::old('Month'),
                                                                                            ]) !!}
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-3">
                                                                                    <div class="form-group">
                                                                                        <label for="SinglePunchAbsent">Single Punch Absent</label>
                                                                                        <div class="controls">
                                                                                            {!! Form::select('SinglePunchAbsent',getStatus(1), $user->SinglePunchAbsent, [
                                                                                                'required',
                                                                                                'class' => 'form-control',
                                                                                                'id' => 'SinglePunchAbsent',
                                                                                                'maxlength' => '1',
                                                                                                'placeholder' => 'Select One',
                                                                                                'value' => Input::old('SinglePunchAbsent'),
                                                                                            ]) !!}
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
