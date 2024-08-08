<form id="pageForm" action="" method="POST" enctype="multipart/form-data">
    @csrf
    <input type="hidden" id="page_id" name="page_id" value="{{ $page->id??'' }}">
    <div class="row mb-3">
        <div class="col-md-12">
            <div class="form-group">
                <label for="page_title" class="text-3xl required">Page Title</label>
                <input type="text" class="form-control" id="page_title" name="page_title" value="{{ $page->title??old('page_title') }}">
            </div>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-12">
            <div class="form-group">
                <label for="page_slug" class="text-3xl required">Page Slug</label>
                <input type="text" class="form-control" id="page_slug" name="page_slug" value="{{ $page->slug??old('page_slug') }}" data-page-id="{{ $page->id??'' }}">
                <i id="slug-exist" class="text-danger d-none">Slug already exists, try a different one</i>
            </div>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-12">
            <div class="form-group mt-3">
                <label for="page_details" class="mb-3 required">Page Details</label>
                <textarea id="page_details" name="page_details" class="form-control mt-5" rows="7" required>{{ $page->details??old('page_details') }}</textarea>
            </div>
        </div>
    </div>
    <button id="page-submit" type="submit" class="btn btn-primary mt-3"><i class="fas fa-upload"></i> Submit</button>
    <button id="page-update" type="submit" class="btn btn-primary mt-3 d-none"><i class="fas fa-wrench"></i> Update</button>
    <button id="page-refresh" type="submit" class="btn btn-secondary mt-3 d-none"><i class="fas fa-sync-alt"></i> Refresh</button>
</form>

@push('custom-js')
<script> 
    CKEDITOR.replace('page_details');
    $(document).ready(function() {
        // Function to generate slug
        function generateSlug(value) {
            return value.toString().toLowerCase()
                .replace(/[^a-z0-9\s-]/g, '') // Remove all non-alphanumeric characters except spaces and hyphens
                .replace(/\s+/g, '-') // Replace spaces with hyphens
                .replace(/-+/g, '-'); // Replace multiple hyphens with a single hyphen
        }

        // Event listener for title input
        $('#page_title').on('input', function() {
            let title = $(this).val();
            let slug = generateSlug(title);
            let page_id = $('#page_id').val();
            $('#page_slug').val(slug);
            checkSlug(slug, page_id);
        });

        // Event listener for slug input
        $('#page_slug').on('input', function() {
            let slug = generateSlug($(this).val());
            let page_id = $('#page_id').val();
            checkSlug(slug, page_id);
        });

        // Function to check slug
        function checkSlug(slug, page_id) {
            $.ajax({
                url: '{{ route('slug.verify') }}',
                method: 'GET',
                data: { 
                    slug: slug,
                    page_id: page_id
                },
                success: function(response) {
                    console.log(response);
                    if(response.exists) {
                        $('#slug-exist').removeClass('d-none');
                        $('#page-submit').prop('disabled', true);
                    } else {
                        $('#slug-exist').addClass('d-none');
                        $('#page-submit').prop('disabled', false);
                    }
                },
                error: function() {
                    console.log('Error checking slug');
                }
            });
        }

        // Form submit handler
        $('#pageForm').on('submit', function(e) {
            e.preventDefault();
            let isValid = true;

            // Check for required fields
            if (!$('#page_title').val()) {
                toastr.error('Page title is required');
                isValid = false;
            }
            if (!$('#page_slug').val()) {
                toastr.error('Page slug is required');
                isValid = false;
            }
            let pageDetails = CKEDITOR.instances['page_details'].getData().trim();
            if (pageDetails === '') {
                toastr.error('Page details are required');
                isValid = false;
            }

            if (isValid) {
                let formData = new FormData(this);
                formData.append('page_details', pageDetails);

                $.ajax({
                    url: '{{ route('page.storeOrUpdate') }}',
                    method: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        toastr.success(response.message);
                        location.reload();
                    },
                    error: function(response) {
                        if (response.responseJSON && response.responseJSON.errors) {
                            $.each(response.responseJSON.errors, function(key, value) {
                                toastr.error(value[0]);
                            });
                        } else {
                            toastr.error('An error occurred while saving the page');
                        }
                    }
                });
            }
        });

        // Refresh button click event
        $('#page-refresh').on('click', function(e) {
            e.preventDefault();
            resetForm();
        });

        // Reset form function
        function resetForm() {
            $('#pageForm')[0].reset();
            CKEDITOR.instances['page_details'].setData('');
            $('#page-submit').removeClass('d-none');
            $('#page-update').addClass('d-none');
            $('#page-refresh').addClass('d-none');
            $('#page-header').text('Add New Page');
            $('#slug-exist').addClass('d-none');
            $('#page-submit').prop('disabled', false);
        }
    });
</script>
@endpush
