@extends('layout.app')
@section('title', 'HRIS | Advance')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0" style="text-align: right;">Advance</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{!! url('hris/dashboard') !!}">HRIS</a></li>
                        <li class="breadcrumb-item"><a href="javascript::void(0)">Database</a></li>
                        <li class="breadcrumb-item"><a href="{!! url('hris/database/advance') !!}">Advance</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Show</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="row">
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header with-border" style="font-size: 16px;">Recent Advance List</div>
                    <div class="card-body">
                        <div style="max-height: 500px; overflow-y: scroll;">
                            <table class="table table-bordered fixed_header" id="datacom">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>NAME</th>
                                        <th>DESIGNATION</th>
                                        <th>ISSUE DATE</th>
                                        <th>REFUND DATE</th>
                                        <th style="text-align: right;">AMOUNT</th>
                                    </tr>
                                </thead>
                                <tbody> 
                                    @foreach($advanceemp as $document)
                                        @if($document->id == $uniqueloan->id)
                                            <tr style="background-color: lightskyblue;">  
                                                <td><a href="{!! URL('hris/database/advance/'.$document->id) !!}">{!! str_pad($document->EmployeeID, 6, "0", STR_PAD_LEFT) !!}</a></td>
                                                <td style="text-transform: uppercase;">{!! $document->Name !!}</td>
                                                <td>{!! $document->Designation !!}</td>
                                                <td>{!! date('d-m-Y', strtotime($document->AdvanceDate)) !!}</td>
                                                <td>{!! date('d-m-Y', strtotime($document->RefundStartFrom)) !!}</td>
                                                <td style="text-align: right;">{!! number_format($document->AdvanceAmount); !!}</td>
                                            </tr>
                                        @else
                                            <tr>
                                                <td><a href="{!! URL('hris/database/advance/'.$document->id) !!}">{!! str_pad($document->EmployeeID, 6, "0", STR_PAD_LEFT) !!}</a></td>
                                                <td style="text-transform: uppercase;">{!! $document->Name !!}</td>
                                                <td>{!! $document->Designation !!}</td>
                                                <td>{!! date('d-m-Y', strtotime($document->AdvanceDate)) !!}</td>
                                                <td>{!! date('d-m-Y', strtotime($document->RefundStartFrom)) !!}</td>
                                                <td style="text-align: right;">{!! number_format($document->AdvanceAmount); !!}</td>
                                            </tr>
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>                        
                        </div>
                    </div>                   
                </div>
            </div>
          
            <div class="col-lg-6" style="padding-left: 5px;">
                {!! Form::open(array('action' => array('\App\Http\Controllers\HRIS\Database\AdvanceController@update', $uniqueloan->id), 'method' => 'PATCH')) !!}
                <div class="card">
                    <div class="card-header with-border" style="font-size: 16px;">
                        Edit Parameters For <strong>Advance ID: <span style="color: darkorange;">{!! $uniqueloan->AdvanceID !!}</span></strong>
                        <a href="{!! URL('hris/database/advance/') !!}" class="btn btn-sm btn-primary" style="margin-top: 0px; float: right;"> <span class="glyphicon glyphicon-arrow-left"></span>&nbsp;Back </a>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-7">                           
                                <table class="table table-bordered">
                                    <tbody>
                                        <tr>
                                            <th style="width: 35%">Employee ID</th>
                                            <td style="width: 65%">
                                                <div class="control-group {!! $errors->has('EmployeeID') ? 'has-error' : '' !!}">
                                                    <div class="controls">
                                                        {!! Form::text('EmployeeID', str_pad($uniqueloan->EmployeeID, 6, "0", STR_PAD_LEFT), array('readonly', 'class'=>'form-control', 'id' => 'EmployeeID', 'placeholder'=>'Employee ID', 'value'=>Input::old('EmployeeID'))) !!}
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Name</th>
                                            <td>
                                                <div class="control-group {!! $errors->has('Name') ? 'has-error' : '' !!}">
                                                    <div class="controls">
                                                        {!! Form::text('Name', $uniqueloan->Name, array('readonly', 'class'=>'form-control', 'id' => 'Name', 'placeholder'=>'Employee Name', 'value'=>Input::old('Name'))) !!}
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Designation</th>
                                            <td>
                                                <div class="control-group {!! $errors->has('Designation') ? 'has-error' : '' !!}">
                                                    <div class="controls">
                                                        {!! Form::text('Designation', $uniqueloan->Designation, array('readonly', 'class'=>'form-control', 'id' => 'Designation', 'placeholder'=>'Designation', 'value'=>Input::old('Designation'))) !!}
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Department</th>
                                            <td>
                                                <div class="control-group {!! $errors->has('Department') ? 'has-error' : '' !!}">
                                                    <div class="controls">
                                                        {!! Form::text('Department', $uniqueloan->Department, array('readonly', 'class'=>'form-control', 'id' => 'Department', 'placeholder'=>'Department', 'value'=>Input::old('Department'))) !!}
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Date Issued</th>
                                            <td>
                                                <div class="control-group {!! $errors->has('AdvanceDate') ? 'has-error' : '' !!}">
                                                    <div class="controls">
                                                        {!! Form::text('AdvanceDate', $uniqueloan->AdvanceDate, array('required', 'class'=>'form-control', 'id' => 'AdvanceDate', 'maxlength'=>'10', 'placeholder'=>'YYYY-MM-DD', 'value'=>Input::old('AdvanceDate'))) !!}
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Refund Start At</th>
                                            <td>
                                                <div class="control-group {!! $errors->has('RefundStartFrom') ? 'has-error' : '' !!}">
                                                    <div class="controls">
                                                        {!! Form::text('RefundStartFrom', $uniqueloan->RefundStartFrom, array('required', 'class'=>'form-control', 'id' => 'RefundStartFrom', 'maxlength'=>'10', 'placeholder'=>'YYYY-MM-DD', 'value'=>Input::old('RefundStartFrom'))) !!}
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-lg-5">
                                <table class="table table-bordered">
                                    <tbody>
                                        <tr>
                                            <th>Adv. Type</th>
                                            <td>
                                                <div class="control-group {!! $errors->has('AdvanceType') ? 'has-error' : '' !!}">
                                                    <div class="controls">
                                                        {!! Form::select('AdvanceType', getAdvType(), $uniqueloan->AdvanceType, array('required', 'class'=>'form-control', 'id' => 'AdvanceType', 'value'=>Input::old('AdvanceType'))) !!}
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th style="width: 35%">Amount</th>
                                            <td style="width: 65%; text-align: center;">
                                                <div class="control-group {!! $errors->has('AdvanceAmount') ? 'has-error' : '' !!}">
                                                    <div class="controls">
                                                        {!! Form::number('AdvanceAmount', round($uniqueloan->AdvanceAmount), array('required', 'class'=>'form-control', 'id' => 'AdvanceAmount', 'min'=> $uniqueloan->AdvanceAmount-$uniqueloan->BalanceAmount, 'max'=>'999999', 'placeholder'=>'Advance Amount', 'value'=>Input::old('AdvanceAmount'))) !!}
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Install. Size</th>
                                            <td>
                                                <div class="control-group {!! $errors->has('ISize') ? 'has-error' : '' !!}">
                                                    <div class="controls">
                                                        {!! Form::number('ISize', round($uniqueloan->ISize), array('required', 'class'=>'form-control', 'id' => 'ISize', 'min'=>'1', 'max'=> $empsal, 'placeholder'=>'Installment Size', 'value'=>Input::old('ISize'))) !!}
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Refunded</th>
                                            <td>
                                                <div class="control-group {!! $errors->has('RefundedAmount') ? 'has-error' : '' !!}">
                                                    <div class="controls">
                                                        {!! Form::number('RefundedAmount', round($uniqueloan->AdvanceAmount-$uniqueloan->BalanceAmount), array('readonly', 'class'=>'form-control', 'id' => 'RefundedAmount', 'placeholder'=>'Refunded Amount', 'value'=>Input::old('RefundedAmount'))) !!}
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Balance</th>
                                            <td>
                                                <div class="control-group {!! $errors->has('BalanceAmount') ? 'has-error' : '' !!}">
                                                    <div class="controls">
                                                        {!! Form::number('BalanceAmount', round($uniqueloan->BalanceAmount), array('readonly', 'class'=>'form-control', 'id' => 'BalanceAmount', 'placeholder'=>'Balance', 'value'=>Input::old('BalanceAmount'))) !!}
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        @if(Sentinel::inRole('superadmin'))
                                        <tr>
                                            <th>Cash Refund</th>
                                            <td>
                                                <div class="control-group {!! $errors->has('CashRefund') ? 'has-error' : '' !!}">
                                                    <div class="controls">
                                                        {!! Form::number('CashRefund', round($uniqueloan->CashRefund), array('class'=>'form-control', 'id' => 'CashRefund', 'min'=>'0', 'max'=> $uniqueloan->BalanceAmount, 'placeholder'=>'Balance', 'value'=>Input::old('CashRefund'))) !!}
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        @else
                                        <tr>
                                            <th>Cash Refund</th>
                                            <td>
                                                <div class="control-group {!! $errors->has('CashRefund') ? 'has-error' : '' !!}">
                                                    <div class="controls">
                                                        {!! Form::number('CashRefund', round($uniqueloan->CashRefund), array('readonly', 'class'=>'form-control', 'id' => 'CashRefund', 'min'=>'0', 'max'=> $uniqueloan->BalanceAmount, 'placeholder'=>'Balance', 'value'=>Input::old('CashRefund'))) !!}
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        @endif
                                        <tr>
                                            <th>Remarks</th>
                                            <td>
                                                <div class="control-group {!! $errors->has('Remarks') ? 'has-error' : '' !!}">
                                                    <div class="controls">
                                                        {!! Form::text('Remarks', $uniqueloan->Remarks, array('class'=>'form-control', 'id' => 'Remarks', 'maxlength'=>'20', 'placeholder'=>'Remarks', 'value'=>Input::old('Remarks'))) !!}
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
                        @if($edit)
                            {!! Form::submit('Update', array('class' => 'btn btn-success')) !!}
                        @endif
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>

    <script type="text/javascript">
        var refund = <?php echo $uniqueloan->AdvanceAmount-$uniqueloan->BalanceAmount; ?>;
        if(refund > 0){
            $('#AdvanceAmount').attr('readonly',true);
        }else{
            $('#AdvanceAmount').attr('readonly',false);
        }
        $('#AdvanceAmount').on('input', function(){
            var refund = <?php echo $uniqueloan->AdvanceAmount-$uniqueloan->BalanceAmount; ?>;
            var advamount  = parseInt(document.getElementById('AdvanceAmount').value);
            $('#BalanceAmount').val(advamount-refund);
        });
    </script>
@stop
