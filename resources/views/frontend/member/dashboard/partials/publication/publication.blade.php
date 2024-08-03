<div id="publication">
    <ul class="sub-profile-tabs nav nav-pills mb-3" id="pills-tab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="add-publication-tab" data-bs-toggle="pill"
                data-bs-target="#add-publication" type="button" role="tab" aria-controls="add-publication"
                aria-selected="true">Add Publication</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="all-publication-tab" data-bs-toggle="pill"
                data-bs-target="#all-publication" type="button" role="tab" aria-controls="all-publication"
                aria-selected="false" tabindex="-1">All Publication</button>
        </li>
    </ul>
    <div class="tab-content" id="pills-tabContent">
        <div class="tab-pane fade show active" id="add-publication" role="tabpanel"
            aria-labelledby="add-publication-tab" tabindex="0">
            <form action="/submit-form" id="publicationForm" method="POST" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-6">
                        <!-- Category -->
                        <div class="form-group ">
                            <label for="category" class="required form-label">Category</label>
                            <select id="category" name="category" class="form-control" required="">
                                <option value="">-- Select Category --</option>
                                <option value="">There is No Category</option>
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
                            <button type="" id="submit" class="btn btn-primary mt-4"> <i
                                    class="fas fa-upload"></i>Submit</button>
                        </div>
                    </div>
                </div>
                <!-- Submit Button -->
            </form>
        </div>
        <div class="tab-pane fade" id="all-publication" role="tabpanel" aria-labelledby="all-publication-tab"
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