<?php

namespace App\Http\Controllers;

use App\Models\Tasks;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Tasks::all();
        return view('tasks.index', compact('tasks'));
    }

    public function store(Request $request)
    {
        Tasks::create([
            'task_name' => $request->task_name,
            'status' => 'Not Started',
            'deadline' => $request->deadline
        ]);

        return redirect()->route('tasks.index');
    }

    public function updateStatus($id, $status)
    {
        $task = Tasks::find($id);
        $task->status = $status;
        $task->save();

        return redirect()->route('tasks.index');
    }
}