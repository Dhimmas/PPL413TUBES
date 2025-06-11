{{-- Navbar --}}
<nav x-data="{ open: false, featuresOpen: false }" class="bg-gradient-to-r from-white/10 via-white/5 to-white/10 backdrop-blur-xl border-b border-white/20 fixed w-full z-40 shadow-2xl">
    <div class="absolute inset-0 bg-gradient-to-r from-purple-600/10 via-blue-600/10 to-indigo-600/10 opacity-50"></div>
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
        <div class="flex justify-between h-16">
            <div class="flex items-center">
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}" class="flex items-center space-x-3 group">
                        <div class="relative">
                            <img src="{{ asset('images/studify-logo.png') }}" alt="Studify Logo" class="h-10 w-auto transition-transform duration-300 group-hover:scale-110">
                            <div class="absolute inset-0 bg-gradient-to-r from-blue-500/20 to-purple-500/20 rounded-lg blur-sm opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                        </div>
                        <span class="text-2xl font-bold bg-gradient-to-r from-blue-300 to-purple-300 bg-clip-text text-transparent tracking-wider">Studify</span>
                    </a>
                </div>

                <div class="hidden space-x-6 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="text-white/90 hover:text-blue-300 transition duration-200 font-medium relative group">
                        <span class="flex items-center">
                            <span class="mr-2 text-lg">🏠</span>
                            Home
                        </span>
                        <div class="absolute bottom-0 left-0 w-0 h-0.5 bg-gradient-to-r from-blue-400 to-purple-400 group-hover:w-full transition-all duration-300"></div>
                    </x-nav-link>

                    {{-- Dropdown Fitur --}}
                    <div class="relative" x-data="{ featuresOpen: false, forumOpen: false, goalsOpen: false }" @click.away="featuresOpen = false; forumOpen = false; goalsOpen = false">
                        <button @click="featuresOpen = !featuresOpen" class="flex items-center px-4 py-3 border border-transparent text-sm leading-4 font-medium rounded-lg text-white/90 hover:text-blue-300 hover:bg-white/10 focus:outline-none transition-all duration-200 h-full group relative">
                            <div class="flex items-center">
                                <span class="mr-2 text-lg">✨</span>
                                Fitur
                            </div>
                            <div class="ms-2">
                                <svg class="fill-current h-4 w-4 transition-transform duration-200" :class="{'rotate-180': featuresOpen}" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="absolute bottom-0 left-0 w-0 h-0.5 bg-gradient-to-r from-blue-400 to-purple-400 group-hover:w-full transition-all duration-300"></div>
                        </button>

                        <div x-show="featuresOpen"
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 scale-95 -translate-y-2"
                             x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                             x-transition:leave="transition ease-in duration-150"
                             x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                             x-transition:leave-end="opacity-0 scale-95 -translate-y-2"
                             class="absolute z-50 mt-2 w-72 rounded-2xl shadow-2xl bg-slate-800/95 backdrop-blur-xl ring-1 ring-slate-600/50 focus:outline-none origin-top-right right-0 sm:left-0 border border-slate-600/60">
                            <div class="py-3">
                                @foreach([
                                    ['📝', 'To-Do List', 'todos.index'],
                                    ['📈', 'Progress', 'tasks.index'],
                                    ['🤖', 'Chatbot', 'user.chatbot.index'],
                                    ['🎓', 'Quiz', 'quiz.index'],
                                    ['⏱️', 'Pomodoro', 'pomodoro.index'],
                                ] as [$icon, $label, $routeName])
                                    <x-dropdown-link :href="route($routeName)" class="text-gray-100 hover:bg-slate-700/70 hover:text-white px-4 py-3 transition-all duration-200 rounded-lg mx-2 flex items-center group">
                                        <span class="mr-3 text-lg group-hover:scale-110 transition-transform">{{ $icon }}</span>
                                        <span class="font-medium">{{ $label }}</span>
                                    </x-dropdown-link>
                                @endforeach

                                {{-- Forum Diskusi Nested --}}
                                <div class="relative group mx-2" x-data="{ forumOpen: false }" @mouseenter="forumOpen = true" @mouseleave="forumOpen = false">
                                    <button type="button"
                                            class="w-full text-left px-4 py-3 text-sm text-gray-100 hover:bg-slate-700/70 hover:text-white flex items-center justify-between transition-all duration-200 rounded-lg group/forum"
                                            @click="forumOpen = !forumOpen">
                                        <span class="flex items-center">
                                            <span class="mr-3 text-lg group-hover/forum:scale-110 transition-transform">💬</span>
                                            <span class="font-medium">Forum Diskusi</span>
                                        </span>
                                        <svg class="fill-current h-4 w-4 transform transition-transform duration-200" :class="{'rotate-90': forumOpen}" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                    <div x-show="forumOpen"
                                         x-transition:enter="transition ease-out duration-200"
                                         x-transition:enter-start="opacity-0 scale-95 translate-x-2"
                                         x-transition:enter-end="opacity-100 scale-100 translate-x-0"
                                         x-transition:leave="transition ease-in duration-150"
                                         x-transition:leave-start="opacity-100 scale-100 translate-x-0"
                                         x-transition:leave-end="opacity-0 scale-95 translate-x-2"
                                         class="absolute left-full top-0 ml-2 w-56 rounded-2xl shadow-2xl bg-slate-800/95 backdrop-blur-xl ring-1 ring-slate-600/50 z-60 border border-slate-600/60">
                                        <div class="py-2">
                                            <x-dropdown-link :href="route('forum.index')" class="text-gray-100 hover:bg-slate-700/70 hover:text-white text-sm px-4 py-2.5 flex items-center transition-all duration-200 rounded-lg mx-2 group">
                                                <span class="mr-3 group-hover:scale-110 transition-transform">💬</span>
                                                <span>Semua Diskusi</span>
                                            </x-dropdown-link>
                                            <x-dropdown-link :href="route('forum.bookmarks.index')" class="text-gray-100 hover:bg-slate-700/70 hover:text-white text-sm px-4 py-2.5 flex items-center transition-all duration-200 rounded-lg mx-2 group">
                                                <span class="mr-3 group-hover:scale-110 transition-transform">📚</span>
                                                <span>Bookmarks</span>
                                            </x-dropdown-link>
                                        </div>
                                    </div>
                                </div>

                                {{-- Goals Nested Dropdown --}}
                                <div class="relative group mx-2" x-data="{ goalsOpen: false }" @mouseenter="goalsOpen = true" @mouseleave="goalsOpen = false">
                                    <button type="button"
                                            class="w-full text-left px-4 py-3 text-sm text-gray-100 hover:bg-slate-700/70 hover:text-white flex items-center justify-between transition-all duration-200 rounded-lg group/goals"
                                            @click="goalsOpen = !goalsOpen">
                                        <span class="flex items-center">
                                            <span class="mr-3 text-lg group-hover/goals:scale-110 transition-transform">🎯</span>
                                            <span class="font-medium">Study Goals</span>
                                        </span>
                                        <svg class="fill-current h-4 w-4 transform transition-transform duration-200" :class="{'rotate-90': goalsOpen}" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                    <div x-show="goalsOpen"
                                         x-transition:enter="transition ease-out duration-200"
                                         x-transition:enter-start="opacity-0 scale-95 translate-x-2"
                                         x-transition:enter-end="opacity-100 scale-100 translate-x-0"
                                         x-transition:leave="transition ease-in duration-150"
                                         x-transition:leave-start="opacity-100 scale-100 translate-x-0"
                                         x-transition:leave-end="opacity-0 scale-95 translate-x-2"
                                         class="absolute left-full top-0 ml-2 w-56 rounded-2xl shadow-2xl bg-slate-800/95 backdrop-blur-xl ring-1 ring-slate-600/50 z-60 border border-slate-600/60">
                                        <div class="py-2">
                                            @foreach([
                                                ['📊', 'Overview', 'study-goals.index'],
                                                ['📅', "Today's Goals", 'study-goals.today'],
                                                ['⏰', 'Upcoming Goals', 'study-goals.upcoming'],
                                                ['✅', 'Completed Goals', 'study-goals.completed'],
                                                ['➕', 'Add New Goal', 'study-goals.create'],
                                            ] as [$icon, $label, $routeName])
                                                <x-dropdown-link :href="route($routeName)" class="text-gray-100 hover:bg-slate-700/70 hover:text-white text-sm px-4 py-2.5 flex items-center transition-all duration-200 rounded-lg mx-2 group">
                                                    <span class="mr-3 group-hover:scale-110 transition-transform">{{ $icon }}</span>
                                                    <span>{{ $label }}</span>
                                                </x-dropdown-link>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ms-6">
                @auth
                    <!-- Theme Toggle Button (Desktop) -->
                    <button id="theme-toggle" class="theme-toggle mr-4" aria-label="Toggle theme">
                        <span id="theme-icon" class="theme-toggle-icon">🌙</span>
                        <span id="theme-text" class="hidden md:inline">Dark Mode</span>
                    </button>

                    <x-dropdown align="right" width="64">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center px-4 py-2 border border-white/20 text-sm leading-4 font-medium rounded-xl text-white/90 bg-white/10 backdrop-blur-sm hover:bg-white/20 hover:text-white focus:outline-none transition-all duration-200 group shadow-lg">
                                <div class="relative mr-3">
                                    @if(Auth::user()->profile && Auth::user()->profile->profile_picture)
                                        <img src="{{ asset('storage/' . Auth::user()->profile->profile_picture) }}" 
                                             alt="Profile" 
                                             class="w-8 h-8 rounded-full object-cover border-2 border-white/30 group-hover:border-white/50 transition-all duration-200">
                                    @else
                                        <div class="w-8 h-8 rounded-full bg-gradient-to-br from-purple-500 to-blue-500 flex items-center justify-center border-2 border-white/30 group-hover:border-white/50 transition-all duration-200">
                                            <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                                            </svg>
                                        </div>
                                    @endif
                                    <div class="absolute -bottom-1 -right-1 w-3 h-3 bg-green-500 rounded-full border-2 border-white/50"></div>
                                </div>
                                
                                <div class="text-left">
                                    <div class="font-semibold">{{ Auth::user()->name }}</div>
                                    <div class="text-xs text-white/60">Online</div>
                                </div>
                                
                                <div class="ms-3">
                                    <svg class="fill-current h-4 w-4 transition-transform duration-200 group-hover:rotate-180" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <div class="bg-slate-800/95 backdrop-blur-xl rounded-xl border border-slate-600/60 shadow-2xl overflow-hidden">
                                <div class="px-4 py-3 bg-gradient-to-r from-purple-600/20 to-blue-600/20 border-b border-slate-600/50">
                                    <div class="flex items-center space-x-3">
                                        @if(Auth::user()->profile && Auth::user()->profile->profile_picture)
                                            <img src="{{ asset('storage/' . Auth::user()->profile->profile_picture) }}" 
                                                 alt="Profile" 
                                                 class="w-12 h-12 rounded-full object-cover border-2 border-white/30">
                                        @else
                                            <div class="w-12 h-12 rounded-full bg-gradient-to-br from-purple-500 to-blue-500 flex items-center justify-center border-2 border-white/30">
                                                <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                                    <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                                            </div>
                                        @endif
                                        <div>
                                            <div class="font-semibold text-white">{{ Auth::user()->name }}</div>
                                            <div class="text-sm text-gray-300">{{ Auth::user()->email }}</div>
                                        </div>
                                    </div>
                                </div>

                                <div class="py-2">
                                    <x-dropdown-link :href="route('profile.show')" class="text-gray-100 hover:bg-white/20 hover:text-white transition-all duration-200 flex items-center px-4 py-3 group">
                                        <svg class="w-4 h-4 mr-3 group-hover:scale-110 transition-transform text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                        </svg>
                                        View Profile
                                    </x-dropdown-link>
                                    
                                    <x-dropdown-link :href="route('profile.edit')" class="text-gray-100 hover:bg-white/20 hover:text-white transition-all duration-200 flex items-center px-4 py-3 group">
                                        <svg class="w-4 h-4 mr-3 group-hover:scale-110 transition-transform text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                        Edit Profile
                                    </x-dropdown-link>

                                    <div class="border-t border-slate-600/50 my-2"></div>

                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <x-dropdown-link :href="route('logout')"
                                                         onclick="event.preventDefault(); this.closest('form').submit();"
                                                         class="text-gray-100 hover:bg-red-500/20 hover:text-red-300 transition-all duration-200 flex items-center px-4 py-3 group">
                                            <svg class="w-4 h-4 mr-3 group-hover:scale-110 transition-transform text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                            </svg>
                                            Log Out
                                        </x-dropdown-link>
                                    </form>
                                </div>
                            </div>
                        </x-slot>
                    </x-dropdown>
                @else
                    {{-- Login/Register buttons --}}
                    <div class="flex items-center space-x-3">
                        <a href="{{ route('login') }}" class="px-4 py-2 text-white/90 hover:text-white transition-all duration-200 font-medium relative group">
                            <span>Log in</span>
                            <div class="absolute bottom-0 left-0 w-0 h-0.5 bg-gradient-to-r from-blue-400 to-purple-400 group-hover:w-full transition-all duration-300"></div>
                        </a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="px-6 py-2 bg-gradient-to-r from-blue-500 to-purple-600 hover:from-blue-600 hover:to-purple-700 text-white font-medium rounded-xl transition-all duration-200 transform hover:scale-105 shadow-lg">
                                Register
                            </a>
                        @endif
                    </div>
                @endauth
            </div>

            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-white hover:text-gray-300 focus:outline-none transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div x-show="open" class="sm:hidden" x-cloak>
        <!-- Backdrop -->
        <div @click="open = false" class="fixed inset-0 bg-black/60 z-40"></div>
        
        <!-- Sidebar -->
        <div x-show="open"
             x-transition:enter="transition ease-out duration-300 transform"
             x-transition:enter-start="-translate-x-full"
             x-transition:enter-end="translate-x-0"
             x-transition:leave="transition ease-in duration-200 transform"
             x-transition:leave-start="translate-x-0"
             x-transition:leave-end="-translate-x-full"
             class="fixed top-0 left-0 w-80 bg-slate-800 h-screen shadow-2xl z-50 border-r border-slate-600 flex flex-col">
            
            <!-- Header -->
            <div class="flex justify-between items-center p-6 bg-slate-700 border-b border-slate-600 flex-shrink-0">
                <div class="flex items-center space-x-3">
                    @auth
                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-purple-500 to-blue-500 flex items-center justify-center border border-slate-600">
                            <span class="text-white font-semibold">{{ substr(Auth::user()->name, 0, 1) }}</span>
                        </div>
                        <div>
                            <p class="text-white font-medium">{{ Auth::user()->name }}</p>
                            <p class="text-slate-300 text-sm">{{ Auth::user()->email }}</p>
                        </div>
                    @else
                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-purple-500 to-blue-500 flex items-center justify-center border border-slate-600">
                            <span class="text-white font-semibold">G</span>
                        </div>
                        <div>
                            <p class="text-white font-medium">Guest</p>
                            <p class="text-slate-300 text-sm">Welcome to Studify</p>
                        </div>
                    @endauth
                </div>
                <button @click="open = false" class="p-2 text-slate-300 hover:text-white hover:bg-slate-600 transition rounded-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Scrollable Content -->
            <div class="flex-1 overflow-y-auto bg-slate-800" style="max-height: calc(100vh - 100px);">
                <!-- Navigation -->
                <div class="p-4 space-y-2 pb-8">
                    <!-- Home -->
                    <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" @click="open = false" class="text-white hover:text-blue-300 hover:bg-slate-700 flex items-center space-x-3 px-4 py-3 rounded-lg transition-all duration-200 border border-slate-600">
                        <span class="text-xl">🏠</span>
                        <span class="font-medium">Home</span>
                    </x-responsive-nav-link>

                    <!-- Fitur Utama Section -->
                    <div class="pt-4">
                        <h3 class="text-sm font-semibold text-slate-300 uppercase tracking-wider mb-3 px-4">Fitur Utama</h3>
                        <div class="space-y-2">
                            @foreach([
                                ['📝', 'To-Do List', 'todos.index'],
                                ['🎯', 'Goals', 'study-goals.index'],
                                ['📈', 'Progress', 'tasks.index'],
                                ['🤖', 'Chatbot', 'user.chatbot.index'],
                                ['🎓', 'Quiz', 'quiz.index'],
                                ['⏱️', 'Pomodoro', 'pomodoro.index'],
                                ['💬', 'Forum Diskusi', 'forum.index'],
                                ['📚', 'Bookmarks', 'forum.bookmarks.index'],
                            ] as [$icon, $label, $routeName])
                                <x-responsive-nav-link :href="route($routeName)" @click="open = false" class="text-white hover:text-blue-300 hover:bg-slate-700 flex items-center space-x-3 px-4 py-3 rounded-lg transition-all duration-200 border border-slate-600">
                                    <span class="text-xl">{{ $icon }}</span>
                                    <span class="font-medium">{{ $label }}</span>
                                </x-responsive-nav-link>
                            @endforeach
                        </div>
                    </div>

                    <!-- Profile & Auth Section -->
                    @auth
                        <div class="pt-4">
                            <h3 class="text-sm font-semibold text-slate-300 uppercase tracking-wider mb-3 px-4">Settings</h3>
                            <div class="space-y-2">
                                <!-- Theme Toggle (Mobile) -->
                                <button id="mobile-theme-toggle" class="mobile-theme-toggle text-white" aria-label="Toggle theme">
                                    <span id="mobile-theme-icon" class="text-xl">🌙</span>
                                    <span id="mobile-theme-text" class="font-medium">Dark Mode</span>
                                </button>
                            </div>
                        </div>
                        
                        <div class="pt-2">
                            <h3 class="text-sm font-semibold text-slate-300 uppercase tracking-wider mb-3 px-4">Account</h3>
                            <div class="space-y-2">
                                <x-responsive-nav-link :href="route('profile.edit')" @click="open = false" class="text-white hover:text-blue-300 hover:bg-slate-700 flex items-center space-x-3 px-4 py-3 rounded-lg transition-all duration-200 border border-slate-600">
                                    <span class="font-medium">Profile</span>
                                </x-responsive-nav-link>

                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="w-full text-left text-white hover:text-red-400 hover:bg-red-900 flex items-center space-x-3 px-4 py-3 rounded-lg transition-all duration-200 border border-slate-600">
                                        <span class="font-medium">Log Out</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <div class="pt-4">
                            <h3 class="text-sm font-semibold text-slate-300 uppercase tracking-wider mb-3 px-4">Settings</h3>
                            <div class="space-y-2">
                                <!-- Theme Toggle (Mobile - Guest) -->
                                <button id="mobile-theme-toggle-guest" class="mobile-theme-toggle text-white" aria-label="Toggle theme">
                                    <span id="mobile-theme-icon-guest" class="text-xl">🌙</span>
                                    <span id="mobile-theme-text-guest" class="font-medium">Dark Mode</span>
                                </button>
                            </div>
                        </div>
                        
                        <div class="pt-2">
                            <h3 class="text-sm font-semibold text-slate-300 uppercase tracking-wider mb-3 px-4">Account</h3>
                            <div class="space-y-2">
                                <x-responsive-nav-link :href="route('login')" @click="open = false" class="text-white hover:text-blue-300 hover:bg-slate-700 flex items-center space-x-3 px-4 py-3 rounded-lg transition-all duration-200 border border-slate-600">
                                    <span class="font-medium">Log in</span>
                                </x-responsive-nav-link>
                                @if (Route::has('register'))
                                    <x-responsive-nav-link :href="route('register')" @click="open = false" class="text-white hover:text-blue-300 hover:bg-slate-700 flex items-center space-x-3 px-4 py-3 rounded-lg transition-all duration-200 border border-slate-600">
                                        <span class="font-medium">Register</span>
                                    </x-responsive-nav-link>
                                @endif
                            </div>
                        </div>
                    @endauth
                </div>
            </div>
        </div>
    </div>
</nav>
