@extends('admin.layouts.backend-layout')

@section('breadcame')
    Email Configuration
@endsection

@section('admin-content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <form id="emailConfigForm" action="{{ route('email.config.update') }}" method="POST">
                        @csrf
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="mail_host" class="text-3xl required">Mail Host</label>
                                    <input type="text" class="form-control" id="mail_host" name="MAIL_HOST"
                                        value="{{ old('MAIL_HOST', config('mail.mailers.smtp.host')) }}">
                                    @error('MAIL_HOST')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="mail_username" class="text-3xl required">Mail Username</label>
                                    <input type="text" class="form-control" id="mail_username" name="MAIL_USERNAME"
                                        value="{{ old('MAIL_USERNAME', config('mail.mailers.smtp.username')) }}">
                                    @error('MAIL_USERNAME')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="mail_password" class="text-3xl required">Mail Password</label>
                                    <input type="password" class="form-control" id="mail_password" name="MAIL_PASSWORD"
                                        value="{{ old('MAIL_PASSWORD', config('mail.mailers.smtp.password')) }}">
                                    @error('MAIL_PASSWORD')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="mail_from_address" class="text-3xl required">Mail From Address</label>
                                    <input type="email" class="form-control" id="mail_from_address"
                                        name="MAIL_FROM_ADDRESS"
                                        value="{{ old('MAIL_FROM_ADDRESS', config('mail.from.address')) }}">
                                    @error('MAIL_FROM_ADDRESS')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <button id="emailConfigSubmit" type="" class="btn btn-primary mt-3">
                            <span id="spinner-email-config-submit" class="spinner-border spinner-border-sm me-2 d-none"
                                role="status" aria-hidden="true"></span>
                            <i class="fas fa-upload"></i> Save Configuration
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('custom-js')
    <script>
        $(document).ready(function() {
            $('#emailConfigForm').on('submit', function(e) {
                e.preventDefault(); // Prevent default form submission

                var $form = $(this);
                var $button = $('#emailConfigSubmit');
                var $spinner = $('#spinner-email-config-submit');

                $button.prop('disabled', true); // Disable the submit button
                $spinner.removeClass('d-none'); // Show the spinner

                $.ajax({
                    url: $form.attr('action'),
                    type: 'POST',
                    data: $form.serialize(),
                    success: function(response) {
                        // Handle success
                        if (response.status == 'success') {
                            toastr.success(response.message);
                        } else {
                            toastr.success(response.message);
                        }
                    },
                    error: function(xhr) {
                        var errors = xhr.responseJSON.errors;
                        $.each(errors, function(key, value) {
                            toastr.error(value); // Displaying each error message
                        });
                    },
                    complete: function() {
                        $button.prop('disabled', false); // Enable the submit button
                        $spinner.addClass('d-none'); // Hide the spinner
                    }
                });
            });
        });
    </script>
@endpush
