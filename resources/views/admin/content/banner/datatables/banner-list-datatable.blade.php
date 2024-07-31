<div class="table-responsive table-container">
    <!--begin::Table-->
    <table class="table election-datatable align-middle table-bordered fs-6 gy-5 m-auto display responsive" id="banner-data">
        <!--begin::Table head-->
        <thead>
            <tr class="text-start text-muted fw-bolder fs-7 text-uppercase gs-0" style="background: #fff;">
                <th class="min-w-50px fw-bold text-dark firstTheadColumn" style="font-weight: 900">
                    {{ __('Banner Title') }}
                </th>
                <th class="min-w-50px fw-bold text-dark" style="font-weight: 900">
                    {{ __('Background') }}
                </th>
                <th class="min-w-50px fw-bold text-dark" style="font-weight: 900">
                    {{ __('Content Img') }}
                </th>
                <th class="min-w-50px fw-bold text-dark" style="font-weight: 900">
                    {{ __('Status') }}
                </th>
                <th class="text-end min-w-140px fw-bold text-dark lastTheadColumn" style="font-weight: 900">
                    {{ __('Action') }}
                </th>
            </tr>
        </thead>
        <tbody>
            <!-- Content will be loaded via DataTables AJAX -->
        </tbody>
        <!--end::Table head-->
    </table>
    <!--end::Table-->
</div>

@push('custom-js')
<script>
    $(document).ready(function() {
        var table = $('#banner-data').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('banner') }}",
                type: 'GET',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            },
            columns: [
                {
                    data: 'title_display',
                    name: 'title_display',
                    orderable: true,
                    searchable: true
                },
                {
                    data: 'background_display',
                    name: 'background_display',
                    orderable: true,
                    searchable: true
                },
                {
                    data: 'content_image_display',
                    name: 'content_image_display',
                    orderable: true,
                    searchable: true
                },
                {
                    data: 'status',
                    name: 'status',
                    orderable: true,
                    searchable: true
                },
                {
                    data: 'actions',
                    name: 'actions',
                    orderable: false,
                    searchable: false
                }
            ],
            lengthMenu: [
                [6, 30, 50, -1],
                [6, 30, 50, "All"]
            ],
            pageLength: 6,
            dom: "<'row'<'col-sm-4'l><'col-sm-4 d-flex justify-content-center'B><'col-sm-4'f>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-5'i><'col-sm-7'p>>",
            buttons: [
                {
                    extend: 'colvis',
                    columns: ':not(:first-child)'
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
                    targets: -1,
                    className: 'text-center'
                }
            ],
        });

        $(document).on('click', '#editButton', function(e) {
            e.preventDefault();

            var id = $(this).attr('data-id');
            var url = "{{ route('banner.info') }}";
            $.ajax({
                url: url,
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: { id: id },
                success: function(response) {
                    var banner = response.banner;
                    $('#add-header').text('Update Banner');
                    $('#banner_id').val(id);
                    $('#title').val(banner.title.text);
                    $('#title_color').val(banner.title.color);
                    $('#titleSwitch').prop('checked', banner.title.status);

                    $('#banner_description').val(banner.description.text);
                    $('#description_color').val(banner.description.color);
                    $('#descriptionSwitch').prop('checked', banner.description.status);

                    $('#background_type').val(banner.background_color.status ? 'color' : 'image');
                    $('#background_color').val(banner.background_color.color);
                    $('#overlay_color').val(banner.overlay_color.color);
                    $('#overlaySwitch').prop('checked', banner.overlay_color.status);

                    if (banner.background_color.status) {
                        $('#backgroundImageRow').hide();
                        $('#backgroundColorRow').show();
                    } else {
                        $('#backgroundImageRow').show();
                        $('#backgroundColorRow').hide();
                    }

                    let basePath = '{{ asset('public/frontend/images/banner/') }}/';
                    $('#pp').attr('src', banner.bg_image && banner.bg_image.path ? basePath + banner.bg_image.path : '');
                    $('#position').val(banner.position);
                    
                    if (banner.content_image && banner.content_image.path) {
                        $('#content_pp').attr('src', basePath + banner.content_image.path);
                        $('#contentImageSwitch').prop('checked', banner.content_image.status);
                    } else {
                        $('#content_pp').attr('src', '');
                        $('#contentImageSwitch').prop('checked', false);
                    }

                    if (banner.button.status) {
                        $('#button_text').val(banner.button.text);
                        $('#button_bg_color').val(banner.button.bg_color);
                        $('#button_color').val(banner.button.color);
                        $('#button_url').val(banner.button.url);
                        $('#add_button').prop('checked', true);
                        $('#buttonRow').show();
                    } else {
                        $('#button_text').val(banner.button.text);
                        $('#button_bg_color').val(banner.button.bg_color);
                        $('#button_color').val(banner.button.color);
                        $('#button_url').val(banner.button.url);
                        $('#add_button').prop('checked', false);
                        $('#buttonRow').hide();
                    }

                    $('#bannerSubmitBtn').text('Update');
                    $('#page-refresh').removeClass('d-none');
                },
                error: function(xhr, status, error) {
                    Swal.fire('Error!', 'An error occurred.', 'error');
                }
            });
        });

        $(document).on('click', '.delete', function(e) {
            e.preventDefault();

            var id = $(this).attr('data-id');
            var url = "{{ route('banner.delete') }}";
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
                    sendAjaxReq(id, null, url);
                }
            });
        });

        $(document).on('click', '.status', function(e) {
            e.preventDefault();

            var id = $(this).attr('data-id');
            var status = $(this).attr('data-status');
            var url = "{{ route('banner.status') }}";
            Swal.fire({
                title: 'Are you sure?',
                text: 'This action will change status of this banner!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, change it!',
                cancelButtonText: 'No, cancel!',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    sendAjaxReq(id, status, url);
                }
            });
        });

        function sendAjaxReq(id, status, url) {
            var requestData = { id: id };
            if (typeof status !== 'undefined' && status !== null) {
                requestData.status = status;
            }
            $.ajax({
                url: url,
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: requestData,
                success: function(response) {
                    $('#banner-data').DataTable().ajax.reload(null, false);
                    toastr.success(response.success);
                },
                error: function(xhr, status, error) {
                    Swal.fire('Error!', 'An error occurred.', 'error');
                }
            });
        }

        $('#page-refresh').on('click', function(e) {
            e.preventDefault();
            $('#add-header').text('Add New Banner');
            $('#bannerForm')[0].reset();
            $('#pp').attr('src', '');
            $('#content_pp').attr('src', '');
            $('#bannerSubmitBtn').text('Submit');
            $('#page-refresh').addClass('d-none');
            $('#banner_id').val('')
        });
    });
</script>
@endpush
