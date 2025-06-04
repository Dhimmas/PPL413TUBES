@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="text-2xl font-bold mb-4">Progress Tracker</h1>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Not Yet Started -->
        <div class="bg-white shadow p-4 rounded">
            <h2 class="text-lg font-semibold mb-2">Not Yet Started</h2>
            @foreach($notStarted->groupBy('date') as $date => $tasks)
                <div class="mb-4">
                    <p class="text-sm text-gray-500">{{ \Carbon\Carbon::parse($date)->format('d F Y') }}</p>
                    @foreach($tasks as $task)
                        <div class="bg-gray-100 rounded p-2 my-1">{{ $task->name }}</div>
                    @endforeach
                </div>
            @endforeach
        </div>

        <!-- On Progress -->
        <div class="bg-white shadow p-4 rounded">
            <h2 class="text-lg font-semibold mb-2">On Progress</h2>
            @foreach($onProgress->groupBy('date') as $date => $tasks)
                <div class="mb-4">
                    <p class="text-sm text-gray-500">{{ \Carbon\Carbon::parse($date)->format('d F Y') }}</p>
                    @foreach($tasks as $task)
                        <div class="bg-yellow-100 rounded p-2 my-1">{{ $task->name }}</div>
                    @endforeach
                </div>
            @endforeach
        </div>

        <div class="flex gap-6 p-6">
    <!-- Deadline List -->
    <div class="w-1/3 bg-white rounded shadow p-4">
        <h2 class="font-bold text-xl mb-4">Not Yet Started</h2>
        @foreach($grouped as $date => $tasks)
            <button 
                onclick="showTasks('{{ \Illuminate\Support\Str::slug($date) }}')" 
                class="w-full bg-gray-800 text-white p-2 my-2 rounded hover:bg-gray-700">
                Deadline: {{ $date }}
            </button>
        @endforeach
    </div>

    <!-- Task Display -->
    <div class="w-2/3 bg-white rounded shadow p-4">
        @foreach($grouped as $date => $tasks)
            <div id="tasks-{{ \Illuminate\Support\Str::slug($date) }}" class="task-section hidden">
                <h3 class="text-xl font-semibold mb-4">{{ $date }}</h3>
                @foreach($tasks as $task)
                    <div class="bg-gray-200 p-2 rounded my-2">
                        Task {{ $loop->iteration }}: {{ $task->name }}
                    </div>
                @endforeach
            </div>
        @endforeach
    </div>
</div>

<script>
    function showTasks(id) {
        document.querySelectorAll('.task-section').forEach(el => el.classList.add('hidden'));
        document.getElementById('tasks-' + id).classList.remove('hidden');
    }
</script>

        <!-- Finished -->
        <div class="bg-white shadow p-4 rounded">
            <h2 class="text-lg font-semibold mb-2">Finished</h2>
            @foreach($finished->groupBy('date') as $date => $tasks)
                <div class="mb-4">
                    <p class="text-sm text-gray-500">{{ \Carbon\Carbon::parse($date)->format('d F Y') }}</p>
                    @foreach($tasks as $task)
                        <div class="bg-green-100 rounded p-2 my-1">{{ $task->name }}</div>
                    @endforeach
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection