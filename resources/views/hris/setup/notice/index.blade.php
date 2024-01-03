@extends('layout.app')
@section('title', 'HRIS | Notice')
@section('content')
    @include('layout/datatable')

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Notice List</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{!! url('hris/dashboard') !!}">HRIS</a></li>
                        <li class="breadcrumb-item"><a href="javascript::void(0)">HRIS Setup</a></li>
                        <li class="breadcrumb-item"><a href="javascript::void(0)">Notice</a></li>
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
                        <h3 class="card-title text-center w-75">Notice List</h3>
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
                                            <h4 class="modal-title">Add Notice</h4>
                                            <button type="button" class="close" data-dismiss="modal"
                                                aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ route('notice.store') }}" method="POST">
                                                @csrf
                                                <div class="row g-4">
                                                    <div class="col-lg-12">
                                                        <label class="form-label" for="name">Notice Description</label>
                                                        <textarea name="content" style="height: 400px" placeholder="Write notice✍" id="editor">{{ old('content')}}</textarea>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="form-label" for="name">Notice Name</label>
                                                            <div class="form-control-wrap">
                                                                <input type="text" value="{{old('name')}}" required placeholder="Notice Name" class="form-control" name="name"
                                                                    id="name" >
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="form-label" for="n_date">Notice Date</label>
                                                            <div class="form-control-wrap">
                                                                <input placeholder="Showing Date" value="{{old('n_date')}}" required  name="n_date" class="form-control datepicker" id="n_date">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="form-label" for="showing_date">Showing Date</label>
                                                            <div class="form-control-wrap">
                                                                <input placeholder="Showing Date" value="{{old('showing_date')}}" required name="showing_date" class="form-control datepicker"
                                                                    id="showing_date">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="form-label" for="remarks">Remarks</label>
                                                            <input type="text" value="{{old('remarks')}}" placeholder="Type Remarks" name="remarks" class="form-control" id="">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="form-label" for="remarks">Status</label>
                                                            <select class="form-control" name="status">
                                                                <option selected disabled>--Select One--</option>
                                                                <option value="1">Active</option>
                                                                <option value="0">InActive</option>
                                                              </select>
                                                        </div>
                                                    </div>

                                                    <div class="col-12 mt-3">
                                                        <div class="form-group d-flex justify-content-center">
                                                            <button type="submit" class="btn btn-primary">Add Notice</button>
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
                                                <th>Title</th>
                                                <th>Notice Date</th>
                                                <th>Showing Date</th>
                                                <th>Remarks</th>
                                                <th>Status</th>
                                                <th style="width: 120px;">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($notices as $item)
                                                <tr>
                                                    <td>{{ $loop->index + 1 }}</td>
                                                    <td>{!! $item->name !!}</td>
                                                    <td>{!! $item->notice_date !!}</td>
                                                    <td>{!! $item->showing_date !!}</td>
                                                    <td>{!! $item->remarks !!}</td>
                                                    <td class="text-{{ $item->status == 1 ? 'success' : 'danger' }}">
                                                        {{ $item->status == 1 ? 'Active' : 'Inactive' }}</td>
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
                                                                        Are you sure you want to delete this Notice:
                                                                        <strong
                                                                            style="color: darkorange">{{ $item->name }}</strong>
                                                                        ?
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <form
                                                                            action="{{ route('notice.destroy', $item->id) }}"
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
                                                                        <h4 class="modal-title">Edit Notice,
                                                                            Name: {!! $item->name !!}</h4>
                                                                        <button type="button" class="close"
                                                                            data-dismiss="modal" aria-label="Close"><span
                                                                                aria-hidden="true">&times;</span></button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <form action="{{ route('notice.update',$item->id) }}" method="POST">
                                                                            @csrf
                                                                            @method('PATCH')
                                                                            <div class="row g-4">
                                                                                <div class="col-lg-12">
                                                                                    <textarea name="content" style="height: 400px" placeholder="Write feed back✍" id="upeditor">{{ old('content',$item->notice )}}</textarea>
                                                                                </div>
                                                                                <div class="col-md-6">
                                                                                    <div class="form-group">
                                                                                        <label class="form-label" for="name">Notice Name</label>
                                                                                        <div class="form-control-wrap">
                                                                                            <input type="text" value="{{old('name',$item->name)}}" required placeholder="Notice Name" class="form-control" name="name"
                                                                                                id="name">
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-6">
                                                                                    <div class="form-group">
                                                                                        <label class="form-label" for="n_date">Notice Date</label>
                                                                                        <div class="form-control-wrap">
                                                                                            <input placeholder="Showing Date" value="{{old('n_date',$item->notice_date)}}" required  name="n_date" class="form-control datepicker" id="n_date">
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-6">
                                                                                    <div class="form-group">
                                                                                        <label class="form-label" for="showing_date">Showing Date</label>
                                                                                        <div class="form-control-wrap">
                                                                                            <input placeholder="Showing Date" value="{{old('showing_date',$item->showing_date)}}" required name="showing_date" class="form-control datepicker"
                                                                                                id="showing_date">
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-6">
                                                                                    <div class="form-group">
                                                                                        <label class="form-label" for="remarks">Remarks</label>
                                                                                        <input type="text" value="{{old('remarks',$item->remarks)}}" placeholder="Type Remarks" name="remarks" class="form-control" id="">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-6">
                                                                                    <div class="form-group">
                                                                                        <label class="form-label" for="remarks">Status</label>
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

                                                                                <div class="col-12 mt-3">
                                                                                    <div class="form-group d-flex justify-content-center">
                                                                                        <button type="submit" class="btn btn-primary">Add Notice</button>
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
        ClassicEditor
            .create(document.querySelector('#upeditor'),{
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
@stop
