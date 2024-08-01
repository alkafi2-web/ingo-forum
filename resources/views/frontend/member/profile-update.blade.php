@extends('frontend.layouts.frontend-page-layout')
@section('page-title', 'Dashboard')
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
                <img
                  src="{{ asset('public/frontend/images/member/') }}/{{ $member->memberInfos[0]['logo'] ?? 'placeholder.jpg' }}"
                  alt="" id="preview-img">
                <i class="fa-solid fa-camera" id="upload-icon"></i>
                <input type="file" name="" id="profile-input" class="d-none">
              </div>
              <span
                class="d-block w-100 text-orange fw-semibold fs-">{{ $member->memberInfos[0]['membership_id'] }}</span>
              <span
                class="d-block w-100">({{ $member->memberInfos[0]['org_type'] == 1 ? 'Registered with NGO Affairs Bureau (NGOAB) as an INGO' : 'Possess international governance structures' }})</span>
            </div>
            <div class="all-profile-tabs d-flex flex-column mt-4 bg-white py-4 px-3">
              <button class="nav-link active" id="profile-tab" data-bs-toggle="pill" data-bs-target="#profile"
                type="button" role="tab" aria-controls="profile" aria-selected="true">Profile</button>

              <button class="nav-link" id="event-tab" data-bs-toggle="pill" data-bs-target="#event" type="button"
                role="tab" aria-controls="event" aria-selected="false">Events</button>

              <button class="nav-link" id="blog-news-tab" data-bs-toggle="pill" data-bs-target="#blog-news"
                type="button" role="tab" aria-controls="blog-news" aria-selected="true">Blog/News</button>

              <button class="nav-link" id="publication-tab" data-bs-toggle="pill" data-bs-target="#publication"
                type="button" role="tab" aria-controls="publication" aria-selected="true">Publication</button>

              <button class="nav-link" id="user-section-tab" data-bs-toggle="pill" data-bs-target="#user-section"
                type="button" role="tab" aria-controls="user-section" aria-selected="true">User Section</button>
            </div>
          </div>
          <div class="col-lg-9 tab-content bg-white p-3 rounded" id="v-pills-tabContent">
            {{-- Tab content start here  --}}
            <div class="tab-pane fade show active" id="profile" role="tabpanel" aria-labelledby="profile-tab"
              tabindex="0">
              {{-- sub tabs start  --}}
              <ul class="sub-profile-tabs nav nav-pills mb-3" id="pills-tab" role="tablist">
                <li class="nav-item" role="presentation">
                  <button class="nav-link active" id="information-tab" data-bs-toggle="pill"
                    data-bs-target="#information" type="button" role="tab" aria-controls="information"
                    aria-selected="true">Information</button>
                </li>
                <li class="nav-item" role="presentation">
                  <button class="nav-link" id="profile-summery-tab" data-bs-toggle="pill"
                    data-bs-target="#profile-summery-profile" type="button" role="tab"
                    aria-controls="profile-summery-profile" aria-selected="false">Profile Summary</button>
                </li>
                <li class="nav-item" role="presentation">
                  <button class="nav-link" id="social-links-tab" data-bs-toggle="pill" data-bs-target="#social-links"
                    type="button" role="tab" aria-controls="social-links" aria-selected="false">Social Links</button>
                </li>
              </ul>
              <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade show active" id="information" role="tabpanel"
                  aria-labelledby="information-tab" tabindex="0">
                  <div class="row">
                    <form id="member-profile-update" action="" method="post">
                      <div class="col-lg-12 mb-3 mb-lg-0">
                        <div class="d-flex align-item-center justify-content-between border-bottom">
                          <h4 class="form-title  pb-2 pt-3">Your Organisation Details</h4>

                        </div>
                        <div class="row mobile-border-none pt-2">
                          <div class="col-12 mb-3">
                            <div class="row align-items-center">
                              <div class="col-md-4">
                                <label for="org_name" class="form-label required">Organisation
                                  Name</label>
                              </div>
                              <div class="col-md-8">
                                <input type="text" name="org_name" class="form-control required" id="org_name"
                                  placeholder="Your Organisation Name"
                                  value="{{ $member->memberInfos[0]['organisation_name'] }}">
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
                                  placeholder="Your Organisation Website"
                                  value="{{ $member->memberInfos[0]['organisation_website'] }}">
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
                                  placeholder="Organisation Email"
                                  value="{{ $member->memberInfos[0]['organisation_email'] }}">
                              </div>
                            </div>
                          </div>
                          <div class="col-12 mb-3">
                            <div class="row align-items-center">
                              <div class="col-md-4">
                                <label for="org_type" class="form-label required">Organisation
                                  Type</label>
                              </div>
                              <div class="col-md-8">
                                <select name="org_type" class="form-select" id="org_type" aria-label="Organisation Type"
                                  required>
                                  <option disabled selected>Organisation Type</option>
                                  <option value="1"
                                    {{ $member->memberInfos[0]['organisation_type'] == 1 ? 'selected' : '' }}>
                                    Registered with NGO Affairs Bureau (NGOAB) as an INGO
                                  </option>
                                  <option value="2"
                                    {{ $member->memberInfos[0]['organisation_type'] == 2 ? 'selected' : '' }}>
                                    Possess international governance structures
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
                                  placeholder="Organisation Address"
                                  value="{{ $member->memberInfos[0]['organisation_address'] }}">
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <!-- Organisation Director Details Section -->
                      <div class="col-lg-12 mb-3 mb-lg-0">
                        <h4 class="form-title border-bottom pb-2 pt-3">Your Organisation Director
                          Details
                        </h4>
                        <div class="row pt-2">
                          <div class="col-12 mb-3">
                            <div class="row align-items-center">
                              <div class="col-md-4">
                                <label for="director_name" class="form-label required">Country
                                  Director
                                  Name</label>
                              </div>
                              <div class="col-md-8">
                                <input type="text" name="director_name" class="form-control" id="director_name"
                                  placeholder="Country Director Name"
                                  value="{{ $member->memberInfos[0]['director_name'] }}">
                              </div>
                            </div>
                          </div>
                          <div class="col-12 mb-3">
                            <div class="row align-items-center">
                              <div class="col-md-4">
                                <label for="director_email" class="form-label required">Country
                                  Director
                                  Email (Personal)</label>
                              </div>
                              <div class="col-md-8">
                                <input type="email" name="director_email" class="form-control" id="director_email"
                                  placeholder="Country Director Email"
                                  value="{{ $member->memberInfos[0]['director_email'] }}">
                              </div>
                            </div>
                          </div>
                          <div class="col-12 mb-3">
                            <div class="row align-items-center">
                              <div class="col-md-4">
                                <label for="director_phone" class="form-label">Phone</label>
                              </div>
                              <div class="col-md-8">
                                <input type="text" name="director_phone" class="form-control" id="director_phone"
                                  placeholder="Phone" value="{{ $member->memberInfos[0]['director_phone'] }}">
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
                                <label for="login_email" class="form-label required">Email
                                  (For
                                  Login)</label>
                              </div>
                              <div class="col-md-8">
                                <input type="email" name="login_email" class="form-control" id="login_email"
                                  placeholder="Email" value="{{ $member->email }}" readonly>
                              </div>
                            </div>
                          </div>
                          <div class="col-lg-6 mb-3">
                            <div class="row align-items-center">
                              <div class="col-md-4">
                                <label for="login_phone" class="form-label">Phone</label>
                              </div>
                              <div class="col-md-8">
                                <input type="text" name="login_phone" class="form-control" id="login_phone"
                                  placeholder="Phone" value="{{ $member->phone }}">
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
                                <label for="password_confirmation" class="form-label required">Confirm
                                  Password</label>
                              </div>
                              <div class="col-md-8">
                                <input type="password" name="password_confirmation" class="form-control"
                                  id="password_confirmation" placeholder="Confirm Password" required>
                              </div>
                            </div>
                          </div>

                          <div class="col-12 text-end pt-3">
                            <input type="submit" id="member-submit" value="Update" class="submit-btn">
                          </div>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
                <div class="tab-pane fade" id="profile-summery-profile" role="tabpanel"
                  aria-labelledby="profile-summery-tab" tabindex="0">
                  <form id="profilDataForm" action="">
                    <div class="row">
                      <div class="col-12 mb-3">
                        <label for="title" class="form-label required">Title</label>
                        <input type="text" class="form-control" id="title" name="title" placeholder="Title"
                          value="{{ $member->memberInfos[0]['title'] ?? '' }}">
                      </div>
                      <div class="col-12 mb-3">
                        <label for="sub_title" class="form-label required">Sub Title</label>
                        <input type="text" class="form-control" id="sub_title" name="sub_title" placeholder="Sub Title"
                          value="{{ $member->memberInfos[0]['sub_title'] ?? '' }}">
                      </div>
                      <div class="col-12 mb-3">
                        <label for="short_description" class="form-label">Short Descrition</label>
                        <textarea class="form-control" id="short_description" name="short_description"
                          rows="3">{{ $member->memberInfos[0]['short_description'] ?? '' }}</textarea>
                      </div>
                      <div class="col-12 mb-3">
                        <label for="organization_document" class="form-label">Organization
                          Document</label>
                        <input type="file" class="form-control" id="organization_document" name="organization_document">
                        <!-- Container to display the file preview -->
                        <div id="file-preview" class="mt-3">

                        </div>
                      </div>
                      <div class="col-12 mb-3">
                        <label for="mission" class="form-label">Mission</label>
                        <textarea class="form-control" id="mission" name="mission"
                          rows="3">{{ $member->memberInfos[0]['mission'] ?? '' }}</textarea>
                      </div>
                      <div class="col-12 mb-3">
                        <label for="vision" class="form-label">Vision</label>
                        <textarea class="form-control" id="vision" name="vision"
                          rows="3">{{ $member->memberInfos[0]['vision'] ?? '' }}</textarea>
                      </div>
                      <div class="col-12 mb-3">
                        <label for="values" class="form-label">Values</label>
                        <textarea class="form-control" id="values" name="values"
                          rows="3">{{ $member->memberInfos[0]['value'] ?? '' }}</textarea>
                      </div>
                      <div class="col-12 mb-3">
                        <label for="work" class="form-label">Work or Projects</label>
                        <textarea class="form-control" id="work" name="work"
                          rows="3">{{ $member->memberInfos[0]['work'] ?? '' }}</textarea>
                      </div>
                      <div class="col-12 mb-3">
                        <label for="history" class="form-label">History</label>
                        <textarea class="form-control" id="history" name="history"
                          rows="3">{{ $member->memberInfos[0]['history'] ?? '' }}</textarea>
                      </div>
                      <div class="col-12 mb-3">
                        <label for="other_description" class="form-label">Other Description</label>
                        <textarea class="form-control" id="other_description" name="other_description"
                          rows="3">{{ $member->memberInfos[0]['other_description'] ?? '' }}</textarea>
                      </div>
                      <div class="col-12 mb-3 text-end">
                        <button id="profilData-submit" class="submit-btn">Update</button>
                      </div>
                    </div>
                  </form>
                </div>
                <div class="tab-pane fade" id="social-links" role="tabpanel" aria-labelledby="social-links-tab"
                  tabindex="0">
                  <form action="" id="social-form">
                    <div id="formContainer" class="row">
                      <div class="col-12 mb-3">
                        <label for="facebook" class="form-label">Facebook</label>
                        <input type="text" class="form-control" id="facebook" name="facebook"
                          placeholder="Facebook Link" value="{{ $member->memberInfos[0]['facebook'] ?? '' }}">
                      </div>
                      <div class="col-12 mb-3">
                        <label for="twitter" class="form-label">Twitter</label>
                        <input type="text" class="form-control" id="twitter" name="twitter" placeholder="Twitter Link"
                          value="{{ $member->memberInfos[0]['twitter'] ?? '' }}">
                      </div>
                      <div class="col-12 mb-3">
                        <label for="linkedin" class="form-label">Linkedin</label>
                        <input type="text" class="form-control" id="linkedin" name="linkedin"
                          placeholder="Linkedin Link" value="{{ $member->memberInfos[0]['linkedin'] ?? '' }}">
                      </div>
                      <div class="col-12 mb-3">
                        <label for="instagram" class="form-label">Instagram</label>
                        <input type="text" class="form-control" id="instagram" placeholder="Instagram Link"
                          value="{{ $member->memberInfos[0]['instagram'] ?? '' }}">
                      </div>
                      <div class="col-12 mb-3">
                        <label for="youtube" class="form-label">YouTube</label>
                        <input type="text" class="form-control" id="youtube" name="youtube" placeholder="YouTube Link"
                          value="{{ $member->memberInfos[0]['youtube'] ?? '' }}">
                      </div>
                      <div class="col-12 text-end">
                        <button id="social-submit" class="submit-btn">Update</button>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
              {{-- sub tabs end  --}}
            </div>
            {{-- Tab content end here --}}
            {{-- Event Tab content start here  --}}
            <div class="tab-pane fade" id="event" role="tabpanel" aria-labelledby="event-tab" tabindex="0">
              <ul class="sub-profile-tabs nav nav-pills mb-3" id="pills-tab" role="tablist">
                <li class="nav-item" role="presentation">
                  <button class="nav-link active" id="add-event-tab" data-bs-toggle="pill" data-bs-target="#add-event" type="button" role="tab" aria-controls="add-event" aria-selected="true">Add Event</button>
                </li>
                <li class="nav-item" role="presentation">
                  <button class="nav-link" id="all-event-tab" data-bs-toggle="pill" data-bs-target="#all-event" type="button" role="tab" aria-controls="all-event" aria-selected="false" tabindex="-1">All Event</button>
                </li>
              </ul>
              <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade show active" id="add-event" role="tabpanel" aria-labelledby="add-event-tab" tabindex="0">
                  <form id="eventForm" action="" method="POST" enctype="multipart/form-data">
                    <div class="row mb-3">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label for="title" class="text-3xl form-label required">Event Title</label>
                          <input type="text" class="form-control" id="title" name="title" value="" spellcheck="false"
                            data-ms-editor="true">
                        </div>
                      </div>
                    </div>
                    <div class="row mb-3">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label for="des" class="text-3xl form-label required">Event Description</label>
                          <textarea class="form-control" id="des" name="des" rows="4" spellcheck="false"
                            data-ms-editor="true"></textarea>
                        </div>
                      </div>
                    </div>
                    <div class="row mb-3">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label for="location" class="text-3xl form-label required">Event Location</label>
                          <textarea class="form-control" id="location" name="location" rows="2" spellcheck="false"
                            data-ms-editor="true"></textarea>
                        </div>
                      </div>
                    </div>
                    <div class="row mb-3">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="start_date" class="text-3xl form-label required">Event Start Date</label>
                          <input type="datetime-local" class="form-control" id="start_date" name="start_date" value="">
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="end_date" class="text-3xl form-label required">Event End Date</label>
                          <input type="datetime-local" class="form-control" id="end_date" name="end_date" value="">
                        </div>
                      </div>
                    </div>
                    <div class="row mb-3">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label for="deadline_date" class="text-3xl form-label required">Registrtaion Deadline</label>
                          <input type="datetime-local" class="form-control" id="deadline_date" name="deadline_date"
                            value="">
                        </div>
                      </div>

                    </div>
                    <div class="row mb-3">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label for="image" class="text-3xl form-label required">Event Image</label>
                          <input type="file" class="form-control" id="image" name="image" value=""
                            oninput="pp.src=window.URL.createObjectURL(this.files[0])" onchange="previewImage(event)">
                          <img id="pp" width="100" class="float-start mt-3" src="">
                        </div>
                      </div>
                    </div>
                    <button id="event-submit" type="submit" class="btn btn-primary mt-3"> <i
                        class="fas fa-upload"></i>Submit</button>
                    <button id="event-update" type="submit" class="btn btn-primary mt-3 d-none"><i
                        class="fas fa-wrench"></i>
                      Update</button>
                    <button id="page-refresh" type="submit" class="btn btn-secondary mt-3 d-none"><i
                        class="fas fa-sync-alt"></i>
                      Refresh</button>
                  </form>
                </div>
                <div class="tab-pane fade" id="all-event" role="tabpanel" aria-labelledby="all-event-tab" tabindex="0">
                  <table class="table table-striped">
                    <thead>
                      <tr>
                        <th scope="col">#</th>
                        <th scope="col">First</th>
                        <th scope="col">Last</th>
                        <th scope="col">Handle</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <th scope="row">1</th>
                        <td>Mark</td>
                        <td>Otto</td>
                        <td>@mdo</td>
                      </tr>
                      <tr>
                        <th scope="row">2</th>
                        <td>Jacob</td>
                        <td>Thornton</td>
                        <td>@fat</td>
                      </tr>
                      <tr>
                        <th scope="row">3</th>
                        <td colspan="2">Larry the Bird</td>
                        <td>@twitter</td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
            {{-- Event Tab content end here --}}
            {{-- Blog/News Tab content start here  --}}
            <div class="tab-pane fade" id="blog-news" role="tabpanel" aria-labelledby="blog-news-tab" tabindex="0">
              <ul class="sub-profile-tabs nav nav-pills mb-3" id="pills-tab" role="tablist">
                <li class="nav-item" role="presentation">
                  <button class="nav-link active" id="add-blog-news-tab" data-bs-toggle="pill" data-bs-target="#add-blog-news" type="button" role="tab" aria-controls="add-blog-news" aria-selected="true">Add Blog/News</button>
                </li>
                <li class="nav-item" role="presentation">
                  <button class="nav-link" id="all-blog-news-tab" data-bs-toggle="pill" data-bs-target="#all-blog-news" type="button" role="tab" aria-controls="all-blog-news" aria-selected="false" tabindex="-1">All Blog/News</button>
                </li>
              </ul>
              <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade show active" id="add-blog-news" role="tabpanel" aria-labelledby="add-blog-news-tab" tabindex="0">
                  <div>
                    <form action="/submit-form" id="postForm" method="POST" enctype="multipart/form-data">
                      <div class="row">
                        <div class="col-md-6">
                          <!-- Category -->
                          <div class="form-group">
                            <label for="category" class="required form-label">Category</label>
                            <select id="category" name="category" class="form-control" required="">
                              <option value="">-- Select Category --</option>
                              <option value="1">News</option>
                              <option value="2">Blog</option>
                            </select>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <!-- Subcategory -->
                          <div class="form-group">
                            <label for="subcategory" class="required form-label">Subcategory</label>
                            <select id="subcategory" name="subcategory" class="form-control" required="">
                              <option value="">-- Select Category First --</option>
                            </select>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-6">
                          <!-- Title -->
                          <div class="form-group mt-3">
                            <label for="title" class="required form-label">Title</label>
                            <input type="text" id="title" name="title" class="form-control" required=""
                              spellcheck="false" data-ms-editor="true">
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group mt-3">
                            <label for="slug" class="required form-label">Slug</label>
                            <input type="text" id="slug" name="slug" class="form-control" required=""
                              spellcheck="false" data-ms-editor="true">
                          </div>
                        </div>
                      </div>
                      <!-- Long Description -->
                      <div class="form-group mt-3">
                        <textarea id="long_description" name="long_description" class="form-control mt-5" rows="7" ></textarea>
                      </div>
                      <!-- Banner -->
                      <div class="row">
                        <div class="col-md-12">
                          <div class="form-group mt-3">
                            <label for="banner" class="required form-label">Banner</label>
                            <input type="file" id="banner" name="banner" class="form-control" required=""
                              oninput="pp.src=window.URL.createObjectURL(this.files[0])">
                            <p class="text-danger">Banner must be 800px by 450px</p>
                            <img id="pp" width="200" class="float-start mt-3" src="">
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-12">
                          <div class="form-group mt-3">
                            <button type="" id="submit" class="btn btn-primary mt-4"> <i
                                class="fas fa-upload"></i>Submit</button>
                          </div>
                        </div>
                      </div>
                      <!-- Submit Button -->
                    </form>
                  </div>
                </div>
                <div class="tab-pane fade" id="all-blog-news" role="tabpanel" aria-labelledby="all-blog-news-tab" tabindex="0">
                  <table class="table table-striped">
                    <thead>
                      <tr>
                        <th scope="col">#</th>
                        <th scope="col">First</th>
                        <th scope="col">Last</th>
                        <th scope="col">Handle</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <th scope="row">1</th>
                        <td>Mark</td>
                        <td>Otto</td>
                        <td>@mdo</td>
                      </tr>
                      <tr>
                        <th scope="row">2</th>
                        <td>Jacob</td>
                        <td>Thornton</td>
                        <td>@fat</td>
                      </tr>
                      <tr>
                        <th scope="row">3</th>
                        <td colspan="2">Larry the Bird</td>
                        <td>@twitter</td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
            {{-- Blog/News Tab content end here --}}
            {{-- Publication Tab content start here  --}}
            <div class="tab-pane fade" id="publication" role="tabpanel" aria-labelledby="publication-tab" tabindex="0">
              <ul class="sub-profile-tabs nav nav-pills mb-3" id="pills-tab" role="tablist">
                <li class="nav-item" role="presentation">
                  <button class="nav-link active" id="add-publication-tab" data-bs-toggle="pill" data-bs-target="#add-publication" type="button" role="tab" aria-controls="add-publication" aria-selected="true">Add Publication</button>
                </li>
                <li class="nav-item" role="presentation">
                  <button class="nav-link" id="all-publication-tab" data-bs-toggle="pill" data-bs-target="#all-publication" type="button" role="tab" aria-controls="all-publication" aria-selected="false" tabindex="-1">All Publication</button>
                </li>
              </ul>
              <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade show active" id="add-publication" role="tabpanel" aria-labelledby="add-publication-tab" tabindex="0">
                    <form action="/submit-form" id="publicationForm" method="POST" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-6">
                                <!-- Category -->
                                <div class="form-group ">
                                    <label for="category" class="required form-label">Category</label>
                                    <select id="category" name="category" class="form-control" required="">
                                        <option value="">-- Select Category --</option>
                                                                                    <option value="">There is No Category</option>
                                                                            </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <!-- Title -->
                                <div class="form-group ">
                                    <label for="title" class="required form-label">Title</label>
                                    <input type="text" id="title" name="title" class="form-control" required="" spellcheck="false" data-ms-editor="true">
                                </div>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group mt-3">
                                    <label for="author" class="required form-label">Author</label>
                                    <input type="text" id="author" name="author" class="form-control" required="" spellcheck="false" data-ms-editor="true">
                                </div>
                            </div>
                            <div class="col-md-4 ">
                                <!-- Subcategory -->
                                <div class="form-group mt-3">
                                    <label for="publisher" class="required form-label">Publisher</label>
                                    <input type="text" id="publisher" name="publisher" class="form-control" required="" spellcheck="false" data-ms-editor="true">
                                </div>
                            </div>
                            <div class="col-md-4 ">
                                <!-- Subcategory -->
                                <div class="form-group mt-3">
                                    <label for="publish_date" class="required form-label">Publish Date</label>
                                    <input type="date" id="publish_date" name="publish_date" class="form-control" required="">
                                </div>
                            </div>

                        </div>

                        <!-- Long Description -->
                        <div class="form-group mt-3">
                            <label for="short_description" class="mb-3 required form-label">Short Description</label>
                            <textarea id="short_description" name="short_description" class="form-control " rows="7" required="" spellcheck="false" data-ms-editor="true"></textarea>
                        </div>

                        <!-- Banner -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mt-3">
                                    <label for="file" class="required form-label">Publication File</label>
                                    <input type="file" id="file" name="file" class="form-control" required="">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mt-3">
                                    <label for="image" class="required form-label">Image</label>
                                    <input type="file" id="image" name="image" class="form-control" required="" oninput="pp.src=window.URL.createObjectURL(this.files[0])">
                                    <img id="pp" width="200" class="float-start" src="">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group mt-3">
                                    <button type="" id="submit" class="btn btn-primary mt-4"> <i class="fas fa-upload"></i>Submit</button>
                                </div>
                            </div>
                        </div>
                        <!-- Submit Button -->
                    </form>
                </div>
                <div class="tab-pane fade" id="all-publication" role="tabpanel" aria-labelledby="all-publication-tab" tabindex="0">
                  <table class="table table-striped">
                    <thead>
                      <tr>
                        <th scope="col">#</th>
                        <th scope="col">First</th>
                        <th scope="col">Last</th>
                        <th scope="col">Handle</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <th scope="row">1</th>
                        <td>Mark</td>
                        <td>Otto</td>
                        <td>@mdo</td>
                      </tr>
                      <tr>
                        <th scope="row">2</th>
                        <td>Jacob</td>
                        <td>Thornton</td>
                        <td>@fat</td>
                      </tr>
                      <tr>
                        <th scope="row">3</th>
                        <td colspan="2">Larry the Bird</td>
                        <td>@twitter</td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>                
            </div>
            </div>
            {{-- Publication Tab content end here --}}
            {{-- Tab content start here  --}}
            <div class="tab-pane fade" id="user-section" role="tabpanel" aria-labelledby="user-section-tab"
              tabindex="0">

            </div>
            {{-- Tab content end here --}}
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- Profile edit page end -->
@push('custom-js')
<script>
  // Initialize CKEditor on the textareas
  CKEDITOR.replace('mission');
  CKEDITOR.replace('vision');
  CKEDITOR.replace('history');
  CKEDITOR.replace('work');
  CKEDITOR.replace('values');
  CKEDITOR.replace('other_description');
  $(document).ready(function() {
    $('#member-submit').on('click', function(e) {
      e.preventDefault();
      let url = "{{ route('member.profile.update') }}";
      let form = $('#member-profile-update')[0];
      let formData = new FormData(form);
      $.ajax({
        type: 'POST',
        url: url,
        data: formData,
        processData: false, // Prevent jQuery from processing the data
        contentType: false,
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
            'content')
        },
        success: function(response) {
          console.log(response);
          toastr.success(response.message);
        },
        error: function(xhr) {
          var errors = xhr.responseJSON.errors;
          // Iterate through each error and display the message using Toastr
          $.each(errors, function(key, value) {
            console.log(value[0]);
            toastr.error(value[
              0
            ]); // Displaying the first error message for each field
          });
        }
      });
    });
    $('#profile-input').on('change', function() {
      var fileInput = $(this)[0];
      if (fileInput.files && fileInput.files[0]) {
        var formData = new FormData();
        formData.append('profile_image', fileInput.files[0]);
        // AJAX request to upload image
        $.ajax({
          url: '{{ route('upload.profile.image') }}', // Replace with your upload route
          type: 'POST',
          data: formData,
          processData: false, // Prevent jQuery from processing the data
          contentType: false,
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          success: function(response) {
            toastr.success(response.message);
          },
          error: function(xhr, status, error) {
            // Handle error
            toastr.error('Failed to upload image.');
          }
        });
      }
    });
    $('#profilData-submit').on('click', function(e) {
      e.preventDefault();
      let url = "{{ route('member.profile.update.summary') }}";
      let title = $('#title').val();
      let subTitle = $('#sub_title').val();
      let short_description = $('#short_description').val();
      let mission = CKEDITOR.instances['mission'].getData();
      let vision = CKEDITOR.instances['vision'].getData();
      let value = CKEDITOR.instances['values'].getData();
      let work = CKEDITOR.instances['work'].getData();
      let history = CKEDITOR.instances['history'].getData();
      let otherDescription = CKEDITOR.instances['other_description'].getData();
      let organizationDocument = $('#organization_document')[0].files[0];
      let formData = new FormData(); // Create FormData object
      // Append form data to FormData object
      formData.append('title', title);
      formData.append('sub_title', subTitle);
      formData.append('short_description', short_description);
      formData.append('mission', mission);
      formData.append('vision', vision);
      formData.append('value', value);
      formData.append('work', work);
      formData.append('history', history);
      formData.append('other_description', otherDescription);
      if (organizationDocument) {
        formData.append('organization_document', organizationDocument);
      }
      $.ajax({
        type: 'POST',
        url: url,
        data: formData,
        processData: false, // Prevent jQuery from processing the data
        contentType: false,
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
            'content')
        },
        success: function(response) {
          toastr.success(response.message);
          $('#organization_document').val('');
          // Display the uploaded file in the preview section
          var fileUrl = response.fileUrl;
          var $previewContainer = $('#file-preview');
          $previewContainer.empty(); // Clear previous preview
          if (fileUrl) {
            var fileType = organizationDocument.type;
            if (fileType.startsWith('image/')) {
              var $img = $('<img>').attr('src', fileUrl).css('max-width',
                '100%');
              $previewContainer.append($img);
            } else if (fileType === 'application/pdf') {
              var $iframe = $('<iframe>').attr({
                src: fileUrl,
                type: 'application/pdf',
                width: '100%',
                height: '300px' // Adjust the height as needed
              });
              $previewContainer.append($iframe);
            } else if (fileType ===
              'application/vnd.openxmlformats-officedocument.wordprocessingml.document' ||
              fileType ===
              'application/vnd.openxmlformats-officedocument.presentationml.presentation'
            ) {
              // For DOCX and PPT files, provide a link to open the file in a new tab
              var $link = $('<a>').attr({
                href: fileUrl,
                target: '_blank'
              }).text('Open file: ' + organizationDocument.name);
              $previewContainer.append($link);
            } else {
              // For other file types, provide a link to open the file in a new tab
              var $link = $('<a>').attr({
                href: fileUrl,
                target: '_blank'
              }).text('Open file: ' + organizationDocument.name);
              $previewContainer.append($link);
            }
          }
        },
        error: function(xhr) {
          var errors = xhr.responseJSON.errors;
          // Iterate through each error and display the message using Toastr
          $.each(errors, function(key, value) {
            console.log(value[0]);
            toastr.error(value[
              0
            ]); // Displaying the first error message for each field
          });
        }
      });
    });
    $('#social-submit').on('click', function(e) {
      e.preventDefault();
      let url = "{{ route('member.profile.update.social') }}";
      // Collect form data manually
      let formData = {
        facebook: $('#facebook').val(),
        twitter: $('#twitter').val(),
        linkedin: $('#linkedin').val(),
        instagram: $('#instagram').val(),
        youtube: $('#youtube').val(),
      };
      $.ajax({
        type: 'POST',
        url: url,
        data: formData,
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
          console.log(response);
          toastr.success(response.message);
        },
        error: function(xhr) {
          console.log(xhr);
          var errors = xhr.responseJSON.errors;
          console.log(errors)
          // Iterate through each error and display the message using Toastr
          $.each(errors, function(key, value) {
            console.log(value[0]);
            toastr.error(value[
              0
            ]); // Displaying the first error message for each field
          });
        }
      });
    });
  });
  $(document).ready(function() {
    var existingFileUrl =
      "{{ asset('public/frontend/images/member/' . ($member->memberInfos[0]['profile_attachment'] ?? '')) }}";
    var $previewContainer = $('#file-preview');
    // Function to preview a file
    function previewFile(fileUrl, fileType, fileName) {
      $previewContainer.empty();
      if (fileType.startsWith('image/')) {
        var $img = $('<img>').attr('src', fileUrl).css('max-width', '100%');
        $previewContainer.append($img);
      } else if (fileType === 'application/pdf') {
        var $iframe = $('<iframe>').attr({
          src: fileUrl,
          type: 'application/pdf',
          width: '100%',
          height: '300px' // Adjust the height as needed
        });
        $previewContainer.append($iframe);
      } else if (fileType === 'application/vnd.openxmlformats-officedocument.wordprocessingml.document' ||
        fileType === 'application/vnd.openxmlformats-officedocument.presentationml.presentation') {
        // For DOCX and PPT files, provide a link to open the file in a new tab
        var $link = $('<a>').attr({
          href: fileUrl,
          target: '_blank'
        }).text('Open file: ' + fileName);
        $previewContainer.append($link);
      } else {
        // For other file types, provide a link to open the file in a new tab
        var $link = $('<a>').attr({
          href: fileUrl,
          target: '_blank'
        }).text('Open file: ' + fileName);
        $previewContainer.append($link);
      }
    }
    // Preview existing file if it exists
    if (existingFileUrl) {
      var existingFileName = "{{ $member->memberInfos[0]['profile_attachment'] ?? '' }}";
      var fileExtension = existingFileName.split('.').pop().toLowerCase();
      var fileType;
      switch (fileExtension) {
        case 'jpg':
        case 'jpeg':
        case 'png':
        case 'gif':
          fileType = 'image/' + fileExtension;
          break;
        case 'pdf':
          fileType = 'application/pdf';
          break;
        case 'docx':
          fileType = 'application/vnd.openxmlformats-officedocument.wordprocessingml.document';
          break;
        case 'pptx':
          fileType = 'application/vnd.openxmlformats-officedocument.presentationml.presentation';
          break;
        default:
          fileType = 'application/octet-stream';
      }
      previewFile(existingFileUrl, fileType, existingFileName);
    }
    // Set up event listener for file input change
    $('#organization_document').on('change', function() {
      var file = this.files[0];
      if (file) {
        var reader = new FileReader();
        reader.onload = function(e) {
          var blob = new Blob([e.target.result], {
            type: file.type
          });
          var url = URL.createObjectURL(blob);
          previewFile(url, file.type, file.name);
        };
        reader.readAsArrayBuffer(file);
      }
    });
  });
</script>
@endpush
@endsection