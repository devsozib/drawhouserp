@extends('layout.app')
@section('title', 'HRIS | Penalty')
@section('content')
    <?php  
        $issuedate = \Carbon\Carbon::now()->format('Y-m-d');
        $startdate = \Carbon\Carbon::now()->startOfMonth()->format('Y-m-d');
        $refunddate = \Carbon\Carbon::now()->endOfMonth()->format('Y-m-d'); 
        if($issuedate == $startdate){
            $issuedate = \Carbon\Carbon::now()->subDays(1)->endOfMonth()->format('Y-m-d');
            $refunddate = \Carbon\Carbon::now()->subDays(1)->endOfMonth()->format('Y-m-d');  
        }
        $issuedate = \Carbon\Carbon::now()->subDays(5)->endOfMonth()->format('Y-m-d');
        $refunddate = \Carbon\Carbon::now()->subDays(5)->endOfMonth()->format('Y-m-d'); 
    ?>
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0" style="text-align: right;">Penalty</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{!! url('hris/dashboard') !!}">HRIS</a></li>
                        <li class="breadcrumb-item"><a href="javascript::void(0)">Database</a></li>
                        <li class="breadcrumb-item"><a href="{!! url('hris/database/punishment') !!}">Penalty</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Index</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="row">
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header with-border" style="font-size: 16px;">Input Parameters For Penalty</div>
                    {!! Form::open(array('action' => array('\App\Http\Controllers\HRIS\Database\PunishmentController@store', 'method' => 'Post'), 'id'=>'add_form')) !!}
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-7">
                                <table class="table" style="margin-bottom: 10px;">
                                    <tbody>
                                        <tr>
                                            <th style="width: 43%; border: none;">
                                                <input type="checkbox" name="AllDepartments" id="AllDepartments"> All Departments?
                                            </th>
                                            <td style="width: 2%; border: none;">:</td>
                                            <td style="width: 55%; border: none;">
                                                <div class="control-group {!! $errors->has('DepartmentID') ? 'has-error' : '' !!}">
                                                    <div class="controls">
                                                        {!! Form::select('DepartmentID', $deptlist, null, array('class'=>'form-control select2bs4', 'id' => 'DepartmentID', 'placeholder'=>'Select One', 'value'=>Input::old('DepartmentID'))) !!}
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-lg-5">
                                <table class="table" style="margin-bottom: 10px;">
                                    <tbody>
                                        <tr>
                                            <th style="width: 43%; border: none;">
                                                Deduction Type
                                            </th>
                                            <td style="width: 2%; border: none;">:</td>
                                            <td style="width: 55%; border: none;">
                                                <div class="control-group {!! $errors->has('Deduct_Type') ? 'has-error' : '' !!}">
                                                    <div class="controls">
                                                        {!! Form::select('Deduct_Type', $deduct_type, null, array('class'=>'form-control', 'id' => 'Deduct_Type', 'value'=>Input::old('Deduct_Type'))) !!}
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-9">
                                <div style="max-height: 400px; min-height: 400px; overflow: auto; margin-bottom: 10px;">
                                    <table class="table table-bordered table-hover fixed_header" id="empdata">
                                        <thead>
                                            <tr>
                                                <th style="width: 30%;">ID</th>
                                                <th style="width: 50%;">Name</th>
                                                <th style="width: 20%;">Designation</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr class="tabledata">
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <?php
                                    $today = \Carbon\Carbon::parse($hroptions->Year.'-'.$hroptions->Month.'-01'); 
                                    $dates = []; 
                                    for($i=1; $i < $today->daysInMonth + 1; ++$i) {
                                        $dates[] = \Carbon\Carbon::createFromDate($today->year, $today->month, $i)->format('d-m-Y');
                                    }
                                ?>
                                
                                <div style="max-height: 410px; min-height: 410px; overflow: auto; margin-bottom: 0px;">
                                    <table class="table table-bordered fixed_header">
                                        <thead>
                                            <tr>
                                                <th>Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($dates as $date)
                                            <tr>
                                                <td>
                                                    <input type="checkbox" name="PMDate[]" id="PMDate" class="PMDate" value="{!! date('Y-m-d', strtotime($date)) !!}"> {!! $date !!}
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>                                    
                            </div>
                        </div>
                    </div>  
                    <div class="card-footer text-right" style="margin-top: -5px;">
                        @if($create)
                            <button type="submit" id="add" class="btn btn-success">Add Date</button>
                        @endif
                    </div> 
                    {!! Form::close() !!}                
                </div>
            </div>
          
            <div class="col-lg-6" style="padding-left: 5px;">
                {!! Form::open(array('action' => array('\App\Http\Controllers\HRIS\Database\PunishmentController@store', 'method' => 'Post'))) !!}
                <div class="card">
                    <div class="card-header with-border" style="font-size: 16px;">Input Parameters For New Penalty</div>
                    <div class="card-body">
                        <div style="max-height: 448px; min-height: 448px; overflow: auto; margin-bottom: 10px;">
                            <table class="table table-bordered table-hover fixed_header" id="empdata2">
                                <thead>
                                    <tr>
                                        <th style="width: 15%;">ID</th>
                                        <th style="width: 30%;">Name</th>
                                        <th style="width: 25%;">Designation</th>
                                        <th style="width: 15%;">Date</th>
                                        <th style="width: 15%;">Deduct Type</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="tabledata2">
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer text-right" style="margin-top: -20px;">
                        &nbsp;&nbsp;<button type="button" id="check_all2" class="btn">Check All</button> &nbsp;&nbsp;<button type="button" id="uncheck_all2" class="btn">Uncheck All</button>&nbsp;&nbsp;
                        @if($create)
                            <button type="button" id="delete_all2" class="btn btn-danger pull-right">Delete</button>
                        @endif
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>

    <script type="text/javascript">
        $("#AllDepartments,#DepartmentID").change(function () {
            $(".tabledata").empty();
            $(".tabledata2").empty();
        });
        
        var value = $('#AllDepartments').is(":checked") ? 'true' : 'false';
        if(value == 'true') {
            $('#DepartmentID').attr('disabled', true);
        } else {
            $('#DepartmentID').attr('disabled', false);
        }
        $("#AllDepartments").click(function() {
            var value = $('#AllDepartments').is(":checked") ? 'true' : 'false';
            if(value == 'true') {
                $('#DepartmentID').attr('disabled', true);
            } else {
                $('#DepartmentID').attr('disabled', false);
            }
        }); 
        
        $('#DepartmentID').on("select2:select", function (event) {
            var deptALL = $('#AllDepartments').is(":checked") ? 'true' : 'false';
            var deptID = $('#DepartmentID option:selected').val();
            $.ajax({
                type:"GET",
                url:"{{url('hris/database/getemployeepun')}}",
                data:{
                    dept_id: deptID,
                    dept_all: deptALL
                },
                success:function(data){               
                    if(data){
                        $(".tabledata").empty();
                        $.each(data, function(key,value){
                            $('#empdata').append("<tr class='tabledata'><td>" + '<input type="radio" name="EmployeeID" id="EmployeeID' + value.EmployeeID + '" class="EmployeeID" value="'+ value.EmployeeID +'"> ' + '<label style="font-weight: normal;" for="EmployeeID' + value.EmployeeID + '">' + lpad(value.EmployeeID, 6) + '</label>' + "</td><td>" + value.Name + "</td><td>" + value.Designation + "</td></tr>");
                        });
                    }else{
                        $(".tabledata").empty();
                    }
                }
            });
            
        });
        
        
        $("#AllDepartments").click(function() {
            var deptALL = $('#AllDepartments').is(":checked") ? 'true' : 'false';
            if(deptALL ==='true') {
                $.ajax({
                    type:"GET",
                    url:"{{url('hris/database/getemployeepun')}}",
                    data:{
                        dept_all: deptALL
                    },
                    success:function(data){               
                        if(data){
                            $(".tabledata").empty();
                            $.each(data, function(key,value){
                                $('#empdata').append("<tr class='tabledata'><td>" + '<input type="radio" name="EmployeeID" id="EmployeeID' + value.EmployeeID + '" class="EmployeeID" value="'+ value.EmployeeID +'"> ' + '<label style="font-weight: normal;" for="EmployeeID' + value.EmployeeID + '">' + lpad(value.EmployeeID, 6) + '</label>' + "</td><td>" + value.Name + "</td><td>" + value.Designation + "</td></tr>");
                            });
                        }else{
                            $(".tabledata").empty();
                        }
                    }
                });
            } else {
                var deptID = $('#DepartmentID option:selected').val();
                $.ajax({
                    type:"GET",
                    url:"{{url('hris/database/getemployeepun')}}",
                    data:{
                        dept_id: deptID,
                        dept_all: deptALL
                    },
                    success:function(data){               
                        if(data){
                            $(".tabledata").empty();
                            $.each(data, function(key,value){
                                $('#empdata').append("<tr class='tabledata'><td>" + '<input type="radio" name="EmployeeID" id="EmployeeID' + value.EmployeeID + '" class="EmployeeID" value="'+ value.EmployeeID +'"> ' + '<label style="font-weight: normal;" for="EmployeeID' + value.EmployeeID + '">' + lpad(value.EmployeeID, 6) + '</label>' + "</td><td>" + value.Name + "</td><td>" + value.Designation + "</td></tr>");
                            });
                        }else{
                            $(".tabledata").empty();
                        }
                    }
                });
            }
        });

        $(document).on('click', '.EmployeeID', function() {
            $.ajax({
                type:"GET",
                url:"{{url('hris/database/getemployeepundate')}}",
                data:{
                    'EmployeeID': $(this).val(),
                },
                success:function(data){               
                    if(data){
                        $(".tabledata2").empty();
                        var dtype = [
                            { id: 1, name: 'Both' },
                            { id: 2, name: 'Salary' },
                            { id: 3, name: 'Service Charge' }
                        ];
                        $.each(data, function(key,value){
                            var dropdownHtml = "<select id='deduct_type" + value.id + "' style='width:100%;' onchange='updateDeductType(" + value.id + ", this.value)'>";
                            // Add a default "Select One" option
                            dropdownHtml += "<option value=''>Select One</option>";
                            // Populate the dropdown options dynamically from the JSON data
                            dtype.forEach(function(item) {
                                var selected = (item.id === value.Deduct_Type) ? 'selected' : ''; 
                                dropdownHtml += "<option value='" + item.id + "' " + selected + ">" + item.name + "</option>";
                            });
                            dropdownHtml += "</select>";

                            $('#empdata2').append("<tr class='tabledata2'><td>" + '<input type="checkbox" name="EmployeeID2[]" id="EmployeeID2" class="EmployeeID2" value="'+ value.id +'"> '+ lpad(value.EmployeeID, 6) + "</td><td>" + value.Name + "</td><td>" + value.Designation + "</td><td>" + value.PMDate + "</td><td>" + dropdownHtml + "</td></tr>");
                        });
                    }else{
                        $(".tabledata2").empty();
                    }
                }
            });
        });

        $("#add_form").on("submit", function (event) {
            event.preventDefault();
            var dates = new Array();
            $(".PMDate:checkbox").each(function () {
                var ischecked = $(this).is(".PMDate:checked");
                if (ischecked) {
                    dates.push($(this).val());
                }
            });
            var selected = $("input[name='EmployeeID']:checked").val();
            if(dates.length <= 0){   
                toastr.error('Please select atleast one record to add!', 'Error Alert', {timeOut: 5000});
            }else{
                var deptALL = $('#AllDepartments').is(":checked") ? 'true' : 'false';
                var deptID = $('#DepartmentID option:selected').val();
                var Deduct_Type = $('#Deduct_Type option:selected').val();
                $.ajax({
                    type: 'POST',
                    url: "{{url('hris/database/punishment')}}",
                    data: {
                        '_token': $('input[name=_token]').val(),
                        'EmployeeID': selected,
                        'dept_id': deptID,
                        'dept_all': deptALL,
                        'PMDate': dates,
                        'Deduct_Type': Deduct_Type,
                    },
                    success: function(data) {
                        if (data.errors) {
                            toastr.error(data.errors, 'Error Alert', {timeOut: 5000});
                        } else {
                            toastr.success(data.success, 'Success Alert', {timeOut: 5000});
                            $(".tabledata2").empty();
                            $(".PMDate").attr('checked', false);
                            var dtype = [
                                { id: 1, name: 'Both' },
                                { id: 2, name: 'Salary' },
                                { id: 3, name: 'Service Charge' }
                            ];
                            $.each(data.empl, function(key,value){
                                var dropdownHtml = "<select id='deduct_type" + value.id + "' style='width:100%;' onchange='updateDeductType(" + value.id + ", this.value)'>";
                                // Add a default "Select One" option
                                dropdownHtml += "<option value=''>Select One</option>";
                                // Populate the dropdown options dynamically from the JSON data
                                dtype.forEach(function(item) {
                                    var selected = (item.id === value.Deduct_Type) ? 'selected' : ''; 
                                    dropdownHtml += "<option value='" + item.id + "' " + selected + ">" + item.name + "</option>";
                                });
                                dropdownHtml += "</select>";
                                $('#empdata2').append("<tr class='tabledata2'><td>" + '<input type="checkbox" name="EmployeeID2[]" id="EmployeeID2" class="EmployeeID2" value="'+ value.id +'"> '+ lpad(value.EmployeeID, 6) + "</td><td>" + value.Name + "</td><td>" + value.Designation + "</td><td>" + value.PMDate + "</td><td>" + dropdownHtml + "</td></tr>");
                            });
                        }
                    },
                });
            }
        });

        $(document).on('click', '#delete_all2', function() {
            var selected = new Array();
            $(".EmployeeID2:checkbox").each(function () {
                var ischecked = $(this).is(".EmployeeID2:checked");
                if (ischecked) {
                    selected.push($(this).val());
                }
            });
            if(selected.length <=0){   
                toastr.error('Please select atleast one record to delete!', 'Error Alert', {timeOut: 5000});
            }else{
                $.ajax({
                    type: 'DELETE',
                    url: "{!! url('hris/database/punishment/" + selected + "') !!}",
                    data: {
                        '_token': $('input[name=_token]').val(),
                    },
                    success: function(data) {
                        toastr.success(data.success, 'Success Alert', {timeOut: 5000});
                        $(".EmployeeID2:checked").each(function() {  
                            $(this).parents("tr").remove();
                        });
                    }
                });
            }
        });

        $('#check_all2').click(function() {
            $('.EmployeeID2').prop('checked', true);
        });
        $('#uncheck_all2').click(function() {
            $('.EmployeeID2').prop('checked', false);
        });  
        

        function updateDeductType(id, value){
            $.ajax({
                type: 'PUT',
                url: "{!! url('hris/database/punishment/" + id + "') !!}",
                data: {
                    '_token': $('input[name=_token]').val(),
                    'deductId': value,
                    'recordId': id,
                    'type':'companyDeduct'
                },
                success: function(data) {
                    //console.log(data);
                    if (data.errors) {
                        toastr.error(data.errors, 'Error Alert', {timeOut: 5000});
                    } else {
                        toastr.success('Successfully updated deduct type!', 'Success Alert', {timeOut: 5000});
                    }
                }
            });
        }
    </script>
@stop
