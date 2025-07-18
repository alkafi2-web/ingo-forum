<form id="albumForm" action="" method="POST" enctype="multipart/form-data">
    <div class="row mb-3">
        <div class="col-md-12">
            <div class="form-group">
                <label for="title" class="text-3xl required">Album Title</label>
                <input type="text" class="form-control" id="title" name="title" value="{{ old('title') }}">
            </div>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-12">
            <div class="form-group">
                <label for="content" class="text-3xl required">Album Content</label>
                <textarea class="form-control" id="content" name="content">{{ old('content') }}</textarea>
            </div>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-12">
            <div class="form-group">
                <label for="subcontent" class="text-3xl required">Album Sub Content</label>
                <textarea class="form-control" id="subcontent" name="subcontent">{{ old('subcontent') }}</textarea>
            </div>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-12">
            <div class="form-group">
                <label for="albumtype" class="text-3xl required">Album Type</label>
                <select class="form-control" id="albumtype" name="albumtype">
                    <option value="photo" {{ old('albumtype') == 'photo' ? 'selected' : '' }}>Photo</option>
                    {{-- <option value="video" {{ old('albumtype') == 'video' ? 'selected' : '' }}>Video</option> --}}
                </select>
            </div>
        </div>
    </div>
    <button id="album-submit" type="submit" class="btn btn-primary mt-3">
        <span id="spinner-album-submit" class="spinner-border spinner-border-sm me-2 d-none" role="status" aria-hidden="true"></span>
        <i class="fas fa-upload"></i> Submit
    </button>
    
    <button id="album-update" type="submit" class="btn btn-primary mt-3 d-none">
        <span id="spinner-album-update" class="spinner-border spinner-border-sm me-2 d-none" role="status" aria-hidden="true"></span>
        <i class="fas fa-wrench"></i> Update
    </button>
    <button id="page-refresh" type="submit" class="btn btn-secondary mt-3 d-none"><i class="fas fa-sync-alt"></i>
        Refresh</button>
</form>

@push('custom-js')
    <script>
        $(document).ready(function() {

            $('#album-submit').on('click', function(e) {
                e.preventDefault();
                $('#spinner-album-submit').removeClass('d-none'); // Show the spinner
                $(this).prop('disabled', true);
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
                        $('#spinner-album-submit').addClass('d-none'); // Show the spinner
                        $('#album-submit').prop('disabled', false);
                        var success = response.success;
                        $.each(success, function(key, value) {
                            toastr.success(value); // Displaying each error message
                        });
                        $('#albumForm')[0].reset();
                        $('#album-data').DataTable().ajax.reload(null, false);
                    },
                    error: function(xhr) {
                        $('#spinner-album-submit').addClass('d-none'); // Show the spinner
                        $('#album-submit').prop('disabled', false);
                        var errors = xhr.responseJSON.errors;
                        // Iterate through each error and display it
                        $.each(errors, function(key, value) {
                            toastr.error(value); // Displaying each error message
                        });
                    }
                });

            });
            $('#album-update').on('click', function(e) {
                e.preventDefault();
                $('#spinner-album-update').removeClass('d-none'); // Show the spinner
                $(this).prop('disabled', true);
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
                        $('#spinner-album-update').addClass('d-none'); // Show the spinner
                        $('#album-update').prop('disabled', false);
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
                        $('#page-refresh').addClass('d-none');
                    },
                    error: function(xhr) {
                        $('#spinner-album-update').addClass('d-none'); // Show the spinner
                        $('#album-update').prop('disabled', false);
                        var errors = xhr.responseJSON.errors;
                        // Iterate through each error and display it
                        $.each(errors, function(key, value) {
                            toastr.error(value); // Displaying each error message
                        });
                    }
                });

            });
            // Refresh button click event
            $('#page-refresh').on('click', function(e) {
                e.preventDefault();
                $('#add-header').text('Add Banner Content');
                $('#albumForm')[0].reset();
                $('#pp').attr('src', '');
                $('#album-submit').removeClass('d-none');
                $('#album-update ').addClass('d-none');
                $('#page-refresh').addClass('d-none');
            });
        });
    </script>
@endpush
