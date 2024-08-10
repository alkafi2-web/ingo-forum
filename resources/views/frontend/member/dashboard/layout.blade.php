@extends('frontend.layouts.frontend-page-layout')
@section('page-title', 'Dashboard')
@section('frontend-section')
    <!-- Profile edit page start -->
    <section class="ptb-50">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="row">
                        @php
                            $member = Auth::guard('member')->user()->load('memberInfos');
                        @endphp
                        <div class="col-lg-3 mb-3 mb-lg-0 nav flex-column nav-pills" id="v-pills-tab" role="tablist"
                            aria-orientation="vertical">
                            <div class="edit-profile-img bg-white py-4 px-3 text-center">
                                <div class="preview-img mb-3">
                                    <img src="{{ asset('public/frontend/images/member/') }}/{{ $member->memberInfos[0]['logo'] ?? 'placeholder.jpg' }}"
                                        alt="" id="preview-img">
                                    <i class="fa-solid fa-camera" id="upload-icon"></i>
                                    <input type="file" name="" id="profile-input" class="d-none">
                                </div>
                                <span
                                    class="d-block w-100 text-orange fw-semibold fs-">{{ $member->memberInfos[0]['membership_id'] }}</span>
                                <span
                                    class="d-block w-100 text-orange fw-semibold fs-">{{ $member->memberInfos[0]['organisation_name'] }}</span>
                                <span
                                    class="d-block w-100">({{ $member->memberInfos[0]['org_type'] == 1 ? 'Registered with NGO Affairs Bureau (NGOAB) as an INGO' : 'Possess international governance structures' }})</span>
                            </div>
                            <div class="all-profile-tabs d-flex flex-column mt-4 bg-white py-4 px-3">
                                <a href="{{route('member.dashboard')}}" class="nav-link {{ Route::currentRouteName() == 'member.dashboard' ? 'active' : '' }}" id="dashboard">Dashboard</a>

                                <a href="{{ route('member.profile') }}"
                                    class="nav-link {{ Route::currentRouteName() == 'member.profile' ? 'active' : '' }}"
                                    id="profile-tab" type="button" aria-controls="profile" aria-selected="true">Profile</a>

                                <a href="{{ route('member.event.index') }}"
                                    class="nav-link {{ Route::currentRouteName() == 'member.event.index' ? 'active' : '' }}"
                                    type="button" role="tab" aria-controls="event" aria-selected="false">Events</a>

                                <a href="{{ route('member.post.index') }}"
                                    class="nav-link {{ Route::currentRouteName() == 'member.post.index' ? 'active' : '' }}"
                                    id="blog-news-tab" aria-selected="true">Blog/News</a>

                                <a href="{{ route('member.publication.index') }}"
                                    class="nav-link {{ Route::currentRouteName() == 'member.publication.index' ? 'active' : '' }}"
                                    id="publication-tab" data-bs-target="#publication" type="button" role="tab"
                                    aria-controls="publication" aria-selected="true">Publication</a>


                            </div>
                        </div>
                        <div class="col-lg-9 tab-content bg-white p-3 rounded" id="v-pills-tabContent">
                            @yield('member-dashboard')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Profile edit page end -->

@endsection
