<!DOCTYPE html>
<html>
<head>
    <title>HRIS || Listing Reports</title>
    @include('layout/pdfhead')
</head>
<body> 
    <div class="header">
        @include('layout/pdfheader')
        @if($title==1)
            {!! $caption !!} <br> Date: {!! date('d-m-Y', strtotime($date)) !!}
        @elseif($title==2)
            {!! $caption !!} <br> Date: {!! date('d-m-Y', strtotime($date)) !!}
        @elseif($title==3)
            {!! $caption !!} <br> Date: {!! date('d-m-Y', strtotime($date)) !!}
        @endif
        </p>
    </div>

    <div class="row" style="margin-top: 40px;">
        @if($title==1 && count($employees) > 0)
            <table class="table table-bordered datatblrpt" id="usertbl">
                <thead>
                    <tr class="border_top">
                        <th style="text-align: center;">SL#</th>
                        <th style="text-align: center;">ID</th>
                        <th>Name</th>
                        <th>Designation</th>
                        <th>Joining Date</th> 
                    </tr>
                </thead>
                <tbody>
                    @foreach($departments as $department)
                        <tr style="line-height: 30px; font-weight: bold;">
                            <td colspan="5">{!! $department->Department !!}</td>
                            <td style="display: none;"></td>
                            <td style="display: none;"></td>
                            <td style="display: none;"></td>
                            <td style="display: none;"></td>
                        </tr>
                        <?php $sl1 = 1; $employees2 = collect($employees)->where('DepartmentID',$department->id)->all(); ?>
                        @foreach($employees2 as $employee)  
                            <tr class="border_top_row">
                                <td style="text-align: center;">{!! $sl1++ !!}</td>
                                <td style="text-align: center;">{!! $employee->EmployeeID !!}</td>
                                <td>{!! $employee->Name !!}</td>
                                <td>{!! $employee->Designation !!}</td>
                                <td>{!! date('d-m-Y', strtotime($employee->JoiningDate)) !!}</td>
                            </tr>
                        @endforeach
                    @endforeach
                </tbody>
            </table> 
        @elseif($title==2 && count($employees) > 0)                      
            <table class="table table-bordered datatblrpt" id="usertbl">
                <thead>
                    <tr class="border_top">
                        <th style="text-align: center;">SL#</th>
                        <th style="text-align: center;">ID</th>
                        <th>Name</th>
                        <th>Department</th>
                    </tr>
                </thead>
                <tbody> 
                    @foreach($departments as $designation)
                        <tr style="line-height: 30px; font-weight: bold;">
                            <td colspan="4">{!! $designation->Designation !!}</td>
                            <td style="display: none;"></td>
                            <td style="display: none;"></td>
                            <td style="display: none;"></td>
                        </tr>
                        <?php $sl1 = 1; $employees2 = collect($employees)->where('DesignationID',$designation->id)->all(); ?>
                        @foreach($employees2 as $employee)
                            <tr class="border_top_row">
                                <td style="text-align: center;">{!! $sl1++ !!}</td>
                                <td style="text-align: center;">{!! $employee->EmployeeID !!}</td>
                                <td>{!! $employee->Name !!}</td>
                                <td>{!! $employee->Department !!}</td>
                            </tr>
                        @endforeach
                    @endforeach
                </tbody>
            </table> 
        @elseif($title==3 && count($employees) > 0)
            <table class="table table-bordered datatblrpt" id="usertbl">
                <thead>
                    <tr class="border_top">
                        <th style="text-align: center;">SL#</th>
                        <th style="text-align: center;">ID</th>
                        <th>Name</th>
                        <th>Designation</th>
                        <th>Joining Date</th> 
                        <th style="text-align: right;">Gross Salary</th> 
                        <th style="text-align: right;">Basic</th> 
                        <th style="text-align: right;">Medical Allow</th> 
                        <th style="text-align: right;">Home Allow</th> 
                        <th style="text-align: right;">Conveyance</th> 
                        <th style="text-align: right;">Housing Allow</th> 
                        <th style="text-align: right;">Food Allow</th> 
                        <th style="text-align: right;">Other Allow</th> 
                        <th style="text-align: right;">Service Charge</th> 
                        <th style="text-align: right;">Service Charge %</th> 
                        <th style="text-align: right;">Total Salary</th> 
                    </tr>
                </thead>
                <tbody>
                    @foreach($departments as $department)
                        <tr style="line-height: 30px; font-weight: bold;">
                            <td colspan="16">{!! $department->Department !!}</td>
                            <td style="display: none;"></td>
                            <td style="display: none;"></td>
                            <td style="display: none;"></td>
                            <td style="display: none;"></td>
                            <td style="display: none;"></td>
                            <td style="display: none;"></td>
                            <td style="display: none;"></td>
                            <td style="display: none;"></td>
                            <td style="display: none;"></td>
                            <td style="display: none;"></td>
                            <td style="display: none;"></td>
                            <td style="display: none;"></td>
                            <td style="display: none;"></td>
                            <td style="display: none;"></td>
                            <td style="display: none;"></td>
                        </tr>
                        <?php $sl1 = 1; $employees2 = collect($employees)->where('DepartmentID',$department->id)->all(); ?>
                        @foreach($employees2 as $employee)  
                            <?php 
                                $scharge = ($employee->ServiceCharge/100)*$employee->ServiceChargePer;
                                $totalsalary = $employee->GrossSalary+$employee->HousingAllowance+$employee->FoodAllowance+$employee->OtherAllowance+$scharge;
                            ?>
                            <tr class="border_top_row">
                                <td style="text-align: center;">{!! $sl1++ !!}</td>
                                <td style="text-align: center;">{!! $employee->EmployeeID !!}</td>
                                <td>{!! $employee->Name !!}</td>
                                <td>{!! $employee->Designation !!}</td>
                                <td>{!! date('d-m-Y', strtotime($employee->JoiningDate)) !!}</td>
                                <td style="text-align: right;">{!! number_format($employee->GrossSalary,2) !!}</td>
                                <td style="text-align: right;">{!! number_format($employee->Basic,2) !!}</td>
                                <td style="text-align: right;">{!! number_format($employee->MedicalAllowance,2) !!}</td>
                                <td style="text-align: right;">{!! number_format($employee->HomeAllowance,2) !!}</td>
                                <td style="text-align: right;">{!! number_format($employee->Conveyance,2) !!}</td>
                                <td style="text-align: right;">{!! number_format($employee->HousingAllowance,2) !!}</td>
                                <td style="text-align: right;">{!! number_format($employee->FoodAllowance,2) !!}</td>
                                <td style="text-align: right;">{!! number_format($employee->OtherAllowance,2) !!}</td>
                                <td style="text-align: right;">{!! number_format($employee->ServiceCharge,2) !!}</td>
                                <td style="text-align: right;">{!! number_format($employee->ServiceChargePer,2) !!}</td>
                                <td style="text-align: right;">{!! number_format($totalsalary,2) !!}</td>
                            </tr>
                        @endforeach
                    @endforeach
                </tbody>
            </table>
        @else
            <div style="font-size: 15px; text-align: center; color: darkorange">No Information Found With Provided Data Combination</div>
        @endif
        @include('layout/pdfprintby')
    </div>
</body>
</html>