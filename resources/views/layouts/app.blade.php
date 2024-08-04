<!DOCTYPE html>
<html x-data lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-[100vh] {{ session('theme') }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @wireUiScripts
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @livewireScriptConfig
        <!-- Styles -->

        @laravelPWA
    </head>
    <body class="font-sans antialiased soft-scrollbar">
        @persist('dictionaries')
            <livewire:nomenclature.nomenclature-dictionary lazy/>
        @endpersist
        <x-preloader></x-preloader>

        <div class="min-h-screen bg-primary-100 dark:bg-primary-900">
            <div class="sticky top-0 z-50">
                @persist('navigation')
                    @livewire('navigation')
                @endpersist
            </div>

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-secondary-500 shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>

            <div id="footer"></div>
        </div>
        @persist('notifications')
            <x-notifications z-index="z-50"></x-notifications>
            <x-dialog z-index="z-50" blur="md" align="center"></x-dialog>
        @endpersist

        @stack('modals')
    </body>
</html>
