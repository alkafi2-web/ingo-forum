@extends('frontend.layouts.frontend-page-layout')
@section('page-title', 'Video Gallery')
@section('frontend-section')
    @php
        use Carbon\Carbon;
        use Illuminate\Support\Str;
    @endphp
    <!-- Video Gallery Area end here  -->
    <section class="video-gallery-page ptb-50">
        <div class="container">
            <div class="row g-3 g-md-4">
                @forelse ($videos as $video)
                    <div class="col-md-4">
                        <div class="blog-card h-100">
                            <div class="blog-img">
                                <a href="{{ $video->url }}" data-toggle="lightbox" data-gallery="video-gallery"
                                    data-title="{{ $video->name }}"><img
                                        src="{{ asset('public/frontend/images/video-thumbnail/') }}/{{ $video->media }}"
                                        alt=""></a>
                                {{-- {{ asset('public/frontend/images/video-thumbnail.png') }} --}}
                            </div>
                            <div class="blog-content">
                                <span class="mini-title">#{{ $video->type }}</span>
                                <h3 class="blog-title line-clamp-2">
                                    <a href="{{ $video->url }}" data-toggle="lightbox" data-gallery="video-gallery"
                                        data-title="{{ $video->name }}">{{ $video->name }}</a>

                                </h3>
                                <p class="line-clamp-3">{{ $video->content }}
                                </p>
                                <div class="blog-publice py-1">
                                    <div class="row pb-1">
                                        <div class="col-6 border-right">
                                            <div class="d-flex align-items-center">
                                                <img src="{{ asset('public/frontend/images/icons/calender.png') }}"
                                                    alt="">
                                                <div class="ms-2">
                                                    <span class="d-block fw-semibold">Date:</span>
                                                    <span
                                                        class="blog-date-admin">{{ Carbon::parse($video->created_at)->format('d M') }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="d-flex d-flex align-items-center">
                                                <img src="{{ asset('public/frontend/images/icons/profile.png') }}"
                                                    alt="">
                                                <div class="ms-2">
                                                    <span class="d-block fw-semibold">By:</span>
                                                    <span
                                                        class="blog-date-admin">{{ ucfirst($video->addedBy->name) }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <h2>There is No Video</h2>
                @endforelse

                
            </div>
    </section>
    <!-- Video Gallery Area end here  -->
@endsection

{{-- @push('custom-js')
    <script>
        $('[data-fancybox="gallery"]').fancybox({
            buttons: [
                "slideShow",
                "thumbs",
                "zoom",
                "fullScreen",
                "share",
                "close"
            ],
            loop: true,
            protect: true
        });
    </script>
@endpush --}}
