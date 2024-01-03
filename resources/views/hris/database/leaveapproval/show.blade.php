@extends('hr/layout/layout')
@section('content')

<style type="text/css">
    input[type='number'] {
        -moz-appearance:textfield;
    }
    input[type=number]::-webkit-inner-spin-button,
    input[type=number]::-webkit-outer-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    /* input field size */
    /* .form-control{
        font-size: 13px;
        height: 30px;
        margin: 0px;
        padding-left: 8px;
        padding-right: 7px;
    } */
</style>

<script type="text/javascript">
    document.onkeydown = function(e) {
        if(e.keyCode == 123) {
            return false;
        }
        if(e.ctrlKey && e.shiftKey && e.keyCode == 'I'.charCodeAt(0)){
            return false;
        }
        if(e.ctrlKey && e.shiftKey && e.keyCode == 'J'.charCodeAt(0)){
            return false;
        }
        if(e.ctrlKey && e.keyCode == 'U'.charCodeAt(0)){
            return false;
        }
        if(e.ctrlKey && e.shiftKey && e.keyCode == 'C'.charCodeAt(0)){
            return false;
        }      
    }
</script>

<?php 
    date_default_timezone_set('Asia/Dhaka');
    $inputDate = date('Y-m-d', time());
?>

<section class="content-header">
    <h1 style="text-align: center;">Leave Approval</h1>
    <ol class="breadcrumb">
        <li><a href="{{ url('/hr') }}">HRIS</a></li>
        <li><a href="{{ url('hr/database') }}">Database</a></li>
        <li><a href="{{ url('hr/database/leaveapproval') }}">Leave Approval</a></li>
        <li class="active">Index</li>
    </ol>
</section>

