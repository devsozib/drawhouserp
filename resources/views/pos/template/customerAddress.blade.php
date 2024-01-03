
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
                        <label for="" class="form-label">Address Specification</label><br>
                        <textarea id="address_specification_{{$key}}" name="address_specification[]" cols="30" rows="2">{{ $address->address_specification }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label for="" class="form-label">Address Label</label>
                        <input type="text" id="address_label_{{$key}}" onchange="changeAddressLabel(this)" name="address_label[]" class="form-control addressLabel" placeholder="Address label" value="{{ $address->address_label }}">
                    </div>
                    <div class="mb-3 d-flex content-justify-center" >
                        <button onclick="setAddress({{$key}})" type="button" class="btn btn-sm btn-primary" data-dismiss="modal">Confirm</button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
        <div class="card" id="new_cart">
            <div class="card-header" id="headingThree">
                <h2 class="mb-0">
                    <button class="btn btn-link w-100 text-left collapsed" type="button" data-toggle="collapse" data-target="#collapse-add" aria-expanded="false" aria-controls="collapse-add">
                        <div>
                            <span style="font-size: 40px;">+</span>
                            <span>Add New</span>
                        </div>
                    </button>
                </h2>
            </div>
            <div id="collapse-add" class="collapse" aria-labelledby="headingThree" data-parent="#new_cart" style="">
                <div class="card-body">
                    <div class="mb-3">
                        <label for="new_address" class="form-label">Address</label>
                        <input type="text" id="new_address" class="form-control" placeholder="Address">
                    </div>

                    <div class="mb-3">
                        <label for="new_address_specification" class="form-label">Address Specification</label><br>
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
