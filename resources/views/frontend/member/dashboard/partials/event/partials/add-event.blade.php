<form id="eventForm" action="" method="POST" enctype="multipart/form-data">
    <div class="row mb-3">
        <div class="col-md-12">
            <div class="form-group">
                <label for="title" class="text-3xl required">Event Title</label>
                <input type="hidden" name="creator_type" value="\App\Models\Member">
                <input type="text" class="form-control" id="title" name="title" value="">
            </div>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-md-12">
            <div class="form-group">
                <label for="des" class="text-3xl required">Event Description</label>
                <textarea name="des" id="des" cols="30" rows="10"></textarea>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="capacity" class="text-3xl">Event Capacity</label>
                    <input type="number" class="form-control" id="capacity" name="capacity">
                </div>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="location" class="text-3xl required">Event Location</label>
                    <input type="text" class="form-control" id="location" name="location">
                </div>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="start_date" class="text-3xl required">Event Start Date</label>
                    <input type="datetime-local" class="form-control" id="start_date" name="start_date" value="">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="end_date" class="text-3xl required">Event End Date</label>
                    <input type="datetime-local" class="form-control" id="end_date" name="end_date" value="">
                </div>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-12">
                <div class="form-group">
                    <label>
                        <input type="checkbox" name="check_deadline" id="toggle-deadline">
                        Enable Registration Deadline
                    </label>
                </div>
            </div>
        </div>

        <div class="row mb-3" id="deadline-container" style="display:none;">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="deadline_date" class="text-3xl required">Registration Deadline</label>
                    <input type="datetime-local" class="form-control" id="deadline_date" name="deadline_date"
                        value="">
                </div>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="image" class="text-3xl required">Event Image</label>
                    <input type="file" class="form-control" id="image" name="image" value=""
                        oninput="pp.src=window.URL.createObjectURL(this.files[0])">
                    <img id="pp" width="100" class="float-start mt-3" src="">
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="form-group mt-3">
                    <input type="hidden" name="id" id="event_id">
                    <input type="hidden" name="type" id="add_type" value="member">
                    <button type="submit" id="submit" class="submit-btn mt-4">
                        <i class="fas fa-save"></i> Submit
                        <span id="submit-spinner" class="spinner-border spinner-border-sm ms-2 d-none" role="status"
                            aria-hidden="true"></span>
                    </button>
                    <button type="submit" id="update" class="submit-btn mt-4 d-none">
                        <i class="fas fa-update"></i> Update
                        <span id="update-spinner" class="spinner-border spinner-border-sm ms-2 d-none" role="status"
                            aria-hidden="true"></span>
                    </button>
                    <button type="" id="refresh" class="submit-btn mt-4 d-none"> <i
                            class="fas fa-refresh"></i> Refresh</button>
                </div>
            </div>
        </div>
</form>

