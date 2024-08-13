<form id="eventForm" action="" method="POST" enctype="multipart/form-data">
    <div class="row mb-3">
        <div class="col-md-12">
            <div class="form-group">
                <label for="title" class="text-3xl required">Event Title</label>
                <input type="hidden" name="creator_type" value="\App\Models\User">
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
                <label for="capacity" class="text-3xl">Event Capacity</label>
                <input type="number" class="form-control" id="capacity" name="capacity">{{ old('capacity') }}</input>
            </div>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-12">
            <div class="form-group">
                <label for="location" class="text-3xl required">Event Location</label>
                <input type="text" class="form-control" id="location" name="location">{{ old('location') }}</input>
            </div>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-6">
            <div class="form-group">
                <label for="start_date" class="text-3xl required">Event Start Date</label>
                <input type="datetime-local" class="form-control" id="start_date" name="start_date"
                    value="{{ old('start_date') }}">
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="end_date" class="text-3xl required">Event End Date</label>
                <input type="datetime-local" class="form-control" id="end_date" name="end_date"
                    value="{{ old('end_date') }}">
            </div>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-12">
            <div class="form-group">
                <label>
                    <input type="checkbox" name="check_deadline" id="toggle-deadline" />
                    Enable Registration Deadline
                </label>
            </div>
        </div>
    </div>

    <div class="row mb-3" id="deadline-container" style="display: none;">
        <div class="col-md-12">
            <div class="form-group">
                <label for="deadline_date" class="text-3xl required">Registration Deadline</label>
                <input type="datetime-local" class="form-control" id="deadline_date" name="deadline_date"
                    value="{{ old('deadline_date') }}">
            </div>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-md-12">
            <div class="form-group">
                <label for="image" class="text-3xl required">Event Image</label>
                <input type="file" class="form-control" id="image" name="image" value=""
                    oninput="pp.src=window.URL.createObjectURL(this.files[0])">
                <img id="pp" width="100" class="float-start mt-3" src="">
            </div>
        </div>
    </div>
    <button id="event-submit" type="submit" class="btn btn-primary mt-3">
        <span id="spinner-submit" class="spinner-border spinner-border-sm me-2 d-none" role="status"
            aria-hidden="true"></span>
        <i class="fas fa-upload"></i> Submit
    </button>

    <button id="event-update" type="submit" class="btn btn-primary mt-3 d-none">
        <span id="spinner-update" class="spinner-border spinner-border-sm me-2 d-none" role="status"
            aria-hidden="true"></span>
        <i class="fas fa-wrench"></i> Update
    </button>
    <button id="page-refresh" type="submit" class="btn btn-secondary mt-3 d-none"><i class="fas fa-sync-alt"></i>
        Refresh</button>
</form>

@push('custom-js')
    <script>
        CKEDITOR.replace('des');
        $(document).ready(function() {

            $('#event-submit').on('click', function(e) {
                e.preventDefault();
                $('#spinner-submit').removeClass('d-none'); // Show the spinner
                $(this).prop('disabled', true);
                let url = "{{ route('event.create') }}";
                let formData = new FormData($('#eventForm')[0]);
                let des = CKEDITOR.instances['des'].getData();
                formData.append('des', des);
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
                        $('#spinner-submit').addClass('d-none'); // hide the spinner
                        $('#event-submit').prop('disabled', false);
                        var success = response.success;
                        $.each(success, function(key, value) {
                            toastr.success(value); // Displaying each error message
                        });
                        $('#eventForm')[0].reset();
                        var des = CKEDITOR.instances['des'];
                        des.setData('');
                        des.focus();
                        $('#pp').attr('src', '');
                        $('#deadline-container').hide();
                        $('#event-data').DataTable().ajax.reload(null, false);
                    },
                    error: function(xhr) {
                        $('#spinner-submit').addClass('d-none'); // hide the spinner
                        $('#event-submit').prop('disabled', false);
                        var errors = xhr.responseJSON.errors;
                        // Iterate through each error and display it
                        $.each(errors, function(key, value) {
                            toastr.error(value); // Displaying each error message
                        });
                    }
                });

            });
            $('#event-update').on('click', function(e) {
                e.preventDefault();
                $('#spinner-update').removeClass('d-none'); // Show the spinner
                $(this).prop('disabled', true);
                let url = "{{ route('event.update') }}";
                let id = $(this).attr('data-id');
                let formData = new FormData($('#eventForm')[0]);
                formData.append('id', id);
                let des = CKEDITOR.instances['des'].getData();
                formData.append('des', des);
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
                        $('#spinner-update').addClass('d-none'); // hide the spinner
                        $('#event-update').prop('disabled', false);
                        var success = response.success;
                        $.each(success, function(key, value) {
                            toastr.success(value); // Displaying each error message
                        });
                        $('#add-header').text('Add Event');
                        $('#eventForm')[0].reset();
                        var des = CKEDITOR.instances['des'];
                        des.setData('');
                        des.focus();
                        $('#pp').attr('src', '');
                        $('#event-data').DataTable().ajax.reload(null, false);
                        $('#event-submit').removeClass('d-none');
                        $('#event-update ').addClass('d-none');
                        $('#page-refresh').addClass('d-none');
                    },
                    error: function(xhr) {
                        $('#spinner-update').addClass('d-none'); // hide the spinner
                        $('#event-update').prop('disabled', false);
                        var errors = xhr.responseJSON.errors;
                        // Iterate through each error and display it
                        $.each(errors, function(key, value) {
                            toastr.error(value); // Displaying each error message
                        });
                    }
                });

            });
            $('#page-refresh').on('click', function(e) {
                e.preventDefault();
                $('#add-header').text('Add Event');
                $('#eventForm')[0].reset();
                var des = CKEDITOR.instances['des'];
                des.setData('');
                des.focus();
                $('#pp').attr('src', '');
                $('#event-submit').removeClass('d-none');
                $('#event-update ').addClass('d-none');
                $('#page-refresh').addClass('d-none');
            });
        });
        $(document).ready(function() {
            // When the checkbox is clicked
            $('#toggle-deadline').on('change', function() {
                if ($(this).is(':checked')) {
                    $('#deadline-container').show(); // Show the deadline input
                } else {
                    $('#deadline-container').hide(); // Hide the deadline input
                }
            });

            // Check if the checkbox is already checked on page load
            if ($('#toggle-deadline').is(':checked')) {
                $('#deadline-container').show(); // Show the deadline input
            }
        });
    </script>
@endpush
