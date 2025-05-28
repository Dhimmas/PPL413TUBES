<?php

namespace App\Http\Controllers;

use App\Models\PomodoroSession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class PomodoroController extends Controller
{
    public function index()
    {
        $sessions = PomodoroSession::where('user_id', Auth::id())
            ->latest()
            ->take(10)
            ->get();

        return view('pomodoro.index', compact('sessions'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'activity_name'     => 'nullable|string|max:255',
            'description'       => 'nullable|string|max:1000',
            'started_at'        => 'required|date',
            'ended_at'          => 'required|date|after:started_at',
            'duration_minutes'  => 'required|integer|min:1|max:180',
            'type'              => 'required|in:work,break',
        ]);

        // Gunakan parse Carbon untuk menjaga konsistensi
        $validated['started_at'] = Carbon::parse($validated['started_at']);
        $validated['ended_at']   = Carbon::parse($validated['ended_at']);
        $validated['user_id']    = Auth::id();

        $session = PomodoroSession::create($validated);

        return response()->json([
            'message' => 'Session saved successfully.',
            'data' => $session,
        ]);
    }
}
