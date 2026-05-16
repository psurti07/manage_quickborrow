<!doctype html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="{{ env('APP_NAME') }}">
        <meta name="keywords" content="{{ env('APP_NAME') }}">
        <meta name="author" content="{{ env('APP_NAME') }}">
        <meta property="og:title" content="{{ env('APP_NAME') }}" />
        <meta property="og:description" content="{{ env('APP_NAME') }}" />
        <meta property="og:image" content="{{ asset('assets/images/favicon-32x32.png') }}" />
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <!-- SITE TITLE -->
        <title>{{ env('APP_NAME') }} :: @yield('title')</title>

        <!-- FAVICON AND TOUCH ICONS -->
        <link rel="icon" href="{{asset('assets/images/logo/favicon.ico')}}" type="image/x-icon">
        <link rel="shortcut icon" href="{{asset('assets/images/logo/favicon.ico')}}" type="image/x-icon">

        <link rel="shortcut icon" href="{{ asset('assets/images/logo/favicon.ico') }}" type="image/x-icon" />
        <link rel="icon" href="{{ asset('assets/images/logo/favicon.ico') }}" type="image/x-icon" />
        <link rel="apple-touch-icon" sizes="152x152" href="{{ asset('assets/images/logo/apple-touch-icon-152x152.png') }}" />
        <link rel="apple-touch-icon" sizes="120x120" href="{{ asset('assets/images/logo/apple-touch-icon-120x120.png') }}" />
        <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('assets/images/logo/apple-touch-icon-76x76.png') }}" />
        <link rel="apple-touch-icon" href="{{ asset('assets/images/logo/apple-touch-icon-60x60.png') }}" />
        <link rel="icon" href="{{ asset('assets/images/logo/main-favicon-180x180.png') }}" type="image/x-icon" />
        <!-- GOOGLE FONTS -->
        <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@300;400;500;600;700&amp;display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&amp;display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&amp;display=swap" rel="stylesheet">
        <!-- BOOTSTRAP CSS -->
        <link href="{{ asset('front/css/bootstrap.min.css') }}" rel="stylesheet">
        <!-- FONT ICONS -->
        <link href="{{ asset('front/css/flaticon.css') }}" rel="stylesheet">
        <!-- PLUGINS STYLESHEET -->
        <link href="{{ asset('front/css/menu.css') }}" rel="stylesheet">
        <link id="effect" href="{{ asset('front/css/dropdown-effects/fade-down.css') }}" media="all" rel="stylesheet">
        <link href="{{ asset('front/css/magnific-popup.css') }}" rel="stylesheet">
        <link href="{{ asset('front/css/owl.carousel.min.css') }}" rel="stylesheet">
        <link href="{{ asset('front/css/owl.theme.default.min.css') }}" rel="stylesheet">
        <link href="{{ asset('front/css/lunar.css') }}" rel="stylesheet">
        <!-- ON SCROLL ANIMATION -->
        <link href="{{ asset('front/css/animate.css') }}" rel="stylesheet">
        <!-- TEMPLATE CSS -->
        <link href="{{ asset('front/css/crocus-theme.css') }}" rel="stylesheet">
        <link href="{{ asset('front/css/responsive.css') }}" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.3/toastr.min.css" />
        @stack('style-tag')
    </head>

    <body>
        <div id="page" class="page font--jakarta">
            @yield('content')
            <script src="{{ asset('front/js/jquery-3.7.0.min.js') }}"></script>
            <script src="{{ asset('front/js/bootstrap.min.js') }}"></script>
            <script src="{{ asset('front/js/menu.js') }}"></script>
            <script src="{{ asset('front/js/jquery.easing.js') }}"></script>
            <script src="{{ asset('front/js/jquery.appear.js') }}"></script>
            <script src="{{ asset('front/js/jquery.magnific-popup.min.js') }}"></script>
            <script src="{{ asset('front/js/jquery.ajaxchimp.min.js') }}"></script>
            <script src="{{ asset('front/js/owl.carousel.min.js') }}"></script>
            <script src="{{ asset('front/js/jquery.validate.min.js') }}"></script>
            <script src="{{ asset('front/js/lunar.js') }}"></script>
            <script src="{{ asset('front/js/wow.js') }}"></script>
            <script src="{{ asset('front/js/custom.js') }}"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.2/js/toastr.min.js"></script>
            @stack('script-tag')
            <script>
                $('.numeric-input').on('keydown', function(event) {
                    if (!(event.key === 'Backspace' || event.key === 'Delete' || (event.key >= '0' && event.key <= '9'))) {
                        event.preventDefault();
                    }
                });
            </script>
        </div>
    </body>
</html>
