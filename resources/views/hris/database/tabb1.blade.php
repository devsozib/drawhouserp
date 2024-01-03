
<div class="row">
      <div class="card">
        {{-- {!! Form::open(array('action' => array('\App\Http\Controllers\HRIS\Database\ApplicantController@show', 'method' => 'Post', 'form' => '1'))) !!} --}}
        <div class="card-body" style="padding-bottom: 0;">
            <div class="row">
                <div class="col-lg-7">
                    <div class="row">
                        <div class="col-lg-6">
                            <table class="table table-striped">
                                <tbody>                               
                                    <tr>
                                        <th>Name</th>
                                        <td colspan="3">
                                            <div class="form-group {!! $errors->has('Name') ? 'has-error' : '' !!}">
                                                <div class="controls">
                                                    {!! Form::text('Name', null, [
                                                        'required',
                                                        'class' => 'form-control',
                                                        'id' => 'Name',
                                                        'maxlength' => '35',
                                                        'placeholder' => 'Applicant Name',
                                                        'value' => Input::old('Name'),
                                                    ]) !!}
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Father Name</th>
                                        <td colspan="3">
                                            <div class="form-group {!! $errors->has('Father') ? 'has-error' : '' !!}">
                                                <div class="controls">
                                                    {!! Form::text('Father', null, [
                                                        'required',
                                                        'class' => 'form-control',
                                                        'id' => 'Father',
                                                        'maxlength' => '35',
                                                        'placeholder' => 'Father Name',
                                                        'value' => Input::old('Father'),
                                                    ]) !!}
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
                                                            <div class="control-group {!! $errors->has('MDistrictID') ? 'has-error' : '' !!}">
                                                                <div class="controls">
                                                                    {!! Form::select('MDistrictID', $districtlist, [
                                                                        'required',
                                                                        'class' => 'form-control select2bs4 blind',
                                                                        'id' => 'MDistrictID',
                                                                        'placeholder' => 'Select One',
                                                                        'value' => Input::old('MDistrictID'),
                                                                    ]) !!}
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th>Thana</th>
                                                        <td>
                                                            <div class="control-group {!! $errors->has('MThanaID') ? 'has-error' : '' !!}">
                                                                <div class="controls">
                                                                    {!! Form::select('MThanaID', $thanalist, [
                                                                        'required',
                                                                        'class' => 'form-control select2bs4 blind',
                                                                        'id' => 'MThanaID',
                                                                        'placeholder' => 'Select One',
                                                                        'value' => Input::old('MThanaID'),
                                                                    ]) !!}
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th>Post Office</th>
                                                        <td>
                                                            <div class="control-group {!! $errors->has('MPOffice') ? 'has-error' : '' !!}">
                                                                <div class="controls">
                                                                    {!! Form::text('MPOffice',null, [
                                                                        'required',
                                                                        'class' => 'form-control blind',
                                                                        'id' => 'MPOffice',
                                                                        'maxlength' => '50',
                                                                        'placeholder' => 'Post Office',
                                                                        'value' => Input::old('MPOffice'),
                                                                    ]) !!}
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th>House/Road/Village</th>
                                                        <td>
                                                            <div class="control-group {!! $errors->has('MVillage') ? 'has-error' : '' !!}">
                                                                <div class="controls">
                                                                    {!! Form::text('MVillage', null,[
                                                                        'required',
                                                                        'class' => 'form-control blind',
                                                                        'id' => 'MVillage',
                                                                        'maxlength' => '50',
                                                                        'placeholder' => 'House No/Road No/Village',
                                                                        'value' => Input::old('MVillage'),
                                                                    ]) !!}
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-lg-6">
                            <table class="table table-striped">
                                <tbody>
                                    <tr>
                                        <th>Mother Name</th>
                                        <td colspan="3">
                                            <div class="form-group {!! $errors->has('Mother') ? 'has-error' : '' !!}">
                                                <div class="controls">
                                                    {!! Form::text('Mother', null, [
                                                        'required',
                                                        'class' => 'form-control',
                                                        'id' => 'Mother',
                                                        'maxlength' => '35',
                                                        'placeholder' => 'Mother Name',
                                                        'value' => Input::old('Mother'),
                                                    ]) !!}
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Date of Birth</th>
                                        <td>
                                            <div class="form-group {!! $errors->has('DateofBirth') ? 'has-error' : '' !!}">
                                                <div class="controls">
                                                    {!! Form::text('DateofBirth', null, [
                                                        'required',
                                                        'class' => 'form-control datepickerbs4v2',
                                                        'id' => 'DateofBirth',
                                                        'maxlength' => '10',
                                                        'placeholder' => 'DD-MM-YYYY',
                                                        'value' => Input::old('DateofBirth'),
                                                    ]) !!}
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Gender</th>
                                        <td>
                                            <div class="form-group {!! $errors->has('Gender') ? 'has-error' : '' !!}">
                                                <div class="controls">
                                                    {!! Form::select('Gender', ['Male', 'Female', 'Others'], null, [
                                                        'required',
                                                        'class' => 'form-control',
                                                        'id' => 'Gender',
                                                        'value' => Input::old('Gender'),
                                                    ]) !!}
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
                                                        <div class="control-group {!! $errors->has('PDistrictID') ? 'has-error' : '' !!}">
                                                            <div class="controls">
                                                                {!! Form::select('PDistrictID', $districtlist, [
                                                                    'required',
                                                                    'class' => 'form-control select2bs4 blind',
                                                                    'id' => 'PDistrictID',
                                                                    'placeholder' => 'Select One',
                                                                    'value' => Input::old('PDistrictID'),
                                                                ]) !!}
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Thana</th>
                                                    <td>
                                                        <div class="control-group {!! $errors->has('PThanaID') ? 'has-error' : '' !!}">
                                                            <div class="controls">
                                                                {!! Form::select('PThanaID', $thanalist, [
                                                                    'required',
                                                                    'class' => 'form-control select2bs4 blind',
                                                                    'id' => 'PThanaID',
                                                                    'placeholder' => 'Select One',
                                                                    'value' => Input::old('PThanaID'),
                                                                ]) !!}
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Post Office</th>
                                                    <td>
                                                        <div class="control-group {!! $errors->has('PPOffice') ? 'has-error' : '' !!}">
                                                            <div class="controls">
                                                                {!! Form::text('PPOffice', null, [
                                                                    'required',
                                                                    'class' => 'form-control blind',
                                                                    'id' => 'PPOffice',
                                                                    'maxlength' => '50',
                                                                    'placeholder' => 'Post Office',
                                                                    'value' => Input::old('PPOffice'),
                                                                ]) !!}
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>House/Road/Village</th>
                                                    <td>
                                                        <div class="control-group {!! $errors->has('PVillage') ? 'has-error' : '' !!}">
                                                            <div class="controls">
                                                                {!! Form::text('PVillage', null, [
                                                                    'required',
                                                                    'class' => 'form-control blind',
                                                                    'id' => 'PVillage',
                                                                    'maxlength' => '50',
                                                                    'placeholder' => 'House No/Road No/Village',
                                                                    'value' => Input::old('PVillage'),
                                                                ]) !!}
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5">
                    <table class="table table-striped">
                        <tbody>
                            <tr>
                                <th style="width: 20%">Marital Status</th>
                                <td style="width: 20%">
                                    <div class="form-group {!! $errors->has('StatusID') ? 'has-error' : '' !!}">
                                        <div class="controls">
                                            {!! Form::select('StatusID', ['0' => 'Unmarried', '1' => 'Married', '2' => 'Single'], 2, [
                                                'required',
                                                'class' => 'form-control',
                                                'id' => 'StatusID',
                                                'placeholder' => 'Select One',
                                                'value' => Input::old('StatusID'),
                                            ]) !!}
                                        </div>
                                    </div>
                                </td>
                                <th style="width: 20%">Nationality</th>
                                <td style="width: 30%">
                                    <div class="form-group {!! $errors->has('Nationality') ? 'has-error' : '' !!}">
                                        <div class="controls">
                                            {!! Form::text('Nationality', null, [
                                                'required',
                                                'class' => 'form-control',
                                                'id' => 'Nationality',
                                                'maxlength' => '35',
                                                'placeholder' => 'Bangladeshi',
                                                'value' => Input::old('Nationality'),
                                            ]) !!}
                                        </div>
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <th>National ID</th>
                                <td colspan="3">
                                    <div class="form-group {!! $errors->has('NID') ? 'has-error' : '' !!}">
                                        <div class="controls">
                                            {!! Form::number('NID', null, [
                                                'class' => 'form-control',
                                                'id' => 'NID',
                                                'maxlength' => '35',
                                                'placeholder' => 'NID',
                                                'value' => Input::old('NID'),
                                            ]) !!}
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th>Phone</th>
                                <td colspan="3">
                                    <div class="form-group {!! $errors->has('Phone') ? 'has-error' : '' !!}">
                                        <div class="controls">
                                            {!! Form::number('Phone', null, [
                                                'class' => 'form-control',
                                                'id' => 'Phone',
                                                'maxlength' => '35',
                                                'placeholder' => 'Phone',
                                                'value' => Input::old('Phone'),
                                            ]) !!}
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td colspan="3">
                                    <div class="form-group {!! $errors->has('Email') ? 'has-error' : '' !!}">
                                        <div class="controls">
                                            {!! Form::email('Email', null, [
                                                'class' => 'form-control',
                                                'id' => 'Email',
                                                'maxlength' => '35',
                                                'placeholder' => 'Email',
                                                'value' => Input::old('Email'),
                                            ]) !!}
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <?php
        return "Hello";
        ?>
        <div class="card-footer text-right">
            @if ($edit)
                {!! Form::submit('Update', ['class' => 'btn btn-success']) !!}
            @endif
        </div>
        {!! Form::close() !!}
    </div>
