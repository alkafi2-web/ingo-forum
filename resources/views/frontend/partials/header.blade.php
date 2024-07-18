<header class="header">
    <div class="top-bar bg-white py-2">
        <div class="container">
            <div class="topbar-content d-flex align-items-center justify-content-between">
                <div class="topbar-info d-flex align-items-center">
                    <div class="mail pe-3">
                        <img src="{{ asset('public/frontend/images/icons/email.png') }}" alt="">
                        <a href="" class="text-decoration-none ms-1">{{ $global['email'] }}</a>
                    </div>
                    <div class="phone ps-3">
                        <img src="{{ asset('public/frontend/images/icons/phone.png') }}" alt="">
                        <a href="" class="text-decoration-none ms-1">{{ $global['phone'] }}</a>
                    </div>
                </div>
                <div class="topbar-social">
                    <ul class="d-flex">
                        <li>
                            <a href="{{ $global['facebook'] }}" class="text-decoration-none"><i
                                    class="fa-brands fa-facebook"></i></a>
                        </li>
                        <li>
                            <a href="{{ $global['linkedin'] }}" class="text-decoration-none"><i
                                    class="fa-brands fa-linkedin-in"></i></a>
                        </li>
                        <li>
                            <a href="{{ $global['twitter'] }}" class="text-decoration-none"><i
                                    class="fa-brands fa-x-twitter"></i></a>
                        </li>
                        <li>
                            <a href="{{ $global['youtube'] }}" class="text-decoration-none"><i
                                    class="fa-brands fa-youtube"></i></a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- resources/views/partials/header.blade.php -->
    <nav class="navbar navbar-expand-lg bg-white">
        <div class="container">
            <a class="navbar-brand" href="{{ route('frontend.index') }}">
                <img class="logo" src="{{ asset('public/frontend/images/' . $global['logo'] ?? 'logo.png') }}"
                    alt="logo">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="{{ route('frontend.index') }}">Home</a>
                    </li>
                    @foreach ($menus as $menu)
                        <li class="nav-item {{ $menu->subMenus->count() ? 'dropdown' : '' }}">
                            @if ($menu->type == 'route')
                                <a class="nav-link {{ $menu->subMenus->count() ? 'dropdown-toggle' : '' }}"
                                    href="{{ route($menu->route) }}"
                                    {{ $menu->subMenus->count() ? 'role=button data-bs-toggle=dropdown aria-expanded=false' : '' }}>
                                    <span>{{ $menu->name }}</span>
                                    @if ($menu->subMenus->count())
                                        <i class="fa-solid fa-angle-down ms-2"></i>
                                    @endif
                                </a>
                            @elseif ($menu->type == 'page' && $menu->page)
                                <a class="nav-link {{ $menu->subMenus->count() ? 'dropdown-toggle' : '' }}"
                                    href="{{ url($menu->page->slug) }}"
                                    {{ $menu->subMenus->count() ? 'role=button data-bs-toggle=dropdown aria-expanded=false' : '' }}>
                                    <span>{{ $menu->name }}</span>
                                    @if ($menu->subMenus->count())
                                        <i class="fa-solid fa-angle-down ms-2"></i>
                                    @endif
                                </a>
                            @elseif ($menu->type == 'post' && $menu->postCategory)
                                <a class="nav-link {{ $menu->subMenus->count() ? 'dropdown-toggle' : '' }}"
                                    href="{{ url('post/'.$menu->postCategory->slug) }}"
                                    {{ $menu->subMenus->count() ? 'role=button data-bs-toggle=dropdown aria-expanded=false' : '' }}>
                                    <span>{{ $menu->name }}</span>
                                    @if ($menu->subMenus->count())
                                        <i class="fa-solid fa-angle-down ms-2"></i>
                                    @endif
                                </a>
                            @elseif ($menu->type == 'url')
                                <a class="nav-link {{ $menu->subMenus->count() ? 'dropdown-toggle' : '' }}"
                                    href="{{ $menu->url }}"
                                    {{ $menu->subMenus->count() ? 'role=button data-bs-toggle=dropdown aria-expanded=false' : '' }}>
                                    <span>{{ $menu->name }}</span>
                                    @if ($menu->subMenus->count())
                                        <i class="fa-solid fa-angle-down ms-2"></i>
                                    @endif
                                </a>
                            @endif

                            @if ($menu->subMenus->count())
                                <ul class="dropdown-menu">
                                    @foreach ($menu->subMenus as $child)
                                        @if ($child->type == 'route')
                                            <li><a class="dropdown-item"
                                                    href="{{ route($child->route) }}">{{ $child->name }}</a></li>
                                        @elseif ($child->type == 'page' && $child->page)
                                            <li><a class="dropdown-item"
                                                    href="{{ url($child->page->slug) }}">{{ $child->name }}</a></li>
                                        @elseif ($child->type == 'post' && $child->postCategory)
                                            <li><a class="dropdown-item" href="{{ url('post/'.$child->postCategory->slug) }}">{{ $child->name }}</a></li>
                                        @elseif ($child->type == 'url')
                                            <li><a class="dropdown-item"
                                                    href="{{ $child->url }}">{{ $child->name }}</a></li>
                                        @endif
                                    @endforeach
                                </ul>
                            @endif
                        </li>
                    @endforeach
                </ul>
                <form class="navbar-btn" role="search">
                    @if (Auth::guard('member')->check() && Auth::guard('member')->user()->status == 1)
                        <a href="{{ route('member.profile') }}" class="btn btn-outline-success">Profile</a>
                        <a href="{{ route('member.logout') }}" class="btn btn-outline-warning">Logout</a>
                    @else
                        <a href="{{ route('frontend.login') }}" class="btn btn-outline-success">Login</a>
                        <a href="{{ route('member') }}" class="btn btn-outline-success">Be a Member</a>
                    @endif
                </form>
            </div>
        </div>
    </nav>
</header>
