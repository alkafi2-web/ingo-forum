@extends('frontend.layouts.frontend-page-layout')
@section('page-title', 'Our Mmebers')
@section('frontend-section')
    <!-- Photo Gallery Area start here  -->
    <section class="photo-gallery-page ptb-50">
        <div class="container">
            <div class="row gy-3 gy-md-5 gx-3 gx-md-4 px-1">
                <div class="col-6 col-md-4">
                    <div class="gallery-card h-100">
                        <div class="gallery-img">
                            <a href="./single-photo-gallery.php"><img src="images/gallery1.png" alt=""></a>
                            <a href="./single-photo-gallery.php"><img src="images/gallery3.png" alt=""></a>
                            <a href="./single-photo-gallery.php"><img src="images/gallery2.png" alt=""></a>
                        </div>
                        <div class="blog-content">
                            <span class="mini-title">#Education</span>
                            <h3 class="blog-title line-clamp-2"><a href="./single-photo-gallery.php">Children Education</a>
                            </h3>
                            <p class="line-clamp-3">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod
                                tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.</p>
                            <div class="blog-publice py-1">
                                <div class="row pb-1">
                                    <div class="col-6 border-right">
                                        <div class="d-flex align-items-center">
                                            <img src="images/icons/calender.png" alt="">
                                            <div class="ms-2">
                                                <span class="d-block fw-semibold">Date:</span>
                                                <span class="blog-date-admin">10 Jun</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="d-flex d-flex align-items-center">
                                            <img src="images/icons/profile.png" alt="">
                                            <div class="ms-2">
                                                <span class="d-block fw-semibold">By:</span>
                                                <span class="blog-date-admin">Admin</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
            <div class="row pt-4">
                <div class="col-12">
                    <nav class="pagination">
                        <ul>
                            <li><a href="">Prev</a></li>
                            <li><a href="" class="active">1</a></li>
                            <li><a href="">2</a></li>
                            <li><a href="">3</a></li>
                            <li><a href="">...</a></li>
                            <li><a href="">10</a></li>
                            <li><a href="">Next</a></li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </section>
    <!-- Photo Gallery end here  -->
@endsection
