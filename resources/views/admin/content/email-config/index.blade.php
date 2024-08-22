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
                                    <label for="mail_mailer" class="text-3xl required">Mail Mailer</label>
                                    <input type="text" class="form-control" id="mail_mailer" name="MAIL_MAILER" value="{{ old('MAIL_MAILER', config('mail.mailers.smtp.driver')) }}">
                                    @error('MAIL_MAILER')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="mail_host" class="text-3xl required">Mail Host</label>
                                    <input type="text" class="form-control" id="mail_host" name="MAIL_HOST" value="{{ old('MAIL_HOST', config('mail.mailers.smtp.host')) }}">
                                    @error('MAIL_HOST')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="mail_port" class="text-3xl required">Mail Port</label>
                                    <input type="text" class="form-control" id="mail_port" name="MAIL_PORT" value="{{ old('MAIL_PORT', config('mail.mailers.smtp.port')) }}">
                                    @error('MAIL_PORT')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="mail_username" class="text-3xl required">Mail Username</label>
                                    <input type="text" class="form-control" id="mail_username" name="MAIL_USERNAME" value="{{ old('MAIL_USERNAME', config('mail.mailers.smtp.username')) }}">
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
                                    <input type="password" class="form-control" id="mail_password" name="MAIL_PASSWORD" value="{{ old('MAIL_PASSWORD', config('mail.mailers.smtp.password')) }}">
                                    @error('MAIL_PASSWORD')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="mail_encryption" class="text-3xl required">Mail Encryption</label>
                                    <input type="text" class="form-control" id="mail_encryption" name="MAIL_ENCRYPTION" value="{{ old('MAIL_ENCRYPTION', config('mail.mailers.smtp.encryption')) }}">
                                    @error('MAIL_ENCRYPTION')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="mail_from_address" class="text-3xl required">Mail From Address</label>
                                    <input type="email" class="form-control" id="mail_from_address" name="MAIL_FROM_ADDRESS" value="{{ old('MAIL_FROM_ADDRESS', config('mail.from.address')) }}">
                                    @error('MAIL_FROM_ADDRESS')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="mail_from_name" class="text-3xl required">Mail From Name</label>
                                    <input type="text" class="form-control" id="mail_from_name" name="MAIL_FROM_NAME" value="{{ old('MAIL_FROM_NAME', config('mail.from.name')) }}">
                                    @error('MAIL_FROM_NAME')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <button id="emailConfigSubmit" type="submit" class="btn btn-primary mt-3">
                            <span id="spinner-email-config-submit" class="spinner-border spinner-border-sm me-2 d-none" role="status" aria-hidden="true"></span>
                            <i class="fas fa-upload"></i> Save Configuration
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
