<div id="file_ts">
    <ul class="sub-profile-tabs nav nav-tabs mb-3" id="pills-tab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link fw-bold active" id="all-file-tab" data-bs-toggle="tab" data-bs-target="#all-file"
                type="button" role="tab" aria-controls="all-file" aria-selected="false" tabindex="-1"><i
                    class="fas fa-file"></i>&nbsp;All File</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link fw-bold" id="add-file-tab" data-bs-toggle="tab" data-bs-target="#add-file"
                type="button" role="tab" aria-controls="add-file" aria-selected="true"><i
                    class="fas fa-file-medical addPubIcon"></i><i class="fas fa-wrench updatePubIcon"
                    style="display: none"></i>&nbsp;<span class="file-btn-text">Add File</span></button>
        </li>
    </ul>
    <div class="tab-content" id="pills-tabContent">

        <div class="tab-pane fade show active" id="all-file" role="tabpanel" aria-labelledby="all-file-tab"
            tabindex="0">
            <div class="table-responsive table-container">
                <!--begin::Table-->
                <table
                    class="table election-datatable w-100 align-middle table-bordered fs-14px gy-5 m-auto display responsive"
                    id="file-list-data">
                    <!--begin::Table head-->
                    <thead>
                        <tr class="text-start text-muted text-uppercase gs-0" style="background: #fff;">
                            <th class="min-w-50px fw-bold text-dark firstTheadColumn" style="font-weight: 900">
                                {{ __('Title') }}
                            </th>
                            <th class="min-w-50px fw-bold text-dark firstTheadColumn" style="font-weight: 900">
                                {{ __('Category') }}
                            </th>
                            <th class="min-w-50px fw-bold text-dark firstTheadColumn" style="font-weight: 900">
                                {{ __('Subcategory') }}
                            </th>
                            <th class="min-w-50px fw-bold text-dark firstTheadColumn" style="font-weight: 900">
                                {{ __('Description') }}
                            </th>
                            <th class="min-w-50px fw-bold text-dark firstTheadColumn" style="font-weight: 900">
                                {{ __('File') }}
                            </th>
                            <th class="min-w-50px fw-bold text-dark" style="font-weight: 900">
                                {{ __('Added By') }}
                            </th>
                            <th class="min-w-50px fw-bold text-dark" style="font-weight: 900">
                                {{ __('Status') }}
                            </th>
                            <th class="text-end min-w-140px fw-bold text-dark lastTheadColumn" style="font-weight: 900">
                                {{ __('Action') }}</th>
                        </tr>
                    </thead>
                    <!--end::Table head-->
                </table>
                <!--end::Table-->
            </div>
        </div>
        <div class="tab-pane fade " id="add-file" role="tabpanel" aria-labelledby="add-file-tab" tabindex="0">
            <form action="/submit-form" id="fileForm" method="POST" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-6">
                        <!-- Category -->
                        <div class="form-group">
                            <label for="category" class="required">Category</label>
                            <select id="category" name="category" class="form-control mt-3" required="">
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
                            <label for="subcategory" class="">Subcategory</label>
                            <select id="subcategory" name="subcategory" class="form-control mt-3">
                                <option value="">-- Select Category First --</option>

                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <!-- Title -->
                        <div class="form-group mt-3">
                            <label for="title" class="required">Title</label>
                            <input type="text" id="title" name="title" class="form-control mt-3"
                                required="">
                        </div>
                    </div>

                </div>

                <!-- Short Description -->
                <div class="form-group mt-3">
                    <label for="short_description" class="mb-3">Short Description</label>
                    <textarea id="short_description" name="short_description" class="form-control" rows="4"></textarea>
                </div>

                <!-- file -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group mt-3">
                            <label for="file" id="file_label" class="required">Attachment</label>
                            <input type="file" id="file" name="file" class="form-control mt-3">
                            <div id="file-preview" class="mt-3">

                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group mt-3">
                            <input type="hidden" name="id" id="file_id">
                            <input type="hidden" name="creator_type" id="creator_type" value="\App\Models\Member">
                            <button type="" id="submit" class="submit-btn mt-4"> <i
                                    class="fas fa-save"></i> Submit</button>
                            <button type="" id="update" class="submit-btn mt-4 d-none"> <i
                                    class="fas fa-update"></i> Update</button>
                            <button type="" id="refresh" class="submit-btn mt-4 d-none"> <i
                                    class="fas fa-refresh"></i> Refresh</button>
                        </div>
                    </div>
                </div>
                {{-- <div class="row">
                    <div class="col-md-12">
                        <div class="form-group mt-3">
                            <input type="hidden" id="creator_type" name="creator_type" value="\App\Models\User">
                            <button type="" id="submit" class="btn btn-primary mt-4"> <i
                                    class="fas fa-upload"></i>Submit</button>
                        </div>
                    </div>
                </div> --}}
                <!-- Submit Button -->
            </form>
        </div>
    </div>
</div>

