<!DOCTYPE html>
<html>
    @php
    $companyName = "";
    $companyEmail = "";
    $companyPhone = "";
    $hrName = "";
    $host = request()->getHost();

    if ($host == 'hris.lakeshorebakery.com') {
        $companyName = "Lakeshore Bakery";
        $companyEmail = "hr@lakeshorebakery.com";
        $companyPhone = '+8801313414431';
        $hrName = 'Monia Rahman Bhuiyan';
    } elseif ($host == 'hris.drawhousedesign.com') {
        $companyName = "DrawHouse Ltd";
        $companyEmail = "hr@drawhousedesign.com";
        $companyPhone = '+8801313414431';
        $hrName = 'Farhana Yasmin';
    } elseif ($host == 'hris.konacafedhaka.com') {
        $companyName = "Kona Cafe Dhaka";
        $companyEmail = "hr@konacafedhaka.com";
        $companyPhone = '+8801313414431';
        $hrName = 'Monia Rahman Bhuiyan';
    } else {
        $companyName = "DrawHouse Ltd";
        $companyEmail = "hr@drawhousedesign.com";
        $companyPhone = '+8801313414431';
        $hrName = 'Farhana Yasmin';
    }
@endphp
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Careers of {{  $companyName }}</title>
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
    .w3-title-blue {
        font-size: 50px;
        line-height: 1.5;
        font-weight: 500;
        /* font-family: 'Montserrat', sans-serif; */
        color: var(--primary-color);
            }
        .job-box {
        display: flex;
        padding: 20px 25px;
        transition: .6s;
        margin: 30px 0;
    }
    .border-light {
        border: 1px solid #eef1f8 !important;
    }
    .job-box:hover {
        border: 1px solid #2681FE !important;
    }
    .job-left {
        flex-basis: 60%;
    }
    a {
        text-decoration: none!important;
        color: #2681FE;
    }
    .w3-title-small-blue {
        font-size: 1.25rem;
        line-height: 2rem;
        font-weight: 400;
    }
    .job-left ul {
        margin-bottom: unset !important;
    }
    .gap-3 {
        gap: 1rem!important;
    }
    .job-center {
        flex-basis: 20%;
    }
    .job-right {
        flex-basis: 20%;
        text-align: end;
    }
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
    .d-flex {
        display: flex!important;
    }
    .job-left p {
        color: #2681fe;
    }
    span.location {
        margin-left: 5px!important;
    }
</style>
</head>

<body>

    <div class="theme-layout" id="scrollup">
        <section class="overlape">
            <div class="block no-padding">
                <div data-velocity="-.1"
                    style="background: url({{ asset('career/profile') }}/images/resource/careers-masthead-image.jpeg) repeat scroll 50% 422.28px transparent;"
                    class="parallax scrolly-invisible no-parallax"></div><!-- PARALLAX BACKGROUND IMAGE -->
                <div class="container fluid">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="inner-header">
                                <h3>Explore Our Current Job Opportunities</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section>
            <div class="current-positions-section pt-6 pb-3 clearfix" id="openPositions">
                <div class="text-center">
                    <a href="{{ route('apply.job.manually') }}" class="w3-btn w3-btn-blue mt-2">Apply job</a>
                </div>
                <div class="container">
                   @forelse ($jobs as $item)
                    <div class="job-box border-light">
                        <div class="job-left">
                            <a href="jobs/Senior-Software-Engineer-Python.html">
                                <p class="w3-title-small-blue text-md-left">{{ $item->Designation }}</p>
                            </a>
                            <ul class="d-flex gap-3">
                                <li class="mr-md-4">
                                    <i class="fa fa-map-marker"></i><span class="location">{{ $item->location }}</span>
                                </li>
                                <li class="mr-md-4">
                                    <i class="fa fa-clock-o" aria-hidden="true"></i>
                                        {{ $item->job_type }}
                                </li>
                            </ul>
                        </div>

                        <div class="job-center">
                            <p>Open for apply <br> No of vacancies: {{ $item->vacancy }}</p>
                            {{-- <p></p> --}}
                        </div>
                        <div class="job-right">
                            <a class="w3-btn w3-btn-blue" href="{{ route('job.details', encrypt($item->id)) }}">Details</a>
                        </div>
                    </div>
                    @empty
                    <p class="w3-title-small-blue text-md-center mt-5">There is no job yet!</p>
                   @endforelse

                    <p class="w3-sub-title text-center py-5">
                        <strong><i>Even if above opened positions do not match with your profile, we still encourage
                            you
                            to apply.</i></strong>
                        <br>
                        We have a few principles in high regard: quality, flexibility, and right attitude.<br>
                        Feel free to send your resume at <a href="mailto:{{ $companyEmail }}" style="color: var(--primary-color)"><strong> {{ $companyEmail }}</strong></a>

                    </p>

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
