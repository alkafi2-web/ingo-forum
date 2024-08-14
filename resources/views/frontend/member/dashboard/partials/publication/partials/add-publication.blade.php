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
                <input type="text" id="publisher" name="publisher" class="form-control"
                    required="" spellcheck="false" data-ms-editor="true">
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
                <label for="file" id="file_label" class="required form-label">Publication
                    File</label>
                <input type="file" id="file" name="file" class="form-control"
                    required="">
                <!-- Container to display the file preview -->
                <div id="file-preview" class="mt-3">

                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group mt-3">
                <label for="image" id="image_label" class="required form-label">Image</label>
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
                <button type="submit" id="submit" class="submit-btn mt-4">
                    <i class="fas fa-save"></i> Submit
                    <span id="submit-spinner" class="spinner-border spinner-border-sm ms-2 d-none" role="status" aria-hidden="true"></span>
                </button>
                <button type="submit" id="update" class="submit-btn mt-4 d-none">
                    <i class="fas fa-update"></i> Update
                    <span id="update-spinner" class="spinner-border spinner-border-sm ms-2 d-none" role="status" aria-hidden="true"></span>
                </button>
                <button type="" id="refresh" class="submit-btn mt-4 d-none"> <i
                        class="fas fa-refresh"></i> Refresh</button>
            </div>
        </div>
    </div>
    <!-- Submit Button -->
</form>