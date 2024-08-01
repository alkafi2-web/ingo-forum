<!-- resources/views/frontend/publication/publication_partials/publications.blade.php -->
<div class="row g-3 g-md-4">
    @forelse ($publications as $publication)
        <div class="col-6 col-md-4">
            <div class="blog-card h-100">
                <div class="blog-img" style="max-height: 230px; overflow: hidden;">
                    <a href="{{ asset('public/frontend/images/publication/') }}/{{$publication->file}}" target="__blank">
                        <img src="{{ asset("public/frontend/images/publication/{$publication->image}") }}" alt="" style="width: 100%; height: auto; object-fit: cover;">
                    </a>
                </div>
                <div class="blog-content">
                    <div class="col-sm-12 col-md-12 postcat-initials">
                        <span class="mini-title">#{{ $publication->category->name }}</span>
                    </div>
                    <h3 class="blog-title line-clamp-2">
                        <a href="{{ asset('public/frontend/images/publication/') }}/{{$publication->file}}" target="__blank">{{ $publication->title }}</a>
                    </h3>
                    <div class="blog-text line-clamp-3" style="text-align: justify;">
                        {!! \Illuminate\Support\Str::limit(htmlspecialchars_decode(strip_tags($publication->short_description)), 200) !!}
                    </div>
                    <div class="blog-publice py-1">
                        <div class="row pb-1">
                            <div class="col-6 border-right">
                                <div class="d-flex align-items-center">
                                    <img src="{{ asset('public/frontend/images/icons/calender.png') }}" alt="">
                                    <div class="ms-2">
                                        <span class="d-block fw-semibold">Date:</span>
                                        <span class="blog-date-admin">{{ $publication->publish_date }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="d-flex align-items-center">
                                    <img src="{{ asset('public/frontend/images/icons/profile.png') }}" alt="">
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
