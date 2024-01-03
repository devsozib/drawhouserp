@extends('layout.app')
@section('title', 'HRIS | Task')
@section('content')
    @include('layout/datatable')

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Task</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{!! url('hris/dashboard') !!}">HRIS</a></li>
                        <li class="breadcrumb-item"><a href="javascript::void(0)">HRIS Resource Hub</a></li>
                        <li class="breadcrumb-item"><a href="javascript::void(0)">Task</a></li>
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
                        <h3 class="card-title text-center w-75">Task List</h3>
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
                                            <h4 class="modal-title">Add Task</h4>
                                            <button type="button" class="close" data-dismiss="modal"
                                                aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ route('task.store') }}" method="POST">
                                                @csrf
                                                <div class="row g-4">
                                                    <div class="col-lg-12">
                                                        <label class="form-label" for="name">Task Description</label>
                                                        <textarea name="t_description" style="height: 400px" placeholder="Write task description✍" id="editor">{{ old('t_description')}}</textarea>
                                                    </div>
                                                    {{-- <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="form-label" for="name">Department</label>
                                                            <div class="form-control-wrap">
                                                                <select name="department" class="form-control" id="">
                                                                    <option value="" selected disabled>--Choose One--</option>
                                                                    @foreach ($depts as $item)
                                                                     <option value="{{ $item->id }}">{{ $item->Department }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div> --}}
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="form-label" for="name">Task Name</label>
                                                            <div class="form-control-wrap">
                                                                <input type="text" value="{{old('name')}}" required placeholder="Notice Name" class="form-control" name="name"
                                                                    id="name" >
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="form-label" for="n_date">Task due Date</label>
                                                            <div class="form-control-wrap">
                                                                <input placeholder="Due Date" value="{{old('t_due_date')}}" required  name="t_due_date" class="form-control datepicker" id="t_due_date">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="form-label" for="showing_date">Task Priority</label>
                                                            <div class="form-control-wrap">
                                                                <select name="task_priority" class="form-control" id="">
                                                                    <option value="" selected disabled>--Choose One--</option>
                                                                    <option value="High" >High</option>
                                                                    <option value="Medium" >Medium</option>
                                                                    <option value="Low" >Low</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="form-label" for="remarks">Task Status</label>
                                                            <select class="form-control" name="status">
                                                                <option selected disabled>--Select One--</option>
                                                                <option value="1">Scheduled</option>
                                                                <option value="2">Pending</option>
                                                                <option value="3">Submitted </option>
                                                              </select>
                                                        </div>
                                                    </div>

                                                    <div class="col-12 mt-3">
                                                        <div class="form-group d-flex justify-content-center">
                                                            <button type="submit" class="btn btn-primary">Add Task</button>
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
                                                <th>Due Date</th>
                                                <th>Priority</th>
                                                <th>Status</th>
                                                <th width="150">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($tasks as $item)
                                                <tr>
                                                    <td>{{ $loop->index + 1 }}</td>                                                   
                                                    <td>{!! $item->name !!}</td>
                                                    <td>{!! $item->t_due_date !!}</td>
                                                    <td>{!! $item->t_priority !!}</td>
                                                    <td class="text">
                                                        {{ $item->t_status == 1 ? 'Scheduled' : ($item->t_status == 2 ? 'Pending' :($item->t_status == 3 ? 'Submitted ' : 'Unknown Status')) }}</td>
                                                    <td>
                                                        <a  href="{{ route('assign',$item->id) }}" class="btn-sm bg-gradient-info" title="Edit">Assign Task</a>
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
                                                                        Are you sure you want to delete this Task:
                                                                        <strong
                                                                            style="color: darkorange">{{ $item->name }}</strong>
                                                                        ?
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <form
                                                                            action="{{ route('task.destroy', $item->id) }}"
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
                                                                        <h4 class="modal-title">Edit Task,
                                                                            Name: {!! $item->name !!}</h4>
                                                                        <button type="button" class="close"
                                                                            data-dismiss="modal" aria-label="Close"><span
                                                                                aria-hidden="true">&times;</span></button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <form action="{{ route('task.update',$item->id) }}" method="POST">
                                                                            @csrf
                                                                            @method('PATCH')
                                                                            <div class="row g-4">
                                                                                <div class="col-lg-12">
                                                                                    <label class="form-label" for="name">Task Description</label>
                                                                                    <textarea name="t_description" style="height: 400px" placeholder="Write task description✍" id="ueditor_{{ $item->id }}">{{ old('t_description',$item->t_description)}}</textarea>
                                                                                </div>
                                                                                
                                                                                <div class="col-md-6">
                                                                                    <div class="form-group">
                                                                                        <label class="form-label" for="name">Task Name</label>
                                                                                        <div class="form-control-wrap">
                                                                                            <input type="text" value="{{old('name',$item->name)}}" required placeholder="Notice Name" class="form-control" name="name"
                                                                                                id="name" >
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-6">
                                                                                    <div class="form-group">
                                                                                        <label class="form-label" for="n_date">Task due Date</label>
                                                                                        <div class="form-control-wrap">
                                                                                            <input placeholder="Due Date" value="{{old('t_due_date',$item->t_due_date)}}" required  name="t_due_date" class="form-control datepicker" id="t_due_date">
                                                                                        </div>
                                                                                    </div>
                                                                                </div>

                                                                                <div class="col-md-6">
                                                                                    <div class="form-group">
                                                                                        <label class="form-label" for="showing_date">Task Priority</label>
                                                                                        <div class="form-control-wrap">
                                                                                            <select name="task_priority" class="form-control" id="">
                                                                                                <option value="" selected disabled>--Choose One--</option>
                                                                                                <option {{ $item->t_priority == 'High' ? 'selected' : '' }} value="High" >High</option>
                                                                                                <option {{ $item->t_priority == 'Medium' ? 'selected' : '' }} value="Medium" >Medium</option>
                                                                                                <option {{ $item->t_priority == 'Low' ? 'selected' : '' }} value="Low" >Low</option>
                                                                                            </select>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-6">
                                                                                    <div class="form-group">
                                                                                        <label class="form-label" for="remarks">Task Status</label>
                                                                                        <select class="form-control" name="status">
                                                                                            <option selected disabled>--Select One--</option>
                                                                                            <option {{ $item->t_status == 1 ? 'selected' : '' }} value="1">Scheduled</option>
                                                                                            <option {{ $item->t_status == 2 ? 'selected' : '' }} value="2">Pending</option>
                                                                                            <option {{ $item->t_status == 3? 'selected' : '' }} value="3">Submitted </option>
                                                                                          </select>
                                                                                    </div>
                                                                                </div>

                                                                                <div class="col-12 mt-3">
                                                                                    <div class="form-group d-flex justify-content-center">
                                                                                        <button type="submit" class="btn btn-primary">Update Task</button>
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
