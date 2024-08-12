@extends('admin.layouts.backend-layout')
@section('breadcame')
    File Create
@endsection
@section('admin-content')
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h2 class="mt-5">File Create</h2>
                    <a href="{{ route('file.list') }}" class="btn btn-primary"><span><i class="fas fa-list"></i></span>All
                        File</a>
                </div>
                <div class="card-body">
                    <form action="/submit-form" id="fileForm" method="POST" enctype="multipart/form-data">
                        <div class="row mb-4">
                            <div class="col-md-12">
                                <!-- Member -->
                                <div class="form-group">
                                    <label for="member" class="mb-3 fw-bold">Assign To Member</label>
                                    <select class="form-select form-select-solid" id="member" name="member_ids[]"  data-control="select2" data-placeholder="Select an option" data-allow-clear="true" multiple="multiple">
                                        <option value="">-- Select Member --</option>
                                        @forelse ($members as $member)
                                            <option value="{{ $member->member_id }}">{{ $member->organisation_name }}
                                            </option>
                                        @empty
                                            <option value="">There is No Member</option>
                                        @endforelse
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <!-- Category -->
                                <div class="form-group">
                                    <label for="category" class="required fw-bold">Category</label>
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
                                <!-- Subcategory -->
                                <div class="form-group">
                                    <label for="subcategory" class="">Subcategory</label>
                                    <select id="subcategory" name="subcategory" class="form-control mt-3">
                                        <option value="">-- Select Category First --</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <!-- Title -->
                                <div class="form-group mt-3">
                                    <label for="title" class="required fw-bold">Title</label>
                                    <input type="text" id="title" name="title" class="form-control mt-3" required>
                                </div>
                            </div>

                        </div>

                        <!-- Short Description -->
                        <div class="form-group mt-3">
                            <label for="short_description" class="mb-3 fw-bold">Short Description</label>
                            <textarea id="short_description" name="short_description" class="form-control" rows="4"></textarea>
                        </div>

                        <!-- file -->
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group mt-3">
                                    <label for="file" class="required fw-bold">Attachment</label>
                                    <input type="file" id="file" name="file" class="form-control mt-3">
                                    <div id="file-preview" class="mt-3">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group mt-3">
                                    <input type="hidden" id="creator_type" name="creator_type" value="\App\Models\User">
                                    <button type="" id="submit" class="btn btn-primary mt-4"> <i
                                            class="fas fa-upload"></i>Submit</button>
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
        // CKEDITOR.replace('short_description');
        CKEDITOR.replace('long_description');
        $(document).ready(function() {
            $('#member').select2({
                placeholder: '-- Select Members --',
                allowClear: true
            });

            // Bootstrap 5 compatibility with Select2
            $('.select2-selection').addClass('form-select');
        });
        $(document).ready(function() {
            var categories = @json($categories);
            $('#category').on('change', function() {
                var categoryId = $(this).val();
                var selectedCategory = categories.find(category => category.id == categoryId);
                var subcategories = selectedCategory ? selectedCategory.subcategories : [];

                $('#subcategory').empty().append('<option value="">-- Select Subcategory --</option>');

                subcategories.forEach(function(subcategory) {
                    $('#subcategory').append(
                        `<option value="${subcategory.id}">${subcategory.name}</option>`);
                });
            });
        });

        $(document).ready(function() {

            $('#submit').on('click', function(e) {
                e.preventDefault();
                let url = "{{ route('file.store') }}";
                let formData = new FormData($('#fileForm')[0]);

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
                        var success = response.success;
                        $.each(success, function(key, value) {
                            toastr.success(value); // Displaying each error message
                        });
                        $('#fileForm')[0].reset();
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
        $(document).ready(function() {
            var existingFileUrl =
                "{{ asset('public/frontend/images/files/' . ($file->attachment ?? '')) }}";
            var $previewContainer = $('#file-preview');
            // Function to preview a file
            function previewFile(fileUrl, fileType, fileName) {
                $previewContainer.empty();
                if (fileType.startsWith('image/')) {
                    var $img = $('<img>')
                        .attr('src', fileUrl)
                        .css('max-width', '100%')
                        .css('height', '400px');
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
            // Preview existing file if it exists
            if (existingFileUrl) {
                var existingFileName = "{{ $file->attachment ?? '' }}";
                var fileExtension = existingFileName.split('.').pop().toLowerCase();
                var fileType;
                switch (fileExtension) {
                    case 'jpg':
                    case 'jpeg':
                    case 'png':
                    case 'gif':
                        fileType = 'image/' + fileExtension;
                        break;
                    case 'pdf':
                        fileType = 'application/pdf';
                        break;
                    case 'docx':
                        fileType = 'application/vnd.openxmlformats-officedocument.wordprocessingml.document';
                        break;
                    case 'pptx':
                        fileType = 'application/vnd.openxmlformats-officedocument.presentationml.presentation';
                        break;
                    default:
                        fileType = 'application/octet-stream';
                }
                previewFile(existingFileUrl, fileType, existingFileName);
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
