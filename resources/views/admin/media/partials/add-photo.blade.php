<form id="photoForm" action="" method="POST" enctype="multipart/form-data">
    <div class="row mb-3">
        <div class="col-md-12">
            <div class="form-group">
                <label for="albumtype" class="text-3xl">Album Type</label>
                <select class="form-control" id="albumtype" name="album_id">
                    <option value="" disabled selected>Select Album</option>
                    @forelse ($albums as $album)
                        <option value="{{ $album->id }}">{{ $album->title }}</option>
                    @empty
                    @endforelse
                </select>
            </div>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-12">
            <div class="form-group">
                <label for="images" class="text-3xl">Upload Images</label>
                <input type="file" class="form-control" id="images" name="images[]" multiple>
                <p class="text-danger">Upload 10 file at once</p>
            </div>
        </div>
    </div>
    <button id="photo-submit" type="submit" class="btn btn-primary ">Submit</button>
    <button id="photo-update" type="submit" class="btn btn-primary d-none">Update</button>
</form>

@push('custom-js')
    <script>
        $(document).ready(function() {

            $('#photo-submit').on('click', function(e) {
                e.preventDefault();
                let url = "{{ route('photo.create') }}";
                let formData = new FormData($('#photoForm')[0]);
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
                        console.log(response);
                        // var success = response.success;
                        // $.each(success, function(key, value) {
                        //     toastr.success(value); // Displaying each error message
                        // });
                        // $('#photoForm')[0].reset();
                        // $('#album-data').DataTable().ajax.reload(null, false);
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
            $('#photo-update').on('click', function(e) {
                e.preventDefault();
                let url = "{{ route('album.update') }}";
                let id = $(this).attr('data-id');
                let formData = new FormData($('#photoForm')[0]);
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
                        $('#photoForm')[0].reset();
                        $('#pp').attr('src', '');
                        $('#album-data').DataTable().ajax.reload(null, false);
                        $('#photo-submit').removeClass('d-none');
                        $('#photo-update ').addClass('d-none');
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
