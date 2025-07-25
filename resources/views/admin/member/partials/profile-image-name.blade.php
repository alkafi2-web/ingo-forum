<div class="card-body pt-9 pb-0 border-bottom">
    <div class="row">
        <div class="col-md-6"><!--begin::Details-->
            <div class="d-flex flex-wrap flex-sm-nowrap mb-3">
                <!--begin: Pic-->
                {{-- @if ($member->memberInfos[0]['logo']) --}}
                <div class="me-7 mb-4">
                    <div class="symbol symbol-100px symbol-lg-160px symbol-fixed position-relative">
                        <img src="{{ asset('public/frontend/images/member/' . ($member->memberInfos[0]['logo'] ?? 'placeholder.jpg')) }}"
                            alt="member" />
                        {{-- <div class="position-absolute translate-middle bottom-0 start-100 mb-6 bg-success rounded-circle border-4 border-white h-20px w-20px"></div> --}}
                    </div>
                </div>
                {{-- @endif --}}
                <!--end::Pic-->
                <!--begin::Info-->
                <div class="flex-grow-1">
                    <!--begin::Title-->
                    <div class="d-flex justify-content-between align-items-start flex-wrap mb-2">
                        <!--begin::User-->
                        <div class="d-flex flex-column">
                            <!--begin::Name-->
                            <div class="d-flex align-items-center mb-2">
                                <a href="javascript:void(0);"
                                    class="text-gray-900 text-hover-primary fs-2 fw-bolder me-1">{{ $member->memberInfos[0]['organisation_name'] }}</a>
                                @if ($member->memberInfos[0]['membership_id'] != null)
                                    <a href="javascript:void(0);">
                                        <!--begin::Svg Icon | path: icons/duotune/general/gen026.svg-->
                                        <span class="svg-icon svg-icon-1 svg-icon-primary">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px"
                                                viewBox="0 0 24 24">
                                                <path
                                                    d="M10.0813 3.7242C10.8849 2.16438 13.1151 2.16438 13.9187 3.7242V3.7242C14.4016 4.66147 15.4909 5.1127 16.4951 4.79139V4.79139C18.1663 4.25668 19.7433 5.83365 19.2086 7.50485V7.50485C18.8873 8.50905 19.3385 9.59842 20.2758 10.0813V10.0813C21.8356 10.8849 21.8356 13.1151 20.2758 13.9187V13.9187C19.3385 14.4016 18.8873 15.491 19.2086 16.4951V16.4951C19.7433 18.1663 18.1663 19.7433 16.4951 19.2086V19.2086C15.491 18.8873 14.4016 19.3385 13.9187 20.2758V20.2758C13.1151 21.8356 10.8849 21.8356 10.0813 20.2758V20.2758C9.59842 19.3385 8.50905 18.8873 7.50485 19.2086V19.2086C5.83365 19.7433 4.25668 18.1663 4.79139 16.4951V16.4951C5.1127 15.491 4.66147 14.4016 3.7242 13.9187V13.9187C2.16438 13.1151 2.16438 10.8849 3.7242 10.0813V10.0813C4.66147 9.59842 5.1127 8.50905 4.79139 7.50485V7.50485C4.25668 5.83365 5.83365 4.25668 7.50485 4.79139V4.79139C8.50905 5.1127 9.59842 4.66147 10.0813 3.7242V3.7242Z"
                                                    fill="#00A3FF"></path>
                                                <path class="permanent"
                                                    d="M14.8563 9.1903C15.0606 8.94984 15.3771 8.9385 15.6175 9.14289C15.858 9.34728 15.8229 9.66433 15.6185 9.9048L11.863 14.6558C11.6554 14.9001 11.2876 14.9258 11.048 14.7128L8.47656 12.4271C8.24068 12.2174 8.21944 11.8563 8.42911 11.6204C8.63877 11.3845 8.99996 11.3633 9.23583 11.5729L11.3706 13.4705L14.8563 9.1903Z"
                                                    fill="white"></path>
                                            </svg>
                                        </span>
                                        <!--end::Svg Icon-->
                                    </a>
                                @endif
                            </div>
                            <!--end::Name-->
                            <!--begin::Info-->
                            <div class=" fw-bold fs-6 mb-4 pe-2 ">
                                <div>
                                    @if ($member->memberInfos[0]['membership_id'] != null)
                                        <span class="membership-id me-2 ">
                                            <i class="fas fa-id-badge fa-lg text-primary"></i>
                                            {{ $member->memberInfos[0]['membership_id'] }}
                                        </span>
                                    @endif
                                    <div class="mt-2">
                                        @if ($member->memberInfos[0]['organisation_ngo_reg'] != null)
                                            <span class="membership-id me-2 ">
                                                <i class="fas fa-id-badge fa-lg text-primary"></i>
                                                {{ $member->memberInfos[0]['organisation_ngo_reg'] }}
                                            </span>
                                        @endif
                                    </div>
                                    {{-- <div class="mt-2">
                                        @if ($member->memberInfos[0]['org_type'] == 1)
                                            <span class="badge badge-secondary"><i
                                                    class="fas fa-info-circle fa-lg text-mute mt-1"></i>&nbsp;
                                                Registered with NGO Affairs Bureau (NGOAB) as an INGO</span>
                                        @else
                                            <span class="badge badge-secondary"><i
                                                    class="fas fa-info-circle fa-lg text-mute mt-1"></i>&nbsp;
                                                Possess
                                                international governance
                                                structures</span>
                                        @endif
                                    </div> --}}



                                </div>
                                <!--end::Info-->
                            </div>
                            <!--end::User-->
                        </div>
                        <!--end::Title-->
                    </div>
                    <!--end::Info-->
                </div>
                <!--end::Details-->
            </div>
        </div>
        <div class="col-md-6">
            <form id="feedback-form">
                <div class="form-group mb-3">
                    <input type="hidden" name="member_id" id="member_id" value="{{ $member->id }}">
                    <textarea id="feedback" class="form-control" name="message" rows="4" placeholder="Write your feedback here..."></textarea>
                </div>
                <div class="d-flex justify-content-end">
                    <button type="button" class="btn btn-secondary me-2" id="see-feeback">
                        <i class="fas fa-eye"></i> See Feedback
                    </button>
                    <button type="submit" id="submit" class="btn btn-primary">
                        <i class="fas fa-paper-plane"></i> Submit Feedback
                        <span class="spinner-border spinner-border-sm ms-2 d-none" id="feedback-spinner" role="status"
                            aria-hidden="true"></span>
                    </button>
                </div>
            </form>
            <!-- Modal Structure -->
            <div class="modal fade" id="feedbackModal" tabindex="-1" aria-labelledby="feedbackModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="feedbackModalLabel">Feedback</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            @include('admin.member.datatables.feedback-list-datatable')
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>
</div>

