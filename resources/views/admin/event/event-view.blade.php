@extends('admin.layouts.backend-layout')
@section('breadcame')
    Request Event View
@endsection
@section('admin-content')
    <div class="card">
        <div class="d-flex justify-content-between align-items-center py-3 px-3 border-bottom">
            <div id="view-header-container" class="d-flex justify-content-between align-items-center" style="width: 92%;">
                @include('admin.event.partials.view-header')
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
                <div class="col-md-8">
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
                                        {{ $event->creator->info->organisation_name }}</span>
                                    <!--end::Label-->
                                </div>
                                <!--end::Item-->
                                
                            </div>
                            <!--end::Info-->
                            <!--begin::Title-->
                            
                            <!--end::Title-->
                            <!--begin::Container-->
                            <div class="overlay mt-8">
                                <!--begin::Image-->
                                <img style="width: 100%" src="{{ asset('public/frontend/images/events/' . ($event->media ?? 'placeholder.jpg')) }}" alt="event emage">
                                <!--end::Image-->
                            </div>
                            <!--end::Container-->
                            <p class="text-dark fs-2">{!! $event->details !!}</p>
                        </div>
                        <!--end::Wrapper-->
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <h6 class="card-title">
                                <i class="fas fa-calendar-alt"></i> Schedule
                            </h6>
                            <p class="card-text"><strong>Start:</strong> {{ \Carbon\Carbon::parse($event->start_date)->format('D, M d, h:i A') }}</p>
                            <p class="card-text"><strong>End:</strong> {{ \Carbon\Carbon::parse($event->end_date)->format('D, M d, h:i A') }}</p>
                    
                            @if(!empty($event->reg_dead_line))
                                <p class="card-text">
                                    <strong>Registration Deadline:</strong> {{ \Carbon\Carbon::parse($event->reg_dead_line)->format('D, M d, h:i A') }}
                                </p>
                            @endif
                            @if(!empty($event->capacity))
                                <p class="card-text">
                                    <strong>Capacity:</strong> {{$event->capacity}}
                                </p>
                            @endif
                    
                            <h6 class="card-title">
                                <i class="fas fa-map-marker-alt"></i> Location
                            </h6>
                            <p class="card-text">{{$event->location}}</p>
                        </div>
                    </div>
                    
                    
                    
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

                var id = $(this).data('event-id');
                var url = "{{ route('event.approved') }}";
                // Show SweetAlert confirmation dialog
                Swal.fire({
                    title: 'Are you sure?',
                    text: 'This action will approve this event!',
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

                var id = $(this).data('event-id'); // Get the URL from the href attribute
                var url = "{{ route('event.reject') }}";
                // Show SweetAlert confirmation dialog
                Swal.fire({
                    title: 'Are you sure?',
                    text: 'This action will reject this event!',
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

                var id = $(this).data('event-id'); // Get the URL from the href attribute
                var url = "{{ route('event.suspend') }}";
                // Show SweetAlert confirmation dialog
                Swal.fire({
                    title: 'Are you sure?',
                    text: 'This action will suspend this event!',
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
                            var pendingEventCount = $(data).find('.pendingEventCount').html();
                            $('.pendingEventCount').html(pendingEventCount);
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
