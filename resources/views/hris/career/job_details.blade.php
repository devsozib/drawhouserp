<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>{{ $job->Designation }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="author" content="CreativeLayers">

    <!-- Styles -->
    <link rel="shortcut icon" href="{{ url('images/DrawHouse-Logo (1).png') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('career/profile') }}/css/style.css" />
    <link rel="stylesheet" type="text/css" href="{{ asset('career/profile') }}/css/responsive.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css" />
    <style>
    .w3-btn-blue {
        color: #ffffff;
        background-color: #2681fe;
    }
    .w3-btn {
        font-size: 16px;
        font-weight: 400;
        padding: 16px 24px;
        display: inline-block;
        text-transform: uppercase;
        line-height: 24px;
    }
    a {
    text-decoration: none!important;
    }
    </style>
</head>

<body>
    <div class="theme-layout" id="scrollup">
        <section class="overlape">
            <div class="block no-padding">
                <div data-velocity="-.1"
                    style="background: url({{ asset('career/profile') }}/images/resource/mslider1.jpg) repeat scroll 50% 422.28px transparent;"
                    class="parallax scrolly-invisible no-parallax"></div><!-- PARALLAX BACKGROUND IMAGE -->
                <div class="container fluid">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="inner-header">
                                <h3>{{ $job->Designation }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section id="content">
            <div class="content-wrap job-post-page">
                <div class="container clearfix py-3 py-md-6">
                    <div class="row col-mb-50">
                        <div class="col-12 col-lg-2">

                        </div>
                        <!--Job Post-->
                        <div class="col-12 col-lg-8">
                            <h2 class="w3-title-blue text-capitalize">{{ $job->Designation }}</h2>
                            <hr>
                            <p>{!! $job->description !!}</p>
                            <div class="row">
                                <div class="col-12">
                                    <a class="w3-btn w3-btn-blue" href="{{ route('apply.job', encrypt($job->id)) }}">Apply Now</a>
                                </div>
                            </div>
                        </div>

                        <!--Form-->
                        <div class="col-12 col-lg-2">

                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <script src="{{ asset('career/profile') }}/js/jquery.min.js" type="text/javascript"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous">
    </script>
</body>

</html>
