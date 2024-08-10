<div class="table-responsive table-container">
    <!--begin::Table-->
    <table class="table election-datatable align-middle table-bordered fs-6 gy-5 m-auto display responsive"
        id="photo-data">
        <!--begin::Table head-->
        <thead>
            <tr class="text-start text-muted fw-bolder fs-7 text-uppercase gs-0" style="background: #fff;">
                <th class="min-w-20px fw-bold text-dark firstTheadColumn" style="font-weight: 900">
                    <input type="checkbox" class="select-all">
                </th>
                <th class="min-w-50px fw-bold text-dark firstTheadColumn" style="font-weight: 900">
                    {{ __('Album Title') }}
                </th>
                <th class="min-w-50px fw-bold text-dark firstTheadColumn" style="font-weight: 900">
                    {{ __('Photo') }}
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
            $('#album_filter').val('');
            $('#status_filter').val('');
            
            $('#photo-data').DataTable().ajax.reload(null, false);
        });
        $(document).ready(function() {
            $('#photo-data').on('click', '.select-all', function() {
                // Get the checked status of the select all checkbox
                var isChecked = $(this).prop('checked');

                // Update the checked status of all checkboxes in the table body
                $('.selected-single').prop('checked', isChecked);
            });
            var table = $('#photo-data').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('photo') }}",
                    type: 'GET',
                    data: function(data) {
                        data.album_filter = $('#album_filter').val();
                        data.status_filter = $('#status_filter').val();
                        return data;
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                },
                columns: [{
                        orderable: false,
                        searchable: false,
                        data: null,
                        render: function(data, type, row) {
                            var checkboxHTML =
                                '<input type="checkbox" name="enrollID[]" class="selected-single" value="' +
                                row.id + '">';
                            return checkboxHTML;
                        },
                        className: 'text-center',
                        name: 'serial_number'
                    },
                    {
                        orderable: true,
                        sortable: false,
                        data: 'album_name',
                        name: 'album_name'
                    },
                    {
                        data: 'media',
                        name: 'media',
                        orderable: true,
                        sortable: false,
                        render: function(data, type, row) {
                            let basePath = '{{ asset('public/frontend/images/photo-gallery/') }}/';
                            return `<img src="${basePath + data}" alt="Image" style="width: 100px; height: 100px; object-fit:contain;">`;
                        }
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
                        <i class="fas fa-edit text-primary" style="font-size: 16px;"></i>
                    </a>
                    <a href="javascript:void(0)" class="text-danger delete" data-id="${row.id}">
                        <i class="fas fa-trash text-danger" style="font-size: 16px;"></i>
                    </a>`;
                        }
                    }
                ],
                lengthMenu: [
                    [5, 10, 30, 50, -1],
                    [5, 10, 30, 50, "All"]
                ],
                pageLength: 5,
                dom: "<'row'<'col-sm-4'l><'col-sm-4 d-flex justify-content-center'B><'col-sm-4'f>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-5'i><'col-sm-7'p>>",
                buttons: [{
                    extend: 'collection',
                    text: 'Actions',
                    buttons: [{
                            text: 'Approve Selected',
                            action: function(e, dt, node, config) {
                                var checkedValues = $('.selected-single:checked').map(
                                    function() {
                                        return this.value;
                                    }).get();

                                if (checkedValues.length === 0) {
                                    toastr.error('No items selected.');
                                } else {
                                    Swal.fire({
                                        title: 'Are you sure?',
                                        text: 'Approve selected items!',
                                        icon: 'warning',
                                        showCancelButton: true,
                                        confirmButtonColor: '#3085d6',
                                        cancelButtonColor: '#d33',
                                        confirmButtonText: 'Yes, approve!'
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            $.ajax({
                                                url: "",
                                                type: 'POST',
                                                data: {
                                                    ids: checkedValues,
                                                    _token: '{{ csrf_token() }}'
                                                },
                                                success: function(
                                                response) {
                                                    table.ajax.reload(
                                                        null, false);
                                                    toastr.success(
                                                        'Items approved successfully.'
                                                        );
                                                },
                                                error: function(xhr, status,
                                                    error) {
                                                    toastr.error(
                                                        'Error: ' +
                                                        xhr
                                                        .responseText
                                                        );
                                                }
                                            });
                                        }
                                    });
                                }
                            }
                        },
                        {
                            text: 'Deliver Selected',
                            action: function(e, dt, node, config) {
                                var checkedValues = $('.selected-single:checked').map(
                                    function() {
                                        return this.value;
                                    }).get();

                                if (checkedValues.length === 0) {
                                    toastr.error('No items selected.');
                                } else {
                                    Swal.fire({
                                        title: 'Are you sure?',
                                        text: 'Deliver selected items!',
                                        icon: 'warning',
                                        showCancelButton: true,
                                        confirmButtonColor: '#3085d6',
                                        cancelButtonColor: '#d33',
                                        confirmButtonText: 'Yes, deliver!'
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            $.ajax({
                                                url: "",
                                                type: 'POST',
                                                data: {
                                                    ids: checkedValues,
                                                    _token: '{{ csrf_token() }}'
                                                },
                                                success: function(
                                                response) {
                                                    table.ajax.reload(
                                                        null, false);
                                                    toastr.success(
                                                        'Items delivered successfully.'
                                                        );
                                                },
                                                error: function(xhr, status,
                                                    error) {
                                                    toastr.error(
                                                        'Error: ' +
                                                        xhr
                                                        .responseText
                                                        );
                                                }
                                            });
                                        }
                                    });
                                }
                            }
                        }
                    ]
                }],
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
                        className: 'text-center'
                    }
                ]
            });

            $('#album_filter, #status_filter').on('change', function() {
                table.ajax.reload(null, false);
            });
        });

        $(document).on('click', '.edit', function(e) {
            e.preventDefault(); // Prevent default link behavior

            var id = $(this).attr('data-id');
            var url = "{{ route('photo.edit') }}";
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
                    console.log(response.photo);
                    var photo = response.photo;
                    $('#add-header').text('Update Photo');
                    $('#warning-photo').addClass('d-none');
                    $('#images-label').removeClass('required');
                    $('#albumtype').val(photo.album_id);
                    $('#pp').removeClass('d-none');
                    let basePath = '{{ asset('public/frontend/images/photo-gallery/') }}/'
                    var imagePath = basePath + photo.media;
                    $('#pp').attr('src', imagePath);
                    $('#photo-update').removeClass('d-none');
                    $('#photo-update').attr('data-id', photo.id);
                    $('#photo-submit').addClass('d-none');
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
            var url = "{{ route('photo.delete') }}";
            // Show SweetAlert confirmation dialog
            Swal.fire({
                title: 'Are you sure?',
                text: 'This action will delete this photo!',
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
            var url = "{{ route('photo.status') }}";
            // Show SweetAlert confirmation dialog
            Swal.fire({
                title: 'Are you sure?',
                text: 'This action will change status of this photo!',
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

                    $('#photo-data').DataTable().ajax.reload(null, false);
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
