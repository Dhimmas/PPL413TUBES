<x-app-layout>
    <div class="container mx-auto">
        <h1 class="text-2xl font-bold mb-4">Kategori Quiz</h1>

        <a href="{{ route('admin.categories.create') }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">+ Tambah Kategori</a>

        <table class="mt-4 w-full bg-gray-800 text-white rounded">
            <thead>
                <tr>
                    <th class="p-2 text-left">Nama</th>
                    <th class="p-2">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($categories as $category)
                    <tr class="border-t border-gray-700">
                        <td class="p-2">{{ $category->name }}</td>
                        <td class="p-2 flex gap-2 justify-center">
                            <a href="{{ route('admin.categories.edit', $category) }}" class="bg-yellow-400 px-3 py-1 rounded text-sm">Edit</a>
                            <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" onsubmit="return confirm('Yakin?')">
                                @csrf
                                @method('DELETE')
                                <button class="bg-red-500 text-white px-3 py-1 rounded text-sm">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>