@extends('layout.app')
@section('title', 'HRIS | Job Appraisal')
@section('content')
@include('layout/datatable')

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0" style="text-align: right;">Job Appraisal</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{!! url('hris/dashboard') !!}">HRIS</a></li>
                        <li class="breadcrumb-item"><a href="javascript::void(0)">Setup</a></li>
                        <li class="breadcrumb-item"><a href="{!! url('hris/setup/job_appraisal') !!}">Job Appraisal</a></li>
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
                        <h3 class="card-title text-center w-75">Job Appraisal List</h3>
                        @if ($create)
                            <div class="float-right"><a role="button" data-toggle="modal" data-target="#add-modal"
                                    class="btn-sm bg-gradient-success" title="Add"><i
                                        class="fas fa-plus"></i>&nbsp;Add</a></div>
                            <!--Add Form Here-->
                            <div class="modal fade" id="add-modal" role="dialog">
                                <div class="modal-dialog modal-lg ">
                                    <!-- Modal content-->
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title">Add Job Appraisal</h4>
                                            <button type="button" class="close" data-dismiss="modal"
                                                aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ route('job_appraisal.store') }}" method="post">
                                                @if (!empty(Session::get('error_code')) == 'add')
                                                    @include('layout/flash-message')
                                                @endif
                                                @csrf
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label for="Name">Name</label>
                                                            <input type="text" placeholder="Name" name="name"
                                                                class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label for="Name">Department</span></label>
                                                            <select name="department" id="" class="form-control">
                                                                <option value="" selected disabled>--Select--</option>
                                                                @foreach ($deptlist as $dept)
                                                                    <option value="{{ $dept->id }}">
                                                                        {{ $dept->Department }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label for="C4S">Part</label>
                                                            <div class="controls">
                                                                <select name="part" id="" class="form-control">
                                                                    <option value="" selected disabled hidden>
                                                                        --Select--</option>
                                                                    <option value="1">1</option>
                                                                    <option value="2">2</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label for="C4S">Status</label>
                                                            <div class="controls">
                                                                <select name="status" id="" class="form-control">
                                                                    <option value="" selected disabled hidden>--Select
                                                                        One--</option>
                                                                    <option value="1">Active</option>
                                                                    <option value="0">Inactive</option>
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
                            @if (!empty(Session::get('error_code')) && Session::get('error_code') == 'Add')
                                <script>
                                    $(function() {
                                        $('#add-modal').modal('show');
                                    });
                                </script>
                            @endif
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
                                                <th>Name</th>
                                                <th>Department</th>
                                                <th>Part</th>
                                                <th>Status</th>
                                                <th style="width: 120px;">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($items as $item)
                                                <tr>
                                                    <td>{{ $loop->index + 1 }}</td>
                                                    <td>{{ $item->name }}</td>
                                                    <td>{{ $item->Department }}</td>
                                                    <td>{{ $item->part }}</td>
                                                    <td>{{ $item->status == 1 ? 'Active' : 'Inactive' }}</td>
                                                    <td>
                                                        @if ($edit)
                                                            <a role="button" data-toggle="modal"
                                                                data-target="#edit-modal{{ $item->id }}"
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
                                                        <div class="modal fade" id="delete-modal{!! $item->id !!}"
                                                            role="dialog">
                                                            <div class="modal-dialog modal-md">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h4 class="modal-title">Warning!!!</h4>
                                                                        <button type="button" class="close"
                                                                            data-dismiss="modal" aria-label="Close"><span
                                                                                aria-hidden="true">&times;</span></button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        Are you sure you want to delete this Company:
                                                                        <strong
                                                                            style="color: darkorange">{{ $item->name }}</strong>
                                                                        ?
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <form
                                                                            action="{{ route('job_appraisal.destroy', $item->id) }}"
                                                                            method="post">
                                                                            @csrf
                                                                            @method('delete')
                                                                            <input type="hidden" name="i_c_id"
                                                                                value="{{ $item->id }}">
                                                                            <button type="submit"
                                                                                class="btn btn-default">Delete</button>
                                                                        </form>
                                                                        <button type="button" class="btn btn-default"
                                                                            data-dismiss="modal">Cancel</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <!--Edit Form Here-->
                                                        <div class="modal fade" id="edit-modal{!! $item->id !!}"
                                                            role="dialog">
                                                            <div class="modal-dialog modal-lg ">
                                                                <!-- Modal content-->
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h4 class="modal-title">Edit Job appraisal</h4>
                                                                        <button type="button" class="close"
                                                                            data-dismiss="modal" aria-label="Close"><span
                                                                                aria-hidden="true">&times;</span></button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <form
                                                                            action="{{ route('job_appraisal.update', $item->id) }}"
                                                                            method="post">
                                                                            @method('patch')
                                                                            @csrf
                                                                            <div class="row">
                                                                                <div class="col-md-3">
                                                                                    <div class="form-group">
                                                                                        <label for="Name">Name</label>
                                                                                        <input type="text"
                                                                                            value="{{ $item->name }}"
                                                                                            placeholder="Name"
                                                                                            name="name"
                                                                                            class="form-control">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-3">
                                                                                    <div class="form-group">
                                                                                        <label
                                                                                            for="Name">Department</span></label>
                                                                                        {{-- <input type="text"
                                                                                            value="{{ $item->department }}"
                                                                                            name="department"
                                                                                            class="form-control"
                                                                                            placeholder="Type department"> --}}
                                                                                        <select name="department"
                                                                                            id=""
                                                                                            class="form-control">
                                                                                            @foreach ($deptlist as $dept)
                                                                                                <option
                                                                                                    {{ $item->department == $dept->id ? 'selected' : '' }}
                                                                                                    value="{{ $dept->id }}">
                                                                                                    {{ $dept->Department }}
                                                                                                </option>
                                                                                            @endforeach
                                                                                        </select>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-3">
                                                                                    <div class="form-group">
                                                                                        <label for="C4S">Part</label>
                                                                                        <div class="controls">
                                                                                            <select name="part"
                                                                                                id=""
                                                                                                class="form-control">
                                                                                                <option value=""
                                                                                                    selected disabled
                                                                                                    hidden>--Select
                                                                                                    One--</option>
                                                                                                <option
                                                                                                    {{ $item->part == 1 ? 'selected' : '' }}
                                                                                                    value="1">1
                                                                                                </option>
                                                                                                <option
                                                                                                    {{ $item->part == 2 ? 'selected' : '' }}
                                                                                                    value="2">2
                                                                                                </option>
                                                                                            </select>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-3">
                                                                                    <div class="form-group">
                                                                                        <label
                                                                                            for="C4S">Status</label>
                                                                                        <div class="controls">
                                                                                            <select name="status"
                                                                                                id=""
                                                                                                class="form-control">
                                                                                                <option
                                                                                                    {{ $item->status == 1 ? 'selected' : '' }}
                                                                                                    value="1">Active
                                                                                                </option>
                                                                                                <option
                                                                                                    {{ $item->status == 0 ? 'selected' : '' }}
                                                                                                    value="0">Inactive
                                                                                                </option>
                                                                                            </select>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="modal-footer">
                                                                                <button type="submit"
                                                                                    class="btn btn-success">Update</button>
                                                                                <button type="button"
                                                                                    class="btn btn-default"
                                                                                    data-dismiss="modal">Cancel</button>
                                                                            </div>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @if (!empty(Session::get('error_code')) && Session::get('error_code') == $item->id)
                                                            <script>
                                                                $(function() {
                                                                    $('#edit-modal{{ $item->id }}').modal('show');
                                                                });
                                                            </script>
                                                        @endif
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
