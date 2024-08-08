$event is getting from controller use to get  last day of joining
<div class="modal fade" id="joinFormModal" tabindex="-1" role="dialog" aria-labelledby="joinFormModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg join_form_modal" role="document">
    <div class="modal-content">
      <div class="text-center pt-3 border-bottom">
        <h3 class="modal-title" id="joinFormModalLabel">Event Join Form</h3>
        <strong><i class="fas fa-user-tag"></i>&nbsp;Total Participant: 12 total count of participant of this event</strong>
        <p style="font-size: 12px;">Last Join Day - May 21, 2035 1 day before of event start date</p>
      </div>
      <div class="modal-body">
        <div class="text-center border-bottom">
          <h5 class="modal-title" id="joinFormModalLabel">Attendee Information</h5>
          <p style="font-size: 12px;">Please fill name and contact information of attendees.</p>
        </div>
        <form class="pt-3" action="" method="POST" enctype="multipart/form-data" id="joinEventForm">
            <div class="row g-2">
                <div class="col-12">
                <div class="form-group">
                    <label for="attendee_name" class="mb-1 required">Attendee's Name</label>
                    <input type="text" class="form-control" id="attendee_name" name="attendee_name" placeholder="Attendee Name">
                </div>
                </div>
                <div class="col-md-6">
                <div class="form-group">
                    <label for="attendee_email" class="mb-1 required">Attendee's Email </label>
                    <input type="email" class="form-control" id="attendee_email" name="attendee_email" placeholder="Email Address">
                </div>
                </div>
                <div class="col-md-6">
                <div class="form-group">
                    <label for="attendee_phone" class="mb-1 required">Attendee's Phone</label>
                    <input type="text" class="form-control" id="attendee_phone" name="attendee_phone" placeholder="Contact Number">
                </div>
                </div>
                <div class="col-12">
                <label for="" class="required">Will you have a guest with you?</label>
                <div class="d-flex align-items-center pt-2">
                    <div class="me-4">
                    <input class="form-check-input have_guest" type="radio" name="have_guest" id="radio1"
                        value="yes">
                    <label class="form-check-label" for="radio1">Yes</label>
                    </div>
                    <div class="">
                    <input class="form-check-input have_guest" type="radio" name="have_guest" id="radio2"
                        value="no">
                    <label class="form-check-label" for="radio2">No</label>
                    </div>
                </div>
                </div>
            </div>
            {{-- show this guestAttendeeWrapper when .have_guest is checked value = yes if no then hide guestAttendeeWrapper --}}
            <div id="guestAttendeeWrapper">
                <div class="row g-2 p-2 mt-3 inputGuestWrapper" style="border:solid 1px #e4e6ef">
                    <span class=""><i class="fas fa-plus-circle"></i></span>
                    <div class="col-12">
                        <div class="form-group">
                        <label for="org_name_guest" class="mb-1 required">Guest 1</label>
                        <input type="text" class="form-control" id="org_name_guest" placeholder="Guest Name">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                        <label for="rep_name_guest" class="mb-1 required">Email Address</label>
                        <input type="email" class="form-control" id="rep_name_guest" placeholder="Email Address">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                        <label for="rep_name_guest" class="mb-1 required">Contact Number</label>
                        <input type="text" class="form-control" id="rep_name_guest" placeholder="Contact Number">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row g-2 p-2 mt-3">
                <div class="col-12">
                <label for="" class="required">Are you already a member?</label>
                <div class="d-flex align-items-center pt-2">
                    <div class="me-4">
                    <input class="form-check-input are_you_member" type="radio" name="are_you_member" id="inlineRadio1"
                        value="yes">
                    <label class="form-check-label are_you_member" for="inlineRadio1">Yes</label>
                    </div>
                    <div class="">
                    <input class="form-check-input" type="radio" name="are_you_member" id="inlineRadio2"
                        value="no">
                    <label class="form-check-label" for="inlineRadio2">No</label>
                    </div>
                </div>
                </div>
                if .are_you_member checked value = yes then show #memberIdWrapper
                <div class="col-md-12" id="memberIdWrapper" style="display: none"> 
                <div class="form-group">
                    <label for="membership_id" class="mb-1 required">Membership ID</label>
                    <input type="text" class="form-control" id="membership_id" name="membership_id" placeholder="24-08-08001">
                </div>
                </div>
            </div>
            <button type="button" class="btn btn-primary mt-2">Join Now</button>
        </form>
      </div>
    </div>
  </div>
</div>