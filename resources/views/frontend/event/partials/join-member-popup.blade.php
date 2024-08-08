<div class="modal fade" id="joinMemberModal" tabindex="-1" role="dialog" aria-labelledby="joinMemberModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="joinMemberModalLabel">Join as Member</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group mb-2">
                        <label for="rep_name_member">Representative Name</label>
                        <input type="text" class="form-control" id="rep_name_member" name="rep_name_member">
                    </div>
                    <div class="form-group mb-2">
                        <label for="email_member">Email</label>
                        <input type="email" class="form-control" id="email_member" name="email_member">
                    </div>
                    <div class="form-group mb-2">
                        <label for="phone_member">Phone</label>
                        <input type="text" class="form-control" id="phone_member" name="phone_member">
                    </div>
                    <div class="form-group mb-2">
                        <label for="participant_number_member">Number of Participants</label>
                        <input type="number" class="form-control" id="participant_number_member" name="participant_number_member" min="1">
                    </div>
                    <div id="member_participant_names"></div>
                    <button type="button" class="btn btn-primary">Join Now</button>
                </form>
            </div>
        </div>
    </div>
</div>
