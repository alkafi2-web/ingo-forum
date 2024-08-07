@extends('admin.layouts.backend-layout')
@section('breadcame')
    Request Publication View
@endsection
@section('admin-content')
    <div class="card">
        <div class="d-flex justify-content-between align-items-center py-3 px-3 border-bottom">
            <div id="view-header-container" class="d-flex justify-content-between align-items-center" style="width: 92%;">
                @include('admin.publication.partials.view-header')
            </div>
            <div>
                <a href="{{ url()->previous() }}">
                    <button class="btn btn-info">
                        <i class="fas fa-arrow-left"></i> Back
                    </button>
                </a>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body border-bottom">
            <div class="row">
                <div class="mb-17">
                    <!--begin::Wrapper-->
                    <div class="mb-8">
                        <!--begin::Info-->
                        <div class="d-flex flex-wrap mb-6">
                            <!--begin::Item-->
                            <div class="me-9 my-1">
                                <!--begin::Icon-->
                                <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                                <span class="svg-icon svg-icon-primary svg-icon-2 me-1">
                                    <i class="fas fa-user fa-fw text-primary"></i>
                                </span>
                                <!--end::Svg Icon-->
                                <!--end::Icon-->
                                <!--begin::Label-->
                                <span class="fw-bolder text-gray-400">Added By:</span> <span class="fw-bolder">
                                    {{ $publication->addedBy_member->organisation_name }}</span>
                                <!--end::Label-->
                            </div>
                            <!--end::Item-->
                            <!--begin::Item-->
                            <div class="me-9 my-1">
                                <!--begin::Icon-->
                                <i class="fas fa-filter text-success"></i>
                                <!--end::Icon-->
                                <!--begin::Label-->
                                <span class="fw-bolder text-gray-400">Category:</span> <span
                                    class="fw-bolder ">{{ $publication->category->name }}</span>
                                <!--begin::Label-->
                            </div>
                            <!--end::Item-->
                        </div>
                        <!--end::Info-->
                        <!--begin::Title-->
                        <p class="text-dark fs-2"> Short Description: {{ $publication->short_description }}</p>
                        <!--end::Title-->
                        <!--begin::Container-->
                        <div class="overlay mt-8">
                            <!--begin::Image-->
                            <div class="bgi-no-repeat bgi-position-center bgi-size-cover card-rounded min-h-350px"
                                style="background-image:url('{{ asset('public/frontend/images/publication/' . ($publication->image ?? 'placeholder.jpg')) }}')">
                            </div>
                            <!--end::Image-->
                        </div>
                        <!--end::Container-->
                    </div>
                    <!--end::Wrapper-->
                    <!--begin::Description-->
                    <div class="fs-5 fw-bold text-gray-600">
                        <!--begin::Text-->
                        <div id="file-preview" class="mt-3">

                        </div>
                        <!--end::Text-->
                    </div>
                    <!--end::Description-->

                </div>
            </div>
        </div>
    </div>
@endsection
@push('custom-js')
    <script>
        // Assuming you are using jQuery for AJAX
        $(document).ready(function() {
            $(document).on('click', '.approveButton', function(e) {
                e.preventDefault(); // Prevent default link behavior

                var id = $(this).data('publication-id');
                var url = "{{ route('publication.approved') }}";
                // Show SweetAlert confirmation dialog
                Swal.fire({
                    title: 'Are you sure?',
                    text: 'This action will approve this post!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, approve it!',
                    cancelButtonText: 'No, cancel!',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Send AJAX request
                        // sendAjaxRequest(url, row);

                        sendAjaxReq(id, status = null, url);
                    }
                });
            });
            $(document).on('click', '.rejectButton', function(e) {
                e.preventDefault(); // Prevent default link behavior

                var id = $(this).data('publication-id'); // Get the URL from the href attribute
                var url = "{{ route('publication.reject') }}";
                // Show SweetAlert confirmation dialog
                Swal.fire({
                    title: 'Are you sure?',
                    text: 'This action will reject this post!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, reject it!',
                    cancelButtonText: 'No, cancel!',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Send AJAX request
                        // sendAjaxRequest(url, row);

                        sendAjaxReq(id, status, url);
                    }
                });
            });
            $(document).on('click', '.suspendButton', function(e) {
                e.preventDefault(); // Prevent default link behavior

                var id = $(this).data('publication-id'); // Get the URL from the href attribute
                var url = "{{ route('publication.suspend') }}";
                // Show SweetAlert confirmation dialog
                Swal.fire({
                    title: 'Are you sure?',
                    text: 'This action will suspend this post!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, suspend it!',
                    cancelButtonText: 'No, cancel!',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Send AJAX request
                        // sendAjaxRequest(url, row);

                        sendAjaxReq(id, status, url);
                    }
                });
            });

            function sendAjaxReq(id, status, url, thisbtn, thatbtn) {
                var requestData = {
                    id: id,
                    // Optionally include status if it's provided
                };
                $.ajax({
                    url: url,
                    type: 'POST', // or 'GET' depending on your server endpoint
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: requestData, // You can send additional data if needed
                    success: function(response) {
                        // Swal.fire('Success!', response.success,
                        //     'success');
                        $('#view-header-container').html(response.viewHeader);
                        // $('#profile-image-name').html(response.profileImageName);
                        $.get(window.location.href, function(data) {
                            var pendingPublicationCount = $(data).find('.pendingPublicationCount').html();
                            $('.pendingPublicationCount').html(pendingPublicationCount);
                        });
                        toastr.success(response.success);
                    },
                    error: function(xhr, status, error) {
                        // Handle AJAX error
                        Swal.fire('Error!', 'An error occurred.', 'error');
                    }
                });
            }
        });

        $(document).ready(function() {
            var existingFileUrl =
                "{{ asset('public/frontend/images/publication/' . ($publication->file ?? '')) }}";
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
                var existingFileName = "{{ $publication->file ?? '' }}";
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
            
        });
    </script>
@endpush
