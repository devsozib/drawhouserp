@extends('layout.app')
@section('title', 'Admin | User')
@section('content')
<style>
    .bootstrap-select.form-control {
        margin-bottom: 0;
        padding: 0;
        border: 1px solid #c7c7c7!important;
        height: auto;
    }
</style>
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Admin Portal<small>-Users</small></h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{!! url('admin/dashboard') !!}">Admin</a></li>
                        <li class="breadcrumb-item"><a href="{!! url('admin/user') !!}">User</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Create</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header with-border">
                        <h3 class="card-title text-center">Register a new user</h3>
                        <div class="float-right"><a href="{!! url('admin/user') !!}" class="btn-sm bg-gradient-info"><i
                                    class="fas fa-arrow-left"></i>&nbsp;Back</a></div>
                    </div>
                    @if ($create)
                        <form action="{{ url('admin/user') }}" method="POST" id="addform">
                            @csrf
                            <div class="card-body register-card-body">
                                <div class="row">
                                   
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="lname">User Type</label>
                                            <select name="user_type" class="form-control" style="width: 100%;"
                                                id="roles" required>
                                                <option value="">Select Type</option>
                                                <option {{ old('user_type') == 'emp'?'selected':'' }} value="emp">Employee</option>
                                                <option {{ old('user_type') == 'guest'?'selected':'' }}  value="guest">Guest</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="EmployeeID">Employee ID</label>
                                            <input type="EmployeeID" name="EmployeeID" class="form-control" id="EmployeeID"
                                                placeholder="Enter Employee ID" value="{{ old('EmployeeID') }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="fullname">Full Name</label>
                                            <input type="text" name="fullname" class="form-control" id="fullname"
                                                placeholder="Enter Full Name" value="{{ old('fullname') }}">
                                        </div>
                                        {{-- <div class="form-group">
                                            <label for="lname">Last Name</label>
                                            <input type="lname" name="lname" class="form-control" id="lname"
                                                placeholder="Enter Last Name" value="{{ old('lname') }}">
                                        </div> --}}
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="email">Email address</label>
                                            <input type="email" name="email" class="form-control" id="email"
                                                placeholder="Enter Email" value="{{ old('email') }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="lname">Role</label>
                                            <select name="roles" class="form-control select2bs4" style="width: 100%;"
                                                id="roles" value="{{ old('roles') }}" required>
                                                <option value="">Select Role</option>
                                                @foreach ($rolelists as $key => $role)
                                                    <option value="{!! $key !!}">{!! $role !!}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        {{-- <div class="form-group">
                                            <label for="company">Company</label>
                                            <select name="company[]" class="form-control select2bs4" multiple="multiple"
                                                style="width: 100%;" id="company" value="{{ old('company.0', '') }}">
                                                <option value="">Select Company</option>
                                                @foreach ($complists as $key => $comp)
                                                    <option value="{!! $key !!}">{!! $comp !!}</option>
                                                @endforeach
                                            </select>
                                        </div> --}}
                                        <div class="form-group">
                                            <label for="company">Company</label>
                                            <select name="company[]" class="form-control selectpicker" multiple  data-live-search="true">                                           
                                                @foreach ($complists as $key => $comp)
                                                <option value="{!! $key !!}">{!! $comp !!}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="phone">Phone</label>
                                            <input type="text" name="phone" class="form-control" id="phone"
                                                placeholder="Phone" value="{{ old('phone') }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="password">Password</label>
                                            <input type="password" name="password" class="form-control" id="password"
                                                placeholder="Password" value="{{ old('password') }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="confirm_password">Confirm Password</label>
                                            <input type="password" name="confirm_password" class="form-control"
                                                id="confirm_password" placeholder="Confirm Password"
                                                value="{{ old('confirm_password') }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer text-right">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    @endif
                </div>
            </div>
        </div>

        <script>
            $(function() {
                $.validator.setDefaults({
                    submitHandler: function() {
                        alert("Form successful submitted!");
                    }
                });
                $('#regform').validate({
                    rules: {
                        fname: {
                            required: true,
                            minlength: 3,
                        },
                        lname: {
                            required: true,
                            minlength: 3,
                        },
                        email: {
                            required: true,
                            email: true,
                        },
                        password: {
                            required: true,
                            minlength: 5
                        },
                    },
                    messages: {
                        fname: {
                            required: "Please enter a first name",
                            fname: "Please enter a valid first name"
                        },
                        lname: {
                            required: "Please enter a last name",
                            lname: "Please enter a valid last name"
                        },
                        email: {
                            required: "Please enter a email address",
                            email: "Please enter a valid email address"
                        },
                        password: {
                            required: "Please provide a password",
                            minlength: "Your password must be at least 5 characters long"
                        },
                    },
                    errorElement: 'span',
                    errorPlacement: function(error, element) {
                        error.addClass('invalid-feedback');
                        element.closest('.form-group').append(error);
                    },
                    highlight: function(element, errorClass, validClass) {
                        $(element).addClass('is-invalid');
                    },
                    unhighlight: function(element, errorClass, validClass) {
                        $(element).removeClass('is-invalid');
                    }
                });
            });
        </script>
    </div>

@stop
