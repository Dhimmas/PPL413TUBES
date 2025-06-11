<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- Activity Overview Section -->
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <header>
                        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                            {{ __('Activity Overview') }}
                        </h2>
                        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                            {{ __('Your quiz activity and progress summary.') }}
                        </p>
                    </header>

                    <!-- Quiz Statistics Grid -->
                    <div class="mt-6 grid grid-cols-2 md:grid-cols-4 gap-4">
                        <!-- Total Quizzes Available -->
                        <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg text-center">
                            <div class="text-2xl font-bold text-blue-600 dark:text-blue-400">
                                {{ $quizStats['total_available_quizzes'] }}
                            </div>
                            <div class="text-sm text-gray-600 dark:text-gray-300 mt-1">
                                Total Quiz
                            </div>
                        </div>

                        <!-- Completed Quizzes -->
                        <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg text-center">
                            <div class="text-2xl font-bold text-green-600 dark:text-green-400">
                                {{ $quizStats['completed_quizzes'] }}
                            </div>
                            <div class="text-sm text-gray-600 dark:text-gray-300 mt-1">
                                Selesai
                            </div>
                        </div>

                        <!-- In Progress -->
                        <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg text-center">
                            <div class="text-2xl font-bold text-yellow-600 dark:text-yellow-400">
                                {{ $quizStats['in_progress_quizzes'] }}
                            </div>
                            <div class="text-sm text-gray-600 dark:text-gray-300 mt-1">
                                Berlangsung
                            </div>
                        </div>

                        <!-- Average Score -->
                        <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg text-center">
                            <div class="text-2xl font-bold text-purple-600 dark:text-purple-400">
                                {{ $quizStats['average_score'] }}
                            </div>
                            <div class="text-sm text-gray-600 dark:text-gray-300 mt-1">
                                Rata-rata Skor
                            </div>
                        </div>
                    </div>

                    <!-- Completion Rate -->
                    <div class="mt-6">
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-sm font-medium text-gray-700 dark:text-gray-300">
                                Progress Completion
                            </span>
                            <span class="text-sm text-gray-500 dark:text-gray-400">
                                {{ $quizStats['completion_rate'] }}%
                            </span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2.5 dark:bg-gray-700">
                            <div class="bg-blue-600 h-2.5 rounded-full transition-all duration-300" 
                                 style="width: {{ $quizStats['completion_rate'] }}%"></div>
                        </div>
                    </div>

                    <!-- Recent Completed Quizzes -->
                    @if($quizStats['recent_completed_quizzes']->count() > 0)
                    <div class="mt-6">
                        <h3 class="text-md font-medium text-gray-900 dark:text-gray-100 mb-3">
                            Quiz Terbaru yang Diselesaikan
                        </h3>
                        <div class="space-y-2">
                            @foreach($quizStats['recent_completed_quizzes'] as $result)
                            <div class="flex justify-between items-center p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                <div>
                                    <div class="font-medium text-gray-900 dark:text-gray-100">
                                        {{ $result->quiz->title }}
                                    </div>
                                    <div class="text-sm text-gray-500 dark:text-gray-400">
                                        {{ $result->finished_at->format('d M Y') }}
                                    </div>
                                </div>
                                <div class="text-right">
                                    <div class="font-bold text-green-600 dark:text-green-400">
                                        {{ $result->score }}/{{ $result->quiz->questions->count() }}
                                    </div>
                                    <div class="text-sm text-gray-500 dark:text-gray-400">
                                        {{ round(($result->score / $result->quiz->questions->count()) * 100, 1) }}%
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        <div class="mt-3">
                            <a href="{{ route('quiz.index') }}" 
                               class="text-blue-600 dark:text-blue-400 hover:text-blue-500 text-sm font-medium">
                                Lihat Semua Quiz →
                            </a>
                        </div>
                    </div>
                    @endif

                    <!-- Suggested Quizzes -->
                    @if($uncompletedQuizzes->count() > 0)
                    <div class="mt-6">
                        <h3 class="text-md font-medium text-gray-900 dark:text-gray-100 mb-3">
                            Quiz yang Belum Dikerjakan
                        </h3>
                        <div class="space-y-2">
                            @foreach($uncompletedQuizzes as $quiz)
                            <div class="flex justify-between items-center p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                <div>
                                    <div class="font-medium text-gray-900 dark:text-gray-100">
                                        {{ $quiz->title }}
                                    </div>
                                    <div class="text-sm text-gray-500 dark:text-gray-400">
                                        {{ $quiz->category?->name ?? 'Tidak Berkategori' }} • {{ $quiz->questions_count }} soal
                                    </div>
                                </div>
                                <a href="{{ route('quiz.attempt', $quiz->id) }}" 
                                   class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition duration-200">
                                    Mulai
                                </a>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Profile Information Section -->
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <!-- Update Password Section -->
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <!-- Delete Account Section -->
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
