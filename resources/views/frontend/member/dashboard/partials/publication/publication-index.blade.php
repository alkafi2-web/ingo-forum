@extends('frontend.member.dashboard.layout')

@section('member-dashboard')
    {{-- Event Tab content start here  --}}
    @include('frontend.member.dashboard.partials.publication.publication')
    {{-- Event Tab content end here --}}
@endsection
