@extends('layout.app')
@section('title', 'HRIS | Task Assign')
@section('content')
<style>

div.dataTables_wrapper div.dataTables_filter input {
    height: 32px!important;
    margin-left: 0.5em;
    display: inline-block;
    width: auto;
}
</style>
    <?php $inputdate = \Carbon\Carbon::now()->format('Y-m-d'); ?>
    @include('layout/datatable')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    {{-- <h1 class="m-0">Assign Task</h1> --}}
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{!! url('hris/dashboard') !!}">HRIS</a></li>
                        <li class="breadcrumb-item"><a href="javascript::void(0)">Setup</a></li>
                        <li class="breadcrumb-item"><a href="javascript::void(0)">Task Assign</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Index</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        @if(count($assignments) > 0)
            <div class="card-body">
                <div class="row">
                    <div class="col-4 m-auto">
                        <h3 class="text-center">Assigned Task Progess</span></h3>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-8 m-auto">
                        <table class="table table-bordered table-striped datatbl" id="usertbl">
                            <thead>
                                <tr>
                                    <th>SL</th>
                                    <th>Employee ID</th>
                                    <th>Name</th>
                                    <th>Employee Status</th>
                                    <th>Manager Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($assignments as $item)
                                    <tr>
                                        <td>{{ $loop->index+1 }}</td>
                                        <td>{{ $item->EmployeeID }}</td>
                                        <td>{{ $item->Name }}</td>
                                        <td>
                                            {{ $item->employee_status =='1'?'Not Started': ($item->employee_status=='2' ? 'In Progress' : ($item->employee_status=='3' ? 'Completed':'On Hold')) }}
                                        </td>
                                        <td>
                                            {{ $item->manager_status == '1' ? 'Not Started': ( $item->manager_status == '2' ? 'In Progress' : ( $item->manager_status == '3' ? 'Completed':'On Hold')) }}
                                        </td>
                                        <td>
                                            <a type="button" class="btn-sm bg-gradient-primary" data-toggle="modal" data-target="#status{{ $item->id }}">Update Status</a>
                                        </td>
                                    </tr>
                                    <div class="modal fade" id="status{{ $item->id }}" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                            <h5 class="modal-title" id="staticBackdropLabel">Update Status</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ route('update.task.status') }}" method="post">
                                                    @csrf
                                                    <input type="hidden" name="task_id" value="{{ $item->task_id }}" id="">
                                                    <input type="hidden" name="emp_id" value="{{ $item->emp_id }}" id="">
                                                    <select name="manager_status" class="form-control" id="">
                                                        <option value="" selected>Choose One</option>
                                                        <option {{ $item->manager_status == '1'?'selected':'' }} value="1">Not Started</option>
                                                        <option {{ $item->manager_status == '2'?'selected':'' }} value="2">In Progress</option>
                                                        <option {{ $item->manager_status == '3'?'selected':'' }} value="3">Completed</option>
                                                        <option {{ $item->manager_status == '4'?'selected':'' }} value="4">On Hold</option>
                                                    </select>
                                                    <button class="btn btn-sm btn-primary mt-2" type="submit">Update</button>
                                                </form>
                                            </div>

                                        </div>
                                        </div>
                                    </div>
                                @endforeach
                            </tbody>
                        </table>
                </div>
            </div>
        @endif
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-4 m-auto">
                                <h3 class="text-center">Assign employee for <span class="text-primary">{{ $task->name }}</span></h3>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-8 m-auto">
                            <form id="issueForm" action="{{ route('assign.task') }}" method="post">
                                @csrf
                                <input type="hidden" value="{{ $task->id }}" name="task_id">
                                <table class="table table-bordered table-striped datatbl" id="usertbl">
                                    <thead>
                                        <tr>
                                            <th><input style="height: 13px!important;" type="checkbox" id="select-all" class="form-control" {{ $allEmployeesSelected ? 'checked' : '' }}></th>
                                            <th>Employee ID</th>
                                            <th>Name</th>
                                            {{-- <th>Status</th> --}}
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($employees as $item)
                                            <tr>
                                                @php
                                                    $isChecked = false;
                                                    foreach ($assignedEmployees as $assigned) {
                                                        if ($assigned['emp_id'] == $item->EmployeeID) {
                                                            $isChecked = true;
                                                            break;
                                                        }
                                                    }
                                                @endphp
                                                <td><input style="height: 13px!important;" type="checkbox" class="form-control" name="selectedEmployees[]" value="{{ $item->EmployeeID }}" {{ $isChecked ? 'checked' : '' }}></td>
                                                <td>{{ $item->EmployeeID }}</td>
                                                <td>{{ $item->Name }}</td>
                                                {{-- <td>{{ $item->employee_status }}</td> --}}
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div class="text-center mb-2">
                                    <button class="btn btn-primary" type="submit">{{ $existingEmployee > 0 ?'Update':'Submit' }}</button>
                                </div>
                            </form>
                        </div>
                    </div>
                  
                </div>
            </div>
        </div>
    </div>


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
