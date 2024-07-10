<form id="subcategoryForm" action="" method="POST" enctype="multipart/form-data">
    <div class="row mb-3">
        <div class="col-md-12">
            <div class="form-group">
                <label for="name" class="text-3xl">-- Select Category --</label>
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
                <label for="name" class="text-3xl">Sub Category Name</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}">
            </div>
        </div>
    </div>
    <button id="subcategory-submit" type="submit" class="btn btn-primary mt-3">Submit</button>
    <button id="subcategory-update" type="submit" class="btn btn-primary mt-3 d-none">Update</button>
</form>

@push('custom-js')
    <script>
        $(document).ready(function() {

            $('#subcategory-submit').on('click', function(e) {
                e.preventDefault();
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
                        var success = response.success;
                        $.each(success, function(key, value) {
                            toastr.success(value); // Displaying each error message
                        });
                        $('#subcategoryForm')[0].reset();
                        $('#post-subcategory-data').DataTable().ajax.reload(null, false);
                    },
                    error: function(xhr) {
                        var errors = xhr.responseJSON.errors;
                        // Iterate through each error and display it
                        $.each(errors, function(key, value) {
                            console.log(key, value);
                            toastr.error(value); // Displaying each error message
                        });
                    }
                });

            });
            $('#subcategory-update').on('click', function(e) {
                e.preventDefault();
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
                        var success = response.success;
                        $.each(success, function(key, value) {
                            toastr.success(value); // Displaying each error message
                        });
                        $('#add-header').text('Add Post Category');
                        $('#subcategoryForm')[0].reset();
                        $('#post-category-data').DataTable().ajax.reload(null, false);
                        $('#subcategory-submit').removeClass('d-none');
                        $('#category-update ').addClass('d-none');
                    },
                    error: function(xhr) {
                        var errors = xhr.responseJSON.errors;
                        // Iterate through each error and display it
                        $.each(errors, function(key, value) {
                            console.log(key, value);
                            toastr.error(value); // Displaying each error message
                        });
                    }
                });

            });
        });
    </script>
@endpush