</div>

<script type="text/javascript">
    var permis = <?php if ($edit) {
        echo 0;
    } else {
        echo 1;
    } ?>;
    $(".blind").prop("disabled", permis);

    // $('#JoiningDate').on('change', function() {
    //     var joiningDate = document.getElementById('JoiningDate').value;
    //     var getjoiningDate = joiningDate.split("-").reverse().join("-");
    //     var jointoconf = <?php echo $optionalparam->JoiningToConfirm; ?>;
    //     var newdate = new Date(getjoiningDate);
    //     var currentYear2 = newdate.getFullYear();
    //     var currentMonth2 = newdate.getMonth();
    //     var currentDay2 = newdate.getDate()
    //     var confirmationDate = new Date(currentYear2, currentMonth2 + jointoconf, currentDay2);
    //     var y = confirmationDate.getFullYear();
    //     var m = (confirmationDate.getMonth() + 1);
    //     var d = confirmationDate.getDate();
    //     var cMonth = m < 10 ? '0' + m : m;
    //     var cDay = d < 10 ? '0' + d : d;
    //     var cDate = cDay + '-' + cMonth + '-' + y;
    //     $('#ConfirmationDate').val(cDate);
    //     $('#ShiftReferenceDate').val(joiningDate);
    // });

    $('#MDistrictID').on("change", function(event) {
        event.preventDefault();
        var distID = $("#MDistrictID option:selected").val();
        if (distID) {
            $.ajax({
                type: "GET",
                url: "{{ url('hris/database/getthana') }}",
                data: {
                    dist_id: distID,
                },
                success: function(data) {
                    if (data) {
                        $("#MThanaID").empty();
                        $.each(data, function(key, value) {
                            $("#MThanaID").append('<option value="' + key + '">' + value +
                                '</option>');
                        });
                    } else {
                        $("#MThanaID").empty();
                    }
                }
            });
        } else {
            $("#MThanaID").empty();
        }
    });

    $('#PDistrictID').on("change", function(event) {
        event.preventDefault();
        var distID = $("#PDistrictID option:selected").val();
        if (distID) {
            $.ajax({
                type: "GET",
                url: "{{ url('hris/database/getthana') }}",
                data: {
                    dist_id: distID,
                },
                success: function(data) {
                    if (data) {
                        $("#PThanaID").empty();
                        $.each(data, function(key, value) {
                            $("#PThanaID").append('<option value="' + key + '">' + value +
                                '</option>');
                        });
                    } else {
                        $("#PThanaID").empty();
                    }
                }
            });
        } else {
            $("#PThanaID").empty();
        }
    });

    // $('#DesignationID').on("change", function(event) {
    //     var desgID = $("#DesignationID option:selected").val();
    //     if (desgID) {
    //         $.ajax({
    //             type: "GET",
    //             url: "{{ url('hris/database/getsubgrade') }}",
    //             data: {
    //                 desg_id: desgID,
    //             },
    //             success: function(data) {
    //                 if (data) {
    //                     $("#SubGrade").val(data);
    //                 } else {
    //                     $("#SubGrade").val(0);
    //                 }
    //             }
    //         });
    //     } else {
    //         $("#SubGrade").val('');
    //     }
    // });
</script>
