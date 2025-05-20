<x-app-layout>
<pre>
Quiz ID: {{ $quiz->id }}
Jumlah soal: {{ $quiz->questions->count() }}
</pre>
<div class="container mx-auto p-4">
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        {{-- Quiz Header --}}
        <div class="p-6 border-b">
            <div class="flex justify-between items-start">
                <div>
                    <h1 class="text-2xl font-bold">{{ $quiz->title }}</h1>
                    <p class="text-gray-600 mt-2">{{ $quiz->description }}</p>
                </div>
                <a href="{{ route('quiz.index') }}" class="text-blue-500 hover:text-blue-700">
                    ← Kembali
                </a>
            </div>
            
            @if($quiz->image)
                <img src="{{ asset('storage/'.$quiz->image) }}" alt="{{ $quiz->title }}" class="mt-4 max-h-64 w-full object-cover rounded">
            @endif
            
            <div class="mt-4 flex gap-4 text-sm">
                <span class="bg-gray-100 px-3 py-1 rounded-full">Kategori: {{ $quiz->category?->name ?? '-' }}</span>
                <span class="bg-gray-100 px-3 py-1 rounded-full">{{ $quiz->questions_count }} Soal</span>
            </div>
        </div>

        {{-- Questions Section --}}
        <div class="p-6">
            <h2 class="text-xl font-bold mb-4">Daftar Soal</h2>
            
            @if($quiz->questions->count() > 0)
                <div class="space-y-6">
                    @foreach($quiz->questions as $question)
                    <div class="border rounded-lg p-4">
                        <div class="flex justify-between items-start">
                            <h3 class="font-bold">Soal {{ $loop->iteration }}</h3>
                            <span class="bg-gray-100 px-2 py-1 text-xs rounded">
                                {{ ucfirst(str_replace('_', ' ', $question->question_type)) }}
                            </span>
                        </div>
                        
                        <div class="mt-2">
                            <p class="whitespace-pre-wrap">{{ $question->question_text }}</p>
                            
                            @if($question->image)
                                <img src="{{ asset('storage/'.$question->image) }}" alt="Question Image" class="mt-2 max-w-xs rounded">
                            @endif
                            
                            {{-- Answers --}}
                            <div class="mt-3">
                                @if($question->question_type === 'multiple_choice')
                                    <div class="space-y-2">
                                        @foreach($question->options as $index => $option)
                                            <div class="flex items-center gap-2">
                                                <div class="w-6 h-6 rounded-full border flex items-center justify-center 
                                                    {{ $option === $question->correct_answer ? 'bg-green-100 border-green-500' : 'bg-gray-100' }}">
                                                    {{ chr(65 + $index) }}
                                                </div>
                                                <span class="{{ $option === $question->correct_answer ? 'font-medium text-green-700' : '' }}">
                                                    {{ $option }}
                                                </span>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <div class="mt-2 p-3 bg-gray-50 rounded">
                                        <p class="font-medium">Jawaban benar:</p>
                                        <p class="whitespace-pre-wrap">{{ $question->correct_answer }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            @else
                <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded">
                    Quiz ini belum memiliki soal.
                </div>
            @endif
        </div>

        {{-- Action Buttons --}}  
            <div class="p-6 border-t flex justify-between">
            <div>
                @auth
                    @if(auth()->user()->is_admin)
                        <a href="{{ route('admin.questions.create', $quiz) }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded transition">
                            + Tambah Soal
                        </a>
                    @endif
                @endauth
            </div>      
            <div>
                <a href="{{ route('quiz.result', $quiz->id) }}" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded transition">
                    Lihat Hasil
                </a>
            </div>
        </div>
    </div>
</div>
</x-app-layout>