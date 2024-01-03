
<input id="selectedCustomerOnModal" type="text" value="{{ $customer->id }}" hidden>
<div>
    <span style="font-size: 12px;"><b>{{ $customer->name }}</b> ({{ $customer->phone }})</span>
</div>
<ul class="nav nav-tabs" id="myTab" role="tablist">
    <li class="nav-item">
        <a class="nav-link active" id="profile-tab" data-toggle="tab" href="#profile" role="tab"
            aria-controls="profile" aria-selected="false">Profile</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" id="voucher-tab" data-toggle="tab" href="#voucher" role="tab"
            aria-controls="voucher" aria-selected="false">Voucher</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" id="reward-tab" data-toggle="tab" href="#reward" role="tab"
            aria-controls="reward" aria-selected="false">Reward</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" id="favourites-tab" data-toggle="tab" href="#favourites" role="tab"
            aria-controls="favourites" aria-selected="false">Favourite Items</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" id="pokeBowl-tab" data-toggle="tab" href="#pokeBowl" role="tab"
            aria-controls="pokeBowl" aria-selected="false">Poke Bowl</a>
    </li>
    <li class="nav-item">
        <a class="nav-link " id="discount-tab" data-toggle="tab" href="#discount" role="tab"
            aria-controls="discount" aria-selected="false">Discount</a>
    </li>
    <li>
        <a id="guest_profile_{{ $customer->id }}" onclick="selectCustomer({{ $customer->id }}, '{{ $customer->name }}','{{ $customer->discount_category }}')" class="nav-link bg-secondary text-white"  href="javascript:void(0)" data-dismiss="modal">Select</a>
    </li>
</ul>
<div class="tab-content" >

    <div class="tab-pane fade show active" id="profile" role="tabpanel" aria-labelledby="profile-tab">
        <h6>Profile Content</h6>
        <div class="input-box">
            <label for="mobile-number" id="mobile-number-label">Full Name:</label>
            <strong>{{ $customer->name }}</strong>
        </div>
        <div class="input-box">
            <label for="mobile-number" id="mobile-number-label">Mobile number:</label>
            <strong>{{ $customer->phone }}</strong>
        </div>
        <div class="input-box">
            <label for="mobile-number" id="mobile-number-label">Email:</label>
            <strong>{{ $customer->email }}</strong>
        </div>
    </div>
    <div class="tab-pane fade" id="voucher" role="tabpanel" aria-labelledby="voucher-tab">
        <h6>Voucher Content</h6>
        <p>This is the content of the Contact tab.</p>
    </div>
    <div class="tab-pane fade" id="reward" role="tabpanel" aria-labelledby="reward-tab">
        <h6>Reward Content</h6>
        <p>This is the content of the Contact tab.</p>
    </div>
    <div class="tab-pane fade" id="favourites" role="tabpanel" aria-labelledby="favourites-tab">
        <h6>Favourite Items</h6>
        <p>This is the content of the Contact tab.</p>
    </div>
    <div class="tab-pane fade" id="pokeBowl" role="tabpanel" aria-labelledby="pokeBowl-tab">
        <h6>Poke Bowl</h6>
        <p>This is the content of the Contact tab.</p>
    </div>
   
    <div class="tab-pane fade" id="discount" role="tabpanel" aria-labelledby="discount-tab">
        <h6>Discount</h6>
        <select onloade="alert('');" onchange="document.getElementById('showDiscountAmount').value=this.options[this.selectedIndex].getAttribute('data-show');" name="discountCategoryOnModal" id="discountCategoryOnModal">
            <option data-show="" value="" {{ $customer->discount_category ==   0 ? 'selected' : ''}}>--Select--</option>
            @foreach ($discountCategories as $category)
            <option data-show="{{ $category->amount }}{{ $category->discount_type==2?'%':'' }}" value="{{ $category->id }}" {{ $customer->discount_category ==   $category->id ? 'selected' : ''}}>{{ $category->category_name }}</option>
            @endforeach
        </select>
        <input type="text" id="showDiscountAmount" style="height: 25px; width: 60px;" readonly placeholder="Amount" value="{{ $selectedAmount }}">
        <button onclick="setDiscountToCustomer()" class="btn btn-sm btn-secondary" style="height: 25px; padding: 0px 5px;" data-dismiss="modal">Save & Select</button>

    </div>

</div>
