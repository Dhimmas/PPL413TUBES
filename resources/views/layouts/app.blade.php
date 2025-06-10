<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Study Goals</title>

    <!-- CSS Umum (untuk semua halaman) -->
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <link rel="stylesheet" href="{{ asset('css/goal-form.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <!-- Import Pikaday CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/pikaday/1.8.0/css/pikaday.min.css">

<!-- Import Pikaday JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/pikaday/1.8.0/pikaday.min.js"></script>
    <!-- CSS Halaman Khusus -->
    @yield('styles')  <!-- Akan mengisi CSS khusus setiap halaman -->
</head>
<body>

    <div class="container">
        <!-- Sidebar navigation (Mobile overlay) -->
       <div class="sidebar" id="sidebar">
    <!-- Close button for sidebar -->
    <span class="close-btn" onclick="toggleSidebar()">×</span>
    <ul>
        <li><a href="{{ route('study-goals.index') }}"><i class="fas fa-chart-pie"></i> Goal Overview</a></li>
        <li><a href="{{ route('study-goals.create') }}"><i class="fas fa-plus-circle"></i> Add Goal</a></li>
        <li><a href="{{ route('study-goals.today') }}"><i class="fas fa-calendar-day"></i> Today</a></li>
        <li><a href="{{ route('study-goals.upcoming') }}"><i class="fas fa-calendar"></i> Upcoming</a></li>
        <li><a href="{{ route('study-goals.completed') }}"><i class="fas fa-check-circle"></i> Completed</a></li>
    </ul>
</div>

<!-- Hamburger Icon -->
<div class="hamburger-menu" id="hamburgerMenu" onclick="toggleSidebar()">
    <i class="fas fa-bars"></i>
</div>

<!-- Main Content -->
<div class="main-content" id="mainContent">
            <!-- Hamburger Icon (for mobile) -->
            <div class="hamburger-menu" id="hamburgerMenu" onclick="toggleSidebar()">
                <i class="fas fa-bars"></i>
            </div>

            @yield('content')
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    @yield('scripts')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    <script>
   // Function to toggle sidebar visibility
// Function to toggle sidebar visibility
    function toggleSidebar() {
    const sidebar = document.getElementById('sidebar');
    const mainContent = document.getElementById('mainContent');
    const hamburgerMenu = document.getElementById('hamburgerMenu');
    
    // Toggle sidebar active class untuk menampilkan atau menyembunyikan sidebar
    sidebar.classList.toggle('active');
    
    // Tambahkan atau hapus overlay di konten utama
    mainContent.classList.toggle('overlay');
    
    // Toggle visibility of hamburger menu (move it behind the sidebar)
    if (sidebar.classList.contains('active')) {
        hamburgerMenu.style.zIndex = "998";  // Hamburger menu akan berada di bawah sidebar
    } else {
        hamburgerMenu.style.zIndex = "999";  // Hamburger menu akan berada di atas overlay
    }
}

// Function to close sidebar when clicking close button
function closeSidebar() {
    const sidebar = document.getElementById('sidebar');
    const mainContent = document.getElementById('mainContent');
    const hamburgerMenu = document.getElementById('hamburgerMenu');
    
    // Hapus kelas active untuk menyembunyikan sidebar
    sidebar.classList.remove('active');
    
    // Hapus overlay pada konten utama
    mainContent.classList.remove('overlay');
    
    // Hamburger menu kembali di atas
    hamburgerMenu.style.zIndex = "999";  // Hamburger menu akan berada di atas
}

// Close sidebar if clicked outside
$(document).click(function(event) {
    if (!$(event.target).closest('#sidebar, #hamburgerMenu').length) {
        if ($('#sidebar').hasClass('active')) {
            toggleSidebar();  // Menutup sidebar saat klik di luar sidebar
        }
    }
});


</script>

</body>
</html>

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Your custom CSS files -->
        <link href="{{ asset('css/todo.css') }}" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
        <link rel="stylesheet" href="{{ asset('css/quiz.css') }}">

        <!-- Font Awesome CSS CDN -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

        <!-- Scripts (Vite akan meng-compile dan memuat app.css dan app.js) -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        @stack('head_scripts') 
    </head>
    <body class="font-sans antialiased bg-[#021c2d]">

        @include('layouts.navigation')

        <div class="min-h-screen flex flex-col pt-16">

            {{-- Header --}}
            @isset($header)
                <header class="bg-[#03263c] bg-opacity-80 backdrop-blur-sm shadow text-white">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            {{-- Main content --}}
            <main class="flex-grow p-4">
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

        @stack('scripts')
    </body>
</html>

