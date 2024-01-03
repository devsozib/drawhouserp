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
                    <div class="site-form">
                        @if($errors->has('login_error'))
                            <div class="alert alert-danger alert-dismissible fade show" id="loginErrorAlert" role="alert">
                                {{ $errors->first('login_error') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif
                        <form action="{{ route('customer.login') }}" method="post">
                            @csrf
                            <input type="hidden" name="function" value="felogin">
                            <input type="hidden" name="returnUrl" value="{{ url('/frontend/menu') }}">
                            <div class="site-form-inputs">
                                <p>New here? <a href="{{ url('/frontend/register') }}">Signup</a></p>
                                <div class="box-input">
                                    <label for="text">Phone Or Email</label>
                                    <input type="text" placeholder="Phone or Email" name="email_or_mobile">
                                </div>
                                <div class="box-input">
                                    <label for="password">Password</label>
                                    <input type="password" placeholder="Password" name="password">
                                </div>
                            </div>
                            <input type="submit" class="bttn-mid btn-fill w-100" value="Login">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script>
        setTimeout(function() {
            document.getElementById('loginErrorAlert').querySelector('.close').click();
        }, 2000); // Adjust the delay time as needed (2 seconds = 2000 milliseconds)
    </script>
    <!--/Register-->
