@extends('layout.app')
@section('title', 'HRIS | Bonus Process')
@section('content')
    <?php 
        $bonustype = array(1=>'EID-UL-FITR', 2=>'EID-UL-ADHA'); 
        $salarytype = array(1=>'Basic', 2=>'Gross'); 
    ?>

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0" style="text-align: right;"></h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{!! url('hris/dashboard') !!}">HRIS</a></li>
                        <li class="breadcrumb-item"><a href="javascript::void(0)">Tools</a></li>
                        <li class="breadcrumb-item"><a href="{!! url('hris/tools/bonusprocess') !!}">Bonus Process</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Index</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="row">
            <div class="col-lg-2"></div>
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header with-border" style="font-size: 22px; text-align: center;">Bonus Process</div>
                    {!! Form::open(array('action' => array('\App\Http\Controllers\HRIS\Tools\BonusProcessController@store', 'method' => 'Post'))) !!}
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="control-group {!! $errors->has('title') ? 'has-error' : '' !!}">             
                                    <div class="controls">
                                        {{ Form::radio('title', 1, true, array('id'=>'title1','class'=>'titles')) }} <label for="title1">Process Bonus</label> <br><br>
                                        {{ Form::radio('title', 2, false, array('id'=>'title2','class'=>'titles')) }} <label for="title2">Undo/Revert Processing of Bonus</label> <br><br>
                                        {{ Form::radio('title', 3, false, array('id'=>'title3','class'=>'titles')) }} <label for="title3">Confirm Bonus Processing</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <table class="table table-bordered">
                                    <tbody>
                                        <tr>
                                            <th>Year</th>
                                            <td>:</td>
                                            <td>
                                                <div class="control-group {!! $errors->has('Year') ? 'has-error' : '' !!}">
                                                    <div class="controls">
                                                        {!! Form::number('Year', $hroptions->Year, array('readonly', 'class'=>'form-control', 'id' => 'Year', 'min'=>'2000', 'max'=>'2100', 'placeholder'=>'Year', 'value'=>Input::old('Year'))) !!}
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th style="width: 38%">Property</th>
                                            <td style="width: 2%">:</td>
                                            <td style="width: 60%">
                                                <div class="control-group {!! $errors->has('company_id') ? 'has-error' : '' !!}">
                                                    <div class="controls">
                                                        {!! Form::select('company_id', $complists, null, ['class' => 'form-control', 'id' => 'company_id']) !!}
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th style="width: 38%">Bonus Type</th>
                                            <td style="width: 2%">:</td>
                                            <td style="width: 60%">
                                                <div class="control-group {!! $errors->has('TypeID') ? 'has-error' : '' !!}">
                                                    <div class="controls">
                                                        {!! Form::Select('TypeID', $bonustype, null, array('required', 'class'=>'form-control', 'id' => 'TypeID', 'placeholder'=>'Select One', 'value'=>Input::old('TypeID'))) !!}
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Base Date</th>
                                            <td>:</td>
                                            <td>
                                                <div class="control-group {!! $errors->has('BaseDate') ? 'has-error' : '' !!}">
                                                    <div class="controls">
                                                        {!! Form::text('BaseDate', $inputDate, array('required', 'class' => 'form-control datepickerbs4v1', 'id' => 'BaseDate', 'max' => '10', 'placeholder'=>'YYYY-MM-DD', 'value'=>Input::old('BaseDate'))) !!}
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th style="width: 38%">Salary Type</th>
                                            <td style="width: 2%">:</td>
                                            <td style="width: 60%">
                                                <div class="control-group {!! $errors->has('SalaryType') ? 'has-error' : '' !!}">
                                                    <div class="controls">
                                                        {!! Form::Select('SalaryType', $salarytype, null, array('required', 'class'=>'form-control', 'id' => 'SalaryType', 'placeholder'=>'Select One', 'value'=>Input::old('SalaryType'))) !!}
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        @if($create)
                            {!! Form::submit('Process', array('class' => 'btn btn-success')) !!}
                        @endif
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
            <div class="col-lg-2"></div>
        </div>

        <div class="row">
            <div class="col-lg-2"></div>
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header with-border text-center">
                        <h4>Bonus Process List</h4>
                    </div>
                    <div class="card-body">
                        <div style="min-height: 500px; max-height: 500px; overflow: auto; margin-bottom: 5px;">
                            <table class="table table-striped fixed_header" id="calendar" width="100%">
                                <thead>
                                    <tr>
                                        <th>SL</th>
                                        <th>Property</th>
                                        <th>Year</th>
                                        <th>Bonus Type</th>
                                        <th>Salary Type</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($processdatas as $item)
                                        <tr>
                                            <td>{{ $loop->index+1 }}</td>                                              
                                            <td>{{ $complists[$item->company_id] }}</td>
                                            <td>{{ $item->Year }}</td>
                                            <td>{{ getArrayData($bonustype, $item->TypeID) }}</td>
                                            <td>{{ getArrayData($salarytype, $item->SalaryType) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-2"></div>
        </div>
    </div>

@stop
