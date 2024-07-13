@extends('frontend.layouts.front-end-layout')
@section('fontend-section')
    <!-- Title Area start here  -->
    <section class="page-title-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-2"></div>
                <div class="col-lg-8 p-mobile">
                    <div class="text-center page-title-area">
                        <div class="page-title">
                            <h2>Page Title</h2>
                        </div>
                        <div class="page-border">
                            <div class="top-bottom-img">
                                <img src="{{ asset('public/frontend/images/top-right.png')}}" alt="" class="page-top-right">
                                <img src="{{ asset('public/frontend/images/bottom-left.png')}}" alt="" class="page-bottom-left">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2"></div>
            </div>
        </div>
    </section>
    <!-- Title Area end here  -->
@endsection
