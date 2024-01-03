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
                    <li class="breadcrumb-item active" aria-current="page">Create</li>
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
                    <h3 class="card-title text-center">New Role Details</h3>
                    <div class="float-right"><a href="{!! url('admin/role') !!}" class="btn-sm bg-gradient-info"><i class="fas fa-arrow-left"></i>&nbsp;Back</a></div>
                </div>
                @if($create)
                <div class="card-body">
                    {!! Form::open(array('action' => array('Admin\RoleController@store', 'method' => 'Post'))) !!}
                    <!-- Role Name -->
                    <div class="form-group is-warning">
                        <label for="name">Role Name</label>
                        <div class="controls">
                            {!! Form::text('name', null, array('required', 'class'=>'form-control', 'id' => 'name','maxlength'=>'100', 'placeholder'=>'Role Name', 'value'=>old('name'))) !!}
                        </div>
                    </div>
                    <br>
                    <!-- Permissions -->
                    <div class="form-group">
                        <label for="permission">Permissions</label>
                        <div class="controls">
                            <div class="row" style="padding-left: 15px; padding-right: 10px;">
                                @foreach($permissions as $permission)
                                    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6">
                                        <input type="checkbox" name="permission[]" id="{{ $permission->id }}" value="{{ $permission->id }}" /> {!! $permission->Name !!}
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <br>
                    <!-- Modules -->
                    <div class="form-group">
                        <label for="module">Access (<i class="fa fa-cube" style="color: green;"></i>&nbsp;Modules&nbsp;&rAarr;&nbsp;<i class="fa fa-clone" style="color: darkblue;"></i>&nbsp;Menus&nbsp;&rAarr;&nbsp;<i class="fas fa-shapes"></i>&nbsp;Childmenus)</label>
                        <div class="controls">
                            <div class="row" style="padding-left: 15px; padding-right: 15px;">
                                @foreach ($modules as $module)
                                <div class="col-lg-12" style="border: gray dashed 1px; padding: 5px; margin-top: 5px;">
                                    <div class="row" style="margin-left: 2px; color: green; font-weight: 600;">
                                        <input type="checkbox" name="module[]" id="m{{ $module->id }}" value="{{ $module->id }}"/>&nbsp;{!! $module->Name !!}
                                    </div>
                                    <?php $allmenus2 = collect($allmenus)->where('ModuleID',$module->id)->all(); ?>
                                    @foreach ($allmenus2 as $allmenu)
                                        <div class="row" style="padding-left: 30px; color: darkblue; margin-bottom: 5px;">
                                            <div class="col-lg-12 ml-auto" style="border: gray dashed 1px; padding: 5px; margin-top: 5px;">
                                                &rAarr;&nbsp;<input type="checkbox" name="menu[]" id="mm{{ $allmenu->id }}" value="{{ $allmenu->id }}" class="mainmenu{{ $module->id }}"/>&nbsp;{!! $allmenu->Name !!}
                                                <div class="row" style="padding-left: 50px; padding-top: 2px; color: black;">
                                                <?php $childmenus2 = collect($childmenus)->where('ModuleID',$module->id)->where('MenuID',$allmenu->id)->all(); $count = sizeOf($childmenus2)%3; ?>
                                                @foreach ($childmenus2 as $childmenu)
                                                    <div class="col-lg-4 ml-auto">
                                                        <input type="checkbox" name="childmenu[]" id="cm{{ $childmenu->id }}" value="{{ $childmenu->id }}" class="childmenu{{$allmenu->id}}"/>&nbsp;{!! $childmenu->Name !!}
                                                    </div>
                                                    <script type="text/javascript">
                                                        $('#cm{{ $childmenu->id }}').click(function() {
                                                            $('input[id=mm{{ $allmenu->id }}]').prop('checked', $('.childmenu{{$allmenu->id}}').is(":checked"));
                                                            $('input[id=m{{ $module->id }}]').prop('checked', $('.mainmenu{{ $module->id }}').is(":checked"));
                                                        });
                                                        $('#m{{ $module->id }}').click(function() {
                                                            $('input[id=mm{{ $allmenu->id }}]').prop("checked",$(this).prop("checked"));
                                                            $('input[id=cm{{ $childmenu->id }}]').prop("checked",$(this).prop("checked"));
                                                        });
                                                        $('#mm{{ $allmenu->id }}').click(function() {
                                                            $('input[id=cm{{ $childmenu->id }}]').prop("checked",$(this).prop("checked"));
                                                        });
                                                    </script>
                                                @endforeach
                                                @if ($count && $count == 1)
                                                <div class="col-lg-4 ml-auto"></div>
                                                <div class="col-lg-4 ml-auto"></div>
                                                @elseif ($count && $count == 2)
                                                <div class="col-lg-4 ml-auto"></div>
                                                @endif
                                                </div>
                                                <script type="text/javascript">
                                                    $('#mm{{ $allmenu->id }}').click(function() {
                                                        $('input[id=m{{ $module->id }}]').prop('checked', $('.mainmenu{{ $module->id }}').is(":checked"));
                                                    });
                                                    $('#m{{ $module->id }}').click(function() {
                                                        $("input[id=mm{{ $allmenu->id }}]").prop("checked",$(this).prop("checked"));
                                                    });
                                                </script>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-right">
                    {!! Form::submit('Save New Role', array('class' => 'btn btn-success btn-file')) !!}
                    <a href="{!! url('admin/role') !!}"class="btn btn-default">&nbsp;Cancel</a>
                    {!! Form::close() !!}
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

@stop
