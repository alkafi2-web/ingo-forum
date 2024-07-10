<form id="albumForm" action="" method="POST" enctype="multipart/form-data">
    <div class="row mb-3">
        <div class="col-md-12">
            <div class="form-group">
                <label for="title" class="text-3xl">Album Title</label>
                <input type="text" class="form-control" id="title" name="title" value="{{ old('title') }}">
            </div>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-12">
            <div class="form-group">
                <label for="content" class="text-3xl">Album Content</label>
                <textarea class="form-control" id="content" name="content">{{ old('content') }}</textarea>
            </div>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-12">
            <div class="form-group">
                <label for="subcontent" class="text-3xl">Album Sub Content</label>
                <textarea class="form-control" id="subcontent" name="subcontent">{{ old('subcontent') }}</textarea>
            </div>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-12">
            <div class="form-group">
                <label for="albumtype" class="text-3xl">Album Type</label>
                <select class="form-control" id="albumtype" name="albumtype">
                    <option value="photo" {{ old('albumtype') == 'photo' ? 'selected' : '' }}>Photo</option>
                    <option value="video" {{ old('albumtype') == 'video' ? 'selected' : '' }}>Video</option>
                </select>
            </div>
        </div>
    </div>
    <button id="album-submit" type="submit" class="btn btn-primary mt-3">Submit</button>
    <button id="album-update" type="submit" class="btn btn-primary mt-3 d-none">Update</button>
</form>

@push('custom-js')
    <script>
        $(document).ready(function() {

            $('#album-submit').on('click', function(e) {
                e.preventDefault();
                let url = "{{ route('album.create') }}";
                let formData = new FormData($('#albumForm')[0]);
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
                        // console.log(response);
                        var success = response.success;
                        $.each(success, function(key, value) {
                            toastr.success(value); // Displaying each error message
                        });
                        $('#albumForm')[0].reset();
                        $('#album-data').DataTable().ajax.reload(null, false);
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
            $('#album-update').on('click', function(e) {
                e.preventDefault();
                let url = "{{ route('album.update') }}";
                let id = $(this).attr('data-id');
                let formData = new FormData($('#albumForm')[0]);
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
                        var success = response.success;
                        $.each(success, function(key, value) {
                            toastr.success(value); // Displaying each error message
                        });
                        $('#add-header').text('Add Banner Content');
                        $('#albumForm')[0].reset();
                        $('#pp').attr('src', '');
                        $('#album-data').DataTable().ajax.reload(null, false);
                        $('#album-submit').removeClass('d-none');
                        $('#album-update ').addClass('d-none');
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
