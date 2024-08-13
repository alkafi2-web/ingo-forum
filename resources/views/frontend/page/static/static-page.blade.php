@extends('frontend.layouts.frontend-page-layout')
@section('frontend-section')
@section('page-title', $page->title)
    <!-- Page content start here  -->
    <div class="container ptb-50">
        {!! $page->details !!}
    </div>
    <!-- Page contentend here  -->
@endsection
