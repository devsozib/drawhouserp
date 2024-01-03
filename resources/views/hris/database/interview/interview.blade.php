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
                        <li class="breadcrumb-item"><a href="javascript::void(0)">Applicant</a></li>
                        <li class="breadcrumb-item"><a href="{!! url('hris/applicant/new-applicant') !!}">Applicant Interview</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Index</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="card">
            <h5 class="m-0 p-3 text-center">Applicant Interview of <span class="text-primary">{{ $applicant->Name }}</span>
            </h5>
            <div class="card-body">
                {{-- <form action="{{ route('interviews.store') }}" method="post">
                    @csrf
                    <div class="row">
                        <input type="hidden" name="emp_id" value="{{ $applicant->emp_id }}">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label>Expected Salary:</label>
                                        </div>
                                        <div class="col-md-3">
                                            @if ($applicant->expected_salary != null)
                                                <p>{{ $applicant->expected_salary }}</p>
                                            @else
                                                <input required="" class="form-control blind" id="GrossSalary"
                                                    pattern="[0-9]+([\.,][0-9]+)?" step="0.01" min="0"
                                                    placeholder="Expected salary" name="expected_salary" type="number">
                                            @endif
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label>Feedback:</label>
                                        </div>
                                        <div class="col-md-8">
                                            <textarea name="content" placeholder="Write feed back✍" id="editor"></textarea>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label>Rating:</label>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="rating">
                                                <input type="hidden" name="rating" id="rating-input" value="">
                                                <span class="star" data-value="1">&#9733;</span>
                                                <span class="star" data-value="2">&#9733;</span>
                                                <span class="star" data-value="3">&#9733;</span>
                                                <span class="star" data-value="4">&#9733;</span>
                                                <span class="star" data-value="5">&#9733;</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-md-3">
                                            <button type="submit" class="btn btn-primary">Save</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </form> --}}
                <div class="container">
                    <h4 class="text-center">Lakeshore Hotels & Apartments Interview Evaluation Form</h4>
                    <form action="{{ route('interviews.store') }}" method="post">
                        @csrf
                        <input type="hidden" name="emp_id" value="{{ $applicant->emp_id }}">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label for="name" class="col-sm-4 col-form-label">Name:</label>
                                    <div class="col-sm-8">
                                    <input type="text" id="name" readonly class="form-control-plaintext" value="{{ $applicant->Name }}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="currentposition" class="col-sm-4 col-form-label">Current Position:</label>
                                    <div class="col-sm-8">
                                        <input type="text" id="currentposition" readonly class="form-control-plaintext" value="{{ $applicant->job_designation != null ? $applicant->job_designation : $applicant->emp_designation }}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="currentSalary" class="col-sm-4 col-form-label">Current Salary: </label>
                                    <div class="col-sm-8">
                                    <input type="number" id="currentSalary" {{ $feedback->current_salary?'readonly':'' }} class="form-control-plaintext" name="current_salary" value="{{ $feedback->current_salary?$feedback->current_salary:'' }}" placeholder="Current salary" id="staticEmail">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="expectedPosition" class="col-sm-4 col-form-label">Expected Position:</label>
                                    <div class="col-sm-8">
                                        <input type="text" id="expectedPosition" readonly class="form-control-plaintext" value="{{ $applicant->job_designation != null ? $applicant->job_designation : $applicant->emp_designation }}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="expectedSalary" class="col-sm-4 col-form-label">Expected Salary:</label>
                                    <div class="col-sm-8">
                                        <input type="number" id="expectedSalary" {{ $applicant->expected_salary?'readonly':'' }} class="form-control-plaintext" name="expected_salary"  value="{{ $applicant->expected_salary?$applicant->expected_salary:'' }}" placeholder="Expected salary" value="">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="reason" class="col-sm-4 col-form-label">Reason for leaving last property:</label>
                                    <div class="col-sm-8">
                                        <input type="text" id="reason" class="form-control-plaintext" {{ $feedback->reason_for_leave?'readonly':'' }} name="reason_for_leave" value="{{ $feedback->reason_for_leave?$feedback->reason_for_leave:'' }}" placeholder="Reason for leaving" value="">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label for="mobileNo" class="col-sm-4 col-form-label">Mobile No:</label>
                                    <div class="col-sm-8">
                                    <input type="text" id="mobileNo" readonly class="form-control-plaintext" value="{{ $applicant->MobileNo }}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="dateOfInterview" class="col-sm-4 col-form-label">Date of Interview:</label>
                                    <div class="col-sm-8">
                                        <input type="text" id="dateOfInterview" class="form-control datepicker" value="{{ $feedback->interview_date?$feedback->interview_date:'' }}" name="date" placeholder="Pick date" id="inputPassword">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="placeOfInterView" class="col-sm-4 col-form-label">Place of Interview: </label>
                                    <div class="col-sm-8">
                                    <input type="text" id="placeOfInterView" class="form-control" value="{{ $feedback->interview_place?$feedback->interview_place:'' }}" placeholder="Inverview place" name="interview_place" id="staticEmail">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="noticePreiod" class="col-sm-4 col-form-label">Notice Period (Days):</label>
                                    <div class="col-sm-8">
                                        <input type="number" id="noticePreiod" class="form-control-plaintext" value="{{ $feedback->notice_period?$feedback->notice_period:'' }}" name="notice_period" placeholder="Notice period" value="">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Add other form fields here -->

                        <h2>Interview Assessment</h2>
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
                                <tr>
                                    <td>Appearance & Personality</td>
                                    <td><input  {{ $feedback->appearance == 5 ? 'checked' : '' }} type="radio" name="appearance" value="5"></td>
                                    <td><input  {{ $feedback->appearance == 4 ? 'checked' : '' }} type="radio" name="appearance" value="4"></td>
                                    <td><input  {{ $feedback->appearance == 3 ? 'checked' : '' }} type="radio" name="appearance" value="3"></td>
                                    <td><input  {{ $feedback->appearance == 2 ? 'checked' : '' }} type="radio" name="appearance" value="2"></td>
                                    <td><input  {{ $feedback->appearance == 1 ? 'checked' : '' }} type="radio" name="appearance" value="1"></td>
                                </tr>                                
                                <tr>
                                    <td>Attitude & Cooperation</td>
                                    <td><input {{ $feedback->attitude_cooperation == 5 ? 'checked' : '' }} type="radio" name="attitude_cooperation" value="5"></td>
                                    <td><input {{ $feedback->attitude_cooperation == 4 ? 'checked' : '' }} type="radio" name="attitude_cooperation" value="4"></td>
                                    <td><input {{ $feedback->attitude_cooperation == 3 ? 'checked' : '' }} type="radio" name="attitude_cooperation" value="3"></td>
                                    <td><input {{ $feedback->attitude_cooperation == 2 ? 'checked' : '' }} type="radio" name="attitude_cooperation" value="2"></td>
                                    <td><input {{ $feedback->attitude_cooperation == 1 ? 'checked' : '' }} type="radio" name="attitude_cooperation" value="1"></td>
                                </tr>
                                <tr>
                                    <td>Expression & Communication</td>
                                    <td><input {{ $feedback->expression_communication == 5 ? 'checked' : '' }} type="radio" name="expression_communication" value="5"></td>
                                    <td><input {{ $feedback->expression_communication == 4 ? 'checked' : '' }} type="radio" name="expression_communication" value="4"></td>
                                    <td><input {{ $feedback->expression_communication == 3 ? 'checked' : '' }} type="radio" name="expression_communication" value="3"></td>
                                    <td><input {{ $feedback->expression_communication == 2 ? 'checked' : '' }} type="radio" name="expression_communication" value="2"></td>
                                    <td><input {{ $feedback->expression_communication == 1 ? 'checked' : '' }} type="radio" name="expression_communication" value="1"></td>
                                </tr>
                                <tr>
                                    <td>Job Knowledge</td>
                                    <td><input {{ $feedback->job_knowledge == 5 ? 'checked' : '' }} type="radio" name="job_knowledge" value="5"></td>
                                    <td><input {{ $feedback->job_knowledge == 4 ? 'checked' : '' }} type="radio" name="job_knowledge" value="4"></td>
                                    <td><input {{ $feedback->job_knowledge == 3 ? 'checked' : '' }} type="radio" name="job_knowledge" value="3"></td>
                                    <td><input {{ $feedback->job_knowledge == 2 ? 'checked' : '' }} type="radio" name="job_knowledge" value="2"></td>
                                    <td><input {{ $feedback->job_knowledge == 1 ? 'checked' : '' }} type="radio" name="job_knowledge" value="1"></td>
                                </tr>
                                <tr>
                                    <td>Initiative or Decision Making</td>
                                    <td><input {{ $feedback->initiative_decision_making == 5 ? 'checked' : '' }} type="radio" name="initiative_decision_making" value="5"></td>
                                    <td><input {{ $feedback->initiative_decision_making == 4 ? 'checked' : '' }} type="radio" name="initiative_decision_making" value="4"></td>
                                    <td><input {{ $feedback->initiative_decision_making == 3 ? 'checked' : '' }} type="radio" name="initiative_decision_making" value="3"></td>
                                    <td><input {{ $feedback->initiative_decision_making == 2 ? 'checked' : '' }} type="radio" name="initiative_decision_making" value="2"></td>
                                    <td><input {{ $feedback->initiative_decision_making == 1 ? 'checked' : '' }} type="radio" name="initiative_decision_making" value="1"></td>
                                </tr>
                                <tr>
                                    <td>Dependability & Leadership</td>
                                    <td><input {{ $feedback->dependability_leadership == 5 ? 'checked' : '' }} type="radio" name="dependability_leadership" value="5"></td>
                                    <td><input {{ $feedback->dependability_leadership == 4 ? 'checked' : '' }} type="radio" name="dependability_leadership" value="4"></td>
                                    <td><input {{ $feedback->dependability_leadership == 3 ? 'checked' : '' }} type="radio" name="dependability_leadership" value="3"></td>
                                    <td><input {{ $feedback->dependability_leadership == 2 ? 'checked' : '' }} type="radio" name="dependability_leadership" value="2"></td>
                                    <td><input {{ $feedback->dependability_leadership == 1 ? 'checked' : '' }} type="radio" name="dependability_leadership" value="1"></td>
                                </tr>

                                <!-- Add more rows for other evaluation criteria -->
                            </tbody>
                        </table>

                        <div class="form-group">
                            <label for="comments">Comments:</label>
                            <textarea class="form-control" placeholder="Write comments" id="comments" name="content" rows="3" required>{{ $feedback->feedback?$feedback->feedback:'' }}</textarea>
                        </div>
                        <h2>Recommendation</h2>
                        <div class="form-check">
                            <input class="form-check-input" {{ $feedback->recommendation == 'Selected' ? 'checked' : '' }} type="radio" name="recommendation" value="Selected">
                            <label class="form-check-label">Selected</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input"  {{ $feedback->recommendation == 'Shortlisted' ? 'checked' : '' }} type="radio" name="recommendation" value="Shortlisted">
                            <label class="form-check-label">Shortlisted</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" {{ $feedback->recommendation == 'Not Suitable' ? 'checked' : '' }} type="radio" name="recommendation" value="Not Suitable">
                            <label class="form-check-label">Not Suitable</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" {{ $feedback->recommendation == 'Others' ? 'checked' : '' }} type="radio" name="recommendation" value="Others">
                            <label class="form-check-label">Others</label>
                        </div>

                        <!-- Add other form fields for Offered Position and more here -->

                        <button type="submit" class="btn btn-primary mt-3">Submit</button>
                    </form>
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
        ClassicEditor
            .create(document.querySelector('#editor'))
            .catch(error => {
                console.error(error);
            });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var stars = document.querySelectorAll('.star');
            var ratingInput = document.getElementById('rating-input');

            stars.forEach(function(star) {
                star.addEventListener('click', function() {
                    var rating = parseInt(this.getAttribute('data-value'));
                    ratingInput.value = rating;

                    stars.forEach(function(innerStar) {
                        if (parseInt(innerStar.getAttribute('data-value')) <= rating) {
                            innerStar.classList.add('selected');
                        } else {
                            innerStar.classList.remove('selected');
                        }
                    });
                });
            });
        });
    </script>
@stop
