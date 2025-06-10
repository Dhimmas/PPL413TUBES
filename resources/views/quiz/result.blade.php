<x-app-layout>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Quiz - {{ $result->quiz->title }}</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        dark: {
                            900: '#121212',
                            800: '#1e1e1e',
                            700: '#2d2d2d',
                            600: '#3d3d3d',
                        },
                        primary: {
                            600: '#7e22ce',
                            500: '#8b5cf6',
                        },
                        success: '#10b981',
                        error: '#ef4444',
                    }
                }
            }
        }
    </script>
    <style>
        .score-circle-bg {
            stroke: #2d2d2d;
        }
        .score-circle-progress {
            stroke: rgba(139, 92, 246, 0.5);
        }
        .glow {
            box-shadow: 0 0 15px rgba(139, 92, 246, 0.5);
        }
        .pulse {
            animation: pulse 2s infinite;
        }
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.03); }
            100% { transform: scale(1); }
        }
        .fade-in {
            animation: fadeIn 0.8s ease-in;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .card-hover {
            transition: all 0.3s ease;
        }
        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
        }
    </style>
</head>
<body class="bg-dark-900 text-gray-200 min-h-screen">
    @php
        $totalQuestions = $result->answers->count();
        $correctAnswers = $result->score;
        $wrongAnswers = $totalQuestions - $correctAnswers;
        $percentage = $totalQuestions > 0 ? ($correctAnswers / $totalQuestions) * 100 : 0;
        $progress = $totalQuestions > 0 ? ($correctAnswers / $totalQuestions) * 283 : 0;
    @endphp

    <div class="container mx-auto px-4 py-8 max-w-4xl">
        <div class="bg-gray-800 border border-gray-700 rounded-2xl shadow-2xl p-8 mb-8 text-center transform hover:-translate-y-1 transition-transform duration-300">
            <h1 class="text-4xl font-extrabold text-white mb-2">Hasil Quiz: <span class="text-purple-400">{{ $result->quiz->title }}</span></h1>
            <p class="mt-4 text-gray-300">
                <i class="far fa-calendar mr-2"></i> 
                {{ $result->created_at->format('d M Y H:i') }}
            </p>
        </div>

        @if($totalQuestions > 0)
            <!-- Score Summary -->
            <div class="bg-dark-800 rounded-xl shadow-xl overflow-hidden mb-8 card-hover fade-in">
                <div class="p-6">
                    <div class="flex flex-col md:flex-row justify-between items-center">
                        <div class="text-center md:text-left mb-6 md:mb-0">
                            <h2 class="text-2xl font-bold text-white mb-2">Ringkasan Hasil</h2>
                            <p class="text-gray-400">Lihat performa kamu dalam quiz ini</p>
                        </div>
                        
                        <div class="relative">
                            <!-- Score Circle -->
                            <div class="relative w-40 h-40">
                                <svg class="w-full h-full" viewBox="0 0 100 100">
                                    <!-- Background circle -->
                                    <circle cx="50" cy="50" r="45" fill="none" class="score-circle-bg" stroke-width="8" />
                                    <!-- Progress circle -->
                                    <circle cx="50" cy="50" r="45" fill="none" 
                                        class="score-circle-progress"
                                        stroke-width="8" 
                                        stroke-dasharray="{{ $progress }} 283" 
                                        stroke-linecap="round" 
                                        transform="rotate(-90 50 50)" />
                                </svg>
                                <div class="absolute inset-0 flex flex-col items-center justify-center">
                                    <span class="text-3xl font-bold text-white">{{ $correctAnswers }}/{{ $totalQuestions }}</span>
                                    <span class="text-gray-400 mt-1">Skor</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Stats -->
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-8">
                        <div class="bg-dark-700 p-4 rounded-lg text-center card-hover">
                            <div class="text-2xl font-bold text-green-400">{{ $correctAnswers }}</div>
                            <div class="text-gray-400">Jawaban Benar</div>
                        </div>
                        <div class="bg-dark-700 p-4 rounded-lg text-center card-hover">
                            <div class="text-2xl font-bold text-red-400">{{ $wrongAnswers }}</div>
                            <div class="text-gray-400">Jawaban Salah</div>
                        </div>
                        <div class="bg-dark-700 p-4 rounded-lg text-center card-hover">
                            <div class="text-2xl font-bold text-white">{{ $totalQuestions }}</div>
                            <div class="text-gray-400">Total Pertanyaan</div>
                        </div>
                        <div class="bg-dark-700 p-4 rounded-lg text-center card-hover">
                            <div class="text-2xl font-bold text-primary-500">{{ number_format($percentage, 1) }}%</div>
                            <div class="text-gray-400">Persentase</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Performance Feedback -->
            <div class="bg-dark-800 rounded-xl shadow-xl overflow-hidden mb-8 card-hover fade-in">
                <div class="p-6">
                    <h2 class="text-xl font-bold text-white mb-4">
                        <i class="fas fa-comment-alt text-primary-500 mr-2"></i> 
                        Feedback Performa
                    </h2>
                    <div class="flex items-start bg-dark-700 p-5 rounded-lg">
                        <div class="mr-4 mt-1 text-primary-500">
                            <i class="fas fa-lightbulb text-2xl"></i>
                        </div>
                        <div>
                            @php
                                $performanceRatio = $percentage / 100;
                            @endphp
                            
                            @if($performanceRatio >= 0.8)
                                <p class="font-bold text-green-400 text-lg">Luar Biasa! <i class="fas fa-star ml-1 text-yellow-400"></i></p>
                                <p class="text-gray-300 mt-3">Kamu menguasai materi ini dengan sangat baik! Hasil ini menunjukkan pemahaman yang mendalam tentang topik yang diujikan. Pertahankan semangat belajarmu dan teruslah mengasah kemampuanmu.</p>
                            @elseif($performanceRatio >= 0.6)
                                <p class="font-bold text-primary-500 text-lg">Bagus! <i class="fas fa-thumbs-up ml-1"></i></p>
                                <p class="text-gray-300 mt-3">Hasil yang cukup baik! Kamu sudah memahami sebagian besar materi, tetapi masih ada beberapa area yang bisa ditingkatkan. Tinjau kembali materi yang sulit dan coba quiz lagi untuk hasil yang lebih baik.</p>
                            @else
                                <p class="font-bold text-purple-400 text-lg">Tetap Semangat! <i class="fas fa-heart ml-1 text-red-400"></i></p>
                                <p class="text-gray-300 mt-3">Jangan menyerah! Setiap kesalahan adalah kesempatan untuk belajar. Tinjau jawaban yang salah, pelajari kembali materinya, dan coba quiz sekali lagi. Kamu pasti bisa meningkat!</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Answers Review -->
            <div class="bg-dark-800 rounded-xl shadow-xl overflow-hidden mb-8 card-hover fade-in">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-xl font-bold text-white">
                            <i class="fas fa-file-alt text-primary-500 mr-2"></i>
                            Review Jawaban
                        </h2>
                        <div class="flex items-center">
                            <span class="bg-green-500 w-3 h-3 rounded-full mr-2"></span>
                            <span class="text-white mr-4">Benar</span>
                            <span class="bg-red-500 w-3 h-3 rounded-full mr-2"></span>
                            <span class="text-white">Salah</span>
                        </div>
                    </div>
                    
                    <div class="space-y-6">
                        @foreach($result->answers as $answer)
                        <div class="border-l-4 p-5 rounded-r-lg {{ $answer->is_correct ? 'border-green-500 bg-dark-700' : 'border-red-500 bg-dark-700' }}">
                            <div class="flex flex-col md:flex-row justify-between">
                                <h3 class="font-semibold text-white mb-2 md:mb-0">
                                    <span class="text-primary-500">#{{ $loop->iteration }}.</span> 
                                    {{ $answer->question->question_text }}
                                </h3>
                                <div class="flex items-center">
                                    @if($answer->is_correct)
                                        <span class="bg-green-900 text-green-300 px-3 py-1 rounded-full text-sm flex items-center">
                                            <i class="fas fa-check mr-2"></i> Benar
                                        </span>
                                    @else
                                        <span class="bg-red-900 text-red-300 px-3 py-1 rounded-full text-sm flex items-center">
                                            <i class="fas fa-times mr-2"></i> Salah
                                        </span>
                                    @endif
                                </div>
                            </div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-5">
                                <div>
                                    <p class="text-gray-400 font-medium">
                                        <i class="fas fa-user mr-2"></i> Jawaban Kamu:
                                    </p>
                                    <p class="mt-2 p-3 rounded-lg bg-dark-600 border {{ $answer->is_correct ? 'border-green-500 text-green-300' : 'border-red-500 text-red-300' }}">
                                        {{ $answer->user_answer }}
                                    </p>
                                </div>
                                @if(!$answer->is_correct)
                                <div>
                                    <p class="text-gray-400 font-medium">
                                        <i class="fas fa-check-circle mr-2"></i> Jawaban Benar:
                                    </p>
                                    <p class="mt-2 p-3 rounded-lg bg-dark-600 border border-green-500 text-green-300">
                                        {{ $answer->question->correct_answer }}
                                    </p>
                                </div>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row justify-between gap-4 mb-8 fade-in">
                <a href="{{ route('quiz.index') }}" class="flex-1 bg-dark-700 hover:bg-dark-600 text-white font-bold py-3 px-4 rounded-lg shadow-lg text-center transition duration-300 flex items-center justify-center card-hover">
                    <i class="fas fa-arrow-left mr-3"></i> Kembali ke Daftar Quiz
                </a>
                @if($performanceRatio < 0.8)
                <a href="{{ route('quiz.attempt', $result->quiz->id) }}" class="flex-1 bg-gradient-to-r from-primary-600 to-purple-600 hover:opacity-90 text-white font-bold py-3 px-4 rounded-lg shadow-lg text-center transition duration-300 flex items-center justify-center card-hover">
                    <i class="fas fa-redo mr-3"></i> Coba Lagi
                </a>
                @endif
                <a href="#" class="flex-1 bg-dark-700 hover:bg-dark-600 text-white font-bold py-3 px-4 rounded-lg shadow-lg text-center transition duration-300 flex items-center justify-center card-hover">
                    <i class="fas fa-download mr-3"></i> Download Hasil
                </a>
            </div>
        @else
            <!-- No Questions/Answers Found -->
            <div class="bg-dark-800 rounded-xl shadow-xl overflow-hidden mb-8 card-hover fade-in">
                <div class="p-8 text-center">
                    <i class="fas fa-exclamation-triangle text-yellow-400 text-6xl mb-4"></i>
                    <h2 class="text-2xl font-bold text-white mb-4">Tidak Ada Data Quiz</h2>
                    <p class="text-gray-400 mb-6">Quiz ini belum memiliki jawaban yang tercatat.</p>
                    <div class="flex flex-col sm:flex-row justify-between gap-4 mb-8 fade-in">
                        <a href="{{ route('quiz.index') }}" class="flex-1 bg-dark-700 hover:bg-dark-600 text-white font-bold py-3 px-4 rounded-lg shadow-lg text-center transition duration-300 flex items-center justify-center card-hover">
                            <i class="fas fa-arrow-left mr-3"></i> Kembali ke Daftar Quiz
                        </a>
                        <a href="{{ route('quiz.attempt', $result->quiz->id) }}" class="flex-1 bg-gradient-to-r from-primary-600 to-purple-600 hover:opacity-90 text-white font-bold py-3 px-4 rounded-lg shadow-lg text-center transition duration-300 flex items-center justify-center card-hover">
                            <i class="fas fa-redo mr-3"></i> Coba Lagi
                        </a>
                    </div>
                </div>
            </div>
        @endif
        
        <!-- Footer -->
        <div class="text-center text-gray-500 text-sm mt-12 pb-6">
            <p class="mt-2">
                <i class="fas fa-shield-alt mr-2"></i> 
                Hasil quiz ini bersifat pribadi dan hanya dapat diakses oleh kamu
            </p>
        </div>
    </div>
</body>
</x-app-layout>