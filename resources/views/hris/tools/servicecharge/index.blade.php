@extends('layout.app')
@section('title', 'HRIS | Service Charge')
@section('content')
@include('layout/datatable')

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0" style="text-align: right;"></h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{!! url('hris/dashboard') !!}">HRIS</a></li>
                        <li class="breadcrumb-item"><a href="javascript::void(0)">Tools</a></li>
                        <li class="breadcrumb-item"><a href="{!! url('hris/tools/service_charge') !!}">Service Charge</a></li>
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
                    <div class="card-header with-border" style="font-size: 22px; text-align: center;">Service Charge
                        @if ($create)
                            <div class="float-right"><a role="button" data-toggle="modal" data-target="#add-modal" class="btn-sm bg-gradient-success" title="Add"><i class="fas fa-plus"></i>&nbsp;Add</a></div>
                        @endif
                    </div>
                    <div class="card-body">
                        <!--Add Form Here-->
                        <div class="modal fade" id="add-modal" role="dialog">
                            <div class="modal-dialog modal-lg modal-dialog-centered">
                                <!-- Modal content-->
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title">Service Charge</h4>
                                        <button type="button" class="close" data-dismiss="modal"
                                            aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ route('service_charge.store') }}" method="post">
                                            @if (!empty(Session::get('error_code')) == 'add')
                                                @include('layout/flash-message')
                                            @endif
                                            @csrf

                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="company_id">Property</span></label>
                                                        <select name="company_id" id="company_id" class="form-control">
                                                            <option value="" selected disabled>--Select--</option>
                                                            @foreach ($complists as $key => $comp)
                                                                <option {{ getHostInfo()['id'] == $key ? 'selected':'' }} value="{{ $key }}">{{ $comp }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="Year">Year</label>
                                                        <div class="controls">
                                                            {!! Form::number('Year', $hroptions->Year, array('readonly', 'class'=>'form-control', 'id' => 'Year', 'min'=>'2021', 'max'=>'2100', 'placeholder'=>'Year', 'value'=>Input::old('Year'))) !!}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="Month">Month</label>
                                                        <div class="controls">
                                                            {!! Form::selectMonth('Month', $hroptions->Month, array('required', 'class' => 'form-control', 'id' => 'Month', 'value'=>Input::old('Month'))) !!}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="amount">Amount</label>
                                                        <input type="number" pattern ='[0-9]+([\.,][0-9]+)?'  step ='0.01'  min= '0', placeholder="Amount" name="amount"
                                                            class="form-control">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="C4S">Status</label>
                                                        <div class="controls">
                                                            <select name="status" id="" class="form-control">
                                                                <option value="1">Active</option>
                                                                <option value="0">Inactive</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-success">Submit</button>
                                                <button type="button" class="btn btn-default"
                                                    data-dismiss="modal">Cancel</button>
                                            </div>
                                        </form>
                                    </div>

                                </div>
                            </div>
                        </div>
                        @if (!empty(Session::get('error_code')) && Session::get('error_code') == 'Add')
                            <script>
                                $(function() {
                                    $('#add-modal').modal('show');
                                });
                            </script>
                        @endif

                        <div style="max-height: 450px; min-height: 450px; overflow: auto;">
                            <table class="table table-bordered table-striped datatbl" id="usertbl">
                                <thead>
                                    <tr>
                                        <th>SL</th>
                                        <th>Property</th>
                                        <th>Period</th>
                                        <th>Amount</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $sl1 = 1; ?>
                                    @foreach($charges as $item)
                                        <tr>
                                            <td style="">{{ $loop->index+1 }}</td>
                                            <td style="">{{ $item->Name}}</td>
                                            <td style="">{{ \Carbon\Carbon::parse($item->year.'-'.$item->month)->format('F, Y') }}</td>
                                            <td style="">{{ $item->amount }}</td>
                                            <td class="text-{{ $item->status == 1 ? 'success' : 'danger' }}">
                                                {{ getC4S($item->status) }}</td>
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
                                                                    Are you sure you want to delete this Service Charge?
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <form
                                                                        action="{{ route('service_charge.destroy', $item->id) }}"
                                                                        method="post">
                                                                        @csrf
                                                                        @method('delete')
                                                                        <input type="hidden" name="i_c_id"
                                                                            value="{{ $item->id }}">
                                                                        <button type="submit"
                                                                            class="btn btn-danger">Delete</button>
                                                                    </form>
                                                                    <button type="button" class="btn btn-default"
                                                                        data-dismiss="modal">Cancel</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!--Edit Form Here-->
                                                    <div class="modal fade"
                                                    id="edit-modal{!! $item->id !!}" role="dialog">
                                                    <div class="modal-dialog modal-lg ">
                                                        <!-- Modal content-->
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h4 class="modal-title">Edit Service Charge</h4>
                                                                <button type="button" class="close"
                                                                    data-dismiss="modal"
                                                                    aria-label="Close"><span
                                                                        aria-hidden="true">&times;</span></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form action="{{ route('service_charge.update',$item->id) }}" method="post">
                                                                    @if (!empty(Session::get('error_code')) && Session::get('error_code') == $item->id)
                                                                        @include('layout/flash-message')
                                                                    @endif
                                                                    @method('PATCH')
                                                                    @csrf
                                                                    <div class="row">
                                                                        <div class="col-md-4">
                                                                            <div class="form-group">
                                                                                <label for="company_id">Property</span></label>
                                                                                <select name="company_id" id="company_id" class="form-control">
                                                                                    <option value="" selected disabled>--Select--</option>
                                                                                    @foreach ($complists as $key => $comp)
                                                                                        <option {{ $item->company_id == $key ?'selected':'' }} value="{{ $key }}">
                                                                                            {{ $comp }}</option>
                                                                                    @endforeach
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <div class="form-group">
                                                                                <label for="Year">Year</label>
                                                                                <div class="controls">
                                                                                    {!! Form::number('Year', $item->year, array('readonly', 'class'=>'form-control', 'id' => 'Year', 'min'=>'2021', 'max'=>'2100', 'placeholder'=>'Year', 'value'=>Input::old('Year'))) !!}
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <div class="form-group">
                                                                                <label for="Month">Month</label>
                                                                                <div class="controls">
                                                                                    {!! Form::selectMonth('Month', $item->month, array('required', 'class' => 'form-control', 'id' => 'Month', 'value'=>Input::old('Month'))) !!}
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <div class="form-group">
                                                                                <label for="amount">Amount</label>
                                                                                <input type="number" pattern ='[0-9]+([\.,][0-9]+)?'  step ='0.01'  min= '0', placeholder="Amount" name="amount"
                                                                                    class="form-control" value="{{ old('amount',$item->amount) }}">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <div class="form-group">
                                                                                <label for="C4S">Status</label>
                                                                                <div class="controls">
                                                                                    <select name="status" id="" class="form-control">
                                                                                        <option {{ $item->status ==1?'selected':'' }}  value="1">Active</option>
                                                                                        <option {{ $item->status ==0?'selected':'' }} value="0">Inactive</option>
                                                                                    </select>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="submit" class="btn btn-success">Submit</button>
                                                                        <button type="button" class="btn btn-default"
                                                                            data-dismiss="modal">Cancel</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                @if (!empty(Session::get('error_code')) && Session::get('error_code') == $item->id)
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

@stop
