@extends('layout.app')
@section('title', 'HRIS | Increment Approval')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0" style="text-align: right;">Increment Approval</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{!! url('hris/dashboard') !!}">HRIS</a></li>
                        <li class="breadcrumb-item"><a href="javascript::void(0)">Database</a></li>
                        <li class="breadcrumb-item"><a href="{!! url('hris/database/incapproval') !!}">Increment Approval</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Index</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="row">
            <div class="col-lg-12">
                 <div class="card">
                    {!! Form::open(array('action' => array('\App\Http\Controllers\HRIS\Database\IncApprovalController@store', 'method' => 'Post'))) !!}
                    <div class="card-body">
                        <div style="max-height: 400px; min-height: 400px; overflow: auto; margin-bottom: 10px;">
                            <table class="table table-striped fixed_header">
                                <thead>
                                    <tr>
                                        <th>Employee ID</th>
                                        <th>Name</th>
                                        <th>Designation</th>
                                        <th>Department</th>
                                        <th style="text-align: center;">Line</th>
                                        <th>Joining Date</th>
                                        <th style="text-align: center;">Gross</th>
                                        <th style="text-align: center;">Basic</th>
                                        <th style="text-align: center;">H/Rent</th>
                                        <th style="text-align: center;">Medical</th>
                                        <th style="text-align: center;">Conveyance</th>
                                        <th>Inc. Date</th>
                                        <th>Eff. Date</th>
                                        <th>Arr. Date</th>
                                        <th>Inc. Source</th>
                                        <th>Pay. Type</th>
                                        <th style="text-align: center;">Inc. Amount</th>
                                        <th>Inc. Type</th>
                                        <th>Remarks</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $sl1 = 1; ?>
                                    @foreach($enfincs as $enfinc)
                                    <tr>
                                        <td>
                                            <input type="checkbox" name="IncID[]" id="IncID" class="IncID" value="{!! $enfinc->id !!}"> {!! $enfinc->EmployeeID !!}
                                        </td>
                                        <td>{!! getEmpName($enfinc->EmployeeID) !!}</td>
                                        <td>{!! getDesignation($enfinc->DesignationID) !!}</td>
                                        <td>{!! getDepartment($enfinc->DepartmentID) !!}</td>
                                        <td style="text-align: center;">{!! $enfinc->Line !!}</td>
                                        <td>{!! date('d-m-Y', strtotime(getEmpDetails($enfinc->EmployeeID)->JoiningDate)) !!}</td>
                                        <td style="text-align: center;">{!! number_format($enfinc->GrossSalary) !!}</td>
                                        <td style="text-align: center;">{!! number_format($enfinc->Basic) !!}</td>
                                        <td style="text-align: center;">{!! number_format($enfinc->HomeAllowance) !!}</td>
                                        <td style="text-align: center;">{!! number_format($enfinc->MedicalAllowance) !!}</td>
                                        <td style="text-align: center;">{!! number_format($enfinc->Conveyance) !!}</td>
                                        <td>{!! date('d-m-Y', strtotime($enfinc->IncrementDate)) !!}</td>
                                        <td>{!! date('d-m-Y', strtotime($enfinc->EffectiveDate)) !!}</td>
                                        <td>{!! date('d-m-Y', strtotime($enfinc->ArrearDate)) !!}</td>
                                        <td>{!! getIncSource()[$enfinc->IncSource] !!}</td>
                                        <td>{!! getPayType()[$enfinc->PayType] !!}</td>
                                        <td style="text-align: center;">{!! number_format($enfinc->Increment) !!}</td>
                                        <td>{!! getIncType($enfinc->IncType) !!}</td>
                                        <td>{!! $enfinc->Remarks !!}</td>
                                    </tr>
                                    <?php $sl1++; ?>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer">
                        Total: {!! count($enfincs) !!} &nbsp;&nbsp;<button type="button" id="check_all" class="btn">Check All</button> &nbsp;&nbsp;<button type="button" id="uncheck_all" class="btn">Uncheck All</button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        @if($edit)
                            @if($delete)
                                <button type="submit" id="delete_all" name="delete" class="btn" style="color:red;" value="delete">Delete</button> &nbsp;&nbsp;
                            @endif
                            {!! Form::submit('Enforce', array('class' => 'btn btn-success pull-right')) !!}
                        @endif
                    </div> 
                    {!! Form::close() !!}   
                 </div>
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
@stop
