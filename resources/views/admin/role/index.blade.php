@extends('layout.app')
@section('title','Admin | Role')
@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Admin Portal<small>-Roles</small></h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{!! url('admin/dashboard') !!}">Admin</a></li>
                    <li class="breadcrumb-item"><a href="{!! url('admin/role') !!}">Roles</a></li>
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
                    <h3 class="card-title text-center w-75">Roles List</h3>
                    @if($create)
                        <div class="float-right"><a href="{!! url('admin/role/create') !!}" class="btn-sm bg-gradient-success"><i class="fas fa-plus"></i>&nbsp;Add Role</a></div>                                 
                    @endif
                </div>
                <div class="card-body" style="overflow-x: scroll;">
                    <div class="row">
                        <div class="col-lg-12">
                            <table class="table table-bordered table-striped" id="usertbl" style="min-width: 400px;">
                                <thead>
                                    <tr>
                                        <th style="width: 5%;">ID</th>
                                        <th style="width: 20%;">Role Name</th>
                                        <th style="width: 20%;">Slug</th>
                                        <th style="width: 35%;">Assigned Users</th>
                                        <th style="width: 10%;">Permissions</th>
                                        <th style="width: 10%;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($roles as $user)
                                        <tr>
                                            <td>{!! $user->id !!}</td>
                                            <td>{!! $user->name !!}</td>
                                            <td>{!! $user->slug !!}</td>
                                            <td>
                                                @if($user->slug != 'general')
                                                    <?php $users2 = collect($users)->where('role_id',$user->id)->all(); ?>
                                                    @foreach($users2 as $val)
                                                        {!! $val->first_name.' '.$val->last_name !!} ({!! $val->empid !!})<br>
                                                    @endforeach
                                                @endif
                                            </td>
                                            <td>
                                                <?php $perms = collect($roleperms)->where('role_id',$user->id)->all(); ?>
                                                @foreach($perms as $perm)
                                                    {!! $perm->Name !!},
                                                @endforeach
                                            </td>
                                            <td>
                                                @if($edit)
                                                    <a href="{!! url('admin/role/'.$user->id.'/edit') !!}" class="btn-sm bg-gradient-info" title="Edit"><i class="fas fa-edit"></i></a>
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
                                                                Are you sure you want to delete this Role: <strong style="color: darkorange">{{ $user->name }}</strong> ?
                                                            </div>                                                    
                                                            <div class="modal-footer">
                                                                {!! Form::open(array('url' => 'admin/role/'.$user->id  )) !!}
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
                        </div>
                    </div>
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
                    if (response['result'] == 'success') {
                        var imagePath = (response['changed'] == 1) ? "{{url('/public/images/publish.png')}}" : "{{url('/public/images/not_publish.png')}}";
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