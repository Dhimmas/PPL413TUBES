<x-app-layout>
    <div class="max-w-3xl mx-auto mt-10 bg-white rounded-lg shadow p-6">
        <h1 class="text-2xl font-bold mb-2">{{ $post->title }}</h1>
        <p class="text-gray-600 mb-4">
            Ditulis oleh {{ $post->user->name }} • {{ $post->created_at->diffForHumans() }}
        </p>

        <div class="prose mb-6">
            {{ $post->content }}
        </div>

        @if (auth()->id() === $post->user_id)
            <div class="flex gap-2">
                <a href="{{ route('forum.edit', $post->id) }}"
                   class="px-4 py-2 bg-yellow-500 text-white rounded hover:bg-yellow-600 transition">
                    ✏️ Edit
                </a>

                <form action="{{ route('forum.destroy', $post->id) }}" method="POST"
                      onsubmit="return confirm('Yakin ingin menghapus postingan ini?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 transition">
                        🗑️ Delete
                    </button>
                </form>
            </div>
        @endif
    </div>
</x-app-layout>
