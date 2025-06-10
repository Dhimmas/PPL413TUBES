<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Quiz;
use App\Models\Question;
use App\Models\UserQuizResult;
use App\Models\QuizAnswers;
use Illuminate\Support\Facades\Auth;

class UserQuizController extends Controller
{
    public function index() {
        $quizzes = Quiz::all();
        return view('quiz.index', compact('quizzes'));
    }

    public function attempt(Quiz $quiz)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Anda harus login untuk mengikuti quiz.');
        }
        if ($quiz->questions->isEmpty()) {
            return redirect()->back()->with('error', 'Quiz ini belum memiliki pertanyaan.');
        }

        $user = Auth::user();
        $result = UserQuizResult::where('user_id', $user->id)
                                ->where('quiz_id', $quiz->id)
                                ->where('status', 'in_progress')
                                ->first();

        // Siapkan variabel di luar blok if/else
        $questionsForCache = collect(); 
        $totalQuestions = $quiz->questions()->count();

        if ($result) { // Lanjutkan kuis
            if ($result->ends_at && now()->isAfter($result->ends_at)) {
                $finalScore = $this->calculateScore($result);
                $result->update([
                    'score' => $finalScore,
                    'finished_at' => $result->ends_at,
                    'status' => 'completed'
                ]);
                return redirect()->route('quiz.result', ['quiz' => $quiz->id])
                                ->with('info', 'Waktu pengerjaan quiz telah habis.');
            }
            
            $resultId = $result->id;
            $timeRemaining = $result->ends_at ? now()->diffInSeconds($result->ends_at, false) : null;
            if ($timeRemaining < 0) $timeRemaining = 0;
            
            $userAnswers = $result->answers->pluck('user_answer', 'question_id')->toArray();
        
            $answeredQuestionIds = $result->answers->pluck('question_id')->toArray();

            if ($result->last_question_id && !in_array($result->last_question_id, $answeredQuestionIds)) {
                $answeredQuestionIds[] = $result->last_question_id;
            }
            
            if (empty($answeredQuestionIds)) {
                $initialQuestion = $quiz->questions()->orderBy('id', 'asc')->first();
                $questionsForCache = collect([$initialQuestion]); // Gunakan collect() agar konsisten
            } else {
                $questionsForCache = Question::whereIn('id', $answeredQuestionIds)->orderBy('id', 'asc')->get();
            }
            
            $initialQuestion = $result->last_question_id 
                            ? $questionsForCache->firstWhere('id', $result->last_question_id) 
                            : $questionsForCache->first();

        } else { // Mulai kuis baru
            $result = UserQuizResult::create([
                'user_id' => $user->id,
                'quiz_id' => $quiz->id,
                'status' => 'in_progress',
                'started_at' => now(),
                'ends_at' => $quiz->time_limit_per_quiz ? now()->addMinutes($quiz->time_limit_per_quiz) : null,
            ]);

            $resultId = $result->id;
            $initialQuestion = $quiz->questions()->orderBy('id', 'asc')->first();
            $userAnswers = [];
            $timeRemaining = $quiz->time_limit_per_quiz ? $quiz->time_limit_per_quiz * 60 : null;

            if ($initialQuestion) {
                $questionsForCache = collect([$initialQuestion]);
            }
        }
        
        if (!$initialQuestion) {
            return redirect()->back()->with('error', 'Gagal memuat pertanyaan kuis.');
        }
        
        // Logika untuk menambahkan 'question_number' ke semua soal yang akan dikirim
        $allQuestionIds = $quiz->questions()->orderBy('id', 'asc')->pluck('id')->all();
        
        $questionsForCache->each(function($q) use ($allQuestionIds) {
            $q->question_number = array_search($q->id, $allQuestionIds) + 1;
        });

        $initialQuestion->question_number = array_search($initialQuestion->id, $allQuestionIds) + 1;

        return view('quiz.attempt', [
            'quiz' => $quiz, 
            'resultId' => $resultId, 
            'initialQuestion' => $initialQuestion,
            'totalQuestions' => $totalQuestions, 
            'timeRemaining' => $timeRemaining, 
            'userAnswers' => $userAnswers,
            'questionsForCache' => $questionsForCache
        ]);
    }

    public function submitAnswer(Request $request, Quiz $quiz)
    {
        $request->validate([
            'question_id' => 'required|exists:questions,id',
            'user_answer' => 'nullable|string|max:5000',
            'result_id' => 'required|exists:user_quiz_results,id',
        ]);

        $result = UserQuizResult::find($request->result_id);
        $question = Question::find($request->question_id);
        $user = auth()->user();

        if (!$result || $result->user_id !== $user->id || $result->status !== 'in_progress') {
            return response()->json(['message' => 'Sesi kuis tidak valid atau sudah selesai.'], 403);
        }

        $isCorrect = false;
        if ($question->question_type === 'multiple_choice' && $request->user_answer !== null) {
            $isCorrect = strtolower($request->user_answer) === strtolower($question->correct_answer);
        } elseif (($question->question_type === 'essay' || $question->question_type === 'file_based') && $request->user_answer !== null) {
            $keywords = explode(',', strtolower($question->correct_answer));
            if (count(array_filter($keywords, fn($k) => str_contains(strtolower($request->user_answer), trim($k)))) > 0) {
                $isCorrect = true;
            }
        }

        QuizAnswers::updateOrCreate(
            ['quiz_result_id' => $result->id, 'question_id' => $question->id],
            ['user_answer' => $request->user_answer, 'is_correct' => $isCorrect]
        );

        $result->update(['last_question_id' => $question->id]);
        
        // HANYA MENGEMBALIKAN STATUS SUKSES. TIDAK ADA KODE LAIN SETELAH INI.
        return response()->json(['status' => 'saved']);
    }

    private function calculateScore(UserQuizResult $result)
    {
        $score = 0;
        foreach ($result->answers as $answer) {
            if ($answer->is_correct) {
                $score++;
            }
        }
        return $score;
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
    public function getQuestionByNumber(Quiz $quiz, $questionNumber)
    {
        $allQuestionIds = $quiz->questions()->orderBy('id','asc')->pluck('id');

        $questionId = $allQuestionIds->get($questionNumber - 1);

        if (!$questionId) {
            return response()-> json(['message' => 'soal tidak ditemukan'], 404);
        }
        $question = Question::find($questionId);

        $question->question_number = (int)$questionNumber;

        return response()->json($question);
    }

    public function finalizeQuiz(UserQuizResult $result)
    {
        // Pastikan hanya user yang berhak yang bisa menyelesaikan
        if ($result->user_id !== auth()->id() || $result->status !== 'in_progress') {
            return response()->json(['message' => 'Tidak diizinkan'], 403);
        }

        $finalScore = $this->calculateScore($result);
        $result->update([
            'score' => $finalScore,
            'status' => 'completed',
            'finished_at' => now(),
        ]);

        return response()->json(['status' => 'quiz_completed', 'redirect_url' => route('quiz.result', $result->quiz_id)]);
    }
}
