
@extends('frontend.layouts.master')
@section('content')
<style>
    <style>
        body {
            text-align: center;
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            font-family: 'Lato', sans-serif;
        }

        h5,
        h6 {
            font-size: small;
        }

        ul {
            list-style-type: none;
        }

        li {
            display: inline-block;
            margin-left: 15px;
            margin-right: 15px;
        }

        input[type="checkbox"] {
            display: none;
            border: 1px solid black;
        }

        input[type="radio"] {
            display: none;
            border: 1px solid black;
        }

        label {
            border: 1px solid #000;
            padding: 10px;
            display: block;
            position: relative;
            margin: 10px;
            cursor: pointer;
            padding-top: 25px;
            padding-bottom: 65px;
        }

        label:before {
            /* background-color: white;
            color: white; */
            content: " ";
            display: block;
            border-radius: 50%;
            border: 1px solid grey;
            position: absolute;
            top: -5px;
            left: -5px;
            width: 25px;
            height: 25px;
            text-align: center;
            line-height: 28px;
            transition-duration: 0.4s;
            transform: scale(0);
        }

        label img {
            height: 100px;
            width: 100px;
            transition-duration: 0.2s;
            transform-origin: 50% 50%;
        }

        :checked+label {
            border-color: #ddd;
            background: #FF8B2A;
            transition-duration: 0.4s;
        }

        :checked+label:before {
            content: "✓" !important;
            /* background-color: grey; */
            transform: scale(1);
        }

        :checked+label img {
            transform: scale(0.9);
            /* box-shadow: 0 0 5px #333; */
            z-index: -1;
        }

        .customRadio {
            /* height: 185px; */
            padding: 10px;
            margin-left: 5px;
        }

        .customRadio> :first-child {
            margin-left: 0px;
        }

        .optionsHolderDivCatcher {
            /* padding-left: unset; */
            /* margin-left: 5px; */
            font-size: small;
            justify-content: center;


        }

        .col-sm-4 {
            width: unset;
        }

        .productOptionDivFIx {
            justify-content: center;
            margin-right: auto;
        }

        .quantity {
            justify-content: center;
        }

        @media only screen and (max-width: 600px) {
            .customRadio {
                margin-left: 0px;
            }

            .col-sm-4 {
                width: 50% !important;
                margin-left: -7px;
                margin-right: unset;
                /* justify-content: center; */
            }

            .col-md-4 {
                width: 50%;
                justify-content: center;
            }

            #optionHolderDiv,
            .optionTitleDivForCenter {
                justify-content: center;
            }

            .optionsHolderDivCatcher {
                padding-left: unset;
                /* margin-left: 5px; */
                font-size: small;

            }

            .productOptionDivFIx {
                justify-content: center;
                margin-right: auto;
            }

            .quantity {
                justify-content: center;
            }
        }





        /* [type="checkbox"]:checked+label:after {
            background: #FF8B2A;
        } */


        /* -- quantity box -- */

        /* .quantity {
            display: inline-block;
        }

        .quantity .input-text.qty {
            width: 35px;
            height: 39px;
            padding: 0 5px;
            text-align: center;
            background-color: transparent;
            border: 1px solid #efefef;
        }

        .quantity.buttons_added {
            text-align: left;
            position: relative;
            white-space: nowrap;
            vertical-align: top;
        }

        .quantity.buttons_added input {
            display: inline-block;
            margin: 0;
            vertical-align: top;
            box-shadow: none;
        }

        .quantity.buttons_added .minus,
        .quantity.buttons_added .plus {
            padding: 7px 10px 8px;
            height: 41px;
            background-color: #ffffff;
            border: 1px solid #efefef;
            cursor: pointer;
        }

        .quantity.buttons_added .minus {
            border-right: 0;
        }

        .quantity.buttons_added .plus {
            border-left: 0;
        }

        .quantity.buttons_added .minus:hover,
        .quantity.buttons_added .plus:hover {
            background: #eeeeee;
        }

        .quantity input::-webkit-outer-spin-button,
        .quantity input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            -moz-appearance: none;
            margin: 0;
        }

        .quantity.buttons_added .minus:focus,
        .quantity.buttons_added .plus:focus {
            outline: none;
        } */

        
    </style>
