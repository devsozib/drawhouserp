@extends('frontend.layouts.master') @section('content')
<!--Custom Banner-->
<div class="custom-banner leaf flower">
  <div class="container">
    <div class="row"></div>
  </div>
</div>
<!--/Custom Banner-->
<!--Cart area-->
<section class="section-padding gray-bg-2 leaf-bottom" id="cartsddddd">
    <div class="container">
      <div class="row mb-60">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
          <div class="cart-items table-responsive">
            <table class="table centered borderless">
              <thead>
                <tr>
                  <th scope="col">Image</th>
                  <th scope="col">Product</th>
                  <th scope="col">Price</th>
                  <th scope="col">Quantity</th>
                  <th scope="col">Total</th>                 
                  <th scope="col">Remove</th>
                </tr>
              </thead>
              <tbody>
                @foreach(cartItems() as $cartItemKey => $cartItem)
                <tr>
                  <td>
                    <img src="{{ asset('product_images/' . $cartItem['product']['image']) }}" alt="{{ $cartItem['product']['name'] }}">
                  </td>
                  <td>
                    <a href="">{{ $cartItem['product']['name'] }}</a>
                    <br>
                    <span>
                      <p>
                        <b>Size:</b> {{ $cartItem['size']['size_name'] }}
                      </p>
                      <p>
                        <b>Options:</b>
                        @foreach($cartItem['options'] as $option)
                          {{ $option['name'] }},
                        @endforeach
                      </p>
                      <p>
                        <b>Addons:</b>
                        @foreach($cartItem['addons'] as $addon)
                          {{ $addon['name'] }},
                        @endforeach
                      </p>
                    </span>
                  </td>
                  <td>৳ {{ $cartItem['price'] }}</td>
                  <td>
                    <input min="0" max="100" onchange="updateCartQuantitys('{{ $cartItemKey  }} ',this.value)"  value="{{ $cartItem['quantity'] }}" type="number" id="quantity{{ $cartItem['product']['id'] }}">
                  </td>
                  <td>৳ {{ $cartItem['quantity'] * $cartItem['price'] }}</td>                 
                  <td>
                    <a class="remove-button" onclick="removeCartItems('{{ $cartItemKey  }}','{{ $cartItem['product']['id'] }}', '{{ $cartItem['size']['id'] }}', '{{ $cartItem['options']?implode(',', $cartItem['options']->pluck('id')->toArray()):'' }}', '{{ $cartItem['addons']?implode(',', $cartItem['addons']->pluck('id')->toArray()):'' }}', '');return false;">
                      <i class="fa fa-trash-o"></i>
                    </a>
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-xl-5 col-lg-5 col-md-6 mb-30">
          <div class="cart-card">
            <!-- Add coupon code section here if needed -->
          </div>
        </div>
        <div class="col-xl-7 col-lg-7 col-md-6">
          <div class="cart-card">
            <div class="card">
              <div class="card-header">
                <h4>Cart Totals</h4>
              </div>
              <div class="card-body">
                @php
                  $subtotal = 0;
                  $deliveryCharge = 0;
                  $total = 0;
                @endphp
  
                @foreach(cartItems() as $cartItem)
                  @php
                    $subtotal += $cartItem['quantity'] * $cartItem['price'];
                  @endphp
                @endforeach
  
                <div class="single-cart-total">
                  <p>Subtotal</p>
                  <p class="cart-amount">৳ {{ $subtotal }}</p>
                </div>
                <div class="single-cart-total">
                  <p>Delivery Charge</p>
                  <p class="cart-amount">৳ {{ $deliveryCharge }}</p>
                </div>
                @php
                  $total = $subtotal + $deliveryCharge;
                @endphp
                <div class="single-cart-total">
                  <p>Total</p>
                  <p class="cart-amount cl-primary">৳ {{ $total }}</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="row mt-50">
        <div class="col centered">
          <a href="{{ route('checkout') }}" class="bttn-mid btn-fill">Proceed to Checkout</a>
        </div>
      </div>
    </div>
  </section>
<!--/Cart area-->
<script>
      function removeCartItems(key, productId, sizeId, optionIds, addonIds) {
        $.ajax({
            url: "{{ route('removeToCart') }}",
            type: "POST",
            data: {
                productId: productId,
                sizeId: sizeId,
                optionIds: optionIds,
                addonIds: addonIds,
                key: key,
                _token: '{{ csrf_token() }}'
            },
            success: function (response) {    
                console.log(response);            
                location.reload();
            },
            error: function (xhr, textStatus, errorThrown) {
                // Handle any errors here
                console.error('Error:', errorThrown);
            }
        });
       
    }

    function updateCartQuantitys(cartKey, productQuantity){    
            $.ajax({
                    method: "post",
                    url: "{{ route('updateCartqty') }}",
                    data: {                                                            
                        productQuantity: productQuantity, 
                        cartkey: cartKey,                  
                        _token: '{{ csrf_token() }}',                        
                    },success: function (response) {
                        $("#cartsddddd").load(" #cartsddddd > *");
                    },
                    error: function (xhr, textStatus, errorThrown) {
                        // Handle any errors here
                        console.error('Error:', errorThrown);
                    }
                })
                
        }
</script>
 @endsection