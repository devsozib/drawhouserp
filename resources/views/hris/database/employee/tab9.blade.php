<div class="row">
    <div class="col-lg-12">
        <div class="card">
            {!! Form::open([
                'action' => [
                    '\App\Http\Controllers\HRIS\Database\EmployeeController@addEmployeeData',
                    $uniqueemp->id,
                    'method' => 'Post',
                    'form' => '9',
                ],
            ]) !!}
            <div class="card-body" style="padding-bottom: 0;">
                <div class="row">
                    <div class="col-lg-6">
                        <table style="width: 100%;">
                            <tr>
                                <td style="width:50%; vertical-align: top;">
                                    <table class="table table-striped">
                                        <tbody>
                                            <tr>
                                                <th style="width: 40%">Date of Birth</th>
                                                <td style="width: 60%">
                                                    <div class="control-group {!! $errors->has('BirthDate') ? 'has-error' : '' !!}">
                                                        <div class="controls">
                                                            {!! Form::text('BirthDate', $uniquepersonal->BirthDate, [
                                                                'required',
                                                                'class' => 'form-control datepickerbs4v1 blind',
                                                                'id' => 'BirthDate',
                                                                'maxlength' => '10',
                                                                'placeholder' => 'YYYY-MM-DD',
                                                                'value' => Input::old('BirthDate'),
                                                            ]) !!}
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Place of Birth</th>
                                                <td>
                                                    <div class="control-group {!! $errors->has('DistrictCode') ? 'has-error' : '' !!}">
                                                        <div class="controls">
                                                            {!! Form::select('DistrictCode', $districtlist, $uniquepersonal->DistrictCode, [
                                                                'required',
                                                                'class' => 'form-control select2bs4 blind',
                                                                'id' => 'DistrictCode',
                                                                'placeholder' => 'Select One',
                                                                'value' => Input::old('DistrictCode'),
                                                            ]) !!}
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Sex</th>
                                                <td>
                                                    <div class="control-group {!! $errors->has('SexCode') ? 'has-error' : '' !!}">
                                                        <div class="controls">
                                                            {!! Form::select('SexCode', $sexlist, $uniquepersonal->SexCode, [
                                                                'required',
                                                                'class' => 'form-control blind',
                                                                'id' => 'SexCode',
                                                                'placeholder' => 'Select One',
                                                                'value' => Input::old('SexCode'),
                                                            ]) !!}
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Height</th>
                                                <td>
                                                    <div class="control-group {!! $errors->has('Height') ? 'has-error' : '' !!}">
                                                        <div class="controls">
                                                            {!! Form::text('Height', $uniquepersonal->Height, [
                                                                'class' => 'form-control blind',
                                                                'id' => 'Height',
                                                                'maxlength' => '10',
                                                                'placeholder' => 'Height',
                                                                'value' => Input::old('Height'),
                                                            ]) !!}
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Weight</th>
                                                <td>
                                                    <div class="control-group {!! $errors->has('Weight') ? 'has-error' : '' !!}">
                                                        <div class="controls">
                                                            {!! Form::text('Weight', $uniquepersonal->Weight, [
                                                                'class' => 'form-control blind',
                                                                'id' => 'Weight',
                                                                'maxlength' => '10',
                                                                'placeholder' => 'Weight',
                                                                'value' => Input::old('Weight'),
                                                            ]) !!}
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                                <td style="width:50%; padding-left: 5px; vertical-align: top;">
                                    <table class="table table-striped">
                                        <tbody>
                                            <tr>
                                                <th style="width: 40%">Blood Group</th>
                                                <td style="width: 60%">
                                                    <div class="control-group {!! $errors->has('BloodGroup') ? 'has-error' : '' !!}">
                                                        <div class="controls">
                                                            {!! Form::select(
                                                                'BloodGroup',
                                                                [
                                                                    'X' => 'X',
                                                                    'A+' => 'A+',
                                                                    'A-' => 'A-',
                                                                    'B+' => 'B+',
                                                                    'B-' => 'B-',
                                                                    'AB+' => 'AB+',
                                                                    'AB-' => 'AB-',
                                                                    'O+' => 'O+',
                                                                    'O-' => 'O-',
                                                                ],
                                                                $uniquepersonal->BloodGroup,
                                                                [
                                                                    'required',
                                                                    'class' => 'form-control blind',
                                                                    'id' => 'BloodGroup',
                                                                    'placeholder' => 'Select One',
                                                                    'value' => Input::old('BloodGroup'),
                                                                ],
                                                            ) !!}
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Highest Degree</th>
                                                <td>
                                                    <div class="control-group {!! $errors->has('DegreeCode') ? 'has-error' : '' !!}">
                                                        <div class="controls">
                                                            {!! Form::select('DegreeCode', $degreelist, $uniquepersonal->DegreeCode, [
                                                                'class' => 'form-control select2bs4 blind',
                                                                'id' => 'DegreeCode',
                                                                'value' => Input::old('DegreeCode'),
                                                            ]) !!}
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Religion</th>
                                                <td>
                                                    <div class="control-group {!! $errors->has('ReligionID') ? 'has-error' : '' !!}">
                                                        <div class="controls">
                                                            {!! Form::select('ReligionID', $religionlist, $uniquepersonal->ReligionID, [
                                                                'required',
                                                                'class' => 'form-control blind',
                                                                'id' => 'ReligionID',
                                                                'value' => Input::old('ReligionID'),
                                                            ]) !!}
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Nationality</th>
                                                <td>
                                                    <div class="control-group {!! $errors->has('NationalityID') ? 'has-error' : '' !!}">
                                                        <div class="controls">
                                                            {!! Form::select('NationalityID', $nationlist, $uniquepersonal->NationalityID, [
                                                                'required',
                                                                'class' => 'form-control blind',
                                                                'id' => 'NationalityID',
                                                                'value' => Input::old('NationalityID'),
                                                            ]) !!}
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Marital Status</th>
                                                <td>
                                                    <div class="control-group {!! $errors->has('MaritalStatusID') ? 'has-error' : '' !!}">
                                                        <div class="controls">
                                                            {!! Form::select('MaritalStatusID', $maritallist, $uniquepersonal->MaritalStatusID, [
                                                                'required',
                                                                'class' => 'form-control blind',
                                                                'id' => 'MaritalStatusID',
                                                                'placeholder' => 'Select One',
                                                                'value' => Input::old('MaritalStatusID'),
                                                            ]) !!}
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                        </table>

                        <table style="width: 100%; margin-top: -10px;">
                            <tr>
                                <td colspan="2"
                                    style="font-weight: 800; color: forestgreen; font-size: 1.2em; padding-left: 5px;">
                                    Nominee Details:</td>
                            </tr>
                            <tr>
                                <td style="vertical-align: top;">
                                    <table style="width:100%; margin: 0;" class="table table-striped">
                                        <tbody>
                                            <tr>
                                                <th style="width: 35%">Nominee</th>
                                                <td style="width: 65%">
                                                    <div class="control-group {!! $errors->has('Nominee') ? 'has-error' : '' !!}">
                                                        <div class="controls">
                                                            {!! Form::text('Nominee', $uniquepersonal->Nominee, [
                                                                'class' => 'form-control blind',
                                                                'id' => 'Nominee',
                                                                'maxlength' => '35',
                                                                'placeholder' => 'Nominee',
                                                                'value' => Input::old('Nominee'),
                                                            ]) !!}
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Relation</th>
                                                <td>
                                                    <div class="control-group {!! $errors->has('Relation') ? 'has-error' : '' !!}">
                                                        <div class="controls">
                                                            {!! Form::text('Relation', $uniquepersonal->Relation, [
                                                                'class' => 'form-control blind',
                                                                'id' => 'Relation',
                                                                'maxlength' => '35',
                                                                'placeholder' => 'Relation',
                                                                'value' => Input::old('Relation'),
                                                            ]) !!}
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>District</th>
                                                <td>
                                                    <div class="control-group {!! $errors->has('NDistrictID') ? 'has-error' : '' !!}">
                                                        <div class="controls">
                                                            {!! Form::select('NDistrictID', $districtlist, $uniquepersonal->NDistrictID, [
                                                                'class' => 'form-control select2bs4 blind',
                                                                'id' => 'NDistrictID',
                                                                'placeholder' => 'Select One',
                                                                'value' => Input::old('NDistrictID'),
                                                            ]) !!}
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                                <td style="padding-left: 5px; vertical-align: top;">
                                    <table style="width:100%; margin: 0;" class="table table-striped">
                                        <tbody>
                                            <tr>
                                                <th style="width: 35%">Thana</th>
                                                <td style="width: 65%">
                                                    <div class="control-group {!! $errors->has('NThanaID') ? 'has-error' : '' !!}">
                                                        <div class="controls">
                                                            {!! Form::select('NThanaID', $thanalist, $uniquepersonal->NThanaID, [
                                                                'class' => 'form-control select2bs4 blind',
                                                                'id' => 'NThanaID',
                                                                'placeholder' => 'Select One',
                                                                'value' => Input::old('NThanaID'),
                                                            ]) !!}
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Post Office</th>
                                                <td>
                                                    <div class="control-group {!! $errors->has('NPOffice') ? 'has-error' : '' !!}">
                                                        <div class="controls">
                                                            {!! Form::text('NPOffice', $uniquepersonal->NPOffice, [
                                                                'class' => 'form-control blind',
                                                                'id' => 'NPOffice',
                                                                'maxlength' => '50',
                                                                'placeholder' => 'Post Office',
                                                                'value' => Input::old('NPOffice'),
                                                            ]) !!}
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>H#/R#/Village</th>
                                                <td>
                                                    <div class="control-group {!! $errors->has('NVillage') ? 'has-error' : '' !!}">
                                                        <div class="controls">
                                                            {!! Form::text('NVillage', $uniquepersonal->NVillage, [
                                                                'class' => 'form-control blind',
                                                                'id' => 'NVillage',
                                                                'maxlength' => '50',
                                                                'placeholder' => 'House No/Road No/Village',
                                                                'value' => Input::old('NVillage'),
                                                            ]) !!}
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-lg-6">
                        <div class="row">
                            <div class="col-lg-6">
                                <table style="width: 100%;">
                                    <tr>
                                        <td style="width:40%; vertical-align: top;">
                                            <table class="table table-striped">
                                                <tbody>
                                                    <tr>
                                                        <th style="width: 40%">Mobile No</th>
                                                        <td style="width: 60%">
                                                            <div class="control-group {!! $errors->has('MobileNo') ? 'has-error' : '' !!}">
                                                                <div class="controls">
                                                                    {!! Form::text('MobileNo', $uniquepersonal->MobileNo, [
                                                                        'class' => 'form-control blind',
                                                                        'id' => 'MobileNo',
                                                                        'pattern' => '(01)[0-9]{9}',
                                                                        'minlength' => '11',
                                                                        'maxlength' => '11',
                                                                        'placeholder' => 'Mobile Number',
                                                                        'value' => Input::old('MobileNo'),
                                                                    ]) !!}
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th>National ID</th>
                                                        <td>
                                                            <div class="control-group {!! $errors->has('NationalIDNo') ? 'has-error' : '' !!}">
                                                                <div class="controls">
                                                                    {!! Form::text('NationalIDNo', $uniquepersonal->NationalIDNo, [
                                                                        'class' => 'form-control blind',
                                                                        'id' => 'NationalIDNo',
                                                                        'pattern' => '[0-9]{10,17}',
                                                                        'minlength' => '10',
                                                                        'maxlength' => '17',
                                                                        'placeholder' => 'National ID',
                                                                        'value' => Input::old('NationalIDNo'),
                                                                    ]) !!}
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th>Birth Certificate</th>
                                                        <td>
                                                            <div class="control-group {!! $errors->has('BirthCertificate') ? 'has-error' : '' !!}">
                                                                <div class="controls">
                                                                    {!! Form::text('BirthCertificate', $uniquepersonal->BirthCertificate, [
                                                                        'class' => 'form-control blind',
                                                                        'id' => 'BirthCertificate',
                                                                        'pattern' => '[0-9]{10,20}',
                                                                        'maxlength' => '30',
                                                                        'placeholder' => 'Birth Certificate',
                                                                        'value' => Input::old('BirthCertificate'),
                                                                    ]) !!}
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th style="width: 40%">No. of Children</th>
                                                        <td style="width: 60%">
                                                            <div class="control-group {!! $errors->has('NoSon') ? 'has-error' : '' !!}">
                                                                <div class="controls">
                                                                    {!! Form::number('NoSon', $uniquepersonal->NoSon, [
                                                                        'class' => 'form-control blind',
                                                                        'id' => 'NoSon',
                                                                        'min' => '0',
                                                                        'max' => '127',
                                                                        'placeholder' => 'Number of Children',
                                                                        'value' => Input::old('NoSon'),
                                                                    ]) !!}
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th>Service Book On Date</th>
                                                        <td>
                                                            <div class="control-group {!! $errors->has('ServiceBookOnDate') ? 'has-error' : '' !!}">
                                                                <div class="controls">
                                                                    {!! Form::text('ServiceBookOnDate', $uniquepersonal->ServiceBookOnDate, [
                                                                        'class' => 'form-control datepickerbs4v1 blind',
                                                                        'id' => 'ServiceBookOnDate',
                                                                        'maxlength' => '10',
                                                                        'placeholder' => 'YYYY-MM-DD',
                                                                        'value' => Input::old('ServiceBookOnDate'),
                                                                    ]) !!}
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th>Reports To</th>
                                                        <td>
                                                            <div class="control-group {!! $errors->has('ManagerID') ? 'has-error' : '' !!}">
                                                                <div class="controls">
                                                                    {!! Form::number('ManagerID', $uniquepersonal->ManagerID, [
                                                                        'class' => 'form-control blind',
                                                                        'id' => 'ManagerID',
                                                                        'min' => '0',
                                                                        'max' => '999999',
                                                                        'placeholder' => 'Reports To',
                                                                        'value' => Input::old('ManagerID'),
                                                                    ]) !!}
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th>Email</th>
                                                        <td>
                                                            <div class="control-group {!! $errors->has('Email') ? 'has-error' : '' !!}">
                                                                <div class="controls">
                                                                    {!! Form::email('Email', $uniquepersonal->Email, [
                                                                        'class' => 'form-control blind',
                                                                        'id' => 'Email',
                                                                        'maxlength' => '50',
                                                                        'placeholder' => 'info@drawhousedesign.com',
                                                                        'value' => Input::old('Email'),
                                                                    ]) !!}
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            @if (Sentinel::inRole('superadmin') || Sentinel::inRole('hr-manager') || Sentinel::inRole('hr-officer') || Sentinel::inRole('programmer') )
                            <div class="col-lg-6">
                                <table style="width: 100%;">
                                    <tr>
                                        <td colspan="2"
                                            style="font-weight: 800; color: forestgreen; font-size: 1.2em; padding-left: 5px;">
                                            For Receptionist:</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <table style="width:100%; margin: 0;" class="table table-striped">
                                                <tbody>
                                                    <tr>
                                                        <th style="width:50%; text-align: right;">Show In Receptionist
                                                            Application?</th>
                                                        <td style="width:50%;">
                                                            <div class="control-group {!! $errors->has('InApp') ? 'has-error' : '' !!}"
                                                                id="frm_InApp">
                                                                <div class="controls">
                                                                    {!! Form::select('InApp', ['Y' => 'Yes', 'N' => 'No'], $uniquepersonal->InApp, [
                                                                        'class' => 'form-control blind',
                                                                        'id' => 'InApp',
                                                                        'value' => Input::old('InApp'),
                                                                    ]) !!}
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr class='form-InApp'>
                                                        <th style="width:50%; text-align: right;">Hierarchical Position?</th>
                                                        <td style="width:50%;">
                                                            <div class="control-group {!! $errors->has('SL') ? 'has-error' : '' !!}">
                                                                <div class="controls">
                                                                    {!! Form::select(
                                                                        'SL',
                                                                        [
                                                                            '7' => 'Seven (Staff)',
                                                                            '6' => 'Six (Officer)',
                                                                            '5' => 'Five (Manager)',
                                                                            '4' => 'Four (Assistant General Manager)',
                                                                            '3' => 'Three (Deputy General Manager)',
                                                                            '2' => 'Two (General Manager)',
                                                                            '1' => 'One (Director, Chairman)',
                                                                        ],
                                                                        $uniquepersonal->SL,
                                                                        ['class' => 'form-control blind', 'id' => 'SL', 'placeholder' => 'Select One', 'value' => Input::old('SL')],
                                                                    ) !!}
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                                <br>
                                <table style="width: 100%;">
                                    <tr>
                                        <td colspan="2"
                                            style="font-weight: 800; color: forestgreen; font-size: 1.2em; padding-left: 5px;">
                                            Manager ID:</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <table style="width:100%; margin: 0;" class="table table-striped">
                                                <tbody>
                                                    <tr>
                                                        <th style="width:30%;">Forward By</th>
                                                        <td style="width:70%;">
                                                            <div class="control-group {!! $errors->has('ForwardBy') ? 'has-error' : '' !!}">
                                                                <div class="controls">
                                                                    {!! Form::select('ForwardBy[]', $userlist, $forids, [
                                                                        'multiple' => true,
                                                                        'title' => 'Select',
                                                                        'data-max-options' => '5',
                                                                        'data-live-search' => 'true',
                                                                        'data-size' => '5',
                                                                        'class' => 'form-control selectpicker',
                                                                        'id' => 'ForwardBy'.$uniquepersonal->id,
                                                                    ]) !!}
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th style="width:30%;">Approve By</th>
                                                        <td style="width:70%;">
                                                            <div class="control-group {!! $errors->has('ApproveBy') ? 'has-error' : '' !!}">
                                                                <div class="controls">
                                                                    <?php
                                                                    foreach ($userlist as $key => $value) {
                                                                        if (str_contains($value, str_pad($uniqueemp->EmployeeID, 6, '0', STR_PAD_LEFT))) {
                                                                            unset($userlist[$key]);
                                                                        }
                                                                    }
                                                                    ?>
                                                                    {!! Form::select('ApproveBy[]', $userlist, $appids, [
                                                                        'multiple',
                                                                        'title' => 'Select',
                                                                        'data-max-options' => '5',
                                                                        'data-live-search' => 'true',
                                                                        'data-size' => '5',
                                                                        'class' => 'form-control selectpicker',
                                                                        'id' => 'ApproveBy' . $uniquepersonal->id,
                                                                        //'value' => Input::old('ApproveBy'),
                                                                    ]) !!}
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer text-right">
                @if ($edit)
                    {!! Form::submit('Save', ['class' => 'btn btn-success']) !!}
                @endif
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>

