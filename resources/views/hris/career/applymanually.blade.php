<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Apply Job|{{ getHostInfo()['name'] }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="author" content="CreativeLayers">

    <!-- Styles -->
    <link rel="shortcut icon" href="{{ url('images/DrawHouse-Logo (1).png') }}" />
    {{-- <link rel="stylesheet" type="text/css" href="{{ asset('career/profile') }}/css/style.css" /> --}}
    <link rel="stylesheet" type="text/css" href="{{ asset('career/profile') }}/css/responsive.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.2/dist/sweetalert2.min.css">
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
        
        <section id="content">
            <div class="content-wrap job-post-page">
                <div class="container clearfix py-3 py-md-6">
                    <div class="row col-mb-50">
                        <div class="col-12 col-lg-2">

                        </div>
                        <!--Job Post-->
                        <div class="col-12 col-lg-8">
                             <div>
                                <a href="{{ route('careers') }}" class="btn btn-secondary">Back</a>
                             </div>
                            <form action="{{ route('apply.job.manually') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="mb-3">
                                  <label for="name" class="form-label">Name:</label>
                                  <input type="text" placeholder="Name" class="form-control" id="name" name="name" value="{{ old('name',Auth::guard('empuser')->user()->name) }}">
                                  @error('name')
                                   <div class="text-danger">{{ $message }}</div>
                                  @enderror
                                </div>
                                <div class="mb-3">
                                  <label for="email" class="form-label">Email:</label>
                                  <input type="email" placeholder="Email" class="form-control" id="email" name="email" value="{{ old('email',Auth::guard('empuser')->user()->email) }}">
                                  @error('email')
                                       <div class="text-danger">{{ $message }}</div>
                                  @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="phone" class="form-label">Phone:</label>
                                    <input type="tel" placeholder="Phone" class="form-control" value="{{ old('phone') }}" id="phone" name="phone" required>
                                    @error('phone')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                  <label for="designation" class="form-label">Designation:</label>
                                   <select class="form-control" name="designation_id">
                                        <option value="" selected>--Select One--</option>
                                        @foreach ($desgs as $item)
                                        <option {{ $item->id == old('designation_id') ?'selected':''}} value="{{ $item->id }}">{{ $item->Designation }}</option>
                                        @endforeach                                     
                                   </select>
                                   @error('designation_id')
                                    <div class="text-danger">{{ $message }}</div>
                                   @enderror
                                </div>
                                <div class="mb-3">
                                  <label for="cv" class="form-label">CV:</label>
                                  <input type="file" class="form-control" id="cv" name="cv" accept=".pdf, .doc, .docx" required>
                                  @error('cv')
                                        <div class="text-danger">{{ $message }}</div>
                                  @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="nidno" class="form-label">National ID No:</label>
                                    <input type="text" placeholder="National ID No" value="{{ old('NationalIDNo') }}" class="form-control" id="nidno" name="NationalIDNo" required>
                                    @error('NationalIDNo')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                  </div>
                                <div class="mb-3">
                                  <label for="nid" class="form-label">National ID:</label>
                                  <input type="file" class="form-control" id="nid" name="nid" required>
                                  @error('nid')
                                        <div class="text-danger">{{ $message }}</div>
                                  @enderror
                                </div>
                               
                                <button type="submit" class="btn btn-primary">Submit</button>
                              </form>
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.2/dist/sweetalert2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous">
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
