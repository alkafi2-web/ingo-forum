<div>
    <ul class="sub-profile-tabs nav nav-pills mb-3" id="pills-tab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="all-event-tab" data-bs-toggle="pill" data-bs-target="#all-event"
                type="button" role="tab" aria-controls="all-event" aria-selected="false" tabindex="-1">All
                Event</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link " id="add-event-tab" data-bs-toggle="pill" data-bs-target="#add-event"
                type="button" role="tab" aria-controls="add-event" aria-selected="true">Add Event</button>
        </li>

    </ul>
    <div class="tab-content" id="pills-tabContent">
        <div class="tab-pane fade show active" id="all-event" role="tabpanel" aria-labelledby="all-event-tab"
            tabindex="0">
            <table class="table table-hover table-sm align-middle fs-6 gy-5 m-auto table-responsive" id="event-data"
                style="width: 100%;">
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
                <tbody>

                </tbody>
            </table>
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
                                <input type="hidden" name="id" id="post_id">
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
                let id = $(this).attr('data-id');
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
                            toastr.success(value); // Displaying each error message
                        });
                        $('#add-header').text('Add Event');
                        $('#eventForm')[0].reset();
                        var des = CKEDITOR.instances['des'];
                        des.setData('');
                        des.focus();
                        $('#pp').attr('src', '');
                        $('#event-data').DataTable().ajax.reload(null, false);
                        $('#event-submit').removeClass('d-none');
                        $('#event-update ').addClass('d-none');
                        $('#page-refresh').addClass('d-none');
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
                e.preventDefault();
                $('#add-header').text('Add Event');
                $('#eventForm')[0].reset();
                var des = CKEDITOR.instances['des'];
                des.setData('');
                des.focus();
                $('#pp').attr('src', '');
                $('#event-submit').removeClass('d-none');
                $('#event-update ').addClass('d-none');
                $('#page-refresh').addClass('d-none');
            });
        });
        $(document).ready(function() {
            // When the checkbox is clicked
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
                    url: "{{ route('event') }}",
                    type: 'GET',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                },
                columns: [{
                        orderable: true,
                        sortable: false,
                        data: 'slug',
                        name: 'slug'
                    },
                    // {
                    //     orderable: true,
                    //     sortable: false,
                    //     data: 'details',
                    //     name: 'details'
                    // },
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
                // responsive: true,

            });
        });

        $(document).on('click', '.edit', function(e) {
            e.preventDefault(); // Prevent default link behavior
            // Handle edit button click
            var id = $(this).data('id');
            $.ajax({
                url: "{{ route('member.post.edit', ':id') }}".replace(':id', id),
                type: 'GET',
                success: function(response) {
                    console.log(response)
                    // Assuming response contains the data to populate the form
                    // Activate the "add-blog-news" tab and change the text to "Update Blog/News"
                    $('#submit').addClass('d-none');

                    // Show the update and refresh buttons
                    $('#update, #refresh').removeClass('d-none');
                    $('#add-blog-news-tab').addClass('active').text('Update Blog/News');
                    $('#add-blog-news').addClass('show active');
                    $('#all-blog-news-tab').removeClass('active');
                    $('#all-blog-news').removeClass('show active');
                    $('#category').val(response.category_id).trigger('change');


                    setTimeout(() => {
                        $('#subcategory').val(response.sub_category_id);
                    }, 100);

                    // Other form fields can be populated here as needed
                    $('#title').val(response.title);
                    $('#slug').val(response.slug);
                    $('#post_id').val(response.id);
                    CKEDITOR.instances['long_description'].setData(response.long_des);
                    let basePath = '{{ asset('public/frontend/images/posts/') }}/'
                    $('#pp').attr('src', `${basePath + response.banner}`);
                    // Use the save icon
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

        $(document).ready(function() {

            $('#update').on('click', function(e) {
                e.preventDefault();
                let url = "{{ route('post.update') }}";
                let id = $('#post_id').val();
                let category = $('#category').val();
                let subcategory = $('#subcategory').val();
                let title = $('#title').val();
                let slug = $('#slug').val();
                let add_type = $('#add_type').val();
                let long_description = CKEDITOR.instances['long_description'].getData();
                // let short_description = CKEDITOR.instances['short_description'].getData();
                let banner = $('#banner')[0].files[0];
                let formData = new FormData(); // Create FormData object

                // Append form data to FormData object
                formData.append('category', category);
                formData.append('subcategory', subcategory);
                formData.append('title', title);
                formData.append('slug', slug);
                formData.append('long_description', long_description);
                // formData.append('short_description', short_description);
                if (banner) {
                    formData.append('banner', banner);
                }
                formData.append('id', id);
                formData.append('add_type', add_type);
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
                        var success = response.success;
                        $.each(success, function(key, value) {
                            Swal.fire('Success!', value,
                                'success'); // Displaying each error message
                        });
                        $('#member-post-list').DataTable().ajax.reload(null, false);

                        $('#add-blog-news-tab').removeClass('active').text('Add Blog/News');
                        $('#add-blog-news').removeClass('show active');
                        $('#all-blog-news-tab').addClass('active');
                        $('#all-blog-news').addClass('show active');
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

        $(document).on('click', '#refresh', function(e) {
            e.preventDefault(); // Prevent default link behavior
            $('#submit').removeClass('d-none');

            // Show the update and refresh buttons
            $('#update, #refresh').addClass('d-none');
            $('#postForm')[0].reset();
            var long_description = CKEDITOR.instances['long_description'];
            long_description.setData('');
            long_description.focus();
            $('#pp').attr('src', '');
            $('#add-blog-news-tab').removeClass('active').text('Add Blog/News');
            $('#add-blog-news').removeClass('show active');
            $('#all-blog-news-tab').addClass('active');
            $('#all-blog-news').addClass('show active');
        });
    </script>
@endpush
