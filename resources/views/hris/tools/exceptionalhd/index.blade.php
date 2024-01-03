@extends('layout.app')
@section('title', 'HRIS | Exceptional Holiday')
@section('content')
    <?php
        $inputDate = \Carbon\Carbon::now()->format('Y-m-d');
        $enddate = \Carbon\Carbon::now()->endOfMonth()->format('Y-m-d');
    ?>
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0" style="text-align: right;">Exceptional Holiday</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{!! url('hris/dashboard') !!}">HRIS</a></li>
                        <li class="breadcrumb-item"><a href="javascript::void(0)">Tools</a></li>
                        <li class="breadcrumb-item"><a href="{!! url('hris/tools/exceptionalhd') !!}">Exceptional Holiday</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Index</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-1">
                    </div>
                    <div class="col-lg-10">
                        <div class="row">
                            <div class="col-lg-5">
                                <div class="card" style="min-height: 222px;">
                                    <div class="card-header with-border">Exceptional Holiday Generate For Year</div>
                                    <div class="card-body">
                                        {{-- @if(Sentinel::inRole('superadmin')) --}}
                                        {!! Form::open(array('action' => array('\App\Http\Controllers\HRIS\Tools\ExceptionalHDController@store', 'method' => 'Post', 'form_id' => '1'), 'id'=>'gen_form')) !!}
                                        <table class="table table-bordered">
                                            <tbody>
                                                <tr>
                                                    <th style="width: 18%;">Year</th>
                                                    <td style="width: 2%">:</td>
                                                    <td style="width: 50%">
                                                        <div class="control-group {!! $errors->has('Year') ? 'has-error' : '' !!}">
                                                            <div class="controls">
                                                                {!! Form::number('Year', $hroptions->Year, array('readonly', 'required', 'class'=>'form-control', 'id' => 'Year', 'min' => '2000', 'max' => '2100', 'placeholder'=>'Year', 'value'=>Input::old('Year'))) !!}
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td style="width: 30%; text-align: center;">
                                                        @if($create)
                                                            {!! Form::submit('Generate', array('class' => 'btn btn-success', 'id' => 'shiftgen')) !!}
                                                        @endif
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        {!! Form::close() !!}
                                        {{-- @endif --}}
                                                                           
                                        {!! Form::open(array('action' => array('\App\Http\Controllers\HRIS\Tools\ExceptionalHDController@store', 'method' => 'Post'), 'id'=>'createexpholiday')) !!}
                                            <table class="table table-bordered" style="margin-bottom: -5px;">
                                                <tbody>
                                                    <tr>
                                                        {!! Form::hidden('forCreateExpHoliday', 1, ['class' => 'form-control']) !!}
                                                        <td style="width: 80%;">
                                                            <div class="row">
                                                                <div class="col-lg-6" style="margin-bottom: 5px;">
                                                                    <div class="control-group">
                                                                        <label for="employee_id">Employee ID</label>
                                                                        <div class="controls">
                                                                            {!! Form::text('employee_id', null, [                                                        
                                                                                'class' => 'form-control',
                                                                                'id' => 'employee_id',
                                                                                'placeholder' => 'Employee ID',
                                                                                'value' => Input::old('Name'),
                                                                            ]) !!}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-6">
                                                                    <div class="form-group {!! $errors->has('Name') ? 'has-error' : '' !!}">
                                                                        <label for="date">Date</label>
                                                                        <div class="controls">
                                                                            {!! Form::text('date', null, [
                                                                                'readonly',
                                                                                'class' => 'form-control datepicker',
                                                                                'id' => 'date',
                                                                                'placeholder' => 'Pick Date',
                                                                                'value' => Input::old('date'),
                                                                            ]) !!}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td style="width: 20%; text-align: center; vertical-align: middle;">
                                                            <button type="submit" id="createED" class="btn btn-success">Create</button>
                                                        </td>
                                                    </tr>
                                                    
                                                </tbody>
                                            </table>
                                        {!! Form::close() !!}                                   
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-7">
                                <div class="card">
                                    <div class="card-header with-border">Display Exceptional Holiday For Date Range</div>
                                    {!! Form::open(array('action' => array('\App\Http\Controllers\HRIS\Tools\ExceptionalHDController@store', 'method' => 'Post'), 'id'=>'add_form')) !!}
                                    <div class="card-body">
                                        <table class="table table-bordered" style="margin-bottom: -5px;">
                                            <tbody>
                                                <tr>
                                                    <td style="width: 80%;">
                                                        <div class="row">
                                                            <div class="col-lg-6" style="margin-bottom: 5px;">
                                                                <div class="control-group">
                                                                    <label for="EmployeeID">Employee ID</label>
                                                                    <div class="controls">
                                                                        {{-- {!! Form::number('EmployeeID', null, array('required', 'class'=>'form-control', 'id' => 'EmployeeID', 'min' => '100', 'max' => '999999', 'placeholder'=>'Employee ID', 'value'=>Input::old('EmployeeID'))) !!} --}}
                                                                        {!! Form::select('EmployeeID', $hdexps, null, ['class' => 'form-control select2bs4', 'id' => 'EmployeeID']) !!}
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="form-group {!! $errors->has('Name') ? 'has-error' : '' !!}">
                                                                    <label for="Name">Name</label>
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
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td style="width: 20%; text-align: center; vertical-align: middle;">
                                                        <button type="button" id="cardno" class="btn btn-success" name="carddisplay">Display</button>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="width: 80%;">
                                                        <div class="row">
                                                            <div class="col-lg-6" style="margin-bottom: 5px;">
                                                                <div class="control-group">
                                                                    <label for="StartDate">Start Date</label>
                                                                    <div class="controls">
                                                                        {!! Form::text('StartDate', $inputDate, array('required', 'class'=>'form-control StartDate', 'id' => 'StartDate', 'maxlength' => '10', 'placeholder'=>'YYYY-MM-DD', 'value'=>Input::old('StartDate'))) !!}
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6" style="margin-bottom: 5px;">
                                                                <div class="control-group">
                                                                    <label for="EndDate">End Date</label>
                                                                    <div class="controls">
                                                                        {!! Form::text('EndDate', $enddate, array('required', 'class'=>'form-control EndDate', 'id' => 'EndDate', 'maxlength' => '10', 'placeholder'=>'YYYY-MM-DD', 'value'=>Input::old('EndDate'))) !!}
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td style="width: 20%; text-align: center; vertical-align: middle;">
                                                        @if($create)
                                                            <button type="submit" id="changebtn" class="btn btn-warning" name="changeshift">Re-Create</button>
                                                        @endif
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    {!! Form::close() !!}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-1">
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-1">
                    </div>
                    <div class="col-lg-10">
                        <div class="card">
                            <div class="card-header with-border">Exceptional Holiday List</div>
                            <div class="card-body">
                                <table class="table table-striped" style="margin-bottom: -5px;">
                                    <thead>
                                        <tr>
                                            <th style="width: 30%;">Employee ID</th>
                                            <th style="width: 40%;">Name</th>
                                            <th style="width: 20%;">Weekly Holiday (YYYY-MM-DD)</th>
                                            <th style="width: 10%;">Action</th>
                                        </tr>
                                    </thead>
                                </table>
                                <div style="min-height: 400px; max-height: 400px; overflow: auto; margin-bottom: 5px;">
                                    <table class="table table-striped table-hover" id="shiftinlist">
                                        <tbody>
                                            <tr class="tabledata">
                                            </tr>        
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-1">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        $('#EmployeeID').on("input", function(event) {
            event.preventDefault();
            var empID = $("#EmployeeID").val();
            if(empID.length >= 4){
                $.ajax({
                    type: "GET",
                    url: "{{ url('hris/database/getemployeeinfo') }}",
                    data: {
                        emp_id: empID,
                        st_date: '00-00-0000',
                    },
                    success: function(data) {
                        if (data) {
                            $("#Name").val(data.Name);
                        } else {
                            $("#Name").val('');
                        }
                    }
                });
            } else {
                $("#Name").val('');
            }
        });
        $(document).on("click", "#cardno", function (event) {
            event.preventDefault();
            var empID = $("#EmployeeID").val();
            var start_date = $("#StartDate").val();
            var end_date = $("#EndDate").val();
            if(empID || start_date || end_date){
                $.ajax({
                    type: "GET",
                    url: "{{url('hris/tools/getexceptionalhd')}}",
                    data: {
                        emp_id: empID,
                        start_date: start_date,
                        end_date: end_date,
                    },
                    success:function(data){
                        //console.log(data);
                        if(data){
                            $(".tabledata").empty();
                            $.each(data, function(key,value){
                                $('#shiftinlist').append("<tr class='tabledata' id='item" + value.id + "'><td style='width:30%'>" + lpad(value.EmployeeID, 6) + "</td><td style='width:40%'>" + value.Name + "</td><td onblur='updateData(" + value.id + ")' id='WeeklyHolidayDate" + value.id + "' contenteditable='true' class='single-line' onkeypress='return(this.innerText.length <= 10)' style='width:20%'>" + value.WeeklyHolidayDate + "</td><td width='10%;'><button class='btn btn-danger btn-xs deletebtn' id='btn' data-id='" + value.id + "'><span class='glyphicon glyphicon-remove'></span> Delete</button></td></tr>");
                            });
                        }else{
                           $(".tabledata").empty();
                        }
                    }
                });
            }else{
                $(".tabledata").empty();
            }
        });

        $("#add_form").on("submit", function (event) {
            event.preventDefault();
            $('#changebtn').attr('disabled', true);
            $.ajax({
                type: 'POST',
                url: "{{url('hris/tools/exceptionalhd/')}}",
                data: {
                    '_token': $('input[name=_token]').val(),
                    'EmployeeID': $('#EmployeeID').val(),
                    'StartDate': $("#StartDate").val(),
                    'EndDate': $("#EndDate").val(),
                    'form_id':2,
                },
                success: function(data) {
                    if (data.errors) {
                        toastr.error(data.errors, 'Error Alert', {timeOut: 5000});
                    } else {
                        toastr.success(data.success, 'Success Alert', {timeOut: 5000});
                    }
                    $('#changebtn').attr('disabled', false);
                },
            });
        });
        $("#createexpholiday").on("submit", function (event) {
            event.preventDefault();
            $.ajax({
                type: 'POST',
                url: "{{ url('hris/tools/exceptionalhd/') }}",
                data: {
                    '_token': $('input[name=_token]').val(),
                    'EmployeeID': $('#employee_id').val(),
                    'date': $("#date").val(),
                    'forCreateExpHoliday': 1
                },
                success: function(data) {                  
                    if (data.errors) {
                        toastr.error(data.errors, 'Error Alert', { timeOut: 5000 });
                    } else {
                        toastr.success(data.success, 'Success Alert', { timeOut: 5000 });
                        $(".tabledata").empty();
                        // Iterate through the data.data array
                        $.each(data.data, function (key, value) {
                            $('#shiftinlist').append("<tr class='tabledata' id='item" + value.id + "'><td style='width:30%'>" + lpad(value.EmployeeID, 6) + "</td><td style='width:40%'>" + value.Name + "</td><td onblur='updateData(" + value.id + ")' id='WeeklyHolidayDate" + value.id + "' contenteditable='true' class='single-line' onkeypress='return(this.innerText.length <= 10)' style='width:20%'>" + value.WeeklyHolidayDate + "</td><td width='10%;'><button class='btn btn-danger btn-xs deletebtn' id='btn' data-id='" + value.id + "'><span class='glyphicon glyphicon-remove'></span> Delete</button></td></tr>");
                        });
                    }
                    $('#changebtn').attr('disabled', false);
                },
            });
        });
        function updateData(id){          
            var WeeklyHolidayDate = strip_html_tags($('#WeeklyHolidayDate'+id).html());
            //console.log(WeeklyHolidayDate);
            $.ajax({
                type: 'PUT',
                url: "{!! url('hris/tools/exceptionalhd/" + id + "') !!}",
                data: {
                    '_token': $('input[name=_token]').val(),
                    'WeeklyHolidayDate': WeeklyHolidayDate,
                },
                success: function(data) {
                    if (data.errors) {
                        toastr.error(data.errors, 'Error Alert', {timeOut: 5000});
                    } else {
                        toastr.success(data.success, 'Success Alert', {timeOut: 5000});
                    }
                }
            });
        }

        $(document).on('click', '.deletebtn', function(event) {
            event.preventDefault();
            var id = $(this).data('id');
            $.ajax({
                type: 'DELETE',
                url: "{!! url('hris/tools/exceptionalhd/" + id + "') !!}",
                data: {
                    '_token': $('input[name=_token]').val(),
                },
                success: function(data) {
                    if (data.errors) {
                        toastr.error(data.errors, 'Error Alert', {timeOut: 5000});
                    } else {
                        toastr.success(data.success, 'Success Alert', {timeOut: 5000});
                        $('#item'+ id).remove();
                    }
                }
            });
        });
    </script>

@stop
