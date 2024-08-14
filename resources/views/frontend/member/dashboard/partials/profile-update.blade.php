@php
    $member = Auth::guard('member')->user()->load('memberInfos');
@endphp
{{-- Tab content start here  --}}
<div id="profile" role="tabpanel" aria-labelledby="profile-tab" tabindex="0">
    {{-- sub tabs start  --}}
    <ul class="sub-profile-tabs nav nav-tabs" id="pills-tab" role="tablist">
        <li class="nav-item" role="presentation">
            <a href="#" class="nav-link active" id="information-tab" data-bs-toggle="tab"
                data-bs-target="#information" role="tab" aria-controls="information" aria-selected="true"><i
                    class="fas fa-info-circle"></i>&nbsp;Information</a>
        </li>
        <li class="nav-item" role="presentation">
            <a href="#" class="nav-link" id="profile-summery-tab" data-bs-toggle="tab"
                data-bs-target="#profile-summery-profile" role="tab" aria-controls="profile-summery-profile"
                aria-selected="false"><i class="fas fa-user-circle"></i>&nbsp;Profile Summary</a>
        </li>
        <li class="nav-item" role="presentation">
            <a href="#" class="nav-link" id="social-links-tab" data-bs-toggle="tab" data-bs-target="#social-links"
                role="tab" aria-controls="social-links" aria-selected="false"><i
                    class="fas fa-share-alt"></i>&nbsp;Social Links</a>
        </li>
    </ul>
    <div class="tab-content mt-2" id="pills-tabContent">
        <div class="tab-pane fade show active member-profile-info" id="information" role="tabpanel"
            aria-labelledby="information-tab" tabindex="0">
            <div class="row">
                <form id="member-profile-update" action="" method="post">
                    <div class="col-lg-12 mb-3 mb-lg-0">
                        <div class="d-flex align-item-center justify-content-between border-bottom">
                            <h4 class="form-title  pb-2 pt-3">Your Organization Details &nbsp; <i
                                    class="far fa-edit edit-info-btn" data-type="org_details"></i></h4>
                        </div>
                        <div class="row mobile-border-none pt-2 edit-org">
                            <div class="col-12 mb-3">
                                <div class="row align-items-center">
                                    <div class="col-md-4">
                                        <label for="org_name" class="form-label required">Organization
                                            Name</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="text" readonly name="org_name"
                                            class="form-control member-profile-input required" id="org_name"
                                            placeholder="Your Organization Name"
                                            value="{{ $member->memberInfos[0]['organisation_name'] }}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 mb-3">
                                <div class="row align-items-center">
                                    <div class="col-md-4">
                                        <label for="org_website" class="form-label required">Organization
                                            Website</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="text" readonly name="org_website"
                                            class="form-control member-profile-input" id="org_website"
                                            placeholder="Your Organization Website"
                                            value="{{ $member->memberInfos[0]['organisation_website'] }}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 mb-3">
                                <div class="row align-items-center">
                                    <div class="col-md-4">
                                        <label for="org_email" class="form-label required">Organization
                                            Email</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="email" name="org_email" class="form-control member-profile-input"
                                            id="org_email" placeholder="Organization Email"
                                            value="{{ $member->memberInfos[0]['organisation_email'] }}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 mb-3">
                                <div class="row align-items-center">
                                    <div class="col-md-4">
                                        <label for="org_type" class="form-label required">Organization
                                            Type</label>
                                    </div>
                                    <div class="col-md-8">
                                        <select name="org_type" class="form-select member-profile-select"
                                            id="org_type" aria-label="Organisation Type" disabled required>
                                            <option disabled selected>Organization Type</option>
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
                                        <label for="ngo_reg_number" class="form-label required">Bureau Reg
                                            Number</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="text" readonly name="ngo_reg_number"
                                            class="form-control member-profile-input" id="ngo_reg_number"
                                            placeholder="Organization NGO Bureau Registration Number" required
                                            value="{{ $member->memberInfos[0]['organisation_ngo_reg'] }}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 mb-3">
                                <div class="row align-items-center">
                                    <div class="col-md-4">
                                        <label for="org_address" class="form-label required">Organization
                                            Address</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="text" readonly name="org_address"
                                            class="form-control member-profile-input" id="org_address"
                                            placeholder="Organization Address"
                                            value="{{ $member->memberInfos[0]['organisation_address'] }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Organisation Director Details Section -->
                    <div class="col-lg-12 mb-3 mb-lg-0">
                        <h4 class="form-title border-bottom pb-2 pt-3">Your Organization Director
                            Details
                            &nbsp; <i class="far fa-edit edit-info-btn" data-type="org_director"></i>
                        </h4>
                        <div class="row pt-2 edit-orgDirector">
                            <div class="col-12 mb-3">
                                <div class="row align-items-center">
                                    <div class="col-md-4">
                                        <label for="director_name" class="form-label required">Country
                                            Director
                                            Name</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="text" readonly name="director_name"
                                            class="form-control member-profile-input" id="director_name"
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
                                        <input type="email" name="director_email"
                                            class="form-control member-profile-input" id="director_email"
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
                                        <input type="text" readonly name="director_phone"
                                            class="form-control member-profile-input" id="director_phone"
                                            placeholder="Phone"
                                            value="{{ $member->memberInfos[0]['director_phone'] }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Member Access Credential Section -->
                    <div class="col-12">
                        <h4 class="form-title border-bottom pb-2 pt-3">Member Access Credential
                            &nbsp; <i class="far fa-edit edit-info-btn" data-type="org_login"></i>
                        </h4>
                        <div class="row pt-2 edit-memberCreden">
                            <div class="col-lg-6 mb-3">
                                <div class="row align-items-center">
                                    <div class="col-md-4">
                                        <label for="login_email" class="form-label required">Email
                                            (For
                                            Login)</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="email" name="login_email"
                                            class="form-control member-profile-input" id="login_email"
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
                                        <input type="text" readonly name="login_phone"
                                            class="form-control member-profile-input" id="login_phone"
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
                                        <input type="password" name="password"
                                            class="form-control member-profile-input" id="password"
                                            placeholder="Password" readonly required>
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
                                        <input type="password" name="password_confirmation"
                                            class="form-control member-profile-input" id="password_confirmation"
                                            placeholder="Confirm Password" readonly required>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 text-end pt-3">
                                <button id="member-submit" type="submit" class="submit-btn" style="display: none;">
                                    <i class="fas fa-upload"></i> Update
                                    <span id="spinner" class="spinner-border spinner-border-sm ms-2 d-none"
                                        role="status" aria-hidden="true"></span>
                                </button>
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
                    <!-- Title -->
                    <div class="col-12 mb-3 position-relative">
                        <label for="title" class="form-label text-nowrap m-0 required">Title&nbsp;
                            <i class="fas fa-edit edit-icon" data-target="#title"></i>
                        </label>
                        <input type="text" readonly class="form-control member-profile-input" id="title"
                            name="title" placeholder="Title" value="{{ $member->memberInfos[0]['title'] ?? '' }}">
                    </div>

                    <!-- Sub Title -->
                    <div class="col-12 mb-3 position-relative">
                        <label for="sub_title" class="form-label text-nowrap m-0 required">Sub Title&nbsp;
                            <i class="fas fa-edit edit-icon" data-target="#sub_title"></i>
                        </label> &nbsp;
                        <input type="text" readonly class="form-control member-profile-input" id="sub_title"
                            name="sub_title" placeholder="Sub Title"
                            value="{{ $member->memberInfos[0]['sub_title'] ?? '' }}">
                    </div>

                    <!-- Short Description -->
                    <div class="col-12 mb-3 position-relative">
                        <label for="short_description" class="form-label">Short Description&nbsp;
                            <i class="fas fa-edit edit-icon" data-target="#short_description"></i>
                        </label>
                        <textarea class="form-control" id="short_description" readonly name="short_description" rows="3">{{ $member->memberInfos[0]['short_description'] ?? '' }}</textarea>
                    </div>

                    <!-- Organization Document -->
                    <div class="col-12 mb-3 position-relative">
                        <label for="organization_document" class="form-label text-nowrap m-0">Organization
                            Document&nbsp;
                            <i class="fas fa-edit edit-icon" data-target="#organization_document"></i>
                        </label>
                        <input type="file" class="form-control member-profile-input" id="organization_document"
                            name="organization_document" disabled>
                    </div>

                    <!-- Mission -->
                    <div class="col-12 mb-3 position-relative">
                        <label for="mission" class="form-label">Mission</label>
                        <textarea class="form-control member-profile-input" id="mission" name="mission" rows="3"
                            style="margin-bottom: -90px;">{{ $member->memberInfos[0]['mission'] ?? '' }}</textarea>
                    </div>

                    <!-- Vision -->
                    <div class="col-12 mb-3 position-relative">
                        <label for="vision" class="form-label">Vision</label>
                        <textarea class="form-control member-profile-input" id="vision" name="vision" rows="3"
                            style="margin-bottom: -90px;">{{ $member->memberInfos[0]['vision'] ?? '' }}</textarea>
                    </div>

                    <!-- Values -->
                    <div class="col-12 mb-3 position-relative">
                        <label for="values" class="form-label">Values</label>
                        <textarea class="form-control member-profile-input" id="values" name="values" rows="3"
                            style="margin-bottom: -90px;">{{ $member->memberInfos[0]['value'] ?? '' }}</textarea>
                    </div>

                    <!-- Work or Projects -->
                    <div class="col-12 mb-3 position-relative">
                        <label for="work" class="form-label">Work or Projects</label>
                        <textarea class="form-control member-profile-input" id="work" name="work" rows="3"
                            style="margin-bottom: -90px;">{{ $member->memberInfos[0]['work'] ?? '' }}</textarea>
                    </div>

                    <!-- History -->
                    <div class="col-12 mb-3 position-relative">
                        <label for="history" class="form-label">History</label>
                        <textarea class="form-control member-profile-input" id="history" name="history" rows="3"
                            style="margin-bottom: -90px;">{{ $member->memberInfos[0]['history'] ?? '' }}</textarea>
                    </div>

                    <!-- Other Description -->
                    <div class="col-12 mb-3 position-relative">
                        <label for="other_description" class="form-label">Other Description</label>
                        <textarea class="form-control member-profile-input" id="other_description" name="other_description" rows="3"
                            style="margin-bottom: -90px;">{{ $member->memberInfos[0]['other_description'] ?? '' }}</textarea>
                    </div>

                    <!-- Submit Button -->
                    <div class="col-12 mb-3 text-end">
                        <button id="profilData-submit" class="submit-btn">
                            <i class="fas fa-upload"></i> Update
                            <span id="spinner-2" class="spinner-border spinner-border-sm ms-2 d-none" role="status"
                                aria-hidden="true"></span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
        <div class="tab-pane fade" id="social-links" role="tabpanel" aria-labelledby="social-links-tab"
            tabindex="0">
            <form action="" id="social-form">
                <div id="formContainer" class="row">
                    <div class="col-12 mb-3">
                        <label for="facebook" class="form-label">Facebook&nbsp;
                            <i class="fas fa-edit edit-social-icon" data-target="#facebook"></i>
                        </label>
                        <input type="text" readonly class="form-control member-profile-input" id="facebook"
                            name="facebook" placeholder="Facebook Link"
                            value="{{ $member->memberInfos[0]['facebook'] ?? '' }}">
                    </div>
                    <div class="col-12 mb-3">
                        <label for="twitter" class="form-label">Twitter&nbsp;
                            <i class="fas fa-edit edit-social-icon" data-target="#twitter"></i>
                        </label>
                        <input type="text" readonly class="form-control member-profile-input" id="twitter"
                            name="twitter" placeholder="Twitter Link"
                            value="{{ $member->memberInfos[0]['twitter'] ?? '' }}">
                    </div>
                    <div class="col-12 mb-3">
                        <label for="linkedin" class="form-label">Linkedin&nbsp;
                            <i class="fas fa-edit edit-social-icon" data-target="#linkedin"></i>
                        </label>
                        <input type="text" readonly class="form-control member-profile-input" id="linkedin"
                            name="linkedin" placeholder="Linkedin Link"
                            value="{{ $member->memberInfos[0]['linkedin'] ?? '' }}">
                    </div>
                    <div class="col-12 mb-3">
                        <label for="instagram" class="form-label">Instagram&nbsp;
                            <i class="fas fa-edit edit-social-icon" data-target="#instagram"></i>
                        </label>
                        <input type="text" readonly class="form-control member-profile-input" id="instagram"
                            placeholder="Instagram Link" value="{{ $member->memberInfos[0]['instagram'] ?? '' }}">
                    </div>
                    <div class="col-12 mb-3">
                        <label for="youtube" class="form-label">YouTube&nbsp;
                            <i class="fas fa-edit edit-social-icon" data-target="#youtube"></i>
                        </label>
                        <input type="text" readonly class="form-control member-profile-input" id="youtube"
                            name="youtube" placeholder="YouTube Link"
                            value="{{ $member->memberInfos[0]['youtube'] ?? '' }}">
                    </div>
                    <div class="col-12 text-end">
                        <button id="social-submit" class="submit-btn">
                            <i class="fas fa-upload"></i> Update
                            <span id="spinner-3" class="spinner-border spinner-border-sm ms-2 d-none" role="status"
                                aria-hidden="true"></span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    {{-- sub tabs end  --}}
