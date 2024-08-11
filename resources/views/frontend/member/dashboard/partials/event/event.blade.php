<div>
    <ul class="sub-profile-tabs nav nav-tabs mb-3" id="pills-tab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active fw-bold" id="all-event-tab" data-bs-toggle="tab" data-bs-target="#all-event"
                type="button" role="tab" aria-controls="all-event" aria-selected="false" tabindex="-1"><i class="fas fa-calendar-alt"></i>&nbsp;All
                Event</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link fw-bold" id="add-event-tab" data-bs-toggle="tab" data-bs-target="#add-event"
                type="button" role="tab" aria-controls="add-event" aria-selected="true"><i class="fas fa-calendar-plus addEventIcon"></i><i class="fas fa-wrench updateEventIcon" style="display: none"></i>&nbsp;<span class="add-event-btn-text">Add Event</span></button>
        </li>

    </ul>
    <div class="tab-content mt-4" id="pills-tabContent">
        <div class="tab-pane fade show active" id="all-event" role="tabpanel" aria-labelledby="all-event-tab" tabindex="0">
            <div class="table-responsive table-container ">
                <!--begin::Table-->
                <table class="table election-datatable w-100 align-middle table-bordered fs-14px gy-5 m-auto display" id="event-data">
                    <!--begin::Table head-->
                    <thead>
                        <th class="fw-bold text-dark" style="font-weight: 900">
                            {{ __('Title') }}
                        </th>
                        {{-- <th class="min-w-50px fw-bold text-dark firstTheadColumn" style="font-weight: 900">
                            {{ __('Details') }}
                        </th> --}}
                        <th class="min-w-150px fw-bold text-dark" style="font-weight: 900">
                            {{ __('Event Date') }}
                        </th>
                        <th class="min-w-50px fw-bold text-dark" style="font-weight: 900">
                            {{ __('Event Image') }}
                        </th>
                        <th class="min-w-50px fw-bold text-dark" style="font-weight: 900">
                            {{ __('Status') }}
                        </th>
                        <th class="min-w-50px fw-bold text-dark" style="font-weight: 900">
                            {{ __('Approval Status') }}
                        </th>
                        <th class="text-end min-w-100px fw-bold text-dark lastTheadColumn" style="font-weight: 900">
                            {{ __('Action') }}</th>
                        </tr>
                    </thead>
                    <!--end::Table head-->
                    <tbody>

                    </tbody>
                </table>
                <!--end::Table-->
            </div>
        </div>
        <div class="tab-pane fade " id="add-event" role="tabpanel" aria-labelledby="add-event-tab" tabindex="0">
            <form id="eventForm" action="" method="POST" enctype="multipart/form-data">
                <div class="row mb-3">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="title" class="text-3xl required">Event Title</label>
                            <input type="hidden" name="creator_type" value="\App\Models\Member">
                            <input type="text" class="form-control" id="title" name="title" value="">
                        </div>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="des" class="text-3xl required">Event Description</label>
                            <textarea name="des" id="des" cols="30" rows="10"></textarea>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="capacity" class="text-3xl">Event Capacity</label>
                                <input type="number" class="form-control" id="capacity" name="capacity">
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="location" class="text-3xl required">Event Location</label>
                                <input type="text" class="form-control" id="location" name="location">
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="start_date" class="text-3xl required">Event Start Date</label>
                                <input type="datetime-local" class="form-control" id="start_date" name="start_date"
                                    value="">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="end_date" class="text-3xl required">Event End Date</label>
                                <input type="datetime-local" class="form-control" id="end_date" name="end_date"
                                    value="">
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>
                                    <input type="checkbox" name="check_deadline" id="toggle-deadline">
                                    Enable Registration Deadline
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3" id="deadline-container" style="display:none;">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="deadline_date" class="text-3xl required">Registration Deadline</label>
                                <input type="datetime-local" class="form-control" id="deadline_date"
                                    name="deadline_date" value="">
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="image" class="text-3xl required">Event Image</label>
                                <input type="file" class="form-control" id="image" name="image"
                                    value="" oninput="pp.src=window.URL.createObjectURL(this.files[0])">
                                <img id="pp" width="100" class="float-start mt-3" src="">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group mt-3">
                                <input type="hidden" name="id" id="event_id">
                                <input type="hidden" name="type" id="add_type" value="member">
                                <button type="" id="submit" class="submit-btn mt-4"> <i
                                        class="fas fa-save"></i> Submit</button>
                                <button type="" id="update" class="submit-btn mt-4 d-none"> <i
                                        class="fas fa-update"></i> Update</button>
                                <button type="" id="refresh" class="submit-btn mt-4 d-none"> <i
                                        class="fas fa-refresh"></i> Refresh</button>
                            </div>
                        </div>
                    </div>
            </form>
        </div>

    </div>
</div>
@push('custom-js')
    <script>
        CKEDITOR.replace('des');
        $(document).ready(function() {
            $('#submit').on('click', function(e) {
                e.preventDefault();
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
                        console.log(response);
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
                        var errors = xhr.responseJSON.errors;
                        // Iterate through each error and display it
                        $.each(errors, function(key, value) {
                            console.log(key, value);
                            toastr.error(value); // Displaying each error message
                        });
                    }
                });

            });
            $('#update').on('click', function(e) {
                e.preventDefault();
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
                        console.log(response);
                        var success = response.success;
                        $.each(success, function(key, value) {
                            // toastr.success(value); // Displaying each error message
                            Swal.fire('Success!', value,
                        'success');
                        });

                        $('#add-header').text('Add Event');
                        $('#eventForm')[0].reset();
                        var des = CKEDITOR.instances['des'];
                        des.setData('');
                        des.focus();
                        $('#pp').attr('src', '');
                        $('#event-data').DataTable().ajax.reload(null, false);
                        $('#submit').removeClass('d-none');
                        $('#update ').addClass('d-none');
                        $('#refresh').addClass('d-none');
                        $('#add-event-tab').addClass('active');
                        $('.add-event-btn-text').text('Update Event');
                        $('.addEventIcon').hide();
                        $('.updateEventIcon').show();

                        $('#add-event').removeClass('show active');
                        $('#all-event-tab').addClass('active');
                        $('#all-event').addClass('show active');
                    },
                    error: function(xhr) {
                        var errors = xhr.responseJSON.errors;
                        // Iterate through each error and display it
                        $.each(errors, function(key, value) {
                            console.log(key, value);
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
