<x-app-layout>
    @push('styles')
    <style>
        .today-header {
            width: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            margin-top: 20px;
        }

        .today-header h2 {
            font-size: 25px;
            font-weight: bold;
            text-align: center;
            color: white;
            margin-bottom: 10px;
        }

        .task-count {
            font-size: 18px;
            color: #fff;
            margin: 0;
        }
    </style>
    @endpush

<div class="today-header">
    <h2><i class="fas fa-calendar-alt"></i> Upcoming Goals</h2>
</div>

<div class="today-goals-list">
    @foreach($goals as $goal)
        <div class="goal-row">
            <div class="goal-left">
                <div class="goal-info">
                    <p class="goal-title">{{ $goal->title }}</p>
                    <p class="goal-description">{{ $goal->description }}</p>
                    <p class="goal-deadline">Start Date: {{ $goal->start_date }}</p>
                </div>
            </div>
            <div class="goal-actions">
                <a href="{{ route('study-goals.edit', $goal->id) }}" class="icon-button"><i class="fas fa-pen"></i></a>
                <form action="{{ route('study-goals.destroy', $goal->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="icon-button delete"><i class="fas fa-trash"></i></button>
                </form>
            </div>
        </div>
    @endforeach
</div>
</x-app-layout>