<div>
    <form action="/submit-form" id="postForm" method="POST" enctype="multipart/form-data">
        <div class="row">
            <div class="col-md-6">
                <!-- Category -->
                <div class="form-group">
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
                <!-- Subcategory -->
                <div class="form-group">
                    <label for="subcategory" class="required form-label">Subcategory</label>
                    <select id="subcategory" name="subcategory" class="form-control" required="">
                        <option value="">-- Select Category First --</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <!-- Title -->
                <div class="form-group mt-3">
                    <label for="title" class="required form-label">Title</label>
                    <input type="text" id="title" name="title" class="form-control" required=""
                        spellcheck="false" data-ms-editor="true">
                </div>
            </div>
            {{-- <div class="col-md-6">
                <div class="form-group mt-3">
                    <label for="slug" class="required form-label">Slug</label>
                    <input type="text" id="slug" name="slug" class="form-control" required=""
                        spellcheck="false" data-ms-editor="true">
                </div>
            </div> --}}
        </div>
        <!-- Long Description -->
        <style>
            #cke_long_description {
                margin-top: -222px !important;
            }
        </style>
        <div class="form-group mt-3">
            <label for="long_description" class="required form-label">Details</label>
            <textarea id="long_description" name="long_description" class="form-control mt-5" rows="7"></textarea>
        </div>
        <!-- Banner -->
        <div class="row">
            <div class="col-md-12">
                <div class="form-group mt-3">
                    <label for="banner" class="required form-label">Banner</label>
                    <input type="file" id="banner" name="banner" class="form-control" required=""
                        oninput="pp.src=window.URL.createObjectURL(this.files[0])">
                    <p class="text-danger">Banner must be 800px by 450px</p>
                    <img id="pp" width="200" class="float-start mt-3" src="">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group mt-3">
                    <input type="hidden" name="id" id="post_id">
                    <input type="hidden" name="type" id="add_type" value="member">
                    <button type="submit" id="submit" class="submit-btn mt-4">
                        <i class="fas fa-save"></i> Submit
                        <span id="submit-spinner" class="spinner-border spinner-border-sm ms-2 d-none" role="status" aria-hidden="true"></span>
                    </button>
                    <button type="submit" id="update" class="submit-btn mt-4 d-none">
                        <i class="fas fa-update"></i> Update
                        <span id="update-spinner" class="spinner-border spinner-border-sm ms-2 d-none" role="status" aria-hidden="true"></span>
                    </button>
                    <button type="" id="refresh" class="submit-btn mt-4 d-none"> <i class="fas fa-refresh"></i>
                        Refresh</button>
                </div>
            </div>
        </div>
        <!-- Submit Button -->
    </form>
</div>

