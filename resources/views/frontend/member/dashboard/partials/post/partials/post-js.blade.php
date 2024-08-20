@push('custom-js')
    <script>
        // CKEDITOR.replace('short_description');
        CKEDITOR.replace('long_description');
        $(document).ready(function() {
            var categories = @json($categories);

            $('#category').on('change', function() {
                var categoryId = $(this).val();
                var subcategories = categories.find(category => category.id == categoryId).subcategories;

                $('#subcategory').empty().append('<option value="">-- Select Subcategory --</option>');

                subcategories.forEach(function(subcategory) {
                    $('#subcategory').append(
                        `<option value="${subcategory.id}">${subcategory.name}</option>`);
                });
            });
        });

        $(document).ready(function() {

            $('#submit').on('click', function(e) {
                e.preventDefault();
                $('#submit-spinner').removeClass('d-none');
                $(this).prop('disabled', true);
                let url = "{{ route('post.store') }}";
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
                formData.append('banner', banner);
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
                        $('#submit-spinner').addClass('d-none');
                        $(('#submit')).prop('disabled', false);
                        var success = response.success;
                        $.each(success, function(key, value) {
                            toastr.success(value); // Displaying each error message
                        });
                        $('#postForm')[0].reset();
                        $('#member-post-list').DataTable().ajax.reload(null, false);
                        var long_description = CKEDITOR.instances['long_description'];
                        long_description.setData('');
                        long_description.focus();
                        $('#pp').attr('src', '');
                    },
                    error: function(xhr) {
                        $('#submit-spinner').addClass('d-none');
                        $(('#submit')).prop('disabled', false);
                        var errors = xhr.responseJSON.errors;
                        // Iterate through each error and display it
                        $.each(errors, function(key, value) {
                            toastr.error(value); // Displaying each error message
                        });
                    }
                });

            });
        });

        $(document).ready(function() {
            $('#title').on('input', function() {
                var title = $(this).val();
                var slug = title.toLowerCase()
                    .replace(/\s+/g, '-') // Replace spaces with hyphens
                    .replace(/[^a-zA-Z0-9-ঀ-৿]/g, '') // Allow alphanumeric, hyphens, and Bangla characters
                    .replace(/-+/g, '-'); // Replace multiple hyphens with a single hyphen

                $('#slug').val(slug);
            });
        });
        $(document).ready(function() {

            $('#update').on('click', function(e) {
                e.preventDefault();
                $('#update-spinner').removeClass('d-none');
                $(this).prop('disabled', true);
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
                        $('#update-spinner').addClass('d-none');
                        $(('#update')).prop('disabled', false);
                        var success = response.success;
                        $.each(success, function(key, value) {
                            Swal.fire('Success!', value,
                                'success'); // Displaying each error message
                        });
                        $('#member-post-list').DataTable().ajax.reload(null, false);
                    
                        $('#add-blog-news-tab').removeClass('active');
                        $('.addBlogIcon').show();
                        $('.updateBlogIcon').hide();
                        $('.add-blog-btn-text').text('Add Blog/News');
                        $('#add-blog-news').removeClass('show active');
                        $('#all-blog-news-tab').addClass('active');
                        $('#all-blog-news').addClass('show active');
                        $('#file-preview').html('');
                    },
                    error: function(xhr) {
                        $('#update-spinner').addClass('d-none');
                        $(('#update')).prop('disabled', false);
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

        $(document).ready(function() {
            var table = $('#member-post-list').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('member.post.index') }}",
                    type: 'GET',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                },
                columns: [{
                        data: 'title',
                        name: 'title',
                        orderable: true,
                        sortable: false
                    },
                    {
                        data: 'category_name',
                        name: 'category_name',
                        orderable: true,
                        sortable: false
                    },
                    {
                        data: 'subcategory_name',
                        name: 'subcategory_name',
                        orderable: true,
                        sortable: false
                    },
                    {
                        data: 'banner',
                        name: 'banner',
                        orderable: true,
                        sortable: false,
                        render: function(data, type, row) {
                            let basePath = '{{ asset('public/frontend/images/posts/') }}/'
                            return `<img src="${basePath + data}" alt="Image" style="width: 100px; height: 100px; object-fit:contain;">`;
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
                                    class: 'bg-light',
                                    text: 'Unknown'
                                };
                            };

                            const badge = getBadge(data);

                            return `<span class="badge ${badge.class}" data-status="${data}" data-id="${row.id}">${badge.text}</span>`;
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
                                    text: 'Published'
                                },
                                0: {
                                    class: 'bg-danger',
                                    text: 'Unpublished'
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
                        data: null,
                        name: 'actions',
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row) {
                            var editRoute = '{{ route('member.post.edit', ':id') }}'.replace(':id',
                                row.id);
                            var singlePostRoute =
                                '{{ route('single.post', ['categorySlug' => ':categorySlug', 'postSlug' => ':postSlug']) }}'
                                .replace(':categorySlug', row.category_slug)
                                .replace(':postSlug', row.slug);

                            // Determine the comment icon based on comment_permission
                            var commentIcon = row.comment_permission == 1 ?
                                'fa-comments text-success' :
                                'fa-comment-slash text-muted';
                            var commentTitle = row.comment_permission == 1 ? 'Comments Enabled' :
                                'Comments Disabled';

                            // Conditional edit button based on approval_status
                            var editButton = row.approval_status != 1 ? `
                            <a href="${editRoute}" class="edit text-primary mr-2 me-2" data-id="${row.id}" style="margin-right: 10px;">
                                <i class="fas fa-edit text-primary" style="font-size: 16px;"></i>
                            </a>` : '';

                            return `<div style="display: flex; align-items: center;">
                            <a href="javascript:void(0)" class="text-danger comment" data-id="${row.id}" style="margin-right: 10px;">
                                <i class="fas ${commentIcon}" title="${commentTitle}" style="font-size: 16px;"></i>
                            </a>
                            <a href="${singlePostRoute}" class="view text-info mr-2 me-2" data-id="${row.id}">
                                <i class="fas fa-eye text-info" style="font-size: 16px;"></i>
                            </a>
                            ${editButton}
                            <a href="javascript:void(0)" class="text-danger delete" data-id="${row.id}" style="margin-right: 10px;">
                                <i class="fas fa-trash text-danger" style="font-size: 16px;"></i>
                            </a>
                        </div>`;
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
                    $('#add-blog-news-tab').addClass('active');
                    $('.add-blog-btn-text').text('Update Blog/News');
                    $('.addBlogIcon').hide();
                    $('.updateBlogIcon').show();
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
            $('#file-preview').html('');
            $('#add-blog-news-tab').removeClass('active');
            $('.add-blog-btn-text').text('Add Blog/News');
            $('.addBlogIcon').show();
            $('.updateBlogIcon').hide();
            $('#add-blog-news').removeClass('show active');
            $('#all-blog-news-tab').addClass('active');
            $('#all-blog-news').addClass('show active');
        });

        $(document).on('click', '.delete', function(e) {
            e.preventDefault(); // Prevent default link behavior

            var id = $(this).attr('data-id');
            var url = "{{ route('post.delete') }}";
            // Show SweetAlert confirmation dialog
            Swal.fire({
                title: 'Are you sure?',
                text: 'This action will delete this Post!',
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
        $(document).on('click', '.comment', function(e) {
            e.preventDefault(); // Prevent default link behavior

            var id = $(this).attr('data-id');
            var url = "{{ route('post.comment') }}";
            // Show SweetAlert confirmation dialog
            Swal.fire({
                title: 'Are you sure?',
                text: 'This action will be change comment permission this Post!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, change it!',
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
            var url = "{{ route('post.status') }}";
            // Show SweetAlert confirmation dialog
            Swal.fire({
                title: 'Are you sure?',
                text: 'This action will change status of this Post!',
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

                    $('#member-post-list').DataTable().ajax.reload(null, false);
                    Swal.fire('Success!', response.success,
                        'success');
                    // toastr.success(response.success);
                },
                error: function(xhr, status, error) {
                    // Handle AJAX error
                    Swal.fire('Error!', 'An error occurred.', 'error');
                }
            });
        }
    </script>
@endpush
