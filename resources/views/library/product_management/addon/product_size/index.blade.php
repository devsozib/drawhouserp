@extends('layout.app')
@section('title', 'Library | Company')
@section('content')
    @include('layout/datatable')

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"><small>Product Sizes</small></h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{!! url('library/dashboard') !!}">Library</a></li>
                        <li class="breadcrumb-item"><a href="javascript::void(0)">Product Mangement</a></li>
                        <li class="breadcrumb-item"><a href="javascript::void(0)">Product Size</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Index</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    @php
        $sizeItems = '';
        if (count($productSizes) > 0) {
            $sizeItems = count($productSizes);
        } else {
            $sizeItems = '';
        }

    @endphp
    <div class="content">
        <div class="row">
            <div class="{{ $sizeItems < 0 ? 'col-lg-12' : 'col-lg-8' }}">
                <div class="card">
                    <div class="card-header with-border">
                        <h3 class="card-title text-center w-75">Add Size of
                            <span class="text-primary">{{ $product->name }}</span>
                        </h3>
                    </div>
                    <div class="card-body" style="overflow-x: scroll;">
                        <div class="row">
                            <div class="col-lg-12">
                                <form action="{{ route('productsize.store') }}" method="post"
                                    enctype="multipart/form-data">
                                    @if (!empty(Session::get('error_code')) && Session::get('error_code') == 'Add')
                                        @include('layout/flash-message')
                                    @endif
                                    @csrf
                                    {{-- {{ $errors }} --}}
                                    <div class="card">
                                        <div class="card-body">
                                            <input type="hidden" value="{{ $product->id }}" name="product_id">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="Name">Product Name</label>
                                                        <input type="text" value="{{ $product->name }}" readonly
                                                            class="form-control">
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="Name">Size Name
                                                        </label>
                                                        <input type="text" placeholder="Size Name" name="size_name"
                                                            class="form-control">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="Name">Product Selling Price
                                                        </label>
                                                        <input type="number" placeholder="Selling Price" name="sell_price"
                                                            class="form-control">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="Name">Special Price
                                                        </label>
                                                        <input type="number" placeholder="Special Price" name="sp_price"
                                                            class="form-control">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="Name">Offer Start Date
                                                        </label>
                                                        <input type="text" name="start_date" placeholder="Start Date"
                                                            id="start_date" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="Name">Offer End Date
                                                        </label>
                                                        <input type="text" placeholder="End Date" name="end_date"
                                                            id="end_date" class="form-control">
                                                    </div>
                                                </div>
                                                @if(in_array(2,explode(",",$product->sales_type)))
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="C4S">Wholesale Price</label>
                                                        <div class="controls">
                                                            <input type="number" placeholder="Wholesale Price" name="wholesale_price"
                                                            class="form-control">
                                                        </div>
                                                    </div>
                                                </div>
                                                @endif
                                                @if(in_array(3,explode(",",$product->sales_type)))
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="C4S">Corporate Price</label>
                                                        <div class="controls">
                                                            <input type="number" placeholder="Corporate Price" name="corporate_price"
                                                            class="form-control">
                                                        </div>
                                                    </div>
                                                </div>
                                                @endif
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="C4S">Status</label>
                                                        <div class="controls">
                                                            <select name="status" id="" class="form-control">
                                                                <option value="" selected disabled hidden>--Select
                                                                    One--</option>
                                                                <option value="1" selected>Active</option>
                                                                <option value="0">Inactive</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <button type="submit" class="btn btn-success float-right">Submit</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="{{ $sizeItems < 0 ? 'd-none col-lg-4' : 'col-lg-4 d-block' }}">
                <div class="card">
                    <div class="card-header with-border">
                        <h3 class="card-title w-75">Add Ingredient Product</h3>
                    </div>
                    <div class="card-body">
                        Are you want to add ingredient for <span class="text-primary">{{ $product->name }}</span>
                        addons?<br />
                        <a href="{{ route('producting.index', $product->id) }}" class="btn btn-primary mt-2">Click
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
                                    <table class="table table-bordered table-striped datatbl" id="usertbl">
                                        <thead>
                                            <tr>
                                                <th>Sl No</th>
                                                <th>Size Name</th>
                                                <th>Selling Price</th>
                                                <th>Special Price</th>
                                                <th>Special Price Starts</th>
                                                <th>Special Price Ends</th>
                                                <th>Wholesale Price</th>
                                                <th>Corporate Price</th>
                                                <th>Status</th>
                                                <th>Option</th>
                                            </tr>
                                        </thead>
                                        <tbody>


                                            @foreach ($productSizes as $item)
                                                <tr>
                                                    <td>{{ $loop->index + 1 }}</td>
                                                    <td>{!! $item->size_name !!}</td>
                                                    <td>{!! $item->selling_price !!} BDT</td>
                                                    <td>{!! $item->special_price ? $item->special_price . 'BDT' : 'N/A' !!}</td>
                                                    <td>{!! $item->special_price_from ? $item->special_price_from : 'N/A' !!}</td>
                                                    <td>{!! $item->special_price_to ? $item->special_price_to : 'N/A' !!}</td>
                                                    <td>{!! $item->wholesale_price ? $item->wholesale_price : 'N/A' !!}</td>
                                                    <td>{!! $item->corporate_price ? $item->corporate_price : 'N/A' !!}</td>
                                                    <td class="text-{{ $item->status == 1 ? 'success' : 'danger' }}">
                                                        {{ $item->status == 1 ? 'Active' : 'Inactive' }}</td>
                                                    <td>
                                                        @if ($edit)
                                                            <a role="button" data-toggle="modal"
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

                                                        <!--Delete-->
                                                        <div class="modal fade" id="delete-modal{!! $item->id !!}"
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
                                                                        Are you sure you want to delete this Company:
                                                                        <strong
                                                                            style="color: darkorange">{{ $item->size_name }}</strong>
                                                                        ?
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <form
                                                                            action="{{ route('productsize.delete', $item->id) }}"
                                                                            method="post">
                                                                            @csrf
                                                                            @method('delete')
                                                                            <button type="submit"
                                                                                class="btn btn-default">Delete</button>
                                                                        </form>
                                                                        <button type="button" class="btn btn-default"
                                                                            data-dismiss="modal">Cancel</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!--Edit Form Here-->
                                                        <div class="modal fade" id="edit-modal{!! $item->id !!}"
                                                            role="dialog">
                                                            <div class="modal-dialog modal-lg ">
                                                                <!-- Modal content-->
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h4 class="modal-title">Edit Product Size:
                                                                            {!! $item->size_name !!}</h4>
                                                                        <button type="button" class="close"
                                                                            data-dismiss="modal" aria-label="Close"><span
                                                                                aria-hidden="true">&times;</span></button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <form action="{{ route('productsize.update') }}"
                                                                            method="post">
                                                                            @method('PATCH')
                                                                            @csrf
                                                                            <div class="row">
                                                                                <input type="hidden"
                                                                                    value="{{ $item->product_id }}"
                                                                                    name="product_id">
                                                                                <input type="hidden"
                                                                                    value="{{ $item->id }}"
                                                                                    name="size_id">
                                                                                <div class="col-md-4">
                                                                                    <div class="form-group">
                                                                                        <label for="Name">Size
                                                                                            Name</label>
                                                                                        <input type="text"
                                                                                            value="{{ $item->size_name }}"
                                                                                            placeholder="Size Name"
                                                                                            name="size_name"
                                                                                            class="form-control">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-4">
                                                                                    <div class="form-group">
                                                                                        <label for="Name">Selling Price
                                                                                        </label>
                                                                                        <input type="number"
                                                                                            placeholder="Sell Price"
                                                                                            name="sell_price"
                                                                                            class="form-control"
                                                                                            value="{{ $item->selling_price }}">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-4">
                                                                                    <div class="form-group">
                                                                                        <label for="Name">Special Price
                                                                                        </label>
                                                                                        <input type="number"
                                                                                            placeholder="Offer Price"
                                                                                            name="sp_price"
                                                                                            class="form-control"
                                                                                            value="{{ $item->special_price }}">
                                                                                    </div>
                                                                                </div>

                                                                                <div class="col-md-4">
                                                                                    <div class="form-group">
                                                                                        <label for="Name">Special Start
                                                                                            Date
                                                                                        </label>
                                                                                        <input type="text"
                                                                                            name="start_date"
                                                                                            placeholder="Start Date"
                                                                                            id="u_start_date"
                                                                                            class="form-control"
                                                                                            value="{{ $item->special_price_from }}">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-4">
                                                                                    <div class="form-group">
                                                                                        <label for="Name">Offer End
                                                                                            Date
                                                                                        </label>
                                                                                        <input type="text"
                                                                                            placeholder="End Date"
                                                                                            name="end_date"
                                                                                            id="u_end_date"
                                                                                            class="form-control"
                                                                                            value="{{ $item->special_price_to }}">
                                                                                    </div>
                                                                                </div>



                                                                                @if(in_array(2,explode(",",$product->sales_type)))
                                                                                <div class="col-md-4">
                                                                                    <div class="form-group">
                                                                                        <label for="C4S">Wholesale Price</label>
                                                                                        <div class="controls">
                                                                                            <input type="number"  value="{{  $item->wholesale_price }}" placeholder="Wholesale Price" name="u_wholesale_price"
                                                                                            class="form-control">
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                @endif
                                                                                @if(in_array(3,explode(",",$product->sales_type)))
                                                                                <div class="col-md-4">
                                                                                    <div class="form-group">
                                                                                        <label for="C4S">Corporate Price</label>
                                                                                        <div class="controls">
                                                                                            <input type="number" value="{{  $item->corporate_price }}" placeholder="Corporate Price" name="u_corporate_price"
                                                                                            class="form-control">
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                @endif



                                                                                <div class="col-md-4">
                                                                                    <div class="form-group">
                                                                                        <label
                                                                                            for="C4S">Status</label>
                                                                                        <div class="controls">
                                                                                            <select name="status"
                                                                                                id=""
                                                                                                class="form-control">
                                                                                                <option
                                                                                                    {{ $item->status == 1 ? 'selected' : '' }}
                                                                                                    value="1">Active
                                                                                                </option>
                                                                                                <option
                                                                                                    {{ $item->status == 0 ? 'selected' : '' }}
                                                                                                    value="0">Inactive
                                                                                                </option>
                                                                                            </select>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="modal-footer">
                                                                                <button type="submit"
                                                                                    class="btn btn-success">Update</button>
                                                                                <button type="button"
                                                                                    class="btn btn-default"
                                                                                    data-dismiss="modal">Cancel</button>
                                                                            </div>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @if (!empty(Session::get('error_code')))
                                                            <script>
                                                                $(function() {
                                                                    $('#edit-modal{{ $item->id }}').modal('show');
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
    </script>
@stop



