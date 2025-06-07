<x-app-layout>
    {{-- CATATAN: Link Font Awesome sudah ada di layouts/app.blade.php, jadi tidak perlu diulang di sini. --}}
    <div class="container mx-auto p-4 max-w-3xl bg-gray-900 text-white rounded-lg shadow-xl mt-8">
        <h1 class="text-3xl font-bold text-center mb-6">{{ $quiz->title }}</h1>

        {{-- Timer Section --}}
        @if ($quiz->time_limit_per_quiz)
            <div class="bg-gray-800 p-4 rounded-lg mb-6 text-center">
                <p class="text-xl font-semibold mb-2">Waktu Quiz Tersisa:</p>
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
        data-question-cache='@json($questionsForCache)'
        >
            {{-- Soal akan dimuat di sini oleh JavaScript --}}
            <div id="current-question-content">
                <p class="text-center text-lg mt-8">Memuat soal...</p>
                <div class="animate-pulse flex space-x-4 mt-4">
                    <div class="flex-1 space-y-4 py-1">
                        <div class="h-4 bg-gray-700 rounded w-3/4 mx-auto"></div>
                        <div class="h-4 bg-gray-700 rounded w-1/2 mx-auto"></div>
                        <div class="h-4 bg-gray-700 rounded w-5/6 mx-auto"></div>
                    </div>
                </div>
            </div>
            <div class="mt-6 text-center text-gray-400 text-sm">
                Soal <span id="question-number" class="font-bold">1</span> dari <span id="total-questions" class="font-bold"></span>
            </div>
        </div>

        <div class="flex justify-between mt-8 gap-4">
            {{-- Tombol Previous --}}
            <button type="button" id="prev-question-btn" class="bg-gray-700 hover:bg-gray-600 text-white px-6 py-3 rounded-lg shadow-md transition duration-300 ease-in-out">
                <i class="fas fa-arrow-left mr-2"></i> Sebelumnya
            </button>
            
            {{-- Placeholder untuk navigasi nomor soal --}}
            <div id="question-pagination" class="flex-grow flex justify-center items-center space-x-2">
                {{-- Nomor-nomor soal akan dirender di sini --}}
            </div>

            {{-- Tombol Next / Selesai --}}
            <button type="button" id="next-question-btn" class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-lg shadow-md transition duration-300 ease-in-out flex items-center">
                Selanjutnya <i class="fas fa-arrow-right ml-2"></i>
            </button>
        </div>
    </div>

    @push('scripts') 
        @vite('resources/js/quiz_attempt.js')
    @endpush
    
</x-app-layout>