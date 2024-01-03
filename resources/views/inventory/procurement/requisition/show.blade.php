@extends('layout.app')
@section('title', 'Inventory | Requisition')
@section('content')
    <?php $inputdate = \Carbon\Carbon::now()->format('Y-m-d'); ?>
    @include('layout/datatable')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Requisition</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{!! url('inventory/dashboard') !!}">Inventory</a></li>
                        <li class="breadcrumb-item"><a href="javascript::void(0)">Procurement</a></li>
                        <li class="breadcrumb-item"><a href="{!! url('inventory/procurement/requisition') !!}">Requisition</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Index</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <style>
        #faq {
            margin-bottom: 10px;
            border: 0;
        }

        #faq {
            border: 0;
            -webkit-box-shadow: 0 0 20px 0 rgba(213, 213, 213, 0.5);
            box-shadow: 0 0 20px 0 rgba(213, 213, 213, 0.5);
            border-radius: 2px;
            padding: 0;
        }

        #faq .btn-header-link {
            color: #fff;
            display: block;
            text-align: center;
            background: #72aaff;
            color: #222;
            padding: 6px;
        }

        #faq .btn-header-link:after {
            content: "\f068";
            font-family: 'Font Awesome 5 Free';
            font-weight: 900;
            float: left;
        }

        #faq .btn-header-link.collapsed {
            background: #bfb9c0;
            color: #fff;
        }

        #faq .btn-header-link.collapsed:after {
            content: "\f067";
        }

        .error-field {
            border: 1px solid red;
        }

        .error {
            color: red;
        }
    </style>
    <div class="content" id="content">
        <div class="row">
            <div class="col-lg-3">
                <div class="card">
                    <div class="card-header with-border">
                        <h3 class="card-title text-center w-75">Requisition List</h3>
                    </div>
                    <div class="card-body">
                        <div class="container">
                            @foreach ($requisitions as $group)
                                <div class="accordion" id="faq">
                                    <div class="" id="faqhead2">
                                        <a href="#"
                                            class="btn btn-header-link {{ $group->first()->date == $requisition->requisition_date ? '' : 'collapsed' }}"
                                            data-toggle="collapse" data-target="#faq{{ $group->first()->date }}"
                                            aria-expanded="true"
                                            aria-controls="faq{{ $group->first()->date }}">{{ \Carbon\Carbon::parse($group->first()->date)->isoFormat('MMM Do YYYY') }}</a>
                                    </div>
                                    @foreach ($group as $item)
                                        <div id="faq{{ $item->requisition_date }}"
                                            class="collapse {{ $item->requisition_date == $requisition->requisition_date ? 'show' : '' }}"
                                            aria-labelledby="faqhead2" data-parent="#faq">
                                            <ul class="list-group ml-3">
                                                <a href="{{ route('requisition.show', $item->id) }}">
                                                    <li class="list-group-item">
                                                        {{ $item->id }}-{{ $item->company_name }} @if ($requisition->status == '3') <img style="float:right" width="30px" src="{{ asset('images/publish_2.png') }}" alt="">@endif
                                                    </li>
                                                </a>
                                            </ul>
                                        </div>
                                    @endforeach
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-9">
                <div class="card">
                    <div class="card-header with-border">
                        <h3 class="card-title text-center w-75">Requisition items of <a href=""
                                class="text-link">00{{ $requisition->id }}-{{ $requisition->company_name }}</a></h3>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th style="width: 25%;">Identity</th>                                  
                                    <th style="width: 25%;">Date</th>
                                    <th style="width: 25%;">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <div class="form-group">
                                            <input type="text" disabled class="form-control"
                                                value="{{ $requisition->id }}">
                                        </div>
                                    </td>                                   
                                    <td>
                                        <div class="form-group">
                                            <input type="date" disabled class="form-control" name="requisition_date"
                                                value="{{ $requisition->requisition_date }}">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <select  name="status" id="status" class="form-control" onchange="updateReqStatus({{ $requisition->id }}, this.value)">
                                                <option {{ $requisition->status == 0? 'selected' : '' }} value="0">Pending</option>
                                                @if (Sentinel::inRole('manager') || Sentinel::inRole('superadmin'))
                                                <option {{ $requisition->status == 1 ? 'selected' : '' }} value="1">Approve by Manager</option>
                                                @endif                                                       
                                                <option {{ $requisition->status == 2 ? 'selected' : '' }} value="2">Approve by Management</option>                                                                                                                                
                                                <option {{ $requisition->status == 3 ? 'selected' : '' }} value="3">Complete</option>
                                            </select>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        @if ($requisition->status != 3)
                            <div class="card p-4">
                                <div class='item'>
                                    <form id="requisitions">
                                        <div id="orderId">
                                            <div class="row">
                                                <input type="hidden" name="req_id" value="{{ $requisition->id }}">
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label class="required">Ingredient Item:</label>
                                                        <select onchange="getUnit(this.value)"
                                                            class="form-select form-control select2bs4 " name="ingredient"
                                                            id="inputGroupSelect0">
                                                            <option class="" selected disbaled value="">
                                                                --Select Ing Item--
                                                            </option>
                                                            @foreach ($items as $item)
                                                                <option class="bg-secondary" value="{{ $item->id }}">
                                                                    {{ $item->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        <span id="ingredientError" class="error"></span>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label class="required">Unit:</label>
                                                        <input type="text" readonly id="unit" class="form-control"
                                                            placeholder="Unit" required><br>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label class="required">Req Qty:</label>
                                                        <input type="text" class="form-control" placeholder="Request Qty"
                                                            name="qty" required>
                                                        <span id="qtyError" class="error"></span>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label>Remarks:(Optional)</label>
                                                        <input type="text" class="form-control" placeholder="Remarks"
                                                            name="remarks"><br>
                                                    </div>
                                                </div>

                                                <div class="col-md-2" style="margin-top: 32px">
                                                    <button type="submit" class="btn btn-success addButton">
                                                        <i class="fa fa-location-arrow"aria-hidden="true"></i>Submit
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        @endif
                        <div class="card p-4">
                            <div class="row">
                                <div class="col-lg-12">
                                    <table class="table table-bordered table-striped datatbl" id="usertbl">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Ingredient</th>
                                                <th>Unit</th>
                                                <th>Req.Qty</th>
                                                <th>Issue.Qty</th>
                                                <th>Recv.Qty</th>
                                                <th>Remarks</th>
                                                @if ($requisition->status != 3)
                                                <th style="width: 120px;">Action</th>
                                                @endif
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($reqtems as $item)
                                                <tr>
                                                    <td>{{ $loop->index + 1 }}</td>
                                                    <td>{!! $item->asset_name !!}</td>
                                                    <td>{!! $item->unit_name !!}</td>
                                                    <td>{!! $item->qty !!}</td>
                                                    <td>{!! $item->issue_qty !!}</td>
                                                    <td><input  {{ $item->issue_qty == 0 || $requisition->status == 3 ? 'readonly' : '' }} class="form-control" type="number" min="0" pattern="[0-9]+([\.,][0-9]+)" value="{{ $item->rcv_qty }}" step="0.1" onInput="updateRcvqty({{ $item->req_id }}, {{ $item->ing_id }}, this.value)"></td>
                                                    <td>{!! $item->remarks ? $item->remarks : 'N/A' !!}</td>
                                                    @if ($item->status != 3)
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
                                                                            Are you sure you want to delete this item:
                                                                            <strong
                                                                                style="color: darkorange">{{ $item->asset_name }}</strong>
                                                                            of Requisition number <a href=""
                                                                                class="text-link">{{ $item->req_id }}</a>
                                                                            ?
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <form
                                                                                action="{{ route('requisition.destroy', $item->id) }}"
                                                                                method="post">
                                                                                @csrf
                                                                                @method('delete')
                                                                                <input type="hidden" name="type"
                                                                                    value="item_del">
                                                                                <button type="submit" class="btn btn-warning"
                                                                                    data-bs-target="#secondmodal"
                                                                                    data-bs-toggle="modal"
                                                                                    data-bs-dismiss="modal">
                                                                                    Delete
                                                                                </button>
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
                                                                            <h4 class="modal-title">Edit Requsition issue item,
                                                                                Name: <a href=""
                                                                                    class="text-link">{{ $item->asset_name }}</a>
                                                                            </h4>
                                                                            <button type="button" class="close"
                                                                                data-dismiss="modal" aria-label="Close"><span
                                                                                    aria-hidden="true">&times;</span></button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            <form method="post"
                                                                                action="{{ route('requisition.update', $item->id) }}">
                                                                                @method('patch')
                                                                                @csrf
                                                                                <input type="hidden" name="type"
                                                                                    value="ItemEdit">
                                                                                <input type="hidden" name="req_id"
                                                                                    value="{{ $item->req_id }}">
                                                                                <div class="row">
                                                                                    <div class="col-md-3">
                                                                                        <div class="form-group">
                                                                                            <label for="Name">Ingredient
                                                                                                Name</label>
                                                                                            <input type="text"
                                                                                                value="{{ $item->asset_name }}"
                                                                                                placeholder="Name" disabled
                                                                                                class="form-control">
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-3">
                                                                                        <div class="form-group">
                                                                                            <label for="Name">Unit</label>
                                                                                            <input type="text"
                                                                                                value="{{ $item->unit_name }}"
                                                                                                placeholder="Name" disabled
                                                                                                class="form-control">
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-3">
                                                                                        <div class="form-group">
                                                                                            <label for="Name">Qty</label>
                                                                                            <input type="number"
                                                                                                value="{{ $item->qty }}"
                                                                                                placeholder="qty"
                                                                                                class="form-control"
                                                                                                name="qty" required>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-3">
                                                                                        <div class="form-group">
                                                                                            <label
                                                                                                for="Name">Remarks</label>
                                                                                            <input type="text"
                                                                                                value="{{ $item->remarks }}"
                                                                                                placeholder="Name"
                                                                                                class="form-control"
                                                                                                name="remarks">
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
                                                            @if (!empty(Session::get('error_code')) && Session::get('error_code') == $user->id)
                                                                <script>
                                                                    $(function() {
                                                                        $('#edit-modal{{ $item->id }}').modal('show');
                                                                    });
                                                                </script>
                                                            @endif
                                                        </td>
                                                    @endif
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

    <script>
        function getUnit(id) {
            if (id) {
                $.ajax({
                    url: '{{ url('getunit') }}',
                    type: 'GET',
                    data: {
                        'ing_id': id
                    },
                    success: function(data) {
                        $('#unit').val(data.unit_name);
                    }
                });

            } else {
                $('#pro_sub_category_select').empty();
                $('#pro_sub_category_select').append(
                    '<option value="">--Select Subcategory--</option>');
            }
        }

        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('#requisitions').submit(function(event) {
                event.preventDefault();
                var formData = $(this).serialize();
                $.ajax({
                    url: '{{ route('requisition.store') }}',
                    method: 'POST',
                    data: formData,
                    type:'storeRequision',
                    success: function(response) {
                        console.log(response.status);
                        if (response.status == 'error') {
                            $.each(response.errors, function(field, error) {
                                $('#' + field).addClass('error-field');
                                $('#' + field + 'Error').text(error[0]);
                            });
                        } else if (response.status == 'exists') {
                            toastr.warning('This item alrady exists please edit.');
                            $("#usertbl").load(window.location + " #usertbl");
                            $('#ingredientError').text("");
                            $('#qtyError').text("");
                        } else {
                            toastr.success('Item Issue Success');
                            $("#usertbl").load(window.location + " #usertbl");
                            $('#ingredientError').text("");
                            $('#qtyError').text("");
                        }

                    },
                });
            });          
        });

        function updateRcvqty(req_id, ing_id, qty){

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                url: '{{ route('requisition.store') }}',
                method: 'POST', // Use 'POST' if you are sending data
                data: { 
                    req_id:req_id,
                    ing_id:ing_id,
                    qty: qty,
                    type:"rcvQtyUpdate" 
                },
                success: function(response) {                  
                    toastr.success('Item Issue Success');
                },
            });

            }

    function updateReqStatus(req_id, status){
            $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                    url: '{{ route('requisition.store') }}',
                    method: 'POST', // Use 'POST' if you are sending data
                    data: { 
                        req_id:req_id,
                        status: status,
                        type:"statusUpdate" 
                    },
                    success: function(response) {
                        var approvedBy = '';
                        if(status == 0){
                            approvedBy = "Pending"
                        }else if(status == 1){
                            approvedBy = 'Manager'
                        }else if(status == 2){
                            approvedBy = 'Management'
                        }else{
                            approvedBy = 'Complete'
                        }
                       
                        toastr.success('Status update to '+approvedBy);
                        location.reload();

                    },
                    });
            }
    </script>

@stop
