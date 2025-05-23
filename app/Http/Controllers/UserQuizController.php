<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\Question;
use App\Models\UserQuizResult;
use App\Models\QuizAnswers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserQuizController extends Controller
{
    public function index() {
        $quizzes = Quiz::all();
        return view('quiz.index', compact('quizzes'));
    }
    public function attempt(Quiz $quiz) {
        return view('quiz.attempt', compact('quiz'));
    }

    public function submit(Request $request, $quizId)
    {
        $quiz = Quiz::with('questions')->findOrFail($quizId);
        $user = Auth::user();

        $answers = $request->input('answers');
        $score = 0;
        $totalQuestions = $quiz->questions->count();

        $result = UserQuizResult::create([
            'user_id' => $user->id,
            'quiz_id' => $quiz->id,
            'score' => 0, // diupdate nanti
            'started_at' => now()->subMinutes(5),
            'finished_at' => now(),
        ]);

        foreach ($quiz->questions as $question) {
            $userAnswer = $answers[$question->id] ?? null;
            $isCorrect = false;

            if ($question->question_type === 'multiple_choice' && $userAnswer !== null) {
                $isCorrect = strtolower($userAnswer) === strtolower($question->correct_answer);
            }

            if ($isCorrect) {
                $score++;
            }

            QuizAnswers::create([
                'quiz_result_id' => $result->id,
                'question_id' => $question->id,
                'user_answer' => $userAnswer,
                'is_correct' => $isCorrect,
            ]);
        }

        $result->update(['score' => $score]);

        return redirect()->route('quiz.result', ['quiz' => $quiz->id])->with('success', "Quiz selesai! Skor kamu: $score/$totalQuestions");
    }
    public function result($quizId)
    {
        $user = Auth::user();
        
        $result = UserQuizResult::with(['quiz', 'answers.question'])
            ->where('quiz_id', $quizId)
            ->where('user_id', $user->id)
            ->latest()
            ->first();

        if (!$result) {
            return redirect()->route('dashboard')->with('error', 'Hasil quiz tidak ditemukan');
        }

        return view('quiz.result', compact('result'));
    }
}
