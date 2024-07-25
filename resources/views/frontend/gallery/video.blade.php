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
    <style>
        .ekko-lightbox.modal .modal-header {
            flex-direction: row-reverse !important;
        }

        .modal-header .close {
            padding: 1rem 1.25rem;
            margin: -1rem -1.25rem -1rem auto;
            display: none;
        }

        .modal-header {
            display: -ms-flexbox;
            display: flex;
            -ms-flex-align: start;
            align-items: flex-start;
            -ms-flex-pack: justify;
            justify-content: space-between;
            padding: 1rem 1.25rem;
            border-bottom: 1px solid #e3e9ef;
            border-top-left-radius: calc(.4375rem - 1px);
            border-top-right-radius: calc(.4375rem - 1px);
        }

        .modal-content {
            position: relative;
            display: -ms-flexbox;
            display: flex;
            -ms-flex-direction: column;
            flex-direction: column;
            width: 100%;
            pointer-events: auto;
            background-color: #fff;
            background-clip: padding-box;
            border: 1px solid #e3e9ef;
            border-radius: .4375rem;
            box-shadow: 0 0.3rem 1.525rem -0.375rem rgba(0, 0, 0, 0.1);
            outline: 0;
        }

        .modal-header {
            -ms-flex-align: center;
            align-items: center;
        }

        button:not(:disabled),
        [type="button"]:not(:disabled),
        [type="reset"]:not(:disabled),
        [type="submit"]:not(:disabled) {
            cursor: pointer;
        }

        button.close {
            padding: 0;
            background-color: transparent;
            border: 0;
        }

        .modal-body {
            position: relative;
            -ms-flex: 1 1 auto;
            flex: 1 1 auto;
            padding: 1.25rem;
        }
    </style>
@endsection

@push('custom-js')
    <script>
        $(document).on('click', '[data-toggle="lightbox"]', function(event) {
            event.preventDefault();
            $(this).ekkoLightbox({
                onShown: function() {
                    var title = $(this).attr('data-title');
                    $('.ekko-lightbox .modal-title').text(title).css('text-align', 'left');
                }
            });
        });
    </script>
@endpush
