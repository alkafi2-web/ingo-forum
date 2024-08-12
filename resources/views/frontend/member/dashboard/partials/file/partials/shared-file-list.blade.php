<div class="table-responsive table-container">
    <!--begin::Table-->
    <table
        class="table election-datatable w-100 align-middle table-bordered fs-14px gy-5 m-auto display responsive"
        id="public-shared-file-list-data">
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
                <th class="min-w-50px fw-bold text-dark" style="font-weight: 900">
                    {{ __('Added By') }}
                </th>
                <th class="text-end min-w-140px fw-bold text-dark lastTheadColumn" style="font-weight: 900">
                    {{ __('Download') }}</th>
            </tr>
        </thead>
        <!--end::Table head-->
    </table>
    <!--end::Table-->
</div>
@push('custom-js')
    <script>
        $(document).ready(function() {
            var table = $('#public-shared-file-list-data').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('member.shared.file') }}",
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
                        orderable: true,
                        sortable: false,
                        data: 'creator',
                        name: 'creator'
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
                                    <i class="${icon}" style="font-size: 20px; color: ${color};" aria-hidden="true"></i>
                                </a>
                            `;
                        }
                    },
                    
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
    </script>
@endpush