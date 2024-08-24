@extends('admin.layouts.backend-layout')

@section('breadcame')
    Upload User Manual
@endsection

@section('admin-content')
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Uploaded Manuals</h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive table-container">
                        <!--begin::Table-->
                        <table id="manualsTable"
                            class="table table-striped election-datatable align-middle table-bordered fs-6 gy-5 m-auto display responsive">
                            <!--begin::Table head-->
                            <thead>
                                <tr class="text-start text-muted fw-bolder fs-7 text-uppercase gs-0"
                                    style="background: #fff;">
                                    <th class="min-w-50px fw-bold text-dark firstTheadColumn" style="font-weight: 900">
                                        Manual Type</th>
                                    <th class="min-w-50px fw-bold text-dark firstTheadColumn" style="font-weight: 900">File
                                        Name</th>
                                    <th class="min-w-50px fw-bold text-dark firstTheadColumn" style="font-weight: 900">File
                                        File</th>
                                    <th class="min-w-50px fw-bold text-dark firstTheadColumn" style="font-weight: 900">
                                        Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- DataTables will populate this -->
                            </tbody>
                            <!--end::Table head-->
                        </table>
                        <!--end::Table-->
                    </div>


                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <form id="userManualForm" action="{{ route('userManual.create') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="manual_type" class="text-3xl required">Manual Type</label>
                                    <select class="form-control" id="manual_type" name="manual_type">
                                        <option value="admin_manual">Admin Manual</option>
                                        <option value="member_manual">Member Manual</option>
                                    </select>
                                    @error('manual_type')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12 mt-3">
                                <div class="form-group">
                                    <label for="manual_file" class="text-3xl required">Upload Manual</label>
                                    <input type="file" class="form-control" id="manual_file" name="manual_file"
                                        accept=".pdf,.doc,.docx">
                                    @error('manual_file')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <button id="manualConfigSubmit" type="submit" class="btn btn-primary mt-3">
                            <span id="spinner-manual-config-submit" class="spinner-border spinner-border-sm me-2 d-none"
                                role="status" aria-hidden="true"></span>
                            <i class="fas fa-upload"></i> Upload Manual
                        </button>
                    </form>
                </div>
            </div>
        </div>


    </div>
@endsection

@push('custom-js')
    <script>
        $(document).ready(function() {
            var table = $('#manualsTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('userManual') }}",
                    type: 'GET',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                },
                columns: [{
                        orderable: true,
                        sortable: false,
                        data: 'name',
                        name: 'name'
                    },
                    {
                        orderable: true,
                        sortable: false,
                        data: 'content',
                        name: 'content'
                    },
                    {
                        data: 'content',
                        name: 'content',
                        orderable: true,
                        sortable: false,
                        render: function(data, type, row) {
                            if (!data) {
                                return ''; // No file
                            }

                            let basePath = '{{ asset('public/frontend/user-manual/') }}/';
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
                        data: null,
                        name: 'actions',
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row) {
                            return `<div style="display: flex; align-items: center;">
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
        });
        $(document).on('click', '.delete', function(e) {
            e.preventDefault(); // Prevent default link behavior

            var id = $(this).attr('data-id');
            var url = "{{ route('userManual.delete') }}";
            // Show SweetAlert confirmation dialog
            Swal.fire({
                title: 'Are you sure?',
                text: 'This action will delete this Manual!',
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

                    $('#manualsTable').DataTable().ajax.reload(null, false);
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
        $(document).ready(function() {
            $('#userManualForm').on('submit', function(e) {
                e.preventDefault(); // Prevent default form submission

                var $form = $(this);
                var $button = $('#manualConfigSubmit');
                var $spinner = $('#spinner-manual-config-submit');

                var formData = new FormData($form[0]); // Use FormData to handle file upload

                $button.prop('disabled', true); // Disable the submit button
                $spinner.removeClass('d-none'); // Show the spinner

                $.ajax({
                    url: $form.attr('action'),
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        console.log(response);
                        // Handle success
                        if (response.status == 'success') {
                            toastr.success(response.message);
                            
                        } else {
                            toastr.error(response.message);
                        }
                    },
                    error: function(xhr) {
                        var errors = xhr.responseJSON.errors;
                        $.each(errors, function(key, value) {
                            toastr.error(value); // Displaying each error message
                        });
                    },
                    complete: function() {
                        $button.prop('disabled', false); // Enable the submit button
                        $spinner.addClass('d-none'); // Hide the spinner
                        $('#userManualForm')[0].reset();
                        $('#manualsTable').DataTable().ajax.reload(null, false);

                    }
                });
            });
        });
    </script>
@endpush
