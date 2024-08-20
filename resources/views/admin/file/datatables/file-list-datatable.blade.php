<div class="table-responsive table-container">
    <!--begin::Table-->
    <table class="table election-datatable align-middle table-bordered fs-6 gy-5 m-auto display responsive"
        id="file-list-data">
        <!--begin::Table head-->
        <thead>
            <tr class="text-start text-muted fw-bolder fs-7 text-uppercase gs-0" style="background: #fff;">
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
                <th class="min-w-50px fw-bold text-dark firstTheadColumn" style="font-weight: 900">
                    {{ __('File Type') }}
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
        <tbody>

        </tbody>
        <!--end::Table head-->
    </table>
    <!--end::Table-->
</div>


@push('custom-js')
    <script>
        $('#reset-filters').click(function() {
            $('#category').val('');
            $('#subcategory').val('');
            $('#status_filter').val('');
            $('#member').val('');
            $('#user').val('');
            $('#file-list-data').DataTable().ajax.reload(null, false);
            // Optionally trigger a search or data reload if needed
            // e.g., $('#yourTableId').DataTable().ajax.reload();
        });
        $(document).ready(function() {
            var table = $('#file-list-data').DataTable({
                processing: true,
                serverSide: true,

                ajax: {
                    url: "{{ route('file.list') }}",
                    type: 'GET',
                    data: function(data) {
                        data.category = $('#category').val();
                        data.subcategory = $('#subcategory').val();
                        data.member_id = $('#member').val();
                        data.user_id = $('#user').val();
                        data.status = $('#status_filter').val();
                        return data;
                    },
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
                                    <i class="${icon}" style="font-size: 20px; color: ${color};" aria-hidden="true"></i>
                                </a>
                            `;
                        }
                    },
                    {
                        data: 'assign_to',
                        name: 'assign_to',
                        orderable: true,
                        sortable: false,
                        render: function(data, type, row) {
                            // Determine icon based on assign_to value
                            const iconClass = data == 0 ? 'fas fa-globe text-success' :
                            'fas fa-share-alt text-primary'; // Globe for Public, Share for Shared

                            return `<i class="${iconClass}" style="font-size: 18px;" data-status="${data}" data-id="${row.id}"></i>`;
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

                            return `<span class="status badge badge-light-${data == 1 ? 'success' : 'danger'}" data-status="${data}" data-id="${row.id}">${data == 1 ? 'Published' : 'Unpublished'}</span>`;
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
                dom: "<'row'<'col-sm-4'l><'col-sm-4 d-flex justify-content-center'B><'col-sm-4'f>>" +
                    // Page length, buttons, and search
                    "<'row'<'col-sm-12'tr>>" + // Table rows
                    "<'row'<'col-sm-5'i><'col-sm-7'p>>", // Information and pagination
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
            $('#category, #subcategory, #status_filter, #member, #user').on('change', function() {
                table.ajax.reload(null, false);
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
