<?php

namespace App\Http\Controllers;

use App\Models\StudyGoal;
use Illuminate\Http\Request;
use Carbon\Carbon;

class StudyGoalController extends Controller
{
    // Goal Overview
    public function index(Request $request)
    {
        $goals = StudyGoal::all();
        $goalsCreated = $goals->count();
        $goalsCompleted = $goals->where('status', 'Completed')->count();
        $goalsInProgress = $goals->where('status', 'In Progress')->count();

        $selectedDay = $request->input('day', 'Today');
        $today = Carbon::today();

        if ($selectedDay === 'Today') {
            $targetDate = $today;
            $label = 'Today';
        } else {
            $targetDate = Carbon::parse("next $selectedDay")->startOfDay();
            $label = $selectedDay;
        }

        $filteredGoals = $goals->filter(function ($goal) use ($targetDate) {
            return Carbon::parse($goal->start_date)->isSameDay($targetDate);
        });

        return view('study-goals.index', compact('goalsCreated', 'goalsCompleted', 'goalsInProgress', 'filteredGoals', 'label'));
    }

    // Add Goal
     public function create()
    {
        return view('study-goals.create');
    }
   public function store(Request $request)
{
    // Validasi input dari form
    $request->validate([
        'goal_title' => 'required|string|max:255',
        'goal_description' => 'required|string',
        'start_date' => 'required|date',
        'end_date' => 'required|date|after_or_equal:start_date',
    ]);

    try {
        // Menyimpan goal
        $goal = new StudyGoal();
        $goal->title = $request->goal_title;
        $goal->description = $request->goal_description;
        $goal->start_date = $request->start_date;
        $goal->end_date = $request->end_date;
        $goal->status = 'In Progress';
        $goal->save();

        // Tentukan halaman tujuan berdasarkan start_date
        $startDate = Carbon::parse($goal->start_date);
        $today = Carbon::today();

        // Jika start_date adalah hari ini
        if ($startDate->isToday()) {
            // Redirect ke halaman Today
            return response()->json([
                'message' => 'Goal berhasil ditambahkan!',
                'redirect' => route('study-goals.today')  // Menyediakan URL untuk redirect ke today
            ]);
        } else {
            // Jika start_date bukan hari ini, arahkan ke Upcoming
            return response()->json([
                'message' => 'Goal berhasil ditambahkan!',
                'redirect' => route('study-goals.upcoming')  // Menyediakan URL untuk redirect ke upcoming
            ]);
        }

    } catch (\Exception $e) {
        \Log::error('Error saving goal: ', ['error' => $e->getMessage()]);
        return response()->json(['error' => 'Terjadi kesalahan saat menyimpan goal.'], 500);
    }
}

    // Today
    public function today()
    {
        $today = Carbon::today()->toDateString();
        $goals = StudyGoal::whereDate('start_date', '<=', $today)
                    ->whereDate('end_date', '>=', $today)
                    ->where('status', 'In Progress')
                    ->get();

        return view('study-goals.today', compact('goals'));
    }

    // Upcoming
    public function upcoming()
    {
        $today = Carbon::today();
        $goals = StudyGoal::whereDate('start_date', '>', $today)
                         ->where('status', 'In Progress')
                         ->get();

        return view('study-goals.upcoming', compact('goals'));
    }

    // Complete
public function complete($id)
{
    $goal = StudyGoal::findOrFail($id);
    $goal->status = 'Completed';
    $goal->save();

    // Mengirimkan pesan dalam bentuk string yang benar
    return redirect()->route('study-goals.today')->with('completed', 'Selamat! Goal Anda telah tercapai!');
}






