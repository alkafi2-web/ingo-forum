@extends('frontend.layouts.frontend-page-layout')
@section('frontend-section')
    <!-- Profile Content Section start here  -->
    <section class="members-profile-content bg-green">
        <div class="container">
            <div class="row">
                <div class="col-md-3 mb-3 mb-md-0">
                    <div class="members-profile-image h-100 text-center position-relative">
                        <img src="{{ asset('public/frontend/images/member/') }}/{{ $memberinfo->info->logo ?? 'logo.png' }}"
                            alt="Profile Image" class="mb-3">
                        <span class="d-block w-100 text-orange fw-semibold fs-">{{ $memberinfo->info->membership_id }}</span>
                        <span
                            class="d-block w-100 text-bold">({{ $memberinfo->info->org_type == 1 ? 'Registered with NGO Affairs Bureau (NGOAB) as an INGO' : 'Possess international governance structures' }})</span>
                            
                            <a href="{{ route('member.profile') }}" type="button" class="ct-btn btn-yellow py-2 px-3 position-absolute end-0 top-0" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Edit Profile">
                                <i class="fa-solid fa-pen-to-square"></i>
                              </a>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="profile-content text-white pb-3">
                        <div class="d-flex align-item-center justify-content-between">
                            <h2 class="section-title">{{ $memberinfo->info->title }}</h2>
                            {{-- <a href="{{ route('member.profile') }}" class="ct-btn btn-yellow">Edit Profile</a> --}}
                        </div>
                        
                        <h4>{{ $memberinfo->info->sub_title }}</h4>
                        <p>{{$memberinfo->info->short_description}}</p>
                        <div class="d-flex align-items-center">
                            <a href="{{ route('profile.download',['membership_id'=>$memberinfo->info->membership_id]) }}" class="ct-btn btn-yellow">Download Our Profile</a>
                            <nav class="d-flex align-items-center profile-social ms-3">
                                @isset($memberinfo->info->instagram)
                                    <a href="{{ $memberinfo->info->instagram }}" class="text-decoration-none" target="_blank"
                                        rel="noopener noreferrer"><i class="fab fa-instagram"></i></a>
                                @endisset

                                @isset($memberinfo->info->linkedin)
                                    <a href="{{ $memberinfo->info->linkedin }}" class="text-decoration-none" target="_blank"
                                        rel="noopener noreferrer"><i class="fab fa-linkedin-in"></i></a>
                                @endisset
                                @isset($memberinfo->info->youtube)
                                    <a href="{{ $memberinfo->info->youtube }}" class="text-decoration-none" target="_blank"
                                        rel="noopener noreferrer"><i class="fab fa-youtube"></i></a>
                                @endisset

                                @isset($memberinfo->info->facebook)
                                    <a href="{{ $memberinfo->info->facebook }}" class="text-decoration-none" target="_blank"
                                        rel="noopener noreferrer"><i class="fab fa-facebook-f"></i></a>
                                @endisset

                                @isset($memberinfo->info->twitter)
                                    <a href="{{ $memberinfo->info->twitter }}" class="text-decoration-none" target="_blank"
                                        rel="noopener noreferrer"><i class="fab fa-twitter"></i></a>
                                @endisset
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Profile Content Section end here  -->
    <!-- Mision Vision Section start here  -->
    <section class="mission-vission-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    <div class="member-single-info">
                        <p class="fw-semibold">Member Since :</p>
                        <p>{{ $memberinfo->info->created_at->format('M d, Y') }}</p>
                        {{-- <p class="fw-semibold">Last Renew :</p>
                        <p>Jan 01, 2024</p>
                        <p class="fw-semibold">Valid Till :</p>
                        <p>Dec 31, 2024</p> --}}
                        <div class="member-contact-info pt-3 pb-3">
                            <h6 class="text-orange fw-semibold text-decoration-underline">Contact Us</h6>
                            <p class="fw-semibold">Email :</p>
                            <p>{{ $memberinfo->info->organisation_email }}</p>
                            <p class="fw-semibold">Phone :</p>
                            <p>{{ $memberinfo->info->organisation_phone ?? 'N/A' }}</p>
                            <p class="fw-semibold">Address :</p>
                            <p>{{ $memberinfo->info->organisation_address }} </p>
                        </div>
                        <a href="{{ $memberinfo->info->organisation_website }}" target="_blank"
                            class="ct-btn btn-yellow w-100 mt-3">Visit Our Website</a>
                        {{-- <div class="d-flex align-items-center justify-content-between">
                            <a href="{{ $memberinfo->info->organisation_website }}" type="button" class="ct-btn btn-yellow w-100 mt-3 py-2 px-3 me-1" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Visit Our Website" target="__blank">
                                <i class="fa-solid fa-globe"></i>
                              </a>
                            <a href="" type="button" class="ct-btn btn-yellow w-100 mt-3 py-2 px-3" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Join Our Forum" target="__blank">
                                <i class="fa-solid fa-paperclip"></i>
                              </a>
                        </div> --}}
                    </div>
                </div>
                <div class="col-lg-9">
                    <div class="row pt-4">
                        <div class="col-md-4 mb-3 md-md-0">
                            <div class="mision-vision-card h-100">
                                <div class="msv-title mission d-flex align-items-center justify-content-between">
                                    <h4>Mission</h4>
                                    <img src="{{ asset('public/frontend/images/icons/mission.png') }}" alt="">
                                </div>
                                <div class="msv-content">
                                    <p>{!! $memberinfo->info->mission !!}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3 md-md-0">
                            <div class="mision-vision-card h-100">
                                <div class="msv-title vision d-flex align-items-center justify-content-between">
                                    <h4>Vision</h4>
                                    <img src="{{ asset('public/frontend/images/icons/vision.png') }}" alt="">
                                </div>
                                <div class="msv-content">
                                    <p>{!! $memberinfo->info->vision !!}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3 md-md-0">
                            <div class="mision-vision-card h-100">
                                <div class="msv-title values d-flex align-items-center justify-content-between">
                                    <h4>Values</h4>
                                    <img src="{{ asset('public/frontend/images/icons/values.png') }}" alt="">
                                </div>
                                <div class="msv-content">
                                    {!! $memberinfo->info->value !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Mision Vision Section end here  -->
    <!-- Mision Vision Section end here  -->
    <section class="work-history bg-gray">
        <div class="container pt-3">
            <div class="row">
                <div class="col-12">
                    @if (!empty($memberinfo->info->work))
                        <h3>Our Work</h3>
                        <p>{!! $memberinfo->info->work !!}</p>
                    @endif

                    @if (!empty($memberinfo->info->history))
                        <h3>Our History & Heritage</h3>
                        <p>{!! $memberinfo->info->history !!}</p>
                    @endif

                    @if (!empty($memberinfo->info->other_description))
                        <h3>Other Description</h3>
                        <p>{!! $memberinfo->info->other_description !!}</p>
                    @endif
                </div>
            </div>
        </div>
    </section>
    <!-- Mision Vision Section end here  -->
@endsection
