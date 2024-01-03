<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header with-border">Reference Summary</div>
            <div class="card-body" style="padding-bottom: 0; min-height: 230px; overflow: auto;">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th style="width:5%;">SL#</th>
                            <th style="width:35%;">Name</th>
                            <th style="width:26%;">Occupation</th>
                            <th style="width:13%;">Organization</th>
                            <th style="width:13%;">Org Address</th>
                            <th style="width:13%;">Phone</th>
                            <th style="width:13%;">Email</th>
                            <th style="width:13%;">Realation</th>
                            <th style="width:8%;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $sl4 = 1; ?>
                        @foreach($uniquereferences as $reference)
                        <tr>
                            <td>{!! $sl4 !!}</td>
                            <td>{!! $reference->r_name  !!}</td>
                            <td>{!! $reference->r_occupation !!}</td>
                            <td>{!! $reference->r_organization !!}</td>
                            <td>{!! $reference->r_org_add !!}</td>
                            <td>{!! $reference->r_phone !!}</td>
                            <td>{!! $reference->r_email !!}</td>
                            <td>{!! $reference->r_relation !!}</td>
                            <td>
                                @if($edit)
                                <a role="button" data-toggle="modal" data-target="#training-edit-modal{{ $reference->id }}" class="btn-sm bg-gradient-info" title="Edit"><i class="fas fa-edit"></i></a>
                                @endif
                                @if($delete)
                                <a role="button" data-toggle="modal" data-target="#training-delete-modal{{ $reference->id }}" class="btn-sm bg-gradient-danger" title="Delete"><i class="fas fa-times"></i></a>
                                @endif

                                <!--Delete-->
                                <div class="modal fade" id="training-delete-modal{!! $reference->id !!}" role="dialog">
                                    <div class="modal-dialog modal-md ">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title">Warning!!!</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            </div>
                                            <div class="modal-body">
                                                Are you sure you want to delete?

                                                {!! Form::open(array('url' => 'hris/database/employee/reference/'.$reference->id  )) !!}
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
                               <div class="modal fade" id="training-edit-modal{!! $reference->id !!}" role="dialog">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title">Edit Reference Information of {{ $reference->r_name }}</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            </div>
                                            <div class="modal-body">
                                                {!! Form::open(array('url' => 'hris/database/employee/reference/'.$reference->id  )) !!}
                                                {!! Form::hidden('_method', 'PATCH') !!}
                                                @if(!empty(Session::get('error_code')) && Session::get('error_code') == $reference->id)
                                                    @include('layout/flash-message')
                                                @endif
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group {!! $errors->has('r_name') ? 'has-error' : '' !!}">
                                                            <label for="TrainingTypeID">Name</label>
                                                            <div class="controls">
                                                                <input value="{{ old('r_name',$reference->r_name) }}" type="text" name="r_name" id="r_name"
                                                                    class="form-control required" placeholder="Name">
                                                            </div>
                                                        </div>
                                                        <br>
                                                        <div class="form-group {!! $errors->has('r_occupation') ? 'has-error' : '' !!}">
                                                            <label for="TrainingTypeID">Occupation</label>
                                                            <div class="controls">
                                                                <select class="form-control required" onchange="uhandleOcc(this.value)" name="r_occupation" id="r_occupation">
                                                                    <option value="" selected>Select</option>
                                                                    <option {{ $reference->r_occupation == 'business'?'selected':'' }} value="business">Busniness</option>
                                                                    <option {{ $reference->r_occupation == 's_h'?'selected':'' }} value="s_h">Service Holder</option>
                                                                    <option {{ $reference->r_occupation == 'others'?'selected':'' }} value="others">Others</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <br>
                                                        <div id="uorg_sec" class="form-group {!! $errors->has('r_organization') ? 'has-error' : '' !!}">
                                                            <label for="Duration">Organization</label>
                                                            <div class="controls">
                                                                <input value="{{ old('r_organization',$reference->r_organization) }}" type="text" name="r_organization" id="ur_organization"
                                                                class="form-control" placeholder="Organization">
                                                            </div>
                                                        </div>
                                                        <br>
                                                        <div id="uorg_add" class="form-group {!! $errors->has('r_org_add') ? 'has-error' : '' !!}">
                                                            <label for="Duration">Organization Address</label>
                                                            <div class="controls">
                                                                <input value="{{ old('r_org_add',$reference->r_org_add) }}" type="text" name="r_org_add" id="ur_org_add"
                                                                class="form-control" placeholder="Organization address">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div  class="form-group {!! $errors->has('r_phone') ? 'has-error' : '' !!}">
                                                            <label for="Duration">Phone</label>
                                                            <div class="controls">
                                                                <input value="{{ old('r_phone',$reference->r_phone) }}" type="text" name="r_phone" id="name"
                                                                class="form-control required" placeholder="Phone">
                                                            </div>
                                                        </div>
                                                        <br>
                                                        <div  class="form-group {!! $errors->has('r_email') ? 'has-error' : '' !!}">
                                                            <label for="Duration">Email</label>
                                                            <div class="controls">
                                                                <input value="{{ old('r_email',$reference->r_email) }}" type="text" name="r_email" id="name"
                                                                class="form-control" placeholder="Email">
                                                            </div>
                                                        </div>
                                                        <br>
                                                        <div  class="form-group {!! $errors->has('r_relation') ? 'has-error' : '' !!}">
                                                            <label for="Duration">Relation with applicant</label>
                                                            <div class="controls">
                                                                <input value="{{ old('r_relation',$reference->r_relation) }}" type="text" name="r_relation" id="name"
                                                                     class="form-control required" placeholder="Relation with applicant">
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
            {!! Form::open(array('action' => array('\App\Http\Controllers\HRIS\Database\EmployeeController@addEmployeeData', $uniqueemp->id, 'method' => 'Post', 'form' => '7'))) !!}
            <div class="card-body" style="padding-bottom: 0;">
                <table class="table table-striped">
                    <tbody>
                        <tr>
                            <th style="width: 50%">Name</th>
                            <td style="width: 50%">
                                <div class="control-group {!! $errors->has('r_name') ? 'has-error' : '' !!}">
                                    <div class="controls">
                                        <input value="{{ old('r_name') }}" type="text" name="r_name" id="r_name"
                                                class="form-control required" placeholder="Name">
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th>Occupation</th>
                            <td>
                               <div class="control-group {!! $errors->has('r_occupation') ? 'has-error' : '' !!}">
                                    <div class="controls">
                                        <select class="form-control required" onchange="handleOcc(this.value)" name="r_occupation" id="r_occupation">
                                            <option value="" selected>Select</option>
                                            <option value="business">Busniness</option>
                                            <option value="s_h">Service Holder</option>
                                            <option value="others">Others</option>
                                        </select>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr id="org_sec" class="">
                            <th>Organization</th>
                            <td>
                               <div class="control-group {!! $errors->has('r_organization') ? 'has-error' : '' !!}">
                                    <div class="controls">
                                        <input value="{{ old('r_organization') }}" type="text" name="r_organization" id="r_organization"
                                                class="form-control" placeholder="Organization">
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr id="org_add" class="">
                            <th>Organization Address</th>
                            <td>
                               <div class="control-group {!! $errors->has('r_org_add') ? 'has-error' : '' !!}">
                                    <div class="controls">
                                        <input value="{{ old('r_org_add') }}" type="text" name="r_org_add" id="r_org_add"
                                        class="form-control" placeholder="Organization Address">
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th>Phone</th>
                            <td>
                               <div class="control-group {!! $errors->has('r_phone') ? 'has-error' : '' !!}">
                                    <div class="controls">
                                        <input value="{{ old('r_phone') }}" type="text" name="r_phone" id="name"
                                        class="form-control required" placeholder="Phone">
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th>Email(Optional)</th>
                            <td>
                               <div class="control-group {!! $errors->has('r_email') ? 'has-error' : '' !!}">
                                    <div class="controls">
                                        <input value="{{ old('r_email') }}" type="email" name="r_email" id="name"
                                        class="form-control" placeholder="Email">
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th>Relation With applicant</th>
                            <td>
                               <div class="control-group {!! $errors->has('r_relation') ? 'has-error' : '' !!}">
                                    <div class="controls">
                                        <input value="{{ old('r_relation') }}" type="text" name="r_relation" id="name"
                                        class="form-control required" placeholder="Relation with applicant">
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
    $('#ReferenceID').on('input', function () {
        var empID= $("#ReferenceID").val();
        if(empID){
            $.ajax({
                type:"GET",
                url:"{{url('hris/database/getemployee')}}",
                data:{
                    emp_id: empID
                },
                success:function(data){
                    if(data){
                        $("#ReferenceName").val(data);
                    }else{
                       $("#ReferenceName").empty();
                    }
                }
            });
        }else{
            $("#ReferenceName").empty();
        }
    });

    function handleOcc(occ) {
        if(occ == 'others'){
            $('#org_sec').addClass('d-none');
            $('#org_add').addClass('d-none');
        }else{
            $('#org_sec').removeClass('d-none');
            $('#org_add').removeClass('d-none');
        }

    }

    function uhandleOcc(occ) {
        if(occ == 'others'){
            $('#uorg_sec').addClass('d-none');
            $('#uorg_add').addClass('d-none');
            $('#ur_organization').val('');
            $('#ur_org_add').val('');
            console.log(occ);
        }else{
            $('#uorg_sec').removeClass('d-none');
            $('#uorg_add').removeClass('d-none');
        }

    }
</script>
