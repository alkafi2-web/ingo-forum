<div class="table-responsive table-container">
    <!--begin::Table-->
    <table class="table election-datatable align-middle table-bordered fs-6 gy-5 m-auto display responsive"
        id="album-data">
        <!--begin::Table head-->
        <thead>
            <tr class="text-start text-muted fw-bolder fs-7 text-uppercase gs-0" style="background: #fff;">
                <th class="min-w-50px fw-bold text-dark firstTheadColumn" style="font-weight: 900">
                    {{ __('Album Title') }}
                </th>
                <th class="min-w-50px fw-bold text-dark firstTheadColumn" style="font-weight: 900">
                    {{ __('Album Content') }}
                </th>
                <th class="min-w-50px fw-bold text-dark" style="font-weight: 900">
                    {{ __('Album Sub Content') }}
                </th>
                <th class="min-w-50px fw-bold text-dark" style="font-weight: 900">
                    {{ __('Album Type') }}
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
            var table = $('#album-data').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('media.album') }}",
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
                        data: 'content',
                        name: 'content'
                    },
                    {
                        orderable: true,
                        sortable: false,
                        data: 'subcontent',
                        name: 'subcontent'
                    },
                    {
                        orderable: true,
                        sortable: false,
                        data: 'albumtype',
                        name: 'albumtype'
                    },
                    {
                        data: 'status',
                        name: 'status',
                        orderable: true,
                        sortable: false,
                        render: function(data, type, row) {

                            return `<span class="status badge badge-light-${data == 1 ? 'success' : 'danger'}" data-status="${data}" data-id="${row.id}">${data == 1 ? 'Active' : 'Deactive'}</span>`;
                        }
                    },
                    {
                        data: null,
                        name: 'actions',
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row) {
                            return `
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
                // responsive: true,

            });
        });
        $(document).on('click', '.edit', function(e) {
            e.preventDefault(); // Prevent default link behavior

            var id = $(this).attr('data-id');
            var url = "{{ route('album.edit') }}";
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
                    console.log(response.album);
                    var album = response.album;
                    $('#add-header').text('Update Album');
                    $('#title').val(album.title);
                    $('#content').val(album.content);
                    $('#subcontent').val(album.subcontent);
                    $('#albumtype').val(album.albumtype);
                    $('#album-update').removeClass('d-none');
                    $('#album-update').attr('data-id',album.id);
                    $('#album-submit').addClass('d-none');
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
            var url = "{{ route('album.delete') }}";
            // Show SweetAlert confirmation dialog
            Swal.fire({
                title: 'Are you sure?',
                text: 'This action will delete this media Album!',
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
            var url = "{{ route('album.status') }}";
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

                    $('#album-data').DataTable().ajax.reload(null, false);
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
