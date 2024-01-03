@extends('layout.app')
@section('title', 'HRIS | Meeting')
@section('content')
    @include('layout/datatable')

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Meeting</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{!! url('hris/dashboard') !!}">HRIS</a></li>
                        <li class="breadcrumb-item"><a href="javascript::void(0)">Setup</a></li>
                        <li class="breadcrumb-item"><a href="javascript::void(0)">Meeting</a></li>
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
                        <h3 class="card-title text-center w-75">Meeting List</h3>
                        @if ($create)
                            <div class="float-right"><a role="button" data-toggle="modal" data-target="#add-modal"
                                    class="btn-sm bg-gradient-success" title="Add"><i
                                        class="fas fa-plus"></i>&nbsp;Add</a></div>

                            <!--Add Form Here-->
                            <div class="modal fade" id="add-modal" role="dialog">
                                <div class="modal-dialog modal-lg ">
                                    <!-- Modal content-->
                                    <div class="modal-content">
                                        @if (!empty(Session::get('error_code')) && Session::get('error_code') == 'Add')
                                            @include('layout/flash-message')
                                        @endif
                                        <div class="modal-header">
                                            <h4 class="modal-title">Add Meeting</h4>
                                            <button type="button" class="close" data-dismiss="modal"
                                                aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ route('meeting.store') }}" method="POST">
                                                @csrf
                                                <div class="row g-4">
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label class="form-label" for="name">Meeting Name</label>
                                                            <div class="form-control-wrap">
                                                                <input type="text" value="{{ old('name') }}" required
                                                                    placeholder="Meeting Name" class="form-control"
                                                                    name="name" id="name">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label class="form-label" for="m_date_time">Meeting Date &
                                                                Time</label>
                                                            <div class="form-control-wrap">
                                                                <input placeholder="Date & Time"
                                                                    value="{{ old('m_date_time') }}" required
                                                                    name="m_date_time" class="form-control datetimepicker"
                                                                    id="m_date_time">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label for="Department">Department</label>
                                                            <select name="dept_id" id="" onchange="getParticipant(this.value)"
                                                                class="form-control select2bs4">
                                                                <option value="" selected disabled hidden>--Select
                                                                    One--</option>
                                                                @foreach ($departmentData as $dept)
                                                                    <option value="{{ $dept->id }}">
                                                                        {{ $dept->Department }}
                                                                    </option>
                                                                @endforeach

                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label for="participants">Participants</label>
                                                            <select name="participant_ids[]" id="participants" class="form-control"  data-live-search="true">
                                                                <option selected disabled>--Select One--</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label class="form-label" for="Agenda">Agenda</label>
                                                            <textarea type="text" name="agenda" id="note" placeholder="Write Agenda" cols="10" rows="4"
                                                                class="form-control"></textarea>
                                                            {{-- <input type="text" value="{{old('remarks')}}" placeholder="Type Remarks" name="remarks" class="form-control" id=""> --}}
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label class="form-label" for="Agenda">Location</label>
                                                            <input type="text" name="location" id="location" placeholder="Write Location" class="form-control"/>
                                                            {{-- <input type="text" value="{{old('remarks')}}" placeholder="Type Remarks" name="remarks" class="form-control" id=""> --}}
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label class="form-label" for="remarks">Status</label>
                                                            <select class="form-control" name="status">
                                                                <option selected disabled>--Select One--</option>
                                                                <option value="1">Active</option>
                                                                <option value="0">InActive</option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-12 mt-3">
                                                        <div class="form-group d-flex justify-content-end">
                                                            <button type="submit" class="btn btn-primary">Add</button>
                                                        </div>
                                                    </div>
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
                                                <th>Department</th>
                                                <th>Meeting Name</th>
                                                <th>Meeting Date & Time</th>
                                                <th>Participants</th>
                                                <th>Agenda</th>
                                                <th>Location</th>
                                                <th>Status</th>
                                                <th style="width: 200px;">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($meetingData as $item)
                                                <tr>
                                                    <td>{!! $loop->index + 1 !!}</td>
                                                    <td>{!! $item['department'] !!}</td>
                                                    <td>{!! $item['m_name'] !!}</td>
                                                    <td>{!! $item['date_time'] !!}</td>
                                                    <td>
                                                        <ul>
                                                            @foreach ($item['participants'] as $participant)
                                                                <li>{{ $participant }}</li>
                                                            @endforeach
                                                        </ul>
                                                    </td>
                                                    <td>{!! $item['agenda'] !!}</td>
                                                    <td>{!! $item['location'] !!}</td>
                                                    <td class="text-{{ $item['status'] == 1 ? 'success' : 'danger' }}">
                                                        {{ $item['status'] == 1 ? 'Active' : 'Inactive' }}</td>
                                                    <td>
                                                    <a  href="{{ route('meeting.attendence',$item['id']) }}" class="btn-sm bg-gradient-info" title="Edit">Attendence</a>
                                                        @if ($edit)
                                                            <a href="{{ route('meeting.edit',$item['id']) }}"
                                                                class="btn-sm bg-gradient-info" title="Edit"><i
                                                                    class="fas fa-edit"></i></a>
                                                        @endif
                                                        @if ($delete)
                                                            <a role="button" data-toggle="modal"
                                                                data-target="#delete-modal{{ $item['id'] }}"
                                                                class="btn-sm bg-gradient-danger" title="Delete"><i
                                                                    class="fas fa-times"></i></a>
                                                        @endif

                                                        <!--Delete-->
                                                        <div class="modal fade" id="delete-modal{!! $item['id'] !!}"
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
                                                                        Are you sure you want to delete this Meeting:
                                                                        <strong
                                                                            style="color: darkorange">{{ $item['m_name'] }}</strong>
                                                                        ?
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <form
                                                                            action="{{ route('meeting.destroy', $item['id']) }}"
                                                                            method="post">
                                                                            @csrf
                                                                            @method('delete')
                                                                            <input type="hidden" name="i_c_id"
                                                                                value="{{ $item['id'] }}">
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
    {{-- <script>
        ClassicEditor
            .create(document.querySelector('#editor'));
    </script>
    <script>
        ClassicEditor
            .create(document.querySelector('#upeditor'));
    </script> --}}
     <script>
        function getParticipant(id) {
            $.ajax({
                type: "GET",
                url: "{{ url('getparticipant') }}",
                data: {
                department_id: id,
                },
                success: function(data) {
                if (data) {
                    var participantsSelect = $('#participants');

                    participantsSelect.empty();
                    $.each(data, function(key, item) {
                    participantsSelect.append($('<option>', {
                        value: item.EmployeeID,
                        text: item.Name
                    }));
                    });

                    // Add the multiple attribute
                    participantsSelect.attr('multiple', 'multiple');

                    // Refresh the selectpicker
                    participantsSelect.selectpicker('refresh');
                } else {
                    $('#participants').empty();
                }
                },
                error: function(xhr, status, error) {
                console.error(error);
                }
            });
            }
    </script>
@stop
