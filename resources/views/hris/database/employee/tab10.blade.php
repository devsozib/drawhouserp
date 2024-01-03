<div class="row">
    <div class="col-lg-12">
        <div class="card">
            {!! Form::open(array('action' => array('\App\Http\Controllers\HRIS\Database\EmployeeController@addEmployeeData', $uniqueemp->id, 'method' => 'Post', 'form' => '10'))) !!}
            <div class="card-body" style="padding-bottom: 0;"> 
                <div class="row">
                    <div class="col-lg-4" style="padding-left: 5px; padding-right: 5px;">
                        <table class="table table-striped">
                            <tbody>
                                <tr>
                                    <th style="width: 35%">নাম</th>
                                    <td style="width: 65%">
                                        <div class="control-group {!! $errors->has('NameB') ? 'has-error' : '' !!}">
                                            <div class="controls">
                                                {!! Form::text('NameB', $uniquebangla->NameB, array('required', 'class'=>'form-control blind', 'id' => 'NameB', 'maxlength' => '35', 'placeholder'=>'নাম', 'value'=>Input::old('NameB'))) !!}
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th>পিতার নাম</th>
                                    <td>
                                        <div class="control-group {!! $errors->has('FatherB') ? 'has-error' : '' !!}">
                                            <div class="controls">
                                                {!! Form::text('FatherB', $uniquebangla->FatherB, array('required', 'class'=>'form-control blind', 'id' => 'FatherB', 'maxlength' => '35', 'placeholder'=>'পিতার নাম', 'value'=>Input::old('FatherB'))) !!}
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th>মাতার নাম</th>
                                    <td>
                                    <div class="control-group {!! $errors->has('MotherB') ? 'has-error' : '' !!}">
                                            <div class="controls">
                                                {!! Form::text('MotherB', $uniquebangla->MotherB, array('required', 'class'=>'form-control blind', 'id' => 'MotherB', 'maxlength' => '35', 'placeholder'=>'মাতার নাম', 'value'=>Input::old('MotherB'))) !!}
                                            </div>
                                        </div> 
                                    </td>
                                </tr>                            
                                <tr>
                                    <td colspan="2">
                                        <p style="font-weight: 800; color: forestgreen; font-size: 1.2em; padding-left: 5px; line-height: 2em;">বর্তমান ঠিকানা</p>
                                        <table style="width:100%; margin-top: -10px;" class="table">
                                            <tr>
                                                <th style="width: 35%">জেলা</th>
                                                <td style="width: 65%">
                                                    <div class="control-group {!! $errors->has('MDistrictIDB') ? 'has-error' : '' !!}">
                                                        <div class="controls">
                                                            {!! Form::select('MDistrictIDB', $districtlistb, $uniquebangla->MDistrictIDB, array('required', 'class'=>'form-control select2bs4 blind', 'id' => 'MDistrictIDB', 'placeholder'=>'নির্বাচন করুন', 'value'=>Input::old('MDistrictIDB'))) !!}
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>                                        
                                            <tr>
                                                <th>থানা</th>
                                                <td>
                                                    <div class="control-group {!! $errors->has('MThanaIDB') ? 'has-error' : '' !!}">
                                                        <div class="controls">
                                                            {!! Form::select('MThanaIDB', $thanalistb, $uniquebangla->MThanaIDB, array('required', 'class'=>'form-control select2bs4 blind', 'id' => 'MThanaIDB', 'placeholder'=>'নির্বাচন করুন', 'value'=>Input::old('MThanaIDB'))) !!}
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>ডাকঘর</th>
                                                <td>
                                                    <div class="control-group {!! $errors->has('MPOfficeB') ? 'has-error' : '' !!}">
                                                        <div class="controls">
                                                            {!! Form::text('MPOfficeB', $uniquebangla->MPOfficeB, array('required', 'class'=>'form-control blind', 'id' => 'MPOfficeB', 'maxlength'=>'50', 'placeholder'=>'ডাকঘর', 'value'=>Input::old('MPOfficeB'))) !!}
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>বাড়ি নং/রাস্তা নং /গ্রাম</th>
                                                <td>
                                                    <div class="control-group {!! $errors->has('MVillageB') ? 'has-error' : '' !!}">
                                                        <div class="controls">
                                                            {!! Form::text('MVillageB', $uniquebangla->MVillageB, array('required', 'class'=>'form-control blind', 'id' => 'MVillageB', 'maxlength'=>'50', 'placeholder'=>'বাড়ি নং/রাস্তা নং/গ্রাম', 'value'=>Input::old('MVillageB'))) !!}
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
                    <div class="col-lg-4" style="padding-left: 5px; padding-right: 5px;">
                        <table class="table table-striped">
                            <tbody>                           
                                <tr>
                                    <th style="width: 35%">সনাক্ত করণ চিহ্ন</th>
                                    <td style="width: 65%">
                                        <div class="control-group {!! $errors->has('IdentificationB') ? 'has-error' : '' !!}">
                                            <div class="controls">
                                                {!! Form::text('IdentificationB', $uniquebangla->IdentificationB, array('class'=>'form-control blind', 'id' => 'IdentificationB', 'maxlength' => '50', 'placeholder'=>'সনাক্ত করণ', 'value'=>Input::old('IdentificationB'))) !!}
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th>আচরণ</th>
                                    <td>
                                        <div class="control-group {!! $errors->has('Conduct') ? 'has-error' : '' !!}">
                                            <div class="controls">
                                                {!! Form::text('Conduct', $uniquebangla->Conduct, array('class'=>'form-control blind', 'id' => 'Conduct', 'maxlength' => '50', 'placeholder'=>'আচরণ', 'value'=>Input::old('Conduct'))) !!}
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th>স্বামী/স্ত্রী</th>
                                    <td>
                                        <div class="control-group {!! $errors->has('SpouseB') ? 'has-error' : '' !!}">
                                            <div class="controls">
                                                {!! Form::text('SpouseB', $uniquebangla->SpouseB, array('class'=>'form-control blind', 'id' => 'SpouseB', 'maxlength' => '35', 'placeholder'=>'স্বামী/স্ত্রী', 'value'=>Input::old('SpouseB'))) !!}
                                            </div>
                                        </div>
                                    </td>
                                </tr>                            
                                <tr>
                                    <td colspan="2">
                                        <p style="font-weight: 800; color: forestgreen; font-size: 1.2em; padding-left: 5px; line-height: 2em;">স্থায়ী ঠিকানা</p>  
                                        <table style="width:100%; margin-top: -10px;" class="table">
                                            <tr>
                                                <th style="width: 35%">জেলা</th>
                                                <td style="width: 65%">
                                                    <div class="control-group {!! $errors->has('PDistrictIDB') ? 'has-error' : '' !!}">
                                                        <div class="controls">
                                                            {!! Form::select('PDistrictIDB', $districtlistb, $uniquebangla->PDistrictIDB, array('required', 'class'=>'form-control select2bs4 blind', 'id' => 'PDistrictIDB', 'placeholder'=>'নির্বাচন করুন', 'value'=>Input::old('PDistrictIDB'))) !!}
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>থানা</th>
                                                <td>
                                                    <div class="control-group {!! $errors->has('PThanaIDB') ? 'has-error' : '' !!}">
                                                        <div class="controls">
                                                            {!! Form::select('PThanaIDB', $thanalistb, $uniquebangla->PThanaIDB, array('required', 'class'=>'form-control select2bs4 blind', 'id' => 'PThanaIDB', 'placeholder'=>'নির্বাচন করুন', 'value'=>Input::old('PThanaIDB'))) !!}
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>ডাকঘর</th>
                                                <td>
                                                    <div class="control-group {!! $errors->has('PPOfficeB') ? 'has-error' : '' !!}">
                                                        <div class="controls">
                                                            {!! Form::text('PPOfficeB', $uniquebangla->PPOfficeB, array('required', 'class'=>'form-control blind', 'id' => 'PPOfficeB', 'maxlength'=>'50', 'placeholder'=>'ডাকঘর', 'value'=>Input::old('PPOfficeB'))) !!}
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>বাড়ি নং/রাস্তা নং /গ্রাম</th>
                                                <td>
                                                    <div class="control-group {!! $errors->has('MVillageB') ? 'has-error' : '' !!}">
                                                        <div class="control-group {!! $errors->has('PVillageB') ? 'has-error' : '' !!}">
                                                            <div class="controls">
                                                                {!! Form::text('PVillageB', $uniquebangla->PVillageB, array('required', 'class'=>'form-control blind', 'id' => 'PVillageB', 'maxlength'=>'50', 'placeholder'=>'বাড়ি নং/রাস্তা নং/গ্রাম', 'value'=>Input::old('PVillageB'))) !!}
                                                            </div>
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
                    <div class="col-lg-4" style="padding-left: 5px; padding-right: 5px;">
                        <table class="table table-striped">
                            <tbody>
                                <tr>
                                    <th style="width: 40%">নমিনি</th>
                                    <td style="width: 60%">
                                        <div class="control-group {!! $errors->has('NomineeB') ? 'has-error' : '' !!}">
                                            <div class="controls">
                                                {!! Form::text('NomineeB', $uniquebangla->NomineeB, array('class'=>'form-control blind', 'id' => 'NomineeB', 'maxlength' => '35', 'placeholder'=>'নমিনি', 'value'=>Input::old('NomineeB'))) !!}
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th>সম্পর্ক</th>
                                    <td>
                                        <div class="control-group {!! $errors->has('RelationB') ? 'has-error' : '' !!}">
                                            <div class="controls">
                                                {!! Form::text('RelationB', $uniquebangla->RelationB, array('class'=>'form-control blind', 'id' => 'RelationB', 'maxlength' => '30', 'placeholder'=>'সম্পর্ক', 'value'=>Input::old('RelationB'))) !!}
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2" style="line-height: 1.7em;"></td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <p style="font-weight: 800; color: forestgreen; font-size: 1.2em; padding-left: 5px; line-height: 2em;">নমিনির ঠিকানা</p> 
                                        <table style="width:100%; margin-top: -10px;" class="table"> 
                                            <tr>
                                                <th style="width: 35%">জেলা</th>
                                                <td style="width: 65%">
                                                    <div class="control-group {!! $errors->has('NDistrictIDB') ? 'has-error' : '' !!}">
                                                        <div class="controls">
                                                            {!! Form::select('NDistrictIDB', $districtlistb, $uniquebangla->NDistrictIDB, array('class'=>'form-control select2bs4 blind', 'id' => 'NDistrictIDB', 'placeholder'=>'নির্বাচন করুন', 'value'=>Input::old('NDistrictIDB'))) !!}
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>থানা</th>
                                                <td>
                                                    <div class="control-group {!! $errors->has('NThanaIDB') ? 'has-error' : '' !!}">
                                                        <div class="controls">
                                                            {!! Form::select('NThanaIDB', $thanalistb, $uniquebangla->NThanaIDB, array('class'=>'form-control select2bs4 blind', 'id' => 'NThanaIDB', 'placeholder'=>'নির্বাচন করুন', 'value'=>Input::old('NThanaIDB'))) !!}
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>ডাকঘর</th>
                                                <td>
                                                    <div class="control-group {!! $errors->has('NPOfficeB') ? 'has-error' : '' !!}">
                                                        <div class="controls">
                                                            {!! Form::text('NPOfficeB', $uniquebangla->NPOfficeB, array('class'=>'form-control blind', 'id' => 'NPOfficeB', 'maxlength'=>'50', 'placeholder'=>'ডাকঘর', 'value'=>Input::old('NPOfficeB'))) !!}
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>বাড়ি নং/রাস্তা নং /গ্রাম</th>
                                                <td>
                                                    <div class="control-group {!! $errors->has('NVillageB') ? 'has-error' : '' !!}">
                                                        <div class="controls">
                                                            {!! Form::text('NVillageB', $uniquebangla->NVillageB, array('class'=>'form-control blind', 'id' => 'NVillageB', 'maxlength'=>'50', 'placeholder'=>'বাড়ি নং/রাস্তা নং/গ্রাম', 'value'=>Input::old('NVillageB'))) !!}
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
    
    var distID3 = $("#MDistrictIDB option:selected").val();
    var thanaID3 = '<?php echo $uniquebangla->MThanaIDB ?>';
    if(distID3){
        $.ajax({
            type:"GET",
            url:"{{url('hris/database/getthanabn')}}",
            data:{
                dist_idbn: distID3,
            },
            success:function(data){               
                if(data){
                    $("#MThanaIDB").empty();
                    $.each(data,function(key,value){
                        $("#MThanaIDB").append('<option value="'+key+'">'+value+'</option>');
                    });
                    $("#MThanaIDB").val(thanaID3);
                }else{
                   $("#MThanaIDB").empty();
                }
            }
        });
    }else{
        $("#MThanaIDB").empty();
    }
    $('#MDistrictIDB').on("change", function (event) {
        event.preventDefault();
        var distID = $("#MDistrictIDB option:selected").val();    
        if(distID){
            $.ajax({
                type:"GET",
                url:"{{url('hris/database/getthanabn')}}",
                data:{
                    dist_idbn: distID,
                },
                success:function(data){               
                    if(data){
                        $("#MThanaIDB").empty();
                        $.each(data,function(key,value){
                            $("#MThanaIDB").append('<option value="'+key+'">'+value+'</option>');
                        });
                    }else{
                       $("#MThanaIDB").empty();
                    }
                }
            });
        }else{
            $("#MThanaIDB").empty();
        }      
    });
    var distID4 = $("#PDistrictIDB option:selected").val();
    var thanaID4 = '<?php echo $uniquebangla->PThanaIDB ?>';  
    console.log(thanaID4);
    if(distID4){
        $.ajax({
            type:"GET",
            url:"{{url('hris/database/getthanabn')}}",
            data:{
                dist_idbn: distID4,
            },
            success:function(data){               
                if(data){
                    $("#PThanaIDB").empty();
                    $.each(data,function(key,value){
                        $("#PThanaIDB").append('<option value="'+key+'">'+value+'</option>');
                    });
                    $("#PThanaIDB").val(thanaID4);
                }else{
                   $("#PThanaIDB").empty();
                }
            }
        });
    }else{
        $("#PThanaIDB").empty();
    }
    $('#PDistrictIDB').on("change", function (event) {
        event.preventDefault();
        var distID = $("#PDistrictIDB option:selected").val();    
        if(distID){
            $.ajax({
                type:"GET",
                url:"{{url('hris/database/getthanabn')}}",
                data:{
                    dist_idbn: distID,
                },
                success:function(data){               
                    if(data){
                        $("#PThanaIDB").empty();
                        $.each(data,function(key,value){
                            $("#PThanaIDB").append('<option value="'+key+'">'+value+'</option>');
                        });
                    }else{
                       $("#PThanaIDB").empty();
                    }
                }
            });
        }else{
            $("#PThanaIDB").empty();
        }      
    });
    
    var distID5 = $("#NDistrictIDB option:selected").val();
    var thanaID5 = '<?php echo $uniquebangla->NThanaIDB ?>';
    if(distID5){
        $.ajax({
            type:"GET",
            url:"{{url('hris/database/getthanabn')}}",
            data:{
                dist_idbn: distID5,
            },
            success:function(data){               
                if(data){
                    $("#NThanaIDB").empty();
                    $.each(data,function(key,value){
                        $("#NThanaIDB").append('<option value="'+key+'">'+value+'</option>');
                    });
                    $("#NThanaIDB").val(thanaID5);
                }else{
                   $("#NThanaIDB").empty();
                }
            }
        });
    }else{
        $("#NThanaIDB").empty();
    }
    $('#NDistrictIDB').on("change", function (event) {
        event.preventDefault();
        var distID = $("#NDistrictIDB option:selected").val();    
        if(distID){
            $.ajax({
                type:"GET",
                url:"{{url('hris/database/getthanabn')}}",
                data:{
                    dist_idbn: distID,
                },
                success:function(data){               
                    if(data){
                        $("#NThanaIDB").empty();
                        $.each(data,function(key,value){
                            $("#NThanaIDB").append('<option value="'+key+'">'+value+'</option>');
                        });
                    }else{
                       $("#NThanaIDB").empty();
                    }
                }
            });
        }else{
            $("#NThanaIDB").empty();
        }      
    });
</script>
    