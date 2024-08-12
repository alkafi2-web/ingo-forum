@extends('frontend.layouts.frontend-page-layout')

@section('page-title', 'Forgot Password')

@section('frontend-section')
<section class="membership-area ptb-50">
    <div class="container">
        <div class="row">
            <div class="col-md-7 mx-auto">
                <div class="register-card">
                    <div class="register-card-header border-bottom">
                        <h2 class="section-title text-center">Reset Password</h2>
                    </div>
                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf
                        <div class="row pt-2 justify-content-center">
                            <div class="col-12 mb-3">
                                <div class="row align-items-center">
                                    <div class="col-md-4">
                                        <label for="email" class="form-label required">Email</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="email" name="email" class="form-control" id="email" placeholder="Email" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 text-center pt-3">
                                <input type="submit" value="Send Password Reset Link" class="submit-btn">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
