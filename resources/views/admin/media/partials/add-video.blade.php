<form id="videoForm" action="" method="POST" enctype="multipart/form-data">
    <div class="row mb-3">
        <div class="col-md-12">
            <div class="form-group">
                <label for="title" class="text-3xl required">Video Title</label>
                <input type="text" class="form-control" id="title" name="title" value="{{ old('title') }}">
            </div>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-12">
            <div class="form-group">
                <label for="image" class="text-3xl required">Upload Thumnil Images</label>
                <input type="file" class="form-control" id="image" name="image" value=""
                    oninput="pp.src=window.URL.createObjectURL(this.files[0])">
                    <p class="text-danger">Thumnil must be 650px by 410px</p>
                <img id="pp" width="100" class="float-end mt-3" src="">
            </div>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-12">
            <div class="form-group">
                <label for="url" class="text-3xl required">Video Link</label>
                <input type="text" class="form-control" id="url" name="url" value="{{ old('url') }}">
            </div>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-12">
            <div class="form-group">
                <label for="content" class="text-3xl required">Video Content</label>
                <textarea class="form-control" id="content" name="content">{{ old('content') }}</textarea>
            </div>
        </div>
    </div>
    <div id="image-preview" class="row mb-3"></div>
    <button id="video-submit" type="submit" class="btn btn-primary "><i class="fas fa-upload"></i>Submit <span
            id="spinner" class="spinner-border spinner-border-sm text-light d-none" role="status"
            aria-hidden="true"></span></button>
    <button id="video-update" type="submit" class="btn btn-primary d-none"><i class="fas fa-wrench"></i>Update <span
            id="update-spinner" class="spinner-border spinner-border-sm text-light d-none" role="status"
            aria-hidden="true"></span></button></button>
    <button id="page-refresh" type="submit" class="btn btn-secondary d-none"><i class="fas fa-sync-alt"></i>
        Refresh</button>
</form>

@push('custom-js')
    <script>
        $(document).ready(function() {

            $('#video-submit').on('click', function(e) {
                e.preventDefault();

                $('#spinner').removeClass('d-none');
                let url = "{{ route('video.create') }}";
                let formData = new FormData($('#videoForm')[0]);
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
                        $('#spinner').addClass('d-none');
                        var success = response.success;
                        $.each(success, function(key, value) {
                            toastr.success(value); // Displaying each error message
                        });
                        $('#videoForm')[0].reset();
                        $('#pp').attr('src', '');
                        $('#video-data').DataTable().ajax.reload(null, false);
                    },
                    error: function(xhr) {
                        $('#spinner').addClass('d-none');
                        var errors = xhr.responseJSON.errors;
                        // Iterate through each error and display it
                        $.each(errors, function(key, value) {
                            console.log(key, value);
                            toastr.error(value); // Displaying each error message
                        });
                    }
                });

            });
            $('#video-update').on('click', function(e) {
                e.preventDefault();
                $('#spinner').removeClass('d-none');
                let url = "{{ route('video.update') }}";
                let id = $(this).attr('data-id');
                let formData = new FormData($('#videoForm')[0]);
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
                        $('#spinner').addClass('d-none');
                        $('#warning-photo').removeClass('d-none');
                        $.each(success, function(key, value) {
                            toastr.success(value); // Displaying each error message
                        });
                        $('#add-header').text('Add Photo');
                        $('#videoForm')[0].reset();
                        $('#pp').attr('src', '');
                        $('#video-data').DataTable().ajax.reload(null, false);
                        $('#video-submit').removeClass('d-none');
                        $('#video-update ').addClass('d-none');
                        $('#page-refresh').addClass('d-none');
                    },
                    error: function(xhr) {
                        $('#spinner').addClass('d-none');
                        var errors = xhr.responseJSON.errors;
                        // Iterate through each error and display it
                        $.each(errors, function(key, value) {
                            console.log(key, value);
                            toastr.error(value); // Displaying each error message
                        });
                    }
                });

            });

            $('#page-refresh').on('click', function(e) {
                e.preventDefault();
                $('#spinner').addClass('d-none');
                $('#warning-photo').removeClass('d-none');
                $('#add-header').text('Add Photo');
                $('#videoForm')[0].reset();
                $('#pp').attr('src', '');
                $('#video-submit').removeClass('d-none');
                $('#video-update ').addClass('d-none');
                $('#page-refresh').addClass('d-none');
            });
        });
    </script>
@endpush
