@extends('layout.app')
@section('title', 'Inventory | Requisition')
@section('content')
    <?php $inputdate = \Carbon\Carbon::now()->format('Y-m-d'); ?>
    @include('layout/datatable')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Issue Requisition</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{!! url('inventory/dashboard') !!}">Inventory</a></li>
                        <li class="breadcrumb-item"><a href="javascript::void(0)">Procurement</a></li>
                        <li class="breadcrumb-item"><a href="{!! url('inventory/procurement/issuerequisition') !!}">Issue Requisition</a></li>
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
                            <div class="col-4 m-auto">
                                <form action="{{ route('getReqItems') }}" method="get">
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
                                                        <option {{ $company_id == $item->id ? 'selected' : '' }} value="{{ $item->id }}">{{ $item->Name }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                        <div class="col-5">
                                            <select name="req_id" id="selected_requisition"
                                                class="form-control select2bs4">
                                                <option>--Select Requisition--</option>
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
                            <form id="issueForm" action="{{ route('postReqItems') }}" method="post">
                                @csrf
                                <table class="table table-bordered table-striped datatbl" id="usertbl">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Requisition ID</th>
                                            <th>Item Name</th>
                                            <th>Unit Name</th>
                                            <th>Request Qty</th>
                                            <th>Stock Qty</th>
                                            <th>Issue Qty</th>
                                            <th>Remarks</th>
                                            <th style="width: 120px;">Issue Qty</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($requisitionsItems as $item)
                                            <tr>
                                                <td>{{ $loop->index + 1 }}</td>
                                                <td>{{ $item->req_id }}</td>
                                                <td>{{ $item->asset_name }}</td>
                                                <td>{{ $item->unit_name }}</td>
                                                <td>{{ $item->qty }}</td>
                                                <td class="{{ $item->stock ? 'text-success' : 'text-danger' }}">
                                                    {{ $item->stock ? $item->stock : 'No Stock' }}</td>
                                                <td class="{{ $item->issue_qty ? 'text-success' : 'text-danger' }}">
                                                    {{ $item->issue_qty ? $item->issue_qty : 'N/A' }}
                                                </td>
                                                <td>{{ $item->remarks }}</td>
                                                <td>
                                                    <input {{ $item->issue_qty == $item->qty ? 'disabled' : '' }}
                                                        type="hidden" value="{{ $item->id }}" name="item_id[]">

                                                    <input {{ $item->issue_qty == $item->qty ? 'disabled' : '' }}
                                                        type="number" name="issue_qty[]" min="1"
                                                        placeholder="Issue Qty" class="form-control">

                                                    @if ($errors->has($item->id))
                                                        <div class="text-danger">{{ $errors->first($item->id) }}</div>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach

                                    </tbody>
                                </table>
                                <div class="text-center mb-2">
                                    <tr><button class="btn btn-primary" type="submit">Submit</button></tr>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#company_id').on('change', function() {
              getRequisition();
            });
            getRequisition();
        });
        function getRequisition(){
            var company_id = $('#company_id').val();
            if (company_id) {

                $.ajax({
                    url: '{{ url('getrequisition') }}',
                    type: 'GET',
                    // dataType: 'json',
                    data: {
                        'company': company_id
                    },
                    success: function(data) {
                      
                        // return; 
                        $('#selected_requisition').empty();
                        $('#selected_requisition').append(
                            '<option selected value="">--Select Requisition--</option>');
                        $.each(data, function(index, item) {
                            $('#selected_requisition').append(`<option value="${item.id}" ${item.id == '{{ $req_id }}' ? 'selected' : ''}>${item.id}-${item.req_date}</option>`);
                        });
                    }
                });
            } else {
                $('#selected_requisition').empty();
                $('#selected_requisition').append(
                    '<option value="">--Select Requisition--</option>');
            }
        }
    </script>

@stop
