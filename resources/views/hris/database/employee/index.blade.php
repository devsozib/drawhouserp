@extends('layout.app')
@section('title', 'HRIS | Employee')
@section('content')
    @include('layout/datatable')
    <style type="text/css">
        .card-header {
            padding-top: 3px;
            padding-bottom: 14px;
        }
    </style>

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0" style="text-align: right;">Employee</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{!! url('hris/dashboard') !!}">HRIS</a></li>
                        <li class="breadcrumb-item"><a href="javascript::void(0)">Database</a></li>
                        <li class="breadcrumb-item"><a href="{!! url('hris/database/employee') !!}">Employee</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Index</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="row">
            @if (count($empentry) > 0)
            <div class="col-lg-3">
                <div class="card">
                    <div class="card-header with-border">Pending List For File</div>
                    <div class="card-body" style="min-height:487px; max-height:487px; overflow-y:auto;">
                        <div class="accordion" id="faq">
                            <?php $j = 0; ?>
                            @foreach ($departments as $item)
                                <?php
                                $deptdatas = collect($empentry)
                                    ->where('DepartmentID', $item->id)
                                    ->sortByDesc('created_at')
                                    ->all();
                                $dates = collect($deptdatas)
                                    ->unique('created_at')
                                    ->sortByDesc('created_at')
                                    ->pluck('created_at');
                                ?>
                                <div id="faqhead1">
                                    <a href="javascript:void(0)" class="btn btn-header-link collapsed"
                                        data-toggle="collapse" data-target="#one{{ $item->id }}" aria-expanded="true"
                                        aria-controls="one{{ $item->id }}">&nbsp;{{ $item->Department }}</a>
                                </div>
                                <div id="one{{ $item->id }}" class="collapse" aria-labelledby="faqhead1"
                                    data-parent="#faq">
                                    <ul class="list-group ml-3">
                                        @foreach ($dates as $date)
                                            <?php
                                            $pendingData = collect($deptdatas)
                                                ->where('created_at', $date)
                                                ->sortByDesc('created_at')
                                                ->all();
                                            $j++;
                                            ?>
                                            <div id="faqhead2">
                                                <a href="javascript:void(0)" class="btn btn-header-link collapsed"
                                                    data-toggle="collapse" data-target="#two{!! $j !!}"
                                                    aria-expanded="true"
                                                    aria-controls="two{{ $j }}">&nbsp;{{ $date }}</a>
                                            </div>
                                            <div id="two{!! $j !!}" class="collapse" aria-labelledby="faqhead2"
                                                data-parent="#one{{ $item->id }}">
                                                <ul class="list-group ml-3">
                                                    @foreach ($pendingData as $data)
                                                        <li class="list-group-item"
                                                            style="padding-top: 5px; padding-bottom: 5px;"><a
                                                                href="javascript:void(0)"
                                                                onclick="employeeEntry({!! $data->id !!})">&nbsp;{{ $data->id }}
                                                                |
                                                                {{ $data->Name }}</a></li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endforeach
                                    </ul>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            @endif


            <div class="{{ count($empentry) > 0 ? 'col-lg-9' : 'col-lg-12'}}">
                <div class="card">
                    <div class="card-header with-border">
                        <h3 class="card-title w-50">Employee Basic Information</h3>
                        <div class="float-right">
                            <div class="form-group">
                                <table class="table" style="margin-bottom: -35px;">
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
                                        <td style="width: 25%; border: none; text-align: right;">
                                            {!! Form::submit('Search', ['class' => 'btn btn-sm btn-default']) !!}
                                            {!! Form::close() !!}
                                        </td>
                                        <td style="width: 25%; border: none;">
                                            {!! Form::reset('Reset', ['id' => 'Refresh', 'class' => 'btn btn-warning btn-sm']) !!}
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                    {!! Form::open([
                        'action' => ['\App\Http\Controllers\HRIS\Database\EmployeeController@store', 'method' => 'Post'],
                    ]) !!}
                    <div class="card-body" style="padding-bottom: 0;">
                        <div class="row">
                            <div class="col-lg-7">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <table class="table table-striped" width="100%">
                                            <tbody>
                                                <tr>
                                                    <th style="width: 30%">Employee ID</th>
                                                    <td style="width: 70%">
                                                        <div class="form-group {!! $errors->has('EmployeeID') ? 'has-error' : '' !!}">
                                                            <div class="controls">
                                                                @if (Sentinel::inRole('superadmin'))
                                                                    {!! Form::number('EmployeeID', null, [
                                                                        // 'readonly',
                                                                        'class' => 'form-control',
                                                                        'id' => 'EmployeeID',
                                                                        'min' => '000100',
                                                                        'max' => '999999',
                                                                        'placeholder' => 'Employee ID',
                                                                        'value' => Input::old('EmployeeID'),
                                                                    ]) !!}
                                                                @else
                                                                    {!! Form::number('EmployeeID', null, [
                                                                        // 'readonly',
                                                                        'class' => 'form-control',
                                                                        'id' => 'EmployeeID',
                                                                        'min' => '000100',
                                                                        'max' => '999999',
                                                                        'placeholder' => 'Employee ID',
                                                                        'value' => Input::old('EmployeeID'),
                                                                    ]) !!}
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <span class="text-danger" id='check_info'>Employee ID
                                                            Checking</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Department</th>
                                                    <td>
                                                        <div class="form-group {!! $errors->has('DepartmentID') ? 'has-error' : '' !!}">
                                                            <div class="controls">
                                                                <select onchange="getDesignation(this.value)"
                                                                    class="form-control select2bs4" name="DepartmentID"
                                                                    id="department">
                                                                    <option value="" selected>--Choose one--</option>
                                                                    @foreach ($deptlist as $dept)
                                                                    <option {{ $dept->id == old('DepartmentID')?'selected':'' }} value="{{ $dept->id }}">{{ $dept->full_name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Designation</th>
                                                    <td>
                                                        <div class="form-group {!! $errors->has('DesignationID') ? 'has-error' : '' !!}">
                                                            <div class="controls">
                                                                <select class="form-control select2bs4" name="DesignationID"
                                                                    id="designation">
                                                                    <option value="" selected>--Choose one--</option>
                                                                    @foreach ($desglist as $desg)
                                                                    <option {{ $desg->id == old('DesignationID')?'selected':'' }} value="{{ $desg->id }}">{{ $desg->full_name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                {{-- <tr>
                                                    <th>Sub Grade</th>
                                                    <td>
                                                        <div class="form-group {!! $errors->has('SubGrade') ? 'has-error' : '' !!}">
                                                            <div class="controls">
                                                                {!! Form::number('SubGrade', null, [
                                                                    'readonly',
                                                                    'class' => 'form-control',
                                                                    'id' => 'SubGrade',
                                                                    'min' => '0',
                                                                    'max' => '127',
                                                                    'placeholder' => 'Sub Grade',
                                                                    'value' => Input::old('SubGrade'),
                                                                ]) !!}
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr> --}}
                                                <tr>
                                                    <td colspan="2" style="line-height: 1.2em;">
                                                </tr>
                                                <tr>
                                                    <td colspan="2">
                                                        <p
                                                            style="font-weight: 800; color: forestgreen; font-size: 1.2em; padding-left: 5px; line-height: 1em;">
                                                            Mailing Address:</p>
                                                        <table style="width:100%; margin: 0;" class="table">
                                                            <tbody>
                                                                <tr>
                                                                    <th style="width: 35%">District</th>
                                                                    <td style="width: 65%">
                                                                        <div class="form-group {!! $errors->has('MDistrictID') ? 'has-error' : '' !!}">
                                                                            <div class="controls">
                                                                                {!! Form::select('MDistrictID', $districtlist, null, [
                                                                                    'required',
                                                                                    'class' => 'form-control select2bs4',
                                                                                    'id' => 'MDistrictID',
                                                                                    'placeholder' => 'Select One',
                                                                                    'value' => Input::old('MDistrictID'),
                                                                                ]) !!}
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <th>Thana</th>
                                                                    <td>
                                                                        <div class="form-group {!! $errors->has('MThanaID') ? 'has-error' : '' !!}">
                                                                            <div class="controls">
                                                                                {!! Form::select('MThanaID', [], null, [
                                                                                    'required',
                                                                                    'class' => 'form-control select2bs4',
                                                                                    'id' => 'MThanaID',
                                                                                    'placeholder' => 'Select One',
                                                                                    'value' => Input::old('MThanaID'),
                                                                                ]) !!}
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <th>Post Office</th>
                                                                    <td>
                                                                        <div class="form-group {!! $errors->has('MPOffice') ? 'has-error' : '' !!}">
                                                                            <div class="controls">
                                                                                {!! Form::text('MPOffice', null, [
                                                                                    'required',
                                                                                    'class' => 'form-control',
                                                                                    'id' => 'MPOffice',
                                                                                    'maxlength' => '50',
                                                                                    'placeholder' => 'Post Office',
                                                                                    'value' => Input::old('MPOffice'),
                                                                                ]) !!}
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <th>House/Road/Village</th>
                                                                    <td>
                                                                        <div class="form-group {!! $errors->has('MVillage') ? 'has-error' : '' !!}">
                                                                            <div class="controls">
                                                                                {!! Form::text('MVillage', null, [
                                                                                    'required',
                                                                                    'class' => 'form-control',
                                                                                    'id' => 'MVillage',
                                                                                    'maxlength' => '50',
                                                                                    'placeholder' => 'House No/Road No/Village',
                                                                                    'value' => Input::old('MVillage'),
                                                                                ]) !!}
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="col-lg-6">
                                        <table class="table table-striped" width="100%">
                                            <tbody>
                                                {{-- <tr>
                                                    <th style="width: 30%">Line</th>
                                                    <td style="width: 70%">
                                                        <div class="form-group {!! $errors->has('Line') ? 'has-error' : '' !!}">
                                                            <div class="controls">
                                                                {!! Form::number('Line', null, [
                                                                    'class' => 'form-control',
                                                                    'id' => 'Line',
                                                                    'min' => '0',
                                                                    'max' => '127',
                                                                    'placeholder' => 'Line Number',
                                                                    'value' => Input::old('Line'),
                                                                ]) !!}
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr> --}}
                                                {{-- <tr><td colspan="2"><br></td></tr> --}}

                                                <tr>
                                                    <th>Property</th>
                                                    <td>
                                                        <div class="form-group {!! $errors->has('company_id') ? 'has-error' : '' !!}">
                                                            <div class="controls">
                                                                {!! Form::select('company_id', $complists, null, ['required','class'=>'form-control select2bs4', 'id'=>'company_id','placeholder' => 'Select One',
                                                                'value' => Input::old('company_id')]) !!}
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Employment Status</th>
                                                    <td>
                                                        <div class="form-group {!! $errors->has('emp_type') ? 'has-error' : '' !!}">
                                                            <div class="controls">
                                                                {!! Form::select('emp_type', $typelist, null, ['required','class'=>'form-control select2bs4', 'id'=>'emp_type','placeholder' => 'Select One',
                                                                'value' => Input::old('emp_type')]) !!}
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Payment</th>
                                                    <td>
                                                        <div class="form-group {!! $errors->has('Salaried') ? 'has-error' : '' !!}">
                                                            <div class="controls">
                                                                {!! Form::select('Salaried', ['Y' => 'Paid', 'N' => 'Unpaid'], 'Y', [
                                                                    'disabled',
                                                                    'class' => 'form-control',
                                                                    'id' => 'Salaried',
                                                                    'value' => Input::old('Salaried'),
                                                                ]) !!}
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2" style="line-height: 1.2em;">
                                                </tr>
                                                <tr>
                                                    <td colspan="2">
                                                        <p
                                                            style="font-weight: 800; color: forestgreen; font-size: 1.2em; padding-left: 5px; line-height: 1em;">
                                                            Permanent Address:</p>
                                                        <table style="width:100%; margin: 0;" class="table">
                                                            <tr>
                                                                <th style="width: 35%">District</th>
                                                                <td style="width: 65%">
                                                                    <div class="form-group {!! $errors->has('PDistrictID') ? 'has-error' : '' !!}">
                                                                        <div class="controls">
                                                                            {!! Form::select('PDistrictID', $districtlist, null, [
                                                                                'required',
                                                                                'class' => 'form-control select2bs4',
                                                                                'id' => 'PDistrictID',
                                                                                'placeholder' => 'Select One',
                                                                                'value' => Input::old('PDistrictID'),
                                                                            ]) !!}
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th>Thana</th>
                                                                <td>
                                                                    <div class="form-group {!! $errors->has('PThanaID') ? 'has-error' : '' !!}">
                                                                        <div class="controls">
                                                                            {!! Form::select('PThanaID', [], null, [
                                                                                'required',
                                                                                'class' => 'form-control select2bs4',
                                                                                'id' => 'PThanaID',
                                                                                'placeholder' => 'Select One',
                                                                                'value' => Input::old('PThanaID'),
                                                                            ]) !!}
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th>Post Office</th>
                                                                <td>
                                                                    <div class="form-group {!! $errors->has('PPOffice') ? 'has-error' : '' !!}">
                                                                        <div class="controls">
                                                                            {!! Form::text('PPOffice', null, [
                                                                                'required',
                                                                                'class' => 'form-control',
                                                                                'id' => 'PPOffice',
                                                                                'maxlength' => '50',
                                                                                'placeholder' => 'Post Office',
                                                                                'value' => Input::old('PPOffice'),
                                                                            ]) !!}
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th>House/Road/Village</th>
                                                                <td>
                                                                    <div class="form-group {!! $errors->has('PVillage') ? 'has-error' : '' !!}">
                                                                        <div class="controls">
                                                                            {!! Form::text('PVillage', null, [
                                                                                'required',
                                                                                'class' => 'form-control',
                                                                                'id' => 'PVillage',
                                                                                'maxlength' => '50',
                                                                                'placeholder' => 'House No/Road No/Village',
                                                                                'value' => Input::old('PVillage'),
                                                                            ]) !!}
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-5">
                                <table class="table table-striped" width="100%">
                                    <tbody>
                                        <tr>
                                            <th style="width: 25%">Joining Date</th>
                                            <td style="width: 25%">
                                                <div class="form-group {!! $errors->has('JoiningDate') ? 'has-error' : '' !!}">
                                                    <div class="controls">
                                                        {!! Form::text('JoiningDate', null, [
                                                            'required',
                                                            'class' => 'form-control datepickerbs4v1',
                                                            'id' => 'JoiningDate',
                                                            'maxlength' => '10',
                                                            'placeholder' => 'YYYY-MM-DD',
                                                            'value' => Input::old('JoiningDate'),
                                                        ]) !!}
                                                    </div>
                                                </div>
                                            </td>
                                            <th style="width: 25%">Confirmation Date</th>
                                            <td style="width: 25%">
                                                <div class="form-group {!! $errors->has('ConfirmationDate') ? 'has-error' : '' !!}">
                                                    <div class="controls">
                                                        {!! Form::text('ConfirmationDate', null, [
                                                            // 'readonly',
                                                            'class' => 'form-control',
                                                            'id' => 'ConfirmationDate',
                                                            'maxlength' => '10',
                                                            'placeholder' => 'YYYY-MM-DD',
                                                            'value' => Input::old('ConfirmationDate'),
                                                        ]) !!}
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Punch Category</th>
                                            <td>
                                                <div class="form-group {!! $errors->has('PunchCategoryID') ? 'has-error' : '' !!}">
                                                    <div class="controls">
                                                        @if (Sentinel::inRole('superadmin'))
                                                        {!! Form::select('PunchCategoryID', ['0' => 'No Punch', '1' => 'Single Punch', '2' => 'Double Punch'], 2, [
                                                            'required',
                                                            'class' => 'form-control',
                                                            'id' => 'PunchCategoryID',
                                                            'placeholder' => 'Select One',
                                                            'value' => Input::old('PunchCategoryID'),
                                                        ]) !!}
                                                        @else
                                                        {!! Form::select('PunchCategoryID', ['2' => 'Double Punch'], 2, [
                                                            'required',
                                                            'class' => 'form-control',
                                                            'id' => 'PunchCategoryID',
                                                            'placeholder' => 'Select One',
                                                            'value' => Input::old('PunchCategoryID'),
                                                        ]) !!}
                                                        @endif                                                       
                                                    </div>
                                                </div>
                                            </td>
                                            <th>Roaster Duty</th>
                                            <td>
                                                <div class="form-group {!! $errors->has('ShiftingDuty') ? 'has-error' : '' !!}">
                                                    <div class="controls">
                                                        {!! Form::select('ShiftingDuty', ['N' => 'No', 'Y' => 'Yes'], 'N', [
                                                            'class' => 'form-control',
                                                            'id' => 'ShiftingDuty',
                                                            'value' => Input::old('ShiftingDuty'),
                                                        ]) !!}
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Initial Shift</th>
                                            <td>
                                                <div class="form-group {!! $errors->has('ReferenceShift') ? 'has-error' : '' !!}">
                                                    <div class="controls">
                                                        {!! Form::select('ReferenceShift', $shiftlist, 'G', [
                                                            'class' => 'form-control',
                                                            'id' => 'ReferenceShift',
                                                            'placeholder' => 'Select One',
                                                            'value' => Input::old('ReferenceShift'),
                                                        ]) !!}
                                                        {!! Form::text('ShiftReferenceDate', null, [
                                                            'class' => 'form-control hidden',
                                                            'id' => 'ShiftReferenceDate',
                                                            'maxlength' => '10',
                                                            'placeholder' => 'YYYY-MM-DD',
                                                            'value' => Input::old('ShiftReferenceDate'),
                                                        ]) !!}
                                                    </div>
                                                </div>
                                            </td>
                                            <th>Applicant Card#</th>
                                            <td>
                                                <div class="form-group {!! $errors->has('EmpEntryID') ? 'has-error' : '' !!}">
                                                    <div class="controls">
                                                        {!! Form::text('EmpEntryID', null, [
                                                            'readonly',
                                                            'class' => 'form-control',
                                                            'id' => 'EmpEntryID',
                                                            'maxlength' => '50',
                                                            'placeholder' => 'Applicant ID',
                                                            'value' => Input::old('EmpEntryID'),
                                                        ]) !!}
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" style="line-height: 1.2em;">
                                        </tr>
                                        <tr>
                                            <th>Name</th>
                                            <td colspan="3">
                                                <div class="form-group {!! $errors->has('Name') ? 'has-error' : '' !!}">
                                                    <div class="controls">
                                                        {!! Form::text('Name', null, [
                                                            'required',
                                                            'class' => 'form-control',
                                                            'id' => 'Name',
                                                            'maxlength' => '35',
                                                            'placeholder' => 'Employee Name',
                                                            'value' => Input::old('Name'),
                                                        ]) !!}
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Father Name</th>
                                            <td colspan="3">
                                                <div class="form-group {!! $errors->has('Father') ? 'has-error' : '' !!}">
                                                    <div class="controls">
                                                        {!! Form::text('Father', null, [
                                                            'required',
                                                            'class' => 'form-control',
                                                            'id' => 'Father',
                                                            'maxlength' => '35',
                                                            'placeholder' => 'Father Name',
                                                            'value' => Input::old('Father'),
                                                        ]) !!}
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Mother Name</th>
                                            <td colspan="3">
                                                <div class="form-group {!! $errors->has('Mother') ? 'has-error' : '' !!}">
                                                    <div class="controls">
                                                        {!! Form::text('Mother', null, [
                                                            'required',
                                                            'class' => 'form-control',
                                                            'id' => 'Mother',
                                                            'maxlength' => '35',
                                                            'placeholder' => 'Mother Name',
                                                            'value' => Input::old('Mother'),
                                                        ]) !!}
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Spouse Name</th>
                                            <td colspan="3">
                                                <div class="form-group {!! $errors->has('Spouse') ? 'has-error' : '' !!}">
                                                    <div class="controls">
                                                        {!! Form::text('Spouse', null, [
                                                            'class' => 'form-control',
                                                            'id' => 'Spouse',
                                                            'maxlength' => '35',
                                                            'placeholder' => 'Spouse Name',
                                                            'value' => Input::old('Spouse'),
                                                        ]) !!}
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                           
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        @if ($create)
                            {!! Form::submit('Save And Go', ['class' => 'btn btn-success']) !!}
                        @endif
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        var empentry = <?= json_encode($empentry) ?>;
        function employeeEntry(id) {
            $.ajax({
                type: "GET",
                url: "{{ url('hris/database/empentry/empentryinfo/') }}" + "/" + id,
                data: {},
                success: function(data) {
                    //console.log(data);
                    data = data.data;
                    let PDistrictID = null;
                    let DesignationID = null;
                    if (data != null) {
                        $("#EmpEntryID").val(data.id);
                        $("#EmployeeID").val(data.EmployeeID);
                        $("#Name").val(data.Name);
                        $("#DepartmentID").val(data.DepartmentID).trigger('change');
                        $("#DesignationID").val(data.DesignationID).trigger('change');
                        $("#Line").val(data.Line);
                        $("#MPOffice").val(data.prsnt_post_office);
                        $("#MVillage").val(data.prsnt_local_add);
                        $("#MDistrictID").val(data.prsnt_district_id).trigger('change');
                        $("#PPOffice").val(data.par_post_office);
                        $("#PVillage").val(data.par_local_add);
                        $("#PDistrictID").val(data.par_district_id).trigger('change');
                        let current_datetime = formatDate(data.JoiningDate);

                        function formatDate(date) {
                            var d = new Date(date),
                                month = '' + (d.getMonth() + 1),
                                day = '' + d.getDate(),
                                year = d.getFullYear();

                            if (month.length < 2) month = '0' + month;
                            if (day.length < 2) day = '0' + day;

                            return [day, month, year].join('-');
                        }

                        $("#JoiningDate").val(current_datetime);
                        PDistrictID = data.par_district_id;
                        DesignationID = data.FinalDesignationID;
                    } else {
                        $("#EmployeeID").val(null);
                        $("#EmpEntryID").val(null);
                        $("#Name").val(null);
                        $("#DepartmentID").val(null);
                        $("#DesignationID").val(null);
                        $("#Line").val(null);
                        $("#JoiningDate").val(null);
                        $("#PDistrictID").val(null);
                        $("#PThanaID").val(null);
                    }
                    $.ajax({
                        type: "GET",
                        url: "{{ url('hris/database/getthana') }}",
                        data: {
                            dist_id: PDistrictID,
                        },
                        success: function(data) {
                            if (data) {
                                $("#PThanaID").empty();
                                $.each(data, function(key, value) {
                                    $("#PThanaID").append('<option value="' + key + '">' +
                                        value + '</option>');
                                });
                            } else {
                                $("#PThanaID").empty();
                            }
                        }
                    });
                    $.ajax({
                        type: "GET",
                        url: "{{ url('hris/database/getsubgrade') }}",
                        data: {
                            desg_id: DesignationID,
                        },
                        success: function(data) {
                            if (data) {
                                $("#SubGrade").val(data);
                            } else {
                                $("#SubGrade").val(0);
                            }
                        }
                    });

                    var joiningDate = document.getElementById('JoiningDate').value;
                    var getjoiningDate = joiningDate.split("-").reverse().join("-");
                    var jointoconf = <?php echo $optionalparam->JoiningToConfirm; ?>;
                    var newdate = new Date(getjoiningDate);
                    var currentYear2 = newdate.getFullYear();
                    var currentMonth2 = newdate.getMonth();
                    var currentDay2 = newdate.getDate();
                    var confirmationDate = new Date(currentYear2, currentMonth2 + jointoconf, currentDay2);
                    var y = confirmationDate.getFullYear();
                    var m = (confirmationDate.getMonth() + 1);
                    var d = confirmationDate.getDate();
                    var cMonth = m < 10 ? '0' + m : m;
                    var cDay = d < 10 ? '0' + d : d;
                    var cDate = y + '-' + cMonth + '-' + cDay;
                    $('#ConfirmationDate').val(cDate);
                    $('#ShiftReferenceDate').val(joiningDate);
                }
            });
        }
        $('#Refresh').on('click', function() {
            $("#EmployeeID").val(null);
            $("#EmpEntryID").val(null);
            $("#Name").val(null);
            $("#DepartmentID").val(null);
            $("#DesignationID").val(null);
            $("#Line").val(null);
            $("#JoiningDate").val(null);
            $("#PDistrictID").val(null);
            $("#PThanaID").val(null);
            $("#SubGrade").val(null);
            $("#ConfirmationDate").val(null);
            $("#ShiftReferenceDate").val(null);
        });
        $('#check_info').hide();
        $('#EmployeeID').on('input', function() {
            var empID = $("#EmployeeID").val();
            if (empID.length >= emplen) {
                $.ajax({
                    type: "GET",
                    url: "{{ url('hris/database/getemployee') }}",
                    data: {
                        emp_id: empID,
                    },
                    success: function(data) {
                        if (data) {
                            $('#check_info').show();
                            document.getElementById("check_info").innerHTML = data;
                        }
                    }
                });
            }
        });

        $('#JoiningDate').on('change', function() {
            var joiningDate = document.getElementById('JoiningDate').value;
            var getjoiningDate = joiningDate.split("-").reverse().join("-");
            var jointoconf = <?php echo $optionalparam->JoiningToConfirm; ?>;
            var newdate = new Date(getjoiningDate);
            var currentYear2 = newdate.getFullYear();
            var currentMonth2 = newdate.getMonth();
            var currentDay2 = newdate.getDate();
            var confirmationDate = new Date(currentYear2, currentMonth2 + jointoconf, currentDay2);
            var y = confirmationDate.getFullYear();
            var m = (confirmationDate.getMonth() + 1);
            var d = confirmationDate.getDate();
            var cMonth = m < 10 ? '0' + m : m;
            var cDay = d < 10 ? '0' + d : d;
            var cDate = cDay + '-' + cMonth + '-' + y;
            $('#ConfirmationDate').val(cDate);
            $('#ShiftReferenceDate').val(joiningDate);
        });

        var distID = $("#MDistrictID option:selected").val();
        if (distID) {
            $.ajax({
                type: "GET",
                url: "{{ url('hris/database/getthana') }}",
                data: {
                    dist_id: distID,
                },
                success: function(data) {
                    if (data) {
                        $("#MThanaID").empty();
                        $.each(data, function(key, value) {
                            $("#MThanaID").append('<option value="' + key + '">' + value + '</option>');
                        });
                    } else {
                        $("#MThanaID").empty();
                    }
                }
            });
        } else {
            $("#MThanaID").empty();
        }

        $('#MDistrictID').on("change", function(event) {
            event.preventDefault();
            var distID = $("#MDistrictID option:selected").val();
            if (distID) {
                $.ajax({
                    type: "GET",
                    url: "{{ url('hris/database/getthana') }}",
                    data: {
                        dist_id: distID,
                    },
                    success: function(data) {
                        //$('#test').append(data);
                        if (data) {
                            $("#MThanaID").empty();
                            $.each(data, function(key, value) {
                                $("#MThanaID").append('<option value="' + key + '">' + value +
                                    '</option>');
                            });
                        } else {
                            $("#MThanaID").empty();
                        }
                    }
                });
            } else {
                $("#MThanaID").empty();
            }
        });

        var distID = $("#PDistrictID option:selected").val();
        if (distID) {
            $.ajax({
                type: "GET",
                url: "{{ url('hris/database/getthana') }}",
                data: {
                    dist_id: distID,
                },
                success: function(data) {
                    if (data) {
                        $("#PThanaID").empty();
                        $.each(data, function(key, value) {
                            $("#PThanaID").append('<option value="' + key + '">' + value + '</option>');
                        });
                    } else {
                        $("#PThanaID").empty();
                    }
                }
            });
        } else {
            $("#PThanaID").empty();
        }
        $('#PDistrictID').on("change", function(event) {
            event.preventDefault();
            var distID = $("#PDistrictID option:selected").val();
            if (distID) {
                $.ajax({
                    type: "GET",
                    url: "{{ url('hris/database/getthana') }}",
                    data: {
                        dist_id: distID,
                    },
                    success: function(data) {
                        if (data) {
                            $("#PThanaID").empty();
                            $.each(data, function(key, value) {
                                $("#PThanaID").append('<option value="' + key + '">' + value +
                                    '</option>');
                            });
                        } else {
                            $("#PThanaID").empty();
                        }
                    }
                });
            } else {
                $("#PThanaID").empty();
            }
        });

        $('#DesignationID').on("change", function(event) {
            var desgID = $("#DesignationID option:selected").val();
            if (desgID) {
                $.ajax({
                    type: "GET",
                    url: "{{ url('hris/database/getsubgrade') }}",
                    data: {
                        desg_id: desgID,
                    },
                    success: function(data) {
                        if (data) {
                            $("#SubGrade").val(data);
                        } else {
                            $("#SubGrade").val(0);
                        }
                    }
                });
            } else {
                $("#SubGrade").val('');
            }
        });

        function getDepartment(id) {
            $.ajax({
                type: "GET",
                url: "{{ url('getdepartment') }}",
                data: {
                    concern_id: id,
                },
                success: function(data) {
                    // console.log(data);
                    if (data) {
                        $("#department").empty();
                        $.each(data, function(key, item) {
                            $('#department').append('<option value="' + item.id + '">' + item
                                .Department + '</option>');
                        });
                    } else {
                        $("#department").empty();
                    }
                    $("#department").prepend('<option value="" selected>--Choose one--</option>');
                }
            });
        }

        function getDesignation(id) {
            $.ajax({
                type: "GET",
                url: "{{ url('getdesignation') }}",
                data: {
                    department_id: id,
                },
                success: function(data) {
                    //console.log(data);
                    if (data) {
                        $("#designation").empty();
                        $.each(data, function(key, item) {
                            $('#designation').append('<option value="' + item.id + '">' + item
                                .Designation + '</option>');
                        });
                    } else {
                        $("#designation").empty();
                    }
                    $("#designation").prepend('<option value="" selected>--Choose one--</option>');
                }
            });
        }
    </script>
@stop
