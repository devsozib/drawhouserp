<div class="card">
    <div class="card-body" style="padding-bottom: 0;">
        <form action="{{ route('applicant.store') }}" method="POST" enctype="multipart/form-data">
            <div class="row">
                <div class="col-lg-7">
                    <table class="table table-striped">
                        @csrf
                        <input id="website" name="tab" type="hidden" value="1">
                        <tbody>
                            <tr>
                                <th style="width: 35%">Department</th>
                                <td style="width: 65%">
                                    <div class="control-group {!! $errors->has('department') ? 'has-error' : '' !!}">
                                        <div class="controls">
                                            <select class="form-control required" name="department" id="department">
                                                <option value="">Choose a department</option>
                                                @foreach ($deptlist as $item)
                                                    <option value="{{ $item->id }}">{{ $item->Department }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th style="width: 35%">Designation</th>
                                <td style="width: 65%">
                                    <div class="control-group {!! $errors->has('designation') ? 'has-error' : '' !!}">
                                        <div class="controls">
                                            <select class="form-control required" name="designation" id="designation">
                                                <option value="">Choose a designation</option>
                                                @foreach ($desglist as $item)
                                                    <option value="{{ $item->id }}">{{ $item->Designation }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th style="width: 35%">Name</th>
                                <td style="width: 65%">
                                    <div class="form-group {!! $errors->has('Name') ? 'has-error' : '' !!}">
                                        <div class="controls">
                                            <input value="{{ old('name') }}" type="text" name="name"
                                                id="name" class="form-control required" placeholder="Name"
                                                onchange="getVals(this, 'name_field');">
                                        </div>
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td colspan="2" style="line-height: 1.2em;">
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <p
                                        style="font-weight: 800; color: forestgreen; font-size: 1.2em; padding-left: 5px; line-height: 1em;">
                                        Present Address:</p>
                                    <table style="width:100%; margin: 0;" class="table">
                                        <tbody>
                                            <tr>
                                                <th style="width: 35%">District</th>
                                                <td style="width: 65%">
                                                    <div class="control-group {!! $errors->has('prsnt_district') ? 'has-error' : '' !!}">
                                                        <div class="form-group">
                                                            <select onchange="getThana(this.value,'prsnt_district')"
                                                                class="form-control required" name="prsnt_district"
                                                                id="positionss">
                                                                <option value="" selected>Select</option>
                                                                @foreach ($districtlist as $item)
                                                                    <option value="{{ $item->id }}">
                                                                        {{ $item->Name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th style="width: 35%">Thana</th>
                                                <td style="width: 65%">
                                                    <div class="control-group {!! $errors->has('present_thana') ? 'has-error' : '' !!}">
                                                        <div class="controls">
                                                            <select class="form-control required" name="prsnt_thana"
                                                                id="present_thana">
                                                                <option value="" selected>Select</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Post Office</th>
                                                <td>
                                                    <div class="control-group {!! $errors->has('prsnt_post_office') ? 'has-error' : '' !!}">
                                                        <div class="controls">
                                                            <input value="{{ old('prsnt_post_office.0') }}"
                                                                type="text" placeholder="Post Office"
                                                                name="prsnt_post_office" id="prsnt_post_office"
                                                                class="form-control required">
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>House/Road/Village</th>
                                                <td>
                                                    <div class="control-group {!! $errors->has('prsnt_local_add') ? 'has-error' : '' !!}">
                                                        <div class="controls">
                                                            <input type="text" value="{{ old('prsnt_local_add.0') }}"
                                                                placeholder="Type your House No/Road/Village"
                                                                name="prsnt_local_add" id="prsnt_local_add"
                                                                class="form-control required">
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="2" style="line-height: 1.2em;">
                                            </tr>
                                            <tr>
                                                <td colspan="2">
                                                    <p
                                                        style="font-weight: 800; color: forestgreen; font-size: 1.2em; padding-left: 5px; line-height: 1em;">
                                                        Permanent Address:</p>
                                                    <table style="width:100%; margin: 0;" class="table">
                                                        <tr>
                                                            <th style="width: 35%">District</th>
                                                            <td style="width: 65%">
                                                                <div class="control-group {!! $errors->has('par_district') ? 'has-error' : '' !!}">
                                                                    <div class="controls">
                                                                        <select onchange="getThana(this.value,'par')"
                                                                            class="form-control required"
                                                                            name="par_district" id="positionss">
                                                                            <option value="" selected>
                                                                                Select</option>
                                                                            @foreach ($districtlist as $item)
                                                                                <option value="{{ $item->id }}">
                                                                                    {{ $item->Name }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th>Thana</th>
                                                            <td>
                                                                <div class="control-group {!! $errors->has('par_thana') ? 'has-error' : '' !!}">
                                                                    <div class="controls">
                                                                        <select class="form-control required"
                                                                            name="par_thana" id="par_thana">
                                                                            <option value="" selected>Select
                                                                            </option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th>Post Office</th>
                                                            <td>
                                                                <div class="control-group {!! $errors->has('par_post_office') ? 'has-error' : '' !!}">
                                                                    <div class="controls">
                                                                        <input type="text"
                                                                            value="{{ old('par_post_office.0') }}"
                                                                            placeholder="Post Office"
                                                                            name="par_post_office"
                                                                            id="par_post_office"
                                                                            class="form-control required">
                                                                    </div>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th>House/Road/Village</th>
                                                            <td>
                                                                <div class="control-group {!! $errors->has('par_local_add') ? 'has-error' : '' !!}">
                                                                    <div class="controls">
                                                                        <input type="text"
                                                                            value="{{ old('par_local_add.0') }}"
                                                                            placeholder="Type your House No/Road/Village"
                                                                            name="par_local_add" id="par_local_add"
                                                                            class="form-control required">
                                                                    </div>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-lg-5">
                    <table class="table table-striped">
                        <tbody>
                            <tr>
                                <th style="width: 35%">Date of Birth</th>
                                <td style="width: 65%">
                                    <div class="form-group {!! $errors->has('DateofBirth') ? 'has-error' : '' !!}">
                                        <div class="controls">
                                            <input value="{{ old('d_o_b') }}" type="date" name="d_o_b"
                                                id="d_o_b" class="form-control datepicker"
                                                onchange="getVals(this, 'd_o_b');">
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th style="width: 35%">Gender</th>
                                <td style="width: 65%">
                                    <div class="form-group {!! $errors->has('gender') ? 'has-error' : '' !!}">
                                        <div class="controls">
                                            <div class="form-group radio_input">
                                                <label class="container_radio me-3">Male
                                                    <input type="radio" name="gender" value="Male"
                                                        class="required">
                                                    <span class="checkmark"></span>
                                                </label>
                                                <label class="container_radio">Female
                                                    <input type="radio" name="gender" value="Female"
                                                        class="required">
                                                    <span class="checkmark"></span>
                                                </label>
                                                <label class="container_radio">Others
                                                    <input type="radio" name="gender" value="Others"
                                                        class="required">
                                                    <span class="checkmark"></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th style="width: 35%">Marital Status</th>
                                <td style="width: 65%">
                                    <div class="form-group {!! $errors->has('StatusID') ? 'has-error' : '' !!}">
                                        <div class="controls">
                                            <div class="form-group">
                                                <select class="form-control required" name="material_status"
                                                    id="positionss">
                                                    <option value="" selected>Select</option>
                                                    <option value="2">Unmarried</option>
                                                    <option value="1"> Married </option>
                                                    <option value="3"> Single </option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th style="width: 35%">Nationality</th>
                                <td style="width: 65%">
                                    <div class="form-group {!! $errors->has('nationality') ? 'has-error' : '' !!}">
                                        <div class="controls">
                                            <input value="{{ old('nationality') }}" type="text"
                                                name="nationality" placeholder="Nationality" id="nationality"
                                                class="form-control required">
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th style="width: 35%">National ID</th>
                                <td style="width: 65%">
                                    <div class="form-group {!! $errors->has('NID') ? 'has-error' : '' !!}">
                                        <div class="controls">
                                            <input value="{{ old('n_id') }}" type="text"
                                                placeholder="ex:12345678910" name="n_id" id="n_id"
                                                class="form-control required">
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th style="width: 35%">Phone</th>
                                <td style="width: 65%">
                                    <div class="form-group {!! $errors->has('Phone') ? 'has-error' : '' !!}">
                                        <div class="controls">
                                            <input type="text" value="{{ old('phone') }}" placeholder="Phone"
                                                name="phone" id="phone" class="form-control required">
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th style="width: 35%">Email</th>
                                <td style="width: 65%">
                                    <div class="form-group {!! $errors->has('Email') ? 'has-error' : '' !!}">
                                        <div class="controls">
                                            <input type="text" value="{{ old('email') }}" placeholder="Email"
                                                name="email" id="email" class="form-control required">
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th style="width: 35%">Upload Resume<br><small>(File accepted: .pdf, .doc/docx - Max
                                        file size:
                                        20MB)</small></th>
                                <td style="width: 65%">
                                    <div class="form-group {!! $errors->has('Email') ? 'has-error' : '' !!}">
                                        <div class="controls">
                                            <input type="file" name="cvfileupload" accept=""
                                                class="required">
                                        </div>
                                    </div>        
                                </td>
                            </tr>
                            <tr>
                                <th style="width: 35%">Upload NID</th>
                                <td style="width: 65%">
                                    <div class="form-group {!! $errors->has('Email') ? 'has-error' : '' !!}">
                                        <div class="controls">
                                            <input type="file" name="nidfileupload" accept=""
                                                class="required">
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="text-right mt-3">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>
    </div>
</div>
