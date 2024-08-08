<div class="modal fade" id="joinGuestModal" tabindex="-1" role="dialog" aria-labelledby="joinGuestModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="joinGuestModalLabel">Join as Guest</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group mb-2">
                        <label for="org_name_guest" class="required">Organization Name</label>
                        <input type="text" class="form-control" id="org_name_guest" name="org_name_guest">
                    </div>
                    <div class="form-group mb-2">
                        <label for="rep_name_guest" class="required">Representative Name</label>
                        <input type="text" class="form-control" id="rep_name_guest" name="rep_name_guest">
                    </div>
                    <div class="form-group mb-2">
                        <label for="email_guest" class="required">Email</label>
                        <input type="email" class="form-control" id="email_guest" name="email_guest">
                    </div>
                    <div class="form-group mb-2">
                        <label for="phone_guest" class="required">Phone</label>
                        <input type="text" class="form-control" id="phone_guest" name="phone_guest">
                    </div>
                    <div class="form-group mb-2">
                        <label for="participant_number_guest" class="required">Number of Participants</label>
                        <input type="number" class="form-control" id="participant_number_guest" name="participant_number_guest" min="1">
                    </div>
                    <div id="guest_participant_names"></div>
                    <button type="button" class="btn btn-primary">Join Now</button>
                </form>
            </div>
        </div>
    </div>
</div>
