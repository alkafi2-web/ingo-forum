<form id="videoForm" action="" method="POST" enctype="multipart/form-data">
    <div class="row mb-3">
        <div class="col-md-12">
            <div class="form-group">
                <label for="title" class="text-3xl">Video Title</label>
                <input type="text" class="form-control" id="title" name="title" value="{{ old('title') }}">
            </div>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-12">
            <div class="form-group">
                <label for="image" class="text-3xl">Upload Thumnil Images</label>
                <input type="file" class="form-control" id="image" name="image" value=""
                    oninput="pp.src=window.URL.createObjectURL(this.files[0])" onchange="previewImage(event)">
                <img id="pp" width="100" class="float-end mt-3" src="">
            </div>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-12">
            <div class="form-group">
                <label for="url" class="text-3xl">Video Link</label>
                <input type="text" class="form-control" id="url" name="url" value="{{ old('url') }}">
            </div>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-12">
            <div class="form-group">
                <label for="content" class="text-3xl">Video Content</label>
                <textarea class="form-control" id="content" name="content">{{ old('content') }}</textarea>
            </div>
        </div>
    </div>
    <div id="image-preview" class="row mb-3"></div>
    <button id="video-submit" type="submit" class="btn btn-primary ">Submit <span id="spinner"
            class="spinner-border spinner-border-sm text-light d-none" role="status"
            aria-hidden="true"></span></button>
    <button id="video-update" type="submit" class="btn btn-primary d-none">Update <span id="update-spinner"
            class="spinner-border spinner-border-sm text-light d-none" role="status"
            aria-hidden="true"></span></button></button>
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
                        $('#pp').src('');
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
                let url = "{{ route('photo.update') }}";
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
                        $('#image-preview').empty(); // Clear all previews
                        filesArray = []; // Clear the files array
                        $('#images').val('');
                        $('#warning-photo').removeClass('d-none');
                        $.each(success, function(key, value) {
                            toastr.success(value); // Displaying each error message
                        });
                        $('#add-header').text('Add Photo');
                        $('#videoForm')[0].reset();
                        $('#pp').addClass('d-none');
                        $('#pp').attr('src', '');
                        $('#video-data').DataTable().ajax.reload(null, false);
                        $('#video-submit').removeClass('d-none');
                        $('#video-update ').addClass('d-none');
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

            var filesArray = []; // Array to store uploaded files

            $('#images').on('change', function() {
                $('#pp').addClass('d-none');
                var previewContainer = $('#image-preview');
                previewContainer.empty(); // Clear previous previews
                filesArray = []; // Reset the files array

                var files = $(this).get(0).files;
                for (var i = 0; i < files.length; i++) {
                    var file = files[i];
                    filesArray.push(file); // Store file in array for reference

                    var reader = new FileReader();

                    reader.onload = function(event) {
                        var imgElement = $('<img>').addClass('img-thumbnail');
                        imgElement.attr('src', event.target.result);

                        var removeBtn = $('<button>').addClass('remove-btn');
                        removeBtn.text('×'); // Add cross symbol
                        removeBtn.on('click', function() {
                            var index = $(this).parent().index(); // Get index of preview div
                            filesArray.splice(index, 1); // Remove file from array
                            $(this).parent().remove(); // Remove the preview div
                            updateFileInput(); // Update file input value
                        });

                        var previewDiv = $('<div>').addClass('preview-image');
                        previewDiv.append(imgElement).append(removeBtn);
                        previewContainer.append(previewDiv);
                    }

                    reader.readAsDataURL(file);
                }
            });

            function updateFileInput() {
                var input = $('#images');
                input.val(''); // Clear current input value

                // Create a new FileList and assign it to the input
                var newFileList = new DataTransfer();
                for (var i = 0; i < filesArray.length; i++) {
                    newFileList.items.add(filesArray[i]);
                }
                input.get(0).files = newFileList.files;
            }

        });
    </script>
@endpush
