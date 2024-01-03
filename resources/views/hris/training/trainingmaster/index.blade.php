@extends('layout.app')
@section('title', 'HRIS | Training')
@section('content')
    @include('layout/datatable')

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Training Master</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{!! url('hris/dashboard') !!}">HRIS</a></li>
                        <li class="breadcrumb-item"><a href="javascript::void(0)">Training Management</a></li>
                        <li class="breadcrumb-item"><a href="javascript::void(0)">Training Master</a></li>
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
                        <h3 class="card-title text-center w-75">Training List</h3>
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
                                            <h4 class="modal-title">Add Training</h4>
                                            <button type="button" class="close" data-dismiss="modal"
                                                aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ route('training_master.store') }}" method="POST">
                                                @csrf
                                                <div class="row g-4">
                                                    <div class="col-lg-12">
                                                        <label class="form-label" for="name">Training Description</label>
                                                        <textarea name="t_description" style="height: 400px" placeholder="Write Training description✍" id="editor">{{ old('t_description')}}</textarea>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="form-label" for="name">Training Name</label>
                                                            <div class="form-control-wrap">
                                                                <input type="text" value="{{old('name')}}" required placeholder="Training Name" class="form-control" name="name"
                                                                    id="name" >
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="form-label" for="conduct">Training Conducted By</label>
                                                            <div class="form-control-wrap">
                                                                <input type="text" value="{{old('conduct')}}" required placeholder="Training Conducted" class="form-control" name="conduct"
                                                                    id="conduct" >
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label class="form-label" for="n_date">Training Date & Time</label>
                                                            <div class="form-control-wrap">
                                                                <input placeholder="Date & Time" value="{{old('t_date_time')}}" required  name="t_date_time" class="form-control datetimepicker" id="t_date_time">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label class="form-label" for="n_date">Training Location</label>
                                                            <div class="form-control-wrap">
                                                                <input placeholder="Location" type="text" value="{{old('tr_location')}}" required  name="tr_location" class="form-control" id="tr_location">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label class="form-label" for="n_date">Training Hours</label>
                                                            <div class="form-control-wrap">
                                                                <input placeholder="Training Hours" value="{{old('t_hours')}}" required  name="t_hours" class="form-control timepicker" id="t_date_time">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label class="form-label" for="remarks">Training Status</label>
                                                            <select class="form-control" name="status">
                                                                <option selected disabled>--Select One--</option>
                                                                <option value="1">Active</option>
                                                                <option value="0">Inactive</option>
                                                              </select>
                                                        </div>
                                                    </div>

                                                    <div class="col-12 mt-3">
                                                        <div class="form-group d-flex justify-content-center">
                                                            <button type="submit" class="btn btn-primary">Add Training</button>
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
                                                <th>Name</th>
                                                <th>Training Conducted</th>
                                                <th>Description</th>
                                                <th>Date & Time</th>
                                                <th>Training Hours</th>
                                                <th>Location</th>
                                                <th>Created By</th>
                                                <th>Created Time</th>
                                                <th>Status</th>
                                                <th width="300">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($trainings as $item)
                                                <tr>
                                                    @php
                                                        list($hours, $minutes, $seconds) = explode(':', $item->t_hours);
                                                    @endphp

                                                    <td>{{ $loop->index + 1 }}</td>
                                                    <td>{!! $item->t_name !!}</td>
                                                    <td>{{ $item->conduct }}</td>
                                                    <td>{!! $item->t_description !!}</td>
                                                    <td>{{ \Carbon\Carbon::parse($item->t_date_time)->format('F j, Y, g:i A') }}</td>
                                                    <td>{{ intval($hours) }} hour {{ intval($minutes) }} minutes</td>
                                                    <td>{!! $item->tr_location !!}</td>
                                                    <td>{{ getUserInfo($item->created_by)->Name }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($item->created_at)->format('F j, Y, g:i A') }}</td>
                                                    <td class="text-{{ $item->status == 1 ? 'success' : 'danger' }}">
                                                        {{ $item->status == 1 ? 'Active' :'Inactive' }}</td>
                                                    <td>
                                                        <a  href="{{ route('assignParticipant',$item->id) }}" class="btn-sm bg-gradient-info" title="Edit">Assign Participant</a>
                                                        <a  href="{{ route('tr.attendence',$item->id) }}" class="btn-sm bg-gradient-info" title="Edit">Attendence</a>
                                                        @if ($edit)
                                                            <a onclick="editor('{{ $item->id }}')" role="button" data-toggle="modal"
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
                                                                        Are you sure you want to delete this Training:
                                                                        <strong
                                                                            style="color: darkorange">{{ $item->t_name }}</strong>
                                                                        ?
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <form
                                                                            action="{{ route('training_master.destroy', $item->id) }}"
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
                                                                        <h4 class="modal-title">Edit Training,
                                                                            Name: {!! $item->t_name !!}</h4>
                                                                        <button type="button" class="close"
                                                                            data-dismiss="modal" aria-label="Close"><span
                                                                                aria-hidden="true">&times;</span></button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <form action="{{ route('training_master.update',$item->id) }}" method="POST">
                                                                            @csrf
                                                                            @method('PATCH')
                                                                            <div class="row g-4">
                                                                                <div class="col-lg-12">
                                                                                    <label class="form-label" for="name">Training Description</label>
                                                                                    <textarea name="t_description" style="height: 400px" placeholder="Write Training description✍" id="ueditor_{{ $item->id }}">{{ old('t_description',$item->t_description)}}</textarea>
                                                                                </div>
                                                                                <div class="row"></div>
                                                                                <div class="col-md-6">
                                                                                    <div class="form-group">
                                                                                        <label class="form-label" for="name">Training Name</label>
                                                                                        <div class="form-control-wrap">
                                                                                            <input type="text" value="{{old('name',$item->t_name)}}" required placeholder="Training Name" class="form-control" name="name"
                                                                                                id="name" >
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-6">
                                                                                    <div class="form-group">
                                                                                        <label class="form-label" for="conduct">Training Conducted By</label>
                                                                                        <div class="form-control-wrap">
                                                                                            <input type="text" value="{{old('conduct',$item->conduct)}}" required placeholder="Training Conducted" class="form-control" name="conduct"
                                                                                                id="conduct" >
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-5">
                                                                                    <div class="form-group">
                                                                                        <label class="form-label" for="n_date">Training Date & Training</label>
                                                                                        <div class="form-control-wrap">
                                                                                            <input placeholder="Due Date" value="{{old('t_date_time',$item->t_date_time)}}" required  name="t_date_time" class="form-control datetimepicker" id="t_date_time">
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-4">
                                                                                    <div class="form-group">
                                                                                        <label class="form-label" for="n_date">Training Location</label>
                                                                                        <div class="form-control-wrap">
                                                                                            <input placeholder="Location" type="text" value="{{old('tr_location',$item->tr_location)}}" required  name="tr_location" class="form-control" id="tr_location">
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-4">
                                                                                    <div class="form-group">
                                                                                        <label class="form-label" for="n_date">Training Hours</label>
                                                                                        <div class="form-control-wrap">
                                                                                            <input placeholder="Training Hours" value="{{old('t_hours',$item->t_hours)}}" required  name="t_hours" class="form-control timepicker" id="t_hours">
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-4">
                                                                                    <div class="form-group">
                                                                                        <label class="form-label" for="remarks">Training Status</label>
                                                                                          <select class="form-control" name="status">
                                                                                            <option selected disabled>--Select One--</option>
                                                                                            <option {{ $item->status == 1 ? 'selected' : '' }} value="1">Active</option>
                                                                                            <option {{ $item->status == 0 ? 'selected' : '' }}  value="0">Inactive</option>
                                                                                          </select>
                                                                                    </div>
                                                                                </div>

                                                                                <div class="col-12 mt-3">
                                                                                    <div class="form-group d-flex justify-content-center">
                                                                                        <button type="submit" class="btn btn-primary">Update Training</button>
                                                                                    </div>
                                                                                </div>
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
    <script>
        ClassicEditor
            .create(document.querySelector('#editor'),{
                heading: {
                options: [
                    { model: 'paragraph', title: 'Paragraph', class: 'ck-heading_paragraph' },
                    { model: 'heading1', view: 'h1', title: 'Heading 1', class: 'ck-heading_heading1' },
                    { model: 'heading2', view: 'h2', title: 'Heading 2', class: 'ck-heading_heading2' },
                    { model: 'heading3', view: 'h3', title: 'Heading 3', class: 'ck-heading_heading3' },
                    { model: 'heading4', view: 'h4', title: 'Heading 4', class: 'ck-heading_heading4' },
                    { model: 'heading5', view: 'h5', title: 'Heading 5', class: 'ck-heading_heading5' },
                    { model: 'heading6', view: 'h6', title: 'Heading 6', class: 'ck-heading_heading6' }
                    // Add more heading options if needed
                ]
            }
            })
            .catch(error => {
                console.error(error);
            });
    </script>
    <script>
   let editors = {}; // Object to store the created editors

