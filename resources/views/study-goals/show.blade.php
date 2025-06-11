<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Goal Detail</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
</head>
<body>
    <div class="container">
        <div class="goal-detail">
            <h2>{{ $goal->title }}</h2>
            <p><strong>Description:</strong> {{ $goal->description }}</p>
            <p><strong>Reminder:</strong> {{ $goal->reminder }}</p>
            <p><strong>Start Date:</strong> {{ $goal->start_date }}</p>
            <p><strong>End Date:</strong> {{ $goal->end_date }}</p>
            <p><strong>Status:</strong> {{ $goal->status }}</p>

            <!-- Button to mark goal as "Completed" -->
            @if ($goal->status != 'Completed')
                <form action="{{ route('study-goals.complete', $goal->id) }}" method="POST">
                    @csrf
                    @method('PATCH')  <!-- Use PATCH to indicate updating an existing record -->
                    <button type="submit">Mark as Done</button>
                </form>
            @else
                <p>This goal is already marked as completed.</p>
            @endif
        </div>
    </div>
</body>
</html>