@extends('admin.layouts.backend-layout')
@section('breadcame')
    Member View
@endsection
@section('admin-content')
    <div class="card">
        <div class="d-flex justify-content-between align-items-center py-3 px-3 border-bottom" id="view-header-container">
            @include('admin.member.partials.view-header')
        </div>
        
        <div class="card-body">
            <div class="row">
                <!-- Organisation Details Section -->
                <div class="col-lg-6 mb-3 mb-lg-0">
                    {{-- <h4 class="form-title border-bottom pb-2 pt-3">Your Organisation Details</h4> --}}
                    <div class="row details-border mobile-border-none pt-2">
                        <div class="col-12 mb-3">
                            <div class="row align-items-center">
                                <div class="col-md-4">
                                    <label for="org_name" class="form-label ">Organisation Name</label>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" name="org_name" class="form-control " id="org_name"
                                        placeholder="Your Organisation Name" readonly
                                        value="{{ $member->memberInfos[0]['organisation_name'] }}">
                                </div>
                            </div>
                        </div>
                        <div class="col-12 mb-3">
                            <div class="row align-items-center">
                                <div class="col-md-4">
                                    <label for="org_website" class="form-label">Organisation
                                        Website</label>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" name="org_website" class="form-control" id="org_website"
                                        placeholder="Your Organisation Website" readonly
                                        value="{{ $member->memberInfos[0]['organisation_website'] }}">
                                </div>
                            </div>
                        </div>
                        <div class="col-12 mb-3">
                            <div class="row align-items-center">
                                <div class="col-md-4">
                                    <label for="org_email" class="form-label">Organisation
                                        Email</label>
                                </div>
                                <div class="col-md-8">
                                    <input type="email" name="org_email" class="form-control" id="org_email"
                                        placeholder="Organisation Email" readonly
                                        value="{{ $member->memberInfos[0]['organisation_email'] }}">
                                </div>
                            </div>
                        </div>
                        <div class="col-12 mb-3">
                            <div class="row align-items-center">
                                <div class="col-md-4">
                                    <label for="org_type" class="form-label">Organisation Type</label>
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
                                    <label for="org_address" class="form-label">Organisation
                                        Address</label>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" name="org_address" class="form-control" id="org_address"
                                        placeholder="Organisation Address" readonly
                                        value="{{ $member->memberInfos[0]['organisation_address'] }}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Organisation Director Details Section -->
                <div class="col-lg-6 mb-3 mb-lg-0">
                    {{-- <h4 class="form-title border-bottom pb-2 pt-3">Your Organisation Director Details</h4> --}}
                    <div class="">
                        <div class="row pt-2">
                            <div class="col-12 mb-3">
                                <div class="row align-items-center">
                                    <div class="col-md-4">
                                        <label for="director_name" class="form-label">Country Director
                                            Name</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="text" name="director_name" class="form-control" id="director_name"
                                            placeholder="Country Director Name" readonly
                                            value="{{ $member->memberInfos[0]['director_name'] }}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 mb-3">
                                <div class="row align-items-center">
                                    <div class="col-md-4">
                                        <label for="director_email" class="form-label">Country Director
                                            Email (Personal)</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="email" name="director_email" class="form-control"
                                            id="director_email" placeholder="Country Director Email" readonly
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
                                            id="director_phone" placeholder="Phone" readonly
                                            value="{{ $member->memberInfos[0]['director_phone'] }}">
                                    </div>
                                </div>
                            </div>
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

                var id = $(this).data('member-id');
                var url = "{{ route('member.approved') }}";
                // Show SweetAlert confirmation dialog
                Swal.fire({
                    title: 'Are you sure?',
                    text: 'This action will approve this member!',
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

                var id = $(this).data('member-id'); // Get the URL from the href attribute
                var url = "{{ route('member.reject') }}";
                // Show SweetAlert confirmation dialog
                Swal.fire({
                    title: 'Are you sure?',
                    text: 'This action will reject this member!',
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

                var id = $(this).data('member-id'); // Get the URL from the href attribute
                var url = "{{ route('member.suspend') }}";
                // Show SweetAlert confirmation dialog
                Swal.fire({
                    title: 'Are you sure?',
                    text: 'This action will suspend this member!',
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