function editor(id) {
  // Check if an editor instance already exists for the given ID
  if (editors.hasOwnProperty(id) && editors[id]) {
    // Destroy the existing editor instance
    editors[id].destroy()
    editors[id] = null;
  }

  // Create a new editor instance
  ClassicEditor
    .create(document.querySelector('#ueditor_' + id), {
      heading: {
        options: [
          { model: 'paragraph', title: 'Paragraph', class: 'ck-heading_paragraph' },
          { model: 'heading1', view: 'h1', title: 'Heading 1', class: 'ck-heading_heading1' },
          { model: 'heading2', view: 'h2', title: 'Heading 2', class: 'ck-heading_heading2' },
          { model: 'heading3', view: 'h3', title: 'Heading 3', class: 'ck-heading_heading3' },
          { model: 'heading4', view: 'h4', title: 'Heading 4', class: 'ck-heading_heading4' },
          { model: 'heading5', view: 'h5', title: 'Heading 5', class: 'ck-heading_heading5' },
          { model: 'heading6', view: 'h6', title: 'Heading 6', class: 'ck-heading_heading6' }
          // Add more heading options if needed
        ]
      }
    })
    .then(editor => {
      // Store the created editor instance
      editors[id] = editor;
    })
    .catch(error => {
      console.error(error);
    });
}
    </script>
@stop
