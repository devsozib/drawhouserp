

<div class="row justify-content-center" id="method{{ $itemNumber }}">
    <div class="col-6 col-md-4 col-xl-2">
        <select onchange="rearengSplitBillMethod({{ $orderId }})" data-key="{{ $orderId }}-{{ $itemNumber }}" name="paymentMethod{{ $orderId }}_{{ $itemNumber }}" id="paymentMethod{{ $orderId }}_{{ $itemNumber }}" class="splitMathod{{ $orderId }} text-capitalize xsm-text d-inline-block font-weight-bold t-pt-5 t-pb-5 form-control rounded-0 text-center">
            <option value="" selected="">-Select-</option>
            @foreach ($paymentMethods as $paymentMethod)
                <option value="{{ $paymentMethod->id }}">{{ $paymentMethod->name }}</option>
            @endforeach
        </select>
    </div>

    <div class="col-6 col-md-5 col-xl-2">
        <input onchange="paymentAmountEntry('{{ $orderId }}',this,'{{ $paidAmount }}')" data-key="{{ $orderId }}-{{ $itemNumber }}" class="splitBill{{ $orderId }}" type="number" style="width: 80%;" min="0" id="amount{{ $orderId }}-{{ $itemNumber }}" value="" >
        <button class="btn btn-sm btn-primary"  onclick="removePaymentWayItem('method{{ $itemNumber }}', {{ $orderId }}, {{ $paidAmount }})">X</button>
    </div>
</div>
