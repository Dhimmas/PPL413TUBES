<x-app-layout>
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">{{ $quiz->title }}</h1>
        <form action="{{ route('quiz.attempt.store', $quiz->id) }}" method="POST">
            @csrf
            @foreach($quiz->questions as $index => $question)
                <div class="mb-4">
                    <p class="font-semibold">{{ $loop->iteration }}. {{ $question->question_text }}</p>
                    
                    @if($question->question_type === 'multiple_choice')
                        @foreach($question->options as $option)
                            <label class="block">
                                <input type="radio" name="answers[{{ $question->id }}]" value="{{ $option }}">
                                {{ $option }}
                            </label>
                        @endforeach
                    @else
                        <textarea name="answers[{{ $question->id }}]" class="w-full mt-2 p-2 border rounded"></textarea>
                    @endif
                </div>
            @endforeach
            <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">Kirim Jawaban</button>
        </form>
    </div>
</x-app-layout>