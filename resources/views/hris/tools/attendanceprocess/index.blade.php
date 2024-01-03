@extends('layout.app')
@section('title', 'HRIS | Attendance Process')
@section('content')
    <?php $date = date('Y-m-d', time()); ?>
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
                        <li class="breadcrumb-item"><a href="{!! url('hris/tools/attendanceprocess') !!}">Attendance Process</a></li>
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
                    <div class="card-header with-border" style="font-size: 22px; text-align: center;">Attendance Process</div>
                    {!! Form::open(array('action' => array('\App\Http\Controllers\HRIS\Tools\AttendanceProcessController@store', 'method' => 'Post'))) !!}
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="control-group {!! $errors->has('title') ? 'has-error' : '' !!}">              
                                    <div class="controls"> 
                                        {{ Form::radio('title', 1, true, array('id'=>'title1','class'=>'titles')) }} <label for="title1">Process For Attendance</label> <br>
                                        {{ Form::radio('title', 2, false, array('id'=>'title2','class'=>'titles')) }} <label for="title2">Undo/ Revert Process Attendance</label> <br>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <table class="table table-bordered">
                                    <tbody>
                                        <tr>
                                            <th style="width: 38%">Year</th>
                                            <td style="width: 2%">:</td>
                                            <td style="width: 60%">
                                                <div class="control-group {!! $errors->has('Year') ? 'has-error' : '' !!}">
                                                    <div class="controls">
                                                        {!! Form::number('Year', $hroptions->Year, array('readonly', 'required', 'class'=>'form-control', 'id' => 'Year', 'min'=>'2019', 'max'=>$hroptions->Year, 'value'=>Input::old('Year'))) !!}
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
                                                        <!-- Display a select dropdown for the "Company" field -->
                                                        {!! Form::select('company_id', $complists, null, ['class' => 'form-control', 'id' => 'company_id']) !!}
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
                                                        {!! Form::selectMonth('Month', $hroptions->Month, array('required', 'class' => 'form-control', 'id' => 'Month', 'value'=>Input::old('Month'))) !!}
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
                    <div class="card">
                        <div class="card-header with-border text-center">
                            <h4>Attendance Process List</h4>
                        </div>
                        <div class="card-body">
                            <form action="{{ action('\App\Http\Controllers\HRIS\Tools\AttendanceProcessController@index') }}" method="get">
                                <input type="hidden" name="displayAP" value="1">
                                <div class="input-group">                                                               
                                    <input type="text" name="date" placeholder="Pick Year Month" class="form-control year-and-month" id="date">
                                    <div class="input-group-prepend">
                                        <button class="btn btn-primary" type="submit">Display</button>
                                      </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    
                    <div class="card-body">
                        <div style="min-height: 500px; max-height: 500px; overflow: auto; margin-bottom: 5px;">
                            <table class="table table-striped fixed_header display" id="calendar" width="100%">
                                <thead>
                                    <tr>
                                        <th>SL</th>
                                        <th>Property</th>
                                        <th>Year</th>
                                        <th>Month</th>                                        
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                        @foreach($attandenceProcess as $item)
                                            <tr>
                                                <td>{{ $loop->index+1 }}</td>                                              
                                                <td>{{ $complists[$item->company_id] }}</td>
                                                <td>{{ $item->Year }}</td>
                                                <td>{{ getMonthName($item->Month) }}</td>
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
