<form id="bannerForm" action="" method="POST" enctype="multipart/form-data">
    <div class="row mb-3">
        <div class="col-md-12">
            <div class="form-group">
                <label for="title" class="text-3xl">Banner Title</label>
                <input type="text" class="form-control" id="title" name="title" value="{{ old('title') }}">
            </div>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-12">
            <div class="form-group">
                <label for="b_des" class="text-3xl">Banner Description</label>
                <input type="text" class="form-control" id="b_des" name="b_des" value="{{ old('b_des') }}">
            </div>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-12">
            <div class="form-group">
                <label for="image" class="text-3xl">Banner Image</label>
                <input type="file" class="form-control" id="image" name="image" value=""
                    oninput="pp.src=window.URL.createObjectURL(this.files[0])" onchange="previewImage(event)">
                <img id="pp" width="100" class="float-start mt-3" src="">
            </div>
        </div>
    </div>
    <button id="banner-submit" type="submit" class="btn btn-primary mt-3">Submit</button>
    <button id="banner-update" type="submit" class="btn btn-primary mt-3 d-none">Update</button>
</form>

@push('custom-js')
    <script>
        $(document).ready(function() {

            $('#banner-submit').on('click', function(e) {
                e.preventDefault();
                let url = "{{ route('banner.create') }}";
                let title = $('#title').val();
                let description = $('#b_des').val();
                let image = $('#image')[0].files[0];
                console.log(image);
                let formData = new FormData(); // Create FormData object

                formData.append('title', title);
                formData.append('description', description);
                formData.append('image', image);
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
                        $('#bannerForm')[0].reset();
                        $('#pp').attr('src', '');
                        $('#banner-data').DataTable().ajax.reload(null, false);
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
