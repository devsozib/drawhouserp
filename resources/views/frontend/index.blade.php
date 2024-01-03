@extends('frontend.layouts.master')
@section('content')

    <!-- Banner Area-->
    <div class="hero owl-carousel leaf gray-bg-2 flower" id="menu">
        @foreach ($sliders as $item)
        <section class="banner-area section-padding">
            <div class="container">
              <div class="row">
                <div class="col-xl-6 col-md-6 order-sm-1 order-2">
                  <div class="banner">
                    <h3>{{ $item->name }}</h3>
                    <p>
                        {{ $item->description  }}
                    </p>
                    <a
                      href="{{ route('product.details',encrypt($item->id)) }}"
                      class="bttn-mid btn-fill"
                      >Order now</a
                    >
                  </div>
                </div>
                <div class="col-xl-6 col-md-6 order-sm-2 order-1">
                  <div class="banner">
                    <img src="{{ asset('product_images') }}/{{ $item->image }}" alt="" />
                  </div>
                </div>
              </div>
            </div>
          </section>
        @endforeach
      </div>
      <!-- /Banner Area-->

      <!--Card Sidebar-->

      <div id="sidebar-cart-curtain"></div>
      <!--/Card Sidebar-->

      <!-- About Area-->
      <section class="banner-area section-padding gray-bg-2" id="about">
        <div class="container-fluid">
          <div class="row">
            <div class="col-xl-7 col-md-6">
              <div class="banner-img">
                <img src="{{ asset('frontend') }}/assets/images/about.png" alt="" />
              </div>
            </div>
            <div class="col-xl-5 col-md-6">
              <div class="banner">
                <h3 class="cl-mint">
                  Animal Fries and Hot Dogs: <br />Treat for Everyone
                </h3>
                <!--<p>The name "Kona" pays homage to the beans cultivated on the slopes of Hualalai and Mauna Loa volcanoes in the Kona districts of Hawaii. This hightly prized coffee beans are mixed with Guatamelan Antigua beans to create a custom-->
                <!--    blend that is full-bodies in flavor, and has a rich, pleasing aroma.</p>-->
                <p>
                  Whether it’s Crunchy or Spicy, there’s a choice for everyone.
                  Our tasty fries & inhouse Hawaiian Bun for Hot Dogs make
                  everything better.
                </p>
              </div>
            </div>
          </div>
        </div>
      </section>
      <!-- /About Area-->

      <form
        action="https://www.konacafedhaka.com/erp/addtocartdirect.php"
        method="post"
        id="addToCartDirect"
      >
        <input type="hidden" name="productId" id="ppi" value="0" />
      </form>

      <!-- slider -->
      <div class="section" style="overflow-x: hidden">
        <h2 class="text-center">Chef' Recommendation</h2>
        <section class="slider">
          <div class="regular row">
            @foreach ($chefSpecials as $item)
            <div class="col-12" style="padding-left: 0px; padding-right: 0px">
                <a href="{{ route('product.details',encrypt($item->id)) }}">
                  <div class="col-12" style="padding-left: 0px; padding-right: 0px">
                    <div class="food-item-card">
                      <div class="item-img">
                        <img src="{{ asset('product_images') }}/{{ $item->image }}" alt="BBQ HD							" />
                      </div>
                      <div class="item-title">
                        <h4 class="">
                          <a href="{{ route('product.details',encrypt($item->id)) }}"
                            >{{ $item->name }}
                          </a>
                        </h4>
                      </div>
                      <div class="item-description">
                      </div>
                      <div class="item-meta">
                        <div class="price">৳{{ $item->selling_price }}</div>
                      </div>
                      <div class="item-meta">
                        <div class="button">
                          <a
                            href="{{ route('product.details',encrypt($item->id)) }}"
                            class="bttn-small btn-fill"
                            >Order</a
                          >
                        </div>
                      </div>
                    </div>
                  </div>
                </a>
              </div>
            @endforeach
          </div>
        </section>
      </div>

      <!-- end slider -->

      <!-- About Area 2-->
      <section
        class="banner-area section-padding leaf-left gray-bg-2 special-section-padding"
        id="about"
      >
        <div class="container-fluid">
          <div class="row">
            <div class="col-xl-4 col-md-6 offset-xl-1">
              <div class="banner">
                <h3 class="cl-pink">Kona Revives You</h3>
                <p>
                  Twitch your day with our freshly blended juice or smoothie.
                  Sweet, tangy and fresh, our juice will give you a lift.<br />“The
                  name “Kona” pays homage to the beans cultivated on the slopes of
                  Hualalai and Mauna Loa volcanoes in the Kona districts of
                  Hawaii.”
                </p>
              </div>
            </div>
            <div class="col-xl-6 col-md-6">
              <div class="banner-img">
                <img src="{{ asset('frontend') }}/assets/images/about-2.png" alt="" />
              </div>
            </div>
          </div>
        </div>
      </section>
      <!-- /About Area 2-->

      <!-- slider -->
      <div class="section" style="overflow-x: hidden">
        <h2 class="text-center">Featured Products</h2>
        <section class="slider">
          <div class="regular row">
            @foreach ($features as $item)
            <div class="col-12" style="padding-left: 0px; padding-right: 0px">
                <a href="{{ route('product.details',encrypt($item->id)) }}">
                  <div class="col-12" style="padding-left: 0px; padding-right: 0px">
                    <div class="food-item-card">
                      <div class="item-img">
                        <img src="{{ asset('product_images') }}/{{ $item->image }}" alt="BBQ HD							" />
                      </div>
                      <div class="item-title">
                        <h4 class="">
                          <a href="{{ route('product.details',encrypt($item->id)) }}"
                            >{{ $item->name }}
                          </a>
                        </h4>
                      </div>
                      <div class="item-description">
                      </div>
                      <div class="item-meta">
                        <div class="price">৳{{ $item->selling_price }}</div>
                      </div>
                      <div class="item-meta">
                        <div class="button">
                          <a
                            href={{ route('product.details',encrypt($item->id)) }}"
                            class="bttn-small btn-fill"
                            >Order</a>
                        </div>
                      </div>
                    </div>
                  </div>
                </a>
              </div>
            @endforeach

          </div>
        </section>
      </div>
      <!-- End slider -->

      <!-- Location Start -->
      <section class="banner-area section-padding gray-bg-2" id="location">
        <div class="container mb-60">
            <div class="row">
                <div class="col-xl-5 col-md-6">
                    <div class="banner">
                        <div class="mb-60">
                            <h3>Find Our <br> Shacks</h3>
                        </div>
                        <h4>Open Everyday</h4>
                        <h5>Hotline: +8801300290494</h5>
                        <div class="map-location">
                            <div class="single">
                                <p>
                                    Lakeshore Hotel (Open 24/7)
                                    <br>
                                    House: 46, Road: 41, Gulshan 2
                                    <br>
                                    Dhaka 1212
                                </p>
                            </div>
                            <div class="single">
                                <p>
                                    Chefs Table Courtside (12.00 - 22.00)
                                    <br>
                                    Madani Ave, Dhaka 1212
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-7 col-md-6">
                    <div class="banner-img">
                        <img src="{{ asset('frontend') }}/assets/images/about-4.png" alt="">
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /Location End-->

      @endsection
