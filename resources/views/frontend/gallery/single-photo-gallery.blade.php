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
                            <img alt="dshbdsfbh" src="./images/gallery/n1.jpg" data-image="./images/gallery/n1.jpg"
                                data-description="Description for Image 1">
                        @empty
                        @endforelse

                        {{-- <img alt="" src="./images/gallery/n2.jpeg" data-image="./images/gallery/n2.jpeg"
                            data-description="Description for Image 2">
                        <img alt="" src="./images/gallery/n2.webp" data-image="./images/gallery/n2.webp"
                            data-description="Description for Image 2">
                        <img alt="" src="./images/gallery/n3.jpg" data-image="./images/gallery/n3.jpg"
                            data-description="Description for Image 1">
                        <img alt="" src="./images/gallery/n4.jpg" data-image="./images/gallery/n4.jpg"
                            data-description="Description for Image 1">
                        <img alt="" src="./images/gallery/n5.webp" data-image="./images/gallery/n5.webp"
                            data-description="Description for Image 2">
                        <img alt="" src="./images/gallery/n6.webp" data-image="./images/gallery/n6.webp"
                            data-description="Description for Image 2">
                        <img alt="" src="./images/gallery/n7.jpg" data-image="./images/gallery/n7.jpg"
                            data-description="Description for Image 2">
                        <img alt="" src="./images/gallery/n8.webp" data-image="./images/gallery/n8.webp"
                            data-description="Description for Image 2"> --}}
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Single photo gallery section end here  -->
@endsection
