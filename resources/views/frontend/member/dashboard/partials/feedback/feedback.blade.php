@extends('frontend.member.dashboard.layout')

@section('member-dashboard')
    <div id="blog-news">
        <ul class="sub-profile-tabs nav nav-tabs mb-3" id="pills-tab" role="tablist">

            <li class="nav-item" role="presentation">
                <button class="nav-link fw-bold active" id="all-blog-news-tab" data-bs-toggle="tab"
                    data-bs-target="#all-blog-news" type="button" role="tab" aria-controls="all-blog-news"
                    aria-selected="false" tabindex="-1"><i class="fas fa-paper-plane"></i>&nbsp;All
                    Feedback</button>
            </li>
        </ul>
        <div class="tab-content mt-4" id="pills-tabContent">
            <div class="tab-pane fade show active" id="all-blog-news" role="tabpanel" aria-labelledby="all-blog-news-tab"
                tabindex="0">
                @include('frontend.member.dashboard.partials.feedback.partials.feedback-list')
            </div>
        </div>
    </div>
@endsection
{{-- @include('frontend.member.dashboard.partials.post.partials.post-js') --}}
