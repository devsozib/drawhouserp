@extends('lakeshore_bakery.layouts.master')
@section('content')

<div class="ps-page--about">
    <div class="ps-hero bg--cover" data-background="{{ asset('lakeshore_bakery') }}/frontend/assets/img/hero/shop-hero.png">
        <div class="ps-hero__container">
            <!-- <div class="ps-breadcrumb">
    <ul class="breadcrumb">
      <li><a href="index-2.html">Home</a></li>
      <li>Menu</li>
    </ul>
  </div> -->
            <h1 class="ps-hero__heading">Get To Know Us</h1>
        </div>
    </div>


    <div class="ps-section ps-home-video bg--cover" data-background="{{ asset('lakeshore_bakery') }}/frontend/assets/img/bg/pages/about-video.jpg">
        <div class="container">
            <div class="ps-section__header">
                <p>Video Present</p>
                <h3>Any Design <br /> For Your Feast-day</h3><a class="ps-video" href="javascript:void(0);"><i
                        class="fa fa-play"></i></a>
            </div>
        </div>
    </div>
    <div class="ps-section ps-home-best-services">
        <div class="ps-section__left bg--cover" data-background="{{ asset('lakeshore_bakery') }}/frontend/assets/img/bg/home-1/home-best-services.jpg"></div>
        <div class="ps-section__right">
            <div class="ps-section__container">
                <div class="ps-section__header">
                    <p>CHIKERY CAKE</p>
                    <h3>Best Services</h3><i class="chikery-tt3"></i>
                </div>
                <div class="ps-section__content">
                    <p>Consectetur adipiscing elit. Curabitur sed turpis feugiat, sed vel nulla non neque.
                        Nullamlacinia faucibus risus, a euismod lorem tincidunt id. Vestibulum imperdiet nibh vel
                        magna lacinia ultricesimperdiet.</p>
                    <ul>
                        <li>BEST QUALITY</li>
                        <li>FAST DELIVERED</li>
                        <li>Event Cakes</li>
                        <li>INGREDIENT SUPPLY</li>
                        <li>ONLINE BOOKING</li>
                    </ul>
                </div>
            </div>
            <div class="ps-section__image bg--cover" data-background="{{ asset('lakeshore_bakery') }}/frontend/assets/img/bg/home-1/home-best-services-2.jpg"></div>
        </div>
    </div>
</div>

@endsection