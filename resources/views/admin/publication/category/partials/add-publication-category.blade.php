<form id="categoryForm" action="" method="POST" enctype="multipart/form-data">
    <div class="row mb-3">
        <div class="col-md-12">
            <div class="form-group">
                <label for="name" class="text-3xl required">Category Name</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}">
            </div>
        </div>
    </div>
    <button id="category-submit" type="submit" class="btn btn-primary mt-3">
        <span id="spinner-submit" class="spinner-border spinner-border-sm me-2 d-none" role="status"
            aria-hidden="true"></span>
        <i class="fas fa-upload"></i> Submit
    </button>

    <button id="category-update" type="submit" class="btn btn-primary mt-3 d-none">
        <span id="spinner-update" class="spinner-border spinner-border-sm me-2 d-none" role="status"
            aria-hidden="true"></span>
        <i class="fas fa-wrench"></i> Update
    </button>

    <button id="page-refresh" type="submit" class="btn btn-secondary mt-3 d-none"><i class="fas fa-sync-alt"></i>
        Refresh</button>
</form>

@push('custom-js')
    <script>
        $(document).ready(function() {

            $('#category-submit').on('click', function(e) {
                e.preventDefault();
                $('#spinner-submit').removeClass('d-none'); // Show the spinner
                $(this).prop('disabled', true);
                let url = "{{ route('publication.category.create') }}";
                let name = $('#name').val();
                let formData = new FormData(); // Create FormData object
                formData.append('name', name);
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
                        $('#category-submit').prop('disabled', false);
                        var success = response.success;
                        $.each(success, function(key, value) {
                            toastr.success(value); // Displaying each error message
                        });
                        $('#categoryForm')[0].reset();
                        $('#publication-category-data').DataTable().ajax.reload(null, false);
                    },
                    error: function(xhr) {
                        $('#spinner-submit').addClass('d-none'); // hide the spinner
                        $('#category-submit').prop('disabled', false);
                        var errors = xhr.responseJSON.errors;
                        // Iterate through each error and display it
                        $.each(errors, function(key, value) {
                            toastr.error(value); // Displaying each error message
                        });
                    }
                });

            });
            $('#category-update').on('click', function(e) {
                e.preventDefault();
                $('#spinner-update').removeClass('d-none'); // Show the spinner
                $(this).prop('disabled', true);
                let url = "{{ route('publication.category.update') }}";
                let id = $(this).attr('data-id');
                let name = $('#name').val();
                let formData = new FormData(); // Create FormData object

                formData.append('name', name);
                formData.append('id', id);
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
                        $('#category-update').prop('disabled', false);
                        var success = response.success;
                        $.each(success, function(key, value) {
                            toastr.success(value); // Displaying each error message
                        });
                        $('#add-header').text('Add Publication Category');
                        $('#categoryForm')[0].reset();
                        $('#publication-category-data').DataTable().ajax.reload(null, false);
                        $('#category-submit').removeClass('d-none');
                        $('#category-update ').addClass('d-none');
                        $('#page-refresh ').addClass('d-none');
                    },
                    error: function(xhr) {
                        $('#spinner-update').addClass('d-none'); // hide the spinner
                        $('#category-update').prop('disabled', false);
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
                $('#add-header').text('Add Publication Category');
                $('#categoryForm')[0].reset();
                $('#category-submit').removeClass('d-none');
                $('#category-update ').addClass('d-none');
                $('#page-refresh ').addClass('d-none');
            });
        });
    </script>
@endpush
