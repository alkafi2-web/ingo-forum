<style>
    .fas{
        cursor: pointer;
    }
</style>
<div class="table-responsive table-container">
    <!--begin::Table-->
    <table class="table election-datatable align-middle table-bordered fs-6 gy-5 m-auto display responsive"
        id="pagelist-datatable">
        <!--begin::Table head-->
        <thead>
            <tr class="text-start text-muted fw-bolder fs-7 text-uppercase gs-0" style="background: #fff;">
                <th class="min-w-50px fw-bold text-dark firstTheadColumn" style="font-weight: 900">
                    {{ __('Title') }}
                </th>
                <th class="min-w-50px fw-bold text-dark" style="font-weight: 900">
                    {{ __('slug') }}
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
    var table = $('#pagelist-datatable').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route('admin.page') }}',
        columns: [
            { data: 'title', name: 'title' },
            { data: 'slug', name: 'slug' },
            { data: 'status', name: 'status', orderable: false, searchable: false },
            { data: 'actions', name: 'actions', orderable: false, searchable: false }
        ],
        lengthMenu: [
            [15, 20, 30, 50, -1],
            [15, 20, 30, 50, "All"]
        ], // Add 'All' option
        pageLength: 15, // Set default page length
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
    // Edit button click event
    $('#pagelist-datatable').on('click', '#edit-page-button', function(e) {
        e.preventDefault();
        let url = $(this).attr('href');
        $.ajax({
            url: url,
            method: 'GET',
            success: function(response) {
                $('#page_id').val(response.id);
                $('#page_title').val(response.title);
                $('#page_slug').val(response.slug);
                CKEDITOR.instances['page_details'].setData(response.details);
                $('#page-submit').addClass('d-none');
                $('#page-update').removeClass('d-none');
                $('#page-refresh').removeClass('d-none');
                $('#page-header').text('Update ' + response.title + ' Page');
            },
            error: function() {
                toastr.error('Failed to load page details');
            }
        });
    });

    // Toggle visibility
    $('#pagelist-datatable').on('click', '#inactive-page, #active-page', function() {
        var pageId = $(this).attr('data');
        var iconElement = $(this);

        Swal.fire({
            title: 'Are you sure?',
            text: "You want to change the visibility of this page!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, change it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '{{ route('page.toggleVisibility') }}',
                    type: 'POST',
                    data: {
                        id: pageId,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        Swal.fire(
                            'Updated!',
                            response.message,
                            'success'
                        );
                        table.draw(false); // Refresh the DataTable without resetting pagination
                    },
                    error: function(response) {
                        Swal.fire(
                            'Failed!',
                            'An error occurred while updating the visibility.',
                            'error'
                        );
                    }
                });
            }
        });
    });

    // Delete page
    $('#pagelist-datatable').on('click', '#delete-page', function() {
        var pageId = $(this).attr('data');

        Swal.fire({
            title: 'Are you sure?',
            text: "You want to delete this page!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '{{ route('page.destroy') }}',
                    type: 'DELETE',
                    data: {
                        id: pageId,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        Swal.fire(
                            'Deleted!',
                            response.message,
                            'success'
                        );
                        table.draw(false); // Refresh the DataTable without resetting pagination
                    },
                    error: function(response) {
                        Swal.fire(
                            'Failed!',
                            'An error occurred while deleting the page.',
                            'error'
                        );
                    }
                });
            }
        });
    });

});
</script>
@endpush