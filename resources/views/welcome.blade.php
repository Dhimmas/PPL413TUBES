<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Studify!</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- AOS Animation -->
    <link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet">
</head>
<body class="bg-[#021c2d] text-white font-sans antialiased scroll-smooth">

    <!-- Navigation -->
    <header class="flex items-center justify-between md:justify-between px-6 py-4 bg-[#03263c] shadow-md fixed w-full z-50">
        <div class="flex items-center justify-center md:justify-start gap-2 w-full md:w-auto">
        <img src="/images/studify-logo.png" alt="Studify Logo" class="h-8 w-8 rounded-lg">
            <h1 class="text-2xl font-bold text-white">Studify</h1>
        </div>
        <nav class="space-x-4 hidden md:block">
            <a href="#features" class="hover:underline text-white/80 hover:text-white transition">Features</a>
            <a href="#tips" class="hover:underline text-white/80 hover:text-white transition">Tips</a>
            <a href="{{ route('login') }}" class="bg-white text-[#053f64] px-4 py-1 rounded-full font-semibold hover:bg-gray-200 transition">Login</a>
        </nav>
    </header>


    <!-- Hero Section -->
    <section class="relative flex flex-col justify-center items-center text-center h-screen px-6 pt-24 overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-br from-[#021c2d] via-[#03263c] to-[#021c2d] opacity-90 -z-10"></div>
        <div class="absolute w-[600px] h-[600px] bg-indigo-500/30 rounded-full blur-3xl animate-pulse -z-20 top-[-100px] right-[-100px]"></div>
        <h2 class="text-5xl font-extrabold mb-4 tracking-tight" data-aos="fade-up" data-aos-duration="800">Boost Your Study Productivity 🚀</h2>
        <p class="text-white/80 max-w-xl mb-6 leading-relaxed" data-aos="fade-up" data-aos-delay="200" data-aos-duration="800">
            Selamat datang di Studify — bantu kamu belajar lebih produktif, konsisten, dan terarah ✨
        </p>
        <div class="space-x-4" data-aos="zoom-in" data-aos-delay="400">
            <a href="{{ route('register') }}"
               class="bg-gradient-to-r from-indigo-500 to-indigo-700 hover:from-indigo-600 hover:to-indigo-800 text-white px-6 py-2 rounded-full transition transform hover:scale-105 font-semibold shadow-xl shadow-indigo-600/40">
               Get Started
            </a>
            <a href="#features"
               class="border border-white/30 bg-white/10 hover:bg-white/20 text-white px-6 py-2 rounded-full transition transform hover:scale-105 font-semibold backdrop-blur shadow">
               Learn More
            </a>
        </div>
        <div class="absolute bottom-6 animate-bounce text-white/70">
            <a href="#features" class="text-sm">↓ Scroll down</a>
        </div>
    </section>

    <!-- Wave Divider -->
    <div class="-mt-12">
        <svg viewBox="0 0 1440 320"><path fill="#03263c" fill-opacity="1" d="M0,256L48,250.7C96,245,192,235,288,202.7C384,171,480,117,576,96C672,75,768,85,864,112C960,139,1056,181,1152,181.3C1248,181,1344,139,1392,117.3L1440,96L1440,320L0,320Z"></path></svg>
    </div>

    <!-- Features Section -->
    <section id="features" class="px-6 py-20 bg-[#03263c]">
        <h3 class="text-3xl font-bold text-center mb-12" data-aos="fade-up">✨ Main Features</h3>
        <div class="grid sm:grid-cols-2 md:grid-cols-3 gap-8 text-center">
            @foreach([
                ['🏠', 'Home', 'Navigasi utama ke dashboard setelah login.'],
                ['📝', 'To-Do', 'Atur dan kelola tugas belajar harianmu dengan mudah.'],
                ['🎯', 'Goals', 'Tentukan target belajar jangka pendek dan panjang.'],
                ['📈', 'Progress', 'Lihat progres belajarmu secara visual dan terukur.'],
                ['👤', 'Profile', 'Kelola profil dan informasi akunmu.'],
                ['🤖', 'Chatbot', 'Tanya apa pun ke AI helper yang siap bantu belajar.'],
                ['🎓', 'LMS', 'Akses materi pembelajaran langsung dari platform.'],
                ['💬', 'Forum Diskusi', 'Berdiskusi dan bertanya bersama pengguna lain.'],
            ] as $i => [$icon, $title, $desc])
                <div class="group bg-white/10 backdrop-blur-md rounded-xl p-6 hover:bg-white/20 transition shadow text-white transform hover:scale-105 relative overflow-hidden" data-aos="fade-up" data-aos-delay="{{ $i * 100 }}">
                    <div class="absolute top-0 left-0 w-full h-full opacity-10 bg-gradient-to-br from-indigo-400 to-cyan-400 pointer-events-none z-0"></div>
                    <div class="relative z-10">
                        <div class="text-4xl mb-3 group-hover:scale-125 transition-transform duration-300">{{ $icon }}</div>
                        <h4 class="font-semibold text-lg mb-1">{{ $title }}</h4>
                        <p class="text-sm text-white/80">{{ $desc }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    <!-- Study Tips Section -->
    <section id="tips" class="px-6 py-20 bg-[#021c2d]">
        <h3 class="text-3xl font-bold text-center mb-12" data-aos="fade-up">📚 Quick Study Tips</h3>
        <div class="max-w-3xl mx-auto grid sm:grid-cols-2 gap-6">
            @foreach([
                'Tentukan tujuan belajar yang jelas.',
                'Gunakan teknik Pomodoro atau time-blocking.',
                'Aktifkan belajar dengan mind map atau flashcards.',
                'Cukup tidur & istirahat secara berkala.',
                'Jaga pola makan dan hidrasi untuk konsentrasi.',
            ] as $i => $tip)
                <div class="bg-white/10 backdrop-blur-md rounded-lg p-4 hover:bg-white/20 transition transform hover:scale-[1.03] shadow-md text-white/90" data-aos="fade-up" data-aos-delay="{{ $i * 100 }}">
                    ✅ {{ $tip }}
                </div>
            @endforeach
        </div>
    </section>

    <!-- App Advantages Section -->
    <section id="advantages" class="px-6 py-20 bg-[#03263c]">
        <h3 class="text-3xl font-bold text-center mb-12" data-aos="fade-up">🚀 Why Studify?</h3>
        <div class="grid sm:grid-cols-2 md:grid-cols-3 gap-8 text-center">
            @foreach([
                ['💡', 'User-Friendly', 'Interface yang sederhana dan mudah digunakan oleh siapa saja.'],
                ['📊', 'Real-Time Progress', 'Pantau progres belajar secara real-time dengan grafik yang jelas.'],
                ['📅', 'Flexible Scheduling', 'Fitur jadwal yang dapat disesuaikan dengan rutinitas harianmu.'],
                ['🤖', 'Smart Assistance', 'Akses chatbot AI yang siap membantu kapan saja dalam belajar.'],
                ['🌐', 'Multi-Platform', 'Akses aplikasi di berbagai perangkat, kapan saja, di mana saja.'],
                ['💬', 'Collaborative', 'Berkolaborasi dengan teman melalui fitur forum dan diskusi.'],
            ] as $i => [$icon, $title, $desc])
                <div class="group bg-white/10 backdrop-blur-md rounded-xl p-6 hover:bg-white/20 transition shadow text-white transform hover:scale-105 relative overflow-hidden" data-aos="fade-up" data-aos-delay="{{ $i * 100 }}">
                    <div class="absolute top-0 left-0 w-full h-full opacity-10 bg-gradient-to-br from-indigo-400 to-cyan-400 pointer-events-none z-0"></div>
                    <div class="relative z-10">
                        <div class="text-4xl mb-3 group-hover:scale-125 transition-transform duration-300">{{ $icon }}</div>
                        <h4 class="font-semibold text-lg mb-1">{{ $title }}</h4>
                        <p class="text-sm text-white/80">{{ $desc }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-[#03263c] text-center py-6 text-white/60 text-sm">
        &copy; {{ date('Y') }} Studify. All rights reserved.
    </footer>

    <!-- AOS Script -->
    <script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>
</body>
</html>
