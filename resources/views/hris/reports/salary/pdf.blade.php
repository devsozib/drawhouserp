<!DOCTYPE html>
<html>
<head>
    <title>HRIS || Salary Reports</title>
    @include('layout/pdfhead')
</head>
<body>
    <div class="header">
        @include('layout/pdfheader')
        @if($title==1)
            {!! $caption !!} <br> {!! date('F, Y', strtotime($year.'-'.$month.'-01')) !!}
        @elseif($title==2)
            {!! $caption !!} <br>  Date: {!! date('d-m-Y', strtotime($date)) !!}
        @endif
        </p>
    </div>

    <div class="row" style="margin-top: 40px;">
        @if($title==1 && count($employees) > 0)
            <table class="table">
                <thead>
                    <tr class="border_top2">
                        <th style="min-width: 30px;">SL#</th>
                        <th style="min-width: 80px;">Card#</th>
                        <th style="min-width: 190px;">Name, Designation, Grade & Joining Date</th>
                        <th style="min-width: 120px;">Days & General Work Hour</th>
                        <th style="min-width: 100px;">Salary Statement</th>
                        <th style="min-width: 160px;">Allowance</th>
                        <th style="min-width: 70px;">Total Salary</th>
                        <th style="min-width: 70px;">Basic Payable</th>
                        <th style="min-width: 70px;">Gross Payable</th>
                        <th style="min-width: 120px;">Overtime Status</th>
                        <th style="min-width: 180px;">Deduction</th>
                        <th style="min-width: 70px;">Net Payable</th>
                        <th style="min-width: 80px;">Signature</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($departments as $department)
                        <?php $basic2 = 0; $hrent2 = 0; $med2 = 0; $food2 = 0; $conv2 = 0; $other2 = 0; $tlsalary2 = 0; $basicpay2 = 0; $attnb2 = 0; $grosspay2 = 0; $workhr2 = 0; $otamnt2 = 0; $advref2 = 0; $stdeduct2 = 0; $taxother2 = 0; $tldeduct2 = 0; $netpay2 = 0; $basicdeduct2 = 0; $hallow2 = 0; $scamnt2 = 0; $adjust2 = 0; ?>
                        <tr style="height: 40px; font-weight: bold;">
                            <th colspan="13">{!! $department->Department !!}</th>
                        </tr>
                        <?php $sl1 = 1; $basic = 0; $hrent = 0; $med = 0; $food = 0; $conv = 0; $other = 0; $tlsalary = 0; $basicpay = 0; $attnb = 0; $grosspay = 0; $workhr = 0; $otamnt = 0; $advref = 0; $stdeduct = 0; $taxother = 0; $tldeduct = 0; $netpay = 0; $basicdeduct = 0; $hallow = 0; $scamnt = 0; $adjust = 0; ?>
                        <?php $employees2 = collect($employees)->where('DepartmentID',$department->id)->all(); ?>
                        @foreach($employees2 as $employee)
                            <?php
                                $basic += $employee->Basic; $basic2 += $employee->Basic;
                                $hrent += $employee->HomeAllowance; $hrent2 += $employee->HomeAllowance;
                                $med += $employee->MedicalAllowance; $med2 += $employee->MedicalAllowance;
                                $food += $employee->FoodAllowance; $food2 += $employee->FoodAllowance;
                                $conv += $employee->Conveyance; $conv2 += $employee->Conveyance;
                                $other += $employee->ServiceCharge; $other2 += $employee->ServiceCharge;
                                $workhr += $employee->OTHour; $workhr2 += $employee->OTHour;
                                $otamnt += $employee->OTAmount; $otamnt2 += $employee->OTAmount;
                                $advref += $employee->AdvanceRefund; $advref2 += $employee->AdvanceRefund;
                                $stdeduct += $employee->LOP; $stdeduct2 += $employee->LOP;
                                $grosssal = $employee->GrossSalary + $employee->ServiceCharge;
                                $tlsalary += $grosssal; $tlsalary2 += $grosssal;

                                $abdays = $employee->ABDays;
                                $lvdays = $employee->LVDays;
                                $bpay = $employee->BasicPayable;
                                $basicpay += $bpay; $basicpay2 += $bpay;
                                $grpay = $employee->GrossPayable;
                                $grosspay += $grpay; $grosspay2 += $grpay;
                                $taxotherdeduct = $employee->IncomeTax;
                                $taxother += $taxotherdeduct; $taxother2 += $taxotherdeduct;
                                $deduction = $employee->TotalDeduction; 
                                $tldeduct += $deduction; $tldeduct2 += $deduction;

                                $hallow = $employee->HousingAllowance; $scamnt = $employee->ServiceCharge; $adjust = $employee->AdjustAmount;
                                $hallow2 = $employee->HousingAllowance; $scamnt2 = $employee->ServiceCharge; $adjust2 = $employee->AdjustAmount;

                                $netpayable = $employee->NetPayable;
                                $netpay += $netpayable; $netpay2 += $netpayable;
                            ?>
                            <tr class="border_sal">
                                <td style="vertical-align: middle; text-align: center;">{!! $sl1++ !!}</td>
                                <td style="vertical-align: middle; text-align: center;">{!! $employee->EmployeeID !!}</td>
                                <td style="vertical-align: top;">
                                    <table class="table" width="100%" style="margin: 0;">
                                        <tr>
                                            <td>{!! $employee->Name !!}</td>
                                        </tr>
                                        <tr>
                                            <td>{!! $employee->Designation !!}</td>
                                        </tr>
                                        <tr>
                                            <td>&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td>{!! date('d-m-Y', strtotime($employee->JoiningDate)) !!}</td>
                                        </tr>
                                    </table>
                                </td>
                                <td style="vertical-align: top;">
                                    <table class="table" width="100%" style="margin: 0;">
                                        <tr>
                                            <td style="width: 63%;">Present Days</td>
                                            <td style="width: 2%;">:</td>
                                            <td style="width: 35%; text-align: right;">{!! $employee->Days == 0 ? '-' : $employee->Days; !!}</td>
                                        </tr>
                                        <tr>
                                            <td>Leave Days</td>
                                            <td>:</td>
                                            <td style="text-align: right;">{!! $lvdays == 0 ? '-' : $lvdays; !!}</td>
                                        </tr>
                                        <tr>
                                            <td>Absent Days</td>
                                            <td>:</td>
                                            <td style="text-align: right;">{!! $abdays == 0 ? '-' : $abdays; !!}</td>
                                        </tr>
                                        <tr>
                                            <td>GWH</td>
                                            <td>:</td>
                                            <td style="text-align: right;">{!! $employee->GWH == 0 ? '-' : $employee->GWH; !!}</td>
                                        </tr>
                                    </table>
                                </td>
                                <td style="vertical-align: top;">
                                    <table class="table" width="100%" style="margin: 0;">
                                        <tr>
                                            <td style="width: 33%;">Basic</td>
                                            <td style="width: 2%;">:</td>
                                            <td style="width: 65%; text-align: right;">{!! $employee->Basic == 0 ? '-' : number_format($employee->Basic); !!}</td>
                                        </tr>
                                        <tr>
                                            <td>H/Rent</td>
                                            <td>:</td>
                                            <td style="text-align: right;">{!! $employee->HomeAllowance == 0 ? '-' : number_format($employee->HomeAllowance); !!}</td>
                                        </tr>
                                        <tr>
                                            <td>Medical</td>
                                            <td>:</td>
                                            <td style="text-align: right;">{!! $employee->MedicalAllowance == 0 ? '-' : number_format($employee->MedicalAllowance); !!}</td>
                                        </tr>
                                        <tr>
                                            <td>Conv.</td>
                                            <td>:</td>
                                            <td style="text-align: right;">{!! $employee->Conveyance == 0 ? '-' : number_format($employee->Conveyance); !!}</td>
                                        </tr>
                                    </table>
                                </td>
                                <td style="vertical-align: top;">
                                    <table class="table" width="100%" style="margin: 0;">
                                        <tr>
                                            <td style="width: 58%;">Housing</td>
                                            <td style="width: 2%;">:</td>
                                            <td style="width: 40%; text-align: right;">{!! $employee->HousingAllowance == 0 ? '-' : number_format($employee->HousingAllowance); !!}</td>
                                        </tr>
                                        <tr>
                                            <td>Food</td>
                                            <td>:</td>
                                            <td style="text-align: right;">{!! $employee->FoodAllowance == 0 ? '-' : number_format($employee->FoodAllowance); !!}</td>
                                        </tr>
                                        <tr>
                                            <td>Adjustment</td>
                                            <td>:</td>
                                            <td style="text-align: right;">{!! $employee->AdjustAmount == 0 ? '-' : number_format($employee->AdjustAmount); !!}</td>
                                        </tr>
                                        <tr>
                                            <td>Service Charge</td>
                                            <td>:</td>
                                            <td style="text-align: right;">{!! $employee->ServiceCharge == 0 ? '-' : number_format($employee->ServiceCharge); !!}</td>
                                        </tr>
                                    </table>
                                </td>
                                <td style="vertical-align: middle; text-align: right;">{!! $grosssal == 0 ? '-' : number_format($grosssal); !!}</td>
                                <td style="vertical-align: middle; text-align: right;">
                                    {!! $bpay == 0 ? '-' : number_format($bpay); !!}
                                </td>
                                <td style="vertical-align: middle; text-align: right;">{!! $grpay == 0 ? '-' : number_format($grpay); !!}</td>
                                <td style="vertical-align: top;">
                                    <table class="table" width="100%" style="margin: 0;">
                                        <tr>
                                            <td style="width: 48%;">Rate/Hr</td>
                                            <td style="width: 2%;">:</td>
                                            <td style="width: 50%; text-align: right;">{!! $employee->OTPayable == 'N' ? '-' : ($employee->OTRate == 0 ? '-' : number_format($employee->OTRate, 2)); !!}</td>
                                        </tr>
                                        <tr>
                                            <td>Work Hr</td>
                                            <td>:</td>
                                            <td style="text-align: right;">{!! $employee->OTHour == 0 ? '-' : number_format($employee->OTHour); !!}</td>
                                        </tr>
                                        <tr><td colspan="3"><br></td></tr>
                                        <tr>
                                            <td>Amount</td>
                                            <td>:</td>
                                            <td style="text-align: right;">{!! $employee->OTAmount == 0 ? '-' : number_format($employee->OTAmount); !!}</td>
                                        </tr>
                                    </table>
                                </td>
                                <td style="vertical-align: top;">
                                    <table class="table" width="100%" style="margin: 0;">
                                        <tr>
                                            <td style="width: 58%;">Advance Refund</td>
                                            <td style="width: 2%;">:</td>
                                            <td style="width: 40%; text-align: right;">{!! $employee->AdvanceRefund == 0 ? '-' : number_format($employee->AdvanceRefund); !!}</td>
                                        </tr>
                                        <tr>
                                            <td>Stamp Deduction</td>
                                            <td>:</td>
                                            <td style="text-align: right;">{!! $employee->LOP == 0 ? '-' : number_format($employee->LOP); !!}</td>
                                        </tr>
                                        <tr>
                                            <td>Tax & Others</td>
                                            <td>:</td>
                                            <td style="text-align: right;">{!! $taxotherdeduct == 0 ? '-' : number_format($taxotherdeduct); !!}</td>
                                        </tr>
                                        <tr>
                                            <td>Total Deduction</td>
                                            <td>:</td>
                                            <td style="text-align: right;">{!! $deduction == 0 ? '-' : number_format($deduction); !!} </td>
                                        </tr>
                                    </table>
                                </td>
                                <td style="vertical-align: middle;">
                                    <table class="table" width="100%" style="margin: 0;">
                                        <tr>
                                            <td style="text-align: right;">{!! $netpayable == 0 ? '-' : number_format($netpayable); !!}</td>
                                        </tr>
                                    </table>
                                </td>
                                <td></td>
                            </tr>
                        @endforeach
                        <tr class="border_sal">
                            <th colspan="4" style="vertical-align: top; text-align: left;">Department Total: </th>
                            <th style="vertical-align: top;">
                                <table class="table" width="100%" style="margin: 0;">
                                    <tr>
                                        <td style="width: 33%;">Basic</td>
                                        <td style="width: 2%;">:</td>
                                        <td style="width: 65%; text-align: right;">{!! $basic2 == 0 ? '-' : number_format($basic2); !!}</td>
                                    </tr>
                                    <tr>
                                        <td>H/Rent</td>
                                        <td>:</td>
                                        <td style="text-align: right;">{!! $hrent2 == 0 ? '-' : number_format($hrent2); !!}</td>
                                    </tr>
                                    <tr>
                                        <td>Medical</td>
                                        <td>:</td>
                                        <td style="text-align: right;">{!! $med2 == 0 ? '-' : number_format($med2); !!}</td>
                                    </tr>
                                    <tr>
                                        <td>Conv.</td>
                                        <td>:</td>
                                        <td style="text-align: right;">{!! $conv2 == 0 ? '-' : number_format($conv2); !!}</td>
                                    </tr>
                                </table>
                            </th>
                            <th style="vertical-align: top;">
                                <table class="table" width="100%" style="margin: 0;">
                                    <tr>
                                        <td style="width: 58%;">Housing</td>
                                        <td style="width: 2%;">:</td>
                                        <td style="width: 40%; text-align: right;">{!! $hallow2 == 0 ? '-' : number_format($hallow2); !!}</td>
                                    </tr>
                                    <tr>
                                        <td>Food</td>
                                        <td>:</td>
                                        <td style="text-align: right;">{!! $food2 == 0 ? '-' : number_format($food2); !!}</td>
                                    </tr>
                                    <tr>
                                        <td>Adjustment</td>
                                        <td>:</td>
                                        <td style="text-align: right;">{!! $adjust2 == 0 ? '-' : number_format($adjust2); !!}</td>
                                    </tr>
                                    <tr>
                                        <td>Service Charge</td>
                                        <td>:</td>
                                        <td style="text-align: right;">{!! $scamnt2 == 0 ? '-' : number_format($scamnt2); !!}</td>
                                    </tr>
                                </table>
                            </th>
                            <th style="vertical-align: middle;">
                                <table class="table" width="100%" style="margin: 0;">
                                    <tr>
                                        <td style="text-align: right;">{!! $tlsalary2 == 0 ? '-' : number_format($tlsalary2); !!}</td>
                                    </tr>
                                </table>
                            </th>
                            <th style="vertical-align: middle; text-align: right;">{!! $basicpay2 == 0 ? '-' : number_format($basicpay2); !!}</td>
                            <th style="vertical-align: middle; text-align: right;">{!! $grosspay2 == 0 ? '-' : number_format($grosspay2); !!}</td>
                            <th style="vertical-align: top;">
                                <table class="table" width="100%" style="margin: 0;">
                                    <tr><td colspan="3"><br></td></tr>
                                    <tr>
                                        <td style="width: 50%;">Work Hr</td>
                                        <td style="width: 2%;">:</td>
                                        <td style="width: 48%; text-align: right;">{!! $workhr2 == 0 ? '-' : number_format($workhr2); !!}</td>
                                    </tr>
                                    <tr><td colspan="3"><br></td></tr>
                                    <tr>
                                        <td>Amount</td>
                                        <td>:</td>
                                        <td style="text-align: right;">{!! $otamnt2 == 0 ? '-' : number_format($otamnt2); !!}</td>
                                    </tr>
                                </table>
                            </th>
                            <th style="vertical-align: top;">
                                <table class="table" width="100%" style="margin: 0;">
                                    <tr>
                                        <td style="width: 58%;">Advance Refund</td>
                                        <td style="width: 2%;">:</td>
                                        <td style="width: 40%; text-align: right;">{!! $advref2 == 0 ? '-' : number_format($advref2); !!}</td>
                                    </tr>
                                    <tr>
                                        <td>Stamp Deduction</td>
                                        <td>:</td>
                                        <td style="text-align: right;">{!! $stdeduct2 == 0 ? '-' : number_format($stdeduct2); !!}</td>
                                    </tr>
                                    <tr>
                                        <td>Tax & Others</td>
                                        <td>:</td>
                                        <td style="text-align: right;">{!! $taxother2 == 0 ? '-' : number_format($taxother2); !!}</td>
                                    </tr>
                                    <tr>
                                        <td>Total Deduction</td>
                                        <td>:</td>
                                        <td style="text-align: right;">{!! $tldeduct2 == 0 ? '-' : number_format($tldeduct2); !!}</td>
                                    </tr>
                                </table>
                            </th>
                            <th style="vertical-align: middle;">
                                <table class="table" width="100%" style="margin: 0;">
                                    <tr>
                                        <td style="text-align: right;">{!! $netpay2 == 0 ? '-' : number_format($netpay2); !!}</td>
                                    </tr>
                                </table>
                            </th>
                            <th></th>
                        </tr>
                        <tr><td colspan="13"><br></td></tr>
                    @endforeach
                </tbody>
            </table>
        @elseif($title==2 && count($employees) > 0)
            <table class="table table-bordered">
                <thead>
                    <tr class="border_top">
                        <th style="text-align: center;">SL#</th>
                        <th style="text-align: center;">ID</th>
                        <th>Name</th>
                        <th>Department</th>
                        <th>Designation</th>
                        <th>Status</th>
                        <th>Joining Date</th>
                        <th style="text-align: right;">Basic</th>
                        <th style="text-align: right;">H/Rent</th>
                        <th style="text-align: right;">Medical</th>
                        <th style="text-align: right;">Conveyance</th>
                        <th style="text-align: right;">Gross</th>
                        <th style="text-align: right;">Days In Month</th>
                        <th style="text-align: right;">Working Days</th>
                        <th style="text-align: right;">Advance/ Loan Amount</th>
                        <th style="text-align: right;">Total Deduction</th>
                        <th style="text-align: right;">Total Payment</th>
                        <th style="text-align: right;">Signature</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $sl1 = 1; ?>
                    @foreach($employees as $employee)  
                        <tr class="border_top_row">
                            <td style="text-align: center;">{!! $sl1++ !!}</td>
                            <td style="text-align: center;">{!! $employee->EmployeeID !!}</td>
                            <td>{!! $employee->Name !!}</td>
                            <td>{!! $employee->Designation !!}</td>
                            <td>{!! $employee->Department !!}</td>
                            <td>{!! $employee->ReasonID == 'N' ? 'Active' : 'Inactive' !!}</td>
                            <td>{!! date('d-m-Y', strtotime($employee->JoiningDate)) !!}</td>
                            <td style="text-align: right;">{!! number_format($employee->Basic) !!}</td>
                            <td style="text-align: right;">{!! number_format($employee->HomeAllowance) !!}</td>
                            <td style="text-align: right;">{!! number_format($employee->MedicalAllowance) !!}</td>
                            <td style="text-align: right;">{!! number_format($employee->Conveyance) !!}</td>
                            <td style="text-align: right;">{!! number_format($employee->GrossSalary) !!}</td>
                            <td style="text-align: right;">{!! number_format($employee->Days+$employee->ABDays) !!}</td>
                            <td style="text-align: right;">{!! number_format($employee->Days) !!}</td>
                            <td style="text-align: right;">{!! number_format($employee->AdvanceRefund) !!}</td>
                            <td style="text-align: right;">{!! number_format($employee->TotalDeduction) !!}</td>
                            <td style="text-align: right;">{!! number_format($employee->NetPayable) !!}</td>
                            <td style="text-align: right;"></td>
                        </tr>
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
