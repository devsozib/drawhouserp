@extends('layout.app')
@section('title', 'HRIS | Punch Upload')
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
                        <li class="breadcrumb-item"><a href="{!! url('hris/tools/punchupload') !!}">Punch Upload</a></li>
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
                    <div class="card-header with-border" style="font-size: 22px; text-align: center;">Punch Upload</div>
                    <div class="card-body">
                        <form method="post" enctype="multipart/form-data" action="{{ url('hris/tools/punchupload/') }}">
                            @csrf
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <th style="width: 28%">Select Text File</th>
                                        <td style="width: 2%">:</td>
                                        <td style="width: 50%">
                                            <div class="control-group {!! $errors->has('punchfile') ? 'has-error' : '' !!}">
                                                <div class="controls">
                                                    <input type="file" name="punchfile" accept=".txt" style="width: 100%;">
                                                </div>
                                            </div>
                                        </td>
                                        <td style="width: 20%; text-align: center;">
                                            @if($create)
                                                <button type="submit" name="read" class="btn btn-success" value="read">Read</button>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Start Date</th>
                                        <td>:</td>
                                        <td>
                                            <div class="control-group {!! $errors->has('StartDate') ? 'has-error' : '' !!}">
                                                <div class="controls">
                                                    {!! Form::text('StartDate', $date, array('class'=>'form-control StartDate', 'id' => 'StartDate', 'value'=>Input::old('StartDate'))) !!}
                                                </div>
                                            </div>
                                        </td>
                                        <td style="text-align: center;">
                                            @if($delete)
                                                <button type="submit" name="undo" class="btn btn-warning" value="undo">Undo</button>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>End Date</th>
                                        <td>:</td>
                                        <td>
                                            <div class="control-group {!! $errors->has('EndDate') ? 'has-error' : '' !!}">
                                                <div class="controls">
                                                    {!! Form::text('EndDate', $date, array('class'=>'form-control EndDate', 'id' => 'EndDate', 'value'=>Input::old('EndDate'))) !!}
                                                </div>
                                            </div>
                                        </td>
                                        <td style="text-align: center;">
                                            @if($create)
                                                <button type="submit" name="syncpunch" class="btn btn-info" value="syncpunch">Sync Punch</button>
                                            @endif
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-lg-2"></div>
        </div>
    </div>

@stop
