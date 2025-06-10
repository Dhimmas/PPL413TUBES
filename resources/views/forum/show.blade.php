<x-app-layout>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    </head>

    <div class="max-w-3xl mx-auto mt-14 bg-white rounded-2xl shadow-lg p-10">
        {{-- Tombol Kembali & Header Postingan --}}
        <div class="mb-8">
            <a href="{{ route('forum.index') }}"
               class="inline-flex items-center gap-2 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold px-6 py-3 rounded-lg shadow-sm transition duration-300">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                </svg>
                Kembali ke Forum
            </a>
        </div>

        <h1 class="text-4xl font-extrabold mb-2 text-gray-900 tracking-tight">{{ $post->title }}</h1>
        
        <div class="flex flex-wrap items-center gap-x-4 gap-y-2 text-sm text-gray-500 mb-8">
            <span>Ditulis oleh <span class="font-semibold">{{ $post->user->name }}</span></span>
            <span class="text-gray-300">&middot;</span>
            <time datetime="{{ $post->created_at->toIso8601String() }}" class="italic">
                {{ $post->created_at->diffForHumans() }}
            </time>
            @if($post->category)
                <span class="text-gray-300">&middot;</span>
                <span class="inline-block bg-indigo-100 text-indigo-700 text-xs font-semibold px-3 py-1 rounded-full">
                    {{ $post->category->name }}
                </span>
            @endif
            <span class="text-gray-300">&middot;</span>
            <span class="flex items-center gap-1">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                </svg>
                {{ $post->views_count ?? 0 }} views
            </span>
            @auth
                <span class="text-gray-300">&middot;</span>
                <button type="button"
                    id="bookmark-button"
                    class="bookmark-button inline-flex items-center gap-2 px-3 py-1 rounded-full transition-all duration-200
                        {{ $post->isBookmarkedBy(auth()->user()) ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}"
                    data-post-id="{{ $post->id }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M5 4a2 2 0 012-2h6a2 2 0 012 2v14l-5-2.5L5 18V4z"/>
                    </svg>
                    <span class="bookmark-text text-xs">
                        {{ $post->isBookmarkedBy(auth()->user()) ? 'Dibookmark' : 'Bookmark' }}
                    </span>
                </button>
            @endauth
        </div>

        @if ($post->image)
            <div class="mb-10 rounded-xl overflow-hidden shadow-md">
                <img src="{{ asset('storage/' . $post->image) }}" alt="Gambar Postingan" 
                     class="w-full max-h-[28rem] object-cover object-center" />
            </div>
        @endif

        <article class="prose prose-indigo max-w-none mb-12 leading-relaxed text-gray-800">
            {!! nl2br(e($post->content)) !!}
        </article>

        {{-- Bagian Polling --}}
        @if ($post->poll)
            @php
                $isPostCreator = auth()->check() && auth()->id() == $post->user_id;
                $userHasVotedOnPoll = auth()->check() ? $post->poll->hasVoted(auth()->user()) : false; 
                $canVoteOnPoll = auth()->check() && !$isPostCreator && !$userHasVotedOnPoll;
                $totalPollVotes = $post->poll->options->sum('votes_count');
            @endphp
            <section class="my-12 p-6 bg-gray-50 rounded-xl shadow border border-gray-200">
                <h3 class="text-xl font-semibold text-gray-800 mb-1">{{ $post->poll->question }}</h3>
                @if (session('success')) <p class="text-sm text-green-600 mt-1 mb-4">{{ session('success') }}</p> @endif
                @if (session('error')) <p class="text-sm text-red-600 mt-1 mb-4">{{ session('error') }}</p> @endif

                @if($post->poll->options->isNotEmpty())
                    @if($canVoteOnPoll)
                        <p class="text-sm text-gray-500 mb-6">Pilih salah satu opsi:</p>
                        <div class="space-y-3">
                            @foreach ($post->poll->options as $option)
                                <form action="{{ route('forum.poll.vote', $option->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="w-full text-left p-3 border border-gray-300 rounded-md hover:bg-indigo-100 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition group">
                                        <span class="text-gray-700 group-hover:text-indigo-700">{{ $option->option_text }}</span>
                                    </button>
                                </form>
                            @endforeach
                        </div>
                    @else
                        @if ($isPostCreator) <p class="text-sm text-gray-500 mb-6">Ini polling Anda. Anda tidak bisa vote. Berikut hasilnya:</p>
                        @elseif (!auth()->check()) <p class="text-sm text-gray-500 mb-6">Silakan <a href="{{ route('login') }}" class="text-indigo-600 hover:underline">login</a> untuk vote. Berikut hasil sementara:</p>
                        @elseif ($userHasVotedOnPoll) <p class="text-sm text-gray-500 mb-6">Kamu sudah vote. Berikut hasilnya:</p>
                        @endif
                        <div class="space-y-4 mt-4">
                            @forelse ($post->poll->options as $option)
                                @php $percentage = ($totalPollVotes > 0) ? round(($option->votes_count / $totalPollVotes) * 100, 1) : 0; @endphp
                                <div>
                                    <div class="flex justify-between mb-1"><span class="text-sm font-medium text-gray-700">{{ $option->option_text }}</span><span class="text-sm font-medium text-gray-500">{{ $option->votes_count }} suara ({{ $percentage }}%)</span></div>
                                    <div class="w-full bg-gray-200 rounded-full h-3.5"><div class="bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500 h-3.5 rounded-full" style="width: {{ $percentage }}%"></div></div>
                                </div>
                            @empty <p class="text-gray-500 italic">Tidak ada opsi.</p>
                            @endforelse
                            @if($totalPollVotes > 0) <p class="text-xs text-gray-500 mt-4 text-right font-medium">Total Suara: {{ $totalPollVotes }}</p>
                            @elseif($post->poll->options->isNotEmpty()) <p class="text-gray-500 italic my-4 text-center">Belum ada suara.</p>
                            @endif
                        </div>
                    @endif
                @else <p class="text-gray-500 italic">Tidak ada opsi.</p>
                @endif
            </section>
        @endif
        {{-- AKHIR BAGIAN POLLING --}}

        @if (auth()->check() && auth()->id() === $post->user_id)
            <div class="flex gap-6 mb-16 mt-8">
                <a href="{{ route('forum.edit', $post->id) }}" class="inline-flex items-center gap-3 px-6 py-3 bg-yellow-500 text-white rounded-xl shadow-md hover:bg-yellow-600 focus:outline-none focus:ring-4 focus:ring-yellow-300 transition font-semibold">Edit</a>
                <form action="{{ route('forum.destroy', $post->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus postingan ini?');">@csrf @method('DELETE')<button type="submit" class="inline-flex items-center gap-3 px-6 py-3 bg-red-600 text-white rounded-xl shadow-md hover:bg-red-700 focus:outline-none focus:ring-4 focus:ring-red-300 transition font-semibold">Hapus</button></form>
            </div>
        @endif

        {{-- Bagian Komentar --}}
        <section class="mt-20">
            <h3 class="text-2xl font-semibold mb-8 text-gray-900 border-b-2 border-indigo-500 pb-2">Komentar</h3>

            @php
                $definedReactionTypes = [
                    'like' => '👍',
                    'love' => '❤️',
                    'haha' => '😂',
                    'wow'  => '😮',
                ];
            @endphp

            <div id="comments-wrapper">
            @forelse($post->comments as $comment)
                <div class="bg-gray-50 p-6 rounded-xl mb-6 shadow border border-gray-200 transition hover:shadow-lg comment-container" id="comment-{{ $comment->id }}">
                    <p class="text-gray-700 text-base leading-relaxed whitespace-pre-line">{{ $comment->content }}</p>
                    <p class="text-xs text-gray-500 mt-3">
                        oleh <strong>{{ $comment->user->name }}</strong> &middot; <time datetime="{{ $comment->created_at->toIso8601String() }}">{{ $comment->created_at->diffForHumans() }}</time>
                    </p>

                    {{-- AWAL BAGIAN REAKSI KOMENTAR --}}
                    <div class="mt-4">
                        @auth
                        <div class="flex items-center space-x-2 reaction-buttons-container">
                            @foreach($definedReactionTypes as $type => $emoji)
                                @php
                                    $userReacted = \App\Models\CommentReaction::isClicked(auth()->id(), $comment->id, $type);
                                    $countForThisType = $comment->reactions()->where('reaction_type', $type)->where('is_click', true)->count();
                                @endphp
                                <button type="button"
                                        class="reaction-button p-1.5 rounded-full flex items-center space-x-1 text-xs cursor-pointer
                                               {{ $userReacted ? 'bg-indigo-100 text-indigo-700 ring-1 ring-indigo-300' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}"
                                        data-comment-id="{{ $comment->id }}"
                                        data-reaction-type="{{ $type }}"
                                        title="{{ ucfirst($type) }}">
                                    <span>{{ $emoji }}</span>
                                    <span class="reaction-count ml-1">{{ $countForThisType > 0 ? $countForThisType : '' }}</span>
                                </button>
                            @endforeach
                        </div>
                        @else
                        <div class="mt-3 flex items-center space-x-2">
                            @foreach($definedReactionTypes as $type => $emoji)
                                @php
                                    $countForThisType = $comment->grouped_reaction_counts->get($type, 0);
                                @endphp
                                @if($countForThisType > 0)
                                <span class="p-1.5 rounded-full flex items-center space-x-1 text-xs bg-gray-100 text-gray-600" title="{{ ucfirst($type) }}">
                                    <span class="text-sm">{{ $emoji }}</span>
                                    <span class="font-medium">{{ $countForThisType }}</span>
                                </span>
                                @endif
                            @endforeach
                        </div>
                        @endauth
                    </div>
                    {{-- AKHIR BAGIAN REAKSI KOMENTAR --}}
                </div>
            @empty
                <p class="text-gray-400 italic text-center py-10">Belum ada komentar. Jadilah yang pertama!</p>
            @endforelse
            </div>

            {{-- Form untuk menambahkan komentar baru --}}
            @auth
                <form action="{{ route('forum.comment.store', $post->id) }}" method="POST" class="mt-10">
                    @csrf
                    <textarea name="content" rows="5" class="w-full border border-gray-300 rounded-2xl p-4 resize-none focus:outline-none focus:ring-4 focus:ring-indigo-500 transition duration-300 text-gray-900 placeholder-gray-400" placeholder="Tulis komentar..." required></textarea>
                    @error('content')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                    <button type="submit"
                            class="mt-5 w-full bg-indigo-600 text-white py-4 rounded-2xl shadow-lg hover:bg-indigo-700 focus:outline-none focus:ring-4 focus:ring-indigo-400 font-bold transition duration-300">
                        Kirim Komentar
                    </button>
                </form>
            @else
                <p class="text-center text-gray-600 mt-10">
                    Silakan <a href="{{ route('login') }}" class="text-indigo-600 underline hover:text-indigo-700 font-semibold">login</a> untuk menambahkan komentar.
                </p>
            @endauth
        </section>
    </div>

    @push('scripts')
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Komentar Reaction
        document.querySelectorAll('.reaction-button').forEach(button => {
            button.addEventListener('click', async function(e) {
                e.preventDefault();
                const commentId = this.dataset.commentId;
                const reactionType = this.dataset.reactionType;
                try {
                    const response = await fetch(`/comments/${commentId}/reactions`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({ reaction_type: reactionType })
                    });
                    const data = await response.json();
                    if (data.success) {
                        document.querySelectorAll(`.reaction-button[data-comment-id="${commentId}"]`).forEach(btn => {
                            if (btn.dataset.reactionType === reactionType && data.is_click) {
                                btn.classList.add('bg-indigo-100', 'text-indigo-700', 'ring-1', 'ring-indigo-300');
                                btn.classList.remove('bg-gray-100', 'text-gray-600', 'hover:bg-gray-200');
                            } else {
                                btn.classList.remove('bg-indigo-100', 'text-indigo-700', 'ring-1', 'ring-indigo-300');
                                btn.classList.add('bg-gray-100', 'text-gray-600', 'hover:bg-gray-200');
                            }
                            const count = data.reaction_counts[btn.dataset.reactionType] ?? 0;
                            btn.querySelector('.reaction-count').textContent = count > 0 ? count : '';
                        });
                    }
                } catch (error) {
                    alert('Terjadi kesalahan: ' + error.message);
                }
            });
        });

        // Bookmark
        const bookmarkButton = document.getElementById('bookmark-button');
        if (bookmarkButton) {
            bookmarkButton.addEventListener('click', async function(e) {
                e.preventDefault();
                const postId = this.dataset.postId;
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
                        if (data.isBookmarked) {
                            this.classList.remove('bg-gray-100', 'text-gray-600', 'hover:bg-gray-200');
                            this.classList.add('bg-yellow-100', 'text-yellow-800');
                            this.querySelector('.bookmark-text').textContent = 'Dibookmark';
                            Swal.fire({
                                title: 'Bookmark Saved!',
                                icon: 'success',
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 1500
                            });
                        } else {
                            this.classList.remove('bg-yellow-100', 'text-yellow-800');
                            this.classList.add('bg-gray-100', 'text-gray-600', 'hover:bg-gray-200');
                            this.querySelector('.bookmark-text').textContent = 'Bookmark';
                            Swal.fire({
                                title: 'Bookmark Removed',
                                icon: 'info',
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 1500
                            });
                        }
                    }
                } catch (error) {
                    Swal.fire({
                        title: 'Error!',
                        text: 'Terjadi kesalahan saat memproses bookmark',
                        icon: 'error',
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 1500
                    });
                }
            });
        }
    });
    </script>
    @endpush
</x-app-layout>