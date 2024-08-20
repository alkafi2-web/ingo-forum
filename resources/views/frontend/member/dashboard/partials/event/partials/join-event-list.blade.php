<!--begin::Table-->
<table class="table election-datatable w-100 align-middle table-bordered fs-14px gy-5 m-auto display"
    id="join-event-data">
    <!--begin::Table head-->
    <thead>
        <th class="min-w-150px fw-bold text-dark" style="font-weight: 900">
            {{ __('Event Name') }}
        </th>
        {{-- <th class="min-w-50px fw-bold text-dark firstTheadColumn" style="font-weight: 900">
            {{ __('Details') }}
        </th> --}}
        <th class="min-w-150px fw-bold text-dark" style="font-weight: 900">
            {{ __('Attendee Name') }}
        </th>
        <th class="min-w-50px fw-bold text-dark" style="font-weight: 900">
            {{ __('Attendee Email') }}
        </th>
        <th class="min-w-50px fw-bold text-dark" style="font-weight: 900">
            {{ __('Attendee Phone') }}
        </th>
        <th class="min-w-50px fw-bold text-dark" style="font-weight: 900">
            {{ __('Total Perticipant') }}
        </th>
        <th class="min-w-50px fw-bold text-dark" style="font-weight: 900">
            {{ __('Guest Info') }}
        </th>
        
        {{-- <th class="text-end min-w-100px fw-bold text-dark lastTheadColumn" style="font-weight: 900">
            {{ __('Action') }}</th>
        </tr> --}}
    </thead>
    <!--end::Table head-->
    <tbody>

    </tbody>
</table>
<!--end::Table-->
@push('custom-js')
    <script>
        $(document).ready(function() {
            var table = $('#join-event-data').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('member.event.join.list') }}",
                    type: 'GET',
                    data: function(data) {
                        data.event = $('#event').val();
                        return data;
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                },
                columns: [{
                        orderable: true,
                        sortable: false,
                        data: 'event_name',
                        name: 'event_name'
                    },
                    {
                        orderable: true,
                        sortable: false,
                        data: 'attendee_name',
                        name: 'attendee_name'
                    },
                    {
                        orderable: true,
                        sortable: false,
                        data: 'attendee_email',
                        name: 'attendee_email'
                    },
                    {
                        orderable: true,
                        sortable: false,
                        data: 'attendee_phone',
                        name: 'attendee_phone'
                    },
                    {
                        orderable: true,
                        sortable: false,
                        data: 'total_participant',
                        name: 'total_participant'
                    },
                    {
                        orderable: true,
                        sortable: false,
                        data: 'guest_info',
                        name: 'guest_info'
                    },
                    // {
                    //     data: 'reg_fees_status',
                    //     name: 'reg_fees_status',
                    //     orderable: true,
                    //     sortable: false,
                    //     render: function(data, type, row) {
                    //         // Check if reg_fees is null or empty
                    //         if (row.reg_fees == 0) {
                    //             return '<span class="badge bg-warning status" data-status="no-fees" data-id="' +
                    //                 row.id + '">No Fees</span>';
                    //         }

                    //         // Map status values to badge classes and texts
                    //         const badgeMap = {
                    //             1: {
                    //                 class: 'bg-success',
                    //                 text: 'Paid'
                    //             },
                    //             0: {
                    //                 class: 'bg-danger',
                    //                 text: 'Due'
                    //             },
                    //             // Add additional mappings as needed
                    //         };

                    //         // Default to 'bg-light' if status is not in the badgeMap
                    //         const badge = badgeMap[data] || {
                    //             class: 'bg-light',
                    //             text: 'Unknown'
                    //         };

                    //         return `<span class="badge ${badge.class} status" data-status="${data}" data-id="${row.id}">${badge.text}</span>`;
                    //     }
                    // }


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
                    'excel', 'print'
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
                        className: '', // Optional: Center align the content in this column
                    },
                    {
                        targets: '_all',
                        searchable: true,
                        orderable: true
                    }
                ],
                // responsive: true,

            });
            $('#event').on('change', function() {
                table.ajax.reload(null, false);
            });
        });
    </script>
@endpush
