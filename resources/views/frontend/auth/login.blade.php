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
                                                    <label for="login_email" class="form-label required">Email (For Login)</label>
                                                </div>
                                                <div class="col-md-8">
                                                    {{-- <label for="login_email" class="form-label required">Email (For Login)</label> --}}
                                                    <input type="email" name="login_email" class="form-control" id="login_email" placeholder="Email" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 mb-3">
                                            <div class="row align-items-center">
                                                <div class="col-md-4">
                                                    <label for="password" class="form-label required">Password</label>
                                                </div>
                                                <div class="col-md-8">
                                                    <input type="password" name="password" class="form-control" id="password" placeholder="Password" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 text-center pt-3">
                                            <input type="submit" id="member-submit" value="Login" class="submit-btn">
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