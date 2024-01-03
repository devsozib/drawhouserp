@extends('layout.app')
@section('title', 'HRIS | Job')
@section('content')
@include('layout/datatable')
    <style>
        .description-scroll {
            max-height: 150px; /* Set the desired maximum height for the scrollable area */
            overflow-y: auto; /* Enable vertical scrolling */
        }
    </style>
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Jobs</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{!! url('hris/dashboard') !!}">HRIS</a></li>
                        <li class="breadcrumb-item"><a href="javascript::void(0)">Setup</a></li>
                        <li class="breadcrumb-item"><a href="{!! url('hris/setup/job') !!}">Jobs</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Index</li>
                    </ol>
                </div>
            </div>
        </div>

        <div class="content">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header with-border">
                            <h3 class="card-title text-center w-75">Job List</h3>
                            @if ($create)
                                <div class="float-right"><a
                                        href="{{ action('\App\Http\Controllers\HRIS\Setup\JobPostController@create') }}"
                                        class="btn-sm bg-gradient-success" title="Add"><i
                                            class="fas fa-plus"></i>&nbsp;Add</a></div>
                            @endif
                        </div>
                        <div class="card-body" style="overflow-x: scroll;">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div style="min-height: 400px;">
                                        <table class="table table-bordered table-striped datatbl" id="usertbl">
                                            <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Company</th>
                                                    <th>Department</th>
                                                    <th>Position</th>
                                                    <th>No of Vacancies</th>
                                                    <th>Location</th>
                                                    <th>Job Type</th>
                                                    <th>Job Description</th>
                                                    <th>Deadline</th>
                                                    <th>Note</th>
                                                    <th>Status</th>
                                                    <th style="width: 120px;">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($items as $item)
                                                    <tr>
                                                        <td>{{ $loop->index + 1 }}</td>
                                                        <td>{!! $item->Name !!}</td>
                                                        <td>{!! $item->Department !!}</td>
                                                        <td>{!! $item->Designation !!}</td>
                                                        <td>{!! $item->vacancy !!}</td>
                                                        <td>{!! $item->location !!}</td>
                                                        <td>{!! $item->job_type !!}</td>
                                                        <td> <div class="description-scroll">
                                                            {!! $item->description !!}</div>
                                                        </td>
                                                        <td>{!! $item->deadline !!}</td>
                                                        <td>{!! $item->note !!}</td>
                                                        <td class="text-{{ $item->status == 1 ? 'success' : 'danger' }}">
                                                            {{ $item->status == 1 ? 'Active' : 'Inactive' }}</td>
                                                        <td>
                                                            @if ($edit)
                                                                <a href="{{ route('job-post.edit', encrypt($item->id)) }}"
                                                                    class="btn-sm bg-gradient-info" title="Edit"><i
                                                                        class="fas fa-edit"></i></a>
                                                            @endif
                                                            @if ($delete)
                                                                <a role="button" data-toggle="modal"
                                                                    data-target="#delete-modal{{ $item->id }}"
                                                                    class="btn-sm bg-gradient-danger" title="Delete"><i
                                                                        class="fas fa-times"></i></a>
                                                            @endif

                                                            <!--Delete-->
                                                            <div class="modal fade"
                                                                id="delete-modal{!! $item->id !!}" role="dialog">
                                                                <div class="modal-dialog modal-md">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h4 class="modal-title">Warning!!!</h4>
                                                                            <button type="button" class="close"
                                                                                data-dismiss="modal"
                                                                                aria-label="Close"><span
                                                                                    aria-hidden="true">&times;</span></button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            Are you sure you want to delete this Job Post:
                                                                            <strong
                                                                                style="color: darkorange">{{ $item->Designation }}</strong>
                                                                            ?
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <form
                                                                                action="{{ action('\App\Http\Controllers\HRIS\Setup\JobPostController@update', $item->id) }}"
                                                                                method="post">
                                                                                @csrf
                                                                                @method('delete')
                                                                                <button type="submit"
                                                                                    class="btn btn-default">Delete</button>
                                                                            </form>
                                                                            <button type="button" class="btn btn-default"
                                                                                data-dismiss="modal">Cancel</button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
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

    @stop
