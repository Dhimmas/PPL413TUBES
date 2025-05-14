<x-app-layout>
    <div class="container mx-auto">
        <h1 class="text-2xl font-bold mb-4">Edit Kategori</h1>

        <form action="{{ route('admin.categories.update', $category) }}" method="POST" class="bg-gray-800 p-4 rounded text-white">
            @csrf
            @method('PUT')
            <label class="block mb-2">Nama Kategori</label>
            <input type="text" name="name" value="{{ $category->name }}" class="w-full p-2 rounded bg-gray-700 text-white" required>
            <button class="mt-4 bg-yellow-600 px-4 py-2 rounded text-white">Update</button>
        </form>
    </div>
</x-app-layout>