@push('custom-js')
    <script>
        $(document).ready(function() {
            $('#submit').on('click', function(e) {
                e.preventDefault();
                $('#feedback-spinner').removeClass('d-none'); // Show the spinner
                $(this).prop('disabled', true); // Disable the submit button

                let url = "{{ route('member.feedback.store') }}"; // Change this to your feedback route
                let formData = new FormData($('#feedback-form')[0]);

                $.ajax({
                    type: 'POST',
                    url: url,
                    data: formData,
                    processData: false, // Prevent jQuery from processing the data
                    contentType: false, // Prevent jQuery from setting the content type
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                            'content') // CSRF token for security
                    },
                    success: function(response) {
                        console.log(response);
                        $('#feedback-spinner').addClass('d-none'); // Hide the spinner
                        $('#submit').prop('disabled', false); // Re-enable the submit button

                        if (response.type) {
                            // Display success, warning, or error message based on the response type
                            toastr[response.type](response.message);

                            if (response.type === 'success') {
                                $('#feedback-form')[0].reset(); // Clear the form on success
                                $('#feedback-data').DataTable().ajax.reload(null,
                                false); // Reload DataTable without resetting the page
                            }
                        }
                    },
                    error: function(xhr) {
                        $('#feedback-spinner').addClass('d-none'); // Hide the spinner
                        $('#submit').prop('disabled', false); // Re-enable the submit button

                        if (xhr.responseJSON && xhr.responseJSON.errors) {
                            var errors = xhr.responseJSON.errors; // Extract errors
                            $.each(errors, function(key, value) {
                                toastr.error(value[0]); // Display each error message
                            });
                        } else if (xhr.responseJSON && xhr.responseJSON.message) {
                            toastr.error(xhr.responseJSON
                            .message); // Display general error message
                        } else {
                            toastr.error(
                            'An unexpected error occurred.'); // Fallback error message
                        }
                    }
                });
            });
            $('#see-feeback').on('click', function() {
                // Adjust the route to match your feedback route
                $('#feedbackModal').modal('show');
                // Fetch feedback data via AJAX

            });
        });
    </script>
@endpush
