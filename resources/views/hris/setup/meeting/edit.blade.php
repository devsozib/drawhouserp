@extends('layout.app')
@section('title', 'HRIS | Meeting')
@section('content')
    @include('layout/datatable')

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Meeting Edit</h1>
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
                    <div class="card-body">
                        <div class="row">
                            <div class="col-4 m-auto">
                                <h3 class="text-center">Meeting Edit</h3>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-8 m-auto">
                        <form id="issueForm" action="{{ route('meeting.update',$meeting->id) }}" method="post">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" value="" name="task_id">
                            <div class="row g-4">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="form-label" for="name">Meeting Name</label>
                                        <div class="form-control-wrap">
                                            <input type="text" value="{{ old('name',$meeting->m_name) }}" required
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
                                                value="{{ old('m_date_time',$meeting->date_time) }}" required
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
                                                <option {{ $meeting->dept_id == $dept->id?'selected':'' }} value="{{ $dept->id }}">
                                                    {{ $dept->Department }}
                                                </option>
                                            @endforeach

                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="participants">Participants</label>
                                        <select name="participant_ids[]" id="participants" class="form-control selectpicker" multiple data-live-search="true">
                                            @foreach ($employees as $emp)
                                                <option {{ $meeting->participants->pluck('participant_id')->contains($emp->EmployeeID) ? 'selected' : '' }}  value="{{ $emp->EmployeeID }}">{{ $emp->Name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-label" for="Agenda">Agenda</label>
                                        <textarea type="text" name="agenda" id="note" placeholder="Write Agenda" cols="10" rows="4"
                                            class="form-control">{{ $meeting->agenda }}</textarea>
                                        {{-- <input type="text" value="{{old('remarks')}}" placeholder="Type Remarks" name="remarks" class="form-control" id=""> --}}
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-label" for="Agenda">Location</label>
                                        <input type="text" name="location" value="{{ old('location',$meeting->location) }}" id="location" placeholder="Write Location" class="form-control"/>
                                        {{-- <input type="text" value="{{old('remarks')}}" placeholder="Type Remarks" name="remarks" class="form-control" id=""> --}}
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-label" for="remarks">Status</label>
                                        <select class="form-control" name="status">
                                            <option selected disabled>--Select One--</option>
                                            <option {{ $meeting->status == '1'?'selected':'' }} value="1">Active</option>
                                            <option {{ $meeting->status == '0'?'selected':'' }} value="0">InActive</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group d-flex justify-content-end m-3">
                                <button class="btn btn-primary" type="submit">Update</button>
                            </div>
                        </form>
                      </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script>
        ClassicEditor
            .create(document.querySelector('#upeditor'));
    </script>
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
