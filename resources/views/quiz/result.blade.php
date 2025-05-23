<x-app-layout>
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">Hasil Quiz: {{ $result->quiz->title }}</h1>
        <p class="mb-2">Skor kamu: <strong>{{ $result->score }} / {{ $result->answers->count() }}</strong></p>
        
        <div class="mt-4">
            @foreach($result->answers as $answer)
                <div class="mb-4 p-4 border rounded">
                    <p class="font-semibold">
                        {{ $loop->iteration }}. {{ $answer->question->question_text }}
                    </p>
                    <p>Jawaban Kamu: {{ $answer->user_answer }}</p>
                    <p>Jawaban Benar: {{ $answer->question->correct_answer }}</p>
                    <p>Status: 
                        @if($answer->is_correct)
                            <span class="text-green-600 font-semibold">Benar</span>
                        @else
                            <span class="text-red-600 font-semibold">Salah</span>
                        @endif
                    </p>
                </div>
            @endforeach
        </div>

        <a href="{{ route('dashboard') }}" class="mt-6 inline-block bg-blue-500 text-white px-4 py-2 rounded">Kembali ke Dashboard</a>
    </div>
</x-app-layout>