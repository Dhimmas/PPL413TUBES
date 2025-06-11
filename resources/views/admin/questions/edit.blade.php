<x-app-layout>
    <div class="max-w-4xl mx-auto p-6">
        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-3xl font-bold text-white">Edit Soal</h1>
                <p class="text-gray-400 mt-1">Quiz: {{ $question->quiz->title }}</p>
            </div>
            <div class="flex gap-3">
                <a href="{{ route('admin.quiz.edit', $question->quiz) }}" 
                   class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition duration-200">
                    <i class="fas fa-edit mr-2"></i>Edit Quiz
                </a>
                <a href="{{ route('admin.quiz.show', $question->quiz) }}" 
                   class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg transition duration-200">
                    <i class="fas fa-arrow-left mr-2"></i>Kembali
                </a>
            </div>
        </div>

        <!-- Question Edit Form -->
        <div class="bg-gray-800 rounded-lg p-6 text-white">
            <form action="{{ route('admin.questions.update', $question) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <!-- Question Type -->
                <div class="mb-6">
                    <label for="question_type" class="block mb-2 font-medium">Tipe Soal</label>
                    <select class="w-full p-3 rounded-lg bg-gray-700 text-white border border-gray-600 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 @error('question_type') border-red-500 @enderror" 
                            id="question_type" name="question_type" required>
                        <option value="multiple_choice" {{ old('question_type', $question->question_type) == 'multiple_choice' ? 'selected' : '' }}>Pilihan Ganda</option>
                        <option value="essay" {{ old('question_type', $question->question_type) == 'essay' ? 'selected' : '' }}>Essay</option>
                        <option value="file_based" {{ old('question_type', $question->question_type) == 'file_based' ? 'selected' : '' }}>Upload File</option>
                    </select>
                    @error('question_type')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Question Text -->
                <div class="mb-6">
                    <label for="question_text" class="block mb-2 font-medium">Teks Soal</label>
                    <textarea class="w-full p-3 rounded-lg bg-gray-700 text-white border border-gray-600 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 @error('question_text') border-red-500 @enderror" 
                              id="question_text" name="question_text" rows="4" required>{{ old('question_text', $question->question_text) }}</textarea>
                    @error('question_text')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Files Section -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <!-- Question File -->
                    <div>
                        <label for="question_file" class="block mb-2 font-medium">File Soal (opsional)</label>
                        <input type="file" 
                               class="w-full p-3 rounded-lg bg-gray-700 text-white border border-gray-600 focus:border-blue-500 @error('question_file') border-red-500 @enderror" 
                               id="question_file" name="question_file">
                        @if($question->question_file)
                            <div class="mt-2">
                                <a href="{{ asset('storage/'.$question->question_file) }}" target="_blank" 
                                   class="text-blue-400 hover:text-blue-300 text-sm">
                                    <i class="fas fa-file mr-1"></i>{{ basename($question->question_file) }}
                                </a>
                            </div>
                        @endif
                        @error('question_file')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Question Image -->
                    <div>
                        <label for="image" class="block mb-2 font-medium">Gambar Soal (opsional)</label>
                        <input type="file" 
                               class="w-full p-3 rounded-lg bg-gray-700 text-white border border-gray-600 focus:border-blue-500 @error('image') border-red-500 @enderror" 
                               id="image" name="image" accept="image/*">
                        @if($question->image)
                            <div class="mt-2">
                                <img src="{{ asset('storage/'.$question->image) }}" alt="Current Image" class="w-32 h-20 object-cover rounded">
                                <p class="text-sm text-gray-400 mt-1">Gambar saat ini</p>
                            </div>
                        @endif
                        @error('image')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                
                <!-- Time Limit -->
                <div class="mb-6">
                    <label for="time_limit_per_question" class="block mb-2 font-medium">Batas Waktu per Soal (detik)</label>
                    <input type="number" 
                           class="w-full p-3 rounded-lg bg-gray-700 text-white border border-gray-600 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 @error('time_limit_per_question') border-red-500 @enderror" 
                           id="time_limit_per_question" name="time_limit_per_question" 
                           value="{{ old('time_limit_per_question', $question->time_limit_per_question) }}" min="0">
                    @error('time_limit_per_question')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Multiple Choice Options -->
                <div id="multiple_choice_section" class="mb-6" style="display: {{ old('question_type', $question->question_type) == 'multiple_choice' ? 'block' : 'none' }}">
                    <h3 class="text-lg font-semibold mb-4">Pilihan Jawaban</h3>
                    @for($i = 0; $i < 5; $i++)
                        <div class="mb-3">
                            <label for="options_{{ $i }}" class="block mb-1 font-medium">Pilihan {{ chr(65 + $i) }}</label>
                            <div class="flex gap-3">
                                <input type="radio" id="correct_{{ $i }}" name="correct_option" value="{{ $i }}" 
                                       class="mt-3 text-blue-600 bg-gray-700 border-gray-600 focus:ring-blue-500"
                                       {{ old('correct_option', array_search($question->correct_answer, $question->options ?? [])) == $i ? 'checked' : '' }}>
                                <input type="text" id="options_{{ $i }}" name="options[{{ $i }}]" 
                                       class="flex-1 p-3 rounded-lg bg-gray-700 text-white border border-gray-600 focus:border-blue-500 focus:ring-2 focus:ring-blue-500"
                                       value="{{ old('options.'.$i, isset($question->options[$i]) ? $question->options[$i] : '') }}"
                                       placeholder="Masukkan pilihan {{ chr(65 + $i) }}">
                            </div>
                        </div>
                    @endfor
                </div>
                
                <!-- Essay/File Based Answer -->
                <div id="text_answer_section" class="mb-6" style="display: {{ old('question_type', $question->question_type) != 'multiple_choice' ? 'block' : 'none' }}">
                    <label for="correct_answer" class="block mb-2 font-medium">Jawaban/Panduan Penilaian</label>
                    <textarea class="w-full p-3 rounded-lg bg-gray-700 text-white border border-gray-600 focus:border-blue-500 focus:ring-2 focus:ring-blue-500" 
                              id="correct_answer" name="correct_answer" rows="3"
                              placeholder="Masukkan jawaban yang benar atau panduan untuk penilaian">{{ old('correct_answer', $question->correct_answer) }}</textarea>
                </div>
                
                <!-- Action Buttons -->
                <div class="flex justify-between items-center">
                    <a href="{{ route('admin.quiz.show', $question->quiz) }}" 
                       class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-3 rounded-lg transition duration-200">
                        <i class="fas fa-arrow-left mr-2"></i>Kembali
                    </a>
                    <button type="submit" 
                            class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-lg transition duration-200">
                        <i class="fas fa-save mr-2"></i>Perbarui Soal
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.getElementById('question_type').addEventListener('change', function() {
            const type = this.value;
            const multipleChoiceSection = document.getElementById('multiple_choice_section');
            const textAnswerSection = document.getElementById('text_answer_section');
            
            if (type === 'multiple_choice') {
                multipleChoiceSection.style.display = 'block';
                textAnswerSection.style.display = 'none';
                
                // Make radio buttons required
                document.querySelectorAll('input[name="correct_option"]').forEach(radio => {
                    radio.setAttribute('required', 'required');
                });
                document.querySelectorAll('input[name^="options"]').forEach(input => {
                    input.setAttribute('required', 'required');
                });
                document.getElementById('correct_answer').removeAttribute('required');
            } else {
                multipleChoiceSection.style.display = 'none';
                textAnswerSection.style.display = 'block';
                
                // Remove required from radio buttons
                document.querySelectorAll('input[name="correct_option"]').forEach(radio => {
                    radio.removeAttribute('required');
                });
                document.querySelectorAll('input[name^="options"]').forEach(input => {
                    input.removeAttribute('required');
                });
                document.getElementById('correct_answer').setAttribute('required', 'required');
            }
        });

        // Trigger change event on page load to set initial state
        document.getElementById('question_type').dispatchEvent(new Event('change'));
    </script>
</x-app-layout>