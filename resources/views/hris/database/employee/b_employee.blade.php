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
                        <li class="breadcrumb-item"><a href="{!! url('hris/database/emlpyees') !!}">Birthday Employee List</a></li>
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
                        <h3 class="card-title w-50 text-right">Birthday Employee List</h3>
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
                                    <table class="table table-bordered table-striped datatbl" id="usertbl">
                                        <thead>
                                            <tr>
                                                <th>SL</th>
                                                <th>EmployeeID</th>
                                                <th>Name</th>
                                                {{-- <th>Concern</th>
                                                <th>DepartmentID</th>
                                                <th>DesignationID</th>
                                                <th>Status</th> --}}
                                                {{-- <th>Details</th> --}}
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($b_employees as $item)
                                                <tr>
                                                    <td>{{ $loop->index + 1 }}</td>
                                                    <td>{!! $item->EmployeeID !!}</td>
                                                    <td>{!! $item->Name !!}</td>
                                                    {{-- <td>{!! $item->concern !!}</td>
                                                    <td>{!! $item->Department !!}</td>
                                                    <td>{!! $item->Designation !!}</td>
                                                    <td class="text-{{ $item->C4S == 'Y' ? 'success' : 'danger' }}">
                                                        {{ $item->C4S == 'Y' ? 'Active' : 'Inactive' }}</td> --}}
                                                    {{-- <td><form action="{{ action('\App\Http\Controllers\HRIS\Database\EmployeeController@getSearch') }}" method="post" >
                                                        @csrf
                                                        <input type="hidden" value="{{ $item->EmployeeID }}" name="search">
                                                        <button type="submit" class="btn btn-primary">See Details</button>
                                                    </form></td> --}}
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
        // function getDepartment(id) {
        //     $.ajax({
        //         type: "GET",
        //         url: "{{ url('getdepartment') }}",
        //         data: {
        //             concern_id: id,
        //         },
        //         success: function(data) {
        //             console.log(data);
        //             if (data) {
        //                 $("#departments").empty();
        //                 $.each(data, function(key, item) {
        //                     $('#departments').append('<option value="' + item.id + '">' + item
        //                         .Department + '</option>');
        //                 });
        //             } else {
        //                 $("#departments").empty();
        //             }
        //             $("#departments").prepend('<option value="" selected>--Choose one--</option>');
        //         }
        //     });
        // }
    </script>
@stop
