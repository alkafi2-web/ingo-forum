<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>INGO Forum Bangladesh</title>
    <link href="https://fonts.cdnfonts.com/css/avenir" rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css2?family=Fredoka:wght@300..700&family=Raleway:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('public/frontend/css/owl-carousel/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public/frontend/css/owl-carousel/owl.theme.default.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public/frontend/css/fontawesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public/frontend/css/photo-gallery/unite-gallery.css') }}">
    <link rel="stylesheet" href="{{ asset('public/frontend/css/slick-slider/slick.css') }}">
    <link rel="stylesheet" href="{{ asset('public/frontend/css/slick-slider/slick-theme.css') }}">
    <link rel="stylesheet" href="{{ asset('public/frontend/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public/frontend/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public/frontend/css/style.css') }}">
</head>

<body>

    <!-- Header Section Start  -->
    @include('frontend.partials.header')
    <!-- Header Section end  -->
    @yield('fontend-section')
    <!-- footer Section Start  -->
    @include('frontend.partials.footer')
    <!-- footer Section End  -->



    <script src="{{ asset('public/frontend/js/jquery.min.js') }}"></script>
    <script src="{{ asset('public/frontend/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('public/frontend/js/fontawesome.min.js') }}"></script>
    <script src="https://cdn.tiny.cloud/1/emwvn1hivgqh9y7ups8vvy1id0vs2af4uh2rjhhtt1gpmjuj/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>
    <script src="{{ asset('public/frontend/js/all.min.js') }}"></script>
    <script src="{{ asset('public/frontend/js/owl-carousel/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('public/frontend/js/photo-gallery/unitegallery.min.js') }}"></script>
    <script src="{{ asset('public/frontend/js/photo-gallery/ug-theme-tiles.js') }}"></script>
    <script src="{{ asset('public/frontend/js/slick-slider/slick.min.js') }}"></script>
    <script src="{{ asset('public/frontend/js/main.js') }}"></script>
</body>

</html>
