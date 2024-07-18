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
                        <h2>{{ $postCategory->name }}</h2>
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

<!-- Blogs Area start here -->
<section class="blogs-page-content ptb-50">
    <div class="container">
        <div class="row g-3 g-md-4">
            @forelse ($posts as $post)
            <div class="col-6 col-md-4">
                <div class="blog-card h-100">
                    <div class="blog-img" style="max-height: 230px; overflow: hidden;">
                        <a href="{{ route('single.post', ['categorySlug'=>$postCategory->slug, 'postSlug'=>$post->slug])}}">
                            <img src="{{ asset("public/frontend/images/posts/{$post->banner}") }}" alt=""
                                style="width: 100%; height: auto; object-fit: cover;">
                        </a>
                    </div>
                    <div class="blog-content">
                        <span class="mini-title">#{{ $post->subcategory->name }}</span>
                        <h3 class="blog-title line-clamp-2"><a href="{{ route('single.post', ['categorySlug'=>$postCategory->slug, 'postSlug'=>
                                    $post->slug])}}">{{ $post->title }}</a></h3>
                        <div class="blog-text line-clamp-3" style="text-align: justify;">
                            {!! \Illuminate\Support\Str::limit(htmlspecialchars_decode(strip_tags($post->long_des)), 200) !!}
                        </div>
                        <div class="blog-publice py-1">
                            <div class="row pb-1">
                                <div class="col-6 border-right">
                                    <div class="d-flex align-items-center">
                                        <img src="{{ asset('public/frontend/images/icons/calender.png') }}"
                                            alt="">
                                        <div class="ms-2">
                                            <span class="d-block fw-semibold">Date:</span>
                                            <span
                                                class="blog-date-admin">{{ $post->created_at->format('d M Y') }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="d-flex d-flex align-items-center">
                                        <img src="{{ asset('public/frontend/images/icons/profile.png') }}"
                                            alt="">
                                        <div class="ms-2">
                                            <span class="d-block fw-semibold">By:</span>
                                            <span class="blog-date-admin">{{ $post->addedBy->name }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <h6>No {{ $postCategory->name }} Found!</h6>
            @endforelse
        </div>
        <div class="row pt-4">
            <div class="col-12 post-pagination">
                {{ $posts->links() }} <!-- Laravel pagination links -->
            </div>
        </div>
    </div>
</section>
<!-- Blogs Area end here -->
@endsection
