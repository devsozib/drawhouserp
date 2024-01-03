@extends('hris.career.layouts.master')

@section('content')
    <div class="container-fluid">
        <div class="row row-height">
            <div class="col-xl-4 col-lg-4 content-left">
                <div class="content-left-wrapper">
                    <a href="{{ url('/careers') }}" id="logo"><img
                            src="{{ asset('public/career') }}/img/DrawHouse-Logo-2.png" alt="" width="200"></a>
                    <div id="social">
                        <div class="btn-group">
                            @if ($getImage && $getImage->image)
                                <img style="width: 40px; border-radius: 50px"
                                    src="{{ url('public/career/applicant_image/' . $getImage->image) }}"
                                    class="dropdown-toggle" data-bs-toggle="dropdown" data-bs-display="static"
                                    aria-expanded="false" />
                            @else
                            <img style="width: 40px; border-radius: 50px"
                                    src="https://t4.ftcdn.net/jpg/03/32/59/65/240_F_332596535_lAdLhf6KzbW6PWXBWeIFTovTii1drkbT.jpg"
                                    class="dropdown-toggle" data-bs-toggle="dropdown" data-bs-display="static"
                                    aria-expanded="false" />
                            @endif
                            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-lg-start">
                                <li><a class="dropdown-item text-black"
                                        href="{{ route('empuser.profile', Auth::guard('empuser')->user()->id) }}"
                                        type="button">My Profile</a></li>
                                <li><a class="dropdown-item text-black" href="{{ route('empuser.logout') }}"
                                        type="button">Logout</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <!-- /social -->
                    <div>
                        <h2>We are Hiring</h2>
                        <p>Tation argumentum et usu, dicit viderer evertitur te has. Eu dictas concludaturque usu, facete
                            detracto patrioque an per, lucilius pertinacia eu vel.</p>
                        {{-- <a href="https://1.envato.market/A6oJN" class="btn_1 rounded yellow" target="_parent">Purchase this template</a> --}}
                        <a href="#start" class="btn_1 rounded mobile_btn">Start Now!</a>
                    </div>
                    <div class="copy">© {{ now()->year }} DRAWHOUSE</div>
                </div>
            </div>

            <div class="col-xl-8 col-lg-8 content-right" id="start">
	            <div id="wizard_container" class="wizard" novalidate="novalidate">
	                <div id="top-wizard">
	                    <span id="location"></span>
	                    <div id="progressbar" class="ui-progressbar ui-widget ui-widget-content ui-corner-all" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0"><div class="ui-progressbar-value ui-widget-header ui-corner-left" style="display: none; width: 0%;"></div></div>
	                </div>
	                <!-- /top-wizard -->
                    <form action="{{ route('careers.post') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input id="job_id" name="job_id" type="hidden" value="{{ $id }}">
	                    <input id="website" name="website" type="text" value="">
	                    <!-- Leave for security protection, read docs for details -->
	                    <div id="middle-wizard" class="wizard-branch wizard-wrapper">
                            {{-- first step --}}
	                        <div class="step wizard-step current" style="">
                                    <h2 class="section_title">Job Application</h2>
                                    <div class="form-group add_bottom_30 mt-3">
                                        <label for="experience">Organization</label>
                                        <div class="styled-select clearfix">
                                            <input type="text" class="form-control" readonly value="{{ $job->Name }}">
                                        </div>
                                    </div>
                                    <div class="form-group add_bottom_30 mt-3">
                                        <label for="experience">Department</label>
                                        <div class="styled-select clearfix">
                                            <div class="styled-select clearfix">
                                                <input type="text"  class="form-control" readonly value="{{ $job->Department }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group add_bottom_30">
                                        <label for="experience">Designation</label>
                                        <div class="styled-select clearfix" id="position">
                                            <div class="styled-select clearfix">
                                                <div class="styled-select clearfix">
                                                    <input type="text" class="form-control" readonly value="{{ $job->Designation }}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group add_bottom_30">
                                        <label>Years of experience</label>
                                        <div class="styled-select clearfix">
                                            <input type="text" class="form-control required" name="experience"
                                                pattern="[0-9]+([\.,][0-9]+)?" placeholder="Years of expericence"
                                                value="{{ old('experience') }}" class="required">
                                        </div>
                                    </div>
                                    <label class="add_top_20">Your main specialities <small>(Separated by
                                            comas)</small></label>
                                    <div class="form-group">
                                        <label for="especality">Ex: One,TWO</label>
                                        <input value="{{ old('especality') }}" type="text" name="especality"
                                            id="especality" class="form-control required">
                                    </div>
	                        </div>
                            {{-- Presentation --}}
                            <div class="step wizard-step">
                                <h2 class="section_title">Presentation</h2>
                                <h3 class="main_question">Personal info</h3>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label>Name</label>
                                            <input value="{{ old('name',Auth::guard('empuser')->user()->name) }}" type="text" name="name" id="name"
                                                class="form-control required" placeholder="Name"
                                                onchange="getVals(this, 'name_field');">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="d_o_b">Date of birth</label>
                                            <input value="{{ old('d_o_b') }}"  id="datepicker" name="d_o_b"
                                                id="d_o_b" placeholder="Pick Date" class="form-control required "
                                                onchange="getVals(this, 'd_o_b');">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <label>Gender</label>
                                        <div class="form-group radio_input">
                                            <label class="container_radio me-3">Male
                                                <input type="radio" name="gender" value="Male" class="required">
                                                <span class="checkmark"></span>
                                            </label>
                                            <label class="container_radio">Female
                                                <input type="radio" name="gender" value="Female" class="required">
                                                <span class="checkmark"></span>
                                            </label>
                                            <label class="container_radio">Others
                                                <input type="radio" name="gender" value="Others" class="required">
                                                <span class="checkmark"></span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label>Marital Status</label>
                                            <select class="form-control required" name="material_status" id="positionss">
                                                <option value="" selected>Select</option>
                                                <option value="2">Unmarried</option>
                                                <option value="1"> Married </option>
                                                <option value="3"> Single </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label>Nationality</label>
                                            <input value="{{ old('nationality')??'' }}" type="text" name="nationality"
                                                placeholder="Nationality" id="nationality" class="form-control required">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label>Religion</label>
                                            <select class="form-control required" name="religion" id="religion">
                                                <option value="" selected>Select</option>
                                                @foreach ($religionlist as $item)
                                                    <option value="{{ $item->ReligionID }}">{{ $item->Religion }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-6">
                                        <div class="form-group">
                                            <label>NID NO</label>
                                            <input value="{{ old('n_id')??'' }}" type="text"
                                                placeholder="ex:12345678910" name="n_id" id="n_id"
                                                class="form-control required">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label>Phone</label>
                                            <input type="text" value="{{ old('phone')??'' }}" placeholder="Phone"
                                                name="phone" id="phone" class="form-control required">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label>Email</label>
                                            <input type="text" value="{{ old('email',Auth::guard('empuser')->user()->email) }}" placeholder="Email"
                                                name="email" id="email" class="form-control required">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- Address --}}
                            <div class="step wizard-step">
                                <h2 class="section_title">Address</h2>
                                <h3 class="main_question">Address Details</h3>
                                <div class="row">
                                    <span style="font-size:20px;font-weight:bold">Present Address</span>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label>District</label>
                                            <select onchange="getThana(this.value,'prsnt')"
                                                class="form-control select2bs4 required" name="prsnt_district"
                                                id="prsnt_dis">
                                                <option value="" selected>Select</option>
                                                @foreach ($districtlist as $item)
                                                    <option value="{{ $item->id }}">{{ $item->Name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label>Thana</label>
                                            <select class="form-control select2bs4 required" name="prsnt_thana"
                                                id="present_thana">
                                                <option value="" selected>Select</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label>Post Office</label>
                                            <input value="{{ old('prsnt_post_office.0')??'' }}" type="text"
                                                placeholder="Post Office" name="prsnt_post_office" id="prsnt_post_office"
                                                class="form-control required">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <input type="text" value="{{ old('prsnt_local_add.0')??'' }}"
                                            placeholder="Type your House No/Road/Village" name="prsnt_local_add"
                                            id="prsnt_local_add" class="form-control required">
                                    </div>
                                </div>
                                <div class="row">
                                    <span style="font-size:20px;font-weight:bold">Permanent Address</span>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label>District</label>
                                            <select onchange="getThana(this.value,'par')"
                                                class="form-control select2bs4 required" name="par_district"
                                                id="positionss">
                                                <option value="" selected>Select</option>
                                                @foreach ($districtlist as $item)
                                                    <option value="{{ $item->id }}">{{ $item->Name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label>Thana</label>
                                            <select class="form-control select2bs4 required" name="par_thana"
                                                id="par_thana">
                                                <option value="" selected>Select</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label>Post Office</label>
                                            <input type="text" value="{{ old('par_post_office.0')??'' }}"
                                                placeholder="Post Office" name="par_post_office" id="par_post_office"
                                                class="form-control required">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <input type="text" value="{{ old('par_local_add.0')??'' }}"
                                            placeholder="Type your House No/Road/Village" name="par_local_add"
                                            id="par_local_add" class="form-control required">
                                    </div>
                                </div>
                            </div>
                            {{-- Granter --}}
                            <div class="step wizard-step">
                                <h2 class="section_title">Grantor (Optional)</h2>
                                <h3 class="main_question">Grantor information</h3>
                                <div id="granter_sec">
                                    <div class="row" id="granter_section">
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label>Name</label>
                                                <input value="{{ old('g_name')??'' }}" type="text" name="g_name" id="name"
                                                class="form-control" placeholder="Name"  onchange="getVals(this, 'g_name');">
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label>Occupation</label>
                                                <select class="form-control" onchange="handleOcc(this.value)" name="g_occupation" id="degree0">
                                                    <option value="" selected>Select</option>
                                                    <option value="business">Busniness</option>
                                                    <option value="s_h">Service Holder</option>
                                                    <option value="others">Others</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-6" id="org_sec">
                                            <div class="form-group">
                                                <label>Organization </label>
                                                <input value="{{ old('g_organization')??'' }}" type="text" name="g_organization" id="g_organization"
                                                class="form-control" placeholder="Organization">
                                            </div>
                                        </div>
                                        <div class="col-6" id="org_add">
                                            <div class="form-group">
                                                <label>Organization Address</label>
                                                <input value="{{ old('g_org_add')??'' }}" type="text" name="g_org_add" id="g_org_add"
                                                class="form-control" placeholder="Organization Address">
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label>Phone</label>
                                                <input value="{{ old('g_phone')??'' }}" type="text" name="g_phone" id="name"
                                                class="form-control" placeholder="Phone">
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label>Email(Optional)</label>
                                                <input value="{{ old('g_email')??'' }}" type="text" name="g_email" id="name"
                                                class="form-control" placeholder="Email">
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label>Relation With applicant</label>
                                                <input value="{{ old('g_relation')??'' }}" type="text" name="g_relation" id="name"
                                                class="form-control" placeholder="Relation with applicant">
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label>Upload NID</label>
                                                <div class="fileupload">
                                                    <input type="file" name="g_nidfileupload" accept=""
                                                        class="">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                </div>
                            </div>
                            {{-- Education --}}
                            <div class="step wizard-step">
                                <h2 class="section_title">Education (Optional)</h2>
                                <h3 class="main_question">Academic Summary</h3>
                                <div id="education_sec">
                                    <div class="row" id="education_section_0">
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label>Degree</label>
                                                <select class="form-control" name="degree[]" id="degree0">
                                                    <option value="" selected>Select</option>
                                                    @foreach ($degrees as $degree)
                                                        <option value="{{ $degree->id }}">{{ $degree->Degree }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label>Institute</label>
                                                <input type="text" value="{{ old('edu_institute.0')??'' }}"
                                                    placeholder="Institute name" name="edu_institute[]"
                                                    id="edu_institute0" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label>Board</label>
                                                <select class="form-control select2bs4" name="board[]"
                                                    id="board0">
                                                    <option value="" selected>Select</option>
                                                    @foreach ($boards as $board)
                                                        <option value="{{ $board->id }}">{{ $board->Name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label>Result Type</label>
                                                <select class="form-control"
                                                    onchange="resultType(this.value, 'result_type_name0', '0')"
                                                    name="result_type[]" id="result_type0">
                                                    <option value="" disabled selected>Select</option>
                                                    <option value="Degree/Devision">Degree/Devision</option>
                                                    <option value="GPA">GPA</option>
                                                    <option value="CGPA">CGPA</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label>Obtained <span id="result_type_name0">Degree/Devision</span></label>
                                                <select class="form-control" disabled name="obt_result[]" id="d0">
                                                    <option value="">Select</option>
                                                    <option value="First Class">First Class</option>
                                                    <option value="Second Class">Second Class</option>
                                                    <option value="Third Class">Third Class</option>
                                                    <option value="Passed">Passed</option>
                                                    <option value="Appeared">Appeared</option>
                                                    <option value="N/A">N/A</option>
                                                </select>
                                                <input value="{{ old('obt_result.0')??'' }}" pattern="[0-9]+([\.,][0-9]+)?"
                                                    class="form-control d-none" id="g0" placeholder="GPA"
                                                    name="obt_result[]" type="text">

                                                <input value="{{ old('obt_result.0')??'' }}" pattern="[0-9]+([\.,][0-9]+)?"
                                                    class="form-control  d-none" id="c0" placeholder="CGPA"
                                                    name="obt_result[]" type="text">
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label>Year of passing</label>
                                                <input class="form-control" id="passing_year0" min="1980"
                                                    max="2100" value="{{ old('passing_year.0')??'' }}"
                                                    placeholder="Year of Passing" name="passing_year[]" type="number">
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                </div>

                                <div>
                                    <a type="button" class="btn btn-outline-primary" onclick="getAddform()"><i
                                            class="icon-plus"></i>&nbsp;Add
                                        Education
                                        (If
                                        Required)</a>
                                </div>
                            </div>
                            {{-- Training --}}
                            <div class="step wizard-step">
                                <h2 class="section_title">Training/Certification (Optional)</h2>
                                <h3 class="main_question">Training/Certification Summary</h3>
                                <div id="training_sec">
                                    <div class="row" id="training_section_0">
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label>Training Title</label>
                                                <input type="text" placeholder="Training Title"
                                                    name="training_title[]" id="training_title0"
                                                    class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label>Country</label>
                                                <input type="text" placeholder="Country" name="tr_country[]"
                                                    id="tr_country0" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label>Topics Covered</label>
                                                <input type="text" placeholder="Topics Covered" name="topic_coverd[]"
                                                    id="topic_coverd0" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label>Training Year</label>
                                                <select name="training_year[]" id="training_year"
                                                    class="form-control select2bs4">
                                                    <option value="" selected="selected">Select</option>
                                                    <option value="2023">2023</option>
                                                    <option value="2022">2022</option>
                                                    <option value="2021">2021</option>
                                                    <option value="2020">2020</option>
                                                    <option value="2019">2019</option>
                                                    <option value="2018">2018</option>
                                                    <option value="2017">2017</option>
                                                    <option value="2016">2016</option>
                                                    <option value="2015">2015</option>
                                                    <option value="2014">2014</option>
                                                    <option value="2013">2013</option>
                                                    <option value="2012">2012</option>
                                                    <option value="2011">2011</option>
                                                    <option value="2010">2010</option>
                                                    <option value="2009">2009</option>
                                                    <option value="2008">2008</option>
                                                    <option value="2007">2007</option>
                                                    <option value="2006">2006</option>
                                                    <option value="2005">2005</option>
                                                    <option value="2004">2004</option>
                                                    <option value="2003">2003</option>
                                                    <option value="2002">2002</option>
                                                    <option value="2001">2001</option>
                                                    <option value="2000">2000</option>
                                                    <option value="1999">1999</option>
                                                    <option value="1998">1998</option>
                                                    <option value="1997">1997</option>
                                                    <option value="1996">1996</option>
                                                    <option value="1995">1995</option>
                                                    <option value="1994">1994</option>
                                                    <option value="1993">1993</option>
                                                    <option value="1992">1992</option>
                                                    <option value="1991">1991</option>
                                                    <option value="1990">1990</option>
                                                    <option value="1989">1989</option>
                                                    <option value="1988">1988</option>
                                                    <option value="1987">1987</option>
                                                    <option value="1986">1986</option>
                                                    <option value="1985">1985</option>
                                                    <option value="1984">1984</option>
                                                    <option value="1983">1983</option>
                                                    <option value="1982">1982</option>
                                                    <option value="1981">1981</option>
                                                    <option value="1980">1980</option>
                                                    <option value="1979">1979</option>
                                                    <option value="1978">1978</option>
                                                    <option value="1977">1977</option>
                                                    <option value="1976">1976</option>
                                                    <option value="1975">1975</option>
                                                    <option value="1974">1974</option>
                                                    <option value="1973">1973</option>
                                                    <option value="1972">1972</option>
                                                    <option value="1971">1971</option>
                                                    <option value="1970">1970</option>
                                                    <option value="1969">1969</option>
                                                    <option value="1968">1968</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label>Institute</label>
                                                <input type="text" placeholder="Institute" name="tr_institute[]"
                                                    id="tr_institute0" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label>Duration</label>
                                                <input type="text" placeholder="Duration" name="tr_duration[]"
                                                    id="tr_duration0" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label>Location</label>
                                                <input type="text" placeholder="Location" name="tr_location[]"
                                                    id="tr_location0" class="form-control">
                                            </div>
                                        </div>
                                        <hr>
                                    </div>
                                </div>

                                <div>
                                    <a type="button" class="btn btn-outline-primary" onclick="addTraining()"><i
                                            class="icon-plus"></i>&nbsp;Add
                                        Training
                                        (If
                                        Required)</a>
                                </div>
                            </div>
                            {{-- Experience --}}
                            <div class="step wizard-step">
                                <h2 class="section_title">Experience (Optional)</h2>
                                <h3 class="main_question">Employment History</h3>
                                <div id="expericence_sec">
                                    <div class="row" id="experience_section0">
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label>Designation</label>
                                                <input type="text" value="{{ old('exp_designation.0')??'' }}"
                                                    placeholder="Designation" name="exp_designation[]"
                                                    id="exp_designation" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label>Organization</label>
                                                <input type="text" value="{{ old('organization.0')??'' }}"
                                                    placeholder="Organization" name="organization[]" id="organization"
                                                    class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label>Responsibilities</label>
                                                <input type="text" placeholder="Responsibilities"
                                                    name="responsibilities[]" value="{{ old('responsibilities.0')??'' }}"
                                                    id="responsibilities" class="form-control">
                                            </div>
                                        </div>
                                        <span style="font-size:20px;font-weight:bold">Employment Period</span>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label>From</label>
                                                <input type="date" value="{{ old('from_date.0')??'' }}"
                                                    name="from_date[]" id="from_date" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group" id="todate0">
                                                <label id="to_text0" class="text">To</label>
                                                <input type="date" value="{{ old('to_date.0')??'' }}" name="to_date[]"
                                                    id="to_date0" class="form-control">
                                                <br>
                                                <input type="text" id="continued0" disabled
                                                    class="form-control d-none" readonly name="to_date[]"
                                                    value="continuting" placeholder="Continuing">
                                            </div>
                                        </div>
                                        <div class="form-group col-md-12 btn-form-control">
                                            <label for="working" class="checkbox-inline">
                                                <input onchange="continueWork(this.checked,'0')" type="checkbox"
                                                    name="working[]" id="working0" value="YES">
                                                Currently Working
                                            </label>
                                        </div>
                                        <hr>
                                    </div>
                                </div>
                                <div>
                                    <a type="button" class="btn btn-outline-primary" onclick="addExp()"><i
                                            class="icon-plus"></i>&nbsp;Add
                                        Experience
                                        (If
                                        Required)</a>
                                </div>
                            </div>
                            {{-- reference --}}
                            <div class="step wizard-step">
                                <h2 class="section_title">Reference</h2>
                                <h3 class="main_question">Reference information</h3>
                                <div id="reference_sec">
                                    <div class="row" id="reference_section_0">
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label>Name</label>
                                                <input value="{{ old('r_name')[0] ?? '' }}" type="text" name="r_name[]" id="r_name0" class="form-control required" placeholder="Name">
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label>Occupation</label>
                                                <select class="form-control required" onchange="rHandleOcc(this.value,'0')" name="r_occupation[]" id="r_occupation0">
                                                    <option value="" selected>Select</option>
                                                    <option value="business">Busniness</option>
                                                    <option value="s_h">Service Holder</option>
                                                    <option value="others">Others</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-6" id="rorg_sec0">
                                            <div class="form-group">
                                                <label>Organization </label>
                                                <input value="{{ old('r_organization')?? '' }}" type="text" name="r_organization[]" id="r_organization0"
                                                class="form-control required" placeholder="Organization">
                                            </div>
                                        </div>
                                        <div class="col-6" id="rorg_add0">
                                            <div class="form-group">
                                                <label>Organization Address</label>
                                                <input value="{{ old('r_org_add')?? '' }}" type="text" name="r_org_add[]" id="r_org_add0"
                                                class="form-control required" placeholder="Organization Address">
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label>Phone</label>
                                                <input value="{{ old('r_phone')?? '' }}" type="text" name="r_phone[]" id="name"
                                                class="form-control required" placeholder="Phone">
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label>Email(Optional)</label>
                                                <input value="{{ old('r_email')?? '' }}" type="text" name="r_email[]" id="name"
                                                class="form-control" placeholder="Email">
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label>Relation With applicant</label>
                                                <input value="{{ old('r_relation')?? '' }}" type="text" name="r_relation[]" id="name"
                                                class="form-control required" placeholder="Relation with applicant">
                                            </div>
                                        </div>

                                    </div>
                                    <hr>
                                </div>
                                <div>
                                    <a type="button" class="btn btn-outline-primary" onclick="addReferennce()"><i
                                            class="icon-plus"></i>&nbsp;Add
                                        Reference
                                        (If
                                        Required)</a>
                                </div>
                            </div>
                            {{-- Documents --}}
                            <div class="step wizard-step">
                                <h2 class="section_title">Documents</h2>
                                <h3 class="main_question">Submit your documents!</h3>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group add_bottom_30 add_top_20">
                                            <label>Upload Resume<br><small>(File accepted: .pdf, .doc/docx - Max file size:
                                                    20MB)</small></label>
                                            <div class="fileupload">
                                                <input type="file" name="cvfileupload" accept=""
                                                    class="required">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group add_bottom_30 add_top_20">
                                            <label>Upload NID</label>
                                            <div class="fileupload">
                                                <input type="file" name="nidfileupload" accept=""
                                                    class="required">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group add_bottom_30 add_top_20">
                                            <label>Vaccine Certificate(Optional)</label>
                                            <div class="fileupload">
                                                <input type="file" name="vac_certificate" accept="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group add_bottom_30 add_top_20">
                                            <label>Upload your recent official passport size image</label>
                                            <div class="fileupload">
                                                <input type="file" name="image" accept="" class="required">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- Submit Step --}}
	                        <div class="submit step wizard-step" id="end" style="display: none;">
	                            <div class="summary">
	                                <div class="wrapper">
	                                    <h3>Thank your for your time<br><span id="name_field">Solomon</span>!</h3>
	                                    <p>We will contat you shorly at the following email address <strong id="email_field">manemiry@mailinator.com</strong></p>
	                                </div>
	                                <div class="text-center">
	                                    <div class="form-group terms">
	                                        <label class="container_check">Please accept our <a href="#" data-bs-toggle="modal" data-bs-target="#terms-txt">Terms and conditions</a> before Submit
	                                            <input type="checkbox" name="terms" value="Yes" class="required">
	                                            <span class="checkmark"></span>
	                                        </label>
	                                    </div>
	                                </div>
	                            </div>
	                        </div>
	                        <!-- /step last-->
	                    </div>
	                    <!-- /middle-wizard -->
	                    <div id="bottom-wizard">
	                        <button type="button" name="backward" class="backward" disabled="disabled">Prev</button>
	                        <button type="button" name="forward" class="forward">Next</button>
	                        <button type="submit" name="process" class="submit" disabled="disabled">Submit</button>
	                    </div>
	                    <!-- /bottom-wizard -->
	                </form>
	            </div>
	            <!-- /Wizard container -->
	        </div>
            <!-- /content-right-->
        </div>
        <!-- /row-->
    </div>
    <!-- /container-fluid -->
@endsection


<script>
    function getThana(id, type) {
        $.ajax({
            type: "GET",
            url: "{{ url('getthana') }}",
            data: {
                dist_id: id,
                type: 'forForntend'
            },
            success: function(data) {
                if (data) {
                    if (type == 'prsnt') {
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
    function handleOcc(occ) {
        if(occ == 'others'){
            $('#org_sec').addClass('d-none');
            $('#org_add').addClass('d-none');
            $('#g_organization').removeClass('required');
            $('#g_org_add').removeClass('required');
        }else{
            $('#org_sec').removeClass('d-none');
            $('#org_add').removeClass('d-none');
            $('#g_organization').addClass('required');
            $('#g_org_add').addClass('required');
        }

    }

    function resultType(resultType, labelId, iemNumber) {
        var d = document.getElementById("d" + iemNumber);
        var c = document.getElementById("c" + iemNumber);
        var g = document.getElementById("g" + iemNumber);
        var element = document.getElementById(labelId);
        element.innerHTML = resultType;
        if (resultType == 'Degree/Devision') {
            d.classList.remove("d-none");
            d.disabled = false;
            c.classList.add("d-none");
            c.disabled = true;
            g.classList.add("d-none");
            g.disabled = true;
        } else if (resultType == 'GPA') {
            d.classList.add("d-none");
            d.disabled = true;
            c.classList.add("d-none");
            c.disabled = true;
            g.classList.remove("d-none");
            g.disabled = false;
        } else {
            d.classList.add("d-none");
            d.disabled = true;
            c.classList.remove("d-none");
            c.disabled = false;
            g.classList.add("d-none");
            g.disabled = true;
        }
    }
    var sectionCount = 1;
    var sectionData = {};

    function getAddform(type) {
        var sectionsContainer = document.getElementById('education_sec');
        var html = `<div class="row" id="education_section_${sectionCount}">
                        <div class="col-6">
                            <div class="form-group">
                                <label>Degree</label>
                                <select class="form-control" name="degree[]" id="degree${sectionCount}">
                                    <option value="" selected>Select</option>
                                    @foreach ($degrees as $degree)
                                        <option value="{{ $degree->id }}">{{ $degree->Degree }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label>Institute</label>
                                <input type="text" placeholder="Institute name" name="edu_institute[]"
                                    id="edu_institute${sectionCount}" class="form-control">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label>Board</label>
                                <select class="form-control" name="board[]" id="board${sectionCount}">
                                    <option value="" selected>Select</option>
                                    @foreach ($boards as $board)
                                        <option value="{{ $board->id }}">{{ $board->Name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label>Result Type</label>
                                <select class="form-control"
                                    onchange="resultType(this.value, 'result_type_name${sectionCount}','${sectionCount}')"
                                    name="result_type[]" id="result_type${sectionCount}">
                                    <option value="">Select</option>
                                    <option value="Degree/Devision">Degree/Devision</option>
                                    <option value="GPA">GPA</option>
                                    <option value="CGPA">CGPA</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label>Obtained <span id="result_type_name${sectionCount}">Degree/Devision</span></label>
                                <select class="form-control" name="obt_result[]" id="d${sectionCount}">
                                    <option value="">Select</option>
                                    <option value="First Class">First Class</option>
                                    <option value="Second Class">Second Class</option>
                                    <option value="Third Class">Third Class</option>
                                    <option value="Passed">Passed</option>
                                    <option value="Appeared">Appeared</option>
                                    <option value="N/A">N/A</option>
                                </select>
                                <input pattern="[0-9]+([\.,][0-9]+)?" class="form-control  d-none"
                                                    id="g${sectionCount}" placeholder="GPA" name="obt_result[]"
                                                    type="text">
                                <input pattern="[0-9]+([\.,][0-9]+)?" step="0.01"
                                    class="form-control  d-none"
                                    placeholder="CGPA" name="obt_result[]" type="text"
                                    id="c${sectionCount}">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label>Year of passing</label>
                                <input class="form-control" id="passing_year${sectionCount}" min="1980"
                                    max="2100" placeholder="Year of Passing" name="passing_year[]"
                                    type="number">
                            </div>
                        </div>
                        <div class="col-3"><a type="button" class="btn btn-outline-danger" onclick="closeEdu('${ sectionCount }')"><i
                                            class="icon-delete"></i>&nbsp;Cancel</a></div>
                        <hr>
                    </div>`;
        sectionsContainer.insertAdjacentHTML('beforeend', html);
        populateSectionData(sectionCount);
        sectionCount++;
    }

    function populateSectionData(sectionId) {
        var sectionDataObj = sectionData[sectionId];
        if (sectionDataObj) {
            var degreeSelect = document.getElementById('degree' + sectionId);
            var instituteInput = document.getElementById('edu_institute' + sectionId);
            var boardSelect = document.getElementById('board' + sectionId);
            var resultTypeSelect = document.getElementById('result_type' + sectionId);
            var obtainedDegreeSelect = document.getElementById('d' + sectionId);
            var obtainedGradeSelect = document.getElementById('g' + sectionId);
            var cgpaInput = document.getElementById('c' + sectionId);
            var passingYearInput = document.getElementById('passing_year' + sectionId);

            // Populate the values from the sectionData object
            degreeSelect.value = sectionDataObj.degree;
            instituteInput.value = sectionDataObj.institute;
            boardSelect.value = sectionDataObj.board;
            resultTypeSelect.value = sectionDataObj.resultType;
            obtainedDegreeSelect.value = sectionDataObj.obtainedDegree;
            obtainedGradeSelect.value = sectionDataObj.obtainedGrade;
            cgpaInput.value = sectionDataObj.cgpa;
            passingYearInput.value = sectionDataObj.passingYear;
        }
    }

    function closeEdu(sectionId) {
        var section = document.getElementById('education_section_' + sectionId);
        if (section) {
            sectionData[sectionId];
            section.parentNode.removeChild(section);
        }
    }

    var trainingCount = 1;
    var traingData = {};

    function addTraining() {
        var sectionsContainer = document.getElementById('training_sec');
        var html = ` <div class="row" id="training_section_${trainingCount}">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label>Training Title</label>
                                            <input type="text" placeholder="Training Title" name="training_title[]"
                                                id="training_title${trainingCount}" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label>Country</label>
                                            <input type="text" placeholder="Country" name="tr_country[]" id="tr_country${trainingCount}"
                                                class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label>Topics Covered</label>
                                            <input type="text" placeholder="Topics Covered" name="topic_coverd[]"
                                                id="topic_coverd${trainingCount}" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label>Training Year</label>
                                            <select name="training_year[]" id="training_year${trainingCount}"
                                                class="form-control  select2bs4">
                                                <option value="" selected="selected">Select</option>
                                                <option value="2023">2023</option>
                                                <option value="2022">2022</option>
                                                <option value="2021">2021</option>
                                                <option value="2020">2020</option>
                                                <option value="2019">2019</option>
                                                <option value="2018">2018</option>
                                                <option value="2017">2017</option>
                                                <option value="2016">2016</option>
                                                <option value="2015">2015</option>
                                                <option value="2014">2014</option>
                                                <option value="2013">2013</option>
                                                <option value="2012">2012</option>
                                                <option value="2011">2011</option>
                                                <option value="2010">2010</option>
                                                <option value="2009">2009</option>
                                                <option value="2008">2008</option>
                                                <option value="2007">2007</option>
                                                <option value="2006">2006</option>
                                                <option value="2005">2005</option>
                                                <option value="2004">2004</option>
                                                <option value="2003">2003</option>
                                                <option value="2002">2002</option>
                                                <option value="2001">2001</option>
                                                <option value="2000">2000</option>
                                                <option value="1999">1999</option>
                                                <option value="1998">1998</option>
                                                <option value="1997">1997</option>
                                                <option value="1996">1996</option>
                                                <option value="1995">1995</option>
                                                <option value="1994">1994</option>
                                                <option value="1993">1993</option>
                                                <option value="1992">1992</option>
                                                <option value="1991">1991</option>
                                                <option value="1990">1990</option>
                                                <option value="1989">1989</option>
                                                <option value="1988">1988</option>
                                                <option value="1987">1987</option>
                                                <option value="1986">1986</option>
                                                <option value="1985">1985</option>
                                                <option value="1984">1984</option>
                                                <option value="1983">1983</option>
                                                <option value="1982">1982</option>
                                                <option value="1981">1981</option>
                                                <option value="1980">1980</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label>Institute</label>
                                            <input type="text" placeholder="Institute" name="tr_institute[]"
                                                id="tr_institute${trainingCount}" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label>Duration</label>
                                            <input type="text" placeholder="Duration" name="tr_duration[]"
                                                id="tr_duration${trainingCount}" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label>Location</label>
                                            <input type="text" placeholder="Location" name="tr_location[]"
                                                id="tr_location${trainingCount}" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-6">

                                    </div>
                                    <div class="col-3"><a type="button" class="btn btn-outline-danger" onclick="closeTraining('${ trainingCount }')"><i
                                            class="icon-delete"></i>&nbsp;Cancel</a></div>
                                    <hr>

                                </div>
                                `;
                        sectionsContainer.insertAdjacentHTML('beforeend', html);
                        setTraingData(trainingCount);
                        trainingCount++;

    }

    function setTraingData(sectionId) {
        var traingDataObj = traingData[sectionId];
        if (traingDataObj) {
            var training_title = document.getElementById('training_title' + sectionId);
            var tr_country = document.getElementById('tr_country' + sectionId);
            var topic_coverd = document.getElementById('topic_coverd' + sectionId);
            var training_year = document.getElementById('training_year' + sectionId);
            var tr_institute = document.getElementById('tr_institute' + sectionId);
            var tr_duration = document.getElementById('tr_duration' + sectionId);
            var tr_location = document.getElementById('tr_location' + sectionId);
            var passing_year = document.getElementById('passing_year' + sectionId);

            // Populate the values from the sectionData object
            training_title.value = traingDataObj.training_title;
            tr_country.value = traingDataObj.tr_country;
            topic_coverd.value = traingDataObj.topic_coverd;
            training_year.value = traingDataObj.training_year;
            tr_institute.value = traingDataObj.tr_institute;
            tr_duration.value = traingDataObj.tr_duration;
            tr_location.value = traingDataObj.tr_location;
            passing_year.value = traingDataObj.passing_year;
        }
    }

    function closeTraining(sectionId) {
        var section = document.getElementById('training_section_' + sectionId);
        if (section) {
            section.parentNode.removeChild(section);
        }
    }
    var experienceCount = 1;
    var experienceData = {};

    function addExp() {
        var sectionsContainer = document.getElementById('expericence_sec');
        var html = `<div class="row" id="experience_section${experienceCount}">
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label>Designation</label>
                                                <input type="text" placeholder="Designation" name="exp_designation[]"
                                                    id="designation${experienceCount}" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label>Organization</label>
                                                <input type="text" placeholder="Organization" name="organization[]"
                                                    id="organization${experienceCount}" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label>Responsibilities</label>
                                                <input type="text" placeholder="Responsibilities"
                                                    name="responsibilities[]" id="responsibilities${experienceCount}"
                                                    class="form-control">
                                            </div>
                                        </div>
                                        <span style="font-size:20px;font-weight:bold">Employment Period</span>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label>From</label>
                                                <input type="date" name="from_date[]" id="from_date${experienceCount}"
                                                    class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group" id="todate${experienceCount}">
                                                <label id="to_text${experienceCount}" class="text">To</label>
                                                <input type="date" name="to_date[]" id="to_date${experienceCount}"
                                                    class="form-control">
                                                <br>
                                                <input type="text" id="continued${experienceCount}" class="form-control d-none"
                                                    readonly name="to_date[]" disabled valu="continuting" placeholder="Continuing">
                                            </div>
                                        </div>
                                        <div class="form-group col-md-12 btn-form-control">
                                            <label for="working" class="checkbox-inline">
                                                <input onchange="continueWork(this.checked,'${experienceCount}')" type="checkbox"
                                                    name="working[]" id="working${experienceCount}" value="YES">
                                                Currently Working
                                            </label>
                                        </div>
                                        <div class="col-3"><a type="button" class="btn btn-outline-danger" onclick="closeExp('${ experienceCount }')"><i
                                            class="icon-delete"></i>&nbsp;Cancel</a></div>
                                        <hr>
                                    </div>
                                    `;
        sectionsContainer.insertAdjacentHTML('beforeend', html);
        setExpData(experienceCount);
        experienceCount++;
    }

    function setExpData(sectionId) {
        var experienceDataObj = experienceData[sectionId];
        if (experienceDataObj) {
            var exp_designation = document.getElementById('exp_designation' + sectionId);
            var organization = document.getElementById('organization' + sectionId);
            var responsibilities = document.getElementById('responsibilities' + sectionId);
            var from_date = document.getElementById('from_date' + sectionId);
            var to_date = document.getElementById('to_date' + sectionId);
            var continued = document.getElementById('continued' + sectionId);
            var working = document.getElementById('working' + sectionId);

            // Populate the values from the sectionData object
            exp_designation.value = traingDataObj.exp_designation;
            organization.value = traingDataObj.organization;
            responsibilities.value = traingDataObj.responsibilities;
            training_year.value = traingDataObj.training_year;
            from_date.value = traingDataObj.from_date;
            to_date.value = traingDataObj.to_date;
            continued.value = traingDataObj.continued;
            working.value = traingDataObj.working;
        }
    }

    function closeExp(sectionId) {
        var section = document.getElementById('experience_section' + sectionId);
        if (section) {
            section.parentNode.removeChild(section);
        }
    }

    function continueWork(checked, itemNumber) {
        var to_date = document.getElementById("to_date" + itemNumber);
        var continued = document.getElementById("continued" + itemNumber);
        if (checked) {
            to_date.classList.add("d-none");
            to_date.disabled = true;
            continued.classList.remove("d-none");
            to_date.classList.remove("required");
            continued.disabled = false;
        } else {
            to_date.classList.remove("d-none");
            to_date.disabled = false;
            to_date.classList.add("required");
            continued.classList.add("d-none");
            continued.disabled = true;
        }
    }
    //Reference

    var referenceCount = 1;
    var referenceData = {};

    function addReferennce() {
        var sectionsContainer = document.getElementById('reference_sec');
        var html = `<div class="row" id="reference_section_${referenceCount}">
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label>Name</label>
                                                <input value="{{ old('r_name') }}" type="text" name="r_name[]" id="r_name${referenceCount}"
                                                class="form-control required" placeholder="Name">
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label>Occupation</label>
                                                <select class="form-control required" onchange="rHandleOcc(this.value,'${referenceCount}')" name="r_occupation[]" id="r_occupation${referenceCount}">
                                                    <option value="" selected>Select</option>
                                                    <option value="business">Busniness</option>
                                                    <option value="s_h">Service Holder</option>
                                                    <option value="others">Others</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-6" id="rorg_sec${referenceCount}">
                                            <div class="form-group">
                                                <label>Organization </label>
                                                <input value="{{ old('r_organization') }}" type="text" name="r_organization[]" id="r_organization${referenceCount}"
                                                class="form-control required" placeholder="Organization">
                                            </div>
                                        </div>
                                        <div class="col-6" id="rorg_add${referenceCount}">
                                            <div class="form-group">
                                                <label>Organization Address</label>
                                                <input value="{{ old('r_org_add') }}" type="text" name="r_org_add[]" id="r_org_add${referenceCount}"
                                                class="form-control required" placeholder="Organization Address">
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label>Phone</label>
                                                <input value="{{ old('r_phone') }}" type="text" name="r_phone[]" id="r_phone${referenceCount}"
                                                class="form-control required" placeholder="Phone">
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label>Email(Optional)</label>
                                                <input value="{{ old('r_email') }}" type="text" name="r_email[]" id="r_email${referenceCount}"
                                                class="form-control" placeholder="Email">
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label>Relation With applicant</label>
                                                <input value="{{ old('r_relation') }}" type="text" name="r_relation[]" id="r_relation${referenceCount}"
                                                class="form-control required" placeholder="Relation with applicant">
                                            </div>
                                        </div>
                                        <div>
                                            <div class="col-3"><a type="button" class="btn btn-outline-danger" onclick="closeRef('${ referenceCount }')"><i
                                            class="icon-delete"></i>&nbsp;Cancel</a></div>
                                        </div>
                                        <hr>
                                    </div>`;
                    sectionsContainer .insertAdjacentHTML('beforeend', html);
                    setReference(referenceCount);
                    referenceCount++;

    }

    function setReference(sectionId) {
        var referenceDataObj = referenceData[sectionId];
        if (referenceData) {
            var r_name = document.getElementById('r_name' + sectionId);
            var r_occupation = document.getElementById('r_occupation' + sectionId);
            var r_organization = document.getElementById('r_organization' + sectionId);
            var r_org_add = document.getElementById('r_org_add' + sectionId);
            var r_phone = document.getElementById('r_phone' + sectionId);
            var r_email = document.getElementById('r_email' + sectionId);
            var r_relation = document.getElementById('r_relation' + sectionId);

            // Populate the values from the sectionData object
            r_name.value = referenceDataObj.r_name;
            r_occupation.value = referenceDataObj.r_occupation;
            r_organization.value = referenceDataObj.r_organization;
            r_org_add.value = referenceDataObj.r_org_add;
            r_phone.value = referenceDataObj.r_phone;
            r_email.value = referenceDataObj.r_email;
            r_relation.value = referenceDataObj.r_relation;
        }
    }
    function rHandleOcc(occ,itemNumber) {
        var rorg_sec = document.getElementById("rorg_sec" + itemNumber);
        var rorg_add = document.getElementById("rorg_add" + itemNumber);
        var r_organization = document.getElementById("r_organization" + itemNumber);
        var r_org_add = document.getElementById("r_org_add" + itemNumber);
        if(occ == 'others'){
            rorg_sec.classList.add("d-none");
            rorg_add.classList.add("d-none");
            r_organization.classList.remove("required");
            r_org_add.classList.remove("required");
        }else{
            rorg_sec.classList.remove("d-none");
            rorg_add.classList.remove("d-none");
            r_organization.classList.add('required');
            r_org_add.classList.add('required');
        }
    }
    function closeRef(sectionId) {
        var section = document.getElementById('reference_section_' + sectionId);
        if (section) {
            section.parentNode.removeChild(section);
        }
    }

</script>
<script type="text/javascript">
    // function getDepartment(id) {
    //     $.ajax({
    //         type: "GET",
    //         url: "{{ url('getdepartment') }}",
    //         data: {
    //             concern_id: id,
    //         },
    //         success: function(data) {
    //             if (data) {
    //                 $("#department").empty();
    //                 $.each(data, function(key, item) {
    //                     $('#department').append('<option value="' + item.id + '">' + item
    //                         .Department + '</option>');
    //                 });
    //             } else {
    //                 $("#department").empty();
    //             }
    //             $("#department").prepend('<option value="" selected>--Choose one--</option>');
    //         }
    //     });
    // }

    // function getDesignation(id) {
    //     $.ajax({
    //         type: "GET",
    //         url: "{{ url('getdesignation') }}",
    //         data: {
    //             department_id: id,
    //         },
    //         success: function(data) {
    //             console.log(data);
    //             if (data) {
    //                 $("#position").empty();

    //                 // Iterate over the data and create the new labels
    //                 $.each(data, function(key, item) {
    //                     var label = $('<label class="container_radio version_2"></label>');
    //                     label.text(item.Designation);

    //                     var input = $('<input type="radio" name="designation" value="' + item.id +
    //                         '" class="required">');
    //                     label.append(input);

    //                     var span = $('<span class="checkmark"></span>');
    //                     label.append(span);

    //                     // Append the new label to the container
    //                     $("#position").append(label);
    //                 });
    //             } else {
    //                 $(".position").empty();
    //             }
    //             // $("#designation").prepend('<option value="" selected>--Choose one--</option>');
    //         }
    //     });
    // }

</script>
