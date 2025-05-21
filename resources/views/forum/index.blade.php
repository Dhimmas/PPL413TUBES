<x-app-layout>

    @include('layouts.navigation')

    {{-- Adjusted max-w-6xl for slightly wider but still centered content --}}
    <div class="max-w-6xl mx-auto mt-16 mb-12 px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col sm:flex-row justify-between items-center mb-12 gap-8">
            <h1 class="text-5xl font-extrabold text-white tracking-tight leading-tight text-center sm:text-left"> {{-- Added text-center for smaller screens --}}
                <span class="bg-clip-text text-transparent bg-gradient-to-r from-blue-400 to-purple-600 animate-gradient-pulse">
                    💬 Jelajahi Diskusi Komunitas
                </span>
            </h1>
            <a href="{{ route('forum.create') }}"
               class="inline-flex items-center gap-3 bg-gradient-to-r from-blue-600 to-purple-700 hover:from-blue-700 hover:to-purple-800 text-white px-8 py-4 rounded-xl text-lg font-semibold shadow-xl hover:shadow-2xl transition duration-300 transform hover:-translate-y-1 hover:scale-105 focus:outline-none focus:ring-4 focus:ring-blue-300 focus:ring-opacity-75">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                Mulai Diskusi Baru
            </a>
        </div>

        {{-- Optional: Add a search bar or filter options here for better discoverability --}}
        {{-- <div class="mb-8">
            <input type="text" placeholder="Cari diskusi..." class="w-full p-3 rounded-lg bg-white/10 text-white placeholder-white/50 border border-white/20 focus:border-blue-400 focus:ring focus:ring-blue-400 focus:ring-opacity-50">
        </div> --}}

        {{-- Ensured grid itself is within the centered container --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($forumPosts as $post)
                <div class="bg-white/10 backdrop-blur-lg rounded-2xl p-7 transition-all duration-300 hover:bg-white/20 shadow-xl hover:shadow-3xl border border-transparent hover:border-white/30 transform hover:-translate-y-1">
                    <a href="{{ route('forum.show', $post->id) }}" class="block group">
                        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-4 gap-3">
                            <h2 class="text-2xl font-bold text-white group-hover:text-blue-300 transition duration-200 leading-tight flex-grow pr-4">
                                {{ $post->title }}
                            </h2>
                            @if($post->category)
                                <span class="text-sm bg-sky-500/80 text-white px-4 py-1.5 rounded-full mt-2 sm:mt-0 whitespace-nowrap font-medium shadow">
                                    {{ $post->category->name }}
                                </span>
                            @endif
                        </div>
                        <p class="text-sm text-white/70 mb-4 flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white/50" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                            </svg>
                            <span class="font-medium text-white/90">{{ $post->user->name }}</span>
                            <span class="text-white/50">•</span>
                            <span class="italic">{{ $post->created_at->diffForHumans() }}</span>
                        </p>
                        <p class="text-white/60 text-base line-clamp-3 leading-relaxed">
                            {{ Str::limit(strip_tags($post->content), 200) }}
                        </p>
                        <div class="flex items-center text-blue-300 group-hover:text-blue-200 mt-4 text-sm font-medium">
                            Baca Selengkapnya
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1 transform group-hover:translate-x-1 transition-transform duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                            </svg>
                        </div>
                    </a>
                </div>
            @empty
                <div class="md:col-span-3 text-center py-20 bg-white/5 backdrop-blur-sm rounded-2xl shadow-lg border border-white/10">
                    <svg class="mx-auto h-20 w-20 text-blue-400/70 mb-6 animate-bounce-slow" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12.76c0 1.6 1.123 2.994 2.707 3.227 1.087.16 2.185.283 3.293.369V21l4.076-4.076a1.526 1.526 0 0 1 1.037-.443 48.282 48.282 0 0 0 5.68-.494c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0 0 12 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018Z" />
                    </svg>
                    <p class="text-white/90 text-2xl font-bold mb-3">Belum ada diskusi nih...</p>
                    <p class="text-white/70 text-lg mb-8">Jadilah yang pertama memulai percakapan seru dan bermanfaat!</p>
                    <a href="{{ route('forum.create') }}"
                       class="inline-flex items-center gap-3 bg-gradient-to-r from-blue-600 to-purple-700 hover:from-blue-700 hover:to-purple-800 text-white px-8 py-4 rounded-xl text-lg font-semibold shadow-xl hover:shadow-2xl transition duration-300 transform hover:-translate-y-1 hover:scale-105 focus:outline-none focus:ring-4 focus:ring-blue-300 focus:ring-opacity-75">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        Mulai Diskusi Baru
                    </a>
                </div>
            @endforelse
        </div>

        @if ($forumPosts->hasPages())
            <div class="mt-16 flex justify-center"> {{-- Centered pagination --}}
                {{ $forumPosts->links() }}
            </div>
        @endif
    </div>

    @push('styles')
        <style>
            /* Custom keyframe for a subtle pulsating gradient effect */
            @keyframes gradient-pulse {
                0%, 100% { background-position: 0% 50%; }
                50% { background-position: 100% 50%; }
            }

            .animate-gradient-pulse {
                background-size: 200% auto;
                animation: gradient-pulse 4s ease infinite;
            }

            /* Tailwind-like styling for pagination, targeting Laravel's default output */
            .pagination {
                display: flex;
                justify-content: center;
                align-items: center;
                list-style: none;
                padding: 0;
            }

            .pagination li {
                margin: 0 0.25rem; /* Equivalent to mx-1 */
            }

            .pagination li span,
            .pagination li a {
                display: block;
                padding: 0.75rem 1.25rem; /* Equivalent to px-5 py-3 */
                border-radius: 0.75rem; /* Equivalent to rounded-xl */
                transition: all 0.2s ease-in-out;
                font-weight: 500;
                text-decoration: none;
                color: rgba(255, 255, 255, 0.7); /* text-white/70 */
                background-color: rgba(255, 255, 255, 0.05); /* bg-white/5 */
                border: 1px solid rgba(255, 255, 255, 0.1); /* border-white/10 */
            }

            .pagination li a:hover {
                background-color: rgba(255, 255, 255, 0.15); /* hover:bg-white/15 */
                color: white;
                border-color: rgba(255, 255, 255, 0.2);
            }

            .pagination li.active span {
                background-image: linear-gradient(to right, #3b82f6, #8b5cf6); /* from-blue-500 to-purple-600 */
                color: white;
                font-weight: 700;
                border-color: transparent;
                box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2); /* shadow-lg */
            }

            .pagination li.disabled span {
                color: rgba(255, 255, 255, 0.4); /* text-white/40 */
                pointer-events: none;
                background-color: rgba(255, 255, 255, 0.02);
                border-color: rgba(255, 255, 255, 0.05);
            }

            /* Improve spacing for prev/next buttons if they exist */
            .pagination li:first-child a,
            .pagination li:last-child a {
                padding-left: 1.5rem; /* px-6 */
                padding-right: 1.5rem; /* px-6 */
            }
        </style>
    @endpush

</x-app-layout>