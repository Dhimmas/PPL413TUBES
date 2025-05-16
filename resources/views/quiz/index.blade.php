<x-app-layout>
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-6">Daftar Quiz</h1>

    {{-- Success Message --}}
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    {{-- Admin Controls --}}
    @auth
        @if(auth()->user()->is_admin)
            <div class="flex gap-4 mb-6">
                <a href="{{ route('admin.quiz.create') }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded transition">
                    + Tambah Quiz
                </a>
            </div>
        @endif
    @endauth

    {{-- Quiz List --}}
    @if($quizzes->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($quizzes as $quiz)
            <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition">
                {{-- Quiz Image --}}
                @if($quiz->image)
                    <img src="{{ asset('storage/'.$quiz->image) }}" alt="{{ $quiz->title }}" class="w-full h-48 object-cover">
                @endif

                <div class="p-4">
                    <h2 class="text-xl font-bold mb-2">{{ $quiz->title }}</h2>
                    <p class="text-gray-600 mb-3 line-clamp-2">{{ $quiz->description }}</p>
                    
                    <div class="flex justify-between items-center text-sm text-gray-500 mb-4">
                        <span>Kategori: {{ $quiz->category?->name ?? '-' }}</span>
                        <span>{{ $quiz->questions_count }} Soal</span>
                    </div>

                    {{-- Action Buttons --}}
                    <div class="flex flex-col gap-2">
                        <a href="{{ route('quiz.show', $quiz->id) }}" class="bg-green-500 hover:bg-green-600 text-white text-center py-2 rounded transition">
                            Lihat Detail
                        </a>
                        
                        @auth
                            @if(auth()->user()->is_admin)
                                <div class="flex gap-2">
                                    <a href="{{ route('admin.quiz.edit', $quiz->id) }}" class="flex-1 bg-blue-500 hover:bg-blue-600 text-white text-center py-2 rounded transition">
                                        Edit
                                    </a>
                                    <form action="{{ route('admin.quiz.destroy', $quiz->id) }}" method="POST" class="flex-1">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" onclick="return confirm('Yakin ingin menghapus quiz ini?')" class="w-full bg-red-500 hover:bg-red-600 text-white py-2 rounded transition">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            @endif
                        @endauth
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    @else
        <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded">
            Belum ada quiz yang tersedia.
        </div>
    @endif
</div>
</x-app-layout>