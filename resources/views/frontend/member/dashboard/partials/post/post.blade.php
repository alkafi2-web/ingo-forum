<div id="blog-news">
    <ul class="sub-profile-tabs nav nav-tabs mb-3" id="pills-tab" role="tablist">

        <li class="nav-item" role="presentation">
            <button class="nav-link fw-bold active" id="all-blog-news-tab" data-bs-toggle="tab" data-bs-target="#all-blog-news"
                type="button" role="tab" aria-controls="all-blog-news" aria-selected="false" tabindex="-1"><i class="far fa-newspaper"></i>&nbsp;All
                Blog/News</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link fw-bold" id="add-blog-news-tab" data-bs-toggle="tab" data-bs-target="#add-blog-news"
                type="button" role="tab" aria-controls="add-blog-news" aria-selected="true"><i class="fas fa-plus-circle addBlogIcon"></i><i class="fas fa-wrench updateBlogIcon" style="display: none"></i>&nbsp;<span class="add-blog-btn-text">Add Blog/News</span></button>
        </li>
    </ul>
    <div class="tab-content mt-4" id="pills-tabContent">
        <div class="tab-pane fade show active" id="all-blog-news" role="tabpanel" aria-labelledby="all-blog-news-tab"
            tabindex="0">
            <div class="table-responsive table-container">
                <!--begin::Table-->
                <table class="table election-datatable w-100 align-middle table-bordered fs-14px gy-5 m-auto display responsive" id="member-post-list">
                    <!--begin::Table head-->
                    <thead>
                        <tr class="text-start text-muted fw-bolder fs-7 text-uppercase gs-0" style="background: #fff;">
                            <th class="" >
                                {{ __('Title') }}
                            </th>
                            <th class="" >
                                {{ __('Category') }}
                            </th>
                            <th class="" >
                                {{ __('Subcategory') }}
                            </th>
                            {{-- <th class="min-w-150px fw-bold text-dark firstTheadColumn" >
                                {{ __('Description') }}
                            </th> --}}
                            <th class="" >
                                {{ __('Banner') }}
                            </th>
                            <th class="" >
                                {{ __('Request Status') }}
                            </th>
                            <th class="" >
                                {{ __('Status') }}
                            </th>
                            <th class="" >
                                {{ __('Action') }}</th>
                        </tr>
                    </thead>
                    <!--end::Table head-->
                </table>
                <!--end::Table-->
            </div>
        </div>
        <div class="tab-pane fade " id="add-blog-news" role="tabpanel" aria-labelledby="add-blog-news-tab"
            tabindex="0">
            <div>
                <form action="/submit-form" id="postForm" method="POST" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-6">
                            <!-- Category -->
                            <div class="form-group">
                                <label for="category" class="required form-label">Category</label>
                                <select id="category" name="category" class="form-control" required="">
                                    <option value="">-- Select Category --</option>
                                    @forelse ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @empty
                                        <option value="">There is No Category</option>
                                    @endforelse
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <!-- Subcategory -->
                            <div class="form-group">
                                <label for="subcategory" class="required form-label">Subcategory</label>
                                <select id="subcategory" name="subcategory" class="form-control" required="">
                                    <option value="">-- Select Category First --</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <!-- Title -->
                            <div class="form-group mt-3">
                                <label for="title" class="required form-label">Title</label>
                                <input type="text" id="title" name="title" class="form-control" required=""
                                    spellcheck="false" data-ms-editor="true">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mt-3">
                                <label for="slug" class="required form-label">Slug</label>
                                <input type="text" id="slug" name="slug" class="form-control" required=""
                                    spellcheck="false" data-ms-editor="true">
                            </div>
                        </div>
                    </div>
                    <!-- Long Description -->
                    <div class="form-group mt-3">
                        <textarea id="long_description" name="long_description" class="form-control mt-5" rows="7"></textarea>
                    </div>
                    <!-- Banner -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group mt-3">
                                <label for="banner" class="required form-label">Banner</label>
                                <input type="file" id="banner" name="banner" class="form-control"
                                    required="" oninput="pp.src=window.URL.createObjectURL(this.files[0])">
                                <p class="text-danger">Banner must be 800px by 450px</p>
                                <img id="pp" width="200" class="float-start mt-3" src="">
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
                    <!-- Submit Button -->
                </form>
            </div>
        </div>
    </div>
</div>
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
                        console.log(response);
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
                    // {
                    //     data: 'long_des',
                    //     name: 'long_des',
                    //     orderable: true,
                    //     sortable: false,
                    //     render: function(data, type, row, meta) {
                    //         console.log("Render Function Data: ", data);

                    //         // Decode HTML entities
                    //         var decodedData = $('<div/>').html(data).text();

                    //         // Strip HTML tags
                    //         var strippedData = $('<div/>').html(decodedData).text();

                    //         // Limit text to 200 characters
                    //         var limitedData = strippedData.length > 150 ? strippedData.substring(0,
                    //             150) + '...' : strippedData;

                    //         return limitedData;
                    //     }
                    // },
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
                            var commentIcon = row.comment_permission ? 'fa-comments text-success' :
                                'fa-comment-slash text-muted';
                            var commentTitle = row.comment_permission ? 'Comments Enabled' :
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
            $('#add-blog-news-tab').removeClass('active');
            $('.add-blog-btn-text').text('Add Blog/News');
            $('.addBlogIcon').show();
            $('.updateBlogIcon').hide();
            $('#add-blog-news').removeClass('show active');
            $('#all-blog-news-tab').addClass('active');
            $('#all-blog-news').addClass('show active');
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
