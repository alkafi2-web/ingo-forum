<form id="eventForm" action="" method="POST" enctype="multipart/form-data">
    <div class="row mb-3">
        <div class="col-md-12">
            <div class="form-group">
                <label for="title" class="text-3xl required">Event Title</label>
                <input type="text" class="form-control" id="title" name="title" value="{{ old('title') }}">
            </div>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-12">
            <div class="form-group">
                <label for="des" class="text-3xl required">Event Description</label>
                <textarea class="form-control" id="des" name="des" rows="4">{{ old('des') }}</textarea>
            </div>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-12">
            <div class="form-group">
                <label for="location" class="text-3xl required">Event Location</label>
                <textarea class="form-control" id="location" name="location" rows="2">{{ old('location') }}</textarea>
            </div>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-6">
            <div class="form-group">
                <label for="start_date" class="text-3xl required">Event Start Date</label>
                <input type="datetime-local" class="form-control" id="start_date" name="start_date" value="{{ old('start_date') }}">
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="end_date" class="text-3xl required">Event End Date</label>
                <input type="datetime-local" class="form-control" id="end_date" name="end_date" value="{{ old('end_date') }}">
            </div>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-12">
            <div class="form-group">
                <label for="deadline_date" class="text-3xl required">Registrtaion Deadline</label>
                <input type="datetime-local" class="form-control" id="deadline_date" name="deadline_date" value="{{ old('deadline_date') }}">
            </div>
        </div>
        {{-- <div class="col-md-6">
            <div class="form-group">
                <label for="reg_fee" class="text-3xl">Registration Fee</label>
                <input type="text" class="form-control" id="reg_fee" name="reg_fee" value="{{ old('reg_fee') }}">
            </div>
        </div> --}}
    </div>
    <div class="row mb-3">
        <div class="col-md-12">
            <div class="form-group">
                <label for="image" class="text-3xl required">Event Image</label>
                <input type="file" class="form-control" id="image" name="image" value=""
                    oninput="pp.src=window.URL.createObjectURL(this.files[0])" onchange="previewImage(event)">
                <img id="pp" width="100" class="float-start mt-3" src="">
            </div>
        </div>
    </div>
    <button id="event-submit" type="submit" class="btn btn-primary mt-3">Submit</button>
    <button id="event-update" type="submit" class="btn btn-primary mt-3 d-none">Update</button>
</form>

@push('custom-js')
    <script>
        $(document).ready(function() {

            $('#event-submit').on('click', function(e) {
                e.preventDefault();
                let url = "{{ route('event.create') }}";
                let formData = new FormData($('#eventForm')[0]);
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
                        $('#eventForm')[0].reset();
                        $('#pp').attr('src', '');
                        $('#event-data').DataTable().ajax.reload(null, false);
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
            $('#event-update').on('click', function(e) {
                e.preventDefault();
                let url = "{{ route('event.update') }}";
                let id = $(this).attr('data-id');
                let formData = new FormData($('#eventForm')[0]);
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
                        console.log(response);
                        var success = response.success;
                        $.each(success, function(key, value) {
                            toastr.success(value); // Displaying each error message
                        });
                        $('#add-header').text('Add Event');
                        $('#eventForm')[0].reset();
                        $('#pp').attr('src', '');
                        $('#event-data').DataTable().ajax.reload(null, false);
                        $('#event-submit').removeClass('d-none');
                        $('#event-update ').addClass('d-none');
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
