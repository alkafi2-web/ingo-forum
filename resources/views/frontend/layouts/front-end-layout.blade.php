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
    <link rel="stylesheet" href="{{asset('public/frontend/css/owl.carousel.min.css')}}">
    <link rel="stylesheet" href="{{asset('public/frontend/css/owl.theme.default.min.css')}}">
    <link rel="stylesheet" href="{{asset('public/frontend/css/fontawesome.min.css')}}">
    <link rel="stylesheet" href="{{asset('public/frontend/css/all.min.css')}}">
    <link rel="stylesheet" href="{{asset('public/frontend/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('public/frontend/css/style.css')}}">
</head>

<body>
    
    <!-- Header Section Start  -->
    @include('frontend.partials.header')
    <!-- Header Section end  -->
    @yield('fontend-section')
    <!-- footer Section Start  -->
    @include('frontend.partials.footer')
    <!-- footer Section End  -->
    


    <script src="{{asset('public/frontend/js/jquery.min.js')}}"></script>
    <script src="{{asset('public/frontend/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset('public/frontend/js/fontawesome.min.js')}}"></script>
    <script src="{{asset('public/frontend/js/all.min.js')}}"></script>
    <script src="{{asset('public/frontend/js/owl.carousel.min.js')}}"></script>
    <script src="{{asset('public/frontend/js/main.js')}}"></script>
</body>

</html>
