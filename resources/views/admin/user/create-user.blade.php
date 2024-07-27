@extends('admin.layouts.backend-layout')
@section('breadcame')
    Create User
@endsection
@section('admin-content')
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h2 class="pt-5">User List</h2>
                </div>
                <div class="card-body">
                    @include('admin.user.datatables.user-list-datatable')
                </div>
            </div>
            <div class="card mt-4">
                <div class="card-header">
                    <h2 class="pt-5">Deleted User List</h2>
                </div>
                <div class="card-body">
                    @include('admin.user.datatables.delete-user-list-datatable')
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h2 class="pt-5 " id="add-header">Add User</h2>
                </div>
                <div class="card-body">
                    @include('admin.user.partials.add-user')
                </div>
            </div>
        </div>
    </div>
    @push('custom-js')
    <script>
        $(document).ready(function() {

            $('#sign_up_submit').on('click', function(e) {
                e.preventDefault();
                let url = "{{ route('register') }}";
                let form = $('#sign_up_form')[0];
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
                        var success = response.success;
                        $.each(success, function(key, value) {
                            toastr.success(value); // Displaying each error message
                        });
                        $('#sign_up_form')[0].reset();
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
@endsection


