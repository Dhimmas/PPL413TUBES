<x-app-layout>
<div class="max-w-2xl mx-auto bg-gray-800 p-6 rounded text-white">
    <h1 class="text-2xl font-bold mb-4">Buat Quiz</h1>

    <form method="POST" action="{{ route('admin.quiz.store') }}">
        @csrf

        <div class="mb-4">
            <label class="block mb-1">Judul Quiz</label>
            <input type="text" name="title" class="w-full p-2 rounded text-black" required>
        </div>

        <div class="mb-4">
            <label class="block mb-1">Deskripsi</label>
            <textarea name="description" class="w-full p-2 rounded text-black"></textarea>
        </div>

        <div class="mb-4">
            <label class="block mb-1">Gambar (URL)</label>
            <input type="url" name="image" class="w-full p-2 rounded text-black">
        </div>

        <div class="mb-4">
            <label class="block mb-1">Kategori (Bisa buat baru)</label>
            <div class="flex gap-2">
                <input type="text" name="new_category" placeholder="Nama Kategori Baru" 
                       class="flex-1 p-2 rounded text-black">
                <span class="self-center">ATAU</span>
                <select name="category_id" class="flex-1 p-2 rounded text-black">
                    <option value="">  Pilih Kategori </option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        
        {{-- Tombol submit --}}
        <button type="submit" class="bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded">
            Simpan Quiz
        </button>
    </form>
</div>
</x-app-layout>