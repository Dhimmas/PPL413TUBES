<x-app-layout>
    @php
        $hour = now()->format('H');
        $greeting = $hour < 12 ? 'Good Morning' : ($hour < 18 ? 'Good Afternoon' : 'Good Evening');
    @endphp

    @include('layouts.navigation')

    <!-- Main Content -->
    <main class="flex-1 ml-0 md:ml-64 p-6">
        <!-- Greeting Section with Animation -->
        <div class="mb-8 relative">
            <div class="absolute inset-0 bg-gradient-to-r from-blue-600/20 to-purple-600/20 rounded-2xl blur-xl"></div>
            <div class="relative bg-white/10 backdrop-blur-xl rounded-2xl p-8 border border-white/20 shadow-2xl">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-4xl font-bold mb-2 text-white bg-gradient-to-r from-white to-blue-200 bg-clip-text text-transparent">
                            {{ $greeting }}, {{ auth()->user()->name }}
                        </h2>
                        <p class="text-white/80 text-lg">✨ Ready to make today productive? Let's get started!</p>
                    </div>
                    <div class="hidden md:block">
                        <div class="w-20 h-20 bg-gradient-to-br from-yellow-400 to-orange-500 rounded-full flex items-center justify-center shadow-lg animate-pulse">
                            <span class="text-3xl">🌟</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions Cards -->
        <div class="grid gap-6 sm:grid-cols-2 mb-8">
            @foreach([
                ['To - Do List', 'A to-do list is a list of tasks to help organize your activities.', '📝', 'from-emerald-500 to-teal-600'],
                ['Study Goals', 'Study goals are learning targets set to improve understanding.', '🎯', 'from-blue-500 to-indigo-600'],
            ] as [$title, $desc, $icon, $gradient])
                <div class="group relative">
                    <div class="absolute inset-0 bg-gradient-to-r {{ $gradient }} rounded-2xl blur opacity-25 group-hover:opacity-50 transition duration-500"></div>
                    <div class="relative bg-white/10 backdrop-blur-xl rounded-2xl p-6 shadow-xl border border-white/20 hover:bg-white/15 transition-all duration-300 hover:scale-105 hover:shadow-2xl">
                        <div class="flex items-start justify-between mb-4">
                            <div class="text-4xl">{{ $icon }}</div>
                            <div class="px-3 py-1 bg-white/20 rounded-full text-xs font-semibold text-white/90">
                                3–10 MIN
                            </div>
                        </div>
                        <h3 class="text-white font-bold text-xl mb-2">{{ $title }}</h3>
                        <p class="text-white/80 text-sm mb-4 leading-relaxed">{{ $desc }}</p>
                        <button class="w-full py-3 bg-gradient-to-r {{ $gradient }} text-white rounded-xl font-semibold hover:shadow-lg transition-all duration-300 hover:scale-105">
                            START NOW
                        </button>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Progress Tracker - Enhanced -->
        <div class="mb-8 relative group">
            <div class="absolute inset-0 bg-gradient-to-r from-purple-600/30 to-pink-600/30 rounded-2xl blur opacity-50"></div>
            <div class="relative bg-white/10 backdrop-blur-xl rounded-2xl p-6 shadow-xl border border-white/20 hover:bg-white/15 transition-all duration-300">
                <div class="flex justify-between items-center">
                    <div>
                        <h3 class="font-bold text-white text-xl flex items-center gap-2">
                            <span class="text-2xl">📊</span>
                            Progress Tracker
                        </h3>
                        <p class="text-sm text-white/70 mt-1">SEE WHAT YOU'VE ACCOMPLISHED!</p>
                    </div>
                    <button class="bg-gradient-to-r from-pink-500 to-purple-600 text-white p-4 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-110">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M8 5a1 1 0 011-1h2a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H7a1 1 0 110-2h3V5z"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Study Goals Progress - Enhanced -->
        <div class="mb-8">
            <h3 class="text-2xl font-bold text-white mb-6 flex items-center gap-3">
                <span class="text-3xl">🎯</span>
                Study Goals Progress
            </h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                @foreach([
                    ['Learning HTML', '75% Complete', '75', 'from-green-400 to-emerald-500'],
                    ['Laravel Authentication', '50% Complete', '50', 'from-blue-400 to-indigo-500'],
                    ['Database Normalization', '90% Complete', '90', 'from-purple-400 to-pink-500'],
                    ['EAI UTS Planning', 'Started • 25%', '25', 'from-orange-400 to-red-500'],
                ] as [$task, $status, $progress, $gradient])
                    <div class="group relative">
                        <div class="absolute inset-0 bg-gradient-to-r {{ $gradient }} rounded-xl blur opacity-20 group-hover:opacity-40 transition duration-500"></div>
                        <div class="relative bg-white/10 backdrop-blur-xl rounded-xl p-5 shadow-lg border border-white/20 hover:bg-white/15 transition-all duration-300 hover:scale-105">
                            <div class="flex justify-between items-start mb-3">
                                <p class="font-semibold text-white text-lg">{{ $task }}</p>
                                <span class="text-sm font-bold text-white bg-white/20 px-2 py-1 rounded-full">{{ $progress }}%</span>
                            </div>
                            <p class="text-sm text-white/70 mb-3">{{ $status }}</p>
                            <div class="w-full bg-white/20 rounded-full h-2">
                                <div class="bg-gradient-to-r {{ $gradient }} h-2 rounded-full transition-all duration-1000 ease-out" 
                                     style="width: {{ $progress }}%"></div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- To-Do List Progress - Enhanced -->
        <div class="mb-8">
            <h3 class="text-2xl font-bold text-white mb-6 flex items-center gap-3">
                <span class="text-3xl">📝</span>
                To-Do List Progress
            </h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                @foreach([
                    ['PPL Homework', 'Deadline • 2 HOURS LEFT', '⚠️', 'from-red-400 to-pink-500'],
                    ['Write Project Report', 'In Progress • Due Tomorrow', '⏳', 'from-yellow-400 to-orange-500'],
                ] as [$task, $status, $icon, $gradient])
                    <div class="group relative">
                        <div class="absolute inset-0 bg-gradient-to-r {{ $gradient }} rounded-xl blur opacity-20 group-hover:opacity-40 transition duration-500"></div>
                        <div class="relative bg-white/10 backdrop-blur-xl rounded-xl p-5 shadow-lg border border-white/20 hover:bg-white/15 transition-all duration-300 hover:scale-105">
                            <div class="flex items-start gap-3">
                                <span class="text-2xl">{{ $icon }}</span>
                                <div class="flex-1">
                                    <p class="font-semibold text-white text-lg mb-1">{{ $task }}</p>
                                    <p class="text-sm text-white/70">{{ $status }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Study Tips - Enhanced -->
        <div class="mb-8">
            <h3 class="text-2xl font-bold text-white mb-6 flex items-center gap-3">
                <span class="text-3xl">📚</span>
                Artikel Pilihan: Teknik Belajar Efektif
            </h3>
            <div class="relative group">
                <div class="absolute inset-0 bg-gradient-to-br from-indigo-600/30 to-purple-600/30 rounded-2xl blur opacity-50"></div>
                <div class="relative bg-white/10 backdrop-blur-xl rounded-2xl p-8 shadow-xl border border-white/20 hover:bg-white/15 transition-all duration-300">
                    <div class="space-y-4">
                        @foreach([
                            ['✅', 'Tentukan tujuan belajar yang jelas dan terukur.', 'from-green-400 to-emerald-500'],
                            ['🕒', 'Kelola waktu belajar dengan teknik Pomodoro atau time-blocking.', 'from-blue-400 to-indigo-500'],
                            ['🧠', 'Gunakan teknik aktif seperti membuat mind map, flashcard, dan self-quizzing.', 'from-purple-400 to-pink-500'],
                            ['🛌', 'Tidur cukup dan beri jeda istirahat untuk meningkatkan konsentrasi.', 'from-indigo-400 to-purple-500'],
                            ['🥗', 'Pola makan sehat bantu stamina belajar tetap stabil!', 'from-orange-400 to-red-500'],
                        ] as [$icon, $tip, $gradient])
                            <div class="flex items-center gap-4 p-4 bg-white/5 rounded-xl hover:bg-white/10 transition-all duration-300 group/item">
                                <div class="w-12 h-12 bg-gradient-to-br {{ $gradient }} rounded-xl flex items-center justify-center text-xl shadow-lg group-hover/item:scale-110 transition-transform duration-300">
                                    {{ $icon }}
                                </div>
                                <p class="text-white flex-1 font-medium">{{ $tip }}</p>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-8 flex flex-col sm:flex-row justify-between items-center gap-4 pt-6 border-t border-white/20">
                        <a href="https://dit-mawa.upi.edu/teknik-belajar-yang-efektif/" target="_blank" 
                           class="text-blue-300 hover:text-blue-200 underline text-sm font-medium transition-colors duration-300 flex items-center gap-2">
                            📖 Baca artikel lengkap
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M11 3a1 1 0 100 2h2.586l-6.293 6.293a1 1 0 101.414 1.414L15 6.414V9a1 1 0 102 0V4a1 1 0 00-1-1h-5z"/>
                                <path d="M5 5a2 2 0 00-2 2v8a2 2 0 002 2h8a2 2 0 002-2v-3a1 1 0 10-2 0v3H5V7h3a1 1 0 000-2H5z"/>
                            </svg>
                        </a>
                        <button class="px-6 py-3 bg-gradient-to-r from-indigo-500 to-purple-600 text-white rounded-xl font-semibold hover:shadow-xl transition-all duration-300 hover:scale-105">
                            🚀 Terapkan Sekarang
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </main>
</x-app-layout>