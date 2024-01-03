@extends('layout.app')
@section('title', 'HRIS | Leave Application')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0" style="text-align: right;">Leave Application</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{!! url('hris/dashboard') !!}">Employee</a></li>
                        <li class="breadcrumb-item"><a href="javascript::void(0)">Leave Management</a></li>
                        <li class="breadcrumb-item"><a href="{!! url('employee/leave_management/leave_application') !!}">Leave Application</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Index</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="row">
            <div class="col-lg-12">
                {!! Form::open(array('action' => array('\App\Http\Controllers\Employee\LeaveManagement\LeaveApplicationController@store', 'method' => 'Post'))) !!}
                <div class="row">
                    <div class="col-lg-8">
                        <div class="card">
                            <div class="card-header with-border" style="font-size: 16px;">Input Parameters For Leave Application Form</div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-5">
                                        <table class="table table-bordered">
                                            <tbody>
                                                <tr>
                                                    <th style="width: 30%">Employee ID</th>
                                                    <td style="width: 70%">
                                                        <div class="form-group {!! $errors->has('EmployeeID') ? 'has-error' : '' !!}">
                                                            <div class="controls">
                                                                {!! Form::number('EmployeeID', Sentinel::getUser()->empid, array('readonly', 'class'=>'form-control', 'id' => 'EmployeeID', 'min' => '100', 'max' => '999999', 'placeholder'=>'Employee ID', 'value'=>Input::old('EmployeeID'))) !!}
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Leave Type</th>
                                                    <td>
                                                        <div class="form-group {!! $errors->has('LeaveTypeID') ? 'has-error' : '' !!}">
                                                            <div class="controls">
                                                                {!! Form::select('LeaveTypeID', $leavetypelist, null, [
                                                                    'required',
                                                                    'class' => 'form-control',
                                                                    'id' => 'LeaveTypeID',
                                                                    'placeholder' => 'Select One',
                                                                    'value' => Input::old('LeaveTypeID'),
                                                                ]) !!}
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Reason</th>
                                                    <td>
                                                        <div class="form-group {!! $errors->has('ReasonID') ? 'has-error' : '' !!}">
                                                            <div class="controls">
                                                                {!! Form::select('ReasonID', [], null, [
                                                                    'required',
                                                                    'class' => 'form-control',
                                                                    'id' => 'ReasonID',
                                                                    'placeholder' => 'Select One',
                                                                    'value' => Input::old('ReasonID'),
                                                                ]) !!}
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Start From</th>
                                                    <td>
                                                        <div class="form-group {!! $errors->has('StartDate') ? 'has-error' : '' !!}">
                                                            <div class="controls">
                                                                {!! Form::text('StartDate', $inputDate, [
                                                                    'required',
                                                                    'class' => 'form-control daycount',
                                                                    'id' => 'StartDate',
                                                                    'maxlength' => '10',
                                                                    'placeholder' => 'YYYY-MM-DD',
                                                                    'value' => Input::old('StartDate'),
                                                                ]) !!}
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>End To</th>
                                                    <td>
                                                        <div class="form-group {!! $errors->has('EndDate') ? 'has-error' : '' !!}">
                                                            <div class="controls">
                                                                {!! Form::text('EndDate', $inputDate, [
                                                                    'required',
                                                                    'class' => 'form-control daycount',
                                                                    'id' => 'EndDate',
                                                                    'maxlength' => '10',
                                                                    'placeholder' => 'YYYY-MM-DD',
                                                                    'value' => Input::old('EndDate'),
                                                                ]) !!}
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Day(s)</th>
                                                    <td>
                                                        <div class="form-group">
                                                            <div class="controls">
                                                                {!! Form::number('Days', null, [
                                                                    'readonly',
                                                                    'class' => 'form-control',
                                                                    'id' => 'Days',
                                                                    'placeholder' => 'Day(s)',
                                                                    'value' => Input::old('Days'),
                                                                ]) !!}
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
                                                    <th style="width: 30%;">Name</th>
                                                    <td style="width: 70%;">
                                                        <div class="form-group {!! $errors->has('Name') ? 'has-error' : '' !!}">
                                                            <div class="controls">
                                                                {!! Form::text('Name', null, [
                                                                    'readonly',
                                                                    'class' => 'form-control',
                                                                    'id' => 'Name',
                                                                    'placeholder' => 'Employee Name',
                                                                    'value' => Input::old('Name'),
                                                                ]) !!}
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Designation</th>
                                                    <td>
                                                        <div class="form-group {!! $errors->has('Designation') ? 'has-error' : '' !!}">
                                                            <div class="controls">
                                                                {!! Form::text('Designation', null, [
                                                                    'readonly',
                                                                    'class' => 'form-control',
                                                                    'id' => 'Designation',
                                                                    'placeholder' => 'Designation',
                                                                    'value' => Input::old('Designation'),
                                                                ]) !!}
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Department</th>
                                                    <td>
                                                        <div class="form-group {!! $errors->has('Department') ? 'has-error' : '' !!}">
                                                            <div class="controls">
                                                                {!! Form::text('Department', null, [
                                                                    'readonly',
                                                                    'class' => 'form-control',
                                                                    'id' => 'Department',
                                                                    'placeholder' => 'Department',
                                                                    'value' => Input::old('Department'),
                                                                ]) !!}
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Joining Date</th>
                                                    <td>
                                                        <div class="form-group {!! $errors->has('JoiningDate') ? 'has-error' : '' !!}">
                                                            <div class="controls">
                                                                {!! Form::text('JoiningDate', null, [
                                                                    'readonly',
                                                                    'class' => 'form-control',
                                                                    'id' => 'JoiningDate',
                                                                    'placeholder' => 'Joining Date',
                                                                    'value' => Input::old('JoiningDate'),
                                                                ]) !!}
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Input Date</th>
                                                    <td>
                                                        {!! Form::text('ApplicationDate', $inputDate, [
                                                            'readonly',
                                                            'class' => 'form-control',
                                                            'id' => 'ApplicationDate',
                                                            'placeholder' => 'YYYY-MM-DD',
                                                            'value' => Input::old('ApplicationDate'),
                                                        ]) !!}
                                                        {!! Form::text('CreatedBy2', getUserInfo(Sentinel::getUser()->id)->Name, [
                                                            'disabled',
                                                            'class' => 'form-control hidden',
                                                            'id' => 'CreatedBy2',
                                                        ]) !!}
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="col-lg-2" style="pointer-events:none;">
                                        <table class="table table-bordered text-center">
                                            <tbody>
                                                <tr><th>Photo</th></tr>
                                                <tr>
                                                    <td>
                                                        <img id="image" src="{!! URL::asset('images/Portrait_Placeholder.png') !!}" width="120"/>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer text-right">
                                @if ($create)
                                    {!! Form::submit('Save', ['class' => 'btn btn-success']) !!}
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="card">
                            <div class="card-header with-border" style="font-size: 16px;">Leave Card Summary</div>
                            <div class="card-body">
                                <table class="table table-bordered text-center">
                                    <thead>
                                        <tr style="line-height: 1.0;">
                                            <th style="width: 37%;">Leave Type</th>
                                            <th style="width: 21%;">Available</th>
                                            <th style="width: 21%;">Availed</th>
                                            <th style="width: 21%;">Balance</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($lvlimits as $item)
                                            <tr>
                                                <th>{{ $item['Description'] }}</th>
                                                <td>
                                                    <div class="form-group">
                                                        <div class="controls">
                                                            {!! Form::number('M' . $item['TypeID'], null, ['readonly', 'class' => 'form-control text-center', 'id' => 'M' . $item['TypeID']]) !!}
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group">
                                                        <div class="controls">
                                                            {!! Form::number('X' . $item['TypeID'], null, ['readonly', 'class' => 'form-control text-center', 'id' => 'X' . $item['TypeID']]) !!}
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group">
                                                        <div class="controls">
                                                            {!! Form::number('B' . $item['TypeID'], null, ['readonly', 'class' => 'form-control text-center', 'id' => 'B' . $item['TypeID']]) !!}
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>

    <?php
        $cllimit = $lvlimits->where('id', 1)->pluck('YearlyMaxlimit')->first();
        $mllimit = $lvlimits->where('id', 2)->pluck('YearlyMaxlimit')->first();
        $pllimit = $lvlimits->where('id', 3)->pluck('YearlyMaxlimit')->first();
        $mtllimit = $lvlimits->where('id', 4)->pluck('YearlyMaxlimit')->first();
        $lwplimit = $lvlimits->where('id', 5)->pluck('YearlyMaxlimit')->first();
        $bllimit = $lvlimits->where('id', 6)->pluck('YearlyMaxlimit')->first();      
        $cmllimit = $lvlimits->where('id', 7)->pluck('YearlyMaxlimit')->first();      
        $wlimit = $lvlimits->where('id', 8)->pluck('YearlyMaxlimit')->first();     
        $elimit = $lvlimits->where('id', 9)->pluck('YearlyMaxlimit')->first();     
    ?>

    <script type="text/javascript">
        var domain = '<?= $filepath ?>';
        var lvlimits = <?= json_encode($lvlimits) ?>;
        $('#StartDate').datepicker({
            format: "yyyy-mm-dd",
            todayBtn: "linked",
            orientation: "top auto",
            autoclose: true,
            todayHighlight: true,
        }).on('changeDate', function() {
            $('#EndDate').datepicker('setStartDate', new Date($(this).val()));
        });
        $('#EndDate').datepicker({
            format: "yyyy-mm-dd",
            todayBtn: "linked",
            orientation: "top auto",
            autoclose: true,
            todayHighlight: true,
        }).on('changeDate', function() {
            $('#StartDate').datepicker('setEndDate', new Date($(this).val()));
        });

        function empLeaveInfo() {
            var empID = $("#EmployeeID").val();
            let lvt = lvday = xlv = '';
            if (empID.length >= emplen) {
                var nowdate = $('#StartDate').val();
                var oneyear = moment(nowdate).subtract(1, 'year').format('YYYY-MM-DD');
                var twoyear = moment(nowdate).subtract(2, 'year').format('YYYY-MM-DD');

                var ALDay = <?= json_encode($cllimit) ?>;
                var SLDay = <?= json_encode($mllimit) ?>;
                var PTLDay = <?= json_encode($pllimit) ?>;
                var MTLDay = <?= json_encode($mtllimit) ?>;
                var LWPDay = <?= json_encode($lwplimit) ?>;
                var BLDay = <?= json_encode($bllimit) ?>;
                var CMLDay = <?= json_encode($cmllimit) ?>;
                var MLDay = <?= json_encode($wlimit) ?>;
                var EXLDay = <?= json_encode($elimit) ?>;               

                $.ajax({
                    type: "GET",
                    url: "{{ url('hris/database/getemployeeinfo') }}",
                    data: {
                        emp_id: empID,
                        st_date: nowdate,
                    },
                    success: function(data) {
                        if (data) {
                            $("#Name").val(data.Name);
                            $("#Designation").val(data.Designation);
                            $("#Department").val(data.Department);
                            $("#JoiningDate").val(data.JoiningDate);
                            $('#image').attr('src', domain + '/public/profiles/' + data.Photo);
                            
                            var joinDate = moment(data.JoiningDate).format('YYYY-MM-DD');
                            if (twoyear >= joinDate) {
                                ALDay = ALDay+2;
                            } else if (oneyear >= joinDate) {
                                ALDay = ALDay;
                            } else {
                                ALDay = 0;
                            }
                            $.each(lvlimits, function (key, value) {
                                lvt = value.TypeID;
                                lvday = eval(lvt+'Day');
                                xlv = data['ILX'+lvt];
                                $('#M'+lvt).val(lvday);
                                $("#X"+lvt).val(Number(xlv));
                                if ((lvday - Number(xlv)) < 0) {
                                    $("#B"+lvt).val(lvday - Number(xlv)).css("background-color", "red").css("color", "white");
                                } else if ((lvday - Number(data.ILXAL)) == 0) {
                                    $("#B"+lvt).val(lvday - Number(xlv)).css("background-color", "orange").css("color", "black");
                                } else {
                                    $("#B"+lvt).val(lvday - Number(xlv)).css("background-color","lightgray").css("color", "black");
                                }
                            });
                        } else {
                            $("#Name").val('');
                            $("#Designation").val('');
                            $("#Department").val('');
                            $("#JoiningDate").val('');
                            $('#image').attr('src', domain + '/public/images/Portrait_Placeholder.png');
                            $.each(lvlimits, function (key, value) {
                                lvt = value.TypeID;
                                $('#M'+lvt).val('');
                                $("#X"+lvt).val('');
                                $("#B"+lvt).val('').css("background-color","lightgray").css("color", "black");
                            });
                        }
                    }
                });
            } else {
                $("#Name").val('');
                $("#Designation").val('');
                $("#Department").val('');
                $("#JoiningDate").val('');
                $('#image').attr('src', domain + '/public/images/Portrait_Placeholder.png');
                $.each(lvlimits, function (key, value) {
                    lvt = value.TypeID;
                    $('#M'+lvt).val('');
                    $("#X"+lvt).val('');
                    $("#B"+lvt).val('').css("background-color","lightgray").css("color", "black");
                });
            }
        }

        empLeaveInfo();
        $('#EmployeeID,#StartDate').on("input", function(event) {
            event.preventDefault();
            empLeaveInfo();
        });

        $('#LeaveTypeID').on("change", function(event) {
            event.preventDefault();
            var lvtype = $("#LeaveTypeID").val();
            if (lvtype) {
                $.ajax({
                    type: "GET",
                    url: "{{ url('hris/database/getlvreason') }}",
                    data: {
                        LeaveTypeID: lvtype,
                    },
                    success: function(data) {
                        if (data) {
                            $("#ReasonID").empty();
                            $.each(data, function(key, value) {
                                $("#ReasonID").append('<option value="' + key + '">' + value +
                                    '</option>');
                            });
                        } else {
                            $("#ReasonID").empty();
                        }
                    }
                });
            } else {
                $("#ReasonID").empty();
            }
        });

        function daysCalculation() {
            var oneDay = 24 * 60 * 60 * 1000;
            var input1 = document.getElementById("StartDate").value;
            var firstDate = new Date(input1);
            var input2 = document.getElementById("EndDate").value;
            var secondDate = new Date(input2);
            var diffDays = 0;
            if (firstDate <= secondDate) {
                diffDays = Math.round(Math.abs((secondDate.getTime() - firstDate.getTime()) / (oneDay)) + 1);
            } else {
                diffDays = 0;
            }
            $('#Days').val(diffDays);
        }
        daysCalculation();
        $('.daycount').change(function() {
            daysCalculation();
        });
    </script>

@stop
