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

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white dark:bg-gray-800 shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>
    </body>
</html>
=======
<!-- resources/views/layouts/app.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', config('app.name'))</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSS / Tailwind -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body class="font-sans antialiased bg-gray-50">

    {{-- Navbar --}}
    <nav class="bg-gradient-to-r from-indigo-600 to-blue-500 shadow-lg p-4">
        <div class="container mx-auto flex justify-between items-center">
            <a href="{{ route('home') }}" class="text-white text-2xl font-bold hover:text-indigo-100 transition duration-300">{{ config('app.name') }}</a>

            <div class="space-x-4">
                @auth
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="text-white px-4 py-2 rounded-md bg-red-600 hover:bg-red-700 transition duration-300">Logout</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="text-white hover:text-indigo-100 transition duration-300">Login</a>
                    <a href="{{ route('register') }}" class="text-white hover:text-indigo-100 transition duration-300">Register</a>
                @endauth
            </div>
        </div>
    </nav>

    {{-- Hero Section (Optional) --}}
    <section class="bg-gradient-to-r from-purple-600 to-pink-500 text-white text-center py-20">
        <h1 class="text-5xl font-extrabold">Welcome to {{ config('app.name') }}</h1>
        <p class="mt-4 text-lg">Your platform for managing tasks with style and efficiency.</p>
    </section>

    {{-- Konten Halaman --}}
    <main class="container mx-auto py-12">
        @yield('content')
    </main>

    {{-- Footer (Optional) --}}
    <footer class="bg-gray-800 text-white py-6">
        <div class="container mx-auto text-center">
            <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
        </div>
    </footer>

    <!-- Optional JS -->
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
    </form>

