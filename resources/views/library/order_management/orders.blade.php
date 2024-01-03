@extends('layout.app')
@section('title', 'Library | Order Management')
@section('content')

    <div class="content-header" style="height: 100vh;">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-right">Orders</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{!! url('library/dashboard') !!}">Library</a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Order management</a></li>
                        <li class="breadcrumb-item"><a href="{!! url('library/order_management/pos-order') !!}">Pos Order</a></li>
                    </ol>
                </div>
            </div>
        </div>

        <div class="content">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body" >
                            <div class="row mb-3">
                                <div class="col-12 col-md-4 col-lg-2">
                                    <label for="concern">Concern</label>
                                    <select class="js-example-basic-single select2" name="concern" id="concern" disabled>
                                        <option value="">-- Select --</option>
                                        @foreach ($companies as $company)
                                            <option value="{{ $company->id  }}" {{ $company->id == getHostInfo()['id'] ? 'selected' : '' }} >{{ $company->Name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-12 col-md-4 col-lg-2">
                                    <label for="start_date">Start Date</label><br>
                                    <input type="text" class="datepickerbs4v1 w-100" id="start_date" name="start_date" value="{{ date('Y-m-d') }}">
                                </div>
                                <div class="col-12 col-md-4 col-lg-2">
                                    <label for="end_date">End Date</label><br>
                                    <input type="text" class="datepickerbs4v1 w-100" id="end_date" name="end_date" value="{{ date('Y-m-d') }}">
                                </div>
                                <div class="col-12 col-md-4 col-lg-2 align-items-center">
                                    <label for="" style="display:block;"></label><br>
                                    <button class="btn btn-sm btn-primary" onclick="showOrders()">Show</button>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body" >
                    <div id="accordion">


                        <table class="table" style="">
                            <thead>
                              <tr>
                                @php
                                    $col = 14;
                                @endphp
                                <th scope="col" style="width:{{ 100/$col }}%; border: 1px solid #000;">Order Type</th>
                                <th scope="col" style="width:{{ 100/$col }}%; border: 1px solid #000;">Order From</th>
                                <th scope="col" style="width:{{ 100/$col }}%; border: 1px solid #000;">Table</th>
                                <th scope="col" style="width:{{ 100/$col }}%; border: 1px solid #000;">Order Time</th>
                                <th scope="col" style="width:{{ 100/$col }}%; border: 1px solid #000;">Guest</th>
                                <th scope="col" style="width:{{ 100/$col }}%; border: 1px solid #000;">Serve By</th>
                                <th scope="col" style="width:{{ 100/$col }}%; border: 1px solid #000;">Total Amount</th>

                                <th scope="col" style="width:{{ (100/$col) }}%; border: 1px solid #000;">Cook. Start</th>
                                <th scope="col" style="width:{{(100/$col)  }}%; border: 1px solid #000;">Cook. End</th>
                                <th scope="col" style="width:{{ (100/$col)  }}%; border: 1px solid #000;">R.T. Delivery</th>
                                <th scope="col" style="width:{{ (100/$col)}}%; border: 1px solid #000;">Delivered</th>
                                <th scope="col" style="width:{{ (100/$col) }}%; border: 1px solid #000;">Complated</th>
                                <th colspan="2" scope="col" style="width:auto;  border: 1px solid #000;">Action</th>
                              </tr>
                            </thead>
                            <tbody id="tableRow">



                            </tbody>
                        </table>


                    </div>
                </div>
            </div>

        </div>


        <script>
            function showOrders(){

                var concern = $("#concern").val();
                var start_date = $("#start_date").val();
                var end_date = $("#end_date").val();

                if(!concern || !start_date || !end_date){
                    alert('enter concern and date range');
                }

                $.get('{{ route('get_pos_order_by_ajax') }}', {concern:concern,start_date:start_date,end_date:end_date}, function(data){
                    $("#tableRow").html(data);
                });
            }

            function cookingStart(ele, orderId){
                var flag = ele.checked;
                $.get('{{ route('cooking_start_by_ajax') }}', {uniqueOrderId:orderId,flag:flag}, function(data){

                });
            }
            function cookingEnd(ele, orderId){
                var flag = ele.checked;
                $.get('{{ route('cooking_end_by_ajax') }}', {uniqueOrderId:orderId,flag:flag}, function(data){

                });
            }

            function readyToServe(ele, orderId){
                var flag = ele.checked;
                $.get('{{ route('ready_to_serve_by_ajax') }}', {uniqueOrderId:orderId,flag:flag}, function(data){

                });
            }

            function delivered(ele, orderId){
                var flag = ele.checked;
                $.get('{{ route('delivered_by_ajax') }}', {uniqueOrderId:orderId,flag:flag}, function(data){

                });
            }

            function orderComplate(ele, orderId){

            }

            function saveOrderBill(orderId, totalAmount, uniqueId){
                var splitBill = document.getElementsByClassName("splitBill"+orderId);
                var splitMethod = document.getElementsByClassName("splitMathod"+orderId);

                var enterdvalue = 0;

                var bills = [];
                var method = [];

                for(var i=0; i<splitBill.length; i++){
                    if(splitBill[i].value < 0) splitBill[i].value = 0;
                    enterdvalue += (splitBill[i].value * 1);
                    bills[splitBill[i].dataset.key] = splitBill[i].value;
                }

                for(var i=0; i<splitMethod.length; i++){
                    if(splitMethod[i].value == "") {alert("payment mode not selected"); return;}
                    method[splitMethod[i].dataset.key] = splitMethod[i].value;
                }

                if(totalAmount > enterdvalue){
                    alert("total bill less than paid amount");return;
                }
                if(totalAmount < enterdvalue){
                    alert("total bill greater than paid amount");return;
                }

                var methodWiseAmount = [];

                for (const key in method) {
                    if(!methodWiseAmount[method[key]]) methodWiseAmount[method[key]] = 0;
                    methodWiseAmount[method[key]] += bills[key]*1;
                }

                var str = "";

                for (const key in methodWiseAmount) {
                    if(str!="") str += ",";
                    str += key+"-"+methodWiseAmount[key];
                }

                $.get('{{ route('save_split_bill_by_ajax') }}', {uniqueId:uniqueId,data:str}, function(data){
                    showOrders();
                })
            }

            // update
            function Complimentary(uniqueId){
                waitingSection(true);
                $.get('{{ route('make_order_complimentary_by_ajax') }}', {uniqueId:uniqueId}, function(data){
                    getTodaysOrders();
                    makeTableBooked();
                    waitingSection(false);
                });
            }

            //update
            function addNewPaymentway(orderId,concern,paid_amount){
                var ele = document.getElementById("paymentList"+orderId);
                var itemNumber = ele.dataset.items;
                itemNumber = itemNumber*1;
                itemNumber++;

                var enterdvalue = 0;
                var splitBill = document.getElementsByClassName("splitBill"+orderId);
                for(var i=0; i<splitBill.length; i++){
                    if(splitBill[i].value < 0) splitBill[i].value = 0;
                    enterdvalue += (splitBill[i].value * 1);
                }

                waitingSection(true);
                $.get('{{ route('get_payment_method_selectOptions_by_ajax') }}', {orderId:orderId,concern:concern,itemNumber:itemNumber,paidAmount:paid_amount}, function(data){
                    ele.dataset.items = itemNumber;
                    var parser = new DOMParser();
                    var newItem = parser.parseFromString(data, "text/html").body.firstChild;
                    ele.appendChild(newItem);

                    document.getElementById("amount"+orderId+'-'+itemNumber).placeholder = paid_amount - enterdvalue;
                    document.getElementById("splitBillAddBtn"+orderId).disabled = true;

                    rearengSplitBill(orderId,paid_amount)

                    waitingSection(false);
                });
            }

            //update
            function removePaymentWayItem(id, orderId, totalAmount){
                var elementToRemove = document.getElementById(id);
                elementToRemove.parentNode.removeChild(elementToRemove);
                rearengSplitBill(orderId, totalAmount);
            }

            //update
            function paymentAmountEntry(order_id,ele,totalAmount){
                manageCashAmount(ele.dataset.key,order_id);
                var need = ele.getAttribute('placeholder') * 1;
                if(need < ele.value) ele.value = need;
                if(need > ele.value){
                    document.getElementById("splitBillAddBtn"+order_id).disabled = false;
                }
                if(need == ele.value || ele.value == 0 || ele.value == ""){
                    document.getElementById("splitBillAddBtn"+order_id).disabled = true;
                }
                rearengSplitBill(order_id,totalAmount);
            }

            // update
            function manageCashAmount(key,orderId){
                var need = document.getElementById("amount"+key).placeholder * 1;
                var received = document.getElementById("amount"+key).value * 1;

                var replacedKey = key.replace(/-/g, '_');
                var method = document.getElementById("paymentMethod"+replacedKey);
                var selectedOptionText = method.options[method.selectedIndex].text;
                selectedOptionText = selectedOptionText.trim();
                selectedOptionText = selectedOptionText.toLowerCase();

                if(selectedOptionText == "cash"){
                    var changed = 0;
                    if(need < received){
                        changed = received - need;
                    }
                    document.getElementById("cash_received"+orderId).value = received;
                    document.getElementById("cash_chenged"+orderId).value = changed;
                }
            }

            // update
            function rearengSplitBill(orderId,totalAmount){
                var splitBill = document.getElementsByClassName("splitBill"+orderId);
                var currentPlaceholder = totalAmount;
                var elementNum = splitBill.length;
                var needDeleteId = [];
                var empltInput = false;

                for(var i=0; i<elementNum; i++){
                    var ele = splitBill[i];
                    var enterdvalue = (ele.value * 1);
                    if(ele.value == "" || ele.value == 0){
                        empltInput = true;
                    }
                    if(currentPlaceholder > 0){
                        ele.placeholder = currentPlaceholder;
                        if(currentPlaceholder < enterdvalue){
                            ele.value = currentPlaceholder;
                        }
                        currentPlaceholder -=  ele.value;
                    //    manageCashAmount(ele.dataset.key,orderId);

                    }else if(currentPlaceholder <= 0){
                        var pamentModeId = (ele.dataset.key.split('-'))[1];
                        needDeleteId.push("method"+pamentModeId);
                    }
                }
                for(var i=0; i<needDeleteId.length; i++){
                    var elementToRemove = document.getElementById(needDeleteId[i]);
                    elementToRemove.parentNode.removeChild(elementToRemove);
                }

                if(currentPlaceholder > 0) {
                    if(!empltInput)document.getElementById("splitBillAddBtn"+orderId).disabled = false;
                    document.getElementById("splitBillSaveBtn"+orderId).disabled = true;
                }
                else {
                    document.getElementById("splitBillAddBtn"+orderId).disabled = true;
                    document.getElementById("splitBillSaveBtn"+orderId).disabled = false;
                }
                rearengSplitBillMethod(orderId);
            }


            // update
            function rearengSplitBillMethod(orderId){
                var elements = document.getElementsByClassName("splitMathod"+orderId);

                var idWiseSelectedmethods = [];
                var chashSelected = false;
                var cashAmount = 0;

                for(var i=0; i<elements.length; i++){
                    if(elements[i].value != "")
                        idWiseSelectedmethods[elements[i].value] = elements[i].id;

                    var key = elements[i].dataset.key;
                    var selectedOptionText = elements[i].options[elements[i].selectedIndex].text;
                    selectedOptionText = selectedOptionText.trim();
                    selectedOptionText = selectedOptionText.toLowerCase();

                    if(selectedOptionText == "cash"){
                        chashSelected = true;
                        cashAmount = document.getElementById("amount"+key).value * 1;
                    }

                }

                if(chashSelected){
                    var received = document.getElementById("cash_received"+orderId).value * 1;
                    document.getElementById("cash_chenged"+orderId).value = 0;
                    if(cashAmount<received){
                        document.getElementById("cash_chenged"+orderId).value = received - cashAmount;
                    }
                }else{
                    document.getElementById("cash_received"+orderId).value = 0;
                    document.getElementById("cash_chenged"+orderId).value = 0;
                }

                for(var i=0; i<elements.length; i++){
                    var options = elements[i].options;

                    for (var j = 0; j < options.length; j++) {
                        var option = options[j];
                        var foundKey = idWiseSelectedmethods[option.value];
                        if(foundKey && foundKey != elements[i].id){
                            option.disabled = true;
                            option.style.color = '#FB9BA5';
                        }else{
                            option.disabled = false;
                            option.style.color = '#495057';
                        }
                    }
                }
            }

        </script>

@stop
