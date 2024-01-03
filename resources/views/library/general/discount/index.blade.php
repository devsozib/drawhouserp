@extends('layout.app')
@section('title', 'HRIS | Table')
@section('content')
@include('layout/datatable')

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Discount Category</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{!! url('library/dashboard') !!}">Library</a></li>
                        <li class="breadcrumb-item"><a href="javascript::void(0)">General</a></li>
                        <li class="breadcrumb-item"><a href="{!! url('library/general/table') !!}">Discount Category</a></li>
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
                            <h3 class="card-title text-center w-75">Discount Category List</h3>
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
                                                <h4 class="modal-title">Add Discount Category</h4>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            </div>
                                            <div class="modal-body">
                                                {!! Form::open([
                                                    'action' => ['\App\Http\Controllers\Library\General\DiscountCategoryController@store', 'method' => 'Post'],
                                                ]) !!}
                                                @if (!empty(Session::get('error_code')) && Session::get('error_code') == 'Add')
                                                    @include('layout/flash-message')
                                                @endif
                                                <div class="row" style="padding-left: 0px; padding-right: 0px;">
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="company_id">Company Name</label>
                                                            <div class="controls">
                                                                {!! Form::select('company_id', $comp_arr, null, [
                                                                    'required',
                                                                    'class' => 'form-control select2bs4',
                                                                    'id' => 'company_id',
                                                                    'placeholder' => 'Select One',
                                                                    'value' => Input::old('company_id'),
                                                                ]) !!}
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="Table">Category name</label>
                                                            <div class="controls">
                                                                {!! Form::text('category_name', null, [
                                                                    'required',
                                                                    'class' => 'form-control',
                                                                    'id' => 'category_name',
                                                                    'maxlength' => '100',
                                                                    'placeholder' => 'Category name',
                                                                    'value' => Input::old('name'),
                                                                ]) !!}
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="Table">Discount Type</label>
                                                            <div class="controls">
                                                                {!! Form::select('discount_type', discountCategory(), null, [
                                                                    'required',
                                                                    'class' => 'form-control select2bs4',
                                                                    'id' => 'discount_type',
                                                                    'placeholder' => 'Select One',
                                                                    'value' => Input::old('discount_type'),
                                                                ]) !!}
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="Table">Amount</label>
                                                            <div class="controls">
                                                                {!! Form::number('amount', null, [
                                                                    'required',
                                                                    'class' => 'form-control',
                                                                    'id' => 'amount',
                                                                    'maxlength' => '100',
                                                                    'placeholder' => 'Amount',
                                                                    'value' => Input::old('amount'),
                                                                ]) !!}
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="status">Status</label>
                                                            <div class="controls">
                                                                {!! Form::select('status', getStatus(2), null, [
                                                                    'required',
                                                                    'class' => 'form-control',
                                                                    'id' => 'status',
                                                                    'placeholder' => 'Select One',
                                                                    'value' => Input::old('status'),
                                                                ]) !!}
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
                                        <table class="table table-bordered table-striped datatbl" id="usertbl">
                                            <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Company Name</th>
                                                    <th>Category Name</th>
                                                    <th>Discount Type</th>
                                                    <th>Amount</th>
                                                    <th>Status</th>
                                                    <th style="width: 120px;">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($categories as $category)
                                                    <tr>
                                                        <td>{!! $category->id !!}</td>
                                                        <td>{!! $comp_arr[$category->company_id] !!}</td>
                                                        <td>{!! $category->category_name !!}</td>
                                                        <td>{!! discountCategory()[$category->discount_type] !!}</td>
                                                        <td>{!! $category->amount !!}</td>
                                                        <td>{!! getC4S($category->status) !!}</td>
                                                        <td>
                                                            @if ($edit)
                                                                <a role="button" data-toggle="modal"
                                                                    data-target="#edit-modal{{ $category->id }}"
                                                                    class="btn-sm bg-gradient-info" title="Edit"><i
                                                                        class="fas fa-edit"></i></a>
                                                            @endif
                                                            @if ($delete)
                                                                <a role="button" data-toggle="modal"
                                                                    data-target="#delete-modal{{ $category->id }}"
                                                                    class="btn-sm bg-gradient-danger" title="Delete"><i
                                                                        class="fas fa-times"></i></a>
                                                            @endif

                                                            <!--Delete-->
                                                            <div class="modal fade"
                                                                id="delete-modal{!! $category->id !!}" role="dialog">
                                                                <div class="modal-dialog modal-md">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h4 class="modal-title">Warning!!!</h4>
                                                                            <button type="button" class="close"
                                                                                data-dismiss="modal"
                                                                                aria-label="Close"><span
                                                                                    aria-hidden="true">&times;</span></button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            Are you sure you want to delete this Table:
                                                                            <strong
                                                                                style="color: darkorange">{{ $category->category_name }}</strong>
                                                                            ?
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            {!! Form::open(['url' => 'library/general/discount_category/' . $category->id]) !!}
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
                                                            <div class="modal fade"
                                                                id="edit-modal{!! $category->id !!}" role="dialog">
                                                                <div class="modal-dialog modal-lg ">
                                                                    <!-- Modal content-->
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h4 class="modal-title">Edit Discount Category,
                                                                                Category: {!! $category->category_name !!}</h4>
                                                                            <button type="button" class="close"
                                                                                data-dismiss="modal"
                                                                                aria-label="Close"><span
                                                                                    aria-hidden="true">&times;</span></button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            {!! Form::open(['url' => 'library/general/discount_category/' . $category->id]) !!}
                                                                            {!! Form::hidden('_method', 'PATCH') !!}
                                                                            @if (!empty(Session::get('error_code')) && Session::get('error_code') == $user->id)
                                                                                @include('layout/flash-message')
                                                                            @endif
                                                                            <div class="row"
                                                                                style="padding-left: 0px; padding-right: 0px;">
                                                                                <div class="col-md-4">
                                                                                    <div class="form-group">
                                                                                        <label for="company_id">Company
                                                                                            Name</label>
                                                                                        <div class="controls">
                                                                                            {!! Form::select('company_id', $comp_arr, $category->company_id, [
                                                                                                'required',
                                                                                                'class' => 'form-control select2bs4',
                                                                                                'id' => 'company_id',
                                                                                                'placeholder' => 'Select One',
                                                                                                'value' => Input::old('company_id'),
                                                                                            ]) !!}
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-4">
                                                                                    <div class="form-group">
                                                                                        <label for="name">Category Name</label>
                                                                                        <div class="controls">
                                                                                            {!! Form::text('category_name', $category->category_name, [
                                                                                                'required',
                                                                                                'class' => 'form-control',
                                                                                                'id' => 'category_name',
                                                                                                'maxlength' => '100',
                                                                                                'placeholder' => 'Category name',
                                                                                                'value' => Input::old('category_name'),
                                                                                            ]) !!}
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-4">
                                                                                    <div class="form-group">
                                                                                        <label for="name">Discount Type</label>
                                                                                        <div class="controls">
                                                                                            {!! Form::select('discount_type', discountCategory(), $category->discount_type, [
                                                                                                'required',
                                                                                                'class' => 'form-control select2bs4',
                                                                                                'id' => 'discount_type',
                                                                                                'placeholder' => 'Select One',
                                                                                                'value' => Input::old('discount_type'),
                                                                                            ]) !!}
                                                                                        </div>
                                                                                    </div>
                                                                                </div>

                                                                                <div class="col-md-4">
                                                                                    <div class="form-group">
                                                                                        <label for="Table">Amount</label>
                                                                                        <div class="controls">
                                                                                            {!! Form::number('amount', $category->amount, [
                                                                                                'required',
                                                                                                'class' => 'form-control',
                                                                                                'id' => 'amount',
                                                                                                'maxlength' => '100',
                                                                                                'placeholder' => 'Amount',
                                                                                                'value' => Input::old('amount'),
                                                                                            ]) !!}
                                                                                        </div>
                                                                                    </div>
                                                                                </div>

                                                                                <div class="col-md-3">
                                                                                    <div class="form-group">
                                                                                        <label for="status">Is
                                                                                            Active?</label>
                                                                                        <div class="controls">
                                                                                            {!! Form::select('status', getStatus(2), $category->status, [
                                                                                                'required',
                                                                                                'class' => 'form-control',
                                                                                                'id' => 'status',
                                                                                                'placeholder' => 'Select One',
                                                                                                'value' => Input::old('status'),
                                                                                            ]) !!}
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
                                                            @if (!empty(Session::get('error_code')) && Session::get('error_code') == $category->id)
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
        </div>

    @stop
