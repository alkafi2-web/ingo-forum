<div>
    <ul class="sub-profile-tabs nav nav-pills mb-3" id="pills-tab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="add-event-tab" data-bs-toggle="pill" data-bs-target="#add-event"
                type="button" role="tab" aria-controls="add-event" aria-selected="true">Add Event</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="all-event-tab" data-bs-toggle="pill" data-bs-target="#all-event"
                type="button" role="tab" aria-controls="all-event" aria-selected="false" tabindex="-1">All
                Event</button>
        </li>
    </ul>
    <div class="tab-content" id="pills-tabContent">
        <div class="tab-pane fade show active" id="add-event" role="tabpanel" aria-labelledby="add-event-tab"
            tabindex="0">
            <form id="eventForm" action="" method="POST" enctype="multipart/form-data">
                <div class="row mb-3">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="title" class="text-3xl form-label required">Event Title</label>
                            <input type="text" class="form-control" id="title" name="title" value=""
                                spellcheck="false" data-ms-editor="true">
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="des" class="text-3xl form-label required">Event Description</label>
                            <textarea class="form-control" id="des" name="des" rows="4" spellcheck="false"
                                data-ms-editor="true"></textarea>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="location" class="text-3xl form-label required">Event Location</label>
                            <textarea class="form-control" id="location" name="location" rows="2" spellcheck="false"
                                data-ms-editor="true"></textarea>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="start_date" class="text-3xl form-label required">Event Start Date</label>
                            <input type="datetime-local" class="form-control" id="start_date" name="start_date"
                                value="">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="end_date" class="text-3xl form-label required">Event End Date</label>
                            <input type="datetime-local" class="form-control" id="end_date" name="end_date"
                                value="">
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="deadline_date" class="text-3xl form-label required">Registrtaion
                                Deadline</label>
                            <input type="datetime-local" class="form-control" id="deadline_date"
                                name="deadline_date" value="">
                        </div>
                    </div>

                </div>
                <div class="row mb-3">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="image" class="text-3xl form-label required">Event Image</label>
                            <input type="file" class="form-control" id="image" name="image" value=""
                                oninput="pp.src=window.URL.createObjectURL(this.files[0])"
                                onchange="previewImage(event)">
                            <img id="pp" width="100" class="float-start mt-3" src="">
                        </div>
                    </div>
                </div>
                <button id="event-submit" type="submit" class="btn btn-primary mt-3"> <i
                        class="fas fa-upload"></i>Submit</button>
                <button id="event-update" type="submit" class="btn btn-primary mt-3 d-none"><i
                        class="fas fa-wrench"></i>
                    Update</button>
                <button id="page-refresh" type="submit" class="btn btn-secondary mt-3 d-none"><i
                        class="fas fa-sync-alt"></i>
                    Refresh</button>
            </form>
        </div>
        <div class="tab-pane fade" id="all-event" role="tabpanel" aria-labelledby="all-event-tab" tabindex="0">
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