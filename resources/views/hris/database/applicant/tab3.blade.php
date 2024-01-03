<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header with-border">Employment History</div>
            <div class="card-body" style="min-height: 260px; overflow: auto;">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th style="width:5%; text-align: center;">SL#</th>
                            <th style="width:17%;">Designation</th>
                            <th style="width:20%;">Organization</th>
                            <th style="width:30%;">Responsibilities</th>
                            <th style="width:20%; text-align: center;">Employment Period</th>
                            <th style="width:8%; text-align: center;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $sl5 = 1; ?>
                        @foreach ($experiences as $experience)
                            <tr>
                                <td style="text-align: center;">{!! $sl5 !!}</td>
                                <td>{!! $experience->Designation !!}</td>
                                <td>{!! $experience->Organization !!}</td>
                                <td>{!! $experience->Description !!}</td>
                                <td style="text-align: center;">{!! $experience->Duration !!}</td>
                                <td style="text-align: center;">
                                    @if ($edit)
                                        <a role="button" data-toggle="modal"
                                            data-target="#experience-edit-modal{{ $experience->id }}"
                                            class="btn-sm bg-gradient-info" title="Edit"><i
                                                class="fas fa-edit"></i></a>
                                    @endif
                                    @if ($delete)
                                        <a role="button" data-toggle="modal"
                                            data-target="#experience-delete-modal{{ $experience->id }}"
                                            class="btn-sm bg-gradient-danger" title="Delete"><i
                                                class="fas fa-times"></i></a>
                                    @endif
                                    <!--Delete-->
                                    <div class="modal fade" id="experience-delete-modal{!! $experience->id !!}"
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
                                                    Are you sure you want to delete Experience Information : <strong
                                                        style="color: darkorange">{!! $experience->Designation !!}</strong> ?

                                                    {!! Form::open(['url' => 'hris/applicant/new-applicant/experience/' . $experience->id]) !!}
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
                                    <div class="modal fade" id="experience-edit-modal{!! $experience->id !!}"
                                        role="dialog">
                                        <div class="modal-dialog modal-lg ">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Edit Experience Information, ID:
                                                        {!! $sl5 !!}</h4>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close"><span
                                                            aria-hidden="true">&times;</span></button>
                                                </div>
                                                <div class="modal-body">
                                                    {!! Form::open(['url' => 'hris/applicant/new-applicant/experience/' . $experience->id]) !!}
                                                    {!! Form::hidden('_method', 'PATCH') !!}
                                                    @if (!empty(Session::get('error_code')) && Session::get('error_code') == $experience->id)
                                                        @include('layout/flash-message')
                                                    @endif
                                                    <div class="row"
                                                        style="padding-left: 10px; padding-right: 10px; text-align: left;">
                                                        <div class="col-lg-6">
                                                            <div class="control-group {!! $errors->has('Designation') ? 'has-error' : '' !!}">
                                                                <label class="control-label"
                                                                    for="Designation">Designation</label>
                                                                <div class="controls">
                                                                    {!! Form::text('Designation', $experience->Designation, [
                                                                        'required',
                                                                        'class' => 'form-control',
                                                                        'id' => 'Designation',
                                                                        'maxlength' => '50',
                                                                        'placeholder' => 'Designation',
                                                                        'value' => Input::old('Designation'),
                                                                    ]) !!}
                                                                </div>
                                                            </div>
                                                            <br>
                                                            <div class="control-group {!! $errors->has('Organization') ? 'has-error' : '' !!}">
                                                                <label class="control-label"
                                                                    for="Organization">Organization</label>
                                                                <div class="controls">
                                                                    {!! Form::textarea('Organization', $experience->Organization, [
                                                                        'class' => 'form-control',
                                                                        'id' => 'Organization',
                                                                        'size' => '2x1',
                                                                        'style' => 'resize:none',
                                                                        'maxlength' => '100',
                                                                        'placeholder' => 'Organization',
                                                                        'value' => Input::old('Organization'),
                                                                    ]) !!}
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="control-group {!! $errors->has('Duration') ? 'has-error' : '' !!}">
                                                                <label class="control-label"
                                                                    for="Duration">Duration</label>
                                                                <div class="controls">
                                                                    {!! Form::text('Duration', $experience->Duration, [
                                                                        'class' => 'form-control',
                                                                        'id' => 'Duration',
                                                                        'maxlength' => '30',
                                                                        'placeholder' => 'Duration',
                                                                        'value' => Input::old('Duration'),
                                                                    ]) !!}
                                                                </div>
                                                            </div>
                                                            <br>
                                                            <div class="control-group {!! $errors->has('Description') ? 'has-error' : '' !!}">
                                                                <label class="control-label"
                                                                    for="Description">Responsibilities</label>
                                                                <div class="controls">
                                                                    {!! Form::textarea('Description', $experience->Description, [
                                                                        'class' => 'form-control',
                                                                        'id' => 'Description',
                                                                        'size' => '2x1',
                                                                        'style' => 'resize:none',
                                                                        'maxlength' => '150',
                                                                        'placeholder' => 'Responsibilities',
                                                                        'value' => Input::old('Description'),
                                                                    ]) !!}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    {!! Form::submit('Update', ['class' => 'btn btn-success']) !!}
                                                    <button type="button" class="btn btn-default"
                                                        data-dismiss="modal">Cancel</button>
                                                    {!! Form::close() !!}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @if (!empty(Session::get('error_code')) && Session::get('error_code') == $experience->id)
                                        <script>
                                            $(function() {
                                                $('#experience-edit-modal{{ $experience->id }}').modal('show');
                                            });
                                        </script>
                                    @endif
                                </td>
                            </tr>
                            <?php $sl5++; ?>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header with-border">Input Parameters For New Experience</div>
            {!! Form::open([
                'action' => ['\App\Http\Controllers\HRIS\Applicant\ApplicantController@create', 'method' => 'Post', 'form' => '5'],
            ]) !!}
            <div class="card-body" style="padding-bottom: 0;">
                <table class="table table-striped">
                    <tbody>
                        <tr>
                            <th>Designation</th>
                            <td colspan="3">
                                <div class="control-group {!! $errors->has('Designation') ? 'has-error' : '' !!}">
                                    <div class="controls">
                                        {!! Form::text('Designation', null, [
                                            'required',
                                            'class' => 'form-control blind',
                                            'id' => 'Designation',
                                            'maxlength' => '50',
                                            'placeholder' => 'Designation',
                                            'value' => Input::old('Designation'),
                                        ]) !!}
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th>Organization</th>
                            <td colspan="3">
                                <div class="control-group {!! $errors->has('Organization') ? 'has-error' : '' !!}">
                                    <div class="controls">
                                        {!! Form::textarea('Organization', null, [
                                            'required',
                                            'class' => 'form-control blind',
                                            'id' => 'Organization',
                                            'size' => '2x1',
                                            'style' => 'resize:none',
                                            'maxlength' => '100',
                                            'placeholder' => 'Organization',
                                            'value' => Input::old('Organization'),
                                        ]) !!}
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th>Responsibilities</th>
                            <td colspan="3">
                                <div class="control-group {!! $errors->has('Description') ? 'has-error' : '' !!}">
                                    <div class="controls">
                                        {!! Form::textarea('Description', null, [
                                            'class' => 'form-control blind',
                                            'id' => 'Description',
                                            'size' => '2x1',
                                            'style' => 'resize:none',
                                            'maxlength' => '150',
                                            'placeholder' => 'Responsibilities',
                                            'value' => Input::old('Description'),
                                        ]) !!}
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th>Employment Period</th>
                            <td>
                                <div class="form-group">
                                    <label style="width: 60px">From</label>
                                    <input style="width: 140px" type="date" name="from_date[]" id="from_date"
                                        class="form-control required">
                                </div>
                            </td>
                            <td>
                                <div class="form-group" id="todate0">
                                    <label style="width: 60px" id="to_text0" class="text">To</label>
                                    <input style="width: 140px" type="date" name="to_date[]" id="to_date0"
                                        class="form-control required">
                                    <br>
                                    <input style="width: 120px" type="text" id="continued0" disabled
                                        class="form-control d-none" readonly name="to_date[]" value="continuting"
                                        placeholder="Continuing">
                                </div>
                            </td>
                            <td>
                                <div class="form-group btn-form-control">
                                    <label style="width: 150px" for="working" class="checkbox-inline">
                                        <input onchange="continueWork(this.checked,'${experienceCount}')"
                                            type="checkbox" name="working[]" id="working${experienceCount}"
                                            value="YES">
                                        Currently Working
                                    </label>
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
</script>
