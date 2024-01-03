@extends('layout.app')
@section('title', 'Library | Company')
@section('content')
    @include('layout/datatable')

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Task List</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{!! url('employee/dashboard') !!}">Employee</a></li>
                        <li class="breadcrumb-item"><a href="javascript::void(0)">Resource Hub</a></li>
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
                                                <th>Description</th>
                                                <th>Due Date</th>
                                                <th>Priority</th>
                                                <th>Manager Status</th>
                                                <th>Employee Status</th>
                                                <th width="150">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($tasks as $item)
                                                <tr>
                                                    <td>{{ $loop->index + 1 }}</td>
                                                    <td>{!! $item->name !!}</td>
                                                    <td><a type="button" class="btn-sm bg-gradient-primary" data-toggle="modal" data-target="#staticBackdrop{{ $item->id }}">See Description</a></td>
                                                    <td>{!! $item->t_due_date !!}</td>
                                                    <td>{!! $item->t_priority !!}</td>
                                                    <td class="">
                                                        {{ $item->t_status == 1 ? 'Scheduled' : ($item->t_status == 2 ? 'Pending' :($item->t_status == 3 ? 'Submitted ' : 'Unknown Status')) }}
                                                    </td>
                                                    <td class="">
                                                        {{ $item->employee_status == 1 ? 'Not Started' : ($item->employee_status == 2 ? 'In Progress' : ($item->employee_status == 3 ? 'Completed ' : ($item->employee_status == 4 ? 'On Hold':'Unknown Status'))) }}
                                                    </td>
                                                    <td>
                                                        <a type="button" class="btn-sm bg-gradient-primary" data-toggle="modal" data-target="#status{{ $item->id }}">Update Status</a>
                                                    </td>
                                                </tr>
                                                <div class="modal fade" id="staticBackdrop{{ $item->id }}" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                                      <div class="modal-content">
                                                        <div class="modal-header">
                                                          <h5 class="modal-title" id="staticBackdropLabel">Description</h5>
                                                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                          </button>
                                                        </div>
                                                        <div class="modal-body">
                                                          {!! $item->t_description !!}
                                                        </div>

                                                      </div>
                                                    </div>
                                                  </div>
                                                  <div class="modal fade" id="status{{ $item->id }}" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                                      <div class="modal-content">
                                                        <div class="modal-header">
                                                          <h5 class="modal-title" id="staticBackdropLabel">Update Status</h5>
                                                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                          </button>
                                                        </div> 
                                                        <div class="modal-body">
                                                            <form action="{{ route('update.task.status') }}" method="post">
                                                                @csrf
                                                                <input type="hidden" name="task_id" value="{{ $item->task_id }}" id="">
                                                                <input type="hidden" name="form" value="employee" id="">
                                                                <select name="employee_status" class="form-control" id="">
                                                                    <option {{ $item->employee_status =='1'?'selected':'' }} value="1">Not Started</option>
                                                                    <option {{ $item->employee_status =='2'?'selected':'' }} value="2">In Progress</option>
                                                                    <option {{ $item->employee_status =='3'?'selected':'' }} value="3">Completed</option>
                                                                    <option {{ $item->employee_status =='4'?'selected':'' }} value="4">On Hold</option>
                                                                </select>
                                                                <button class="btn btn-sm btn-primary mt-2" type="submit">Update</button>
                                                            </form>
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
    <script>

    </script>
@stop
