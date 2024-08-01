<div class="table-responsive table-container">
    <!--begin::Table-->
    <table class="table election-datatable align-middle table-bordered fs-6 gy-5 m-auto display responsive"
        id="member-data">
        <!--begin::Table head-->
        <thead>
            <tr class="text-start text-muted fw-bolder fs-7 text-uppercase gs-0" style="background: #fff;">
                <th class="min-w-50px fw-bold text-dark firstTheadColumn" style="font-weight: 900">
                    {{ __('Organisation Name') }}
                </th>
                <th class="min-w-50px fw-bold text-dark firstTheadColumn" style="font-weight: 900">
                    {{ __('Country Head') }}
                </th>
                <th class="min-w-50px fw-bold text-dark firstTheadColumn" style="font-weight: 900">
                    {{ __('NGO Bureau Number') }}
                </th>
                <th class="min-w-50px fw-bold text-dark" style="font-weight: 900">
                    {{ __('Organisation Type') }}
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
        $(document).ready(function() {
            var table = $('#member-data').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('member.list') }}",
                    type: 'GET',
                    data: function(data) {
                        data.organization = $('#organization').val();
                        data.status_filter = $('#status_filter').val();
                        return data;
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                },
                columns: [{
                        orderable: true,
                        sortable: false,
                        data: 'organisation_name',
                        name: 'organisation_name'
                    },
                    {
                        orderable: true,
                        sortable: false,
                        data: 'director_name',
                        name: 'director_name'
                    },
                    {
                        orderable: true,
                        sortable: false,
                        data: 'organisation_ngo_reg',
                        name: 'organisation_ngo_reg'
                    },
                    {
                        orderable: true,
                        sortable: false,
                        data: 'org_type',
                        name: 'org_type',
                        render: function(data, type, row) {
                            return `<span class="badge badge-${data == 1 ? 'primary' : 'info'}" data-status="${data}" data-id="${row.id}">${data == 1 ? 'Registered with NGO Affairs Bureau (NGOAB) as an INGO' : 'Possess international governance structures'}</span>`;
                        }
                    },
                    {
                        data: 'status',
                        name: 'status',
                        orderable: true,
                        sortable: false,
                        render: function(data, type, row) {
                            const statusMap = {
                                0: {
                                    text: 'Pending',
                                    class: 'warning'
                                },
                                1: {
                                    text: 'Approved',
                                    class: 'success'
                                },
                                2: {
                                    text: 'Suspended',
                                    class: 'info'
                                },
                                3: {
                                    text: 'Rejected',
                                    class: 'danger'
                                }
                            };

                            const status = statusMap[data] || {
                                text: '',
                                class: 'secondary'
                            };

                            return `<span class="badge badge-${status.class}" data-status="${data}" data-id="${row.id}">${status.text}</span>`;
                        }
                    },
                    {
                        data: null,
                        name: 'actions',
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row) {
                            var url = "{{ route('member.view', ':id') }}".replace(':id', row.id);
                            return `
                        <a href="${url}" class="text-info mr-2 me-2" data-id="${row.id}">
                            <i class="fas fa-eye text-info" style="font-size: 16px;"></i>
                        </a>`;
                        }
                    }
                ],
                lengthMenu: [
                    [5, 10, 30, 50, -1],
                    [5, 10, 30, 50, "All"]
                ], // Add 'All' option
                pageLength: 10, // Set default page length
                dom: "<'row'<'col-sm-4'l><'col-sm-4 d-flex justify-content-center'B><'col-sm-4'f>>" +
                    // Page length, buttons, and search
                    "<'row'<'col-sm-12'tr>>" + // Table rows
                    "<'row'<'col-sm-5'i><'col-sm-7'p>>", // Information and pagination
                buttons: [{
                        extend: 'colvis',
                        columns: ':not(:first-child)' // Exclude first column (serial)
                    },
                    {
                        extend: 'excel',
                        exportOptions: {
                            columns: ':visible' // Export only visible columns
                        }
                    }
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
                ]
            });

            $('#organization, #status_filter').on('change', function() {
                table.ajax.reload(null, false);
            });
        });


        $(document).on('click', '.view', function(e) {
            e.preventDefault(); // Prevent default link behavior

            var id = $(this).attr('data-id');
            var url = "";
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
                    console.log(response);
                    // var banner = response.banner;
                    // $('#add-header').text('Update Banner Content');
                    // $('#title').val(banner.title);
                    // $('#b_des').val(banner.description);
                    // let basePath = '{{ asset('public/frontend/images/banner/') }}/'
                    // var imagePath = basePath + banner.image;
                    // $('#pp').attr('src', imagePath);
                    // $('#banner-update').removeClass('d-none');
                    // $('#banner-update').attr('data-id', banner.id);
                    // $('#banner-submit').addClass('d-none');
                    // $('#page-refresh').removeClass('d-none');
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
            var url = "{{ route('banner.delete') }}";
            // Show SweetAlert confirmation dialog
            Swal.fire({
                title: 'Are you sure?',
                text: 'This action will delete this banner!',
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
            var url = "{{ route('banner.status') }}";
            // Show SweetAlert confirmation dialog
            Swal.fire({
                title: 'Are you sure?',
                text: 'This action will change status of this banner!',
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

                    $('#member-data').DataTable().ajax.reload(null, false);
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
