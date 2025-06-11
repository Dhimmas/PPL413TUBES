<x-app-layout>
    <div class="min-h-screen bg-gradient-to-br from-gray-900 via-purple-900 to-gray-900 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header with Actions -->
            <div class="bg-white/10 backdrop-blur-lg rounded-2xl p-6 shadow-xl border border-white/20 mb-8">
                <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4">
                    <div>
                        <h1 class="text-3xl lg:text-4xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-purple-400">
                            {{ $quiz->title }}
                        </h1>
                        <div class="flex items-center gap-4 mt-2">
                            <span class="text-white/70">
                                <i class="fas fa-question-circle mr-1"></i>
                                {{ $quiz->questions->count() }} soal
                            </span>
                            @if($quiz->time_limit_per_quiz)
                                <span class="text-white/70">
                                    <i class="fas fa-clock mr-1"></i>
                                    {{ $quiz->time_limit_per_quiz }} menit
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="flex flex-wrap gap-3">
                        <a href="{{ route('admin.quiz.edit', $quiz) }}" 
                           class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition duration-200 transform hover:scale-105">
                            <i class="fas fa-edit mr-2"></i>Edit Quiz
                        </a>
                        <a href="{{ route('admin.questions.create', $quiz) }}" 
                           class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg transition duration-200 transform hover:scale-105">
                            <i class="fas fa-plus mr-2"></i>Tambah Soal
                        </a>
                        <a href="{{ route('quiz.ranking', $quiz) }}" 
                           class="inline-flex items-center px-4 py-2 bg-yellow-600 hover:bg-yellow-700 text-white rounded-lg transition duration-200 transform hover:scale-105">
                            <i class="fas fa-trophy mr-2"></i>Lihat Ranking
                        </a>
                        <a href="{{ route('admin.quiz.index') }}" 
                           class="inline-flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white rounded-lg transition duration-200 transform hover:scale-105">
                            <i class="fas fa-arrow-left mr-2"></i>Kembali
                        </a>
                    </div>
                </div>
            </div>

            <!-- Quiz Information Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
                <!-- Quiz Details -->
                <div class="lg:col-span-2 bg-white/10 backdrop-blur-lg rounded-2xl p-6 shadow-xl border border-white/20">
                    <h2 class="text-xl font-bold text-white mb-4 flex items-center">
                        <i class="fas fa-info-circle text-blue-400 mr-2"></i>
                        Informasi Quiz
                    </h2>
                    @if($quiz->image)
                        <img src="{{ asset('storage/'.$quiz->image) }}" alt="{{ $quiz->title }}" 
                             class="w-full h-48 object-cover rounded-xl mb-4 shadow-lg">
                    @endif
                    <p class="text-white/80 leading-relaxed">
                        {{ $quiz->description ?: 'Tidak ada deskripsi tersedia untuk quiz ini.' }}
                    </p>
                </div>

                <!-- Quiz Stats -->
                <div class="bg-white/10 backdrop-blur-lg rounded-2xl p-6 shadow-xl border border-white/20">
                    <h2 class="text-xl font-bold text-white mb-4 flex items-center">
                        <i class="fas fa-chart-bar text-green-400 mr-2"></i>
                        Statistik
                    </h2>
                    <div class="space-y-4">
                        <div class="flex justify-between items-center p-3 bg-white/5 rounded-lg">
                            <span class="text-white/70">Kategori:</span>
                            <span class="text-white font-medium">{{ $quiz->category?->name ?? 'Tidak Berkategori' }}</span>
                        </div>
                        <div class="flex justify-between items-center p-3 bg-white/5 rounded-lg">
                            <span class="text-white/70">Jumlah Soal:</span>
                            <span class="text-white font-medium">{{ $quiz->questions->count() }}</span>
                        </div>
                        <div class="flex justify-between items-center p-3 bg-white/5 rounded-lg">
                            <span class="text-white/70">Batas Waktu:</span>
                            <span class="text-white font-medium">{{ $quiz->time_limit_per_quiz ? $quiz->time_limit_per_quiz . ' menit' : 'Tidak terbatas' }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Questions Section -->
            <div class="bg-white/10 backdrop-blur-lg rounded-2xl p-6 shadow-xl border border-white/20">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
                    <h2 class="text-xl font-bold text-white flex items-center">
                        <i class="fas fa-list text-purple-400 mr-2"></i>
                        Daftar Soal
                        @if($quiz->questions->count() > 0)
                            <span class="ml-2 px-3 py-1 bg-purple-500/30 text-purple-200 rounded-full text-sm">
                                {{ $quiz->questions->count() }} soal
                            </span>
                        @endif
                    </h2>
                    @if($quiz->questions->count() > 0)
                        <a href="{{ route('admin.questions.create', $quiz) }}" 
                           class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg transition duration-200 transform hover:scale-105">
                            <i class="fas fa-plus mr-2"></i>Tambah Soal Lagi
                        </a>
                    @endif
                </div>
                
                @if($quiz->questions->count() > 0)
                    <div class="space-y-4">
                        @foreach($quiz->questions as $question)
                            <div class="bg-white/5 backdrop-blur-sm rounded-xl p-6 hover:bg-white/10 transition-all duration-300 border border-white/10">
                                <div class="flex justify-between items-start">
                                    <div class="flex-1 pr-4">
                                        <div class="flex items-center gap-3 mb-3">
                                            <span class="bg-blue-600 text-white px-3 py-1 rounded-full text-sm font-medium">
                                                Soal {{ $loop->iteration }}
                                            </span>
                                            <span class="bg-gray-600 text-white px-2 py-1 rounded text-xs">
                                                {{ ucfirst(str_replace('_', ' ', $question->question_type)) }}
                                            </span>
                                            @if($question->time_limit_per_question)
                                                <span class="bg-yellow-600 text-white px-2 py-1 rounded text-xs">
                                                    <i class="fas fa-clock mr-1"></i>{{ $question->time_limit_per_question }}s
                                                </span>
                                            @endif
                                        </div>
                                        
                                        <p class="text-white font-medium mb-3 leading-relaxed">{{ $question->question_text }}</p>
                                        
                                        @if($question->image)
                                            <img src="{{ asset('storage/'.$question->image) }}" alt="Question Image" 
                                                 class="w-32 h-20 object-cover rounded-lg mb-3 shadow-md">
                                        @endif
                                        
                                        @if($question->question_file)
                                            <a href="{{ asset('storage/'.$question->question_file) }}" target="_blank" 
                                               class="inline-flex items-center text-blue-400 hover:text-blue-300 text-sm mb-3">
                                                <i class="fas fa-file mr-1"></i>{{ basename($question->question_file) }}
                                            </a>
                                        @endif
                                        
                                        <!-- Show options for multiple choice -->
                                        @if($question->question_type === 'multiple_choice' && $question->options)
                                            <div class="mt-3 grid grid-cols-1 md:grid-cols-2 gap-2">
                                                @foreach($question->options as $index => $option)
                                                    @if($option)
                                                        <div class="flex items-center gap-2 text-sm p-2 rounded-lg {{ $option === $question->correct_answer ? 'bg-green-500/20 border border-green-500/50' : 'bg-gray-600/20' }}">
                                                            <div class="w-6 h-6 rounded-full border flex items-center justify-center text-xs
                                                                {{ $option === $question->correct_answer ? 'bg-green-600 border-green-500 text-white' : 'bg-gray-600 border-gray-500 text-gray-300' }}">
                                                                {{ chr(65 + $index) }}
                                                            </div>
                                                            <span class="{{ $option === $question->correct_answer ? 'text-green-300 font-medium' : 'text-gray-300' }}">
                                                                {{ $option }}
                                                            </span>
                                                            @if($option === $question->correct_answer)
                                                                <i class="fas fa-check text-green-400 ml-auto"></i>
                                                            @endif
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                        @endif
                                        
                                        <!-- Show correct answer for other types -->
                                        @if($question->question_type !== 'multiple_choice' && $question->correct_answer)
                                            <div class="mt-3 p-3 bg-green-500/20 border border-green-500/50 rounded-lg">
                                                <p class="font-medium text-green-300 text-sm mb-1">
                                                    <i class="fas fa-check-circle mr-1"></i>Jawaban/Panduan:
                                                </p>
                                                <p class="text-green-200 text-sm">{{ $question->correct_answer }}</p>
                                            </div>
                                        @endif
                                    </div>
                                    
                                    <!-- Action Buttons -->
                                    <div class="flex flex-col gap-2">
                                        <a href="{{ route('admin.questions.edit', $question) }}" 
                                           class="inline-flex items-center justify-center px-3 py-2 bg-yellow-600 hover:bg-yellow-700 text-white rounded-lg text-sm transition duration-200 transform hover:scale-105">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.questions.destroy', $question) }}" method="POST" class="inline" 
                                              onsubmit="return confirm('Yakin ingin menghapus soal ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="w-full inline-flex items-center justify-center px-3 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg text-sm transition duration-200 transform hover:scale-105">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-16">
                        <div class="bg-white/5 rounded-full w-24 h-24 flex items-center justify-center mx-auto mb-6">
                            <i class="fas fa-question-circle text-4xl text-gray-400"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-white mb-2">Belum Ada Soal</h3>
                        <p class="text-white/70 text-lg mb-6">Quiz ini belum memiliki soal. Mari tambahkan soal pertama!</p>
                        <a href="{{ route('admin.questions.create', $quiz) }}" 
                           class="inline-flex items-center px-6 py-3 bg-green-600 hover:bg-green-700 text-white rounded-xl transition duration-200 transform hover:scale-105 shadow-lg">
                            <i class="fas fa-plus mr-2"></i>Tambah Soal Pertama
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>