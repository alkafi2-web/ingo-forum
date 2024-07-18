@extends('frontend.layouts.frontend-page-layout')
@section('page-title', $album->title)
@section('frontend-section')
    <!-- Single photo gallery section satrt here  -->
    <section class="single-photo-gallery ptb-50">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <div class="photo-content">
                        <h2 class="photo-title">{{ $album->title }}</h2>
                        <div class="photo-desc">
                            <p>{{ $album->content }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-8 photo-gallery">
                    <div id="gallery">
                        @forelse ($album->mediaGalleries as $photo)
                            {{-- <a href="{{ asset('public/frontend/images/photo-gallery/') }}/{{ $photo->media }}"
                                >
                                <img src="{{ asset('public/frontend/images/photo-gallery/') }}/{{ $photo->media }}"
                                    class="img-fluid rounded" data-fancybox="gallery">
                            </a> --}}
                            <img alt="" src="{{ asset('public/frontend/images/photo-gallery/') }}/{{ $photo->media }}" data-image="{{ asset('public/frontend/images/photo-gallery/') }}/{{ $photo->media }}"
                            data-description="Description for Image 2">
                        @empty
                        <h3>There is NO Photo In Album</h3>
                        @endforelse

                        
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Single photo gallery section end here  -->
@endsection

@push('custom-js')
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
@endpush
