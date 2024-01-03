@extends('layout.app')
@section('title', 'Library | Company')
@section('content')
    @include('layout/datatable')

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"><small>Edit Product Option Title</small></h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{!! url('library/dashboard') !!}">Library</a></li>
                        <li class="breadcrumb-item"><a href="javascript::void(0)">Product Mangement</a></li>
                        <li class="breadcrumb-item"><a href="javascript::void(0)">Edit Product Option title</a></li>
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
                        <h3 class="card-title text-center w-75">Edit Option title of
                            <span class="text-primary">{{ $proOptnTitle->title }}</span>
                        </h3>
                    </div>
                    <div class="card-body" style="overflow-x: scroll;">
                        <div class="row">
                            <div class="col-lg-12">
                                <form action="{{ route('proopttitle.update') }}" method="post"
                                    enctype="multipart/form-data">
                                    @if (!empty(Session::get('error_code')) && Session::get('error_code') == 'Update')
                                        @include('layout/flash-message')
                                    @endif
                                    @csrf
                                    @method('PATCH')
                                    {{-- {{ $errors }} --}}
                                    <div class="card-body">
                                        <input type="hidden" value="{{ $proOptnTitle->id }}" name="title_id">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="Name">Product Name</label>
                                                    <input type="text" value="{{ $proOptnTitle->name }}" readonly
                                                        class="form-control">
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="Name">Select Product Size</label>
                                                    </label>
                                                    <input type="text" value="{{ $proOptnTitle->size_name }}" readonly
                                                        class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="C4S">Select Option Type</label>
                                                    <div class="controls">
                                                        <select name="option_type" id="" class="form-control">
                                                            <option value="" selected disabled hidden>--Select
                                                                One--</option>
                                                            <option
                                                                {{ $proOptnTitle->option_type == 'radio' ? 'selected' : '' }}
                                                                value="radio">
                                                                Radio</option>
                                                            <option
                                                                {{ $proOptnTitle->option_type == 'checkbox' ? 'selected' : '' }}
                                                                value="checkbox">Checkbox</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="Name">Title Name</label>
                                                    <input type="text" name="title_name" placeholder="Title name"
                                                        class="form-control" value="{{ $proOptnTitle->title }}">
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="C4S">Status</label>
                                                    <div class="controls">
                                                        <select name="status" id="" class="form-control">
                                                            <option value="" selected disabled hidden>--Select
                                                                One--</option>
                                                            <option {{ $proOptnTitle->status == '1' ? 'selected' : '' }}
                                                                value="1">Active</option>
                                                            <option {{ $proOptnTitle->status == '0' ? 'selected' : '' }}
                                                                value="0">Inactive</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <button type="submit" class="btn btn-success float-right">Submit</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>

    <script type="text/javascript"></script>
@stop
