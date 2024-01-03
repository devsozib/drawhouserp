@extends('layout.app')
@section('title', 'HRIS | Applicant')
@section('content')
    <style>
        .rating {
            display: inline-block;
            font-size: 30px;
        }

        .star {
            cursor: pointer;
            color: #ccc;
        }

        .star:hover,
        .star.selected {
            color: #ffcc00;
        }
    </style>
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    {{-- <h1 class="m-0" style="text-align: right;">Applicant details of <span
                            class="text-primary">{{ $applicant->Name }}</span></h1> --}}
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{!! url('hris/dashboard') !!}">HRIS</a></li>
                        <li class="breadcrumb-item"><a href="javascript::void(0)">Database</a></li>
                        <li class="breadcrumb-item"><a href="{!! url('hris/database/applicant') !!}">Applicant Interview</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Index</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="card">
            <h5 class="m-0 p-3 text-center">Job Performance Appraisal</span>
            </h5>
            <div id="allPerfomanceLink" class="d-none" style="text-align: center">
                <a href="#" id="allPerformanceUrl" class="btn btn-primary" target="_blank">Click here to see all performance</a>
            </div>
            <div class="card-body">
                @if (!empty(Session::get('error_code')) && Session::get('error_code') == 'Add')
                    @include('layout/flash-message')
                @endif
                <form id="rating-form" action="{{ route('performance.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="Name">Organization</span></label>
                                                <select name="department"
                                                    class="form-control select2bs4" disabled>
                                                    <option value="" selected disabled>--Select--</option>
                                                    @foreach ($concerns as $item)
                                                        <option  {{ getHostInfo()['id'] == $item->id ?'selected':'' }} value="{{ $item->id }}">
                                                            {{ $item->Name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="Name">Department</span></label>
                                                <select class="form-control select2bs4" name="deparmentSelect"
                                                    id="deparmentSelect">
                                                    <option value="">--Choose one--</option>
                                                    @foreach ($deptlist as $item)
                                                    <option value="{{ $item->id }}">
                                                        {{ $item->Department }}</option>
                                                @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="Name">Employee</span></label>
                                                <select name="employee" id="employee" class="form-control select2bs4">
                                                    <option value="" selected disabled>--Select--</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="Name">ID</span></label>
                                                <input type="text" readonly id="employee_id" placeholder="Employee ID"
                                                    class="form-control">
                                            </div>
                                        </div>     
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="Name">Performance Month</span></label>
                                                <input type="text" placeholder="Pick date"
                                                    class="form-control year-and-month" name="perf_date">
                                            </div>
                                        </div>                                   
                                    </div>
                                    {{-- <div class="row mt-2">                                                                                                              
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="Name">Last Performance</span></label>
                                                <input type="text" id="last_performance" placeholder="Last performance"
                                                    readonly class="form-control">
                                            </div>
                                        </div>
                                    </div> --}}
                                    <div id="appraisal1">

                                    </div>
                                    <div id="appraisal2">

                                    </div>
                                    <div class="d-none" id="remarks" >
                                        <div class="col-md-4 mt-2">
                                            <label>Remarks</label>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="remarks">
                                                <input type="text" name="remarks" class="form-control" placeholder="Write remarks" value="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-right mt-3">
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </form>
            </div>
        </div>

    </div>
    <script>
        $(document).ready(function() {
            $('#deparmentSelect').on('input', function() {
                var deparmentId = $(this).val();
                if (deparmentId) {
                    $.ajax({
                        url: '{{ url('getempandjobappraisal') }}',
                        type: 'GET',
                        data: {
                            'deparmentId': deparmentId
                        },
                        success: function(data) {                            
                            $('#employee').empty();
                            $('#employee').append(
                                '<option selected value="">--Select--</option>');
                            $.each(data[0], function(index, employee) {
                                $('#employee').append('<option value="' + employee.EmployeeID +
                                    '">' + employee.Name + '</option>');
                            });
                            // $('#appraisal').html(data[1]);
                            var appraisalDiv1 = $('#appraisal1');
                            var appraisalDiv2 = $('#appraisal2');
                            if (!appraisalDiv1.hasClass('populated')) {
                                appraisalDiv1.html(data[1]);
                                appraisalDiv1.addClass('populated');
                                attachRatingEventHandlers();
                            }
                            appraisalDiv2.html(data[2]);
                            attachRatingEventHandlers();
                            $('#remarks').removeClass('d-none');
                        }
                    });
                } else {
                    $('#employee').empty();
                    $('#employee').append(
                        '<option value="">--Select--</option>');
                }
            });
        });
        $(document).ready(function() {
            $('#employee').on('input', function() {
                var emp_id = $(this).val();
                if (emp_id) {
                    $.ajax({
                        url: '{{ url('getempinfo') }}',
                        type: 'GET',
                        data: {
                            'emp_id': emp_id
                        },
                        success: function(data) {
                            console.log(data);
                            document.getElementById("employee_id").value = data[0].EmployeeID;
                            var employeeID = data[0].EmployeeID;
                            var link = '{{ route('performance.show', ':employeeID') }}';
                            link = link.replace(':employeeID', employeeID);
                            $('#allPerformanceUrl').attr('href', link);
                            var totalPerformance  = data[1];
                            var myDiv = document.getElementById("allPerfomanceLink");
                            if(totalPerformance > 0){
                                myDiv.classList.remove("d-none");
                            }else{
                                myDiv.classList.add("d-none");
                            }                       
                        }
                    });
                }
            });
        });
    </script>
    <script>
        function attachRatingEventHandlers() {
            $('.rating .star').click(function() {
                var rating = $(this).attr('data-value');
                var ratingInput = $(this).siblings('.rating-input');
                ratingInput.val(rating);
                $(this).addClass('selected');
                $(this).prevAll('.star').addClass('selected');
                $(this).nextAll('.star').removeClass('selected');
            });
        }

        // function getDepartment(id) {
        //     $.ajax({
        //         type: "GET",
        //         url: "{{ url('getdepartment') }}",
        //         data: {
        //             concern_id: id,
        //         },
        //         success: function(data) {
        //             console.log(data);
        //             if (data) {
        //                 $("#deparmentSelect").empty();
        //                 $.each(data, function(key, item) {
        //                     $('#deparmentSelect').append('<option value="' + item.id + '">' + item
        //                         .Department + '</option>');
        //                 });
        //             } else {
        //                 $("#deparmentSelect").empty();
        //             }
        //             $("#deparmentSelect").prepend('<option value="" selected>--Choose one--</option>');
        //         }
        //     });
        // }
    </script>
@stop
