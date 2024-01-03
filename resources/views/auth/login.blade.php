<!DOCTYPE html>
<html lang="en">
<head>
  @include('../layout/head')
  <script>document.title = "Login";</script>
  <style>
    body {
      background-image: url('images/gray-calathea-lutea-leaf-patterned-background.jpg');
      background-repeat: no-repeat;
      background-attachment: fixed;
      /* background-size: 100% 100%; */
      background-size: cover;
      /* color: #FFFFFF; */
      background-position: center center;
    }
    .login-box {
      opacity: 0.9;
    }

    .input-group-text {
    display: -ms-flexbox;
    display: flex;
    -ms-flex-align: center;
    align-items: center;
    padding: 0.375rem 0.75rem;
    margin-bottom: 0;
    font-size: 15px;
    font-weight: 400;
    line-height: 0.5;
    color: #495057;
    text-align: center;
    white-space: nowrap;
    background-color: #e9ecef;
    border: 1px solid #ced4da;
    border-radius: 0.25rem;
}
  </style>
</head>
<body class="hold-transition login-page">
  @if ($errors->any())
  <div class="alert alert-danger">
    <ul>
      @foreach ($errors->all() as $error)
      <li>{{ $error }}</li>
      @endforeach
    </ul>
  </div>
  @endif
  @include('../layout/toastr')
  <div class="login-box">
    <!-- /.login-logo -->
    <div class="card card-outline card-primary">
      @php
        $host = request()->getHost();
        $host = str_replace('.','_',$host);
        // _print($host);
        $companyInfo = Config::get("rmconf.$host")??Config::get("rmconf.default");
        $host = Config::get("rmconf.$host") ? $host : Config::get("rmconf.midory");


        $black_logo = [
            Config::get("rmconf.lakeshore_bakery"),
            Config::get("rmconf.drawHouse"),
            Config::get("rmconf.kona_cafe"),
            Config::get("rmconf.poche_group"),
            Config::get("rmconf.midory"),
        ];

        $companyName = $companyInfo['name'];

        if(in_array($host,$black_logo)){
            $logo = $companyInfo['logo_black'];
        }else{
            $logo = $companyInfo['logo_white'];
        }

        $logoWidth = $companyInfo['logo_width_login'];
        $margin = $companyInfo['margin_login'];
        $location = $companyInfo['location'];

        // if ($host == 'hris.lakeshorebakery.com') {
        //     $companyName =  Config::get('rmconf.lakeshorebakery') ;
        //     $logo = Config::get('rmconf.lakeshorebakerylogoblack') ;
        //     $logoWidth = '70';
        //     $margin= "30px";
        //     $location = 'Gulshan-2';
        // } elseif ($host == 'hris.drawhousedesign.com') {
        //     $companyName =  Config::get('rmconf.drawhousedesign') ;
        //     $logo = Config::get('rmconf.drawhousedesignlogoblack');
        //     $logoWidth = '250';
        //     $margin= "0px";
        //     $location = 'Gulshan-2';
        // } elseif ($host == 'hris.konacafedhaka.com') {
        //     $companyName =  Config::get('rmconf.konacafedhaka') ;
        //     $logo =  Config::get('rmconf.konacafedhakalogoblack') ;
        //     $logoWidth = '70';
        //     $margin= "20px";
        //     $location = 'Gulshan-2';
        // } elseif ($host == 'hris.pochegroup.com') {
        //     $companyName = Config::get('rmconf.pochegroup') ;
        //     $logo = Config::get('rmconf.pochelogoblack') ;
        //     $logoWidth = '100';
        //     $margin= "0px";
        //     $location = 'Gulshan-2';
        // } elseif ($host == 'hris.lakeshorebanani.com.bd') {
        //     $companyName = Config::get('rmconf.lakeshoresuites') ;
        //     $logo = Config::get('rmconf.lsslogowhite') ;
        //     $logoWidth = '100';
        //     $margin= "0px";
        //     $location = ' House # 81, Block D,Road # 13/A, Banani, Dhaka-1212, Bangladesh.';
        // } elseif ($host == 'hris.themidoridhaka.com') {
        //     $companyName = Config::get('rmconf.midory') ;
        //     $logo = Config::get('rmconf.midorilogoblack') ;
        //     $logoWidth = '80';
        //     $margin= "0px";
        //     $location = 'Gulshan-2';
        // } else {
        //     $companyName =  Config::get('rmconf.drawhousedesign') ;
        //     $logo = Config::get('rmconf.drawhousedesignlogoblack');
        //     $logoWidth = '250';
        //     $margin= "0px";
        //     $location = 'Gulshan-2';
        // }

  @endphp
      <div class="card-header text-center">
        <div class="brand-logo">
            <a href="javascript:void(0)" class="logo  appsname" style="padding: 0px;">
                <img style="width:{{ $logoWidth  }}px; " src="{{ url('images/',$logo) }}" alt="Logo"
                    class="brand-image">
                {{-- <span class="brand-text">&nbsp;{{ Config::get('rmconf.apps_name') }}</span> --}}
            </a>
        </div><br>
        <a href="javascript::void(0)" class="h2"><b>Login</b></a>
      </div>
      <div class="card-body">
        <form action="{{ url('login') }}" method="POST">
          {{ csrf_field() }}
          <div class="input-group mb-3">
            <input name="email" type="email" class="form-control" placeholder="Email" value="{{old('email')}}">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-envelope"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input name="password" type="password" class="form-control" placeholder="Password" value="{{ old('password') }}" id="password">
            <div class="input-group-append">
                <div class="input-group-text">
                  <a href="#" id="toggle-password" style="text-decoration: none;">
                    <span class="fas fa-eye" id="toggle-icon"></span>
                  </a>
                </div>
            </div>

        </div>
          <div class="row">
            <div class="col-8">
              <div class="icheck-primary">
                <input type="checkbox" id="remember">
                <label for="remember">
                  Remember Me
                </label>
              </div>
            </div>
            <!-- /.col -->
            <div class="col-4">
              {!! Form::text('LocalIP', null, array('readonly', 'class'=>'form-control', 'hidden', 'id' => 'LocalIP', 'value'=>old('LocalIP'))) !!}
              <button type="submit" class="btn btn-primary btn-block">Sign In</button>
            </div>
            <!-- /.col -->
          </div>
        </form>

        <p class="mb-1">
          <a href="javascript::void(0)">I forgot my password</a>
        </p>
        {{-- <p class="mb-1">
            <a href="{{ url
            ('registration') }}">Don't have an account? <span class="text-info">Register now</span></a>
        </p> --}}
      </div>
      <!-- /.card-body -->
    </div>
    <!-- /.card -->
  </div>
  <!-- /.login-box -->
  <script type="text/javascript">
    window.RTCPeerConnection = window.RTCPeerConnection || window.mozRTCPeerConnection || window.webkitRTCPeerConnection;
    var pc = new RTCPeerConnection({iceServers:[]}), noop = function(){};
    pc.createDataChannel('');
    pc.createOffer(pc.setLocalDescription.bind(pc), noop);
    pc.onicecandidate = function(ice) {
        if (ice && ice.candidate && ice.candidate.candidate) {
            var myIP = /([0-9]{1,3}(\.[0-9]{1,3}){3}|[a-f0-9]{1,4}(:[a-f0-9]{1,4}){7})/.exec(ice.candidate.candidate)[1];
            $('#LocalIP').val(myIP);
            pc.onicecandidate = noop;
        }
    };

  </script>
<script>
  const passwordInput = document.getElementById('password');
  const togglePassword = document.getElementById('toggle-password');
  const toggleIcon = document.getElementById('toggle-icon');

  togglePassword.addEventListener('click', function () {
      if (passwordInput.type === 'password') {
          passwordInput.type = 'text';
          toggleIcon.classList.remove('fa-eye');
          toggleIcon.classList.add('fa-eye-slash');
      } else {
          passwordInput.type = 'password';
          toggleIcon.classList.remove('fa-eye-slash');
          toggleIcon.classList.add('fa-eye');
      }
  });
</script>
</body>

</html>
