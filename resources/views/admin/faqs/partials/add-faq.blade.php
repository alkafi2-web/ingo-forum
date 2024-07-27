<form id="faqForm" action="" method="POST" enctype="multipart/form-data">
    <div class="row mb-3">
        <div class="col-md-12">
            <div class="form-group">
                <label for="question" class="text-3xl required">FAQ Question</label>
                <input type="text" class="form-control" id="question" name="question" value="{{ old('question') }}">
            </div>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-12">
            <div class="form-group">
                <label for="answer" class="text-3xl required">FAQ Answer</label>
                <textarea class="form-control" id="answer" name="answer" rows="4">{{ old('answer') }}</textarea>
            </div>
        </div>
    </div>
    <button id="faq-submit" type="submit" class="btn btn-primary mt-3"><i class="fas fa-upload"></i> Submit</button>
    <button id="faq-update" type="submit" class="btn btn-primary mt-3 d-none"> <i
            class="fas fa-wrench"></i>Update</button>
    <button id="page-refresh" type="submit" class="btn btn-secondary mt-3 d-none"><i class="fas fa-sync-alt"></i>
        Refresh</button>
</form>

@push('custom-js')
    <script>
        CKEDITOR.replace('answer');
        $(document).ready(function() {

            $('#faq-submit').on('click', function(e) {
                e.preventDefault();
                let url = "{{ route('faqs.create') }}";
                let formData = new FormData($('#faqForm')[0]);
                let answer = CKEDITOR.instances['answer'].getData();
                formData.append('answer', answer);
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
                        $('#faqForm')[0].reset();
                        var answer = CKEDITOR.instances['answer'];
                        answer.setData('');
                        answer.focus();
                        $('#faq-data').DataTable().ajax.reload(null, false);
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
            $('#faq-update').on('click', function(e) {
                e.preventDefault();
                let url = "{{ route('faqs.update') }}";
                let id = $(this).attr('data-id');
                let formData = new FormData($('#faqForm')[0]);
                let answer = CKEDITOR.instances['answer'].getData();
                formData.append('answer', answer);
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
                        $('#add-header').text('Add FAQ Content');
                        $('#faqForm')[0].reset();
                        var answer = CKEDITOR.instances['answer'];
                        answer.setData('');
                        answer.focus();
                        $('#faq-data').DataTable().ajax.reload(null, false);
                        $('#faq-submit').removeClass('d-none');
                        $('#faq-update').addClass('d-none');
                        $('#page-refresh').addClass('d-none');

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

            // Refresh button click event
            $('#page-refresh').on('click', function(e) {
                e.preventDefault();
                $('#faqForm')[0].reset();
                var answer = CKEDITOR.instances['answer'];
                answer.setData('');
                answer.focus();
                $('#add-header').text('Add FAQ Content');
                $('#faq-submit').removeClass('d-none');
                $('#faq-update').addClass('d-none');
                $('#page-refresh').addClass('d-none');
            });
        });
    </script>
@endpush
