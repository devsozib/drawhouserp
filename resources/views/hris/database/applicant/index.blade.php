@extends('layout.app')
@section('title', 'HRIS | Applicant')
@section('content')
    @include('layout/datatable')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0" style="text-align: right;">Applicant</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{!! url('hris/dashboard') !!}">HRIS</a></li>
                        <li class="breadcrumb-item"><a href="javascript::void(0)">Applicant</a></li>
                        <li class="breadcrumb-item"><a href="{!! url('hris/applicant/new-applicant') !!}">New Applicant</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Index</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header with-border">
                        <h3 class="card-title text-center w-75">Applicants</h3>

                    </div>
                    <div class="card-body" style="overflow-x: scroll;">
                        <div class="row">
                            <div class="col-lg-12">
                                <div style="min-height: 400px;">
                                    <table class="table table-bordered table-striped datatbl" id="usertbl">
                                        <thead>
                                            <tr>
                                                <th>Serial</th>
                                                <th>Name</th>
                                                <th>Concern</th>
                                                <th>Department</th>
                                                <th>Position</th>
                                                <th>Applicant Id</th>
                                                <th>Phone</th>
                                                <th>email</th>
                                                <th>NationalIDNo</th>
                                                <th>Status</th>
                                                <th style="width: 120px;">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($applicants as $item)
                                                <tr>
                                                    <td>{{ $loop->index + 1 }}</td>
                                                    <td>{{ $item->Name }}</td>
                                                    <td>{{ $item->concern_name }}</td>
                                                    <td>{{ $item->Department??'N/A' }}</td>
                                                    <td>{{ $item->job_designation != null ? $item->job_designation : $item->emp_designation }}</td>
                                                    <td>{{ $item->emp_id }}</td>
                                                    <td>{{ $item->MobileNo }}</td>
                                                    <td>{{ $item->email }}</td>
                                                    <td>{{ $item->NationalIDNo }}</td>
                                                    <td>
                                                        <div class="btn-group">
                                                            <button
                                                                class="btn btn-{{ $item->status == 0 ? 'info' : ($item->status == 1 ? 'warning' : ($item->status == 2 ? 'success' : ($item->status == 3 ? 'danger' : 'secondary'))) }} btn-sm dropdown-toggle"
                                                                type="button" data-toggle="dropdown" aria-expanded="false">
                                                                {{ $item->status == 0 ? 'Pending' : ($item->status == 1 ? 'Processing' : ($item->status == 2 ? 'Selected' : ($item->status == 3 ? 'Rejected' : 'Nothing'))) }}
                                                            </button>
                                                            <div class="dropdown-menu">
                                                                <a class="dropdown-item"
                                                                    onclick="changeStatus({{ $item->emp_id }},'0')"
                                                                    href="#">Pending</a>
                                                                <a class="dropdown-item"
                                                                    onclick="changeStatus({{ $item->emp_id }},'1')"
                                                                    href="#">Select for
                                                                    interview</a>
                                                                <a class="dropdown-item"
                                                                    onclick="changeStatus({{ $item->emp_id }},'2')"
                                                                    href="#">Selected</a>
                                                                <a class="dropdown-item"
                                                                    onclick="changeStatus({{ $item->emp_id }},'3')"
                                                                    href="#">Reject</a>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <a class="btn btn-sm btn-primary" target="_blank"
                                                            href="{!! URL('hris/applicant/new-applicant', [$item->emp_id]) !!}?applicant=show">See
                                                            Details</a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function changeStatus(id, status) {
            // console.log(id + '-' + status);
            $.ajax({
                url: "{{ url('updateApplicant') }}",
                type: "GET",
                data: {
                    id: id,
                    status: status
                },
                success: function(response) {
                    toastr.success(response[1]);
                    $("#usertbl").load(window.location + " #usertbl");
                },
                error: function(xhr) {
                    // Handle the error if the request fails
                    console.log(xhr.responseText);
                }
            });
        }
    </script>
@stop
