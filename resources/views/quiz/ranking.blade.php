<x-app-layout>
    <div class="min-h-screen bg-gradient-to-br from-gray-900 via-purple-900 to-gray-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <!-- Header -->
            <div class="text-center mb-12">
                <h1 class="text-4xl md:text-5xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-purple-400 mb-4">
                    🏆 Ranking Quiz
                </h1>
                <h2 class="text-2xl md:text-3xl font-bold text-white mb-2">{{ $quiz->title }}</h2>
                <p class="text-white/70 text-lg">Lihat siapa yang mendapat skor tertinggi!</p>
            </div>

            <!-- Quiz Stats -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <div class="bg-white/10 backdrop-blur-lg rounded-2xl p-6 shadow-xl border border-white/20 text-center">
                    <div class="text-3xl font-bold text-blue-400 mb-2">{{ $totalAttempts }}</div>
                    <div class="text-white/70">Total Percobaan</div>
                </div>
                <div class="bg-white/10 backdrop-blur-lg rounded-2xl p-6 shadow-xl border border-white/20 text-center">
                    <div class="text-3xl font-bold text-green-400 mb-2">{{ $completedAttempts }}</div>
                    <div class="text-white/70">Selesai</div>
                </div>
                <div class="bg-white/10 backdrop-blur-lg rounded-2xl p-6 shadow-xl border border-white/20 text-center">
                    <div class="text-3xl font-bold text-yellow-400 mb-2">{{ $averageScore ? number_format($averageScore, 1) : '0' }}</div>
                    <div class="text-white/70">Rata-rata Skor</div>
                </div>
                <div class="bg-white/10 backdrop-blur-lg rounded-2xl p-6 shadow-xl border border-white/20 text-center">
                    <div class="text-3xl font-bold text-purple-400 mb-2">{{ $averageTime ? number_format($averageTime, 1) : '0' }}</div>
                    <div class="text-white/70">Rata-rata Waktu (menit)</div>
                </div>
            </div>

            <!-- Top Scorers -->
            <div class="mb-8">
                <div class="bg-white/10 backdrop-blur-lg rounded-2xl p-6 shadow-xl border border-white/20">
                    <div class="flex items-center mb-6">
                        <div class="w-12 h-12 bg-gradient-to-r from-yellow-400 to-orange-500 rounded-full flex items-center justify-center mr-4">
                            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-white">🥇 Top Scorers</h3>
                    </div>
                    @if($topScorers->count() > 0)
                        <div class="space-y-4">
                            @foreach($topScorers as $index => $result)
                                <div class="flex items-center justify-between p-4 bg-white/5 rounded-xl hover:bg-white/10 transition-colors duration-200">
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 rounded-full flex items-center justify-center font-bold text-lg mr-4
                                            {{ $index == 0 ? 'bg-gradient-to-r from-yellow-400 to-yellow-600 text-white' : '' }}
                                            {{ $index == 1 ? 'bg-gradient-to-r from-gray-300 to-gray-500 text-white' : '' }}
                                            {{ $index == 2 ? 'bg-gradient-to-r from-orange-400 to-orange-600 text-white' : '' }}
                                            {{ $index > 2 ? 'bg-white/10 text-white/70' : '' }}">
                                            @if($index < 3)
                                                {{ $index + 1 }}
                                            @else
                                                {{ $index + 1 }}
                                            @endif
                                        </div>
                                        <div>
                                            <div class="font-semibold text-white">{{ $result->user->name }}</div>
                                            <div class="text-sm text-white/60">
                                                Selesai: {{ $result->finished_at->format('d M Y, H:i') }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <div class="text-2xl font-bold text-green-400">
                                            {{ $result->score }} / {{ $quiz->questions->count() }}
                                        </div>
                                        <div class="text-sm text-white/60">
                                            {{ number_format(($result->score / $quiz->questions->count()) * 100, 1) }}%
                                        </div>
                                        @if($result->completion_time_minutes)
                                            <div class="text-xs text-blue-400 mt-1">
                                                ⏱️ {{ number_format($result->completion_time_minutes, 1) }} menit
                                            </div>
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
            </div>

            <!-- Recent Completions -->
            <div class="mb-8">
                <div class="bg-white/10 backdrop-blur-lg rounded-2xl p-6 shadow-xl border border-white/20">
                    <div class="flex items-center mb-6">
                        <div class="w-12 h-12 bg-gradient-to-r from-blue-400 to-cyan-500 rounded-full flex items-center justify-center mr-4">
                            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-white">🕒 Terbaru Selesai</h3>
                    </div>
                    @if($recentCompletions->count() > 0)
                        <div class="space-y-3">
                            @foreach($recentCompletions as $result)
                                <div class="flex items-center justify-between p-3 bg-white/5 rounded-lg hover:bg-white/10 transition-colors duration-200">
                                    <div class="flex items-center">
                                        <div class="w-8 h-8 bg-blue-500/20 rounded-full flex items-center justify-center mr-3">
                                            <span class="text-sm font-bold text-blue-400">{{ substr($result->user->name, 0, 1) }}</span>
                                        </div>
                                        <div>
                                            <div class="font-medium text-white">{{ $result->user->name }}</div>
                                            <div class="text-xs text-white/50">{{ $result->finished_at->diffForHumans() }}</div>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <div class="font-bold text-green-400">{{ $result->score }}/{{ $quiz->questions->count() }}</div>
                                        @if($result->completion_time_minutes)
                                            <div class="text-xs text-blue-400">{{ number_format($result->completion_time_minutes, 1) }}m</div>
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
            </div>

            <!-- Back Button -->
            <div class="text-center">
                <a href="{{ route('quiz.index') }}" 
                   class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-gray-600 to-gray-700 hover:from-gray-700 hover:to-gray-800 text-white rounded-xl font-semibold shadow-lg hover:shadow-xl transition-all duration-200 transform hover:scale-105">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Kembali ke Daftar Quiz
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
