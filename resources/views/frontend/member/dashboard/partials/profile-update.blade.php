
    {{-- Tab content start here  --}}
    <div id="profile" role="tabpanel" aria-labelledby="profile-tab" tabindex="0">
        {{-- sub tabs start  --}}
        <ul class="sub-profile-tabs nav nav-pills mb-3" id="pills-tab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="information-tab" data-bs-toggle="pill" data-bs-target="#information"
                    type="button" role="tab" aria-controls="information" aria-selected="true">Information</button>
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
            <div class="tab-pane fade show active" id="information" role="tabpanel" aria-labelledby="information-tab"
                tabindex="0">
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
                                            <input type="text" name="org_name" class="form-control required"
                                                id="org_name" placeholder="Your Organisation Name"
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
                                            <select name="org_type" class="form-select" id="org_type"
                                                aria-label="Organisation Type" required>
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
                                            <label for="ngo_reg_number" class="form-label required">Bureau Reg Number</label>
                                        </div>
                                        <div class="col-md-8">
                                            <input type="text" name="ngo_reg_number" class="form-control" id="ngo_reg_number"
                                                placeholder="Organization NGO Bureau Registration Number" required value="{{ $member->memberInfos[0]['organisation_ngo_reg'] }}">
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
                                            <input type="text" name="org_address" class="form-control"
                                                id="org_address" placeholder="Organisation Address"
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
                                            <input type="text" name="director_name" class="form-control"
                                                id="director_name" placeholder="Country Director Name"
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
                                            <input type="email" name="director_email" class="form-control"
                                                id="director_email" placeholder="Country Director Email"
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
                                            <input type="text" name="director_phone" class="form-control"
                                                id="director_phone" placeholder="Phone"
                                                value="{{ $member->memberInfos[0]['director_phone'] }}">
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
                                            <input type="email" name="login_email" class="form-control"
                                                id="login_email" placeholder="Email" value="{{ $member->email }}"
                                                readonly>
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
                                                id="login_phone" placeholder="Phone" value="{{ $member->phone }}">
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
                            <input type="text" class="form-control" id="title" name="title"
                                placeholder="Title" value="{{ $member->memberInfos[0]['title'] ?? '' }}">
                        </div>
                        <div class="col-12 mb-3">
                            <label for="sub_title" class="form-label required">Sub Title</label>
                            <input type="text" class="form-control" id="sub_title" name="sub_title"
                                placeholder="Sub Title" value="{{ $member->memberInfos[0]['sub_title'] ?? '' }}">
                        </div>
                        <div class="col-12 mb-3">
                            <label for="short_description" class="form-label">Short Descrition</label>
                            <textarea class="form-control" id="short_description" name="short_description" rows="3">{{ $member->memberInfos[0]['short_description'] ?? '' }}</textarea>
                        </div>
                        <div class="col-12 mb-3">
                            <label for="organization_document" class="form-label">Organization
                                Document</label>
                            <input type="file" class="form-control" id="organization_document"
                                name="organization_document">
                            <!-- Container to display the file preview -->
                            <div id="file-preview" class="mt-3">

                            </div>
                        </div>
                        <div class="col-12 mb-3">
                            <label for="mission" class="form-label">Mission</label>
                            <textarea class="form-control" id="mission" name="mission" rows="3">{{ $member->memberInfos[0]['mission'] ?? '' }}</textarea>
                        </div>
                        <div class="col-12 mb-3">
                            <label for="vision" class="form-label">Vision</label>
                            <textarea class="form-control" id="vision" name="vision" rows="3">{{ $member->memberInfos[0]['vision'] ?? '' }}</textarea>
                        </div>
                        <div class="col-12 mb-3">
                            <label for="values" class="form-label">Values</label>
                            <textarea class="form-control" id="values" name="values" rows="3">{{ $member->memberInfos[0]['value'] ?? '' }}</textarea>
                        </div>
                        <div class="col-12 mb-3">
                            <label for="work" class="form-label">Work or Projects</label>
                            <textarea class="form-control" id="work" name="work" rows="3">{{ $member->memberInfos[0]['work'] ?? '' }}</textarea>
                        </div>
                        <div class="col-12 mb-3">
                            <label for="history" class="form-label">History</label>
                            <textarea class="form-control" id="history" name="history" rows="3">{{ $member->memberInfos[0]['history'] ?? '' }}</textarea>
                        </div>
                        <div class="col-12 mb-3">
                            <label for="other_description" class="form-label">Other Description</label>
                            <textarea class="form-control" id="other_description" name="other_description" rows="3">{{ $member->memberInfos[0]['other_description'] ?? '' }}</textarea>
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
                            <input type="text" class="form-control" id="twitter" name="twitter"
                                placeholder="Twitter Link" value="{{ $member->memberInfos[0]['twitter'] ?? '' }}">
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
                            <input type="text" class="form-control" id="youtube" name="youtube"
                                placeholder="YouTube Link" value="{{ $member->memberInfos[0]['youtube'] ?? '' }}">
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
    