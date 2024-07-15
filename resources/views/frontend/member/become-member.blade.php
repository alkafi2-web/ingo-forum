@extends('frontend.layouts.frontend-page-layout')
@section('page-title')
    Become A Member
@endsection
@section('fontend-section')
    <!-- Membership Area start here  -->
    <section class="membership-area ptb-50">
        <div class="container">
            <div class="register-card">
                <div class="register-card-header border-bottom">
                    <h2 class="section-title text-center">Membership Request Form</h2>
                    <p class="text-center">Please let us know you before we proceed with the registration.</p>
                </div>
                <form id="member-form" action="" method="post">
                    <div class="row">
                        <!-- Organisation Details Section -->
                        <div class="col-lg-6 mb-3 mb-lg-0">
                            <h4 class="form-title border-bottom pb-2 pt-3">Your Organisation Details</h4>
                            <div class="row details-border mobile-border-none pt-2">
                                <div class="col-12 mb-3">
                                    <div class="row align-items-center">
                                        <div class="col-md-4">
                                            <label for="org_name" class="form-label required">Organisation Name</label>
                                        </div>
                                        <div class="col-md-8">
                                            <input type="text" name="org_name" class="form-control required"
                                                id="org_name" placeholder="Your Organisation Name" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 mb-3">
                                    <div class="row align-items-center">
                                        <div class="col-md-4">
                                            <label for="org_website" class="form-label required">Organisation
                                                Website</label>
                                        </div>
                                        <div class="col-md-8">
                                            <input type="text" name="org_website" class="form-control" id="org_website"
                                                placeholder="Your Organisation Website" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 mb-3">
                                    <div class="row align-items-center">
                                        <div class="col-md-4">
                                            <label for="org_email" class="form-label required">Organisation
                                                Email</label>
                                        </div>
                                        <div class="col-md-8">
                                            <input type="email" name="org_email" class="form-control" id="org_email"
                                                placeholder="Organisation Email" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 mb-3">
                                    <div class="row align-items-center">
                                        <div class="col-md-4">
                                            <label for="org_type" class="form-label required">Organisation Type</label>
                                        </div>
                                        <div class="col-md-8">
                                            <select name="org_type" class="form-select" id="org_type"
                                                aria-label="Organisation Type" required>
                                                <option disabled selected>Organisation Type</option>
                                                <option value="1">Registered with NGO Affairs Bureau (NGOAB) as an
                                                    INGO</option>
                                                <option value="2">Possess international governance structures
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 mb-3">
                                    <div class="row align-items-center">
                                        <div class="col-md-4">
                                            <label for="org_address" class="form-label required">Organisation
                                                Address</label>
                                        </div>
                                        <div class="col-md-8">
                                            <input type="text" name="org_address" class="form-control" id="org_address"
                                                placeholder="Organisation Address" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Company Director Details Section -->
                        <div class="col-lg-6 mb-3 mb-lg-0">
                            <h4 class="form-title border-bottom pb-2 pt-3">Your Company Director Details</h4>
                            <div class="">
                                <div class="row pt-2">
                                    <div class="col-12 mb-3">
                                        <div class="row align-items-center">
                                            <div class="col-md-4">
                                                <label for="director_name" class="form-label required">Country Director
                                                    Name</label>
                                            </div>
                                            <div class="col-md-8">
                                                <input type="text" name="director_name" class="form-control"
                                                    id="director_name" placeholder="Country Director Name" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 mb-3">
                                        <div class="row align-items-center">
                                            <div class="col-md-4">
                                                <label for="director_email" class="form-label required">Country Director
                                                    Email (Personal)</label>
                                            </div>
                                            <div class="col-md-8">
                                                <input type="email" name="director_email" class="form-control"
                                                    id="director_email" placeholder="Country Director Email" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 mb-3">
                                        <div class="row align-items-center">
                                            <div class="col-md-4">
                                                <label for="director_phone" class="form-label">Phone</label>
                                            </div>
                                            <div class="col-md-8">
                                                <input type="text" name="director_phone" class="form-control"
                                                    id="director_phone" placeholder="Phone">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Member Access Credential Section -->
                        <div class="col-12">
                            <h4 class="form-title border-bottom pb-2 pt-3">Member Access Credential</h4>
                            <div class="row pt-2">
                                <div class="col-lg-6 mb-3">
                                    <div class="row align-items-center">
                                        <div class="col-md-4">
                                            <label for="login_email" class="form-label required">Email (For
                                                Login)</label>
                                        </div>
                                        <div class="col-md-8">
                                            <input type="email" name="login_email" class="form-control"
                                                id="login_email" placeholder="Email" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 mb-3">
                                    <div class="row align-items-center">
                                        <div class="col-md-4">
                                            <label for="login_phone" class="form-label">Phone</label>
                                        </div>
                                        <div class="col-md-8">
                                            <input type="text" name="login_phone" class="form-control"
                                                id="login_phone" placeholder="Phone">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 mb-3">
                                    <div class="row align-items-center">
                                        <div class="col-md-4">
                                            <label for="password" class="form-label required">Password</label>
                                        </div>
                                        <div class="col-md-8">
                                            <input type="password" name="password" class="form-control" id="password"
                                                placeholder="Password" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 mb-3">
                                    <div class="row align-items-center">
                                        <div class="col-md-4">
                                            <label for="password_confirmation" class="form-label required">Confirm Password</label>
                                        </div>
                                        <div class="col-md-8">
                                            <input type="password" name="password_confirmation" class="form-control" id="password_confirmation" placeholder="Confirm Password" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 text-end pt-3">
                                    <input type="submit" id="member-submit" value="Send" class="submit-btn">
                                </div>
                            </div>
                        </div>
                    </div>
                </form>

                <div class="register-card-footer"></div>
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
                let url = "{{ route('member.register') }}";
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
                        console.log(response)
                        var success = response.success;
                        $.each(success, function(key, value) {
                            toastr.success(value); // Displaying each error message
                        });
                        $('#member-form')[0].reset();
                    },
                    error: function(xhr) {
                      toastr.error('this is from error');
                        var errors = xhr.responseJSON.errors;
                        // Iterate through each error and display the message using Toastr
                        $.each(errors, function(key, value) {
                          console.log(value[0]);
                            toastr.error(value[0]); // Displaying the first error message for each field
                        });
                    }
                });

            });
        });
    </script>
@endpush
