@extends('lakeshore_bakery.layouts.master')
@section('content')

<div class="ps-hero ps-hero--shopping bg--cover" style="background-color:#F6F5F3 !important; url('{{ asset('lakeshore_bakery/frontend/assets/img/hero/shop-hero.png') }}');">
    <div class="ps-hero__container">
      <!-- <div class="ps-breadcrumb">
       <ul class="breadcrumb">
         <li><a href="index-2.html">Home</a></li>
         <li>Menu</li>
       </ul>
     </div> -->
      <h1 class="ps-hero__heading">Our Menu</h1>
    </div>
  </div>
  <div class="ps-page--shop" style="background-color:#F6F5F3">
    <div class="container-fluid">
      <div class="ps-shopping ps-shopping--no-sidebar" style="padding: 10px 0 40px !important;">
        <!-- <div class="ps-shopping__top"> -->
        <div class="ps-shopping text-center" style="padding: 10px 0 40px !important;">
          <ul class="ps-product__categories">

            <li class="active" id="allItem"><a href="product10b0.html?type=1">All</a></li>

            

              <li id="itemType1">
                <a href="product1ac1.html?type=1&amp;subCategory=1">Breads</a>
              </li>

            

              <li id="itemType3">
                <a href="product9ebc.html?type=1&amp;subCategory=3">Pastry</a>
              </li>

            

              <li id="itemType6">
                <a href="product6a1a.html?type=1&amp;subCategory=6">Cookies</a>
              </li>

            

              <li id="itemType13">
                <a href="product3c9e.html?type=1&amp;subCategory=13">Sweets</a>
              </li>

            

              <li id="itemType15">
                <a href="product13a5.html?type=1&amp;subCategory=15">Whole Cake</a>
              </li>

            

              <li id="itemType16">
                <a href="producta59d.html?type=1&amp;subCategory=16">Cannoli</a>
              </li>

            

              <li id="itemType17">
                <a href="productc1bb.html?type=1&amp;subCategory=17">Pound Cake</a>
              </li>

            

              <li id="itemType18">
                <a href="product2792.html?type=1&amp;subCategory=18">Doughnuts</a>
              </li>

            

              <li id="itemType19">
                <a href="productfc97.html?type=1&amp;subCategory=19">Tart</a>
              </li>

            

              <li id="itemType21">
                <a href="productaff6.html?type=1&amp;subCategory=21">Croissant</a>
              </li>

            

              <li id="itemType22">
                <a href="product5f98.html?type=1&amp;subCategory=22">Bagel</a>
              </li>

            

              <li id="itemType23">
                <a href="product0944.html?type=1&amp;subCategory=23">Rolls</a>
              </li>

            

              <li id="itemType24">
                <a href="productb2ad.html?type=1&amp;subCategory=24">Brownies </a>
              </li>

            

              <li id="itemType25">
                <a href="product72bf.html?type=1&amp;subCategory=25">Danish</a>
              </li>

            

              <li id="itemType26">
                <a href="productea57.html?type=1&amp;subCategory=26">Berliner</a>
              </li>

            

              <li id="itemType27">
                <a href="product7047.html?type=1&amp;subCategory=27">Savory Snacks</a>
              </li>

            

              <li id="itemType29">
                <a href="product60ea.html?type=1&amp;subCategory=29">Bun</a>
              </li>

            

              <li id="itemType30">
                <a href="productdbe7.html?type=1&amp;subCategory=30">Macaron</a>
              </li>

            

              <li id="itemType31">
                <a href="product9c47.html?type=1&amp;subCategory=31">Wholesale</a>
              </li>

            

              <li id="itemType32">
                <a href="producta670.html?type=1&amp;subCategory=32">Eclairs </a>
              </li>

            

              <li id="itemType33">
                <a href="product105c.html?type=1&amp;subCategory=33">Bangla Misty Retail</a>
              </li>

                       </ul>
        </div>

        <div class="ps-product-box five-column">
          <div class="row">
                           <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-6 ">
                <div class="ps-product">
                  <div class="ps-product__thumbnail"><img src="{{ asset('lakeshore_bakery') }}/frontend/assets/erp/images/16633967951542.png" alt="Assorted Milk Cake" />
                    <!-- <a class="ps-product__overlay" href="product-default.html"></a> -->
                                           <span class="ps-badge ps-badge--sale text-center"><i style="font-size:10px !important;">Pre Orders <br>Only</i></span>
                                       </div>
                  <div class="ps-product__content">
                    <div class="ps-product__desc">
                      <span class="ps-product__title">Assorted Milk Cake</span>
                      <!-- <p>
                        <span>350g</span>
                        <span>30 Min</span>
                        <span>120 <sup>o</sup>C</span>
                      </p> -->

                      <span class="ps-product__price">৳1280</span>

                    </div>

                                           <div class="ps-product__shopping">
                                                   <a class="ps-btn ps-product__add-to-cart col-md-12" href="{{ url('/lakeshorebakery/product-details') }}">Order</a>
                                                 <!-- <div class="ps-product__actions">
                       <a href="javascript:void(0);"><i class="fa fa-heart-o"></i></a>
                       <a href="javascript:void(0);"><i class="fa fa-random"></i></a>
                   </div> -->

                      </div>
                                       </div>
                </div>
              </div>

                           <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-6 ">
                <div class="ps-product">
                  <div class="ps-product__thumbnail"><img src="{{ asset('lakeshore_bakery') }}/frontend/assets/erp/images/164871353308618.png" alt="Brown Bread" />
                    <!-- <a class="ps-product__overlay" href="product-default.html"></a> -->
                                           <span class="ps-badge ps-badge--sale text-center"><i style="font-size:10px !important;">Pre Orders <br>Only</i></span>
                                       </div>
                  <div class="ps-product__content">
                    <div class="ps-product__desc">
                      <span class="ps-product__title">Brown Bread</span>
                      <!-- <p>
                        <span>350g</span>
                        <span>30 Min</span>
                        <span>120 <sup>o</sup>C</span>
                      </p> -->

                      <span class="ps-product__price">৳220</span>

                    </div>

                                           <div class="ps-product__shopping">
                        
                          <div class="button">
                            <button class="ps-btn ps-product__add-to-cart" onclick="addToCart('88')">Quick Add</button>
                          </div>

                          <a class="ps-btn ps-product__add-to-cart" href="product-details51f3.html?tokenOfLove=88">Order</a>
                                                 <!-- <div class="ps-product__actions">
                       <a href="javascript:void(0);"><i class="fa fa-heart-o"></i></a>
                       <a href="javascript:void(0);"><i class="fa fa-random"></i></a>
                   </div> -->

                      </div>
                                       </div>
                </div>
              </div>

                           <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-6 ">
                <div class="ps-product">
                  <div class="ps-product__thumbnail"><img src="{{ asset('lakeshore_bakery') }}/frontend/assets/erp/images/163896354397718.png" alt="Chia-Sesame Bread" />
                    <!-- <a class="ps-product__overlay" href="product-default.html"></a> -->
                                           <span class="ps-badge ps-badge--sale text-center"><i style="font-size:10px !important;">Pre Orders <br>Only</i></span>
                                       </div>
                  <div class="ps-product__content">
                    <div class="ps-product__desc">
                      <span class="ps-product__title">Chia-Sesame Bread</span>
                      <!-- <p>
                        <span>350g</span>
                        <span>30 Min</span>
                        <span>120 <sup>o</sup>C</span>
                      </p> -->

                      <span class="ps-product__price">৳330</span>

                    </div>

                                           <div class="ps-product__shopping">
                        
                          <div class="button">
                            <button class="ps-btn ps-product__add-to-cart" onclick="addToCart('12')">Quick Add</button>
                          </div>

                          <a class="ps-btn ps-product__add-to-cart" href="product-details30bd.html?tokenOfLove=12">Order</a>
                                                 <!-- <div class="ps-product__actions">
                       <a href="javascript:void(0);"><i class="fa fa-heart-o"></i></a>
                       <a href="javascript:void(0);"><i class="fa fa-random"></i></a>
                   </div> -->

                      </div>
                                       </div>
                </div>
              </div>

                           <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-6 ">
                <div class="ps-product">
                  <div class="ps-product__thumbnail"><img src="{{ asset('lakeshore_bakery') }}/frontend/assets/erp/images/170013128085930.png" alt="Choco Luxe" />
                    <!-- <a class="ps-product__overlay" href="product-default.html"></a> -->
                                           <span class="ps-badge ps-badge--sale text-center"><i style="font-size:10px !important;">Pre Orders <br>Only</i></span>
                                       </div>
                  <div class="ps-product__content">
                    <div class="ps-product__desc">
                      <span class="ps-product__title">Choco Luxe</span>
                      <!-- <p>
                        <span>350g</span>
                        <span>30 Min</span>
                        <span>120 <sup>o</sup>C</span>
                      </p> -->

                      <span class="ps-product__price">৳410</span>

                    </div>

                                           <div class="ps-product__shopping">
                        
                          <div class="button">
                            <button class="ps-btn ps-product__add-to-cart" onclick="addToCart('186')">Quick Add</button>
                          </div>

                          <a class="ps-btn ps-product__add-to-cart" href="product-details5714.html?tokenOfLove=186">Order</a>
                                                 <!-- <div class="ps-product__actions">
                       <a href="javascript:void(0);"><i class="fa fa-heart-o"></i></a>
                       <a href="javascript:void(0);"><i class="fa fa-random"></i></a>
                   </div> -->

                      </div>
                                       </div>
                </div>
              </div>

                           <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-6 ">
                <div class="ps-product">
                  <div class="ps-product__thumbnail"><img src="{{ asset('lakeshore_bakery') }}/frontend/assets/erp/images/163896378375018.png" alt="Chocolate Babka " />
                    <!-- <a class="ps-product__overlay" href="product-default.html"></a> -->
                                           <span class="ps-badge ps-badge--sale text-center"><i style="font-size:10px !important;">Pre Orders <br>Only</i></span>
                                       </div>
                  <div class="ps-product__content">
                    <div class="ps-product__desc">
                      <span class="ps-product__title">Chocolate Babka </span>
                      <!-- <p>
                        <span>350g</span>
                        <span>30 Min</span>
                        <span>120 <sup>o</sup>C</span>
                      </p> -->

                      <span class="ps-product__price">৳500</span>

                    </div>

                                           <div class="ps-product__shopping">
                        
                          <div class="button">
                            <button class="ps-btn ps-product__add-to-cart" onclick="addToCart('10')">Quick Add</button>
                          </div>

                          <a class="ps-btn ps-product__add-to-cart" href="product-details964b.html?tokenOfLove=10">Order</a>
                                                 <!-- <div class="ps-product__actions">
                       <a href="javascript:void(0);"><i class="fa fa-heart-o"></i></a>
                       <a href="javascript:void(0);"><i class="fa fa-random"></i></a>
                   </div> -->

                      </div>
                                       </div>
                </div>
              </div>

                           <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-6 ">
                <div class="ps-product">
                  <div class="ps-product__thumbnail"><img src="{{ asset('lakeshore_bakery') }}/frontend/assets/erp/images/170123482467530.png" alt="Classic chocolate" />
                    <!-- <a class="ps-product__overlay" href="product-default.html"></a> -->
                                           <span class="ps-badge ps-badge--sale text-center"><i style="font-size:10px !important;">Pre Orders <br>Only</i></span>
                                       </div>
                  <div class="ps-product__content">
                    <div class="ps-product__desc">
                      <span class="ps-product__title">Classic chocolate</span>
                      <!-- <p>
                        <span>350g</span>
                        <span>30 Min</span>
                        <span>120 <sup>o</sup>C</span>
                      </p> -->

                      <span class="ps-product__price">৳1450</span>

                    </div>

                                           <div class="ps-product__shopping">
                                                   <a class="ps-btn ps-product__add-to-cart col-md-12" href="{{ url('/lakeshorebakery/product-details') }}">Order</a>
                                                 <!-- <div class="ps-product__actions">
                       <a href="javascript:void(0);"><i class="fa fa-heart-o"></i></a>
                       <a href="javascript:void(0);"><i class="fa fa-random"></i></a>
                   </div> -->

                      </div>
                                       </div>
                </div>
              </div>

                           <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-6 ">
                <div class="ps-product">
                  <div class="ps-product__thumbnail"><img src="{{ asset('lakeshore_bakery') }}/frontend/assets/erp/images/16287519973922.png" alt="French Baguette" />
                    <!-- <a class="ps-product__overlay" href="product-default.html"></a> -->
                                           <span class="ps-badge ps-badge--sale text-center"><i style="font-size:10px !important;">Pre Orders <br>Only</i></span>
                                       </div>
                  <div class="ps-product__content">
                    <div class="ps-product__desc">
                      <span class="ps-product__title">French Baguette</span>
                      <!-- <p>
                        <span>350g</span>
                        <span>30 Min</span>
                        <span>120 <sup>o</sup>C</span>
                      </p> -->

                      <span class="ps-product__price">৳130</span>

                    </div>

                                           <div class="ps-product__shopping">
                        
                          <div class="button">
                            <button class="ps-btn ps-product__add-to-cart" onclick="addToCart('11')">Quick Add</button>
                          </div>

                          <a class="ps-btn ps-product__add-to-cart" href="product-details230a.html?tokenOfLove=11">Order</a>
                                                 <!-- <div class="ps-product__actions">
                       <a href="javascript:void(0);"><i class="fa fa-heart-o"></i></a>
                       <a href="javascript:void(0);"><i class="fa fa-random"></i></a>
                   </div> -->

                      </div>
                                       </div>
                </div>
              </div>

                           <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-6 ">
                <div class="ps-product">
                  <div class="ps-product__thumbnail"><img src="{{ asset('lakeshore_bakery') }}/frontend/assets/erp/images/170123557930430.png" alt="Malai Shor" />
                    <!-- <a class="ps-product__overlay" href="product-default.html"></a> -->
                                           <span class="ps-badge ps-badge--sale text-center"><i style="font-size:10px !important;">Pre Orders <br>Only</i></span>
                                       </div>
                  <div class="ps-product__content">
                    <div class="ps-product__desc">
                      <span class="ps-product__title">Malai Shor</span>
                      <!-- <p>
                        <span>350g</span>
                        <span>30 Min</span>
                        <span>120 <sup>o</sup>C</span>
                      </p> -->

                      <span class="ps-product__price">৳780</span>

                    </div>

                                           <div class="ps-product__shopping">
                                                   <a class="ps-btn ps-product__add-to-cart col-md-12" href="product-details1137.html?tokenOfLove=147">Order</a>
                                                 <!-- <div class="ps-product__actions">
                       <a href="javascript:void(0);"><i class="fa fa-heart-o"></i></a>
                       <a href="javascript:void(0);"><i class="fa fa-random"></i></a>
                   </div> -->

                      </div>
                                       </div>
                </div>
              </div>

                           <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-6 ">
                <div class="ps-product">
                  <div class="ps-product__thumbnail"><img src="{{ asset('lakeshore_bakery') }}/frontend/assets/erp/images/170123549308930.png" alt="Mawa Laddu" />
                    <!-- <a class="ps-product__overlay" href="product-default.html"></a> -->
                                           <span class="ps-badge ps-badge--sale text-center"><i style="font-size:10px !important;">Pre Orders <br>Only</i></span>
                                       </div>
                  <div class="ps-product__content">
                    <div class="ps-product__desc">
                      <span class="ps-product__title">Mawa Laddu</span>
                      <!-- <p>
                        <span>350g</span>
                        <span>30 Min</span>
                        <span>120 <sup>o</sup>C</span>
                      </p> -->

                      <span class="ps-product__price">৳1100</span>

                    </div>

                                           <div class="ps-product__shopping">
                        
                          <div class="button">
                            <button class="ps-btn ps-product__add-to-cart" onclick="addToCart('173')">Quick Add</button>
                          </div>

                          <a class="ps-btn ps-product__add-to-cart" href="product-details69c1.html?tokenOfLove=173">Order</a>
                                                 <!-- <div class="ps-product__actions">
                       <a href="javascript:void(0);"><i class="fa fa-heart-o"></i></a>
                       <a href="javascript:void(0);"><i class="fa fa-random"></i></a>
                   </div> -->

                      </div>
                                       </div>
                </div>
              </div>

                           <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-6 ">
                <div class="ps-product">
                  <div class="ps-product__thumbnail"><img src="{{ asset('lakeshore_bakery') }}/frontend/assets/erp/images/16287498162572.png" alt="Molasses Brown Bread" />
                    <!-- <a class="ps-product__overlay" href="product-default.html"></a> -->
                                           <span class="ps-badge ps-badge--sale text-center"><i style="font-size:10px !important;">Pre Orders <br>Only</i></span>
                                       </div>
                  <div class="ps-product__content">
                    <div class="ps-product__desc">
                      <span class="ps-product__title">Molasses Brown Bread</span>
                      <!-- <p>
                        <span>350g</span>
                        <span>30 Min</span>
                        <span>120 <sup>o</sup>C</span>
                      </p> -->

                      <span class="ps-product__price">৳220</span>

                    </div>

                                           <div class="ps-product__shopping">
                        
                          <div class="button">
                            <button class="ps-btn ps-product__add-to-cart" onclick="addToCart('7')">Quick Add</button>
                          </div>

                          <a class="ps-btn ps-product__add-to-cart" href="product-details5371.html?tokenOfLove=7">Order</a>
                                                 <!-- <div class="ps-product__actions">
                       <a href="javascript:void(0);"><i class="fa fa-heart-o"></i></a>
                       <a href="javascript:void(0);"><i class="fa fa-random"></i></a>
                   </div> -->

                      </div>
                                       </div>
                </div>
              </div>

                           <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-6 ">
                <div class="ps-product">
                  <div class="ps-product__thumbnail"><img src="{{ asset('lakeshore_bakery') }}/frontend/assets/erp/images/16377465864152.png" alt="Multi Grain Bread" />
                    <!-- <a class="ps-product__overlay" href="product-default.html"></a> -->
                                           <span class="ps-badge ps-badge--sale text-center"><i style="font-size:10px !important;">Pre Orders <br>Only</i></span>
                                       </div>
                  <div class="ps-product__content">
                    <div class="ps-product__desc">
                      <span class="ps-product__title">Multi Grain Bread</span>
                      <!-- <p>
                        <span>350g</span>
                        <span>30 Min</span>
                        <span>120 <sup>o</sup>C</span>
                      </p> -->

                      <span class="ps-product__price">৳370</span>

                    </div>

                                           <div class="ps-product__shopping">
                        
                          <div class="button">
                            <button class="ps-btn ps-product__add-to-cart" onclick="addToCart('77')">Quick Add</button>
                          </div>

                          <a class="ps-btn ps-product__add-to-cart" href="product-details7bf8.html?tokenOfLove=77">Order</a>
                                                 <!-- <div class="ps-product__actions">
                       <a href="javascript:void(0);"><i class="fa fa-heart-o"></i></a>
                       <a href="javascript:void(0);"><i class="fa fa-random"></i></a>
                   </div> -->

                      </div>
                                       </div>
                </div>
              </div>

                           <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-6 ">
                <div class="ps-product">
                  <div class="ps-product__thumbnail"><img src="{{ asset('lakeshore_bakery') }}/frontend/assets/erp/images/16377464966232.png" alt="Sandwich Bread" />
                    <!-- <a class="ps-product__overlay" href="product-default.html"></a> -->
                                           <span class="ps-badge ps-badge--sale text-center"><i style="font-size:10px !important;">Pre Orders <br>Only</i></span>
                                       </div>
                  <div class="ps-product__content">
                    <div class="ps-product__desc">
                      <span class="ps-product__title">Sandwich Bread</span>
                      <!-- <p>
                        <span>350g</span>
                        <span>30 Min</span>
                        <span>120 <sup>o</sup>C</span>
                      </p> -->

                      <span class="ps-product__price">৳320</span>

                    </div>

                                           <div class="ps-product__shopping">
                        
                          <div class="button">
                            <button class="ps-btn ps-product__add-to-cart" onclick="addToCart('76')">Quick Add</button>
                          </div>

                          <a class="ps-btn ps-product__add-to-cart" href="product-details1e94.html?tokenOfLove=76">Order</a>
                                                 <!-- <div class="ps-product__actions">
                       <a href="javascript:void(0);"><i class="fa fa-heart-o"></i></a>
                       <a href="javascript:void(0);"><i class="fa fa-random"></i></a>
                   </div> -->

                      </div>
                                       </div>
                </div>
              </div>

                           <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-6 ">
                <div class="ps-product">
                  <div class="ps-product__thumbnail"><img src="{{ asset('lakeshore_bakery') }}/frontend/assets/erp/images/168836606176230.png" alt="Assorted Pastry Box" />
                    <!-- <a class="ps-product__overlay" href="product-default.html"></a> -->
                                           <span class="ps-badge ps-badge--sale text-center"><i style="font-size:10px !important;">Pre Orders <br>Only</i></span>
                                       </div>
                  <div class="ps-product__content">
                    <div class="ps-product__desc">
                      <span class="ps-product__title">Assorted Pastry Box</span>
                      <!-- <p>
                        <span>350g</span>
                        <span>30 Min</span>
                        <span>120 <sup>o</sup>C</span>
                      </p> -->

                      <span class="ps-product__price">৳1300</span>

                    </div>

                                           <div class="ps-product__shopping">
                                                   <a class="ps-btn ps-product__add-to-cart col-md-12" href="product-details0ed8.html?tokenOfLove=178">Order</a>
                                                 <!-- <div class="ps-product__actions">
                       <a href="javascript:void(0);"><i class="fa fa-heart-o"></i></a>
                       <a href="javascript:void(0);"><i class="fa fa-random"></i></a>
                   </div> -->

                      </div>
                                       </div>
                </div>
              </div>

                           <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-6 ">
                <div class="ps-product">
                  <div class="ps-product__thumbnail"><img src="{{ asset('lakeshore_bakery') }}/frontend/assets/erp/images/16625360801012.png" alt="Cheese Milk Cake" />
                    <!-- <a class="ps-product__overlay" href="product-default.html"></a> -->
                                           <span class="ps-badge ps-badge--sale text-center"><i style="font-size:10px !important;">Pre Orders <br>Only</i></span>
                                       </div>
                  <div class="ps-product__content">
                    <div class="ps-product__desc">
                      <span class="ps-product__title">Cheese Milk Cake</span>
                      <!-- <p>
                        <span>350g</span>
                        <span>30 Min</span>
                        <span>120 <sup>o</sup>C</span>
                      </p> -->

                      <span class="ps-product__price">৳320</span>

                    </div>

                                           <div class="ps-product__shopping">
                                                   <a class="ps-btn ps-product__add-to-cart col-md-12" href="product-detailsca1f.html?tokenOfLove=113">Order</a>
                                                 <!-- <div class="ps-product__actions">
                       <a href="javascript:void(0);"><i class="fa fa-heart-o"></i></a>
                       <a href="javascript:void(0);"><i class="fa fa-random"></i></a>
                   </div> -->

                      </div>
                                       </div>
                </div>
              </div>

                           <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-6 ">
                <div class="ps-product">
                  <div class="ps-product__thumbnail"><img src="{{ asset('lakeshore_bakery') }}/frontend/assets/erp/images/16625361363572.png" alt="Chocolate Milk Cake" />
                    <!-- <a class="ps-product__overlay" href="product-default.html"></a> -->
                                           <span class="ps-badge ps-badge--sale text-center"><i style="font-size:10px !important;">Pre Orders <br>Only</i></span>
                                       </div>
                  <div class="ps-product__content">
                    <div class="ps-product__desc">
                      <span class="ps-product__title">Chocolate Milk Cake</span>
                      <!-- <p>
                        <span>350g</span>
                        <span>30 Min</span>
                        <span>120 <sup>o</sup>C</span>
                      </p> -->

                      <span class="ps-product__price">৳320</span>

                    </div>

                                           <div class="ps-product__shopping">
                                                   <a class="ps-btn ps-product__add-to-cart col-md-12" href="product-details1b1a.html?tokenOfLove=121">Order</a>
                                                 <!-- <div class="ps-product__actions">
                       <a href="javascript:void(0);"><i class="fa fa-heart-o"></i></a>
                       <a href="javascript:void(0);"><i class="fa fa-random"></i></a>
                   </div> -->

                      </div>
                                       </div>
                </div>
              </div>

                           <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-6 ">
                <div class="ps-product">
                  <div class="ps-product__thumbnail"><img src="{{ asset('lakeshore_bakery') }}/frontend/assets/erp/images/170123438793830.png" alt="Coco Afro" />
                    <!-- <a class="ps-product__overlay" href="product-default.html"></a> -->
                                           <span class="ps-badge ps-badge--sale text-center"><i style="font-size:10px !important;">Pre Orders <br>Only</i></span>
                                       </div>
                  <div class="ps-product__content">
                    <div class="ps-product__desc">
                      <span class="ps-product__title">Coco Afro</span>
                      <!-- <p>
                        <span>350g</span>
                        <span>30 Min</span>
                        <span>120 <sup>o</sup>C</span>
                      </p> -->

                      <span class="ps-product__price">৳350</span>

                    </div>

                                           <div class="ps-product__shopping">
                        
                          <div class="button">
                            <button class="ps-btn ps-product__add-to-cart" onclick="addToCart('192')">Quick Add</button>
                          </div>

                          <a class="ps-btn ps-product__add-to-cart" href="product-details9dcc.html?tokenOfLove=192">Order</a>
                                                 <!-- <div class="ps-product__actions">
                       <a href="javascript:void(0);"><i class="fa fa-heart-o"></i></a>
                       <a href="javascript:void(0);"><i class="fa fa-random"></i></a>
                   </div> -->

                      </div>
                                       </div>
                </div>
              </div>

                           <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-6 ">
                <div class="ps-product">
                  <div class="ps-product__thumbnail"><img src="{{ asset('lakeshore_bakery') }}/frontend/assets/erp/images/169391584771630.png" alt="Cup cakes" />
                    <!-- <a class="ps-product__overlay" href="product-default.html"></a> -->
                                           <span class="ps-badge ps-badge--sale text-center"><i style="font-size:10px !important;">Pre Orders <br>Only</i></span>
                                       </div>
                  <div class="ps-product__content">
                    <div class="ps-product__desc">
                      <span class="ps-product__title">Cup cakes</span>
                      <!-- <p>
                        <span>350g</span>
                        <span>30 Min</span>
                        <span>120 <sup>o</sup>C</span>
                      </p> -->

                      <span class="ps-product__price">৳0</span>

                    </div>

                                           <div class="ps-product__shopping">
                        <h3 class="text-center">Not for Internal Sale</h3>
                      </div>
                                       </div>
                </div>
              </div>

                           <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-6 ">
                <div class="ps-product">
                  <div class="ps-product__thumbnail"><img src="{{ asset('lakeshore_bakery') }}/frontend/assets/erp/images/169391612230030.png" alt="CUP CAKES" />
                    <!-- <a class="ps-product__overlay" href="product-default.html"></a> -->
                                           <span class="ps-badge ps-badge--sale text-center"><i style="font-size:10px !important;">Pre Orders <br>Only</i></span>
                                       </div>
                  <div class="ps-product__content">
                    <div class="ps-product__desc">
                      <span class="ps-product__title">CUP CAKES</span>
                      <!-- <p>
                        <span>350g</span>
                        <span>30 Min</span>
                        <span>120 <sup>o</sup>C</span>
                      </p> -->

                      <span class="ps-product__price">৳130</span>

                    </div>

                                           <div class="ps-product__shopping">
                        
                          <div class="button">
                            <button class="ps-btn ps-product__add-to-cart" onclick="addToCart('183')">Quick Add</button>
                          </div>

                          <a class="ps-btn ps-product__add-to-cart" href="product-detailsf790.html?tokenOfLove=183">Order</a>
                                                 <!-- <div class="ps-product__actions">
                       <a href="javascript:void(0);"><i class="fa fa-heart-o"></i></a>
                       <a href="javascript:void(0);"><i class="fa fa-random"></i></a>
                   </div> -->

                      </div>
                                       </div>
                </div>
              </div>

                           <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-6 ">
                <div class="ps-product">
                  <div class="ps-product__thumbnail"><img src="{{ asset('lakeshore_bakery') }}/frontend/assets/erp/images/169987606444330.png" alt="Lotus Bomb" />
                    <!-- <a class="ps-product__overlay" href="product-default.html"></a> -->
                                           <span class="ps-badge ps-badge--sale text-center"><i style="font-size:10px !important;">Pre Orders <br>Only</i></span>
                                       </div>
                  <div class="ps-product__content">
                    <div class="ps-product__desc">
                      <span class="ps-product__title">Lotus Bomb</span>
                      <!-- <p>
                        <span>350g</span>
                        <span>30 Min</span>
                        <span>120 <sup>o</sup>C</span>
                      </p> -->

                      <span class="ps-product__price">৳450</span>

                    </div>

                                           <div class="ps-product__shopping">
                        
                          <div class="button">
                            <button class="ps-btn ps-product__add-to-cart" onclick="addToCart('188')">Quick Add</button>
                          </div>

                          <a class="ps-btn ps-product__add-to-cart" href="product-detailse841.html?tokenOfLove=188">Order</a>
                                                 <!-- <div class="ps-product__actions">
                       <a href="javascript:void(0);"><i class="fa fa-heart-o"></i></a>
                       <a href="javascript:void(0);"><i class="fa fa-random"></i></a>
                   </div> -->

                      </div>
                                       </div>
                </div>
              </div>

                           <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-6 ">
                <div class="ps-product">
                  <div class="ps-product__thumbnail"><img src="{{ asset('lakeshore_bakery') }}/frontend/assets/erp/images/169987614335830.png" alt="Nutella Bomb" />
                    <!-- <a class="ps-product__overlay" href="product-default.html"></a> -->
                                           <span class="ps-badge ps-badge--sale text-center"><i style="font-size:10px !important;">Pre Orders <br>Only</i></span>
                                       </div>
                  <div class="ps-product__content">
                    <div class="ps-product__desc">
                      <span class="ps-product__title">Nutella Bomb</span>
                      <!-- <p>
                        <span>350g</span>
                        <span>30 Min</span>
                        <span>120 <sup>o</sup>C</span>
                      </p> -->

                      <span class="ps-product__price">৳150</span>

                    </div>

                                           <div class="ps-product__shopping">
                        
                          <div class="button">
                            <button class="ps-btn ps-product__add-to-cart" onclick="addToCart('189')">Quick Add</button>
                          </div>

                          <a class="ps-btn ps-product__add-to-cart" href="product-details3d25.html?tokenOfLove=189">Order</a>
                                                 <!-- <div class="ps-product__actions">
                       <a href="javascript:void(0);"><i class="fa fa-heart-o"></i></a>
                       <a href="javascript:void(0);"><i class="fa fa-random"></i></a>
                   </div> -->

                      </div>
                                       </div>
                </div>
              </div>

                           <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-6 ">
                <div class="ps-product">
                  <div class="ps-product__thumbnail"><img src="{{ asset('lakeshore_bakery') }}/frontend/assets/erp/images/16400706579032.png" alt="Assorted Cookies" />
                    <!-- <a class="ps-product__overlay" href="product-default.html"></a> -->
                                           <span class="ps-badge ps-badge--sale text-center"><i style="font-size:10px !important;">Pre Orders <br>Only</i></span>
                                       </div>
                  <div class="ps-product__content">
                    <div class="ps-product__desc">
                      <span class="ps-product__title">Assorted Cookies</span>
                      <!-- <p>
                        <span>350g</span>
                        <span>30 Min</span>
                        <span>120 <sup>o</sup>C</span>
                      </p> -->

                      <span class="ps-product__price">৳610</span>

                    </div>

                                           <div class="ps-product__shopping">
                                                   <a class="ps-btn ps-product__add-to-cart col-md-12" href="product-detailsd56c.html?tokenOfLove=87">Order</a>
                                                 <!-- <div class="ps-product__actions">
                       <a href="javascript:void(0);"><i class="fa fa-heart-o"></i></a>
                       <a href="javascript:void(0);"><i class="fa fa-random"></i></a>
                   </div> -->

                      </div>
                                       </div>
                </div>
              </div>

                           <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-6 ">
                <div class="ps-product">
                  <div class="ps-product__thumbnail"><img src="{{ asset('lakeshore_bakery') }}/frontend/assets/erp/images/16377472040352.png" alt="Butter Cookies" />
                    <!-- <a class="ps-product__overlay" href="product-default.html"></a> -->
                                           <span class="ps-badge ps-badge--sale text-center"><i style="font-size:10px !important;">Pre Orders <br>Only</i></span>
                                       </div>
                  <div class="ps-product__content">
                    <div class="ps-product__desc">
                      <span class="ps-product__title">Butter Cookies</span>
                      <!-- <p>
                        <span>350g</span>
                        <span>30 Min</span>
                        <span>120 <sup>o</sup>C</span>
                      </p> -->

                      <span class="ps-product__price">৳350</span>

                    </div>

                                           <div class="ps-product__shopping">
                                                   <a class="ps-btn ps-product__add-to-cart col-md-12" href="product-detailsde27.html?tokenOfLove=79">Order</a>
                                                 <!-- <div class="ps-product__actions">
                       <a href="javascript:void(0);"><i class="fa fa-heart-o"></i></a>
                       <a href="javascript:void(0);"><i class="fa fa-random"></i></a>
                   </div> -->

                      </div>
                                       </div>
                </div>
              </div>

                           <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-6 ">
                <div class="ps-product">
                  <div class="ps-product__thumbnail"><img src="{{ asset('lakeshore_bakery') }}/frontend/assets/erp/images/163896394381318.png" alt="Nutella Stuffed Chocolate Soft Cookies" />
                    <!-- <a class="ps-product__overlay" href="product-default.html"></a> -->
                                           <span class="ps-badge ps-badge--sale text-center"><i style="font-size:10px !important;">Pre Orders <br>Only</i></span>
                                       </div>
                  <div class="ps-product__content">
                    <div class="ps-product__desc">
                      <span class="ps-product__title">Nutella Stuffed Chocolate Soft Cookies</span>
                      <!-- <p>
                        <span>350g</span>
                        <span>30 Min</span>
                        <span>120 <sup>o</sup>C</span>
                      </p> -->

                      <span class="ps-product__price">৳125</span>

                    </div>

                                           <div class="ps-product__shopping">
                                                   <a class="ps-btn ps-product__add-to-cart col-md-12" href="product-details347f.html?tokenOfLove=14">Order</a>
                                                 <!-- <div class="ps-product__actions">
                       <a href="javascript:void(0);"><i class="fa fa-heart-o"></i></a>
                       <a href="javascript:void(0);"><i class="fa fa-random"></i></a>
                   </div> -->

                      </div>
                                       </div>
                </div>
              </div>

                           <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-6 ">
                <div class="ps-product">
                  <div class="ps-product__thumbnail"><img src="{{ asset('lakeshore_bakery') }}/frontend/assets/erp/images/16287595447732.png" alt="Nutella Stuffed Red Velvet Soft Cookies " />
                    <!-- <a class="ps-product__overlay" href="product-default.html"></a> -->
                                           <span class="ps-badge ps-badge--sale text-center"><i style="font-size:10px !important;">Pre Orders <br>Only</i></span>
                                       </div>
                  <div class="ps-product__content">
                    <div class="ps-product__desc">
                      <span class="ps-product__title">Nutella Stuffed Red Velvet Soft Cookies </span>
                      <!-- <p>
                        <span>350g</span>
                        <span>30 Min</span>
                        <span>120 <sup>o</sup>C</span>
                      </p> -->

                      <span class="ps-product__price">৳510</span>

                    </div>

                                           <div class="ps-product__shopping">
                                                   <a class="ps-btn ps-product__add-to-cart col-md-12" href="product-details79c3.html?tokenOfLove=15">Order</a>
                                                 <!-- <div class="ps-product__actions">
                       <a href="javascript:void(0);"><i class="fa fa-heart-o"></i></a>
                       <a href="javascript:void(0);"><i class="fa fa-random"></i></a>
                   </div> -->

                      </div>
                                       </div>
                </div>
              </div>

                           <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-6 ">
                <div class="ps-product">
                  <div class="ps-product__thumbnail"><img src="{{ asset('lakeshore_bakery') }}/frontend/assets/erp/images/170288487880830.png" alt="Raad Sirs giftx box" />
                    <!-- <a class="ps-product__overlay" href="product-default.html"></a> -->
                                           <span class="ps-badge ps-badge--sale text-center"><i style="font-size:10px !important;">Pre Orders <br>Only</i></span>
                                       </div>
                  <div class="ps-product__content">
                    <div class="ps-product__desc">
                      <span class="ps-product__title">Raad Sirs giftx box</span>
                      <!-- <p>
                        <span>350g</span>
                        <span>30 Min</span>
                        <span>120 <sup>o</sup>C</span>
                      </p> -->

                      <span class="ps-product__price">৳1000</span>

                    </div>

                                           <div class="ps-product__shopping">
                        
                          <div class="button">
                            <button class="ps-btn ps-product__add-to-cart" onclick="addToCart('194')">Quick Add</button>
                          </div>

                          <a class="ps-btn ps-product__add-to-cart" href="product-details8c3e.html?tokenOfLove=194">Order</a>
                                                 <!-- <div class="ps-product__actions">
                       <a href="javascript:void(0);"><i class="fa fa-heart-o"></i></a>
                       <a href="javascript:void(0);"><i class="fa fa-random"></i></a>
                   </div> -->

                      </div>
                                       </div>
                </div>
              </div>

                           <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-6 ">
                <div class="ps-product">
                  <div class="ps-product__thumbnail"><img src="{{ asset('lakeshore_bakery') }}/frontend/assets/erp/images/16377468634362.png" alt="Salted Cookies" />
                    <!-- <a class="ps-product__overlay" href="product-default.html"></a> -->
                                           <span class="ps-badge ps-badge--sale text-center"><i style="font-size:10px !important;">Pre Orders <br>Only</i></span>
                                       </div>
                  <div class="ps-product__content">
                    <div class="ps-product__desc">
                      <span class="ps-product__title">Salted Cookies</span>
                      <!-- <p>
                        <span>350g</span>
                        <span>30 Min</span>
                        <span>120 <sup>o</sup>C</span>
                      </p> -->

                      <span class="ps-product__price">৳580</span>

                    </div>

                                           <div class="ps-product__shopping">
                                                   <a class="ps-btn ps-product__add-to-cart col-md-12" href="product-details2829.html?tokenOfLove=78">Order</a>
                                                 <!-- <div class="ps-product__actions">
                       <a href="javascript:void(0);"><i class="fa fa-heart-o"></i></a>
                       <a href="javascript:void(0);"><i class="fa fa-random"></i></a>
                   </div> -->

                      </div>
                                       </div>
                </div>
              </div>

                           <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-6 ">
                <div class="ps-product">
                  <div class="ps-product__thumbnail"><img src="{{ asset('lakeshore_bakery') }}/frontend/assets/erp/images/169770038788230.png" alt="Assorted Misty Mix" />
                    <!-- <a class="ps-product__overlay" href="product-default.html"></a> -->
                                           <span class="ps-badge ps-badge--sale text-center"><i style="font-size:10px !important;">Pre Orders <br>Only</i></span>
                                       </div>
                  <div class="ps-product__content">
                    <div class="ps-product__desc">
                      <span class="ps-product__title">Assorted Misty Mix</span>
                      <!-- <p>
                        <span>350g</span>
                        <span>30 Min</span>
                        <span>120 <sup>o</sup>C</span>
                      </p> -->

                      <span class="ps-product__price">৳1400</span>

                    </div>

                                           <div class="ps-product__shopping">
                        
                          <div class="button">
                            <button class="ps-btn ps-product__add-to-cart" onclick="addToCart('185')">Quick Add</button>
                          </div>

                          <a class="ps-btn ps-product__add-to-cart" href="product-detailsb2c0.html?tokenOfLove=185">Order</a>
                                                 <!-- <div class="ps-product__actions">
                       <a href="javascript:void(0);"><i class="fa fa-heart-o"></i></a>
                       <a href="javascript:void(0);"><i class="fa fa-random"></i></a>
                   </div> -->

                      </div>
                                       </div>
                </div>
              </div>

                           <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-6 ">
                <div class="ps-product">
                  <div class="ps-product__thumbnail"><img src="{{ asset('lakeshore_bakery') }}/frontend/assets/erp/images/167975200833730.png" alt="Assorted Sweets Box" />
                    <!-- <a class="ps-product__overlay" href="product-default.html"></a> -->
                                           <span class="ps-badge ps-badge--sale text-center"><i style="font-size:10px !important;">Pre Orders <br>Only</i></span>
                                       </div>
                  <div class="ps-product__content">
                    <div class="ps-product__desc">
                      <span class="ps-product__title">Assorted Sweets Box</span>
                      <!-- <p>
                        <span>350g</span>
                        <span>30 Min</span>
                        <span>120 <sup>o</sup>C</span>
                      </p> -->

                      <span class="ps-product__price">৳1600</span>

                    </div>

                                           <div class="ps-product__shopping">
                        
                          <div class="button">
                            <button class="ps-btn ps-product__add-to-cart" onclick="addToCart('139')">Quick Add</button>
                          </div>

                          <a class="ps-btn ps-product__add-to-cart" href="product-details11db.html?tokenOfLove=139">Order</a>
                                                 <!-- <div class="ps-product__actions">
                       <a href="javascript:void(0);"><i class="fa fa-heart-o"></i></a>
                       <a href="javascript:void(0);"><i class="fa fa-random"></i></a>
                   </div> -->

                      </div>
                                       </div>
                </div>
              </div>

                           <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-6 ">
                <div class="ps-product">
                  <div class="ps-product__thumbnail"><img src="{{ asset('lakeshore_bakery') }}/frontend/assets/erp/images/163896415758918.png" alt="Golap Jaam" />
                    <!-- <a class="ps-product__overlay" href="product-default.html"></a> -->
                                           <span class="ps-badge ps-badge--sale text-center"><i style="font-size:10px !important;">Pre Orders <br>Only</i></span>
                                       </div>
                  <div class="ps-product__content">
                    <div class="ps-product__desc">
                      <span class="ps-product__title">Golap Jaam</span>
                      <!-- <p>
                        <span>350g</span>
                        <span>30 Min</span>
                        <span>120 <sup>o</sup>C</span>
                      </p> -->

                      <span class="ps-product__price">৳60</span>

                    </div>

                                           <div class="ps-product__shopping">
                                                   <a class="ps-btn ps-product__add-to-cart col-md-12" href="product-details7e32.html?tokenOfLove=49">Order</a>
                                                 <!-- <div class="ps-product__actions">
                       <a href="javascript:void(0);"><i class="fa fa-heart-o"></i></a>
                       <a href="javascript:void(0);"><i class="fa fa-random"></i></a>
                   </div> -->

                      </div>
                                       </div>
                </div>
              </div>

                           <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-6 ">
                <div class="ps-product">
                  <div class="ps-product__thumbnail"><img src="{{ asset('lakeshore_bakery') }}/frontend/assets/erp/images/163896419040418.png" alt="Red Velvet Golap Jaam" />
                    <!-- <a class="ps-product__overlay" href="product-default.html"></a> -->
                                           <span class="ps-badge ps-badge--sale text-center"><i style="font-size:10px !important;">Pre Orders <br>Only</i></span>
                                       </div>
                  <div class="ps-product__content">
                    <div class="ps-product__desc">
                      <span class="ps-product__title">Red Velvet Golap Jaam</span>
                      <!-- <p>
                        <span>350g</span>
                        <span>30 Min</span>
                        <span>120 <sup>o</sup>C</span>
                      </p> -->

                      <span class="ps-product__price">৳500</span>

                    </div>

                                           <div class="ps-product__shopping">
                                                   <a class="ps-btn ps-product__add-to-cart col-md-12" href="product-detailsd70c.html?tokenOfLove=55">Order</a>
                                                 <!-- <div class="ps-product__actions">
                       <a href="javascript:void(0);"><i class="fa fa-heart-o"></i></a>
                       <a href="javascript:void(0);"><i class="fa fa-random"></i></a>
                   </div> -->

                      </div>
                                       </div>
                </div>
              </div>

                           <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-6 ">
                <div class="ps-product">
                  <div class="ps-product__thumbnail"><img src="{{ asset('lakeshore_bakery') }}/frontend/assets/erp/images/16326385500412.png" alt="Saffron Golap Jaam" />
                    <!-- <a class="ps-product__overlay" href="product-default.html"></a> -->
                                           <span class="ps-badge ps-badge--sale text-center"><i style="font-size:10px !important;">Pre Orders <br>Only</i></span>
                                       </div>
                  <div class="ps-product__content">
                    <div class="ps-product__desc">
                      <span class="ps-product__title">Saffron Golap Jaam</span>
                      <!-- <p>
                        <span>350g</span>
                        <span>30 Min</span>
                        <span>120 <sup>o</sup>C</span>
                      </p> -->

                      <span class="ps-product__price">৳600</span>

                    </div>

                                           <div class="ps-product__shopping">
                                                   <a class="ps-btn ps-product__add-to-cart col-md-12" href="product-detailsee6e.html?tokenOfLove=54">Order</a>
                                                 <!-- <div class="ps-product__actions">
                       <a href="javascript:void(0);"><i class="fa fa-heart-o"></i></a>
                       <a href="javascript:void(0);"><i class="fa fa-random"></i></a>
                   </div> -->

                      </div>
                                       </div>
                </div>
              </div>

                           <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-6 ">
                <div class="ps-product">
                  <div class="ps-product__thumbnail"><img src="{{ asset('lakeshore_bakery') }}/frontend/assets/erp/images/169036967321230.png" alt="Sweet " />
                    <!-- <a class="ps-product__overlay" href="product-default.html"></a> -->
                                           <span class="ps-badge ps-badge--sale text-center"><i style="font-size:10px !important;">Pre Orders <br>Only</i></span>
                                       </div>
                  <div class="ps-product__content">
                    <div class="ps-product__desc">
                      <span class="ps-product__title">Sweet </span>
                      <!-- <p>
                        <span>350g</span>
                        <span>30 Min</span>
                        <span>120 <sup>o</sup>C</span>
                      </p> -->

                      <span class="ps-product__price">৳80</span>

                    </div>

                                           <div class="ps-product__shopping">
                        
                          <div class="button">
                            <button class="ps-btn ps-product__add-to-cart" onclick="addToCart('179')">Quick Add</button>
                          </div>

                          <a class="ps-btn ps-product__add-to-cart" href="product-details1a76.html?tokenOfLove=179">Order</a>
                                                 <!-- <div class="ps-product__actions">
                       <a href="javascript:void(0);"><i class="fa fa-heart-o"></i></a>
                       <a href="javascript:void(0);"><i class="fa fa-random"></i></a>
                   </div> -->

                      </div>
                                       </div>
                </div>
              </div>

                           <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-6 ">
                <div class="ps-product">
                  <div class="ps-product__thumbnail"><img src="{{ asset('lakeshore_bakery') }}/frontend/assets/erp/images/163896427217418.png" alt="Belgian Chocolate" />
                    <!-- <a class="ps-product__overlay" href="product-default.html"></a> -->
                                           <span class="ps-badge ps-badge--sale text-center"><i style="font-size:10px !important;">Pre Orders <br>Only</i></span>
                                       </div>
                  <div class="ps-product__content">
                    <div class="ps-product__desc">
                      <span class="ps-product__title">Belgian Chocolate</span>
                      <!-- <p>
                        <span>350g</span>
                        <span>30 Min</span>
                        <span>120 <sup>o</sup>C</span>
                      </p> -->

                      <span class="ps-product__price">৳2300</span>

                    </div>

                                           <div class="ps-product__shopping">
                                                   <a class="ps-btn ps-product__add-to-cart col-md-12" href="product-details3f43.html?tokenOfLove=71">Order</a>
                                                 <!-- <div class="ps-product__actions">
                       <a href="javascript:void(0);"><i class="fa fa-heart-o"></i></a>
                       <a href="javascript:void(0);"><i class="fa fa-random"></i></a>
                   </div> -->

                      </div>
                                       </div>
                </div>
              </div>

                           <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-6 ">
                <div class="ps-product">
                  <div class="ps-product__thumbnail"><img src="{{ asset('lakeshore_bakery') }}/frontend/assets/erp/images/163896423754918.png" alt="Dense Chocolate Caramel" />
                    <!-- <a class="ps-product__overlay" href="product-default.html"></a> -->
                                           <span class="ps-badge ps-badge--sale text-center"><i style="font-size:10px !important;">Pre Orders <br>Only</i></span>
                                       </div>
                  <div class="ps-product__content">
                    <div class="ps-product__desc">
                      <span class="ps-product__title">Dense Chocolate Caramel</span>
                      <!-- <p>
                        <span>350g</span>
                        <span>30 Min</span>
                        <span>120 <sup>o</sup>C</span>
                      </p> -->

                      <span class="ps-product__price">৳1550</span>

                    </div>

                                           <div class="ps-product__shopping">
                                                   <a class="ps-btn ps-product__add-to-cart col-md-12" href="product-details406e.html?tokenOfLove=70">Order</a>
                                                 <!-- <div class="ps-product__actions">
                       <a href="javascript:void(0);"><i class="fa fa-heart-o"></i></a>
                       <a href="javascript:void(0);"><i class="fa fa-random"></i></a>
                   </div> -->

                      </div>
                                       </div>
                </div>
              </div>

                           <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-6 ">
                <div class="ps-product">
                  <div class="ps-product__thumbnail"><img src="{{ asset('lakeshore_bakery') }}/frontend/assets/erp/images/169631646613130.png" alt="Lotus Biscoff" />
                    <!-- <a class="ps-product__overlay" href="product-default.html"></a> -->
                                           <span class="ps-badge ps-badge--sale text-center"><i style="font-size:10px !important;">Pre Orders <br>Only</i></span>
                                       </div>
                  <div class="ps-product__content">
                    <div class="ps-product__desc">
                      <span class="ps-product__title">Lotus Biscoff</span>
                      <!-- <p>
                        <span>350g</span>
                        <span>30 Min</span>
                        <span>120 <sup>o</sup>C</span>
                      </p> -->

                      <span class="ps-product__price">৳3900</span>

                    </div>

                                           <div class="ps-product__shopping">
                        
                          <div class="button">
                            <button class="ps-btn ps-product__add-to-cart" onclick="addToCart('184')">Quick Add</button>
                          </div>

                          <a class="ps-btn ps-product__add-to-cart" href="product-detailsf490.html?tokenOfLove=184">Order</a>
                                                 <!-- <div class="ps-product__actions">
                       <a href="javascript:void(0);"><i class="fa fa-heart-o"></i></a>
                       <a href="javascript:void(0);"><i class="fa fa-random"></i></a>
                   </div> -->

                      </div>
                                       </div>
                </div>
              </div>

                           <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-6 ">
                <div class="ps-product">
                  <div class="ps-product__thumbnail"><img src="{{ asset('lakeshore_bakery') }}/frontend/assets/erp/images/169631325047030.png" alt="Mocha Cake" />
                    <!-- <a class="ps-product__overlay" href="product-default.html"></a> -->
                                           <span class="ps-badge ps-badge--sale text-center"><i style="font-size:10px !important;">Pre Orders <br>Only</i></span>
                                       </div>
                  <div class="ps-product__content">
                    <div class="ps-product__desc">
                      <span class="ps-product__title">Mocha Cake</span>
                      <!-- <p>
                        <span>350g</span>
                        <span>30 Min</span>
                        <span>120 <sup>o</sup>C</span>
                      </p> -->

                      <span class="ps-product__price">৳1200</span>

                    </div>

                                           <div class="ps-product__shopping">
                                                   <a class="ps-btn ps-product__add-to-cart col-md-12" href="product-detailsdaae.html?tokenOfLove=119">Order</a>
                                                 <!-- <div class="ps-product__actions">
                       <a href="javascript:void(0);"><i class="fa fa-heart-o"></i></a>
                       <a href="javascript:void(0);"><i class="fa fa-random"></i></a>
                   </div> -->

                      </div>
                                       </div>
                </div>
              </div>

                           <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-6 ">
                <div class="ps-product">
                  <div class="ps-product__thumbnail"><img src="{{ asset('lakeshore_bakery') }}/frontend/assets/erp/images/166081393613018.png" alt="Opera Cake" />
                    <!-- <a class="ps-product__overlay" href="product-default.html"></a> -->
                                           <span class="ps-badge ps-badge--sale text-center"><i style="font-size:10px !important;">Pre Orders <br>Only</i></span>
                                       </div>
                  <div class="ps-product__content">
                    <div class="ps-product__desc">
                      <span class="ps-product__title">Opera Cake</span>
                      <!-- <p>
                        <span>350g</span>
                        <span>30 Min</span>
                        <span>120 <sup>o</sup>C</span>
                      </p> -->

                      <span class="ps-product__price">৳1500</span>

                    </div>

                                           <div class="ps-product__shopping">
                                                   <a class="ps-btn ps-product__add-to-cart col-md-12" href="product-detailsc0f1.html?tokenOfLove=127">Order</a>
                                                 <!-- <div class="ps-product__actions">
                       <a href="javascript:void(0);"><i class="fa fa-heart-o"></i></a>
                       <a href="javascript:void(0);"><i class="fa fa-random"></i></a>
                   </div> -->

                      </div>
                                       </div>
                </div>
              </div>

                           <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-6 ">
                <div class="ps-product">
                  <div class="ps-product__thumbnail"><img src="{{ asset('lakeshore_bakery') }}/frontend/assets/erp/images/163896431050518.png" alt="Red Velvet" />
                    <!-- <a class="ps-product__overlay" href="product-default.html"></a> -->
                                           <span class="ps-badge ps-badge--sale text-center"><i style="font-size:10px !important;">Pre Orders <br>Only</i></span>
                                       </div>
                  <div class="ps-product__content">
                    <div class="ps-product__desc">
                      <span class="ps-product__title">Red Velvet</span>
                      <!-- <p>
                        <span>350g</span>
                        <span>30 Min</span>
                        <span>120 <sup>o</sup>C</span>
                      </p> -->

                      <span class="ps-product__price">৳1450</span>

                    </div>

                                           <div class="ps-product__shopping">
                                                   <a class="ps-btn ps-product__add-to-cart col-md-12" href="product-detailsb138.html?tokenOfLove=72">Order</a>
                                                 <!-- <div class="ps-product__actions">
                       <a href="javascript:void(0);"><i class="fa fa-heart-o"></i></a>
                       <a href="javascript:void(0);"><i class="fa fa-random"></i></a>
                   </div> -->

                      </div>
                                       </div>
                </div>
              </div>

                           <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-6 ">
                <div class="ps-product">
                  <div class="ps-product__thumbnail"><img src="{{ asset('lakeshore_bakery') }}/frontend/assets/erp/images/16549310999922.png" alt="Tiramisu" />
                    <!-- <a class="ps-product__overlay" href="product-default.html"></a> -->
                                           <span class="ps-badge ps-badge--sale text-center"><i style="font-size:10px !important;">Pre Orders <br>Only</i></span>
                                       </div>
                  <div class="ps-product__content">
                    <div class="ps-product__desc">
                      <span class="ps-product__title">Tiramisu</span>
                      <!-- <p>
                        <span>350g</span>
                        <span>30 Min</span>
                        <span>120 <sup>o</sup>C</span>
                      </p> -->

                      <span class="ps-product__price">৳1750</span>

                    </div>

                                           <div class="ps-product__shopping">
                                                   <a class="ps-btn ps-product__add-to-cart col-md-12" href="product-detailsf482.html?tokenOfLove=73">Order</a>
                                                 <!-- <div class="ps-product__actions">
                       <a href="javascript:void(0);"><i class="fa fa-heart-o"></i></a>
                       <a href="javascript:void(0);"><i class="fa fa-random"></i></a>
                   </div> -->

                      </div>
                                       </div>
                </div>
              </div>

                           <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-6 ">
                <div class="ps-product">
                  <div class="ps-product__thumbnail"><img src="{{ asset('lakeshore_bakery') }}/frontend/assets/erp/images/16549310393512.png" alt="Ube Cake" />
                    <!-- <a class="ps-product__overlay" href="product-default.html"></a> -->
                                           <span class="ps-badge ps-badge--sale text-center"><i style="font-size:10px !important;">Pre Orders <br>Only</i></span>
                                       </div>
                  <div class="ps-product__content">
                    <div class="ps-product__desc">
                      <span class="ps-product__title">Ube Cake</span>
                      <!-- <p>
                        <span>350g</span>
                        <span>30 Min</span>
                        <span>120 <sup>o</sup>C</span>
                      </p> -->

                      <span class="ps-product__price">৳2100</span>

                    </div>

                                           <div class="ps-product__shopping">
                                                   <a class="ps-btn ps-product__add-to-cart col-md-12" href="product-details207b.html?tokenOfLove=115">Order</a>
                                                 <!-- <div class="ps-product__actions">
                       <a href="javascript:void(0);"><i class="fa fa-heart-o"></i></a>
                       <a href="javascript:void(0);"><i class="fa fa-random"></i></a>
                   </div> -->

                      </div>
                                       </div>
                </div>
              </div>

                           <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-6 ">
                <div class="ps-product">
                  <div class="ps-product__thumbnail"><img src="{{ asset('lakeshore_bakery') }}/frontend/assets/erp/images/169631554698530.png" alt="Vanilla Bean" />
                    <!-- <a class="ps-product__overlay" href="product-default.html"></a> -->
                                           <span class="ps-badge ps-badge--sale text-center"><i style="font-size:10px !important;">Pre Orders <br>Only</i></span>
                                       </div>
                  <div class="ps-product__content">
                    <div class="ps-product__desc">
                      <span class="ps-product__title">Vanilla Bean</span>
                      <!-- <p>
                        <span>350g</span>
                        <span>30 Min</span>
                        <span>120 <sup>o</sup>C</span>
                      </p> -->

                      <span class="ps-product__price">৳1300</span>

                    </div>

                                           <div class="ps-product__shopping">
                                                   <a class="ps-btn ps-product__add-to-cart col-md-12" href="product-detailsc83e.html?tokenOfLove=120">Order</a>
                                                 <!-- <div class="ps-product__actions">
                       <a href="javascript:void(0);"><i class="fa fa-heart-o"></i></a>
                       <a href="javascript:void(0);"><i class="fa fa-random"></i></a>
                   </div> -->

                      </div>
                                       </div>
                </div>
              </div>

                           <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-6 ">
                <div class="ps-product">
                  <div class="ps-product__thumbnail"><img src="{{ asset('lakeshore_bakery') }}/frontend/assets/erp/images/163896447664718.png" alt="Assorted Cannoli" />
                    <!-- <a class="ps-product__overlay" href="product-default.html"></a> -->
                                           <span class="ps-badge ps-badge--sale text-center"><i style="font-size:10px !important;">Pre Orders <br>Only</i></span>
                                       </div>
                  <div class="ps-product__content">
                    <div class="ps-product__desc">
                      <span class="ps-product__title">Assorted Cannoli</span>
                      <!-- <p>
                        <span>350g</span>
                        <span>30 Min</span>
                        <span>120 <sup>o</sup>C</span>
                      </p> -->

                      <span class="ps-product__price">৳650</span>

                    </div>

                                           <div class="ps-product__shopping">
                        
                          <div class="button">
                            <button class="ps-btn ps-product__add-to-cart" onclick="addToCart('74')">Quick Add</button>
                          </div>

                          <a class="ps-btn ps-product__add-to-cart" href="product-details9240.html?tokenOfLove=74">Order</a>
                                                 <!-- <div class="ps-product__actions">
                       <a href="javascript:void(0);"><i class="fa fa-heart-o"></i></a>
                       <a href="javascript:void(0);"><i class="fa fa-random"></i></a>
                   </div> -->

                      </div>
                                       </div>
                </div>
              </div>

                           <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-6 ">
                <div class="ps-product">
                  <div class="ps-product__thumbnail"><img src="{{ asset('lakeshore_bakery') }}/frontend/assets/erp/images/16377479957942.png" alt="Butter Pound Cake " />
                    <!-- <a class="ps-product__overlay" href="product-default.html"></a> -->
                                           <span class="ps-badge ps-badge--sale text-center"><i style="font-size:10px !important;">Pre Orders <br>Only</i></span>
                                       </div>
                  <div class="ps-product__content">
                    <div class="ps-product__desc">
                      <span class="ps-product__title">Butter Pound Cake </span>
                      <!-- <p>
                        <span>350g</span>
                        <span>30 Min</span>
                        <span>120 <sup>o</sup>C</span>
                      </p> -->

                      <span class="ps-product__price">৳600</span>

                    </div>

                                           <div class="ps-product__shopping">
                        
                          <div class="button">
                            <button class="ps-btn ps-product__add-to-cart" onclick="addToCart('81')">Quick Add</button>
                          </div>

                          <a class="ps-btn ps-product__add-to-cart" href="product-detailsb234.html?tokenOfLove=81">Order</a>
                                                 <!-- <div class="ps-product__actions">
                       <a href="javascript:void(0);"><i class="fa fa-heart-o"></i></a>
                       <a href="javascript:void(0);"><i class="fa fa-random"></i></a>
                   </div> -->

                      </div>
                                       </div>
                </div>
              </div>

                           <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-6 ">
                <div class="ps-product">
                  <div class="ps-product__thumbnail"><img src="{{ asset('lakeshore_bakery') }}/frontend/assets/erp/images/163896479687718.png" alt="Chocolate Pound Cake" />
                    <!-- <a class="ps-product__overlay" href="product-default.html"></a> -->
                                           <span class="ps-badge ps-badge--sale text-center"><i style="font-size:10px !important;">Pre Orders <br>Only</i></span>
                                       </div>
                  <div class="ps-product__content">
                    <div class="ps-product__desc">
                      <span class="ps-product__title">Chocolate Pound Cake</span>
                      <!-- <p>
                        <span>350g</span>
                        <span>30 Min</span>
                        <span>120 <sup>o</sup>C</span>
                      </p> -->

                      <span class="ps-product__price">৳650</span>

                    </div>

                                           <div class="ps-product__shopping">
                        
                          <div class="button">
                            <button class="ps-btn ps-product__add-to-cart" onclick="addToCart('80')">Quick Add</button>
                          </div>

                          <a class="ps-btn ps-product__add-to-cart" href="product-details8901.html?tokenOfLove=80">Order</a>
                                                 <!-- <div class="ps-product__actions">
                       <a href="javascript:void(0);"><i class="fa fa-heart-o"></i></a>
                       <a href="javascript:void(0);"><i class="fa fa-random"></i></a>
                   </div> -->

                      </div>
                                       </div>
                </div>
              </div>

                           <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-6 ">
                <div class="ps-product">
                  <div class="ps-product__thumbnail"><img src="{{ asset('lakeshore_bakery') }}/frontend/assets/erp/images/16377482066952.png" alt="Fruit Pound Cake" />
                    <!-- <a class="ps-product__overlay" href="product-default.html"></a> -->
                                           <span class="ps-badge ps-badge--sale text-center"><i style="font-size:10px !important;">Pre Orders <br>Only</i></span>
                                       </div>
                  <div class="ps-product__content">
                    <div class="ps-product__desc">
                      <span class="ps-product__title">Fruit Pound Cake</span>
                      <!-- <p>
                        <span>350g</span>
                        <span>30 Min</span>
                        <span>120 <sup>o</sup>C</span>
                      </p> -->

                      <span class="ps-product__price">৳600</span>

                    </div>

                                           <div class="ps-product__shopping">
                        
                          <div class="button">
                            <button class="ps-btn ps-product__add-to-cart" onclick="addToCart('83')">Quick Add</button>
                          </div>

                          <a class="ps-btn ps-product__add-to-cart" href="product-details1903.html?tokenOfLove=83">Order</a>
                                                 <!-- <div class="ps-product__actions">
                       <a href="javascript:void(0);"><i class="fa fa-heart-o"></i></a>
                       <a href="javascript:void(0);"><i class="fa fa-random"></i></a>
                   </div> -->

                      </div>
                                       </div>
                </div>
              </div>

                           <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-6 ">
                <div class="ps-product">
                  <div class="ps-product__thumbnail"><img src="{{ asset('lakeshore_bakery') }}/frontend/assets/erp/images/163896484154418.png" alt="Marble Pound Cake" />
                    <!-- <a class="ps-product__overlay" href="product-default.html"></a> -->
                                           <span class="ps-badge ps-badge--sale text-center"><i style="font-size:10px !important;">Pre Orders <br>Only</i></span>
                                       </div>
                  <div class="ps-product__content">
                    <div class="ps-product__desc">
                      <span class="ps-product__title">Marble Pound Cake</span>
                      <!-- <p>
                        <span>350g</span>
                        <span>30 Min</span>
                        <span>120 <sup>o</sup>C</span>
                      </p> -->

                      <span class="ps-product__price">৳620</span>

                    </div>

                                           <div class="ps-product__shopping">
                        
                          <div class="button">
                            <button class="ps-btn ps-product__add-to-cart" onclick="addToCart('82')">Quick Add</button>
                          </div>

                          <a class="ps-btn ps-product__add-to-cart" href="product-detailsc348.html?tokenOfLove=82">Order</a>
                                                 <!-- <div class="ps-product__actions">
                       <a href="javascript:void(0);"><i class="fa fa-heart-o"></i></a>
                       <a href="javascript:void(0);"><i class="fa fa-random"></i></a>
                   </div> -->

                      </div>
                                       </div>
                </div>
              </div>

                           <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-6 ">
                <div class="ps-product">
                  <div class="ps-product__thumbnail"><img src="{{ asset('lakeshore_bakery') }}/frontend/assets/erp/images/16378224221562.png" alt="Doughnut Box" />
                    <!-- <a class="ps-product__overlay" href="product-default.html"></a> -->
                                           <span class="ps-badge ps-badge--sale text-center"><i style="font-size:10px !important;">Pre Orders <br>Only</i></span>
                                       </div>
                  <div class="ps-product__content">
                    <div class="ps-product__desc">
                      <span class="ps-product__title">Doughnut Box</span>
                      <!-- <p>
                        <span>350g</span>
                        <span>30 Min</span>
                        <span>120 <sup>o</sup>C</span>
                      </p> -->

                      <span class="ps-product__price">৳990</span>

                    </div>

                                           <div class="ps-product__shopping">
                        
                          <div class="button">
                            <button class="ps-btn ps-product__add-to-cart" onclick="addToCart('84')">Quick Add</button>
                          </div>

                          <a class="ps-btn ps-product__add-to-cart" href="product-detailsc4ba.html?tokenOfLove=84">Order</a>
                                                 <!-- <div class="ps-product__actions">
                       <a href="javascript:void(0);"><i class="fa fa-heart-o"></i></a>
                       <a href="javascript:void(0);"><i class="fa fa-random"></i></a>
                   </div> -->

                      </div>
                                       </div>
                </div>
              </div>

                           <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-6 ">
                <div class="ps-product">
                  <div class="ps-product__thumbnail"><img src="{{ asset('lakeshore_bakery') }}/frontend/assets/erp/images/16400702919932.png" alt="Assorted Tart" />
                    <!-- <a class="ps-product__overlay" href="product-default.html"></a> -->
                                           <span class="ps-badge ps-badge--sale text-center"><i style="font-size:10px !important;">Pre Orders <br>Only</i></span>
                                       </div>
                  <div class="ps-product__content">
                    <div class="ps-product__desc">
                      <span class="ps-product__title">Assorted Tart</span>
                      <!-- <p>
                        <span>350g</span>
                        <span>30 Min</span>
                        <span>120 <sup>o</sup>C</span>
                      </p> -->

                      <span class="ps-product__price">৳1400</span>

                    </div>

                                           <div class="ps-product__shopping">
                        
                          <div class="button">
                            <button class="ps-btn ps-product__add-to-cart" onclick="addToCart('86')">Quick Add</button>
                          </div>

                          <a class="ps-btn ps-product__add-to-cart" href="product-details1812.html?tokenOfLove=86">Order</a>
                                                 <!-- <div class="ps-product__actions">
                       <a href="javascript:void(0);"><i class="fa fa-heart-o"></i></a>
                       <a href="javascript:void(0);"><i class="fa fa-random"></i></a>
                   </div> -->

                      </div>
                                       </div>
                </div>
              </div>

                           <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-6 ">
                <div class="ps-product">
                  <div class="ps-product__thumbnail"><img src="{{ asset('lakeshore_bakery') }}/frontend/assets/erp/images/16513151582102.png" alt="Chocolate Tart" />
                    <!-- <a class="ps-product__overlay" href="product-default.html"></a> -->
                                           <span class="ps-badge ps-badge--sale text-center"><i style="font-size:10px !important;">Pre Orders <br>Only</i></span>
                                       </div>
                  <div class="ps-product__content">
                    <div class="ps-product__desc">
                      <span class="ps-product__title">Chocolate Tart</span>
                      <!-- <p>
                        <span>350g</span>
                        <span>30 Min</span>
                        <span>120 <sup>o</sup>C</span>
                      </p> -->

                      <span class="ps-product__price">৳230</span>

                    </div>

                                           <div class="ps-product__shopping">
                        
                          <div class="button">
                            <button class="ps-btn ps-product__add-to-cart" onclick="addToCart('109')">Quick Add</button>
                          </div>

                          <a class="ps-btn ps-product__add-to-cart" href="product-details167c.html?tokenOfLove=109">Order</a>
                                                 <!-- <div class="ps-product__actions">
                       <a href="javascript:void(0);"><i class="fa fa-heart-o"></i></a>
                       <a href="javascript:void(0);"><i class="fa fa-random"></i></a>
                   </div> -->

                      </div>
                                       </div>
                </div>
              </div>

                           <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-6 ">
                <div class="ps-product">
                  <div class="ps-product__thumbnail"><img src="{{ asset('lakeshore_bakery') }}/frontend/assets/erp/images/16513139635032.png" alt="Coffee Tart" />
                    <!-- <a class="ps-product__overlay" href="product-default.html"></a> -->
                                           <span class="ps-badge ps-badge--sale text-center"><i style="font-size:10px !important;">Pre Orders <br>Only</i></span>
                                       </div>
                  <div class="ps-product__content">
                    <div class="ps-product__desc">
                      <span class="ps-product__title">Coffee Tart</span>
                      <!-- <p>
                        <span>350g</span>
                        <span>30 Min</span>
                        <span>120 <sup>o</sup>C</span>
                      </p> -->

                      <span class="ps-product__price">৳280</span>

                    </div>

                                           <div class="ps-product__shopping">
                        
                          <div class="button">
                            <button class="ps-btn ps-product__add-to-cart" onclick="addToCart('108')">Quick Add</button>
                          </div>

                          <a class="ps-btn ps-product__add-to-cart" href="product-details91d4.html?tokenOfLove=108">Order</a>
                                                 <!-- <div class="ps-product__actions">
                       <a href="javascript:void(0);"><i class="fa fa-heart-o"></i></a>
                       <a href="javascript:void(0);"><i class="fa fa-random"></i></a>
                   </div> -->

                      </div>
                                       </div>
                </div>
              </div>

                           <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-6 ">
                <div class="ps-product">
                  <div class="ps-product__thumbnail"><img src="{{ asset('lakeshore_bakery') }}/frontend/assets/erp/images/16513151827612.png" alt="Creamy Chocolate Tart" />
                    <!-- <a class="ps-product__overlay" href="product-default.html"></a> -->
                                           <span class="ps-badge ps-badge--sale text-center"><i style="font-size:10px !important;">Pre Orders <br>Only</i></span>
                                       </div>
                  <div class="ps-product__content">
                    <div class="ps-product__desc">
                      <span class="ps-product__title">Creamy Chocolate Tart</span>
                      <!-- <p>
                        <span>350g</span>
                        <span>30 Min</span>
                        <span>120 <sup>o</sup>C</span>
                      </p> -->

                      <span class="ps-product__price">৳210</span>

                    </div>

                                           <div class="ps-product__shopping">
                        
                          <div class="button">
                            <button class="ps-btn ps-product__add-to-cart" onclick="addToCart('110')">Quick Add</button>
                          </div>

                          <a class="ps-btn ps-product__add-to-cart" href="product-details30dd.html?tokenOfLove=110">Order</a>
                                                 <!-- <div class="ps-product__actions">
                       <a href="javascript:void(0);"><i class="fa fa-heart-o"></i></a>
                       <a href="javascript:void(0);"><i class="fa fa-random"></i></a>
                   </div> -->

                      </div>
                                       </div>
                </div>
              </div>

                           <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-6 ">
                <div class="ps-product">
                  <div class="ps-product__thumbnail"><img src="{{ asset('lakeshore_bakery') }}/frontend/assets/erp/images/16513152354032.png" alt="Honey & Nut Tart" />
                    <!-- <a class="ps-product__overlay" href="product-default.html"></a> -->
                                           <span class="ps-badge ps-badge--sale text-center"><i style="font-size:10px !important;">Pre Orders <br>Only</i></span>
                                       </div>
                  <div class="ps-product__content">
                    <div class="ps-product__desc">
                      <span class="ps-product__title">Honey & Nut Tart</span>
                      <!-- <p>
                        <span>350g</span>
                        <span>30 Min</span>
                        <span>120 <sup>o</sup>C</span>
                      </p> -->

                      <span class="ps-product__price">৳210</span>

                    </div>

                                           <div class="ps-product__shopping">
                                                   <a class="ps-btn ps-product__add-to-cart col-md-12" href="product-detailsf419.html?tokenOfLove=111">Order</a>
                                                 <!-- <div class="ps-product__actions">
                       <a href="javascript:void(0);"><i class="fa fa-heart-o"></i></a>
                       <a href="javascript:void(0);"><i class="fa fa-random"></i></a>
                   </div> -->

                      </div>
                                       </div>
                </div>
              </div>

                           <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-6 ">
                <div class="ps-product">
                  <div class="ps-product__thumbnail"><img src="{{ asset('lakeshore_bakery') }}/frontend/assets/erp/images/16513156640312.png" alt="Lemon Tart" />
                    <!-- <a class="ps-product__overlay" href="product-default.html"></a> -->
                                           <span class="ps-badge ps-badge--sale text-center"><i style="font-size:10px !important;">Pre Orders <br>Only</i></span>
                                       </div>
                  <div class="ps-product__content">
                    <div class="ps-product__desc">
                      <span class="ps-product__title">Lemon Tart</span>
                      <!-- <p>
                        <span>350g</span>
                        <span>30 Min</span>
                        <span>120 <sup>o</sup>C</span>
                      </p> -->

                      <span class="ps-product__price">৳160</span>

                    </div>

                                           <div class="ps-product__shopping">
                        
                          <div class="button">
                            <button class="ps-btn ps-product__add-to-cart" onclick="addToCart('112')">Quick Add</button>
                          </div>

                          <a class="ps-btn ps-product__add-to-cart" href="product-details6b2c.html?tokenOfLove=112">Order</a>
                                                 <!-- <div class="ps-product__actions">
                       <a href="javascript:void(0);"><i class="fa fa-heart-o"></i></a>
                       <a href="javascript:void(0);"><i class="fa fa-random"></i></a>
                   </div> -->

                      </div>
                                       </div>
                </div>
              </div>

                           <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-6 ">
                <div class="ps-product">
                  <div class="ps-product__thumbnail"><img src="{{ asset('lakeshore_bakery') }}/frontend/assets/erp/images/170123457896430.png" alt="Lotus Popscile" />
                    <!-- <a class="ps-product__overlay" href="product-default.html"></a> -->
                                           <span class="ps-badge ps-badge--sale text-center"><i style="font-size:10px !important;">Pre Orders <br>Only</i></span>
                                       </div>
                  <div class="ps-product__content">
                    <div class="ps-product__desc">
                      <span class="ps-product__title">Lotus Popscile</span>
                      <!-- <p>
                        <span>350g</span>
                        <span>30 Min</span>
                        <span>120 <sup>o</sup>C</span>
                      </p> -->

                      <span class="ps-product__price">৳250</span>

                    </div>

                                           <div class="ps-product__shopping">
                        
                          <div class="button">
                            <button class="ps-btn ps-product__add-to-cart" onclick="addToCart('193')">Quick Add</button>
                          </div>

                          <a class="ps-btn ps-product__add-to-cart" href="product-details81ee.html?tokenOfLove=193">Order</a>
                                                 <!-- <div class="ps-product__actions">
                       <a href="javascript:void(0);"><i class="fa fa-heart-o"></i></a>
                       <a href="javascript:void(0);"><i class="fa fa-random"></i></a>
                   </div> -->

                      </div>
                                       </div>
                </div>
              </div>

                           <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-6 ">
                <div class="ps-product">
                  <div class="ps-product__thumbnail"><img src="{{ asset('lakeshore_bakery') }}/frontend/assets/erp/images/170049315820330.png" alt="Mushroom tarts" />
                    <!-- <a class="ps-product__overlay" href="product-default.html"></a> -->
                                           <span class="ps-badge ps-badge--sale text-center"><i style="font-size:10px !important;">Pre Orders <br>Only</i></span>
                                       </div>
                  <div class="ps-product__content">
                    <div class="ps-product__desc">
                      <span class="ps-product__title">Mushroom tarts</span>
                      <!-- <p>
                        <span>350g</span>
                        <span>30 Min</span>
                        <span>120 <sup>o</sup>C</span>
                      </p> -->

                      <span class="ps-product__price">৳120</span>

                    </div>

                                           <div class="ps-product__shopping">
                        
                          <div class="button">
                            <button class="ps-btn ps-product__add-to-cart" onclick="addToCart('191')">Quick Add</button>
                          </div>

                          <a class="ps-btn ps-product__add-to-cart" href="product-details145f.html?tokenOfLove=191">Order</a>
                                                 <!-- <div class="ps-product__actions">
                       <a href="javascript:void(0);"><i class="fa fa-heart-o"></i></a>
                       <a href="javascript:void(0);"><i class="fa fa-random"></i></a>
                   </div> -->

                      </div>
                                       </div>
                </div>
              </div>

                           <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-6 ">
                <div class="ps-product">
                  <div class="ps-product__thumbnail"><img src="{{ asset('lakeshore_bakery') }}/frontend/assets/erp/images/16513138357782.png" alt="Red Velvet Cheese Tart" />
                    <!-- <a class="ps-product__overlay" href="product-default.html"></a> -->
                                           <span class="ps-badge ps-badge--sale text-center"><i style="font-size:10px !important;">Pre Orders <br>Only</i></span>
                                       </div>
                  <div class="ps-product__content">
                    <div class="ps-product__desc">
                      <span class="ps-product__title">Red Velvet Cheese Tart</span>
                      <!-- <p>
                        <span>350g</span>
                        <span>30 Min</span>
                        <span>120 <sup>o</sup>C</span>
                      </p> -->

                      <span class="ps-product__price">৳320</span>

                    </div>

                                           <div class="ps-product__shopping">
                        
                          <div class="button">
                            <button class="ps-btn ps-product__add-to-cart" onclick="addToCart('107')">Quick Add</button>
                          </div>

                          <a class="ps-btn ps-product__add-to-cart" href="product-detailsfe09.html?tokenOfLove=107">Order</a>
                                                 <!-- <div class="ps-product__actions">
                       <a href="javascript:void(0);"><i class="fa fa-heart-o"></i></a>
                       <a href="javascript:void(0);"><i class="fa fa-random"></i></a>
                   </div> -->

                      </div>
                                       </div>
                </div>
              </div>

                           <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-6 ">
                <div class="ps-product">
                  <div class="ps-product__thumbnail"><img src="{{ asset('lakeshore_bakery') }}/frontend/assets/erp/images/16328996210132.png" alt="Croissant Box" />
                    <!-- <a class="ps-product__overlay" href="product-default.html"></a> -->
                                           <span class="ps-badge ps-badge--sale text-center"><i style="font-size:10px !important;">Pre Orders <br>Only</i></span>
                                       </div>
                  <div class="ps-product__content">
                    <div class="ps-product__desc">
                      <span class="ps-product__title">Croissant Box</span>
                      <!-- <p>
                        <span>350g</span>
                        <span>30 Min</span>
                        <span>120 <sup>o</sup>C</span>
                      </p> -->

                      <span class="ps-product__price">৳370</span>

                    </div>

                                           <div class="ps-product__shopping">
                        
                          <div class="button">
                            <button class="ps-btn ps-product__add-to-cart" onclick="addToCart('64')">Quick Add</button>
                          </div>

                          <a class="ps-btn ps-product__add-to-cart" href="product-details40c3.html?tokenOfLove=64">Order</a>
                                                 <!-- <div class="ps-product__actions">
                       <a href="javascript:void(0);"><i class="fa fa-heart-o"></i></a>
                       <a href="javascript:void(0);"><i class="fa fa-random"></i></a>
                   </div> -->

                      </div>
                                       </div>
                </div>
              </div>

                           <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-6 ">
                <div class="ps-product">
                  <div class="ps-product__thumbnail"><img src="{{ asset('lakeshore_bakery') }}/frontend/assets/erp/images/170049287337730.png" alt="Tuna Croissant" />
                    <!-- <a class="ps-product__overlay" href="product-default.html"></a> -->
                                           <span class="ps-badge ps-badge--sale text-center"><i style="font-size:10px !important;">Pre Orders <br>Only</i></span>
                                       </div>
                  <div class="ps-product__content">
                    <div class="ps-product__desc">
                      <span class="ps-product__title">Tuna Croissant</span>
                      <!-- <p>
                        <span>350g</span>
                        <span>30 Min</span>
                        <span>120 <sup>o</sup>C</span>
                      </p> -->

                      <span class="ps-product__price">৳250</span>

                    </div>

                                           <div class="ps-product__shopping">
                        
                          <div class="button">
                            <button class="ps-btn ps-product__add-to-cart" onclick="addToCart('190')">Quick Add</button>
                          </div>

                          <a class="ps-btn ps-product__add-to-cart" href="product-details83e8.html?tokenOfLove=190">Order</a>
                                                 <!-- <div class="ps-product__actions">
                       <a href="javascript:void(0);"><i class="fa fa-heart-o"></i></a>
                       <a href="javascript:void(0);"><i class="fa fa-random"></i></a>
                   </div> -->

                      </div>
                                       </div>
                </div>
              </div>

                           <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-6 ">
                <div class="ps-product">
                  <div class="ps-product__thumbnail"><img src="{{ asset('lakeshore_bakery') }}/frontend/assets/erp/images/16321177439732.png" alt="Soft Dinner Roll" />
                    <!-- <a class="ps-product__overlay" href="product-default.html"></a> -->
                                           <span class="ps-badge ps-badge--sale text-center"><i style="font-size:10px !important;">Pre Orders <br>Only</i></span>
                                       </div>
                  <div class="ps-product__content">
                    <div class="ps-product__desc">
                      <span class="ps-product__title">Soft Dinner Roll</span>
                      <!-- <p>
                        <span>350g</span>
                        <span>30 Min</span>
                        <span>120 <sup>o</sup>C</span>
                      </p> -->

                      <span class="ps-product__price">৳140</span>

                    </div>

                                           <div class="ps-product__shopping">
                        
                          <div class="button">
                            <button class="ps-btn ps-product__add-to-cart" onclick="addToCart('40')">Quick Add</button>
                          </div>

                          <a class="ps-btn ps-product__add-to-cart" href="product-detailsa18a.html?tokenOfLove=40">Order</a>
                                                 <!-- <div class="ps-product__actions">
                       <a href="javascript:void(0);"><i class="fa fa-heart-o"></i></a>
                       <a href="javascript:void(0);"><i class="fa fa-random"></i></a>
                   </div> -->

                      </div>
                                       </div>
                </div>
              </div>

                           <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-6 ">
                <div class="ps-product">
                  <div class="ps-product__thumbnail"><img src="{{ asset('lakeshore_bakery') }}/frontend/assets/erp/images/16509576395142.png" alt="Assorted Brownies" />
                    <!-- <a class="ps-product__overlay" href="product-default.html"></a> -->
                                           <span class="ps-badge ps-badge--sale text-center"><i style="font-size:10px !important;">Pre Orders <br>Only</i></span>
                                       </div>
                  <div class="ps-product__content">
                    <div class="ps-product__desc">
                      <span class="ps-product__title">Assorted Brownies</span>
                      <!-- <p>
                        <span>350g</span>
                        <span>30 Min</span>
                        <span>120 <sup>o</sup>C</span>
                      </p> -->

                      <span class="ps-product__price">৳900</span>

                    </div>

                                           <div class="ps-product__shopping">
                        
                          <div class="button">
                            <button class="ps-btn ps-product__add-to-cart" onclick="addToCart('101')">Quick Add</button>
                          </div>

                          <a class="ps-btn ps-product__add-to-cart" href="product-details2543.html?tokenOfLove=101">Order</a>
                                                 <!-- <div class="ps-product__actions">
                       <a href="javascript:void(0);"><i class="fa fa-heart-o"></i></a>
                       <a href="javascript:void(0);"><i class="fa fa-random"></i></a>
                   </div> -->

                      </div>
                                       </div>
                </div>
              </div>

                           <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-6 ">
                <div class="ps-product">
                  <div class="ps-product__thumbnail"><img src="{{ asset('lakeshore_bakery') }}/frontend/assets/erp/images/16510490986972.png" alt="Nutella Stuffed Berliner" />
                    <!-- <a class="ps-product__overlay" href="product-default.html"></a> -->
                                           <span class="ps-badge ps-badge--sale text-center"><i style="font-size:10px !important;">Pre Orders <br>Only</i></span>
                                       </div>
                  <div class="ps-product__content">
                    <div class="ps-product__desc">
                      <span class="ps-product__title">Nutella Stuffed Berliner</span>
                      <!-- <p>
                        <span>350g</span>
                        <span>30 Min</span>
                        <span>120 <sup>o</sup>C</span>
                      </p> -->

                      <span class="ps-product__price">৳900</span>

                    </div>

                                           <div class="ps-product__shopping">
                        
                          <div class="button">
                            <button class="ps-btn ps-product__add-to-cart" onclick="addToCart('103')">Quick Add</button>
                          </div>

                          <a class="ps-btn ps-product__add-to-cart" href="product-detailsc1b3.html?tokenOfLove=103">Order</a>
                                                 <!-- <div class="ps-product__actions">
                       <a href="javascript:void(0);"><i class="fa fa-heart-o"></i></a>
                       <a href="javascript:void(0);"><i class="fa fa-random"></i></a>
                   </div> -->

                      </div>
                                       </div>
                </div>
              </div>

                           <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-6 ">
                <div class="ps-product">
                  <div class="ps-product__thumbnail"><img src="{{ asset('lakeshore_bakery') }}/frontend/assets/erp/images/16512990885412.png" alt="Chicken Patties" />
                    <!-- <a class="ps-product__overlay" href="product-default.html"></a> -->
                                           <span class="ps-badge ps-badge--sale text-center"><i style="font-size:10px !important;">Pre Orders <br>Only</i></span>
                                       </div>
                  <div class="ps-product__content">
                    <div class="ps-product__desc">
                      <span class="ps-product__title">Chicken Patties</span>
                      <!-- <p>
                        <span>350g</span>
                        <span>30 Min</span>
                        <span>120 <sup>o</sup>C</span>
                      </p> -->

                      <span class="ps-product__price">৳350</span>

                    </div>

                                           <div class="ps-product__shopping">
                        
                          <div class="button">
                            <button class="ps-btn ps-product__add-to-cart" onclick="addToCart('104')">Quick Add</button>
                          </div>

                          <a class="ps-btn ps-product__add-to-cart" href="product-details216a.html?tokenOfLove=104">Order</a>
                                                 <!-- <div class="ps-product__actions">
                       <a href="javascript:void(0);"><i class="fa fa-heart-o"></i></a>
                       <a href="javascript:void(0);"><i class="fa fa-random"></i></a>
                   </div> -->

                      </div>
                                       </div>
                </div>
              </div>

                           <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-6 ">
                <div class="ps-product">
                  <div class="ps-product__thumbnail"><img src="{{ asset('lakeshore_bakery') }}/frontend/assets/erp/images/16512998278322.png" alt="Sausage Roll" />
                    <!-- <a class="ps-product__overlay" href="product-default.html"></a> -->
                                           <span class="ps-badge ps-badge--sale text-center"><i style="font-size:10px !important;">Pre Orders <br>Only</i></span>
                                       </div>
                  <div class="ps-product__content">
                    <div class="ps-product__desc">
                      <span class="ps-product__title">Sausage Roll</span>
                      <!-- <p>
                        <span>350g</span>
                        <span>30 Min</span>
                        <span>120 <sup>o</sup>C</span>
                      </p> -->

                      <span class="ps-product__price">৳80</span>

                    </div>

                                           <div class="ps-product__shopping">
                        
                          <div class="button">
                            <button class="ps-btn ps-product__add-to-cart" onclick="addToCart('106')">Quick Add</button>
                          </div>

                          <a class="ps-btn ps-product__add-to-cart" href="product-details28fc.html?tokenOfLove=106">Order</a>
                                                 <!-- <div class="ps-product__actions">
                       <a href="javascript:void(0);"><i class="fa fa-heart-o"></i></a>
                       <a href="javascript:void(0);"><i class="fa fa-random"></i></a>
                   </div> -->

                      </div>
                                       </div>
                </div>
              </div>

                           <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-6 ">
                <div class="ps-product">
                  <div class="ps-product__thumbnail"><img src="{{ asset('lakeshore_bakery') }}/frontend/assets/erp/images/16549309969072.png" alt="Macaron" />
                    <!-- <a class="ps-product__overlay" href="product-default.html"></a> -->
                                           <span class="ps-badge ps-badge--sale text-center"><i style="font-size:10px !important;">Pre Orders <br>Only</i></span>
                                       </div>
                  <div class="ps-product__content">
                    <div class="ps-product__desc">
                      <span class="ps-product__title">Macaron</span>
                      <!-- <p>
                        <span>350g</span>
                        <span>30 Min</span>
                        <span>120 <sup>o</sup>C</span>
                      </p> -->

                      <span class="ps-product__price">৳600</span>

                    </div>

                                           <div class="ps-product__shopping">
                                                   <a class="ps-btn ps-product__add-to-cart col-md-12" href="product-details234a.html?tokenOfLove=114">Order</a>
                                                 <!-- <div class="ps-product__actions">
                       <a href="javascript:void(0);"><i class="fa fa-heart-o"></i></a>
                       <a href="javascript:void(0);"><i class="fa fa-random"></i></a>
                   </div> -->

                      </div>
                                       </div>
                </div>
              </div>

                           <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-6 ">
                <div class="ps-product">
                  <div class="ps-product__thumbnail"><img src="{{ asset('lakeshore_bakery') }}/frontend/assets/erp/images/16861232139151.png" alt="Chana Balushai" />
                    <!-- <a class="ps-product__overlay" href="product-default.html"></a> -->
                                           <span class="ps-badge ps-badge--sale text-center"><i style="font-size:10px !important;">Pre Orders <br>Only</i></span>
                                       </div>
                  <div class="ps-product__content">
                    <div class="ps-product__desc">
                      <span class="ps-product__title">Chana Balushai</span>
                      <!-- <p>
                        <span>350g</span>
                        <span>30 Min</span>
                        <span>120 <sup>o</sup>C</span>
                      </p> -->

                      <span class="ps-product__price">৳950</span>

                    </div>

                                           <div class="ps-product__shopping">
                        
                          <div class="button">
                            <button class="ps-btn ps-product__add-to-cart" onclick="addToCart('167')">Quick Add</button>
                          </div>

                          <a class="ps-btn ps-product__add-to-cart" href="product-details84c3.html?tokenOfLove=167">Order</a>
                                                 <!-- <div class="ps-product__actions">
                       <a href="javascript:void(0);"><i class="fa fa-heart-o"></i></a>
                       <a href="javascript:void(0);"><i class="fa fa-random"></i></a>
                   </div> -->

                      </div>
                                       </div>
                </div>
              </div>

                           <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-6 ">
                <div class="ps-product">
                  <div class="ps-product__thumbnail"><img src="{{ asset('lakeshore_bakery') }}/frontend/assets/erp/images/16861230005111.png" alt="Cream Jam" />
                    <!-- <a class="ps-product__overlay" href="product-default.html"></a> -->
                                           <span class="ps-badge ps-badge--sale text-center"><i style="font-size:10px !important;">Pre Orders <br>Only</i></span>
                                       </div>
                  <div class="ps-product__content">
                    <div class="ps-product__desc">
                      <span class="ps-product__title">Cream Jam</span>
                      <!-- <p>
                        <span>350g</span>
                        <span>30 Min</span>
                        <span>120 <sup>o</sup>C</span>
                      </p> -->

                      <span class="ps-product__price">৳1100</span>

                    </div>

                                           <div class="ps-product__shopping">
                        
                          <div class="button">
                            <button class="ps-btn ps-product__add-to-cart" onclick="addToCart('165')">Quick Add</button>
                          </div>

                          <a class="ps-btn ps-product__add-to-cart" href="product-details35a4.html?tokenOfLove=165">Order</a>
                                                 <!-- <div class="ps-product__actions">
                       <a href="javascript:void(0);"><i class="fa fa-heart-o"></i></a>
                       <a href="javascript:void(0);"><i class="fa fa-random"></i></a>
                   </div> -->

                      </div>
                                       </div>
                </div>
              </div>

                           <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-6 ">
                <div class="ps-product">
                  <div class="ps-product__thumbnail"><img src="{{ asset('lakeshore_bakery') }}/frontend/assets/erp/images/169961868494330.png" alt="Gurer Sondesh" />
                    <!-- <a class="ps-product__overlay" href="product-default.html"></a> -->
                                           <span class="ps-badge ps-badge--sale text-center"><i style="font-size:10px !important;">Pre Orders <br>Only</i></span>
                                       </div>
                  <div class="ps-product__content">
                    <div class="ps-product__desc">
                      <span class="ps-product__title">Gurer Sondesh</span>
                      <!-- <p>
                        <span>350g</span>
                        <span>30 Min</span>
                        <span>120 <sup>o</sup>C</span>
                      </p> -->

                      <span class="ps-product__price">৳800</span>

                    </div>

                                           <div class="ps-product__shopping">
                                                   <a class="ps-btn ps-product__add-to-cart col-md-12" href="product-detailsb7d1.html?tokenOfLove=187">Order</a>
                                                 <!-- <div class="ps-product__actions">
                       <a href="javascript:void(0);"><i class="fa fa-heart-o"></i></a>
                       <a href="javascript:void(0);"><i class="fa fa-random"></i></a>
                   </div> -->

                      </div>
                                       </div>
                </div>
              </div>

                           <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-6 ">
                <div class="ps-product">
                  <div class="ps-product__thumbnail"><img src="{{ asset('lakeshore_bakery') }}/frontend/assets/erp/images/16861203969361.png" alt="Irani Voog" />
                    <!-- <a class="ps-product__overlay" href="product-default.html"></a> -->
                                           <span class="ps-badge ps-badge--sale text-center"><i style="font-size:10px !important;">Pre Orders <br>Only</i></span>
                                       </div>
                  <div class="ps-product__content">
                    <div class="ps-product__desc">
                      <span class="ps-product__title">Irani Voog</span>
                      <!-- <p>
                        <span>350g</span>
                        <span>30 Min</span>
                        <span>120 <sup>o</sup>C</span>
                      </p> -->

                      <span class="ps-product__price">৳1380</span>

                    </div>

                                           <div class="ps-product__shopping">
                        
                          <div class="button">
                            <button class="ps-btn ps-product__add-to-cart" onclick="addToCart('151')">Quick Add</button>
                          </div>

                          <a class="ps-btn ps-product__add-to-cart" href="product-details378e.html?tokenOfLove=151">Order</a>
                                                 <!-- <div class="ps-product__actions">
                       <a href="javascript:void(0);"><i class="fa fa-heart-o"></i></a>
                       <a href="javascript:void(0);"><i class="fa fa-random"></i></a>
                   </div> -->

                      </div>
                                       </div>
                </div>
              </div>

                           <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-6 ">
                <div class="ps-product">
                  <div class="ps-product__thumbnail"><img src="{{ asset('lakeshore_bakery') }}/frontend/assets/erp/images/16861236850901.png" alt="Kaju Barfi" />
                    <!-- <a class="ps-product__overlay" href="product-default.html"></a> -->
                                           <span class="ps-badge ps-badge--sale text-center"><i style="font-size:10px !important;">Pre Orders <br>Only</i></span>
                                       </div>
                  <div class="ps-product__content">
                    <div class="ps-product__desc">
                      <span class="ps-product__title">Kaju Barfi</span>
                      <!-- <p>
                        <span>350g</span>
                        <span>30 Min</span>
                        <span>120 <sup>o</sup>C</span>
                      </p> -->

                      <span class="ps-product__price">৳2600</span>

                    </div>

                                           <div class="ps-product__shopping">
                        
                          <div class="button">
                            <button class="ps-btn ps-product__add-to-cart" onclick="addToCart('169')">Quick Add</button>
                          </div>

                          <a class="ps-btn ps-product__add-to-cart" href="product-details8659.html?tokenOfLove=169">Order</a>
                                                 <!-- <div class="ps-product__actions">
                       <a href="javascript:void(0);"><i class="fa fa-heart-o"></i></a>
                       <a href="javascript:void(0);"><i class="fa fa-random"></i></a>
                   </div> -->

                      </div>
                                       </div>
                </div>
              </div>

                           <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-6 ">
                <div class="ps-product">
                  <div class="ps-product__thumbnail"><img src="{{ asset('lakeshore_bakery') }}/frontend/assets/erp/images/170123622297930.png" alt="Kalo Jam" />
                    <!-- <a class="ps-product__overlay" href="product-default.html"></a> -->
                                           <span class="ps-badge ps-badge--sale text-center"><i style="font-size:10px !important;">Pre Orders <br>Only</i></span>
                                       </div>
                  <div class="ps-product__content">
                    <div class="ps-product__desc">
                      <span class="ps-product__title">Kalo Jam</span>
                      <!-- <p>
                        <span>350g</span>
                        <span>30 Min</span>
                        <span>120 <sup>o</sup>C</span>
                      </p> -->

                      <span class="ps-product__price">৳900</span>

                    </div>

                                           <div class="ps-product__shopping">
                        
                          <div class="button">
                            <button class="ps-btn ps-product__add-to-cart" onclick="addToCart('161')">Quick Add</button>
                          </div>

                          <a class="ps-btn ps-product__add-to-cart" href="product-details606a.html?tokenOfLove=161">Order</a>
                                                 <!-- <div class="ps-product__actions">
                       <a href="javascript:void(0);"><i class="fa fa-heart-o"></i></a>
                       <a href="javascript:void(0);"><i class="fa fa-random"></i></a>
                   </div> -->

                      </div>
                                       </div>
                </div>
              </div>

                           <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-6 ">
                <div class="ps-product">
                  <div class="ps-product__thumbnail"><img src="{{ asset('lakeshore_bakery') }}/frontend/assets/erp/images/170123565227130.png" alt="Lal Chomchom" />
                    <!-- <a class="ps-product__overlay" href="product-default.html"></a> -->
                                           <span class="ps-badge ps-badge--sale text-center"><i style="font-size:10px !important;">Pre Orders <br>Only</i></span>
                                       </div>
                  <div class="ps-product__content">
                    <div class="ps-product__desc">
                      <span class="ps-product__title">Lal Chomchom</span>
                      <!-- <p>
                        <span>350g</span>
                        <span>30 Min</span>
                        <span>120 <sup>o</sup>C</span>
                      </p> -->

                      <span class="ps-product__price">৳900</span>

                    </div>

                                           <div class="ps-product__shopping">
                        
                          <div class="button">
                            <button class="ps-btn ps-product__add-to-cart" onclick="addToCart('155')">Quick Add</button>
                          </div>

                          <a class="ps-btn ps-product__add-to-cart" href="product-details700a.html?tokenOfLove=155">Order</a>
                                                 <!-- <div class="ps-product__actions">
                       <a href="javascript:void(0);"><i class="fa fa-heart-o"></i></a>
                       <a href="javascript:void(0);"><i class="fa fa-random"></i></a>
                   </div> -->

                      </div>
                                       </div>
                </div>
              </div>

                           <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-6 ">
                <div class="ps-product">
                  <div class="ps-product__thumbnail"><img src="{{ asset('lakeshore_bakery') }}/frontend/assets/erp/images/16861240442781.png" alt="Motichur Laddu" />
                    <!-- <a class="ps-product__overlay" href="product-default.html"></a> -->
                                           <span class="ps-badge ps-badge--sale text-center"><i style="font-size:10px !important;">Pre Orders <br>Only</i></span>
                                       </div>
                  <div class="ps-product__content">
                    <div class="ps-product__desc">
                      <span class="ps-product__title">Motichur Laddu</span>
                      <!-- <p>
                        <span>350g</span>
                        <span>30 Min</span>
                        <span>120 <sup>o</sup>C</span>
                      </p> -->

                      <span class="ps-product__price">৳800</span>

                    </div>

                                           <div class="ps-product__shopping">
                        
                          <div class="button">
                            <button class="ps-btn ps-product__add-to-cart" onclick="addToCart('171')">Quick Add</button>
                          </div>

                          <a class="ps-btn ps-product__add-to-cart" href="product-details53fe.html?tokenOfLove=171">Order</a>
                                                 <!-- <div class="ps-product__actions">
                       <a href="javascript:void(0);"><i class="fa fa-heart-o"></i></a>
                       <a href="javascript:void(0);"><i class="fa fa-random"></i></a>
                   </div> -->

                      </div>
                                       </div>
                </div>
              </div>

                           <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-6 ">
                <div class="ps-product">
                  <div class="ps-product__thumbnail"><img src="{{ asset('lakeshore_bakery') }}/frontend/assets/erp/images/168794983592930.png" alt="Rasmalai" />
                    <!-- <a class="ps-product__overlay" href="product-default.html"></a> -->
                                           <span class="ps-badge ps-badge--sale text-center"><i style="font-size:10px !important;">Pre Orders <br>Only</i></span>
                                       </div>
                  <div class="ps-product__content">
                    <div class="ps-product__desc">
                      <span class="ps-product__title">Rasmalai</span>
                      <!-- <p>
                        <span>350g</span>
                        <span>30 Min</span>
                        <span>120 <sup>o</sup>C</span>
                      </p> -->

                      <span class="ps-product__price">৳800</span>

                    </div>

                                           <div class="ps-product__shopping">
                        
                          <div class="button">
                            <button class="ps-btn ps-product__add-to-cart" onclick="addToCart('177')">Quick Add</button>
                          </div>

                          <a class="ps-btn ps-product__add-to-cart" href="product-details4d45.html?tokenOfLove=177">Order</a>
                                                 <!-- <div class="ps-product__actions">
                       <a href="javascript:void(0);"><i class="fa fa-heart-o"></i></a>
                       <a href="javascript:void(0);"><i class="fa fa-random"></i></a>
                   </div> -->

                      </div>
                                       </div>
                </div>
              </div>

                           <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-6 ">
                <div class="ps-product">
                  <div class="ps-product__thumbnail"><img src="{{ asset('lakeshore_bakery') }}/frontend/assets/erp/images/16861207125371.png" alt="Rosh Golla" />
                    <!-- <a class="ps-product__overlay" href="product-default.html"></a> -->
                                           <span class="ps-badge ps-badge--sale text-center"><i style="font-size:10px !important;">Pre Orders <br>Only</i></span>
                                       </div>
                  <div class="ps-product__content">
                    <div class="ps-product__desc">
                      <span class="ps-product__title">Rosh Golla</span>
                      <!-- <p>
                        <span>350g</span>
                        <span>30 Min</span>
                        <span>120 <sup>o</sup>C</span>
                      </p> -->

                      <span class="ps-product__price">৳800</span>

                    </div>

                                           <div class="ps-product__shopping">
                        
                          <div class="button">
                            <button class="ps-btn ps-product__add-to-cart" onclick="addToCart('153')">Quick Add</button>
                          </div>

                          <a class="ps-btn ps-product__add-to-cart" href="product-detailsdedd.html?tokenOfLove=153">Order</a>
                                                 <!-- <div class="ps-product__actions">
                       <a href="javascript:void(0);"><i class="fa fa-heart-o"></i></a>
                       <a href="javascript:void(0);"><i class="fa fa-random"></i></a>
                   </div> -->

                      </div>
                                       </div>
                </div>
              </div>

                           <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-6 ">
                <div class="ps-product">
                  <div class="ps-product__thumbnail"><img src="{{ asset('lakeshore_bakery') }}/frontend/assets/erp/images/170123573018530.png" alt="Shor Roll" />
                    <!-- <a class="ps-product__overlay" href="product-default.html"></a> -->
                                           <span class="ps-badge ps-badge--sale text-center"><i style="font-size:10px !important;">Pre Orders <br>Only</i></span>
                                       </div>
                  <div class="ps-product__content">
                    <div class="ps-product__desc">
                      <span class="ps-product__title">Shor Roll</span>
                      <!-- <p>
                        <span>350g</span>
                        <span>30 Min</span>
                        <span>120 <sup>o</sup>C</span>
                      </p> -->

                      <span class="ps-product__price">৳650</span>

                    </div>

                                           <div class="ps-product__shopping">
                                                   <a class="ps-btn ps-product__add-to-cart col-md-12" href="product-detailsdced.html?tokenOfLove=159">Order</a>
                                                 <!-- <div class="ps-product__actions">
                       <a href="javascript:void(0);"><i class="fa fa-heart-o"></i></a>
                       <a href="javascript:void(0);"><i class="fa fa-random"></i></a>
                   </div> -->

                      </div>
                                       </div>
                </div>
              </div>

                           <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-6 ">
                <div class="ps-product">
                  <div class="ps-product__thumbnail"><img src="{{ asset('lakeshore_bakery') }}/frontend/assets/erp/images/170123646139730.png" alt="Sweet Sour Youghurt" />
                    <!-- <a class="ps-product__overlay" href="product-default.html"></a> -->
                                           <span class="ps-badge ps-badge--sale text-center"><i style="font-size:10px !important;">Pre Orders <br>Only</i></span>
                                       </div>
                  <div class="ps-product__content">
                    <div class="ps-product__desc">
                      <span class="ps-product__title">Sweet Sour Youghurt</span>
                      <!-- <p>
                        <span>350g</span>
                        <span>30 Min</span>
                        <span>120 <sup>o</sup>C</span>
                      </p> -->

                      <span class="ps-product__price">৳130</span>

                    </div>

                                           <div class="ps-product__shopping">
                                                   <a class="ps-btn ps-product__add-to-cart col-md-12" href="product-details35e3.html?tokenOfLove=175">Order</a>
                                                 <!-- <div class="ps-product__actions">
                       <a href="javascript:void(0);"><i class="fa fa-heart-o"></i></a>
                       <a href="javascript:void(0);"><i class="fa fa-random"></i></a>
                   </div> -->

                      </div>
                                       </div>
                </div>
              </div>

                           <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-6 ">
                <div class="ps-product">
                  <div class="ps-product__thumbnail"><img src="{{ asset('lakeshore_bakery') }}/frontend/assets/erp/images/16861197991231.png" alt="Tounge Toast" />
                    <!-- <a class="ps-product__overlay" href="product-default.html"></a> -->
                                           <span class="ps-badge ps-badge--sale text-center"><i style="font-size:10px !important;">Pre Orders <br>Only</i></span>
                                       </div>
                  <div class="ps-product__content">
                    <div class="ps-product__desc">
                      <span class="ps-product__title">Tounge Toast</span>
                      <!-- <p>
                        <span>350g</span>
                        <span>30 Min</span>
                        <span>120 <sup>o</sup>C</span>
                      </p> -->

                      <span class="ps-product__price">৳775</span>

                    </div>

                                           <div class="ps-product__shopping">
                                                   <a class="ps-btn ps-product__add-to-cart col-md-12" href="product-details20d0.html?tokenOfLove=149">Order</a>
                                                 <!-- <div class="ps-product__actions">
                       <a href="javascript:void(0);"><i class="fa fa-heart-o"></i></a>
                       <a href="javascript:void(0);"><i class="fa fa-random"></i></a>
                   </div> -->

                      </div>
                                       </div>
                </div>
              </div>

                           <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-6 ">
                <div class="ps-product">
                  <div class="ps-product__thumbnail"><img src="{{ asset('lakeshore_bakery') }}/frontend/assets/erp/images/16861233504711.png" alt="Kaju Barfi" />
                    <!-- <a class="ps-product__overlay" href="product-default.html"></a> -->
                                           <span class="ps-badge ps-badge--sale text-center"><i style="font-size:10px !important;">Pre Orders <br>Only</i></span>
                                       </div>
                  <div class="ps-product__content">
                    <div class="ps-product__desc">
                      <span class="ps-product__title">Kaju Barfi</span>
                      <!-- <p>
                        <span>350g</span>
                        <span>30 Min</span>
                        <span>120 <sup>o</sup>C</span>
                      </p> -->

                      <span class="ps-product__price">৳1100</span>

                    </div>

                                           <div class="ps-product__shopping">
                        
                          <div class="button">
                            <button class="ps-btn ps-product__add-to-cart" onclick="addToCart('168')">Quick Add</button>
                          </div>

                          <a class="ps-btn ps-product__add-to-cart" href="product-detailsf89c.html?tokenOfLove=168">Order</a>
                                                 <!-- <div class="ps-product__actions">
                       <a href="javascript:void(0);"><i class="fa fa-heart-o"></i></a>
                       <a href="javascript:void(0);"><i class="fa fa-random"></i></a>
                   </div> -->

                      </div>
                                       </div>
                </div>
              </div>

                       </div>
        </div>
        <!-- <div class="ps-pagination">
         <ul class="pagination">
           <li><a href="javascript:void(0);"><i class="fa fa-caret-left"></i></a></li>
           <li class="active"><a href="javascript:void(0);">1</a></li>
           <li><a href="javascript:void(0);">2</a></li>
           <li><a href="javascript:void(0);">3</a></li>
           <li><a href="javascript:void(0);"><i class="fa fa-caret-right"></i></a></li>
         </ul>
       </div> -->
      </div>
    </div>
  </div>

  @endsection