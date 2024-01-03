<header class="header header--default header--home-4" data-sticky="true">
    <div class="header__left">
        <ul class="ps-list--social">

            <li><a href="https://www.instagram.com/lakeshorebkry"><i class="fa fa-instagram"></i></a></li>
            <li><a href="https://www.facebook.com/lakeshorebkry"><i class="fa fa-facebook"></i></a></li>
            <!-- <li><a href="javascript:void(0);"><i class="fa fa-linkedin"></i></a></li> -->

        </ul>
    </div>
    <div class="header__center">
        <nav class="header__navigation left">
            <ul class="menu">
                <li><a href="{{ url('/lakeshorebakery') }}">Home</a>
                </li>

                <li class="menu-item-has-children"><a href="javascript:void(0);">Menu</a><span class="sub-toggle"><i
                            class="fa fa-angle-down"></i></span>
                    <ul class="sub-menu">
                        <li><a href="{{ url('/lakeshorebakery/menu') }}">Pre Order </a>
                        </li>
                    </ul>
                </li>

            </ul>
        </nav>
        <div class="header__logo">
            <a class="ps-logo" href="{{ url('/lakeshorebakery') }}"><img src="{{ asset('lakeshore_bakery') }}/frontend/assets/img/logo.svg" alt="Lakeshore Bakery"></a>
        </div>
        <nav class="header__navigation right">
            <ul class="menu">
                <li><a href="{{ url('/lakeshorebakery/about-us') }}">About Us</a>
                </li>
                <li><a href="{{ url('/lakeshorebakery/contact-us') }}">Contact</a>
                </li>
            </ul>
        </nav>
    </div>
    <div class="header__right">
        <div class="header__actions">
            <ul class="menu">
                <li>
                    <a href="javascript:void(0);" onclick="customerLogin();">Login</a>
                </li>
            </ul>

            <div class="ps-cart--mini" id="miniCartDiv">

                <a class="ps-cart__toggle" href="javascript:void(0);"><i class="fa fa-shopping-basket"></i><span><i
                            id="totalCartProductsView">0</i></span></a>

                <div class="ps-cart__content" id="miniCartContent">
                    <div class="ps-cart__items" style="max-height: 68vh;  overflow-y: scroll;">

                    </div>
                    <div class="ps-cart__footer">
                        <h3>Sub Total:<strong>৳ 0</strong></h3>
                        <strong style="font-weight: 100; font-size: 12px;"><b>**Price Includes 5% Service Charge &
                                15% VAT</b></strong>
                        <br><br>
                        <figure><a class="ps-btn" href="{{ url('/frontend/lakeshorebakery') }}">View Cart</a><a class="ps-btn ps-btn--dark"
                                href="{{ url('/frontend/lakeshorebakery') }}">Checkout</a></figure>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
<header class="header header--mobile" data-sticky="false">
    <div class="header__content">
        <div class="header__center">
            <a class="ps-logo" href="{{ url('/frontend/lakeshorebakery') }}"><img src="{{ asset('lakeshore_bakery') }}/frontend/assets/img/logo.svg" alt=""></a>
        </div>
    </div>
    <style>
        .ps-cart--mobile .ps-cart__footer figure .ps-btn {
            width: unset;

        }
    </style>
</header>