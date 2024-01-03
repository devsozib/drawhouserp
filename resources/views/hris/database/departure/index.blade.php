
@extends('layout.app')
@section('title', 'HRIS | Departure')
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
                        <li class="breadcrumb-item"><a href="javascript::void(0)">Database</a></li>
                        <li class="breadcrumb-item"><a href="{!! url('hris/database/departure') !!}">Departure</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Index</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="row">
            <div class="col-lg-2"></div>
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header with-border text-center" style="font-size: 20px;">Departure</div>
                    {!! Form::open(array('action' => array('\App\Http\Controllers\HRIS\Database\DepartureController@store', 'method' => 'Post'), 'id'=>'add_form', 'files'=>true)) !!}
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-5">
                                <table class="table table-bordered">
                                    <tbody>
                                        <tr>
                                            <th style="width: 33%">Employee ID</th>
                                            <td style="width: 2%">:</td>
                                            <td style="width: 65%">
                                                <div class="control-group {!! $errors->has('EmployeeID') ? 'has-error' : '' !!}">
                                                    <div class="controls">
                                                        {!! Form::number('EmployeeID', null, array('required', 'class'=>'form-control', 'id' => 'EmployeeID', 'min' => '100', 'max' => '999999', 'placeholder'=>'Employee ID', 'value'=>Input::old('EmployeeID'))) !!}
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Name</th>
                                            <td>:</td>
                                            <td>
                                                <div class="control-group {!! $errors->has('Name') ? 'has-error' : '' !!}">
                                                    <div class="controls">
                                                        {!! Form::text('Name', null, array('readonly', 'class'=>'form-control', 'id' => 'Name', 'placeholder'=>'Employee Name', 'value'=>Input::old('Name'))) !!}
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Designation</th>
                                            <td>:</td>
                                            <td>
                                                <div class="control-group {!! $errors->has('Designation') ? 'has-error' : '' !!}">
                                                    <div class="controls">
                                                        {!! Form::text('Designation', null, array('readonly', 'class'=>'form-control', 'id' => 'Designation', 'placeholder'=>'Designation', 'value'=>Input::old('Designation'))) !!}
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Department</th>
                                            <td>:</td>
                                            <td>
                                                <div class="control-group {!! $errors->has('Department') ? 'has-error' : '' !!}">
                                                    <div class="controls">
                                                        {!! Form::text('Department', null, array('readonly', 'class'=>'form-control', 'id' => 'Department', 'placeholder'=>'Department', 'value'=>Input::old('Department'))) !!}
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Joining Date</th>
                                            <td>:</td>
                                            <td>
                                                <div class="control-group {!! $errors->has('JoiningDate') ? 'has-error' : '' !!}">
                                                    <div class="controls">
                                                        {!! Form::text('JoiningDate', null, array('readonly', 'class'=>'form-control', 'id' => 'JoiningDate', 'placeholder'=>'Joining Date', 'value'=>Input::old('JoiningDate'))) !!}
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Tenure (Y|M|D)</th>
                                            <td>:</td>
                                            <td>
                                                <div class="row">
                                                    <div class="col-lg-4" style="margin-bottom: 2px;">
                                                        <div class="control-group">
                                                            <div class="controls">
                                                                {!! Form::text('TenureY', null, array('readonly', 'class'=>'form-control', 'id' => 'TenureY', 'placeholder'=>'Year', 'value'=>Input::old('TenureY'))) !!}
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4" style="margin-bottom: 2px;">
                                                        <div class="control-group">
                                                            <div class="controls">
                                                                {!! Form::text('TenureM', null, array('readonly', 'class'=>'form-control', 'id' => 'TenureM', 'placeholder'=>'Month', 'value'=>Input::old('TenureM'))) !!}
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4" style="margin-bottom: 2px;">
                                                        <div class="control-group">
                                                            <div class="controls">
                                                                {!! Form::text('TenureD', null, array('readonly', 'class'=>'form-control', 'id' => 'TenureD', 'placeholder'=>'Day', 'value'=>Input::old('TenureD'))) !!}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th style="width: 33%">Advance Amount</th>
                                            <td style="width: 2%">:</td>
                                            <td style="width: 65%">
                                                <div class="control-group {!! $errors->has('Salaried') ? 'has-error' : '' !!}">
                                                    <div class="controls">
                                                        {!! Form::text('AdvAmnt', null, array('readonly', 'class'=>'form-control', 'id' => 'AdvAmnt', 'placeholder'=>'Advance Amount', 'value'=>Input::old('AdvAmnt'))) !!}
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
                                            <th style="width: 33%">Payment</th>
                                            <td style="width: 2%">:</td>
                                            <td style="width: 65%">
                                                <div class="control-group {!! $errors->has('Salaried') ? 'has-error' : '' !!}">
                                                    <div class="controls">
                                                        {!! Form::select('Salaried', array('Y' => 'Paid', 'N' => 'Unpaid'), null, array('class'=>'form-control', 'id' => 'Salaried', 'value'=>Input::old('Salaried'))) !!}
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Reason</th>
                                            <td>:</td>
                                            <td>
                                                <div class="control-group {!! $errors->has('ReasonID') ? 'has-error' : '' !!}" id="form_leaveing">
                                                    <div class="controls">
                                                        {!! Form::select('ReasonID', $resonlist, null, array('required', 'class'=>'form-control', 'id' => 'ReasonID', 'placeholder'=>'Select One', 'value'=>Input::old('ReasonID'))) !!}
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Leaving Date</th>
                                            <td>:</td>
                                            <td>
                                                <div class="control-group {!! $errors->has('LeavingDate') ? 'has-error' : '' !!}">
                                                    <div class="controls">
                                                        {!! Form::text('LeavingDate', null, array('class'=>'form-control datepickerbs4v1', 'id' => 'LeavingDate', 'maxlength' => '10', 'placeholder'=>'YYYY-MM-DD', 'value'=>Input::old('LeavingDate'))) !!}
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Notes</th>
                                            <td>:</td>
                                            <td>
                                                <div class="control-group {!! $errors->has('LeavingNotes') ? 'has-error' : '' !!}">
                                                    <div class="controls">
                                                        {!! Form::text('LeavingNotes', null, array('class'=>'form-control', 'id' => 'LeavingNotes', 'maxlength' => '50', 'placeholder'=>'Leaving Notes', 'value'=>Input::old('LeavingNotes'))) !!}
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr class="form_mtreturn">
                                            <th>Maternity End Date</th>
                                            <td>:</td>
                                            <td>
                                                <div class="control-group {!! $errors->has('MTReturnDate') ? 'has-error' : '' !!}">
                                                    <div class="controls">
                                                        {!! Form::text('MTReturnDate', null, array('class'=>'form-control', 'id' => 'MTReturnDate', 'maxlength' => '10', 'placeholder'=>'YYYY-MM-DD', 'value'=>Input::old('MTReturnDate'))) !!}
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        {{-- <tr>
                                            <th>Document</th>
                                            <td>:</td>
                                            <td style="vertical-align: top;">
                                                {!! Form::file('DocPdf', array('accept'=>'.pdf','class'=>'form-control', 'id' => 'DocPdf', 'placeholder'=>'PDF', 'value'=>Input::old('DocPdf'))) !!}
                                            </td>
                                        </tr> --}}
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-lg-3 text-center" style="pointer-events:none;">
                                <div class="col-lg-12">
                                    <h4>Photo</h4>
                                    <img id="image" src="{!! URL::asset('images/Portrait_Placeholder.png') !!}" width="140" height="160"/>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        @if($create)
                            {!! Form::submit('Save', array('class' => 'btn btn-success')) !!}
                        @endif
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
            <div class="col-lg-2"></div>
        </div>
    </div>

    <script type="text/javascript">
        var domain = '<?= $imgpath ?>';
        function updateIsClosed() {
            $('.form_mtreturn').hide();
            var divKey = $("#form_leaveing option:selected").val();
            if(divKey == "M"){
                $('.form_mtreturn').show();
                $("#LeavingDate").attr('required', true);
                $("#MTReturnDate").attr('required', true);
            }else if(divKey != "N"){
                $("#LeavingDate").attr('required', true);
                $("#MTReturnDate").attr('required', false);
            }else{
                $("#LeavingDate").attr('required', false);
                $("#MTReturnDate").attr('required', false);
            }
        }
        updateIsClosed();
        $("#form_leaveing").change(function() {
            updateIsClosed();
        });

        $('#EmployeeID').on("input", function (event) {
            var empID = $("#EmployeeID").val();
            if(empID.length >= emplen){
                $.ajax({
                    type:"GET",
                    url:"{{url('hris/database/getdepartureemp')}}",
                    data:{
                        emp_id: empID,
                    },
                    success:function(data){
                        if(data){
                            $("#Name").val(data[0].Name);
                            $("#Designation").val(data[0].Designation);
                            $("#Department").val(data[0].Department);
                            $("#JoiningDate").val(data[0].JoiningDate);
                            $("#Salaried").val(data[0].Salaried);
                            $('#TenureY').val(data[1]);
                            $('#TenureM').val(data[2]);
                            $('#TenureD').val(data[3]);
                            $('#AdvAmnt').val(data[4]);
                            $("#ReasonID").val(data[0].ReasonID);
                            $("#LeavingDate").val(data[0].LeavingDate);
                            if(data[0].MTReturnDate || data[0].ReasonID == 'M'){
                                $('.form_mtreturn').show();
                                $("#MTReturnDate").val(data[0].MTReturnDate).attr('required', false);
                                if(data[0].ReasonID == 'M'){
                                    $("#MTReturnDate").val(data[0].MTReturnDate).attr('required', true);
                                }
                            }else{
                                //$('.form_mtreturn').hide();
                                $("#MTReturnDate").val(data[0].MTReturnDate).attr('required', false);
                            }
                            if(data[0].ReasonID == 'R'){
                                $("#Salaried").attr('readonly', true);
                                $("#ReasonID").attr('readonly', true);
                                $("#LeavingDate").attr('readonly', true);
                            }else{
                                $("#Salaried").attr('readonly', false);
                                $("#ReasonID").attr('readonly', false);
                                $("#LeavingDate").attr('readonly', false);
                            }
                            $("#LeavingNotes").val(data[0].LeavingNotes);
                            $('#image').attr('src', domain + '/public/profiles/' + data[0].Photo);
                            //$('#image').attr('src', 'https://hris.drawhousedesign.com/' + data[0].Photo);
                        }else{
                            $("#Name").val('');
                            $("#Designation").val('');
                            $("#Department").val('');
                            $("#JoiningDate").val('');
                            $("#Salaried").val('');
                            $('#TenureY').val('');
                            $('#TenureM').val('');
                            $('#TenureD').val('');
                            $('#AdvAmnt').val('');
                            $("#ReasonID").val('');
                            $("#LeavingDate").val('');
                            $("#MTReturnDate").val('').attr('required', false);
                            $("#Salaried").attr('readonly', false);
                            $("#ReasonID").attr('readonly', false);
                            $("#LeavingDate").attr('readonly', false);
                            $("#LeavingNotes").val('');
                            $('#image').attr('src','');
                            //$('.form_mtreturn').hide();
                        }
                    }
                });
            }else{
                //this.form.reset();
                $("#Name").val('');
                $("#Designation").val('');
                $("#Department").val('');
                $("#JoiningDate").val('');
                $("#Salaried").val('');
                $('#TenureY').val('');
                $('#TenureM').val('');
                $('#TenureD').val('');
                $("#ReasonID").val('');
                $("#LeavingDate").val('');
                $("#MTReturnDate").val('').attr('required', false);
                $("#Salaried").attr('readonly', false);
                $("#ReasonID").attr('readonly', false);
                $("#LeavingDate").attr('readonly', false);
                $("#LeavingNotes").val('');
                $('#image').attr('src','');
            }
        });

        $("#add_form").on("submit", function (event) {
            event.preventDefault();
            //var formData1 = $("#add_form").serialize();
            var formData2 = new FormData(this);
            $.ajax({
                type: 'POST',
                url: "{{url('hris/database/departure/')}}",
                data: formData2,
                cache: false,
                contentType: false,
                processData: false,
                success: function(data) {
                    //console.log(data);
                    //$('#test').append(data);
                    if (data.errors) {
                        toastr.error(data.errors, 'Error Alert', {timeOut: 1000});
                    } else {
                        toastr.success(data.success, 'Success Alert', {timeOut: 500});
                    }
                },
            });
        });
    </script>
@stop
