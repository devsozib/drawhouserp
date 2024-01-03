@extends('layout.app')
@section('title', 'Library | Company')
@section('content')
    @include('layout/datatable')

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"><small>Product Option Ingredients Edit</small>
                    </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{!! url('library/dashboard') !!}">Library</a></li>
                        <li class="breadcrumb-item"><a href="javascript::void(0)">Product Mangement</a></li>
                        <li class="breadcrumb-item"><a href="javascript::void(0)">Product Option Ingredients</a>
                        </li>
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
                        <h3 class="card-title text-center w-75">Edit Product Ingredient of
                            {{ $productOptnIng->option_name }}</h3>
                    </div>
                    <div class="card-body" style="overflow-x: scroll;">
                        <div class="row">
                            <div class="col-lg-12">
                                <form action="{{ route('prooptioning.update') }}" method="post"
                                    enctype="multipart/form-data">
                                    @if (!empty(Session::get('error_code')) && Session::get('error_code') == 'Update')
                                        @include('layout/flash-message')
                                    @endif
                                    @csrf
                                    @method('patch')
                                    {{-- {{ $errors }} --}}
                                    <div class="card">
                                        <div class="card-body">
                                            <input type="hidden" value="{{ $productOptnIng->id }}" name="ing_id">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="Name">Product Name</label>
                                                        <input type="text" value="{{ $productOptnIng->product_name }}"
                                                            readonly class="form-control">
                                                    </div>
                                                </div>

                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="Name">Product Size</label>
                                                        </label>
                                                        <input type="text" value="{{ $productOptnIng->size_name }}"
                                                            readonly class="form-control">
                                                    </div>
                                                </div>

                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="Name">Product Option Title</label>
                                                        </label>
                                                        <input type="text" value="{{ $productOptnIng->title }}" readonly
                                                            class="form-control">
                                                    </div>
                                                </div>

                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="Name">Product Option</label>
                                                        </label>
                                                        <input type="text" value="{{ $productOptnIng->option_name }}"
                                                            readonly class="form-control">
                                                    </div>
                                                </div>


                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="Name">Ingredient</label>
                                                        </label>
                                                        <input type="text" value="{{ $productOptnIng->ing_name }}"
                                                            readonly class="form-control">
                                                    </div>
                                                </div>

                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="Name">Ingredient Amount</label>
                                                        </label>
                                                        <input type="number" name="amount"
                                                            value="{{ $productOptnIng->amount }}" class="form-control">
                                                    </div>
                                                </div>


                                            </div>
                                            <button type="submit" class="btn btn-success float-right">Update</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

@stop
