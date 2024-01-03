@extends('frontend.layouts.master') @section('content')
<!--Custom Banner-->
<div class="custom-banner leaf flower">
  <div class="container">
    <div class="row"></div>
  </div>
</div>
<!--/Custom Banner-->
<!--Food Items Area-->
<section class="section-padding leaf-bottom">
  <div class="container text-center">
    <h6>You Are Ordering Online</h6>
    <br>
    <br>
    <div class="row">
      <div class="col-xl-12">
        <div class="cat-mainmenu">
          <ul>
            <li class="{{  $id==null?'active arrow_box':'' }}">
              <a href="{{ url('/frontend/menu') }}">All Categories</a>
            </li>
            @foreach ($categories as $cat)
            <li class="{{ $id==$cat->id?'active arrow_box':'' }}">
                <a href="{{ route('menu',$cat->id) }}">{{ $cat->name }}</a>
              </li> 
            @endforeach                    
          </ul>
        </div>
        <hr>
        <div class="tab-content">
            <div class="tab-pane fade show active" role="tabpanel">
              <div class="row mb-40">
                <div class="col">
                  <div class="cat-submenu">
                    <ul>
                        <li class="{{ $subcat==null?'active':''  }}"><a href="{{ route('menu',$id) }}">All</a></li>
                        @foreach ($subcategories as $subcats)
                        <li class="{{ $subcat == $subcats->id?'active':'' }}">
                            <a href="{{ route('menu', ['id' => $id, 'subcat' => $subcats->id]) }}">{{ $subcats->name }}</a>
                          </li>
                        @endforeach                                       
                    </ul>
                  </div>
                </div>
              </div>
              <hr>             
            </div>
          </div>
        <div class="tab-content">
          <div class="tab-pane fade show active" role="tabpanel">
            <hr>
            <div class="row">
              @foreach ($products as $item)
              <a href="{{ route('product.details',encrypt($item->id)) }}">
                <div class="col-6 col-md-3">
                  <div class="food-item-card">
                    <div class="item-img">
                      <img src="{{ asset('product_images') }}/{{ $item->image }}" alt="{{  $item->name }}">
                    </div>
                    <div class="item-title">
                      <h4 class="">
                        <a href="{{ route('product.details',encrypt($item->id)) }}">{{  $item->name }}</a>
                      </h4>
                    </div>
                    <div class="item-description">
                        {{-- <p>{!! $item->name  !!}</p>  --}}
                    </div>
                    <div class="item-meta">
                      <div class="price"> ৳{{ $item->selling_price }} </div>
                    </div>
                    <div class="item-meta">
                      <div class="button">
                        <a href="{{ route('product.details',encrypt($item->id)) }}" class="bttn-small btn-fill">Order</a>
                      </div>
                    </div>
                  </div>
                </div>
              </a> 
              @endforeach
                                   
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<!--/Food Items Area-->
<form action="https://www.konacafedhaka.com/erp/addtocartdirect.php" method="post" id="addToCartDirect">
  <input type="hidden" name="productId" id="ppi" value="0">
</form> @endsection