<x-app-layout>
    <div class="max-w-4xl mx-auto p-6">
        <!-- Header with navigation -->
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-white">Edit Quiz: {{ $quiz->title }}</h1>
            <div class="flex gap-3">
                <a href="{{ route('admin.quiz.show', $quiz) }}" 
                   class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg transition duration-200">
                    <i class="fas fa-eye mr-2"></i>Lihat Detail
                </a>
            </div>
        </div>

        <!-- Quiz Edit Form -->
        <div class="bg-gray-800 rounded-lg p-6 text-white">
            <form action="{{ route('admin.quiz.update', $quiz) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Left Column -->
                    <div class="space-y-4">
                        <div>
                            <label for="title" class="block mb-2 font-medium">Judul Quiz</label>
                            <input type="text" 
                                   class="w-full p-3 rounded-lg bg-gray-700 text-white border border-gray-600 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 @error('title') border-red-500 @enderror" 
                                   id="title" name="title" value="{{ old('title', $quiz->title) }}" required>
                            @error('title')
                                <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="description" class="block mb-2 font-medium">Deskripsi</label>
                            <textarea class="w-full p-3 rounded-lg bg-gray-700 text-white border border-gray-600 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 @error('description') border-red-500 @enderror" 
                                      id="description" name="description" rows="4">{{ old('description', $quiz->description) }}</textarea>
                            @error('description')
                                <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="image" class="block mb-2 font-medium">Gambar Quiz</label>
                            <input type="file" 
                                   class="w-full p-3 rounded-lg bg-gray-700 text-white border border-gray-600 focus:border-blue-500 @error('image') border-red-500 @enderror" 
                                   id="image" name="image" accept="image/*">
                            @if($quiz->image)
                                <div class="mt-2">
                                    <img src="{{ asset('storage/'.$quiz->image) }}" alt="Current Image" class="w-32 h-20 object-cover rounded">
                                    <p class="text-sm text-gray-400 mt-1">Gambar saat ini</p>
                                </div>
                            @endif
                            @error('image')
                                <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Right Column -->
                    <div class="space-y-4">
                        <div>
                            <label for="time_limit_per_quiz" class="block mb-2 font-medium">Batas Waktu Quiz (menit)</label>
                            <input type="number" 
                                   class="w-full p-3 rounded-lg bg-gray-700 text-white border border-gray-600 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 @error('time_limit_per_quiz') border-red-500 @enderror" 
                                   id="time_limit_per_quiz" name="time_limit_per_quiz" 
                                   value="{{ old('time_limit_per_quiz', $quiz->time_limit_per_quiz) }}" min="0">
                            @error('time_limit_per_quiz')
                                <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
                
                <!-- Action Buttons -->
                <div class="flex justify-between items-center mt-8">
                    <a href="{{ route('admin.quiz.index') }}" 
                       class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-3 rounded-lg transition duration-200">
                        <i class="fas fa-arrow-left mr-2"></i>Kembali
                    </a>
                    <button type="submit" 
                            class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-lg transition duration-200">
                        <i class="fas fa-save mr-2"></i>Perbarui Quiz
                    </button>
                </div>
            </form>
        </div>

        <!-- Questions List -->
        @if($quiz->questions->count() > 0)
            <div class="mt-8 bg-gray-800 rounded-lg p-6">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-xl font-bold text-white">Daftar Soal ({{ $quiz->questions->count() }})</h2>
                    <a href="{{ route('admin.questions.create', $quiz) }}" 
                       class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm transition duration-200">
                        <i class="fas fa-plus mr-2"></i>Tambah Soal
                    </a>
                </div>
                
                <div class="space-y-3">
                    @foreach($quiz->questions as $question)
                        <div class="bg-gray-700 rounded-lg p-4 flex justify-between items-center">
                            <div class="flex-1">
                                <div class="flex items-center gap-3">
                                    <span class="bg-blue-600 text-white px-2 py-1 rounded text-sm font-medium">
                                        Soal {{ $loop->iteration }}
                                    </span>
                                    <span class="bg-gray-600 text-white px-2 py-1 rounded text-xs">
                                        {{ ucfirst(str_replace('_', ' ', $question->question_type)) }}
                                    </span>
                                </div>
                                <p class="text-white mt-2 truncate">{{ $question->question_text }}</p>
                            </div>
                            <div class="flex gap-2 ml-4">
                                <a href="{{ route('admin.questions.edit', $question) }}" 
                                   class="bg-yellow-600 hover:bg-yellow-700 text-white px-3 py-1 rounded text-sm transition duration-200">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.questions.destroy', $question) }}" method="POST" class="inline" 
                                      onsubmit="return confirm('Yakin ingin menghapus soal ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded text-sm transition duration-200">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</x-app-layout>