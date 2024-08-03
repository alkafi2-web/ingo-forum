<div id="blog-news">
    <ul class="sub-profile-tabs nav nav-pills mb-3" id="pills-tab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="add-blog-news-tab" data-bs-toggle="pill"
                data-bs-target="#add-blog-news" type="button" role="tab" aria-controls="add-blog-news"
                aria-selected="true">Add Blog/News</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="all-blog-news-tab" data-bs-toggle="pill" data-bs-target="#all-blog-news"
                type="button" role="tab" aria-controls="all-blog-news" aria-selected="false"
                tabindex="-1">All Blog/News</button>
        </li>
    </ul>
    <div class="tab-content" id="pills-tabContent">
        <div class="tab-pane fade show active" id="add-blog-news" role="tabpanel"
            aria-labelledby="add-blog-news-tab" tabindex="0">
            <div>
                <form action="/submit-form" id="postForm" method="POST" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-6">
                            <!-- Category -->
                            <div class="form-group">
                                <label for="category" class="required form-label">Category</label>
                                <select id="category" name="category" class="form-control" required="">
                                    <option value="">-- Select Category --</option>
                                    <option value="1">News</option>
                                    <option value="2">Blog</option>
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
                        <div class="col-md-6">
                            <!-- Title -->
                            <div class="form-group mt-3">
                                <label for="title" class="required form-label">Title</label>
                                <input type="text" id="title" name="title" class="form-control"
                                    required="" spellcheck="false" data-ms-editor="true">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mt-3">
                                <label for="slug" class="required form-label">Slug</label>
                                <input type="text" id="slug" name="slug" class="form-control"
                                    required="" spellcheck="false" data-ms-editor="true">
                            </div>
                        </div>
                    </div>
                    <!-- Long Description -->
                    <div class="form-group mt-3">
                        <textarea id="long_description" name="long_description" class="form-control mt-5" rows="7"></textarea>
                    </div>
                    <!-- Banner -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group mt-3">
                                <label for="banner" class="required form-label">Banner</label>
                                <input type="file" id="banner" name="banner" class="form-control"
                                    required="" oninput="pp.src=window.URL.createObjectURL(this.files[0])">
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
        <div class="tab-pane fade" id="all-blog-news" role="tabpanel" aria-labelledby="all-blog-news-tab"
            tabindex="0">
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
    </div>
</div>