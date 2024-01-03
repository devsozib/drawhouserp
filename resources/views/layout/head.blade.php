    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <!-- <meta name="viewport" content="width=device-width, initial-scale=1"> -->
    <meta name="_token" content="{!! csrf_token() !!}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="keywords" content="DrawHouse, HRIS">
    <meta name="description" content="HRIS Software">
    <meta name="author" content="DrawHouse Dhaka">

    <title>@yield('title')</title>
    @php
        $host = request()->getHost();
        $host = str_replace('.','_',$host);
        $companyInfo = Config::get("rmconf.$host")??Config::get("rmconf.default");

        $companyName = $companyInfo['name'];
        $logo = $companyInfo['logo'];
        $logoWidth = $companyInfo['logo_width'];
        $location = $companyInfo['location'];
        $icon = $companyInfo['icon'];
    @endphp
    <link rel="shortcut icon" href="{{ url('images/'.$icon) }}" />
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- jQuery -->
    <script src="{{ url('theme/plugins/jquery/jquery.min.js') }}"></script>
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Font Awesome Icons -->
    <!-- <link rel="stylesheet" href="{{ url('theme/plugins/fontawesome-free/css/all.min.css') }}"> -->
    <link rel="stylesheet" href="{{ url('theme/plugins/font-awesome-6.4.0/all.min.css') }}">
    <script src="{{ url('theme/plugins/font-awesome-6.4.0/all.min.js') }}"></script>
    <!-- bootstrap -->
    <script src="{{ url('theme/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ url('theme/dist/css/adminlte.min.css') }}">
    <script src="{{ url('theme/dist/js/adminlte.min.js') }}"></script>
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="{{ url('theme/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <!-- jquery-validation -->
    <script src="{{ url('theme/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ url('theme/plugins/jquery-validation/additional-methods.min.js') }}"></script>
    <!-- toastr -->
    <link rel="stylesheet" href="{{ url('theme/plugins/toastr/toastr.min.css') }}">
    <script src="{{ url('theme/plugins/toastr/toastr.min.js') }}"></script>
    <!-- select2 -->
    <link rel="stylesheet" href="{{ url('theme/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ url('theme/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    <script src="{{ url('theme/plugins/select2/js/select2.full.min.js') }}"></script>
    <!-- moment -->
    <script src="{{ url('theme/plugins/moment/moment.min.js') }}"></script>
    <!-- bootstrap datepicker -->
    <link rel="stylesheet" href="{{ url('theme/plugins/bootstrap-datepicker-1.9.0/bootstrap-datepicker.min.css') }}">
    <script src="{{ url('theme/plugins/bootstrap-datepicker-1.9.0/bootstrap-datepicker.min.js') }}"></script>
    <!-- daterange picker -->
    <!-- <link rel="stylesheet" href="{{ url('theme/plugins/daterangepicker/daterangepicker.css') }}">
    <script src="{{ url('theme/plugins/daterangepicker/daterangepicker.js') }}"></script> -->
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet" href="{{ url('theme/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
    <script src="{{ url('theme/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
    <!-- InputMask -->
    <!-- <script src="{{ url('theme/plugins/inputmask/jquery.inputmask.min.js') }}"></script> -->
    <!-- date-time-picker -->
    <script src="{{ url('theme/plugins/datetimepicker/datetimepicker.js') }}"></script>

    {{-- bootstrap-select --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.18/css/bootstrap-select.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.18/js/bootstrap-select.min.js"></script>
    <!--ckeditor js -->
    <script src="https://cdn.ckeditor.com/ckeditor5/30.0.0/classic/ckeditor.js"></script>
    <!-- custom -->
    <link rel="stylesheet" href="{{ url('custom/style.css') }}">

    @yield('css')

    <!-- custom css -->
    <style type="text/css">
        .card-title {
            font-size: 20px !important;
        }

        .modal-header {
            padding: 7px !important;
        }

        .form-control {
            /*font-size: 13px;
            height: 30px;
            margin: 0px;*/
            padding-left: 7px !important;
            padding-right: 7px !important;
        }

        .custom-header {
            margin-top: -2px;
            margin-bottom: -3px;
        }

        .appsname:hover {
            color: lightskyblue;
        }

        /*body {
            margin-top: -10px !important;
        }*/

        .table>thead>tr>th,
        .table>thead>tr>td,
        .table>tbody>tr>th,
        .table>tbody>tr>td,
        .table>tr>th,
        .table>tr>td {
            padding: 3px 3px 3px 3px;
            text-align: left;
            padding: 5px;
            vertical-align: top;
        }

        td:empty:after {
            content: "\00a0";
        }

        .table td, .table th {
            padding: 5px;
            vertical-align: top;
            border-top: none;
        }

        .table thead th {
            vertical-align: top;
        }

        .form-control {
            /*font-size: 13px;*/
            height: 28px;
            margin: 0px;
            padding: 2px 5px 2px 5px;
            border-radius: 5px !important;
        }

        .btn {
            border-radius: 5px !important;
        }
        
        .select2-selection__rendered{
            word-wrap: break-word !important;
            text-overflow: inherit !important;
            white-space: normal !important;
        }

        .select2-container .select2-selection--single {
            height: 28px;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            color: #444;
            line-height: 16px;
            margin-left: -5px;
        }

        .select2-container--bootstrap4 .select2-selection--single {
            height: 28px !important;
        }

        .select2-container--bootstrap4 .select2-selection--single .select2-selection__rendered {
            padding-left: .75rem;
            margin-left: -5px;
            line-height: 24px;
            color: #495057;
        }

        .select2-container--bootstrap4 .select2-selection__clear {
            float: right;
            width: 13px;
            height: 13px;
            padding-left: .15em;
            margin-top: 6px;
            margin-right: 0px;
            line-height: .75em;
            color: #f8f9fa;
            background-color: #c8c8c8;
            border-radius: 100%;
        }

        .select2-container--bootstrap4 .select2-selection--single .select2-selection__placeholder {
            line-height: 24px !important;
            color: #6c757d;
        }

        .toast-top-right {
            top: 60px;
        }

        [contenteditable='true'].single-line {
            white-space: nowrap;
            overflow: hidden;
        }

        [contenteditable='true'].single-line br {
            display: none;
        }

        [contenteditable='true'].single-line * {
            display: inline;
            white-space: nowrap;
        }

        input[type='number'] {
            -moz-appearance: textfield;
        }

        input[type=number]::-webkit-inner-spin-button,
        input[type=number]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        .modal-content {
            border-radius: 10px !important;
        }

        select {
            -webkit-appearance: none;
            -moz-appearance: none;
            -ms-appearance: none;
            -o-appearance: none;
            appearance: none;
        }

        .bootstrap-select .btn {
            /* enables multiline on selectpicker */
            white-space: normal !important;
            word-wrap: break-word;
            line-height: 18px;
        }

        .form-group {
            margin-bottom: 0px;
        }

        .hidden {
            visibility: hidden;
            display: none;
        }

        a.active {
            line-height: 0.8em;
            font-weight: 600;
            color: #000000;
        }

        .nav-tabs-custom {
            -webkit-box-shadow: none;
            box-shadow: none;
        }

        .address-border {
            border: 2px solid lightgray;
        }

        /* collapse */
        #faq {
            margin-bottom: 10px;
            border: 0;
        }

        #faq {
            border: 0;
            -webkit-box-shadow: 0 0 20px 0 rgba(213, 213, 213, 0.5);
            box-shadow: 0 0 20px 0 rgba(213, 213, 213, 0.5);
            border-radius: 2px;
            padding: 5px;
        }

        #faq .btn-header-link {
            color: #fff;
            display: block;
            text-align: left;
            background: #72aaff;
            color: #222;
            padding: 6px;
            margin: 5px;
        }

        #faq .btn-header-link:after {
            content: "\f068";
            font-family: 'Font Awesome 5 Free';
            font-weight: 900;
            float: left;
        }

        #faq .btn-header-link.collapsed {
            background: #bfb9c0;
            color: #fff;
        }

        #faq .btn-header-link.collapsed:after {
            content: "\f067";
        }

        .card-header,
        .card-footer {
            padding-top: 5px;
            padding-bottom: 5px;
        }
    </style>

    <script type="text/javascript">
        var emplen = 5;
        function lpad(str, max) {
            str = str.toString();
            return str.length < max ? lpad("0" + str, max) : str;
        }

        function strip_html_tags(str) {
            if ((str === null) || (str === '')) {
                return '';
            } else {
                str1 = str.toString();
                return str1.replace(/<[^>]*>/g, '');
            }
        }
        $(document).on("click", ".single-line", function () {
            $(this).addClass('bg-warning');
        });
        $(document).on('focus', '.select2', function() {
            $(this).siblings('select').select2('open');
        });
        $(document).on('select2:open', () => {
            document.querySelector('.select2-search__field').focus();
        });
        $(document).on("wheel", "input[type=number]", function (e) {
            $(this).blur();
        });

        function dateTimeToDate(dtime) {
            var fullDate = new Date(dtime);
            var twoDigitMonth = fullDate.getMonth() + 1 + "";
            if (twoDigitMonth.length == 1) {
                twoDigitMonth = "0" + twoDigitMonth;
            }
            var twoDigitDate = fullDate.getDate() + "";
            if (twoDigitDate.length == 1) {
                twoDigitDate = "0" + twoDigitDate;
            }
            var currentDate = twoDigitDate + "-" + twoDigitMonth + "-" + fullDate.getFullYear();

            return currentDate;
        }
    </script>
