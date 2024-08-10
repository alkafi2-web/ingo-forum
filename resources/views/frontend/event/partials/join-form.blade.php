<!-- join-form.blade.php -->
<div class="modal fade" id="joinFormModal" tabindex="-1" role="dialog" aria-labelledby="joinFormModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg join_form_modal" role="document">
        <div class="modal-content">
            <div class="text-center pt-3 border-bottom">
                <h3 class="modal-title" id="joinFormModalLabel">Event Join Form</h3>
                <strong><i class="fas fa-user-tag"></i>&nbsp;Total Participant: {{ $event->participants->count() }}</strong>
                <p style="font-size: 12px;">Last Join Day - {{ $event->reg_deadline ?? $event->end_date->format('D, M d, Y') }}</p>
            </div>
            <div class="modal-body">
                <div class="text-center border-bottom">
                    <h5 class="modal-title" id="joinFormModalLabel">Attendee Information</h5>
                    <p style="font-size: 12px;">Please fill name and contact information of attendees.</p>
                </div>
                <form class="pt-3" action="" method="POST" enctype="multipart/form-data" id="joinEventForm">
                    @csrf
                    <input type="hidden" name="event_id" value="{{ $event->id }}">
                    <div class="row g-2">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="attendee_name" class="mb-1 required">Attendee's Name</label>
                                <input type="text" class="form-control" id="attendee_name" name="attendee_name" placeholder="Attendee Name" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="attendee_email" class="mb-1 required">Attendee's Email</label>
                                <input type="email" class="form-control" id="attendee_email" name="attendee_email" placeholder="Email Address" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="attendee_phone" class="mb-1 required">Attendee's Phone</label>
                                <input type="text" class="form-control" id="attendee_phone" name="attendee_phone" placeholder="Contact Number" required>
                            </div>
                        </div>
                        <div class="col-12">
                            <label for="" class="required">Will you have a guest with you?</label>
                            <div class="d-flex align-items-center pt-2">
                                <div class="me-4">
                                    <input class="form-check-input have_guest" type="radio" name="have_guest" id="radio1" value="yes">
                                    <label class="form-check-label" for="radio1">Yes</label>
                                </div>
                                <div class="">
                                    <input class="form-check-input have_guest" type="radio" name="have_guest" id="radio2" value="no" checked>
                                    <label class="form-check-label" for="radio2">No</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Guest Attendee Wrapper -->
                    <div id="guestAttendeeWrapper" style="border:solid 1px #e4e6ef; display:none;">
                        <div class="row g-2 p-2 mt-3 inputGuestWrapper">
                            <div class="col-12">
                                <div class="form-group">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <label for="guest_name_1" class="mb-1 required">Guest 1</label>
                                        <button class="bg-transparent border-0 removeInputGuestWrapper"><i class="fas fa-minus-circle"></i></button>
                                    </div>
                                    <input type="text" class="form-control" id="guest_name_1" name="guest_name[]" placeholder="Guest Name" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="guest_email_1" class="mb-1 required">Email Address</label>
                                    <input type="email" class="form-control" id="guest_email_1" name="guest_email[]" placeholder="Email Address" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="guest_phone_1" class="mb-1 required">Contact Number</label>
                                    <input type="text" class="form-control" id="guest_phone_1" name="guest_phone[]" placeholder="Contact Number" required>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-center">
                            <button type="button" class="bg-transparent border-0" id="addNewInputGuestWrapper"><i class="fas fa-plus-circle"></i></button>
                        </div>
                    </div>

                    <!-- Membership Information -->
                    <div class="row g-2 p-2 mt-3">
                        <div class="col-12">
                            <label for="" class="required">Are you already a member?</label>
                            <div class="d-flex align-items-center pt-2">
                                <div class="me-4">
                                    <input class="form-check-input are_you_member" type="radio" name="are_you_member" id="inlineRadio1" value="yes" {{ Auth::guard('member')->check()?'checked':'' }}>
                                    <label class="form-check-label" for="inlineRadio1">Yes</label>
                                </div>
                                <div class="">
                                    <input class="form-check-input are_you_member" type="radio" name="are_you_member" id="inlineRadio2" value="no" {{ Auth::guard('member')->check()?'':'checked' }}>
                                    <label class="form-check-label" for="inlineRadio2">No</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12" id="memberIdWrapper" style="{{ Auth::guard('member')->check() ? '' : 'display: none;' }}">

                            <div class="form-group">
                                <label for="membership_id" class="mb-1 required">Membership ID</label>
                                <input type="text" class="form-control" id="membership_id" name="membership_id" placeholder="24-08-08001" value="{{ Auth::guard('member')->check()?Auth::guard('member')->user()->info->membership_id:"" }}">
                            </div>
                        </div>
                    </div>

                    <button type="button" class="btn btn-primary mt-2" id="submitJoinFormBtn">Join Now</button>
                </form>
            </div>
        </div>
    </div>
