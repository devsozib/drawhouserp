@extends('layout.app')
@section('title', 'HRIS | Participant Assign')
@section('content')
    @include('layout/datatable')
    <style type="text/css">
        .card-header {
            padding-top: 3px;
            padding-bottom: 14px;
        }
    </style>
    <style>
        .form-control {
        height: 13px!important;
    }
    div.dataTables_wrapper div.dataTables_filter input {
        height: 32px!important;
        margin-left: 0.5em;
        display: inline-block;
        width: auto;
    }
    .bootstrap-select:not(.input-group-btn), .bootstrap-select[class*="col-"] {
        float: none;
        display: inline;
        margin-left: 0;
        }
    </style>

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0" style="text-align: right;"></h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{!! url('hris/dashboard') !!}">HRIS</a></li>
                        <li class="breadcrumb-item"><a href="javascript::void(0)">Setup</a></li>
                        <li class="breadcrumb-item"><a href="{!! url('hris/training/training_master') !!}">Assign Participant</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Index</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    {{-- @php
        $concernId = request('concern_id');
        $departmentId = request('department_id');
    @endphp --}}

    <div class="content">
        <div class="row">
            <div class="col-lg-2"></div>
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header with-border"><h3 class="text-center">Assign participant for <span class="text-primary">{{ $training->t_name }}</span></h3></div>                    
                        <div class="card-body">
                            <table class="table">
                                <form action="{{ route('assignParticipant',$id) }}" method="GET">
                                    <tr>
                                        <th style="width: 10px;">Property</th>
                                        <td style="border: none;">
                                            <select class="form-control select2bs4" onchange="getDepartment(this.value)"
                                                class="form-control" name="concern_id" id="concern" disabled>
                                                <option value="">--Choose one--
                                                </option>
                                                {{-- <option value="all">All</option> --}}
                                                @foreach (userWiseCompanies([Sentinel::getUser()->company_id]) as $company)
                                                    <option {{ getHostInfo()['id'] == $company->id ? 'selected' : '' }} value="{{ $company->id }}">
                                                        {{ $company->Name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <th style="width: 10px;">Department</th>
                                        <td style="border: none;">
                                            <select name="department[]" class="form-control selectpicker" multiple data-live-search="true">                                                  
                                                @foreach ($depts as $dept)
                                                    <option {{ $department?in_array($dept->id, $department) ? 'selected' : '':'' }} value="{{ $dept->id }}">
                                                        {{ $dept->Department }}
                                                    </option>
                                                @endforeach
                                            </select>                                            
                                        </td>
                                        <td style="border: none;">
                                            <button type="submit" class="btn btn-sm btn-default">Search</button>
                                        </td>
                                        {{-- @php
                                            $concernId = request('concern_id');
                                            $departmentId = request('department_id');
                                        @endphp
                                        @if ($concernId or $departmentId)
                                            <td style="border: none;">
                                                <a href="{{ route('emlpyees') }}" class="btn btn-sm btn-default">Show
                                                    All</a>
                                            </td>
                                        @endif --}}
                                    </tr>
                                </form>
                            </table>
                            <form id="issueForm" action="{{ route('assign.training') }}" method="post">
                            @csrf
                            <input type="hidden" value="{{ $training->id }}" name="training_id">
                            <table class="table table-bordered table-striped datatbl" id="usertbl">
                                <thead>
                                    <tr>
                                        <th><input type="checkbox" id="select-all" class="form-control" {{ $allEmployeesSelected ? 'checked' : '' }}></th>
                                        <th>Employee ID</th>
                                        <th>Name</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($employees as $item)
                                        <tr>
                                            @php
                                                $isChecked = false;
                                                foreach ($assignedEmployees as $assigned) {
                                                    if ($assigned['participant_id'] == $item->EmployeeID) {
                                                        $isChecked = true;
                                                        break;
                                                    }
                                                }
                                            @endphp
                                            <td><input type="checkbox" class="form-control" name="selectedEmployees[]" value="{{ $item->EmployeeID }}" {{ $isChecked ? 'checked' : '' }}></td>
                                            <td>{{ $item->EmployeeID }}</td>
                                            <td>{{ $item->Name }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer text-right">
                            <button class="btn btn-primary" type="submit">{{ $existingEmployee > 0 ?'Update':'Submit' }}</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-lg-2"></div>
        </div>
    </div>
    <script>
        function getDepartment(id) {
            $.ajax({
                type: "GET",
                url: "{{ url('getdepartment') }}",
                data: {
                    concern_id: id,
                },
                success: function(data) {
                    console.log(data);
                    if (data) {
                        $("#departments").empty();
                        $.each(data, function(key, item) {
                            $('#departments').append('<option value="' + item.id + '">' + item
                                .Department + '</option>');
                        });
                    } else {
                        $("#departments").empty();
                    }
                    $("#departments").prepend('<option value="" selected>--Choose one--</option>');
                }
            });
        }
    </script>

<script>
    // JavaScript code to handle "Select All" functionality
    var selectAllCheckbox = document.getElementById("select-all");
    var checkboxes = document.getElementsByName("selectedEmployees[]");

    selectAllCheckbox.addEventListener("change", function() {
        for (var i = 0; i < checkboxes.length; i++) {
            checkboxes[i].checked = this.checked;
        }
    });

    for (var i = 0; i < checkboxes.length; i++) {
        checkboxes[i].addEventListener("change", function() {
            var allChecked = true;
            for (var j = 0; j < checkboxes.length; j++) {
                if (!checkboxes[j].checked && !checkboxes[j].hasAttribute('disabled')) {
                    allChecked = false;
                    break;
                }
            }
            selectAllCheckbox.checked = allChecked;
        });
    }
</script>
@stop
