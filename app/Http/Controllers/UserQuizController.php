<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use Illuminate\Http\Request;

class UserQuizController extends Controller
{
    public function index() {
        $quizzes = Quiz::all();
        return view('quiz.index', compact('quizzes'));
    }
    public function attempt(Quiz $quiz) {
        return view('quiz.attempt', compact('quiz'));
    }

    public function submit(Request $request, Quiz $quiz) {
        // proses simpan jawaban
        return redirect()->route('quiz.result');
    }

    public function result(Request $request) {
        // tampilkan hasil quiz
        return view('quiz.result');
    }
}
