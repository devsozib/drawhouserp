@extends('layout.app')
@section('title', 'HRIS | Employee List')
@section('content')
    @include('layout/datatable')
    <style type="text/css">
        .card-header {
            padding-top: 3px;
            padding-bottom: 14px;
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
                        <li class="breadcrumb-item"><a href="javascript::void(0)">Database</a></li>
                        <li class="breadcrumb-item"><a href="{!! url('hris/database/emlpyees') !!}">Employee List</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Index</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    @php
        $concernId = request('concern_id');
        $departmentId = request('department_id');
    @endphp

    <div class="content">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header with-border">
                        <h3 class="card-title w-50 text-right">Employee List</h3>
                        {{-- <div class="float-right w-25">
                            <div class="form-group">
                                <table class="table" style="margin-bottom: -40px;">
                                    <form action="{{ route('emlpyees') }}" method="GET">
                                        <tr>
                                            <td style="border: none;">
                                                <select class="form-control select2bs4"
                                                    class="form-control" name="concern_id" id="concern">
                                                    <option value="">--Choose one--
                                                    </option>
                                                    @foreach ($concerns as $concern)
                                                        <option {{ $concern_id == $concern->id ? 'selected' : '' }}
                                                            value="{{ $concern->id }}">
                                                            {{ $concern->Name }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td style="border: none;">
                                                <select class="form-control select2bs4" name="department_id"
                                                    id="departments">
                                                    <option value="">--Choose one--</option>
                                                    @foreach ($departments as $dept)
                                                    <option {{ $department_id == $dept->id ? 'selected' : '' }}
                                                        value="{{ $dept->id }}">
                                                        {{ $dept->Department }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td style="border: none;">
                                                <button type="submit" class="btn btn-sm btn-default">Search</button>
                                            </td>
                                            @php
                                                $concernId = request('concern_id');
                                                $departmentId = request('department_id');
                                            @endphp
                                            @if ($concernId or $departmentId)
                                                <td style="border: none;">
                                                    <a href="{{ route('emlpyees') }}" class="btn btn-sm btn-default">Show
                                                        All</a>
                                                </td>
                                            @endif
                                        </tr>
                                    </form>
                                </table>
                            </div>
                        </div> --}}
                    </div>
                    <div class="card-body" style="overflow-x: scroll;">
                        <div class="row">
                            <div class="col-lg-12">
                                <div style="min-height: 400px;">
                                    <table class="table table-bordered table-striped datatblsp" id="usertbl">
                                        <thead>
                                            <tr>
                                                <th>SL</th>
                                                <th>Property</th>
                                                <th>Employee ID</th>
                                                <th>Name</th>
                                                <th>Department</th>
                                                <th>Designation</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($employees as $item)
                                                 <tr>
                                                    <td>{{ $loop->index + 1 }}</td>
                                                    <td>{!! $item->concern !!}</td>
                                                    <td>{!! $item->EmployeeID !!}</td>
                                                    <td>{!! $item->Name !!}</td>
                                                    <td>{!! $item->Department !!}</td>
                                                    <td>{!! $item->Designation !!}</td>
                                                    <td class="text-{{ $item->C4S == 'Y' ? 'success' : 'danger' }}">
                                                        {{ $item->C4S == 'Y' ? 'Active' : 'Inactive' }}
                                                    </td>
                                                    <td>
                                                        <div style="display: inline-block;">
                                                            <form action="{{ action('\App\Http\Controllers\HRIS\Database\EmployeeController@getSearch') }}" method="post" target="_blank">
                                                                @csrf
                                                                <input type="hidden" value="{{ $item->EmployeeID }}" name="search">
                                                                <button type="submit" class="btn-sm btn-primary">See Info</button>
                                                            </form>
                                                        </div>
                                                        @if (Sentinel::inRole('superadmin') || Sentinel::inRole('management') || Sentinel::inRole('hr_manager') || Sentinel::inRole('programmer'))
                                                            <div style="display: inline-block;">
                                                                <form action="{{ action('\App\Http\Controllers\HRIS\Database\EmployeeController@getHistory') }}" method="post" target="_blank">
                                                                    @csrf
                                                                    <input type="hidden" value="{{ $item->EmployeeID }}" name="search">
                                                                    <button type="submit" class="btn-sm btn-primary">See History</button>
                                                                </form>
                                                            </div>
                                                        @endif
                                                        @if ($delete && Sentinel::inRole('superadmin'))
                                                        <div style="display: inline-block;">
                                                            <a role="button" data-toggle="modal" data-target="#delete-modal{{ $item->id }}" class="btn-sm btn-danger" title="Delete">Delete</a>
                                                        </div>
                                                        @endif
                                                    </td>
                                                </tr>
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
                                                                Are you sure you want to delete this Employee:
                                                                <strong
                                                                    style="color: darkorange">{{ $item->Name }}</strong>
                                                                ?
                                                            </div>
                                                            <div class="modal-footer">
                                                                <form
                                                                    action="{{ action('\App\Http\Controllers\HRIS\Database\EmployeeController@destroy',$item->EmployeeID) }}"
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
