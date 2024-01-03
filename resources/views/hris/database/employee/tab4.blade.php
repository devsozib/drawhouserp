<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header with-border">Training Summary</div>
            <div class="card-body" style="padding-bottom: 0; min-height: 230px; overflow: auto;">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th style="width:5%;">SL#</th>
                            <th style="width:35%;">Training Title</th>
                            <th style="width:26%;">Country</th>
                            <th style="width:13%;">Topics Covered</th>
                            <th style="width:13%;">Training Year</th>
                            <th style="width:13%;">Institute</th>
                            <th style="width:13%;">Duration</th>
                            <th style="width:13%;">Location</th>
                            <th style="width:8%;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $sl4 = 1; ?>
                        @foreach($trainings as $training)
                        <tr>
                            <td>{!! $sl4 !!}</td>
                            <td>{!! $training->tr_title  !!}</td>
                            <td>{!! $training->tr_country !!}</td>
                            <td>{!! $training->topic_coverd !!}</td>
                            <td>{!! $training->training_year !!}</td>
                            <td>{!! $training->tr_institute !!}</td>
                            <td>{!! $training->Duration !!}</td>
                            <td>{!! $training->tr_location !!}</td>
                            <td>
                                @if($edit)
                                <a role="button" data-toggle="modal" data-target="#training-edit-modal{{ $training->id }}" class="btn-sm bg-gradient-info" title="Edit"><i class="fas fa-edit"></i></a>
                                @endif
                                @if($delete)
                                <a role="button" data-toggle="modal" data-target="#training-delete-modal{{ $training->id }}" class="btn-sm bg-gradient-danger" title="Delete"><i class="fas fa-times"></i></a>
                                @endif

                                <!--Delete-->
                                <div class="modal fade" id="training-delete-modal{!! $training->id !!}" role="dialog">
                                    <div class="modal-dialog modal-md ">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title">Warning!!!</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            </div>
                                            <div class="modal-body">
                                                Are you sure you want to delete Training Information : <strong style="color: darkorange">{!! $training->tr_title !!}</strong> ?

                                                {!! Form::open(array('url' => 'hris/database/employee/training/'.$training->id  )) !!}
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
                                <div class="modal fade" id="training-edit-modal{!! $training->id !!}" role="dialog">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title">Edit Training Information, ID: {!! $sl4 !!}</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            </div>
                                            <div class="modal-body">
                                                {!! Form::open(array('url' => 'hris/database/employee/training/'.$training->id  )) !!}
                                                {!! Form::hidden('_method', 'PATCH') !!}
                                                @if(!empty(Session::get('error_code')) && Session::get('error_code') == $training->id)
                                                    @include('layout/flash-message')
                                                @endif
                                                <div class="row">
                                                    <div class="col-md-8">
                                                        <div class="form-group {!! $errors->has('TrainingTypeID') ? 'has-error' : '' !!}">
                                                            <label for="TrainingTypeID">Training</label>
                                                            <div class="controls">
                                                                {!! Form::select('TrainingTypeID', $traininglist, $training->TrainingTypeID, array('required', 'class'=>'form-control', 'id' => 'TrainingTypeID', 'placeholder'=>'Select One', 'value'=>Input::old('TrainingTypeID'))) !!}
                                                            </div>
                                                        </div>
                                                        <br>
                                                        <div class="form-group {!! $errors->has('Instructor') ? 'has-error' : '' !!}">
                                                            <label for="Instructor">Instructor</label>
                                                            <div class="controls">
                                                                {!! Form::text('Instructor', $training->Instructor, array('class'=>'form-control', 'id' => 'Instructor', 'maxlength' => '30', 'placeholder'=>'Instructor', 'value'=>Input::old('Instructor'))) !!}
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group {!! $errors->has('Grade') ? 'has-error' : '' !!}">
                                                            <label for="Grade">Grade</label>
                                                            <div class="controls">
                                                                {!! Form::text('Grade', $training->Grade, array('class'=>'form-control', 'id' => 'Grade', 'maxlength' => '30', 'placeholder'=>'Grade', 'value'=>Input::old('Grade'))) !!}
                                                            </div>
                                                        </div>
                                                        <br>
                                                        <div class="form-group {!! $errors->has('Duration') ? 'has-error' : '' !!}">
                                                            <label for="Duration">Duration</label>
                                                            <div class="controls">
                                                                {!! Form::text('Duration', $training->Duration, array('class'=>'form-control', 'id' => 'Duration', 'maxlength'=>'30', 'placeholder'=>'Duration', 'value'=>Input::old('Duration'))) !!}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                {!! Form::number('CreatedBy', Sentinel::getUser()->id, array('class'=>'form-control  hidden', 'id' => 'CreatedBy', 'value'=>Input::old('CreatedBy'))) !!}
                                                {!! Form::submit('Update', array('class' => 'btn btn-success')) !!}
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                                {!! Form::close() !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @if(!empty(Session::get('error_code')) && Session::get('error_code') == $training->id)
                                <script>
                                    $(function() {
                                        $('#training-edit-modal{{ $training->id }}').modal('show');
                                    });
                                </script>
                                @endif
                            </td>
                        </tr>
                        <?php $sl4++; ?>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header with-border">Input Parameters For New Training</div>
            {!! Form::open(array('action' => array('\App\Http\Controllers\HRIS\Database\EmployeeController@addEmployeeData', $uniqueemp->id, 'method' => 'Post', 'form' => '4'))) !!}
            <div class="card-body" style="padding-bottom: 0;">
                <table class="table table-striped">
                    <tbody>
                        <tr>
                            <th style="width: 25%">Training Title</th>
                            <td style="width: 75%">
                                <div class="form-group {!! $errors->has('tr_title') ? 'has-error' : '' !!}">
                                    <div class="controls">
                                        <input type="text" placeholder="Training Title"
                                                    name="tr_title" id="tr_title"
                                                    class="form-control required" value="{{ old('tr_title') }}">
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th>Country</th>
                            <td>
                                <div class="form-group {!! $errors->has('tr_country') ? 'has-error' : '' !!}">
                                    <input type="text" placeholder="Country" name="tr_country"
                                                    id="tr_country" class="form-control required" value="{{ old('tr_country') }}">
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th>Topics Covered</th>
                            <td>
                               <div class="form-group {!! $errors->has('topic_coverd') ? 'has-error' : '' !!}">
                                <input type="text" placeholder="Topics Covered" name="topic_coverd"
                                id="topic_coverd" class="form-control required" value="{{ old('topic_coverd') }}">
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th>Training Year</th>
                            <td>
                               <div class="form-group {!! $errors->has('training_year') ? 'has-error' : '' !!}">
                                <select name="training_year" id="training_year"
                                                    class="form-control required select2bs4">
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
                            </td>
                        </tr>
                        <tr>
                            <th>Institute</th>
                            <td>
                                <div class="form-group {!! $errors->has('tr_institute') ? 'has-error' : '' !!}">
                                    <div class="controls">
                                        <input type="text" placeholder="Institute" name="tr_institute"
                                        id="tr_institute" class="form-control required" value="{{ old('tr_institute') }}">
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th>Duration</th>
                            <td>
                                <div class="form-group {!! $errors->has('Duration') ? 'has-error' : '' !!}">
                                    <div class="controls">
                                        <input type="text" placeholder="Duration" name="Duration"
                                        id="Duration" class="form-control required" value="{{ old('Duration') }}">
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th>Location</th>
                            <td>
                                <div class="form-group {!! $errors->has('tr_location') ? 'has-error' : '' !!}">
                                    <div class="controls">
                                        <input type="text" placeholder="Location" name="tr_location"
                                                    id="tr_location" class="form-control required" value="{{ old('tr_location') }}">
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
