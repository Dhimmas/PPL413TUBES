<x-app-layout>
@php
    $hour = now()->format('H');
    $greeting = $hour < 12 ? 'Good Morning' : ($hour < 18 ? 'Good Afternoon' : 'Good Evening');
    $quizStats = $quizStats ?? [];
    $uncompletedQuizzes = $uncompletedQuizzes ?? collect();
    $studyGoals = $studyGoals ?? collect();
    $tasks = $tasks ?? collect();
@endphp

<main class="flex flex-col items-center justify-center min-h-screen p-6 text-white bg-transparent">
    <!-- Greeting -->
    <div class="mb-6 text-center">
        <h2 class="text-2xl font-bold mb-1">{{ $greeting }}, {{ auth()->user()->name }}</h2>
        <p class="text-white/70">We wish you have a productive day!</p>
    </div>

    <!-- Quick Actions Cards -->
    <div class="grid gap-6 sm:grid-cols-2 mb-8 w-full max-w-4xl">
        <a href="{{ route('todos.index') }}" class="group relative hover:scale-105 transition">
            <div class="absolute inset-0 bg-gradient-to-r from-emerald-500 to-teal-600 rounded-2xl blur opacity-25 group-hover:opacity-50 transition duration-500"></div>
            <div class="relative bg-white/10 backdrop-blur-xl rounded-2xl p-6 shadow-xl border border-white/20 hover:bg-white/15 transition-all duration-300">
                <div class="flex items-start justify-between mb-4">
                    <div class="text-4xl">📝</div>
                    <div class="px-3 py-1 bg-white/20 rounded-full text-xs font-semibold text-white/90">
                        To-Do
                    </div>
                </div>
                <h3 class="text-white font-bold text-xl mb-2">To-Do List</h3>
                <p class="text-white/80 text-sm mb-4 leading-relaxed">Organize your daily tasks and boost productivity.</p>
                <button class="w-full py-3 bg-gradient-to-r from-emerald-500 to-teal-600 text-white rounded-xl font-semibold hover:shadow-lg transition-all duration-300 hover:scale-105">
                    Go to To-Do List
                </button>
            </div>
        </a>
        <a href="{{ route('study-goals.index') }}" class="group relative hover:scale-105 transition">
            <div class="absolute inset-0 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-2xl blur opacity-25 group-hover:opacity-50 transition duration-500"></div>
            <div class="relative bg-white/10 backdrop-blur-xl rounded-2xl p-6 shadow-xl border border-white/20 hover:bg-white/15 transition-all duration-300">
                <div class="flex items-start justify-between mb-4">
                    <div class="text-4xl">🎯</div>
                    <div class="px-3 py-1 bg-white/20 rounded-full text-xs font-semibold text-white/90">
                        Goals
                    </div>
                </div>
                <h3 class="text-white font-bold text-xl mb-2">Study Goals</h3>
                <p class="text-white/80 text-sm mb-4 leading-relaxed">Set and track your learning targets for better results.</p>
                <button class="w-full py-3 bg-gradient-to-r from-blue-500 to-indigo-600 text-white rounded-xl font-semibold hover:shadow-lg transition-all duration-300 hover:scale-105">
                    Go to Study Goals
                </button>
            </div>
        </a>
    </div>

    <!-- Progress Tracker Cards (Quiz, Goals, To-Do) -->
    <div class="mb-8 grid grid-cols-1 md:grid-cols-3 gap-6 w-full max-w-5xl">
        <!-- Quiz Progress -->
        <div class="bg-white/10 backdrop-blur-xl rounded-2xl p-6 shadow-xl border border-white/20 flex flex-col">
            <div class="flex items-center gap-3 mb-4">
                <span class="text-2xl">📚</span>
                <span class="font-bold text-white text-lg">Quiz Progress</span>
            </div>
            <div class="flex-1">
                <p class="text-white/80 mb-2">Completed: <span class="font-bold text-green-400">{{ $quizStats['completed_quizzes'] ?? 0 }}</span> / <span class="text-white/60">{{ $quizStats['total_available_quizzes'] ?? 0 }}</span></p>
                <p class="text-white/80 mb-2">Average Score: <span class="font-bold text-blue-400">{{ $quizStats['average_score'] ?? 0 }}</span></p>
                <div class="w-full bg-white/20 rounded-full h-2 mb-2">
                    <div class="bg-gradient-to-r from-green-400 to-emerald-500 h-2 rounded-full transition-all duration-1000 ease-out"
                        style="width: {{ $quizStats['completion_rate'] ?? 0 }}%"></div>
                </div>
                <p class="text-xs text-white/60">Completion Rate: {{ $quizStats['completion_rate'] ?? 0 }}%</p>
            </div>
            <a href="{{ route('quiz.index') }}" class="mt-4 inline-block text-teal-300 hover:underline text-sm">Lihat Semua Quiz</a>
        </div>
        <!-- Study Goals Progress -->
        <div class="bg-white/10 backdrop-blur-xl rounded-2xl p-6 shadow-xl border border-white/20 flex flex-col">
            <div class="flex items-center gap-3 mb-4">
                <span class="text-2xl">🎯</span>
                <span class="font-bold text-white text-lg">Goals Progress</span>
            </div>
            <div class="flex-1">
                @if($studyGoals->count())
                    @foreach($studyGoals->take(2) as $goal)
                        @php
                            $start = \Carbon\Carbon::parse($goal->start_date);
                            $end = \Carbon\Carbon::parse($goal->end_date);
                            $total = $start->diffInDays($end) + 1;
                            $checked = $goal->progress()->count();
                            $percent = $total > 0 ? round(($checked / $total) * 100) : 0;
                        @endphp
                        <div class="mb-3">
                            <div class="flex justify-between items-center">
                                <span class="font-semibold text-white">{{ $goal->title }}</span>
                                <span class="text-xs text-white/60">{{ $percent }}%</span>
                            </div>
                            <div class="w-full bg-white/20 rounded-full h-2">
                                <div class="bg-gradient-to-r from-blue-400 to-indigo-500 h-2 rounded-full transition-all duration-1000 ease-out"
                                    style="width: {{ $percent }}%"></div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <p class="text-white/60 text-sm">No active goals.</p>
                @endif
            </div>
            <a href="{{ route('study-goals.index') }}" class="mt-4 inline-block text-teal-300 hover:underline text-sm">Lihat Semua Goals</a>
        </div>
        <!-- To-Do Progress -->
        <div class="bg-white/10 backdrop-blur-xl rounded-2xl p-6 shadow-xl border border-white/20 flex flex-col">
            <div class="flex items-center gap-3 mb-4">
                <span class="text-2xl">📝</span>
                <span class="font-bold text-white text-lg">To-Do Progress</span>
            </div>
            <div class="flex-1">
                @if($tasks->count())
                    @foreach($tasks->take(2) as $task)
                        @php
                            $status = $task->completed ? 'Selesai' : 'Belum Selesai';
                            $percent = $task->completed ? 100 : 0;
                        @endphp
                        <div class="mb-3">
                            <div class="flex justify-between items-center">
                                <span class="font-semibold text-white">{{ $task->title }}</span>
                                <span class="text-xs text-white/60">{{ $status }}</span>
                            </div>
                            <div class="w-full bg-white/20 rounded-full h-2">
                                <div class="bg-gradient-to-r from-emerald-400 to-teal-500 h-2 rounded-full transition-all duration-1000 ease-out"
                                    style="width: {{ $percent }}%"></div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <p class="text-white/60 text-sm">No tasks for today.</p>
                @endif
            </div>
            <a href="{{ route('todos.index') }}" class="mt-4 inline-block text-teal-300 hover:underline text-sm">Lihat Semua Tugas</a>
        </div>
    </div>

    <!-- Interaktif: Progress Ring (contoh) -->
    <div class="mb-8 grid grid-cols-1 md:grid-cols-3 gap-6 w-full max-w-5xl">
        <div class="bg-white/10 rounded-2xl p-6 flex flex-col items-center shadow-xl border border-white/20">
            <canvas id="quizProgressRing" width="120" height="120"></canvas>
            <div class="mt-3 text-center">
                <div class="text-lg font-bold text-white">Quiz Completion</div>
                <div class="text-white/70 text-sm">{{ $quizStats['completion_rate'] ?? 0 }}%</div>
            </div>
        </div>
        <div class="bg-white/10 rounded-2xl p-6 flex flex-col items-center shadow-xl border border-white/20">
            <canvas id="goalProgressRing" width="120" height="120"></canvas>
            <div class="mt-3 text-center">
                <div class="text-lg font-bold text-white">Goals Completion</div>
                <div class="text-white/70 text-sm">
                    @if($studyGoals->count())
                        {{ round($studyGoals->avg(function($g){
                            $start = \Carbon\Carbon::parse($g->start_date);
                            $end = \Carbon\Carbon::parse($g->end_date);
                            $total = $start->diffInDays($end) + 1;
                            $checked = $g->progress()->count();
                            return $total > 0 ? ($checked / $total) * 100 : 0;
                        })) }}%
                    @else
                        0%
                    @endif
                </div>
            </div>
        </div>
        <div class="bg-white/10 rounded-2xl p-6 flex flex-col items-center shadow-xl border border-white/20">
            <canvas id="todoProgressRing" width="120" height="120"></canvas>
            <div class="mt-3 text-center">
                <div class="text-lg font-bold text-white">To-Do Completion</div>
                <div class="text-white/70 text-sm">
                    @php
                        $totalTasks = $tasks->count();
                        $doneTasks = $tasks->where('completed', true)->count();
                        $todoPercent = $totalTasks > 0 ? round(($doneTasks / $totalTasks) * 100) : 0;
                    @endphp
                    {{ $todoPercent }}%
                </div>
            </div>
        </div>
    </div>

    <!-- Study Tips - Enhanced -->
    <div class="mb-8 w-full max-w-4xl">
        <h3 class="text-2xl font-bold text-white mb-6 flex items-center gap-3">
            <span class="text-3xl">📚</span>
            Artikel Pilihan: Teknik Belajar Efektif
        </h3>
        <div class="relative group">
            <div class="absolute inset-0 bg-gradient-to-br from-indigo-600/30 to-purple-600/30 rounded-2xl blur opacity-50"></div>
            <div class="relative bg-white/10 backdrop-blur-xl rounded-2xl p-8 shadow-xl border border-white/20 hover:bg-white/15 transition-all duration-300">
                <div class="space-y-4">
                    @foreach([
                        ['✅', 'Tentukan tujuan belajar yang jelas dan terukur.', 'from-green-400 to-emerald-500'],
                        ['🕒', 'Kelola waktu belajar dengan teknik Pomodoro atau time-blocking.', 'from-blue-400 to-indigo-500'],
                        ['🧠', 'Gunakan teknik aktif seperti membuat mind map, flashcard, dan self-quizzing.', 'from-purple-400 to-pink-500'],
                        ['🛌', 'Tidur cukup dan beri jeda istirahat untuk meningkatkan konsentrasi.', 'from-indigo-400 to-purple-500'],
                        ['🥗', 'Pola makan sehat bantu stamina belajar tetap stabil!', 'from-orange-400 to-red-500'],
                    ] as [$icon, $tip, $gradient])
                        <div class="flex items-center gap-4 p-4 bg-white/5 rounded-xl hover:bg-white/10 transition-all duration-300 group/item">
                            <div class="w-12 h-12 bg-gradient-to-br {{ $gradient }} rounded-xl flex items-center justify-center text-xl shadow-lg group-hover/item:scale-110 transition-transform duration-300">
                                {{ $icon }}
                            </div>
                            <p class="text-white flex-1 font-medium">{{ $tip }}</p>
                        </div>
                    @endforeach
                </div>
                <div class="mt-8 flex flex-col sm:flex-row justify-between items-center gap-4 pt-6 border-t border-white/20">
                    <a href="https://dit-mawa.upi.edu/teknik-belajar-yang-efektif/" target="_blank" 
                       class="text-blue-300 hover:text-blue-200 underline text-sm font-medium transition-colors duration-300 flex items-center gap-2">
                        📖 Baca artikel lengkap
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M11 3a1 1 0 100 2h2.586l-6.293 6.293a1 1 0 101.414 1.414L15 6.414V9a1 1 0 102 0V4a1 1 0 00-1-1h-5z"/>
                            <path d="M5 5a2 2 0 00-2 2v8a2 2 0 002 2h8a2 2 0 002-2v-3a1 1 0 10-2 0v3H5V7h3a1 1 0 000-2H5z"/>
                        </svg>
                    </a>
                    <button class="px-6 py-3 bg-gradient-to-r from-indigo-500 to-purple-600 text-white rounded-xl font-semibold hover:shadow-xl transition-all duration-300 hover:scale-105">
                        🚀 Terapkan Sekarang
                    </button>
                </div>
            </div>
        </div>
    </div>
