<div class="scroll-to-top">
    <span id="scroll-top"><i class="fa-solid fa-arrow-up"></i></span>
</div>
<footer class="footer">
    <div class="container">
        <div class="footer-top-area">
            <div class="row">
                <div class="col-md-4 mb-3 mb-md-0">
                    <div class="footer-info">
                        <img src="{{ asset('public/frontend/images/' . $global['logo']) }}" alt="">
                        <p class="pt-3">{{ $global['short_content'] }}</p>
                        <div class="footer-social pt-2">
                            @php
                                $socialLinks = [
                                    'facebook' => 'fa-facebook-f',
                                    'linkedin' => 'fa-linkedin-in',
                                    'twitter' => 'fa-x-twitter',
                                    'youtube' => 'fa-youtube',
                                ];
                            @endphp
        
                            <nav class="d-flex align-items-center">
                                @foreach ($socialLinks as $key => $icon)
                                    @if (!empty($global[$key]))
                                        <a href="{{ $global[$key] }}" target="__blank" class="text-decoration-none"><i
                                                class="fa-brands {{ $icon }}"></i></a>
                                    @endif
                                @endforeach
                            </nav>
                        </div>
                    </div>
                </div>
        
                @php
                    $footerMenus = $menus->where('origin_type', 'footer')->take(3);
                    $count = $footerMenus->count();
                @endphp
        
                @if ($count == 1)
                    <div class="col-md-8 mb-3 mb-md-0 text-center text-md-start">
                        @foreach ($footerMenus as $menu)
                            <h4 class="footer-menu-title">{{ $menu->name }}</h4>
                            <nav class="footer-menu">
                                <ul>
                                    @foreach ($menu->subMenus as $child)
                                        <li>
                                            @if ($child->type == 'route')
                                                <a href="{{ route($child->route) }}">{{ $child->name }}</a>
                                            @elseif ($child->type == 'page' && $child->page)
                                                <a href="{{ url('post/' . $child->page->slug) }}">{{ $child->name }}</a>
                                            @elseif ($child->type == 'post' && $child->postCategory)
                                                <a href="{{ url('post/' . $child->postCategory->slug) }}">{{ $child->name }}</a>
                                            @elseif ($child->type == 'url')
                                                <a href="{{ $child->url }}">{{ $child->name }}</a>
                                            @endif
                                        </li>
                                    @endforeach
                                </ul>
                            </nav>
                        @endforeach
                    </div>
                @elseif ($count == 2)
                    @foreach ($footerMenus as $menu)
                        <div class="col-md-4 mb-3 mb-md-0 text-center text-md-start">
                            <h4 class="footer-menu-title">{{ $menu->name }}</h4>
                            <nav class="footer-menu">
                                <ul>
                                    @foreach ($menu->subMenus as $child)
                                        <li>
                                            @if ($child->type == 'route')
                                                <a href="{{ route($child->route) }}">{{ $child->name }}</a>
                                            @elseif ($child->type == 'page' && $child->page)
                                                <a href="{{ url('post/' . $child->page->slug) }}">{{ $child->name }}</a>
                                            @elseif ($child->type == 'post' && $child->postCategory)
                                                <a href="{{ url('post/' . $child->postCategory->slug) }}">{{ $child->name }}</a>
                                            @elseif ($child->type == 'url')
                                                <a href="{{ $child->url }}">{{ $child->name }}</a>
                                            @endif
                                        </li>
                                    @endforeach
                                </ul>
                            </nav>
                        </div>
                    @endforeach
                @elseif ($count == 3)
                    @foreach ($footerMenus as $index => $menu)
                        @if ($index < 2)
                            <div class="col-md-3 mb-3 mb-md-0 text-center text-md-start">
                                <h4 class="footer-menu-title">{{ $menu->name }}</h4>
                                <nav class="footer-menu">
                                    <ul>
                                        @foreach ($menu->subMenus as $child)
                                            <li>
                                                @if ($child->type == 'route')
                                                    <a href="{{ route($child->route) }}">{{ $child->name }}</a>
                                                @elseif ($child->type == 'page' && $child->page)
                                                    <a href="{{ url('post/' . $child->page->slug) }}">{{ $child->name }}</a>
                                                @elseif ($child->type == 'post' && $child->postCategory)
                                                    <a href="{{ url('post/' . $child->postCategory->slug) }}">{{ $child->name }}</a>
                                                @elseif ($child->type == 'url')
                                                    <a href="{{ $child->url }}">{{ $child->name }}</a>
                                                @endif
                                            </li>
                                        @endforeach
                                    </ul>
                                </nav>
                            </div>
                        @else
                            <div class="col-12 col-md-2 mb-3 mb-md-0 text-center text-md-start">
                                <h4 class="footer-menu-title">{{ $menu->name }}</h4>
                                <nav class="footer-menu">
                                    <ul>
                                        @foreach ($menu->subMenus as $child)
                                            <li>
                                                @if ($child->type == 'route')
                                                    <a href="{{ route($child->route) }}">{{ $child->name }}</a>
                                                @elseif ($child->type == 'page' && $child->page)
                                                    <a href="{{ url('post/' . $child->page->slug) }}">{{ $child->name }}</a>
                                                @elseif ($child->type == 'post' && $child->postCategory)
                                                    <a href="{{ url('post/' . $child->postCategory->slug) }}">{{ $child->name }}</a>
                                                @elseif ($child->type == 'url')
                                                    <a href="{{ $child->url }}">{{ $child->name }}</a>
                                                @endif
                                            </li>
                                        @endforeach
                                    </ul>
                                </nav>
                            </div>
                        @endif
                    @endforeach
                @endif
            </div>
        </div>        
        <div
            class="copyright-area d-flex flex-column flex-md-row align-items-center justify-content-center justify-content-md-between pt-3">
            <p class="text-center text-md-left">© Copyright 2021 <a href="" target="_blank">INGO Forum
                    Bangladesh</a>. All rights reserved</p>
            <p>Crafted ❤️️ by <a href="https://webase.com.bd" target="_blank">Webase</a></p>
        </div>
    </div>
</footer>
