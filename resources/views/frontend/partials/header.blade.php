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
                    @php
                        $socialLinks = [
                            'facebook' => 'fa-facebook',
                            'linkedin' => 'fa-linkedin-in',
                            'twitter' => 'fa-x-twitter',
                            'youtube' => 'fa-youtube',
                        ];
                    @endphp

                    <ul class="d-flex">
                        @foreach ($socialLinks as $key => $icon)
                            @if (!empty($global[$key]))
                                <li>
                                    <a href="{{ $global[$key] }}" target="__blank" class="text-decoration-none"><i
                                            class="fa-brands {{ $icon }}"></i></a>
                                </li>
                            @endif
                        @endforeach
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
                    @foreach ($menus->where('origin_type', 'header') as $menu)
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
                                    href="{{ url('post/' . $menu->postCategory->slug) }}"
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
                                        @if ($child->visibility == 1)
                                            @if ($child->type == 'route')
                                                <li><a class="dropdown-item"
                                                        href="{{ route($child->route) }}">{{ $child->name }}</a></li>
                                            @elseif ($child->type == 'page' && $child->page)
                                                <li><a class="dropdown-item"
                                                        href="{{ url($child->page->slug) }}">{{ $child->name }}</a>
                                                </li>
                                            @elseif ($child->type == 'post' && $child->postCategory)
                                                <li><a class="dropdown-item"
                                                        href="{{ url('post/' . $child->postCategory->slug) }}">{{ $child->name }}</a>
                                                </li>
                                            @elseif ($child->type == 'url')
                                                <li><a class="dropdown-item"
                                                        href="{{ $child->url }}">{{ $child->name }}</a></li>
                                            @endif
                                        @endif
                                    @endforeach
                                </ul>
                            @endif
                        </li>
                    @endforeach
                </ul>
                {{-- <form class="navbar-btn" role="search">
                    @if (Auth::guard('member')->check() && Auth::guard('member')->user()->status == 1)
                        <a href="{{ route('member.profile') }}" class="btn btn-outline-success">Dashboard</a>
                        <a href="{{ route('member.own.profile') }}" class="btn btn-outline-success">Profile</a>
                        <a href="{{ route('member.logout') }}" class="btn btn-outline-warning">Logout</a>
                    @else
                        <a href="{{ route('frontend.login') }}" class="btn btn-outline-success">Login</a>
                        <a href="{{ route('member') }}" class="btn btn-outline-success">Be a Member</a>
                    @endif
                </form> --}}
                <div class="dropdown navbar-btn">
                    <button class="btn btn-outline-warning dropdown-toggle" type="button" id="navbarDropdown"
                        data-bs-toggle="dropdown" aria-expanded="false">

                        @auth('member')
                            @if (Auth::guard('member')->user()->status == 1)
                                @php
                                    $member = Auth::guard('member')->user();
                                    $organisationName = $member->info
                                        ? $member->info->organisation_name
                                        : 'Not Available';
                                @endphp
                                {{ $organisationName }}
                            @else
                                Login / Be A Member
                            @endif
                        @else
                            Login / Be A Member
                        @endauth
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        @if (Auth::guard('member')->check() && Auth::guard('member')->user()->status == 1)
                            <li><a class="dropdown-item" href="{{ route('member.dashboard') }}"><i
                                        class="fas fa-tachometer-alt"></i> Dashboard</a></li>
                            <li><a class="dropdown-item" href="{{ route('member.own.profile') }}"><i
                                        class="fas fa-user"></i> Profile</a></li>
                            <li><a class="dropdown-item" href="{{ route('member.logout') }}"><i
                                        class="fas fa-sign-out-alt"></i> Logout</a></li>
                        @else
                            <li><a class="dropdown-item" href="{{ route('frontend.login') }}"><i
                                        class="fas fa-sign-in-alt"></i> Login</a></li>
                            <li><a class="dropdown-item" href="{{ route('member') }}"><i class="fas fa-user-plus"></i>
                                    Be a Member</a></li>
                            {{-- <li><a href="{{ route('frontend.login') }}" >Login</a></li>
                            <li><a href="{{ route('member') }}" class="btn btn-outline-success">Be a Member</a></li> --}}
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </nav>
</header>
