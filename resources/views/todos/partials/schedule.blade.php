<div class="bg-white rounded-lg shadow overflow-hidden">
    <div class="p-4 border-b">
        <h3 class="text-lg font-medium">{{ now()->format('F Y') }}</h3>
    </div>
    <table class="min-w-full">
        <thead>
            <tr>
                @foreach(['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'] as $day)
                    <th class="px-4 py-2 text-center">{{ $day }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach($calendar as $week)
                <tr>
                    @foreach($week as $day)
                        <td class="border px-4 py-2 text-center 
                            {{ !$day['isCurrentMonth'] ? 'text-gray-400' : '' }}
                            {{ $day['isToday'] ? 'bg-blue-100' : '' }}">
                            <a href="{{ route('todos.index', ['date' => $day['date']->format('Y-m-d')]) }}" 
                               class="block w-full h-full">
                                {{ $day['date']->format('j') }}
                            </a>
                        </td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>
</div>