@extends('layout.app')
@section('title', 'HRIS | Leave Status')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0" style="text-align: right;"></h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{!! url('hris/dashboard') !!}">HRIS</a></li>
                        <li class="breadcrumb-item"><a href="javascript::void(0)">Database</a></li>
                        <li class="breadcrumb-item"><a href="{!! url('hris/database/leavestatus') !!}">Leave Status</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Index</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="row">
            <div class="col-lg-12">
                {!! Form::open(array('action' => array('\App\Http\Controllers\HRIS\Database\LeaveStatusController@store', 'method' => 'Post'))) !!}
                <div class="card">
                    <div class="card-header with-border" style="font-size: 22px; text-align: center;">Leave Status ({!! count($leavedatas) !!})</div>
                    <div class="card-body">
                        <div style="max-height: 450px; min-height: 450px; overflow: auto;">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Employee ID</th>
                                        <th>Name</th>
                                        <th>Designation</th>
                                        <th>Department</th>
                                        <th>Joining Date</th>
                                        <th>Start Date</th>
                                        <th>End Date</th>
                                        <th style="text-align: center;">Days</th>
                                        <th style="text-align: center;">Type</th>
                                        <th>Input Date</th>
                                        <th>Head Approval</th>
                                        <th>Management Approval</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $sl1 = 1; ?>
                                    @foreach($leavedatas as $enfinc)
                                    <tr>
                                        <td>
                                            <input type="checkbox" name="LVID[]" id="LVID" class="LVID hidden" value="{!! $enfinc->id !!}"> {!! str_pad($enfinc->EmployeeID, 6, "0", STR_PAD_LEFT) !!}
                                        </td>
                                        <td>{!! $enfinc->Name !!}</td>
                                        <td>{!! $enfinc->Designation !!}</td>
                                        <td>{!! $enfinc->Department !!}</td>
                                        <td>{!! date('d-m-Y', strtotime($enfinc->JoiningDate)) !!}</td>
                                        <td>{!! date('d-m-Y', strtotime($enfinc->StartDate)) !!}</td>
                                        <td>{!! date('d-m-Y', strtotime($enfinc->EndDate)) !!}</td>
                                        <td style="text-align: center;">{!! \Carbon\Carbon::parse($enfinc->EndDate)->diffInDays(\Carbon\Carbon::parse($enfinc->StartDate))+1 !!}</td>
                                        <td style="text-align: center;">{!! $enfinc->LeaveTypeID !!}</td>
                                        <td>{!! date('d-m-Y', strtotime($enfinc->created_at)) !!}</td>
                                        <td style="text-align: center;">
                                            @if($edit)
                                                @if(getApproval($enfinc->id))
                                                    <a href="javascript::void(0)" id="{!! $enfinc->id !!}" class="forwarding hidden forw{!! $enfinc->id !!}"><img style="width:20px" id="forwarding-image-{!! $enfinc->id !!}" src="{{url('/images')}}{!! (getForwarding($enfinc->id)) ? '/publish_2.png' : '/not_publish_2.png' !!}" title="{!! (getForwarding($enfinc->id)) ? 'Forwarded' : 'Default'  !!}" alt="{!! (getForwarding($enfinc->id)) ? 'Forwarded' : 'Default'  !!}"/></a>
                                                @else
                                                    <a href="javascript::void(0)" id="{!! $enfinc->id !!}" class="forwarding forw{!! $enfinc->id !!}"><img style="width:20px" id="forwarding-image-{!! $enfinc->id !!}" src="{{url('/images')}}{!! (getForwarding($enfinc->id)) ? '/publish_2.png' : '/not_publish_2.png' !!}" title="{!! (getForwarding($enfinc->id)) ? 'Forwarded' : 'Default'  !!}" alt="{!! (getForwarding($enfinc->id)) ? 'Forwarded' : 'Default'  !!}"/></a>
                                                @endif
                                            @endif
                                        </td>
                                        <td style="text-align: center;">
                                            @if($edit)
                                                @if(getForwarding($enfinc->id))
                                                    <a href="javascript::void(0)" id="{!! $enfinc->id !!}" class="approval appr{!! $enfinc->id !!}"><img style="width:20px" id="approval-image-{!! $enfinc->id !!}" src="{{url('/images')}}{!! (getApproval($enfinc->id)) ? '/publish_2.png' : '/not_publish_2.png' !!}" title="{!! (getApproval($enfinc->id)) ? 'Approved' : 'Default'  !!}" alt="{!! (getApproval($enfinc->id)) ? 'Approved' : 'Default'  !!}"/></a>
                                                @else
                                                    <a href="javascript::void(0)" id="{!! $enfinc->id !!}" class="approval hidden appr{!! $enfinc->id !!}"><img style="width:20px" id="approval-image-{!! $enfinc->id !!}" src="{{url('/images')}}{!! (getApproval($enfinc->id)) ? '/publish_2.png' : '/not_publish_2.png' !!}" title="{!! (getApproval($enfinc->id)) ? 'Approved' : 'Default'  !!}" alt="{!! (getApproval($enfinc->id)) ? 'Approved' : 'Default'  !!}"/></a>
                                                @endif
                                            @endif
                                        </td>
                                    </tr>
                                    <?php $sl1++; ?>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    {{-- <div class="card-footer">
                        Total: {!! count($leavedatas) !!}
                        &nbsp;&nbsp;<button type="button" id="check_all" class="btn">Check All</button> &nbsp;&nbsp;<button type="button" id="uncheck_all" class="btn">Uncheck All</button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        @if($create)
                            {!! Form::submit('Save', array('class' => 'btn btn-success')) !!}
                        @endif
                    </div> --}}
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>

    <script type="text/javascript">
        $('#check_all').click(function() {
            $('.LVID').prop('checked', true);
        });
        $('#uncheck_all').click(function() {
            $('.LVID').prop('checked', false);
        });

        $(document).ready(function () {
            $(".forwarding").bind("click", function (e) {
                var id = $(this).attr('id');
                e.preventDefault();
                $.ajax({
                    type: "POST",
                    //url: "{!! url('/hris/database/" + id + "/fowarding/') !!}",
                    url: "{!! url('/hris/database/leavestatus/" + id + "') !!}",
                    headers: {
                        'X-CSRF-Token': $('meta[name="_token"]').attr('content'),
                    },
                    data: {
                        'form_id': 1,
                    },
                    success: function (response) {
                        if (response['result'] == 'success') {
                            var imagePath = (response['changed'] == 1) ? "{{url('/images/publish_2.png')}}" : "{{url('/images/not_publish_2.png')}}";
                            $("#forwarding-image-" + id).attr('src', imagePath);
                            if (response['changed'] == 1) {
                                toastr.success("Leave Successfully Forwarded");
                                $('.appr' + id).removeClass('hidden');
                            } else {
                                toastr.warning("Leave Successfully Discarded");
                                $('.appr' + id).addClass('hidden');
                            }
                        } else {
                            toastr.warning("You are not permitted to perform this task");
                        }
                    },
                    error: function () {
                        toastr.warning("Validation Error!");
                    }
                })
            });
            $(".approval").bind("click", function (e) {
                var id = $(this).attr('id');
                e.preventDefault();
                $.ajax({
                    type: "POST",
                    //url: "{!! url('/hris/database/" + id + "/fowarding/') !!}",
                    url: "{!! url('/hris/database/leavestatus/" + id + "') !!}",
                    headers: {
                        'X-CSRF-Token': $('meta[name="_token"]').attr('content'),
                    },
                    data: {
                        'form_id': 2,
                    },
                    success: function (response) {
                        if (response['result'] == 'success') {
                            var imagePath = (response['changed'] == 1) ? "{{url('/images/publish_2.png')}}" : "{{url('/images/not_publish_2.png')}}";
                            $("#approval-image-" + id).attr('src', imagePath);
                            if (response['changed'] == 1) {
                                toastr.success("Leave Successfully Approved");
                                $('.forw' + id).addClass('hidden');
                            } else {
                                toastr.warning("Leave Successfully Rejected");
                                $('.forw' + id).removeClass('hidden');
                            }
                        } else {
                            toastr.warning("You are not permitted to perform this task");
                        }
                    },
                    error: function () {
                        toastr.warning("Validation Error!");
                    }
                })
            });
        });

    </script>

@stop
