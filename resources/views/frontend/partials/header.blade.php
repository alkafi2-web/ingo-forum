<header class="header">
    <div class="top-bar bg-white py-2">
        <div class="container">
            <div class="topbar-content d-flex align-items-center justify-content-between">
                <div class="topbar-info d-flex align-items-center">
                    <div class="mail pe-3">
                        <img src="{{asset('public/frontend/images/icons/email.png')}}" alt="">
                        <a href="" class="text-decoration-none ms-1">{{$global['email']}}</a>
                    </div>
                    <div class="phone ps-3">
                        <img src="{{asset('public/frontend/images/icons/phone.png')}}" alt="">
                        <a href="" class="text-decoration-none ms-1">{{$global['phone']}}</a>
                    </div>
                </div>
                <div class="topbar-social">
                    <ul class="d-flex">
                        <li>
                            <a href="{{$global['facebook']}}" class="text-decoration-none"><i
                                    class="fa-brands fa-facebook"></i></a>
                        </li>
                        <li>
                            <a href="{{$global['linkedin']}}" class="text-decoration-none"><i
                                    class="fa-brands fa-linkedin-in"></i></a>
                        </li>
                        <li>
                            <a href="{{$global['twitter']}}" class="text-decoration-none"><i
                                    class="fa-brands fa-x-twitter"></i></a>
                        </li>
                        <li>
                            <a href="{{$global['youtube']}}" class="text-decoration-none"><i
                                    class="fa-brands fa-youtube"></i></a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <nav class="navbar navbar-expand-lg bg-white">
        <div class="container">
            <a class="navbar-brand" href="index.php"><img class="logo" src="{{asset('public/frontend/images/'.$global['logo'])}}" alt="logo"></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="{{route('frontend.index')}}">Home</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            <span>About Us</span>
                            <i class="fa-solid fa-angle-down ms-2"></i>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">Why INGO Forum</a></li>
                            <li><a class="dropdown-item" href="#">What we do.</a></li>
                            <li><a class="dropdown-item" href="#">Governance and structure</a></li>
                            <li><a class="dropdown-item" href="#">Values and principles</a></li>
                            <li><a class="dropdown-item" href="#">Executive Committee members</a></li>
                            <li><a class="dropdown-item" href="#">FAQs</a></li>
                            <li><a class="dropdown-item" href="#">Contact us</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            <span>Members</span>
                            <i class="fa-solid fa-angle-down ms-2"></i>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">Our members</a></li>
                            <li><a class="dropdown-item" href="#">Membership Criteria</a></li>
                            <li><a class="dropdown-item" href="{{route('member')}}">Become a member/ Join us</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <span>Press and Media</span>
                            <i class="fa-solid fa-angle-down ms-2"></i>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">Latest News</a></li>
                            <li><a class="dropdown-item" href="#">Photos Gallery</a></li>
                            <li><a class="dropdown-item" href="#">Video Gallery</a></li>
                            <li><a class="dropdown-item" href="#">National Events (calendar type)</a></li>
                            <li><a class="dropdown-item" href="#">Blogs</a></li>
                            <li><a class="dropdown-item" href="#">Forum</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <span>Resources</span>
                            <i class="fa-solid fa-angle-down ms-2"></i>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">Policy/ Strategies</a></li>
                            <li><a class="dropdown-item" href="#">Reports</a></li>
                            <li><a class="dropdown-item" href="#">Publications</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Contact</a>
                    </li>
                </ul>
                <form class="navbar-btn" role="search">
                    <button class="btn btn-outline-success" type="submit">Be a Member</button>
                </form>
            </div>
        </div>
    </nav>
</header>