@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4 text-capitalize">{{ str_replace('_', ' ', $status) }}</h2>

    @if($status === 'on_progress')
        <div class="row">
            @foreach ($tasks as $task)
                <div class="col-md-6 mb-3">
                    <div class="p-3 rounded bg-dark text-white">
                        <strong>{{ $task['title'] }}</strong><br>
                        {{ $task['progress'] }}% Complete
                    </div>
                </div>
            @endforeach
        </div>
    @elseif($status === 'not_started')
        @php
            $grouped = $tasks->groupBy('deadline');
        @endphp

        @foreach ($grouped as $date => $taskGroup)
            <div class="mb-3">
                <div class="bg-secondary text-white p-2 mb-2">{{ \Carbon\Carbon::parse($date)->format('d F Y') }}</div>
                @foreach ($taskGroup as $task)
                    <div class="bg-light p-2 rounded mb-1">{{ $task['title'] }}</div>
                @endforeach
            </div>
        @endforeach
    @endif
</div>
@endsection