<script type="text/javascript">
    var permis = <?php if ($edit) {
        echo 0;
    } else {
        echo 1;
    } ?>;
    $(".blind").prop("disabled", permis);
    $('#NDistrictID').on("change", function(event) {
        event.preventDefault();
        var distID = $("#NDistrictID option:selected").val();
        if (distID) {
            $.ajax({
                type: "GET",
                url: "{{ url('hris/database/getthana') }}",
                data: {
                    dist_id: distID,
                },
                success: function(data) {
                    if (data) {
                        $("#NThanaID").empty();
                        $.each(data, function(key, value) {
                            $("#NThanaID").append('<option value="' + key + '">' + value +
                                '</option>');
                        });
                    } else {
                        $("#NThanaID").empty();
                    }
                }
            });
        } else {
            $("#NThanaID").empty();
        }
    });

    $(function() {
        $("#frm_InApp").change(function() {
            updateIsClosed();
        });

        function updateIsClosed() {
            // hide all form-duration-divs
            $('.form-InApp').hide();
            $('#SL').attr('required', false);
            $('#MobileNo').attr('required', false);
            var divKey = $("#frm_InApp option:selected").val();
            if (divKey == "Y") {
                $('.form-InApp').show();
                $('#SL').attr('required', true);
                $('#MobileNo').attr('required', true);
            }
        }
        updateIsClosed();
    });
</script>
