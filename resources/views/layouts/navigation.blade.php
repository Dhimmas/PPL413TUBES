{{-- Navbar --}}
<nav x-data="{ open: false, featuresOpen: false }" class="bg-gradient-to-r from-[#0f172a] to-[#1e293b] text-white border-b border-gray-700 fixed w-full z-40 shadow-lg">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center">
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}" class="flex items-center space-x-2">
                        <img src="{{ asset('images/studify-logo.png') }}" alt="Studify Logo" class="h-9 w-auto">
                        <span class="text-xl font-bold tracking-wider">Studify</span>
                    </a>
                </div>

                <div class="hidden space-x-6 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="text-white hover:text-blue-300 transition duration-200">
                        🏠 Home
                    </x-nav-link>

                    {{-- Dropdown Fitur --}}
                    <div class="relative" x-data="{ featuresOpen: false }" @click.away="featuresOpen = false">
                        <button @click="featuresOpen = !featuresOpen" class="flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white hover:text-blue-300 focus:outline-none transition ease-in-out duration-150 h-full">
                            <div>✨ Fitur</div>
                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>

                        <div x-show="featuresOpen" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95" class="absolute z-50 mt-2 w-48 rounded-md shadow-lg bg-gray-800 ring-1 ring-black ring-opacity-5 focus:outline-none origin-top-right right-0 sm:left-0">
                            <div class="py-1">
                                <x-dropdown-link :href="route('todos.index')" class="text-gray-200 hover:bg-gray-700 hover:text-white">
                                    📝 To-Do List
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('goals')" class="text-gray-200 hover:bg-gray-700 hover:text-white">
                                    🎯 Goals
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('progress')" class="text-gray-200 hover:bg-gray-700 hover:text-white">
                                    📈 Progress
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('user.chatbot.index')" class="text-gray-200 hover:bg-gray-700 hover:text-white">
                                    🤖 Chatbot
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('quiz.index')" class="text-gray-200 hover:bg-gray-700 hover:text-white">
                                    🎓 Quiz
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('forum.index')" class="text-gray-200 hover:bg-gray-700 hover:text-white">
                                    💬 Forum Diskusi
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('pomodoro.index')" class="text-gray-200 hover:bg-gray-700 hover:text-white">
                                    ⏱️ Pomodoro
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('forum.bookmarks.index')" class="text-gray-200 hover:bg-gray-700 hover:text-white">
                                    📚 Bookmarks
                                </x-dropdown-link>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ms-6">
                @auth
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-200 bg-gray-800 hover:text-white focus:outline-none transition ease-in-out duration-150">
                                <div>{{ Auth::user()->name }}</div>
                                <div class="ms-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link :href="route('profile.edit')" class="text-gray-200 hover:bg-gray-700 hover:text-white">
                                {{ __('Profile') }}
                            </x-dropdown-link>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')"
                                                 onclick="event.preventDefault(); this.closest('form').submit();"
                                                 class="text-gray-200 hover:bg-gray-700 hover:text-white">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                @else
                    {{-- Tombol Login/Register jika belum login --}}
                    <a href="{{ route('login') }}" class="font-semibold text-gray-200 hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Log in</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="ms-4 font-semibold text-gray-200 hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Register</a>
                    @endif
                @endauth
            </div>

            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900 focus:text-gray-500 dark:focus:text-gray-400 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div x-show="open"
         x-transition:enter="transition ease-out duration-300 transform"
         x-transition:enter-start="-translate-x-full"
         x-transition:enter-end="translate-x-0"
         x-transition:leave="transition ease-in duration-200 transform"
         x-transition:leave-start="translate-x-0"
         x-transition:leave-end="-translate-x-full"
         class="fixed top-0 left-0 w-64 bg-gradient-to-b from-[#03263c] to-[#021623] p-6 h-full md:hidden shadow-lg z-50 overflow-y-auto"> {{-- <<< INI YANG DITAMBAHKAN overflow-y-auto --}}
        <div class="flex justify-end items-center mb-6">
            <button @click="open = false" class="text-white hover:text-red-400 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        <nav class="space-y-4">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="text-white hover:text-blue-300">
                🏠 Home
            </x-responsive-nav-link>

            {{-- Fitur Utama --}}
            <h3 class="text-lg font-semibold text-white mt-6 mb-2">Fitur Utama</h3> {{-- <<< INI YANG DIPEBAIKI WARNANYA --}}
            @foreach([
                ['📝', 'To-Do List', 'todos.index'],
                ['🎯', 'Goals', 'goals'],
                ['📈', 'Progress', 'progress'],
                ['🤖', 'Chatbot', 'user.chatbot.index'],
                ['🎓', 'Quiz', 'quiz.index'],
                ['⏱️', 'Pomodoro', 'pomodoro.index'],
                ['💬', 'Forum Diskusi', 'forum.index'],
                ['📚', 'Bookmarks', 'forum.bookmarks.index'],
            ] as [$icon, $label, $routeName])
                <x-responsive-nav-link :href="route($routeName)" :active="request()->routeIs($routeName)" class="flex items-center space-x-3 text-white hover:text-blue-300">
                    <span class="text-xl">{{ $icon }}</span>
                    <span>{{ $label }}</span>
                </x-responsive-nav-link>
            @endforeach

            {{-- Bagian Profil dan Logout (Mobile) --}}
            @auth
                <div class="pt-4 pb-1 border-t border-gray-600">
                    <div class="px-4">
                        <div class="font-medium text-base text-gray-200">{{ Auth::user()->name }}</div>
                        <div class="font-medium text-sm text-gray-400">{{ Auth::user()->email }}</div>
                    </div>
                    <div class="mt-3 space-y-1">
                        <x-responsive-nav-link :href="route('profile.edit')" class="text-gray-200 hover:text-white">
                            {{ __('Profile') }}
                        </x-responsive-nav-link>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-responsive-nav-link :href="route('logout')"
                                                   onclick="event.preventDefault(); this.closest('form').submit();"
                                                   class="text-gray-200 hover:text-white">
                                {{ __('Log Out') }}
                            </x-responsive-nav-link>
                        </form>
                    </div>
                </div>
            @else
                <div class="pt-4 pb-1 border-t border-gray-600">
                    <x-responsive-nav-link :href="route('login')" class="text-gray-200 hover:text-white">
                        Log in
                    </x-responsive-nav-link>
                    @if (Route::has('register'))
                        <x-responsive-nav-link :href="route('register')" class="text-gray-200 hover:text-white">
                            Register
                        </x-responsive-nav-link>
                    @endif
                </div>
            @endauth
        </nav>
    </div>
</nav>