<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>
            @hasSection('page-title')
                @yield('page-title') -
            @endif
            {{ config('app.name', 'Laravel') }}
        </title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @wireUiScripts
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @livewireStyles
        @livewireScripts
    </head>
    <body class="bg-[url('/images/intro.jpg')]">
        <div class="fixed flex gap-4 p-6 justify-end w-full">
            @unless(request()->is('login'))
                <x-button sm emerald flat href="{{ route('login') }}">Войти</x-button>
            @endunless
            @unless(request()->is('register'))
                <x-button sm emerald flat href="{{ route('register') }}">Зарегистрироваться</x-button>
            @endunless
        </div>
        <div class="font-sans text-gray-900 antialiased">
            {{ $slot }}
        </div>
    </body>
</html>
