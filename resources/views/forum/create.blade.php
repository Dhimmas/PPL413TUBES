<x-app-layout>
    <div class="max-w-2xl mx-auto mt-10 bg-white rounded-lg shadow p-6">
        <h2 class="text-xl font-semibold mb-4">Buat Diskusi Baru</h2>
        <form action="{{ route('forum.store') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label class="block font-semibold mb-1">Judul</label>
                <input type="text" name="title" class="w-full border rounded p-2" required>
            </div>
            <div class="mb-4">
                <label class="block font-semibold mb-1">Konten</label>
                <textarea name="content" rows="6" class="w-full border rounded p-2" required></textarea>
            </div>
            <button class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">Posting</button>
        </form>
    </div>
</x-app-layout>
