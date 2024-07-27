<form id="aboutusForm" action="" method="POST" enctype="multipart/form-data">
    <div class="row mb-3">
        <div class="col-md-12">
            <div class="form-group">
                <label for="title" class="text-3xl required">About Us Title</label>
                <input type="text" class="form-control" id="title" name="title" value="{{ old('title') }}">
            </div>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-12">
            <div class="form-group">
                <label for="slogan" class="text-3xl required">About Us Slogan</label>
                <input type="text" class="form-control" id="slogan" name="slogan" value="{{ old('slogan') }}">
            </div>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-12">
            <div class="form-group">
                <label for="ab_des" class="text-3xl required">About Us Description</label>
                <textarea class="form-control" id="ab_des" name="ab_des">{{ old('ab_des') }}</textarea>
            </div>
        </div>
    </div>
    <button id="about-us-submit" type="submit" class="btn btn-primary mt-3"> <i class="fas fa-upload"></i>Submit</button>
    <button id="about-us-update" type="submit" class="btn btn-primary mt-3 d-none"> <i class="fas fa-wrench"></i>Update</button>
    
</form>
@push('custom-js')
    <script>
        CKEDITOR.replace('ab_des');
        $(document).ready(function() {
            $('#about-us-submit').on('click', function(e) {
                e.preventDefault();
                let url = "{{ route('aboutus.create') }}";
                let title = $('#title').val();
                let slogan = $('#slogan').val();
                // let description = $('#ab_des').val();
                let formData = new FormData(); // Create FormData object
                let description = CKEDITOR.instances['ab_des'].getData();
                formData.append('description', description);
                formData.append('title', title);
                formData.append('slogan', slogan);
                formData.append('description', description);
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
                        $('#aboutusForm')[0].reset();
                        $('#about-us-data').DataTable().ajax.reload(null, false);
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
            $('#banner-update').on('click', function(e) {
                e.preventDefault();
                let url = "{{ route('banner.update') }}";
                let id = $(this).attr('data-id');
                let title = $('#title').val();
                let description = $('#b_des').val();
                let image = $('#image')[0].files[0];
                console.log(image);
                let formData = new FormData(); // Create FormData object

                formData.append('title', title);
                formData.append('description', description);
                formData.append('image', image);
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
                        $('#bannerForm')[0].reset();
                        $('#pp').attr('src', '');
                        $('#banner-data').DataTable().ajax.reload(null, false);
                        $('#banner-submit').removeClass('d-none');
                        $('#banner-update ').addClass('d-none');
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