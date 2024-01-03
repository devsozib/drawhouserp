@extends('layout.app')
@section('title', 'HRIS | Applicant')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-2 p-4" style="text-align: right;">Applicant</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{!! url('hris/dashboard') !!}">HRIS</a></li>
                        <li class="breadcrumb-item"><a href="javascript::void(0)">Applicant</a></li>
                        <li class="breadcrumb-item"><a href="{!! url('hris/applicant/new-applicant') !!}">New Applicant</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Add</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="row" style="margin-top: -20px;">
            <div class="col-lg-12">
                <div class="card card-primary card-outline card-outline-tabs">
                    <div class="card-header p-0 border-bottom-0">
                        <ul class="nav nav-tabs" id="employee-tabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link {!! $tab == 1 ? 'active' : '' !!}" id="basic-tab" data-target="basic"
                                    href="{!! URL('hris/applicant/new-applicant', [1]) !!}?tab=1" role="tab" aria-controls="basic"
                                    aria-selected="{!! $tab == 1 ? 'true' : 'false' !!}">Basic Info</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {!! $tab == 2 ? 'active' : '' !!}" id="salary-tab" data-target="salary"
                                    href="{!! URL('hris/applicant/new-applicant', [1]) !!}?tab=2" role="tab" aria-controls="salary"
                                    aria-selected="{!! $tab == 2 ? 'true' : 'false' !!}">Education</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {!! $tab == 3 ? 'active' : '' !!}" id="education-tab" data-target="education"
                                    href="{!! URL('hris/applicant/new-applicant', [1]) !!}?tab=3" role="tab" aria-controls="education"
                                    aria-selected="{!! $tab == 3 ? 'true' : 'false' !!}">Experience</a>
                            </li>
                        </ul>
                    </div>

                    <div class="card-body">
                        <div class="tab-content" id="employee-tabsContent">
                            @if ($tab == 1)
                                <div class="tab-pane fade {!! $tab == 1 ? 'show active' : '' !!}" id="basic" role="tabpanel"
                                    aria-labelledby="basic-tab">
                                    @include('hris/applicant/new-applicant/tab1')
                                    <script type="text/javascript">
                                        $('#TabNo').val(1);
                                    </script>
                                </div>
                            @elseif($tab == 2)
                                <div class="tab-pane fade {!! $tab == 2 ? 'show active' : '' !!}" id="salary" role="tabpanel"
                                    aria-labelledby="salary-tab">
                                    @include('hris/applicant/new-applicant/tab2')
                                    <script type="text/javascript">
                                        $('#TabNo').val(2);
                                    </script>
                                </div>
                            @elseif($tab == 3)
                                <div class="tab-pane fade {!! $tab == 3 ? 'show active' : '' !!}" id="education" role="tabpanel"
                                    aria-labelledby="education-tab">
                                    @include('hris/applicant/new-applicant/tab3')
                                    <script type="text/javascript">
                                        $('#TabNo').val(3);
                                    </script>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@stop
<script>
    function getThana(id, type) {
        $.ajax({
            type: "GET",
            url: "{{ url('hris/database/getthana') }}",
            data: {
                dist_id: id,
                type: 'forForntend'
            },
            success: function(data) {
                if (data) {
                    if (type == 'prsnt_district') {
                        $("#present_thana").empty();
                        $.each(data, function(key, item) {
                            $('#present_thana').append('<option value="' + item.id + '">' + item
                                .Name + '</option>');
                        });
                    } else {
                        $("#par_thana").empty();
                        $.each(data, function(key, item) {
                            $('#par_thana').append('<option value="' + item.id + '">' + item.Name +
                                '</option>');
                        });
                    }
                } else {
                    $("#present_thana").empty();
                }
            }
        });
    }
</script>