   public function updateProgress(Request $request, $goalId)
{
    $goal = StudyGoal::findOrFail($goalId);

    // Ambil array tanggal yang dipilih dari checkbox
    $dates = $request->input('dates'); // dates adalah array tanggal yang dikirimkan

    // Validasi apakah tanggal ada
    if (!$dates || count($dates) == 0) {
        return redirect()->back()->with('error', 'Tidak ada tanggal yang dipilih!');
    }

    // Proses setiap tanggal yang dipilih
    foreach ($dates as $date) {
        // Mengonversi tanggal dari format m/d/Y ke Y-m-d
        $formattedDate = Carbon::createFromFormat('Y-m-d', $date)->format('Y-m-d');

        // Menyimpan progress untuk setiap tanggal yang dipilih
        $goal->progress()->updateOrCreate(
            ['date' => $formattedDate], // Mencari progress yang sudah ada dengan tanggal yang sama
            ['status' => 'Checked'] // Status baru untuk progress yang dicentang
        );
    }

    // Menghitung persentase
    $startDate = Carbon::parse($goal->start_date);
    $endDate = Carbon::parse($goal->end_date);
    $totalDays = $startDate->diffInDays($endDate) + 1; // Total hari antara start dan end date
    $checkedDays = $goal->progress()->whereBetween('date', [$startDate, $endDate])->count(); // Jumlah hari yang dicentang

    $percentage = ($checkedDays / $totalDays) * 100; // Menghitung presentase progres

    // Jika 100%, ubah status goal menjadi "Completed" dan kirimkan flag untuk pop-up
    if ($percentage == 100) {
        $goal->status = 'Completed';
        $goal->save();
        
       return redirect()->route('study-goals.today')->with([
    'success' => '',
    'percentage' => $percentage,
    'completed' => 'Selamat! Goal Anda telah tercapai!',  // Mengirimkan pesan sebagai string
    ]);

    }

    // Jika belum 100%, tetap kirim data progress
    return redirect()->route('study-goals.today')->with([
        'success' => '',
        'percentage' => $percentage,
    ]);
}

public function completed()
{
    // Mendapatkan semua goal dengan status 'Completed'
    $goals = StudyGoal::where('status', 'Completed')->get();

    // Mengembalikan view dengan data goals yang sudah selesai
    return view('study-goals.completed', compact('goals'));
}

public function destroy($id)
{
    try {
        // Mencari goal berdasarkan ID
        $goal = StudyGoal::findOrFail($id);

        // Menyimpan URL referer (halaman asal)
        $referer = url()->previous();

        // Menghapus goal
        $goal->delete();

        // Jika goal dihapus dan statusnya 'Completed', arahkan ke halaman 'completed'
        if ($goal->status == 'Completed') {
            return redirect()->route('study-goals.completed')->with('');
        }

        // Jika goal dihapus dan statusnya 'In Progress', arahkan ke halaman 'today'
        return redirect()->route('study-goals.today')->with('');
    } catch (\Exception $e) {
        // Log error jika ada masalah
        \Log::error('Error deleting goal: ', ['error' => $e->getMessage()]);

        // Mengarahkan kembali ke halaman yang sesuai dengan pesan error
        return redirect()->route('study-goals.today')->with('error', 'An error occurred while deleting the goal.');
    }
}

// Menampilkan halaman edit untuk goal
public function edit($id)
{
    // Mencari goal berdasarkan ID
    $goal = StudyGoal::findOrFail($id);
    
    // Menampilkan halaman edit dengan data goal
    return view('study-goals.edit', compact('goal'));
}

// Mengupdate data goal setelah edit

public function update(Request $request, $id)
{
    // Validasi input
    $request->validate([
        'goal_title' => 'required|string|max:255',
        'goal_description' => 'required|string',
        'start_date' => 'required|date',
        'end_date' => 'required|date|after_or_equal:start_date',
    ]);

    // Cari goal berdasarkan ID
    $goal = StudyGoal::findOrFail($id);

    // Update goal dengan data yang baru
    $goal->title = $request->goal_title;
    $goal->description = $request->goal_description;
    $goal->start_date = $request->start_date;
    $goal->end_date = $request->end_date;
    $goal->save();

    // Tentukan tujuan redirect berdasarkan start_date
    $startDate = Carbon::parse($goal->start_date);
    $today = Carbon::today();

    // Jika start_date adalah hari ini, arahkan ke halaman 'today'
    if ($startDate->isToday()) {
        return redirect()->route('study-goals.today')->with([
            'success' => 'Goal berhasil diupdate!', // Pop-up success
        ]);
    } 
    // Jika start_date lebih dari hari ini, arahkan ke halaman 'upcoming'
    else {
        return redirect()->route('study-goals.upcoming')->with([
            'success' => 'Goal berhasil diupdate!', // Pop-up success
        ]);
    }
}


}