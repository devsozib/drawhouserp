@extends('layout.app')
@section('title', 'HRIS | Attendance')
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
                        <li class="breadcrumb-item"><a href="{!! url('hris/reports/attendance') !!}">Attendance</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Preview</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header with-border" style="font-size: 22px; text-align: center">Attendance Reports</div>
                    <div class="card-body">
                        <div style="text-align: center;">
                            @if($title==1)
                                <h5>{!! $caption !!}</h5>
                                <h5>Date Range: {!! date('d-m-Y', strtotime($start_date)) !!} to {!! date('d-m-Y', strtotime($end_date)) !!}</h5>
                            @elseif($title==2)
                                <h5>{!! $caption !!}</h5>
                                <h5>Date Range: {!! date('d-m-Y', strtotime($start_date)) !!} to {!! date('d-m-Y', strtotime($end_date)) !!}</h5>
                            @elseif($title==3)
                                <h5>{!! $caption !!}</h5>
                                <h5>Date Range: {!! date('d-m-Y', strtotime($start_date)) !!} to {!! date('d-m-Y', strtotime($end_date)) !!}</h5>
                            @elseif($title==4)
                                <h5>{!! $caption !!}</h5>
                                <h5>Date Range: {!! date('d-m-Y', strtotime($start_date)) !!} to {!! date('d-m-Y', strtotime($end_date)) !!}</h5>
                            @endif
                            <hr style="border-bottom: 1px solid black;">

                            @if($title==1 && count($employees) > 0)
                                @foreach($employees as $employee)
                                    <table class="table" style="width: 40%;">
                                        <tbody>
                                            <tr>
                                                <th colspan="3">Employee Details</th>
                                            </tr>
                                            <tr>
                                                <th style="width: 28%;">ID</th>
                                                <th style="width: 2%;">:</th>
                                                <th style="width: 70%;">{!! $employee->EmployeeID !!}</th>
                                            </tr>
                                            <tr>
                                                <th>Name</th>
                                                <th>:</th>
                                                <th>{!! $employee->Name !!}</th>
                                            </tr>
                                            <tr>
                                                <th>Designation</th>
                                                <th>:</th>
                                                <th>{!! $employee->Designation !!}</th>
                                            </tr>
                                            <tr>
                                                <th>Department</th>
                                                <th>:</th>
                                                <th>{!! $employee->Department !!}</th>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <table class="table table-bordered" style="margin-top: -5px;">
                                        <thead>
                                            <tr>
                                                <th>
                                                    <table width="100%">
                                                        <tr>
                                                            <td colspan="3" style="text-align: center; background: lightgrey">Punch Time</td>
                                                        </tr>
                                                        <tr>
                                                            <td style="width: 34%;">Work Date</td>
                                                            <td style="width: 33%;">Start Punch</td>
                                                            <td style="width: 33%;">End Punch</td>
                                                        </tr>
                                                    </table>
                                                </th>
                                                <th style="text-align: right;">Real Work Hour</th>
                                                <th style="text-align: right;">Wage Work Hour</th>
                                                <th style="text-align: right;">OT Work Hour</th>
                                                <th style="text-align: center;">Shift</th>
                                                <th>Attendance Type</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $rwh = 0; $wwh = 0; $oth = 0; $dup1 = ''; $dup2 = ''; $dup3 = ''; $dup4 = ''; ?>
                                            <?php
                                                $empid = $employee->EmployeeID;
                                                $punchdata = collect($punchrecords)->where('EmployeeID',$empid)->sortBy('EmployeeID')->sortBy('WorkDate')->all();
                                            ?>
                                            @foreach($punchdata as $punchrecord)
                                                <tr>
                                                    <td>
                                                        <table width="100%">
                                                            <tr>
                                                                <td style="width: 34%;">{!! ($punchrecord->WorkDate != 0) ? date('d-m-Y', strtotime($punchrecord->WorkDate)) : '-' !!}</td>
                                                                <?php
                                                                    $dup1 = ($punchrecord->StartPunch != 0) ? date('d-m-Y H:i', strtotime($punchrecord->StartPunch)) : '';
                                                                    $dup2 = ($punchrecord->EndPunch != 0) ? date('d-m-Y H:i', strtotime($punchrecord->EndPunch)) : '';
                                                                ?>
                                                                @if($dup1 == $dup3 && $dup1 != '' && $dup3 != '')
                                                                    <td style="width: 33%; background-color: darkorange;">{!! ($punchrecord->StartPunch != 0) ? date('d-m-Y H:i', strtotime($punchrecord->StartPunch)) : '-' !!}</td>
                                                                @elseif($dup1 == $dup4 && $dup1 != '' && $dup4 != '')
                                                                    <td style="width: 33%; background-color: darkorange;">{!! ($punchrecord->StartPunch != 0) ? date('d-m-Y H:i', strtotime($punchrecord->StartPunch)) : '-' !!}</td>
                                                                @elseif($dup1 == $dup2 && $dup1 != '' && $dup2 != '')
                                                                    <td style="width: 33%; background-color: darkorange;">{!! ($punchrecord->StartPunch != 0) ? date('d-m-Y H:i', strtotime($punchrecord->StartPunch)) : '-' !!}</td>
                                                                @else
                                                                    <td style="width: 33%;">{!! ($punchrecord->StartPunch != 0) ?  date('d-m-Y H:i', strtotime($punchrecord->StartPunch)) : '-' !!}</td>
                                                                @endif
                                                                @if($dup2 == $dup3 && $dup2 != '' && $dup3 != '')
                                                                    <td style="width: 33%; background-color: darkorange;">{!! ($punchrecord->EndPunch != 0) ? date('d-m-Y H:i', strtotime($punchrecord->EndPunch)) : '-' !!}</td>
                                                                @elseif($dup2 == $dup4 && $dup2 != '' && $dup4 != '')
                                                                    <td style="width: 33%; background-color: darkorange;">{!! ($punchrecord->EndPunch != 0) ? date('d-m-Y H:i', strtotime($punchrecord->EndPunch)) : '-' !!}</td>
                                                                @elseif($dup1 == $dup2 && $dup1 != '' && $dup2 != '')
                                                                    <td style="width: 33%; background-color: darkorange;">{!! ($punchrecord->EndPunch != 0) ? date('d-m-Y H:i', strtotime($punchrecord->EndPunch)) : '-' !!}</td>
                                                                @else
                                                                    <td style="width: 33%;">{!! ($punchrecord->EndPunch != 0) ? date('d-m-Y H:i', strtotime($punchrecord->EndPunch)) : '-' !!}</td>
                                                                @endif
                                                                <?php
                                                                    $dup3 = ($punchrecord->StartPunch != 0) ? date('d-m-Y H:i', strtotime($punchrecord->StartPunch)) : '';
                                                                    $dup4 = ($punchrecord->EndPunch != 0) ? date('d-m-Y H:i', strtotime($punchrecord->EndPunch)) : '';
                                                                ?>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                    <td style="text-align: right;">{!! $punchrecord->RealWorkHour !!} <?php $rwh += $punchrecord->RealWorkHour; ?></td>
                                                    <td style="text-align: right;">{!! $punchrecord->WageWorkHour !!} <?php $wwh += $punchrecord->WageWorkHour; ?></td>
                                                    <td style="text-align: right;">{!! $punchrecord->OTHour !!} <?php $oth += $punchrecord->OTHour; ?></td>
                                                    <td style="text-align: center;">{!! $punchrecord->Shift !!}</td>
                                                    <td>{!! getAttnType($punchrecord->AttnType,$punchrecord->WorkDate) !!}</td>
                                                </tr>
                                            @endforeach
                                            <tr style="height: 35px;">
                                                <th style="text-align: center;">Total: </th>
                                                <th style="text-align: right;">{!! number_format($rwh);  !!}</th>
                                                <th style="text-align: right;">{!! number_format($wwh);  !!}</th>
                                                <th style="text-align: right;">{!! number_format($oth);  !!}</th>
                                                <th></th>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <table class="table" style="width: 40%;">
                                        <tbody>
                                            <tr>
                                                <th colspan="3">Time Card Summary</th>
                                            </tr>
                                            <tr>
                                                <td style="width: 58%;">Present</td>
                                                <td style="width: 2%;">:</td>
                                                <td style="width: 40%;">{!! count($punchrecords->where('AttnType','PR')->where('EmployeeID',$employee->EmployeeID)) !!}</td>
                                            </tr>
                                            <tr>
                                                <td>Holiday</td>
                                                <td>:</td>
                                                <td>{!! count($punchrecords->where('AttnType','HD')->where('EmployeeID',$employee->EmployeeID)) !!}</td>
                                            </tr>
                                            <tr>
                                                <td>Absent</td>
                                                <td>:</td>
                                                <td>{!! count($punchrecords->where('AttnType','AB')->where('EmployeeID',$employee->EmployeeID)) !!}</td>
                                            </tr>
                                            <tr>
                                                <td>Casual Leave</td>
                                                <td>:</td>
                                                <td>{!! count($punchrecords->where('AttnType','CL')->where('EmployeeID',$employee->EmployeeID)) !!}</td>
                                            </tr>
                                            <tr>
                                                <td>Medical Leave</td>
                                                <td>:</td>
                                                <td>{!! count($punchrecords->where('AttnType','ML')->where('EmployeeID',$employee->EmployeeID)) !!}</td>
                                            </tr>
                                            <tr>
                                                <td>Earn Leave</td>
                                                <td>:</td>
                                                <td>{!! count($punchrecords->where('AttnType','EL')->where('EmployeeID',$employee->EmployeeID)) !!}</td>
                                            </tr>
                                            <tr>
                                                <td>Without Pay Leave</td>
                                                <td>:</td>
                                                <td>{!! count($punchrecords->where('AttnType','WP')->where('EmployeeID',$employee->EmployeeID)) !!}</td>
                                            </tr>
                                            <tr>
                                                <th style="border-top: 1px solid;">Total Wages Day</th>
                                                <th style="border-top: 1px solid;">:</th>
                                                <th style="border-top: 1px solid;">
                                                    <?php
                                                        $empid = $employee->EmployeeID;
                                                        $wdays = $punchrecords->filter(function ($value, $key) use ($empid) {
                                                            return $value->EmployeeID == $empid && $value->AttnType != 'AB' && $value->AttnType != 'WP' && $value->AttnType != 'MT';
                                                        })->count();
                                                    ?>
                                                    {!! $wdays !!}
                                                </th>
                                            </tr>
                                            <tr>
                                                <th>Total Late Coming</th>
                                                <th>:</th>
                                                <th>{!! count($punchrecords->where('IsLate','Y')->where('EmployeeID',$employee->EmployeeID)) !!}</th>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <br>
                                    <br>
                                @endforeach
                            @elseif($title==2 && count($employees) > 0)
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th style="text-align: center;">SL#</th>
                                            <th style="text-align: center;">ID</th>
                                            <th>Name</th>
                                            <th>Designation</th> 
                                            <th>Work Date</th> 
                                            <th>Shift</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($departments as $department)
                                            <tr style="height: 40px; font-weight: bold;">
                                                <td colspan="6">{!! $department->Department !!}</td>
                                                <td style="display: none;"></td>
                                                <td style="display: none;"></td>
                                                <td style="display: none;"></td>
                                                <td style="display: none;"></td>
                                                <td style="display: none;"></td>
                                            </tr>
                                            <?php $sl1 = 1; $employees2 = collect($employees)->where('DepartmentID',$department->id)->all(); ?>
                                            @foreach($employees2 as $employee) 
                                                <tr>
                                                    <td style="text-align: center;">{!! $sl1++ !!}</td>
                                                    <td style="text-align: center;">{!! $employee->EmployeeID !!}</td>
                                                    <td>{!! $employee->Name !!}</td>
                                                    <td>{!! $employee->Designation !!}</td>
                                                    <td>{!! date('d-m-Y', strtotime($employee->WorkDate)) !!}</td>
                                                    <td>{!! $employee->Shift !!}</td>
                                                </tr>
                                            @endforeach
                                        @endforeach
                                    </tbody>
                                </table> 
                            @elseif($title==3 && count($employees) > 0)
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th style="text-align: center;">SL#</th>
                                            <th style="text-align: center;">ID</th>
                                            <th>Name</th>
                                            <th>Designation</th> 
                                            <th>Work Date</th> 
                                            <th>Shift</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($departments as $department)
                                            <tr style="height: 40px; font-weight: bold;">
                                                <td colspan="6">{!! $department->Department !!}</td>
                                                <td style="display: none;"></td>
                                                <td style="display: none;"></td>
                                                <td style="display: none;"></td>
                                                <td style="display: none;"></td>
                                                <td style="display: none;"></td>
                                            </tr>
                                            <?php $sl1 = 1; $employees2 = collect($employees)->where('DepartmentID',$department->id)->all(); ?>
                                            @foreach($employees2 as $employee) 
                                                <tr>
                                                    <td style="text-align: center;">{!! $sl1++ !!}</td>
                                                    <td style="text-align: center;">{!! $employee->EmployeeID !!}</td>
                                                    <td>{!! $employee->Name !!}</td>
                                                    <td>{!! $employee->Designation !!}</td>
                                                    <td>{!! date('d-m-Y', strtotime($employee->WorkDate)) !!}</td>
                                                    <td>{!! $employee->Shift !!}</td>
                                                </tr>
                                            @endforeach
                                        @endforeach
                                    </tbody>
                                </table> 
                            @elseif($title==4 && count($employees) > 0)
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th style="text-align: center;">SL#</th>
                                            <th style="text-align: center;">ID</th>
                                            <th>Name</th>
                                            <th>Designation</th> 
                                            <th>Department</th> 
                                            <th>Work Time</th> 
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $sl1 = 1; ?>
                                        @foreach($employees as $employee) 
                                            <tr>
                                                <td style="text-align: center;">{!! $sl1++ !!}</td>
                                                <td style="text-align: center;">{!! $employee->EmployeeID !!}</td>
                                                <td>{!! $employee->Name !!}</td>
                                                <td>{!! $employee->Designation !!}</td>
                                                <td>{!! $employee->Department !!}</td>
                                                <td>{!! date('d-m-Y H:i:s', strtotime($employee->AttnDate)) !!}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table> 
                            @else
                                <div style="color: darkorange; text-align: center;">No Information Found With Provided Data Combination</div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@stop

