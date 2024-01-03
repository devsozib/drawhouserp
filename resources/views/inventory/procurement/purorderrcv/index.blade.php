@extends('layout.app')
@section('title', 'Inventory | Requisition')
@section('content')
    <?php $inputdate = \Carbon\Carbon::now()->format('Y-m-d'); ?>
    @include('layout/datatable')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-7">
                    <h1 class="m-0 text-right">Check Purchase Order Items from Gate</h1>
                </div>
                <div class="col-sm-5">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{!! url('inventory/dashboard') !!}">Inventory</a></li>
                        <li class="breadcrumb-item"><a href="javascript::void(0)">Procurement</a></li>
                        <li class="breadcrumb-item"><a href="{!! url('inventory/procurement/purorderrecv') !!}">Check Purchase Order Items from Gate</a></li>
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
                    <div class="card-body">
                        <div class="row">
                            <div class="col-8 m-auto">
                                <form action="{{ route('getPurchItems') }}" method="get">
                                    <div class="input-group">
                                        <div class="col-5">
                                            <select class="form-control select2bs4" onchange="" name="company"
                                                id="company_id">
                                                <option>--Select Company--</option>
                                                @if (!$company_id)
                                                    @foreach ($comp_arr as $item)
                                                        <option {{ getHostInfo()['id'] == $item->id ? 'selected' : '' }} value="{{ $item->id }}">{{ $item->Name }}</option>
                                                    @endforeach
                                                @else
                                                    @foreach ($comp_arr as $item)
                                                        <option {{ $company_id == $item->id ? 'selected' : '' }}
                                                            value="{{ $item->id }}">{{ $item->Name }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                        <div class="col-5">
                                            <select name="purch_id" id="selected_purchase_id"
                                                class="form-control select2bs4">
                                                <option>--Select Order ID--</option>
                                            </select>
                                        </div>
                                        <div class="col-2">
                                            <button type="submit" style="border:none"><span class="input-group-text"><i
                                                        class="fa fa-search"></i></span></button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-8 m-auto">
                            <form id="rcvFromGate">
                                <div id="orderId">
                                    <div class="row">
                                        <input type="hidden" name="puch_id" id="puch_id">
                                        <input type="hidden" name="ing_id" id="ing_id">
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label class="required">Ingredient Item:</label>
                                                <select onchange="getFullInfo(this.value)"
                                                    class="form-select form-control select2bs4 " name="ingredient"
                                                    id="inputGroupSelect0">
                                                    <option class="" selected disbaled value="">
                                                        --Select Ing Item--
                                                    </option>
                                                    @foreach ($ingitemInfos as $item)
                                                        <option class="bg-secondary" value="{{ $item->id }}">
                                                            {{ $item->asset_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <span id="ingredientError" class="error"></span>
                                            </div>
                                        </div>
                                        <div class="col-md-1">
                                            <div class="form-group">
                                                <label class="required">Unit</label>
                                                <input type="text" readonly id="unit" class="form-control"
                                                    placeholder="Unit" required><br>
                                            </div>
                                        </div>
                                        <div class="col-md-1">
                                            <div class="form-group">
                                                <label class="required">Unit Price</label>
                                                <input type="text" id="unit_price" readonly class="form-control"
                                                    placeholder="Unit Price" required>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label>Purchased By</label>
                                                <input type="text" placeholder="Purchased By" id="purchase_by" readonly
                                                    class="form-control"><br>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label>Remarks</label>
                                                <input type="text" id="remarks" readonly class="form-control"
                                                    placeholder="Remarks"><br>
                                            </div>
                                        </div>
                                        <div class="col-md-1">
                                            <div class="form-group">
                                                <label>P.QTY</label>
                                                <input type="number" readonly id="p_qty" class="form-control"
                                                    placeholder="Pur.QTY">
                                                <br>
                                            </div>
                                        </div>
                                        <div class="col-md-1">
                                            <div class="form-group">
                                                <label>R.QTY</label>
                                                <input type="number" id="r_qty" class="form-control"
                                                    placeholder="Rcv QTY" min="1" required name="rcv_qty"><br>
                                            </div>
                                        </div>
                                        <div class="col-md-2" style="margin-top: 32px">
                                            <button type="submit" class="btn btn-success addButton">Received</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-8 m-auto">
                            <table class="table table-bordered table-striped datatbl" id="usertbl">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Item Name</th>
                                        <th>Unit</th>
                                        <th>Puchase Qty</th>
                                        <th>Rcv Qty</th>
                                        <th>Remarks</th>
                                        <th style="width: 120px;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($gateUpdateItems as $item)
                                        <tr>
                                            <td>{{ $loop->index + 1 }}</td>
                                            <td>{{ $item->asset_name }}</td>
                                            <td>{{ $item->unit_name }}</td>
                                            <td>{{ $item->ing_qty }}</td>
                                            <td>{{ $item->gate_rcv_qty }}</td>
                                            <td>{{ $item->remarks }}</td>
                                            <td>
                                                @if ($edit)
                                                    <a role="button" data-toggle="modal"
                                                        data-target="#edit-modal{{ $item->id }}"
                                                        class="btn-sm bg-gradient-info" title="Edit"><i
                                                            class="fas fa-edit"></i></a>
                                                @endif
                                                <!--Edit Form Here-->
                                                <div class="modal fade" id="edit-modal{!! $item->id !!}"
                                                    role="dialog">
                                                    <div class="modal-dialog modal-lg ">
                                                        <!-- Modal content-->
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h4 class="modal-title">Edit Purchase item,
                                                                    Of <a href=""
                                                                        class="text-link">{{ $item->asset_name }}</a>
                                                                </h4>
                                                                <button type="button" class="close"
                                                                    data-dismiss="modal" aria-label="Close"><span
                                                                        aria-hidden="true">&times;</span></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form method="post"
                                                                    action="{{ route('gatecheckUpdate', $item->id) }}">
                                                                    @csrf
                                                                    <div class="row">
                                                                        <input type="hidden"
                                                                            value="{{ $item->purch_id }}"
                                                                            name="purch_id">
                                                                        <input type="hidden" value="{{ $item->id }}"
                                                                            name="item_id">
                                                                        <input type="hidden" name="type"
                                                                            value="itemUpdate">
                                                                        <div class="col-md-3">
                                                                            <label for="">Ingredient Name</label>
                                                                            <input type="text"
                                                                                value="{{ $item->asset_name }}" readonly
                                                                                id="p_qty" class="form-control">
                                                                        </div>
                                                                        <div class="col-md-3">
                                                                            <label for="">Unit Name</label>
                                                                            <input type="text"
                                                                                value="{{ $item->unit_name }}" readonly
                                                                                id="p_qty" class="form-control">
                                                                        </div>
                                                                        <div class="col-md-3">
                                                                            <label>P.QTY</label>
                                                                            <input type="number" readonly id="p_qty"
                                                                                class="form-control"
                                                                                value="{{ $item->ing_qty }}">
                                                                            <br>
                                                                        </div>
                                                                        <div class="col-md-3">
                                                                            <label>R.QTY</label>
                                                                            <input type="number" id="rcv_qty"
                                                                                class="form-control"
                                                                                value="{{ $item->gate_rcv_qty }}"
                                                                                name="rcv_qty">
                                                                            <br>
                                                                        </div>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="submit"
                                                                            class="btn btn-success">Update</button>
                                                                        <button type="button" class="btn btn-default"
                                                                            data-dismiss="modal">Cancel</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                {{-- @if (!empty(Session::get('error_code')) && Session::get('error_code') == $user->id)
                                                    <script>
                                                        $(function() {
                                                            $('#edit-modal{{ $item->id }}').modal('show');
                                                        });
                                                    </script>
                                                @endif --}}
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

    <script>
        $(document).ready(function() {
            $('#company_id').on('change', function() {
                getItems();
            });
            getItems()
        });
        function getItems(){
            var company_id = $('#company_id').val();
                if (company_id) {
                    $.ajax({
                        url: '{{ url('getpurhaseid') }}',
                        type: 'GET',
                        dataType: 'json',
                        data: {
                            'company': company_id
                        },
                        success: function(data) {                          
                        $('#selected_purchase_id').empty();
                        $('#selected_purchase_id').append('<option selected value="">--Select Purchase Id--</option>');
                        
                        $.each(data, function(index, item) {
                            $('#selected_purchase_id').append('<option value="' + item.id + '" ' + (item.id == '{{ $purch_id }}' ? 'selected' : '') + '>' + item.id + '-' + item.po_date + '</option>');
                        });
                    }

                    });
                } else {
                    $('#selected_purchase_id').empty();
                    $('#selected_purchase_id').append(
                        '<option value="">--Select Purchase ID--</option>');
                }
        }
        function getFullInfo(id) {
            if (id) {
                $.ajax({
                    url: '{{ url('getpurhaseiteminfo') }}',
                    type: 'GET',
                    data: {
                        'id': id
                    },
                    success: function(item) {
                        console.log(item);
                        $('#puch_id').val(item.purch_id);
                        $('#ing_id').val(item.ing_id);
                        $('#unit').val(item.unit_name);
                        $('#unit_price').val(item.ing_unit_price);
                        $('#remarks').val(item.remarks);
                        if (item.l_name != null) {
                            $('#purchase_by').val(item.f_name + ' ' + item.l_name);
                        } else {
                            $('#purchase_by').val(item.f_name);
                        }
                        $('#p_qty').val(item.ing_qty);
                    }
                });
            } else {
                // $('#selected_purchase_id').empty();
                // $('#selected_purchase_id').append(
                //     '<option value="">--Select Purchase ID--</option>');
            }
        }
        // Submit New Qty After gate check
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('#rcvFromGate').submit(function(event) {
                event.preventDefault();
                var formData = $(this).serialize();
                // console.log(formData)
                $.ajax({
                    url: '{{ route('gatecheckUpdate') }}',
                    method: 'POST',
                    data: formData,
                    success: function(response) {
                        console.log(response);
                        // return;
                        if (response.status == 'success') {
                            toastr.success('Item Receive Success');
                            $("#usertbl").load(window.location + " #usertbl");
                        } else if (response.status == 'warnForEdit') {
                            toastr.warning('This item already received please edit if need!');
                            $("#usertbl").load(window.location + " #usertbl");
                        } else {
                            toastr.warning('Please select an item!');
                        }

                    },
                });
            });
        });
    </script>

@stop
