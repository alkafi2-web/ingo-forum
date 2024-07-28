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
                                <input type="text" class="form-control" id="name" name="name" placeholder="Your Name">
                            </div>
                            <div class="col-md-6">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" placeholder="Your Email">
                            </div>
                            <div class="col-md-6">
                                <label for="phone" class="form-label">Phone</label>
                                <input type="text" class="form-control" id="phone" name="phone" placeholder="Your Phone">
                            </div>
                            <div class="col-12">
                                <label for="subject" class="form-label">Subject</label>
                                <input type="text" class="form-control" id="subject" name="subject" placeholder="Subject">
                            </div>
                            <div class="col-12">
                                <label for="message" class="form-label">Message</label>
                                <textarea class="form-control" id="message" name="message" rows="3"></textarea>
                            </div>
                            <div class="col-12 pt-2">
                                <button type="submit" id="contact-submit" class="ct-btn btn-yellow">Submit</button>
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
                        <div class="map mt-3">
                            <iframe
                                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d8684.678039702163!2d90.36168459766252!3d23.766724173655497!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3755c09f9ba3d447%3A0x1babce9f1c6c95a3!2sMohammadpur%2C%20Dhaka!5e0!3m2!1sen!2sbd!4v1719827661161!5m2!1sen!2sbd"
                                width="100%" height="290" style="border:0;" allowfullscreen="" loading="lazy"
                                referrerpolicy="no-referrer-when-downgrade"></iframe>
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
                    console.log(response);
                    var success = response.success;
                    $.each(success, function(key, value) {
                        toastr.success(value); // Displaying each success message
                    });
                    $('#contactForm')[0].reset();
                },
                error: function(xhr) {
                    var errors = xhr.responseJSON.errors;
                    // Iterate through each error and display it
                    $.each(errors, function(key, value) {
                        console.log(key, value);
                        toastr.error(value); // Displaying each error message
                    });
                }
            });
        });
    </script>
@endpush
