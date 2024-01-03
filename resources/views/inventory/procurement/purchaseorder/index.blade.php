@extends('layout.app')
@section('title', 'Inventory | Purchase')
@section('content')
    <?php $inputdate = \Carbon\Carbon::now()->format('Y-m-d'); ?>
    @include('layout/datatable')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Purchase Order</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{!! url('inventory/dashboard') !!}">Inventory</a></li>
                        <li class="breadcrumb-item"><a href="javascript::void(0)">Procurement</a></li>
                        <li class="breadcrumb-item"><a href="{!! url('inventory/procurement/purchaseorder') !!}">Purchase Order</a></li>
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
    </style>
    <div class="content">
        <div class="row">
            <div class="col-lg-3">
                <div class="card">
                    <div class="card-header with-border">
                        <h3 class="card-title text-center w-75">Purchase List</h3>
                    </div>

                    <div class="container">
                        @foreach ($requisitions as $group)
                            <div class="accordion" id="faq">
                                <div class="" id="faqhead2">
                                    <a href="#" class="btn btn-header-link collapsed" data-toggle="collapse"
                                        data-target="#faq{{ $group->first()->date }}" aria-expanded="true"
                                        aria-controls="faq{{ $group->first()->date }}">{{ \Carbon\Carbon::parse($group->first()->date)->isoFormat('MMM Do YYYY') }}</a>
                                </div>
                                @foreach ($group as $item)
                                    <div id="faq{{ $item->po_date }}" class="collapse" aria-labelledby="faqhead2"
                                        data-parent="#faq">
                                        <ul class="list-group ml-3">
                                            <a href="{{ route('purchaseorder.show', $item->id) }}">
                                                <li class="list-group-item">
                                                    {{ $item->id }}-{{ $item->company_name }}@if ($item->status == '3') <img style="float:right" width="30px" src="{{ asset('images/publish_2.png') }}" alt="">@endif
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
            <div class="col-lg-9">
                <div class="card">
                    <div class="card-header with-border">
                        <h3 class="card-title text-center w-75">Purchase Order List</h3>
                    </div>
                    <div class="card-body" style="min-height:400px; max-height:500px; overflow-y:auto;">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th style="width: 25%;">Identity</th>
                                    <th style="width: 25%;">Company</th>
                                    <th style="width: 25%;">Date</th>
                                    <th style="width: 25%; text-align: center;">Action</th>
                                </tr>
                            </thead>
                            {!! Form::open([
                                'action' => [
                                    '\App\Http\Controllers\Inventory\Procurement\PurchaseOrderController@store',
                                    'method' => 'Post',
                                    'form' => '1',
                                ],
                            ]) !!}
                            <tbody>
                                <tr>
                                    <input type="hidden" value="forReqAdd" name="type">
                                    <td>
                                        <div class="form-group">
                                            <div class="controls">
                                                {!! Form::text('RequisitionID', null, [
                                                    'disabled',
                                                    'class' => 'form-control',
                                                    'id' => 'RequisitionID',
                                                    'placeholder' => 'Purchase ID',
                                                    'value' => Input::old('RequisitionID'),
                                                ]) !!}
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <div class="controls">
                                                {!! Form::select('company_id', $comp_arr, getHostInfo()['id'], [
                                                    'required',
                                                    'class' => 'form-control',
                                                    'id' => 'company_id',
                                                    'placeholder' => 'Select One',
                                                    'value' => Input::old('company_id'),
                                                ]) !!}
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <div class="controls">
                                                {!! Form::text('po_date', $inputdate, [
                                                    'required',
                                                    'class' => 'form-control datepicker',
                                                    'id' => 'po_date',
                                                    'placeholder' => 'Requisition Date',
                                                    'value' => Input::old('po_date'),
                                                ]) !!}
                                            </div>
                                        </div>
                                    </td>
                                    <td style="text-align: center;">
                                        @if ($create)
                                            {!! Form::submit('Add', ['class' => 'btn btn-success']) !!}
                                        @endif
                                    </td>
                                </tr>
                            </tbody>
                            {!! Form::close() !!}
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@section('script')
    <script>
        $(document).ready(function() {
            // Add minus icon for collapse element which
            // is open by default
            $(".collapse.show").each(function() {
                $(this).prev(".card-header").find(".fa")
                    .addClass("fa-minus").removeClass("fa-plus");
            });
            // Toggle plus minus icon on show hide
            // of collapse element
            $(".collapse").on('show.bs.collapse', function() {
                $(this).prev(".card-header").find(".fa")
                    .removeClass("fa-plus").addClass("fa-minus");
            }).on('hide.bs.collapse', function() {
                $(this).prev(".card-header").find(".fa")
                    .removeClass("fa-minus").addClass("fa-plus");
            });
        });
    </script>
@endsection
@stop
