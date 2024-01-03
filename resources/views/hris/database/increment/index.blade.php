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
                    <h1 class="m-0" style="text-align: right;">Employee Increment</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{!! url('hris/dashboard') !!}">HRIS</a></li>
                        <li class="breadcrumb-item"><a href="javascript::void(0)">Database</a></li>
                        <li class="breadcrumb-item"><a href="{!! url('hris/database/increment') !!}">Employee Increment</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Index</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="row">
            <div class="col-lg-12">
                <div class="float-right">
                    <table class="table">
                        <tr>
                            <td style="width: 50%; border: none;">
                                {!! Form::open(['action' => '\App\Http\Controllers\HRIS\Database\IncrementController@getSearch']) !!}
                                {!! Form::number('search', null, ['required', 'class' => 'form-control', 'min' => '000100', 'max' => '999999', 'placeholder' => 'Employee ID']) !!}
                            </td>
                            <td style="width: 25%; border: none; text-align: right;">
                                {!! Form::submit('Search', ['class' => 'btn btn-sm btn-default']) !!}
                                {!! Form::close() !!}
                            </td>
                            <td style="width: 25%; border: none;">
                                &nbsp;
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @if(Sentinel::inRole('superadminx'))
        <div class="content">
            <div class="row">
                <div class="col-lg-3"></div>
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header with-border" style="font-size: 16px;">Bulk Increment Section</div>
                        <div class="card-body">
                            <form method="post" enctype="multipart/form-data" action="{{ url('hris/database/increment') }}">
                                {{ csrf_field() }}
                                <table class="table table-bordered">
                                    <tbody>
                                        <tr>
                                            <th style="width: 38%">Select Text File</th>
                                            <td style="width: 2%">:</td>
                                            <td style="width: 60%">
                                                <div class="control-group {!! $errors->has('incfile') ? 'has-error' : '' !!}">
                                                    <div class="controls">
                                                        <input type="file" name="incfile" accept=".txt" style="width: 100%;">
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Increment Date</th>
                                            <td>:</td>
                                            <td>
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
                            </form>
                        </div>    
                        <div class="card-footer text-right" style="margin-top: -20px;">
                            {!! Form::number('formid', 2, ['class' => 'hidden', 'id' => 'formid']) !!}
                            @if($create)
                                <button type="submit" id="readfile" class="btn btn-success">Save</button>
                            @endif
                        </div>               
                    </div>
                </div>
                <div class="col-lg-3"></div>
            </div>
        </div>
    @endif

    <script type="text/javascript">
        $('#EffectiveDate').on('change',function(e){
            var effdate = document.getElementById('EffectiveDate').value;
            $('#ArrearDate').val(effdate);
        });
    </script>
@stop
