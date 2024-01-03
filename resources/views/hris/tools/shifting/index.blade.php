@extends('layout.app')
@section('title', 'HRIS | Roaster')
@section('content')
    <?php
        $inputDate = \Carbon\Carbon::now()->startOfMonth()->format('Y-m-d');
        $enddate = \Carbon\Carbon::now()->endOfMonth()->format('Y-m-d');
    ?>
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0" style="text-align: right;">Roaster</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{!! url('hris/dashboard') !!}">HRIS</a></li>
                        <li class="breadcrumb-item"><a href="javascript::void(0)">Tools</a></li>
                        <li class="breadcrumb-item"><a href="{!! url('hris/tools/shifting') !!}">Roaster</a></li>
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
                                <div class="card" style="min-height: 214px;">
                                    <div class="card-header with-border">Roaster Generate For Year</div>
                                    <div class="card-body">
                                        {{-- @if(Sentinel::inRole('superadmin')) --}}
                                        {!! Form::open(array('action' => array('\App\Http\Controllers\HRIS\Tools\ShiftingController@store', 'method' => 'Post', 'form_id' => '1'), 'id'=>'gen_form')) !!}
                                        <table class="table table-bordered">
                                            <tbody>                                            
                                                <tr>
                                                    <th style="width: 18%;">Property</th>
                                                    <td style="width: 2%">:</td>
                                                    <td style="width: 50%">
                                                        <div class="control-group {!! $errors->has('company_id') ? 'has-error' : '' !!}">
                                                            <div class="controls">
                                                                <!-- Display a select dropdown for the "Company" field -->
                                                                {!! Form::select('company_id', $complists, getHostInfo()['id'], ['class' => 'form-control', 'id' => 'company_id']) !!}
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td rowspan="2" style="width: 30%; text-align: center; vertical-align: middle;">
                                                        @if($create)
                                                            {!! Form::submit('Generate', array('class' => 'btn btn-success', 'id' => 'shiftgen')) !!}
                                                        @endif
                                                    </td>
                                                </tr>
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
                                                </tr>
                                            </tbody>
                                        </table>
                                        {!! Form::close() !!}
                                        {{-- @endif --}}
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-7">
                                <div class="card">
                                    <div class="card-header with-border">Display Roaster For Date Range</div>
                                    {!! Form::open(array('action' => array('\App\Http\Controllers\HRIS\Tools\ShiftingController@store', 'method' => 'Post'), 'id'=>'add_form')) !!}
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
                                                                        {!! Form::number('EmployeeID', null, array('required', 'class'=>'form-control', 'id' => 'EmployeeID', 'min' => '100', 'max' => '999999', 'placeholder'=>'Employee ID', 'value'=>Input::old('EmployeeID'))) !!}
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6" style="margin-bottom: 5px;">
                                                                <div class="control-group">
                                                                    <label for="Shift">Shift</label>
                                                                    <div class="controls">
                                                                        <select name="Shift" id="Shift" class="form-control" required>
                                                                            <option value="" selected disabled>Select one</option>
                                                                            @foreach ($shiftlist as $item)
                                                                            <option value="{{ $item->Shift }}">{{ $item->Shift_Name . ' (' . $item->ShiftStartHour . '-' . $item->ShiftEndHour . ')' }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td rowspan="2" style="width: 20%; text-align: center; vertical-align: middle;">
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
                                                    {{-- <td style="width: 20%; text-align: center; vertical-align: middle;">
                                                        @if($create)
                                                            <button type="submit" id="changebtn" class="btn btn-warning" name="changeshift">Change</button>
                                                        @endif
                                                    </td> --}}
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
                            <div class="card-header with-border">Roaster List</div>
                            <div class="card-body">
                                <table class="table table-striped" style="margin-bottom: -5px;">
                                    <thead>
                                        <tr>
                                            <th style="width: 10%;">Employee ID</th>
                                            <th style="width: 25%;">Name</th>
                                            <th style="width: 15%;">Joining Date</th>
                                            <th style="width: 15%;">Date</th>
                                            <th style="width: 12%;">Shift</th>
                                            <th style="width: 12%;">HD Type</th>
                                            <th style="width: 18%;">Property</th>
                                        </tr>
                                    </thead>
                                </table>
                                <div style="min-height: 390px; max-height: 390px; overflow: auto; margin-bottom: 5px;">
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
        $(document).on("click", "#cardno", function (event) {
            event.preventDefault();
            var empID = $("#EmployeeID").val();
            var start_date = $("#StartDate").val();
            var end_date = $("#EndDate").val();
            var Shift = $("#Shift").val();
            if(empID || start_date || end_date){
                $.ajax({
                    type: "GET",
                    url: "{{url('hris/tools/getshiftingtwo')}}",
                    data: {
                        emp_id: empID,
                        start_date: start_date,
                        end_date: end_date,
                        Shift: Shift,
                    },
                    success:function(data){
                        console.log(data);
                        // return;
                        if(data[0]){
                            $(".tabledata").empty();
                                $.each(data[0], function (key, value) {

                                    var shiftDropdownHtml = "<select id='shift" + value.id + "' style='width:100%;' onchange='updateData(" + value.id + ", this.value)'";                               
                                    shiftDropdownHtml += "<option value=''>Select One</option>";                                 
                                    $.each(data[3], function(index, shift) {
                                        var selected = (shift.Shift === value.Shift) ? 'selected' : ''; // Check if it's the selected option
                                        
                                        shiftDropdownHtml += "<option value='" + shift.Shift + "' " + selected + ">";
                                        shiftDropdownHtml += shift.Shift_Name + " (" + shift.ShiftStartHour + " - " + shift.ShiftEndHour+ ")";
                                        shiftDropdownHtml += "</option>";
                                    });

                                    shiftDropdownHtml += "</select>";                               

                                    var dropdownHtml = "<select id='company" + value.id + "' style='width:100%;' onchange='updateCompany(" + value.id + ", this.value)'";                               
                                    dropdownHtml += "<option value=''>Select One</option>";                                 
                                    $.each(data[1], function (index, company) {
                                        var selected = (company.id === value.company_id) ? 'selected' : ''; // Check if it's the selected option
                                        dropdownHtml += "<option value='" + company.id + "' " + selected + ">" + company.Name + "</option>";
                                    });
                                    dropdownHtml += "</select>";

                                    var hddropdownHtml = "<select id='leaveType" + value.id + "' style='width:100%;' onchange='updateLVType(" + value.id + ", this.value)'";                               
                                    hddropdownHtml += "<option value=''>Select One</option>";                                 
                                    $.each(data[2], function (index, item) {
                                        var selected = (item === value.Holiday) ? 'selected' : ''; // Check if it's the selected option
                                        hddropdownHtml += "<option value='" + item+ "' " + selected + ">" + item + "</option>";
                                    });
                                    hddropdownHtml += "</select>";
                                    
                                    $('#shiftinlist').append("<tr class='tabledata' id='item" + value.id + "'><td style='width:10%'>" + lpad(value.EmployeeID, 6) + "</td><td style='width:25%'>" + value.Name + "</td><td style='width:15%'>" + value.JoiningDate + "</td><td style='width:15%'>" + value.Date + "</td></td><td style='width:15%'>" + shiftDropdownHtml + "</td><td>" + hddropdownHtml + "</td><td style='width:15%'>" + dropdownHtml + "</td></tr>");
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
                url: "{{url('hris/tools/shifting/')}}",
                data: {
                    '_token': $('input[name=_token]').val(),
                    'EmployeeID': $('#EmployeeID').val(),
                    'StartDate': $("#StartDate").val(),
                    'EndDate': $("#EndDate").val(),
                    'Shift': $("#Shift").val(),
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

        function updateData(id, shift){          
            var Shift = shift;            
            $.ajax({
                type: 'PUT',
                url: "{!! url('hris/tools/shifting/" + id + "') !!}",
                data: {
                    '_token': $('input[name=_token]').val(),
                    'Shift': shift,            
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


        function updateCompany(id, value){
            $.ajax({
                type: 'PUT',
                url: "{!! url('hris/tools/shifting/" + id + "') !!}",
                data: {
                    '_token': $('input[name=_token]').val(),
                    'company_id': value,
                    'recordId': id,
                    'type':'companyUpdate'
                },
                success: function(data) {
                    //console.log(data);
                    if (data.errors) {
                        toastr.error(data.errors, 'Error Alert', {timeOut: 5000});
                    } else {
                        toastr.success('Successfully updated Shift!', 'Success Alert', {timeOut: 5000});
                    }
                }
            });
        }

        function updateLVType(id, value){
            $.ajax({
                type: 'PUT',
                url: "{!! url('hris/tools/shifting/" + id + "') !!}",
                data: {
                    '_token': $('input[name=_token]').val(),
                    'leaveType': value,
                    'recordId': id,
                    'type':'leaveTypeUpdate'
                },
                success: function(data) {
                    // console.log(data);
                    if (data.errors) {
                        toastr.error(data.errors, 'Error Alert', {timeOut: 5000});
                    } else {
                        toastr.success('Successfully updated Shift!', 'Success Alert', {timeOut: 5000});
                    }
                }
            });
        }
    </script>

@stop
