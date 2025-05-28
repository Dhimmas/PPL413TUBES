<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link href="{{ asset('css/todo.css') }}" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
        <link rel="stylesheet" href="{{ asset('css/quiz.css') }}">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-[#021c2d]"> {{-- Pastikan body memiliki background gelap --}}

        {{-- Navigation (tetap fixed di sini) --}}
        @include('layouts.navigation')

        <div class="min-h-screen flex flex-col pt-16">

            {{-- Header jika ada --}}
            @isset($header)
                {{-- Header ini sekarang tidak perlu pt-16 lagi, karena sudah ada di parent div --}}
                <header class="bg-[#03263c] bg-opacity-80 backdrop-blur-sm shadow text-white">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            {{-- Main content --}}
            <main class="flex-grow p-4"> {{-- p-4 akan menambahkan padding di semua sisi konten --}}
                {{ $slot }}
            </main>

            {{-- Footer --}}
            <footer class="bg-gray-900 text-white py-6">
                <div class="container mx-auto text-center">
                    <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
                </div>
            </footer>
        </div>

        <script src="{{ asset('js/todo.js') }}"></script>
    </body>
</html>