</div>
{{-- Tab content end here --}}

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
                $('#spinner').removeClass('d-none');
                $(this).prop('disabled', true);
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
                        $('#spinner').addClass('d-none');
                        $('#member-submit').prop('disabled', false);
                        $('#member-profile-update input').attr('readonly', true);
                        toastr.success(response.message);
                    },
                    error: function(xhr) {
                        $('#spinner').addClass('d-none');
                        $('#member-submit').prop('disabled', false);
                        var errors = xhr.responseJSON.errors;
                        // Iterate through each error and display the message using Toastr
                        $.each(errors, function(key, value) {
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
                            // Make text inputs and textareas readonly
                            $('#profilDataForm input[type="text"], #profilDataForm textarea')
                                .attr('readonly', true);

                            // Disable file inputs
                            $('#profilDataForm input[type="file"]').prop('disabled', true);

                            // Set CKEditor instances to readonly
                            const ckeditorInstances = [
                                // 'short_description',
                                'mission',
                                'vision',
                                'values',
                                'work',
                                'history',
                                'other_description'
                            ];

                            ckeditorInstances.forEach(function(id) {
                                if (CKEDITOR.instances[id]) {
                                    CKEDITOR.instances[id].setReadOnly(true);
                                }
                            });
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
                $('#spinner-2').removeClass('d-none');
                $(this).prop('disabled', true);
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
                        $('#spinner-2').addClass('d-none');
                        $('#profilData-submit').prop('disabled', false);
                        $('#profilDataForm input').attr('readonly', true);
                        toastr.success(response.message);
                        var organizationDocument = $('#organization_document').val('');
                        // Display the uploaded file in the preview section
                        var fileUrl = response.profile_attachment;
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
                        $('#spinner-2').addClass('d-none');
                        $('#profilData-submit').prop('disabled', false);
                        var errors = xhr.responseJSON.errors;
                        // Iterate through each error and display the message using Toastr
                        $.each(errors, function(key, value) {
                            toastr.error(value[
                                0
                            ]); // Displaying the first error message for each field
                        });
                    }
                });
            });
            $('#social-submit').on('click', function(e) {
                e.preventDefault();
                $('#spinner-3').removeClass('d-none');
                $(this).prop('disabled', true);
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
                        $('#spinner-3').addClass('d-none');
                        $('#social-submit').prop('disabled', false);
                        $('#social-form input').attr('readonly', true);
                        toastr.success(response.message);
                    },
                    error: function(xhr) {
                        $('#spinner-3').addClass('d-none');
                        $('#social-submit').prop('disabled', false);
                        var errors = xhr.responseJSON.errors;
                        // Iterate through each error and display the message using Toastr
                        $.each(errors, function(key, value) {
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
        // query for make profile infor editable
        $(document).ready(function() {
            $('.edit-info-btn').on('click', function() {
                var type = $(this).data('type');

                var $orgDiv = $('.edit-org');
                var isOrgReadonly = $orgDiv.find('input.member-profile-input').prop('readonly');

                var $orgDirectorDiv = $('.edit-orgDirector');
                var isOrgDirReadonly = $orgDirectorDiv.find('input.member-profile-input').prop('readonly');

                var $orgCredenDiv = $('.edit-memberCreden');
                var isOrgCredenReadonly = $orgCredenDiv.find('input.member-profile-input').prop('readonly');

                $('#member-submit').hide(); // Initially hide the submit button

                if (isOrgReadonly && type === "org_details") {
                    // Make Organisation fields editable
                    $orgDiv.find('input.member-profile-input').removeClass('member-profile-input').prop(
                        'readonly', false);
                    $orgDiv.find('select.member-profile-select').removeClass('member-profile-select').prop(
                        'disabled', false);
                    $('#member-submit').show();
                } else if (isOrgDirReadonly && type === "org_director") {
                    // Make Director fields editable
                    $orgDirectorDiv.find('input.member-profile-input').removeClass('member-profile-input')
                        .prop('readonly', false);
                    $('#member-submit').show();
                } else if (isOrgCredenReadonly && type === "org_login") {
                    // Make Credentials fields editable
                    $orgCredenDiv.find('input.member-profile-input').removeClass('member-profile-input')
                        .prop('readonly', false);
                    $('#member-submit').show();
                } else {
                    // Revert all fields to non-editable
                    $orgDiv.find('input').addClass('member-profile-input').prop('readonly', true);
                    $orgDiv.find('select').addClass('member-profile-select').prop('disabled', true);

                    $orgDirectorDiv.find('input').addClass('member-profile-input').prop('readonly', true);

                    $orgCredenDiv.find('input:not([type="submit"])').addClass('member-profile-input').prop(
                        'readonly', true);
                }
            });

            $('.edit-icon').on('click', function() {
                var target = $(this).data('target');
                var $targetField = $(target);

                if ($targetField.is('textarea')) {
                    // For text areas, just toggle readonly
                    if ($targetField.prop('readonly')) {
                        $targetField.prop('readonly', false);
                    } else {
                        $targetField.prop('readonly', true);
                    }
                } else {
                    // For other inputs, toggle readonly and disabled, and also handle class
                    if ($targetField.prop('readonly') || $targetField.prop('disabled')) {
                        $targetField.prop('readonly', false).prop('disabled', false).removeClass(
                            'member-profile-input');
                    } else {
                        $targetField.prop('readonly', true).prop('disabled', true).addClass(
                            'member-profile-input');
                    }
                }
            });

            $('.edit-social-icon').on('click', function() {
                var target = $(this).data('target');
                var $targetField = $(target);
                // For other inputs, toggle readonly and disabled, and also handle class
                if ($targetField.prop('readonly') || $targetField.prop('disabled')) {
                    $targetField.prop('readonly', false).prop('disabled', false).removeClass(
                        'member-profile-input');
                    $('#social-submit').show();
                } else {
                    $targetField.prop('readonly', true).prop('disabled', true).addClass(
                        'member-profile-input');
                    $('#social-submit').hide();
                }
            });
        });
    </script>
@endpush
