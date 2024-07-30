@extends('frontend.layouts.frontend-page-layout')
@section('frontend-section')
@section('page-title', $postCategory->name)
<!-- Blogs Area start here -->
<section class="blogs-page-content ptb-50">
    <div class="container">
        <div class="filter-arrow mb-3 d-flex align-items-center justify-content-between" style="margin: 0 2px;">
            <div class="cw-1 text-start">
                <span class="fs-6"><i class="fa-solid fa-filter filter-toggle1" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="Filter"></i></span>
            </div>
            <div class="cw-2 search-filter">
                <div class="position-relative search-group">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <input type="text" id="searchInput" class="form-control" placeholder="Search..." value="{{ request()->input('search') }}">
                    <input type="hidden" id="searchHidden" name="search" value="{{ request()->input('search') }}">
                </div>
            </div>
            <div class="cw-3 text-end">
                <span class="fs-6 filter-toggle2">
                    <i class="fa-solid fa-angle-down"></i>
                    <i class="fa-solid fa-xmark"></i>
                </span>
            </div>
        </div>
        <div class="filter-box">
            <div class="row mb-3 g-3 search-filter">
                <div class="col-md-12">
                    <select id="categoryFilter" class="form-select" aria-label="Default select example">
                        <option value="">Category</option>
                        @forelse ($postCategory->subcategories as $category)
                            <option value="{{ $category->id }}" {{ request()->input('category') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}</option>
                        @empty
                            <option>There Is No Category</option>
                        @endforelse
                    </select>
                </div>
            </div>
        </div>
        <div class="reset-area d-flex align-items-center pb-2 {{ request()->input('search') || request()->input('category') || request()->input('author') || request()->input('publisher') ? '' : 'd-none' }}">
            <button type="button" id="resetAllFilters" class="btn btn-outline-secondary me-1">
                <span>Reset All Filters</span> <i class="fas fa-times"></i>
            </button>
            <div id="activeFilters">
                @if (request()->input('search'))
                    <button type="button" class="btn btn-outline-secondary filterReset" data-filter="search" data-value="{{ request()->input('search') }}">
                        <span>{{ request()->input('search') }}</span> <i class="fas fa-times"></i>
                    </button>
                @endif
                @if (request()->input('category'))
                    <button type="button" class="btn btn-outline-secondary filterReset" data-filter="category" data-value="{{ request()->input('category') }}">
                        <span>Category: {{ $categories->where('id', request()->input('category'))->first()->name ?? 'Unknown' }}</span> <i class="fas fa-times"></i>
                    </button>
                @endif
            </div>
        </div>
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
