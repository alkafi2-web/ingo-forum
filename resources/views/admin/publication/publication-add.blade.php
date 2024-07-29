@extends('admin.layouts.backend-layout')
@section('breadcame')
    Publication Add
@endsection
@section('admin-content')
    <style>
        .custom-select {
            font-family: 'Arial', sans-serif;
            font-size: 16px;
            padding: 10px;
            border-radius: 4px;
            background-color: #f8f9fa;
            border: 1px solid #ced4da;
        }

        .custom-select option {
            background-color: #f8f9fa;
            color: #495057;
            padding: 10px;
        }

        .custom-select option:hover {
            background-color: #e9ecef;
        }
    </style>
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h2 class="mt-5">Publication Add</h2>
                    <a href="{{ route('post.list') }}" class="btn btn-primary"><span><i class="fas fa-list"></i></span>All
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
                            <div class="col-md-6">
                                <div class="form-group mt-3">
                                    <label for="author" class="required">Author</label>
                                    <input type="text" id="author" name="author" class="form-control mt-3" required>
                                </div>
                            </div>
                            <div class="col-md-6 ">
                                <!-- Subcategory -->
                                <div class="form-group mt-3">
                                    <label for="publisher" class="required">Publisher</label>
                                    <input type="text" id="publisher" name="publisher" class="form-control mt-3"
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
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mt-3">
                                    <label for="image" class="required">Image</label>
                                    <input type="file" id="image" name="image" class="form-control mt-3" required
                                        oninput="pp.src=window.URL.createObjectURL(this.files[0])">
                                    <p class="text-danger">Banner must be 800px by 450px</p>
                                    <img id="pp" width="200" class="float-start mt-3" src="">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group mt-3">
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
        // CKEDITOR.replace('long_description');


        $(document).ready(function() {

            $('#submit').on('click', function(e) {
                e.preventDefault();
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
                        console.log(response);
                        var success = response.success;
                        $.each(success, function(key, value) {
                            toastr.success(value); // Displaying each error message
                        });
                        $('#publicationForm')[0].reset();
                        $('#pp').attr('src', '');
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
            $('#title').on('input', function() {
                var title = $(this).val();
                var slug = title.toLowerCase()
                    .replace(/\s+/g, '-') // Replace spaces with hyphens
                    .replace(/[^a-zA-Z0-9-ঀ-৿]/g, '') // Allow alphanumeric, hyphens, and Bangla characters
                    .replace(/-+/g, '-'); // Replace multiple hyphens with a single hyphen

                $('#slug').val(slug);
            });
        });
    </script>
@endpush
