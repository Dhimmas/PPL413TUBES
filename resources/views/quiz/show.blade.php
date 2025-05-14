<x-app-layout>
<h2>Quiz #{{ $id }}</h2>
<form method="POST" action="{{ route('quiz.result') }}">
    @csrf

    @foreach($questions as $index => $q)
        <div style="margin-bottom: 20px;">
            <p><strong>{{ $index + 1 }}. {{ $q->question }}</strong></p>
            @foreach($q->options as $optIndex => $option)
                <label>
                    <input type="radio" name="answers[{{ $index }}]" value="{{ $optIndex }}">
                    {{ $option }}
                </label><br>
            @endforeach
        </div>
    @endforeach

    <button type="submit">Submit</button>
</form>
</x-app-layout>