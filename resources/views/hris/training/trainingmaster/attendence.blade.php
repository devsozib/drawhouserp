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
        height: 13px !important;
    }

    div.dataTables_wrapper div.dataTables_filter input {
        height: 32px !important;
        margin-left: 0.5em;
        display: inline-block;
        width: auto;
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
                    <li class="breadcrumb-item"><a href="javascript::void(0)">Training Arttendence Participant</a></li>
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
        <div class="col-lg-12">
            <div class="card">
                <h3 class="text-center">Attendance for <span class="text-primary">{{ $training->t_name }}</span></h3>
                <div class="row">
                    <div class="col-md-8 m-auto">
                        <form id="issueForm" action="{{ route('assign.training') }}" method="post">
                            @csrf
                            <input type="hidden" value="{{ $training->id }}" name="training_id">
                            <table class="table table-bordered table-striped datatbl" id="usertbl">
                                <thead>
                                    <tr>
                                        <th>SL</th>
                                        <th>Employee ID</th>
                                        <th>Name</th>
                                        <th>Attendence</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($assignedEmployees as $item)
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
                                        <td>{{ $loop->index+1 }}</td>
                                        <td>{{ $item->EmployeeID }}</td>
                                        <td>{{ $item->Name }}</td>
                                        <td><div class="form-check form-switch">
                                            <input class="form-check-input" onchange="attendence('{{ $item->training_id }}','{{ $item->EmployeeID }}')" type="checkbox"  id="flexSwitchCheckChecked" {{ $item->present=='1'?'checked':'' }}>
                                            {{-- <label class="form-check-label" for="flexSwitchCheckChecked">Checked switch checkbox input</label> --}}
                                          </div></td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function attendence(tr_id, emp_id) {
        $.ajax({
            type: "GET",
            url: "{{ url('attendence') }}",
            data: {
                tr_id: tr_id,
                emp_id: emp_id,
            },
            success: function(data) {
              if(data == 'success'){
                toastr.success('Attendance Success');
              }

            }
        });
    }
</script>


@stop
