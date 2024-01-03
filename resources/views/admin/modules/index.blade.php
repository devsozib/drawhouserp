@extends('layout.app')
@section('title','Admin | Modules')
@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Admin Portal<small>-Modules</small></h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{!! url('admin/dashboard') !!}">Admin</a></li>
                    <li class="breadcrumb-item"><a href="{!! url('admin/modules') !!}">Modules</a></li>
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
                    <h3 class="card-title text-center w-75">Modules List</h3>
                    @if($create)
                        <div class="float-right"><a role="button" data-toggle="modal" data-target="#add-modal"  class="btn-sm bg-gradient-success" title="Add"><i class="fas fa-plus"></i>&nbsp;Add Module</a></div>

                        <!--Add Form Here-->
                        <div class="modal fade" id="add-modal" role="dialog">
                            <div class="modal-dialog modal-lg ">
                                <!-- Modal content-->
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title">Add Module Information</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    </div>
                                    <div class="modal-body"> 
                                        {!! Form::open(array('action' => array('\App\Http\Controllers\Admin\ModulesController@store', 'method' => 'Post'))) !!}
                                        @if(!empty(Session::get('error_code')) && Session::get('error_code') == 'Add')
                                            @include('layout/flash-message')
                                        @endif
                                        <div class="row" style="padding-left: 5px; padding-right: 5px;">
                                            <div class="col-lg-5">  
                                                <div class="form-group">
                                                    <label for="Name">Display Name</label>
                                                    <div class="controls">
                                                        {!! Form::text('Name', null, array('required', 'class'=>'form-control', 'id' => 'Name', 'maxlength'=>'50', 'placeholder'=>'Name', 'value'=>Input::old('Name'))) !!}
                                                    </div>
                                                </div>                                                     
                                            </div>
                                            <div class="col-lg-5">
                                                <div class="form-group">
                                                    <label for="Slug">Slug</label>
                                                    <div class="controls">
                                                        {!! Form::text('Slug', null, array('required', 'class'=>'form-control', 'id' => 'Slug', 'maxlength'=>'50', 'placeholder'=>'Slug', 'value'=>Input::old('Slug'))) !!}
                                                    </div>
                                                </div>                                                     
                                            </div>
                                            <div class="col-lg-2">
                                                <div class="form-group">
                                                    <label for="C4S">Status</label>
                                                    <div class="controls">
                                                        {!! Form::select('C4S', array('Y' => 'Yes', 'N' => 'No'), null, array('required', 'class' => 'form-control', 'id' => 'C4S', 'value'=>Input::old('C4S'))) !!}
                                                    </div>
                                                </div>                                                     
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">   
                                        {!! Form::submit('Add', array('class' => 'btn btn-success')) !!}
                                        {!! Form::close() !!}
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @if(!empty(Session::get('error_code')) && Session::get('error_code') == 'Add')
                        <script>
                            $(function() { $('#add-modal').modal('show'); });
                        </script>
                        @endif
                    @endif
                </div>
                <div class="card-body" style="overflow-x: scroll;">
                    <div class="row">
                        <div class="col-lg-12">
                            <table class="table table-bordered table-striped" id="usertbl" style="min-width: 400px;">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Display Name</th>
                                        <th>Slug</th>
                                        <th>Status</th>
                                        <th style="width: 120px;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($users as $user)
                                        <tr>
                                            <td>{!! $user->id !!}</td>
                                            <td>{!! $user->Name !!}</td>
                                            <td>{!! $user->Slug !!}</td>
                                            <td>{!! getC4S($user->C4S) !!}</td>
                                            <td>
                                                @if($edit)
                                                    <a role="button" data-toggle="modal" data-target="#edit-modal{{ $user->id }}"  class="btn-sm bg-gradient-info" title="Edit"><i class="fas fa-edit"></i></a>
                                                @endif
                                                @if($delete)
                                                    <a role="button" data-toggle="modal" data-target="#delete-modal{{ $user->id }}"  class="btn-sm bg-gradient-danger" title="Delete"><i class="fas fa-times"></i></a>
                                                @endif

                                                <!--Delete-->
                                                <div class="modal fade" id="delete-modal{!! $user->id !!}" role="dialog">
                                                    <div class="modal-dialog modal-md">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h4 class="modal-title">Warning!!!</h4>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                Are you sure you want to delete this Module: <strong style="color: darkorange">{{ $user->Name }}</strong> ?
                                                            </div>                                                    
                                                            <div class="modal-footer">
                                                                {!! Form::open(array('url' => 'admin/modules/'.$user->id  )) !!}
                                                                {!! Form::hidden('_method', 'DELETE') !!}
                                                                {!! Form::submit('Delete',array('class'=>'btn btn-danger'))  !!}
                                                                {!! Form::close() !!}
                                                                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!--Edit Form Here-->
                                                <div class="modal fade" id="edit-modal{!! $user->id !!}" role="dialog">
                                                    <div class="modal-dialog modal-lg ">
                                                        <!-- Modal content-->
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h4 class="modal-title">Edit Module Information, Name: {!! $user->Name !!}</h4>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                            </div>
                                                            <div class="modal-body"> 
                                                                {!! Form::open(array('url' => 'admin/modules/'.$user->id  )) !!}
                                                                {!! Form::hidden('_method', 'PATCH') !!}
                                                                @if(!empty(Session::get('error_code')) && Session::get('error_code') == $user->id)
                                                                    @include('layout/flash-message') 
                                                                @endif
                                                                <div class="row" style="padding-left: 5px; padding-right: 5px;">
                                                                    <div class="col-lg-5">  
                                                                        <div class="form-group">
                                                                            <label for="Name">Display Name</label>
                                                                            <div class="controls">
                                                                                {!! Form::text('Name', $user->Name, array('required', 'class'=>'form-control', 'id' => 'Name', 'maxlength'=>'50', 'placeholder'=>'Name', 'value'=>Input::old('Name'))) !!}
                                                                            </div>
                                                                        </div>                                                     
                                                                    </div>
                                                                    <div class="col-lg-5">
                                                                        <div class="form-group">
                                                                            <label for="Slug">Slug</label>
                                                                            <div class="controls">
                                                                                {!! Form::text('Slug', $user->Slug, array('required', 'class'=>'form-control', 'id' => 'Slug', 'maxlength'=>'50', 'placeholder'=>'Slug', 'value'=>Input::old('Slug'))) !!}
                                                                            </div>
                                                                        </div>                                                     
                                                                    </div>
                                                                    <div class="col-lg-2">
                                                                        <div class="form-group">
                                                                            <label for="C4S">Status</label>
                                                                            <div class="controls">
                                                                                {!! Form::select('C4S', array('Y' => 'Yes', 'N' => 'No'), $user->C4S, array('required', 'class' => 'form-control', 'id' => 'C4S','value'=>Input::old('C4S'))) !!}
                                                                            </div>
                                                                        </div>                                                     
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">   
                                                                {!! Form::submit('Update', array('class' => 'btn btn-success')) !!}
                                                                {!! Form::close() !!}
                                                                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                @if(!empty(Session::get('error_code')) && Session::get('error_code') == $user->id)
                                                <script>
                                                    $(function() {
                                                        $('#edit-modal{{ $user->id }}').modal('show');
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

@stop