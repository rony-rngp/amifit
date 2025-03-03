<!doctype html>

<html
        lang="en"
        class="light-style layout-wide customizer-hide"
        dir="ltr"
        data-theme="theme-default"
        data-assets-path="{{ asset('backend/assets') }}/"
        data-template="vertical-menu-template-free"
        data-style="light">
<head>
    <meta charset="utf-8" />
    <meta
            name="viewport"
            content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>Admin Login</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('backend/assets') }}/img/favicon/favicon.ico" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
            href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
            rel="stylesheet" />

    <link rel="stylesheet" href="{{ asset('backend/assets') }}/vendor/fonts/boxicons.css" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{ asset('backend/assets') }}/vendor/css/core.css" class="template-customizer-core-css" />
    <link rel="stylesheet" href="{{ asset('backend/assets') }}/vendor/css/theme-default.css" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="{{ asset('backend/assets') }}/css/demo.css" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{ asset('backend/assets') }}/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />

    <!-- Page CSS -->
    <!-- Page -->
    <link rel="stylesheet" href="{{ asset('backend/assets') }}/vendor/css/pages/page-auth.css" />

    <!-- Helpers -->
    <script src="{{ asset('backend/assets') }}/vendor/js/helpers.js"></script>
    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="{{ asset('backend/assets') }}/js/config.js"></script>
</head>

<body>
<!-- Content -->

<div class="container-xxl">
    <div class="authentication-wrapper authentication-basic container-p-y">
        <div class="authentication-inner">
            <!-- Register -->
            <div class="card px-sm-6 px-0">
                <div class="card-body">
                    <!-- Logo -->
                    <div class="app-brand justify-content-center mb-6">
                        <a href="{{ route('admin.login') }}" class="app-brand-link gap-2">
                            <span class="app-brand-text demo text-heading fw-bold">Admin Login</span>
                        </a>
                    </div>
                    <!-- /Logo -->

                    <br>
                    <form class="mb-8" action="{{ route('admin.login') }}" method="post">
                        @csrf
                        <div class="mb-6">
                            <label for="email" class="form-label">Email or Username</label>
                            <input
                                    type="email"
                                    class="form-control"
                                    id="email"
                                    required
                                    name="email"
                                    placeholder="Enter your email or username"
                                    autofocus />
                            <span class="text-danger">{{ $errors->has('email') ? $errors->first('email') : '' }}</span>
                        </div>
                        <div class="mb-6 form-password-toggle">
                            <label class="form-label" for="password">Password</label>
                            <div class="input-group input-group-merge">
                                <input
                                        type="password"
                                        id="password"
                                        required
                                        class="form-control"
                                        name="password"
                                        placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                        aria-describedby="password" />
                                <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                            </div>
                            <span class="text-danger">{{ $errors->has('password') ? $errors->first('password') : '' }}</span>
                        </div>

                        <div class="mb-6">
                            <button class="btn btn-primary d-grid w-100" type="submit">Login</button>
                        </div>
                    </form>


                </div>
            </div>
            <!-- /Register -->
        </div>
    </div>
</div>



<script src="{{ asset('backend/assets') }}/vendor/libs/jquery/jquery.js"></script>
<script src="{{ asset('backend/assets') }}/vendor/libs/popper/popper.js"></script>
<script src="{{ asset('backend/assets') }}/vendor/js/bootstrap.js"></script>
<script src="{{ asset('backend/assets') }}/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
<script src="{{ asset('backend/assets') }}/vendor/js/menu.js"></script>


</body>
</html>
