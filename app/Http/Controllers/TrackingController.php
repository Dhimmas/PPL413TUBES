<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task; // Pastikan kamu punya model Task
use Carbon\Carbon;

class TrackingController extends Controller
{
    /**
     * Menampilkan halaman utama Progress Tracker.
     */
    public function index()
    {
        // Ambil semua task dan filter berdasarkan status
        $notStarted = Task::where('status', 'not_started')->get();
        $onProgress = Task::where('status', 'on_progress')->get();
        $finished = Task::where('status', 'finished')->get();

        // Group khusus untuk sidebar deadline task Not Yet Started
        $grouped = $notStarted->groupBy(function ($task) {
            return Carbon::parse($task->date)->format('Y-m-d');
        });

        return view('tracking.index', compact(
            'notStarted', 'onProgress', 'finished', 'grouped'
        ));
    }

    /**
     * Menampilkan task berdasarkan status via route dinamis.
     */
    public function byStatus($status)
    {
        $validStatuses = [
            'not_started' => 'Not Yet Started',
            'on_progress' => 'On Progress',
            'finished'    => 'Finished'
        ];

        if (!array_key_exists($status, $validStatuses)) {
            abort(404);
        }

        $tasks = Task::where('status', $status)->get();

        return view('tracking.detail', [
            'tasks' => $tasks,
            'statusTitle' => $validStatuses[$status]
        ]);
    }
}
