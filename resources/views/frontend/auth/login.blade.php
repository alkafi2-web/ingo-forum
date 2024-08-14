@extends('frontend.layouts.frontend-page-layout')
@section('page-title')
    Login
@endsection
@section('frontend-section')
    <!-- Membership Area start here  -->
    <section class="membership-area ptb-50">
        <div class="container">
            <div class="row">
                <div class="col-md-7 mx-auto">
                    <div class="register-card">
                        <div class="register-card-header border-bottom">
                            <h2 class="section-title text-center">Membership Login Form</h2>
                        </div>
                        <form id="member-form" action="" method="post">
                            <div class="row pt-2 justify-content-center">
                                <!-- Member Access Credential Section -->
                                <div class="col-12 ml-auto">
                                    <div class="row pt-2 justify-content-center">
                                        <div class="col-12 mb-3">
                                            <div class="row align-items-center">
                                                <div class="col-md-4">
                                                    <label for="login_email" class="form-label required">Email (For
                                                        Login)</label>
                                                </div>
                                                <div class="col-md-8">
                                                    {{-- <label for="login_email" class="form-label required">Email (For Login)</label> --}}
                                                    <input type="email" name="login_email" class="form-control"
                                                        id="login_email" placeholder="Email" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 mb-3">
                                            <div class="row align-items-center">
                                                <div class="col-md-4">
                                                    <label for="password" class="form-label required">Password</label>
                                                </div>
                                                <div class="col-md-8">
                                                    <input type="password" name="password" class="form-control"
                                                        id="password" placeholder="Password" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 mb-3">
                                            <div class="row align-items-center">
                                                <div class="col-md-4"></div>
                                                <div class="col-md-8">
                                                    <div class="d-flex align-items-center justify-content-between">
                                                        <button type="submit" id="member-submit" class="submit-btn">
                                                            Login
                                                            <span id="login-spinner"
                                                                class="spinner-border spinner-border-sm ms-2 d-none"
                                                                role="status" aria-hidden="true"></span>
                                                        </button>
                                                        <a href="{{ route('password.request') }}" class="fs-12px">Forgot
                                                            Your Password?</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Membership Area end here  -->
@endsection
@push('custom-js')
    <script>
        $(document).ready(function() {
            $('#member-submit').on('click', function(e) {
                e.preventDefault();
                $('#login-spinner').removeClass('d-none');
                $(this).prop('disabled', true);
                let url = "{{ route('frontend.login.post') }}";
                let form = $('#member-form')[0];
                let formData = new FormData(form);
                $.ajax({
                    type: 'POST',
                    url: url,
                    data: formData,
                    processData: false, // Prevent jQuery from processing the data
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        $('#login-spinner').addClass('d-none');
                        $('#member-submit').prop('disabled', false);
                        // toastr.success(response.message);
                        window.location.href = response.redirect;
                    },
                    error: function(xhr) {
                        $('#login-spinner').addClass('d-none');
                        $('#member-submit').prop('disabled', false);
                        var errors = xhr.responseJSON.errors;
                        // Iterate through each error and display it
                        $.each(errors, function(key, value) {
                            toastr.error(value); // Displaying each error message
                        });
                    }
                });

            });
        });
    </script>
@endpush
