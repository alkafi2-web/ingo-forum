@extends('admin.layouts.backend-layout')
@section('breadcame')
    Post Update
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
                    <h2 class="mt-5">Post Update</h2>
                    <a href="{{ route('post.list') }}" class="btn btn-primary"><span><i class="fas fa-list"></i></span>All
                        Post</a>
                </div>
                <div class="card-body">
                    <form action="/submit-form" id="postUpdateForm" method="POST" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-6">
                                <!-- Category -->
                                <div class="form-group">
                                    <label for="category">Category</label>
                                    <select id="category" name="category" class="form-control mt-3" required>
                                        <option value="">-- Select Category --</option>
                                        @forelse ($categories as $category)
                                            <option value="{{ $category->id }}"
                                                {{ $post->category_id == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}</option>
                                        @empty
                                            <option value="">There is No Category</option>
                                        @endforelse
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <!-- Subcategory -->
                                <div class="form-group">
                                    <label for="subcategory">Subcategory</label>
                                    <select id="subcategory" name="subcategory" class="form-control mt-3" required>
                                        <option value="">-- Select Subcategory --</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <!-- Title -->
                                <div class="form-group mt-3">
                                    <label for="title">Title</label>
                                    <input type="text" id="title" name="title" class="form-control mt-3" required
                                        value="{{ $post->title }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mt-3">
                                    <label for="slug">Slug</label>
                                    <input type="text" id="slug" name="slug" class="form-control mt-3" required
                                        value="{{ $post->slug }}">
                                </div>
                            </div>
                        </div>



                        <!-- Short Description -->
                        {{-- <div class="form-group mt-3">
                            <label for="short_description" class="mb-3">Short Description</label>
                            <textarea id="short_description" name="short_description" class="form-control mt-5" rows="1" required>{{ $post->short_des ?? '' }}</textarea>
                        </div> --}}

                        <!-- Long Description -->
                        <div class="form-group mt-3">
                            <label for="long_description" class="mb-3">Long Description</label>
                            <textarea id="long_description" name="long_description" class="form-control mt-5" rows="7" required>{{ $post->long_des ?? '' }}</textarea>
                        </div>

                        <!-- Banner -->
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group mt-3">
                                    <label for="banner" class="">Banner</label>
                                    <input type="file" id="banner" name="banner" class="form-control mt-3" required
                                        oninput="pp.src=window.URL.createObjectURL(this.files[0])">
                                    <p class="text-danger">Banner must be 800px by 450px</p>
                                    <img id="pp" width="200" class="float-start mt-3"
                                        src="{{ asset('/public/frontend/images/posts/') }}/{{ $post->banner }}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group mt-3">
                                    <input type="hidden" id="id" name="id" value="{{ $post->id }}">
                                    <button type="submit" id="update" class="btn btn-primary mt-4">
                                        <span id="spinner-update" class="spinner-border spinner-border-sm d-none"
                                            role="status" aria-hidden="true"></span>
                                        <i class="fas fa-wrench"></i> Update
                                    </button>
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
        // Initialize CKEditor on the textareas
        CKEDITOR.replace('short_description');
        CKEDITOR.replace('long_description');
        $(document).ready(function() {
            var categories = @json($categories);
            var postId = '{{ $post->id }}';
            var selectedCategoryId = '{{ $post->category_id }}';
            var selectedSubcategoryId = '{{ $post->sub_category_id }}';

            $('#category').on('change', function() {
                var categoryId = $(this).val();
                var subcategories = [];

                if (categoryId) {
                    subcategories = categories.find(category => category.id == categoryId).subcategories;
                }

                $('#subcategory').empty().append('<option value="">-- Select Subcategory --</option>');

                subcategories.forEach(function(subcategory) {
                    var selected = (subcategory.id == selectedSubcategoryId) ? 'selected' : '';
                    $('#subcategory').append(
                        `<option value="${subcategory.id}" ${selected}>${subcategory.name}</option>`
                    );
                });
            });

            // Trigger change event on page load to populate subcategories based on selected category
            $('#category').val(selectedCategoryId).trigger('change');
        });

        $(document).ready(function() {

            $('#update').on('click', function(e) {
                e.preventDefault();
                $('#spinner-update').removeClass('d-none');
                $(this).prop('disabled', true);
                
                let url = "{{ route('post.update') }}";
                let id = $('#id').val();
                let category = $('#category').val();
                let subcategory = $('#subcategory').val();
                let title = $('#title').val();
                let slug = $('#slug').val();
                let long_description = CKEDITOR.instances['long_description'].getData();
                // let short_description = CKEDITOR.instances['short_description'].getData();
                let banner = $('#banner')[0].files[0];
                let formData = new FormData(); // Create FormData object

                // Append form data to FormData object
                formData.append('category', category);
                formData.append('subcategory', subcategory);
                formData.append('title', title);
                formData.append('slug', slug);
                formData.append('long_description', long_description);
                // formData.append('short_description', short_description);
                if (banner) {
                    formData.append('banner', banner);
                }
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
                        $('#spinner-update').addClass('d-none');
                        $('#update').prop('disabled', false);
                        var success = response.success;
                        $.each(success, function(key, value) {
                            toastr.success(value); // Displaying each error message
                        });
                    },
                    error: function(xhr) {
                        $('#spinner-update').addClass('d-none');
                        $('#update').prop('disabled', false);
                        var errors = xhr.responseJSON.errors;
                        // Iterate through each error and display it
                        $.each(errors, function(key, value) {
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
                    .replace(/[^a-zA-Z0-9-ঀ-৿]/g, ''); // Allow alphanumeric, hyphens, and Bangla characters

                $('#slug').val(slug);
            });
        });
    </script>
@endpush
