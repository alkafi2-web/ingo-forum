<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
    <link href="https://cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/4.0.1/ekko-lightbox.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('public/frontend/css/app.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('public/frontend/css/style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
</head>

<body>

    <!-- Header Section Start  -->
    @include('frontend.partials.header')
    {{-- @include('frontend.partials.breadcum') --}}
    <!-- Header Section end  -->
    @yield('frontend-section')
    <!-- footer Section Start  -->
    @include('frontend.partials.footer')
    <!-- footer Section End  -->

    <script src="{{ asset('public/frontend/js/jquery.min.js') }}"></script>
    <script src="{{ asset('public/frontend/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('public/frontend/js/fontawesome.min.js') }}"></script>
    <script src="https://cdn.tiny.cloud/1/emwvn1hivgqh9y7ups8vvy1id0vs2af4uh2rjhhtt1gpmjuj/tinymce/7/tinymce.min.js"
        referrerpolicy="origin"></script>
    <script src="{{ asset('public/frontend/js/all.min.js') }}"></script>
    <script src="{{ asset('public/frontend/js/owl-carousel/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('public/frontend/js/photo-gallery/unitegallery.min.js') }}"></script>
    <script src="{{ asset('public/frontend/js/photo-gallery/ug-theme-tiles.js') }}"></script>
    <script src="{{ asset('public/frontend/js/slick-slider/slick.min.js') }}"></script>
    <script src="{{ asset('public/admin/js/ekko-lightbox.js') }}"></script>
    <script src="{{ asset('public/frontend/js/main.js') }}"></script>
    <!-- Toastr JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="{{ asset('public/js/share.js') }}"></script>
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
    @stack('custom-js')
    {!! Toastr::message() !!}
    @if (session('success'))
        <script>
            toastr.success('{{ session('success') }}');
        </script>
    @endif

    @if (session('info'))
        <script>
            toastr.info('{{ session('info') }}');
        </script>
    @endif

    @if (session('warning'))
        <script>
            toastr.warning('{{ session('warning') }}');
        </script>
    @endif

    @if (session('error'))
        <script>
            toastr.error('{{ session('error') }}');
        </script>
    @endif

    @if (session('failed'))
        <script>
            toastr.error('{{ session('failed') }}');
        </script>
    @endif

    @if (session('errors'))
        @foreach (session('errors') as $error)
            <script>
                toastr.error('{{ $error }}');
            </script>
        @endforeach
    @endif

    @if ($errors->any())
        <script>
            @foreach ($errors->all() as $error)
                toastr.error('{{ $error }}');
            @endforeach
        </script>
    @endif

</body>

</html>
