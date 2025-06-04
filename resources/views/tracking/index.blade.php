@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Progress Tracker</h1>

    <!-- Navigasi Kategori -->
    <div class="mb-6">
        <ul class="flex flex-wrap gap-4">
            <li>
                <a href="{{ route('progress.byStatus', 'not_started') }}"
                   class="px-4 py-2 bg-gray-200 hover:bg-gray-300 rounded text-gray-800 font-semibold">
                    Not Yet Started
                </a>
            </li>
            <li>
                <a href="{{ route('progress.byStatus', 'on_progress') }}"
                   class="px-4 py-2 bg-yellow-200 hover:bg-yellow-300 rounded text-yellow-900 font-semibold">
                    On Progress
                </a>
            </li>
            <li>
                <a href="{{ route('progress.byStatus', 'finished') }}"
                   class="px-4 py-2 bg-green-200 hover:bg-green-300 rounded text-green-900 font-semibold">
                    Finished
                </a>
            </li>
        </ul>
    </div>

    <!-- Grid Progress Section -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <!-- Not Yet Started -->
        <div class="bg-white rounded shadow p-4">
            <h2 class="text-xl font-bold text-gray-800 mb-4">Not Yet Started</h2>
            @forelse ($notStarted->groupBy('date') as $date => $tasks)
                <div class="mb-4">
                    <p class="text-sm text-gray-500">{{ \Carbon\Carbon::parse($date)->format('d F Y') }}</p>
                    @foreach($tasks as $task)
                        <div class="bg-gray-100 p-2 rounded mt-1">{{ $task->name }}</div>
                    @endforeach
                </div>
            @empty
                <p class="text-gray-400">No tasks yet.</p>
            @endforelse
        </div>

        <!-- On Progress -->
        <div class="bg-white rounded shadow p-4">
            <h2 class="text-xl font-bold text-gray-800 mb-4">On Progress</h2>
            @forelse ($onProgress->groupBy('date') as $date => $tasks)
                <div class="mb-4">
                    <p class="text-sm text-gray-500">{{ \Carbon\Carbon::parse($date)->format('d F Y') }}</p>
                    @foreach($tasks as $task)
                        <div class="bg-yellow-100 p-2 rounded mt-1">{{ $task->name }}</div>
                    @endforeach
                </div>
            @empty
                <p class="text-gray-400">No tasks in progress.</p>
            @endforelse
        </div>

        <!-- Finished -->
        <div class="bg-white rounded shadow p-4">
            <h2 class="text-xl font-bold text-gray-800 mb-4">Finished</h2>
            @forelse ($finished->groupBy('date') as $date => $tasks)
                <div class="mb-4">
                    <p class="text-sm text-gray-500">{{ \Carbon\Carbon::parse($date)->format('d F Y') }}</p>
                    @foreach($tasks as $task)
                        <div class="bg-green-100 p-2 rounded mt-1">{{ $task->name }}</div>
                    @endforeach
                </div>
            @empty
                <p class="text-gray-400">No tasks finished yet.</p>
            @endforelse
        </div>
    </div>

    <!-- Deadline Task Section -->
    <div class="flex flex-col md:flex-row gap-6">
        <!-- Sidebar Deadline Dates -->
        <div class="md:w-1/3 bg-white p-4 rounded shadow">
            <h2 class="text-lg font-bold mb-4 text-gray-800">Not Yet Started Deadlines</h2>
            @forelse($grouped as $date => $tasks)
                <button onclick="showTasks('{{ \Illuminate\Support\Str::slug($date) }}')"
                        class="w-full text-left bg-gray-800 text-white p-2 rounded mb-2 hover:bg-gray-700">
                    {{ $date }}
                </button>
            @empty
                <p class="text-gray-400">No deadlines.</p>
            @endforelse
        </div>

        <!-- Task Detail by Deadline -->
        <div class="md:w-2/3 bg-white p-4 rounded shadow">
            @foreach($grouped as $date => $tasks)
                <div id="tasks-{{ \Illuminate\Support\Str::slug($date) }}" class="task-section hidden">
                    <h3 class="text-xl font-semibold mb-4 text-gray-800">{{ $date }}</h3>
                    @foreach($tasks as $task)
                        <div class="bg-gray-200 p-2 rounded mb-2">
                            Task {{ $loop->iteration }}: {{ $task->name }}
                        </div>
                    @endforeach
                </div>
            @endforeach
        </div>
    </div>
</div>

<script>
    function showTasks(id) {
        document.querySelectorAll('.task-section').forEach(el => el.classList.add('hidden'));
        document.getElementById('tasks-' + id).classList.remove('hidden');
    }
</script>
@endsection
