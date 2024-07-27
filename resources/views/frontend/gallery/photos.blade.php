@extends('frontend.layouts.frontend-page-layout')
@section('page-title', 'Photos Album')
@section('frontend-section')
    @php
        use Carbon\Carbon;
        use Illuminate\Support\Str;
    @endphp
    <!-- Photo Gallery Area start here  -->
    <section class="photo-gallery-page ptb-50">
        <div class="container">
            <div class="row gy-3 gy-md-5 gx-3 gx-md-5 px-1 mt-3">
                @forelse ($albums as $album)
                    <div class="col-6 col-md-4">
                        <div class="gallery-card h-100">
                            <div class="gallery-img">
                                @forelse ($album->mediaGalleries->where('status', 1)->take(3) as $photo)
                                    <a href="{{route('singleAlbum',['id'=>$album->id])}}"><img
                                            src="{{ asset('public/frontend/images/photo-gallery/') }}/{{ $photo->media }}"
                                            alt=""></a>
                                @empty
                                    <a href=""><img src="{{ asset('public/frontendimages/gallery1.png')}}" alt=""></a>
                                    <a href=""><img src="{{ asset('public/frontendimages/gallery3.png')}}" alt=""></a>
                                    <a href=""><img src="{{ asset('public/frontendimages/gallery2.png')}}" alt=""></a>
                                @endforelse

                            </div>
                            <div class="blog-content">
                                <span class="mini-title">#{{ $album->albumtype }}</span>
                                <h3 class="blog-title line-clamp-2"><a href="{{route('singleAlbum',['id'=>$album->id])}}">{{ $album->title }}</a></h3>
                                <p class="line-clamp-3">{{ Str::limit($album->subcontent ?? '', 150) }}</p>
                                <div class="blog-publice py-1">
                                    <div class="row pb-1">
                                        <div class="col-6 border-right">
                                            <div class="d-flex align-items-center">
                                                <img src="{{ asset('public/frontend/images/icons/calender.png') }}"
                                                    alt="">
                                                <div class="ms-2">
                                                    <span class="d-block fw-semibold">Date:</span>
                                                    <span
                                                        class="blog-date-admin">{{ Carbon::parse($album->created_at)->format('d M') }}</span>
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
                                                        class="blog-date-admin">{{ ucfirst($album->addedBy->name) }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                <div class="mx-auto">
                    <h3>There Is No Photo Album</h3>
                </div>
                @endforelse
            </div>
            <div class="row pt-4">
                <div class="col-12 post-pagination">
                    {{ $albums->links() }} <!-- Laravel pagination links -->
                </div>
            </div>
        </div>
    </section>
    <!-- Photo Gallery end here  -->
@endsection
