@extends('frontend.member.dashboard.layout')

@section('member-dashboard')
    @php
        $member = Auth::guard('member')->user()->load('memberInfos');
    @endphp
    {{-- Tab content start here  --}}
    @include('frontend.member.dashboard.partials.profile-update')
    {{-- Tab content end here --}}
    {{-- Event Tab content start here  --}}
    {{-- @include('frontend.member.dashboard.partials.event.event-index') --}}
    {{-- Event Tab content end here --}}
    {{-- Blog/News Tab content start here  --}}
    {{-- @include('frontend.member.dashboard.partials.blog.blog-index') --}}
    {{-- Blog/News Tab content end here --}}
    {{-- Publication Tab content start here  --}}
    {{-- @include('frontend.member.dashboard.partials.publication.publication-index') --}}
    {{-- Publication Tab content end here --}}
    
@endsection
