<style>
    .preview-container {
        display: flex;
        flex-wrap: wrap;
        margin-bottom: 10px;
    }

    .preview-image {
        position: relative;
        width: calc(33.33% - 10px);
        /* Adjust width and margin as needed */
        margin-right: 10px;
        margin-bottom: 10px;
    }

    .preview-image img {
        display: block;
        width: 100%;
        height: auto;
    }

    .remove-btn {
        position: absolute;
        top: 5px;
        right: 5px;
        background-color: rgba(255, 255, 255, 0.8);
        border: none;
        color: red;
        border-radius: 50%;
        width: 20px;
        height: 20px;
        line-height: 1;
        text-align: center;
        cursor: pointer;
    }
</style>
<form id="photoForm" action="" method="POST" enctype="multipart/form-data">
    <div class="row mb-3">
        <div class="col-md-12">
            <div class="form-group">
                <label for="albumtype" class="text-3xl required">Album Type</label>
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
                <label for="images" class="text-3xl required" id="images-label">Upload Images</label>
                <input type="file" class="form-control" id="images" name="images[]" multiple>
                <p class="text-danger mt-2" id="warning-photo">Upload 10 file at once</p>
                <img src="" id="pp" alt="image" class="d-none"
                    style="height: 150px;width:150px; object-fit:contain">
            </div>
        </div>
    </div>
    <div id="image-preview" class="row mb-3"></div>
    <button id="photo-submit" type="submit" class="btn btn-primary "><i class="fas fa-upload"></i>Submit <span
            id="spinner" class="spinner-border spinner-border-sm text-light d-none" role="status"
            aria-hidden="true"></span></button>
    <button id="photo-update" type="submit" class="btn btn-primary d-none"><i class="fas fa-wrench"></i>Update <span
            id="update-spinner" class="spinner-border spinner-border-sm text-light d-none" role="status"
            aria-hidden="true"></span></button></button>
    <button id="page-refresh" type="submit" class="btn btn-secondary mt-3 d-none"><i class="fas fa-sync-alt"></i>
        Refresh </button>
</form>

@push('custom-js')
    <script>
        $(document).ready(function() {

            $('#photo-submit').on('click', function(e) {
                e.preventDefault();

                $('#spinner').removeClass('d-none');
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
                        $('#spinner').addClass('d-none');
                        $('#image-preview').empty(); // Clear all previews
                        filesArray = []; // Clear the files array
                        $('#images').val('');
                        var success = response.success;
                        $.each(success, function(key, value) {
                            toastr.success(value); // Displaying each error message
                        });
                        $('#photoForm')[0].reset();
                        $('#photo-data').DataTable().ajax.reload(null, false);
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
            $('#photo-update').on('click', function(e) {
                e.preventDefault();
                $('#spinner').removeClass('d-none');
                let url = "{{ route('photo.update') }}";
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
                        $('#spinner').addClass('d-none');
                        $('#images-label').addClass('required');
                        $('#image-preview').empty(); // Clear all previews
                        filesArray = []; // Clear the files array
                        $('#images').val('');
                        $('#warning-photo').removeClass('d-none');
                        $.each(success, function(key, value) {
                            toastr.success(value); // Displaying each error message
                        });
                        $('#add-header').text('Add Photo');
                        $('#photoForm')[0].reset();
                        $('#pp').addClass('d-none');
                        $('#pp').attr('src', '');
                        $('#photo-data').DataTable().ajax.reload(null, false);
                        $('#photo-submit').removeClass('d-none');
                        $('#photo-update ').addClass('d-none');
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

            $('#page-refresh').on('click', function(e) {
                e.preventDefault();
                $('#spinner').addClass('d-none');
                $('#images-label').addClass('required');
                $('#image-preview').empty(); // Clear all previews
                filesArray = []; // Clear the files array
                $('#images').val('');
                $('#warning-photo').removeClass('d-none');
                $('#add-header').text('Add Photo');
                $('#photoForm')[0].reset();
                $('#pp').addClass('d-none');
                $('#pp').attr('src', '');
                $('#photo-data').DataTable().ajax.reload(null, false);
                $('#photo-submit').removeClass('d-none');
                $('#photo-update ').addClass('d-none');
                $('#page-refresh').addClass('d-none');
            });

        });
    </script>
@endpush
