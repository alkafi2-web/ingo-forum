<form id="pageForm" action="" method="POST" enctype="multipart/form-data">
    <div class="row mb-3">
        <div class="col-md-12">
            <div class="form-group">
                <label for="page_title" class="text-3xl required">Page Title</label>
                <input type="text" class="form-control" id="page_title" name="page_title" value="{{ old('page_title') }}">
            </div>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-12">
            <div class="form-group">
                <label for="page_slug" class="text-3xl required">Page Slug</label>
                <input type="text" class="form-control" id="page_slug" name="page_slug" value="{{ old('page_slug') }}">
                <i id="slug-exist" class="text-danger d-none">Slug already exists, try a different one</i>
            </div>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-12">
            <div class="form-group mt-3">
                <label for="page_details" class="mb-3 required">Page Details</label>
                <textarea id="page_details" name="page_details" class="form-control mt-5" rows="7" required></textarea>
            </div>
        </div>
    </div>
    <button id="page-submit" type="submit" class="btn btn-primary mt-3">Submit</button>
    <button id="page-update" type="submit" class="btn btn-primary mt-3 d-none">Update</button>
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
            $('#page_slug').val(slug);
            checkSlug(slug);
        });

        // Event listener for slug input
        $('#page_slug').on('input', function() {
            let slug = generateSlug($(this).val());
            $(this).val(slug);
            checkSlug(slug);
        });

        // Function to check slug
        function checkSlug(slug) {
            $.ajax({
                url: '{{ route('slug.verify') }}',
                method: 'GET',
                data: { slug: slug },
                success: function(response) {
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
    });
</script>
@endpush