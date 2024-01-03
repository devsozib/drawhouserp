
@extends('layout.app')
@section('title', 'HRIS | Attendance Status')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0" style="text-align: right;">Attendance Status</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{!! url('hris/dashboard') !!}">HRIS</a></li>
                        <li class="breadcrumb-item"><a href="javascript::void(0)">Database</a></li>
                        <li class="breadcrumb-item"><a href="{!! url('hris/database/attendance_status') !!}">Attendance Approval</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Index</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <div style="max-height: 450px; min-height: 450px; overflow: auto;">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Employee ID</th>
                                        <th>Name</th>
                                        <th>Designation</th>
                                        <th>Request Date</th>
                                        <th>Effective Date</th>
                                        <th>Request Type</th>
                                        <th>Details</th>
                                        <th>Head Approval</th>
                                        <th>Management Approval</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($attendanceApprovals as $approval)
                                        <tr>
                                            <td>{{ $approval->EmployeeID }}</td>
                                            <td>{{ $approval->Name }}</td>
                                            <td>{{ $approval->Designation }}</td>
                                            <td>{{ format($approval->created_at, 'Y-m-d') }}</td>
                                            <td>{{ $approval->effective_date }}</td>
                                            <td>{{ abnormalAttendanceType()[$approval->request_type] }}</td>
                                            <td>{{ $approval->details }}</td>
                                            <td style="text-align: center;">
                                                @if($edit)
                                                    <a href="javascript:void(0)" class="forwarding"><img id="forwardBtn{{$approval->id}}" onclick="forwareded({{$approval->id}},this)"  data-isForwarded="{{ $approval->IsForwarded }}" class="{{ $approval->IsApproved == "Y" ? 'd-none' : '' }}"  style="width:30px" src="{{url('/images')}}{!! $approval->IsForwarded=='Y' ? '/publish_2.png' : '/not_publish_2.png' !!}"/></a>
                                                @endif
                                            </td>
                                            <td  style="text-align: center;">
                                                @if($edit)
                                                    <a href="javascript:void(0)" class="forwarding"><img id="approveBtn{{$approval->id}}" onclick="approved({{$approval->id}},this)"  data-isApproved="{{ $approval->IsApproved }}" class="{{ $approval->IsForwarded == "N" ? 'd-none' : '' }}" style="width:30px" src="{{url('/images')}}{!! $approval->IsApproved=='Y' ? '/publish_2.png' : '/not_publish_2.png' !!}"/></a>
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

    @section("js")
        <script type="text/javascript">
            $('#effectiveDate').datepicker({
                format: "yyyy-mm-dd",
                todayBtn: "linked",
                orientation: "top auto",
                autoclose: true,
                todayHighlight: true,
            });

            function forwareded(id,ele){
                var value = ele.dataset['isforwarded'];
                var img = null;
                if(value=="Y") {value = "N"; img = "{{url('/images/not_publish_2.png')}}";}
                else if(value=="N") {value = "Y"; img = "{{url('/images/publish_2.png')}}";}
                updateColumnValue('AttendanceApproval', id, 'IsForwarded', value, function(res){
                    if(res){
                        if(value=="Y") {
                            document.getElementById('approveBtn'+id).classList.remove('d-none');
                        }
                        else if(value=="N") {
                            document.getElementById('approveBtn'+id).classList.add('d-none');
                        }
                        ele.dataset['isforwarded'] = value;
                        ele.src = img;
                    }
                });
            }

            function approved(id,ele){
                var value = ele.dataset['isapproved'];
                var img = null;
                if(value=="Y") {value = "N"; img = "{{url('/images/not_publish_2.png')}}";}
                else if(value=="N") {value = "Y"; img = "{{url('/images/publish_2.png')}}";}
                updateColumnValue('AttendanceApproval', id, 'IsApproved', value, function(res){
                    //console.log(res);
                    if(res){
                        if(value=="Y") {
                            document.getElementById('forwardBtn'+id).classList.add('d-none');
                        }
                        else if(value=="N") {
                            document.getElementById('forwardBtn'+id).classList.remove('d-none');
                        }
                        ele.dataset['isapproved'] = value;
                        ele.src = img;
                    }
                });
            }
        </script>
    @endsection
@stop
