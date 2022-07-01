<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('layouts.includes._base', ['favicon' => $favicon])

        <!-- Title -->
        <title>{{ $title }} | Pencatatan Pajak</title>

        <!-- Mengatur style pada header-->
        {{ $styles }}

    </head>

    <body>
        @yield('body')
    </body>
</html>
