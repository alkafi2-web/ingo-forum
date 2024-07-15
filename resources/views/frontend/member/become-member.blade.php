@extends('frontend.layouts.frontend-page-layout')
@section('page-title')
    BreadCum
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
        <div class="row">
          <div class="col-lg-6 mb-3 mb-lg-0">
            <h4 class="form-title border-bottom pb-2 pt-3">Your Organisation Details</h4>
            <form action="" class="pt-2">
              <div class="row details-border mobile-border-none">
                <div class="col-12 mb-3">
                  <div class="row align-items-center">
                    <div class="col-md-4">
                      <label for="og-name" class="form-label required">Organisation Name</label>
                    </div>
                    <div class="col-md-8">
                    <input type="text" class="form-control required" id="og-name" placeholder="Your Organisation Name">
                    </div>
                  </div>
                </div>
                <div class="col-12 mb-3">
                  <div class="row align-items-center">
                    <div class="col-md-4">
                      <label for="og-website" class="form-label required">Organisation Website</label>
                    </div>
                    <div class="col-md-8">
                    <input type="text" class="form-control" id="og-website" placeholder="Your Organisation website">
                    </div>
                  </div>
                </div>
                <div class="col-12 mb-3">
                  <div class="row align-items-center">
                    <div class="col-md-4">
                      <label for="og-mail" class="form-label required">Organisation Email</label>
                    </div>
                    <div class="col-md-8">
                    <input type="text" class="form-control" id="og-mail" placeholder="Organisation Email">
                    </div>
                  </div>
                </div>
                <div class="col-12 mb-3">
                  <div class="row align-items-center">
                    <div class="col-md-4">
                      <label for="og-type" class="form-label required">Organisation Type</label>
                    </div>
                    <div class="col-md-8">
                    <select class="form-select" aria-label="Organisation Type">
                      <option disabled selected>Organisation Type</option>
                      <option value="1">Registered with NGO Affairs Bureau (NGOAB) as an INGO</option>
                      <option value="2">Possess international governance structures</option>
                    </select>
                    </div>
                  </div>
                </div>
                <div class="col-12 mb-3">
                  <div class="row align-items-center">
                    <div class="col-md-4">
                      <label for="og-address" class="form-label required">Organisation Address</label>
                    </div>
                    <div class="col-md-8">
                    <input type="text" class="form-control" id="og-address" placeholder="Organisation Address">
                    </div>
                  </div>
                </div>
              </div>
            </form>
          </div>
          <div class="col-lg-6 mb-3 mb-lg-0">
            <h4 class="form-title border-bottom pb-2 pt-3">Your Details</h4>
            <form action="" class="pt-2">
              <div class="row ">
                <div class="col-12 mb-3">
                  <div class="row align-items-center">
                    <div class="col-md-4">
                      <label for="first-name" class="form-label required">Country Director Name</label>
                    </div>
                    <div class="col-md-8">
                    <input type="text" class="form-control" id="first-name" placeholder="Country Director Name">
                    </div>
                  </div>
                </div>
                <div class="col-12 mb-3">
                  <div class="row align-items-center">
                    <div class="col-md-4">
                      <label for="email" class="form-label required">Country Director Email (Personal)</label>
                    </div>
                    <div class="col-md-8">
                    <input type="email" class="form-control" id="email" placeholder="Email" placeholder="Country Director Email">
                    </div>
                  </div>
                </div>
                <div class="col-12 mb-3">
                  <div class="row align-items-center">
                    <div class="col-md-4">
                      <label for="phone" class="form-label">Phone</label>
                    </div>
                    <div class="col-md-8">
                    <input type="text" class="form-control" id="phone" placeholder="Phone">
                    </div>
                  </div>
                </div>
              </div>
            </form>
          </div>
          
          <div class="col-12">
            <h4 class="form-title border-bottom pb-2 pt-3">Member Access Credential</h4>
            <form action="" class="pt-2">
              <div class="row">
                <div class="col-lg-6 mb-3">
                  <div class="row align-items-center">
                    <div class="col-md-4">
                      <label for="mail" class="form-label required">Email (For Login)</label>
                    </div>
                    <div class="col-md-8">
                    <input type="text" class="form-control" id="mail" placeholder="Email">
                    </div>
                  </div>
                </div>
                <div class="col-lg-6 mb-3">
                  <div class="row align-items-center">
                    <div class="col-md-4">
                      <label for="phone" class="form-label">Phone</label>
                    </div>
                    <div class="col-md-8">
                    <input type="text" class="form-control" id="phone" placeholder="Phone">
                    </div>
                  </div>
                </div>
                <div class="col-lg-6 mb-3">
                  <div class="row align-items-center">
                    <div class="col-md-4">
                      <label for="password" class="form-label required">Password</label>
                    </div>
                    <div class="col-md-8">
                    <input type="password" class="form-control" id="password" placeholder="Password">
                    </div>
                  </div>
                </div>
                <div class="col-lg-6 mb-3">
                  <div class="row align-items-center">
                    <div class="col-md-4">
                      <label for="confirm-pass" class="form-label">Confirm Password</label>
                    </div>
                    <div class="col-md-8">
                    <input type="password" class="form-control" id="confirm-pass" placeholder="Confirm Password">
                    </div>
                  </div>
                </div>
                <div class="col-lg-6 mb-3">
                  <div class="row align-items-center">
                    <div class="col-md-4">
                      <label for="comment" class="form-label">Comments (Optional)</label>
                    </div>
                    <div class="col-md-8">
                    <input type="text" class="form-control" id="comment" placeholder="Comments (Optional)">
                    </div>
                  </div>
                </div>
                <div class="col-12 text-end pt-3">
                  <input type="submit" value="Send" class="submit-btn">
                </div>
              </div>
            </form>
          </div>
        </div>
        <div class="register-card-footer"></div>
      </div>
    </div>
   </section>
  <!-- Membership Area end here  -->
@endsection