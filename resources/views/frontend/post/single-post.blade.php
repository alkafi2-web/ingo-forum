@extends('frontend.layouts.frontend-page-layout')
@section('frontend-section')
    @if ($post->category)
        @section('page-title', $post->category->name)
    @endif
    <!-- main section start here -->
    <section class="bg-gray ptb-50">
        <div class="container single-post-container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="single-blog-content">
                        <div class="blog-thumb">
                            <img src="{{ asset("public/frontend/images/posts/{$post->banner}") }}" alt=""
                                class="w-100">
                        </div>
                        <div class="single-blog-details pt-4">
                            <h2 class="single-post-title pb-1 fw-bold">{{ $post->title }}</h2>
                            <h5 class="text-dark fw-bold author-name"><i
                                    class="fas fa-pen-nib"></i>&nbsp;{{ $post->addedBy->name??$post->addedBy_member->organisation_name }}</h5>
                            <div class="w-100 d-flex justify-content-between">
                                <h6 class="m-0 publish-title d-flex align-items-center"><i
                                        class="fas fa-globe-asia"></i>&nbsp;{{ $post->created_at->format('d F Y h:i A') }}&nbsp;&nbsp;
                                    <i class="fas fa-book-reader"></i> &nbsp;{{ $readCount }} reads
                                </h6>
                                <div class="social-link-wrapper d-flex align-items-center justify-content-end">
                                    {!! Share::page(url()->current(), $post->title)->facebook()->twitter()->linkedin()->whatsapp() !!}
                                </div>
                            </div>
                            <hr class="mt-1">
                            <div style="text-align: justify;">
                                {!! $post->long_des !!}
                            </div>
                        </div>
                        <div class="comment-wrapper w-100">
                            @if ($post->comment_permission == 1)
                                @include('frontend.post.partials.comment-box')
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    @if ($latestPosts->count())
                        <div class="blog-sidebar bg-white p-2">
                            <h4 class="sidebar-title pb-1">Latest
                                @if ($post->category)
                                    {{ $post->category->name }}
                                @endif
                            </h4>
                            <div class="row gy-3">
                                @foreach ($latestPosts as $latestPost)
                                    <div class="col-12">
                                        <div class="latest-post d-flex align-items-center">
                                            <img src="{{ asset("public/frontend/images/posts/{$latestPost->banner}") }}"
                                                alt="">
                                            <div class="ms-2">
                                                <h5><a
                                                        href="{{ route('single.post', ['categorySlug' => $post->category->slug, 'postSlug' => $latestPost->slug]) }}">{{ $latestPost->title }}</a>
                                                </h5>
                                                <span>Date: {{ $latestPost->created_at->format('d M Y') }}</span>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                    @if ($relatedPosts->count())
                        <div class="blog-sidebar mt-4 bg-white p-2">
                            <h4 class="sidebar-title pb-1">Related
                                @if ($post->category)
                                    {{ $post->category->name }}
                                @endif
                            </h4>
                            <div class="row gy-3">
                                @foreach ($relatedPosts as $relatedPost)
                                    <div class="col-12">
                                        <div class="latest-post d-flex align-items-center">
                                            <img src="{{ asset("public/frontend/images/posts/{$relatedPost->banner}") }}"
                                                alt="">
                                            <div class="ms-2">
                                                <h5><a
                                                        href="{{ route('single.post', ['categorySlug' => $post->category->slug, 'postSlug' => $relatedPost->slug]) }}">{{ $relatedPost->title }}</a>
                                                </h5>
                                                <span>Date: {{ $relatedPost->created_at->format('d M Y') }}</span>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
@endsection
