@extends('frontend.layouts.frontend-page-layout')
@section('frontend-section')
@section('page-title', $postCategory->name)
<!-- Blogs Area start here -->
<section class="blogs-page-content ptb-50">
    <div class="container">
        <div class="filter-arrow mb-3 d-flex align-items-center justify-content-between" style="margin: 0 2px;">
            <div class="cw-1 text-start">
                <span class="fs-6">
                    <i class="fa-solid fa-filter filter-toggle1" data-bs-toggle="tooltip" data-bs-placement="right"
                        data-bs-title="Filter"></i>
                </span>
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
                <div class="col-md-12">
                    <select id="categoryFilter" class="form-select" aria-label="Default select example">
                        <option value="">Category</option>
                        @forelse ($postCategory->subcategories as $category)
                            <option value="{{ $category->id }}"
                                {{ request()->input('category') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @empty
                            <option>There Is No Category</option>
                        @endforelse
                    </select>
                </div>
            </div>
        </div>
        <div
            class="reset-area d-flex align-items-center pb-2 {{ request()->input('search') || request()->input('category') ? '' : 'd-none' }}">
            <button type="button" id="resetAllFilters" class="btn btn-outline-secondary me-1">
                <span>Reset All Filters</span> <i class="fas fa-times"></i>
            </button>
            <div id="activeFilters">
                @if (request()->input('search'))
                    <button type="button" class="btn btn-outline-secondary filterReset" data-filter="search"
                        data-value="{{ request()->input('search') }}">
                        <span>{{ request()->input('search') }}</span> <i class="fas fa-times"></i>
                    </button>
                @endif
                @if (request()->input('category'))
                    <button type="button" class="btn btn-outline-secondary filterReset" data-filter="category"
                        data-value="{{ request()->input('category') }}">
                        <span>Category:
                            {{ $postCategory->subcategories->where('id', request()->input('category'))->first()->name ?? 'Unknown' }}</span>
                        <i class="fas fa-times"></i>
                    </button>
                @endif
            </div>
        </div>
        <div id="postContainer" class="row g-3 g-md-4">
            @include('frontend.post.partials.post') <!-- Include posts partial view -->
        </div>
        <div class="row pt-4">
            <div class="col-12 post-pagination">
                @include('frontend.post.partials.pagination') <!-- Include pagination partial view -->
            </div>
        </div>
    </div>
</section>
<!-- Blogs Area end here -->

@endsection

@push('custom-js')
<script>
    $(document).ready(function() {
        function updateBlogs() {
            let search = $('#searchHidden').val();
            let category = $('#categoryFilter').val();
            let url = new URL(window.location.href);
            url.searchParams.set('search', search);
            url.searchParams.set('category', category);

            // Update the URL in the browser
            window.history.pushState({}, '', url);

            $.ajax({
                url: url.toString(),
                method: 'GET',
                dataType: 'json',
                success: function(data) {
                    $('#postContainer').html(data.html);
                    $('.post-pagination').html(data.pagination);
                    updateResetArea(search, category);
                }
            });
        }

        function updateResetArea(search, category) {
            let resetHtml = '';

            if (search) {
                resetHtml += `<button type="button" class="btn btn-outline-secondary filterReset" data-filter="search" data-value="${search}">
                    <span>${search}</span> <i class="fas fa-times"></i>
                </button>`;
            }
            if (category) {
                let categoryName = $('#categoryFilter option:selected').text();
                resetHtml += `<button type="button" class="btn btn-outline-secondary filterReset" data-filter="category" data-value="${category}">
                    <span>Category: ${categoryName}</span> <i class="fas fa-times"></i>
                </button>`;
            }

            if (resetHtml) {
                $('#activeFilters').html(resetHtml);
                $('.reset-area').removeClass('d-none');
            } else {
                $('#activeFilters').html('');
                $('.reset-area').addClass('d-none');
            }
        }

        // Trigger search update on input change
        $('#searchInput').on('keyup', function() {
            $('#searchHidden').val($(this).val());
            updateBlogs();
        });

        // Trigger filter update on select change
        $('#categoryFilter').on('change', function() {
            updateBlogs();
        });

        // Reset individual filters
        $(document).on('click', '.filterReset', function() {
            let filterType = $(this).data('filter');
            let filterValue = $(this).data('value');

            switch (filterType) {
                case 'search':
                    $('#searchInput').val('');
                    $('#searchHidden').val('');
                    break;
                case 'category':
                    $('#categoryFilter').val('');
                    break;
                    // Add more cases if needed
            }
            updateBlogs();
        });

        // Reset all filters
        $('#resetAllFilters').on('click', function() {
            $('#searchInput').val('');
            $('#searchHidden').val('');
            $('#categoryFilter').val('');
            updateBlogs();
        });

        // Initialize filter UI based on existing URL parameters
        function initializeFilters() {
            let search = new URLSearchParams(window.location.search).get('search');
            let category = new URLSearchParams(window.location.search).get('category');

            if (search) {
                $('#searchInput').val(search);
                $('#searchHidden').val(search);
            }
            if (category) {
                $('#categoryFilter').val(category);
            }

            updateBlogs();
        }

        // Run on page load
        initializeFilters();
    });
</script>
@endpush
