@extends('admin.layouts.backend-layout')
@section('breadcame')
    Publication Update
@endsection
@section('admin-content')
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h2 class="mt-5">Publication Update</h2>
                    <a href="{{ route('publication.list') }}" class="btn btn-primary"><span><i
                                class="fas fa-list"></i></span>All Post</a>
                </div>
                <div class="card-body">
                    <form action="/submit-form" id="publicationForm" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <!-- Category -->
                                <div class="form-group ">
                                    <label for="category" class="required">Category</label>
                                    <select id="category" name="category" class="form-control mt-3" required>
                                        <option value="">-- Select Category --</option>
                                        @forelse ($categories as $category)
                                            <option value="{{ $category->id }}"
                                                {{ $publication->category_id == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
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
                                    <input type="text" id="title" name="title" class="form-control mt-3" required
                                        value="{{ $publication->title }}">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group mt-3">
                                    <label for="author" class="required">Author</label>
                                    <input type="text" id="author" name="author" class="form-control mt-3" required
                                        value="{{ $publication->author }}">
                                </div>
                            </div>
                            <div class="col-md-4 ">
                                <!-- Publisher -->
                                <div class="form-group mt-3">
                                    <label for="publisher" class="required">Publisher</label>
                                    <input type="text" id="publisher" name="publisher" class="form-control mt-3" required
                                        value="{{ $publication->publisher }}">
                                </div>
                            </div>
                            <div class="col-md-4 ">
                                <!-- Publish Date -->
                                <div class="form-group mt-3">
                                    <label for="publish_date" class="required">Publish Date</label>
                                    <input type="date" id="publish_date" name="publish_date" class="form-control mt-3"
                                        required value="{{ $publication->publish_date }}">
                                </div>
                            </div>
                        </div>

                        <!-- Short Description -->
                        <div class="form-group mt-3">
                            <label for="short_description" class="mb-3 required">Short Description</label>
                            <textarea id="short_description" name="short_description" class="form-control mt-5" rows="7" required>{{ $publication->short_description }}</textarea>
                        </div>

                        <!-- Files -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mt-3">
                                    <label for="file" class="required">Publication File</label>
                                    <input type="file" id="file" name="file" class="form-control mt-3">
                                    @if ($publication->file)
                                        <p>Current File: <a
                                                href="{{ asset('public/frontend/files/publication/' . $publication->file) }}"
                                                target="_blank">Open File</a></p>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mt-3">
                                    <label for="image" class="required">Image</label>
                                    <input type="file" id="image" name="image" class="form-control mt-3"
                                        oninput="pp.src=window.URL.createObjectURL(this.files[0])">
                                    @if ($publication->image)
                                        <img id="pp" width="200" class="float-start mt-3"
                                            src="{{ asset('public/frontend/images/publication/' . $publication->image) }}">
                                    @else
                                        <img id="pp" width="200" class="float-start mt-3" src="">
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group mt-3">
                                    <input type="hidden" value="{{$publication->id}}" name="id">
                                    <button type="submit" id="update" class="btn btn-primary mt-4"> <i
                                            class="fas fa-upload"></i>Update</button>
                                </div>
                            </div>
                        </div>
                    </form>

                </div>

            </div>
        </div>
    </div>
@endsection
@push('custom-js')
    <script>
        $(document).ready(function() {
            $('#update').on('click', function(e) {
                e.preventDefault();
                let url = "{{ route('publication.update') }}";
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
