<!DOCTYPE html>
<html>
<head>
    <title>HRIS || Attendance Reports</title>
    @include('layout/pdfhead')
</head>
<body>
    <div class="header">
        @include('layout/pdfheader')
        @if($title==1)
            Job Card
        @endif
        </p>
    </div>

    @if($title==1 && count($employees) > 0)
        <?php $i = 1; $count = count($employees); ?>
        @foreach($employees as $employee)
            <div class="row">
                <table style="width: 100%; margin-top: 20px; font-size: 13px;">
                    <tr>
                        <td style="width: 15%; text-align: right; font-weight: 600;">ID#: </td>
                        <td style="width: 35%; text-align: left;  font-weight: 600;">{!! $employee->EmployeeID !!}</td>
                        <td style="width: 15%; text-align: right;">Designation: </td>
                        <td style="width: 35%; text-align: left;">{!! $employee->Designation !!}</td>
                    </tr>
                    <tr>
                        <td style="width: 15%; text-align: right;">Name: </td>
                        <td style="width: 35%; text-align: left;">{!! $employee->Name !!}</td>
                        <td style="width: 15%; text-align: right;">Department: </td>
                        <td style="width: 35%; text-align: left;">{!! $employee->Department !!}</td>
                    </tr>
                </table>
                <br>
                <table style="width: 100%;">
                    <tr>
                        <td style="width: 55%; border-bottom:  thin solid black; border-top:  thin dashed black; border-right:  thin solid black; text-align: right; padding-right: 10px;">
                            <p style="font-size: 12px; font-weight: bolder; font-style: italic; margin: 5px;">PAY PERIOD</p>
                        </td>
                        <td style="width: 45%; border-top:  thin solid black; border-bottom: thin dashed black;">
                            <table style="width: 100%;">
                                <tr>
                                    <td  style="width: 50%; font-size: 10px; text-align: center; font-weight: 600;">From: {!! date('d-M-Y', strtotime($start_date)) !!} </td>
                                    <td style="width: 50%; font-size: 10px; text-align: center; font-weight: 600;"> To: {!! date('d-M-Y', strtotime($end_date)) !!}</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr class="border_top">
                        <td>
                            <table width="100%">
                                <tr>
                                    <th style="width: 22%;">Work Date</th>
                                    <th style="width: 27%;">Start Punch</th>
                                    <th style="width: 27%;">End Punch</th>
                                    <th style="width: 24%;">Real Work Hour</th>
                                </tr>
                            </table>
                        </td>
                        <td>
                            <table width="100%">
                                <tr>
                                    <th style="width: 30%;">Wage Work Hour</th>
                                    <th style="width: 30%;">OT Work Hour</th>
                                    <th style="width: 40%; text-align: left;">Attendance Type</th>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <?php $rwh = 0; $wwh = 0; $oth = 0; $dup1 = ''; $dup2 = ''; $dup3 = ''; $dup4 = ''; ?>
                    <?php
                        $empid = $employee->EmployeeID;
                        $punchdata = collect($punchrecords)->where('EmployeeID',$empid)->sortBy('EmployeeID')->sortBy('WorkDate')->all();
                    ?>
                    @foreach($punchdata as $punchrecord)
                        <tr style="font-family: sans-serif;">
                            <td>
                                <table width="100%">
                                    <tr>
                                        <td style="width: 22%; text-align: center;">{!! ($punchrecord->WorkDate != 0) ? date('d-m-Y', strtotime($punchrecord->WorkDate)) : '-' !!}</td>
                                        <?php
                                            $dup1 = ($punchrecord->StartPunch != 0) ? date('d-m-Y H:i', strtotime($punchrecord->StartPunch)) : '';
                                            $dup2 = ($punchrecord->EndPunch != 0) ? date('d-m-Y H:i', strtotime($punchrecord->EndPunch)) : '';
                                        ?>
                                        @if($dup1 == $dup3 && $dup1 != '' && $dup3 != '')
                                            <td style="width: 27%; text-align: center; background-color: darkorange;">{!! ($punchrecord->StartPunch != 0) ? date('d-m-Y H:i', strtotime($punchrecord->StartPunch)) : '-' !!}</td>
                                        @elseif($dup1 == $dup4 && $dup1 != '' && $dup4 != '')
                                            <td style="width: 27%; text-align: center; background-color: darkorange;">{!! ($punchrecord->StartPunch != 0) ? date('d-m-Y H:i', strtotime($punchrecord->StartPunch)) : '-' !!}</td>
                                        @elseif($dup1 == $dup2 && $dup1 != '' && $dup2 != '')
                                            <td style="width: 27%; text-align: center; background-color: darkorange;">{!! ($punchrecord->StartPunch != 0) ? date('d-m-Y H:i', strtotime($punchrecord->StartPunch)) : '-' !!}</td>
                                        @else
                                            <td style="width: 27%; text-align: center;">{!! ($punchrecord->StartPunch != 0) ?  date('d-m-Y H:i', strtotime($punchrecord->StartPunch)) : '-' !!}</td>
                                        @endif
                                        @if($dup2 == $dup3 && $dup2 != '' && $dup3 != '')
                                            <td style="width: 27%; text-align: center; background-color: darkorange;">{!! ($punchrecord->EndPunch != 0) ? date('d-m-Y H:i', strtotime($punchrecord->EndPunch)) : '-' !!}</td>
                                        @elseif($dup2 == $dup4 && $dup2 != '' && $dup4 != '')
                                            <td style="width: 27%; text-align: center; background-color: darkorange;">{!! ($punchrecord->EndPunch != 0) ? date('d-m-Y H:i', strtotime($punchrecord->EndPunch)) : '-' !!}</td>
                                        @elseif($dup1 == $dup2 && $dup1 != '' && $dup2 != '')
                                            <td style="width: 27%; text-align: center; background-color: darkorange;">{!! ($punchrecord->EndPunch != 0) ? date('d-m-Y H:i', strtotime($punchrecord->EndPunch)) : '-' !!}</td>
                                        @else
                                            <td style="width: 27%; text-align: center;">{!! ($punchrecord->EndPunch != 0) ? date('d-m-Y H:i', strtotime($punchrecord->EndPunch)) : '-' !!}</td>
                                        @endif
                                        <?php
                                            $dup3 = ($punchrecord->StartPunch != 0) ? date('d-m-Y H:i', strtotime($punchrecord->StartPunch)) : '';
                                            $dup4 = ($punchrecord->EndPunch != 0) ? date('d-m-Y H:i', strtotime($punchrecord->EndPunch)) : '';
                                        ?>
                                        <td style="width: 24%; text-align: center;">{!! ($punchrecord->RealWorkHour != 0) ? $punchrecord->RealWorkHour : '-' !!} <?php $rwh += $punchrecord->RealWorkHour; ?></td>
                                    </tr>
                                </table>
                            </td>
                            <td>
                                <table width="100%">
                                    <tr>
                                        <td style="width: 30%; text-align: center;">{!! ($punchrecord->WageWorkHour != 0) ? $punchrecord->WageWorkHour : '-' !!}<?php $wwh += $punchrecord->WageWorkHour; ?></td>
                                        <td style="width: 30%; text-align: center;">{!! ($punchrecord->OTHour != 0) ? $punchrecord->OTHour : '-' !!}<?php $oth += $punchrecord->OTHour; ?></td>
                                        <td style="width: 40%;">{!! getAttnType($punchrecord->AttnType, $punchrecord->WorkDate) !!}</td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    @endforeach
                    <tr class="border_top">
                        <td>
                            <table width="100%">
                                <tr>
                                    <th style="width: 75%; text-align: center;">TOTAL</th>
                                    <th style="width: 25%; text-align: center;">{!! ($rwh != 0) ? number_format($rwh) : '-' !!}</th>
                                </tr>
                            </table>
                        </td>
                        <td>
                            <table width="100%">
                                <tr>
                                    <th style="width: 30%; text-align: center;">{!! ($wwh != 0) ? number_format($wwh) : '-' !!}</th>
                                    <th style="width: 30%; text-align: center;">{!! ($oth != 0) ? number_format($oth) : '-' !!}</th>
                                    <th style="width: 40%; text-align: center;"></th>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr><td colspan="2">&nbsp;</td></tr>
                    <tr>
                        <td style="vertical-align: middle; font-family: 'Source Sans Pro'; margin: 0; font-size: 14px; font-weight: bolder; font-style: italic; text-align: center; border-right: thin solid black;">TIME CARD SUMMARY</td>
                        <td style="border-left: thin solid black; padding:10px;">
                            <table width="100%" style="font-size: 13px;">
                                <tr>
                                    <td style="width: 25%;"></td>
                                    <td style="width: 35%;">Present</td>
                                    <td style="width: 5%;">:</td>
                                    <td style="width: 10%; text-align: right; padding-right: 5px;">{!! count($punchrecords->where('AttnType','PR')->where('EmployeeID',$employee->EmployeeID)) !!}</td>
                                    <td style="width: 25%;">Days</td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td>Holiday</td>
                                    <td>:</td>
                                    <td style="text-align: right; padding-right: 5px;">{!! count($punchrecords->where('AttnType','HD')->where('EmployeeID',$employee->EmployeeID)) !!}</td>
                                    <td>Days</td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td>Absent</td>
                                    <td>:</td>
                                    <td style="text-align: right; padding-right: 5px;">{!! count($punchrecords->where('AttnType','AB')->where('EmployeeID',$employee->EmployeeID)) !!}</td>
                                    <td>Days</td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td>Annual Leave</td>
                                    <td>:</td>
                                    <td style="text-align: right; padding-right: 5px;">{!! count($punchrecords->where('AttnType','CL')->where('EmployeeID',$employee->EmployeeID)) !!}</td>
                                    <td>Days</td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td>Sick Leave</td>
                                    <td>:</td>
                                    <td style="text-align: right; padding-right: 5px;">{!! count($punchrecords->where('AttnType','ML')->where('EmployeeID',$employee->EmployeeID)) !!}</td>
                                    <td>Days</td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td>Without Pay Leave</td>
                                    <td>:</td>
                                    <td style="text-align: right; padding-right: 5px;">{!! count($punchrecords->where('AttnType','WP')->where('EmployeeID',$employee->EmployeeID)) !!}</td>
                                    <td>Days</td>
                                </tr>
                                <tr><td colspan="5"><hr style="border: none; border-top: thin solid black;"></td></tr>
                                <tr>
                                    <td></td>
                                    <td style="font-weight: 600;">Total Wages Day</td>
                                    <td style="font-weight: 600;">:</td>
                                    <td style="font-weight: 600; text-align: right; padding-right: 5px;">
                                        <?php
                                            $empid = $employee->EmployeeID;
                                            $wdays = $punchrecords->filter(function ($value, $key) use ($empid) {
                                                return $value->EmployeeID == $empid && $value->AttnType != 'AB' && $value->AttnType != 'WP' && $value->AttnType != 'MT';
                                            })->count();
                                        ?>
                                        {!! $wdays !!}
                                    </td>
                                    <td style="font-weight: 600;">Days</td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td style="font-weight: 600;">Total Late Coming</td>
                                    <td style="font-weight: 600;">:</td>
                                    <td style="font-weight: 600; text-align: right; padding-right: 5px;">{!! count($punchrecords->where('IsLate','Y')->where('EmployeeID',$employee->EmployeeID)) !!}</td>
                                    <td style="font-weight: 600;">Days</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
                @if($i < $count)
                    <div class="page-break"></div>
                @endif
                <?php $i++; ?>
            </div>
        @endforeach
    @else
        <div style="font-size: 15px; text-align: center; color: darkorange; margin-top:100px">No Information Found With Provided Data Combination</div>
    @endif
    @include('layout/pdfprintby')
</body>
</html>
