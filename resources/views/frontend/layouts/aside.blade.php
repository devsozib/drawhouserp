<aside id="sidebar-cart">
    <main>
        <a href="#" class="close-button"><span class="close-icon">X</span></a>
        <span id="miniCartDetails">
            <h2>Order Summary <span class="count">{{ count(cartItems()) }}</span></h2>
            <ul class="products">
                @php
                    $totalProductPrice = 0;
                @endphp
                @foreach (cartItems() as $cartItemKey => $cartItem)
                    <li class="product">
                        <a href="#" class="product-link">
                            <span class="product-image">
                                <img src="{{ asset('product_images/' . $cartItem['product']['image']) }}" alt="{{ $cartItem['product']['name'] }}">
                            </span>
                            @php
                                $offerPriceTotal = 0;
                                $optionPrices = 0;
                            @endphp
                            <span class="product-details">
                                <h3>{{ $cartItem['product']['name'] }}</h3>
                                <p><b>Size:</b> {{ $cartItem['size']['size_name'] }}</p>
                                @if ($cartItem['options'])
                                    <p><b>Options:</b> {{ implode(', ', $cartItem['options']->pluck('name')->toArray()) }}</p>
                                    @php
                                        $optionPrices = 0;
                                        foreach ($cartItem['options'] as $item){
                                            if($item->offer_price>0){
                                                $optionPrices += $item->offer_money;
                                            }else{
                                                $optionPrices += $item->extra_price;
                                            }
                                        }
                                    @endphp
                                    <p><b>Extra options Price:</b> ৳{{ $optionPrices }}</p>
                                @endif
                                @if ($cartItem['addons'])
                                <p><b>Addons:</b> {{ implode(', ', $cartItem['addons']->pluck('name')->toArray()) }}</p>
                                @php
                                    foreach ($cartItem['addons'] as $item){
                                        if($item->offer_price>0){
                                            $offerPriceTotal += $item->offer_price;
                                        }else{
                                            $offerPriceTotal += $item->extra_money_added;
                                        }
                                    }
                                @endphp
                                <p><b>Extra addon Price:</b> ৳{{ $offerPriceTotal }}</p>
                                @endif
                                <span class="qty-price" style="display: block;">
                                    <span class="qty">
                                        <p><b>Quantity:</b></p>&nbsp;
                                        <button class="minus-button" id="minus-button-{{ $cartItemKey }}">-</button>
                                        <input type="number" id="quantity{{ $cartItemKey }}" class="qty-input" step="1" min="1" max="50" name="qty-input" value="{{ $cartItem['quantity'] }}" pattern="[0-9]*" title="Quantity" inputmode="numeric"  productid="{{ $cartItem['product']['id'] }}" productsizeid="{{ $cartItem['size']['id'] }}" productoptionids="{{ $cartItem['options']?implode(',', $cartItem['options']->pluck('id')->toArray()):'' }}" productaddonids="{{ $cartItem['addons']? implode(',', $cartItem['addons']->pluck('id')->toArray()):'' }}"  subcategoryaddonids="" cartkey="{{ $cartItemKey }}">
                                        <button class="plus-button" id="plus-button-{{ $cartItemKey }}">+</button>
                                    </span>
                                    @php
                                       $totalProductPrice +=  ($cartItem['price'] + $offerPriceTotal + $optionPrices) * ($cartItem['quantity']);
                                    @endphp
                                    <span class="price">৳ {{ ($cartItem['price'] + $offerPriceTotal + $optionPrices) * ($cartItem['quantity'])}}</span>
                                </span>
                            </span>
                        </a>
                        <a  class="remove-button" onclick="removeCartItem('{{ $cartItemKey  }}','{{ $cartItem['product']['id'] }}', '{{ $cartItem['size']['id'] }}', '{{ $cartItem['options']?implode(',', $cartItem['options']->pluck('id')->toArray()):'' }}', '{{ $cartItem['addons']?implode(',', $cartItem['addons']->pluck('id')->toArray()):'' }}', '');return false;"><span class="remove-icon">X</span></a>
                    </li>
                @endforeach
            </ul>
            <div class="totals">
                <div class="subtotal">
                    <span class="label">Total:</span> <span class="amount">৳ {{ $totalProductPrice }}</span>
                </div>
            </div>
        </span>
        <div class="action-buttons centered">
            <a class="bttn-mid btn-fill" href="{{ route('cart') }}">Cart</a>
            <a class="bttn-mid btn-fill" href="{{ route('checkout') }}">Checkout</a>
        </div>
        <div class="text-center" style="bottom: 10px; width: 100%; border: 2px solid #FFA259;">
            <span>**Price Includes 5% Service Charge &amp; 5% VAT</span>
        </div>
    </main>
</aside>
<script>
    function removeCartItem(key, productId, sizeId, optionIds, addonIds) {
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
                $("#sidebar-cart").load(" #sidebar-cart > *");
            },
            error: function (xhr, textStatus, errorThrown) {
                // Handle any errors here
                console.error('Error:', errorThrown);
            }
        });

    }
    function updateCartQuantity(productId, productSizeId, productOptionIds, productAddonIds, subCategoryAddonIds, productQuantity,  cartKey){
        // console.log(cartKey);
            $.ajax({
                    method: "post",
                    url: "{{ route('updateCartqty') }}",
                    data: {
                        productId: productId,
                        productSizeId: productSizeId,
                        productOptionIds: productOptionIds,
                        productAddonIds: productAddonIds,
                        subCategoryAddonIds: subCategoryAddonIds,
                        productQuantity: productQuantity,
                        cartkey: cartKey,
                        _token: '{{ csrf_token() }}',
                    },success: function (response) {
                        $("#sidebar-cart").load(" #sidebar-cart > *");
                    },
                    error: function (xhr, textStatus, errorThrown) {
                        // Handle any errors here
                        console.error('Error:', errorThrown);
                    }
                })

        }
</script>
