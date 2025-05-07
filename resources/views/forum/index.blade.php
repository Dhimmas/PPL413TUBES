<x-app-layout>
  <div class="max-w-4xl mx-auto mt-12 px-4">
    <!-- Forum Header -->
    <div class="flex justify-between items-center mb-8">
      <h1 class="text-3xl font-bold text-white">💬 Forum Diskusi</h1>
      <a href="{{ route('forum.create') }}"
         class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-full text-sm shadow-lg hover:shadow-xl transition duration-300 transform hover:-translate-y-1 hover:scale-105">
        + Buat Diskusi Baru
      </a>
    </div>

    <!-- Forum Posts -->
    @forelse($forumPosts as $post)
      <div class="bg-white/10 backdrop-blur-xl rounded-2xl p-6 mb-5 transition transform duration-300 hover:scale-[1.02] hover:bg-white/20 shadow-md hover:shadow-xl">
        <a href="{{ route('forum.show', $post->id) }}" class="block">
          <div class="flex justify-between items-center mb-2">
            <h2 class="text-xl font-semibold text-white truncate">{{ $post->title }}</h2>
            @if($post->category)
              <span class="text-xs bg-blue-500/80 text-white px-3 py-1 rounded-full">
                {{ $post->category->name }}
              </span>
            @endif
          </div>
          <p class="text-sm text-white/70 mb-1">
            oleh <span class="font-medium">{{ $post->user->name }}</span> • {{ $post->created_at->diffForHumans() }}
          </p>
          <p class="text-white/60 text-sm line-clamp-2">
            {{ Str::limit(strip_tags($post->content), 100) }}
          </p>
        </a>
      </div>
    @empty
      <div class="text-center py-10 bg-white/5 rounded-xl">
        <p class="text-white/70 text-lg">Belum ada diskusi.</p>
        <p class="text-white/50">Yuk mulai diskusi pertamamu dan berbagi wawasan!</p>
        <a href="{{ route('forum.create') }}"
           class="inline-block mt-4 bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded-full transition hover:scale-105 duration-300 shadow-lg">
          Mulai Diskusi
        </a>
      </div>
    @endforelse

    <!-- Pagination -->
    <div class="mt-8 text-white">
      {{ $forumPosts->links() }}
    </div>
  </div>

  @push('styles')
    <style>
      /* Optional: line clamp for preview content */
      .line-clamp-2 {
        overflow: hidden;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
      }
    </style>
  @endpush
</x-app-layout>
