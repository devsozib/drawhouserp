<div class="ps-panel--sidebar" id="cart-mobile" style="height: 100%;  ">
    <div class="ps-panel__header">
        <h3>Your Cart</h3>
    </div>
    <div class="navigation__content" id="miniCartContentMobile">
        <div class="ps-cart--mobile">

            <div class="ps-cart__content">
                <div class="ps-cart__items" style="height:calc(75vh - (66vh/8) ); overflow-y: scroll;">

                </div>

            </div>
            <div class="ps-cart__footer"
                style="position: fixed; width: 100%; bottom: 50px; z-index: 99999999; padding-top: 8px;">
                <h3>Sub Total:<strong>৳ 0</strong></h3>
                <strong style="font-weight: 100; font-size: 12px;"><b>**Price Includes 5% Service Charge & 15%
                        VAT</b></strong>

                <h3>Cart is Empty</h3>
            </div>
        </div>
    </div>
</div>
<div class="ps-panel--sidebar" id="navigation-mobile">
    <div class="ps-panel__header">
        <h3>Menu</h3>
    </div>
    <div class="ps-panel__content">
        <ul class="menu--mobile">
            <li><a href="{{ url('/lakeshorebakery') }}">Home</a>
            <li><a href="{{ url('/lakeshorebakery/about-us') }}">About Us</a>
            <li class="current-menu-item menu-item-has-children"><a href="javascript:void(0);">Menu</a><span
                    class="sub-toggle"></span>
                <ul class="sub-menu">

                    <li><a href="{{ url('/lakeshorebakery/menu') }}">Pre Order </a>
                    </li>
                </ul>
            </li>
            <li><a href="{{ url('/lakeshorebakery/contact-us') }}">Contact</a>
            </li>

            <li>
                <a onclick="customerLogin();">Login</a>
            </li>

        </ul>
    </div>
</div>
<div class="navigation--list">
    <div class="navigation__content">
        <a class="navigation__item active" href="{{ url('/lakeshorebakery') }}"><i class="fa fa-home"></i></a>
        <a class="navigation__item ps-toggle--sidebar" href="#navigation-mobile"><i class="fa fa-bars"></i></a>
        <!-- <a class="navigation__item ps-toggle--sidebar" href="#search-sidebar"><i class="fa fa-search"></i></a> -->
        <a class="navigation__item ps-toggle--sidebar" href="#cart-mobile">
            <i class="fa fa-shopping-basket"></i>
            <span style="padding: 2px; border-radius: 10px;">
                <i>
                    <p id="totalCartProductsViewForMobile" style="font-size: 15px;   font-weight: bold; font-style: normal;">0</p>
                </i>
            </span>
        </a>
    </div>
</div>

<div class="ps-popup" id="loginDiv" data-time="0" style="z-index: 10000;">
    <div class="ps-popup__content bg--cover" data-background="{{ asset('lakeshore_bakery') }}/frontend/assets/img/bg/subcribe.jpg" style="background: url(_img/bg/subcribe.html);"><a class="ps-popup__close ps-btn--close" href="javascript:void(0);"></a>
        <div class="ps-form--subscribe-popup">
            <div class="ps-form__content text-center">

                <h3>Login </h3>
                <h5>Please enter your credentials</h5>
                <div class="form-group">
                    <input class="form-control" id="mobile" type="text" value="" required placeholder="Phone Number">
                    <input class="form-control" type="password" id="password" value="" required placeholder="Password">
                    <button class="ps-btn" onclick="authenticate()">Submit</button>
                </div>


            </div>
        </div>
    </div>
</div>  <!--include search-sidebar-->