@push('custom-js')
    <script>
        $(document).ready(function() {
            var categories = @json($categories);
            $('#category').on('change', function() {
                var categoryId = $(this).val();
                var selectedCategory = categories.find(category => category.id == categoryId);
                var subcategories = selectedCategory ? selectedCategory.subcategories : [];

                $('#subcategory').empty().append('<option value="">-- Select Sub Category --</option>');

                subcategories.forEach(function(subcategory) {
                    $('#subcategory').append(
                        `<option value="${subcategory.id}">${subcategory.name}</option>`);
                });
            });
        });


        $(document).ready(function() {
            $('#submit').on('click', function(e) {
                e.preventDefault();
                let url = "{{ route('file.store') }}";
                let form = $('#fileForm')[0];
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
                        $('#file-list-data').DataTable().ajax.reload(null, false);
                        $('#fileForm')[0].reset();
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
            var table = $('#file-list-data').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('member.file.index') }}",
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
                        data: 'category_name',
                        name: 'category_name'
                    },
                    {
                        orderable: true,
                        sortable: false,
                        data: 'subcategory_name',
                        name: 'subcategory_name'
                    },
                    {
                        orderable: true,
                        sortable: false,
                        data: 'description',
                        name: 'description'
                    },
                    {
                        data: 'attachment',
                        name: 'attachment',
                        orderable: true,
                        sortable: false,
                        render: function(data, type, row) {
                            if (!data) {
                                return ''; // No file
                            }

                            let basePath = '{{ asset('public/frontend/images/files/') }}/';
                            let fileExtension = data.split('.').pop().toLowerCase();
                            let icon;
                            let color;

                            // Determine icon and color based on file extension
                            if (fileExtension === 'pdf') {
                                icon = 'fas fa-file-pdf';
                                color = '#d9534f'; // Red
                            } else if (['doc', 'docx'].includes(fileExtension)) {
                                icon = 'fas fa-file-word';
                                color = '#007bff'; // Blue
                            } else if (['ppt', 'pptx'].includes(fileExtension)) {
                                icon = 'fas fa-file-powerpoint';
                                color = '#fd7e14'; // Orange
                            } else if (['jpg', 'jpeg', 'png'].includes(fileExtension)) {
                                icon = 'fas fa-file-image';
                                color = '#28a745'; // Green
                            } else if (fileExtension === 'zip') {
                                icon = 'fas fa-file-archive';
                                color = '#6c757d'; // Gray
                            } else {
                                icon = 'fas fa-file'; // Default icon
                                color = '#343a40'; // Dark Gray
                            }

                            return `
                                <a href="${basePath + data}" target="_blank">
                                    <i class="${icon}" style="font-size: 20px; color: ${color};" aria-hidden="true"></i> ${data}
                                </a>
                            `;
                        }
                    },
                    {
                        orderable: true,
                        sortable: false,
                        data: 'creator',
                        name: 'creator'
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
                            var editRoute = '{{ route('file.edit', ':id') }}'.replace(':id', row
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
                url: "{{ route('member.file.edit', ':id') }}".replace(':id', id),
                type: 'GET',
                success: function(response) {
                    console.log(response)
                    // Assuming response contains the data to populate the form
                    // Activate the "add-blog-news" tab and change the text to "Update Blog/News"
                    $('#submit').addClass('d-none');

                    // Show the update and refresh buttons
                    $('#update, #refresh').removeClass('d-none');
                    $('.updatePubIcon').show();
                    $('.addPubIcon').hide();

                    $('#add-file-tab').addClass('active');
                    $('.file-btn-text').text('Update file');
                    $('#add-file').addClass('show active');
                    $('#all-file-tab').removeClass('active');
                    $('#all-file').removeClass('show active');
                    $('#file_label').removeClass('required');
                    $('#category').val(response.category_id).trigger('change');
                    setTimeout(() => {
                        $('#subcategory').val(response.subcategory_id);
                    }, 100);
                    // Other form fields can be populated here as needed
                    $('#title').val(response.title);
                    $('#short_description').val(response.description);
                    $('#file_id').val(response.id);

                    let basePath = '{{ asset('public/frontend/images/files/') }}/'
                    var existingFileUrl = `${basePath}${response.attachment}`;
                    var $previewContainer = $('#file-preview');
                    if (existingFileUrl) {
                        var existingFileName = response.attachment;
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
                                var $link = $('<a>').attr({
                                    href: fileUrl,
                                    target: '_blank'
                                }).text('Open file: ' + fileName);
                                $previewContainer.append($link);
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
                let url = "{{ route('file.update') }}";
                let form = $('#fileForm')[0];
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
                        $('#file-list-data').DataTable().ajax.reload(null, false);
                        $('#submit').removeClass('d-none');

                        // Show the update and refresh buttons
                        $('#update, #refresh').addClass('d-none');
                        $('#fileForm')[0].reset();

                        $('#add-file-tab').removeClass('active');
                        $('.file-btn-text').text('Add File');
                        $('.updatePubIcon').hide();
                        $('.addPubIcon').show();
                        $('#file-preview').html('');

                        $('#add-file').removeClass('show active');
                        $('#all-file-tab').addClass('active');
                        $('#all-file').addClass('show active');
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
            var url = "{{ route('file.delete') }}";
            // Show SweetAlert confirmation dialog
            Swal.fire({
                title: 'Are you sure?',
                text: 'This action will delete this file!',
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
            var url = "{{ route('file.status') }}";
            // Show SweetAlert confirmation dialog
            Swal.fire({
                title: 'Are you sure?',
                text: 'This action will change status of this file!',
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

                    $('#file-list-data').DataTable().ajax.reload(null, false);
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
            $('#fileForm')[0].reset();
            $('#add-file-tab').removeClass('active');
            $('.file-btn-text').text('Add File');
            $('.updatePubIcon').hide();
            $('.addPubIcon').show();
            $('#file-preview').html('');
            $('#add-file').removeClass('show active');
            $('#all-file-tab').addClass('active');
            $('#all-file').addClass('show active');

        });

        $(document).ready(function() {
            
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