</style>
<style>
    .custom-toast {
    position: fixed;
    top: 20px;
    right: 20px;
    z-index: 9999;
    max-width: 300px;
    border-radius: 4px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
    animation: slide-in 0.5s ease-in-out, fade-out 0.5s 2.5s ease-in-out forwards;
    }

    .alert-content {
        padding: 0px 15px;
        color: #fff;
        font-size: 11px;
    }

    .custom-toast.alert-success {
        background-color: #5cb85c;
    }

    /* Animation keyframes */
    @keyframes slide-in {
        from {
            transform: translateX(100%);
        }
        to {
            transform: translateX(0);
        }
    }

    @keyframes fade-out {
        from {
            opacity: 1;
        }
        to {
            opacity: 0;
        }
    }
</style>
<div class="hero owl-carousel leaf gray-bg-2 flower" id="menu">
             
  </div>
  @if(session('success'))
  <div class="custom-toast alert alert-success alert-dismissible fade show" role="alert">
      <div class="alert-content">
          {{ session('success') }}
      </div>
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
      </button>
  </div>
  @endif
<form action="{{ route('addToCart') }}" method="POST">
    @csrf
    <input type="hidden" name="productId" value="{{ $id }}">
    <section class="section-padding leaf-bottom">
        <div class="container">
            <div class="row mb-40">
                <div class="col-xl-5 col-lg-5 col-md-6">
                    <div class="item-photo">
                        <img src="{{ asset('product_images') }}/{{ $product->image }}" alt="{{ $product->name }}">
                    </div>
                </div>
                <div class="col-xl-7 col-lg-7 col-md-6">
                    <div class="item-descriptions">
                        <h2>{{ $product->name }}</h2>
                        <p></p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-12 mb-60">
                    <div class="item-option-title">
                        <h2>Size</h2>
                    </div>
                    <span class="item-options">
                        <fieldset class="form-group">
                            <div class="row productOptionDivFIx" style="justify-content:center">
                                @foreach ($productSizes as $key => $item)
                                @php
                                    $productPrice = 0;
                                    $currentDate = date("Y-m-d H:i:s");
                        
                                    if ($item->special_price_from < $currentDate && $item->special_price_to > $currentDate) {
                                        $productPrice = $item->special_price;
                                    } else {
                                        $productPrice = $item->selling_price;
                                    }
                                @endphp
                                <div class="col-sm-4">
                                    <div class="form-check" id="productSizeButtons">
                                        <div class="single-item-radio">
                                            <input class="form-check-input" type="radio" name="productSizeId" id="ps{{ $item->id }}" value="{{ $item->id }}" @if($loop->first) checked @endif>
                                            <label class="form-check-label" for="ps{{ $item->id }}">
                                                <strong>{{ $item->size_name }}</strong>
                                                <span>Base Price <span id="psp{{ $item->id }}">{{ $productPrice }}</span></span>
                                            </label>
                                        </div>
                                    </div>
                                </div>                            
                                @endforeach
                                {{-- <input type="hidden" name="productID" value="{{ $id }}" id="productSizePrice"> --}}
                            </div>
                        </fieldset>
                    </span>
                </div>

                <div class="col-xl-12">
                    <div class="option-holder" id="optionHolder">
                        @foreach ($productOptions as $title => $options)
                            <div class="col-md-12" style="margin-top: 20px; margin-bottom: 20px; border: 1px solid blues">
                                <div class="item-option-title">
                                    <h2>{{ $title }}</h2>
                                </div>
                                <div class="row text-center optionsHolderDivCatcher">

                                    @foreach ($options as $key => $option)
                                        @php
                                            $optionPrice = 0;
                                            $currentDate = date("Y-m-d H:i:s");

                                            if ($option->offer_money_from < $currentDate && $option->offer_money_to > $currentDate) {
                                                $optionPrice = $option->offer_price;
                                            } else {
                                                $optionPrice = $option->extra_price;
                                            }
                                        @endphp
                                        @if ($option->option_type == "checkbox")
                                            <div class="col-md-4">
                                                <input type="checkbox" name="productOptionIds[]" value="{{ $option->id }}" id="po{{ $option->id }}">
                                                <label for="po{{ $option->id }}" style="padding: 10px;">
                                                    <img src="{{ asset('option_images') }}/{{ $option->image }}" alt="{{ $option->name }}">
                                                    <p>{{ $option->name }}<br>+৳{{ $option->extra_price ?? '0' }}</p>
                                                </label>
                                            </div>
                                        @else
                                            @if($key==0)
                                            <ul class="text-center">
                                            @endif
                                                <li class="col-sm-4">
                                                    <input type="radio" name="productOptionIds[]" value="{{ $option->id }}" id="po{{ $option->id }}">
                                                    <label for="po{{ $option->id }}" class="customRadio" style="height: 185px;">
                                                        <div class="row optionTitleDivForCenter">
                                                            <div class="col-md-12">
                                                                <img style="z-index: 999999;" src="{{ asset('option_images') }}/{{ $option->image }}" alt="{{ $option->name }}">
                                                            </div>
                                                            <div class="col-md-12">
                                                                <p style="margin-left: 0px;">
                                                                    {{ $option->name }}<br>+৳{{ $optionPrice ? $optionPrice : '0' }}
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </label>
                                                </li>
                                            @if($key==count($options)-1)
                                            </ul>
                                            @endif

                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        @endforeach

                    </div>
                </div>

                <div class="col-xl-12">
                    <div class="addon-holder">
                        <div class="item-option-title">
                            <h2>@if(count($productAddons) > 0) You May Also Add: @endif</h2>
                        </div>
                        <div class="row text-center" style="justify-content: center">
                            <ul class="text-center">
                                @foreach($productAddons as $key => $value)
                                    @php
                                        $productAddonPrice = 0;
                                        $currentDate = now();
                
                                        if ($productAddons[$key]['offer_money_from'] < $currentDate && $productAddons[$key]['offer_money_to'] > $currentDate) {
                                            $productAddonPrice = $productAddons[$key]['offer_money_added'];
                                        } else {
                                            $productAddonPrice = $productAddons[$key]['extra_money_added'];
                                        }
                                    @endphp
                                    <li>
                                        <input type="checkbox" id="pc{{ $productAddons[$key]['id'] }}" value="{{ $productAddons[$key]['id'] }}" name="productAddonIds[]">
                                        <label for="pc{{ $productAddons[$key]['id'] }}" style="padding:10px;">
                                            <img src="{{ asset('product_addon_images') }}/{{$productAddons[$key]['image']}}">
                                            <h5>{{ $productAddons[$key]['name'] }}</h5>
                                            <h6>+৳{{ $productAddonPrice }}</h6>
                                        </label>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col-xl-12">
                    <div class="item-option-title">
                        <h2>Quantity</h2>
                    </div>
                    <div class="quantity">
                        <a href="#" class="quantity__minus"><span>-</span></a>
                        <input name="productQuntity" type="text" class="quantity__input" value="1">
                        <a href="#" class="quantity__plus"><span>+</span></a>
                    </div>
                </div>
                <div class="col mt-60" style="text-align:center">
                    <input type="submit" class="bttn-mid btn-fill" value="Add To Cart" id="addToCartButton">
                </div>
            </div>
        
            </div>
        </div>
    </section>
</form>
@endsection
