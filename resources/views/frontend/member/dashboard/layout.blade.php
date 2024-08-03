@extends('frontend.layouts.frontend-page-layout')
@section('page-title', 'Dashboard')
@section('frontend-section')
    <!-- Profile edit page start -->
    <section class="ptb-50">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="row">
                        @php
                            $member = Auth::guard('member')->user()->load('memberInfos');
                        @endphp
                        <div class="col-lg-3 mb-3 mb-lg-0 nav flex-column nav-pills" id="v-pills-tab" role="tablist"
                            aria-orientation="vertical">
                            <div class="edit-profile-img bg-white py-4 px-3 text-center">
                                <div class="preview-img mb-3">
                                    <img src="{{ asset('public/frontend/images/member/') }}/{{ $member->memberInfos[0]['logo'] ?? 'placeholder.jpg' }}"
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
                                {{-- <button class="nav-link active" id="profile-tab" data-bs-toggle="pill" data-bs-target="#profile"
                type="button" role="tab" aria-controls="profile" aria-selected="true">Profile</button> --}}

                                <a href="{{ route('member.profile') }}" class="nav-link {{ Route::currentRouteName() == 'member.profile' ? 'active' : '' }}" id="profile-tab"
                                    type="button" aria-controls="profile" aria-selected="true">Profile</a>

                                <a href="{{ route('member.event.index') }}" class="nav-link {{ Route::currentRouteName() == 'member.event.index' ? 'active' : '' }}" type="button" role="tab"
                                    aria-controls="event" aria-selected="false">Events</a>

                                <a href="{{ route('member.post.index') }}" class="nav-link {{ Route::currentRouteName() == 'member.post.index' ? 'active' : '' }}" id="blog-news-tab" 
                                    
                                    aria-selected="true">Blog/News</a>

                                <a href="{{ route('member.publication.index') }}" class="nav-link {{ Route::currentRouteName() == 'member.publication.index' ? 'active' : '' }}" id="publication-tab"
                                    data-bs-target="#publication" type="button" role="tab" aria-controls="publication"
                                    aria-selected="true">Publication</a>

                                {{-- <button class="nav-link" id="user-section-tab" data-bs-toggle="pill" data-bs-target="#user-section"
                type="button" role="tab" aria-controls="user-section" aria-selected="true">User Section</button> --}}
                            </div>
                        </div>
                        <div class="col-lg-9 tab-content bg-white p-3 rounded" id="v-pills-tabContent">
                            @yield('member-dashboard')
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
