<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header with-boarder">Academic Summary</div>
            <div class="card-body" style="padding-bottom: 0; min-height: 335px; overflow: auto;">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th style="width:4%;">SL#</th>
                            <th style="width:20%;">Degree</th>
                            <th style="width:34%;">Institute</th>
                            <th style="width:20%;">Board/University</th>
                            <th style="width:10%;">Result</th>
                            <th style="width:6%;">Year</th>
                            <th style="width:6%;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $sl3 = 1; ?>
                        @foreach ($educations as $education)
                            <tr>
                                <td>{!! $sl3 !!}</td>
                                <td>{!! $degreelist[$education->DegreeID] !!}</td>
                                <td>{!! $education->Institute !!}<br>{!! $education->InstituteB !!}</td>
                                <td>{!! $boardlist[$education->BoardID] !!}</td>
                                <td>{!! $education->ClassObtained !!}</td>
                                <td>{!! $education->Year !!}</td>
                                <td>
                                    @if ($edit)
                                        <a role="button" data-toggle="modal"
                                            data-target="#education-edit-modal{{ $education->id }}"
                                            class="btn-sm bg-gradient-info" title="Edit"><i
                                                class="fas fa-edit"></i></a>
                                    @endif
                                    @if ($delete)
                                        <a role="button" data-toggle="modal"
                                            data-target="#education-delete-modal{{ $education->id }}"
                                            class="btn-sm bg-gradient-danger" title="Delete"><i
                                                class="fas fa-times"></i></a>
                                    @endif
                                    <!--Delete-->
                                    <div class="modal fade" id="education-delete-modal{!! $education->id !!}"
                                        role="dialog">
                                        <div class="modal-dialog modal-md ">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Warning!!!</h4>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close"><span
                                                            aria-hidden="true">&times;</span></button>
                                                </div>
                                                <div class="modal-body">
                                                    Are you sure you want to delete Education Information : <strong
                                                        style="color: darkorange">{!! $degreelist[$education->DegreeID] !!}</strong> ?
                                                    {!! Form::open(['url' => 'hris/database/employee/education/' . $education->id]) !!}
                                                </div>
                                                <div class="modal-footer">
                                                    {!! Form::hidden('_method', 'DELETE') !!}
                                                    {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
                                                    <button type="button" class="btn btn-default"
                                                        data-dismiss="modal">Cancel</button>
                                                    {!! Form::close() !!}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--Edit Form Here-->
                                    <div class="modal fade" id="education-edit-modal{!! $education->id !!}"
                                        role="dialog">
                                        <div class="modal-dialog modal-lg ">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Edit Education Information, ID:
                                                        {!! $sl3 !!}</h4>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close"><span
                                                            aria-hidden="true">&times;</span></button>
                                                </div>
                                                <div class="modal-body">
                                                    {!! Form::open(['url' => 'hris/database/employee/education/' . $education->id]) !!}
                                                    {!! Form::hidden('_method', 'PATCH') !!}
                                                    @if (!empty(Session::get('error_code')) && Session::get('error_code') == $education->id)
                                                        @include('layout/flash-message')
                                                    @endif
                                                    <div class="row">
                                                        <div class="col-lg-6">
                                                            <div class="form-group {!! $errors->has('DegreeID') ? 'has-error' : '' !!}">
                                                                <label for="DegreeID{{ $education->id }}">Degree</label>
                                                                <div class="controls">
                                                                    {!! Form::select('DegreeID', $degreelist, $education->DegreeID, [
                                                                        'required',
                                                                        'class' => 'form-control select2bs4',
                                                                        'id' => 'DegreeID' . $education->id,
                                                                        'placeholder' => 'Select One',
                                                                        'value' => Input::old('DegreeID'),
                                                                    ]) !!}
                                                                </div>
                                                                <br>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="form-group {!! $errors->has('BoardID') ? 'has-error' : '' !!}">
                                                                <label for="BoardID">Board/University</label>
                                                                <div class="controls">
                                                                    {!! Form::select('BoardID', $boardlist, $education->BoardID, [
                                                                        'required',
                                                                        'class' => 'form-control select2bs4',
                                                                        'id' => 'BoardID' . $education->id,
                                                                        'value' => Input::old('BoardID'),
                                                                    ]) !!}
                                                                </div>
                                                                <br>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-lg-12">
                                                            <div class="form-group {!! $errors->has('Institute') ? 'has-error' : '' !!}">
                                                                <label for="Institute">Institute</label>
                                                                <div class="controls">
                                                                    {!! Form::text('Institute', $education->Institute, [
                                                                        'required',
                                                                        'class' => 'form-control',
                                                                        'id' => 'Institute',
                                                                        'maxlength' => '150',
                                                                        'placeholder' => 'Institute',
                                                                        'value' => Input::old('Institute'),
                                                                    ]) !!}
                                                                </div>
                                                                <br>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-lg-12">
                                                            <div class="form-group {!! $errors->has('InstituteB') ? 'has-error' : '' !!}">
                                                                <label for="InstituteB">Institute Bangla</label>
                                                                <div class="controls">
                                                                    {!! Form::text('InstituteB', $education->InstituteB, [
                                                                        'class' => 'form-control',
                                                                        'id' => 'InstituteB',
                                                                        'maxlength' => '150',
                                                                        'placeholder' => 'Institute Bangla',
                                                                        'value' => Input::old('InstituteB'),
                                                                    ]) !!}
                                                                </div>
                                                                <br>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-lg-4">
                                                            <div class="form-group {!! $errors->has('Year') ? 'has-error' : '' !!}">
                                                                <label for="Year">Year of Passing</label>
                                                                <div class="controls">
                                                                    {!! Form::number('Year', $education->Year, [
                                                                        'required',
                                                                        'class' => 'form-control',
                                                                        'id' => 'Year',
                                                                        'min' => '1980',
                                                                        'max' => '2100',
                                                                        'placeholder' => 'Year of Passing',
                                                                        'value' => Input::old('Year'),
                                                                    ]) !!}
                                                                </div>
                                                                <br>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-4">
                                                            <div class="control-control {!! $errors->has('ResultType') ? 'has-error' : '' !!}"
                                                                id="frm_ResultType_edit{!! $education->id !!}">
                                                                <label for="ResultType">Result Type</label>
                                                                <div class="controls">
                                                                    {!! Form::select(
                                                                        'ResultType',
                                                                        ['D' => 'Degree/Division', 'G' => 'Grade', 'C' => 'CGPA', 'O' => 'Other'],
                                                                        $education->ResultType,
                                                                        ['class' => 'form-control', 'id' => 'ResultType', 'value' => Input::old('ResultType')],
                                                                    ) !!}
                                                                </div>
                                                                <br>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-4 Degree_edit{!! $education->id !!}">
                                                            <div class="form-group {!! $errors->has('Degree') ? 'has-error' : '' !!}">
                                                                <label for="Degree">Obtained Degree</label>
                                                                <div class="controls">
                                                                    {!! Form::select(
                                                                        'Degree',
                                                                        [
                                                                            'First Class' => 'First Class',
                                                                            'Second Class' => 'Second Class',
                                                                            'Third Class' => 'Third Class',
                                                                            'Passed' => 'Passed',
                                                                            'Appeared' => 'Appeared',
                                                                            'N/A' => 'N/A',
                                                                        ],
                                                                        $education->ClassObtained,
                                                                        ['class' => 'form-control', 'id' => 'Degree', 'value' => Input::old('Degree')],
                                                                    ) !!}
                                                                </div>
                                                                <br>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-4 Grade_edit{!! $education->id !!}">
                                                            <div class="form-group {!! $errors->has('Grade') ? 'has-error' : '' !!}">
                                                                <label for="Grade">Obtained Grade</label>
                                                                <div class="controls">
                                                                    {!! Form::select(
                                                                        'Grade',
                                                                        [
                                                                            'Grade: A+' => 'Grade: A+',
                                                                            'Grade: A' => 'Grade: A',
                                                                            'Grade: A-' => 'Grade: A-',
                                                                            'Grade: B+' => 'Grade: B+',
                                                                            'Grade: B' => 'Grade: B',
                                                                            'Grade: B-' => 'Grade: B-',
                                                                            'Grade: C+' => 'Grade: C+',
                                                                            'Grade: C' => 'Grade: C',
                                                                            'Grade: C-' => 'Grade: C-',
                                                                            'Grade: D+' => 'Grade: D+',
                                                                            'Grade: D' => 'Grade: D',
                                                                            'Grade: D-' => 'Grade: D-',
                                                                            'Grade: F' => 'Grade: F',
                                                                        ],
                                                                        $education->ClassObtained,
                                                                        ['class' => 'form-control', 'id' => 'Grade', 'value' => Input::old('Grade')],
                                                                    ) !!}
                                                                </div>
                                                                <br>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-4 CGPA_edit{!! $education->id !!}">
                                                            <div class="form-group {!! $errors->has('CGPA') ? 'has-error' : '' !!}">
                                                                <label for="CGPA">Obtained CGPA</label>
                                                                <div class="controls">
                                                                    {!! Form::number('CGPA', $education->ClassObtained, [
                                                                        'pattern' => '[0-9]+([\.,][0-9]+)?',
                                                                        'step' => '0.01',
                                                                        'class' => 'form-control',
                                                                        'id' => 'CGPA',
                                                                        'min' => 1,
                                                                        'max' => 5,
                                                                        'placeholder' => 'CGPA',
                                                                        'value' => Input::old('CGPA'),
                                                                    ]) !!}
                                                                </div>
                                                                <br>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-4 Other_edit{!! $education->id !!}">
                                                            <div class="form-group {!! $errors->has('Other') ? 'has-error' : '' !!}">
                                                                <label for="Other">Obtained CGPA</label>
                                                                <div class="controls">
                                                                    {!! Form::number('Other', $education->ClassObtained, [
                                                                        'pattern' => '[0-9]+([\.,][0-9]+)?',
                                                                        'step' => '0.01',
                                                                        'class' => 'form-control',
                                                                        'id' => 'Other',
                                                                        'min' => 1,
                                                                        'placeholder' => 'CGPA',
                                                                        'value' => Input::old('Other'),
                                                                    ]) !!}
                                                                </div>
                                                                <br>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    {!! Form::submit('Update', ['class' => 'btn btn-success']) !!}
                                                    {!! Form::close() !!}
                                                    <button type="button" class="btn btn-default"
                                                        data-dismiss="modal">Cancel</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @if (!empty(Session::get('error_code')) && Session::get('error_code') == $education->id)
                                        <script type="text/javascript">
                                            $(function() {
                                                $('#education-edit-modal{{ $education->id }}').modal('show');
                                            });
                                        </script>
                                    @endif
                                    <script type="text/javascript">
                                        $(function() {
                                            $('#frm_ResultType_edit{{ $education->id }}').change(function() {
                                                updateIsClosed_edit{{ $education->id }}();
                                            });

                                            function updateIsClosed_edit{{ $education->id }}() {
                                                $('.Degree_edit{{ $education->id }}').hide();
                                                $('.Grade_edit{{ $education->id }}').hide();
                                                $('.CGPA_edit{{ $education->id }}').hide();
                                                $('.Other_edit{{ $education->id }}').hide();
                                                var divKey = $("#frm_ResultType_edit{{ $education->id }} option:selected").val();
                                                if (divKey == "D") {
                                                    $('.Degree_edit{{ $education->id }}').show();
                                                    $('.Grade_edit{{ $education->id }}').hide();
                                                    $('.CGPA_edit{{ $education->id }}').hide();
                                                    $('.Other_edit{{ $education->id }}').hide();
                                                } else if (divKey == "G") {
                                                    $('.Degree_edit{{ $education->id }}').hide();
                                                    $('.Grade_edit{{ $education->id }}').show();
                                                    $('.CGPA_edit{{ $education->id }}').hide();
                                                    $('.Other_edit{{ $education->id }}').hide();
                                                } else if (divKey == "C") {
                                                    $('.Degree_edit{{ $education->id }}').hide();
                                                    $('.Grade_edit{{ $education->id }}').hide();
                                                    $('.CGPA_edit{{ $education->id }}').show();
                                                    $('.Other_edit{{ $education->id }}').hide();
                                                }
                                                else if (divKey == "O") {
                                                    $('.Degree_edit{{ $education->id }}').hide();
                                                    $('.Grade_edit{{ $education->id }}').hide();
                                                    $('.CGPA_edit{{ $education->id }}').hide();
                                                    $('.Other_edit{{ $education->id }}').show();
                                                }
                                            }
                                            updateIsClosed_edit{{ $education->id }}();
                                        });
                                    </script>
                                </td>
                            </tr>
                            <?php $sl3++; ?>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header with-boarder">Input Parameters For New Academic Qualification</div>
            {!! Form::open([
                'action' => [
                    '\App\Http\Controllers\HRIS\Database\EmployeeController@addEmployeeData',
                    $uniqueemp->id,
                    'method' => 'Post',
                    'form' => '3',
                ],
            ]) !!}
            <div class="card-body" style="padding-bottom: 0;">
                <table class="table table-striped">
                    <tbody>
                        <tr>
                            <th style="width: 30%">Degree</th>
                            <td style="width: 70%">
                                <div class="form-group {!! $errors->has('DegreeID') ? 'has-error' : '' !!}">
                                    <div class="controls">
                                        {!! Form::select('DegreeID', $degreelist, 3, [
                                            'required',
                                            'class' => 'form-control select2bs4 blind',
                                            'id' => 'DegreeID',
                                            'placeholder' => 'Select One',
                                            'value' => Input::old('DegreeID'),
                                        ]) !!}
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th>Institute</th>
                            <td>
                                <div class="form-group {!! $errors->has('Institute') ? 'has-error' : '' !!}">
                                    <div class="controls">
                                        {!! Form::text('Institute', null, [
                                            'required',
                                            'class' => 'form-control blind',
                                            'id' => 'Institute',
                                            'maxlength' => '150',
                                            'placeholder' => 'Institute',
                                            'value' => Input::old('Institute'),
                                        ]) !!}
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th>Board/University</th>
                            <td>
                                <div class="form-group {!! $errors->has('BoardID') ? 'has-error' : '' !!}">
                                    <div class="controls">
                                        {!! Form::select('BoardID', $boardlist, null, [
                                            'required',
                                            'class' => 'form-control select2bs4 blind blind',
                                            'id' => 'BoardID',
                                            'value' => Input::old('BoardID'),
                                        ]) !!}
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th>Result Type</th>
                            <td>
                                <div class="control-control {!! $errors->has('ResultType') ? 'has-error' : '' !!}" id="frm_ResultType">
                                    <div class="controls">
                                        {!! Form::select('ResultType', ['D' => 'Degree/Division', 'G' => 'Grade', 'C' => 'CGPA', 'O' => 'Other'], 'D', [
                                            'class' => 'form-control blind',
                                            'id' => 'ResultType',
                                            'value' => Input::old('ResultType'),
                                        ]) !!}
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr class="Degree">
                            <th>Obtained Degree</th>
                            <td>
                                <div class="form-group {!! $errors->has('Degree') ? 'has-error' : '' !!}">
                                    <div class="controls">
                                        {!! Form::select(
                                            'Degree',
                                            [
                                                'First Class' => 'First Class',
                                                'Second Class' => 'Second Class',
                                                'Third Class' => 'Third Class',
                                                'Passed' => 'Passed',
                                                'Appeared' => 'Appeared',
                                                'N/A' => 'N/A',
                                            ],
                                            null,
                                            ['class' => 'form-control blind', 'id' => 'Degree', 'value' => Input::old('Degree')],
                                        ) !!}
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr class="Grade">
                            <th>Obtained Grade</th>
                            <td>
                                <div class="form-group {!! $errors->has('Grade') ? 'has-error' : '' !!}">
                                    <div class="controls">
                                        {!! Form::select(
                                            'Grade',
                                            [
                                                'Grade: A+' => 'Grade: A+',
                                                'Grade: A' => 'Grade: A',
                                                'Grade: A-' => 'Grade: A-',
                                                'Grade: B+' => 'Grade: B+',
                                                'Grade: B' => 'Grade: B',
                                                'Grade: B-' => 'Grade: B-',
                                                'Grade: C+' => 'Grade: C+',
                                                'Grade: C' => 'Grade: C',
                                                'Grade: C-' => 'Grade: C-',
                                                'Grade: D+' => 'Grade: D+',
                                                'Grade: D' => 'Grade: D',
                                                'Grade: D-' => 'Grade: D-',
                                                'Grade: F' => 'Grade: F',
                                            ],
                                            null,
                                            ['class' => 'form-control blind', 'id' => 'Grade', 'value' => Input::old('Grade')],
                                        ) !!}
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr class="CGPA">
                            <th>Obtained CGPA</th>
                            <td>
                                <div class="form-group {!! $errors->has('CGPA') ? 'has-error' : '' !!}">
                                    <div class="controls">
                                        {!! Form::number('CGPA', null, [
                                            'pattern' => '[0-9]+([\.,][0-9]+)?',
                                            'step' => '0.01',
                                            'class' => 'form-control blind',
                                            'id' => 'CGPA',
                                            'min' => 1,
                                            'max' => 5,
                                            'placeholder' => 'CGPA',
                                            'value' => Input::old('CGPA'),
                                        ]) !!}
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr class="Other">
                            <th>Obtained CGPA</th>
                            <td>
                                <div class="form-group {!! $errors->has('Other') ? 'has-error' : '' !!}">
                                    <div class="controls">
                                        {!! Form::number('Other', null, [
                                            'pattern' => '[0-9]+([\.,][0-9]+)?',
                                            'step' => '0.01',
                                            'class' => 'form-control blind',
                                            'id' => 'Other',
                                            'min' => 1,
                                            'placeholder' => 'CGPA',
                                            'value' => Input::old('Other'),
                                        ]) !!}
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th>Year of Passing</th>
                            <td>
                                <div class="form-group {!! $errors->has('Year') ? 'has-error' : '' !!}">
                                    <div class="controls">
                                        {!! Form::number('Year', null, [
                                            'required',
                                            'class' => 'form-control',
                                            'id' => 'Year',
                                            'min' => '1980',
                                            'max' => '2100',
                                            'placeholder' => 'Year of Passing',
                                            'value' => Input::old('Year'),
                                        ]) !!}
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
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
    $("#frm_ResultType").change(function() {
        updateIsClosed();
    });

    function updateIsClosed() {
        // hide all form-duration-divs
        $('.Degree').hide();
        $('.Grade').hide();
        $('.CGPA').hide();
        var divKey = $("#frm_ResultType option:selected").val();

        if (divKey == "D") {
            $('.Degree').show();
            $('.Grade').hide();
            $('.CGPA').hide();
            $('.Other').hide();
        } else if (divKey == "G") {
            $('.Degree').hide();
            $('.Grade').show();
            $('.CGPA').hide();
            $('.Other').hide();
        } else if (divKey == "C") {
            $('.Degree').hide();
            $('.Grade').hide();
            $('.CGPA').show();
            $('.Other').hide();
        }
        else if (divKey == "O") {
            $('.Degree').hide();
            $('.Grade').hide();
            $('.CGPA').hide();
            $('.Other').show();
        }
    }
    updateIsClosed();
</script>
