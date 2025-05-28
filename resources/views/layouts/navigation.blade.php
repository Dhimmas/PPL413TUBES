<div x-data="{ open: false }" class="flex bg-[#021c2d] text-white">
    <!-- Sidebar Desktop -->
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
                ['⏱️', 'Pomodoro Timer', 'pomodoro.index'],
                ['👤', 'Profile', 'profile.edit'],
                ['🤖', 'Chatbot', 'chatbot'],
                ['🎓', 'Quiz', 'quiz.index'],
                ['💬', 'Forum Diskusi', 'forum.index'],
            ] as [$icon, $label, $routeName])
                <a href="{{ route($routeName) }}" class="flex items-center space-x-3 text-sm font-medium p-3 rounded-xl bg-white/10 hover:bg-white/20 transition hover:scale-105">
                    <span class="text-xl">{{ $icon }}</span>
                    <span>{{ $label }}</span>
                </a>
            @endforeach
        </nav>
    </aside>

    <!-- Mobile Toggle Button -->
    <div class="md:hidden fixed top-4 left-4 z-40">
        <button @click="open = !open" class="bg-black/50 hover:bg-black/70 text-white p-2 rounded-full shadow-md transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>
    </div>

    <!-- Sidebar Mobile -->
    <div :class="{ 'translate-x-0': open, '-translate-x-full': !open }"
         class="fixed top-0 left-0 w-64 bg-gradient-to-b from-[#03263c] to-[#021623] p-6 transform transition-transform duration-300 z-50 h-full md:hidden shadow-lg">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-bold">Menu</h2>
            <button @click="open = false">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 hover:text-red-400 transition" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        <nav class="space-y-4">
            @foreach([
                ['🏠', 'Home', 'dashboard'],
                ['📝', 'To-Do', 'to_do'],
                ['🎯', 'Goals', 'goals'],
                ['📈', 'Progress', 'progress'],
                ['⏱️', 'Pomodoro Timer', 'pomodoro.index'],
                ['👤', 'Profile', 'profile.edit'],
                ['🤖', 'Chatbot', 'chatbot'],
                ['🎓', 'Quiz', 'quiz.index'],
                ['💬', 'Forum Diskusi', 'forum.index'],
            ] as [$icon, $label, $routeName])
                <a href="{{ route($routeName) }}"
                class="flex items-center space-x-3 text-sm font-medium p-3 rounded-xl bg-white/10 hover:bg-white/20 transition hover:scale-105">
                    <span class="text-xl">{{ $icon }}</span>
                    <span>{{ $label }}</span>
                </a>
            @endforeach
        </nav>
    </div>
</div>
