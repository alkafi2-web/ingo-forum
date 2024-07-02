<div class="table-responsive table-container">
    <!--begin::Table-->
    <table class="table election-datatable align-middle table-bordered fs-6 gy-5 m-auto display responsive"
        id="role-data">
        <!--begin::Table head-->
        <thead>
            <tr class="text-start text-muted fw-bolder fs-7 text-uppercase gs-0" style="background: #fff;">
                <th class="min-w-50px fw-bold text-dark firstTheadColumn" style="font-weight: 900">{{ __('Serial') }}
                </th>
                <th class="min-w-50px fw-bold text-dark firstTheadColumn" style="font-weight: 900">{{ __('Role Name') }}
                </th>
                <th class="min-w-50px fw-bold text-dark" style="font-weight: 900">
                    {{ __('Created at') }}
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
        var table = $('#role-data').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "",
                type: 'GET',
                
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            },
            columns: [{
                    orderable: true,
                    searchable: true,
                    data: null,
                    render: function(data, type, row, meta) {
                        // Use meta.row + 1 to get the actual row number starting from 1
                        return meta.row + 1;
                    },
                    name: 'serial_number'
                },
                {
                    orderable: true,
                    sortable: false,
                    data: 'name',
                    name: 'name'
                },
                {
                    orderable: true,
                    sortable: false,
                    data: 'created_at',
                    name: 'created_at',
                    render: function(data, type, row) {
                        // Format the date using moment.js
                        return moment(data).format(
                            'DD MMM YYYY hh:mm A');
                    }
                },
                
            ],
            lengthMenu: [
                [10, 30, 50, -1],
                [10, 30, 50, "All"]
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
</script>
@endpush
