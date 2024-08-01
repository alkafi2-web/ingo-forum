
<div class="table-responsive table-container">
    <!--begin::Table-->
    <table class="table election-datatable align-middle table-bordered fs-6 gy-5 m-auto display responsive"
        id="userActivityDatatable">
        <!--begin::Table head-->
        <thead>
            <tr class="text-start text-muted fw-bolder fs-7 text-uppercase gs-0" style="background: #fff;">
                <th class="min-w-50px fw-bold text-dark firstTheadColumn" style="font-weight: 900">
                    {{ __('User Name') }}
                </th>
                <th class="min-w-50px fw-bold text-dark firstTheadColumn" style="font-weight: 900">
                    {{ __('IP') }}
                </th>
                <th class="min-w-50px fw-bold text-dark firstTheadColumn" style="font-weight: 900">
                    {{ __('Activity') }}
                </th>
                <th class="min-w-50px fw-bold text-dark firstTheadColumn" style="font-weight: 900">
                    {{ __('Device/Browser') }}
                </th>
                <th class="min-w-50px fw-bold text-dark firstTheadColumn" style="font-weight: 900">
                    {{ __('Datetime') }}
                </th>
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
        var table = $('#userActivityDatatable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('activity.list') }}",
                type: 'GET',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            },
            columns: [
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'ip',
                    name: 'ip'
                },
                {
                    data: 'activity',
                    name: 'activity'
                },
                {
                    data: 'device_browser',
                    name: 'device_browser'
                },
                {
                    data: 'datetime',
                    name: 'datetime'
                }
            ],
            lengthMenu: [
                [5, 10, 30, 50, -1],
                [5, 10, 30, 50, "All"]
            ], // Add 'All' option
            pageLength: 5, // Set default page length
            dom: "<'row'<'col-sm-4'l><'col-sm-4 d-flex justify-content-center'B><'col-sm-4'f>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-5'i><'col-sm-7'p>>",
            buttons: [
                {
                    extend: 'colvis',
                    columns: ':not(:first-child)' // Exclude first column (serial)
                },
            ],
            language: {
                search: '<div class="input-group">' +
                    '<span class="input-group-text">' +
                    '<i class="fas fa-search"></i>' +
                    '</span>' +
                    '_INPUT_' +
                    '</div>'
            },
            columnDefs: [
                {
                    targets: '_all',
                    searchable: true,
                    orderable: true
                },
                {
                    targets: -1, // Target the last column (actions column)
                    className: 'text-center', // Optional: Center align the content in this column
                }
            ],
            responsive: true,
        });
    });
</script>
@endpush