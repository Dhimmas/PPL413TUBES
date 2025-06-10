<x-app-layout>
    <div class="max-w-3xl mx-auto mt-14 bg-white rounded-2xl shadow-lg p-10">
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
        
        {{-- TAMPILKAN KATEGORI DI SINI --}}
        @if($post->category)
            <div class="mb-4">
                <span class="inline-block bg-indigo-100 text-indigo-700 text-xs font-semibold px-3 py-1 rounded-full">
                    {{ $post->category->name }}
                </span>
            </div>
        @endif

        <p class="text-sm text-gray-500 mb-8">
            Ditulis oleh <span class="font-semibold">{{ $post->user->name }}</span> &middot; 
            <time datetime="{{ $post->created_at->toIso8601String() }}" class="italic">{{ $post->created_at->diffForHumans() }}</time>
        </p>

        @if ($post->image)
            <div class="mb-10 rounded-xl overflow-hidden shadow-md">
                <img src="{{ asset('storage/' . $post->image) }}" alt="Gambar Postingan" 
                     class="w-full max-h-[28rem] object-cover object-center transition-transform duration-500 hover:scale-105" />
            </div>
        @endif

        <article class="prose prose-indigo max-w-none mb-12 leading-relaxed text-gray-800">
            {!! nl2br(e($post->content)) !!}
        </article>

        @if (auth()->check() && auth()->id() === $post->user_id) {{-- Pastikan pengguna login sebelum cek id --}}
            <div class="flex gap-6 mb-16">
                <a href="{{ route('forum.edit', $post->id) }}"
                   class="inline-flex items-center gap-3 px-6 py-3 bg-yellow-500 text-white rounded-xl shadow-md hover:bg-yellow-600 focus:outline-none focus:ring-4 focus:ring-yellow-300 transition duration-300 font-semibold">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H12m0 0V2.5M12 5v2.5M12 5H9.5M12 5H14.5M12 5l2.5-2.5M12 5l-2.5 2.5M12 17.5v2.5M12 17.5V15M12 17.5H9.5M12 17.5h2.5m-4.5 0l2.5 2.5M12 17.5l-2.5-2.5M5 12H2.5M5 12H7.5M5 12v2.5M5 12V9.5m0 4.5l-2.5 2.5M5 12l2.5-2.5M19 12H16.5M19 12H21.5M19 12v2.5M19 12V9.5m0 4.5l2.5 2.5M19 12l-2.5-2.5" />
                    </svg>
                    Edit
                </a>

                <form action="{{ route('forum.destroy', $post->id) }}" method="POST"
                      onsubmit="return confirm('Yakin ingin menghapus postingan ini?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            class="inline-flex items-center gap-3 px-6 py-3 bg-red-600 text-white rounded-xl shadow-md hover:bg-red-700 focus:outline-none focus:ring-4 focus:ring-red-300 transition duration-300 font-semibold">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                        Hapus
                    </button>
                </form>
            </div>
        @endif

        <section class="mt-20">
            <h3 class="text-2xl font-semibold mb-8 text-gray-900 border-b-2 border-indigo-500 pb-2">Komentar</h3>

            @forelse($post->comments as $comment) {{-- Asumsi relasi 'comments' sudah di-load di controller --}}
                <div class="bg-gray-50 p-6 rounded-xl mb-6 shadow border border-gray-200 transition hover:shadow-lg">
                    <p class="text-gray-700 text-base leading-relaxed whitespace-pre-line">{{ $comment->content }}</p>
                    <p class="text-xs text-gray-500 mt-3">
                        oleh <strong>{{ $comment->user->name }}</strong> &middot; <time datetime="{{ $comment->created_at->toIso8601String() }}">{{ $comment->created_at->diffForHumans() }}</time>
                    </p>
                </div>
            @empty
                <p class="text-gray-400 italic text-center py-10">Belum ada komentar. Jadilah yang pertama!</p>
            @endforelse

            @auth
                <form action="{{ route('forum.comment.store', $post->id) }}" method="POST" class="mt-10">
                    @csrf
                    <textarea name="content" rows="5" class="w-full border border-gray-300 rounded-2xl p-4 resize-none focus:outline-none focus:ring-4 focus:ring-indigo-500 transition duration-300 text-gray-900 placeholder-gray-400" placeholder="Tulis komentar..." required></textarea>
                    @error('content') {{-- Menambahkan error handling untuk komentar --}}
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
</x-app-layout>