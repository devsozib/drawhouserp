<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
@include('frontend.layouts.head')


<body>
    <!-- Preloader -->
    <div class="preloader">
        <div class="lds-hourglass"></div>
    </div>
    <!-- /Preloader -->

    <div class="global-cart-btn">
        <a href="#" class="cart-button"><i class="fa fa-shopping-cart"></i><span id="totalCartProductsView">{{ session('cart')?count(session('cart')):'0' }}</span></a>
    </div>

    <!-- Home Popup Section -->
    <div class="modal fade subscribe_popup" id="onload-popup" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="fa fa-times"></i></span>
                    </button>
                    <div class="row no-gutters">
                        <div class="col-sm-12">
                            <div class="popup_content" style="background: url('assets/images/popup.jpg') no-repeat;">
                                <div class="popup-text">
                                    <h4>Sign Up for our Newsletter to get discounts!</h4>
                                    <p>We’ll be sending you offers and discounts every week</p>
                                </div>
                                <div class="newslatter">
                                    <form action="#">
                                        <input type="email" placeholder="Email Address" required>
                                        <button type="submit">Signup</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('frontend.layouts.header')
    @yield('content')
    @include('frontend.layouts.aside')
    @include('frontend.layouts.footer')

    <a href="javascript:void(0)" class="back-to-top bounce"><i class="ri-arrow-up-s-line"></i></a>
    @include('frontend.layouts.script')
    @yield('js')
</body>

</html>
