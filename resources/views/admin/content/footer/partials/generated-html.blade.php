<div class="container">
    <div class="footer-top-area ">
        <div class="row ">
            <div class="col-md-4 mb-3 mb-md-0 builder-col">
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
            <div class="col-md-3 mb-3 mb-md-0 text-center text-md-start">
                <h4 class="footer-menu-title">About Us</h4>
                <nav class="footer-menu">
                    @foreach ($menus as $menu)
                        <ul>
                            @if ($menu->name === 'About' && $menu->subMenus->count())
                                @foreach ($menu->subMenus as $child)
                                    <li>
                                        @if ($child->type == 'route')
                                            <a href="{{ route($child->route) }}">{{ $child->name }}</a>
                                        @elseif ($child->type == 'page' && $child->page)
                                            <a href="{{ url($child->page->slug) }}">{{ $child->name }}</a>
                                        @elseif ($child->type == 'post' && $child->postCategory)
                                            <a href="{{ url($child->postCategory->slug) }}">{{ $child->name }}</a>
                                        @elseif ($child->type == 'url')
                                            <a href="{{ $child->url }}">{{ $child->name }}</a>
                                        @endif
                                    </li>
                                @endforeach
                            @else
                            @endif
                        </ul>
                    @endforeach
                </nav>
            </div>
            <div class="col-md-3 mb-3 mb-md-0 text-center text-md-start">
                <h4 class="footer-menu-title">Members</h4>
                <nav class="footer-menu">
                    @foreach ($menus as $menu)
                        <ul>
                            @if ($menu->name === 'Members' && $menu->subMenus->count())
                                @foreach ($menu->subMenus as $child)
                                    <li>
                                        @if ($child->type == 'route')
                                            <a href="{{ route($child->route) }}">{{ $child->name }}</a>
                                        @elseif ($child->type == 'page' && $child->page)
                                            <a href="{{ url($child->page->slug) }}">{{ $child->name }}</a>
                                        @elseif ($child->type == 'post' && $child->postCategory)
                                            <a
                                                href="{{ url($child->postCategory->slug) }}">{{ $child->name }}</a>
                                        @elseif ($child->type == 'url')
                                            <a href="{{ $child->url }}">{{ $child->name }}</a>
                                        @endif
                                    </li>
                                @endforeach
                            @else
                            @endif
                        </ul>
                    @endforeach
                </nav>
            </div>
            <div class="col-12 col-md-2 mb-3 mb-md-0 text-center text-md-start">
                <h4 class="footer-menu-title">Resources</h4>
                <nav class="footer-menu">
                    <ul>
                        <li><a href="">Privacy Policy</a></li>
                        <li><a href="">Terms and Conditions</a></li>
                        <li><a href="">Disclaimer</a></li>
                        <li><a href="">FAQ</a></li>
                        <li><a href="">Contact us</a></li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>
