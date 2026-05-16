    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="{{ env('APP_NAME') }}">
        <meta name="keywords" content="{{ env('APP_NAME') }}">
        <meta name="author" content="{{ env('APP_NAME') }}">
        <meta property="og:title" content="{{ env('APP_NAME') }}" />
        <meta property="og:description" content="{{ env('APP_NAME') }}" />
        <meta property="og:image" content="{{ asset('assets/images/logo/favicon-32x32.png') }}" />
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="icon" href="{{asset('assets/images/logo/favicon.ico')}}" type="image/x-icon">
        <link rel="shortcut icon" href="{{asset('assets/images/logo/favicon.ico')}}" type="image/x-icon">
        <title>{{ env('APP_NAME') }} :: @yield('title')</title>
        <!-- Google font-->
        <link href="https://fonts.googleapis.com/css?family=Rubik:400,400i,500,500i,700,700i&amp;display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Roboto:300,300i,400,400i,500,500i,700,700i,900&amp;display=swap" rel="stylesheet">
        @include('stacks.css.auth.css-links')
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css"/>
    </head>
