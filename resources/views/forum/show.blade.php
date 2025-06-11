<x-app-layout>
    {{-- Memuat SweetAlert & CSRF Token di head --}}
    <x-slot name="header">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    </x-slot>

    {{-- Container Halaman --}}
    <div class="py-10 sm:py-12">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Tombol Kembali & Aksi Postingan (Edit/Hapus) --}}
            <div class="flex flex-col sm:flex-row justify-between sm:items-center gap-4 mb-6">
                <a href="{{ route('forum.index') }}"
                   class="inline-flex items-center gap-2 text-slate-300 hover:text-white font-semibold px-5 py-2 rounded-lg shadow-sm transition duration-300 bg-slate-800/50 hover:bg-slate-700/60 border border-slate-700">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                    </svg>
                    <span>Kembali ke Forum</span>
                </a>
                @if (auth()->check() && auth()->id() === $post->user_id)
                    <div class="flex items-center gap-4">
                        <a href="{{ route('forum.edit', $post->id) }}" class="inline-flex items-center gap-2 px-5 py-2 bg-sky-600 text-white rounded-lg shadow-md hover:bg-sky-700 focus:outline-none focus:ring-4 focus:ring-sky-400 transition font-semibold text-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor"><path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z" /><path fill-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" clip-rule="evenodd" /></svg>
                            <span>Edit</span>
                        </a>
                        <form action="{{ route('forum.destroy', $post->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus postingan ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="inline-flex items-center gap-2 px-5 py-2 bg-red-600 text-white rounded-lg shadow-md hover:bg-red-700 focus:outline-none focus:ring-4 focus:ring-red-400 transition font-semibold text-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" /></svg>
                                <span>Hapus</span>
                            </button>
                        </form>
                    </div>
                @endif
            </div>

            {{-- Konten Utama Postingan --}}
            <div class="bg-slate-800/50 backdrop-blur-md rounded-2xl p-6 md:p-8 shadow-2xl border border-slate-700/50">
                <h1 class="text-2xl md:text-3xl font-extrabold mb-3 text-white tracking-tight">{{ $post->title }}</h1>
                
                {{-- Metadata --}}
                <div class="flex flex-wrap items-center gap-x-4 gap-y-2 text-xs text-slate-400 mb-6">
                    <span>Oleh <span class="font-semibold text-slate-200">{{ $post->user->name }}</span></span>
                    <span class="text-slate-600">&middot;</span>
                    <time datetime="{{ $post->created_at->toIso8601String() }}">{{ $post->created_at->diffForHumans() }}</time>
                    @if($post->category)
                        <span class="text-slate-600">&middot;</span>
                        <span class="inline-block bg-teal-500/10 text-teal-300 text-xs font-semibold px-2.5 py-0.5 rounded-full border border-teal-500/20">
                            {{ $post->category->name }}
                        </span>
                    @endif
                    <span class="text-slate-600">&middot;</span>
                    <span class="flex items-center gap-1.5"><svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg> {{ $post->views_count ?? 0 }} views</span>
                    @auth
                        <span class="text-slate-600">&middot;</span>
                        <button type="button" id="bookmark-button" class="bookmark-button inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full transition-all duration-200 text-xs
                            {{ $post->isBookmarkedBy(auth()->user()) ? 'bg-amber-400/10 text-amber-300 ring-1 ring-amber-400/30' : 'bg-slate-700/60 text-slate-300 hover:bg-slate-600/80' }}"
                            data-post-id="{{ $post->id }}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" viewBox="0 0 20 20" fill="currentColor"><path d="M5 4a2 2 0 012-2h6a2 2 0 012 2v14l-5-2.5L5 18V4z"/></svg>
                            <span class="bookmark-text">{{ $post->isBookmarkedBy(auth()->user()) ? 'Dibookmark' : 'Bookmark' }}</span>
                        </button>
                    @endauth
                </div>

                @if ($post->image)
                    <div class="mb-8 rounded-lg overflow-hidden border border-slate-700">
                        <img src="{{ asset('storage/' . $post->image) }}" alt="Gambar Postingan" class="w-full max-h-80 object-cover object-center" />
                    </div>
                @endif

                <article class="prose prose-invert max-w-none leading-relaxed">
                    {!! nl2br(e($post->content)) !!}
                </article>

                {{-- Bagian Polling dengan Desain Baru --}}
                @if ($post->poll)
                    @php
                        $isPostCreator = auth()->check() && auth()->id() == $post->user_id;
                        $userHasVotedOnPoll = auth()->check() ? $post->poll->hasVoted(auth()->user()) : false; 
                        $canVoteOnPoll = auth()->check() && !$isPostCreator && !$userHasVotedOnPoll;
                        $totalPollVotes = $post->poll->options->sum('votes_count');
                    @endphp
                    <section class="my-8 p-5 bg-slate-900/50 rounded-xl border border-slate-700">
                        <h3 class="text-lg font-semibold text-white mb-1">{{ $post->poll->question }}</h3>
                        @if (session('success')) <p class="text-xs text-green-400 mt-1 mb-3">{{ session('success') }}</p> @endif
                        @if (session('error')) <p class="text-xs text-red-400 mt-1 mb-3">{{ session('error') }}</p> @endif

                        @if($post->poll->options->isNotEmpty())
                            @if($canVoteOnPoll)
                                <p class="text-xs text-slate-400 mb-4">Pilih salah satu opsi:</p>
                                <div class="space-y-2.5">
                                    @foreach ($post->poll->options as $option)
                                        <form action="{{ route('forum.poll.vote', $option->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="w-full text-left p-2.5 border border-slate-600 rounded-md hover:bg-teal-500/10 hover:border-teal-500/40 focus:outline-none focus:ring-2 focus:ring-teal-500 transition group">
                                                <span class="text-sm text-slate-200 group-hover:text-teal-300">{{ $option->option_text }}</span>
                                            </button>
                                        </form>
                                    @endforeach
                                </div>
                            @else
                                @if ($isPostCreator) <p class="text-xs text-slate-400 mb-4">Ini polling Anda. Anda tidak bisa vote. Berikut hasilnya:</p>
                                @elseif (!auth()->check()) <p class="text-xs text-slate-400 mb-4">Silakan <a href="{{ route('login') }}" class="text-teal-400 hover:underline">login</a> untuk vote. Berikut hasil sementara:</p>
                                @elseif ($userHasVotedOnPoll) <p class="text-xs text-slate-400 mb-4">Anda sudah vote. Berikut hasilnya:</p>
                                @endif
                                <div class="space-y-3 mt-3">
                                    @forelse ($post->poll->options as $option)
                                        @php $percentage = ($totalPollVotes > 0) ? round(($option->votes_count / $totalPollVotes) * 100, 1) : 0; @endphp
                                        <div>
                                            <div class="flex justify-between mb-1 text-xs"><span class="font-medium text-slate-200">{{ $option->option_text }}</span><span class="font-medium text-slate-400">{{ $option->votes_count }} ({{ $percentage }}%)</span></div>
                                            <div class="w-full bg-slate-700 rounded-full h-2"><div class="bg-gradient-to-r from-blue-500 to-teal-400 h-2 rounded-full" style="width: {{ $percentage }}%"></div></div>
                                        </div>
                                    @empty <p class="text-slate-500 italic text-sm">Tidak ada opsi.</p>
                                    @endforelse
                                    @if($totalPollVotes > 0) <p class="text-xs text-slate-500 mt-3 text-right font-medium">Total Suara: {{ $totalPollVotes }}</p>
                                    @endif
                                </div>
                            @endif
                        @else <p class="text-slate-500 italic text-sm">Tidak ada opsi.</p>
                        @endif
                    </section>
                @endif
            </div>

            {{-- Bagian Komentar dengan Desain Baru --}}
            <section class="mt-10">
                <h3 class="text-xl font-semibold mb-6 text-white border-b-2 border-slate-700 pb-2">Komentar ({{ $post->comments->count() }})</h3>
                @php
                    $definedReactionTypes = ['like' => '👍', 'love' => '❤️', 'haha' => '😂', 'wow'  => '😮'];
                @endphp

                <div id="comments-wrapper" class="space-y-4">
                    @forelse($post->comments as $comment)
                        <div class="bg-slate-800/50 p-4 rounded-xl border border-slate-700/50 comment-container" id="comment-{{ $comment->id }}">
                            <p class="text-slate-300 text-sm leading-relaxed whitespace-pre-line">{!! nl2br(e($comment->content)) !!}</p>
                            <div class="flex flex-wrap items-center justify-between mt-3 pt-3 border-t border-slate-700">
                                <p class="text-xs text-slate-400">
                                    oleh <strong class="text-slate-300">{{ $comment->user->name }}</strong> &middot; <time datetime="{{ $comment->created_at->toIso8601String() }}">{{ $comment->created_at->diffForHumans() }}</time>
                                </p>
                                @auth
                                <div class="flex items-center space-x-1.5 reaction-buttons-container">
                                    @foreach($definedReactionTypes as $type => $emoji)
                                        @php
                                            $userReacted = \App\Models\CommentReaction::isClicked(auth()->id(), $comment->id, $type);
                                            $countForThisType = $comment->reactions()->where('reaction_type', $type)->where('is_click', true)->count();
                                        @endphp
                                        <button type="button" class="reaction-button p-1 rounded-full flex items-center space-x-1 text-xs cursor-pointer transition-all duration-200
                                            {{ $userReacted ? 'bg-teal-500/20 text-teal-300 ring-1 ring-teal-500/30' : 'bg-slate-700/60 text-slate-300 hover:bg-slate-600/80' }}"
                                            data-comment-id="{{ $comment->id }}" data-reaction-type="{{ $type }}" title="{{ ucfirst($type) }}">
                                            <span>{{ $emoji }}</span>
                                            <span class="reaction-count font-medium ml-1">{{ $countForThisType > 0 ? $countForThisType : '' }}</span>
                                        </button>
                                    @endforeach
                                </div>
                                @else
                                <div class="flex items-center space-x-1.5">
                                    @foreach($definedReactionTypes as $type => $emoji)
                                        @php $countForThisType = $comment->grouped_reaction_counts->get($type, 0); @endphp
                                        @if($countForThisType > 0)
                                        <span class="p-1 rounded-full flex items-center space-x-1 text-xs bg-slate-700/60 text-slate-300" title="{{ ucfirst($type) }}">
                                            <span class="text-sm">{{ $emoji }}</span>
                                            <span class="font-medium">{{ $countForThisType }}</span>
                                        </span>
                                        @endif
                                    @endforeach
                                </div>
                                @endauth
                            </div>
                        </div>
                    @empty
                        <p class="text-slate-500 italic text-center py-8">Belum ada komentar. Jadilah yang pertama!</p>
                    @endforelse
                </div>

                @auth
                    <form action="{{ route('forum.comment.store', $post->id) }}" method="POST" class="mt-8">
                        @csrf
                        <label for="comment-textarea" class="text-white font-semibold mb-2 block">Tinggalkan Komentar</label>
                        <textarea name="content" id="comment-textarea" rows="3" class="w-full bg-slate-800 text-slate-100 border border-slate-600 rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition duration-200 placeholder-slate-500" placeholder="Tulis komentar..." required></textarea>
                        @error('content') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                        <div class="text-right">
                            <button type="submit" class="mt-3 bg-gradient-to-r from-blue-500 to-teal-500 hover:from-blue-600 hover:to-teal-600 text-white py-2.5 px-6 rounded-lg shadow-lg hover:shadow-teal-900/40 font-semibold transition duration-300 text-sm">
                                Kirim Komentar
                            </button>
                        </div>
                    </form>
                @else
                    <p class="text-center text-slate-400 mt-8">
                        Silakan <a href="{{ route('login') }}" class="text-teal-400 underline hover:text-teal-300 font-semibold">login</a> untuk menambahkan komentar.
                    </p>
                @endauth
            </section>
        </div>
    </div>

    @push('scripts')
    <script>
