<x-app-layout>
    @php
        $hour = now()->format('H');
        $greeting = $hour < 12 ? 'Good Morning' : ($hour < 18 ? 'Good Afternoon' : 'Good Evening');
    @endphp

    <div x-data="{ open: false }" class="flex bg-[#021c2d] text-white min-h-screen">
        <!-- Sidebar -->
        <aside class="w-64 bg-gradient-to-b from-[#03263c] to-[#021623] p-6 hidden md:flex flex-col fixed h-full z-30 shadow-xl">
            <div class="flex flex-col items-center mb-6">
                <img src="{{ asset('images/studify-logo.png') }}" alt="Studify Logo" class="w-32 h-32 mb-2">
                <h2 class="text-2xl font-bold text-center">Studify</h2>
            </div>
            <nav class="space-y-4">
                @foreach([
                    ['🏠', 'Home', 'dashboard'],
                    ['📝', 'To-Do', 'to_do'],
                    ['🎯', 'Goals', 'goals'],
                    ['📈', 'Progress', 'progress'],
                    ['👤', 'Profile', 'profile'],
                    ['🤖', 'Chatbot', 'chatbot'],
                    ['🎓', 'LMS', 'lms'],
                    ['💬', 'Forum Diskusi', 'forum.index'], // Correct route name
                ] as [$icon, $label, $routeName])
                    <a href="{{ route($routeName) }}" class="flex items-center space-x-3 text-sm font-medium p-3 rounded-xl bg-white/10 hover:bg-white/20 transition hover:scale-105">
                        <span class="text-xl">{{ $icon }}</span>
                        <span>{{ $label }}</span>
                    </a>
                @endforeach
            </nav>
        </aside>

        <!-- Mobile Toggle -->
        <div class="md:hidden fixed top-4 left-4 z-40">
            <button @click="open = !open"
                class="bg-black/50 hover:bg-black/70 text-white p-2 rounded-full shadow-md transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
        </div>

        <!-- Mobile Sidebar -->
        <div :class="{ 'translate-x-0': open, '-translate-x-full': !open }"
            class="fixed top-0 left-0 w-64 bg-gradient-to-b from-[#03263c] to-[#021623] p-6 transform transition-transform duration-300 z-50 h-full md:hidden shadow-lg">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-xl font-bold">Menu</h2>
                <button @click="open = false">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 hover:text-red-400 transition" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <nav class="space-y-4">
                @foreach([
                    ['🏠', 'Home', 'dashboard'],
                    ['📝', 'To-Do', 'to_do'],
                    ['🎯', 'Goals', 'goals'],
                    ['📈', 'Progress', 'progress'],
                    ['👤', 'Profile', 'profile'],
                    ['🤖', 'Chatbot', 'chatbot'],
                    ['🎓', 'LMS', 'lms'],
                    ['💬', 'Forum Diskusi', 'forum.index'], // Correct route name
                ] as [$icon, $label, $routeName])
                    <a href="{{ route($routeName) }}" class="flex items-center space-x-3 text-sm font-medium p-3 rounded-xl bg-white/10 hover:bg-white/20 transition hover:scale-105">
                        <span class="text-xl">{{ $icon }}</span>
                        <span>{{ $label }}</span>
                    </a>
                @endforeach
            </nav>
        </div>

        <!-- Main Content -->
        <main class="flex-1 ml-0 md:ml-64 p-6">
            <!-- Greeting -->
            <div class="mb-6">
                <h2 class="text-2xl font-bold mb-1">{{ $greeting }}, {{ auth()->user()->name }}</h2>
                <p class="text-white/70">We wish you have a productive day!</p>
            </div>

            <!-- Highlights -->
            <div class="grid gap-4 sm:grid-cols-2">
                @foreach([
                    ['To - Do List', 'A to-do list is a list of tasks to help organize your activities.'],
                    ['Study Goals', 'Study goals are learning targets set to improve understanding.'],
                ] as [$title, $desc])
                    <div class="bg-white/10 backdrop-blur-md rounded-xl p-5 shadow hover:bg-white/20 transition duration-200">
                        <h3 class="text-white font-semibold text-lg mb-1">{{ $title }}</h3>
                        <p class="text-white/80 text-sm mb-3">{{ $desc }}</p>
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-white/60">3–10 MIN</span>
                            <button class="px-4 py-1 bg-white text-[#053f64] rounded-full font-semibold hover:bg-gray-100 transition">
                                START
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Progress Tracker -->
            <div class="mt-8 bg-white/10 backdrop-blur-md rounded-xl p-4 flex justify-between items-center shadow">
                <div>
                    <h3 class="font-bold">Progress Tracker</h3>
                    <p class="text-xs text-white/70">SEE WHAT YOU'VE ACCOMPLISHED!</p>
                </div>
                <button class="bg-white text-black p-2 rounded-full shadow hover:bg-gray-200">▶️</button>
            </div>

            <!-- Study Goals Progress -->
            <h3 class="mt-8 text-lg font-semibold">🎯 Study Goals Progress</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-2">
                @foreach([
                    ['Learning HTML', '75% Complete'],
                    ['Laravel Authentication', '50% Complete'],
                    ['Database Normalization', '90% Complete'],
                    ['EAI UTS Planning', 'Started • 25%'],
                ] as [$task, $status])
                    <div class="bg-white/10 backdrop-blur-md rounded-xl p-4 hover:bg-white/20 transition">
                        <p class="font-semibold text-white">{{ $task }}</p>
                        <p class="text-xs text-white/70">{{ $status }}</p>
                    </div>
                @endforeach
            </div>

            <!-- To-Do List Progress -->
            <h3 class="mt-8 text-lg font-semibold">📝 To-Do List Progress</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-2">
                @foreach([
                    ['PPL Homework', 'Deadline • 2 HOURS LEFT'],
                    ['Write Project Report', 'In Progress • Due Tomorrow'],
                ] as [$task, $status])
                    <div class="bg-white/10 backdrop-blur-md rounded-xl p-4 hover:bg-white/20 transition">
                        <p class="font-semibold text-white">{{ $task }}</p>
                        <p class="text-xs text-white/70">{{ $status }}</p>
                    </div>
                @endforeach
            </div>

            <!-- Study Tips -->
            <h3 class="mt-10 text-lg font-semibold flex items-center gap-2">📚 Artikel Pilihan: Teknik Belajar Efektif</h3>
            <div class="mt-2 bg-white/10 backdrop-blur rounded-xl p-5 space-y-3 hover:bg-white/20 transition">
                @foreach([
                    ['✅', 'Tentukan tujuan belajar yang jelas dan terukur.'],
                    ['🕒', 'Kelola waktu belajar dengan teknik Pomodoro atau time-blocking.'],
                    ['🧠', 'Gunakan teknik aktif seperti membuat mind map, flashcard, dan self-quizzing.'],
                    ['🛌', 'Tidur cukup dan beri jeda istirahat untuk meningkatkan konsentrasi.'],
                    ['🥗', 'Pola makan sehat bantu stamina belajar tetap stabil!'],
                ] as [$icon, $tip])
                    <div class="flex items-center gap-3">
                        <span class="text-xl">{{ $icon }}</span>
                        <p class="text-sm text-white">{{ $tip }}</p>
                    </div>
                @endforeach

                <div class="mt-4 flex justify-between items-center">
                    <a href="https://dit-mawa.upi.edu/teknik-belajar-yang-efektif/" target="_blank" class="text-indigo-300 underline text-xs">
                        Baca artikel lengkap ↗
                    </a>
                    <button class="text-sm bg-indigo-500 text-white px-3 py-1 rounded-full hover:bg-indigo-600 transition">
                        Terapkan Sekarang
                    </button>
                </div>
            </div>
        </main>
    </div>
</x-app-layout>