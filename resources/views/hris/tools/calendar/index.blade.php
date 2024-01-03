@extends('layout.app')
@section('title', 'HRIS | Calendar')
@section('content')
<style>
    .input-group-text {
        padding: 2px;
    
    }
</style>
    <?php $complist = getCompanyList(1); ?>
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
                        <li class="breadcrumb-item"><a href="{!! url('hris/tools/calendar') !!}">Calendar</a></li>
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
                <div class="row">
                    <div class="col-md-8 col-sm-12">
                        <div class="card">
                            <div class="card-header with-border" style="font-size: 22px; text-align: center;">Calendar</div>
                            <div class="card-body">
                                <table class="table table-bordered">
                                    {!! Form::open(array('action' => array('\App\Http\Controllers\HRIS\Tools\CalendarController@store', 'method' => 'Post'))) !!}
                                    <tbody>
                                        <tr>
                                            <th style="width: 10%;">Property</th>
                                            <td style="width: 2%">:</td>
                                            <td style="width: 30%">
                                                <div class="control-group {!! $errors->has('company') ? 'has-error' : '' !!}">
                                                    <div class="controls">
                                                        <!-- Display a select dropdown for the "Company" field -->
                                                        {!! Form::select('company', $complists, getHostInfo()['id'], ['class' => 'form-control selectpicker', 'id' => 'Company']) !!}
                                                    </div>
                                                </div>
                                            </td>                                        
                                            <th style="width: 23%;">Year</th>
                                            <td style="width: 2%">:</td>
                                            <td style="width: 50%">
                                                <div class="control-group {!! $errors->has('Year') ? 'has-error' : '' !!}">
                                                    <div class="controls">
                                                        {!! Form::number('Year', $hroptions->Year, array('required', 'readonly', 'class'=>'form-control', 'id' => 'Year', 'min' => '2000', 'max' => '2100', 'placeholder'=>'Year', 'value'=>Input::old('Year'))) !!}
                                                    </div>
                                                </div>
                                            </td>
                                            <td style="width: 25%; text-align: center;">
                                                @if($create)
                                                    {!! Form::submit('Generate', array('class' => 'btn btn-success')) !!}
                                                @endif
                                            </td>
                                        </tr>
                                    </tbody>
                                    {!! Form::close() !!}
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-12">
                        <div class="card" style="min-height:133px">
                            <div class="card-header with-border" style="font-size: 22px; text-align: center;">Add Holiday</div>
                            <div class="card-body">
                                @if ($create)
                                <div class=" text-center" ><a role="button" data-toggle="modal" data-target="#add-modal" class="btn bg-gradient-success" title="Add"><i class="fas fa-plus"></i>&nbsp;Add Holiday</a></div>
    
                                <!--Add Form Here-->
                                <div class="modal fade" id="add-modal" role="dialog">
                                    <div class="modal-dialog modal-lg ">
                                        <!-- Modal content-->
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title">Add Holiday</h4>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            </div>
                                            <div class="modal-body">
                                             <form
                                                    action="{{ action('\App\Http\Controllers\HRIS\Tools\CalendarController@store') }}"
                                                    method="post" id="addCalender">
                                                    @if (!empty(Session::get('error_code')) && Session::get('error_code') == $user->id)
                                                        @include('layout/flash-message')
                                                    @endif
                                                    @csrf
                                                    <div class="row">                                                     
                                                       <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label for="Name">Comapny</label>
                                                                <select name="company" id="company" class="form-control select2bs4">
                                                                    <option selected disabled>--Select One--</option>
                                                                    @foreach ($complists as $id => $name)
                                                                        <option {{ getHostInfo()['id'] == $id ?'selected':'' }} value="{{ $id }}">{{ $name }}</option>
                                                                    @endforeach
                                                                </select>
                                                                
                                                            </div>
                                                        </div> 
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label for="Name">Holiday Name</label>
                                                                <input type="text" placeholder="Holiday Name" name="name"
                                                                    class="form-control" id="name">
                                                            </div>
                                                        </div> 
                                                        
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label for="Name">Date</label>
                                                                <input type="text" placeholder="Pick Date" id="date" name="date"
                                                                    class="form-control datepicker">
                                                            </div>
                                                        </div>                                                      
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label for="C4S">Is PublicHoliday?</label>
                                                                <div class="controls">
                                                                    <select name="p_holiday" id="p_holiday" class="form-control">
                                                                        <option value="" selected disabled hidden>--Select
                                                                            One--</option>
                                                                        <option value="Y">YES</option>
                                                                        <option value="N">NO</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="submit" class="btn btn-success">Submit</button>
                                                        <button type="button" class="btn btn-default"
                                                            data-dismiss="modal">Cancel</button>
                                                    </div>
                                                </form>
                                            </div>
    
                                        </div>
                                    </div>
                                </div>
                                {{-- @if (!empty(Session::get('error_code')) && Session::get('error_code') == 'Add')
                                    <script>
                                        $(function() {
                                            $('#add-modal').modal('show');
                                        });
                                    </script>
                                @endif --}}
                            @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-2">
               
            </div>
        </div>

        <div class="row">
            <div class="col-lg-2"></div>
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header with-border" style="font-size: 22px; text-align: center;">
                        <p>Calendar List</p> 
                        <form action="{{ action('\App\Http\Controllers\HRIS\Tools\CalendarController@index') }}" method="get">      
                             <input type="hidden" name="dispalyCW" value="1">                    
                            <div class="input-group mb-3">
                                <select name="company" id="company" class="form-control">
                                    <option {{ $request->company == 'all' ? 'selected' : '' }} value="all">All</option>
                                    @foreach ($complists as $id => $name)
                                        <option {{ $request->company == $id ? 'selected' : '' }} value="{{ $id }}">{{ $name }}</option>
                                    @endforeach
                                </select>
                                <div class="input-group-append">
                                    <button class="input-group-text" type="submit">Display</button>
                                </div>
                            </div>       
                        </form>                                                                                            
                    </div>
                    <div class="card-body">
                        <div style="min-height: 500px; max-height: 500px; overflow: auto; margin-bottom: 5px;">
                            <table class="table table-striped fixed_header display" id="calendar" width="100%">
                                <thead>
                                    <tr>
                                        <th>Property</th>
                                        <th>Date</th>
                                        <th>Holiday?</th>
                                        <th>Public Holiday?</th>
                                        <th>Narration</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if($edit)
                                        @foreach($calendars as $calendar)
                                            <tr>
                                                <td>{{ $complist[$calendar->company_id] }}</td>
                                                <td>{{ date('d-m-Y', strtotime($calendar->Date)) }}</td>
                                                <td id='Holiday{{$calendar->id}}' contenteditable='true' class='single-line' onkeypress='return(this.innerText.length <= 1)'>{{ $calendar->Holiday }}</td>
                                                <td id='PublicHoliday{{$calendar->id}}' contenteditable='true' class='single-line' onkeypress='return(this.innerText.length <= 1)'>{{ $calendar->PublicHoliday }}</td>
                                                <td onblur='updateData("{{$calendar->id}}")' id='Naration{{$calendar->id}}' contenteditable='true' class='single-line' onkeypress='return(this.innerText.length <= 49)'>{{ $calendar->Naration }}</td>
                                            </tr>
                                        @endforeach
                                    @else
                                        @foreach($calendars as $calendar)
                                            <tr>
                                                <td>{{ $complist[$calendar->company_id] }}</td>
                                                <td>{{ date('d-m-Y', strtotime($calendar->Date)) }}</td>
                                                <td>{{ $calendar->Holiday }}</td>
                                                <td>{{ $calendar->PublicHoliday }}</td>
                                                <td>{{ $calendar->Naration }}</td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-2"></div>
        </div>
    </div>

    <script type="text/javascript">
        function updateData(id){
            var holiday = strip_html_tags($('#Holiday'+id).html()).replace(/[^A-Za-z]/g, "").toUpperCase();
            var pholiday = strip_html_tags($('#PublicHoliday'+id).html()).replace(/[^A-Za-z]/g, "").toUpperCase();
            var naration = strip_html_tags($('#Naration'+id).html()).replace(/[^0-9A-Za-z_ -/]/g, "");
           
            $.ajax({
                type: 'PUT',
                url: "{!! url('/hris/tools/calendar/" + id + "') !!}",
                data: {
                    '_token': $('input[name=_token]').val(),
                    'Holiday': holiday,
                    'PublicHoliday': pholiday,
                    'Naration': naration,
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

        $("#addCalender").on("submit", function (event) {
            event.preventDefault();
            $.ajax({
                type: 'POST',
                url: "{{ url('hris/tools/calendar/') }}",
                data: {
                    '_token': $('input[name=_token]').val(),
                    'company': $('#company').val(),
                    'name': $("#name").val(),
                    'date': $("#date").val(),
                    'p_holiday': $("#p_holiday").val(),
                    'addCalender': 1
                },
                success: function(data) {                                      
                    if (data.errors) {
                        toastr.error(data.errors, 'Error Alert', { timeOut: 5000 });
                        $('#add-modal').modal('show');
                    } else {
                        toastr.success(data.success, 'Success Alert', { timeOut: 5000 });
                        $('#add-modal').modal('hide');
                        $("#calendar").load(window.location.href + " #calendar");
                    }
                    $('#changebtn').attr('disabled', false);
                },
            });
        });
    </script> 

@stop
