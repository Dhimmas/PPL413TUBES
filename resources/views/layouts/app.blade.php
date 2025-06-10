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
