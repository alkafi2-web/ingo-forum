@extends('admin.layouts.backend-layout')
@section('breadcame')
    Publication Add
@endsection
@section('admin-content')
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h2 class="mt-5">Publication Add</h2>
                    <a href="{{ route('publication.list') }}" class="btn btn-primary"><span><i
                                class="fas fa-list"></i></span>All
                        Publication</a>
                </div>
                <div class="card-body">
                    <form action="/submit-form" id="publicationForm" method="POST" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-6">
                                <!-- Category -->
                                <div class="form-group ">
                                    <label for="category" class="required">Category</label>
                                    <select id="category" name="category" class="form-control mt-3" required>
                                        <option value="">-- Select Category --</option>
                                        @forelse ($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @empty
                                            <option value="">There is No Category</option>
                                        @endforelse
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <!-- Title -->
                                <div class="form-group ">
                                    <label for="title" class="required">Title</label>
                                    <input type="text" id="title" name="title" class="form-control mt-3" required>
                                </div>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group mt-3">
                                    <label for="author" class="required">Author</label>
                                    <input type="text" id="author" name="author" class="form-control mt-3" required>
                                </div>
                            </div>
                            <div class="col-md-4 ">
                                <!-- Subcategory -->
                                <div class="form-group mt-3">
                                    <label for="publisher" class="required">Publisher</label>
                                    <input type="text" id="publisher" name="publisher" class="form-control mt-3"
                                        required>
                                </div>
                            </div>
                            <div class="col-md-4 ">
                                <!-- Subcategory -->
                                <div class="form-group mt-3">
                                    <label for="publish_date" class="required">Publish Date</label>
                                    <input type="date" id="publish_date" name="publish_date" class="form-control mt-3"
                                        required>
                                </div>
                            </div>

                        </div>

                        <!-- Long Description -->
                        <div class="form-group mt-3">
                            <label for="short_description" class="mb-3 required">Short Description</label>
                            <textarea id="short_description" name="short_description" class="form-control mt-5" rows="7" required></textarea>
                        </div>

                        <!-- Banner -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mt-3">
                                    <label for="file" class="required">Publication File</label>
                                    <input type="file" id="file" name="file" class="form-control mt-3" required>
                                    <div id="file-preview" class="mt-3">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mt-3">
                                    <label for="image" class="required">Image</label>
                                    <input type="file" id="image" name="image" class="form-control mt-3" required
                                        oninput="pp.src=window.URL.createObjectURL(this.files[0])">
                                    <img id="pp" width="200" class="float-start mt-3" src="">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group mt-3">
                                    <button type="button" id="submit" class="btn btn-primary mt-4">
                                        <span id="spinner-submit" class="spinner-border spinner-border-sm me-2 d-none"
                                            role="status" aria-hidden="true"></span>
                                        <i class="fas fa-upload"></i> Submit
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Button -->
                    </form>
                </div>

            </div>
        </div>
    </div>
@endsection
@push('custom-js')
    <script>
        $(document).ready(function() {
            $('#submit').on('click', function(e) {
                e.preventDefault();
                $('#spinner-submit').removeClass('d-none');
                $(this).prop('disabled', true);
                let url = "{{ route('publication.store') }}";
                let form = $('#publicationForm')[0];
                let formData = new FormData(form);
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
                        $('#spinner-submit').addClass('d-none');
                        $('#submit').prop('disabled', false);
                        var success = response.success;
                        $.each(success, function(key, value) {
                            toastr.success(value); // Displaying each error message
                        });
                        $('#publicationForm')[0].reset();
                        $('#pp').attr('src', '');
                        $('#file-preview').html('');
                    },
                    error: function(xhr) {
                        $('#spinner-submit').addClass('d-none');
                        $('#submit').prop('disabled', false);
                        var errors = xhr.responseJSON.errors;
                        // Iterate through each error and display it
                        $.each(errors, function(key, value) {
                            toastr.error(value); // Displaying each error message
                        });
                    }
                });

            });
        });
        $(document).ready(function() {
            
            var $previewContainer = $('#file-preview');
            // Function to preview a file
            function previewFile(fileUrl, fileType, fileName) {

                $previewContainer.empty();
                if (fileType.startsWith('image/')) {
                    var $img = $('<img>')
                        .attr('src', fileUrl)
                        .css('max-width', '100%')
                        .css('height', '300px');
                    $previewContainer.append($img);
                } else if (fileType === 'application/pdf') {
                    var $iframe = $('<iframe>').attr({
                        src: fileUrl,
                        type: 'application/pdf',
                        width: '100%',
                        height: '400px' // Adjust the height as needed
                    });
                    $previewContainer.append($iframe);
                } else if (fileType === 'application/vnd.openxmlformats-officedocument.wordprocessingml.document' ||
                    fileType === 'application/vnd.openxmlformats-officedocument.presentationml.presentation') {
                    // For DOCX and PPT files, provide a link to open the file in a new tab
                    var $link = $('<a>').attr({
                        href: fileUrl,
                        target: '_blank'
                    }).text('Open file: ' + fileName);
                    $previewContainer.append($link);
                } else {
                    // For other file types, provide a link to open the file in a new tab
                    // var $link = $('<a>').attr({
                    //     href: fileUrl,
                    //     target: '_blank'
                    // }).text('Open file: ' + fileName);
                    // $previewContainer.append($link);
                }
            }
            
            // Set up event listener for file input change
            $('#file').on('change', function() {
                var file = this.files[0];
                if (file) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        var blob = new Blob([e.target.result], {
                            type: file.type
                        });
                        var url = URL.createObjectURL(blob);
                        previewFile(url, file.type, file.name);
                    };
                    reader.readAsArrayBuffer(file);
                }
            });
        });
    </script>
@endpush
