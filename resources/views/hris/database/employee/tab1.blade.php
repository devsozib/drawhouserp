<div class="row">
    <div class="card" style="width: 100%">
        {!! Form::open([
            'action' => [
                '\App\Http\Controllers\HRIS\Database\EmployeeController@addEmployeeData',
                $uniqueemp->id,
                'method' => 'Post',
                'form' => '1',
            ],
        ]) !!}
        <div class="card-body" style="padding-bottom: 0;">
            <div class="row">
                <div class="col-lg-7">
                    <div class="row">
                        <div class="col-lg-6">
                            <table class="table table-striped">
                                <tbody>
                                    <tr>
                                        <th style="width: 30%">Employee ID</th>
                                        <td style="width: 70%">
                                            <div class="control-group {!! $errors->has('EmployeeID') ? 'has-error' : '' !!}">
                                                <div class="controls">
                                                    @if (Sentinel::inRole('superadmin'))
                                                        {!! Form::number('EmployeeID', $uniqueemp->EmployeeID, [
                                                            'required',
                                                            'class' => 'form-control',
                                                            'id' => 'EmployeeID',
                                                            'min' => '000100',
                                                            'max' => '999999',
                                                            'placeholder' => 'Employee ID',
                                                            'value' => Input::old('EmployeeID'),
                                                        ]) !!}
                                                    @else
                                                        {!! Form::number('EmployeeID', $uniqueemp->EmployeeID, [
                                                            'required',
                                                            Sentinel::inRole('general') ? 'readonly' : '',
                                                            'class' => 'form-control',
                                                            'id' => 'EmployeeID',
                                                            'min' => '000100',
                                                            'max' => '999999',
                                                            'placeholder' => 'Employee ID',
                                                            'value' => Input::old('EmployeeID'),
                                                        ]) !!}
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Designation</th>
                                        <td>
                                            <div class="control-group {!! $errors->has('DesignationID') ? 'has-error' : '' !!}">
                                                <div class="controls">
                                                    {!! Form::select('DesignationID', $desglist, $uniqueemp->DesignationID, [
                                                        'required',
                                                        'class' => 'form-control select2bs4 blind',
                                                        'id' => 'DesignationID',
                                                        'placeholder' => 'Select One',
                                                        'value' => Input::old('DesignationID'),
                                                    ]) !!}
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Department</th>
                                        <td>
                                            <div class="control-group {!! $errors->has('DepartmentID') ? 'has-error' : '' !!}">
                                                <div class="controls">
                                                    {!! Form::select('DepartmentID', $deptlist, $uniqueemp->DepartmentID, [
                                                        'required',
                                                        'class' => 'form-control select2bs4 blind',
                                                        'id' => 'DepartmentID',
                                                        'placeholder' => 'Select One',
                                                        'value' => Input::old('DepartmentID'),
                                                    ]) !!}
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    {{-- <tr>
                                        <th>Sub Grade</th>
                                        <td>
                                            <div class="control-group {!! $errors->has('SubGrade') ? 'has-error' : '' !!}">
                                                <div class="controls">
                                                    {!! Form::number('SubGrade', $uniqueemp->SubGrade, [
                                                        'readonly',
                                                        'class' => 'form-control blind',
                                                        'id' => 'SubGrade',
                                                        'min' => '0',
                                                        'max' => '127',
                                                        'placeholder' => 'Sub Grade',
                                                        'value' => Input::old('SubGrade'),
                                                    ]) !!}
                                                </div>
                                            </div>
                                        </td>
                                    </tr> --}}
                                    <tr>
                                        <td colspan="2" style="line-height: 1.2em;">
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <p
                                                style="font-weight: 800; color: forestgreen; font-size: 1.2em; padding-left: 5px; line-height: 1em;">
                                                Mailing Address:</p>
                                            <table style="width:100%; margin: 0;" class="table">
                                                <tbody>
                                                    <tr>
                                                        <th style="width: 35%">District</th>
                                                        <td style="width: 65%">
                                                            <div class="control-group {!! $errors->has('MDistrictID') ? 'has-error' : '' !!}">
                                                                <div class="controls">
                                                                    {!! Form::select('MDistrictID', $districtlist, $uniqueemp->MDistrictID, [
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
                                                                    {!! Form::select('MThanaID', $thanalist, $uniqueemp->MThanaID, [
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
                                                                    {!! Form::text('MPOffice', $uniqueemp->MPOffice, [
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
                                                                    {!! Form::text('MVillage', $uniqueemp->MVillage, [
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
                                    {{-- <tr>
                                        <th style="width: 30%">Line</th>
                                        <td style="width: 70%">
                                            <div class="control-group {!! $errors->has('Line') ? 'has-error' : '' !!}">
                                                <div class="controls">
                                                    {!! Form::number('Line', $uniqueemp->Line, [
                                                        'class' => 'form-control blind',
                                                        'id' => 'Line',
                                                        'min' => '0',
                                                        'max' => '127',
                                                        'placeholder' => 'Line Number',
                                                        'value' => Input::old('Line'),
                                                    ]) !!}
                                                </div>
                                            </div>
                                        </td>
                                    </tr> --}}
                                    <tr>
                                        <th>Property</th>
                                        <td>
                                            <div class="form-group {!! $errors->has('company_id') ? 'has-error' : '' !!}">
                                                <div class="controls">
                                                    {!! Form::select('company_id', $complists, $uniqueemp->company_id, ['required','class'=>'form-control select2bs4', 'id'=>'company_id','placeholder' => 'Select One', 'value' => Input::old('company_id')]) !!}
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Employment Status</th>
                                        <td>
                                            <div class="form-group {!! $errors->has('emp_type') ? 'has-error' : '' !!}">
                                                <div class="controls">
                                                    {!! Form::select('emp_type', $typelist, $uniqueemp->emp_type, ['required','class'=>'form-control select2bs4', 'id'=>'emp_type','placeholder' => 'Select One',
                                                    'value' => Input::old('emp_type')]) !!}
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Payment</th>
                                        <td>
                                            <div class="control-group {!! $errors->has('Salaried') ? 'has-error' : '' !!}">
                                                <div class="controls">
                                                    {!! Form::select('Salaried', ['Y' => 'Paid', 'N' => 'Unpaid'], $uniqueemp->Salaried, [
                                                        'required',
                                                        'class' => 'form-control blind',
                                                        'id' => 'Salaried',
                                                        'value' => Input::old('Salaried'),
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
                                                                {!! Form::select('PDistrictID', $districtlist, $uniqueemp->PDistrictID, [
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
                                                                {!! Form::select('PThanaID', $thanalist, $uniqueemp->PThanaID, [
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
                                                                {!! Form::text('PPOffice', $uniqueemp->PPOffice, [
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
                                                                {!! Form::text('PVillage', $uniqueemp->PVillage, [
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
                                <th style="width: 25%">Joining Date</th>
                                <td style="width: 25%">
                                    <div class="control-group {!! $errors->has('JoiningDate') ? 'has-error' : '' !!}">
                                        <div class="controls">
                                            {!! Form::text('JoiningDate', $uniqueemp->JoiningDate, [
                                                'required',
                                                'class' => 'form-control datepickerbs4v1 blind',
                                                'id' => 'JoiningDate',
                                                'maxlength' => '10',
                                                'placeholder' => 'YYYY-MM-DD',
                                                'value' => Input::old('JoiningDate'),
                                            ]) !!}
                                        </div>
                                    </div>
                                </td>
                                <th style="width: 25%">Confirmation Date</th>
                                <td style="width: 25%">
                                    <div class="control-group {!! $errors->has('ConfirmationDate') ? 'has-error' : '' !!}">
                                        <div class="controls">
                                            {!! Form::text('ConfirmationDate', $uniqueemp->ConfirmationDate, [
                                                Sentinel::inRole('general') ? 'readonly' : '',
                                                'class' => 'form-control blind',
                                                'id' => 'ConfirmationDate',
                                                'maxlength' => '10',
                                                'placeholder' => 'YYYY-MM-DD',
                                                'value' => Input::old('ConfirmationDate'),
                                            ]) !!}
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th>Punch Category</th>
                                <td>
                                    <div class="control-group {!! $errors->has('PunchCategoryID') ? 'has-error' : '' !!}">
                                        <div class="controls">
                                            @if (Sentinel::inRole('superadmin'))
                                            {!! Form::select(
                                                'PunchCategoryID',
                                                ['0' => 'No Punch', '1' => 'Single Punch', '2' => 'Double Punch'],
                                                $uniqueemp->PunchCategoryID,
                                                [
                                                    'required',
                                                    'class' => 'form-control blind',
                                                    'id' => 'PunchCategoryID',
                                                    'placeholder' => 'Select One',
                                                    'value' => Input::old('PunchCategoryID'),
                                                ],
                                            ) !!}
                                            @else
                                            {!! Form::select(
                                                'PunchCategoryID',
                                                ['2' => 'Double Punch'],
                                                $uniqueemp->PunchCategoryID,
                                                [
                                                    'required',
                                                    'class' => 'form-control blind',
                                                    'id' => 'PunchCategoryID',
                                                    'placeholder' => 'Select One',
                                                    'value' => Input::old('PunchCategoryID'),
                                                ],
                                            ) !!}
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <th>Roaster Duty</th>
                                <td>
                                    <div class="control-group {!! $errors->has('ShiftingDuty') ? 'has-error' : '' !!}">
                                        <div class="controls">
                                            {!! Form::select('ShiftingDuty', ['N' => 'No', 'Y' => 'Yes'], $uniqueemp->ShiftingDuty, [
                                                'class' => 'form-control blind',
                                                'id' => 'ShiftingDuty',
                                                'value' => Input::old('ShiftingDuty'),
                                            ]) !!}
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th>Initial Shift</th>
                                <td>
                                    <div class="control-group {!! $errors->has('ReferenceShift') ? 'has-error' : '' !!}">
                                        <div class="controls">
                                            {!! Form::select('ReferenceShift', $shiftlist, $uniqueemp->ReferenceShift, [
                                                'class' => 'form-control blind',
                                                'id' => 'ReferenceShift',
                                                'placeholder' => 'Select One',
                                                'value' => Input::old('ReferenceShift'),
                                            ]) !!}
                                        </div>
                                    </div>
                                </td>
                                <th>Reference Date</th>
                                <td>
                                    <div class="control-group {!! $errors->has('ShiftReferenceDate') ? 'has-error' : '' !!}">
                                        <div class="controls">
                                            {!! Form::text('ShiftReferenceDate', $uniqueemp->ShiftReferenceDate, [
                                                'class' => 'form-control datepickerbs4v1 blind',
                                                Sentinel::inRole('general') ? 'readonly' : '',
                                                'id' => 'ShiftReferenceDate',
                                                'maxlength' => '10',
                                                'placeholder' => 'YYYY-MM-DD',
                                                'value' => Input::old('ShiftReferenceDate'),
                                            ]) !!}
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th>Name</th>
                                <td colspan="3">
                                    <div class="control-group {!! $errors->has('Name') ? 'has-error' : '' !!}">
                                        <div class="controls">
                                            {!! Form::text('Name', $uniqueemp->Name, [
                                                'required',
                                                'class' => 'form-control blind',
                                                'id' => 'Name',
                                                'maxlength' => '35',
                                                'placeholder' => 'Employee Name',
                                                'value' => Input::old('Name'),
                                            ]) !!}
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th>Father Name</th>
                                <td colspan="3">
                                    <div class="control-group {!! $errors->has('Father') ? 'has-error' : '' !!}">
                                        <div class="controls">
                                            {!! Form::text('Father', $uniqueemp->Father, [
                                                'required',
                                                'class' => 'form-control blind',
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
                                <th>Mother Name</th>
                                <td colspan="3">
                                    <div class="control-group {!! $errors->has('Mother') ? 'has-error' : '' !!}">
                                        <div class="controls">
                                            {!! Form::text('Mother', $uniqueemp->Mother, [
                                                'required',
                                                'class' => 'form-control blind',
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
                                <th>Spouse Name</th>
                                <td colspan="3">
                                    <div class="control-group {!! $errors->has('Spouse') ? 'has-error' : '' !!}">
                                        <div class="controls">
                                            {!! Form::text('Spouse', $uniqueemp->Spouse, [
                                                'class' => 'form-control blind',
                                                'id' => 'Spouse',
                                                'maxlength' => '35',
                                                'placeholder' => 'Spouse Name',
                                                'value' => Input::old('Spouse'),
                                            ]) !!}
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th>Applicant Card#</th>
                                <td colspan="3">
                                    <div class="form-group {!! $errors->has('EmpEntryID') ? 'has-error' : '' !!}">
                                        <div class="controls">
                                            {!! Form::text('EmpEntryID', $uniqueemp->EmpEntryID, [
                                                'readonly',
                                                'class' => 'form-control',
                                                'id' => 'EmpEntryID',
                                                'maxlength' => '50',
                                                'placeholder' => 'Applicant ID',
                                                'value' => Input::old('EmpEntryID'),
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

    $('#JoiningDate').on('change', function() {
        var joiningDate = document.getElementById('JoiningDate').value;
        var getjoiningDate = joiningDate.split("-").reverse().join("-");
        var jointoconf = <?php echo $optionalparam->JoiningToConfirm; ?>;
        var newdate = new Date(getjoiningDate);
        var currentYear2 = newdate.getFullYear();
        var currentMonth2 = newdate.getMonth();
        var currentDay2 = newdate.getDate()
        var confirmationDate = new Date(currentYear2, currentMonth2 + jointoconf, currentDay2);
        var y = confirmationDate.getFullYear();
        var m = (confirmationDate.getMonth() + 1);
        var d = confirmationDate.getDate();
        var cMonth = m < 10 ? '0' + m : m;
        var cDay = d < 10 ? '0' + d : d;
        var cDate = y + '-' + cMonth + '-' + cDay;
        $('#ConfirmationDate').val(cDate);
        $('#ShiftReferenceDate').val(joiningDate);
    });

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

    $('#DesignationID').on("change", function(event) {
        var desgID = $("#DesignationID option:selected").val();
        if (desgID) {
            $.ajax({
                type: "GET",
                url: "{{ url('hris/database/getsubgrade') }}",
                data: {
                    desg_id: desgID,
                },
                success: function(data) {
                    if (data) {
                        $("#SubGrade").val(data);
                    } else {
                        $("#SubGrade").val(0);
                    }
                }
            });
        } else {
            $("#SubGrade").val('');
        }
    });
</script>
