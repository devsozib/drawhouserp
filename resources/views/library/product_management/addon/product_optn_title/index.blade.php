@extends('layout.app')
@section('title', 'Library | Company')
@section('content')
    @include('layout/datatable')

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"><small>Product Option Title</small></h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{!! url('library/dashboard') !!}">Library</a></li>
                        <li class="breadcrumb-item"><a href="javascript::void(0)">Product Mangement</a></li>
                        <li class="breadcrumb-item"><a href="javascript::void(0)">Product Option title</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Index</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header with-border">
                        <h3 class="card-title text-center w-75">Add Option title of
                            <span class="text-primary">{{ $product->name }}</span>
                        </h3>
                    </div>
                    <div class="card-body" style="overflow-x: scroll;">
                        <div class="row">
                            <div class="col-lg-12">
                                <form action="{{ route('proopttitle.store') }}" method="post"
                                    enctype="multipart/form-data">
                                    @if (!empty(Session::get('error_code')) && Session::get('error_code') == 'Add')
                                        @include('layout/flash-message')
                                    @endif
                                    @csrf
                                    {{-- {{ $errors }} --}}
                                    <div class="card-body">
                                        <input type="hidden" value="{{ $product->id }}" name="product_id">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="Name">Product Name</label>
                                                    <input type="text" value="{{ $product->name }}" readonly
                                                        class="form-control">
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="Name">Select Product Size</label>
                                                    </label>
                                                    <select name="sizeId" id="selectedSize"
                                                        onchange="getTitles(this.value,{{ $product->id }})"
                                                        class="form-control">
                                                        <option value="" selected disabled hidden>--Select
                                                            One--</option>
                                                        @foreach ($sizes as $item)
                                                            <option value="{{ $item->id }}">{{ $item->size_name }}
                                                            </option>
                                                        @endforeach

                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="C4S">Select Option Type</label>
                                                    <div class="controls">
                                                        <select name="option_type" id="" class="form-control">
                                                            <option value="" selected disabled hidden>--Select
                                                                One--</option>
                                                            <option value="radio">Radio</option>
                                                            <option value="checkbox">Checkbox</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="Name">Title Name</label>
                                                    <input type="text" name="title_name" placeholder="Title name"
                                                        class="form-control" value="{{ old('title_name') }}">
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="C4S">Status</label>
                                                    <div class="controls">
                                                        <select name="status" id="" class="form-control">
                                                            <option value="" selected disabled hidden>--Select
                                                                One--</option>
                                                            <option value="1">Active</option>
                                                            <option value="0">Inactive</option>
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
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header with-border">
                        <h3 class="card-title w-75">Add Product Option</h3>
                    </div>
                    <div class="card-body">
                        Are you want to add product option for <span class="text-primary">{{ $product->name }}</span>
                        addons?<br />
                        <a href="{{ route('prooption.indx', $product->id) }}" class="btn btn-primary mt-2">Click
                            Here</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header with-border">
                        <h3 class="card-title text-center w-75">Size List</h3>
                    </div>
                    <div class="card-body" style="overflow-x: scroll;">
                        <div class="row">
                            <div class="col-lg-12">
                                <div style="min-height: 400px;">
                                    <table class="table table-bordered table-striped datatbl" id="branchTable">
                                        <thead>
                                            <tr>
                                                <th>Sl No</th>
                                                <th>Product Name</th>
                                                <th>Product Size Name</th>
                                                <th>Option Title</th>
                                                <th>Option Type</th>
                                                <th>Status</th>
                                                <th>Option</th>
                                            </tr>
                                        </thead>
                                        <tbody>

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

    <script type="text/javascript">
        function getTitles(id, productId) {
            var selectedSize = id;
            var productId = productId;
            if (selectedSize && productId) {
                $.ajax({
                    url: '{{ url('getprooptntitle') }}',
                    type: 'GET',
                    // dataType: 'json',
                    data: {
                        'selectedSizeId': selectedSize,
                        'productId': productId
                    },
                    success: function(data) {
                        console.log(data);
                        $('#branchTable').html(data);
                        if ($.fn.DataTable.isDataTable("#branchTable")) {
                            $('#branchTable').DataTable().clear().destroy();
                        }
                    }
                });
            }
        }
    </script>
@stop
