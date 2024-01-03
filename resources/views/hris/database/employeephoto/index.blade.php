
@extends('layout.app')
@section('title', 'HRIS | Employee Photo')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0" style="text-align: right;"></h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{!! url('hris/dashboard') !!}">HRIS</a></li>
                        <li class="breadcrumb-item"><a href="javascript::void(0)">Database</a></li>
                        <li class="breadcrumb-item"><a href="{!! url('hris/database/employeephoto') !!}">Employee Photo</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Index</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="row">
            <div class="col-lg-1"></div>
            <div class="col-lg-10">
                <div class="card">
                    <div class="card-header with-border text-center" style="font-size: 20px;">Employee Photo</div>
                    {!! Form::open(array('action' => array('\App\Http\Controllers\HRIS\Database\EmployeePhotoController@store', 'method' => 'Post'), 'id'=>'add_form', 'files'=>true)) !!}
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-5">
                                <table class="table table-bordered">
                                    <tbody>
                                        <tr>
                                            <th style="width: 33%">Employee ID</th>
                                            <td style="width: 2%">:</td>
                                            <td style="width: 65%">
                                                <div class="control-group {!! $errors->has('EmployeeID') ? 'has-error' : '' !!}">
                                                    <div class="controls">
                                                        {!! Form::number('EmployeeID', null, array('required', 'class'=>'form-control', 'id' => 'EmployeeID', 'min' => '100', 'max' => '999999', 'placeholder'=>'Employee ID', 'value'=>Input::old('EmployeeID'))) !!}
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Name</th>
                                            <td>:</td>
                                            <td>
                                                <div class="control-group {!! $errors->has('Name') ? 'has-error' : '' !!}">
                                                    <div class="controls">
                                                        {!! Form::text('Name', null, array('readonly', 'class'=>'form-control', 'id' => 'Name', 'placeholder'=>'Employee Name', 'value'=>Input::old('Name'))) !!}
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Designation</th>
                                            <td>:</td>
                                            <td>
                                                <div class="control-group {!! $errors->has('Designation') ? 'has-error' : '' !!}">
                                                    <div class="controls">
                                                        {!! Form::text('Designation', null, array('readonly', 'class'=>'form-control', 'id' => 'Designation', 'placeholder'=>'Designation', 'value'=>Input::old('Designation'))) !!}
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Department</th>
                                            <td>:</td>
                                            <td>
                                                <div class="control-group {!! $errors->has('Department') ? 'has-error' : '' !!}">
                                                    <div class="controls">
                                                        {!! Form::text('Department', null, array('readonly', 'class'=>'form-control', 'id' => 'Department', 'placeholder'=>'Department', 'value'=>Input::old('Department'))) !!}
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Joining Date</th>
                                            <td>:</td>
                                            <td>
                                                <div class="control-group {!! $errors->has('JoiningDate') ? 'has-error' : '' !!}">
                                                    <div class="controls">
                                                        {!! Form::text('JoiningDate', null, array('readonly', 'class'=>'form-control', 'id' => 'JoiningDate', 'placeholder'=>'Joining Date', 'value'=>Input::old('JoiningDate'))) !!}
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-lg-4">
                                <table class="table table-bordered">
                                    <tbody>
                                        <tr>
                                            <th style="width: 38%">Photo(531x650)</th>                                            
                                            <td style="width: 2%">:</td>
                                            <td style="width: 60%">
                                                <div class="col-md-3 d-none" id="image_sec">
                                                    <div class="form-group ">
                                                        {{-- <label for="Name">Ingredient Image</label> --}}
                                                        <img style="width:100px" id="image-preview"
                                                            src="#" alt="Preview" class="mb-2" >
                                                    </div>
                                                </div>
                                                <div>
                                                    <span class="btn btn-default btn-file">
                                                        <span class="fileinput-new">Select Photo</span>
                                                        {{-- {!! Form::file('image', null, array('class'=>'form-control', 'id' => 'image', 'placeholder'=>'Image', 'value'=>Input::old('image'))) !!} --}}
                                                        <input type="file" name="image" id="image"
                                                        class="form-control" value="{{ old('image') }}">
                                                    </span>
                                                    <a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Sign(300x80)</th>
                                            <td>:</td>
                                            <td>
                                                <div class="col-md-3 d-none" id="sigimage_sec">
                                                    <div class="form-group">
                                                        {{-- <label for="Name">Ingredient Image</label> --}}
                                                        <img style="width:100px" class="mb-2" id="sign-preview"
                                                            src="#" alt="Preview">
                                                    </div>
                                                </div>
                                                <div>
                                                    <span class="btn btn-default btn-file">
                                                        <span class="fileinput-new">Select Signature</span>
                                                        {{-- {!! Form::file('sign', null, array('class'=>'form-control', 'id' => 'sign', 'placeholder'=>'sign', 'value'=>Input::old('sign'))) !!} --}}
                                                        <input type="file" name="sign" id="sign"
                                                        class="form-control " value="{{ old('sign') }}">
                                                    </span>
                                                    <a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-lg-3 text-center">
                                <table class="table table-bordered text-center">
                                    <tbody>
                                        <tr>
                                            <th style="width: 100%; padding: 5px;">Existing Photo</th>
                                        </tr>
                                        <tr>
                                            <th style="width: 100%; padding: 15px;">
                                                <img id="imagev" src="{!! URL::asset('images/Portrait_Placeholder.png') !!}" height="140"/>
                                            </th>
                                        </tr>
                                        <tr>
                                            <th style="width: 100%; padding: 5px;">Existing Signature</th>
                                        </tr>
                                        <tr>
                                            <th style="width: 100%; padding: 15px;">
                                                <img id="signv" src="{!! URL::asset('images/jk-placeholder-image-300x203.jpg') !!}" width="150" height="80"/>
                                            </th>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        @if($create)
                            {!! Form::submit('Upload Photo And Sign', array('class' => 'btn btn-success')) !!}
                        @endif
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
            <div class="col-lg-1"></div>
        </div>
    </div>

    <script type="text/javascript">
        var domain = '<?= $imgpath ?>';
        $('#EmployeeID').on("input", function () {
            var empID = $("#EmployeeID").val();
            if(empID.length >= emplen){
                $.ajax({
                    type:"GET",
                    url:"{{url('hris/database/getempphoto')}}",
                    data:{
                        emp_id: empID,
                    },
                    success:function(data){
                        if(data){
                            $("#Name").val(data[0].Name);
                            $("#Designation").val(data[0].Designation);
                            $("#Department").val(data[0].Department);
                            $("#JoiningDate").val(data[0].JoiningDate);
                            $('#imagev').attr('src', domain + '/public/profiles/' + data[0].Photo);
                            $('#signv').attr('src', domain + '/public/sign/' + data[0].Sign);
                        }else{
                            $("#Name").val('');
                            $("#Designation").val('');
                            $("#Department").val('');
                            $("#JoiningDate").val('');
                            $('#image').attr('src','');
                            $('#sign').attr('src','');
                        }
                    }
                });
            }else{
                $("#Name").val('');
                $("#Designation").val('');
                $("#Department").val('');
                $("#JoiningDate").val('');
                $('#image').attr('src','');
                $('#sign').attr('src','');
            }
        });
        $('#image').change(function() {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#image_sec').removeClass('d-none');
                $('#image-preview').attr('src', e.target.result);
            }
            reader.readAsDataURL(this.files[0]);
        })
        $('#sign').change(function() {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#sigimage_sec').removeClass('d-none');
                $('#sign-preview').attr('src', e.target.result);
            }
            reader.readAsDataURL(this.files[0]);
        })
    </script>
@stop
