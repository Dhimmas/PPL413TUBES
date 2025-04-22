@extends('layouts.app_2')

@section('content')
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
                <a href="" class="flex items-center gap-2 hover:text-indigo-400"><span>🏠</span><span>Home</span></a>
                <a href="To-Do List" class="flex items-center gap-2 hover:text-indigo-400"><span>📝</span><span>To-Do List</span></a>
                <a href="Study Goals" class="flex items-center gap-2 hover:text-indigo-400"><span>🎯</span><span>Study Goals</span></a>
                <a href="progress" class="flex items-center gap-2 hover:text-indigo-400"><span>📈</span><span>Progress</span></a>
                <a href="profile" class="flex items-center gap-2 hover:text-indigo-400"><span>👤</span><span>Profile</span></a>
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
@endsection
