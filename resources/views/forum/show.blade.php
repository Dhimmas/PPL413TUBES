<x-app-layout>
    <div class="max-w-3xl mx-auto mt-14 bg-white rounded-2xl shadow-lg p-10">
        <!-- Tombol Kembali -->
        <div class="mb-8">
            <a href="{{ route('forum.index') }}"
               class="inline-flex items-center gap-2 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold px-6 py-3 rounded-lg shadow-sm transition duration-300">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                </svg>
                Kembali ke Forum
            </a>
        </div>

        <!-- Post Header -->
        <h1 class="text-4xl font-extrabold mb-4 text-gray-900 tracking-tight">{{ $post->title }}</h1>
        <p class="text-sm text-gray-500 mb-8">
            Ditulis oleh <span class="font-semibold">{{ $post->user->name }}</span> &middot; 
            <time datetime="{{ $post->created_at->toIso8601String() }}" class="italic">{{ $post->created_at->diffForHumans() }}</time>
        </p>

        <!-- Post Image -->
        @if ($post->image)
            <div class="mb-10 rounded-xl overflow-hidden shadow-md">
                <img src="{{ asset('storage/' . $post->image) }}" alt="Gambar Postingan" 
                     class="w-full max-h-[28rem] object-cover object-center transition-transform duration-500 hover:scale-105" />
            </div>
        @endif

        <!-- Post Content -->
        <article class="prose prose-indigo max-w-none mb-12 leading-relaxed text-gray-800">
            {!! nl2br(e($post->content)) !!}
        </article>

        <!-- Post Actions (Edit/Delete) -->
        @if (auth()->id() === $post->user_id)
            <div class="flex gap-6 mb-16">
                <a href="{{ route('forum.edit', $post->id) }}"
                   class="inline-flex items-center gap-3 px-6 py-3 bg-yellow-500 text-white rounded-xl shadow-md hover:bg-yellow-600 focus:outline-none focus:ring-4 focus:ring-yellow-300 transition duration-300 font-semibold">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M11 5h7M6 12h7m-7 7h7" />
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
                          <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                        Hapus
                    </button>
                </form>
            </div>
        @endif

        <!-- Komentar -->
        <section class="mt-20">
            <h3 class="text-2xl font-semibold mb-8 text-gray-900 border-b-2 border-indigo-500 pb-2">Komentar</h3>

            <!-- List Komentar -->
            @forelse($post->comments as $comment)
                <div class="bg-gray-50 p-6 rounded-xl mb-6 shadow border border-gray-200 transition hover:shadow-lg">
                    <p class="text-gray-700 text-base leading-relaxed whitespace-pre-line">{{ $comment->content }}</p>
                    <p class="text-xs text-gray-500 mt-3">
                        oleh <strong>{{ $comment->user->name }}</strong> &middot; <time datetime="{{ $comment->created_at->toIso8601String() }}">{{ $comment->created_at->diffForHumans() }}</time>
                    </p>
                </div>
            @empty
                <p class="text-gray-400 italic text-center py-10">Belum ada komentar. Jadilah yang pertama!</p>
            @endforelse

            <!-- Form Tambah Komentar -->
            @auth
                <form action="{{ route('forum.comment.store', $post->id) }}" method="POST" class="mt-10">
                    @csrf
                    <textarea name="content" rows="5" class="w-full border border-gray-300 rounded-2xl p-4 resize-none focus:outline-none focus:ring-4 focus:ring-indigo-500 transition duration-300 text-gray-900 placeholder-gray-400" placeholder="Tulis komentar..." required></textarea>
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
