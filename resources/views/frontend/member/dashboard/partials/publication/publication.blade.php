<div id="publication">
    <ul class="sub-profile-tabs nav nav-pills mb-3" id="pills-tab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="all-publication-tab" data-bs-toggle="pill" data-bs-target="#all-publication"
                type="button" role="tab" aria-controls="all-publication" aria-selected="false" tabindex="-1">All
                Publication</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link " id="add-publication-tab" data-bs-toggle="pill" data-bs-target="#add-publication"
                type="button" role="tab" aria-controls="add-publication" aria-selected="true">Add
                Publication</button>
        </li>
    </ul>
    <div class="tab-content" id="pills-tabContent">

        <div class="tab-pane fade show active" id="all-publication" role="tabpanel"
            aria-labelledby="all-publication-tab" tabindex="0">
            <!--begin::Table-->
            <table class="table election-datatable align-middle table-bordered fs-6 gy-5 m-auto display responsive"
                id="post-list-data">
                <!--begin::Table head-->
                <thead>
                    <tr class="text-start text-muted fw-bolder fs-7 text-uppercase gs-0" style="background: #fff;">
                        <th class="min-w-50px fw-bold text-dark firstTheadColumn" style="font-weight: 900">
                            {{ __('Category') }}
                        </th>
                        <th class="min-w-50px fw-bold text-dark firstTheadColumn" style="font-weight: 900">
                            {{ __('Title') }}
                        </th>
                        <th class="min-w-50px fw-bold text-dark firstTheadColumn" style="font-weight: 900">
                            {{ __('Author') }}
                        </th>
                        <th class="min-w-50px fw-bold text-dark firstTheadColumn" style="font-weight: 900">
                            {{ __('Publisher') }}
                        </th>
                        <th class="min-w-50px fw-bold text-dark firstTheadColumn" style="font-weight: 900">
                            {{ __('Publish Date') }}
                        </th>
                        <th class="min-w-50px fw-bold text-dark firstTheadColumn" style="font-weight: 900">
                            {{ __('File') }}
                        </th>
                        <th class="min-w-50px fw-bold text-dark firstTheadColumn" style="font-weight: 900">
                            {{ __('Image') }}
                        </th>
                        <th class="min-w-50px fw-bold text-dark" style="font-weight: 900">
                            {{ __('Status') }}
                        </th>
                        <th class="text-end min-w-140px fw-bold text-dark lastTheadColumn" style="font-weight: 900">
                            {{ __('Action') }}</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
                <!--end::Table head-->
            </table>
            <!--end::Table-->
        </div>
        <div class="tab-pane fade " id="add-publication" role="tabpanel" aria-labelledby="add-publication-tab"
            tabindex="0">
            <form action="/submit-form" id="publicationForm" method="POST" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-6">
                        <!-- Category -->
                        <div class="form-group ">
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
                        <!-- Title -->
                        <div class="form-group ">
                            <label for="title" class="required form-label">Title</label>
                            <input type="text" id="title" name="title" class="form-control" required=""
                                spellcheck="false" data-ms-editor="true">
                        </div>
                    </div>

                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group mt-3">
                            <label for="author" class="required form-label">Author</label>
                            <input type="text" id="author" name="author" class="form-control" required=""
                                spellcheck="false" data-ms-editor="true">
                        </div>
                    </div>
                    <div class="col-md-4 ">
                        <!-- Subcategory -->
                        <div class="form-group mt-3">
                            <label for="publisher" class="required form-label">Publisher</label>
                            <input type="text" id="publisher" name="publisher" class="form-control"
                                required="" spellcheck="false" data-ms-editor="true">
                        </div>
                    </div>
                    <div class="col-md-4 ">
                        <!-- Subcategory -->
                        <div class="form-group mt-3">
                            <label for="publish_date" class="required form-label">Publish Date</label>
                            <input type="date" id="publish_date" name="publish_date" class="form-control"
                                required="">
                        </div>
                    </div>

                </div>

                <!-- Long Description -->
                <div class="form-group mt-3">
                    <label for="short_description" class="mb-3 required form-label">Short Description</label>
                    <textarea id="short_description" name="short_description" class="form-control " rows="7" required=""
                        spellcheck="false" data-ms-editor="true"></textarea>
                </div>
                <!-- Banner -->
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mt-3">
                            <label for="file" id="file_label" class="required form-label">Publication
                                File</label>
                            <input type="file" id="file" name="file" class="form-control"
                                required="">
                            <!-- Container to display the file preview -->
                            <div id="file-preview" class="mt-3">

                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mt-3">
                            <label for="image" id="image_label" class="required form-label">Image</label>
                            <input type="file" id="image" name="image" class="form-control" required=""
                                oninput="pp.src=window.URL.createObjectURL(this.files[0])">
                            <img id="pp" width="200" class="float-start" src="">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group mt-3">
                            <input type="hidden" name="id" id="publication_id">
                            <input type="hidden" name="add_type" id="add_type" value="member">
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

