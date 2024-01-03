<div class="row">
    <div class="col-12">
        <div class="card">
            {!! Form::open([
                'action' => [
                    '\App\Http\Controllers\HRIS\Database\EmployeeController@addEmployeeData',
                    $uniqueemp->id,
                    'method' => 'Post',
                    'form' => '2',
                ],
            ]) !!}
            <div class="card-body" style="padding-bottom: 0;">
                <div class="row">
                    <div class="col-lg-8" style="padding-left: 5px; padding-right: 5px;">
                        <table style="width: 100%;">
                            <tr>
                                <td style="width:50%; padding-right: 5px;">
                                    <table class="table table-striped">
                                        <tbody>
                                            <tr>
                                                <th style="width: 50%">Gross Salary</th>
                                                <td style="width: 50%">
                                                    <div class="control-group {!! $errors->has('GrossSalary') ? 'has-error' : '' !!}">
                                                        <div class="controls">
                                                            {!! Form::number('GrossSalary', $uniquesalary->GrossSalary, [
                                                                'required',
                                                                'class' => 'form-control blind',
                                                                'id' => 'GrossSalary',
                                                                'pattern' => '[0-9]+([\.,][0-9]+)?',
                                                                'step' => '0.01',
                                                                'min' => '0',
                                                                'placeholder' => 'Gross Salary',
                                                                'value' => Input::old('GrossSalary'),
                                                                'oninput' => 'totalSalaryHandle(this.value, "gross");',
                                                            ]) !!}
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Basic</th>
                                                <td>
                                                    <div class="control-group {!! $errors->has('Basic') ? 'has-error' : '' !!}">
                                                        <div class="controls">
                                                            {!! Form::number('Basic', $uniquesalary->Basic, [
                                                                'readonly',
                                                                'class' => 'form-control blind',
                                                                'id' => 'Basic',
                                                                'pattern' => '[0-9]+([\.,][0-9]+)?',
                                                                'step' => '0.01',
                                                                'min' => '0',
                                                                'placeholder' => 'Basic Salary',
                                                                'value' => Input::old('Basic'),
                                                            ]) !!}
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>House Rent</th>
                                                <td>
                                                    <div class="control-group {!! $errors->has('HomeAllowance') ? 'has-error' : '' !!}">
                                                        <div class="controls">
                                                            {!! Form::number('HomeAllowance', $uniquesalary->HomeAllowance, [
                                                                'readonly',
                                                                'class' => 'form-control blind',
                                                                'id' => 'HomeAllowance',
                                                                'pattern' => '[0-9]+([\.,][0-9]+)?',
                                                                'step' => '0.01',
                                                                'min' => '0',
                                                                'placeholder' => 'House Rent',
                                                                'value' => Input::old('HomeAllowance'),
                                                            ]) !!}
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Medical Allowance</th>
                                                <td>
                                                    <div class="control-group {!! $errors->has('MedicalAllowance') ? 'has-error' : '' !!}">
                                                        <div class="controls">
                                                            {!! Form::number('MedicalAllowance', $uniquesalary->MedicalAllowance, [
                                                                'readonly',
                                                                'class' => 'form-control blind',
                                                                'id' => 'MedicalAllowance',
                                                                'pattern' => '[0-9]+([\.,][0-9]+)?',
                                                                'step' => '0.01',
                                                                'min' => '0',
                                                                'placeholder' => 'Medical Allowance',
                                                                'value' => Input::old('MedicalAllowance'),
                                                            ]) !!}
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th style="width: 50%">Conveyance</th>
                                                <td style="width: 50%">
                                                    <div class="control-group {!! $errors->has('Conveyance') ? 'has-error' : '' !!}">
                                                        <div class="controls">
                                                            {!! Form::number('Conveyance', $uniquesalary->Conveyance, [
                                                                'readonly',
                                                                'class' => 'form-control blind',
                                                                'id' => 'Conveyance',
                                                                'pattern' => '[0-9]+([\.,][0-9]+)?',
                                                                'step' => '0.01',
                                                                'min' => '0',
                                                                'placeholder' => 'Conveyance',
                                                                'value' => Input::old('Conveyance'),
                                                            ]) !!}
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                                <td style="width:50%; padding-left: 5px;">
                                    <table class="table table-striped">
                                        <tbody>
                                            <tr>
                                                <th>Housing Allowance</th>
                                                <td>
                                                    <div class="control-group {!! $errors->has('HousingAllowance') ? 'has-error' : '' !!}">
                                                        <div class="controls">
                                                            {!! Form::number('HousingAllowance', $uniquesalary->HousingAllowance, [
                                                                'class' => 'form-control blind',
                                                                'id' => 'HousingAllowance',
                                                                'pattern' => '[0-9]+([\.,][0-9]+)?',
                                                                'step' => '0.01',
                                                                'min' => '0',
                                                                'placeholder' => 'Housing Allowance',
                                                                'value' => Input::old('HousingAllowance'),
                                                                'oninput' => 'totalSalaryHandle(this.value, "housing");', 
                                                            ]) !!}
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Other Allowance</th>
                                                <td>
                                                    <div class="control-group {!! $errors->has('OtherAllowance') ? 'has-error' : '' !!}">
                                                        <div class="controls">
                                                            {!! Form::number('OtherAllowance', $uniquesalary->OtherAllowance, array('class'=>'form-control blind', 'id' => 'OtherAllowance', 'pattern'=>'[0-9]+([\.,][0-9]+)?', 'step'=>'0.01', 'min'=>'0', 'placeholder'=>'Other Allowance', 'value'=>Input::old('OtherAllowance'), 'oninput' => 'totalSalaryHandle(this.value, "other");')) !!}
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Food Allowance</th>
                                                <td>
                                                    <div class="control-group {!! $errors->has('FoodAllowance') ? 'has-error' : '' !!}">
                                                        <div class="controls">
                                                            {!! Form::number('FoodAllowance', $uniquesalary->FoodAllowance, [
                                                                'class' => 'form-control blind',
                                                                'id' => 'FoodAllowance',
                                                                'pattern' => '[0-9]+([\.,][0-9]+)?',
                                                                'step' => '0.01',
                                                                'min' => '0',
                                                                'placeholder' => 'Food Allowance',
                                                                'value' => Input::old('FoodAllowance'),
                                                            ]) !!}
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Service Charge</th>
                                                <td>
                                                    <div class="control-group {!! $errors->has('ServiceCharge') ? 'has-error' : '' !!}">
                                                        <div class="controls">
                                                            {!! Form::number('ServiceCharge', $monthlySerivceCharge?$monthlySerivceCharge:'', [
                                                                'class' => 'form-control blind',
                                                                'id' => 'ServiceCharge',
                                                                'pattern' => '[0-9]+([\.,][0-9]+)?',
                                                                'step' => '0.01',
                                                                'min' => '0',
                                                                'placeholder' => 'Service Charge',
                                                                'value' => Input::old('ServiceCharge'),
                                                            ]) !!}
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Service Charge(%)</th>
                                                <td>
                                                    <div class="control-group {!! $errors->has('ServiceChargePer') ? 'has-error' : '' !!}">
                                                        <div class="controls">
                                                            {!! Form::text('ServiceChargePer', $uniquesalary->ServiceChargePer, [
                                                                'class' => 'form-control blind',
                                                                'id' => 'ServiceCharge',
                                                                'placeholder' => 'ServiceChargePer',
                                                                'value' => Input::old('ServiceChargePer'),
                                                            ]) !!}
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                          
                                            {{-- <tr>
                                                <th>Attendance Bonus</th>
                                                <td>
                                                    <div class="control-group {!! $errors->has('AttendanceBonus') ? 'has-error' : '' !!}">
                                                        <div class="controls">
                                                            {!! Form::number('AttendanceBonus', $uniquesalary->AttendanceBonus, [
                                                                'class' => 'form-control blind',
                                                                'id' => 'AttendanceBonus',
                                                                'pattern' => '[0-9]+([\.,][0-9]+)?',
                                                                'step' => '0.01',
                                                                'min' => '0',
                                                                'placeholder' => 'Attendance Bonus',
                                                                'value' => Input::old('AttendanceBonus'),
                                                            ]) !!}
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Holiday Allowance?</th>
                                                <td>
                                                    <div class="control-group {!! $errors->has('HolidayAllowance') ? 'has-error' : '' !!}">
                                                        <div class="controls">
                                                            {!! Form::select('HolidayAllowance', ['N' => 'No', 'Y' => 'Yes'], $uniquesalary->HolidayAllowance, [
                                                                'class' => 'form-control blind',
                                                                'id' => 'HolidayAllowance',
                                                                'value' => Input::old('HolidayAllowance'),
                                                            ]) !!}
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr> --}}
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-lg-4" style="padding-left: 5px; padding-right: 5px;">
                        <table style="width: 100%;">
                            <tr>
                                <td style="width:50%; padding-right: 5px;">
                                    <table class="table table-striped">
                                        <tbody>
                                            <tr>
                                                <th>Overtime Payable</th>
                                                <td>
                                                    <div class="control-group {!! $errors->has('OTPayable') ? 'has-error' : '' !!}">
                                                        <div class="controls">
                                                            {!! Form::select('OTPayable', ['N' => 'No', 'Y' => 'Yes'], $uniquesalary->OTPayable, [
                                                                'class' => 'form-control blind',
                                                                'id' => 'OTPayable',
                                                                'value' => Input::old('OTPayable'),
                                                            ]) !!}
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th style="width: 50%">OT Allowance Fixed</th>
                                                <td style="width: 50%">
                                                    <div class="control-group {!! $errors->has('SalaryFromBank') ? 'has-error' : '' !!}">
                                                        <div class="controls">
                                                            {!! Form::number('OTAllowanceFixed', $uniquesalary->OTAllowanceFixed, [
                                                                'class' => 'form-control blind',
                                                                'id' => 'OTAllowanceFixed',
                                                                'maxlength' => '16',
                                                                'placeholder' => 'OT Allowance Fixed',
                                                                'value' => Input::old('OTAllowanceFixed'),
                                                            ]) !!}
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th style="width: 50%">Payment Method{{ old($uniquesalary->SalaryFromBank) }}</th>
                                                <td style="width: 50%">
                                                    <div class="control-group {!! $errors->has('SalaryFromBank') ? 'has-error' : '' !!}">
                                                        <div class="controls">
                                                            {!! Form::select('SalaryFromBank', ['N' => 'Cash', 'Y' => 'Bank'], $uniquesalary->SalaryFromBank, [
                                                                'class' => 'form-control blind',
                                                                'id' => 'SalaryFromBank',
                                                                'onchange' => 'paymentMethodHandle(this.value)',
                                                                'placeholder' => 'Select One',
                                                                'value' => Input::old('SalaryFromBank'),
                                                            ]) !!}
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr id="bank" class="{{ ($uniquesalary->BankId ==null && $uniquesalary->SalaryFromBank  == 'N') || old($uniquesalary->SalaryFromBank) == 'N' ?'d-none':' '}}">
                                               
                                                    <th style="width: 50%">Bank</th>
                                                    <td style="width: 50%">
                                                        <div class="control-group {!! $errors->has('Bank') ? 'has-error' : '' !!}">
                                                            <div class="controls">
                                                                {!! Form::select('Bank', $bankList,  $uniquesalary->BankId, [
                                                                    'disabled'=>$uniquesalary->BankId != null ? false:true,
                                                                    'class' => 'form-control',
                                                                    'id' => 'Bank',
                                                                    'placeholder' => 'Select One',
                                                                    'value' => old('Bank'),
                                                                ]) !!}
                                                            </div>
                                                        </div>
                                                    </td>
                                                
                                            </tr>
                                            <tr id="account" class="{{ $uniquesalary->AccountNo ==null && $uniquesalary->SalaryFromBank == 'N' ?'d-none':' '}}">
                                                
                                                    <th tyle="width: 50%">Account No</th>
                                                    <td  style="width: 50%">
                                                        <div class="control-group {!! $errors->has('AccountNo') ? 'has-error' : '' !!}">
                                                            <div class="controls">
                                                                {!! Form::text('AccountNo', $uniquesalary->AccountNo, [
                                                                    'disabled'=> $uniquesalary->AccountNo!=null?false:true,
                                                                    'class' => 'form-control blind',
                                                                    'id' => 'AccountNo',
                                                                    'maxlength' => '16',
                                                                    'placeholder' => 'Account Number',
                                                                    'value' => Input::old('AccountNo'),
                                                                ]) !!}
                                                            </div>
                                                        </div>
                                                    </td>
                                                
                                                
                                            </tr>
                                            {{-- <tr>
                                                <th style="width: 50%">Mobile Banking</th>
                                                <td style="width: 50%">
                                                    <div class="control-group {!! $errors->has('MobileBanking') ? 'has-error' : '' !!}">
                                                        <div class="controls">
                                                            <!--{!! Form::text('MobileBanking', $uniquesalary->MobileBanking, [
                                                                // 'required',
                                                                'class' => 'form-control blind',
                                                                'id' => 'MobileBanking',
                                                                // 'pattern' => '(01)[0-9]{9}[A-Z]{1}',
                                                                'minlength' => '11',
                                                                'maxlength' => '15',
                                                                'placeholder' => 'Mobile Banking',
                                                                'value' => Input::old('MobileBanking'),
                                                            ]) !!}-->
                                                            {!! Form::text('MobileBanking', $uniquesalary->MobileBanking, [
                                                                // 'required',
                                                                'class' => 'form-control blind',
                                                                'id' => 'MobileBanking',
                                                                // 'pattern' => '(01)[0-9]{10}',
                                                                'minlength' => '11',
                                                                'maxlength' => '15',
                                                                'placeholder' => 'Mobile Banking',
                                                                'value' => Input::old('MobileBanking'),
                                                            ]) !!}
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr> --}}
                                            {{-- <tr>
                                                <th>Cash?{{ $uniqueemp->Cash }}</th>
                                                <td>
                                                    <div class="control-group {!! $errors->has('Cash') ? 'has-error' : '' !!}">
                                                        <div class="controls">
                                                            {!! Form::select('Cash', ['Y' => 'Yes', 'N' => 'NO'], $uniquesalary->Cash, [
                                                                'required',
                                                                'class' => 'form-control blind',
                                                                'id' => 'Cash',
                                                                'value' => Input::old('Cash'),
                                                            ]) !!}
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr> --}}
                                            {{-- <tr>
                                                <th>TIN</th>
                                                <td>
                                                    <div class="control-group {!! $errors->has('TIN') ? 'has-error' : '' !!}">
                                                        <div class="controls">
                                                            {!! Form::text('TIN', $uniquesalary->TIN, [
                                                                'class' => 'form-control blind',
                                                                'id' => 'TIN',
                                                                'maxlength' => '16',
                                                                'placeholder' => 'TIN',
                                                                'value' => Input::old('TIN'),
                                                            ]) !!}
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Tax</th>
                                                <td>
                                                    <div class="control-group {!! $errors->has('Tax') ? 'has-error' : '' !!}">
                                                        <div class="controls">
                                                            {!! Form::number('Tax', $uniquesalary->Tax, [
                                                                'class' => 'form-control blind',
                                                                'id' => 'Tax',
                                                                'pattern' => '[0-9]+([\.,][0-9]+)?',
                                                                'step' => '0.01',
                                                                'min' => '0',
                                                                'placeholder' => 'Tax',
                                                                'value' => Input::old('Tax'),
                                                            ]) !!}
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>PF</th>
                                                <td>
                                                    <div class="control-group {!! $errors->has('PF') ? 'has-error' : '' !!}">
                                                        <div class="controls">
                                                            {!! Form::number('PF', $uniquesalary->PF, [
                                                                'class' => 'form-control blind',
                                                                'id' => 'PF',
                                                                'pattern' => '[0-9]+([\.,][0-9]+)?',
                                                                'step' => '0.01',
                                                                'min' => '0',
                                                                'placeholder' => 'PF',
                                                                'value' => Input::old('PF'),
                                                            ]) !!}
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr> --}}
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <div class="card-footer" style="display: flex; justify-content: space-between; align-items: center;">
                <strong>Total Salary: <span id="totalSalary">{{ $uniquesalary->GrossSalary + $uniquesalary->HousingAllowance + $uniquesalary->OtherAllowance }}</span></strong>
                <div style="margin-left: auto;">
                    @if ($edit) {!! Form::submit('Save', ['class' => 'btn btn-success']) !!} @endif
                </div>
            </div>
            
            
            {!! Form::close() !!}
        </div>
    </div>
