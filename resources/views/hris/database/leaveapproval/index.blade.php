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
</style>

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

<section class="content">
    <div class="row" style="padding-left: 5px; padding-right: 5px;">
        <div class="col-lg-12" style="padding-left: 5px; padding-right: 5px;">
            @include('flash::message')  
            <div class="col-lg-3" style="padding-left: 5px; padding-right: 5px;">
                <div class="panel panel-default">
                    <div class="panel-heading" style="font-size: 16px;">Leave Approval List</div>
                    <div class="panel-body" style="min-height: 535px; max-height: 535px; overflow: auto;">
                        <div style="margin-left: 30px;">
                            <nav>
                                <ul class="nav">
                                @foreach( $departments as $buyer )
                                <li style="line-height: 0.7em; margin-left: 15px;"><a href="javascript:void(0)" style="margin-left: -20px;">{!! $buyer->Department !!}</a><a href="javascript:void(0)" class="toggle-custom" id="btn-1" data-toggle="collapse" data-target="#{!! $buyer->id !!}" aria-expanded="false"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span></a>
                                    <ul class="nav collapse" id="{!! $buyer->id !!}" role="menu" aria-labelledby="btn-1" style="margin-left: 1px;">
                                        <?php $empid1 = collect($empid)->where('DepartmentID',$buyer->id)->all(); ?>
                                        @foreach( $empid1 as $order )
                                            @if($order->DepartmentID == $buyer->id)
                                               <li style="line-height: 0.7em; margin-left: 15px;"><a href="javascript:void(0)" style="margin-left: -20px;">{!! str_pad($order->EmployeeID, 6, "0", STR_PAD_LEFT) !!} : {!! $order->Name !!}</a><a href="javascript:void(0)" class="toggle-custom" id="btn-1" data-toggle="collapse" data-target="#{!! $order->EmployeeID !!}" aria-expanded="true"><span class="glyphicon glyphicon-plus" aria-hidden="false"></span></a>
                                                    <ul class="nav collapse in" id="{!! $order->EmployeeID !!}" role="menu" aria-labelledby="btn-1" style="margin-left: 1px;">
                                                        <?php $formid1 = collect($formid)->where('EmployeeID',$order->EmployeeID)->all(); ?>
                                                        @foreach( $formid1 as $fabricbooking )
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
                                @endforeach                            
                                </ul>
                            </nav>  
                        </div>                               
                    </div>                     
                </div>
            </div>
            
            <div class="col-lg-9" style="padding-left: 5px; padding-right: 5px;">
                @if(Sentinel::inRole('managing-director') || Sentinel::inRole('superadmin') || Sentinel::inRole('manager') || Sentinel::getUser()->id==21)
                <div class="panel panel-default">
                    <div class="panel-heading" style="font-size: 16px;">One Shot Leave Approval</div>
                    {!! Form::open(array('action' => array('\App\Http\Controllers\HR\Database\LeaveApprovalController@store', 'method' => 'Post'))) !!}
                    <div class="panel-body">
                        <div style="max-height: 450px; min-height: 450px; overflow: auto;">
                            <table class="table table-striped fixed_header">
                                <thead>
                                    <tr>
                                        <th>Employee ID</th>
                                        <th>Name</th>
                                        <th>Designation</th>
                                        <th>Department</th>
                                        <th>Joining Date</th>
                                        <th>Start Date</th>
                                        <th>End Date</th>
                                        <th style="text-align: center;">Days</th>
                                        <th style="text-align: center;">Type</th>
                                        <th>Input Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $sl1 = 1; ?>
                                    @foreach($leavedata as $enfinc)
                                    <tr>
                                        <td>
                                            <input type="checkbox" name="IncID[]" id="IncID" class="IncID" value="{!! $enfinc->id !!}"> {!! str_pad($enfinc->EmployeeID, 6, "0", STR_PAD_LEFT) !!}
                                        </td>
                                        <td>{!! $enfinc->Name !!}</td>
                                        <td>{!! $enfinc->Designation !!}</td>
                                        <td>{!! $enfinc->Department !!}</td>
                                        <td>{!! date('d-m-Y', strtotime($enfinc->JoiningDate)) !!}</td>
                                        <td>{!! date('d-m-Y', strtotime($enfinc->StartDate)) !!}</td>
                                        <td>{!! date('d-m-Y', strtotime($enfinc->EndDate)) !!}</td>
                                        <td style="text-align: center;">{!! \Carbon\Carbon::parse($enfinc->EndDate)->diffInDays(\Carbon\Carbon::parse($enfinc->StartDate))+1 !!}</td>
                                        <td style="text-align: center;">{!! $enfinc->LeaveTypeID !!}</td>
                                        <td>{!! date('d-m-Y', strtotime($enfinc->created_at)) !!}</td>
                                    </tr>
                                    <?php $sl1++; ?>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="panel-footer">
                        Total: {!! count($leavedata) !!} &nbsp;&nbsp;<button type="button" id="check_all" class="btn">Check All</button> &nbsp;&nbsp;<button type="button" id="uncheck_all" class="btn">Uncheck All</button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        {!! Form::number('CreatedBy', Sentinel::getUser()->id, array('class'=>'form-control  hidden', 'id' => 'CreatedBy')) !!}
                        @if(Sentinel::inRole('managing-director') || Sentinel::inRole('superadmin') || Sentinel::inRole('manager') || Sentinel::getUser()->id==21)
                            <button type="submit" id="delete_all" name="reject" class="btn" style="color:red;">Reject</button> &nbsp;&nbsp;
                            {!! Form::submit('Approve', array('class' => 'btn btn-success pull-right')) !!}
                        @else                                            
                            @foreach($uniquepermissions as $uniquepermission)
                                @if($uniquepermission->Slug=='view')
                                    {!! Form::submit('Approve', array('class' => 'btn btn-success pull-right')) !!}
                                @endif
                            @endforeach
                        @endif
                    </div> 
                    {!! Form::close() !!}   
                </div>
                @endif 
            </div>

        </div>         
    </div>

    <script type="text/javascript">
        $('#check_all').click(function() {
            $('.IncID').prop('checked', true);
        });
        $('#uncheck_all').click(function() {
            $('.IncID').prop('checked', false);
        });
    </script>

</section>

@stop