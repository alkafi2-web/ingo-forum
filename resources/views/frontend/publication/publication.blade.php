@extends('frontend.layouts.frontend-page-layout')
@section('frontend-section')
@section('page-title', 'Publication')
<!-- Blogs Area start here -->
<section class="blogs-page-content ptb-50">
    <div class="container">
        <!-- filter section start -->
        <div class="filter-arrow mb-3 d-flex align-items-center justify-content-between" style="margin: 0 2px;">
            <div class="cw-1 text-start">
                <span class="fs-6"><i class="fa-solid fa-filter filter-toggle1" data-bs-toggle="tooltip"
                        data-bs-placement="right" data-bs-title="Filter"></i></span>
            </div>
            <div class="cw-2 search-filter">
                <div class="position-relative search-group">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <input type="text" id="searchInput" class="form-control" placeholder="Search..."
                        value="{{ request()->input('search') }}">
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
                <div class="col-md-4">
                    <select id="categoryFilter" class="form-select" aria-label="Default select example">
                        <option value="">Category</option>
                        @forelse ($categories as $category)
                            <option value="{{ $category->id }}"
                                {{ request()->input('category') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}</option>
                        @empty
                            <option>There Is No Category</option>
                        @endforelse
                    </select>
                </div>
                <div class="col-md-4">
                    <select id="authorFilter" class="form-select" aria-label="Default select example">
                        <option value="">Author</option>
                        @forelse ($authorsAndPublishers as $author)
                            <option value="{{ $author->author }}"
                                {{ request()->input('author') == $author->author ? 'selected' : '' }}>
                                {{ $author->author }}</option>
                        @empty
                            <option>There Is No Author</option>
                        @endforelse
                    </select>
                </div>
                <div class="col-md-4">
                    <select id="publisherFilter" class="form-select" aria-label="Default select example">
                        <option value="">Publisher</option>
                        @forelse ($authorsAndPublishers as $publisher)
                            <option value="{{ $publisher->publisher }}"
                                {{ request()->input('publisher') == $publisher->publisher ? 'selected' : '' }}>
                                {{ $publisher->publisher }}</option>
                        @empty
                            <option>There Is No Publisher</option>
                        @endforelse
                    </select>
                </div>
            </div>
        </div>
        {{-- <div class="reset-area d-flex align-items-center pb-2 d-none">
            <button type="button" class="btn btn-outline-secondary me-1">Secondary <span><i class="fas fa-times"></i></span></button>
            <button type="button" class="btn btn-outline-secondary">Secondary</button>
        </div> --}}
        <!-- filter section end -->
        <div id="publicationsContainer" class="row g-3 g-md-4">
            @forelse ($publications as $publication)
                <div class="col-6 col-md-4">
                    <div class="blog-card h-100">
                        <div class="blog-img" style="max-height: 230px; overflow: hidden;">
                            <a href="{{ asset('public/frontend/images/publication/') }}/{{ $publication->file }}"
                                target="__blank">
                                <img src="{{ asset("public/frontend/images/publication/{$publication->image}") }}"
                                    alt="" style="width: 100%; height: auto; object-fit: cover;">
                            </a>
                        </div>
                        <div class="blog-content">
                            <div class="col-sm-12 col-md-12 postcat-initials">
                                <span class="mini-title">#{{ $publication->category->name }}</span>
                            </div>
                            <h3 class="blog-title line-clamp-2">
                                <a href="{{ asset('public/frontend/images/publication/') }}/{{ $publication->file }}"
                                    target="__blank">{{ $publication->title }}</a>
                            </h3>
                            <div class="blog-text line-clamp-3" style="text-align: justify;">
                                {!! \Illuminate\Support\Str::limit(htmlspecialchars_decode(strip_tags($publication->short_description)), 200) !!}
                            </div>
                            <div class="blog-publice py-1">
                                <div class="row pb-1">
                                    <div class="col-6 border-right">
                                        <div class="d-flex align-items-center">
                                            <img src="{{ asset('public/frontend/images/icons/calender.png') }}"
                                                alt="">
                                            <div class="ms-2">
                                                <span class="d-block fw-semibold">Date:</span>
                                                <span class="blog-date-admin">{{ $publication->publish_date }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="d-flex align-items-center">
                                            <img src="{{ asset('public/frontend/images/icons/profile.png') }}"
                                                alt="">
                                            <div class="ms-2">
                                                <span class="d-block fw-semibold">Author:</span>
                                                <span class="blog-date-admin">{{ $publication->author }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <h6>Not Found!</h6>
            @endforelse
        </div>
        <div class="row pt-4">
            <div class="col-12 post-pagination">
                {{ $publications->links() }} <!-- Laravel pagination links -->
            </div>
        </div>
    </div>
</section>


<!-- Blogs Area end here -->
@endsection

@push('custom-js')
{{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}
<script>
    $(document).ready(function() {
        function updatePublications() {
            let search = $('#searchHidden').val();
            let category = $('#categoryFilter').val();
            let author = $('#authorFilter').val();
            let publisher = $('#publisherFilter').val();

            $.ajax({
                url: "{{ route('frontend.publication') }}",
                method: 'GET',
                data: {
                    search: search,
                    category: category,
                    author: author,
                    publisher: publisher
                },
                success: function(data) {
                    $('#publicationsContainer').html(data.html);
                    $('.post-pagination').html(data.pagination);
                }
            });
        }

        // Trigger search update on input change
        $('#searchInput').on('keyup', function() {
            $('#searchHidden').val($(this).val());
            updatePublications();
        });

        // Trigger filter update on select change
        $('#categoryFilter, #authorFilter, #publisherFilter').on('change', function() {
            updatePublications();
        });
    });
</script>
@endpush
