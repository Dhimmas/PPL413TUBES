<x-app-layout>
    <div class="max-w-2xl mx-auto p-6 bg-white rounded-xl shadow mt-10">
        <h2 class="text-2xl font-bold mb-4">Edit Forum Post</h2>

        <form action="{{ route('forum.update', $post->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="block font-semibold mb-1">Title</label>
                <input type="text" name="title" class="w-full p-2 border rounded" value="{{ old('title', $post->title) }}" required>
            </div>

            <div class="mb-4">
                <label class="block font-semibold mb-1">Content</label>
                <textarea name="content" class="w-full p-2 border rounded" rows="5" required>{{ old('content', $post->content) }}</textarea>
            </div>

            <div class="flex justify-between">
                <a href="{{ route('forum.show', $post->id) }}" class="text-gray-600 hover:underline">Cancel</a>
                <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">Update</button>
            </div>
        </form>
    </div>
</x-app-layout>