<section class="content" oncontextmenu="return false">
    <div class="row" style="padding-left: 5px; padding-right: 5px;">
        <div class="col-lg-12" style="padding-left: 5px; padding-right: 5px;">
            @include('flash::message')
            <div class="col-lg-3" style="padding-left: 5px; padding-right: 5px;">
                <div class="panel panel-default">
                    <div class="panel-heading" style="font-size: 16px;">Leave Approval List</div>
                    <div class="panel-body" style="max-height: 535px; overflow: auto;">
                        <div style="margin-left: 30px;">
                            <nav>
                                <ul class="nav">
                                @foreach( $departments as $buyer ) 
                                    <?php $empid1 = collect($empid)->where('DepartmentID',$buyer->id)->all(); ?>
                                    @if($uniquedeptid->DepartmentID==$buyer->id)
                                    <li style="line-height: 0.7em; margin-left: 15px;"><a href="javascript:void(0)" style="margin-left: -20px;">{!! $buyer->Department !!}</a><a href="javascript:void(0)" class="toggle-custom" id="btn-1" data-toggle="collapse" data-target="#{!! $buyer->id !!}" aria-expanded="true"><span class="glyphicon glyphicon-plus" aria-hidden="false"></span></a>
                                        <ul class="nav collapse  in" id="{!! $buyer->id !!}" role="menu" aria-labelledby="btn-1" style="margin-left: 10px;">
                                            @foreach( $empid1 as $orderr )
                                                <?php $formid11 = collect($formid)->where('EmployeeID',$orderr->EmployeeID)->all(); ?>
                                                @if($orderr->DepartmentID == $buyer->id)  
                                                    @if($orderr->EmployeeID==$uniqueleave->EmployeeID)
                                                        <li style="line-height: 0.7em; margin-left: 15px;"><a href="javascript:void(0)" style="margin-left: -20px;">{!! str_pad($orderr->EmployeeID, 6, "0", STR_PAD_LEFT) !!} : {!! $orderr->Name !!}</a><a href="javascript:void(0)" class="toggle-custom" id="btn-1" data-toggle="collapse" data-target="#{!! $orderr->EmployeeID !!}" aria-expanded="true"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span></a>
                                                            <ul class="nav collapse in" id="{!! $orderr->EmployeeID !!}" role="menu" aria-labelledby="btn-1" style="margin-left: 1px;">
                                                                @foreach( $formid11 as $fabricbooking )
                                                                    @if($orderr->EmployeeID == $fabricbooking->EmployeeID)
                                                                        @if($fabricbooking->id==$uniqueleave->id)
                                                                        <li style="line-height: 0.7em;"><a style="margin-left: -10px; background-color: lightgray;" href="{!! URL::route('hr.database.leaveapproval.show', array($fabricbooking->id)) !!}">{!! $fabricbooking->FormID !!} : {!! \Carbon\Carbon::parse($fabricbooking->ApplicationDate)->format('d-m-Y g:i A') !!}</a></li>
                                                                        @else
                                                                        <li style="line-height: 0.7em;"><a style="margin-left: -10px;" href="{!! URL::route('hr.database.leaveapproval.show', array($fabricbooking->id)) !!}">{!! $fabricbooking->FormID !!} : {!! \Carbon\Carbon::parse($fabricbooking->ApplicationDate)->format('d-m-Y g:i A') !!}</a></li>
                                                                        @endif
                                                                    @endif
                                                                @endforeach
                                                            </ul>
                                                        </li>
                                                    @else
                                                        <li style="line-height: 0.7em; margin-left: 15px;"><a href="javascript:void(0)" style="margin-left: -20px;">{!! str_pad($orderr->EmployeeID, 6, "0", STR_PAD_LEFT) !!} : {!! $orderr->Name !!}</a><a href="javascript:void(0)" class="toggle-custom" id="btn-1" data-toggle="collapse" data-target="#{!! $orderr->EmployeeID !!}" aria-expanded="false"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span></a>
                                                            <ul class="nav collapse" id="{!! $orderr->EmployeeID !!}" role="menu" aria-labelledby="btn-1" style="margin-left: 1px;">
                                                                @foreach( $formid11 as $fabricbooking )
                                                                    @if($orderr->EmployeeID == $fabricbooking->EmployeeID)
                                                                        <li style="line-height: 0.7em;"><a style="margin-left: -10px;" href="{!! URL::route('hr.database.leaveapproval.show', array($fabricbooking->id)) !!}"> {!! $fabricbooking->FormID !!} : {!! \Carbon\Carbon::parse($fabricbooking->ApplicationDate)->format('d-m-Y g:i A') !!}</a></li>
                                                                    @endif
                                                                @endforeach
                                                            </ul>
                                                        </li> 
                                                    @endif
                                                @endif
                                            @endforeach
                                        </ul>
                                    </li>
                                    @else
                                    <li style="line-height: 0.7em; margin-left: 15px;"><a href="javascript:void(0)" style="margin-left: -20px;">{!! $buyer->Department !!}</a><a href="javascript:void(0)" class="toggle-custom" id="btn-1" data-toggle="collapse" data-target="#{!! $buyer->id !!}" aria-expanded="false"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span></a>
                                        <ul class="nav collapse" id="{!! $buyer->id !!}" role="menu" aria-labelledby="btn-1" style="margin-left: 1px;">
                                            @foreach( $empid1 as $order )
                                                <?php $formid12 = collect($formid)->where('EmployeeID',$order->EmployeeID)->all(); ?>
                                                @if($order->DepartmentID == $buyer->id)
                                                   <li style="line-height: 0.7em; margin-left: 15px;"><a href="javascript:void(0)" style="margin-left: -20px;">{!! str_pad($order->EmployeeID, 6, "0", STR_PAD_LEFT) !!} : {!! $order->Name !!}</a><a href="javascript:void(0)" class="toggle-custom" id="btn-1" data-toggle="collapse" data-target="#{!! $order->EmployeeID !!}" aria-expanded="false"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span></a>
                                                        <ul class="nav collapse" id="{!! $order->EmployeeID !!}" role="menu" aria-labelledby="btn-1" style="margin-left: 1px;">
                                                            @foreach( $formid12 as $fabricbooking )
                                                                @if($order->EmployeeID == $fabricbooking->EmployeeID)
                                                                    <li style="line-height: 0.7em;"><a style="margin-left: -10px;" href="{!! URL::route('hr.database.leaveapproval.show', array($fabricbooking->id)) !!}"> {!! $fabricbooking->FormID !!} : {!! \Carbon\Carbon::parse($fabricbooking->ApplicationDate)->format('d-m-Y g:i A') !!}</a></li>
                                                                @endif
                                                            @endforeach
                                                        </ul>
                                                    </li> 
                                                @endif
                                            @endforeach
                                        </ul>
                                    </li>
                                    @endif  
                                @endforeach                            
                                </ul>
                            </nav>  
                        </div>                               
                    </div>                     
                </div>
            </div>
            {!! Form::open(array('action' => array('\App\Http\Controllers\HR\Database\LeaveApprovalController@update', $uniqueleave->id), 'method' => 'PATCH')) !!}
            <div class="col-lg-9" style="padding-left: 5px; padding-right: 5px;">
                <div class="panel panel-default">
                    <div class="panel-heading" style="font-size: 16px;">
                        Input Parameters For Leave Forwarding
                        <a href="{!! URL::route('hr.database.leaveapproval.index') !!}" class="btn btn-primary pull-right" style="margin-top: -5px;"> <span class="glyphicon glyphicon-arrow-left"></span>&nbsp;Back </a>
                    </div>
                    <div class="panel-body">
                        <div class="row" style="padding-left: 5px; padding-right: 5px;">
                            <div class="col-lg-4" style="padding-left: 5px; padding-right: 5px;">
                                <table class="table table-bordered">
                                    <tbody>
                                        <tr>
                                            <th style="width: 30%">Form ID</th>
                                            <td style="width: 70%">
                                                <div class="control-group {!! $errors->has('FormID') ? 'has-error' : '' !!}">
                                                    <div class="controls">
                                                        {!! Form::number('FormID', $uniqueleave->FormID, array('readonly', 'class'=>'form-control', 'id' => 'FormID', 'placeholder'=>'Form ID', 'value'=>Input::old('FormID'))) !!}
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Employee ID</th>
                                            <td>
                                                <div class="control-group {!! $errors->has('EmployeeID') ? 'has-error' : '' !!}">
                                                    <div class="controls">
                                                        {!! Form::number('EmployeeID', $uniqueleave->EmployeeID, array('readonly', 'class'=>'form-control', 'id' => 'EmployeeID', 'min' => '100', 'max' => '999999', 'placeholder'=>'Employee ID', 'value'=>Input::old('EmployeeID'))) !!}
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Leave Type</th>
                                            <td>
                                                <div class="control-group {!! $errors->has('LeaveTypeID') ? 'has-error' : '' !!}">
                                                    <div class="controls">
                                                        {!! Form::select('LeaveTypeID', $leavetypelist, $uniqueleave->LeaveTypeID, array('required', 'class'=>'form-control', 'id' => 'LeaveTypeID', 'placeholder'=>'Select One', 'value'=>Input::old('LeaveTypeID'))) !!}
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Reason</th>
                                            <td>
                                                <div class="control-group {!! $errors->has('ReasonID') ? 'has-error' : '' !!}">
                                                    <div class="controls">
                                                        {!! Form::select('ReasonID', $reasonlist, $uniqueleave->ReasonID, array('required', 'class'=>'form-control', 'id' => 'ReasonID', 'placeholder'=>'Select One', 'value'=>Input::old('ReasonID'))) !!}
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Start From</th>
                                            <td>
                                                <div class="control-group {!! $errors->has('StartDate') ? 'has-error' : '' !!}">
                                                    <div class="controls">
                                                        {!! Form::text('StartDate', $uniqueleave->StartDate, array('required', 'class'=>'form-control daycount', 'id' => 'StartDate', 'maxlength'=>'10', 'placeholder'=>'YYYY-MM-DD', 'value'=>Input::old('StartDate'))) !!}
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>End To</th>
                                            <td>
                                                <div class="control-group {!! $errors->has('EndDate') ? 'has-error' : '' !!}">
                                                    <div class="controls">
                                                        {!! Form::text('EndDate', $uniqueleave->EndDate, array('required', 'class'=>'form-control daycount', 'id' => 'EndDate', 'maxlength'=>'10', 'placeholder'=>'YYYY-MM-DD', 'value'=>Input::old('EndDate'))) !!}
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Day(s)</th>
                                            <td>
                                                <div class="control-group">
                                                    <div class="controls">
                                                        {!! Form::number('Days', null, array('readonly', 'class'=>'form-control', 'id' => 'Days', 'placeholder'=>'Day(s)', 'value'=>Input::old('Days'))) !!}
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Input Date</th>
                                            <td>
                                                {!! Form::text('ApplicationDate', $uniqueleave->ApplicationDate, array('readonly', 'class'=>'form-control', 'id' => 'ApplicationDate', 'placeholder'=>'YYYY-MM-DD', 'value'=>Input::old('ApplicationDate'))) !!}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Forwarded By</th>
                                            <td>
                                                <div class="control-group">
                                                    <div class="controls">
                                                        {!! Form::text('ForwardedBy2', GetUserDetails($uniqueleave->ForwardedBy)->Name, array('disabled', 'class'=>'form-control', 'id' => 'ForwardedBy2')) !!}
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-lg-4" style="padding-left: 5px; padding-right: 5px;">
                                <table class="table table-bordered">
                                    <tbody>
                                        <tr><th colspan="2" style="text-align: center; background-color: lightgray;">Photo</th></tr>
                                        <tr>
                                            <td colspan="2" style="text-align: center; pointer-events:none;">
                                                <img id="image" src="{!! URL::asset('uploads/back.jpg') !!}" width="120"/>
                                            </td>
                                        </tr>
                                        <tr><th colspan="2"></th></tr>
                                        <tr>
                                            <th style="width: 30%;">Name</th>
                                            <td style="width: 70%;">
                                                <div class="control-group {!! $errors->has('Name') ? 'has-error' : '' !!}">
                                                    <div class="controls">
                                                        {!! Form::text('Name', $uniqueleave->Name, array('readonly', 'class'=>'form-control', 'id' => 'Name', 'placeholder'=>'Employee Name', 'value'=>Input::old('Name'))) !!}
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Designation</th>
                                            <td>
                                                <div class="control-group {!! $errors->has('Designation') ? 'has-error' : '' !!}">
                                                    <div class="controls">
                                                        {!! Form::text('Designation', $uniqueleave->Designation, array('readonly', 'class'=>'form-control', 'id' => 'Designation', 'placeholder'=>'Designation', 'value'=>Input::old('Designation'))) !!}
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Department</th>
                                            <td>
                                                <div class="control-group {!! $errors->has('Department') ? 'has-error' : '' !!}">
                                                    <div class="controls">
                                                        {!! Form::text('Department', $uniqueleave->Department, array('readonly', 'class'=>'form-control', 'id' => 'Department', 'placeholder'=>'Department', 'value'=>Input::old('Department'))) !!}
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Joining Date</th>
                                            <td>
                                                <div class="control-group {!! $errors->has('JoiningDate') ? 'has-error' : '' !!}">
                                                    <div class="controls">
                                                        {!! Form::text('JoiningDate', $uniqueleave->JoiningDate, array('readonly', 'class'=>'form-control', 'id' => 'JoiningDate', 'placeholder'=>'Joining Date', 'value'=>Input::old('JoiningDate'))) !!}
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>                                            
                            </div>
                            <div class="col-lg-4" style="padding-left: 5px; padding-right: 5px;">
                                <table class="table table-bordered text-center">
                                    <thead>
                                        <tr><th colspan="4" style="text-align: center; font-size: 15px; font-weight: bold; margin-top: -5px;">Leave Card</th></tr>
                                        <tr>
                                            <th style="width: 25%;">Type</th>
                                            <th style="width: 25%;">Available</th>
                                            <th style="width: 25%;">Availed</th>
                                            <th style="width: 25%;">Balance</th>
                                        </tr>
                                    </thead>
                                    <tbody>                                    
                                        <tr>
                                            <th>CL</th>                                        
                                            <td>
                                                <div class="control-group">
                                                    <div class="controls">
                                                        {!! Form::number('MCL', null, array('readonly', 'class'=>'form-control text-center', 'id' => 'MCL')) !!}
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="control-group">
                                                    <div class="controls">
                                                        {!! Form::number('XCL', null, array('readonly', 'class'=>'form-control text-center', 'id' => 'XCL')) !!}
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="control-group">
                                                    <div class="controls">
                                                        {!! Form::number('BCL', null, array('readonly', 'class'=>'form-control text-center', 'id' => 'BCL')) !!}
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>ML</th>
                                            <td>
                                                <div class="control-group">
                                                    <div class="controls">
                                                        {!! Form::number('MML', null, array('readonly', 'class'=>'form-control text-center', 'id' => 'MML')) !!}
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="control-group">
                                                    <div class="controls">
                                                        {!! Form::number('XML', null, array('readonly', 'class'=>'form-control text-center', 'id' => 'XML')) !!}
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="control-group">
                                                    <div class="controls">
                                                        {!! Form::number('BML', null, array('readonly', 'class'=>'form-control text-center', 'id' => 'BML')) !!}
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>EL</th>
                                            <td>
                                                <div class="control-group">
                                                    <div class="controls">
                                                        {!! Form::number('MEL', null, array('readonly', 'class'=>'form-control text-center', 'id' => 'MEL')) !!}
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="control-group">
                                                    <div class="controls">
                                                        {!! Form::number('XEL', null, array('readonly', 'class'=>'form-control text-center', 'id' => 'XEL')) !!}
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="control-group">
                                                    <div class="controls">
                                                        {!! Form::number('BEL', null, array('readonly', 'class'=>'form-control text-center', 'id' => 'BEL')) !!}
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>  
                    </div>
                    <div class="panel-footer" style="margin-top: -20px;">
                        {!! Form::text('ApprovedDate', $inputDate, array('class'=>'form-control hidden', 'id' => 'ApprovedDate', 'maxlength'=>'10')) !!}
                        @foreach($uniquepermissions as $uniquepermission)
                            @if($uniquepermission->Slug=='view')
                            <button type="submit" name="reject" value="Reject" class="btn btn-warning">Reject</button>&nbsp;&nbsp;&nbsp;&nbsp;
                            {!! Form::submit('Approve', array('class' => 'btn btn-success pull-right')) !!}
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
            {!! Form::close() !!}
        </div>         
    </div>
    
    <script type="text/javascript">
        $('#StartDate').datepicker({
            format: "yyyy-mm-dd",
            todayBtn: "linked",
            orientation: "top auto",
            autoclose: true,
            todayHighlight: true,
        }).on('changeDate', function(){
            $('#EndDate').datepicker('setStartDate', new Date($(this).val()));
        });

        $('#EndDate').datepicker({
            format: "yyyy-mm-dd",
            todayBtn: "linked",
            orientation: "top auto",
            autoclose: true,
            todayHighlight: true,
        }).on('changeDate', function(){
            $('#StartDate').datepicker('setEndDate', new Date($(this).val()));
        });
    </script>

    <script type="text/javascript">
        function empLeaveInfo(){
            var empID = $("#EmployeeID").val();    
            if(empID){
                var nowdate = $('#StartDate').val();
                var date = new Date(nowdate);
                var currentYear = date.getFullYear();
                var oneDay = 24*60*60*1000; // hours*minutes*seconds*milliseconds
                var firstDate = new Date(currentYear+"-01-01");
                var nowYear = new Date().getFullYear();
                if(currentYear < nowYear){
                    var secondDate = new Date(currentYear+"-12-31");
                }else{
                    var secondDate = new Date();
                }
                var clDay2 = Math.round(Math.abs((secondDate.getTime() - firstDate.getTime())/(oneDay))/36.5);
                var mlDay2 = Math.round(Math.abs((secondDate.getTime() - firstDate.getTime())/(oneDay))/26);
            
                $.ajax({
                    type:"GET",
                    url:"{{url('hr/database/getemployeeinfo')}}",
                    data:{
                        emp_id: empID,
                        st_date: nowdate,
                    },
                    success:function(data){ 
                        if(data){
                            $("#Name").val(data.Name);
                            $("#Designation").val(data.Designation);
                            $("#Department").val(data.Department);
                            $("#JoiningDate").val(data.JoiningDate);
                            $('#image').attr('src','https://erp.texeuropbd.com/'+data.Photo);

                            var elenjoy = Number(data.ILXEL) + data.PayDays;
                            var elbal = data.EarnDays + data.PrevDays;
                            var joinDate = new Date(data.JoiningDate);
                            var joinYear = joinDate.getFullYear();
                            var clDay3 = Math.round(Math.abs((secondDate.getTime() - joinDate.getTime())/(oneDay))/36.5);
                            var mlDay3 = Math.round(Math.abs((secondDate.getTime() - joinDate.getTime())/(oneDay))/26);
                            if(currentYear == joinYear){
                                $('#MCL').val(clDay3);
                                $("#XCL").val(Number(data.ILXCL));
                                if((clDay3 - Number(data.ILXCL)) < 0){
                                    $("#BCL").val(clDay3 - Number(data.ILXCL)).css("background-color","red").css("color","white");
                                }else if((clDay3 - Number(data.ILXCL)) == 0){
                                    $("#BCL").val(clDay3 - Number(data.ILXCL)).css("background-color","orange").css("color","black");
                                }else{
                                    $("#BCL").val(clDay3 - Number(data.ILXCL)).css("background-color","lightgray").css("color","black");
                                }
                                $('#MML').val(mlDay3);
                                $("#XML").val(Number(data.ILXML));
                                if((mlDay3 - Number(data.ILXML)) < 0){
                                    $("#BML").val(mlDay3 - Number(data.ILXML)).css("background-color","red").css("color","white");
                                }else if((mlDay3 - Number(data.ILXML)) == 0){
                                    $("#BML").val(mlDay3 - Number(data.ILXML)).css("background-color","orange").css("color","black");
                                }else{
                                    $("#BML").val(mlDay3 - Number(data.ILXML)).css("background-color","lightgray").css("color","black");
                                }
                                $("#MEL").val(elbal);
                                $("#XEL").val(elenjoy);
                                if((elbal - elenjoy) < 0){
                                    $("#BEL").val(elbal - elenjoy).css("background-color","red").css("color","white");
                                }else if((elbal - elenjoy) == 0){
                                    $("#BEL").val(elbal - elenjoy).css("background-color","orange").css("color","black");
                                }else{
                                    $("#BEL").val(elbal - elenjoy).css("background-color","lightgray").css("color","black");
                                }
                            }else{
                                $('#MCL').val(clDay2);
                                $("#XCL").val(Number(data.ILXCL));
                                if((clDay2 - Number(data.ILXCL)) < 0){
                                    $("#BCL").val(clDay2 - Number(data.ILXCL)).css("background-color","red").css("color","white");
                                }else if((clDay2 - Number(data.ILXCL)) == 0){
                                    $("#BCL").val(clDay2 - Number(data.ILXCL)).css("background-color","orange").css("color","black");
                                }else{
                                    $("#BCL").val(clDay2 - Number(data.ILXCL)).css("background-color","lightgray").css("color","black");
                                }
                                $('#MML').val(mlDay2);
                                $("#XML").val(Number(data.ILXML));
                                if((mlDay2 - Number(data.ILXML)) < 0){
                                    $("#BML").val(mlDay2 - Number(data.ILXML)).css("background-color","red").css("color","white");
                                }else if((mlDay2 - Number(data.ILXML)) == 0){
                                    $("#BML").val(mlDay2 - Number(data.ILXML)).css("background-color","orange").css("color","black");
                                }else{
                                    $("#BML").val(mlDay2 - Number(data.ILXML)).css("background-color","lightgray").css("color","black");
                                }
                                $("#MEL").val(elbal);
                                $("#XEL").val(elenjoy);
                                if((elbal - elenjoy) < 0){
                                    $("#BEL").val(elbal - elenjoy).css("background-color","red").css("color","white");
                                }else if((elbal - elenjoy) == 0){
                                    $("#BEL").val(elbal - elenjoy).css("background-color","orange").css("color","black");
                                }else{
                                    $("#BEL").val(elbal - elenjoy).css("background-color","lightgray").css("color","black");
                                }
                            }
                        }else{
                            $("#Name").val('');
                            $("#Designation").val('');
                            $("#Department").val('');
                            $("#JoiningDate").val('');
                            $('#image').attr('src','');
                            $('#MCL').val('');
                            $("#XCL").val('');
                            $("#BCL").val('').css("background-color","lightgray").css("color","black");
                            $('#MML').val('');
                            $("#XML").val('');
                            $("#BML").val('').css("background-color","lightgray").css("color","black");
                            $("#MEL").val('');
                            $("#XEL").val('');
                            $("#BEL").val('').css("background-color","lightgray").css("color","black");
                        }
                    }
                });
            }else{
                $("#BCL").css("background-color","lightgray").css("color","black");
                $("#BML").css("background-color","lightgray").css("color","black");
                $("#BEL").css("background-color","lightgray").css("color","black");
            }  
        }   
        empLeaveInfo();
        $('#EmployeeID,#StartDate').on("input", function (event) {
            event.preventDefault();
            empLeaveInfo();
        });
        $('#EmployeeID,#StartDate').on("change", function (event) {  
            event.preventDefault();
            empLeaveInfo();
        });
        
        $('#LeaveTypeID').on("change", function (event) {
            event.preventDefault();
            var lvtype = $("#LeaveTypeID").val();  
            if(lvtype){
                $.ajax({
                    type:"GET",
                    url:"{{url('hr/database/getlvreason')}}",
                    data:{
                        LeaveTypeID: lvtype,
                    },
                    success:function(data){               
                        if(data){
                            $("#ReasonID").empty();
                            $.each(data, function(key,value){
                                $("#ReasonID").append('<option value="'+key+'">'+value+'</option>');
                            });
                        }else{
                           $("#ReasonID").empty();
                        }
                    }
                });
            }else{
                $("#ReasonID").empty();
            }      
        });
    </script>

    <script type="text/javascript">
        var oneDay = 24*60*60*1000;
        var input1 = document.getElementById("StartDate").value;
        var firstDate = new Date(input1);
        var input2 = document.getElementById("EndDate").value;
        var secondDate = new Date(input2);                                                                                    
        var diffDays = 0;
        if(firstDate<=secondDate){
            diffDays = Math.round(Math.abs((secondDate.getTime() - firstDate.getTime())/(oneDay))+1);
        }else{
            diffDays=0;
        } 
        $('#Days').val(diffDays); 

        $('.daycount').change(function () {
            var oneDay = 24*60*60*1000;
            var input1 = document.getElementById("StartDate").value;
            var firstDate = new Date(input1);
            var input2 = document.getElementById("EndDate").value;
            var secondDate = new Date(input2);                                                                                    
            var diffDays = 0;
            if(firstDate<=secondDate){
                diffDays = Math.round(Math.abs((secondDate.getTime() - firstDate.getTime())/(oneDay))+1);
            }else{
                diffDays=0;
            } 
            $('#Days').val(diffDays);
        }); 
    </script> 

</section>

@stop