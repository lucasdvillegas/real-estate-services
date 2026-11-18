<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>@yield('title', 'Inicio') · {{ config('site.name') }}</title>
        <meta name="description" content="@yield('description', config('site.description'))">

        <link rel="icon" href="/favicon.ico" sizes="any">
        <link rel="icon" href="/favicon.svg" type="image/svg+xml">
        <link rel="apple-touch-icon" href="/apple-touch-icon.png">

        @fonts
        @vite(['resources/css/site.css', 'resources/js/site.js'])
    </head>
    <body class="flex min-h-screen flex-col bg-surface text-ink">
        <a href="#contenido" class="sr-only focus:not-sr-only focus:fixed focus:top-3 focus:left-3 focus:z-[60] focus:rounded-full focus:bg-ink focus:px-4 focus:py-2 focus:text-sm focus:text-surface">
            Saltar al contenido
        </a>

        @php
            $navItems = [
                ['label' => 'Inicio', 'href' => url('/'), 'active' => request()->is('/')],
                ['label' => 'Propiedades', 'href' => url('/propiedades'), 'active' => request()->is('propiedades*')],
                ['label' => 'Nosotros', 'href' => url('/nosotros'), 'active' => request()->is('nosotros*')],
                ['label' => 'Contacto', 'href' => url('/').'#contacto', 'active' => false],
            ];
        @endphp

        @include('site.partials.header')
        @include('site.partials.mobile-menu')

        <main id="contenido" class="flex-1">
            @yield('content')
        </main>

        @include('site.partials.footer')
    </body>
</html>
