@extends('layout.app')
@section('title', 'HRIS | Advance Process')
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
                        <li class="breadcrumb-item"><a href="{!! url('hris/tools/advanceprocess') !!}">Advance Process</a></li>
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
                    <div class="card-header with-border" style="font-size: 22px; text-align: center;">Advance Process</div>
                    {!! Form::open(array('action' => array('\App\Http\Controllers\HRIS\Tools\AdvanceProcessController@store', 'method' => 'Post'))) !!}
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="control-group {!! $errors->has('title') ? 'has-error' : '' !!}">             
                                    <div class="controls">  
                                        {{ Form::radio('title', 1, true, array('id'=>'title1','class'=>'titles')) }} <label for="title1">Intialize Refund List For Advance</label> <br>
                                        {{ Form::radio('title', 2, false, array('id'=>'title2','class'=>'titles')) }} <label for="title2">Undo/Revert Refund List of Advance</label> <br>
                                        {{ Form::radio('title', 3, false, array('id'=>'title3','class'=>'titles')) }} <label for="title3">Update Balance of Advance</label>
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
                                                        {!! Form::number('Year', $hroptions->Year, array('required', 'class'=>'form-control', 'id' => 'Year', 'min'=>'2021', 'max'=>'2100', 'placeholder'=>'Year', 'value'=>Input::old('Year'))) !!}
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
    </div>

@stop
