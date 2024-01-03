@extends('layout.app')
@section('title','Admin | Activity Logs')
@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <!-- <h1 class="m-0">Admin Portal<small>-Activity Logs</small></h1> -->
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{!! url('admin/dashboard') !!}">Admin</a></li>
                    <li class="breadcrumb-item"><a href="{!! url('admin/menus') !!}">Activity Logs</a></li>
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
                    <h3 class="card-title text-center w-75">Activity Logs List</h3>
                </div>
                <div class="card-body" style="overflow-x: scroll;">
                    <div class="row">
                        <div class="col-lg-12">
                            <table class="table table-bordered table-striped" id="usertbl" style="min-width: 400px;">
                                <thead>
                                    <tr>
                                        <th style="width: 6%;">Sl No</th>
                                        <th style="width: 14%;">Subject</th>
                                        <th style="width: 14%;">URL</th>
                                        <th style="width: 8%;">Real IP</th>
                                        <!-- <th style="width: 10%;">Old Data</th>
                                        <th style="width: 10%;">New Data</th>
                                        <th style="width: 12%;">User Agent</th> -->
                                        <th style="width: 12%;">User Name</th>
                                        <th style="width: 14%;">Date Time</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1; ?>
                                    @foreach($users as $user)
                                    <tr>
                                        <td>{{ $i++ }}</td>
                                        <td>{{ $user->subject }}</td>
                                        <td class="text-success">{{ $user->url }}</td>
                                        <td class="text-warning">{{ $user->ip }}</td>
                                        <!-- <td>{{ $user->olddata }}</td>
                                        <td>{{ $user->newdata }}</td>
                                        <td class="text-danger">{{ $user->agent }}</td> -->
                                        <td>{{ getUserInfo($user->user_id)->Name }}</td>
                                        <td>{{ date('d-m-Y H:i:s', strtotime($user->created_at)) }}</td>
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