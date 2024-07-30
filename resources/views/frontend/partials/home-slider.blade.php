<!-- Hero Section Start  -->
<section>
    <div class="owl-carousel owl-theme hero-slider">
        @forelse ($global['banner'] as $banner) 
        <div class="item">
            <div class="hero-section ptb-70 d-flex align-items-center" 
                @if($banner['background_color']['status'] ?? false) 
                    style="background-color: {{ $banner['background_color']['color'] }}"
                @else 
                    style="background-image: url('{{ asset('public/frontend/images/banner/' . ($banner['bg_image']['path'] ?? 'default-bg.jpg')) }}')"
                @endif
                >
                @if(!$banner['background_color']['status'] && ($banner['overlay_color']['status'] ?? false))
                <div class="hero-overlay" style="background-color: {{ $banner['overlay_color']['color'] }}"></div>
                @endif
                <div class="container">
                    <div class="row d-flex align-items-center">
                        <div class="col-lg-6 hero-left mb-2 lg-mb-0">
                            @if($banner['title']['status'] ?? false)
                            <h1 style="color: {{ $banner['title']['color'] }}">{{ $banner['title']['text'] }}</h1>
                            @endif
                            @if($banner['description']['status'] ?? false)
                            <p class="pb-3" style="color: {{ $banner['description']['color'] }}">{{ $banner['description']['text'] }}</p>
                            @endif
                            @if(($banner['button']['status'] ?? false) && isset($banner['button']))
                            <a href="{{ $banner['button']['url'] }}" class="ct-btn" style="background-color: {{ $banner['button']['bg_color'] }}; color: {{ $banner['button']['color'] }}">{{ $banner['button']['text'] }}</a>
                            @endif
                        </div>
                        <div class="col-lg-6 hero-right">
                            @if($banner['content_image']['status'] ?? false)
                            <img src="{{ asset('public/frontend/images/banner/' . ($banner['content_image']['path'] ?? 'default-content.jpg')) }}" alt="banner image">
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <!-- Default Banner -->
        <div class="item">
            <div class="hero-section ptb-70" style="background-image: url('{{ asset('public/frontend/images/banner/bg.png') }}'); background-color: #D7E8E0;">
                <div class="hero-overlay" style="background-color: rgba(0, 0, 0, 0.5);"></div>
                <div class="container">
                    <div class="row d-flex align-items-center">
                        <div class="col-lg-6 hero-left mb-2 lg-mb-0">
                            <h1>Lorem ipsum is placeholder text commonly used in the graphic, print, mockups.</h1>
                            <p class="pb-3">Lorem ipsum dolor sit amet consectetur adipisicing elit. Assumenda rem iure, quidem neque quae dolorem consequatur dolorum corrupti perspiciatis vero unde, doloribus temporibus itaque maxime. Molestiae vel enim ab dolor.</p>
                            <a href="{{ route('member') }}" class="ct-btn btn-yellow">Be a Member</a>
                        </div>
                        <div class="col-lg-6 hero-right">
                            <img src="{{ asset('public/frontend/images/hero-img.png') }}" alt="default hero image">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforelse
    </div>
</section>
