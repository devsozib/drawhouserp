<!DOCTYPE html>
<html lang="en">

<meta http-equiv="content-type" content="text/html;charset=UTF-8" />

@include('lakeshore_bakery.layouts.head')

<body style="background-color:#f6f5f3;">
   
        @include('lakeshore_bakery.layouts.header')

        @include('lakeshore_bakery.layouts.sidebar')

    @yield('content')

   @include('lakeshore_bakery.layouts.footer')

    <form action="https://lakeshorebakery.com/erp/addtocartdirect.php" method="post" id="addToCartDirect">
        <input type="hidden" name="productId" id="ppi" value="0">
        <!--<input type="hidden" name="productId" id="ppi" value="0">-->
        <input type="hidden" name="updateFrom" value="index-2.html">
    </form>
    <div id="back2top"><i class="pe-7s-angle-up"></i></div>
    <div class="ps-site-overlay"></div>
    <div id="loader-wrapper">
        <div class="loader-section section-left"></div>
        <div class="loader-section section-right"></div>
    </div>
    <div class="ps-search" id="site-search">
        <a class="ps-btn--close" href="javascript:void(0);"></a>
        <div class="ps-search__content">
            <form class="ps-form--primary-search" action="#" method="post">
                <input class="form-control" type="text" placeholder="Search for...">
                <button><i class="fa fa-search"></i></button>
            </form>
        </div>
    </div><!-- Plugins-->
@include('lakeshore_bakery.layouts.script')
</body>
</html>