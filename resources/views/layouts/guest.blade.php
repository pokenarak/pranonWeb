<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>วัดพระนอนจักรสีห์</title>
        <link rel="shortcut icon" type="image/x-icon" href="{{ asset('images/logo.png') }}">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.googleapis.com/css2?family=Krub:wght@200;300;500;700&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/scss/app.scss'])
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

        <!-- Styles -->
        @livewireStyles
        <style>
            img{
                width: 100%;
            }
            .cuttext{
                width:100%;
                overflow: hidden;
                display: -webkit-box;
                -webkit-line-clamp: 3;
                -webkit-box-orient: vertical;
            }
        </style>
    </head>
    <body style="font-family:Krub;">
        @include('user.navbaruser')
        <div class="container-xxl mt-5">
            {{ $slot }}
        </div>

        {{-- @livewireScripts --}}
    </body>
</html>
