<!-- resources/views/tasks/index.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Progress Tracker</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .status {
            padding: 0.5rem 1rem;
            border-radius: 9999px;
            font-weight: bold;
            font-size: 0.875rem;
        }
        .status-not-started {
            background-color: #f3f4f6;
            color: #6b7280;
        }
        .status-in-progress {
            background-color: #fbbf24;
            color: white;
        }
        .status-finished {
            background-color: #10b981;
            color: white;
        }
    </style>
</head>
<body class="bg-gradient-to-br from-indigo-100 via-purple-100 to-pink-100 min-h-screen">

    <div class="container max-w-4xl mx-auto p-6">
        <!-- Header -->
        <div class="text-center mb-10">
            <h1 class="text-5xl font-extrabold text-gray-800 mb-2">📈 Progress Tracker</h1>
            <p class="text-lg text-gray-600">Track your tasks in a colorful and simple way</p>
        </div>

        <!-- Create Task Form -->
        <form action="/tasks" method="POST" class="bg-white rounded-xl p-6 shadow-lg mb-10 space-y-6">
            @csrf
            <div>
                <label for="task_name" class="block text-lg font-semibold text-gray-700 mb-2">Task Name</label>
                <input type="text" name="task_name" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-400 focus:outline-none" required>
            </div>
            <div>
                <label for="deadline" class="block text-lg font-semibold text-gray-700 mb-2">Deadline</label>
                <input type="date" name="deadline" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-400 focus:outline-none" required>
            </div>
            <div class="text-right">
                <button type="submit" class="bg-indigo-500 text-white px-6 py-2 rounded-lg hover:bg-indigo-600 transition-all shadow-md">Add Task</button>
            </div>
        </form>

        <!-- Task List -->
        <h2 class="text-3xl font-bold text-gray-800 mb-6">🗂 Task List</h2>
        <div class="space-y-4">
            @forelse ($tasks as $task)
                <div class="bg-white p-5 rounded-xl shadow-md flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                    <div class="flex-1">
                        <h3 class="text-xl font-semibold text-gray-800">{{ $task->task_name }}</h3>
                        <p class="text-sm text-gray-500">📅 Deadline: {{ $task->deadline }}</p>
                    </div>
                    <div>
                        <span class="status 
                            @if($task->status == 'Not Started') status-not-started
                            @elseif($task->status == 'On Progress') status-in-progress
                            @else status-finished
                            @endif">
                            {{ $task->status }}
                        </span>
                    </div>
                    <div class="flex space-x-2">
                        @if($task->status != 'Finished')
                            <form action="/tasks/{{ $task->id }}/status/On Progress" method="POST">
                                @csrf
                                <button type="submit" class="bg-yellow-400 text-white px-4 py-2 rounded-lg hover:bg-yellow-500 transition-all shadow-sm">
                                    ▶️ Start
                                </button>
                            </form>
                            <form action="/tasks/{{ $task->id }}/status/Finished" method="POST">
                                @csrf
                                <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600 transition-all shadow-sm">
                                    ✅ Finish
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            @empty
                <p class="text-center text-gray-500 italic">No tasks yet. Create one above ⬆️</p>
            @endforelse
        </div>
    </div>

</body>
</html>
