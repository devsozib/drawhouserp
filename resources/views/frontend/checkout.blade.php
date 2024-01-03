@extends('frontend.layouts.master')
@section('content')

    <!--Custom Banner-->
    <div class="custom-banner leaf flower">
        <div class="container">
            <div class="row">

            </div>
        </div>
    </div>
    <!--/Custom Banner-->

    <!--Checkout area-->
    <section class="section-padding gray-bg-2 leaf-bottom">
        <div class="container">
            @if(!Auth::guard('customer')->check())
            <form action="{{ route('customer.login') }}" method="POST">
                @csrf
                <input type="hidden" name="function" value="felogin">
                <input type="hidden" name="returnRoute" value="{{ 'checkout' }}">
                <div class="row mb-40">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                        <div class="coupon-accordion">
                            <div class="accordion" id="accordionExample">
                                <div class="card">
                                    <div class="card-header" id="headingOne">
                                        <i class="fa fa-file-o"></i> Already Registered? <a href="#" class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne"> Sign in </a> <span class="d-block d-md-inline"><span class="d-none">or</span></span>
                                        <input onclick="selectGuestOrder(this)" class="d-none" type="checkbox" style="margin-left:10px;"> <span class="d-none">Are you order as a guest?</span>
                                    </div>
                                    <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
                                        <div class="card-body">
                                            <span>If you have an account before, please sign in below.</span>
                                            <input name="email_or_mobile" type="text" placeholder="Mobile Number or Email">
                                            <input name="password" type="password" placeholder="Password">
                                            <button type="submit" class="bttn-small btn-fill">Login</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
          </form>
          <div class="nnfgo">
              <b>Or create a new account for order.</b><br><br>
          </div>
          @endif
          @php
            $user = new stdClass();
            $isCustomer = Auth::guard('customer')->check();
            if($isCustomer){
                $user = Auth::guard('customer')->user();
            }
          @endphp
          <form action="{{ route('saveOrder') }}" method="post" id="clintDataForm">
            @csrf
            <div class="row">
              <div class="col-xl-6 col-lg-6 col-md-6">
                <div class="checkout-card">
                    <div class="input-text nnfgo">
                        <label for="fname">Full Name</label>
                        <input type="text" id="clientName" name="clientName" placeholder="Full Name" value="{{ $user->name??null }}" {{ $isCustomer?'readonly':'' }}>
                    </div>
                    <div class="input-text nnfgo">
                        <label for="email">Email Address</label>
                        <input type="text" id="clientEmail" name="clientEmail" placeholder="Email" value="{{ $user->email??null }}" {{ $isCustomer?'readonly':'' }}>
                    </div>
                    <div class="input-text">
                        <label for="pnumber">Phone Number</label>
                        <input type="text" id="clientMobile" name="clientMobile" placeholder="Mobile" value="{{ $user->phone??null }}" {{ $isCustomer?'readonly':'' }}>
                        <input type="hidden" class="input-text" id="clientBranch" name="clientBranch" value="1">
                        <input type="hidden" class="input-text" id="clientSubBranch" name="clientSubBranch" value="1">
                        <!-- <input type="hidden" class="input-text" id="clientDOB" name="clientDOB"> -->
                        <input type="hidden" class="input-text" id="clientPaymentMethod" name="clientPaymentMethod">
                        <input type="hidden" class="input-text" value="perfectOrder" name="funName">
                        <input type="hidden" class="input-text" value="0" name="deliveryCharge" id="deliveryCharge">
                        <input type="hidden" class="input-text" value="0" name="tableId" id="tableId">
                        <input type="hidden" class="input-text" id="clientId" value="{{ Auth::guard('customer')->check()?Auth::guard('customer')->user()->id:0 }}" name="clientId">
                    </div>
                    <div class="input-text nnfgo">
                        <label for="date">Date of birth</label>
                        <input type="date" id="{{ $isCustomer?'':'' }}" name="clientDOB" placeholder="Date of birth" required value="{{ $user->dob??null }}" {{ $isCustomer?'readonly':'' }}>
                    </div>
                    <div class="input-text">
                        <label for="fname">Address</label>
                        {{-- <textarea rows="3" id="clientAddress" name="clientAddress" placeholder="Client Address" {{ $isCustomer?'readonly':'' }}>{{ $user->address??null }}</textarea> --}}
                        <div style="cursor: pointer; border: 2px solid #cccbcb; border-radius: 4px; padding: 20px 10px;" class="" onclick="selectAddress()" id="selected_address">
                            <div id="default_section" class="btn-link">Select Address</div>
                            <div id="address_section" class="d-none">
                                <input type="hidden" id="selected_address_temp_id" name="selected_address_temp_id">
                                <b id="selected_address_label"></b><br>
                                <p id="selected_address_text"></p>
                            </div>
                        </div>

                        <div class="accordion shadow-lg d-none " id="addresslist">

                            @foreach ($customerAddresses as $key => $address)
                                <div class="card" id="accordion-{{ $key }}">
                                    <div class="card-header" id="heading-{{ $key }}">
                                        <h2 class="mb-0">
                                            <button class="btn btn-link collapsed w-100 text-left" type="button" data-toggle="collapse" data-target="#collapse-{{ $key }}" aria-expanded="false" aria-controls="collapse-{{ $key }}">
                                                {{ $address->address_label }}
                                            </button>
                                        </h2>
                                    </div>

                                    <div id="collapse-{{ $key }}" class="collapse" aria-labelledby="heading-{{ $key }}" data-parent="#accordion-{{ $key }}">
                                        <div class="card-body">
                                            <input type="hidden" name="address_id[]" value="{{ $address->id }}">
                                            <input type="hidden" name="temp_id[]" value="{{ $key }}">
                                            <div class="mb-3">
                                                <label for="" class="form-label">Address</label>
                                                <input type="text" id="address_{{$key}}" name="address[]" class="form-control" placeholder="Address" value="{{ $address->local_address }}">
                                            </div>

                                            <div class="mb-3">
                                                <label for="" class="form-label">Address Specification</label>
                                                <textarea id="address_specification_{{$key}}" name="address_specification[]" cols="30" rows="2">{{ $address->address_specification }}</textarea>
                                            </div>

                                            <div class="mb-3">
                                                <label for="" class="form-label">Address Label</label>
                                                <input type="text" id="address_label_{{$key}}" onchange="changeAddressLabel(this)" name="address_label[]" class="form-control addressLabel" placeholder="Address label" value="{{ $address->address_label }}">
                                            </div>
                                            <div class="mb-3 d-flex content-justify-center" >
                                                <button onclick="setAddress({{$key}})" type="button" class="btn btn-sm btn-primary">Confirm</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                            <div class="card" id="new_cart">
                                <div class="card-header" id="headingThree">
                                    <h2 class="mb-0">
                                        <button class="btn btn-link collapsed w-100 text-left" type="button" data-toggle="collapse" data-target="#collapse-add" aria-expanded="false" aria-controls="collapse-add">
                                            <div >
                                                <span style="font-size: 40px;">+</span>
                                                <span>Add New</span>
                                            </div>
                                        </button>
                                    </h2>
                                </div>
                                <div id="collapse-add" class="collapse" aria-labelledby="headingThree" data-parent="#new_cart">
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label for="new_address" class="form-label">Address</label>
                                            <input type="text" id="new_address" class="form-control" placeholder="Address">
                                        </div>

                                        <div class="mb-3">
                                            <label for="new_address_specification" class="form-label">Address Specification</label>
                                            <textarea id="new_address_specification" class="form-control" cols="30" rows="2"></textarea>
                                        </div>

                                        <div class="mb-3">
                                            <label for="new_address_label" class="form-label">Address Label</label>
                                            <input type="text" id="new_address_label" class="form-control addressLabel" placeholder="Address label">
                                        </div>
                                        <button type="button" class="btn btn-primary" onclick="addNewAddress()">Add</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    {{-- <div class="checkout-checkbox nnfgo">
                        <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="sameAddress" onclick="sameAddressFun();">
                        <label class="form-check-label" for="sameAddress">Check if same</label>
                        </div>
                    </div> --}}
                    {{-- <div class="input-text">
                        <label for="clientDeliveryAddress">Delivery Address</label>
                        <textarea rows="3" id="clientDeliveryAddress" name="clientDeliveryAddress" placeholder="Delivery Address"></textarea>
                    </div> --}}
                    <div class="input-text">
                        <label for="orderRemarks">Remarks</label>
                        <textarea rows="3" id="orderRemarks" name="orderRemarks" placeholder="Any Extra Requirements.">No Extra Requirements</textarea>
                    </div>
                    @if(!Auth::guard('customer')->check())
                        <div class="input-text nnfgo">
                            <input type="password" id="clientPassword" name="clientPassword" placeholder="Client Password">
                        </div>
                        <div class="input-text nnfgo">
                            <input type="password" id="retypePassword" name="retypePassword" placeholder="Confirm Client Password">
                        </div>
                    @endif
                </div>
              </div>
              <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                <div class="checkout-card">
                  <div class="card">
                    <div class="card-header">
                      <h4>Your order</h4>
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <thead>
                              <tr>
                                <th scope="col">Product</th>
                                <th scope="col" class="text-right">Qty</th>
                                <th scope="col" class="text-right">Su Total</th>
                              </tr>
                            </thead>
                            <tbody>
                            @php
                                $totalPrice = 0;
                            @endphp
                            @foreach (cartItems() as $cartItemKey => $cartItem)
                                @php
                                    $optionPrices = 0;
                                    $offerPriceTotal = 0;
                                    $subTotal = 0;
                                    if ($cartItem['options']){
                                        foreach ($cartItem['options'] as $item){
                                            if($item->offer_price>0){
                                                $optionPrices += $item->offer_money;
                                            }else{
                                                $optionPrices += $item->extra_price;
                                            }
                                        }
                                    }
                                    if ($cartItem['addons']){
                                        foreach ($cartItem['addons'] as $item){
                                            if($item->offer_price>0){
                                                $offerPriceTotal += $item->offer_price;
                                            }else{
                                                $offerPriceTotal += $item->extra_money_added;
                                            }
                                        }
                                    }
                                    $subTotal = ($cartItem['price'] + $offerPriceTotal + $optionPrices) * ($cartItem['quantity']);
                                    $totalPrice += $subTotal;
                                @endphp
                              <tr>
                                <td>{{ $cartItem['product']['name'] }}</td>
                                <td align="right">{{ $cartItem['quantity'] }}</td>
                                <td align="right">৳ {{ $subTotal }}</td>
                              </tr>
                            @endforeach
                                <tr>

                                    <td colspan="2" align="right">Total</td>
                                    <td align="right">৳ {{ $totalPrice }}</td>
                                </tr>
                            </tbody>
                          </table>
                    </div>
                    <div class="card-body">
                      <!-- <div class="single-checkout-total"><p class="checkout-amount">Service Charge</p><h4 class="checkout-amount">৳0</h4></div><div class="single-checkout-total"><p class="checkout-amount">VAT</p><h4 class="checkout-amount">৳0</h4></div><div class="single-checkout-total"><p class="checkout-amount">Delivery Charge</p><h4 class="checkout-amount">৳0</h4></div><div class="single-checkout-total"><p class="checkout-amount">Total</p><h4 class="checkout-amount cl-primary">৳0/-</h4></div> -->
                      <br>
                      <br>
                      <div class="checkout-checkbox">
                        <div class="form-check">
                          <input type="checkbox" class="form-check-input" id="termAndCondition" onclick="termsAndConditions();">
                          <label class="form-check-label" for="termAndCondition">Accept Our Terms & Condition ( <a href="#">View</a>) </label>
                        </div>
                      </div>
                      <div style="visibility: hidden;" id="paymentDiv">
                        <div class="payment-options">
                          <ul class="row">
                            <li class="col-xl-6 col-md-12">
                              <input type="radio" id="paymentId2" name="paymentMethod" value="2" onclick="paymentMethodSelected();">
                              <label for="paymentId2">Pay Online</label>
                              <div class="payment-option-text"></div>
                            </li>
                            <li class="col-xl-6 col-md-12">
                              <input type="radio" id="paymentId1" name="paymentMethod" value="1" onclick="paymentMethodSelected();">
                              <label for="paymentId1">Cash On Delivery</label>
                              <div class="payment-option-text"></div>
                            </li>
                          </ul>
                        </div>
                      </div>
                      <button type="button" class="bttn-mid btn-fill w-100 centered" style="visibility: hidden; z-index: 1112;" id="payOnlieButton" onclick="nextStep()">Continue to Payment</button>
                      <button type="button" class="bttn-mid btn-fill w-100 centered" style="visibility: hidden; z-index: 1112;" id="cashOnDeliveryButton" onclick="nextStep()">Confirm Order</button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </form>
        </div>
      </section>
    <!--/Checkout area-->

    @endsection

    @section('js')
      <script>
        var address_cnt = {{ count($customerAddresses)+1 }};
        function selectGuestOrder(ele){
            if (ele.checked) {
                var elements = document.getElementsByClassName("nnfgo");
                for(var i = 0; i < elements.length; i++) {
                    var element = elements[i];
                    element.style.display = "none";
                    element.disabled = true;
                }
            }else{
                var elements = document.getElementsByClassName("nnfgo");
                for(var i = 0; i < elements.length; i++) {
                    var element = elements[i];
                    element.style.display = "";
                    element.disabled = false;
                }
            }
        }
        function termsAndConditions(){
            if($('#termAndCondition').is(':checked')){
                $('#paymentDiv').css("visibility", "visible");
            }else{
                $('#paymentDiv').css("visibility", "hidden");
            }
        }
        function addNewAddress(){
            var address = $("#new_address").val();
            var address_specification = $("#new_address_specification").val();
            var address_label = $("#new_address_label").val();

            $("#new_address").val('');
            $("#new_address_specification").val('');
            $("#new_address_label").val('');

            var html = `<div class="card" id="accordion-${address_cnt}">
                                <div class="card-header" id="heading-${address_cnt}">
                                    <h2 class="mb-0">
                                        <button class="btn btn-link w-100 text-left" type="button" data-toggle="collapse" data-target="#collapse-${address_cnt}" aria-expanded="true" aria-controls="collapseOne">
                                            ${address_label}
                                        </button>
                                    </h2>
                                </div>

                                <div id="collapse-${address_cnt}" class="collapse" aria-labelledby="headingOne" data-parent="#accordion-${address_cnt}">
                                    <div class="card-body">
                                        <input type="hidden" name="address_id[]" value="">
                                        <input type="hidden" name="temp_id[]" value="${address_cnt}">
                                        <div class="mb-3">
                                        <label for="" class="form-label">Address</label>
                                        <input type="text" id="address_${address_cnt}" class="form-control" name="address[]" placeholder="Address" value="${address}">
                                        </div>

                                        <div class="mb-3">
                                        <label for="" class="form-label">Address Specification</label>
                                        <textarea id="address_specification_${address_cnt}" name="address_specification[]" cols="30" rows="2">${address_specification}</textarea>
                                        </div>

                                        <div class="mb-3">
                                        <label for="" class="form-label">Address Label</label>
                                        <input type="text" id="address_label_${address_cnt}" onchange="changeAddressLabel(this)" name="address_label[]" class="form-control addressLabel" placeholder="Address label" value="${address_label}">
                                        </div>
                                        <div class="mb-3 d-flex content-justify-center" >
                                                <button onclick="setAddress(${address_cnt})" type="button" class="btn btn-sm btn-primary">Confirm</button>
                                        </div>
                                    </div>
                                </div>
                            </div>`;

                address_cnt++;
                var newCartElement = document.getElementById("new_cart");
                newCartElement.insertAdjacentHTML('beforebegin', html);

        }

        function changeAddressLabel(ele){
            var elements = document.getElementsByClassName("addressLabel");
            var cnt = 0;
            for (var i = 0; i < elements.length; i++) {
                var element = elements[i];
                if(element.value.trim() === ele.value.trim()) {
                    cnt++;
                }
            }

            if(cnt>1){
                ele.value = "";
                alert("Duplicate address label");
            }
        }

        function selectAddress(){
            var element = document.getElementById("addresslist");
            element.classList.remove("d-none");

            var element = document.getElementById("selected_address");
            element.classList.add("d-none");
        }
        function setAddress(id){
            var address = $("#address_"+id).val();
            var address_specification = $("#address_specification_"+id).val();
            var address_label = $("#address_label_"+id).val();

            var element = document.getElementById("addresslist");
            element.classList.add("d-none");

            var element = document.getElementById("selected_address");
            element.classList.remove("d-none") ;

            var element = document.getElementById("default_section");
            element.classList.add("d-none");

            var element = document.getElementById("address_section");
            element.classList.remove("d-none") ;

            $("#selected_address_temp_id").val(id);
            $("#selected_address_label").html(address_label);
            $("#selected_address_text").html(address);

        }

        function paymentMethodSelected() {

            var clientId = $('#clientId').val();
            var clientName = $('#clientName').val();
            var clientEmail = $('#clientEmail').val();
            var clientMobile = $('#clientMobile').val();
            var clientDOB = $('#datepicker').val();
            //var clientDOB = $('#clientDate').val() + "-" + $('#clientMonth').val();
            var clientDeliveryAddress = $('#selected_address_temp_id').val();
            var clientPassword = $('#clientPassword').val();
            var retypePassword = $('#retypePassword').val();
            //$('#clientDOB').val(clientDOB);

            //alert(clientName+"  "+clientEmail+"  "+clientMobile+"  "+clientDOB+"  "+clientAddress+"  "+clientDeliveryAddress);

            if (clientName != "" && clientEmail != "" && clientMobile != "" && clientDOB != "" && clientDeliveryAddress != "") {

                var id = document.querySelector('input[name="paymentMethod"]:checked').value;
                if (id == 1) {
                    $('#payOnlieButton').css("visibility", "hidden");
                    $('#cashOnDeliveryButton').css("visibility", "visible");
                } else if (id == 2) {
                    $('#payOnlieButton').css("visibility", "visible");
                    $('#cashOnDeliveryButton').css("visibility", "hidden");
                } else {
                    $('#payOnlieButton').css("visibility", "hidden");
                    $('#cashOnDeliveryButton').css("visibility", "visible");
                }
            } else {
                alert('Please Select All Fields !');
            }
        }

        function nextStep() {
            var paymentId = document.querySelector('input[name="paymentMethod"]:checked').value;
            $('#clientPaymentMethod').val(paymentId);
            // if (paymentId == 2) {
            //     $('#tableId').val("0");
            // }else{

            // }
            var clientId = $('#clientId').val();
            var clientName = $('#clientName').val();
            var clientEmail = $('#clientEmail').val();
            var clientMobile = $('#clientMobile').val();
            var clientDOB = $('#datepicker').val();
            // var clientAddress = $('#clientAddress').val();
            var clientDeliveryAddress = $('#selected_address_temp_id').val();
            var clientPassword = $('#clientPassword').val();
            var retypePassword = $('#retypePassword').val();

            if (paymentId != "" || clientName != "" || clientEmail != "" || clientMobile != "" || clientDOB != "" || clientDeliveryAddress != "") {

                if (clientId >= 0) {

                    $('#clintDataForm').submit();

                } else {
                    alert('Please Fill All The Fields !');
                }
            } else {
                alert('Please Fill All The Fields !');
            }
        }
      </script>
    @endsection
