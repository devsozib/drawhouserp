@extends('lakeshore_bakery.layouts.master')
@section('content')

<div id="homepage-4">
    <div class="ps-home-banner bg--cover" data-background="{{ asset('lakeshore_bakery') }}/frontend/assets/img/slider/1.jpg" id="mainSliderHome">
       @foreach ($sliders as $item)
            <span class="singleItem">
                <div class="ps-product--banner horizontal">
                    <div class="ps-product__thumbnail">
                        <!-- <span class="ps-badge ps-badge--sale"><i style="font-size:16px;">Limited Stock</i></span> -->
                        <a href="#"><img src="{{ asset('product_images') }}/{{ $item->image }}" alt=""></a>
                    </div>
                    <div class="ps-product__content">
                        <a class="ps-product__title" href="{{ route('lbproduct.details',$item->id) }}">{{ $item->name }}</a>
                        <p>Pre Order - Cookies</p>
                        <a class="ps-btn" href="{{ route('lbproduct.details',$item->id) }}"> Order Now</a>
                    </div>
                </div>
            </span>
       @endforeach
        
        {{-- <span class="singleItem">
            <div class="ps-product--banner horizontal">
                <div class="ps-product__thumbnail">
                    <!-- <span class="ps-badge ps-badge--sale"><i style="font-size:16px;">Limited Stock</i></span> -->
                    <a href="#"><img src="{{ asset('lakeshore_bakery') }}/frontend/assets/img/sliderProductImages/1637743740.png" alt=""></a>
                </div>
                <div class="ps-product__content">
                    <a class="ps-product__title" href="product-details406e.html?tokenOfLove=70"> Dense Chocolate
                        Caramel</a>
                    <p>Pre Order - Whole Cake</p>
                    <a class="ps-btn" href="product-details406e.html?tokenOfLove=70"> Order Now</a>
                </div>
            </div>
        </span>
        <span class="singleItem">
            <div class="ps-product--banner horizontal">
                <div class="ps-product__thumbnail">
                    <!-- <span class="ps-badge ps-badge--sale"><i style="font-size:16px;">Limited Stock</i></span> -->
                    <a href="#"><img src="{{ asset('lakeshore_bakery') }}/frontend/assets/img/sliderProductImages/1637743766.png" alt=""></a>
                </div>
                <div class="ps-product__content">
                    <a class="ps-product__title" href="product-details9240.html?tokenOfLove=74"> Assorted
                        Cannoli</a>
                    <p>Pre Order - Cannoli</p>
                    <a class="ps-btn" href="product-details9240.html?tokenOfLove=74"> Order Now</a>
                </div>
            </div>
        </span> --}}
    </div>
    <div class="ps-section ps-home-about">
        <div class="container">
            <div class="ps-section__header">
                <h3>Chef' Recommendation</h3>
            </div>
            <div class="ps-section__top">
                <div class="row" id="homePage1stSlider">
                    @foreach ($chefSpecials as $item)
                    <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12 ">
                        <div class="ps-block--award">
                            <div class="ps-block__header"><img src="{{ asset('product_images') }}/{{ $item->image }}"
                                    alt="{{ $item->name }}">
                                <h3 style="min-height:55px;">{{ $item->name }}</h3>
                                <p>
                                <h4>
                                    ৳{{ $item->selling_price }} 
                                </h4>
                                </p>
                            </div>
                            <div class="ps-block__content">
                                <p></p>
                            </div>
                        </div>
                        <div class="ps-product__shopping row" style="padding: 20px;">
                            <button class="ps-btn ps-product__add-to-cart text-center btn btn-xs col-md-5"
                                onclick="addToCart('7')">Quick Add</button>
                            <p class="col-md-2"></p>
                            <a class="ps-btn ps-product__add-to-cart  text-center btn btn-xs col-md-5"
                                href="{{ route('lbproduct.details',$item->id) }}">Order
                            </a>
                        </div>
                    </div> 
                    @endforeach                
                </div>
            </div>
            <hr style="margin-bottom: 130px;">
        </div>
    </div>
    <div class="ps-section ps-home-product bg--cover" data-background="{{ asset('lakeshore_bakery') }}/frontend/assets/img/bg/home-4/home-product.jpg">
        <div class="container">
            <div class="ps-section__header">
                <i class="chikery-tt5"></i>
                <p>Fresh Every day</p>
                <h3> Featured Products</h3>
            </div>

            <div class="ps-section__content">
                <div class="row">
                    @foreach ($features as $item) 
                        <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-6 ">
                            <div class="ps-product">
                                <div class="ps-product__thumbnail"><img src="{{ asset('product_images') }}/{{ $item->image }}"
                                        alt="{{ $item->name }}" />
                                </div>
                                <div class="ps-product__content">
                                    <div class="ps-product__desc">
                                        <span class="ps-product__title">{{ $item->name }}</span>
                                        <span class="ps-product__price">৳{{ $item->selling_price }} </span>
                                    </div>
                                    <div class="ps-product__shopping">
                                        <div class="button">
                                            <button class="ps-btn ps-product__add-to-cart"
                                                onclick="addToCart('11')">Quick Add</button>
                                        </div>
                                        <a class="ps-btn ps-product__add-to-cart"
                                            href="{{ route('lbproduct.details',$item->id) }}">Order</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach    
                </div>
            </div>

        </div>
    </div>
    <div class="ps-section ps-home-video bg--cover" data-background="{{ asset('lakeshore_bakery') }}/frontend/assets/img/bg/home-3/web-banner.jpg">
        <div class="container">
            <div class="ps-section__header">
                <!--<p>Picky Words</p>-->
                <h3>The Premium line of chocolate cakes and pastry made with one of the world’s finest chocolate
                    from the small village of Tain L’Hermitage, France since 1922</h3>
                <!--<a class="ps-video" href="https://youtu.be/_mYuCp9IFcs"><i class="fa fa-play"></i></a> -->
            </div>
        </div>
    </div>
</div>

@endsection