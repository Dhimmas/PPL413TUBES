<x-app-layout>
    @push('styles')
        @vite('resources/css/quiz_navigation.css')
    @endpush
    
    {{-- Main Container yang menggabungkan quiz dan navigation --}}
    <div class="quiz-main-container">
        {{-- Quiz Content Card --}}
        <div class="quiz-content-card">
            <h1 class="text-3xl font-bold text-center mb-6 text-white">{{ $quiz->title }}</h1>

            {{-- Timer Section --}}
            @if ($quiz->time_limit_per_quiz)
                <div class="bg-gray-800 p-4 rounded-lg mb-6 text-center">
                    <p class="text-xl font-semibold mb-2 text-white">Waktu Quiz Tersisa:</p>
                    <span id="quiz-timer" class="text-4xl font-extrabold text-blue-400"></span>
                </div>
            @else
                <div class="bg-gray-800 p-4 rounded-lg mb-6 text-center">
                    <p class="text-xl font-semibold text-gray-400">Quiz ini tidak memiliki batas waktu total.</p>
                </div>
            @endif

            <div id="question-display" 
                 class="bg-gray-800 p-6 rounded-lg shadow-inner mb-6"
                 data-quiz-id="{{ $quiz->id }}"
                 data-result-id="{{ $resultId }}"
                 data-time-remaining="{{ $timeRemaining }}"
                 data-initial-question='@json($initialQuestion)'
                 data-current-answers='@json($userAnswers)'
                 data-total-questions="{{ $totalQuestions }}"
                 data-question-cache='@json($questionsForCache)'>
                {{-- Soal akan dimuat di sini oleh JavaScript --}}
                <div id="current-question-content">
                    <p class="text-center text-lg mt-8 text-white">Memuat soal...</p>
                    <div class="animate-pulse flex space-x-4 mt-4">
                        <div class="flex-1 space-y-4 py-1">
                            <div class="h-4 bg-gray-700 rounded w-3/4 mx-auto"></div>
                            <div class="h-4 bg-gray-700 rounded w-1/2 mx-auto"></div>
                            <div class="h-4 bg-gray-700 rounded w-5/6 mx-auto"></div>
                        </div>
                    </div>
                </div>
                <div class="mt-6 text-center text-gray-400 text-sm">
                    Soal <span id="question-number" class="font-bold">1</span> dari <span id="total-questions" class="font-bold">{{ $totalQuestions }}</span>
                </div>
            </div>

            {{-- Navigation Buttons --}}
            <div class="flex justify-between mt-8 gap-4">
                {{-- Tombol Previous --}}
                <button type="button" id="prev-question-btn" class="bg-gray-700 hover:bg-gray-600 text-white px-6 py-3 rounded-lg shadow-md transition duration-300 ease-in-out">
                    <i class="fas fa-arrow-left mr-2"></i> Sebelumnya
                </button>
                
                {{-- Tombol Next / Selesai --}}
                <button type="button" id="next-question-btn" class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-lg shadow-md transition duration-300 ease-in-out flex items-center">
                    Selanjutnya <i class="fas fa-arrow-right ml-2"></i>
                </button>
            </div>

            {{-- Navigation Instructions untuk Mobile --}}
            <div class="mt-4 text-center text-gray-400 text-sm lg:hidden">
                <p>
                    <i class="fas fa-mobile-alt mr-1"></i>
                    Tekan tombol menu di kanan atas untuk melihat navigasi soal
                </p>
            </div>
        </div>

        {{-- Navigation Card --}}
        <div class="quiz-navigation-card" id="questionNavigationCard">
            <div class="nav-card-header">
                <div class="nav-title">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none">
                        <path d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <span>Quiz Navigation</span>
                </div>
                {{-- Close button hanya muncul di mobile/tablet --}}
                <button class="nav-close" onclick="toggleQuestionNav()" aria-label="Close navigation">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none">
                        <path d="M18 6L6 18M6 6l12 12" stroke="currentColor" stroke-width="2"/>
                    </svg>
                </button>
            </div>
            
            <div class="nav-progress-section">
                <div class="progress-info">
                    <span class="progress-label">Progress</span>
                    <span class="progress-count" id="progressCount">0/{{ $totalQuestions }}</span>
                </div>
                <div class="progress-bar">
                    <div class="progress-fill" id="progressFill"></div>
                </div>
            </div>
            
            <div class="nav-content">
                <div class="question-grid" id="questionGrid">
                    {{-- Question cards akan di-generate oleh JavaScript --}}
                </div>
                
                <div class="nav-legend">
                    <h4>Status Legend:</h4>
                    <div class="legend-items">
                        <div class="legend-item">
                            <span class="legend-dot current"></span>
                            <span>Current</span>
                        </div>
                        <div class="legend-item">
                            <span class="legend-dot answered"></span>
                            <span>Answered</span>
                        </div>
                        <div class="legend-item">
                            <span class="legend-dot unanswered"></span>
                            <span>Unanswered</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Mobile Toggle Button - Hanya muncul di mobile/tablet --}}
        <button class="nav-toggle" onclick="toggleQuestionNav()" aria-label="Toggle navigation">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                <rect x="3" y="6" width="18" height="2" fill="currentColor"/>
                <rect x="3" y="12" width="18" height="2" fill="currentColor"/>
                <rect x="3" y="18" width="18" height="2" fill="currentColor"/>
            </svg>
        </button>

        {{-- Overlay for mobile/tablet only --}}
        <div class="nav-overlay" id="navOverlay" onclick="toggleQuestionNav()"></div>
    </div>

    @push('scripts') 
        @vite('resources/js/quiz_attempt.js')
    @endpush
    
</x-app-layout>