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
        input[type="radio"]:checked {
            background-color: #3498db; /* Change the background color to your desired color */
            border-color: #3498db; /* Change the border color to match the background color */
            color: #fff; /* Change the text color to white or a color that contrasts well with the background */
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
                        <li class="breadcrumb-item"><a href="javascript::void(0)">Applicant</a></li>
                        <li class="breadcrumb-item"><a href="{!! url('hris/applicant/new-applicant') !!}">New Applicant</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Index</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="card">
            <h5 class="m-0 p-3 text-center">Applicant details of <span class="text-primary">{{ $applicant->Name }}</span>
            </h5>
            @if ($checkEmp)
                <h4 class="m-0 p-3 text-center">{{ $applicant->Name }} is a former employee of . <span class="text-primary">{{ getCompanyName($checkEmp->company_id)['Name'] }}</span>
                </h4>
            @endif        
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <nav>
                            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                <button class="nav-link active" id="nav-home-tab" data-toggle="tab"
                                    data-target="#nav_applying_for" type="button" role="tab" aria-controls="nav-home"
                                    aria-selected="true">Applying For
                                </button>
                                <button class="nav-link" id="nav-profile-tab" data-toggle="tab" data-target="#personal_info"
                                    type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Personal
                                    Info</button>
                                <button class="nav-link" id="nav-contact-tab" data-toggle="tab"
                                data-target="#granter_info" type="button" role="tab" aria-controls="nav-contact"
                                aria-selected="false">Grantor</button>
                                <button class="nav-link" id="nav-contact-tab" data-toggle="tab"
                                    data-target="#education_info" type="button" role="tab" aria-controls="nav-contact"
                                    aria-selected="false">Education</button>
                                <button class="nav-link" id="nav-contact-tab" data-toggle="tab" data-target="#experiences"
                                    type="button" role="tab" aria-controls="nav-contact"
                                    aria-selected="false">Experiences</button>
                                <button class="nav-link" id="nav-contact-tab" data-toggle="tab" data-target="#reference_info"
                                    type="button" role="tab" aria-controls="nav-contact"
                                    aria-selected="false">Refercence</button>
                                <button class="nav-link" id="nav-contact-tab" data-toggle="tab" data-target="#documents"
                                    type="button" role="tab" aria-controls="nav-contact"
                                    aria-selected="false">Documents</button>
                                @if ($applicant->status == 1)
                                    <button class="nav-link" id="interview" data-toggle="tab"
                                        data-target="#interview_process" type="button" role="tab"
                                        aria-controls="nav-contact" aria-selected="false">Inverviewer Select</button>
                                @endif
                                @if (count($feedbacks) > 0)
                                    <button class="nav-link" id="feedback" data-toggle="tab" data-target="#feedbackstatus"
                                        type="button" role="tab" aria-controls="nav-contact"
                                        aria-selected="false">Feedbacks</button>
                                @endif
                            </div>
                        </nav>
                        <div class="tab-content" id="nav-tabContent">
                            <div class="tab-pane fade show active mt-2 container" id="nav_applying_for" role="tabpanel"
                                aria-labelledby="nav-home-tab">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label>Apply Type:</label>
                                            </div>
                                            <div class="col-md-8">
                                                <p> {{ $applicant->apply_type == 'manual' ? 'Manual' : 'Job Post' }}
                                                </p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label>Status:</label>
                                            </div>
                                            <div class="col-md-8">
                                                <p> {{ $applicant->status == 0 ? 'Pending' : ($applicant->status == 1 ? 'Processing' : ($applicant->status == 2 ? 'Selected' : ($applicant->status == 3 ? 'Rejected' : 'Nothing'))) }}
                                                </p>
                                            </div>
                                        </div>
                                        @if($applicant->Department)
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label>Department:</label>
                                            </div>
                                            <div class="col-md-8">
                                                <p>{{ $applicant->Department }}</p>
                                            </div>
                                        </div>
                                        @endif
                                     
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label>Designation:</label>
                                            </div>
                                            <div class="col-md-8">
                                                <p>{{ $applicant->job_designation != null ? $applicant->job_designation : $applicant->emp_designation }}</p>
                                            </div>
                                        </div>
                                        @if($applicant->experience )
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label>Experience:</label>
                                            </div>
                                            <div class="col-md-8">
                                                <p>{{ $applicant->experience }}</p>
                                            </div>
                                        </div>
                                        @endif
                                        @if($applicant->especality )
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label>Especalities:</label>
                                            </div>
                                            <div class="col-md-8">
                                                <p>{{ $applicant->especality }}</p>
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="personal_info" role="tabpanel"
                                aria-labelledby="nav-profile-tab">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <span><img
                                                    style="width: 200px; border-radius:10px" src="{{ url('public/career/applicant_image',$applicant->image) }}"
                                                    alt="" /></span>
                                            </div>
                                            <div class="col-md-6">

                                            </div>
                                        </div>
                                        @if($applicant->Name )
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label>Name:</label>
                                            </div>
                                            <div class="col-md-8">
                                                <p>{{ $applicant->Name }}</p>
                                            </div>
                                        </div>
                                        @endif
                                        @if($applicant->MobileNo )
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label>Mobile No:</label>
                                            </div>
                                            <div class="col-md-8">
                                                <p>{{ $applicant->MobileNo }}</p>
                                            </div>
                                        </div>
                                        @endif
                                        @if($applicant->email )
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label>Email:</label>
                                            </div>
                                            <div class="col-md-8">
                                                <p>{{ $applicant->email }}</p>
                                            </div>
                                        </div>
                                        @endif
                                        @if($applicant->gender )
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label>Gender:</label>
                                            </div>
                                            <div class="col-md-8">
                                                <p>{{ $applicant->gender }}</p>
                                            </div>
                                        </div>
                                        @endif
                                        @if($applicant->d_o_b )
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label>Date of birth:</label>
                                            </div>
                                            <div class="col-md-8">
                                                <p>{{ \Carbon\Carbon::parse($applicant->d_o_b)->isoFormat('MMM Do YYYY') }}
                                                </p>
                                            </div>
                                        </div>
                                        @endif
                                        @if($applicant->nationality )
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label>Nationality:</label>
                                            </div>
                                            <div class="col-md-8">
                                                <p>{{ $applicant->nationality }}</p>
                                            </div>
                                        </div>
                                        @endif
                                        @if($applicant->NationalIDNo )
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label>National ID:</label>
                                            </div>
                                            <div class="col-md-8">
                                                <p>{{ $applicant->NationalIDNo }}</p>
                                            </div>
                                        </div>
                                        @endif
                                        @if($applicant->prsnt_dis)
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label>Present Address:</label>
                                            </div>
                                            <div class="col-md-8">
                                                <p>{{ $applicant->prsnt_local_add . ',' . $applicant->prsnt_post_office . ',' . $applicant->prsnt_thana . ',' . $applicant->prsnt_dis }}
                                                </p>
                                            </div>
                                        </div>
                                        @endif
                                        @if($applicant->par_dis)
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label>Permanent Address:</label>
                                            </div>
                                            <div class="col-md-8">
                                                <p>{{ $applicant->par_local_add . ',' . $applicant->par_post_office . ',' . $applicant->par_thana . ',' . $applicant->par_dis }}
                                                </p>
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="granter_info" role="tabpanel"
                            aria-labelledby="nav-contact-tab">
                                <div class="card">
                                @forelse ($granters as $item)
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label>Name:</label>
                                            </div>
                                            <div class="col-md-8">
                                                <p>{{ $item->g_name }}</p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label>Occupation:</label>
                                            </div>
                                            <div class="col-md-8">
                                                <p>{{ $item->g_occupation }}</p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label>Organization:</label>
                                            </div>
                                            <div class="col-md-8">
                                                <p>{{ $item->g_organization }}</p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label>Organization Address:</label>
                                            </div>
                                            <div class="col-md-8">
                                                <p>{{ $item->g_org_add }}</p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label>Phone:</label>
                                            </div>
                                            <div class="col-md-8">
                                                <p>{{ $item->g_phone }}
                                                </p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label>Email:</label>
                                            </div>
                                            <div class="col-md-8">
                                                <p>{{ $item->g_email }}</p>
                                            </div>
                                        </div>

                                    </div>
                                 @empty
                                 <h6 class="text-center mt-2 text-warning">No granter data!</h6>
                                @endforelse
                                </div>
                             </div>
                            <div class="tab-pane fade" id="education_info" role="tabpanel"
                                aria-labelledby="nav-contact-tab">
                                @forelse ($education as $item)
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label>Institute:</label>
                                            </div>
                                            <div class="col-md-8">
                                                <p>{{ $item->edu_institute }}</p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label>Degree:</label>
                                            </div>
                                            <div class="col-md-8">
                                                <p>{{ $item->Degree }}</p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label>Result Type:</label>
                                            </div>
                                            <div class="col-md-8">
                                                <p>{{ $item->result_type }}</p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label>Obtained Result:</label>
                                            </div>
                                            <div class="col-md-8">
                                                <p>{{ $item->obt_result }}</p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label>Passing Year:</label>
                                            </div>
                                            <div class="col-md-8">
                                                <p>{{ $item->passing_yr }}
                                                </p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label>Board Name:</label>
                                            </div>
                                            <div class="col-md-8">
                                                <p>{{ $item->Name }}</p>
                                            </div>
                                        </div>

                                    </div>
                                @empty
                                <h6 class="text-center mt-2 text-warning">No education data!</h6>
                                @endforelse

                            </div>
                            <div class="tab-pane fade" id="experiences" role="tabpanel"
                                aria-labelledby="nav-contact-tab">
                                @forelse ($experiences as $item)
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label>Designation:</label>
                                            </div>
                                            <div class="col-md-8">
                                                <p>{{ $item->exp_designation }}</p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label>Organization:</label>
                                            </div>
                                            <div class="col-md-8">
                                                <p>{{ $item->organization }}</p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label>Responsibilities:</label>
                                            </div>
                                            <div class="col-md-8">
                                                <p>{{ $item->responsibilities }}</p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label>From date:</label>
                                            </div>
                                            <div class="col-md-8">
                                                <p>{{ \Carbon\Carbon::parse($item->from_date)->isoFormat('MMM Do YYYY') }}
                                                </p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label>To date:</label>
                                            </div>
                                            <div class="col-md-8">
                                                <p>{{ $item->to_date == 'continuing' ? 'Continuing' : \Carbon\Carbon::parse($item->to_date)->isoFormat('MMM Do YYYY') }}</p>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                <h6 class="text-center mt-2 text-warning">No experience data!</h6>
                                @endforelse
                            </div>
                            <div class="tab-pane fade" id="reference_info" role="tabpanel"
                            aria-labelledby="nav-contact-tab">
                            @foreach ($refercences as $item)
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label>Name:</label>
                                        </div>
                                        <div class="col-md-8">
                                            <p>{{ $item->r_name }}</p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label>Occupation:</label>
                                        </div>
                                        <div class="col-md-8">
                                            <p>{{ $item->r_occupation }}</p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label>Organization:</label>
                                        </div>
                                        <div class="col-md-8">
                                            <p>{{ $item->r_organization }}</p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label>Organization Address:</label>
                                        </div>
                                        <div class="col-md-8">
                                            <p>{{ $item->r_org_add }}</p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label>Phone:</label>
                                        </div>
                                        <div class="col-md-8">
                                            <p>{{ $item->r_phone }}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label>Email:</label>
                                        </div>
                                        <div class="col-md-8">
                                            <p>{{ $item->r_email }}</p>
                                        </div>
                                    </div>

                                </div>
                            @endforeach

                        </div>
                            <div class="tab-pane fade" id="documents" role="tabpanel" aria-labelledby="nav-contact-tab">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label>Applicant CV:</label>
                                            </div>
                                            <div class="col-md-8">
                                                <p><a href="{{ url('public/employee/applicant_cv', $applicant->cvfile) }}"
                                                        target="_blank"><img
                                                            src="{{ asset('public/career') }}/img/pdf.png" alt=""
                                                            width="30" height="30"></a></p>
                                            </div>
                                        </div>
                                        @if ($applicant->nidfile)
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <label>Applicant NID:</label>
                                                </div>
                                                <div class="col-md-8">
                                                    <p><a href="{{ url('public/employee/nid', $applicant->nidfile) }}"
                                                            target="_blank"><img
                                                                src="{{ asset('public/career') }}/img/pdf.png"
                                                                alt="" width="30" height="30"></a></p>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            @if ($applicant->status == 1)
                                <div class="tab-pane fade" id="interview_process" role="tabpanel"
                                    aria-labelledby="nav-contact-tab">
                                    <div class="card" id="card">
                                        <div class="card-body mt-2">
                                            <form action="{{ route('interviews.store') }}" method="post" id="firstForm">
                                                @csrf
                                                <input type="hidden" name="for" value="assign_interviewer">
                                                <input type="hidden" name="step" value="first">
                                                <input type="hidden" name="emp_id" value="{{ $applicant->emp_id }}">
                                                <input type="hidden" name="job_id" value="{{ $applicant->job_id }}">
                                                <div class="row mt-2">
                                                    <div class="col-md-2">
                                                        <label>Select HR @if ($applicant->interview_status == 1)
                                                                ✅
                                                            @endif
                                                        </label>
                                                    </div>                                                  
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <select class="form-control selectpicker"
                                                                id="exampleFormControlSelect1" name="interviewers[]"
                                                                multiple data-live-search="true"
                                                                {{ $applicant->interview_status == 1 ? 'disabled' : '' }}>
                                                                @foreach (getUsersRoleWise([5, 3]) as $item)
                                                                    <option
                                                                        {{ in_array($item->user_id, [$selectedFirstInterviewers]) ? 'selected' : '' }}
                                                                        value="{{ $item->user_id }}">
                                                                        @if ($item->first_name && $item->last_name) 
                                                                            {!! $item->first_name !!} {!! $item->last_name !!} 
                                                                        @else
                                                                            {!! $item->fullname !!} 
                                                                        @endif
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <input type="text" name="datetime"
                                                            placeholder="Select date time"
                                                            class="form-control datetimepicker"
                                                            value="{{ isset($selectedFirstDatetime[0]) ? $selectedFirstDatetime[0] : '' }}"
                                                            @if (empty($selectedFirstDatetime)) @endif
                                                            {{ $applicant->interview_status == 1 ? 'disabled' : '' }}>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <input type="text" name="location"
                                                            placeholder="Location"
                                                            class="form-control"
                                                            value="{{ isset($selectedFirstLocation[0]) ? $selectedFirstLocation[0] : '' }}"
                                                            @if (empty($selectedFirstLocation))  @endif
                                                            {{ $applicant->interview_status == 1 ? 'disabled' : '' }}>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <button type="submit" class="btn btn-sm btn-primary"
                                                            id="saveButton">Save</button>
                                                    </div>
                                                </div>
                                            </form>

                                            <form action="{{ route('interviews.store') }}" method="post"
                                                id="secondForm">
                                                @csrf
                                                <input type="hidden" name="for" value="assign_interviewer">
                                                <input type="hidden" name="step" value="second">
                                                <input type="hidden" name="emp_id" value="{{ $applicant->emp_id }}">
                                                <input type="hidden" name="job_id" value="{{ $applicant->job_id }}">
                                                <div class="row mt-2">
                                                    <div class="col-md-2">
                                                        <label>Select Department @if ($applicant->interview_status == 2)
                                                                ✅
                                                            @endif
                                                        </label>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <select class="form-control selectpicker"
                                                                id="exampleFormControlSelect1"
                                                                name="interviewers_second[]" multiple
                                                                data-live-search="true"
                                                                {{ $applicant->interview_status == 2 ? 'disabled' : '' }}>
                                                                @foreach (getUsersRoleWise([5, 3]) as $item)
                                                                    <option
                                                                        {{ in_array($item->user_id, $selectedSecondInterviewers) ? 'selected' : '' }}
                                                                        value="{{ $item->user_id }}">
                                                                        @if ($item->first_name && $item->last_name) 
                                                                            {!! $item->first_name !!} {!! $item->last_name !!} 
                                                                        @else
                                                                            {!! $item->fullname !!} 
                                                                        @endif
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-2">
                                                        <input type="text" name="datetime_second"
                                                            placeholder="Select date time"
                                                            class="form-control datetimepicker"
                                                            value="{{ isset($selectedSecondDatetime[0]) ? $selectedSecondDatetime[0] : '' }}"
                                                            @if (empty($selectedSecondDatetime)) placeholder="Select date time" @endif
                                                            {{ $applicant->interview_status == 2 ? 'disabled' : '' }}>
                                                    </div>

                                                    <div class="col-md-3">
                                                        <input type="text" name="location"
                                                            placeholder="Location"
                                                            class="form-control"
                                                            value="{{ isset($selectedSecondLocation[0]) ? $selectedSecondLocation[0] : '' }}"
                                                            @if (empty($selectedSecondLocation)) @endif
                                                            {{ $applicant->interview_status == 2 ? 'disabled' : '' }}>
                                                    </div>

                                                    <div class="col-md-2">
                                                        <button type="submit" class="btn btn-sm btn-primary"
                                                            id="saveButton">Save</button>
                                                    </div>
                                                </div>
                                            </form>

                                            <form action="{{ route('interviews.store') }}" method="post" id="thirdForm">
                                                @csrf
                                                <input type="hidden" name="for" value="assign_interviewer">
                                                <input type="hidden" name="step" value="third">
                                                <input type="hidden" name="emp_id" value="{{ $applicant->emp_id }}">
                                                <input type="hidden" name="job_id" value="{{ $applicant->job_id }}">
                                                <div class="row mt-2">
                                                    <div class="col-md-2">
                                                        <label>Select Management @if ($applicant->interview_status == 3)
                                                                ✅
                                                            @endif
                                                        </label>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            {{-- @php
                                                                _print(getUsersRoleWise([1]));
                                                            @endphp --}}
                                                            <select class="form-control selectpicker"
                                                                id="exampleFormControlSelect1" name="interviewers_third[]"
                                                                multiple data-live-search="true"
                                                                {{ $applicant->interview_status == 3 ? 'disabled' : '' }}>
                                                                @foreach (getUsersRoleWise([1]) as $item)
                                                                    <option
                                                                        {{ in_array($item->user_id, $selectedThirdInterviewers) ? 'selected' : '' }}
                                                                        value="{{ $item->user_id }}">
                                                                        @if ($item->first_name && $item->last_name) 
                                                                            {!! $item->first_name !!} {!! $item->last_name !!} 
                                                                        @else
                                                                            {!! $item->fullname !!} 
                                                                        @endif
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <input type="text" name="datetime_third"
                                                            placeholder="Select date time"
                                                            class="form-control datetimepicker"
                                                            value="{{ isset($selectedThirdDatetime[0]) ? $selectedThirdDatetime[0] : '' }}"
                                                            @if (empty($selectedThirdDatetime)) @endif
                                                            {{ $applicant->interview_status == 3 ? 'disabled' : '' }}>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <input type="text" name="location"
                                                            placeholder="Location"
                                                            class="form-control"
                                                            value="{{ isset($selectedThirdLocation[0]) ? $selectedThirdLocation[0] : '' }}"
                                                            @if (empty($selectedThirdLocation)) @endif
                                                            {{ $applicant->interview_status == 3 ? 'disabled' : '' }}>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <button type="submit"
                                                            {{ $applicant->interview_status == 3 ? 'disabled' : '' }}
                                                            class="btn btn-sm btn-primary" id="saveButton">Save</button>
                                                    </div>

                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            @if (count($feedbacks) > 0)
                                <div class="tab-pane fade" id="feedbackstatus" role="tabpanel"
                                    aria-labelledby="nav-contact-tab">
                                    <div class="card" id="card">
                                        @foreach ($feedbacks as $item)
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <label>Feedback By:</label>
                                                    </div>
                                                    <div class="col-md-8">
                                                        <p>{{ $item->first_name . ' ' . $item->last_name }}</p>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <label>Rating:</label>
                                                    </div>
                                                    <div class="col-md-8">
                                                        <table class="table table-bordered">
                                                            <thead>
                                                                <tr>
                                                                    <th>Points</th>
                                                                    <th>5 - Excellent</th>
                                                                    <th>4 - Good</th>
                                                                    <th>3 - Satisfactory</th>
                                                                    <th>2 - Marginal</th>
                                                                    <th>1 - Unsatisfactory</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tbody>
                                                                    {{-- <tr>
                                                                        <td>Appearance & Personality</td>
                                                                        <td><input type="radio" name="appearance" value="5" {{ $item->appearance == 5 ? 'checked' : '' }}></td>
                                                                        <td><input type="radio" name="appearance" value="4" {{ $item->appearance == 4 ? 'checked' : '' }}></td>
                                                                        <td><input type="radio" name="appearance" value="3" {{ $item->appearance == 3 ? 'checked' : '' }}></td>
                                                                        <td><input type="radio" name="appearance" value="2" {{ $item->appearance == 2 ? 'checked' : '' }}></td>
                                                                        <td><input type="radio" name="appearance" value="1" {{ $item->appearance == 1 ? 'checked' : '' }}></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Attitude & Cooperation</td>
                                                                        <td><input type="radio" name="attitude_cooperation" value="5" {{ $item->attitude_cooperation == 5 ? 'checked' : '' }}></td>
                                                                        <td><input type="radio" name="attitude_cooperation" value="4" {{ $item->attitude_cooperation == 4 ? 'checked' : '' }}></td>
                                                                        <td><input type="radio" name="attitude_cooperation" value="3" {{ $item->attitude_cooperation == 3 ? 'checked' : '' }}></td>
                                                                        <td><input type="radio" name="attitude_cooperation" value="2" {{ $item->attitude_cooperation == 2 ? 'checked' : '' }}></td>
                                                                        <td><input type="radio" name="attitude_cooperation" value="1" {{ $item->attitude_cooperation == 1 ? 'checked' : '' }}></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Expression & Communication</td>
                                                                        <td><input type="radio" name="expression_communication" value="5" {{ $item->expression_communication == 5 ? 'checked' : '' }}></td>
                                                                        <td><input type="radio" name="expression_communication" value="4" {{ $item->expression_communication == 4 ? 'checked' : '' }}></td>
                                                                        <td><input type="radio" name="expression_communication" value="3" {{ $item->expression_communication == 3 ? 'checked' : '' }}></td>
                                                                        <td><input type="radio" name="expression_communication" value="2" {{ $item->expression_communication == 2 ? 'checked' : '' }}></td>
                                                                        <td><input type="radio" name="expression_communication" value="1" {{ $item->expression_communication == 1 ? 'checked' : '' }}></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Job Knowledge</td>
                                                                        <td><input type="radio" name="job_knowledge" value="5" {{ $item->job_knowledge == 5 ? 'checked' : '' }}></td>
                                                                        <td><input type="radio" name="job_knowledge" value="4" {{ $item->job_knowledge == 4 ? 'checked' : '' }}></td>
                                                                        <td><input type="radio" name="job_knowledge" value="3" {{ $item->job_knowledge == 3 ? 'checked' : '' }}></td>
                                                                        <td><input type="radio" name="job_knowledge" value="2" {{ $item->job_knowledge == 2 ? 'checked' : '' }}></td>
                                                                        <td><input type="radio" name="job_knowledge" value="1" {{ $item->job_knowledge == 1 ? 'checked' : '' }}></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Initiative or Decision Making</td>
                                                                        <td><input type="radio" name="initiative_decision_making" value="5" {{ $item->initiative_decision_making == 5 ? 'checked' : '' }}></td>
                                                                        <td><input type="radio" name="initiative_decision_making" value="4" {{ $item->initiative_decision_making == 4 ? 'checked' : '' }}></td>
                                                                        <td><input type="radio" name="initiative_decision_making" value="3" {{ $item->initiative_decision_making == 3 ? 'checked' : '' }}></td>
                                                                        <td><input type="radio" name="initiative_decision_making" value="2" {{ $item->initiative_decision_making == 2 ? 'checked' : '' }}></td>
                                                                        <td><input type="radio" name="initiative_decision_making" value="1" {{ $item->initiative_decision_making == 1 ? 'checked' : '' }}></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Dependability & Leadership</td>
                                                                        <td><input type="radio" name="dependability_leadership" value="5" {{ $item->dependability_leadership == 5 ? 'checked' : '' }}></td>
                                                                        <td><input type="radio" name="dependability_leadership" value="4" {{ $item->dependability_leadership == 4 ? 'checked' : '' }}></td>
                                                                        <td><input type="radio" name="dependability_leadership" value="3" {{ $item->dependability_leadership == 3 ? 'checked' : '' }}></td>
                                                                        <td><input type="radio" name="dependability_leadership" value="2" {{ $item->dependability_leadership == 2 ? 'checked' : '' }}></td>
                                                                        <td><input type="radio" name="dependability_leadership" value="1" {{ $item->dependability_leadership == 1 ? 'checked' : '' }}></td>
                                                                    </tr> --}}
                                                                    <tr>
                                                                        <td>Appearance & Personality</td>
                                                                        @for ($i = 5; $i >= 1; $i--)
                                                                            <td>
                                                                                <input type="radio" onclick="radioClick(this)" name="appearance_{{ $item->id }}" value="{{ $i }}" {{ $item->appearance == $i ? 'checked' : '' }} >
                                                                            </td>
                                                                        @endfor
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Attitude & Cooperation</td>
                                                                        @for ($i = 5; $i >= 1; $i--)
                                                                            <td>
                                                                                <input type="radio" name="attitude_cooperation_{{ $item->id }}" value="{{ $i }}" {{ $item->attitude_cooperation == $i ? 'checked' : '' }}>
                                                                            </td>
                                                                        @endfor
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Expression & Communication</td>
                                                                        @for ($i = 5; $i >= 1; $i--)
                                                                            <td>
                                                                                <input type="radio" name="expression_communication_{{ $item->id }}" value="{{ $i }}" {{ $item->expression_communication == $i ? 'checked' : '' }}>
                                                                            </td>
                                                                        @endfor
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Job Knowledge</td>
                                                                        @for ($i = 5; $i >= 1; $i--)
                                                                            <td>
                                                                                <input type="radio" name="job_knowledge_{{ $item->id }}" value="{{ $i }}" {{ $item->job_knowledge == $i ? 'checked' : '' }}>
                                                                            </td>
                                                                        @endfor
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Initiative or Decision Making</td>
                                                                        @for ($i = 5; $i >= 1; $i--)
                                                                            <td>
                                                                                <input type="radio" name="initiative_decision_making_{{ $item->id }}" value="{{ $i }}" {{ $item->initiative_decision_making == $i ? 'checked' : '' }}>
                                                                            </td>
                                                                        @endfor
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Dependability & Leadership</td>
                                                                        @for ($i = 5; $i >= 1; $i--)
                                                                            <td>
                                                                                <input type="radio" name="dependability_leadership_{{ $item->id }}" value="{{ $i }}" {{ $item->dependability_leadership == $i ? 'checked' : '' }}>
                                                                            </td>
                                                                        @endfor
                                                                    </tr>
                                                                </tbody>
                                                            <!-- Recommendation -->
                                                            <div class="row">
                                                                <div class="col-md-4">
                                                                    <label>Recommendation:</label>
                                                                </div>
                                                                <div class="col-md-8">
                                                                    <p>{{ $item->recommendation }}</p>
                                                                </div>
                                                            </div>

                                                            <!-- Current Salary -->
                                                            <div class="row">
                                                                <div class="col-md-4">
                                                                    <label>Current Salary:</label>
                                                                </div>
                                                                <div class="col-md-8">
                                                                    <p>{{ $item->current_salary }}</p>
                                                                </div>
                                                            </div>
                                                            <!-- Expected Salary -->
                                                            <div class="row">
                                                                <div class="col-md-4">
                                                                    <label>Expected Salary:</label>
                                                                </div>
                                                                <div class="col-md-8">
                                                                    <p>{{ $applicant->expected_salary }}</p>
                                                                </div>
                                                            </div>
                                                            <!-- Reason for Leaving -->
                                                            <div class="row">
                                                                <div class="col-md-4">
                                                                    <label>Reason for Leaving:</label>
                                                                </div>
                                                                <div class="col-md-8">
                                                                    <p>{{ $item->reason_for_leave }}</p>
                                                                </div>
                                                            </div>

                                                            <!-- Interview Date -->
                                                            <div class="row">
                                                                <div class="col-md-4">
                                                                    <label>Interview Date:</label>
                                                                </div>
                                                                <div class="col-md-8">
                                                                    <p>{{ $item->interview_date }}</p>
                                                                </div>
                                                            </div>

                                                            <!-- Interview Place -->
                                                            <div class="row">
                                                                <div class="col-md-4">
                                                                    <label>Interview Place:</label>
                                                                </div>
                                                                <div class="col-md-8">
                                                                    <p>{{ $item->interview_place }}</p>
                                                                </div>
                                                            </div>

                                                            <!-- Notice Period -->
                                                            <div class="row">
                                                                <div class="col-md-4">
                                                                    <label>Notice Period (Days):</label>
                                                                </div>
                                                                <div class="col-md-8">
                                                                    <p>{{ $item->notice_period }} Days</p>
                                                                </div>
                                                            </div>
                                                                <!-- Add more rows for other evaluation criteria -->
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <label>Feedback:</label>
                                                    </div>
                                                    <div class="col-md-8">
                                                        {!! $item->feedback !!}
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <script>
        function selectInterviewer(user, emp_id, type) {
            $.ajax({
                url: "{{ url('assign-interviewer') }}", // Replace this with the actual URL
                type: "GET",
                data: {
                    user: user,
                    emp_id: emp_id,
                    type: type
                },
                success: function(response) {
                    console.log(response);
                    toastr.success(response[1]);
                    var interview = document.getElementById("interview");
                    var interview_process = document.getElementById("interview_process");
                    // interview.classList.add('active');
                    // interview.setAttribute("aria-selected", "true");
                    // $("#interview_process").load(window.location + "#interview_process");

                },
                error: function(xhr) {
                    // Handle the error if the request fails
                    console.log(xhr.responseText);
                }
            });
        }
    </script>
    <script>
        $(document).ready(function() {
            $('.selectpicker').selectpicker();

            $('#saveButton').click(function(e) {
                e.preventDefault();

                var selectedInterviewers = $('#exampleFormControlSelect1').val();
                $('input[name="interviewers"]').val(selectedInterviewers);

                // Submit the form
                $('form').submit();
            });
        });

        $(document).ready(function() {
            $('#saveButton').on('click', function() {
                var formId = $(this).closest('form').attr('id');
                $('#' + formId).submit();
            });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Disable all radio buttons
            var radioButtons = document.querySelectorAll('input[type="radio"]');
            radioButtons.forEach(function (radioButton) {
               if(!radioButton.checked){
                 radioButton.disabled = true;
               }
            });
        });

    </script>
@stop
