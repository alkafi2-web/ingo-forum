@extends('frontend.layouts.frontend-page-layout')
@section('page-title', 'Profile')
@section('frontend-section')
    <!-- Profile edit page start -->
    <section class="ptb-50">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="row">
                        <div class="col-lg-3 mb-3 mb-lg-0 nav flex-column nav-pills" id="v-pills-tab" role="tablist"
                            aria-orientation="vertical">
                            <div class="edit-profile-img bg-white py-4 px-3 text-center">
                                <div class="preview-img mb-3">
                                    <img src="./images/oxfam.png" alt="" id="preview-img">
                                    <i class="fa-solid fa-camera" id="upload-icon"></i>
                                    <input type="file" name="" id="profile-input" class="d-none">
                                </div>
                                <span class="d-block w-100 text-orange fw-semibold fs-">AF-05-04-143</span>
                                <span class="d-block w-100">(Type Name)</span>
                            </div>
                            <div class="all-profile-tabs d-flex flex-column mt-4 bg-white py-4 px-3">
                                <button class="nav-link active" id="v-pills-home-tab" data-bs-toggle="pill"
                                    data-bs-target="#v-pills-home" type="button" role="tab"
                                    aria-controls="v-pills-home" aria-selected="true">Information</button>
                                <button class="nav-link" id="v-pills-profile-tab" data-bs-toggle="pill"
                                    data-bs-target="#v-pills-profile" type="button" role="tab"
                                    aria-controls="v-pills-profile" aria-selected="false">Profile Summary</button>
                                <button class="nav-link" id="v-pills-disabled-tab" data-bs-toggle="pill"
                                    data-bs-target="#v-pills-disabled" type="button" role="tab"
                                    aria-controls="v-pills-disabled" aria-selected="false">Social Links</button>
                            </div>
                        </div>
                        <div class="col-lg-9 tab-content bg-white p-3 rounded" id="v-pills-tabContent">
                            <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel"
                                aria-labelledby="v-pills-home-tab" tabindex="0">
                                <div class="row">
                                    <div class="col-12 mb-3 mb-lg-0">
                                        <h4 class="form-title border-bottom pb-2 pt-3">Your Details</h4>
                                        <form action="" class="pt-2">
                                            <div class="row">
                                                <div class="col-12 mb-3">
                                                    <div class="row align-items-center">
                                                        <div class="col-md-4">
                                                            <label for="first-name" class="form-label">First Name</label>
                                                        </div>
                                                        <div class="col-md-8">
                                                            <input type="text" class="form-control" id="first-name"
                                                                placeholder="First Name">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12 mb-3">
                                                    <div class="row align-items-center">
                                                        <div class="col-md-4">
                                                            <label for="last-name" class="form-label">Last Name</label>
                                                        </div>
                                                        <div class="col-md-8">
                                                            <input type="text" class="form-control" id="last-name"
                                                                placeholder="Last Name">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12 mb-3">
                                                    <div class="row align-items-center">
                                                        <div class="col-md-4">
                                                            <label for="email" class="form-label">Email
                                                                (Personal)</label>
                                                        </div>
                                                        <div class="col-md-8">
                                                            <input type="email" class="form-control" id="email"
                                                                placeholder="Email">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12 mb-3">
                                                    <div class="row align-items-center">
                                                        <div class="col-md-4">
                                                            <label for="phone" class="form-label">Phone</label>
                                                        </div>
                                                        <div class="col-md-8">
                                                            <input type="text" class="form-control" id="phone"
                                                                placeholder="Phone">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="col-12 mb-3 mb-lg-0">
                                        <h4 class="form-title border-bottom pb-2 pt-3">Your Organisation Details</h4>
                                        <form action="" class="pt-2">
                                            <div class="row">
                                                <div class="col-12 mb-3">
                                                    <div class="row align-items-center">
                                                        <div class="col-md-4">
                                                            <label for="og-name" class="form-label">Your Organisation
                                                                Name</label>
                                                        </div>
                                                        <div class="col-md-8">
                                                            <input type="text" class="form-control" id="og-name"
                                                                placeholder="Your Organisation Name" spellcheck="false"
                                                                data-ms-editor="true">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12 mb-3">
                                                    <div class="row align-items-center">
                                                        <div class="col-md-4">
                                                            <label for="og-mail" class="form-label">Organisation
                                                                Email</label>
                                                        </div>
                                                        <div class="col-md-8">
                                                            <input type="text" class="form-control" id="og-mail"
                                                                placeholder="Organisation Email" spellcheck="false"
                                                                data-ms-editor="true">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12 mb-3">
                                                    <div class="row align-items-center">
                                                        <div class="col-md-4">
                                                            <label for="og-acronym" class="form-label">Orgainsation
                                                                Acronym</label>
                                                        </div>
                                                        <div class="col-md-8">
                                                            <input type="text" class="form-control" id="og-acronym"
                                                                placeholder="Orgainsation Acronym" spellcheck="false"
                                                                data-ms-editor="true">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12 mb-3">
                                                    <div class="row align-items-center">
                                                        <div class="col-md-4">
                                                            <label for="og-type" class="form-label">Organisation
                                                                Type</label>
                                                        </div>
                                                        <div class="col-md-8">
                                                            <select class="form-select" aria-label="Organisation Type">
                                                                <option selected="">Organisation Type</option>
                                                                <option value="1">One</option>
                                                                <option value="2">Two</option>
                                                                <option value="3">Three</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12 mb-3">
                                                    <div class="row align-items-center">
                                                        <div class="col-md-4">
                                                            <label for="og-address" class="form-label">Organisation
                                                                Address</label>
                                                        </div>
                                                        <div class="col-md-8">
                                                            <input type="text" class="form-control" id="og-address"
                                                                placeholder="Organisation Address" spellcheck="false"
                                                                data-ms-editor="true">
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
                                                <div class="col-12 mb-3">
                                                    <div class="row align-items-center">
                                                        <div class="col-md-4">
                                                            <label for="mail" class="form-label">Email (For
                                                                Login)</label>
                                                        </div>
                                                        <div class="col-md-8">
                                                            <input type="text" class="form-control" id="mail"
                                                                placeholder="Email" spellcheck="false"
                                                                data-ms-editor="true">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12 mb-3">
                                                    <div class="row align-items-center">
                                                        <div class="col-md-4">
                                                            <label for="phone" class="form-label">Phone</label>
                                                        </div>
                                                        <div class="col-md-8">
                                                            <input type="text" class="form-control" id="phone"
                                                                placeholder="Phone">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12 mb-3">
                                                    <div class="row align-items-center">
                                                        <div class="col-md-4">
                                                            <label for="password" class="form-label">Password</label>
                                                        </div>
                                                        <div class="col-md-8">
                                                            <input type="password" class="form-control" id="password"
                                                                placeholder="Password">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12 mb-3">
                                                    <div class="row align-items-center">
                                                        <div class="col-md-4">
                                                            <label for="og-type" class="form-label">Organisation
                                                                Type</label>
                                                        </div>
                                                        <div class="col-md-8">
                                                            <select class="form-select" aria-label="Organisation Type">
                                                                <option selected="">Organisation Type</option>
                                                                <option value="1">One</option>
                                                                <option value="2">Two</option>
                                                                <option value="3">Three</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12 text-end pt-3">
                                                    <input type="submit" value="Update" class="submit-btn">
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="v-pills-profile" role="tabpanel"
                                aria-labelledby="v-pills-profile-tab" tabindex="0">
                                <form action="">
                                    <div class="row">
                                        <div class="col-12 mb-3">
                                            <label for="title" class="form-label">Title</label>
                                            <input type="text" class="form-control" id="title"
                                                placeholder="Title">
                                        </div>
                                        <div class="col-12 mb-3">
                                            <label for="sub-title" class="form-label">Sub Title</label>
                                            <input type="text" class="form-control" id="sub-title"
                                                placeholder="Sub Title">
                                        </div>
                                        <div class="col-12 mb-3">
                                            <label for="profile" class="form-label">Upload Profile</label>
                                            <input type="file" class="form-control" id="profile">
                                        </div>
                                        <div class="col-12 mb-3">
                                            <label for="sub-title" class="form-label">Summary</label>
                                            <textarea id="description" rows="3"></textarea>
                                        </div>
                                        <div class="col-12 mb-3">
                                            <h4 class="form-title pb-2 pt-3">Mission</h4>
                                            <textarea id="mission" rows="3"></textarea>
                                        </div>
                                        <div class="col-12 mb-3">
                                            <h4 class="form-title pb-2 pt-3">Vision</h4>
                                            <textarea id="vision" rows="3"></textarea>
                                        </div>
                                        <div class="col-12 mb-3">
                                            <h4 class="form-title pb-2 pt-3">Values</h4>
                                            <textarea id="values" rows="3"></textarea>
                                        </div>
                                        <div class="col-12 mb-3">
                                            <h4 class="form-title pb-2 pt-3">Other Description</h4>
                                            <textarea id="other" rows="3"></textarea>
                                        </div>
                                        <div class="col-12 mb-3 text-end">
                                            <input type="submit" value="Update" class="submit-btn">
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="tab-pane fade" id="v-pills-disabled" role="tabpanel"
                                aria-labelledby="v-pills-disabled-tab" tabindex="0">
                                <form action="">
                                    <div id="formContainer" class="row">
                                        <div class="col-12 mb-3">
                                            <label for="facebook" class="form-label">Facebook</label>
                                            <input type="text" class="form-control" id="facebook"
                                                placeholder="Facebook Link">
                                        </div>
                                        <div class="col-12 mb-3">
                                            <label for="twitter" class="form-label">Twitter</label>
                                            <input type="text" class="form-control" id="twitter"
                                                placeholder="Twitter Link">
                                        </div>
                                        <div class="col-12 mb-3">
                                            <label for="linkedin" class="form-label">Linkedin</label>
                                            <input type="text" class="form-control" id="linkedin"
                                                placeholder="Linkedin Link">
                                        </div>
                                        <div class="col-12 mb-3">
                                            <label for="instagram" class="form-label">Instagram</label>
                                            <input type="text" class="form-control" id="instagram"
                                                placeholder="Instagram Link">
                                        </div>
                                        <div class="col-12 mb-3">
                                            <label for="youtube" class="form-label">YouTube</label>
                                            <input type="text" class="form-control" id="youtube"
                                                placeholder="YouTube Link">
                                        </div>
                                        <div class="col-12 text-end">
                                            <input type="submit" value="Update" class="submit-btn">
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Profile edit page end -->
@endsection
