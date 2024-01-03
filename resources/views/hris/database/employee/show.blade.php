@extends('layout.app')
@section('title', 'HRIS | Employee')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0" style="text-align: right;">Employee ID: {{ $uniqueemp->EmployeeID }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{!! url('hris/dashboard') !!}">HRIS</a></li>
                        <li class="breadcrumb-item"><a href="javascript::void(0)">Database</a></li>
                        <li class="breadcrumb-item"><a href="{!! url('hris/database/employee') !!}">Employee</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Show</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="content">

        <div class="row">
            <div class="col-lg-12">
                <div class="float-right">
                    <div class="form-group">

                        <table class="table" style="margin-top: -10px; margin-bottom: 0px;">
                            @if (!Sentinel::inRole('general') && !Sentinel::inRole('manager'))
                                <tr>
                                    <td style="width: 50%; border: none;">
                                        {!! Form::open(['action' => '\App\Http\Controllers\HRIS\Database\EmployeeController@getSearch']) !!}
                                        {!! Form::number('search', null, [
                                            'required',
                                            'class' => 'form-control',
                                            'min' => '000100',
                                            'max' => '999999',
                                            'placeholder' => 'Employee ID',
                                        ]) !!}
                                        {!! Form::number('TabNo', 1, ['class' => 'form-control hidden', 'id' => 'TabNo']) !!}
                                    </td>
                                    <td style="width: 25%; border: none;">
                                        {!! Form::submit('Search', ['class' => 'btn btn-sm btn-default']) !!}
                                        {!! Form::close() !!}
                                    </td>
                                    <td style="width: 25%; border: none;">
                                        <a href="{!! URL('hris/database/employee') !!}" class="btn btn-sm btn-primary"
                                            style="float: right;">
                                            <span class="fa-solid fa-arrow-left"></span>&nbsp;Back </a>
                                    </td>
                                </tr>
                            @endif
                        </table>

                    </div>
                </div>
            </div>
        </div>

        <div class="row" style="margin-top: {{ "Sentinel::inRole('general') && Sentinel::inRole('manager')" ? '' : '-20px' }};">
            <div class="col-lg-12">
                <div class="card card-primary card-outline card-outline-tabs">
                    <div class="card-header p-0 border-bottom-0">
                        <ul class="nav nav-tabs" id="employee-tabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link {!! $tab == 1 ? 'active' : '' !!}" id="basic-tab" data-target="basic"
                                    href="{!! URL('hris/database/employee', [$uniqueemp->id]) !!}?tab=1" role="tab" aria-controls="basic"
                                    aria-selected="{!! $tab == 1 ? 'true' : 'false' !!}">Basic Info</a>
                            </li>
                            @if (!Sentinel::inRole('general') && !Sentinel::inRole('manager'))
                            <li class="nav-item">
                                <a class="nav-link {!! $tab == 2 ? 'active' : '' !!}" id="salary-tab" data-target="salary"
                                    href="{!! URL('hris/database/employee', [$uniqueemp->id]) !!}?tab=2" role="tab" aria-controls="salary"
                                    aria-selected="{!! $tab == 2 ? 'true' : 'false' !!}">Salary</a>
                            </li>
                            @endif
                            <li class="nav-item">
                                <a class="nav-link {!! $tab == 11 ? 'active' : '' !!}" id="granter-tab" data-target="granter"
                                    href="{!! URL('hris/database/employee', [$uniqueemp->id]) !!}?tab=11" role="tab" aria-controls="granter"
                                    aria-selected="{!! $tab == 11 ? 'true' : 'false' !!}">Grantor</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {!! $tab == 3 ? 'active' : '' !!}" id="education-tab" data-target="education"
                                    href="{!! URL('hris/database/employee', [$uniqueemp->id]) !!}?tab=3" role="tab" aria-controls="education"
                                    aria-selected="{!! $tab == 3 ? 'true' : 'false' !!}">Education</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {!! $tab == 4 ? 'active' : '' !!}" id="training-tab" data-target="training"
                                    href="{!! URL('hris/database/employee', [$uniqueemp->id]) !!}?tab=4" role="tab" aria-controls="training"
                                    aria-selected="{!! $tab == 4 ? 'true' : 'false' !!}">Training</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {!! $tab == 5 ? 'active' : '' !!}" id="experience-tab" data-target="experience"
                                    href="{!! URL('hris/database/employee', [$uniqueemp->id]) !!}?tab=5" role="tab" aria-controls="experience"
                                    aria-selected="{!! $tab == 5 ? 'true' : 'false' !!}">Experience</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {!! $tab == 7 ? 'active' : '' !!}" id="reference-tab" data-target="reference"
                                    href="{!! URL('hris/database/employee', [$uniqueemp->id]) !!}?tab=7" role="tab" aria-controls="reference"
                                    aria-selected="{!! $tab == 7 ? 'true' : 'false' !!}">Reference</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {!! $tab == 8 ? 'active' : '' !!}" id="document-tab" data-target="document"
                                    href="{!! URL('hris/database/employee', [$uniqueemp->id]) !!}?tab=8" role="tab" aria-controls="document"
                                    aria-selected="{!! $tab == 8 ? 'true' : 'false' !!}">Document</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {!! $tab == 9 ? 'active' : '' !!}" id="personal-tab" data-target="personal"
                                    href="{!! URL('hris/database/employee', [$uniqueemp->id]) !!}?tab=9" role="tab" aria-controls="personal"
                                    aria-selected="{!! $tab == 9 ? 'true' : 'false' !!}">Personal</a>
                            </li>

                            {{-- <li class="nav-item">
                                <a class="nav-link {!! $tab == 10 ? 'active' : '' !!}" id="bangla-tab" data-target="bangla"
                                    href="{!! URL('hris/database/employee', [$uniqueemp->id]) !!}?tab=10" role="tab" aria-controls="bangla"
                                    aria-selected="{!! $tab == 10 ? 'true' : 'false' !!}">Bangla</a>
                            </li> --}}
                            <li class="nav-item">
                                <a class="nav-link {!! $tab == 12 ? 'active' : '' !!}" id="settings-tab" data-target="settings"
                                    href="{!! URL('hris/database/employee', [$uniqueemp->id]) !!}?tab=12" role="tab" aria-controls="settings"
                                    aria-selected="{!! $tab == 12 ? 'true' : 'false' !!}">Change Password</a>
                            </li>

                        </ul>
                    </div>

                    <div class="card-body">
                        <div class="tab-content" id="employee-tabsContent">
                            @if ($tab == 1)
                                <div class="tab-pane fade {!! $tab == 1 ? 'show active' : '' !!}" id="basic" role="tabpanel"
                                    aria-labelledby="basic-tab">
                                    @include('hris/database/employee/tab1')
                                    <script type="text/javascript">
                                        $('#TabNo').val(1);
                                    </script>
                                </div>
                                @elseif($tab == 2)
                                    <div class="tab-pane fade {!! $tab == 2 ? 'show active' : '' !!}" id="salary" role="tabpanel"
                                        aria-labelledby="salary-tab">
                                        @include('hris/database/employee/tab2')
                                        <script type="text/javascript">
                                            $('#TabNo').val(2);
                                        </script>
                                    </div>
                                @elseif($tab == 11)
                                    <div class="tab-pane fade {!! $tab == 11 ? 'show active' : '' !!}" id="granter" role="tabpanel"
                                        aria-labelledby="granter-tab">
                                        @include('hris/database/employee/tab11')
                                        <script type="text/javascript">
                                            $('#TabNo').val(11);
                                        </script>
                                    </div>
                                @elseif($tab == 3)
                                    <div class="tab-pane fade {!! $tab == 3 ? 'show active' : '' !!}" id="education" role="tabpanel"
                                        aria-labelledby="education-tab">
                                        @include('hris/database/employee/tab3')
                                        <script type="text/javascript">
                                            $('#TabNo').val(3);
                                        </script>
                                    </div>
                                @elseif($tab == 4)
                                    <div class="tab-pane fade {!! $tab == 4 ? 'show active' : '' !!}" id="training" role="tabpanel"
                                        aria-labelledby="training-tab">
                                        @include('hris/database/employee/tab4')
                                        <script type="text/javascript">
                                            $('#TabNo').val(4);
                                        </script>
                                    </div>
                                @elseif($tab == 5)
                                    <div class="tab-pane fade {!! $tab == 5 ? 'show active' : '' !!}" id="experience" role="tabpanel"
                                        aria-labelledby="experience-tab">
                                        @include('hris/database/employee/tab5')
                                        <script type="text/javascript">
                                            $('#TabNo').val(5);
                                        </script>
                                    </div>
                                @elseif($tab == 7)
                                    <div class="tab-pane fade {!! $tab == 7 ? 'show active' : '' !!}" id="reference" role="tabpanel"
                                        aria-labelledby="reference-tab">
                                        @include('hris/database/employee/tab7')
                                        <script type="text/javascript">
                                            $('#TabNo').val(7);
                                        </script>
                                    </div>
                                @elseif($tab == 8)
                                    <div class="tab-pane fade {!! $tab == 8 ? 'show active' : '' !!}" id="document" role="tabpanel"
                                        aria-labelledby="document-tab">
                                        @include('hris/database/employee/tab8')
                                        <script type="text/javascript">
                                            $('#TabNo').val(8);
                                        </script>
                                    </div>
                                @elseif($tab == 9)

                                    <div class="tab-pane fade {!! $tab == 9 ? 'show active' : '' !!}" id="personal" role="tabpanel"
                                        aria-labelledby="personal-tab">
                                        @include('hris/database/employee/tab9')
                                        <script type="text/javascript">
                                            $('#TabNo').val(9);
                                        </script>
                                    </div>
                                @elseif($tab == 10)
                                    <div class="tab-pane fade {!! $tab == 10 ? 'show active' : '' !!}" id="bangla" role="tabpanel"
                                        aria-labelledby="bangla-tab">
                                        @include('hris/database/employee/tab10')
                                        <script type="text/javascript">
                                            $('#TabNo').val(10);
                                        </script>
                                    </div>
                                @elseif($tab == 12)
                                    <div class="tab-pane fade {!! $tab == 12 ? 'show active' : '' !!}" id="" role="tabpanel"
                                        aria-labelledby="settings-tab">
                                        @include('hris/database/employee/tab12')
                                        <script type="text/javascript">
                                            $('#TabNo').val(12);
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