@push('custom-js')
    <script>
        $(document).ready(function() {
            $('#submit').on('click', function(e) {
                e.preventDefault();
                let url = "{{ route('publication.store') }}";
                let form = $('#publicationForm')[0];
                let formData = new FormData(form);
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
                        $('#post-list-data').DataTable().ajax.reload(null, false);
                        $('#publicationForm')[0].reset();
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
            var table = $('#post-list-data').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('member.publication.index') }}",
                    type: 'GET',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                },
                columns: [{
                        orderable: true,
                        sortable: false,
                        data: 'category_name',
                        name: 'category_name'
                    },
                    {
                        orderable: true,
                        sortable: false,
                        data: 'title',
                        name: 'title'
                    },
                    {
                        orderable: true,
                        sortable: false,
                        data: 'author',
                        name: 'author'
                    },
                    {
                        orderable: true,
                        sortable: false,
                        data: 'publisher',
                        name: 'publisher'
                    },
                    {
                        orderable: true,
                        sortable: false,
                        data: 'publish_date',
                        name: 'publish_date'
                    },
                    {
                        data: 'file',
                        name: 'file',
                        orderable: true,
                        sortable: false,
                        render: function(data, type, row) {
                            let basePath = '{{ asset('public/frontend/images/publication/') }}/';
                            return `<a href="${basePath + data}" target="_blank">Open File</a>`;
                        }
                    },
                    {
                        data: 'image',
                        name: 'image',
                        orderable: true,
                        sortable: false,
                        render: function(data, type, row) {
                            let basePath = '{{ asset('public/frontend/images/publication/') }}/'
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
                            var editRoute = '{{ route('member.publication.edit', ':id') }}'
                                .replace(':id',
                                    row
                                    .id);
                            return `<div style="display: flex; align-items: center;">
                            <a href="${editRoute}" class="edit text-primary mr-2 me-2" data-id="${row.id}" style="margin-right: 10px;">
                                <i class="fas fa-edit text-primary" style="font-size: 16px;"></i>
                            </a>
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
                    "<'row mt-3'<'col-sm-5'i><'col-sm-7 text-end'p>>", // Information and pagination
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
                        className: 'text-center', // Optional: Center align the content in this column
                    },
                    {
                        targets: '_all',
                        searchable: true,
                        orderable: true
                    }
                ],
                responsive: true,

            });
        });
        $(document).on('click', '.edit', function(e) {
            e.preventDefault(); // Prevent default link behavior
            // Handle edit button click
            var id = $(this).data('id');
            $.ajax({
                url: "{{ route('member.publication.edit', ':id') }}".replace(':id', id),
                type: 'GET',
                success: function(response) {
                    console.log(response)
                    // Assuming response contains the data to populate the form
                    // Activate the "add-blog-news" tab and change the text to "Update Blog/News"
                    $('#submit').addClass('d-none');

                    // Show the update and refresh buttons
                    $('#update, #refresh').removeClass('d-none');
                    $('#add-publication-tab').addClass('active').text('Update Publication');
                    $('#add-publication').addClass('show active');
                    $('#all-publication-tab').removeClass('active');
                    $('#all-publication').removeClass('show active');
                    $('#image_label').removeClass('required');
                    $('#file_label').removeClass('required');
                    $('#category').val(response.category_id).trigger('change');
                    // Other form fields can be populated here as needed
                    $('#title').val(response.title);
                    $('#author').val(response.author);
                    $('#publisher').val(response.publisher);
                    $('#publish_date').val(response.publish_date);
                    $('#short_description').val(response.short_description);
                    $('#publication_id').val(response.id);

                    let basePath = '{{ asset('public/frontend/images/publication/') }}/'
                    $('#pp').attr('src', `${basePath + response.image}`);


                    var existingFileUrl = `${basePath}${response.file}`;
                    var $previewContainer = $('#file-preview');
                    if (existingFileUrl) {
                        var existingFileName = response.file;
                        var fileExtension = existingFileName.split('.').pop().toLowerCase();
                        var fileType;
                        switch (fileExtension) {
                            case 'jpg':
                            case 'jpeg':
                            case 'png':
                            case 'gif':
                                fileType = 'image/' + fileExtension;
                                break;
                            case 'pdf':
                                fileType = 'application/pdf';
                                break;
                            case 'docx':
                                fileType =
                                    'application/vnd.openxmlformats-officedocument.wordprocessingml.document';
                                break;
                            case 'pptx':
                                fileType =
                                    'application/vnd.openxmlformats-officedocument.presentationml.presentation';
                                break;
                            default:
                                fileType = 'application/octet-stream';
                        }
                        previewFile(existingFileUrl, fileType, existingFileName);

                        function previewFile(fileUrl, fileType, fileName) {
                            $previewContainer.empty();
                            if (fileType.startsWith('image/')) {
                                var $img = $('<img>').attr('src', fileUrl).css('max-width', '100%');
                                $previewContainer.append($img);
                            } else if (fileType === 'application/pdf') {
                                var $iframe = $('<iframe>').attr({
                                    src: fileUrl,
                                    type: 'application/pdf',
                                    width: '100%',
                                    height: '300px' // Adjust the height as needed
                                });
                                $previewContainer.append($iframe);
                            } else if (fileType ===
                                'application/vnd.openxmlformats-officedocument.wordprocessingml.document' ||
                                fileType ===
                                'application/vnd.openxmlformats-officedocument.presentationml.presentation'
                                ) {
                                // For DOCX and PPT files, provide a link to open the file in a new tab
                                var $link = $('<a>').attr({
                                    href: fileUrl,
                                    target: '_blank'
                                }).text('Open file: ' + fileName);
                                $previewContainer.append($link);
                            } else {
                                // For other file types, provide a link to open the file in a new tab
                                // var $link = $('<a>').attr({
                                //     href: fileUrl,
                                //     target: '_blank'
                                // }).text('Open file: ' + fileName);
                                // $previewContainer.append($link);
                            }
                        }
                    }
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
                let url = "{{ route('publication.update') }}";
                let form = $('#publicationForm')[0];
                let formData = new FormData(form);
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
                        // console.log(response);
                        var success = response.success;
                        $.each(success, function(key, value) {
                            // toastr.success(value);
                            Swal.fire('Success!', value,
                                'success');
                        });
                        $('#post-list-data').DataTable().ajax.reload(null, false);

                    },
                    error: function(xhr) {
                        var errors = xhr.responseJSON.errors;
                        // Iterate through each error and display it
                        $.each(errors, function(key, value) {
                            // console.log(key, value);
                            toastr.error(value); // Displaying each error message
                        });
                    }
                });

            });
        });
        $(document).on('click', '.delete', function(e) {
            e.preventDefault(); // Prevent default link behavior

            var id = $(this).attr('data-id');
            var url = "{{ route('publication.delete') }}";
            // Show SweetAlert confirmation dialog
            Swal.fire({
                title: 'Are you sure?',
                text: 'This action will delete this publication!',
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
            var url = "{{ route('publication.status') }}";
            // Show SweetAlert confirmation dialog
            Swal.fire({
                title: 'Are you sure?',
                text: 'This action will change status of this publication!',
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

                    $('#post-list-data').DataTable().ajax.reload(null, false);
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
        $(document).on('click', '#refresh', function(e) {
            e.preventDefault(); // Prevent default link behavior
            $('#submit').removeClass('d-none');

            // Show the update and refresh buttons
            $('#update, #refresh').addClass('d-none');
            $('#publicationForm')[0].reset();
            $('#pp').attr('src', '');
            $('#add-publication-tab').removeClass('active').text('Add Publication');
            $('#add-publication').removeClass('show active');
            $('#all-publication-tab').addClass('active');
            $('#all-publication').addClass('show active');
        });
        $(document).ready(function() {
            var existingFileUrl =
                "{{ asset('public/frontend/images/publication/' . ($member->memberInfos[0]['profile_attachment'] ?? '')) }}";
            var $previewContainer = $('#file-preview');
            // Function to preview a file
            function previewFile(fileUrl, fileType, fileName) {
                $previewContainer.empty();
                if (fileType.startsWith('image/')) {
                    var $img = $('<img>').attr('src', fileUrl).css('max-width', '100%');
                    $previewContainer.append($img);
                } else if (fileType === 'application/pdf') {
                    var $iframe = $('<iframe>').attr({
                        src: fileUrl,
                        type: 'application/pdf',
                        width: '100%',
                        height: '300px' // Adjust the height as needed
                    });
                    $previewContainer.append($iframe);
                } else if (fileType === 'application/vnd.openxmlformats-officedocument.wordprocessingml.document' ||
                    fileType === 'application/vnd.openxmlformats-officedocument.presentationml.presentation') {
                    // For DOCX and PPT files, provide a link to open the file in a new tab
                    var $link = $('<a>').attr({
                        href: fileUrl,
                        target: '_blank'
                    }).text('Open file: ' + fileName);
                    $previewContainer.append($link);
                } else {
                    // For other file types, provide a link to open the file in a new tab
                    // var $link = $('<a>').attr({
                    //     href: fileUrl,
                    //     target: '_blank'
                    // }).text('Open file: ' + fileName);
                    // $previewContainer.append($link);
                }
            }
            // Preview existing file if it exists
            if (existingFileUrl) {
                var existingFileName = "{{ $member->memberInfos[0]['profile_attachment'] ?? '' }}";
                var fileExtension = existingFileName.split('.').pop().toLowerCase();
                var fileType;
                switch (fileExtension) {
                    case 'jpg':
                    case 'jpeg':
                    case 'png':
                    case 'gif':
                        fileType = 'image/' + fileExtension;
                        break;
                    case 'pdf':
                        fileType = 'application/pdf';
                        break;
                    case 'docx':
                        fileType = 'application/vnd.openxmlformats-officedocument.wordprocessingml.document';
                        break;
                    case 'pptx':
                        fileType = 'application/vnd.openxmlformats-officedocument.presentationml.presentation';
                        break;
                    default:
                        fileType = 'application/octet-stream';
                }
                previewFile(existingFileUrl, fileType, existingFileName);
            }
            // Set up event listener for file input change
            $('#file').on('change', function() {
                var file = this.files[0];
                if (file) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        var blob = new Blob([e.target.result], {
                            type: file.type
                        });
                        var url = URL.createObjectURL(blob);
                        previewFile(url, file.type, file.name);
                    };
                    reader.readAsArrayBuffer(file);
                }
            });
        });
    </script>
@endpush
