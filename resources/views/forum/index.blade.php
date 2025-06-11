<x-app-layout>
    {{--
        Page Container
        - Increased top margin (mt-24) for more breathing room from the navbar.
        - Increased bottom margin (mb-24) for a balanced layout.
    --}}
    <div class="max-w-7xl mx-auto mt-24 mb-24 px-4 sm:px-6 lg:px-8">

        {{-- Header Section --}}
        <div class="flex flex-col lg:flex-row justify-between items-center mb-16 gap-8">
            <div class="text-center lg:text-left">
                <h1 class="text-5xl font-extrabold text-white tracking-tight leading-tight mb-4">
                    {{--
                        Refined Heading with New Colors
                        - Gradient updated to a cool, professional blue-to-teal transition.
                    --}}
                    <span class="bg-clip-text text-transparent bg-gradient-to-r from-blue-400 to-teal-400">
                        💬 Jelajahi Diskusi Komunitas
                    </span>
                </h1>
                <p class="text-slate-300 text-lg max-w-2xl">
                    Bergabunglah dalam diskusi yang menarik dan berbagi pengetahuan dengan komunitas.
                </p>
            </div>
            {{--
                Refined "New Discussion" Button with New Colors
                - Gradient, shadow, and focus ring now use the new blue/teal palette.
            --}}
            <a href="{{ route('forum.create') }}"
               class="inline-flex items-center gap-3 bg-gradient-to-r from-blue-500 to-teal-500 hover:from-blue-600 hover:to-teal-600 text-white px-8 py-4 rounded-xl text-lg font-semibold shadow-lg shadow-teal-900/40 hover:shadow-lg hover:shadow-teal-700/40 transition-all duration-300 transform hover:-translate-y-1 focus:outline-none focus:ring-4 focus:ring-teal-400 focus:ring-opacity-75">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m6-6H6" />
                </svg>
                <span>Mulai Diskusi Baru</span>
            </a>
        </div>

        {{-- Search & Filter Control Panel --}}
        <form method="GET" action="{{ route('forum.index') }}" id="filterForm" class="mb-12">
            <div class="bg-slate-900/50 backdrop-blur-lg border border-white/10 rounded-2xl p-6 space-y-6">
                {{-- Search Bar --}}
                <div class="flex items-stretch gap-3">
                    <div class="relative flex-grow">
                        <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-slate-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                        <input type="text" name="keyword" id="searchInput" value="{{ $keyword ?? '' }}" placeholder="Cari diskusi berdasarkan judul atau konten..."
                               class="w-full h-full pl-14 pr-5 py-4 rounded-xl bg-slate-800/60 text-white placeholder-slate-400 border border-white/10 focus:border-teal-500 focus:ring-2 focus:ring-teal-500 transition duration-300 text-base shadow-inner" />
                    </div>
                    <button type="submit" id="searchButton" aria-label="Cari"
                            class="inline-flex items-center justify-center gap-2 bg-teal-600 hover:bg-teal-500 text-white px-6 py-3 rounded-xl text-base font-semibold shadow-md transition duration-300 transform hover:-translate-y-0.5 focus:outline-none focus:ring-4 focus:ring-teal-400 focus:ring-opacity-75">
                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        <span class="hidden sm:inline">Cari</span>
                    </button>
                </div>

                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                    <div class="flex flex-wrap items-center gap-x-6 gap-y-4">
                        <div class="flex items-center gap-3">
                            <label for="categorySelect" class="text-slate-300 font-medium">Kategori:</label>
                            <div class="relative">
                                <select name="category" id="categorySelect" onchange="document.getElementById('filterForm').submit()"
                                        class="pl-4 pr-10 py-2.5 rounded-xl bg-slate-800/60 text-slate-200 border border-white/10 focus:outline-none focus:ring-2 focus:ring-teal-500 transition duration-200 appearance-none">
                                    <option value="all" @if(($categorySlug ?? 'all') == 'all') selected @endif>Semua Kategori</option>
                                    @isset($categories)
                                        @foreach ($categories as $category_item)
                                            <option value="{{ $category_item->slug }}" @if(($categorySlug ?? '') == $category_item->slug) selected @endif>
                                                {{ $category_item->name }}
                                            </option>
                                        @endforeach
                                    @else
                                        <option value="" disabled>Kategori tidak dapat dimuat.</option>
                                    @endisset
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-slate-400">
                                    <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd" /></svg>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center gap-3">
                            <label for="sortSelect" class="text-slate-300 font-medium">Urutkan:</label>
                            <div class="relative">
                                <select name="sort" id="sortSelect" onchange="document.getElementById('filterForm').submit()"
                                        class="pl-4 pr-10 py-2.5 rounded-xl bg-slate-800/60 text-slate-200 border border-white/10 focus:outline-none focus:ring-2 focus:ring-teal-500 transition duration-200 appearance-none">
                                    <option value="newest" @if(($sortOrder ?? 'newest') == 'newest') selected @endif>Terbaru</option>
                                    <option value="oldest" @if(($sortOrder ?? 'newest') == 'oldest') selected @endif>Terlama</option>
                                    <option value="most-replied" @if(($sortOrder ?? 'newest') == 'most-replied') selected @endif>Paling Populer</option>
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-slate-400">
                                    <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd" /></svg>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="text-slate-400 text-sm text-left md:text-right">
                        Menampilkan <span class="font-semibold text-slate-200">{{ $forumPosts->total() }}</span> hasil
                    </div>
                </div>
            </div>
        </form>

        {{-- Forum Posts Grid --}}
        <div id="postsContainer" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($forumPosts as $post)
                @php
                    $categoryBadgeSlug = $post->category->slug ?? 'umum';
                    $badgeColors = [
                        'teknologi'   => 'bg-sky-500/10 text-sky-300 border-sky-500/20',
                        'edukasi'     => 'bg-emerald-500/10 text-emerald-300 border-emerald-500/20',
                        'bisnis'      => 'bg-amber-500/10 text-amber-300 border-amber-500/20',
                        'gaya-hidup'  => 'bg-pink-500/10 text-pink-300 border-pink-500/20',
                        'olahraga'    => 'bg-red-500/10 text-red-300 border-red-500/20',
                        // Replaced Violet with Purple for 'Seni' (Art)
                        'seni'        => 'bg-purple-500/10 text-purple-300 border-purple-500/20',
                        'bahasa'      => 'bg-cyan-500/10 text-cyan-300 border-cyan-500/20',
                        'umum'        => 'bg-slate-500/10 text-slate-300 border-slate-500/20',
                    ];
                    $bgColorClass = collect($badgeColors)->first(fn($v, $k) => Str::contains($categoryBadgeSlug, $k)) ?? $badgeColors['umum'];
                @endphp
                
                <a href="{{ route('forum.show', $post->id) }}" class="forum-post group flex flex-col h-full bg-slate-900/50 backdrop-blur-lg rounded-2xl p-6 transition-all duration-300 hover:bg-slate-800/60 shadow-lg hover:shadow-2xl hover:shadow-black/20 border border-white/10 hover:border-teal-500/50 transform hover:-translate-y-2">
                    <div class="flex-1">
                        <div class="flex items-start justify-between gap-4 mb-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-gradient-to-br from-slate-600 to-slate-700 rounded-full flex items-center justify-center text-slate-200 font-bold text-lg shadow-inner">
                                    {{ substr($post->user->name, 0, 1) }}
                                </div>
                                <div>
                                    <div class="font-semibold text-slate-100 text-base leading-tight">{{ $post->user->name }}</div>
                                    <div class="text-xs text-slate-400">{{ $post->created_at->diffForHumans() }}</div>
                                </div>
                            </div>
                            @if($post->category)
                                <span class="flex-shrink-0 {{ $bgColorClass }} text-xs font-semibold px-3 py-1 rounded-full border">
                                    {{ $post->category->name }}
                                </span>
                            @endif
                        </div>
                        {{-- Title now hovers to the new accent color --}}
                        <h2 class="text-xl font-bold text-slate-50 group-hover:text-teal-400 transition duration-200 leading-snug line-clamp-2 mb-3">
                            {{ $post->title }}
                        </h2>
                        <p class="text-slate-400 text-sm line-clamp-3 leading-relaxed">
                            {{ Str::limit(strip_tags($post->content), 150) }}
                        </p>
                    </div>
                    <div class="flex items-center justify-between mt-6 pt-4 border-t border-white/10">
                        <div class="flex items-center gap-4 text-xs text-slate-400">
                            <span class="flex items-center gap-1.5">
                                <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10c0 3.866-3.582 7-8 7a8.841 8.841 0 01-4.083-.98L2 17l1.338-3.123C2.493 12.767 2 11.434 2 10c0-3.866 3.582-7 8-7s8 3.134 8 7zM7 9H5v2h2V9zm8 0h-2v2h2V9zM9 9h2v2H9V9z" clip-rule="evenodd" /></svg>
                                {{ $post->comments_count }} balasan
                            </span>
                            <span class="flex items-center gap-1.5">
                                <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20"><path d="M10 12a2 2 0 100-4 2 2 0 000 4z" /><path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" /></svg>
                                {{ $post->views_count ?? 0 }} views
                            </span>
                        </div>
                        <div class="flex items-center text-teal-500 group-hover:text-teal-400 text-sm font-medium">
                            <span>Detail</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1 transform group-hover:translate-x-1 transition-transform duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" /></svg>
                        </div>
                    </div>
                </a>
            @empty
                {{-- Refined Empty State with New Colors --}}
                <div class="md:col-span-3 text-center py-20 bg-slate-900/50 backdrop-blur-sm rounded-2xl shadow-lg border border-white/10">
                    <div class="relative inline-block">
                        <svg class="mx-auto h-24 w-24 text-teal-400/50 mb-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 5.25h.008v.008H12v-.008Z" />
                        </svg>
                        <div class="absolute inset-0 bg-gradient-to-t from-teal-500/10 to-transparent rounded-full blur-2xl"></div>
                    </div>
                    @if(!empty($keyword) || (!empty($categorySlug) && $categorySlug !== 'all'))
                        <p class="text-slate-50 text-2xl font-bold mb-3">Tidak ada diskusi yang cocok.</p>
                        <p class="text-slate-300 text-lg mb-8 max-w-md mx-auto">Coba ubah kata kunci pencarian atau filter kategori Anda.</p>
                    @else
                        <p class="text-slate-50 text-2xl font-bold mb-3">Belum ada diskusi nih...</p>
                        <p class="text-slate-300 text-lg mb-8 max-w-md mx-auto">Jadilah yang pertama memulai percakapan seru di komunitas!</p>
                    @endif
                    <a href="{{ route('forum.create') }}"
                       class="inline-flex items-center gap-3 bg-gradient-to-r from-blue-500 to-teal-500 hover:from-blue-600 hover:to-teal-600 text-white px-8 py-4 rounded-xl text-lg font-semibold shadow-lg shadow-teal-900/40 hover:shadow-lg hover:shadow-teal-700/40 transition-all duration-300 transform hover:-translate-y-1 focus:outline-none focus:ring-4 focus:ring-teal-400 focus:ring-opacity-75">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m6-6H6" /></svg>
                        Mulai Diskusi Baru
                    </a>
                </div>
            @endforelse
        </div>

        @if ($forumPosts->hasPages())
            <div class="mt-16 flex justify-center">
                {{ $forumPosts->links() }}
            </div>
        @endif
    </div>

    @push('styles')
    <style>
        .line-clamp-2 { display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
        .line-clamp-3 { display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; }
    </style>
    @endpush

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const postsToAnimate = document.querySelectorAll('.forum-post');
            if (!("IntersectionObserver" in window)) {
                postsToAnimate.forEach(post => { post.style.opacity = '1'; post.style.transform = 'translateY(0)'; });
                return;
            }
            postsToAnimate.forEach((post, index) => {
                post.style.opacity = '0';
                post.style.transform = 'translateY(30px)';
                post.style.transition = `opacity 0.6s ease ${index * 0.05}s, transform 0.6s ease ${index * 0.05}s`;
            });
            const observer = new IntersectionObserver((entries, obs) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.opacity = '1';
                        entry.target.style.transform = 'translateY(0)';
                        obs.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.1, rootMargin: '0px 0px -50px 0px' });
            postsToAnimate.forEach(post => observer.observe(post));

            const searchInput = document.getElementById('searchInput');
            if (searchInput) {
                searchInput.addEventListener('keypress', function(e) {
                    if (e.key === 'Enter') {
                        e.preventDefault();
                        document.getElementById('filterForm').submit();
                    }
                });
            }
        });
    </script>
    @endpush
</x-app-layout>