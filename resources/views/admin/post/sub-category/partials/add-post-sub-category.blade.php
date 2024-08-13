<form id="subcategoryForm" action="" method="POST" enctype="multipart/form-data">
    <div class="row mb-3">
        <div class="col-md-12">
            <div class="form-group">
                <label for="name" class="text-3xl required">-- Select Category --</label>
                <select name="category" id="category" class="form-select">
                    <option value="">-- Select Category --</option>
                    @forelse ($categories as $category)
                        <option value="{{ $category->id }}" class="form-group">{{ $category->name }}</option>
                    @empty
                        <option value="">There Is No Category</option>
                    @endforelse
                </select>
            </div>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-12">
            <div class="form-group">
                <label for="name" class="text-3xl required">Sub Category Name</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}">
            </div>
        </div>
    </div>
    <button id="subcategory-submit" type="submit" class="btn btn-primary mt-3">
        <span id="spinner-submit" class="spinner-border spinner-border-sm me-2 d-none" role="status"
            aria-hidden="true"></span>
        <i class="fas fa-upload"></i> Submit
    </button>

    <button id="subcategory-update" type="submit" class="btn btn-primary mt-3 d-none">
        <span id="spinner-update" class="spinner-border spinner-border-sm me-2 d-none" role="status"
            aria-hidden="true"></span>
        <i class="fas fa-wrench"></i> Update
    </button>

    <button id="page-refresh" type="submit" class="btn btn-secondary mt-3 d-none">
        <span id="spinner-refresh" class="spinner-border spinner-border-sm me-2 d-none" role="status"
            aria-hidden="true"></span>
        <i class="fas fa-sync-alt"></i> Refresh
    </button>

</form>

@push('custom-js')
    <script>
        $(document).ready(function() {

            $('#subcategory-submit').on('click', function(e) {
                e.preventDefault();
                $('#spinner-submit').removeClass('d-none'); // Show the spinner
                $(this).prop('disabled', true);
                let url = "{{ route('subcategory.create') }}";
                let category = $('#category').val();
                let name = $('#name').val();
                let formData = new FormData(); // Create FormData object

                formData.append('name', name);
                formData.append('category', category);
                $.ajax({
                    type: 'POST',
                    url: url,
                    data: formData,
                    processData: false, // Prevent jQuery from processing the data
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        $('#spinner-submit').addClass('d-none'); // hide the spinner
                        $('#subcategory-submit').prop('disabled', false);
                        var success = response.success;
                        $.each(success, function(key, value) {
                            toastr.success(value); // Displaying each error message
                        });
                        $('#subcategoryForm')[0].reset();
                        $('#post-subcategory-data').DataTable().ajax.reload(null, false);
                    },
                    error: function(xhr) {
                        $('#spinner-submit').addClass('d-none'); // hide the spinner
                        $('#subcategory-submit').prop('disabled', false);
                        var errors = xhr.responseJSON.errors;
                        // Iterate through each error and display it
                        $.each(errors, function(key, value) {
                            toastr.error(value); // Displaying each error message
                        });
                    }
                });

            });
            $('#subcategory-update').on('click', function(e) {
                e.preventDefault();
                $('#spinner-update').removeClass('d-none'); // Show the spinner
                $(this).prop('disabled', true);
                let url = "{{ route('subcategory.update') }}";
                let id = $(this).attr('data-id');
                let category = $('#category').val();
                let name = $('#name').val();
                let formData = new FormData(); // Create FormData object

                formData.append('name', name);
                formData.append('id', id);
                formData.append('category', category);
                $.ajax({
                    type: 'POST',
                    url: url,
                    data: formData,
                    processData: false, // Prevent jQuery from processing the data
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        $('#spinner-update').addClass('d-none'); // hide the spinner
                        $('#subcategory-update').prop('disabled', false);
                        var success = response.success;
                        $.each(success, function(key, value) {
                            toastr.success(value); // Displaying each error message
                        });
                        $('#add-header').text('Add Post Sub Category');
                        $('#subcategoryForm')[0].reset();
                        $('#post-subcategory-data').DataTable().ajax.reload(null, false);
                        $('#subcategory-submit').removeClass('d-none');
                        $('#subcategory-update ').addClass('d-none');
                        $('#page-refresh ').addClass('d-none');
                    },
                    error: function(xhr) {
                        $('#spinner-update').addClass('d-none'); // hide the spinner
                        $('#subcategory-update').prop('disabled', false);
                        var errors = xhr.responseJSON.errors;
                        // Iterate through each error and display it
                        $.each(errors, function(key, value) {
                            toastr.error(value); // Displaying each error message
                        });
                    }
                });

            });
            $('#page-refresh').on('click', function(e) {
                e.preventDefault();
                $('#add-header').text('Add Post Category');
                $('#subcategoryForm')[0].reset();
                $('#subcategory-submit').removeClass('d-none');
                $('#subcategory-update').addClass('d-none');
                $('#page-refresh ').addClass('d-none');
            });
        });
    </script>
@endpush
