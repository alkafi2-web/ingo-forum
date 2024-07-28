@extends('frontend.layouts.frontend-page-layout')
@section('page-title', {{ $page->title }})
@section('frontend-section')
    <!-- Page content start here  -->
    <div class="container ptb-50">
        {!! $page->details !!}
    </div>
    <!-- Page contentend here  -->
@endsection
