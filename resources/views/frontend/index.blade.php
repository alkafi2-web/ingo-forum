@extends('frontend.layouts.front-end-layout')
@section('fontend-section')
    <!-- Hero Section Start  -->
    <section class="hero-section ptb-70">
        <div class="container">
            <div class="row d-flex align-items-center">
                <div class="col-lg-6 hero-left mb-2 lg-mb-0">
                    <h1>Lorem ipsum is placeholder text commonly used in the graphic, print, mockups.</h1>
                    <p class="pb-3">Lorem ipsum dolor sit amet consectetur adipisicing elit. Assumenda rem iure,
                        quidem neque quae dolorem consequatur dolorum corrupti perspiciatis vero unde, doloribus
                        temporibus itaque maxime. Molestiae vel enim ab dolor.</p>
                    <a href="" class="ct-btn btn-yellow">Be a Member</a>
                </div>
                <div class="col-lg-6 hero-right">
                    <img src="{{asset('public/frontend/images/hero-img.png')}}" alt="">
                </div>
            </div>
        </div>
    </section>
    <!-- Hero Section End  -->
    <!-- About Us Section Start  -->
    <section class="about-us-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="fixtures">
                        <div class="row gx-4 gy-5">
                            <div class="col-6">
                                <div class="fixtures-item fx1">
                                    <div class="fixture-icon">
                                        <img src="{{asset('public/frontend/images/icons/fx1.png')}}" alt="">
                                    </div>
                                    <div class="fixture-text">
                                        <span>Donate for</span>
                                        <h3>Children Education</h3>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="fixtures-item fx2">
                                    <div class="fixture-icon">
                                        <img src="{{asset('public/frontend/images/icons/fx3.png')}}" alt="">
                                    </div>
                                    <div class="fixture-text">
                                        <span>Donate for</span>
                                        <h3>Children Education</h3>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="fixtures-item fx3">
                                    <div class="fixture-icon">
                                        <img src="{{asset('public/frontend/images/icons/fx4.png')}}" alt="">
                                    </div>
                                    <div class="fixture-text">
                                        <span>Donate for</span>
                                        <h3>Children Education</h3>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="fixtures-item fx4">
                                    <div class="fixture-icon">
                                        <img src="{{asset('public/frontend/images/icons/fx2.png')}}" alt="">
                                    </div>
                                    <div class="fixture-text">
                                        <span>Donate for</span>
                                        <h3>Children Education</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 ps-lg-5 mt-4 mt-lg-0">
                    <div class="about-text">
                        <h5 class="sub-title">About Us</h5>
                        <h2 class="section-title">A world where poverty will not exists</h2>
                        <h4>We are the largest crowdfunding</h4>
                        <p>
                            Lorem ipsum, or lipsum as it is sometimes known, is dummy text used in laying out print,
                            graphic or web designs. The passage is attributed to an unknown typesetter in the 15th
                            century who is thought to have scrambled parts of Cicero's De Finibus Bonorum et Malorum for
                            use in a type specimen book. It usually begins with:</p>
                        <p>“Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut
                            labore et dolore magna aliqua.”</p>
                        <p>The purpose of lorem ipsum is to create a natural looking block of text (sentence, paragraph,
                            page, etc.) that doesn't distract from the layout. A practice not without controversy,
                            laying out pages with meaningless filler text can be very useful when the focus is meant to
                            be on design, not content.
                        </p>
                        <a href="" class="ct-btn btn-yellow">Be a Member</a>
                    </div>
                </div>
            </div>
            <div class="member-count-area">
                <div class="row">
                    <div class="col-6 col-md-3 text-center mb-4 mb-md-0">
                        <div class="counter border-right">
                            <img src="{{asset('public/frontend/images/member-badge.png')}}" alt="">
                            <h3 class="text-white count-number" data-count="150">0</h3>
                            <p class="text-white">Total Members</p>
                        </div>
                    </div>
                    <div class="col-6 col-md-3 text-center mb-4 mb-md-0">
                        <div class="counter border-right mobile-border-none">
                            <img src="{{asset('public/frontend/images/member-badge.png')}}" alt="">
                            <h3 class="text-white count-number" data-count="120">0</h3>
                            <p class="text-white">Total Members</p>
                        </div>
                    </div>
                    <div class="col-6 col-md-3 text-center mb-4 mb-md-0">
                        <div class="counter border-right">
                            <img src="{{asset('public/frontend/images/member-badge.png')}}" alt="">
                            <h3 class="text-white count-number" data-count="170">0</h3>
                            <p class="text-white">Total Members</p>
                        </div>
                    </div>
                    <div class="col-6 col-md-3 text-center mb-4 mb-md-0">
                        <div class="counter">
                            <img src="{{asset('public/frontend/images/member-badge.png')}}" alt="">
                            <h3 class="text-white count-number" data-count="100">0</h3>
                            <p class="text-white">Total Members</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- About Us Section End  -->
    <!-- Member Section Start  -->
    <section class="member-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-3"></div>
                <div class="col-lg-6">
                    <div class="text-center">
                        <h5 class="sub-title">Our Members</h5>
                        <h2 class="section-title">Hands in Together, Hearts in Unison</h2>
                    </div>
                </div>
                <div class="col-lg-3"></div>
            </div>
        </div>
        <hr>
        <div class="container">
            <div class="owl-carousel owl-theme members-logo py-2">
                <div class="item">
                    <img src="{{asset('public/frontend/images/wateraid.png')}}" alt="">
                </div>
                <div class="item">
                    <img src="{{asset('public/frontend/images/int.png')}}" alt="">
                </div>
                <div class="item">
                    <img src="{{asset('public/frontend/images/snv.png')}}" alt="">
                </div>
                <div class="item">
                    <img src="{{asset('public/frontend/images/pa.png')}}" alt="">
                </div>
                <div class="item">
                    <img src="{{asset('public/frontend/images/snv.png')}}" alt="">
                </div>
                <div class="item">
                    <img src="{{asset('public/frontend/images/int.png')}}" alt="">
                </div>
                <div class="item">
                    <img src="{{asset('public/frontend/images/pa.png')}}" alt="">
                </div>
            </div>
        </div>
        <hr>
    </section>
    <!-- Member Section End  -->
    <!-- Events Section Start  -->
    <section class="events-area ptb-70">
        <div class="container">
            <div class="row">
                <div class="col-lg-3"></div>
                <div class="col-lg-6">
                    <div class="text-center">
                        <h5 class="sub-title">Upcoming events</h5>
                        <h2 class="section-title">Join our upcoming events for contribution</h2>
                    </div>
                </div>
                <div class="col-lg-3"></div>
            </div>
            <div class="row pt-4 ">
                <div class="col-lg-6 mb-3 mb-lg-0">
                    <div class="single-big-event">
                        <div class="event-info">
                            <img src="{{asset('public/frontend/images/logo.png')}}" alt="">
                            <h4>Lorem ipsum is placeholder text commonly used in the graphic, print, mockups.</h4>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt
                                ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation
                                ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                        </div>
                        <div class="single-event">
                            <span class="event-year mb-2 d-block">#Event2024</span>
                            <h4 class="event-title"><a href="">Children Education</a></h4>
                            <p class="event-short-desc">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do
                                eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                                quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                            <div class="event-date-time py-2">
                                <div class="row">
                                    <div class="col-6 border-right">
                                        <div class="d-flex align-items-center">
                                            <img src="{{asset('public/frontend/images/icons/location.png')}}" alt="">
                                            <div class="ms-2">
                                                <span class="d-block fw-semibold">Location:</span>
                                                <span>Banani, Dhaka</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="d-flex d-flex align-items-center">
                                            <img src="{{asset('public/frontend/images/icons/time.png')}}" alt="">
                                            <div class="ms-2">
                                                <span class="d-block fw-semibold">Starts at:</span>
                                                <span>10 am</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <a href="" class="ct-btn btn-yellow d-block mt-3">Join Events</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="row gy-3">
                        <div class="col-12">
                            <div class="event-item">
                                <div class="row">
                                    <div class="col-9">
                                        <span class="event-year mb-2 d-block">#Event2024</span>
                                        <h4 class="event-title"><a href="">Children Education</a></h4>
                                        <p class="event-item-desc mb-0 pb-1">Lorem ipsum dolor sit amet, consectetur
                                            adipiscing elit, sed do eiusmod
                                            tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                                            quis nostrud exercitation ullamco
                                            laboris nisi ut aliquip ex ea commodo consequat.</p>
                                    </div>
                                    <div class="col-3 bg-event-date">
                                        <div class="event-item-date position-relative">
                                            <div class="position-absolute event-date-card text-center">
                                                <span class="date-event d-block">12</span>
                                                <span class="date-month">Jan</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="event-date-time py-1">
                                        <div class="row">
                                            <div class="col-6 border-right">
                                                <div class="d-flex align-items-center">
                                                    <img src="{{asset('public/frontend/images/icons/location.png')}}" alt="">
                                                    <div class="ms-2">
                                                        <span class="d-block fw-semibold">Location:</span>
                                                        <span>Banani, Dhaka</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="d-flex d-flex align-items-center">
                                                    <img src="{{asset('public/frontend/images/icons/time.png')}}" alt="">
                                                    <div class="ms-2">
                                                        <span class="d-block fw-semibold">Starts at:</span>
                                                        <span>10 am</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="event-item">
                                <div class="row">
                                    <div class="col-9">
                                        <span class="event-year mb-2 d-block">#Event2024</span>
                                        <h4 class="event-title"><a href="">Children Education</a></h4>
                                        <p class="event-item-desc mb-0 pb-1">Lorem ipsum dolor sit amet, consectetur
                                            adipiscing elit, sed do eiusmod
                                            tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                                            quis nostrud exercitation ullamco
                                            laboris nisi ut aliquip ex ea commodo consequat.</p>
                                    </div>
                                    <div class="col-3 bg-event-date">
                                        <div class="event-item-date position-relative">
                                            <div class="position-absolute event-date-card text-center">
                                                <span class="date-event d-block">12</span>
                                                <span class="date-month">Jan</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="event-date-time py-1">
                                        <div class="row">
                                            <div class="col-6 border-right">
                                                <div class="d-flex align-items-center">
                                                    <img src="{{asset('public/frontend/images/icons/location.png')}}" alt="">
                                                    <div class="ms-2">
                                                        <span class="d-block fw-semibold">Location:</span>
                                                        <span>Banani, Dhaka</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="d-flex d-flex align-items-center">
                                                    <img src="{{asset('public/frontend/images/icons/time.png')}}" alt="">
                                                    <div class="ms-2">
                                                        <span class="d-block fw-semibold">Starts at:</span>
                                                        <span>10 am</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="event-item">
                                <div class="row">
                                    <div class="col-9">
                                        <span class="event-year mb-2 d-block">#Event2024</span>
                                        <h4 class="event-title"><a href="">Children Education</a></h4>
                                        <p class="event-item-desc mb-0 pb-1">Lorem ipsum dolor sit amet, consectetur
                                            adipiscing elit, sed do eiusmod
                                            tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                                            quis nostrud exercitation ullamco
                                            laboris nisi ut aliquip ex ea commodo consequat.</p>
                                    </div>
                                    <div class="col-3 bg-event-date">
                                        <div class="event-item-date position-relative">
                                            <div class="position-absolute event-date-card text-center">
                                                <span class="date-event d-block">12</span>
                                                <span class="date-month">Jan</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="event-date-time py-1">
                                        <div class="row">
                                            <div class="col-6 border-right">
                                                <div class="d-flex align-items-center">
                                                    <img src="{{asset('public/frontend/images/icons/location.png')}}" alt="">
                                                    <div class="ms-2">
                                                        <span class="d-block fw-semibold">Location:</span>
                                                        <span>Banani, Dhaka</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="d-flex d-flex align-items-center">
                                                    <img src="{{asset('public/frontend/images/icons/time.png')}}" alt="">
                                                    <div class="ms-2">
                                                        <span class="d-block fw-semibold">Starts at:</span>
                                                        <span>10 am</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Events Section End  -->
@endsection