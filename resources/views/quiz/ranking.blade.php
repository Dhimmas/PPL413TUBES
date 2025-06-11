<x-app-layout>
    <div class="min-h-screen bg-gradient-to-br from-gray-900 via-purple-900 to-gray-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <!-- Header -->
            <div class="text-center mb-12">
                <div class="bg-white/10 backdrop-blur-lg rounded-3xl p-8 shadow-2xl border border-white/20">
                    <h1 class="text-4xl md:text-5xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-yellow-400 via-orange-500 to-red-500 mb-4">
                        🏆 Leaderboard Quiz
                    </h1>
                    <h2 class="text-2xl md:text-3xl font-bold text-white mb-2">{{ $quiz->title }}</h2>
                    <p class="text-white/70 text-lg">{{ $quiz->description ?? 'Lihat siapa yang terbaik dalam quiz ini!' }}</p>
                    
                    <!-- Quiz Stats -->
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-6">
                        <div class="bg-white/5 rounded-xl p-4">
                            <div class="text-2xl font-bold text-blue-400">{{ $totalAttempts }}</div>
                            <div class="text-white/60 text-sm">Total Attempts</div>
                        </div>
                        <div class="bg-white/5 rounded-xl p-4">
                            <div class="text-2xl font-bold text-green-400">{{ $completedAttempts }}</div>
                            <div class="text-white/60 text-sm">Completed</div>
                        </div>
                        <div class="bg-white/5 rounded-xl p-4">
                            <div class="text-2xl font-bold text-purple-400">{{ number_format($averageScore ?? 0, 1) }}</div>
                            <div class="text-white/60 text-sm">Avg Score</div>
                        </div>
                        <div class="bg-white/5 rounded-xl p-4">
                            <div class="text-2xl font-bold text-yellow-400">{{ number_format($averageTime ?? 0, 1) }}m</div>
                            <div class="text-white/60 text-sm">Avg Time</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Rankings Grid -->
            <div class="grid lg:grid-cols-2 gap-8 mb-8">
                <!-- Top Scorers -->
                <div class="bg-white/10 backdrop-blur-lg rounded-2xl p-6 shadow-xl border border-white/20">
                    <div class="flex items-center mb-6">
                        <div class="w-12 h-12 bg-gradient-to-r from-yellow-400 to-orange-500 rounded-full flex items-center justify-center mr-4">
                            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-white">🏆 Top Scorers</h3>
                    </div>
                    
                    @if($topScorers->count() > 0)
                        <div class="space-y-3">
                            @foreach($topScorers as $index => $result)
                                <div class="flex items-center p-4 bg-white/5 rounded-xl hover:bg-white/10 transition-all duration-300 {{ $index < 3 ? 'ring-2 ring-yellow-400/50' : '' }}">
                                    <div class="flex-shrink-0 w-10 h-10 rounded-full flex items-center justify-center mr-4 {{ $index === 0 ? 'bg-gradient-to-r from-yellow-400 to-yellow-600' : ($index === 1 ? 'bg-gradient-to-r from-gray-300 to-gray-500' : ($index === 2 ? 'bg-gradient-to-r from-orange-400 to-orange-600' : 'bg-gray-600')) }}">
                                        @if($index < 3)
                                            <span class="text-white font-bold">{{ $index + 1 }}</span>
                                        @else
                                            <span class="text-white text-sm">{{ $index + 1 }}</span>
                                        @endif
                                    </div>
                                    <div class="flex-1">
                                        <div class="font-semibold text-white">{{ $result->user->name }}</div>
                                        <div class="text-white/60 text-sm">
                                            Score: {{ $result->score }}/{{ $quiz->questions->count() }} 
                                            ({{ number_format(($result->score / $quiz->questions->count()) * 100, 1) }}%)
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <div class="text-green-400 font-bold">{{ number_format(($result->score / $quiz->questions->count()) * 100, 1) }}%</div>
                                        @if($result->completion_time_minutes)
                                            <div class="text-white/60 text-sm">{{ number_format($result->completion_time_minutes, 1) }}m</div>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8">
                            <div class="text-white/40 text-lg">Belum ada yang menyelesaikan quiz ini</div>
                        </div>
                    @endif
                </div>

                <!-- Fastest Completions -->
                <div class="bg-white/10 backdrop-blur-lg rounded-2xl p-6 shadow-xl border border-white/20">
                    <div class="flex items-center mb-6">
                        <div class="w-12 h-12 bg-gradient-to-r from-blue-400 to-cyan-500 rounded-full flex items-center justify-center mr-4">
                            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-white">⚡ Speed Masters</h3>
                    </div>
                    
                    @if($fastestCompletions->count() > 0)
                        <div class="space-y-3">
                            @foreach($fastestCompletions as $index => $result)
                                <div class="flex items-center p-4 bg-white/5 rounded-xl hover:bg-white/10 transition-all duration-300 {{ $index < 3 ? 'ring-2 ring-blue-400/50' : '' }}">
                                    <div class="flex-shrink-0 w-10 h-10 rounded-full flex items-center justify-center mr-4 {{ $index === 0 ? 'bg-gradient-to-r from-blue-400 to-blue-600' : ($index === 1 ? 'bg-gradient-to-r from-cyan-400 to-cyan-600' : ($index === 2 ? 'bg-gradient-to-r from-teal-400 to-teal-600' : 'bg-gray-600')) }}">
                                        <span class="text-white font-bold text-sm">{{ $index + 1 }}</span>
                                    </div>
                                    <div class="flex-1">
                                        <div class="font-semibold text-white">{{ $result->user->name }}</div>
                                        <div class="text-white/60 text-sm">
                                            Score: {{ $result->score }}/{{ $quiz->questions->count() }}
                                            ({{ number_format(($result->score / $quiz->questions->count()) * 100, 1) }}%)
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <div class="text-blue-400 font-bold">⚡ {{ number_format($result->completion_time_minutes, 1) }}m</div>
                                        <div class="text-white/60 text-sm">Completed</div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8">
                            <div class="text-white/40 text-lg">Belum ada data waktu penyelesaian</div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Recent Completions -->
            <div class="bg-white/10 backdrop-blur-lg rounded-2xl p-6 shadow-xl border border-white/20">
                <div class="flex items-center mb-6">
                    <div class="w-12 h-12 bg-gradient-to-r from-purple-400 to-pink-500 rounded-full flex items-center justify-center mr-4">
                        <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-white">🕒 Recent Completions</h3>
                </div>
                
                @if($recentCompletions->count() > 0)
                    <div class="grid md:grid-cols-2 gap-4">
                        @foreach($recentCompletions->take(10) as $result)
                            <div class="flex items-center p-4 bg-white/5 rounded-xl hover:bg-white/10 transition-all duration-300">
                                <div class="flex-1">
                                    <div class="font-semibold text-white">{{ $result->user->name }}</div>
                                    <div class="text-white/60 text-sm">
                                        @if($result->finished_at && $result->finished_at instanceof \Carbon\Carbon)
                                            {{ $result->finished_at->diffForHumans() }}
                                        @else
                                            {{ $result->finished_at ?? 'Waktu tidak tersedia' }}
                                        @endif
                                    </div>
                                </div>
                                <div class="text-right">
                                    <div class="text-purple-400 font-bold">{{ $result->score }}/{{ $quiz->questions->count() }}</div>
                                    @if($result->completion_time_minutes)
                                        <div class="text-white/60 text-sm">{{ number_format($result->completion_time_minutes, 1) }}m</div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8">
                        <div class="text-white/40 text-lg">Belum ada yang menyelesaikan quiz ini</div>
                    </div>
                @endif
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row justify-center gap-4 mt-8">
                <a href="{{ route('quiz.index') }}" 
                   class="inline-flex items-center justify-center px-8 py-4 bg-gradient-to-r from-gray-600 to-gray-700 hover:from-gray-700 hover:to-gray-800 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Kembali ke Quiz
                </a>
                
                @auth
                    @php
                        $userResult = \App\Models\UserQuizResult::where('quiz_id', $quiz->id)
                                        ->where('user_id', auth()->id())
                                        ->where('status', 'completed')
                                        ->latest()
                                        ->first();
                    @endphp
                    
                    @if($userResult)
                        <a href="{{ route('quiz.result', $quiz->id) }}" 
                           class="inline-flex items-center justify-center px-8 py-4 bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                            </svg>
                            Lihat Hasil Saya
                        </a>
                    @else
                        <a href="{{ route('quiz.attempt', $quiz->id) }}" 
                           class="inline-flex items-center justify-center px-8 py-4 bg-gradient-to-r from-blue-500 to-purple-600 hover:from-blue-600 hover:to-purple-700 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h1.586a1 1 0 01.707.293l2.414 2.414a1 1 0 00.707.293H15M9 10v4a6 6 0 006 6v-3"/>
                            </svg>
                            Coba Quiz Ini
                        </a>
                    @endif
                @endauth
            </div>
        </div>
    </div>
</x-app-layout>
