@extends('frontend.member.dashboard.layout')

@section('member-dashboard')
    {{-- Event Tab content start here  --}}
    @include('frontend.member.dashboard.partials.event.event')
    {{-- Event Tab content end here --}}
@endsection
