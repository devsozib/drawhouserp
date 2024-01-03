@extends('frontend.layouts.master')
@section('content')

    <!--Custom Banner-->
    <div class="custom-banner leaf flower">
        <div class="container">
            <div class="row">

            </div>
        </div>
    </div>
    <!--/Custom Banner-->

    <!--Register-->
    <section class="section-padding leaf-bottom">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-5 col-12">
                    <form action="{{ route('customer.register') }}" method="post">
                        @csrf
                        <div class="checkout-card">
                            <div class="input-text">
                                <label for="fname">Full Name</label>
                                <input type="text" id="clientName" name="clientName" placeholder="Full Name">
                            </div>                         
                            <div class="input-text">
                                <label for="pnumber">Phone Number</label>
                                <input type="text" id="clientMobile" name="clientMobile" placeholder="Mobile">
                                <input type="hidden" class="input-text" id="clientBranch" name="clientBranch" value="1">
                                <input type="hidden" class="input-text" id="clientSubBranch" name="clientSubBranch" value="1">
                                <input type="hidden" class="input-text" value="register" name="function">
                            </div>
                            <div class="input-text">
                                <label for="email">Email Address</label>
                                <input type="text" id="clientEmail" name="clientEmail" placeholder="Email">
                            </div>                                                     
                            <div class="input-text">
                                <input type="password" id="clientPassword" name="clientPassword" placeholder="Client Password">
                            </div>                           
                            <input type="submit" class="bttn-mid btn-fill w-100" value="Register">

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <!--/Register-->

    @endsection