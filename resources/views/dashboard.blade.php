<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex flex-col justify-between">

    <div class="flex-grow flex items-center justify-center px-4 pt-10 pb-24">
        <div class="w-full max-w-md bg-white rounded-2xl shadow-lg p-6">
            <div class="flex justify-between items-center mb-4">
                <h1 class="text-2xl font-semibold text-gray-800">🎉 Welcome</h1>
            </div>

            <p class="text-gray-600 mb-6 text-sm">
                Hai, {{ Auth::user()->name }} 👋<br>
                Kamu berhasil login! Ini adalah halaman dashboard aplikasi kamu.
            </p>

            <button onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                class="w-full py-3 rounded-xl bg-red-500 text-white font-semibold hover:bg-red-600 transition">
                Logout
            </button>
        </div>
    </div>

    <!-- Floating Bottom Navigation -->
    <div class="fixed bottom-4 left-1/2 transform -translate-x-1/2 w-full max-w-sm px-4">
        <div class="bg-white shadow-lg rounded-full flex justify-between px-6 py-3">
            <!-- Home -->
            <a href="#" class="flex flex-col items-center text-purple-500 hover:text-purple-600">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mb-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l9-9 9 9M4 10v10a1 1 0 001 1h3m10-11v10a1 1 0 001 1h3m-14 0h4m4 0h4" />
                </svg>
                <span class="text-xs">Home</span>
            </a>

            <!-- Profile -->
            <a href="#" class="flex flex-col items-center text-gray-500 hover:text-purple-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mb-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 15c2.21 0 4.29.534 6.121 1.475M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                <span class="text-xs">Profile</span>
            </a>

            <!-- Logout -->
            <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
               class="flex flex-col items-center text-gray-500 hover:text-red-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mb-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a2 2 0 11-4 0v-1m4-4V7a2 2 0 10-4 0v1" />
                </svg>
                <span class="text-xs">Logout</span>
            </a>
        </div>
    </div>

    <!-- Hidden logout form -->
    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
        @csrf
    </form>

</body>
</html>



<x-app-layout>
    @php
        $hour = now()->format('H');
        if ($hour < 12) $greeting = 'Good Morning';
        elseif ($hour < 18) $greeting = 'Good Afternoon';
        else $greeting = 'Good Evening';
    @endphp

    <div x-data="{ open: false }" class="flex min-h-screen bg-gradient-to-br from-slate-900 via-indigo-900 to-slate-800 text-white">

        <!-- Sidebar -->
        <div :class="{ 'translate-x-0': open, '-translate-x-full': !open }"
             class="fixed md:static inset-y-0 left-0 w-64 bg-white/10 backdrop-blur-md p-4 transform md:translate-x-0 transition-transform duration-300 z-40">

            <div class="flex justify-between items-center mb-6 md:hidden">
                <span class="text-lg font-semibold">Menu</span>
                <button @click="open = false">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <nav class="space-y-4">
                <a href="#" class="flex items-center gap-2 hover:text-indigo-400"><span>🏠</span><span>Home</span></a>
                <a href="#" class="flex items-center gap-2 hover:text-indigo-400"><span>📝</span><span>To-Do List</span></a>
                <a href="#" class="flex items-center gap-2 hover:text-indigo-400"><span>🎯</span><span>Study Goals</span></a>
                <a href="#" class="flex items-center gap-2 hover:text-indigo-400"><span>📈</span><span>Progress</span></a>
                <a href="#" class="flex items-center gap-2 hover:text-indigo-400"><span>👤</span><span>Profile</span></a>
            </nav>
        </div>

        <!-- Sidebar toggle button for mobile -->
        <button @click="open = !open"
                class="fixed top-4 left-4 z-50 md:hidden bg-white/10 backdrop-blur p-2 rounded-full">
            <svg xmlns="http://www.w3.org/2000/svg"
                 class="h-6 w-6 text-white"
                 fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path :class="{ 'rotate-180': open }"
                      class="transition-transform duration-300"
                      stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M9 5l7 7-7 7"/>
            </svg>
        </button>

        <!-- Main Content -->
        <main class="flex-1 p-6 ml-0 md:ml-64 transition-all duration-300">
            <div class="text-white">
                <h2 class="text-2xl font-bold mb-1">{{ $greeting }}, {{ auth()->user()->name }}</h2>
                <p class="mb-6 text-white/80">We wish you have a good day!</p>

                <div class="grid gap-4 sm:grid-cols-2">
                    <!-- To-Do Card -->
                    <div class="bg-indigo-300 rounded-xl p-4 text-black shadow-lg">
                        <h3 class="font-semibold text-lg mb-1">To - Do List</h3>
                        <p class="text-sm mb-2">A to-do list is a list of tasks to help organize your activities.</p>
                        <div class="flex items-center justify-between">
                            <span class="text-xs">3-10 MIN</span>
                            <button class="px-4 py-1 bg-white text-indigo-600 rounded-full text-sm font-semibold">START</button>
                        </div>
                    </div>

                    <!-- Study Goals Card -->
                    <div class="bg-amber-300 rounded-xl p-4 text-black shadow-lg">
                        <h3 class="font-semibold text-lg mb-1">Study Goals</h3>
                        <p class="text-sm mb-2">Study goals are learning targets set to improve understanding.</p>
                        <div class="flex items-center justify-between">
                            <span class="text-xs">3-10 MIN</span>
                            <button class="px-4 py-1 bg-white text-amber-600 rounded-full text-sm font-semibold">START</button>
                        </div>
                    </div>
                </div>

                <!-- Progress Tracker -->
                <div class="mt-6 bg-gray-800 rounded-xl p-4 flex items-center justify-between">
                    <div>
                        <h3 class="font-bold">Progress Tracker</h3>
                        <p class="text-xs text-white/70">SEE WHAT YOU'VE ACCOMPLISHED!</p>
                    </div>
                    <button class="bg-white text-black p-2 rounded-full">
                        ▶️
                    </button>
                </div>

                <!-- Progress List -->
                <h3 class="mt-8 text-lg font-semibold">Your progress</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-2">
                    <div class="bg-white/10 backdrop-blur rounded-xl p-4">
                        <p class="font-semibold">Learning HTML</p>
                        <p class="text-xs text-white/70">75% Complete</p>
                    </div>
                    <div class="bg-white/10 backdrop-blur rounded-xl p-4">
                        <p class="font-semibold">PPL Homework</p>
                        <p class="text-xs text-white/70">Deadline • 2 HOURS LEFT</p>
                    </div>
                </div>
            </div>
        </main>
    </div>
</x-app-layout>
