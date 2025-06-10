<x-app-layout>

    <div class="max-w-7xl mx-auto mt-16 mb-12 px-4 sm:px-6 lg:px-8">
        {{-- Header Section --}}
        <div class="flex flex-col lg:flex-row justify-between items-center mb-12 gap-8">
            <div class="text-center lg:text-left">
                <h1 class="text-5xl font-extrabold text-white tracking-tight leading-tight mb-3">
                    <span class="bg-clip-text text-transparent bg-gradient-to-r from-blue-400 via-purple-500 to-pink-500 animate-gradient-pulse">
                        💬 Jelajahi Diskusi Komunitas
                    </span>
                </h1>
                <p class="text-white/70 text-lg max-w-2xl">
                    Bergabunglah dalam diskusi yang menarik dan berbagi pengetahuan dengan komunitas
                </p>
            </div>
            <a href="{{ route('forum.create') }}"
               class="inline-flex items-center gap-3 bg-gradient-to-r from-blue-600 via-purple-600 to-pink-600 hover:from-blue-700 hover:via-purple-700 hover:to-pink-700 text-white px-8 py-4 rounded-2xl text-lg font-semibold shadow-2xl hover:shadow-pink-500/25 transition duration-300 transform hover:-translate-y-1 hover:scale-105 focus:outline-none focus:ring-4 focus:ring-purple-300 focus:ring-opacity-75 backdrop-blur-sm border border-white/10">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                Mulai Diskusi Baru
            </a>
        </div>

        {{-- Form untuk Search, Filter, dan Sort --}}
        <form method="GET" action="{{ route('forum.index') }}" id="filterForm" class="mb-10 space-y-6">
            {{-- Search Bar with Button --}}
            <div class="flex items-stretch gap-2 md:gap-3">
                <div class="relative flex-grow">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-white/50" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <input type="text" name="keyword" id="searchInput" value="{{ $keyword ?? '' }}" placeholder="Cari diskusi berdasarkan judul atau konten..."
                           class="w-full h-full pl-12 pr-4 py-4 rounded-2xl bg-white/10 backdrop-blur-lg text-white placeholder-white/50 border border-white/20 focus:border-purple-400 focus:ring-2 focus:ring-purple-400 focus:ring-opacity-50 transition duration-300 text-lg shadow-xl">
                </div>
                <button type="submit" id="searchButton" aria-label="Cari"
                        class="inline-flex items-center justify-center gap-2 bg-gradient-to-r from-purple-600 to-pink-600 hover:from-purple-700 hover:to-pink-700 text-white px-5 sm:px-6 py-3 rounded-2xl text-lg font-semibold shadow-xl hover:shadow-purple-500/25 transition duration-300 transform hover:-translate-y-0.5 focus:outline-none focus:ring-4 focus:ring-purple-300 focus:ring-opacity-75">
                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    <span class="hidden sm:inline">Cari</span>
                </button>
            </div>

            {{-- Filter Categories & Sort Options --}}
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                {{-- Category Filter Menggunakan SELECT --}}
                <div class="flex items-center gap-3">
                    <span class="text-white/70 font-medium">Filter Kategori:</span>
                    <select name="category" id="categorySelect" onchange="document.getElementById('filterForm').submit()"
                            class="px-4 py-2.5 rounded-xl bg-white/5 text-white border border-white/20 focus:outline-none focus:ring-2 focus:ring-purple-400 focus:border-transparent transition duration-200 appearance-none min-w-[220px] filter-btn">
                        <option value="all" @if(($categorySlug ?? 'all') == 'all') selected @endif class="bg-gray-800 hover:bg-purple-600">Semua Kategori</option>
                        @isset($categories)
                            @foreach ($categories as $category_item)
                                <option value="{{ $category_item->slug }}" @if(($categorySlug ?? '') == $category_item->slug) selected @endif class="bg-gray-800 hover:bg-purple-600">
                                    {{ $category_item->name }}
                                </option>
                            @endforeach
                        @else
                            <option value="" disabled class="bg-gray-800">Kategori tidak dapat dimuat.</option>
                        @endisset
                    </select>
                </div>
                
                {{-- Sort Options --}}
                <div class="flex items-center gap-3">
                    <span class="text-white/70 font-medium">Urutkan:</span>
                    <select name="sort" id="sortSelect" onchange="document.getElementById('filterForm').submit()"
                            class="px-4 py-2.5 rounded-xl bg-white/5 text-white border border-white/20 focus:outline-none focus:ring-2 focus:ring-purple-400 focus:border-transparent transition duration-200 appearance-none min-w-[180px] filter-btn">
                        <option value="newest" @if(($sortOrder ?? 'newest') == 'newest') selected @endif class="bg-gray-800 hover:bg-purple-600">Terbaru</option>
                        <option value="oldest" @if(($sortOrder ?? 'newest') == 'oldest') selected @endif class="bg-gray-800 hover:bg-purple-600">Terlama</option>
                        <option value="most-replied" @if(($sortOrder ?? 'newest') == 'most-replied') selected @endif class="bg-gray-800 hover:bg-purple-600">Paling Banyak Balasan</option>
                    </select>
                </div>

                {{-- Result Count --}}
                <div class="text-white/60 text-sm sm:ml-auto">
                    <span id="resultCount">{{ $forumPosts->total() }}</span> diskusi ditemukan
                </div>
            </div>
        </form> {{-- Akhir form --}}


        {{-- Forum Posts Grid --}}
        <div id="postsContainer" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($forumPosts as $post)
                <div class="forum-post bg-white/10 backdrop-blur-lg rounded-2xl p-7 transition-all duration-300 hover:bg-white/20 shadow-xl hover:shadow-2xl border border-white/10 hover:border-white/30 transform hover:-translate-y-2 hover:scale-[1.02] group">
                    <a href="{{ route('forum.show', $post->id) }}" class="block">
                        <div class="flex justify-between items-start mb-4">
                            <div class="flex-1 pr-4">
                                <h2 class="text-xl font-bold text-white group-hover:text-purple-300 transition duration-200 leading-tighcategoryBadgeSlugt line-clamp-2">
                                    {{ $post->title }}
                                </h2>
                            </div>
                            @if($post->category)
                                <span class="category-badge text-xs px-3 py-1.5 rounded-full font-medium shadow-lg whitespace-nowrap
                                    @php
                                        // Logika pewarnaan badge kategori tetap di sini, ini untuk tampilan per post
                                        $categoryBadgeSlug = $post->category->slug ?? '';
                                        $bgColorClass = 'bg-sky-500/80 text-white'; 
                                        if (Str::contains($categoryBadgeSlug, ['teknologi', 'komputer', 'it'])) $bgColorClass = 'bg-blue-500/80 text-white';
                                        elseif (Str::contains($categoryBadgeSlug, 'edukasi')) $bgColorClass = 'bg-green-500/80 text-white';
                                        elseif (Str::contains($categoryBadgeSlug, ['bisnis', 'pemasaran', 'karir'])) $bgColorClass = 'bg-yellow-500/80 text-black';
                                        elseif (Str::contains($categoryBadgeSlug, ['gaya-hidup', 'hobi'])) $bgColorClass = 'bg-pink-500/80 text-white';
                                        elseif (Str::contains($categoryBadgeSlug, ['olahraga', 'kesehatan'])) $bgColorClass = 'bg-red-500/80 text-white';
                                        elseif (Str::contains($categoryBadgeSlug, ['seni', 'desain', 'kreativitas'])) $bgColorClass = 'bg-purple-500/80 text-white';
                                        elseif (Str::contains($categoryBadgeSlug, 'bahasa')) $bgColorClass = 'bg-teal-500/80 text-white';
                                    @endphp
                                    {{ $bgColorClass }}">
                                    {{ $post->category->name }}
                                </span>
                            @else
                                <span class="category-badge text-xs px-3 py-1.5 rounded-full font-medium shadow-lg whitespace-nowrap bg-gray-400/80 text-white">
                                    Uncategorized
                                </span>
                            @endif
                        </div>

                        <div class="flex items-center gap-3 mb-4 text-sm text-white/70">
                            <div class="flex items-center gap-2">
                                <div class="w-8 h-8 bg-gradient-to-br from-purple-400 to-pink-400 rounded-full flex items-center justify-center text-white font-semibold text-xs">
                                    {{ substr($post->user->name, 0, 1) }}
                                </div>
                                <span class="font-medium text-white/90">{{ $post->user->name }}</span>
                            </div>
                            <span class="text-white/40">•</span>
                            <span class="italic text-white/60">{{ $post->created_at->diffForHumans() }}</span>
                        </div>

                        <p class="text-white/70 text-sm line-clamp-3 leading-relaxed mb-4">
                            {{ Str::limit(strip_tags($post->content), 150) }}
                        </p>

                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-4 text-xs text-white/60">
                                <span class="flex items-center gap-1">
                                    <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10c0 3.866-3.582 7-8 7a8.841 8.841 0 01-4.083-.98L2 17l1.338-3.123C2.493 12.767 2 11.434 2 10c0-3.866 3.582-7 8-7s8 3.134 8 7zM7 9H5v2h2V9zm8 0h-2v2h2V9zM9 9h2v2H9V9z" clip-rule="evenodd" /></svg>
                                    {{ $post->comments_count }} balasan
                                </span>
                                <span class="flex items-center gap-1">
                                    <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20"><path d="M10 12a2 2 0 100-4 2 2 0 000 4z" /><path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" /></svg>
                                    {{ $post->views_count ?? 0 }} views
                                </span>
                            </div>
                            <div class="flex items-center text-purple-300 group-hover:text-purple-200 text-sm font-medium">
                                Baca Selengkapnya
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1 transform group-hover:translate-x-1 transition-transform duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" /></svg>
                            </div>
                        </div>
                    </a>
                </div>
            @empty
                <div class="md:col-span-3 text-center py-20 bg-white/5 backdrop-blur-sm rounded-2xl shadow-lg border border-white/10">
                    <div class="relative">
                        <svg class="mx-auto h-24 w-24 text-purple-400/70 mb-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 5.25h.008v.008H12v-.008Z" />
                        </svg>
                        <div class="absolute inset-0 bg-gradient-to-t from-purple-500/10 to-transparent rounded-full blur-xl"></div>
                    </div>
                    @if(!empty($keyword) || (!empty($categorySlug) && $categorySlug !== 'all'))
                        <p class="text-white/90 text-2xl font-bold mb-3">Tidak ada diskusi yang cocok.</p>
                        <p class="text-white/70 text-lg mb-8 max-w-md mx-auto">Coba ubah kata kunci pencarian atau filter kategori Anda.</p>
                    @else
                        <p class="text-white/90 text-2xl font-bold mb-3">Belum ada diskusi nih...</p>
                        <p class="text-white/70 text-lg mb-8 max-w-md mx-auto">Jadilah yang pertama memulai percakapan seru dan bermanfaat dengan komunitas!</p>
                    @endif
                    <a href="{{ route('forum.create') }}"
                       class="inline-flex items-center gap-3 bg-gradient-to-r from-purple-600 to-pink-600 hover:from-purple-700 hover:to-pink-700 text-white px-8 py-4 rounded-2xl text-lg font-semibold shadow-2xl hover:shadow-purple-500/25 transition duration-300 transform hover:-translate-y-1 hover:scale-105 focus:outline-none focus:ring-4 focus:ring-purple-300 focus:ring-opacity-75">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6m0 0v6m0-6h6m-6 0H6" /></svg>
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
        @keyframes gradient-pulse{0%,to{background-position:0 50%;background-size:200% auto}50%{background-position:100% 50%;background-size:220% auto}}
        .animate-gradient-pulse{animation:gradient-pulse 6s ease infinite}
        .filter-btn{ /* Class ini sekarang juga dipakai oleh select */
            background:rgba(255,255,255,.1);
            backdrop-filter:blur(10px);
            color:#fff!important;
            border:1px solid rgba(255,255,255,.1);
            padding-left: 1rem; /* Pastikan padding konsisten jika memakai class yang sama */
            padding-right: 1rem;
        }
        .filter-btn:hover{
            background:rgba(255,255,255,.2);
            color:#fff!important;
            border-color:rgba(255,255,255,.3);
        }
        /* Tidak ada .active untuk select standar, jadi .filter-btn.active tidak relevan untuk select */

        .pagination{display:flex;justify-content:center;align-items:center;list-style:none;padding:0;gap:.5rem}
        .pagination li span,.pagination li a{display:block;padding:.75rem 1.25rem;border-radius:1rem;transition:all .3s ease;font-weight:500;text-decoration:none;color:rgba(255,255,255,.7);background:rgba(255,255,255,.1);backdrop-filter:blur(10px);border:1px solid rgba(255,255,255,.1)}
        .pagination li a:hover{background:rgba(255,255,255,.2);color:#fff;border-color:rgba(255,255,255,.3);transform:translateY(-2px)}
        .pagination li.active span{background:linear-gradient(135deg,#8b5cf6,#ec4899);color:#fff;font-weight:700;border-color:transparent;box-shadow:0 8px 25px rgba(139,92,246,.3)}
        .pagination li.disabled span{color:rgba(255,255,255,.3);pointer-events:none;background:rgba(255,255,255,.05);border-color:rgba(255,255,255,.05)}
        .line-clamp-2{display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden}
        .line-clamp-3{display:-webkit-box;-webkit-line-clamp:3;-webkit-box-orient:vertical;overflow:hidden}
        @keyframes bounce-slow{0%,to{transform:translateY(0);animation-timing-function:cubic-bezier(.8,0,1,1)}50%{transform:translateY(-10px);animation-timing-function:cubic-bezier(0,0,.2,1)}}
        .animate-bounce-slow{animation:bounce-slow 3s infinite}
        ::-webkit-scrollbar{width:8px}
        ::-webkit-scrollbar-track{background:rgba(255,255,255,.1);border-radius:4px}
        ::-webkit-scrollbar-thumb{background:rgba(139,92,246,.6);border-radius:4px}
        ::-webkit-scrollbar-thumb:hover{background:rgba(139,92,246,.8)}
        /* CSS untuk custom dropdown (id #categoryDropdownMenu, #categoryDropdownButton, #categoryDropdownChevron) tidak lagi diperlukan */
    </style>
    @endpush

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // JavaScript untuk interaksi dropdown custom (seperti membuka/menutup menu, update teks tombol)
                // TIDAK LAGI DIPERLUKAN karena kita menggunakan elemen <select> standar.
                // Input hidden untuk kategori juga TIDAK LAGI DIPERLUKAN karena <select name="category"> sudah menghandle-nya.

                // Animasi untuk post saat muncul di viewport (Intersection Observer)
                const postsToAnimate = document.querySelectorAll('.forum-post');
                if (postsToAnimate.length > 0 && "IntersectionObserver" in window) {
                    postsToAnimate.forEach((post) => {
                        post.style.opacity = '0';
                        post.style.transform = 'translateY(20px) scale(0.98)';
                    });
                    const observerOptions = { threshold: 0.1, rootMargin: '0px 0px -50px 0px' };
                    const observer = new IntersectionObserver((entries, obs) => {
                        entries.forEach(entry => {
                            if (entry.isIntersecting) {
                                entry.target.style.transition = 'opacity 0.6s ease-out, transform 0.6s ease-out';
                                entry.target.style.opacity = '1';
                                entry.target.style.transform = 'translateY(0) scale(1)';
                            }
                        });
                    }, observerOptions);
                    postsToAnimate.forEach(post => { observer.observe(post); });
                } else {
                     postsToAnimate.forEach((post) => {
                        post.style.opacity = '1';
                        post.style.transform = 'translateY(0) scale(1)';
                    });
                }
            });
        </script>
    @endpush

</x-app-layout>