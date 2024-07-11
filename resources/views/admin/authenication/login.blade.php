<!DOCTYPE html>

<html lang="en">
<!--begin::Head-->

<head>
    <title>INGO Forum</title>
    <meta name="description"
        content="Ingo Forum login" />
    <meta name="keywords"
        content="Metronic, bootstrap, bootstrap 5, Angular, VueJs, React, Laravel, admin themes, web design, figma, web development, free templates, free admin themes, bootstrap theme, bootstrap template, bootstrap dashboard, bootstrap dak mode, bootstrap button, bootstrap datepicker, bootstrap timepicker, fullcalendar, datatables, flaticon" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta charset="utf-8" />
    <meta property="og:locale" content="en_US" />
    <meta property="og:type" content="article" />
    <meta property="og:title"
        content="Metronic - Bootstrap 5 HTML, VueJS, React, Angular &amp; Laravel Admin Dashboard Theme" />
    <meta property="og:url" content="https://keenthemes.com/metronic" />
    <meta property="og:site_name" content="Keenthemes | Metronic" />
    <link rel="canonical" href="https://preview.keenthemes.com/metronic8" />
    <link rel="shortcut icon" href="assets/media/logos/favicon.ico" />
    <!--begin::Fonts-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
    <!--end::Fonts-->
    <!--begin::Global Stylesheets Bundle(used by all pages)-->
    <link href="{{ asset('public/admin/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('public/admin/css/style.bundle.css') }}" rel="stylesheet" type="text/css" />
    <!--end::Global Stylesheets Bundle-->
    {{-- kk start --}}
    <!-- Toastr CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

</head>
<!--end::Head-->
<!--begin::Body-->

<body id="kt_body" class="bg-body">
    <!--begin::Main-->
    <div class="d-flex flex-column flex-root">
        <!--begin::Authentication - Sign-in -->
        <div class="d-flex flex-column flex-column-fluid bgi-position-y-bottom position-x-center bgi-no-repeat bgi-size-contain bgi-attachment-fixed"
            style="background-image: url({{ asset('public/admin/media/illustrations/sketchy-1/14.png') }}">
            <!--begin::Content-->
            <div class="d-flex flex-center flex-column flex-column-fluid p-10 pb-lg-20">

                <!--begin::Wrapper-->
                <div class="w-lg-500px bg-body rounded shadow-sm p-10 p-lg-15 mx-auto">
                    <!--begin::Form-->
                    <form class="form w-100" novalidate="novalidate" id="kt_sign_in_form"
                        action="{{ route('login') }}" method="POST">
                        @csrf
                        <div class="text-center mb-10">
                            <h1 class="text-dark mb-3">Log In to
                                <img alt="Logo" src="{{ asset('public/frontend/images/logo.png') }}"
                                    class="h-40px" />
                            </h1>
                        </div>
                        <div class="fv-row mb-10">
                            <label class="form-label fs-6 fw-bolder text-dark">Email</label>
                            <input class="form-control form-control-lg form-control-solid" type="text" name="email"
                                autocomplete="off" />
                            <span class="text-danger" id="email-error"></span>
                        </div>
                        <div class="fv-row mb-10">
                            <div class="d-flex flex-stack mb-2">
                                <label class="form-label fw-bolder text-dark fs-6 mb-0">Password</label>
                            </div>
                            <input class="form-control form-control-lg form-control-solid" type="password"
                                name="password" autocomplete="off" />
                            <span class="text-danger" id="password-error"></span>
                        </div>
                        <div class="text-center">
                            <button type="button" id="kt_sign_in_submit" class="btn btn-lg btn-primary w-100 mb-5">
                                <span class="indicator-label">Login</span>
                                <span class="indicator-progress">Please wait...
                                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                </span>
                            </button>
                        </div>
                    </form>

                    <!--end::Form-->
                </div>
                <!--end::Wrapper-->
            </div>
            <!--end::Content-->
            <!--begin::Footer-->
            <div class="d-flex flex-center flex-column-auto p-10">
                <!--begin::Links-->
                <div class="d-flex align-items-center fw-bold fs-6">
                    <a href="#" class="text-muted text-hover-primary px-2">About</a>
                    <a href="#" class="text-muted text-hover-primary px-2">Contact</a>
                    <a href="#" class="text-muted text-hover-primary px-2">Contact Us</a>
                </div>
                <!--end::Links-->
            </div>
            <!--end::Footer-->
        </div>
        <!--end::Authentication - Sign-in-->
    </div>
    <!--end::Main-->
    <script>
        var hostUrl = "assets/";
    </script>
    <!--begin::Javascript-->
    <!--begin::Global Javascript Bundle(used by all pages)-->
    <script src="{{ asset('public/admin/plugins/global/plugins.bundle.js') }}"></script>
    <script src="{{ asset('public/admin/js/scripts.bundle.js') }}"></script>
    <!--end::Global Javascript Bundle-->
    <!--begin::Page Custom Javascript(used by this page)-->
    {{-- <script src="{{ asset('public/admin/js/custom/authentication/sign-in/general.js') }}"></script> --}}
    <!--end::Page Custom Javascript-->

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Toastr JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <!-- Initialize Toastr -->
    {!! Toastr::message() !!}

    <script>
        $(document).ready(function() {
            $('#kt_sign_in_submit').on('click', function(e) {
                e.preventDefault();
                let form = $('#kt_sign_in_form');
                let url = form.attr('action');
                let formData = form.serialize();

                $.ajax({
                    type: 'POST',
                    url: url,
                    data: formData,
                    beforeSend: function() {
                        $('#kt_sign_in_submit .indicator-progress').show();
                        $('#kt_sign_in_submit .indicator-label').hide();
                    },
                    success: function(response) {
                        window.location.href = response.redirect;
                    },
                    error: function(xhr) {
                        var errors = xhr.responseJSON.errors;
                        // Iterate through each error and display it
                        $.each(errors, function(key, value) {
							console.log(key,value);
                            toastr.error(value); // Displaying each error message
                        });

                    },
                    complete: function() {
                        // Action after the request completes (both success and error)
                        $('#kt_sign_in_submit .indicator-progress').hide();
                        $('#kt_sign_in_submit .indicator-label').show();
                    }
                });
            });
        });
    </script>


    <!--end::Javascript-->
</body>
<!--end::Body-->

</html>
