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
                                                <th>Date & Time</th>
                                                <th>Training Hours</th>
                                                <th>Location</th>
                                                {{-- <th>Status</th> --}}
                                                {{-- <th width="200">Action</th> --}}
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($trainings as $item)
                                            @php
                                                list($hours, $minutes, $seconds) = explode(':', $item->t_hours);
                                            @endphp

                                            {{ intval($hours) }} hour {{ intval($minutes) }} minutes
                                                <tr>
                                                    <td>{{ $loop->index + 1 }}</td>
                                                    <td>{!! $item->t_name !!}</td>
                                                    <td><a type="button" class="btn-sm bg-gradient-primary" data-toggle="modal" data-target="#staticBackdrop{{ $item->id }}">See Description</a></td>
                                                    <td>{{ \Carbon\Carbon::parse($item->t_date_time)->format('F j, Y, g:i A') }}</td>
                                                    <td>{{ intval($hours) }} hour {{ intval($minutes) }} minutes</td>
                                                    <td>{!! $item->tr_location !!}</td>
                                                    {{-- <td class="text-{{ $item->status == 1 ? 'success' : 'danger' }}">
                                                        {{ $item->status == 1 ? 'Active' :'Inactive' }}</td> --}}
                                                    {{-- <td>
                                                        <a  href="{{ route('assignParticipant',$item->id) }}" class="btn-sm bg-gradient-info" title="Edit">Assign Participant</a>
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
                                                    </td> --}}
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
@stop
