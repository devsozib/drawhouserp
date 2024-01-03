<!DOCTYPE html>
<html lang="en">


<!-- Mirrored from www.ansonika.com/potenza/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 06 Jun 2023 08:31:19 GMT -->

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Potenza - Job Application Form Wizard with Resume upload and Branch feature">
    <meta name="author" content="Ansonika">
    <title>HRM | Job Application Form by DRAWHOUSE</title>

    <!-- Favicons-->
    <link rel="shortcut icon" href="{{ url('images/DrawHouse-Logo (1).png') }}" />
    <link rel="apple-touch-icon" type="image/x-icon" href="{{ url('images/DrawHouse-Logo (1).png') }}">
    <link rel="apple-touch-icon" type="image/x-icon" sizes="72x72" href="{{ url('images/DrawHouse-Logo (1).png') }}">
    <link rel="apple-touch-icon" type="image/x-icon" sizes="114x114" href="{{ url('images/DrawHouse-Logo (1).png') }}">
    <link rel="apple-touch-icon" type="image/x-icon" sizes="144x144" href="{{ url('images/DrawHouse-Logo (1).png') }}">

    <!-- GOOGLE WEB FONT -->
    <link href="https://fonts.googleapis.com/css?family=Work+Sans:400,500,600" rel="stylesheet">
    {{-- sweetalert2 Css --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.2/dist/sweetalert2.min.css">
    <!-- select2 -->
    <link rel="stylesheet" href="{{ url('theme/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ url('theme/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    <!-- bootstrap datepicker -->
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <!-- BASE CSS -->
    <link href="{{ asset('public/career') }}/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('public/career') }}/css/menu.css" rel="stylesheet">
    <link href="{{ asset('public/career') }}/css/style.css" rel="stylesheet">
    <link href="{{ asset('public/career') }}/css/vendors.css" rel="stylesheet">

    <!-- YOUR CUSTOM CSS -->
    <link href="{{ asset('public/career') }}/css/custom.css" rel="stylesheet">

    <!-- MODERNIZR MENU -->
    <script src="{{ asset('public/career') }}/js/modernizr.js"></script>

</head>

<body>
    <div id="preloader">
        <div data-loader="circle-side"></div>
    </div><!-- /Preload -->

    <div id="loader_form">
        <div data-loader="circle-side-2"></div>
    </div><!-- /loader_form -->

    @yield('content')

    <div class="cd-overlay-nav">
        <span></span>
    </div>
    <!-- /cd-overlay-nav -->

    <div class="cd-overlay-content">
        <span></span>
    </div>
    <!-- /cd-overlay-content -->

    {{-- <a href="#0" class="cd-nav-trigger">Menu<span class="cd-icon"></span></a> --}}
    <!-- /menu button -->

    <!-- Modal terms -->
    <div class="modal fade" id="terms-txt" tabindex="-1" role="dialog" aria-labelledby="termsLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="termsLabel">Terms and conditions</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Lorem ipsum dolor sit amet, in porro albucius qui, in <strong>nec quod novum accumsan</strong>,
                        mei ludus tamquam dolores id. No sit debitis meliore postulant, per ex prompta alterum sanctus,
                        pro ne quod dicunt sensibus.</p>
                    <p>Lorem ipsum dolor sit amet, in porro albucius qui, in nec quod novum accumsan, mei ludus tamquam
                        dolores id. No sit debitis meliore postulant, per ex prompta alterum sanctus, pro ne quod dicunt
                        sensibus. Lorem ipsum dolor sit amet, <strong>in porro albucius qui</strong>, in nec quod novum
                        accumsan, mei ludus tamquam dolores id. No sit debitis meliore postulant, per ex prompta alterum
                        sanctus, pro ne quod dicunt sensibus.</p>
                    <p>Lorem ipsum dolor sit amet, in porro albucius qui, in nec quod novum accumsan, mei ludus tamquam
                        dolores id. No sit debitis meliore postulant, per ex prompta alterum sanctus, pro ne quod dicunt
                        sensibus.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn_1" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->

    <!-- COMMON SCRIPTS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"
        integrity="sha512-3gJwYpMe3QewGELv8k/BX9vcqhryRdzRMxVfq6ngyWXwo03GFEzjsUm8Q7RZcHPHksttq7/GFoxjCVUjkjvPdw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="{{ asset('public/career') }}/js/common_scripts.min.js"></script>
    <!-- sweetalert2 JavaScript file -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.2/dist/sweetalert2.min.js"></script>
    <script src="{{ asset('public/career') }}/js/velocity.min.js"></script>
    <script src="{{ url('theme/plugins/select2/js/select2.full.min.js') }}"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    <script src="{{ asset('public/career') }}/js/common_functions.js"></script>
    <script src="{{ asset('public/career') }}/js/file-validator.js"></script>

    <!-- Wizard script-->
    <script src="{{ asset('public/career') }}/js/func_1.js"></script>
    @yield('sweetalert-script')
    <script type="text/javascript">
        $(document).ready(function(event) {
            $('.select2bs4').select2({
                theme: 'bootstrap4',
                placeholder: "Select One",
                width: "100%",
                allowClear: true,
            });
        });

    </script>
  <script>
    $(document).ready(function() {
        $('#datepicker').datepicker({
        dateFormat: 'yy-mm-dd' // Change the format as per your requirement
        });
    });
  </script>

</body>
</html>
