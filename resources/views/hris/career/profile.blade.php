<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Profile of {{ Auth::guard('empuser')->user()->name }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="author" content="CreativeLayers">

    <!-- Styles -->
    <link rel="shortcut icon" href="{{ url('images/DrawHouse-Logo (1).png') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('career/profile') }}/css/bootstrap-grid.css" />
    <link rel="stylesheet" href="{{ asset('career/profile') }}/css/icons.css">
    <link rel="stylesheet" href="{{ asset('career/profile') }}/css/animate.min.css">
    {{-- sweetalert2 Css --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.2/dist/sweetalert2.min.css">
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/line-awesome@1.3.0/dist/line-awesome/css/line-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('career/profile') }}/css/style.css" />
    <link rel="stylesheet" type="text/css" href="{{ asset('career/profile') }}/css/responsive.css" />
    <link rel="stylesheet" type="text/css" href="{{ asset('career/profile') }}/css/chosen.css" />
    <link rel="stylesheet" type="text/css" href="{{ asset('career/profile') }}/css/colors/colors.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css" />

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
                                <h3>Welcome {{ Auth::guard('empuser')->user()->name }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section>
            <div class="block no-padding">
                <div class="container">
                    <div class="row no-gape">
                        <aside class="col-lg-3 column border-right">
                            <div class="widget">
                                <div class="tree_widget-sec">
                                    <div class="nav flex-column nav-pills me-3" id="v-pills-tab" role="tablist"
                                        aria-orientation="vertical">
                                        <a class="nav-link active" id="v-pills-home-tab" data-bs-toggle="pill"
                                            data-bs-target="#v-pills-home" type="button" role="tab"
                                            aria-controls="v-pills-home" aria-selected="true"><i
                                                class="la la-paper-plane"></i>My Profile</a>
                                        <a class="nav-link" id="v-pills-profile-tab" data-bs-toggle="pill"
                                            data-bs-target="#v-pills-profile" type="button" role="tab"
                                            aria-controls="v-pills-profile" aria-selected="false"><i
                                                class="la la-lock"></i>Change Password</a>
                                        <a class="nav-link" href="{{ route('empuser.logout') }}"><i
                                                class="la la-unlink"></i>Logout</a>
                                    </div>
                                </div>
                            </div>
                        </aside>
                        <div class="col-lg-9 column">
                            <div class="padding-left">
                                <div class="tab-content" id="v-pills-tabContent">
                                    @if ($empUserInfo)
                                        <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel"
                                            aria-labelledby="v-pills-home-tab" tabindex="0">
                                            <div class="profile-title" id="mp">
                                                <h3>My Profile</h3>
                                                <div class="upload-img-bar">
                                                    <span><img
                                                            src="{{ $empUserInfo->image?url('public/career/applicant_image',$empUserInfo->image):'' }}"
                                                            alt="" /><i>x</i></span>
                                                    <div class="upload-info">
                                                        <a href="#" title="">Browse</a>
                                                        <span>Max file size is 1MB, Minimum dimension: 270x210 And
                                                            Suitable
                                                            files
                                                            are .jpg & .png</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="profile-form-edit">
                                                <form>
                                                    <div class="row">
                                                        <div class="col-lg-6">
                                                            <span class="pf-title">Name</span>
                                                            <div class="pf-field">
                                                                <input type="text" placeholder="My Name"
                                                                    name="name"
                                                                    value="{{ $empUserInfo->name }}" />
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <span class="pf-title">Email</span>
                                                            <div class="pf-field">
                                                                <input type="email" placeholder="Email"
                                                                    name="email"
                                                                    value="{{ $empUserInfo->email }}" />
                                                            </div>
                                                        </div>
                                                        {{-- <div class="col-lg-12">
                                                            <button type="submit">Update</button>
                                                        </div> --}}
                                                    </div>
                                                </form>
                                            </div>
                                            <div class="contact-edit" id="ci">
                                                <h3>You applied job</h3>
                                                <table class="table">
                                                    <thead>
                                                        <tr>
                                                            <th scope="col">SL</th>
                                                            <th scope="col">Name</th>
                                                            <th scope="col">Department</th>
                                                            <th scope="col">Designation</th>
                                                            <th scope="col">Status</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($appliedJobs as $item)
                                                            <tr>
                                                                <th scope="row">{{ $loop->index + 1 }}</th>
                                                                <td>{{ $item->name }}</td>
                                                                <td>{{ $item->Department??'N/A' }}</td>
                                                                <td>{{ $item->job_designation != null ? $item->job_designation : $item->emp_designation }}</td>
                                                                <td>{{ $item->status == 0 ? 'Pending' : ($item->status == 1 ? 'Processing' : ($item->status == 2 ? 'Selected' : ($item->status == 3 ? 'Rejected' : 'Nothing'))) }}
                                                                </td>
                                                            </tr>
                                                        @endforeach


                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="v-pills-profile" role="tabpanel"
                                            aria-labelledby="v-pills-profile-tab" tabindex="0">...</div>
                                    @else
                                        <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel"
                                            aria-labelledby="v-pills-home-tab" tabindex="0">
                                            <div class="profile-title" id="mp">
                                                <h3>My Profile</h3>
                                            </div>
                                            <div class="profile-form-edit">
                                                <form>
                                                    <div class="row">
                                                        <div class="col-lg-6">
                                                            <span class="pf-title">Name</span>
                                                            <div class="pf-field">
                                                                <input type="text" placeholder="My Name"
                                                                    name="name" value="{{ $empUser->name }}" />
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <span class="pf-title">Email</span>
                                                            <div class="pf-field">
                                                                <input type="email" placeholder="Email"
                                                                    name="email" value="{{ $empUser->email }}" />
                                                            </div>
                                                        </div>
                                                        {{-- <div class="col-lg-12">
                                                            <button type="submit">Update</button>
                                                        </div> --}}
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="v-pills-profile" role="tabpanel"
                                            aria-labelledby="v-pills-profile-tab" tabindex="0">...</div>
                                    @endif


                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <script src="{{ asset('career/profile') }}/js/jquery.min.js" type="text/javascript"></script>
    <script src="{{ asset('career/profile') }}/js/modernizr.js" type="text/javascript"></script>
    <script src="{{ asset('career/profile') }}/js/script.js" type="text/javascript"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous">
    </script>
        <!-- sweetalert2 JavaScript file -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.2/dist/sweetalert2.min.js"></script>
    <script src="{{ asset('career/profile') }}/js/wow.min.js" type="text/javascript"></script>
    <script src="{{ asset('career/profile') }}/js/slick.min.js" type="text/javascript"></script>
    <script src="{{ asset('career/profile') }}/js/parallax.js" type="text/javascript"></script>
    <script src="{{ asset('career/profile') }}/js/select-chosen.js" type="text/javascript"></script>
    <script src="{{ asset('career/profile') }}/js/jquery.scrollbar.min.js" type="text/javascript"></script>
    <script src="{{ asset('career/profile') }}/js/tag.js" type="text/javascript"></script>
    <script src="{{ asset('career/profile') }}/js/maps3.js" type="text/javascript"></script>
    <script
        src="http://maps.googleapis.com/maps/api/js?key=AIzaSyCYc537bQom7ajFpWE5sQaVyz1SQa9_tuY&sensor=true&libraries=places">
    </script>
    @if (session('success'))
    <script>
        // Display the toaster message using SweetAlert2
        Swal.fire({
            icon: 'success',
            title: 'Success',
            text: "{{ session('success') }}",
        });
    </script>
    @endif
    @if (session('already_exists_message'))
    <script>
        // Display the "Already Exists" message using SweetAlert2
        Swal.fire({
            icon: 'warning',
            title: 'Already Exists',
            text: "{{ session('already_exists_message') }}",
        });
    </script>
    @endif
</body>

</html>
