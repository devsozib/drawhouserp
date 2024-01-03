<header class="header-area">
    <nav class="navbar navbar-expand-lg main-menu">
        <div class="container">

            <a class="navbar-brand" href="{{ url('/frontend') }}"><img src="{{ asset('frontend') }}/assets/images/logo.png" class="d-inline-block align-top" alt=""></a>

            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="menu-toggle"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item"><a class="nav-link" href="{{ url('/frontend') }}">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ url('/frontend/about') }}">About</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ url('/frontend/menu') }}">Menu</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ url('/frontend/event') }}">Events</a>
                    <li class="nav-item"><a class="nav-link" href="{{ url('/frontend#location') }}">Location/Hours</a></li>
                </ul>
                @guest('customer')
                    <div class="header-btn justify-content-end">
                        <a href="{{ url('/frontend/login') }}" class="bttn-mid btn-emt login-button">Login/SignUp</a>
                    </div>
                @else
                    <div class="header-btn justify-content-end">
                        <a href="{{ route('customer.profile') }}" class="bttn-mid btn-emt login-button">Hello, {{ Auth::guard('customer')->user()->name }}</a>
                    </div>
                @endguest
            </div>
        </div>
    </nav>
</header> 
