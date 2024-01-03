@extends('layout.app')
@section('title', 'Library | Company')
@section('content')
    @include('layout/datatable')

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"><small>Sub Category Addons</small></h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{!! url('library/dashboard') !!}">Library</a></li>
                        <li class="breadcrumb-item"><a href="javascript::void(0)">Product Mangement</a></li>
                        <li class="breadcrumb-item"><a href="javascript::void(0)">Sub Category Addons</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Index</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    @php
        $addontItems = '';
        if (count($subCategoryAddons) > 0) {
            $addontItems = count($subCategoryAddons);
        } else {
            $addontItems = '';
        }
        
    @endphp
    <div class="content">
        <div class="row">
            <div class="{{ $addontItems < 0 ? 'col-lg-12' : 'col-lg-8' }}">
                <div class="card">
                    <div class="card-header with-border">
                        <h3 class="card-title text-center w-75">Add Sub Category Addon of
                            {{ $subCategory->name }}</h3>
                    </div>
                    <div class="card-body" style="overflow-x: scroll;">
                        <div class="row">
                            <div class="col-lg-12">
                                <form action="{{ route('sca.store') }}" method="post" enctype="multipart/form-data">
                                    @if (!empty(Session::get('error_code')) && Session::get('error_code') == 'Add')
                                        @include('layout/flash-message')
                                    @endif
                                    @csrf
                                    {{-- {{ $errors }} --}}
                                    <div class="card">
                                        <div class="card-body">
                                            <input type="hidden" value="{{ $subCategory->id }}" name="sub_cat_id">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="Name">Sub Category Name</label>
                                                        <input type="text" value="{{ $subCategory->name }}" readonly
                                                            class="form-control">
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="Name">Addon Name
                                                        </label>
                                                        <input type="text" placeholder="Name" name="addon_name"
                                                            class="form-control">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="Name">Extra Price
                                                        </label>
                                                        <input type="number" placeholder="Extra Price" name="ex_price"
                                                            class="form-control">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="Name">Offer Price
                                                        </label>
                                                        <input type="number" placeholder="Offer Price" name="off_price"
                                                            class="form-control">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="Name">Offer Start Date
                                                        </label>
                                                        <input type="text" name="start_price" placeholder="Start Date"
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
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="C4S">Is Active?</label>
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
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="Name">Addon Image</label>
                                                        <input type="file" name="image" id="file-input"
                                                            class="form-control">
                                                    </div>
                                                </div>
                                                <div class="col-md-4 d-none" id="image_sec">
                                                    <div class="form-group">
                                                        {{-- <label for="Name">Ingredient Image</label> --}}
                                                        <img style="width:200px; border-radius:10px" id="image-preview"
                                                            src="#" alt="Preview">
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
            <div class="{{ $addontItems < 0 ? 'd-none col-lg-4' : 'col-lg-4 d-block' }}">
                <div class="card">
                    <div class="card-header with-border">
                        <h3 class="card-title w-75">Add Ingredient for Sub Category Addon</h3>
                    </div>
                    <div class="card-body">
                        Are you want to add ingredient for <span class="text-primary">{{ $subCategory->name }}</span>
                        addons?<br />
                        <a href="{{ route('sca_ing.index', encrypt($subCategory->id)) }}"
                            class="btn btn-primary mt-2">Click Here</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header with-border">
                        <h3 class="card-title text-center w-75">Addons List</h3>
                    </div>
                    <div class="card-body" style="overflow-x: scroll;">
                        <div class="row">
                            <div class="col-lg-12">
                                <div style="min-height: 400px;">
                                    <table class="table table-bordered table-striped datatbl" id="usertbl">
                                        <thead>
                                            <tr>
                                                <th>Sl No</th>
                                                <th>Image</th>
                                                <th>Addon Name</th>
                                                <th>Extra Price</th>
                                                <th>Offer Price</th>
                                                <th>Offer Price Starts</th>
                                                <th>Offer Price Ends</th>
                                                <th>Status</th>
                                                <th>Option</th>
                                            </tr>
                                        </thead>
                                        <tbody>


                                            @foreach ($subCategoryAddons as $item)
                                                <tr>
                                                    <td>{{ $loop->index + 1 }}</td>
                                                    <td><img style="width:100px"
                                                            src="{{ url('public/addon_images/', $item->image) }}"
                                                            alt=""></td>
                                                    <td>{!! $item->name !!}</td>
                                                    <td>{!! $item->extra_money_added !!} BDT</td>
                                                    <td>{!! $item->offer_money_added !!} BDT</td>
                                                    <td>{!! $item->offer_money_from !!}</td>
                                                    <td>{!! $item->offer_money_to !!}</td>
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
                                                                            style="color: darkorange">{{ $item->name }}</strong>
                                                                        ?
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <form
                                                                            action="{{ route('sca.delete', $item->id) }}"
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
                                                                        <h4 class="modal-title">Edit Ingredient Category,
                                                                            Name: {!! $item->name !!}</h4>
                                                                        <button type="button" class="close"
                                                                            data-dismiss="modal" aria-label="Close"><span
                                                                                aria-hidden="true">&times;</span></button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <form action="{{ route('sca.update') }}"
                                                                            method="post">
                                                                            @csrf
                                                                            <div class="row">
                                                                                <input type="hidden"
                                                                                    value="{{ $item->sub_category_id }}"
                                                                                    name="sub_cat_id">
                                                                                <input type="hidden"
                                                                                    value="{{ $item->id }}"
                                                                                    name="addon_id">
                                                                                <div class="col-md-4">
                                                                                    <div class="form-group">
                                                                                        <label for="Name">Name</label>
                                                                                        <input type="text"
                                                                                            value="{{ $item->name }}"
                                                                                            placeholder="Name"
                                                                                            name="name"
                                                                                            class="form-control">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-4">
                                                                                    <div class="form-group">
                                                                                        <label for="Name">Extra Price
                                                                                        </label>
                                                                                        <input type="number"
                                                                                            placeholder="Extra Price"
                                                                                            name="ex_price"
                                                                                            class="form-control"
                                                                                            value="{{ $item->extra_money_added }}">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-4">
                                                                                    <div class="form-group">
                                                                                        <label for="Name">Offer Price
                                                                                        </label>
                                                                                        <input type="number"
                                                                                            placeholder="Offer Price"
                                                                                            name="off_price"
                                                                                            class="form-control"
                                                                                            value="{{ $item->offer_money_added }}">
                                                                                    </div>
                                                                                </div>

                                                                                <div class="col-md-4">
                                                                                    <div class="form-group">
                                                                                        <label for="Name">Offer Start
                                                                                            Date
                                                                                        </label>
                                                                                        <input type="text"
                                                                                            name="start_price"
                                                                                            placeholder="Start Date"
                                                                                            id="u_start_date"
                                                                                            class="form-control"
                                                                                            value="{{ $item->offer_money_from }}">
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
                                                                                            value="{{ $item->offer_money_from }}">
                                                                                    </div>
                                                                                </div>
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
