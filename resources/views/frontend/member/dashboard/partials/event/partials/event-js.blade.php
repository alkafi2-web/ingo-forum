@push('custom-js')
    <script>
        CKEDITOR.replace('des');
        $(document).ready(function() {
            $('#submit').on('click', function(e) {
                e.preventDefault();
                $('#submit-spinner').removeClass('d-none');
                $(this).prop('disabled', true);
                let url = "{{ route('event.create') }}";
                let formData = new FormData($('#eventForm')[0]);
                let des = CKEDITOR.instances['des'].getData();
                formData.append('des', des);
                $.ajax({
                    type: 'POST',
                    url: url,
                    data: formData,
                    processData: false, // Prevent jQuery from processing the data
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        $('#submit-spinner').addClass('d-none');
                        $('#submit').prop('disabled', false);
                        var success = response.success;
                        $.each(success, function(key, value) {
                            toastr.success(value); // Displaying each error message
                        });
                        $('#eventForm')[0].reset();
                        var des = CKEDITOR.instances['des'];
                        des.setData('');
                        des.focus();
                        $('#pp').attr('src', '');
                        $('#deadline-container').hide();
                        $('#event-data').DataTable().ajax.reload(null, false);
                    },
                    error: function(xhr) {
                        $('#submit-spinner').addClass('d-none');
                        $('#submit').prop('disabled', false);
                        var errors = xhr.responseJSON.errors;
                        // Iterate through each error and display it
                        $.each(errors, function(key, value) {
                            toastr.error(value); // Displaying each error message
                        });
                    }
                });

            });
            $('#update').on('click', function(e) {
                e.preventDefault();
                $('#update-spinner').removeClass('d-none');
                $(this).prop('disabled', true);
                let url = "{{ route('event.update') }}";
                let id = $('#event_id').val();
                let formData = new FormData($('#eventForm')[0]);
                formData.append('id', id);
                let des = CKEDITOR.instances['des'].getData();
                formData.append('des', des);
                $.ajax({
                    type: 'POST',
                    url: url,
                    data: formData,
                    processData: false, // Prevent jQuery from processing the data
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        $('#update-spinner').addClass('d-none');
                        $('#update').prop('disabled', false);
                        var success = response.success;
                        $.each(success, function(key, value) {
                            // toastr.success(value); // Displaying each error message
                            Swal.fire('Success!', value,
                                'success');
                        });
                        $('#eventForm')[0].reset();
                        var des = CKEDITOR.instances['des'];
                        des.setData('');
                        des.focus();
                        $('#pp').attr('src', '');
                        $('#event-data').DataTable().ajax.reload(null, false);
                        $('#submit').removeClass('d-none');
                        $('#update ').addClass('d-none');
                        $('#refresh').addClass('d-none');
                        $('#add-event-tab').removeClass('active');
                        $('.add-event-btn-text').text('Add Event');
                        $('.addEventIcon').show();
                        $('.updateEventIcon').hide();

                        $('#add-event').removeClass('show active');
                        $('#all-event-tab').addClass('active');
                        $('#all-event').addClass('show active');
                    },
                    error: function(xhr) {
                        $('#update-spinner').addClass('d-none');
                        $('#update').prop('disabled', false);
                        var errors = xhr.responseJSON.errors;
                        // Iterate through each error and display it
                        $.each(errors, function(key, value) {
                            toastr.error(value); // Displaying each error message
                        });
                    }
                });

            });
            $('#refresh').on('click', function(e) {
                e.preventDefault(); // Prevent default link behavior
                $('#submit').removeClass('d-none');

                // Show the update and refresh buttons
                $('#update, #refresh').addClass('d-none');
                $('#eventForm')[0].reset();
                var des = CKEDITOR.instances['des'];
                des.setData('');
                des.focus();
                $('#pp').attr('src', '');
                $('#add-event-tab').removeClass('active');
                $('.add-event-btn-text').text('Add Event');
                $('.addEventIcon').show();
                $('.updateEventIcon').hide();
                $('#add-event').removeClass('show active');
                $('#all-event-tab').addClass('active');
                $('#all-event').addClass('show active');
            });
            $('#toggle-deadline').on('change', function() {
                if ($(this).is(':checked')) {
                    $('#deadline-container').show(); // Show the deadline input
                } else {
                    $('#deadline-container').hide(); // Hide the deadline input
                }
            });
            // Check if the checkbox is already checked on page load
            if ($('#toggle-deadline').is(':checked')) {
                $('#deadline-container').show(); // Show the deadline input
            }


        });
        $(document).ready(function() {
            var table = $('#event-data').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('member.event.list') }}",
                    type: 'GET',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                },
                columns: [{
                        orderable: true,
                        sortable: false,
                        data: 'title',
                        name: 'title'
                    },
                    {
                        orderable: true,
                        sortable: false,
                        name: 'event_details',
                        render: function(data, type, row) {
                            // Format dates
                            const startDate = new Date(row.start_date).toLocaleDateString();
                            const endDate = new Date(row.end_date).toLocaleDateString();
                            const deadlineDate = row.reg_dead_line ? new Date(row.reg_dead_line)
                                .toLocaleDateString() : null;

                            // Format registration fee if applicable
                            const regFee = row.reg_fee ? `$${parseFloat(row.reg_fees).toFixed(2)}` :
                                'Free';

                            // Return formatted string with user-friendly text
                            return `
                                    <div>
                                        <div><strong>Start Date:</strong> ${startDate}</div>
                                        <div><strong>End Date:</strong> ${endDate}</div>
                                        ${deadlineDate ? `<div><strong>Registration Deadline:</strong> ${deadlineDate}</div>` : ''}
                                    </div>
                                `;
                        }
                    },
                    {
                        data: 'media',
                        name: 'media',
                        orderable: true,
                        sortable: false,
                        render: function(data, type, row) {
                            let basePath = '{{ asset('public/frontend/images/events/') }}/'
                            return `<img src="${basePath + data}" alt="Image" style="width: 100px; height: 100px; object-fit:contain;">`;
                        }
                    },
                    {
                        data: 'status',
                        name: 'status',
                        orderable: true,
                        sortable: false,
                        render: function(data, type, row) {
                            // Map status values to badge classes and texts
                            const badgeMap = {
                                1: {
                                    class: 'bg-success',
                                    text: 'Active'
                                },
                                0: {
                                    class: 'bg-danger',
                                    text: 'Deactive'
                                },
                                // Add additional mappings as needed
                            };

                            // Default to 'bg-light' if status is not in the badgeMap
                            const badge = badgeMap[data] || {
                                class: 'bg-light',
                                text: 'Unknown'
                            };

                            return `<span class="badge ${badge.class} status" data-status="${data}" data-id="${row.id}">${badge.text}</span>`;
                        }
                    },
                    {
                        data: 'approval_status',
                        name: 'approval_status',
                        orderable: true,
                        sortable: false,
                        render: function(data, type, row) {
                            // Function to generate badge class and text
                            const getBadge = (status) => {
                                const statusMap = {
                                    0: {
                                        class: 'bg-warning',
                                        text: 'Pending'
                                    },
                                    1: {
                                        class: 'bg-success',
                                        text: 'Approved'
                                    },
                                    2: {
                                        class: 'bg-danger',
                                        text: 'Suspended'
                                    },
                                    3: {
                                        class: 'bg-secondary',
                                        text: 'Rejected'
                                    }
                                };

                                // Return the status badge or default to 'Unknown'
                                return statusMap[status] || {
                                    class: 'bg-info',
                                    text: 'Unknown'
                                };
                            };

                            const badge = getBadge(data);

                            return `<span class="badge ${badge.class}" data-status="${data}" data-id="${row.id}">${badge.text}</span>`;
                        }
                    },
                    {
                        data: null,
                        name: 'actions',
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row) {
                            var singleEventRoute =
                                '{{ route('frontend.event.show', ':slug') }}'
                                .replace(':slug', row.slug);

                            return `
                            <a href="${singleEventRoute}" class="view text-info mr-2 me-2" data-id="${row.id}">
                                <i class="fas fa-eye text-info" style="font-size: 16px;"></i>
                            </a>
                            <a href="javascript:void(0)" class="edit text-primary mr-2 me-2 " data-id="${row.id}">
                                <i class="fas fa-edit text-primary" style="font-size: 16px;"></i> <!-- Adjust font-size here -->
                            </a>
                            <a href="javascript:void(0)" class="text-danger delete" data-id="${row.id}">
                                <i class="fas fa-trash text-danger" style="font-size: 16px;"></i> <!-- Adjust font-size here -->
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
                        columns: ':not(:first-child)' // Exclude first column (serial)
                    },
                    // 'excel', 'print', 'copy'
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
                // responsive: true

            });
        });

        $(document).on('click', '.edit', function(e) {
            e.preventDefault(); // Prevent default link behavior
            // Handle edit button click
            var id = $(this).attr('data-id');
            $.ajax({
                url: "{{ route('event.edit') }}",
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    id: id
                },
                success: function(response) {
                    $('#submit').addClass('d-none');

                    // Show the update and refresh buttons
                    $('#update, #refresh').removeClass('d-none');
                    var event = response.event;
                    $('#add-header').text('Update Event');
                    $('#title').val(event.title);
                    $('#des').val(event.details);
                    var des = CKEDITOR.instances['des'];
                    des.setData(event.des);
                    des.focus();
                    $('#location').val(event.location);
                    $('#capacity').val(event.capacity);
                    $('#event_id').val(event.id);

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
                    $('#add-event-tab').addClass('active');
                    $('.add-event-btn-text').text('Update Event');
                    $('.addEventIcon').hide();
                    $('.updateEventIcon').show();

                    $('#add-event').addClass('show active');
                    $('#all-event-tab').removeClass('active');
                    $('#all-event').removeClass('show active');
                },
                error: function(xhr) {
                    console.error('Error fetching data:', xhr);
                    Swal.fire({
                        title: 'Error',
                        text: 'Failed to fetch data. Please try again.',
                        icon: 'error'
                    });
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
