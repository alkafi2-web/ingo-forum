<div class="table-responsive table-container">
    <!--begin::Table-->
    <table class="table election-datatable align-middle table-bordered fs-6 gy-5 m-auto display responsive"
        id="event-data">
        <!--begin::Table head-->
        <thead>
            <tr class="text-start text-muted fw-bolder fs-7 text-uppercase gs-0" style="background: #fff;">
                <th class="fw-bold text-dark" style="font-weight: 900">
                    {{ __('Event Name') }}
                </th>
                <th class="min-w-50px fw-bold text-dark firstTheadColumn" style="font-weight: 900">
                    {{ __('Attendee Type') }}
                </th>
                <th class="min-w-150px fw-bold text-dark" style="font-weight: 900">
                    {{ __('Attendee Name') }}
                </th>
                <th class="min-w-50px fw-bold text-dark" style="font-weight: 900">
                    {{ __('Attendee Email') }}
                </th>
                <th class="min-w-50px fw-bold text-dark" style="font-weight: 900">
                    {{ __('Attendee Phone') }}
                </th>
                <th class="min-w-50px fw-bold text-dark" style="font-weight: 900">
                    {{ __('Total Participant') }}
                </th>
                <th class="text-end min-w-100px fw-bold text-dark lastTheadColumn" style="font-weight: 900">
                    {{ __('Attendee Guest') }}</th>
            </tr>
        </thead>
        <tbody>

        </tbody>
        <!--end::Table head-->
    </table>
    <!--end::Table-->
</div>


@push('custom-js')
    <script>
        $(document).ready(function() {
            var table = $('#event-data').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('event.attendee.list') }}",
                    type: 'GET',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                },
                columns: [{
                        orderable: true,
                        sortable: false,
                        data: 'event_name',
                        name: 'event_name'
                    },
                    {
                        orderable: true,
                        sortable: false,
                        data: 'attendee_type',
                        name: 'attendee_type'
                    },
                    {
                        orderable: true,
                        sortable: false,
                        data: 'attendee_name',
                        name: 'attendee_name'
                    },
                    {
                        orderable: true,
                        sortable: false,
                        data: 'attendee_email',
                        name: 'attendee_email'
                    },
                    {
                        orderable: true,
                        sortable: false,
                        data: 'attendee_phone',
                        name: 'attendee_phone'
                    },
                    {
                        orderable: true,
                        sortable: false,
                        data: 'total_participant',
                        name: 'total_participant'
                    },
                    {
                        orderable: true,
                        sortable: false,
                        data: 'guest_info',
                        name: 'guest_info'
                    }
                
                ],
                lengthMenu: [
                    [5, 10, 30, 50, -1],
                    [5, 10, 30, 50, "All"]
                ], // Add 'All' option
                pageLength: 5, // Set default page length
                dom: "<'row'<'col-sm-4'l><'col-sm-4 d-flex justify-content-center'B><'col-sm-4'f>>" +
                    // Page length, buttons, and search
                    "<'row'<'col-sm-12'tr>>" + // Table rows
                    "<'row'<'col-sm-5'i><'col-sm-7'p>>", // Information and pagination
                buttons: [{
                        extend: 'colvis',
                        columns: ':not(:first-child)' // Exclude first column (serial)
                    },
                    'excel', 'print'
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
                        targets: -1, // Target the last column (actions column)
                        className: '', // Optional: Center align the content in this column
                    },
                    {
                        targets: '_all',
                        searchable: true,
                        orderable: true
                    }
                ],
                // responsive: true,

            });
        });
        $(document).on('click', '.edit', function(e) {
            e.preventDefault(); // Prevent default link behavior

            var id = $(this).attr('data-id');
            var url = "{{ route('event.edit') }}";
            $.ajax({
                url: url,
                type: 'POST', // or 'GET' depending on your server endpoint
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    id: id
                }, // You can send additional data if needed
                success: function(response) {
                    console.log(response.event);
                    var event = response.event;
                    $('#add-header').text('Update Event');
                    $('#title').val(event.title);
                    $('#des').val(event.details);
                    var des = CKEDITOR.instances['des'];
                    des.setData(event.des);
                    des.focus();
                    $('#location').val(event.location);
                    $('#capacity').val(event.capacity);

                    function formatDateForInput(dateString) {
                        if (!dateString) {
                            return ''; // Return empty string if dateString is null or undefined
                        }

                        const date = new Date(dateString);

                        if (isNaN(date.getTime())) {
                            return ''; // Return empty string if dateString is invalid
                        }

                        const year = date.getFullYear();
                        const month = String(date.getMonth() + 1).padStart(2, '0');
                        const day = String(date.getDate()).padStart(2, '0');
                        const hours = String(date.getHours()).padStart(2, '0');
                        const minutes = String(date.getMinutes()).padStart(2, '0');

                        return `${year}-${month}-${day}T${hours}:${minutes}`;
                    }


                    // Set the values for form fields
                    $('#start_date').val(formatDateForInput(event.start_date) || '');
                    $('#end_date').val(formatDateForInput(event.end_date) || '');
                    $('#deadline_date').val(formatDateForInput(event.reg_dead_line) || '');

                    // Set the checkbox state and display the deadline container if needed
                    $('#toggle-deadline').prop('checked', event.reg_enable_status == 1);
                    $('#deadline-container').css('display', event.reg_enable_status == 1 ? 'block' :
                        'none');

                    // Toggle the visibility of the deadline container based on checkbox change
                    $('#toggle-deadline').change(function() {
                        $('#deadline-container').css('display', $(this).is(':checked') ?
                            'block' : 'none');
                    });
                    let basePath = '{{ asset('public/frontend/images/events/') }}/'
                    var imagePath = basePath + event.media;
                    $('#pp').attr('src', imagePath);
                    $('#event-update').removeClass('d-none');
                    $('#event-update').attr('data-id', event.id);
                    $('#event-submit').addClass('d-none');
                    $('#page-refresh').removeClass('d-none');
                },
                error: function(xhr, status, error) {
                    // Handle AJAX error
                    Swal.fire('Error!', 'An error occurred.', 'error');
                }
            });
        });
        $(document).on('click', '.delete', function(e) {
            e.preventDefault(); // Prevent default link behavior

            var id = $(this).attr('data-id');
            var url = "{{ route('event.delete') }}";
            // Show SweetAlert confirmation dialog
            Swal.fire({
                title: 'Are you sure?',
                text: 'This action will delete this event!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
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
        $(document).on('click', '.status', function(e) {
            e.preventDefault(); // Prevent default link behavior

            var id = $(this).attr('data-id'); // Get the URL from the href attribute
            var status = $(this).attr('data-status');
            var url = "{{ route('event.status') }}";
            // Show SweetAlert confirmation dialog
            Swal.fire({
                title: 'Are you sure?',
                text: 'This action will change status of this event!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, Change it!',
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

        function sendAjaxReq(id, status, url) {
            var requestData = {
                id: id,
                // Optionally include status if it's provided
            };

            // Check if status is defined and not null
            if (typeof status !== 'undefined' && status !== null) {
                requestData.status = status;
            }
            $.ajax({
                url: url,
                type: 'POST', // or 'GET' depending on your server endpoint
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: requestData, // You can send additional data if needed
                success: function(response) {

                    $('#event-data').DataTable().ajax.reload(null, false);
                    // Swal.fire('Success!', response.success,
                    //     'success');
                    toastr.success(response.success);
                },
                error: function(xhr, status, error) {
                    // Handle AJAX error
                    Swal.fire('Error!', 'An error occurred.', 'error');
                }
            });
        }
    </script>
@endpush
