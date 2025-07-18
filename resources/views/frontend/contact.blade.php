@extends('frontend.layouts.frontend-page-layout')
@section('page-title', 'Contact')
@section('frontend-section')
    <section class="contact-us-area ptb-50">
        <div class="container">
            <div class="row">
                <div class="col-md-6 mb-4 mb-md-0 bg-white p-3">
                    <div class="contact-form">
                        <h2>Get In Touch</h2>
                        <form id="contactForm" class="row g-2">
                            <div class="col-12">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" class="form-control" id="name" name="name"
                                    placeholder="Your Name">
                            </div>
                            <div class="col-md-6">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email"
                                    placeholder="Your Email">
                            </div>
                            <div class="col-md-6">
                                <label for="phone" class="form-label">Phone</label>
                                <input type="text" class="form-control" id="phone" name="phone"
                                    placeholder="Your Phone">
                            </div>
                            <div class="col-12">
                                <label for="subject" class="form-label">Subject</label>
                                <input type="text" class="form-control" id="subject" name="subject"
                                    placeholder="Subject">
                            </div>
                            <div class="col-12">
                                <label for="message" class="form-label">Message</label>
                                <textarea class="form-control" id="message" name="message" rows="3"></textarea>
                            </div>
                            <div class="col-12 pt-2">
                                <button type="submit" id="contact-submit" class="ct-btn btn-yellow">
                                    <span id="spinner" class="spinner-border spinner-border-sm" role="status"
                                        aria-hidden="true" style="display:none;"></span>
                                    Submit
                                </button>
                            </div>
                        </form>

                    </div>
                </div>
                <div class="col-md-6">
                    <div class="contact-info">
                        <div class="row g-3">
                            <div class="col-12">
                                <div class="contact-details d-flex align-items-center">
                                    <div class="icon me-2 d-flex align-items-center justify-content-center">
                                        <i class="fa-solid fa-phone"></i>
                                    </div>
                                    <div class="d-flex flex-column">
                                        <h6>Phone</h6>
                                        <a href="tel:01315256454">{{ $global['phone'] }}</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="contact-details d-flex align-items-center">
                                    <div class="icon me-2 d-flex align-items-center justify-content-center">
                                        <i class="fa-solid fa-envelope"></i>
                                    </div>
                                    <div class="d-flex flex-column">
                                        <h6>Email</h6>
                                        <a href="mailto:{{ $global['email'] }}">{{ $global['email'] }}</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="contact-details d-flex align-items-center">
                                    <div class="icon me-2 d-flex align-items-center justify-content-center">
                                        <i class="fa-solid fa-location-dot"></i>
                                    </div>
                                    <div class="d-flex flex-column">
                                        <h6>Address</h6>
                                        <p>{{ $global['address'] }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @php
                            $embeddedAddress = $global['address_embaded'];
                            $src = '';
                            if (preg_match('/src="([^"]+)"/', $embeddedAddress, $match)) {
                                $src = $match[1];
                            }
                        @endphp

                        <div class="map mt-3">
                            {{-- {{ $global['address_embaded'] }} --}}
                            <iframe src="{{ $src }}" width="100%" height="290" style="border:0;"
                                allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

@push('custom-js')
    <script>
        $('#contact-submit').on('click', function(e) {
            e.preventDefault();
            $(this).prop('disabled', true); // Disable the button to prevent multiple submissions
            $('#spinner').show();
            let url = "{{ route('frontend.contact.info') }}";
            let formData = new FormData($('#contactForm')[0]);

            $.ajax({
                type: 'POST',
                url: url,
                data: formData,
                contentType: false,
                processData: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    $('#contact-submit').prop('disabled',
                        true); // Disable the button to prevent multiple submissions
                    $('#spinner').hide();
                    var success = response.success;
                    $.each(success, function(key, value) {
                        toastr.success(value); // Displaying each success message
                    });
                    $('#contactForm')[0].reset();
                },
                error: function(xhr) {
                    $('#contact-submit').prop('disabled',
                        true); // Disable the button to prevent multiple submissions
                    $('#spinner').hide();
                    var errors = xhr.responseJSON.errors;
                    // Iterate through each error and display it
                    $.each(errors, function(key, value) {
                        toastr.error(value); // Displaying each error message
                    });
                }
            });
        });
    </script>
@endpush
