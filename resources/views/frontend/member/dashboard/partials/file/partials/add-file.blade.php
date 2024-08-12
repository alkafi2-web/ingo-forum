<form action="/submit-form" id="fileForm" method="POST" enctype="multipart/form-data">
    <div class="row">
        <div class="col-md-12">
            <!-- Member -->
            <div class="form-group mt-3">
                <label for="member" class="">Assign To Member</label>
                <select id="member" name="member_ids[]" class="form-control mt-3" multiple required>
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
                <label for="category" class="required">Category</label>
                <select id="category" name="category" class="form-control mt-3" required="">
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
                <label for="title" class="required">Title</label>
                <input type="text" id="title" name="title" class="form-control mt-3"
                    required="">
            </div>
        </div>

    </div>

    <!-- Short Description -->
    <div class="form-group mt-3">
        <label for="short_description" class="mb-3">Short Description</label>
        <textarea id="short_description" name="short_description" class="form-control" rows="4"></textarea>
    </div>

    <!-- file -->
    <div class="row">
        <div class="col-md-12">
            <div class="form-group mt-3">
                <label for="file" id="file_label" class="required">Attachment</label>
                <input type="file" id="file" name="file" class="form-control mt-3">
                <div id="file-preview" class="mt-3">

                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group mt-3">
                <input type="hidden" name="id" id="file_id">
                <input type="hidden" name="creator_type" id="creator_type" value="\App\Models\Member">
                <button type="" id="submit" class="submit-btn mt-4"> <i
                        class="fas fa-save"></i> Submit</button>
                <button type="" id="update" class="submit-btn mt-4 d-none"> <i
                        class="fas fa-update"></i> Update</button>
                <button type="" id="refresh" class="submit-btn mt-4 d-none"> <i
                        class="fas fa-refresh"></i> Refresh</button>
            </div>
        </div>
    </div>
    {{-- <div class="row">
        <div class="col-md-12">
            <div class="form-group mt-3">
                <input type="hidden" id="creator_type" name="creator_type" value="\App\Models\User">
                <button type="" id="submit" class="btn btn-primary mt-4"> <i
                        class="fas fa-upload"></i>Submit</button>
            </div>
        </div>
    </div> --}}
    <!-- Submit Button -->
</form>
@push('custom-js')
    <script>
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

                $('#subcategory').empty().append('<option value="">-- Select Sub Category --</option>');

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
                let form = $('#fileForm')[0];
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
                        console.log(response);
                        var success = response.success;
                        $.each(success, function(key, value) {
                            toastr.success(value); // Displaying each error message
                        });
                        $('#file-list-data').DataTable().ajax.reload(null, false);
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
            $('#update').on('click', function(e) {
                e.preventDefault();
                let url = "{{ route('file.update') }}";
                let form = $('#fileForm')[0];
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
                        // console.log(response);
                        var success = response.success;
                        $.each(success, function(key, value) {
                            // toastr.success(value);
                            Swal.fire('Success!', value,
                                'success');
                        });
                        $('#file-list-data').DataTable().ajax.reload(null, false);
                        $('#submit').removeClass('d-none');

                        // Show the update and refresh buttons
                        $('#update, #refresh').addClass('d-none');
                        $('#fileForm')[0].reset();

                        $('#add-file-tab').removeClass('active');
                        $('.file-btn-text').text('Add File');
                        $('.updatePubIcon').hide();
                        $('.addPubIcon').show();
                        $('#file-preview').html('');

                        $('#add-file').removeClass('show active');
                        $('#all-file-tab').addClass('active');
                        $('#all-file').addClass('show active');
                    },
                    error: function(xhr) {
                        var errors = xhr.responseJSON.errors;
                        // Iterate through each error and display it
                        $.each(errors, function(key, value) {
                            // console.log(key, value);
                            toastr.error(value); // Displaying each error message
                        });
                    }
                });

            });
        });
        $(document).on('click', '.delete', function(e) {
            e.preventDefault(); // Prevent default link behavior

            var id = $(this).attr('data-id');
            var url = "{{ route('file.delete') }}";
            // Show SweetAlert confirmation dialog
            Swal.fire({
                title: 'Are you sure?',
                text: 'This action will delete this file!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'No, cancel!',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    // Send AJAX request
                    // sendAjaxRequest(url, row);

                    sendAjaxReq(id, status = null, url);
                }
            });
        });
        $(document).on('click', '.status', function(e) {
            e.preventDefault(); // Prevent default link behavior

            var id = $(this).attr('data-id'); // Get the URL from the href attribute
            var status = $(this).attr('data-status');
            var url = "{{ route('file.status') }}";
            // Show SweetAlert confirmation dialog
            Swal.fire({
                title: 'Are you sure?',
                text: 'This action will change status of this file!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, Change it!',
                cancelButtonText: 'No, cancel!',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    // Send AJAX request
                    // sendAjaxRequest(url, row);

                    sendAjaxReq(id, status, url);
                }
            });
        });

        function sendAjaxReq(id, status, url) {
            var requestData = {
                id: id,
                // Optionally include status if it's provided
            };

            // Check if status is defined and not null
            if (typeof status !== 'undefined' && status !== null) {
                requestData.status = status;
            }
            $.ajax({
                url: url,
                type: 'POST', // or 'GET' depending on your server endpoint
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: requestData, // You can send additional data if needed
                success: function(response) {

                    $('#file-list-data').DataTable().ajax.reload(null, false);
                    Swal.fire('Success!', response.success,
                        'success');
                    // toastr.success(response.success);
                },
                error: function(xhr, status, error) {
                    // Handle AJAX error
                    Swal.fire('Error!', 'An error occurred.', 'error');
                }
            });
        }
        $(document).on('click', '#refresh', function(e) {
            e.preventDefault(); // Prevent default link behavior
            $('#submit').removeClass('d-none');

            // Show the update and refresh buttons
            $('#update, #refresh').addClass('d-none');
            $('#fileForm')[0].reset();
            $('#add-file-tab').removeClass('active');
            $('.file-btn-text').text('Add File');
            $('.updatePubIcon').hide();
            $('.addPubIcon').show();
            $('#file-preview').html('');
            $('#add-file').removeClass('show active');
            $('#all-file-tab').addClass('active');
            $('#all-file').addClass('show active');

        });

        $(document).ready(function() {
            
            var $previewContainer = $('#file-preview');
            // Function to preview a file
            function previewFile(fileUrl, fileType, fileName) {
                $previewContainer.empty();
                if (fileType.startsWith('image/')) {
                    var $img = $('<img>').attr('src', fileUrl).css('max-width', '100%');
                    $previewContainer.append($img);
                } else if (fileType === 'application/pdf') {
                    var $iframe = $('<iframe>').attr({
                        src: fileUrl,
                        type: 'application/pdf',
                        width: '100%',
                        height: '300px' // Adjust the height as needed
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