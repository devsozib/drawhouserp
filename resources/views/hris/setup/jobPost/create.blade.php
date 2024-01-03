@extends('layout.app')
@section('title', 'HRIS | Job')
@section('content')
    @include('layout/datatable')

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
    </div>
        <div class="content">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header with-border">
                            <h3 class="card-title text-center w-75">Add Job</h3>
                            @if ($create)
                                <div class="float-right"><a
                                        href="{{ action('\App\Http\Controllers\HRIS\Setup\JobPostController@index') }}"
                                        class="btn-sm bg-gradient-success" title="Add">&nbsp;Job List</a></div>
                            @endif
                        </div>
                        <div class="card-body" style="overflow-x: scroll;">
                            <div class="row">
                                <div class="col-lg-12">
                                    <form action="{{ action('\App\Http\Controllers\HRIS\Setup\JobPostController@store') }}"
                                        method="post" enctype="multipart/form-data">
                                        @if (!empty(Session::get('error_code')) && Session::get('error_code') == 'Add')
                                            @include('layout/flash-message')
                                        @endif
                                        @csrf
                                        {{-- {{ $errors }} --}}
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label for="Company">Company</label>
                                                            <select name="company_id" id=""
                                                                class="form-control select2bs4" readonly>
                                                                <option value="" selected disabled hidden>--Select
                                                                    One--</option>
                                                                @foreach ($companies as $company)
                                                                    <option value="{{ $company->id }}">{{ $company->Name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label for="Department">Department</label>
                                                            <select name="dept_id" id=""
                                                                class="form-control select2bs4">
                                                                <option value="" selected disabled hidden>--Select
                                                                    One--</option>
                                                                @foreach ($depts as $dept)
                                                                    <option value="{{ $dept->id }}">
                                                                        {{ $dept->Department }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label for="Designation">Position</label>
                                                            <select name="desg_id" id=""
                                                                class="form-control select2bs4">
                                                                <option value="" selected disabled hidden>--Select
                                                                    One--</option>
                                                                @foreach ($desgs as $desg)
                                                                    <option value="{{ $desg->id }}">
                                                                        {{ $desg->Designation }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label for="Vacancy">No. of Vacancies</label>
                                                            <input type="number" placeholder="No. of Vacancies" name="vacancy"
                                                                class="form-control">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row mt-3">
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label for="Location">Location</label>
                                                            <input type="text" placeholder="Location" name="location"
                                                                class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label for="Job Type">Job Type</label>
                                                            <div class="controls">
                                                                <select name="job_type" id="" class="form-control">
                                                                    <option value="" selected disabled hidden>--Select
                                                                        One--</option>
                                                                    <option value="Full-Time">Full-Time</option>
                                                                    <option value="Part-Time">Part-Time</option>
                                                                    <option value="Temporary">Temporary</option>
                                                                    <option value="Contractual">Contractual</option>
                                                                    <option value="Internship">Internship</option>
                                                                    <option value="Remote">Remote</option>
                                                                    <option value="Consulting">Consulting</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label class="form-label" for="deadline">Deadline</label>
                                                            <div class="form-control-wrap">
                                                                <input placeholder="Showing Date"
                                                                    value="{{ old('deadline') }}" required name="deadline"
                                                                    class="form-control datepicker" id="deadline">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label for="Status">Status</label>
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
                                                <div class="row mt-3 mb-2">
                                                    <div class="col-md-8">
                                                        <div class="form-group">
                                                            <label class="form-label" for="Description">Job
                                                                Description</label>
                                                            <textarea class="form-control" name="description" style="height: 600px" placeholder="Write Job Description✍"
                                                                id="editor">{{ old('description') }}</textarea>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label class="form-label" for="notes">Notes</label>
                                                            <textarea type="text" name="note" id="note" placeholder="Write notes" cols="10" rows="4"
                                                                class="form-control"></textarea>
                                                            {{-- <input type="text" value="{{old('remarks')}}" placeholder="Type Remarks" name="remarks" class="form-control" id=""> --}}
                                                        </div>
                                                    </div>
                                                </div>
                                                <button type="submit" class="btn btn-success float-right">Submit</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <script type="text/javascript">
            ClassicEditor
                .create(document.querySelector('#editor'))
                .catch(error => {
                    console.error(error);
                });
        </script>

    @stop