document.addEventListener('DOMContentLoaded', function() {
    const bookmarkButton = document.getElementById('bookmark-button');

    function getSwalColors() {
        // Tailwind dark mode: class 'dark' di html
        const isDark = document.documentElement.classList.contains('dark');
        return {
            background: '#fff',
            color: isDark ? '#fff' : '#222'
        };
    }

    if (bookmarkButton) {
        bookmarkButton.addEventListener('click', async function(e) {
            e.preventDefault();
            try {
                const response = await fetch("{{ route('forum.bookmarks.toggle', ['post' => $post->id]) }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    },
                    credentials: 'same-origin'
                });
                const data = await response.json();
                if (data.success) {
                    const text = this.querySelector('.bookmark-text');
                    this.classList.toggle('bg-amber-400/10', data.isBookmarked);
                    this.classList.toggle('text-amber-300', data.isBookmarked);
                    this.classList.toggle('ring-1', data.isBookmarked);
                    this.classList.toggle('ring-amber-400/30', data.isBookmarked);
                    this.classList.toggle('bg-slate-700/60', !data.isBookmarked);
                    this.classList.toggle('text-slate-300', !data.isBookmarked);
                    this.classList.toggle('hover:bg-slate-600/80', !data.isBookmarked);
                    text.textContent = data.isBookmarked ? 'Dibookmark' : 'Bookmark';

                    // Custom SweetAlert: kotak putih, teks dinamis, ceklis hijau
                    const swalColors = getSwalColors();
                    Swal.fire({
                        html: `<div style="display:flex;align-items:center;gap:12px;">
                            <svg width="32" height="32" viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="12" fill="#22c55e"/><path d="M7 13l3 3 7-7" stroke="#fff" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                            <span style="font-size:1.1rem;font-weight:600;${swalColors.color === '#fff' ? 'color:#fff;' : 'color:#222;'}">
                                ${data.isBookmarked ? 'Diskusi berhasil ditambahkan ke bookmark!' : 'Bookmark diskusi berhasil dihapus!'}
                            </span>
                        </div>`,
                        background: swalColors.background,
                        color: swalColors.color,
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 1700,
                        customClass: {
                            popup: 'shadow-lg'
                        }
                    });
                }
            } catch (error) {
                const swalColors = getSwalColors();
                Swal.fire({
                    html: `<div style="display:flex;align-items:center;gap:12px;">
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="12" fill="#ef4444"/><path d="M7 13l3 3 7-7" stroke="#fff" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        <span style="font-size:1.1rem;font-weight:600;${swalColors.color === '#fff' ? 'color:#fff;' : 'color:#222;'}">
                            Terjadi kesalahan saat mengubah bookmark!
                        </span>
                    </div>`,
                    background: swalColors.background,
                    color: swalColors.color,
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 1700,
                    customClass: {
                        popup: 'shadow-lg'
                    }
                });
            }
        });
    }

    // --- Reaction Script ---
    document.querySelectorAll('.reaction-button').forEach(button => {
        button.addEventListener('click', async function(e) {
            e.preventDefault();
            const commentId = this.dataset.commentId;
            const reactionType = this.dataset.reactionType;
            try {
                const response = await fetch(`/comments/${commentId}/reactions`, {
                    method: 'POST',
                    headers: {'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content, 'Accept': 'application/json'},
                    body: JSON.stringify({ reaction_type: reactionType })
                });
                const data = await response.json();
                if (data.success) {
                    document.querySelectorAll(`.reaction-button[data-comment-id="${commentId}"]`).forEach(btn => {
                        const type = btn.dataset.reactionType;
                        const isActive = (type === reactionType && data.is_click);
                        btn.classList.toggle('bg-teal-500/20', isActive);
                        btn.classList.toggle('text-teal-300', isActive);
                        btn.classList.toggle('ring-1', isActive);
                        btn.classList.toggle('ring-teal-500/30', isActive);
                        btn.classList.toggle('bg-slate-700/60', !isActive);
                        btn.classList.toggle('text-slate-300', !isActive);
                        btn.classList.toggle('hover:bg-slate-600/80', !isActive);
                        
                        const count = data.reaction_counts[type] ?? 0;
                        btn.querySelector('.reaction-count').textContent = count > 0 ? count : '';
                    });
                }
            } catch (error) {
                console.error('Reaction Error:', error);
            }
        });
    });
});
</script>
    @endpush
</x-app-layout>