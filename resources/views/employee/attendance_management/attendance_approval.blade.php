
@extends('layout.app')
@section('title', 'Employee | Attendance Approval')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0" style="text-align: right;">Attendance Approval</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{!! url('employee/dashboard') !!}">Employee</a></li>
                        <li class="breadcrumb-item"><a href="javascript::void(0)">Attendance Management</a></li>
                        <li class="breadcrumb-item"><a href="{!! url('employee/attendence_time_management/attendance_approval') !!}">Attendance Approval</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Index</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="row">
            <div class="col-lg-12">
                {!! Form::open(array('action' => array('\App\Http\Controllers\Employee\AttendanceManagement\AttendanceApprovalController@store', 'method' => 'Post'))) !!}
                <div class="row">
                    <div class="col">
                        <div class="card">
                            <div class="card-header with-border" style="font-size: 16px;">Input Parameters For Attendance Approval Form</div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <table class="table table-bordered">
                                            <tbody>
                                                <tr>
                                                    <th style="width: 30%">Employee ID</th>
                                                    <td style="width: 70%">
                                                        <div class="form-group {!! $errors->has('EmployeeID') ? 'has-error' : '' !!}">
                                                            <div class="controls">
                                                                {!! Form::number('EmployeeID', $empid, ['readonly', 'required', 'class' => 'form-control', 'id' => 'EmployeeID', 'min' => '100', 'max' => '999999', 'placeholder' => 'Employee ID', 'oninput' => 'empLeaveInfo()']) !!}

                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Effective Date</th>
                                                    <td>
                                                        <div class="form-group {!! $errors->has('effectiveDate') ? 'has-error' : '' !!}">
                                                            <div class="controls">
                                                                {!! Form::text('effectiveDate', $inputDate, array('required', 'class'=>'form-control datepickerbs4v1', 'id' => 'effectiveDate', 'maxlength'=>'10', 'placeholder'=>'YYYY-MM-DD', 'value'=>Input::old('effectiveDate'))) !!}
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="col-lg-4">
                                        <table class="table table-bordered">
                                            <tbody>
                                                <tr>
                                                    <th>Name</th>
                                                    <td>
                                                        <div class="form-group {!! $errors->has('name') ? 'has-error' : '' !!}">
                                                            <div class="controls">
                                                                {!! Form::text('name', null, array('readonly', 'class'=>'form-control', 'id' => 'name', 'placeholder'=>'Name')) !!}
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Request Type</th>
                                                    <td>
                                                        <div class="form-group {!! $errors->has('typeOfRequest') ? 'has-error' : '' !!}">
                                                            <div class="controls">
                                                                {!! Form::select('typeOfRequest',abnormalAttendanceType(), null, array('required', 'class'=>'form-control', 'id' => 'typeOfRequest', 'placeholder'=>'Select One', 'value'=>Input::old('typeOfRequest'))) !!}
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="col-lg-4">
                                        <table class="table table-bordered">
                                            <tbody>
                                                <tr>
                                                    <th>Designation</th>
                                                    <td>
                                                        <div class="form-group {!! $errors->has('designation') ? 'has-error' : '' !!}">
                                                            <div class="controls">
                                                                {!! Form::text('designation', null, array('readonly', 'class'=>'form-control', 'id' => 'designation', 'placeholder'=>'Designation')) !!}
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Details</th>
                                                    <td>
                                                        <div class="form-group {!! $errors->has('effectiveDate') ? 'has-error' : '' !!}">
                                                            <div class="controls">
                                                                {!! Form::textarea('details', Input::old('details'), array( 'class'=>'form-control', 'id' => 'details', 'rows' => 1)) !!}
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
                                    {!! Form::submit('Save', array('class' => 'btn btn-success')) !!}
                            </div>
                        </div>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-header with-border" style="font-size: 22px; text-align: center;">Attendance Approval Status</div>
                    <div class="card-body">
                        <div style="max-height: 450px; min-height: 450px; overflow: auto;">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Employee ID</th>
                                        <th>Name</th>
                                        <th>Designation</th>
                                        <th>Request Date</th>
                                        <th>Effective Date</th>
                                        <th>Request Type</th>
                                        <th>Details</th>
                                        <th>Head Approval</th>
                                        <th>Management Approval</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($attendanceApprovals as $approval)
                                        <tr>
                                            <td>{{ $approval->EmployeeID }}</td>
                                            <td>{{ $approval->Name }}</td>
                                            <td>{{ $approval->Designation }}</td>
                                            <td>{{ format($approval->created_at, 'Y-m-d') }}</td>
                                            <td>{{ $approval->effective_date }}</td>
                                            <td>{{ abnormalAttendanceType()[$approval->request_type] }}</td>
                                            <td>{{ $approval->details }}</td>
                                            <td style="text-align: center;">
                                                <img id="forwardBtn{{$approval->id}}"  class=""  style="width:30px" src="{{url('/images')}}{!! $approval->IsForwarded=='Y' ? '/publish_2.png' : '/not_publish_2.png' !!}"/>
                                            </td>
                                            <td  style="text-align: center;">
                                                <img id="approveBtn{{$approval->id}}"  class="" style="width:30px" src="{{url('/images')}}{!! $approval->IsApproved=='Y' ? '/publish_2.png' : '/not_publish_2.png' !!}"/>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script type="text/javascript">
        $(document).ready(function() {
            empLeaveInfo();
        });
        function empLeaveInfo() {
            var empID = $("#EmployeeID").val();

            if (empID.length >= 4) {
                var nowdate = jsCurrentDate('Y-m-d');

                $.ajax({
                    type: "GET",
                    url: "{{ url('hris/database/getemployeeinfo') }}",
                    data: {
                        emp_id: empID,
                        st_date: nowdate,
                    },
                    success: function(data) {
                        if (data) {
                            //console.log(data);
                            $("#name").val(data.Name);
                            $("#designation").val(data.Designation);
                            // $("#Department").val(data.Department);
                            // $("#JoiningDate").val(data.JoiningDate);
                            // $('#image').attr('src', domain + '/public/profiles/' + data.Photo);
                        }
                    }
                });
            }
        }
    </script>

@stop
