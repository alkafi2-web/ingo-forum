@extends('admin.layouts.backend-layout')
@section('breadcame')
    Request Post View
@endsection
@section('admin-content')
    <div class="card">
        <div class="d-flex justify-content-between align-items-center py-3 px-3 border-bottom">
            <div id="view-header-container" class="d-flex justify-content-between align-items-center" style="width: 92%;">
                @include('admin.post.partials.view-header')
            </div>
            <div>
                <a href="{{ url()->previous() }}">
                    <button class="btn btn-info">
                        <i class="fas fa-arrow-left"></i> Back
                    </button>
                </a>
            </div>
        </div>
        <div id="profile-image-name">
            {{-- @include('admin.member.partials.profile-image-name') --}}
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
                                    {{ $post->addedBy_member->organisation_name }}</span>
                                <!--end::Label-->
                            </div>
                            <!--end::Item-->
                            <!--begin::Item-->
                            <div class="me-9 my-1">
                                <!--begin::Icon-->
                                <i class="fas fa-filter text-success"></i>
                                <!--end::Icon-->
                                <!--begin::Label-->
                                <span class="fw-bolder text-gray-400">Category:</span> <span class="fw-bolder ">{{ $post->category->name }}</span>
                                <!--begin::Label-->
                            </div>
                            <!--end::Item-->
                            <!--begin::Item-->
                            <div class="my-1">
                                <!--begin::Icon-->
                                <!--begin::Svg Icon | path: icons/duotune/communication/com003.svg-->
                                <span class="svg-icon svg-icon-primary svg-icon-2 me-1">
                                    <i class="fas fa-filter text-info"></i>
                                </span>
                                <!--end::Svg Icon-->
                                <!--end::Icon-->
                                <!--begin::Label-->
                                <span class="fw-bolder text-gray-400">Subcategory:</span> <span class="fw-bolder ">{{ $post->subcategory->name }}</span>
                                <!--end::Label-->
                            </div>
                            <!--end::Item-->
                        </div>
                        <!--end::Info-->
                        <!--begin::Title-->
                        <h4 class="text-dark text-hover-primary fs-2 fw-bolder">{{$post->title}}</h4>
                        <!--end::Title-->
                        <!--begin::Container-->
                        <div class="overlay mt-8">
                            <!--begin::Image-->
                            <div class="bgi-no-repeat bgi-position-center bgi-size-cover card-rounded min-h-350px"
                                style="background-image:url('{{ asset('public/frontend/images/posts/' . ($post->banner ?? 'placeholder.jpg')) }}')"></div>
                            <!--end::Image-->
                            <!--begin::Links-->
                            {{-- <div class="overlay-layer card-rounded bg-dark bg-opacity-25">
                                <span class="fw-bolder text-gray-400">Subcategory:</span> <span class="fw-bolder ">{{ $post->subcategory->name }}</span>
                                <a href="../../demo1/dist/pages/careers/apply.html" class="btn btn-light-primary ms-3">Join
                                    Us</a>
                            </div> --}}
                            <!--end::Links-->
                        </div>
                        <!--end::Container-->
                    </div>
                    <!--end::Wrapper-->
                    <!--begin::Description-->
                    <div class="fs-5 fw-bold text-gray-600">
                        <!--begin::Text-->
                        {!!$post->long_des!!}
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

                var id = $(this).data('post-id');
                var url = "{{ route('post.approved') }}";
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

                var id = $(this).data('post-id'); // Get the URL from the href attribute
                var url = "{{ route('post.reject') }}";
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

                var id = $(this).data('post-id'); // Get the URL from the href attribute
                var url = "{{ route('post.suspend') }}";
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
                            var pendingPostCount = $(data).find('.pendingPostCount').html();
                            $('.pendingPostCount').html(pendingPostCount);
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
    </script>
@endpush
