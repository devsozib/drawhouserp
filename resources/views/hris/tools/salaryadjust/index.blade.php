@extends('layout.app')
@section('title', 'HRIS | Salary Adjustment')
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
                        <li class="breadcrumb-item"><a href="javascript::void(0)">Tools</a></li>
                        <li class="breadcrumb-item"><a href="{!! url('hris/tools/salaryadjust') !!}">Salary Adjustment</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Index</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="row">
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header with-border" style="font-size: 22px; text-align: center;">Salary Adjustment</div>
                    {!! Form::open(array('action' => array('\App\Http\Controllers\HRIS\Tools\SalaryAdjustController@store', 'method' => 'Post'), 'id'=>'add_form')) !!}
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <table class="table" style="margin-top: -15px;margin-bottom: 0px;">
                                    <tbody>
                                        <tr>
                                            <th style="width: 38%">Property</th>
                                            <td style="width: 2%">:</td>
                                            <td style="width: 60%">
                                                <div class="control-group {!! $errors->has('company_id') ? 'has-error' : '' !!}">
                                                    <div class="controls">
                                                        {!! Form::select('company_id', $complists, getHostInfo()['id'], ['class' => 'form-control', 'id' => 'company_id']) !!}
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <table class="table" style="margin-bottom: 10px;">
                                    <tbody>
                                        <tr>
                                            <th style="width: 38%; border: none;">
                                                <input type="checkbox" name="AllDepartments" id="AllDepartments"> All Departments?
                                            </th>
                                            <td style="width: 2%; border: none;">:</td>
                                            <td style="width: 60%; border: none;">
                                                <div class="control-group">
                                                    <div class="controls">
                                                        {!! Form::select('DepartmentID', $deptlist, null, array('class'=>'form-control select2bs4', 'id' => 'DepartmentID', 'placeholder'=>'Select One', 'value'=>Input::old('DepartmentID'))) !!}
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <table class="table" style="margin-bottom: 10px;">
                                    <tbody>
                                        <tr>
                                            <th style="width: 20%; border: none;">Year</th>
                                            <td style="width: 30%; border: none;">
                                                {!! Form::text('Year', $hroptions->Year, array('readonly', 'class'=>'form-control', 'id' => 'Year')) !!}
                                            </td>
                                            <th style="width: 20%; border: none;">Month</th>
                                            <td style="width: 30%; border: none;">
                                                {!! Form::selectMonth('Month', $hroptions->Month, array('class'=>'form-control', 'id' => 'Month')) !!}
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div style="max-height: 313px; min-height: 313px; overflow: auto; margin-bottom: 10px;">
                                    <table class="table table-bordered table-hover fixed_header" id="empdata">
                                        <thead>
                                            <tr>
                                                <th style="width: 30%;">ID</th>
                                                <th style="width: 70%;">Name</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr class="tabledata">
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer" style="margin-top: -10px;">
                        &nbsp;&nbsp;<button type="button" id="check_all" class="btn">Check All</button> &nbsp;&nbsp;<button type="button" id="uncheck_all" class="btn">Uncheck All</button>&nbsp;&nbsp;
                        @if($create)
                            <button type="submit" id="addbtn" class="btn btn-success pull-right">Add</button>
                        @endif
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header with-border" style="font-size: 22px; text-align: center;">Salary Adjustment Details</div>
                    <div class="card-body">
                        <div style="max-height: 430px; min-height: 430px; overflow: auto; margin-bottom: 10px;">
                            <table class="table table-bordered table-hover fixed_header" id="empdata2">
                                <thead>
                                    <tr>
                                        <th style="width: 10%;">ID</th>
                                        <th style="width: 20%;">Name</th>
                                        <th style="width: 20%;">Department</th>
                                        <th style="width: 10%;">Period</th>
                                        <th style="width: 10%; text-align: center;">Adjustment</th>
                                        <th style="width: 10%; text-align: center;">Deduction</th>
                                        <th style="width: 20%;">Remarks</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="tabledata2">
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer" style="margin-top: -10px;">
                        &nbsp;&nbsp;<button type="button" id="check_all2" class="btn">Check All</button> &nbsp;&nbsp;<button type="button" id="uncheck_all2" class="btn">Uncheck All</button>&nbsp;&nbsp;
                        @if($delete)
                            <button type="button" id="delete_all2" class="btn btn-danger pull-right">Delete</button>
                        @endif
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>

        <script type="text/javascript">
            $('#AllDepartments,#DepartmentID').change(function () {
                $(".tabledata").empty();
                $(".tabledata2").empty();
            });
            var value = $('#AllDepartments').is(":checked") ? 'true' : 'false';
            if(value === 'true') {
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

            function getEmployee () {
                var deptALL = $('#AllDepartments').is(":checked") ? 'true' : 'false';
                if(deptALL == 'true') {
                    $.ajax({
                        type:"GET",
                        url:"{{url('hris/tools/getadjustemp')}}",
                        data:{
                            'dept_all': deptALL,
                            'company_id': $('#company_id option:selected').val(),
                        },
                       success:function(data){               
                            if(data){
                                $(".tabledata").empty();
                                $.each(data, function(key,value){
                                    $('#empdata').append("<tr class='tabledata'><td>" + '<input type="checkbox" name="EmployeeID[]" id="EmployeeID" class="EmployeeID" value="'+ value.EmployeeID +'"> '+ lpad(value.EmployeeID, 6) + "</td><td>" + value.Name + "</td></tr>");
                                });
                            }else{
                                $(".tabledata").empty();
                            }
                        }
                    });
                    $.ajax({
                        type:"GET",
                        url:"{{url('hris/tools/getadjustempsa')}}",
                        data:{
                            'dept_all': deptALL,
                            'Year': $("#Year").val(),
                            'Month': $("#Month").val(),
                            'company_id': $('#company_id option:selected').val(),
                        },
                        success:function(data){               
                            if(data){
                                $(".tabledata2").empty();
                                let period = '';
                                $.each(data, function(key,value){
                                    period = month[value.Month] +', '+ value.Year;
                                    $('#empdata2').append("<tr class='tabledata2' id='item" + value.id + "'><td>" + '<input type="checkbox" name="EmployeeID[]" id="EmployeeID2" class="EmployeeID2" value="'+ value.id +'"> '+ lpad(value.EmployeeID, 6) + "</td><td>" + value.Name + "</td><td>" + value.Department + "</td><td>" + period + "</td><td id='Adjustment" + value.id + "' contenteditable='true' class='single-line' onkeypress='return(this.innerText.length <= 10)' style='text-align:center;'>" + value.Adjustment + "</td><td id='Deduction" + value.id + "' contenteditable='true' class='single-line' onkeypress='return(this.innerText.length <= 10)' style='text-align:center;'>" + value.Deduction + "</td><td onblur='updateData(" + value.id + ")' id='Remarks" + value.id + "' contenteditable='true' class='single-line' onkeypress='return(this.innerText.length <= 50)'>" + value.Remarks + "</td></tr>");
                                });
                            }else{
                                $(".tabledata2").empty();
                            }
                        }
                    });                
                } else {
                    var deptALL = $('#AllDepartments').is(":checked") ? 'true' : 'false';
                    var deptID = $('#DepartmentID option:selected').val();
                    $.ajax({
                        type:"GET",
                        url:"{{url('hris/tools/getadjustemp')}}",
                        data:{
                            'dept_id': deptID,
                            'dept_all': deptALL,
                            'company_id': $('#company_id option:selected').val(),
                        },
                       success:function(data){               
                            if(data){
                                $(".tabledata").empty();
                                $.each(data, function(key,value){
                                    $('#empdata').append("<tr class='tabledata'><td>" + '<input type="checkbox" name="EmployeeID[]" id="EmployeeID" class="EmployeeID" value="'+ value.EmployeeID +'"> '+ lpad(value.EmployeeID, 6) + "</td><td>" + value.Name + "</td></tr>");
                                });
                            }else{
                                $(".tabledata").empty();
                            }
                        }
                    });
                    $.ajax({
                        type:"GET",
                        url:"{{url('hris/tools/getadjustempsa')}}",
                        data:{
                            'dept_id': deptID,
                            'dept_all': deptALL,
                            'Year': $("#Year").val(),
                            'Month': $("#Month").val(),
                            'company_id': $('#company_id option:selected').val(),
                        },
                        success:function(data){               
                            if(data){
                                $(".tabledata2").empty();
                                let period = '';
                                $.each(data, function(key,value){
                                    period = month[value.Month] +', '+ value.Year;
                                    $('#empdata2').append("<tr class='tabledata2' id='item" + value.id + "'><td>" + '<input type="checkbox" name="EmployeeID[]" id="EmployeeID2" class="EmployeeID2" value="'+ value.id +'"> '+ lpad(value.EmployeeID, 6) + "</td><td>" + value.Name + "</td><td>" + value.Department + "</td><td>" + period + "</td><td id='Adjustment" + value.id + "' contenteditable='true' class='single-line' onkeypress='return(this.innerText.length <= 10)' style='text-align:center;'>" + value.Adjustment + "</td><td id='Deduction" + value.id + "' contenteditable='true' class='single-line' onkeypress='return(this.innerText.length <= 10)' style='text-align:center;'>" + value.Deduction + "</td><td onblur='updateData(" + value.id + ")' id='Remarks" + value.id + "' contenteditable='true' class='single-line' onkeypress='return(this.innerText.length <= 50)'>" + value.Remarks + "</td></tr>");
                                });
                            }else{
                                $(".tabledata2").empty();
                            }
                        }
                    });  
                }
            }
            getEmployee();
            
            $('#DepartmentID').on("select2:select", function (event) {
                getEmployee();            
            });
            
            $("#AllDepartments,#company_id").click(function() {
                getEmployee();
            });
            
            $("#add_form").on("submit", function (event) {
                event.preventDefault();
                var selected = new Array();
                $(".EmployeeID:checkbox").each(function () {
                    var ischecked = $(this).is(".EmployeeID:checked");
                    if (ischecked) {
                        selected.push($(this).val());
                    }
                });
                if(selected.length <= 0){   
                    toastr.error('Please select atleast one record to add!', 'Error Alert', {timeOut: 5000});
                }else{
                    var deptALL = $('#AllDepartments').is(":checked") ? 'true' : 'false';
                    var deptID = $('#DepartmentID option:selected').val();
                    $.ajax({
                        type: 'POST',
                        url: "{{url('hris/tools/salaryadjust')}}",
                        data: {
                            '_token': $('input[name=_token]').val(),
                            'EmployeeID': selected,
                            'Year': $("#Year").val(),
                            'Month': $("#Month").val(),
                            'dept_id': deptID,
                            'dept_all': deptALL,
                            'company_id': $('#company_id option:selected').val(),
                        },
                        success: function(data) {
                            if (data.errors) {
                                toastr.error(data.errors, 'Error Alert', {timeOut: 5000});
                            } else {
                                toastr.success(data.success, 'Success Alert', {timeOut: 5000});
                                $(".tabledata2").empty();
                                let period = '';
                                $.each(data.empl, function(key,value){
                                    period = month[value.Month] +', '+ value.Year;
                                    $('#empdata2').append("<tr class='tabledata2' id='item" + value.id + "'><td>" + '<input type="checkbox" name="EmployeeID[]" id="EmployeeID2" class="EmployeeID2" value="'+ value.id +'"> '+ lpad(value.EmployeeID, 6) + "</td><td>" + value.Name + "</td><td>" + value.Department + "</td><td>" + period + "</td><td id='Adjustment" + value.id + "' contenteditable='true' class='single-line' onkeypress='return(this.innerText.length <= 10)' style='text-align:center;'>" + value.Adjustment + "</td><td id='Deduction" + value.id + "' contenteditable='true' class='single-line' onkeypress='return(this.innerText.length <= 10)' style='text-align:center;'>" + value.Deduction + "</td><td onblur='updateData(" + value.id + ")' id='Remarks" + value.id + "' contenteditable='true' class='single-line' onkeypress='return(this.innerText.length <= 50)'>" + value.Remarks + "</td></tr>");
                                });
                            }
                        },
                    });
                }
            });
    
            $(document).on('click', '#delete_all2', function() {
                var selected = new Array();
                $(".EmployeeID2:checkbox").each(function () {
                    var ischecked = $(this).is(":checked");
                    if (ischecked) {
                        selected.push($(this).val());
                    }
                });
                if(selected.length <=0){   
                    toastr.error('Please select atleast one record to delete!', 'Error Alert', {timeOut: 5000});
                }else{
                    $.ajax({
                        type: 'DELETE',
                        url: "{!! url('hris/tools/salaryadjust/" + selected + "') !!}",
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
    
            $('#check_all').click(function() {
                $('.EmployeeID').prop('checked', true);
            });
            $('#uncheck_all').click(function() {
                $('.EmployeeID').prop('checked', false);
            });
            $('#check_all2').click(function() {
                $('.EmployeeID2').prop('checked', true);
            });
            $('#uncheck_all2').click(function() {
                $('.EmployeeID2').prop('checked', false);
            });
        </script>
    
        <script type="text/javascript">
            function updateData(id){
                var Adjustment = strip_html_tags($('#Adjustment'+id).html()).replace(/[^0-9]/g, "");
                var Deduction = strip_html_tags($('#Deduction'+id).html()).replace(/[^0-9]/g, "");
                var Remarks = strip_html_tags($('#Remarks'+id).html());
                $.ajax({
                    type: 'PUT',
                    url: "{!! url('hris/tools/salaryadjust/" + id + "') !!}",
                    data: {
                        '_token': $('input[name=_token]').val(),
                        'id': id,
                        'Adjustment': Adjustment,
                        'Deduction': Deduction,
                        'Remarks': Remarks,
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
        </script>

    </div>

@stop
