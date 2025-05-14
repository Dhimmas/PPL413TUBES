{{--
<x-app-layout>
    <div class="min-h-screen bg-gray-900 text-white py-10 px-6">
    <div class="max-w-5xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold">Quiz</h1>
            <div class="flex items-center space-x-4">
                <select class="bg-gray-800 text-white px-3 py-2 rounded">
                    <option>All Categories</option>
                    <option>Linux</option>
                    <option>Kimia</option>
                    <option>HTML</option>
                </select>
                <input type="text" placeholder="Search Quiz" class="px-4 py-2 rounded bg-gray-800 text-white focus:outline-none focus:ring w-64" />
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @foreach($quizzes as $quiz)
                <div class="bg-gray-800 rounded-lg p-4 flex justify-between items-center shadow hover:shadow-lg transition">
                    <div>
                        <h2 class="text-xl font-semibold mb-1">{{ $quiz->title }}</h2>
                        <p class="text-gray-300 text-sm">{{ $quiz->description }}</p>
                        <a href="#" class="mt-2 inline-block bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded text-sm">Learn</a>
                    </div>
                    <div class="ml-4">
                        <img src="{{ $quiz->image }}" alt="{{ $quiz->title }}" class="w-20 h-20 object-cover rounded">
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
</x-app-layout>
--}}

<x-app-layout>
<div class="container mx-auto">
    <h1 class="text-2xl font-bold mb-4">Daftar Quiz</h1>

    {{-- Tombol Tambah hanya untuk Admin --}}
    @auth
        @if(auth()->user()->is_admin)
            <a href="{{ route('admin.quiz.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded mb-4 inline-block">
                Tambah Quiz
            </a>
        @endif
    @endauth

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        @foreach($quizzes as $quiz)
        <div class="bg-white rounded shadow p-4">
            <h2 class="text-xl font-semibold">{{ $quiz->title }}</h2>
            <p class="text-gray-600">{{ $quiz->description }}</p>

            <p class="text-sm text-gray-400 mt-2">Kategori: {{ $quiz->category?->name ?? 'Tidak ada kategori' }}</p>

            {{-- Tombol hanya untuk Admin --}}
            @auth
                @if(auth()->user()->is_admin)
                    <div class="mt-3 flex gap-2">
                        <a href="{{ route('admin.quiz.edit', $quiz->id) }}" class="text-blue-600">Edit</a>
                        <form action="{{ route('admin.quiz.destroy', $quiz->id) }}" method="POST" onsubmit="return confirm('Yakin ingin hapus?')">
                            @csrf
                            @method('DELETE')
                            <button class="text-red-600">Hapus</button>
                        </form>
                    </div>
                @endif
            @endauth
        </div>
        @endforeach
    </div>
</div>
</x-app-layout>