</main>

@push('scripts')
<script>
function drawProgressRing(canvasId, percent, color1, color2) {
    const canvas = document.getElementById(canvasId);
    if (!canvas) return;
    const ctx = canvas.getContext('2d');
    const radius = 50;
    const center = 60;
    ctx.clearRect(0, 0, 120, 120);

    // Background ring
    ctx.beginPath();
    ctx.arc(center, center, radius, 0, 2 * Math.PI);
    ctx.strokeStyle = '#334155';
    ctx.lineWidth = 12;
    ctx.stroke();

    // Progress ring
    const grad = ctx.createLinearGradient(0, 0, 120, 0);
    grad.addColorStop(0, color1);
    grad.addColorStop(1, color2);
    ctx.beginPath();
    ctx.arc(center, center, radius, -Math.PI/2, (2 * Math.PI) * (percent/100) - Math.PI/2);
    ctx.strokeStyle = grad;
    ctx.lineWidth = 12;
    ctx.lineCap = 'round';
    ctx.stroke();

    // Text
    ctx.font = "bold 22px 'Poppins', sans-serif";
    ctx.fillStyle = "#fff";
    ctx.textAlign = "center";
    ctx.textBaseline = "middle";
    ctx.fillText(percent + "%", center, center);
}

document.addEventListener('DOMContentLoaded', function() {
    drawProgressRing('quizProgressRing', {{ $quizStats['completion_rate'] ?? 0 }}, '#34d399', '#10b981');
    drawProgressRing('goalProgressRing', {{ $studyGoals->count() ? round($studyGoals->avg(function($g){
        $start = \Carbon\Carbon::parse($g->start_date);
        $end = \Carbon\Carbon::parse($g->end_date);
        $total = $start->diffInDays($end) + 1;
        $checked = $g->progress()->count();
        return $total > 0 ? ($checked / $total) * 100 : 0;
    })) : 0 }}, '#60a5fa', '#6366f1');
    drawProgressRing('todoProgressRing', {{ $todoPercent ?? 0 }}, '#34d399', '#06b6d4');
});
</script>
@endpush
</x-app-layout>