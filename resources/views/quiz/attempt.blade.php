<x-app-layout>
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-6">{{ $quiz->title }}</h1>

        <form action="{{ route('quiz.attempt.store', $quiz->id) }}" method="POST">
            @csrf

            @foreach($quiz->questions as $index => $question)
                <div class="mb-6 p-4 border rounded shadow-sm">
                    <p class="font-semibold mb-2">
                        {{ $loop->iteration }}. {{ $question->question_text }}
                    </p>

                    {{-- Menampilkan gambar soal jika ada --}}
                    @if ($question->image)
                        <img src="{{ asset('storage/' . $question->image) }}" alt="Question Image" class="mb-4 w-1/2">
                    @endif

                    {{-- Menampilkan file jika ada --}}
                    @if ($question->question_file)
                        <a href="{{ asset('storage/' . $question->question_file) }}" target="_blank" class="text-blue-600 underline mb-2 block">Lihat File Soal</a>
                    @endif

                    {{-- Jawaban --}}
                    @if($question->question_type === 'multiple_choice')
                        @foreach($question->options as $option)
                            <label class="block mb-2">
                                <input type="radio" name="answers[{{ $question->id }}]" value="{{ $option }}"
                                    {{ old("answers.{$question->id}") === $option ? 'checked' : '' }} required>
                                {{ $option }}
                            </label>
                        @endforeach
                    @else
                        <textarea name="answers[{{ $question->id }}]" class="w-full mt-2 p-2 border rounded" rows="3" required>{{ old("answers.{$question->id}") }}</textarea>
                    @endif
                </div>
            @endforeach

            <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-6 py-2 rounded">
                Kirim Jawaban
            </button>
        </form>
    </div>
</x-app-layout>
