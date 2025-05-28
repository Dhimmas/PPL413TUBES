<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\TaskCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class TodoController extends Controller
{
    // Menampilkan halaman utama To-Do List
    public function index(Request $request)
    {
        // Ambil tanggal yang dipilih (default: hari ini)
        $selectedDate = $request->input('date') ? Carbon::parse($request->date) : now();
        
        // Ambil tugas untuk tanggal tersebut
        $tasks = Task::with('category')
            ->whereDate('date', $selectedDate)
            ->orderBy('time')
            ->get();
            
        // Ambil semua kategori
        $categories = TaskCategory::all();
        
        // Generate data kalender
        $calendar = $this->generateCalendar($selectedDate);
        
        return view('todos.index', [
            'tasks' => Task::all(),
            'categories' => $categories,
            'calendar' => $calendar,
            'selectedDate' => $selectedDate->format('Y-m-d'),
        ]);
    }
    
    // Menyimpan tugas baru
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'date' => 'required|date',
            'description' => 'nullable|string',
            'time' => 'nullable|date_format:H:i'
        ]);
        
        Task::create($request->all());
        
        return back()->with('success', 'Tugas berhasil ditambahkan!');
    }
    
    // Update status tugas (selesai/belum)
    public function update(Request $request, Task $task)
    {
        $task->update(['completed' => $request->completed]);
        return response()->json(['success' => true]);
    }
    
    // Hapus tugas
    public function destroy(Task $task)
    {
        $task->delete();
        return response()->json(['success' => true]);
    }
    
    // Helper: Generate data kalender
    private function generateCalendar($date)
    {
        $startOfMonth = Carbon::parse($date)->startOfMonth();
        $endOfMonth = Carbon::parse($date)->endOfMonth();
        
        $calendar = [];
        $currentDay = $startOfMonth->copy()->startOfWeek(Carbon::SUNDAY);
        
        while ($currentDay <= $endOfMonth->copy()->endOfWeek(Carbon::SATURDAY)) {
            $week = [];
            for ($i = 0; $i < 7; $i++) {
                $week[] = [
                    'date' => $currentDay->copy(),
                    'isCurrentMonth' => $currentDay->month == $date->month,
                    'isToday' => $currentDay->isToday(),
                ];
                $currentDay->addDay();
            }
            $calendar[] = $week;
        }
        
        return $calendar;
    }
}

