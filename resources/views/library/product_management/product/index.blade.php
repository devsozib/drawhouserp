@extends('layout.app')
@section('title', 'Library | Company')
@section('content')
    @include('layout/datatable')

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"><small>Product Lists</small></h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{!! url('library/dashboard') !!}">Library</a></li>
                        <li class="breadcrumb-item"><a href="javascript::void(0)">Product Mangement</a></li>
                        <li class="breadcrumb-item"><a href="{!! url('library/product_management/products') !!}">Product Lists</a></li>
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
                        <h3 class="card-title text-center w-75">Product List</h3>
                        @if ($create)
                            <div class="float-right"><a
                                    href="{{ action('\App\Http\Controllers\Library\ProductManagement\ProductController@create') }}"
                                    class="btn-sm bg-gradient-success" title="Add"><i
                                        class="fas fa-plus"></i>&nbsp;Add</a></div>
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
                                                <th>Image</th>
                                                <th>Sales type</th>
                                                <th>Name</th>
                                                <th>Company</th>
                                                <th>Category</th>
                                                <th>Sub Category</th>
                                                <th>Website Status</th>
                                                <th>Status</th>
                                                <th style="width: 120px;">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($products as $item)
                                                <tr>
                                                    <td>{{ $loop->index + 1 }}</td>
                                                    <td><img style="width:100px"
                                                            src="{{ url('public/product_images/', $item->image) }}"
                                                            alt=""></td>
                                                    <td>{{ implode(',', array_intersect_key(salesTypes(), array_flip(explode(',',  $item->sales_type)))) }}</td>
                                                    <td>{!! $item->name !!}</td>
                                                    <td>{!! $item->Name !!}</td>
                                                    <td>{!! $item->cat_name !!}</td>
                                                    <td>{!! $item->sub_cat_name !!}</td>
                                                    <td class="text-center">
                                                        @if ($item->website_view == '1')
                                                            <i class="fa-solid fa-eye"></i>
                                                        @else
                                                            <i class="fa-solid fa-eye-slash"></i>
                                                        @endif

                                                        <br />
                                                        <div class="btn-group">
                                                            <button type="button" class="btn btn-primary dropdown-toggle"
                                                                data-toggle="dropdown" aria-haspopup="true"
                                                                aria-expanded="false">
                                                                Change
                                                            </button>
                                                            <div class="dropdown-menu">
                                                                {{-- For web status --}}
                                                                @if ($item->website_view == '1')
                                                                    <a class="dropdown-item" href="#"
                                                                        onclick="changeStatus('hide',{{ $item->id }})">Hide
                                                                        From
                                                                        Web</a>
                                                                @else
                                                                    <a class="dropdown-item" href="#"
                                                                        onclick="changeStatus('show',{{ $item->id }})">Show
                                                                        Web</a>
                                                                @endif
                                                                {{-- For feature and chef special --}}
                                                                @if ($item->chef_special == '1')
                                                                    <a class="dropdown-item" href="#"
                                                                        onclick="changeStatus('removechef',{{ $item->id }})">Remove
                                                                        From
                                                                        Chef special</a>
                                                                @else
                                                                    <a class="dropdown-item" href="#"
                                                                        onclick="changeStatus('addchef',{{ $item->id }})">Add
                                                                        to
                                                                        Chef special</a>
                                                                @endif
                                                                @if ($item->featured == '1')
                                                                    <a class="dropdown-item" href="#"
                                                                        onclick="changeStatus('removef',{{ $item->id }})">Remove
                                                                        From
                                                                        Featured</a>
                                                                @else
                                                                    <a class="dropdown-item" href="#"
                                                                        onclick="changeStatus('addf',{{ $item->id }})">Add
                                                                        to
                                                                        Featured</a>
                                                                @endif
                                                                @if ($item->chef_special == '1' && $item->featured == '1')
                                                                    <a class="dropdown-item" href="#"
                                                                        onclick="changeStatus('removeformboth',{{ $item->id }})">Remove
                                                                        From
                                                                        Both</a>
                                                                @else
                                                                    <a class="dropdown-item" href="#"
                                                                        onclick="changeStatus('addtoboth',{{ $item->id }})">Add
                                                                        to both</a>
                                                                @endif
                                                                @if ($item->slider == '1')
                                                                    <a class="dropdown-item" href="#"
                                                                        onclick="changeStatus('removeformslider',{{ $item->id }})">Remove
                                                                        From
                                                                        Slider</a>
                                                                @else
                                                                    <a class="dropdown-item" href="#"
                                                                        onclick="changeStatus('addtoslider',{{ $item->id }})">Add
                                                                        to Slider</a>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="text-{{ $item->status == 1 ? 'success' : 'danger' }}">
                                                        {{ $item->status == 1 ? 'Active' : 'Inactive' }}</td>
                                                    <td>
                                                        @if ($edit)
                                                            <a href="{{ route('products.edit', encrypt($item->id)) }}"
                                                                class="btn-sm bg-gradient-info" title="Edit"><i
                                                                    class="fas fa-edit"></i></a>
                                                        @endif
                                                        @if ($delete)
                                                            <a role="button" data-toggle="modal"
                                                                data-target="#delete-modal{{ $item->id }}"
                                                                class="btn-sm bg-gradient-danger" title="Delete"><i
                                                                    class="fas fa-times"></i></a>
                                                        @endif
                                                        <br />
                                                        <br />
                                                        <div class="btn-group">
                                                            <button type="button" class="btn btn-primary dropdown-toggle"
                                                                data-toggle="dropdown" aria-haspopup="true"
                                                                aria-expanded="false">
                                                                Add
                                                            </button>
                                                            <div class="dropdown-menu">
                                                                <a class="dropdown-item"
                                                                    href="{{ route('productsize.index', $item->id) }}">Product
                                                                    Size</a>
                                                                @php
                                                                    $productSizes = getProductSize($item->id);
                                                                @endphp
                                                                @if ($productSizes > 0)
                                                                    <a class="dropdown-item"
                                                                        href="{{ route('producting.index', $item->id) }}">Product
                                                                        Ingredient</a>
                                                                    <a class="dropdown-item"
                                                                        href="{{ route('proopttitle.index', $item->id) }}">Product
                                                                        option title</a>
                                                                    <a class="dropdown-item"
                                                                        href="{{ route('prooption.indx', $item->id) }}">Product
                                                                        option</a>
                                                                    <a class="dropdown-item"
                                                                        href="{{ route('prooptioning.indx', $item->id) }}">Product
                                                                        option ingredient</a>
                                                                    <a class="dropdown-item"
                                                                        href="{{ route('proaddon.indx', $item->id) }}">Product
                                                                        Addon</a>
                                                                    <a class="dropdown-item"
                                                                        href="{{ route('proaddoning.indx', $item->id) }}">Product
                                                                        Addon Ingredient</a>
                                                                @endif

                                                            </div>
                                                        </div>

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
                                                                        Are you sure you want to delete this product:
                                                                        <strong
                                                                            style="color: darkorange">{{ $item->name }}</strong>
                                                                        ?
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <form
                                                                            action="{{ action('\App\Http\Controllers\Library\ProductManagement\ProductController@destroy', $item->id) }}"
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
        function changeStatus(type, id) {
            $.ajax({
                url: '{{ url('changewebstatus') }}',
                type: 'GET',
                // dataType: 'json',
                data: {
                    'type': type,
                    'id': id
                },
                success: function(data) {
                    setTimeout(function() {
                        window.location = 'products';
                    }, 1000);
                    toastr.success(data.success);
                }
            });
        }
    </script>
@stop
