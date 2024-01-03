<div class="row">    
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header with-border">Employment History</div>
            <div class="card-body" style="min-height: 260px; overflow: auto;">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th style="width:5%; text-align: center;">SL#</th>
                            <th style="width:20%;">Designation</th>
                            <th style="width:25%;">Organization</th>
                            <th style="width:30%;">Description</th>
                            <th style="width:12%; text-align: center;">Duration</th>
                            <th style="width:8%; text-align: center;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $sl5 = 1; ?>
                        @foreach($experiences as $experience)
                        <tr>
                            <td style="text-align: center;">{!! $sl5 !!}</td>
                            <td>{!! $experience->Designation !!}</td>
                            <td>{!! $experience->Organization !!}</td>
                            <td>{!! $experience->Description !!}</td>
                            <td style="text-align: center;">{!! $experience->Duration !!}</td>                            
                            <td style="text-align: center;"> 
                                @if($edit)
                                <a role="button" data-toggle="modal" data-target="#experience-edit-modal{{ $experience->id }}" class="btn-sm bg-gradient-info" title="Edit"><i class="fas fa-edit"></i></a>
                                @endif
                                @if($delete)
                                <a role="button" data-toggle="modal" data-target="#experience-delete-modal{{ $experience->id }}" class="btn-sm bg-gradient-danger" title="Delete"><i class="fas fa-times"></i></a>
                                @endif
                                <!--Delete-->
                                <div class="modal fade" id="experience-delete-modal{!! $experience->id !!}" role="dialog">
                                    <div class="modal-dialog modal-md ">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title">Warning!!!</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            </div>
                                            <div class="modal-body">
                                                Are you sure you want to delete Experience Information : <strong style="color: darkorange">{!! $experience->Designation !!}</strong> ?

                                                {!! Form::open(array('url' => 'hris/database/employee/experience/'.$experience->id  )) !!}
                                            </div>
                                            <div class="modal-footer">
                                                {!! Form::hidden('_method', 'DELETE') !!}
                                                {!! Form::submit('Delete',array('class'=>'btn btn-danger'))  !!}
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                                {!! Form::close() !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--Edit Form Here-->
                                <div class="modal fade" id="experience-edit-modal{!! $experience->id !!}" role="dialog">
                                    <div class="modal-dialog modal-lg ">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title">Edit Experience Information, ID: {!! $sl5 !!}</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            </div>
                                            <div class="modal-body"> 
                                                {!! Form::open(array('url' => 'hris/database/employee/experience/'.$experience->id  )) !!}
                                                {!! Form::hidden('_method', 'PATCH') !!}
                                                @if(!empty(Session::get('error_code')) && Session::get('error_code') == $experience->id)
                                                    @include('layout/flash-message') 
                                                @endif
                                                <div class="row" style="padding-left: 10px; padding-right: 10px; text-align: left;">
                                                    <div class="col-lg-6">
                                                        <div class="control-group {!! $errors->has('Designation') ? 'has-error' : '' !!}">
                                                            <label class="control-label" for="Designation">Designation</label>
                                                            <div class="controls">
                                                                {!! Form::text('Designation', $experience->Designation, array('required', 'class'=>'form-control', 'id' => 'Designation', 'maxlength'=>'50', 'placeholder'=>'Designation', 'value'=>Input::old('Designation'))) !!}
                                                            </div>
                                                        </div>
                                                        <br>
                                                        <div class="control-group {!! $errors->has('Organization') ? 'has-error' : '' !!}">
                                                            <label class="control-label" for="Organization">Organization</label>
                                                            <div class="controls">
                                                                {!! Form::textarea('Organization', $experience->Organization, array('class'=>'form-control', 'id' => 'Organization', 'size' => '2x1', 'style' => 'resize:none', 'maxlength'=>'100', 'placeholder'=>'Organization', 'value'=>Input::old('Organization'))) !!}
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="control-group {!! $errors->has('Duration') ? 'has-error' : '' !!}">
                                                            <label class="control-label" for="Duration">Duration</label>
                                                            <div class="controls">
                                                                {!! Form::text('Duration', $experience->Duration, array('class'=>'form-control', 'id' => 'Duration', 'maxlength' => '30', 'placeholder'=>'Duration', 'value'=>Input::old('Duration'))) !!}
                                                            </div>
                                                        </div>
                                                        <br>
                                                        <div class="control-group {!! $errors->has('Description') ? 'has-error' : '' !!}">
                                                            <label class="control-label" for="Description">Description</label>
                                                            <div class="controls">
                                                                {!! Form::textarea('Description', $experience->Description, array('class'=>'form-control', 'id' => 'Description', 'size' => '2x1', 'style' => 'resize:none', 'maxlength'=>'150', 'placeholder'=>'Description', 'value'=>Input::old('Description'))) !!}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">   
                                                {!! Form::submit('Update', array('class' => 'btn btn-success')) !!}
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                                {!! Form::close() !!}  
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @if(!empty(Session::get('error_code')) && Session::get('error_code') == $experience->id)
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
            {!! Form::open(array('action' => array('\App\Http\Controllers\HRIS\Database\EmployeeController@addEmployeeData', $uniqueemp->id, 'method' => 'Post', 'form' => '5'))) !!}
             <div class="card-body" style="padding-bottom: 0;">
                <table class="table table-striped">
                    <tbody>
                        <tr>
                            <th style="width: 25%">Designation</th>
                            <td style="width: 75%">
                                <div class="control-group {!! $errors->has('Designation') ? 'has-error' : '' !!}">
                                    <div class="controls">
                                        {!! Form::text('Designation', null, array('required', 'class'=>'form-control blind', 'id' => 'Designation', 'maxlength'=>'50', 'placeholder'=>'Designation', 'value'=>Input::old('Designation'))) !!}
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th>Organization</th>
                            <td>
                               <div class="control-group {!! $errors->has('Organization') ? 'has-error' : '' !!}">
                                    <div class="controls">
                                        {!! Form::textarea('Organization', null, array('required', 'class'=>'form-control blind', 'id' => 'Organization', 'size' => '2x1', 'style' => 'resize:none', 'maxlength'=>'100', 'placeholder'=>'Organization', 'value'=>Input::old('Organization'))) !!}
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th>Description</th>
                            <td>
                               <div class="control-group {!! $errors->has('Description') ? 'has-error' : '' !!}">
                                    <div class="controls">
                                        {!! Form::textarea('Description', null, array('class'=>'form-control blind', 'id' => 'Description', 'size' => '2x1', 'style' => 'resize:none', 'maxlength'=>'150', 'placeholder'=>'Description', 'value'=>Input::old('Description'))) !!}
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th>Duration</th>
                            <td>
                               <div class="control-group {!! $errors->has('Duration') ? 'has-error' : '' !!}">
                                    <div class="controls">
                                        {!! Form::text('Duration', null, array('required', 'class'=>'form-control blind', 'id' => 'Duration', 'maxlength' => '30', 'placeholder'=>'Duration', 'value'=>Input::old('Duration'))) !!}
                                    </div>
                                </div>
                            </td>
                        </tr>                    
                    </tbody>
                </table>                
            </div>
            <div class="card-footer text-right">
                @if($edit)
                {!! Form::submit('Save', array('class' => 'btn btn-success')) !!}
                @endif
            </div>
            {!! Form::close() !!}
        </div>        
    </div>
</div>
<script type="text/javascript">
    var permis = <?php if($edit) { echo 0; }else { echo 1;}; ?>;
    $(".blind").prop("disabled", permis);
</script>
