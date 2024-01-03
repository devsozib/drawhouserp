@extends('layout.app')
@section('title', 'HRIS | Salary')
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
                        <li class="breadcrumb-item"><a href="{!! url('hris/reports/salary') !!}">Salary</a></li>
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
                    {!! Form::open(array('action' => '\App\Http\Controllers\HRIS\Reports\SalaryReportController@preview')) !!}
                    <div class="card-header with-border" style="font-size: 22px; text-align: center">Salary Reports</div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="control-group {!! $errors->has('title') ? 'has-error' : '' !!}">
                                    <label class="control-label" for="title">Preview Title's</label>
                                    <div class="controls" style="max-height: 350px; min-height: 350px; overflow-y: auto;">
                                        {{-- {{ Form::radio('title', 1, true, array('id'=>'title1','class'=>'titles')) }} <label for="title1">Employee-wise Salary Sheet</label> <br> --}}
                                        {{ Form::radio('title', 2, false, array('id'=>'title2','class'=>'titles')) }} <label for="title2">Employee-wise Salary Sheet</label> <br>

                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-5">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="control-group {!! $errors->has('DepartmentID') ? 'has-error' : '' !!}">
                                            <label class="control-label" for="DepartmentID">Department</label>
                                            <div class="controls" style="min-height: 350px; max-height: 350px; overflow-y: scroll; margin-bottom: 5px;">
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
                                            <div class="controls" style="min-height: 350px; max-height: 350px; overflow-y: scroll; margin-bottom: 5px;">
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
                                            <th style="width: 38%;">Employee ID</th>
                                            <td style="width: 2%;">:</td>
                                            <td style="width: 60%;">
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
                                            <th>Year</th>
                                            <td>:</td>
                                            <td>
                                                <div class="control-group {!! $errors->has('Year') ? 'has-error' : '' !!}">
                                                    <div class="controls">
                                                        {!! Form::number('Year', $hroptions->Year, array('class'=>'form-control', 'id' => 'Year', 'min'=>'2000', 'max'=>'2100', 'placeholder'=>'YYYY-MM-DD', 'value'=>Input::old('Year'))) !!}
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Month</th>
                                            <td>:</td>
                                            <td>
                                                <div class="control-group {!! $errors->has('Month') ? 'has-error' : '' !!}">
                                                    <div class="controls">
                                                        {!! Form::selectMonth('Month', $hroptions->Month, array('class'=>'form-control', 'id' => 'Month',  'placeholder'=>'Select Month', 'value'=>Input::old('Month'))) !!}
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
                $("#Year").attr('disabled', false);
                $("#Month").attr('disabled', false);
                $("#Date").attr('disabled', false);
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

