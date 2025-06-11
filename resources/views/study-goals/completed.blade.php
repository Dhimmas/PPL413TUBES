<x-app-layout>
    @push('styles')
    <style>
        .completed-header {
            width: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            margin-top: 20px;
        }

        .completed-header h2 {
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

<div class="completed-header">
    <h2><i class="fas fa-check-circle"></i> Completed Goals</h2>
    <p class="task-count">Total: {{ $goals->count() }} goal{{ $goals->count() > 1 ? 's' : '' }}</p>
</div>

<div class="completed-goals-list">
    @forelse($goals as $goal)
        <div class="goal-row">
            <div class="goal-left">
                <div class="goal-info">
                    <p class="goal-title">{{ $goal->title }}</p>
                    <p class="goal-description">{{ $goal->description }}</p>
                    <p class="goal-deadline">Deadline: {{ \Carbon\Carbon::parse($goal->end_date)->format('d M Y') }}</p>
                </div>
            </div>
            <div class="goal-actions">
                <form action="{{ route('study-goals.destroy', $goal->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="icon-button delete"><i class="fas fa-trash"></i></button>
                </form>
            </div>
        </div>
    @empty
        <p style="color: white;">Tidak ada completed goals.</p>
    @endforelse
</div>
</x-app-layout>
