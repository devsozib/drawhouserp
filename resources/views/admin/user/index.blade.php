@extends('layout.app')
@section('title','Admin | User')

@section('content')
@include('layout/datatable')

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Admin Portal<small>-Users</small></h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{!! url('admin/dashboard') !!}">Admin</a></li>
                    <li class="breadcrumb-item"><a href="{!! url('admin/user') !!}">User</a></li>
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
                    <h3 class="card-title text-center w-75">Users List</h3>
                    @if($create)
                        <div class="float-right"><a href="{!! url('admin/user/create') !!}" class="btn-sm bg-gradient-success"><i class="fas fa-plus"></i>&nbsp;Add</a></div>
                    @endif
                </div>
                <div class="card-body" style="overflow-x: scroll;">
                    <div class="row">
                        <div class="col-lg-12">
                            <table class="table table-bordered table-striped datatbl" id="usertbl" style="min-width: 400px;">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        {{-- <th>Name</th> --}}
                                        <th>User Name</th>
                                        <th>Email Address</th>
                                        <th>Employee ID</th>
                                        <th>Join Date</th>
                                        <th>Last Login</th>
                                        <th>Role</th>
                                        <th>Online?</th>
                                        <th>Activate</th>
                                        <th style="width: 100px;">Reset</th>
                                        <th style="width: 120px;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 0; ?>
                                    @foreach($users as $user)
                                        <tr>
                                            <td>{!! $user->id !!}</td>
                                            {{-- <td>{!! $user->Name !!}</td> --}}
                                            <td>@if ($user->first_name && $user->last_name) {!! $user->first_name !!} {!! $user->last_name !!} @else {!! $user->fullname !!} @endif</td>
                                            <td>{!! $user->email !!}</td>
                                            <td>{!! $user->empid !!}</td>
                                            <td>{!! date('d-m-Y', strtotime($user->created_at)) !!}</td>
                                            <td>{!! $user->last_login ? date('d-m-Y H:i', strtotime($user->last_login)) : '' !!}</td>
                                            <td>{!! $rolelists[$user->role_id] ??'' !!}</td>
                                            <td>
                                                @if($user->isOnline())
                                                    <button type="button" class="btn-sm bg-gradient-default">
                                                        <i style="color: green;" class="fas fa-user"></i>
                                                    </button>
                                                    <?php $i++; ?>
                                                @else
                                                    <button type="button" class="btn-sm bg-gradient-default">
                                                        <i style="color: red;" class="fas fa-user"></i>
                                                    </button>
                                                @endif
                                            </td>
                                            <td>
                                                @if($edit)
                                                    <a href="javascript::void(0)" id="{!! $user->id !!}" class="activating"><img id="publish-image-{!! $user->id !!}" src="{{url('/images')}}{!! (UserActiveOrNot($user->id)) ? '/publish.png' : '/not_publish.png' !!}" title="{!! (UserActiveOrNot($user->id)) ? 'Activated' : 'Deactivated'  !!}" alt="{!! (UserActiveOrNot($user->id)) ? 'Activated' : 'Deactivated'  !!}"/></a>
                                                @endif
                                            </td>
                                            <td>
                                                @if($edit)
                                                    @if(UserActiveOrNot($user->id))
                                                        <a role="button" data-toggle="modal" data-target="#profile-edit-modal{{ $user->id }}"  class="btn-sm bg-gradient-warning" title="Reset Password"><i class="fas fa-lock-open"></i></a>

                                                        <!--Reset Here-->
                                                        <div class="modal fade" id="profile-edit-modal{!! $user->id !!}" role="dialog">
                                                            <div class="modal-dialog modal-md">
                                                                <!-- Modal content-->
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h4 class="modal-title">Password Reset Form For: <strong style="color: darkorange">{{ $user->first_name . ' ' . $user->last_name }}</strong></h4>
                                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        {!! Form::open(array('url' => 'admin/user/'.$user->id  )) !!}
                                                                        {!! Form::hidden('form_id', 1) !!}
                                                                        {!! Form::hidden('_method', 'PATCH') !!}
                                                                        @if(!empty(Session::get('error_code')) && Session::get('error_code') == $user->id)
                                                                            @include('layout/flash-message')
                                                                        @endif
                                                                        <div class="row">
                                                                            <div class="col-md-6">
                                                                                <div class="form-group">
                                                                                    <label class="control-label" for="password">New Password</label>
                                                                                    <div class="controls">
                                                                                        {!! Form::password('password', array('required','class'=>'form-control', 'id' => 'password', 'placeholder'=>'New Password', 'minlength'=>'6', 'value'=>old('password'))) !!}
                                                                                    </div>
                                                                                    @if ($errors->first('password'))
                                                                                    <span class="help-block">{!! $errors->first('password') !!}</span>
                                                                                    @endif
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-6">
                                                                                <div class="form-group">
                                                                                    <label class="control-label" for="confirm_password">Confirm Password</label>
                                                                                    <div class="controls">
                                                                                        {!! Form::password('confirm_password', array('required','class'=>'form-control', 'id' => 'confirm_password', 'placeholder'=>'Confirm Password', 'minlength'=>'6', 'value'=>old('confirm_password'))) !!}
                                                                                    </div>
                                                                                    @if ($errors->first('confirm_password'))
                                                                                    <span class="help-block">{!! $errors->first('confirm_password') !!}</span>
                                                                                    @endif
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        {!! Form::submit('Reset', array('class' => 'btn btn-warning')) !!}
                                                                        {!! Form::close() !!}
                                                                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @if(!empty(Session::get('error_code')) && Session::get('error_code') == $user->id)
                                                        <script>
                                                            $(function() {
                                                                $('#profile-edit-modal{{ $user->id }}').modal('show');
                                                            });
                                                        </script>
                                                        @endif
                                                    @endif

                                                    @if($user->isOnline())
                                                        <a role="button" data-toggle="modal" data-target="#profile-out-modal{{ $user->id }}"  class="btn-sm bg-gradient-danger" title="Log Out This User"><i class="fas fa-sign-out-alt"></i></a>

                                                        <!--Log Out Here-->
                                                        <div class="modal fade" id="profile-out-modal{!! $user->id !!}" role="dialog">
                                                            <div class="modal-dialog modal-md">
                                                                <!-- Modal content-->
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h4 class="modal-title">Warning!!!</h4>
                                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        {!! Form::open(array('url' => 'admin/user/'.$user->id  )) !!}
                                                                        {!! Form::hidden('form_id', 2) !!}
                                                                        {!! Form::hidden('_method', 'PATCH') !!}
                                                                        @if(!empty(Session::get('error_code')) && Session::get('error_code') == $user->id)
                                                                            @include('layout/flash-message')
                                                                        @endif
                                                                        <div class="row" style="padding-left: 15px; padding-right: 10px;">
                                                                            Are you sure you want to Log Out: &nbsp;<strong style="color: darkorange">{{ $user->first_name . ' ' . $user->last_name }} ?</strong>
                                                                        </div>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        {!! Form::submit('Log Out', array('class' => 'btn btn-danger')) !!}
                                                                        {!! Form::close() !!}
                                                                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif
                                                @endif
                                            </td>
                                            <td>
                                                @if($edit)
                                                    <a href="{!! url('admin/user/'.$user->id.'/edit') !!}" class="btn-sm bg-gradient-info" title="Edit"><i class="fas fa-edit"></i></a>
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
                                                                Are you sure you want to delete this User: <strong style="color: darkorange">{{ $user->first_name . ' ' . $user->last_name }}</strong> ?
                                                            </div>
                                                            <div class="modal-footer">
                                                                {!! Form::open(array('url' => 'admin/user/'.$user->id  )) !!}
                                                                {!! Form::hidden('_method', 'DELETE') !!}
                                                                {!! Form::submit('Delete',array('class'=>'btn btn-danger'))  !!}
                                                                {!! Form::close() !!}
                                                                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div style="background: transparent; text-align: center;">
                                {!! $users->withQueryString()->links('pagination::bootstrap-5') !!}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer with-border">
                    <h3 class="card-title" style="color: green;">Online Users : {{$i}}</h3>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        $('#notification').show().delay(4000).fadeOut(700);
        $(".activating").bind("click", function (e) {
            var id = $(this).attr('id');
            e.preventDefault();
            $.ajax({
                type: "POST",
                url: "{!! url('/admin/user/" + id + "/toggleactivating/') !!}",
                headers: {
                    'X-CSRF-Token': $('meta[name="_token"]').attr('content')
                },
                success: function (response) {
                    console.log(response);

                    if (response['result'] == 'success') {
                        var imagePath = (response['changed'] == 1) ? "{{url('/images/publish.png')}}" : "{{url('/images/not_publish.png')}}";
                        $("#publish-image-" + id).attr('src', imagePath);
                        toastr.success("User Activation Status Successfully Changed");
                    } else {
                        toastr.warning("You are not permitted to perform this task");
                    }
                },
                error: function () {
                    toastr.warning("Validation Error!");
                }
            })
        });
    });
</script>

@stop
