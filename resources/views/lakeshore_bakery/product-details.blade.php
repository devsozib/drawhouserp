@extends('lakeshore_bakery.layouts.master')
@section('content')

<div class="ps-page ps-page--product-detail">
    <div class="ps-hero ps-hero--shopping bg--cover" data-background="{{ asset('lakeshore_bakery') }}/frontend/assets/img/hero/shop-hero.png">
      <div class="ps-hero__container">
        <div class="ps-breadcrumb">
          <ul class="breadcrumb">
            <li><a href="productb87b.html?type=PreOrder">
                <b>
                  Pre Order
                 </b>
              </a></li>
            <li>
              <a href="product159c.html?type=PreOrder&amp;subCategory=3">
                <b>
                  Pastry 
                </b>
              </a>
            </li>

          </ul>
        </div>

      </div>
    </div>
    <div class="container">
      <div class="ps-product--detail" style="padding-top: 40px;">
        <div class="ps-product__header">
          <div class="ps-product__thumbnail" data-vertical="false">
            <figure>
              <div class="ps-wrapper">
                <div class="ps-product__gallery" data-arrow="false">
                  <div class="item"><img src="{{ asset('lakeshore_bakery') }}/frontend/assets/erp/images/168836606176230.png" alt=""></div>
                </div>
              </div>
            </figure>
          </div>
          <div class="ps-product__info">
            <h1>Assorted Pastry Box</h1>
            <input type="hidden" value=178 id="productId">
            <h4 class="ps-product__price sale" id="productPriceHolder">
              ৳1300
            </h4>
            <div class="ps-product__desc">
              <p style="font-weight: unset; color: black">
              </p>
            </div>
            <div class="ps-product__specification">
              <p><strong>AVAILABILITY:</strong>In Stock </p>
              <p><strong>CATEGORIES:</strong>

                <a href="product9ebc.html?type=1&amp;subCategory=3">
                  <b>
                    Pastry </b>
                </a>
              </p>
            </div>
            <div class="ps-product__shopping">
              <select class="ps-select" id="sizeSelector" title="Choose Size"
                onchange="getProductOtionDetailsFromSizeId(this.value);">
                <option value="229">
                  4pcs Box</option>
                <option value="230">
                  6pcs Box</option>
              </select>
            </div>
          </div>

        </div>
      </div>
    </div>
  </div>
  </div>
  <div class="row" id="productOptionDivRow" style="padding-bottom: 50px; max-width: 100%;">
    <div class="container col-md-10 text-center" id="productOptionDiv" style="padding: 2px 0px 5px 25px;">

      <!-- end div -->
    </div>
  </div>
  <div class="ps-product__info">
    <div class="ps product__shopping">
      <div class="ro" style="padding:20px;">
        <div class="col-md-6 col-lg-4 col-sm-12 col-xs-12 divCenter">
          <div class="form-group--number">
            <button class="up"></button>
            <button class="down"></button>
            <input class="form-control quantity__input" value="1" type="number" min="1" id="orderQuantity"
              placeholder="1">
          </div>
        </div>
        <div class="col-md-6 col-lg-4 col-sm-12 col-xs-12 text-center divCenter">
          <a class="ps-btn btn-block" href="javascript:void(0)" onclick="addAllToCart()">Order now</a>
        </div>
      </div>
    </div>
  </div>
  </div>
  </div>

  @endsection