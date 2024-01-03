<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">


    <link rel="shortcut icon" href="{{ asset('frontend') }}/assets/images/favicon.ico" type="image/x-icon">
    <link rel="icon" href="{{ asset('frontend') }}/assets/images/favicon.ico" type="image/x-icon">

    <title>Kona Cafe</title>

    <!-- Bootstrap -->
    <link href="{{ asset('frontend') }}/assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('frontend') }}/assets/css/jquery-ui.css" rel="stylesheet">

    <link href="{{ asset('frontend') }}/assets/css/font-awesome.min.css" rel="stylesheet">
    <link href="{{ asset('frontend') }}/assets/css/owl.carousel.min.css" rel="stylesheet">


    <!-- Main css -->
    <link href="{{ asset('frontend') }}/assets/css/main.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ asset('frontend') }}/assets/css/slick.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('frontend') }}/assets/css/slick-theme.css">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <style>
        html,
        body {
            margin: 0;
            padding: 0;
        }

        * {
            box-sizing: border-box;
        }

        .slider {
            width: 100%;
            margin: 100px auto;
        }

        .slick-slide {
            margin: 0px 20px;
        }

        .slick-slide img {
            width: 100%;
        }

        .slick-prev:before,
        .slick-next:before {
            color: black;
        }


        .slick-slide {
            transition: all ease-in-out .3s;
            opacity: .2;
        }

        .slick-active {
            opacity: .5;
        }

        .slick-current {
            opacity: 1;
        }

        .food-item-card {

            margin: 5px !important;
        }

        @media (max-width: 767px) {
            .special-section-padding {
                padding: 0 0;
            }

        }
    </style>

</head>