</div>

{{-- <div class="row">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header with-border">
                <h3 class="card-title">History of Other Allowance</h3>
            </div>
            <div class="card-body" style="padding-bottom: 0;">
                <table class="table table-bordered">
                    <thead>
                        <th>SL#</th>
                        <th>ID</th>
                        <th>Date Changed</th>
                        <th>Amount</th>
                    </thead>
                    <tbody>
                        <?php $sl3 = 1; ?>
                        @foreach ($empotherallowances as $empotherallowance)
                            <tr>
                                <td>{!! $sl3 !!}</td>
                                <td>{!! $empotherallowance->EmployeeID !!}</td>
                                <td>{!! $empotherallowance->DateChanged !!}</td>
                                <td>{!! $empotherallowance->Amount !!}</td>
                            </tr>
                            <?php $sl3++; ?>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div> --}}

<script type="text/javascript">
    var permis = <?php if ($edit) {
        echo 0;
    } else {
        echo 1;
    } ?>;
    $(".blind").prop("disabled", permis);
    //apply for automatic calaculation
    /* var medical = <?= $optionalparam->MedicalAllowance; ?>;
    var food = <?= $optionalparam->FoodAllowance; ?>;
    var conveyance = <?= $optionalparam->Conveyance; ?>;
    var mfcallowance = medical + food + conveyance;
    var hrpb = <?= $optionalparam->HouseRentPercentBasic; ?>; */

    /*var grossalary  = parseInt(document.getElementById('GrossSalary').value);
    if(grossalary > 0){
        var basicraw = (grossalary-mfcallowance)/((100+hrpb)/100);
        var basic = Math.round(basicraw);
        var houserent = Math.round((basicraw/100)*hrpb);
        $('#Basic').val(basic);
        $('#HomeAllowance').val(houserent);
        $('#MedicalAllowance').val(medical);
        $('#FoodAllowance').val(food);
        $('#Conveyance').val(conveyance);
    }else{
        $('#Basic').val(0);
        $('#HomeAllowance').val(0);
        $('#MedicalAllowance').val(0);
        $('#FoodAllowance').val(0);
        $('#Conveyance').val(0);
    }*/
    $('#GrossSalary').on('input', function() {
        var grossalary = parseInt(document.getElementById('GrossSalary').value);
        if (grossalary > 0) {
            var basicper = '<?= $hroptions->BasicPer; ?>';
            var hrentper = '<?= $hroptions->HRentPer; ?>';
            var medper = '<?= $hroptions->MedPer; ?>';
            var convper = '<?= $hroptions->ConvPer; ?>';

            var basic = Math.round((grossalary/100) * basicper);
            var houserent = Math.round((grossalary/100) * hrentper);
            var medical = Math.round((grossalary/100) * medper);
            var conveyance = Math.round((grossalary/100) * convper);
            $('#Basic').val(basic);
            $('#HomeAllowance').val(houserent);
            $('#MedicalAllowance').val(medical);
            $('#Conveyance').val(conveyance);
        } else {
            $('#Basic').val(0);
            $('#HomeAllowance').val(0);
            $('#MedicalAllowance').val(0);
            $('#Conveyance').val(0);
        }
    });

    function paymentMethodHandle(id) {
        var bankRow = document.getElementById('bank');
        var bankDropdown = document.getElementById('Bank');
        var accountRow = document.getElementById('account');
        var accountInput = document.getElementById('AccountNo');


        if (id == 'Y') {
            // Show and enable Bank dropdown
            bankRow.classList.remove('d-none');
            bankDropdown.disabled = false;
            accountRow.classList.remove('d-none');
            accountInput.disabled = false;
        } else {
            // Hide and disable Bank dropdown
            bankRow.classList.add('d-none');
            bankDropdown.disabled = true;
            accountRow.classList.add('d-none');
            accountInput.disabled = true;
        }
    }

    function totalSalaryHandle(amount, type) {
        var grossalary = parseInt(document.getElementById('GrossSalary').value);
        var HousingAllowance = parseInt(document.getElementById('HousingAllowance').value);
        var OtherAllowance = parseInt(document.getElementById('OtherAllowance').value);
        // Calculate total salary based on input parameters
        var totalSalary = grossalary+HousingAllowance+OtherAllowance;

        // Update the DOM element with the new total salary
        document.getElementById("totalSalary").innerText = totalSalary;
    }

    // function calculateTotalSalary(amount, type) {
    //     // Your calculation logic here based on amount and type
    //     // For example:
    //     return amount + type;
    // }

</script>
