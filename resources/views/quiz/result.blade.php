<x-app-layout>
<h2>Your Summary</h2>
<p>Grade: <strong>{{ $grade }}</strong></p>

@foreach($results as $res)
    <div style="margin-bottom: 10px; padding: 10px; background-color: {{ $res['isCorrect'] ? '#c8f7c5' : '#f7c5c5' }}">
        <p>Soal {{ $res['no'] }}:
            {{ $res['isCorrect'] ? 'Correct' : 'Incorrect' }}<br>
            Jawaban Kamu: {{ $res['user'] }} <br>
            Jawaban Benar: {{ $res['correct'] }}
        </p>
    </div>
@endforeach

<a href="/quiz">Back to Quiz List</a>
</x-app-layout>