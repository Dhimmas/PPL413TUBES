<x-app-layout>
    <div class="max-w-7xl mx-auto mt-16 mb-12 px-4 sm:px-6 lg:px-8">
        {{-- Header Section --}}
        <div class="flex flex-col lg:flex-row justify-between items-center mb-12 gap-8">
            <div class="text-center lg:text-left">
                <h1 class="text-5xl font-extrabold text-white tracking-tight leading-tight mb-3">
                    <span class="bg-clip-text text-transparent bg-gradient-to-r from-blue-400 via-purple-500 to-pink-500 animate-gradient-pulse">
                        🔖 Diskusi yang Dibookmark
                    </span>
                </h1>
                <p class="text-white/70 text-lg max-w-2xl">
                    Kumpulan diskusi yang telah Anda simpan untuk dibaca nanti
                </p>
            </div>
        </div>

        {{-- Bookmarked Posts Grid --}}
        <div id="postsContainer" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($bookmarkedPosts as $post)
                <div class="forum-post bg-white/10 backdrop-blur-lg rounded-2xl p-7 transition-all duration-300 hover:bg-white/20 shadow-xl hover:shadow-2xl border border-white/10 hover:border-white/30 transform hover:-translate-y-2 hover:scale-[1.02] group">
                    <a href="{{ route('forum.show', $post->id) }}" class="block">
                        <div class="flex justify-between items-start mb-4">
                            <div class="flex-1 pr-4">
                                <h2 class="text-xl font-bold text-white group-hover:text-purple-300 transition duration-200 leading-tight line-clamp-2">
                                    {{ $post->title }}
                                </h2>
                            </div>
                            @if($post->category)
                                <span class="category-badge text-xs px-3 py-1.5 rounded-full font-medium shadow-lg whitespace-nowrap {{ $bgColorClass }}">
                                    {{ $post->category->name }}
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

                        <div class="flex justify-between items-center">
                            <div class="flex items-center gap-4 text-xs text-white/60">
                                <span class="flex items-center gap-1">
                                    <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10c0 3.866-3.582 7-8 7a8.841 8.841 0 01-4.083-.98L2 17l1.338-3.123C2.493 12.767 2 11.434 2 10c0-3.866 3.582-7 8-7s8 3.134 8 7zM7 9H5v2h2V9zm8 0h-2v2h2V9zM9 9h2v2H9V9z" clip-rule="evenodd" />
                                    </svg>
                                    {{ $post->comments_count }} balasan
                                </span>
                            </div>
                            <button onclick="removeBookmark('{{ $post->id }}')" class="text-white/60 hover:text-red-400 transition-colors duration-200">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M5 4a2 2 0 012-2h6a2 2 0 012 2v14l-5-2.5L5 18V4z"/>
                                </svg>
                            </button>
                        </div>
                    </a>
                </div>
            @empty
                <div class="md:col-span-3 text-center py-20 bg-white/5 backdrop-blur-sm rounded-2xl shadow-lg border border-white/10">
                    <div class="relative">
                        <svg class="mx-auto h-24 w-24 text-purple-400/70 mb-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/>
                        </svg>
                    </div>
                    <p class="text-white/90 text-2xl font-bold mb-3">Belum ada diskusi yang dibookmark</p>
                    <p class="text-white/70 text-lg mb-8">Mulai simpan diskusi yang menarik untuk dibaca nanti!</p>
                    <a href="{{ route('forum.index') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-purple-600 text-white rounded-xl hover:bg-purple-700 transition-colors duration-200">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        Kembali ke Forum
                    </a>
                </div>
            @endforelse
        </div>

        @if ($bookmarkedPosts->hasPages())
            <div class="mt-16 flex justify-center">
                {{ $bookmarkedPosts->links() }}
            </div>
        @endif
    </div>

    @push('scripts')
    <script>
        async function removeBookmark(postId) {
            if (!confirm('Hapus bookmark ini?')) return;
            
            try {
                const response = await fetch(`/forum/${postId}/bookmark`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    }
                });
                
                const data = await response.json();
                if (data.success) {
                    // Reload halaman untuk memperbarui daftar
                    window.location.reload();
                }
            } catch (error) {
                console.error('Error:', error);
                alert('Terjadi kesalahan saat menghapus bookmark');
            }
        }
    </script>
    @endpush

</x-app-layout>