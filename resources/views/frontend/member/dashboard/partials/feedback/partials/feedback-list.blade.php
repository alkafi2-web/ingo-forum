<div class="table-responsive table-container">
    <!--begin::Table-->
    <table class="table election-datatable w-100 align-middle table-bordered fs-14px gy-5 m-auto display responsive"
        id="feedback-list">
        <!--begin::Table head-->
        <thead>
            <tr class="text-start text-muted fw-bolder fs-7 text-uppercase gs-0" style="background: #fff;">
                <th class="">
                    {{ __('Date') }}
                </th>
                <th class="">
                    {{ __('Feedback') }}
                </th>
                <th class="">
                    {{ __('Feedback From') }}
                </th>
                <th class="">
                    {{ __('Status') }}
                </th>
                <th class="">
                    {{ __('Action') }}</th>
            </tr>
        </thead>
        <!--end::Table head-->
    </table>
    <!--end::Table-->
    <!-- Feedback Information Modal -->
    <div class="modal fade" id="feedbackInfoModal" tabindex="-1" aria-labelledby="feedbackInfoModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="feedbackInfoModalLabel">Feedback Information</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p><strong>Feedback From:</strong> <span id="feedback-user"></span></p>
                    <p><strong>Feedback Message:</strong> <span id="feedback-message"></span></p>
                    <p><strong>Date:</strong> <span id="feedback-date"></span></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

</div>
@push('custom-js')
    <script>
        $(document).ready(function() {
            var table = $('#feedback-list').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('member.feedback.index') }}",
                    type: 'GET',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                },
                columns: [{
                        data: 'create_date',
                        name: 'create_date',
                        orderable: true,
                        sortable: false
                    },
                    {
                        data: 'message',
                        name: 'message',
                        orderable: true,
                        sortable: false
                    },
                    {
                        data: 'user_name',
                        name: 'user_name',
                        orderable: true,
                        sortable: false
                    },
                    {
                        data: 'read_status',
                        name: 'read_status',
                        orderable: true,
                        sortable: false,
                        render: function(data, type, row) {
                            // Map status values to badge classes and texts
                            const badgeMap = {
                                'unread': {
                                    class: 'bg-danger',
                                    text: 'Unread'
                                },
                                'read': {
                                    class: 'bg-success',
                                    text: 'Read'
                                },
                                // Add additional mappings as needed
                            };

                            // Default to 'bg-light' if status is not in the badgeMap
                            const badge = badgeMap[data] || {
                                class: 'bg-light',
                                text: 'Unknown'
                            };

                            return `<span class="badge ${badge.class} " data-status="${data}" data-id="${row.id}">${badge.text}</span>`;
                        }
                    },
                    {
                        data: null,
                        name: 'actions',
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row) {
                            return `
                        <a href="#" class="text-info mr-2 me-2 view" data-id="${row.id}">
                            <i class="fas fa-eye text-info" style="font-size: 16px;"></i>
                        </a>`;
                        }
                    }
                ],
                lengthMenu: [
                    [5, 10, 30, 50, -1],
                    [5, 10, 30, 50, "All"]
                ], // Add 'All' option
                pageLength: 5, // Set default page length
                dom: "<'row'<'col-sm-4'l><'col-sm-4 d-flex justify-content-center 'B><'col-sm-4 text-end'f>>" +
                    "<'row'<'col-sm-12'tr>>" + // Table rows
                    "<'row mt-3'<'col-sm-6 'i><'col-sm-6 text-end'p>>", // Information and pagination
                buttons: [{
                        extend: 'colvis',
                        columns: ':not(:first-child)'
                    },
                    // Add more buttons as needed, e.g., 'excel', 'print', 'copy'
                ],
                language: {
                    search: '<div class="input-group">' +
                        '<span class="input-group-text">' +
                        '<i class="fas fa-search"></i>' +
                        '</span>' +
                        '_INPUT_' +
                        '</div>'
                },
                columnDefs: [{
                        targets: '_all',
                        searchable: true
                    },
                    {
                        targets: -1,
                        className: ''
                    }, // Center align the actions column
                    {
                        targets: '_all',
                        searchable: true,
                        orderable: true
                    }
                ],
                responsive: true // Enable responsive behavior
            });


        });
        $(document).on('click', '.view', function(e) {
            e.preventDefault(); // Prevent default link behavior

            var id = $(this).attr('data-id'); // Get the URL from the href attribute
            var url = "{{ route('member.feedback.get') }}";
            // Show SweetAlert confirmation dialog
            sendAjaxReq(id, url);
        });

        function sendAjaxReq(id, url) {
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

                    $('#feedback-message').text(response.message);
                    $('#feedback-user').text(response.user_name); // Assuming user name is in response
                    $('#feedback-date').text(response.created_at); // Display formatted date
                    // Show the modal
                    $('#feedbackInfoModal').modal('show');
                },
                error: function(xhr, status, error) {
                    // Handle AJAX error
                    Swal.fire('Error!', 'An error occurred.', 'error');
                }
            });
        }
        $('#feedbackInfoModal').on('hidden.bs.modal', function() {
            // Reload DataTable after modal is hidden
            $('#feedback-list').DataTable().ajax.reload(null, false);
        });
    </script>
@endpush
