<!DOCTYPE html>
<html lang="en">

<head>
    @include('layout/head')
</head>
<!-- <body class="hold-transition sidebar-mini" style="height: auto;"> -->

<body class="hold-transition sidebar-collapse" style="height: auto;">
    <!-- Navbar -->
    @include('layout/header')
    <!-- /.navbar -->
    <div class="wrapper" style="height: auto;">
        <!-- Main Sidebar Container -->
        @include('layout/menu')
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper" style="min-height: 916px;">
            @if (!Session::get('error_code'))
                {{-- @include('layout/toastr') --}}
                @include('layout/flash-message')
            @endif
            @if (Sentinel::getUser()->id == 1)
                <span id="test"></span>
            @endif
            @yield('content')
        </div>
        <!-- /.content-wrapper -->

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->

        <!-- Main Footer -->
        @include('layout/footer')
    </div>
    <!-- ./wrapper -->
    @include('layout/script')
    <script type="text/javascript">
        $('div.alert').not('.alert-important').delay(3000).fadeOut(350);
    </script>
    @yield('js')
</body>

</html>
