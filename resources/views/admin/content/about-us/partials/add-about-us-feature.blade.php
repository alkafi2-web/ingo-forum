<form id="aboutusfeatureForm" action="" method="POST" enctype="multipart/form-data">
    <div class="row mb-3">
        <div class="col-md-12">
            <div class="form-group">
                <label for="f_icon" class="text-3xl required">Feature Icon</label>
                <input type="file" class="form-control" id="f_icon" name="f_icon" value="{{ old('f_icon') }}" oninput="pp.src=window.URL.createObjectURL(this.files[0])" onchange="previewImage(event)">
                <img id="pp" width="100" class="float-start mt-3" src="">
            </div>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-12">
            <div class="form-group">
                <label for="f_sub_title" class="text-3xl required">Feature Sub Title</label>
                <input type="text" class="form-control" id="f_sub_title" name="f_sub_title" value="{{ old('f_sub_title') }}">
            </div>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-12">
            <div class="form-group">
                <label for="f_title" class="text-3xl required">Feature Title</label>
                <input type="text" class="form-control" id="f_title" name="f_title" value="{{ old('f_title') }}">
            </div>
        </div>
    </div>
    <button id="about-us-feature-submit" type="submit" class="btn btn-primary mt-3">Submit</button>
    <button id="about-us-feature-update" type="submit" class="btn btn-primary mt-3 d-none">Update</button>
</form>
@push('custom-js')
    <script>
        $(document).ready(function() {
            $('#about-us-feature-submit').on('click', function(e) {
                e.preventDefault();
                let url = "{{ route('aboutus.feature.create') }}";
                let subtitle = $('#f_sub_title').val();
                let title = $('#f_title').val();
                let icon = $('#f_icon')[0].files[0];
                let formData = new FormData(); // Create FormData object

                formData.append('title', title);
                formData.append('subtitle', subtitle);
                formData.append('icon', icon);
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
                        $('#aboutusfeatureForm')[0].reset();
                        $('#pp').attr('src', '');
                        $('#about-us-feature-data').DataTable().ajax.reload(null, false);
                        var success = response.success;
                        $.each(success, function(key, value) {
                            toastr.success(value); // Displaying each error message
                        });
                        
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
            $('#about-us-feature-update').on('click', function(e) {
                e.preventDefault();
                let url = "{{ route('feature.update') }}";
                let oldTitle = $(this).attr('data-title');
                let subtitle = $('#f_sub_title').val();
                let title = $('#f_title').val();
                let icon = $('#f_icon')[0].files[0];
                let formData = new FormData(); // Create FormData object

                formData.append('oldTitle', oldTitle);
                formData.append('title', title);
                formData.append('subtitle', subtitle);
                formData.append('icon', icon);
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
                        toastr.success(response.success);
                        $('#feature-header').text('Add About Us Feature');
                        $('#aboutusfeatureForm')[0].reset();
                        $('#pp').attr('src', '');
                        $('#about-us-feature-data').DataTable().ajax.reload(null, false);
                        $('#about-us-feature-submit').removeClass('d-none');
                        $('#about-us-feature-update').addClass('d-none');
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