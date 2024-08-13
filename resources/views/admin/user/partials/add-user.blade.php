<!--begin::Form-->
<form class="form w-100 fv-plugins-bootstrap5 fv-plugins-framework" novalidate="novalidate" id="sign_up_form">
    <!--begin::Input group-->
    <div class="row fv-row mb-7 fv-plugins-icon-container">
        <!--begin::Col-->
        <div class="col-xl-12">
            <label class="form-label fw-bolder text-dark fs-6 required">Name</label>
            <input class="form-control form-control-lg form-control-solid" type="text" placeholder="" name="first-name"
                id="name" autocomplete="off">
            <div class="fv-plugins-message-container invalid-feedback"></div>
        </div>
        <!--end::Col-->
    </div>
    <!--end::Input group-->
    <!--begin::Input group-->
    <div class="fv-row mb-7 fv-plugins-icon-container">
        <label class="form-label fw-bolder text-dark fs-6 required">Email</label>
        <input class="form-control form-control-lg form-control-solid" type="email" placeholder="" name="email"
            id="email" autocomplete="off">
        <div class="fv-plugins-message-container invalid-feedback"></div>
    </div>
    <!--end::Input group-->
    <!--begin::Input group-->
    <div class="mb-10 fv-row fv-plugins-icon-container" data-kt-password-meter="true">
        <!--begin::Wrapper-->
        <div class="mb-1">
            <!--begin::Label-->
            <label class="form-label fw-bolder text-dark fs-6 required">Password</label>
            <!--end::Label-->
            <!--begin::Input wrapper-->
            <div class="position-relative">
                <input class="form-control form-control-lg form-control-solid" type="password" placeholder=""
                    name="password" autocomplete="off" id="password">
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
    <!--end::Input group=-->
    <!--begin::Input group-->
    <div class="mb-10 fv-row fv-plugins-icon-container" data-kt-password-meter="true">
        <!--begin::Wrapper-->
        <div class="mb-1">
            <!--begin::Label-->
            <label class="form-label fw-bolder text-dark fs-6 required">Your Password</label>
            <!--end::Label-->
            <!--begin::Input wrapper-->
            <div class="position-relative">
                <input class="form-control form-control-lg form-control-solid" type="password" placeholder=""
                    name="own-password" autocomplete="off" id="own-password">
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
    <!--end::Input group-->
    <!--begin::Input group-->
    <div class="fv-row mb-7 fv-plugins-icon-container">
        <label class="form-label fw-bolder text-dark fs-6 required">Role</label>
        <select class="form-control form-control-lg form-control-solid" name="role" id="role">
            <option value="" disabled selected>Select Role</option>
            @forelse ($roles as $role)
                <option value="{{ $role->name }}">{{ ucfirst($role->name) }}</option>
            @empty
            @endforelse
            <!-- Add more roles as needed -->
        </select>
        <div class="fv-plugins-message-container invalid-feedback"></div>
    </div>
    <!--end::Input group-->
    <!--begin::Actions-->
    <div class="text-center">
        <button id="user-submit" type="submit" class="btn btn-primary mt-3">
            <span id="spinner-user-submit" class="spinner-border spinner-border-sm me-2 d-none" role="status"
                aria-hidden="true"></span>
            <i class="fas fa-store"></i> Submit
        </button>

        <button id="user-update" type="submit" class="btn btn-primary mt-3 d-none">
            <span id="spinner-user-update" class="spinner-border spinner-border-sm me-2 d-none" role="status"
                aria-hidden="true"></span>
            <i class="fas fa-wrench"></i> Update
        </button>
        <button id="page-refresh" type="submit" class="btn btn-secondary mt-3 d-none"><i class="fas fa-sync-alt"></i>
            Refresh</button>
    </div>
    <!--end::Actions-->
</form>
<!--end::Form-->

@push('custom-js')
    <script>
        $(document).ready(function() {

            $('#user-submit').on('click', function(e) {
                e.preventDefault();
                $('#spinner-user-submit').removeClass('d-none'); // Show the spinner
                $(this).prop('disabled', true);
                let url = "{{ route('register') }}";
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
                        $('#spinner-user-submit').addClass('d-none'); // Show the spinner
                        $('#user-submit').prop('disabled', false);
                        var success = response.success;
                        $.each(success, function(key, value) {
                            toastr.success(value); // Displaying each error message
                        });
                        $('#sign_up_form')[0].reset();
                        $('#user-list-data').DataTable().ajax.reload(null, false);
                    },
                    error: function(xhr) {
                        $('#spinner-user-submit').addClass('d-none'); // Show the spinner
                        $('#user-submit').prop('disabled', false);
                        var errors = xhr.responseJSON.errors;
                        // Iterate through each error and display it
                        $.each(errors, function(key, value) {
                            toastr.error(value); // Displaying each error message
                        });
                    }
                });

            });
            $('#user-update').on('click', function(e) {
                e.preventDefault();
                $('#spinner-user-update').removeClass('d-none'); // Show the spinner
                $(this).prop('disabled', true);
                let url = "{{ route('user.update') }}";
                let id = $(this).attr('data-id');
                let form = $('#sign_up_form')[0];
                let formData = new FormData(form);
                formData.append('id', id);
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
                        $('#spinner-user-update').addClass('d-none'); // hide the spinner
                        $('#user-update').prop('disabled', true);
                        var success = response.success;
                        $.each(success, function(key, value) {
                            toastr.success(value); // Displaying each error message
                        });
                        $('#add-header').text('Add User');
                        $('#sign_up_form')[0].reset();
                        $('#user-list-data').DataTable().ajax.reload(null, false);
                        $('#delete-user-list-data').DataTable().ajax.reload(null, false);
                        $('#user-submit').removeClass('d-none');
                        $('#user-update').addClass('d-none');
                        $('#page-refresh').addClass('d-none');

                    },
                    error: function(xhr) {
                        $('#spinner-user-update').addClass('d-none'); // hide the spinner
                        $('#user-update').prop('disabled', true);
                        var errors = xhr.responseJSON.errors;
                        // Iterate through each error and display it
                        $.each(errors, function(key, value) {
                            toastr.error(value); // Displaying each error message
                        });
                    }
                });

            });
            $('#page-refresh').on('click', function(e) {
                e.preventDefault();
                $('#add-header').text('Add User');
                $('#sign_up_form')[0].reset();
                $('#user-data-list').DataTable().ajax.reload(null, false);
                $('#user-submit').removeClass('d-none');
                $('#user-update').addClass('d-none');
                $('#page-refresh').addClass('d-none');
            });
        });
    </script>
@endpush
