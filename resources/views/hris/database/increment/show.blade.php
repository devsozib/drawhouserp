@extends('layout.app')
@section('title', 'HRIS | Increment')
@section('content')

    <?php 
        $inputDate = \Carbon\Carbon::now()->subDays(8)->startOfMonth()->format('Y-m-d');
        $effDate = \Carbon\Carbon::now()->subDays(8)->startOfMonth()->format('Y-m-d');
    ?>

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0" style="text-align: right;">Employee Increment || Employee ID: {{ $uniqueincrement->EmployeeID }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{!! url('hris/dashboard') !!}">HRIS</a></li>
                        <li class="breadcrumb-item"><a href="javascript::void(0)">Database</a></li>
                        <li class="breadcrumb-item"><a href="{!! url('hris/database/increment') !!}">Increment</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Show</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="row">
            <div class="col-lg-12">
                <div class="float-right">
                    <table class="table" style="margin-top: -10px; margin-bottom: 0px;">
                        <tr>
                            <td style="width: 50%; border: none;">
                                {!! Form::open(['action' => '\App\Http\Controllers\HRIS\Database\EmployeeController@getSearch']) !!}
                                {!! Form::number('search', null, [
                                    'required',
                                    'class' => 'form-control',
                                    'min' => '000100',
                                    'max' => '999999',
                                    'placeholder' => 'Employee ID',
                                ]) !!}
                                {!! Form::number('TabNo', 1, ['class' => 'form-control hidden', 'id' => 'TabNo']) !!}
                            </td>
                            <td style="width: 25%; border: none;">
                                {!! Form::submit('Search', ['class' => 'btn btn-sm btn-default']) !!}
                                {!! Form::close() !!}
                            </td>
                            <td style="width: 25%; border: none;">
                                <a href="{!! URL('hris/database/employee') !!}" class="btn btn-sm btn-primary" style="float: right;">
                                    <span class="fa-solid fa-arrow-left"></span>&nbsp;Back </a>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <div class="row" style="margin-top: -20px; margin-bottom: 0px;">
            <div class="col-lg-9">
                {!! Form::open(array('action' => array('\App\Http\Controllers\HRIS\Database\IncrementController@store', 'method' => 'Post'))) !!}
                <div class="card">
                    <div class="card-header with-border" style="font-size: 16px;">Input Parameters For  Increment</div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-6">
                                <table class="table table-bordered">
                                    <tbody>
                                        <tr>
                                            <th style="width: 28%">Employee ID</th>
                                            <td style="width: 2%">:</td>
                                            <td style="width: 70%">
                                                <div class="control-group {!! $errors->has('EmployeeID') ? 'has-error' : '' !!}">
                                                    <div class="controls">
                                                        {!! Form::text('EmployeeID', $uniqueincrement->EmployeeID, array('readonly', 'class'=>'form-control', 'id' => 'EmployeeID', 'placeholder'=>'Employee ID', 'value'=>Input::old('EmployeeID'))) !!}
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Name</th>
                                            <td>:</td>
                                            <td>
                                                <div class="control-group {!! $errors->has('Name') ? 'has-error' : '' !!}">
                                                    <div class="controls">
                                                        {!! Form::text('Name', $uniqueincrement->Name, array('readonly', 'class'=>'form-control', 'id' => 'Name', 'placeholder'=>'Employee Name', 'value'=>Input::old('Name'))) !!}
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Joining Date</th>
                                            <td>:</td>
                                            <td>
                                                <div class="control-group {!! $errors->has('JoiningDate') ? 'has-error' : '' !!}">
                                                    <div class="controls">
                                                        {!! Form::text('JoiningDate', $uniqueincrement->JoiningDate, array('readonly', 'class'=>'form-control', 'id' => 'JoiningDate', 'placeholder'=>'Joining Date', 'value'=>Input::old('JoiningDate'))) !!}
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Department</th>
                                            <td>:</td>
                                            <td>
                                                <div class="control-group {!! $errors->has('Department') ? 'has-error' : '' !!}">
                                                    <div class="controls">
                                                        {!! Form::text('Department', $uniqueincrement->Department, array('readonly', 'class'=>'form-control', 'id' => 'Department', 'placeholder'=>'Department', 'value'=>Input::old('Department'))) !!}
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Designation</th>
                                            <td>:</td>
                                            <td>
                                                <div class="control-group {!! $errors->has('Designation') ? 'has-error' : '' !!}">
                                                    <div class="controls">
                                                        {!! Form::text('Designation', $uniqueincrement->Designation, array('readonly', 'class'=>'form-control', 'id' => 'Designation', 'placeholder'=>'Designation', 'value'=>Input::old('Designation'))) !!}
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>New Department</th>
                                            <td>:</td>
                                            <td>
                                                <div class="control-group {!! $errors->has('NewDepartmentID') ? 'has-error' : '' !!}">
                                                    <div class="controls">
                                                        {!! Form::select('NewDepartmentID', $deptlist, $uniqueincrement->DepartmentID, array('required', 'class'=>'form-control select2bs4', 'id' => 'NewDepartmentID', 'placeholder'=>'Select One', 'value'=>Input::old('NewDepartmentID'))) !!}
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>New Designation</th>
                                            <td>:</td>
                                            <td>
                                                <div class="control-group {!! $errors->has('NewDesignationID') ? 'has-error' : '' !!}">
                                                    <div class="controls">
                                                        {!! Form::select('NewDesignationID', $desglist, $uniqueincrement->DesignationID, array('required', 'class'=>'form-control select2bs4', 'id' => 'NewDesignationID', 'placeholder'=>'Select One', 'value'=>Input::old('NewDesignationID'))) !!}
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Remarks</th>
                                            <td>:</td>
                                            <td>
                                                <div class="control-group {!! $errors->has('Remarks') ? 'has-error' : '' !!}">
                                                    <div class="controls">
                                                        {!! Form::text('Remarks', null, array('class'=>'form-control', 'id' => 'Remarks', 'maxlength'=>'50', 'placeholder'=>'Remarks', 'value'=>Input::old('Remarks'))) !!}
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-lg-6">
                                <table class="table table-bordered">
                                    <tbody>
                                        <tr>
                                            <th style="width: 28%">Increment Date</th>
                                            <td style="width: 2%">:</td>
                                            <td style="width: 70%">
                                                <div class="control-group {!! $errors->has('IncrementDate') ? 'has-error' : '' !!}">
                                                    <div class="controls">
                                                        {!! Form::text('IncrementDate', $inputDate, array('required', 'class'=>'form-control datepickerbs4v3', 'id' => 'IncrementDate', 'maxlength'=>'10', 'placeholder'=>'YYYY-MM-DD', 'value'=>Input::old('IncrementDate'))) !!}
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Effective Date</th>
                                            <td>:</td>
                                            <td>
                                                <div class="control-group {!! $errors->has('EffectiveDate') ? 'has-error' : '' !!}">
                                                    <div class="controls">
                                                        {!! Form::text('EffectiveDate', $effDate, array('required', 'class'=>'form-control datepickerbs4v3', 'id' => 'EffectiveDate', 'maxlength'=>'10', 'placeholder'=>'YYYY-MM-DD', 'value'=>Input::old('EffectiveDate'))) !!}
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Arrear Upto Date</th>
                                            <td>:</td>
                                            <td>
                                                <div class="control-group {!! $errors->has('ArrearDate') ? 'has-error' : '' !!}">
                                                    <div class="controls">
                                                        {!! Form::text('ArrearDate', $effDate, array('readonly', 'class'=>'form-control', 'id' => 'ArrearDate', 'maxlength'=>'10', 'placeholder'=>'YYYY-MM-DD', 'value'=>Input::old('ArrearDate'))) !!}
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Inc Source</th>
                                            <td>:</td>
                                            <td>
                                                <div class="control-group {!! $errors->has('IncSource') ? 'has-error' : '' !!}">
                                                    <div class="controls">
                                                        {!! Form::select('IncSource', getIncSource(), null, array('class'=>'form-control', 'id' => 'IncSource', 'value'=>Input::old('IncSource'))) !!}
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Pay Type</th>
                                            <td>:</td>
                                            <td>
                                                <div class="control-group {!! $errors->has('PayType') ? 'has-error' : '' !!}">
                                                    <div class="controls">
                                                        {!! Form::select('PayType', getPayType(), null, array('class'=>'form-control', 'id' => 'PayType', 'value'=>Input::old('PayType'))) !!}
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Increment Amount</th>
                                            <td>:</td>
                                            <td>
                                                <div class="control-group {!! $errors->has('IncrementAmnt') ? 'has-error' : '' !!}">
                                                    <div class="controls">
                                                        {!! Form::number('IncrementAmnt', null, array('class'=>'form-control', 'id' => 'IncrementAmnt', 'min'=>'0', 'max'=>'99999', 'placeholder'=>'Increment Amount', 'value'=>Input::old('IncrementAmnt'))) !!}
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Increment Type</th>
                                            <td>:</td>
                                            <td>
                                                <div class="control-group {!! $errors->has('IncType') ? 'has-error' : '' !!}">
                                                    <div class="controls">
                                                        {!! Form::select('IncType', $inctypelists, null, array('class'=>'form-control', 'id' => 'IncType', 'value'=>Input::old('IncType'))) !!}
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-right" style="margin-top: -20px;">
                        {!! Form::number('formid', 1, array('class'=>'hidden', 'id' => 'formid')) !!}
                        @if($create)
                            {!! Form::submit('Save', array('class' => 'btn btn-success')) !!}
                        @endif
                    </div>
                </div>
                {!! Form::close() !!} 
            </div>
            <div class="col-lg-3">   
                <div class="card">
                    <div class="card-header with-border" style="font-size: 16px;">Salary Information</div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <th style="width: 40%;">Gross Salary</th>
                                    <td style="width: 2%;">:</td>
                                    <td style="width: 58%;">
                                        <div class="control-group">
                                            <div class="controls">
                                                {!! Form::number('GrossSalary', $uniqueincrement->GrossSalary, array('readonly', 'class'=>'form-control', 'id' => 'GrossSalary')) !!}
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Basic</th>
                                    <td>:</td>
                                    <td>
                                        <div class="control-group">
                                            <div class="controls">
                                                {!! Form::number('Basic', $uniqueincrement->Basic, array('readonly', 'class'=>'form-control', 'id' => 'Basic')) !!}
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th>House Rent</th>
                                    <td>:</td>
                                    <td>
                                        <div class="control-group">
                                            <div class="controls">
                                                {!! Form::number('HomeAllowance', $uniqueincrement->HomeAllowance, array('readonly', 'class'=>'form-control', 'id' => 'HomeAllowance')) !!}
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Medical Allow</th>
                                    <td>:</td>
                                    <td>
                                        <div class="control-group">
                                            <div class="controls">
                                                {!! Form::number('MedicalAllowance', $uniqueincrement->MedicalAllowance, array('readonly', 'class'=>'form-control', 'id' => 'MedicalAllowance')) !!}
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Conveyance</th>
                                    <td>:</td>
                                    <td>
                                        <div class="control-group">
                                            <div class="controls">
                                                {!! Form::number('Conveyance', $uniqueincrement->Conveyance, array('readonly', 'class'=>'form-control', 'id' => 'Conveyance')) !!}
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Food Allow</th>
                                    <td>:</td>
                                    <td>
                                        <div class="control-group">
                                            <div class="controls">
                                                {!! Form::number('FoodAllowance', $uniqueincrement->FoodAllowance, array('readonly', 'class'=>'form-control', 'id' => 'FoodAllowance')) !!}
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Housing Allow</th>
                                    <td>:</td>
                                    <td>
                                        <div class="control-group">
                                            <div class="controls">
                                                {!! Form::number('HousingAllowance', $uniqueincrement->HousingAllowance, array('readonly', 'class'=>'form-control', 'id' => 'HousingAllowance')) !!}
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Other Allow</th>
                                    <td>:</td>
                                    <td>
                                        <div class="control-group">
                                            <div class="controls">
                                                {!! Form::number('OtherAllowance', $uniqueincrement->OtherAllowance, array('readonly', 'class'=>'form-control', 'id' => 'OtherAllowance')) !!}
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header with-border" style="font-size: 16px;">Increment History</div>
                    <div class="card-body" style="overflow: auto;">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>SL#</th>
                                    <th>Employee ID</th>
                                    <th>Department</th>
                                    <th>Designation</th>
                                    <th style="text-align: center;">Gross</th>
                                    <th style="text-align: center;">Basic</th>
                                    <th style="text-align: center;">H/Rent</th>
                                    <th style="text-align: center;">Medical</th>
                                    <th style="text-align: center;">Conveyance</th>
                                    <th>Inc. Date</th>
                                    <th>Eff. Date</th>
                                    <th>Arr. Date</th>
                                    <th>Inc. Source</th>
                                    <th>Pay. Type</th>
                                    <th style="text-align: center;">Inc. Amount</th>
                                    <th>Inc. Type</th>
                                    <th>Remarks</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $sl1 = 1; ?>
                                @foreach($indvincs as $indvinc)
                                <tr>
                                    <td>{!! $sl1 !!}</td>
                                    <td>{!! $indvinc->EmployeeID !!}</td>
                                    <td>{!! getDepartment($indvinc->DepartmentID) !!}</td>
                                    <td>{!! getDesignation($indvinc->DesignationID) !!}</td>
                                    <td style="text-align: center;">{!! number_format($indvinc->GrossSalary) !!}</td>
                                    <td style="text-align: center;">{!! number_format($indvinc->Basic) !!}</td>
                                    <td style="text-align: center;">{!! number_format($indvinc->HomeAllowance) !!}</td>
                                    <td style="text-align: center;">{!! number_format($indvinc->MedicalAllowance) !!}</td>
                                    <td style="text-align: center;">{!! number_format($indvinc->Conveyance) !!}</td>
                                    <td>{!! date('d-m-Y', strtotime($indvinc->IncrementDate)) !!}</td>
                                    <td>{!! date('d-m-Y', strtotime($indvinc->EffectiveDate)) !!}</td>
                                    <td>{!! date('d-m-Y', strtotime($indvinc->ArrearDate)) !!}</td>
                                    <td>{!! getIncSource()[$indvinc->IncSource] !!}</td>
                                    <td>{!! getPayType()[$indvinc->PayType] !!}</td>
                                    <td style="text-align: center;">{!! number_format($indvinc->Increment) !!}</td>
                                    <td>{!! getIncType($indvinc->IncType) !!}</td>
                                    <td>{!! $indvinc->Remarks !!}</td>
                                    <td>
                                        @if($indvinc->Enforce == 'N')
                                            @if ($edit)
                                                <a role="button" data-toggle="modal"
                                                    data-target="#indvinc-edit-modal{{ $indvinc->id }}"
                                                    class="btn-sm bg-gradient-info" title="Edit"><i
                                                        class="fas fa-edit"></i></a>
                                            @endif
                                            @if ($delete)
                                                <a role="button" data-toggle="modal"
                                                    data-target="#indvinc-delete-modal{{ $indvinc->id }}"
                                                    class="btn-sm bg-gradient-danger" title="Delete"><i
                                                        class="fas fa-times"></i></a>
                                            @endif
                                        @endif

                                        <!--Delete-->
                                        <div class="modal fade" id="indvinc-delete-modal{!! $indvinc->id !!}" role="dialog">
                                            <div class="modal-dialog modal-md ">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">Warning!!!</h4>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        Are you sure you want to delete  Increment Information : <strong style="color: darkorange">{!! $indvinc->EmployeeID !!}</strong> ?
                                                    </div>
                                                    <div class="modal-footer">
                                                        {!! Form::open(array('url' => 'hris/database/increment/'.$indvinc->id  )) !!}
                                                        {!! Form::hidden('_method', 'DELETE') !!}
                                                        {!! Form::submit('Delete',array('class'=>'btn btn-danger'))  !!}
                                                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                                        {!! Form::close() !!}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!--Edit Form Here-->
                                        <div class="modal fade" id="indvinc-edit-modal{!! $indvinc->id !!}" role="dialog">
                                            <div class="modal-dialog modal-lg ">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">Edit Increment Information, ID: {!! $sl1 !!}</h4>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                    </div>
                                                    <div class="modal-body"> 
                                                        {!! Form::open(array('url' => 'hris/database/increment/'.$indvinc->id)) !!}
                                                        {!! Form::hidden('_method', 'PATCH') !!}
                                                        @if(!empty(Session::get('error_code')) && Session::get('error_code') == $indvinc->id)
                                                            @include('layout/flash-message')
                                                        @endif
                                                        <div class="row">
                                                            <div class="col-lg-6">
                                                                <table class="table table-striped">
                                                                    <tbody>
                                                                        <tr>
                                                                            <th style="width: 33%">Employee ID</th>
                                                                            <td style="width: 2%">:</td>
                                                                            <td style="width: 65%">
                                                                                <div class="control-group {!! $errors->has('EmployeeID') ? 'has-error' : '' !!}">
                                                                                    <div class="controls">
                                                                                        {!! Form::text('EmployeeID', $uniqueincrement->EmployeeID, array('readonly', 'class'=>'form-control', 'id' => 'EmployeeID', 'placeholder'=>'Employee ID', 'value'=>Input::old('EmployeeID'))) !!}
                                                                                    </div>
                                                                                </div>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th>Name</th>
                                                                            <td>:</td>
                                                                            <td>
                                                                                <div class="control-group {!! $errors->has('Name') ? 'has-error' : '' !!}">
                                                                                    <div class="controls">
                                                                                        {!! Form::text('Name', $uniqueincrement->Name, array('readonly', 'class'=>'form-control', 'id' => 'Name', 'placeholder'=>'Employee Name', 'value'=>Input::old('Name'))) !!}
                                                                                    </div>
                                                                                </div>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th>Joining Date</th>
                                                                            <td>:</td>
                                                                            <td>
                                                                                <div class="control-group {!! $errors->has('JoiningDate') ? 'has-error' : '' !!}">
                                                                                    <div class="controls">
                                                                                        {!! Form::text('JoiningDate', $uniqueincrement->JoiningDate, array('readonly', 'class'=>'form-control', 'id' => 'JoiningDate', 'placeholder'=>'Joining Date', 'value'=>Input::old('JoiningDate'))) !!}
                                                                                    </div>
                                                                                </div>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th>Department</th>
                                                                            <td>:</td>
                                                                            <td>
                                                                                <div class="control-group {!! $errors->has('Department') ? 'has-error' : '' !!}">
                                                                                    <div class="controls">
                                                                                        {!! Form::text('Department', $uniqueincrement->Department, array('readonly', 'class'=>'form-control', 'id' => 'Department', 'placeholder'=>'Department', 'value'=>Input::old('Department'))) !!}
                                                                                    </div>
                                                                                </div>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th>Designation</th>
                                                                            <td>:</td>
                                                                            <td>
                                                                                <div class="control-group {!! $errors->has('Designation') ? 'has-error' : '' !!}">
                                                                                    <div class="controls">
                                                                                        {!! Form::text('Designation', $uniqueincrement->Designation, array('readonly', 'class'=>'form-control', 'id' => 'Designation', 'placeholder'=>'Designation', 'value'=>Input::old('Designation'))) !!}
                                                                                    </div>
                                                                                </div>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th>New Department</th>
                                                                            <td>:</td>
                                                                            <td>
                                                                                <div class="control-group {!! $errors->has('NewDepartmentID') ? 'has-error' : '' !!}">
                                                                                    <div class="controls">
                                                                                        {!! Form::select('NewDepartmentID', $deptlist, $indvinc->NewDepartmentID, array('required', 'class'=>'form-control select2bs4', 'id' => 'NewDepartmentID'.$indvinc->id, 'placeholder'=>'Select One', 'value'=>Input::old('NewDepartmentID'))) !!}
                                                                                    </div>
                                                                                </div>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th>New Designation</th>
                                                                            <td>:</td>
                                                                            <td>
                                                                                <div class="control-group {!! $errors->has('NewDesignationID') ? 'has-error' : '' !!}">
                                                                                    <div class="controls">
                                                                                        {!! Form::select('NewDesignationID', $desglist, $indvinc->NewDesignationID, array('required', 'class'=>'form-control select2bs4', 'id' => 'NewDesignationID'.$indvinc->id, 'placeholder'=>'Select One', 'value'=>Input::old('NewDesignationID'))) !!}
                                                                                    </div>
                                                                                </div>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th>Remarks</th>
                                                                            <td>:</td>
                                                                            <td>
                                                                                <div class="control-group {!! $errors->has('Remarks') ? 'has-error' : '' !!}">
                                                                                    <div class="controls">
                                                                                        {!! Form::text('Remarks', $indvinc->Remarks, array('class'=>'form-control', 'id' => 'Remarks', 'maxlength'=>'50', 'placeholder'=>'Remarks', 'value'=>Input::old('Remarks'))) !!}
                                                                                    </div>
                                                                                </div>
                                                                            </td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <table class="table table-striped">
                                                                    <tbody>
                                                                        <tr>
                                                                            <th style="width: 38%">Increment Date</th>
                                                                            <td style="width: 2%">:</td>
                                                                            <td style="width: 60%">
                                                                                <div class="control-group {!! $errors->has('IncrementDate') ? 'has-error' : '' !!}">
                                                                                    <div class="controls">
                                                                                        {!! Form::text('IncrementDate', $indvinc->IncrementDate, array('required', 'class'=>'form-control datepickerbs4v3', 'id' => 'IncrementDate'.$indvinc->id, 'maxlength'=>'10', 'placeholder'=>'YYYY-MM-DD', 'value'=>Input::old('IncrementDate'))) !!}
                                                                                    </div>
                                                                                </div>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th>Effective Date</th>
                                                                            <td>:</td>
                                                                            <td>
                                                                                <div class="control-group {!! $errors->has('EffectiveDate') ? 'has-error' : '' !!}">
                                                                                    <div class="controls">
                                                                                        {!! Form::text('EffectiveDate', $indvinc->EffectiveDate, array('required', 'class'=>'form-control datepickerbs4v3', 'id' => 'EffectiveDate'.$indvinc->id, 'maxlength'=>'10', 'placeholder'=>'YYYY-MM-DD', 'value'=>Input::old('EffectiveDate'))) !!}
                                                                                    </div>
                                                                                </div>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th>Arrear Upto Date</th>
                                                                            <td>:</td>
                                                                            <td>
                                                                                <div class="control-group {!! $errors->has('ArrearDate') ? 'has-error' : '' !!}">
                                                                                    <div class="controls">
                                                                                        {!! Form::text('ArrearDate', $indvinc->ArrearDate, array('readonly', 'class'=>'form-control', 'id' => 'ArrearDate'.$indvinc->id, 'maxlength'=>'10', 'placeholder'=>'YYYY-MM-DD', 'value'=>Input::old('ArrearDate'))) !!}
                                                                                    </div>
                                                                                </div>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th>Inc Source</th>
                                                                            <td>:</td>
                                                                            <td>
                                                                                <div class="control-group {!! $errors->has('IncSource') ? 'has-error' : '' !!}">
                                                                                    <div class="controls">
                                                                                        {!! Form::select('IncSource', getIncSource(), $indvinc->IncSource, array('class'=>'form-control', 'id' => 'IncSource'.$indvinc->id, 'value'=>Input::old('IncSource'))) !!}
                                                                                    </div>
                                                                                </div>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th>Pay Type</th>
                                                                            <td>:</td>
                                                                            <td>
                                                                                <div class="control-group {!! $errors->has('PayType') ? 'has-error' : '' !!}">
                                                                                    <div class="controls">
                                                                                        {!! Form::select('PayType', getPayType(), $indvinc->PayType, array('class'=>'form-control', 'id' => 'PayType'.$indvinc->id, 'value'=>Input::old('PayType'))) !!}
                                                                                    </div>
                                                                                </div>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th>Increment Amount</th>
                                                                            <td>:</td>
                                                                            <td>
                                                                                <div class="control-group {!! $errors->has('IncrementAmnt') ? 'has-error' : '' !!}">
                                                                                    <div class="controls">
                                                                                        {!! Form::number('IncrementAmnt', $indvinc->IncrementAmnt, array('class'=>'form-control', 'id' => 'IncrementAmnt'.$indvinc->id, 'min'=>'0', 'max'=>'99999', 'placeholder'=>'Increment Amount', 'value'=>Input::old('IncrementAmnt'))) !!}
                                                                                    </div>
                                                                                </div>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th>Increment Type</th>
                                                                            <td>:</td>
                                                                            <td>
                                                                                <div class="control-group {!! $errors->has('IncType') ? 'has-error' : '' !!}">
                                                                                    <div class="controls">
                                                                                        {!! Form::select('IncType', $inctypelists, $indvinc->IncType, array('class'=>'form-control', 'id' => 'IncType'.$indvinc->id, 'value'=>Input::old('IncType'))) !!}
                                                                                    </div>
                                                                                </div>
                                                                            </td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        {!! Form::submit('Update', array('class' => 'btn btn-success')) !!}
                                                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                                        {!! Form::close() !!}  
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @if(!empty(Session::get('error_code')) && Session::get('error_code') == $indvinc->id)
                                        <script>
                                            $(function() {
                                                $('#indvinc-edit-modal{{ $indvinc->id }}').modal('show');
                                            });
                                            $('#indvinc-edit-modal{{ $indvinc->id }}').on('hidden.bs.modal', function () {
                                                location.reload();
                                            });
                                        </script>
                                        @endif  
    
                                        <script type="text/javascript">
                                            $('#EffectiveDate{{$indvinc->id}}').on('change',function(e){
                                                var effdate = document.getElementById('EffectiveDate{{$indvinc->id}}').value;
                                                $('#ArrearDate{{$indvinc->id}}').val(effdate);
                                            });
                                        </script>                                   
                                    </td>
                                </tr>
                                <?php $sl1++; ?>
                                @endforeach
                            </tbody>
                        </table>
                    </div>    
                </div>
            </div> 
        </div>
    </div>

    <script type="text/javascript">
        $('#EffectiveDate').on('change',function(e){
            var effdate = document.getElementById('EffectiveDate').value;
            $('#ArrearDate').val(effdate);
        });
    </script>
@stop
