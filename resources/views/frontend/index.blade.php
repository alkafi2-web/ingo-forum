@extends('frontend.layouts.frontend-page-layout')
@section('frontend-section')
    @php
        use Carbon\Carbon;
        use Illuminate\Support\Str;
        use App\Helpers\Helper;
    @endphp

    <!-- Hero slider Section Start  -->
    @include('frontend.partials.home-slider')
    <!-- Hero slider Section End  -->

    <!-- About Us Section Start  -->
    <section class="about-us-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="fixtures">
                        <div class="row gx-4 gy-5">
                            @forelse ($global['aboutus_feature'] as $index => $feature)
                                <div class="col-6">
                                    <div class="fixtures-item fx{{ ($index % 4) + 1 }}">
                                        <div class="fixture-icon">
                                            <img src="{{ asset('public/frontend/images/icons/fx' . (($index % 4) + 1) . '.png') }}"
                                                alt="">
                                            {{-- <img src="{{ asset('public/frontend/images/icons/fx1.png') }}" alt=""> --}}
                                        </div>
                                        <div class="fixture-text">
                                            <span>{{ $feature['subtitle'] }}</span>
                                            <h3>{{ $feature['title'] }}</h3>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="col-6">
                                    <div class="fixtures-item fx1">
                                        <div class="fixture-icon">
                                            <img src="{{ asset('public/frontend/images/icons/fx1.png') }}" alt="">
                                        </div>
                                        <div class="fixture-text">
                                            <h3>Coordination</h3>
                                            <span>The Forum Secretariat facilitates information sharing and mutual
                                                understanding among our members.</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="fixtures-item fx2">
                                        <div class="fixture-icon">
                                            <img src="{{ asset('public/frontend/images/icons/fx3.png') }}" alt="">
                                        </div>
                                        <div class="fixture-text">
                                            <h3>Advocacy</h3>
                                            <span>We mobilise the INGO Forum members on collective positioning on critical
                                                humanitarian issues.</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="fixtures-item fx3">
                                        <div class="fixture-icon">
                                            {{-- <img src="images/icons/fx4.png" alt=""> --}}
                                            <img src="{{ asset('public/frontend/images/icons/fx4.png') }}" alt="">
                                        </div>
                                        <div class="fixture-text">
                                            <h3>Safety and security</h3>
                                            <span>The members of the INGO Forum are convinced that security, safety and
                                                well-being of humanitarian personnel prevail.</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="fixtures-item fx4">
                                        <div class="fixture-icon">
                                            <img src="{{ asset('public/frontend/images/icons/fx2.png') }}" alt="">
                                            {{-- <img src="images/icons/fx2.png" alt=""> --}}
                                        </div>
                                        <div class="fixture-text">
                                            <h3>Liaison with national NGOs</h3>
                                            <span>The INGO members are committed to strengthening relationships, linkages
                                                and collaborative efforts .</span>
                                        </div>
                                    </div>
                                </div>
                            @endforelse

                        </div>
                    </div>
                </div>
                <div class="col-lg-6 ps-lg-5 mt-4 mt-lg-0">
                    <div class="about-text add-list-style">
                        <h5 class="sub-title">About Us</h5>
                        <h2 class="section-title">{{ $global['aboutus_content']->title ?? 'Please Upload It From Admin' }}
                        </h2>
                        <h4>{{ $global['aboutus_content']->slogan ?? 'Please Upload It From Admin' }}</h4>
                        <p>
                            {!! $global['aboutus_content']->description ?? 'Please Upload It From Admin' !!}
                        </p>
                        {{-- <a href="{{route('member')}}" class="ct-btn btn-yellow">Be a Member</a> --}}
                    </div>
                </div>
            </div>
            <div class="member-count-area">
                <div class="row">
                    <div class="col-12 col-md-4 mb-3 mb-md-0">
                        <div class="counter d-flex align-items-center">
                            <img src="{{ asset('public/frontend/images/icons/globe.png') }}" alt="">
                            <div class="d-flex align-items-start flex-column ms-2">
                                <p class="text-white">Working for 17 SDG Goal</p>
                                <a href="#" class="d-flex align-items-center">
                                    <span>Values and principles</span>
                                    <i class="fa-solid fa-angle-right ms-1"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-4 text-center mb-3 mb-md-0">
                        <div class="counter d-flex align-items-center">
                            <img src="{{ asset('public/frontend/images/icons/alert.png') }}" alt="">
                            <div class="d-flex align-items-start flex-column ms-2">
                                <p class="text-white">Committed to Peace since 2000</p>
                                <a href="#" class="d-flex align-items-center">
                                    <span>Governance and structure</span>
                                    <i class="fa-solid fa-angle-right ms-1"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-4 text-center mb-3 mb-md-0">
                        <div class="counter d-flex align-items-center">
                            <img src="{{ asset('public/frontend/images/icons/bird.png') }}" alt="">
                            <div class="d-flex align-items-start flex-column ms-2">
                                <p class="text-white">Member Organisation's 94</p>
                                <a href="#" class="d-flex align-items-center">
                                    <span>Be a Member</span>
                                    <i class="fa-solid fa-angle-right ms-1"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- About Us Section End  -->
    <!-- Member Section Start  -->
    @if ($global['membersInfos']->count())
        <section class="member-section">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3"></div>
                    <div class="col-lg-6">
                        <div class="text-center">
                            <h5 class="sub-title">Our Members</h5>
                            <h2 class="section-title">Hands in Together</h2>
                        </div>
                    </div>
                    <div class="col-lg-3"></div>
                </div>
            </div>
            <hr>
            <div class="container">
                <div class="owl-carousel owl-theme members-logo py-2">
                    @foreach ($global['membersInfos'] as $membersInfos)
                        <div class="item">
                            <img src="{{ asset('public/frontend/images/member') }}/{{ $membersInfos->logo }}"
                                alt="">
                        </div>
                    @endforeach
                </div>
            </div>
            <hr>
        </section>
    @endif
    <!-- Member Section End  -->
    <!-- Events Section Start  -->
    @if ($global['events']->count())
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
                            <div class="event-info1">
                                <img src="{{ asset('public/frontend/images/events/' . $global['latest_event']->media) }}"
                                    alt="logo" style="width:100%; height:390px">
                                {{-- <h4>{{ $global['aboutus_content']->title ?? 'Please Upload It From Admin' }}</h4>
            <p>{!! $global['aboutus_content']->description ?? 'Please Upload It From Admin' !!}</p> --}}
                            </div>
                            @php
                                if ($global['latest_event']->creator->info) {
                                    $route = route(
                                        'frontend.member.show',
                                        $global['latest_event']->creator->info->membership_id,
                                    );
                                } else {
                                    $route = 'javascript:void(0)';
                                }
                            @endphp
                            <div class="single-event">
                                <span class="mini-title mb-2 d-block"><a href="{{ $route }}"
                                        class="text-warning text-decoration-none"><i
                                            class="fas fa-feather"></i>&nbsp;{{ $global['latest_event']->creator->name ?? $global['latest_event']->creator->info->organisation_name }}</a>
                                    &nbsp;
                                    @if ($global['latest_event']->reg_enable_status == 1)
                                        <i class="fas fa-users text-success"></i> <span
                                            class="text-success">{{ $global['latest_event']->participants->count() }}</span>
                                    @endif
                                </span>
                                <h4 class="event-title"><a
                                        href="{{ route('frontend.event.show', $global['latest_event']->slug) }}">{{ $global['latest_event']->title ?? '' }}</a>
                                </h4>
                                <p class="line-clamp-3">{!! Str::limit($global['latest_event']->details ?? '', 200) !!}</p>
                                <div class="event-date-time py-2">
                                    <div class="row">
                                        <div class="col-6 border-right">
                                            <div class="d-flex align-items-center">
                                                <img src="{{ asset('public/frontend/images/icons/location.png') }}"
                                                    alt="">
                                                <div class="ms-2">
                                                    <span class="d-block fw-semibold">Location:</span>
                                                    <span>{{ $global['latest_event']->location ?? '' }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="d-flex d-flex align-items-center">
                                                <img src="{{ asset('public/frontend/images/icons/time.png') }}"
                                                    alt="">
                                                <div class="ms-2">
                                                    <span class="d-block fw-semibold">Starts at:</span>
                                                    <span>{{ Carbon::parse($global['latest_event']->start_date ?? '')->format('h A') }}</span>
                                                    {{-- <span>10 am</span> --}}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <a href="{{ route('frontend.event.show', $global['latest_event']->slug) }}"
                                    class="ct-btn btn-yellow d-block mt-3">View Details</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="row gy-3">
                            @forelse ($global['events'] as $event)
                                @php
                                    if ($event->creator->info) {
                                        $route = route('frontend.member.show', $event->creator->info->membership_id);
                                    } else {
                                        $route = 'javascript:void(0)';
                                    }
                                @endphp
                                <div class="col-12">
                                    <div class="event-item">
                                        <div class="row">
                                            <div class="col-9">
                                                <span class="mini-title mb-2 d-block"><a href="{{ $route }}"
                                                        class="text-warning text-decoration-none"><i
                                                            class="fas fa-feather"></i>&nbsp;{{ $event->creator->name ?? $event->creator->info->organisation_name }}</a>
                                                    &nbsp;
                                                    @if ($event->reg_enable_status == 1)
                                                        <i class="fas fa-users text-success"></i> <span
                                                            class="text-success">{{ $event->participants->count() }}</span>
                                                    @endif
                                                </span>
                                                <h4 class="event-title"><a
                                                        href="{{ route('frontend.event.show', $event->slug) }}">{{ $event->title }}</a>
                                                </h4>
                                                <p class="line-clamp-2 mb-0 pb-1">{!! Str::limit($event->details, 150) !!}
                                                </p>
                                            </div>
                                            <div class="col-3 bg-event-date">
                                                <div class="event-item-date position-relative">
                                                    <div class="position-absolute event-date-card text-center">
                                                        <span
                                                            class="date-event d-block">{{ Carbon::parse($event->start_date)->format('d') }}</span>
                                                        <span
                                                            class="date-month">{{ Carbon::parse($event->start_date)->format('M') }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="event-date-time py-1">
                                                <div class="row">
                                                    <div class="col-6 border-right">
                                                        <div class="d-flex align-items-center">
                                                            <img src="{{ asset('public/frontend/images/icons/location.png') }}"
                                                                alt="">
                                                            <div class="ms-2">
                                                                <span class="d-block fw-semibold">Location:</span>
                                                                <span>{{ $event->location }}</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <div class="d-flex d-flex align-items-center">
                                                            <img src="{{ asset('public/frontend/images/icons/time.png') }}"
                                                                alt="">
                                                            <div class="ms-2">
                                                                <span class="d-block fw-semibold">Starts at:</span>
                                                                <span>{{ Carbon::parse($event->start_date)->format('h A') }}</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                            @endforelse

                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif
    <!-- Events Section End  -->
    <!-- Blog Section Start  -->
    @if ($global['posts']->count())
        <section class="blog-section ptb-70 bg-gray">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3"></div>
                    <div class="col-lg-6">
                        <div class="text-center">
                            <h5 class="sub-title">Blog & News</h5>
                            <h2 class="section-title">Moments of INGO</h2>
                        </div>
                    </div>
                    <div class="col-lg-3"></div>
                </div>
                <div class="row gy-3 gy-md-4 gx-3 gx-md-4 pt-5">
                    @forelse ($global['posts'] as $post)
                        <div class="col-6 col-md-4">
                            <div class="blog-card h-100">
                                <div class="blog-img">
                                    <a
                                        href="{{ route('single.post', ['categorySlug' => $post->category->slug, 'postSlug' => $post->slug]) }}"><img
                                            src="{{ asset('public/frontend/images/posts') }}/{{ $post->banner }}"
                                            alt=""></a>
                                    {{-- <a href=""><img src="{{ asset('public/frontend/images/blog.png')}}" alt=""></a> --}}
                                </div>
                                <div class="blog-content">
                                    <div class="w-100 row">
                                        <div class="col-sm-12 col-md-6 postcat-initials">
                                            <span class="mini-title">#{{ $post->category->name }}</span>
                                            <span class="mini-title">> {{ $post->subcategory->name }}</span>
                                        </div>
                                        <div class="col-sm-12 col-md-6 text-end post-overview">
                                            <i class="fas fa-comments text-secondary"></i>&nbsp;
                                            <small style="color: #999">{{ $post->total_comments_and_replies }}</small>
                                            &nbsp;&nbsp;
                                            <i class="fas fa-book-reader text-success"></i> &nbsp;
                                            <small style="color: #999">{{ $post->total_reads }}</small> &nbsp;
                                        </div>
                                    </div>
                                    <h3 class="blog-title line-clamp-2"><a
                                            href="{{ route('single.post', ['categorySlug' => $post->category->slug, 'postSlug' => $post->slug]) }}">{{ $post->title }}</a>
                                    </h3>

                                    <p class="line-clamp-3" style="height: 60px;">{!! \Illuminate\Support\Str::limit(htmlspecialchars_decode(strip_tags($post->long_des)), 200) !!}</p>

                                    <div class="blog-publice py-1">
                                        <div class="row pb-1">
                                            <div class="col-6 border-right">
                                                <div class="d-flex align-items-center">
                                                    <img src="{{ asset('public/frontend/images/icons/calender.png') }}"
                                                        alt="">
                                                    <div class="ms-2">
                                                        <span class="d-block fw-semibold">Date:</span>
                                                        <span
                                                            class="blog-date-admin">{{ Carbon::parse($post->created_at)->format('d M') }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="d-flex d-flex align-items-center">
                                                    <img src="{{ asset('public/frontend/images/icons/profile.png') }}"
                                                        alt="">
                                                    <div class="ms-2">
                                                        <span class="d-block fw-semibold">By:</span>
                                                        <span
                                                            class="blog-date-admin">{{ $post->addedBy->name ?? $post->addedBy_member->organisation_name }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-6 col-md-4">
                            <div class="blog-card h-100">
                                <div class="blog-img">
                                    <a href=""><img src="images/blog.png" alt=""></a>
                                </div>
                                <div class="blog-content">
                                    <span class="mini-title">#Education</span>
                                    <h3 class="blog-title line-clamp-2"><a href="">Children Education</a></h3>
                                    <p class="line-clamp-3">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do
                                        eiusmod
                                        tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.</p>
                                    <div class="blog-publice py-1">
                                        <div class="row pb-1">
                                            <div class="col-6 border-right">
                                                <div class="d-flex align-items-center">
                                                    <img src="images/icons/calender.png" alt="">
                                                    <div class="ms-2">
                                                        <span class="d-block fw-semibold">Date:</span>
                                                        <span class="blog-date-admin">10 Jun</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="d-flex d-flex align-items-center">
                                                    <img src="images/icons/profile.png" alt="">
                                                    <div class="ms-2">
                                                        <span class="d-block fw-semibold">By:</span>
                                                        <span class="blog-date-admin">Admin</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 col-md-4">
                            <div class="blog-card h-100">
                                <div class="blog-img">
                                    <a href=""><img src="images/blog.png" alt=""></a>
                                </div>
                                <div class="blog-content">
                                    <span class="mini-title">#Education</span>
                                    <h3 class="blog-title line-clamp-2"><a href="">Children Education</a></h3>
                                    <p class="line-clamp-3">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do
                                        eiusmod
                                        tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.</p>
                                    <div class="blog-publice py-1">
                                        <div class="row pb-1">
                                            <div class="col-6 border-right">
                                                <div class="d-flex align-items-center">
                                                    <img src="images/icons/calender.png" alt="">
                                                    <div class="ms-2">
                                                        <span class="d-block fw-semibold">Date:</span>
                                                        <span class="blog-date-admin">10 Jun</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="d-flex d-flex align-items-center">
                                                    <img src="images/icons/profile.png" alt="">
                                                    <div class="ms-2">
                                                        <span class="d-block fw-semibold">By:</span>
                                                        <span class="blog-date-admin">Admin</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 col-md-4">
                            <div class="blog-card h-100">
                                <div class="blog-img">
                                    <a href=""><img src="images/blog.png" alt=""></a>
                                </div>
                                <div class="blog-content">
                                    <span class="mini-title">#Education</span>
                                    <h3 class="blog-title line-clamp-2"><a href="">Children Education</a></h3>
                                    <p class="line-clamp-3">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do
                                        eiusmod
                                        tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.</p>
                                    <div class="blog-publice py-1">
                                        <div class="row pb-1">
                                            <div class="col-6 border-right">
                                                <div class="d-flex align-items-center">
                                                    <img src="images/icons/calender.png" alt="">
                                                    <div class="ms-2">
                                                        <span class="d-block fw-semibold">Date:</span>
                                                        <span class="blog-date-admin">10 Jun</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="d-flex d-flex align-items-center">
                                                    <img src="images/icons/profile.png" alt="">
                                                    <div class="ms-2">
                                                        <span class="d-block fw-semibold">By:</span>
                                                        <span class="blog-date-admin">Admin</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforelse

                </div>
            </div>
        </section>
    @endif
    <!-- Blog Section End  -->
    <!-- Publication Section Start  -->
    @if ($global['publications']->count())
        <section class="blog-section ptb-70 bg-gray">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="text-center">
                            <h5 class="sub-title">Publications</h5>
                            <h2 class="section-title">Insights and Innovations from INGO</h2>
                        </div>
                    </div>
                </div>
                <div class="row gy-3 gy-md-4 gx-3 gx-md-4 pt-5">
                    @forelse ($global['publications'] as $publication)
                        <div class="col-6 col-md-4">
                            <div class="blog-card h-100">
                                <div class="blog-img" style="max-height: 230px; overflow: hidden;">
                                    <a href="{{ asset('public/frontend/images/publication/') }}/{{ $publication->file }}"
                                        target="__blank">
                                        <img src="{{ asset("public/frontend/images/publication/{$publication->image}") }}"
                                            alt="" style="width: 100%; height: auto; object-fit: cover;">
                                    </a>
                                </div>
                                <div class="blog-content">
                                    <div class="col-sm-12 col-md-12 postcat-initials">
                                        <span class="mini-title">#{{ $publication->category->name }}</span>
                                    </div>
                                    <h3 class="blog-title line-clamp-2">
                                        <a href="{{ asset('public/frontend/images/publication/') }}/{{ $publication->file }}"
                                            target="__blank">{{ $publication->title }}</a>
                                    </h3>
                                    <div class="blog-text line-clamp-3" style="text-align: justify;">
                                        {!! \Illuminate\Support\Str::limit(htmlspecialchars_decode(strip_tags($publication->short_description)), 200) !!}
                                    </div>
                                    <div class="blog-publice py-1">
                                        <div class="row pb-1">
                                            <div class="col-6 border-right">
                                                <div class="d-flex align-items-center">
                                                    <img src="{{ asset('public/frontend/images/icons/calender.png') }}"
                                                        alt="">
                                                    <div class="ms-2">
                                                        <span class="d-block fw-semibold">Date:</span>
                                                        <span
                                                            class="blog-date-admin">{{ $publication->publish_date }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="d-flex align-items-center">
                                                    <img src="{{ asset('public/frontend/images/icons/profile.png') }}"
                                                        alt="">
                                                    <div class="ms-2">
                                                        <span class="d-block fw-semibold">Author:</span>
                                                        <span class="blog-date-admin">{{ $publication->author }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <h6>Not Found!</h6>
                    @endforelse

                </div>
            </div>
        </section>
    @endif
    <!-- publication Section End  -->
    <!-- Photo Gallery Section start  -->
    @if ($global['albums']->count())
        <section class="gallery-section ptb-70">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3"></div>
                    <div class="col-lg-6">
                        <div class="text-center">
                            <h5 class="sub-title">Photo Gallery</h5>
                            <h2 class="section-title">Snapshots of INGO Moments</h2>
                        </div>
                    </div>
                    <div class="col-lg-3"></div>
                </div>

                <div class="row gy-4 gx-4 gx-md-5 pt-5 px-1 mt-3">
                    @forelse ($global['albums'] as $album)
                        <div class="col-6 col-md-4">
                            <div class="gallery-card h-100">
                                <div class="gallery-img">
                                    @forelse ($album->mediaGalleries->where('status', 1)->take(3) as $photo)
                                        <a href="{{ route('singleAlbum', ['id' => $album->id]) }}"><img
                                                src="{{ asset('public/frontend/images/photo-gallery/') }}/{{ $photo->media }}"
                                                alt=""></a>
                                    @empty
                                        <a href=""><img src="{{ asset('public/frontend/images/gallery1.png') }}"
                                                alt=""></a>
                                        <a href=""><img src="{{ asset('public/frontend/images/gallery3.png') }}"
                                                alt=""></a>
                                        <a href=""><img src="{{ asset('public/frontend/images/gallery2.png') }}"
                                                alt=""></a>
                                    @endforelse

                                </div>
                                <div class="blog-content">
                                    <span class="mini-title">#{{ $album->albumtype }}</span>
                                    <h3 class="blog-title line-clamp-2"><a
                                            href="{{ route('singleAlbum', ['id' => $album->id]) }}">{{ $album->title }}</a>
                                    </h3>
                                    <p class="line-clamp-3">
                                        {{ Str::limit($album->subcontent ?? '', 150) }}</p>
                                    {{-- <div class="blog-publice py-1">
              <div class="row pb-1">
                <div class="col-6 border-right">
                  <div class="d-flex align-items-center">
                    <img src="{{ asset('public/frontend/images/icons/calender.png') }}" alt="">
                    <div class="ms-2">
                      <span class="d-block fw-semibold">Date:</span>
                      <span class="blog-date-admin">{{ Carbon::parse($album->created_at)->format('d M') }}</span>
                    </div>
                  </div>
                </div>
                <div class="col-6">
                  <div class="d-flex d-flex align-items-center">
                    <img src="{{ asset('public/frontend/images/icons/profile.png') }}" alt="">
                    <div class="ms-2">
                      <span class="d-block fw-semibold">By:</span>
                      <span class="blog-date-admin">{{ ucfirst($album->addedBy->name) }}</span>
                    </div>
                  </div>
                </div>
              </div>
            </div> --}}
                                </div>
                            </div>
                        </div>
                    @empty
                    @endforelse

                </div>
            </div>
        </section>
    @endif
    <!-- Photo Gallery Section End  -->
    <!-- Video Section start  -->
    @if ($global['videos']->count())
        <section class="video-gallery ptb-70 bg-gray">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3"></div>
                    <div class="col-lg-6">
                        <div class="text-center">
                            <h5 class="sub-title">Video Gallery</h5>
                            <h2 class="section-title">Live Moments of INGO</h2>
                        </div>
                    </div>
                    <div class="col-lg-3"></div>
                </div>
                <div class="row pt-2">
                    <div class="video-slider">
                        @forelse ($global['videos'] as $video)
                            <div class="item">
                                <div class="blog-card h-100">
                                    <div class="blog-img">
                                        <a href="{{ $video->url }}" data-toggle="lightbox"
                                            data-gallery="video-gallery" data-title="{{ $video->name }}"><img
                                                src="{{ asset('public/frontend/images/video-thumbnail/') }}/{{ $video->media }}"
                                                alt=""></a>
                                        {{-- {{ asset('public/frontend/images/video-thumbnail.png') }} --}}
                                    </div>
                                    <div class="blog-content">
                                        <span class="mini-title">#{{ $video->type }}</span>
                                        <h3 class="blog-title line-clamp-2">
                                            <a href="{{ $video->url }}" data-toggle="lightbox"
                                                data-gallery="video-gallery"
                                                data-title="{{ $video->name }}">{{ $video->name }}</a>

                                        </h3>
                                        <p class="line-clamp-3" style="height: 60px;">{{ $video->content }}
                                        </p>
                                        {{-- <div class="blog-publice py-1">
                <div class="row pb-1">
                  <div class="col-6 border-right">
                    <div class="d-flex align-items-center">
                      <img src="{{ asset('public/frontend/images/icons/calender.png') }}" alt="">
                      <div class="ms-2">
                        <span class="d-block fw-semibold">Date:</span>
                        <span class="blog-date-admin">{{ Carbon::parse($video->created_at)->format('d M') }}</span>
                      </div>
                    </div>
                  </div>
                  <div class="col-6">
                    <div class="d-flex d-flex align-items-center">
                      <img src="{{ asset('public/frontend/images/icons/profile.png') }}" alt="">
                      <div class="ms-2">
                        <span class="d-block fw-semibold">By:</span>
                        <span class="blog-date-admin">{{ ucfirst($video->addedBy->name) }}</span>
                      </div>
                    </div>
                  </div>
                </div>
              </div> --}}
                                    </div>
                                </div>
                            </div>
                        @empty
                        @endforelse
                    </div>
                </div>
        </section>
    @endif
    <!-- Video Section End  -->
    <section style="background-color: #F2F9F5">
        <div class="subscribe-area ptb-70">
            <div class="container">
                <div class="row d-flex align-items-center cs-pt-sub">
                    <div class="col-12">
                        <div class="newsletter-box">
                            <p>Join with our Community</p>
                            <h4>Subscribe Newsletter </h4>
                            <span>& get Company News</span>
                            <form id="newslaterForm" action="">
                                <div class="main-box pt-3">
                                    <div class="input-group flex-nowrap">
                                        <i class="fa-regular fa-envelope position-absolute"></i>
                                        <input type="text" name="email" class="form-control" id=""
                                            aria-describedby="" placeholder="Enter your email" style="border-top-right-radius: 0!important; border-bottom-right-radius: 0!important;">
                                        <button class="btn btn-subscribe" type="button"
                                            id="subscribe">Subscribe</button>
                                    </div>
                            </form>
                        </div>
                    </div>
                    <div class="col-12">
                        <style>
                            .footer {
                                padding: 75px 0 5px 0 !important;
                            }

                            @media screen and (max-width: 768px) {
                                .be-a-member-section {
                                    margin-bottom: -80px;
                                }
                            }
                        </style>
                        <div class="be-a-member-section">
                            <div class="row d-flex align-items-center g-3">
                                <div class="col-md-6 d-flex flex-column">
                                    <span class="be-1 pb-1">Become a member</span>
                                    <span class="be-2">Express Your Interest</span>
                                </div>
                                <div class="col-md-6">
                                    <a href="{{ route('member') }}" class="btn join-btn w-100">Join With Us</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('custom-js')
    <script>
        $(document).ready(function() {
            $('#subscribe').on('click', function(e) {
                e.preventDefault();
                let url = "{{ route('frontend.newslater.store') }}";
                let formData = new FormData($('#newslaterForm')[0]);
                $.ajax({
                    type: 'POST',
                    url: url,
                    data: formData,
                    processData: false, // Prevent jQuery from processing the data
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        console.log(response);
                        var success = response.success;
                        $.each(success, function(key, value) {
                            toastr.success(value); // Displaying each error message
                        });
                        $('#newslaterForm')[0].reset();
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
        });
    </script>
@endpush
