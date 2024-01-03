@extends('layout.app')
@section('title', 'Library | Vendor')
@section('content')
@include('layout/datatable')

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Vendor</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{!! url('library/dashboard') !!}">Library</a></li>
                    <li class="breadcrumb-item"><a href="javascript::void(0)">General</a></li>
                    <li class="breadcrumb-item"><a href="{!! url('library/general/suppliers') !!}">Vendor</a></li>
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
                    <h3 class="card-title text-center w-75">Vendor List</h3>
                    @if ($create)
                        <div class="float-right"><a role="button" data-toggle="modal" data-target="#add-modal"
                                class="btn-sm bg-gradient-success" title="Add"><i
                                    class="fas fa-plus"></i>&nbsp;Add</a></div>

                        <!--Add Form Here-->
                        <div class="modal fade" id="add-modal" role="dialog">
                            <div class="modal-dialog modal-lg ">
                                <!-- Modal content-->
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title">Add Vendor Information</h4>
                                        <button type="button" class="close" data-dismiss="modal"
                                            aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    </div>
                                    <div class="modal-body">
                                        {!! Form::open(['action' => ['\App\Http\Controllers\Library\General\SupplierController@store', 'method' => 'Post'],
                                        ]) !!}
                                        @if (!empty(Session::get('error_code')) && Session::get('error_code') == 'Add')
                                            @include('layout/flash-message')
                                        @endif
                                       
                                        <div class="row" style="padding-left: 0px; padding-right: 0px;">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="Name">Name</label>
                                                    <input type="text" placeholder="Name" name="name" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="Name">Company</label>
                                                    <select name="company_id" id="" class="form-control">
                                                        <option value="" selected disabled hidden>--Select One--</option>
                                                        @foreach($companies as $company)
                                                        <option value="{{ $company->id }}">{{ $company->Name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="Phone">Phone</label>
                                                    <input type="text" placeholder="Phone" name="Phone" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="Email">Email</label>
                                                    <input type="email" placeholder="Email" name="Email" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="Address">Address</label>
                                                    <input type="text" placeholder="Address" name="Address" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="Contact Person">Contact Person</label>
                                                    <input type="text" placeholder="Contact Person" name="Contact_Person" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="Contact Person Mobile">Contact Person Mobile</label>
                                                    <input type="text" placeholder="Contact Person Mobile" name="cp_mobile" class="form-control">
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="C4S">Status</label>
                                                    <div class="controls">
                                                        <select name="status" id="" class="form-control">
                                                            <option value="" selected disabled hidden>--Select One--</option>
                                                            <option value="1">Active</option>
                                                            <option value="0">Inactive</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        {!! Form::submit('Add', ['class' => 'btn btn-success']) !!}
                                        {!! Form::close() !!}
                                        <button type="button" class="btn btn-default"
                                            data-dismiss="modal">Cancel</button>
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
                                <table class="table table-bordered table-striped datatbl" id="suppliertbl">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Name</th>
                                            <th>Company</th>
                                            <th>Email</th>
                                            <th>Phone</th>
                                            <th>Address</th>
                                            <th>Contact Person</th>
                                            <th>Contact Person Mobile</th>
                                            <th>Status</th>
                                            <th style="width: 120px;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($suppliers as $supplier)
                                            <tr>
                                                <td>{!! $supplier->id !!}</td>
                                                <td>{!! $supplier->name !!}</td>
                                                <td>{!! $supplier->company_name !!}</td>
                                                <td>{!! $supplier->email !!}</td>
                                                <td>{!! $supplier->phone !!}</td>
                                                <td>{!! $supplier->address !!}</td>
                                                <td>{!! $supplier->contact_person !!}</td>
                                                <td>{!! $supplier->cp_mobile !!}</td>
                                                <td class="text-{{ $supplier->status==1?'success':'danger' }}">{{  $supplier->status==1?'Active':'Inactive' }}</td>
                                                <td>
                                                    @if ($edit)
                                                        <a role="button" data-toggle="modal"
                                                            data-target="#edit-modal{{ $supplier->id }}"
                                                            class="btn-sm bg-gradient-info" title="Edit"><i
                                                                class="fas fa-edit"></i></a>
                                                    @endif
                                                    @if ($delete)
                                                        <a role="button" data-toggle="modal"
                                                            data-target="#delete-modal{{ $supplier->id }}"
                                                            class="btn-sm bg-gradient-danger" title="Delete"><i
                                                                class="fas fa-times"></i></a>
                                                    @endif

                                                    <!--Delete-->
                                                    <div class="modal fade" id="delete-modal{!! $supplier->id !!}"
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
                                                                    Are you sure you want to delete this supplier:
                                                                    <strong
                                                                        style="color: darkorange">{{ $supplier->name }}</strong>
                                                                    ?
                                                                </div>
                                                                <div class="modal-footer">
                                                                    {!! Form::open(['url' => 'library/general/suppliers/' . $supplier->id]) !!}
                                                                    {!! Form::hidden('_method', 'DELETE') !!}
                                                                    {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
                                                                    {!! Form::close() !!}
                                                                    <button type="button" class="btn btn-default"
                                                                        data-dismiss="modal">Cancel</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!--Edit Form Here-->
                                                    <div class="modal fade" id="edit-modal{!! $supplier->id !!}"
                                                        role="dialog">
                                                        <div class="modal-dialog modal-lg ">
                                                            <!-- Modal content-->
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h4 class="modal-title">Edit supplier Information,
                                                                        Name: {!! $supplier->name !!}</h4>
                                                                    <button type="button" class="close"
                                                                        data-dismiss="modal" aria-label="Close"><span
                                                                            aria-hidden="true">&times;</span></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    {!! Form::open(['url' => 'library/general/suppliers/' . $supplier->id]) !!}
                                                                    {!! Form::hidden('_method', 'PATCH') !!}
                                                                    @if (!empty(Session::get('error_code')) && Session::get('error_code') == $supplier->id)
                                                                        @include('layout/flash-message')
                                                                    @endif
                                                                    <div class="row" style="padding-left: 0px; padding-right: 0px;">
                                                                        <div class="col-md-4">
                                                                            <div class="form-group">
                                                                                <label for="Name">Name</label>
                                                                                <input type="text" value="{{ $supplier->name }}" placeholder="Name" name="name" class="form-control">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <div class="form-group">
                                                                                <label for="Name">Company</label>
                                                                                <select name="company_id" id="" class="form-control">
                                                                                    @foreach($companies as $company)
                                                                                    <option {{ $supplier->company_id==$company->id?"selected":""}} value="{{ $company->id }}">{{ $company->Name }}</option>
                                                                                    @endforeach
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <div class="form-group">
                                                                                <label for="Phone">Phone</label>
                                                                                <input type="text" value="{{ $supplier->phone }}" placeholder="Phone" name="Phone" class="form-control">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <div class="form-group">
                                                                                <label for="Email">Email</label>
                                                                                <input type="email" value="{{ $supplier->email }}" placeholder="Email" name="Email" class="form-control">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <div class="form-group">
                                                                                <label for="Address">Address</label>
                                                                                <input type="text" value="{{ $supplier->address }}" placeholder="Address" name="Address" class="form-control">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <div class="form-group">
                                                                                <label for="Contact Person">Contact Person</label>
                                                                                <input type="text" value="{{ $supplier->contact_person }}" placeholder="Contact Person" name="Contact_Person" class="form-control">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <div class="form-group">
                                                                                <label for="Contact Person Mobile">Contact Person Mobile</label>
                                                                                <input type="text" value="{{ $supplier->cp_mobile }}" placeholder="Contact Person" name="cp_mobile" class="form-control">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <div class="form-group">
                                                                                <label for="C4S">Status</label>
                                                                                <div class="controls">
                                                                                    <select name="status" id="" class="form-control">
                                                                                        <option {{ $supplier->status==1?"selected":""}} value="1">Active</option>
                                                                                        <option {{ $supplier->status==0?"selected":""}}  value="0">Inactive</option>
                                                                                    </select>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    {!! Form::submit('Update', ['class' => 'btn btn-success']) !!}
                                                                    {!! Form::close() !!}
                                                                    <button type="button" class="btn btn-default"
                                                                        data-dismiss="modal">Cancel</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @if (!empty(Session::get('error_code')) && Session::get('error_code') == $supplier->id)
                                                        <script>
                                                            $(function() {
                                                                $('#edit-modal{{ $supplier->id }}').modal('show');
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

@stop
