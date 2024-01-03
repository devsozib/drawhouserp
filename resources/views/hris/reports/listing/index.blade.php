@extends('layout.app')
@section('title', 'HRIS | Listing')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0" style="text-align: right;"></h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{!! url('hris/dashboard') !!}">HRIS</a></li>
                        <li class="breadcrumb-item"><a href="javascript::void(0)">Reports</a></li>
                        <li class="breadcrumb-item"><a href="{!! url('hris/reports/listing') !!}">Listing</a></li>
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
                    {!! Form::open(array('action' => '\App\Http\Controllers\HRIS\Reports\ListingReportController@preview')) !!}
                    <div class="card-header with-border" style="font-size: 22px; text-align: center">Listing Reports</div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="control-group {!! $errors->has('title') ? 'has-error' : '' !!}">
                                    <label class="control-label" for="title">Preview Title's</label>                     
                                    <div class="controls" style="max-height: 410px; min-height: 410px; overflow-y: auto;">
                                        {{ Form::radio('title', 1, true, array('id'=>'title1','class'=>'titles')) }} <label for="title1">Department-wise Listing of Employees</label> <br>
                                        {{ Form::radio('title', 2, false, array('id'=>'title2','class'=>'titles')) }} <label for="title2">Designation-wise Listing of Employees</label> <br>
                                        {{ Form::radio('title', 3, false, array('id'=>'title3','class'=>'titles')) }} <label for="title3">Department-wise Listing of Employees (With Salary)</label> <br>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-5">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="control-group {!! $errors->has('DepartmentID') ? 'has-error' : '' !!}">
                                            <label class="control-label" for="DepartmentID">Department</label>
                                            <div class="controls" style="min-height: 400px; max-height: 400px; overflow-y: scroll; margin-bottom: 5px;">
                                                @foreach($deptlist as $department)                                        
                                                    {{ Form::checkbox('DepartmentID[]', $department->id, true, array('id'=>'DepartmentID'.$department->id,'class'=>'DepartmentID')) }} <label for="DepartmentID{!! $department->id !!}" style="font-weight: 400; margin-bottom: 0; margin-top: 0;">{!! $department->Department !!}</label><br>
                                                @endforeach 
                                            </div>
                                            <div class="btn-toolbar">
                                                <button type="button" id='check_all'>Check All</button> &nbsp;&nbsp;<button type="button" id='uncheck_all'>Uncheck All</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="control-group {!! $errors->has('DesignationID') ? 'has-error' : '' !!}">
                                            <label class="control-label" for="DesignationID">Designation</label>
                                            <div class="controls" style="min-height: 400px; max-height: 400px; overflow-y: scroll; margin-bottom: 5px;">
                                                @foreach($desglist as $designation)
                                                    {{ Form::checkbox('DesignationID[]', $designation->id, true, array('id'=>'DesignationID'.$designation->id,'class'=>'DesignationID')) }} <label for="DesignationID{!! $designation->id !!}" style="font-weight: 400; margin-bottom: 0; margin-top: 0;">{!! $designation->Designation !!}</label><br>
                                                @endforeach 
                                            </div>
                                            <div class="btn-toolbar">
                                                <button type="button" id='check_all2'>Check All</button> &nbsp;&nbsp;<button type="button" id='uncheck_all2'>Uncheck All</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <table class="table">
                                    <tbody>
                                        <tr>
                                            <th style="width: 43%;">Employee ID</th>
                                            <td style="width: 2%;">:</td>
                                            <td style="width: 55%;">
                                                <table width="100%">
                                                    <tr>
                                                        <td>
                                                            <div class="control-group {!! $errors->has('EmployeeF') ? 'has-error' : '' !!}">
                                                                <div class="controls">
                                                                    {!! Form::number('EmployeeF', $first, array('class'=>'form-control', 'id' => 'EmployeeF', 'min' => $first, 'max' => $last, 'placeholder'=>'Employee ID', 'value'=>Input::old('EmployeeF'))) !!}
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="control-group {!! $errors->has('EmployeeL') ? 'has-error' : '' !!}">
                                                                <div class="controls">
                                                                    {!! Form::number('EmployeeL', $last, array('class'=>'form-control', 'id' => 'EmployeeL', 'min' => $first, 'max' => $last, 'placeholder'=>'Employee ID', 'value'=>Input::old('EmployeeL'))) !!}
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </table>  
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>
                                                <div class="control-group {!! $errors->has('AllConcern') ? 'has-error' : '' !!}">
                                                    <div class="controls">
                                                        <input type="checkbox" name="AllConcern" id="AllConcern" checked=""><label for="AllConcern">&nbsp;All Concern</label>
                                                    </div>
                                                </div>
                                            </th>
                                            <td>:</td>
                                            <td>
                                                <div class="control-group {!! $errors->has('company_id') ? 'has-error' : '' !!}">
                                                    <div class="controls">
                                                        {!! Form::select('company_id', getCompanyList(), null, array('class'=>'form-control', 'id' => 'company_id', 'placeholder'=>'Select One','value'=>Input::old('company_id'))) !!}
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>
                                                <div class="control-group {!! $errors->has('AllDistrict') ? 'has-error' : '' !!}">
                                                    <div class="controls">
                                                        <input type="checkbox" name="AllDistrict" id="AllDistrict" checked=""><label for="AllDistrict">&nbsp;All District</label>
                                                    </div>
                                                </div>
                                            </th>
                                            <td>:</td>
                                            <td>
                                                <div class="control-group {!! $errors->has('DistrictID') ? 'has-error' : '' !!}">
                                                    <div class="controls">
                                                        {!! Form::select('DistrictID', $districtlist, null, array('class'=>'form-control', 'id' => 'DistrictID', 'placeholder'=>'Select One','value'=>Input::old('DistrictID'))) !!}
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>
                                                <div class="control-group {!! $errors->has('AllBloodGroup') ? 'has-error' : '' !!}">
                                                    <div class="controls">
                                                        <input type="checkbox" name="AllBloodGroup" id="AllBloodGroup" checked=""><label for="AllBloodGroup">&nbsp;All Blood Group</label>
                                                    </div>
                                                </div>
                                            </th>
                                            <td>:</td>
                                            <td>
                                                <div class="control-group {!! $errors->has('BloodGroup') ? 'has-error' : '' !!}">
                                                    <div class="controls">
                                                        {!! Form::select('BloodGroup', array('X'=>'X','A+'=>'A+','A-'=>'A-','B+'=>'B+','B-'=>'B-','AB+'=>'AB+','AB-'=>'AB-','O+'=>'O+','O-'=>'O-'), null, array('class'=>'form-control', 'id' => 'BloodGroup', 'placeholder'=>'Select One', 'value'=>Input::old('BloodGroup'))) !!}
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>
                                                <div class="control-group {!! $errors->has('AllReason') ? 'has-error' : '' !!}">
                                                    <div class="controls">
                                                        <input type="checkbox" name="AllReason" id="AllReason" checked=""><label for="AllReason">&nbsp;All Reason</label>
                                                    </div>
                                                </div>
                                            </th>
                                            <td>:</td>
                                            <td>
                                                <div class="control-group {!! $errors->has('Reason') ? 'has-error' : '' !!}">
                                                    <div class="controls">
                                                        {!! Form::select('ReasonID', $resonlist, null, array('class'=>'form-control', 'id' => 'ReasonID', 'placeholder'=>'Select One', 'value'=>Input::old('ReasonID'))) !!}
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Start Date</th>
                                            <td>:</td>
                                            <td>
                                                <div class="control-group {!! $errors->has('StartDate') ? 'has-error' : '' !!}">
                                                    <div class="controls">
                                                        {!! Form::text('StartDate', $inputDate, array('class'=>'form-control StartDate', 'id' => 'StartDate', 'maxlength'=>'10', 'placeholder'=>'YYYY-MM-DD', 'value'=>Input::old('StartDate'))) !!}
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>End Date</th>
                                            <td>:</td>
                                            <td>
                                                <div class="control-group {!! $errors->has('EndDate') ? 'has-error' : '' !!}">
                                                    <div class="controls">
                                                        {!! Form::text('EndDate', $inputDate, array('class'=>'form-control EndDate', 'id' => 'EndDate', 'maxlength'=>'10', 'placeholder'=>'YYYY-MM-DD', 'value'=>Input::old('EndDate'))) !!}
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Religion</th>
                                            <td>:</td>
                                            <td>
                                                <div class="control-group {!! $errors->has('ReligionID') ? 'has-error' : '' !!}">
                                                    <div class="controls">
                                                        {!! Form::select('ReligionID', $religionlist, null, array('class'=>'form-control', 'id' => 'ReligionID', 'placeholder'=>'Select One','value'=>Input::old('ReligionID'))) !!}
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Date</th>
                                            <td>:</td>
                                            <td>
                                                <div class="control-group {!! $errors->has('Date') ? 'has-error' : '' !!}">
                                                    <div class="controls">
                                                        {!! Form::text('Date', $inputDate, array('class'=>'form-control datepickerbs4v3', 'id' => 'Date','value'=>Input::old('Date'))) !!}
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>View Mode's</th>
                                            <td>:</td>
                                            <td>
                                                <div class="control-group {!! $errors->has('viewmode') ? 'has-error' : '' !!}">
                                                    <div class="controls">
                                                        {!! Form::select('viewmode', array('1' => 'Normal View', '2' => 'PDF View'), 1, array('class' => 'form-control', 'id' => 'viewmode', 'value'=>Input::old('viewmode'))) !!}
                                                    </div>
                                                </div> 
                                            </td>
                                        </tr>
                                        <tr>
                                            <th></th>
                                            <td></td>
                                            <td style="text-align: right;">
                                                @if($view)
                                                    {!! Form::submit('Preview', array('class' => 'btn btn-success', 'formtarget' => '_blank')) !!}
                                                @endif
                                            </td>
                                        </tr>
                                    </tbody>
                                </table> 
                            </div>
                        </div>
                    </div>        
                    {!! Form::close() !!}           
                </div>
            </div>
        </div>
    </div>
    
    <script type="text/javascript">
        var value = $('#AllConcern').is(":checked") ? 'true' : 'false';
        if(value == 'true') {
            $('#company_id').attr('disabled', true);
        } else {
            $('#company_id').attr('disabled',false);
        }
        $("#AllConcern").click(function() {
            var value = $('#AllConcern').is(":checked") ? 'true' : 'false';
            if(value == 'true') {
                $('#company_id').attr('disabled', true);
            } else {
                $('#company_id').attr('disabled',false);
            }
        });
        
        var value = $('#AllDistrict').is(":checked") ? 'true' : 'false';
        if(value == 'true') {
            $('#DistrictID').attr('disabled', true);
        } else {
            $('#DistrictID').attr('disabled',false);
        }
        $("#AllDistrict").click(function() {
            var value = $('#AllDistrict').is(":checked") ? 'true' : 'false';
            if(value == 'true') {
                $('#DistrictID').attr('disabled', true);
            } else {
                $('#DistrictID').attr('disabled',false);
            }
        });

        var value = $('#AllBloodGroup').is(":checked") ? 'true' : 'false';
        if(value == 'true') {
            $('#BloodGroup').attr('disabled', true);
        } else {
            $('#BloodGroup').attr('disabled',false);
        }
        $("#AllBloodGroup").click(function() {
            var value = $('#AllBloodGroup').is(":checked") ? 'true' : 'false';
            if(value == 'true') {
                $('#BloodGroup').attr('disabled', true);
            } else {
                $('#BloodGroup').attr('disabled',false);
            }
        });
        var value = $('#AllReason').is(":checked") ? 'true' : 'false';
        if(value == 'true') {
            $('#ReasonID').attr('disabled', true);
        } else {
            $('#ReasonID').attr('disabled',false);
        }
        $("#AllReason").click(function() {
            var value = $('#AllReason').is(":checked") ? 'true' : 'false';
            if(value == 'true') {
                $('#ReasonID').attr('disabled', true);
            } else {
                $('#ReasonID').attr('disabled',false);
            }
        });

        $('#check_all').click(function() {
            $('.DepartmentID').prop('checked', true);
        });
        $('#uncheck_all').click(function() {
            $('.DepartmentID').prop('checked', false);
        });

        $('#check_all2').click(function() {
            $('.DesignationID').prop('checked', true);
        });
        $('#uncheck_all2').click(function() {
            $('.DesignationID').prop('checked', false);
        });
        
        function titleValidation(radval){
            if(radval==1 || radval==2) {
                $("#StartDate").attr('disabled', true);
                $("#EndDate").attr('disabled', true);
                $("#AllDistrict").attr('disabled', true);
                $("#AllBloodGroup").attr('disabled', true);
                $("#AllReason").attr('disabled', true);
                $("#ReligionID").attr('disabled', true);
                $("#AllConcern").attr('disabled', false);
            }
        }
        var radval = $('[name="title"]:checked').val();
        titleValidation(radval);
        $(".titles").click(function() {
            var radval = $('[name="title"]:checked').val();
            titleValidation(radval);
        });  
    </script>

@stop

