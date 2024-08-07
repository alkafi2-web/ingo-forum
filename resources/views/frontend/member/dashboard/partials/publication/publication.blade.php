<div id="publication">
    <ul class="sub-profile-tabs nav nav-pills mb-3" id="pills-tab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="all-publication-tab" data-bs-toggle="pill" data-bs-target="#all-publication"
                type="button" role="tab" aria-controls="all-publication" aria-selected="false" tabindex="-1">All
                Publication</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link " id="add-publication-tab" data-bs-toggle="pill" data-bs-target="#add-publication"
                type="button" role="tab" aria-controls="add-publication" aria-selected="true">Add
                Publication</button>
        </li>
    </ul>
    <div class="tab-content" id="pills-tabContent">

        <div class="tab-pane fade show active" id="all-publication" role="tabpanel"
            aria-labelledby="all-publication-tab" tabindex="0">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">First</th>
                        <th scope="col">Last</th>
                        <th scope="col">Handle</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th scope="row">1</th>
                        <td>Mark</td>
                        <td>Otto</td>
                        <td>@mdo</td>
                    </tr>
                    <tr>
                        <th scope="row">2</th>
                        <td>Jacob</td>
                        <td>Thornton</td>
                        <td>@fat</td>
                    </tr>
                    <tr>
                        <th scope="row">3</th>
                        <td colspan="2">Larry the Bird</td>
                        <td>@twitter</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="tab-pane fade " id="add-publication" role="tabpanel" aria-labelledby="add-publication-tab"
            tabindex="0">
            <form action="/submit-form" id="publicationForm" method="POST" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-6">
                        <!-- Category -->
                        <div class="form-group ">
                            <label for="category" class="required form-label">Category</label>
                            <select id="category" name="category" class="form-control" required="">
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
                            <label for="title" class="required form-label">Title</label>
                            <input type="text" id="title" name="title" class="form-control" required=""
                                spellcheck="false" data-ms-editor="true">
                        </div>
                    </div>

                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group mt-3">
                            <label for="author" class="required form-label">Author</label>
                            <input type="text" id="author" name="author" class="form-control" required=""
                                spellcheck="false" data-ms-editor="true">
                        </div>
                    </div>
                    <div class="col-md-4 ">
                        <!-- Subcategory -->
                        <div class="form-group mt-3">
                            <label for="publisher" class="required form-label">Publisher</label>
                            <input type="text" id="publisher" name="publisher" class="form-control" required=""
                                spellcheck="false" data-ms-editor="true">
                        </div>
                    </div>
                    <div class="col-md-4 ">
                        <!-- Subcategory -->
                        <div class="form-group mt-3">
                            <label for="publish_date" class="required form-label">Publish Date</label>
                            <input type="date" id="publish_date" name="publish_date" class="form-control"
                                required="">
                        </div>
                    </div>

                </div>

                <!-- Long Description -->
                <div class="form-group mt-3">
                    <label for="short_description" class="mb-3 required form-label">Short Description</label>
                    <textarea id="short_description" name="short_description" class="form-control " rows="7" required=""
                        spellcheck="false" data-ms-editor="true"></textarea>
                </div>

                <!-- Banner -->
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mt-3">
                            <label for="file" class="required form-label">Publication File</label>
                            <input type="file" id="file" name="file" class="form-control"
                                required="">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mt-3">
                            <label for="image" class="required form-label">Image</label>
                            <input type="file" id="image" name="image" class="form-control" required=""
                                oninput="pp.src=window.URL.createObjectURL(this.files[0])">
                            <img id="pp" width="200" class="float-start" src="">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group mt-3">
                            <input type="hidden" name="id" id="publication_id">
                            <input type="hidden" name="add_type" id="add_type" value="member">
                            <button type="" id="submit" class="submit-btn mt-4"> <i
                                    class="fas fa-save"></i> Submit</button>
                            <button type="" id="update" class="submit-btn mt-4 d-none"> <i
                                    class="fas fa-update"></i> Update</button>
                            <button type="" id="refresh" class="submit-btn mt-4 d-none"> <i
                                    class="fas fa-refresh"></i> Refresh</button>
                        </div>
                    </div>
                </div>
                <!-- Submit Button -->
            </form>
        </div>
    </div>
</div>

@push('custom-js')
    <script>
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
    </script>
@endpush