</div>
@push('custom-js')
    <script>
        $(document).ready(function () {
            // Show/hide guest attendee fields
            $('.have_guest').on('change', function () {
                if ($(this).val() === 'yes') {
                    $('#guestAttendeeWrapper').slideDown();
                } else {
                    $('#guestAttendeeWrapper').slideUp().find('input').val('');
                }
            });

            // Add new guest input
            $('#addNewInputGuestWrapper').on('click', function (e) {
                e.preventDefault();
                var guestIndex = $('.inputGuestWrapper').length + 1;
                var newGuestHtml = `
                    <div class="row g-2 p-2 mt-3 inputGuestWrapper">
                        <div class="col-12">
                            <div class="form-group">
                                <div class="d-flex align-items-center justify-content-between">
                                    <label for="guest_name_${guestIndex}" class="mb-1 required">Guest ${guestIndex}</label>
                                    <button class="bg-transparent border-0 removeInputGuestWrapper"><i class="fas fa-minus-circle"></i></button>
                                </div>
                                <input type="text" class="form-control" id="guest_name_${guestIndex}" name="guest_name[]" placeholder="Guest Name" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="guest_email_${guestIndex}" class="mb-1 required">Email Address</label>
                                <input type="email" class="form-control" id="guest_email_${guestIndex}" name="guest_email[]" placeholder="Email Address" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="guest_phone_${guestIndex}" class="mb-1 required">Contact Number</label>
                                <input type="text" class="form-control" id="guest_phone_${guestIndex}" name="guest_phone[]" placeholder="Contact Number" required>
                            </div>
                        </div>
                    </div>`;
                $('#guestAttendeeWrapper').append(newGuestHtml);
            });

            // Remove guest input
            $(document).on('click', '.removeInputGuestWrapper', function (e) {
                e.preventDefault();
                if ($('.inputGuestWrapper').length > 1) {
                    $(this).closest('.inputGuestWrapper').remove();
                } else {
                    $('#guestAttendeeWrapper').slideUp().find('input').val('');
                    $('input[name="have_guest"][value="no"]').prop('checked', true);
                }
            });

            // Show/hide membership ID field
            $('.are_you_member').on('change', function () {
                if ($(this).val() === 'yes') {
                    $('#memberIdWrapper').slideDown();
                    $('#membership_id').prop('required', true);
                } else {
                    $('#memberIdWrapper').slideUp().find('input').val('');
                    $('#membership_id').prop('required', false);
                }
            });

            // Handle form submission
            $('#submitJoinFormBtn').on('click', function (e) {
                e.preventDefault();
                
                var formData = $('#joinEventForm').serialize();
                var url = '{{ route('join.event') }}'; // Define your form action route here

                $.ajax({
                    url: url,
                    type: 'POST',
                    data: formData,
                    success: function (response) {
                        if (response.success) {
                            toastr.success(response.msg);
                            $('#joinFormModal').modal('hide');
                        }
                        else{
                            toastr.error(response.msg);
                        }
                    },
                    error: function (xhr) {
                        var errors = xhr.responseJSON.errors;
                        $.each(errors, function (key, value) {
                            toastr.error(value);
                        });
                    }
                });
            });
        });
    </script>
@endpush