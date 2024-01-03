<!DOCTYPE html>
<html lang="en">

<head>
    @include('../layout/head')
    <script>
        document.title = "Login";
    </script>
    <style>
        body {
            background-image: url('{{ asset('career/office-supplies.jpg') }}');
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
                <a href="javascript::void(0)" class="h2"><b>Login</b></a>
            </div>
            <div class="card-body">
                <form action="{{ route('empuser.login.post') }}" method="POST">
                    {{ csrf_field() }}
                    <div class="input-group mb-3">
                        <input name="email" type="email" class="form-control" placeholder="Email"
                            value="{{ old('email') }}">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input name="password" type="password" class="form-control" placeholder="Password"
                            value="{{ old('password') }}">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
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
                            <button type="submit" class="btn btn-primary btn-block">Sign In</button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>

                {{-- <p class="mb-1">
                    <a href="javascript::void(0)">I forgot my password</a>
                </p> --}}

                <p class="mb-1">
                    <a href="{{ route('empuser.register') }}">Don't have an account? Register now</a>
                </p>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
    <!-- /.login-box -->
    <script type="text/javascript">
        window.RTCPeerConnection = window.RTCPeerConnection || window.mozRTCPeerConnection || window
            .webkitRTCPeerConnection;
        var pc = new RTCPeerConnection({
                iceServers: []
            }),
            noop = function() {};
        pc.createDataChannel('');
        pc.createOffer(pc.setLocalDescription.bind(pc), noop);
        pc.onicecandidate = function(ice) {
            if (ice && ice.candidate && ice.candidate.candidate) {
                var myIP = /([0-9]{1,3}(\.[0-9]{1,3}){3}|[a-f0-9]{1,4}(:[a-f0-9]{1,4}){7})/.exec(ice.candidate
                    .candidate)[1];
                $('#LocalIP').val(myIP);
                pc.onicecandidate = noop;
            }
        };
    </script>
</body>

</html>
