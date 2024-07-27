@extends('frontend.layouts.front-end-layout')

@section('frontend-section')
<!-- Title Area start here -->
<section class="page-title-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-2"></div>
            <div class="col-lg-8 p-mobile">
                <div class="text-center page-title-area">
                    <div class="page-title">
                        <h2>
                        @if ($post->category)
                          <h2>{{ $post->category->name }}</h2>
                      @endif
                        </h2>
                    </div>
                    <div class="page-border">
                        <div class="top-bottom-img">
                            <img src="{{ asset('public/frontend/images/top-right.png')}}" alt=""
                                class="page-top-right">
                            <img src="{{ asset('public/frontend/images/bottom-left.png')}}" alt=""
                                class="page-bottom-left">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-2"></div>
        </div>
    </div>
</section>
<!-- Title Area end here -->

<!-- main section start here -->
<section class="bg-gray ptb-50">
  <div class="container">
    <div class="row">
      <div class="col-lg-8">
        <div class="single-blog-content">
            <div class="blog-thumb">
                <img src="{{ asset("public/frontend/images/posts/{$post->banner}") }}" alt="" class="w-100">
            </div>
            <div class="single-blog-details pt-4">
                <h2 class="single-post-title pb-1">{{ $post->title }}</h2>
                <div style="text-align: justify;">
                    {!! $post->long_des !!}
                </div>
            </div>
            <h4>Share this post:</h4>
            <div class="social-share-links pt-4">
              <h4>Share this post:</h4>
              {!! Share::page(url()->current(), $post->title)
                  ->facebook('<i class="fab fa-facebook"></i>')
                  ->twitter('<i class="fab fa-twitter"></i>')
                  ->linkedin('<i class="fab fa-linkedin"></i>')
                  ->whatsapp('<i class="fab fa-whatsapp"></i>'); !!}
          </div>
          
            <div class="comment-wrapper w-100">
                @include('frontend.post.partials.comment-box')
            </div>
        </div>
      </div>
      <div class="col-lg-4">
        @if($latestPosts->count())
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
                <img src="{{ asset("public/frontend/images/posts/{$latestPost->banner}") }}" alt="">
                <div class="ms-2">
                  <h5><a href="{{ url("{$post->category->slug}/{$latestPost->slug}") }}">{{ $latestPost->title }}</a></h5>
                  <span>Date: {{ $latestPost->created_at->format('d M Y') }}</span>
                </div>
              </div>
            </div>
            @endforeach
          </div>
        </div>
        @endif
        @if($relatedPosts->count())
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
                <img src="{{ asset("public/frontend/images/posts/{$relatedPost->banner}") }}" alt="">
                <div class="ms-2">
                  <h5><a href="{{ url("{$post->category->slug}/{$relatedPost->slug}") }}">{{ $relatedPost->title }}</a></h5>
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