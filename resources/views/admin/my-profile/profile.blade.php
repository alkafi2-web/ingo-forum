@extends('admin.layouts.backend-layout')
@section('breadcame')
    My Profile
@endsection
@section('admin-content')
    <div class="row g-5 das_board">
        <div class="card">
            <div class="card-header">
                <h2 class="pt-5 " id="add-header">My Profile</h2>
            </div>
            <div class="card-body">
                <!--begin::Form-->
                <form class="form w-100 fv-plugins-bootstrap5 fv-plugins-framework" novalidate="novalidate" id="sign_up_form">
                    <div class="row">
                        <!--begin::Col-->
                        <div class="col-md-6 mb-7 fv-row fv-plugins-icon-container">
                            <label class="form-label fw-bolder text-dark fs-6 required">Name</label>
                            <input class="form-control form-control-lg form-control-solid" type="text" placeholder=""
                                name="first-name" id="name" autocomplete="off" value="{{ $user->name }}">
                        </div>
                        <!--end::Col-->

                        <!--begin::Col-->
                        <div class="col-md-6 mb-7 fv-row fv-plugins-icon-container">
                            <label class="form-label fw-bolder text-dark fs-6 required">Email</label>
                            <input class="form-control form-control-lg form-control-solid" type="email" placeholder=""
                                name="email" id="email" autocomplete="off" value="{{ $user->email }}">
                        </div>
                        <!--end::Col-->
                    </div>

                    <div class="row">
                        <!--begin::Col-->
                        <div class="col-md-6 mb-7 fv-row fv-plugins-icon-container">
                            <label class="form-label fw-bolder text-dark fs-6 required">Image</label>
                            <input class="form-control form-control-lg form-control-solid" type="file" name="image"
                                id="image" oninput="pp.src=window.URL.createObjectURL(this.files[0])">
                            <img id="pp" width="200" class="float-start mt-3 d-block" src="{{ $user->image ? asset('public/frontend/images/profile/' . $user->image) : asset('public/frontend/images/member/placeholder.jpg') }}">
                        </div>
                        <!--end::Col-->

                        <!--begin::Col-->
                        <div class="col-md-6 mb-7 fv-row fv-plugins-icon-container" data-kt-password-meter="true">
                            <!--begin::Wrapper-->
                            <div class="mb-1">
                                <!--begin::Label-->
                                <label class="form-label fw-bolder text-dark fs-6 required">Password</label>
                                <!--end::Label-->
                                <!--begin::Input wrapper-->
                                <div class="position-relative">
                                    <input class="form-control form-control-lg form-control-solid" type="password"
                                        placeholder="" name="password" autocomplete="off" id="password">
                                    <span class="btn btn-sm btn-icon position-absolute translate-middle top-50 end-0 me-n2"
                                        data-kt-password-meter-control="visibility">
                                        <i class="bi bi-eye-slash fs-2"></i>
                                        <i class="bi bi-eye fs-2 d-none"></i>
                                    </span>
                                </div>
                                <!--end::Input wrapper-->
                            </div>
                            <!--end::Wrapper-->
                        </div>
                        <!--end::Col-->
                    </div>

                    <!--begin::Actions-->
                    <div class="text-center">
                        <button id="user-submit" type="submit" class="btn btn-primary mt-3 mr-2">
                            <i class="fas fa-store"></i> Update
                        </button>
                    </div>
                    <!--end::Actions-->
                </form>
                <!--end::Form-->

            </div>
        </div>
    </div>
@endsection


@push('custom-js')
    <script>
        $(document).ready(function() {

            $('#user-submit').on('click', function(e) {
                e.preventDefault();
                let url = "{{ route('user.profile.update') }}";
                let form = $('#sign_up_form')[0];
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
                        var success = response.success;
                        $.each(success, function(key, value) {
                            toastr.success(value); // Displaying each error message
                        });
                    },
                    error: function(xhr) {
                        var errors = xhr.responseJSON.errors;
                        // Iterate through each error and display it
                        $.each(errors, function(key, value) {
                            console.log(key, value);
                            toastr.error(value); // Displaying each error message
                        });
                    }
                });

            });
        });
    </script>
@endpush
