<!DOCTYPE html>
<html lang="en">
<head>
  @include('../layout/head')
  <script>document.title = "Login";</script>
  <style>
    body {
      background-image: url('images/Header-front.jpg');
      background-repeat: no-repeat;
      background-attachment: fixed;
      background-size: 100% 100%;
      /* color: #FFFFFF; */
    }
    .login-box {
      opacity: 0.9;
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
      <div class="card-header text-center">
        <a href="javascript::void(0)" class="h2"><b>Registration</b></a>
      </div>
      <div class="card-body">
        <form action="{{ url('registration') }}" method="POST">
          {{ csrf_field() }}
          <div class="input-group mb-3">
            <input name="EmployeeID" type="text" class="form-control" placeholder="EmployeeID" value="{{old('EmployeeID')}}" required>
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fa fa-id-card"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input name="FName" type="text" class="form-control" placeholder="First Name" value="{{old('FName')}}" required>
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="	fas fa-user-circle"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input name="LName" type="text" class="form-control" placeholder="Last Name" value="{{old('LName')}}">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="	fas fa-user-circle"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input name="email" type="email" class="form-control" placeholder="Email" value="{{old('email')}}" required>
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-envelope"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input name="phone" type="text" class="form-control" placeholder="Phone" value="{{old('phone')}}" required>
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-phone"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input name="password" type="password" class="form-control" placeholder="Password" value="{{old('password')}}" required>
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>
          <div class="row">
            <!-- /.col -->
            <div class="col-4 m-auto">
              {!! Form::text('LocalIP', null, array('readonly', 'class'=>'form-control', 'hidden', 'id' => 'LocalIP', 'value'=>old('LocalIP'))) !!}
              <button type="submit" class="btn btn-primary btn-block">Sign Up</button>
            </div>
            <!-- /.col -->
          </div>
        </form>
        <p class="mb-1 text-center">
            <a href="{{ route('login') }}">Already Registered? <span class="text-info">Login now</span></a>
        </p>
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
</body>

</html>
