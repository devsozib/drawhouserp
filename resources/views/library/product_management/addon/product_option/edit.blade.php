@extends('layout.app')
@section('title', 'Library | Company')
@section('content')
    @include('layout/datatable')

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"><small>Edit Product Option</small></h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{!! url('library/dashboard') !!}">Library</a></li>
                        <li class="breadcrumb-item"><a href="javascript::void(0)">Product Mangement</a></li>
                        <li class="breadcrumb-item"><a href="javascript::void(0)">Edit Product Option</a></li>
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
                        <h3 class="card-title text-center w-75">Edit Option of
                            <span class="text-primary">{{ $proOption->name }}</span>
                        </h3>
                    </div>
                    <div class="card-body" style="overflow-x: scroll;">
                        <div class="row">
                            <div class="col-lg-12">
                                <form action="{{ route('prooption.update') }}" method="post" enctype="multipart/form-data">
                                    @if (!empty(Session::get('error_code')) && Session::get('error_code') == 'Update')
                                        @include('layout/flash-message')
                                    @endif
                                    @csrf
                                    @method('PATCH')
                                    {{-- {{ $errors }} --}}
                                    <div class="card-body">
                                        <input type="hidden" value="{{ $proOption->id }}" name="pro_option_id">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="Name">Product Name</label>
                                                    <input type="text" value="{{ $proOption->product_name }}" readonly
                                                        class="form-control">
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="Name">Product Size</label>
                                                    </label>
                                                    <input type="text" value="{{ $proOption->size_name }}" readonly
                                                        class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="Name">Product Option Title</label>
                                                    </label>
                                                    <input type="text" value="{{ $proOption->title }}" readonly
                                                        class="form-control">
                                                </div>
                                            </div>


                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="Name">Option Name</label>
                                                    <input type="text" name="name" placeholder="Option name"
                                                        class="form-control" value="{{ $proOption->name }}">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="Name">Extra Price
                                                    </label>
                                                    <input type="number" placeholder="Extra Price" name="ex_price"
                                                        class="form-control" value="{{ $proOption->extra_price }}">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="Name">Offer Price
                                                    </label>
                                                    <input type="number" placeholder="Offer Price" name="off_price"
                                                        class="form-control" value="{{ $proOption->offer_price }}">
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="Name">Offer Start
                                                        Date
                                                    </label>
                                                    <input type="text" name="start_date" placeholder="Start Date"
                                                        id="u_start_date" class="form-control"
                                                        value="{{ $proOption->offer_money_from }}">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="Name">Offer End
                                                        Date
                                                    </label>
                                                    <input type="text" placeholder="End Date" name="end_date"
                                                        id="u_end_date" class="form-control"
                                                        value="{{ $proOption->offer_money_to }}">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="C4S">Status</label>
                                                    <div class="controls">
                                                        <select name="status" id="" class="form-control">
                                                            <option value="" selected disabled hidden>--Select
                                                                One--</option>
                                                            <option {{ $proOption->status == '1' ? 'selected' : '' }}
                                                                value="1">Active</option>
                                                            <option {{ $proOption->status == '0' ? 'selected' : '' }}
                                                                value="0">Inactive</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="Name">Addon Image
                                                    </label>
                                                    <input type="file" class="form-control" name="image"
                                                        id="file-input">
                                                </div>
                                            </div>
                                            <div class="col-md-4" id="image_sec">
                                                <div class="form-group">
                                                    {{-- <label for="Name">Ingredient Image</label> --}}
                                                    <img style="width:200px; border-radius:10px" id="image-preview"
                                                        src="{{ url('public/option_images/', $proOption->image) }}"
                                                        alt="Preview">
                                                </div>
                                            </div>

                                        </div>
                                        <button type="submit" class="btn btn-success float-right">Update</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        $('#start_date').dateTimePicker({
            mode: 'dateTime',
            format: 'yyyy-MM-dd HH:mm:ss'
        });
        $('#end_date').dateTimePicker({
            mode: 'dateTime',
            format: 'yyyy-MM-dd HH:mm:ss'
        });
        $('#u_start_date').dateTimePicker({
            mode: 'dateTime',
            format: 'yyyy-MM-dd HH:mm:ss'
        });
        $('#u_end_date').dateTimePicker({
            mode: 'dateTime',
            format: 'yyyy-MM-dd HH:mm:ss'
        });

        $('#file-input').change(function() {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#image_sec').removeClass('d-none');
                $('#image-preview').attr('src', e.target.result);
            }
            reader.readAsDataURL(this.files[0]);
        })
    </script>
@stop
