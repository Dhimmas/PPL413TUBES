<div class="space-y-4">
    @foreach($tasks as $task)
        <div class="flex items-start p-4 border rounded-lg hover:bg-gray-50">
            <input type="checkbox" 
                   class="mt-1 h-5 w-5 rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                   data-task-id="{{ $task->id }}"
                   {{ $task->completed ? 'checked' : '' }}>
            
            <div class="ml-3 flex-1">
                <div class="flex justify-between items-start">
                    <div>
                        <h3 class="font-medium {{ $task->completed ? 'line-through text-gray-500' : 'text-gray-900' }}">
                            {{ $task->title }} 
                        </h3>
                    </div>
                    <div class="flex items-center space-x-4">
                        <span class="text-sm text-gray-500">
                            {{ \Carbon\Carbon::parse($task->date)->format('d/m/Y') }}
                        </span>
                        @if($task->time)
                            <span class="text-sm text-gray-500">
                                {{ \Carbon\Carbon::parse($task->time)->format('H:i') }}
                            </span>
                        @endif
                    </div>
                </div>
                
                @if($task->description)
                    <p class="mt-1 text-sm text-gray-700">{{ $task->description }}</p>
                @endif
                
                <div class="mt-2 flex space-x-2">
                    <button class="text-sm text-blue-600 hover:text-blue-800 edit-task" 
                            data-task-id="{{ $task->id }}">
                        Edit
                    </button>
                    <button class="text-sm text-red-600 hover:text-red-800 delete-task" 
                            data-task-id="{{ $task->id }}">
                        Hapus
                    </button>
                </div>
            </div>
        </div>
    @endforeach
    
    @if($tasks->isEmpty())
        <p class="text-center text-gray-500 py-4">Tidak ada tugas hari ini.</p>
    @endif
</div>