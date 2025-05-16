<?php

namespace App\Http\Controllers\Admin;

use App\Models\Quiz;
use App\Models\Question;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class QuestionController extends Controller
{
    public function create(Quiz $quiz)
    {
        return view('admin.questions.create', compact('quiz'));
    }
    
    public function store(Request $request, Quiz $quiz)
    {
        $questions = $request->input('questions');

        if (!$questions || !is_array($questions)) {
            return back()->withErrors(['questions' => 'Data soal tidak valid'])->withInput();
        }

        foreach ($questions as $index => $questionData) {
            // Validasi manual tiap soal
            $validated = \Validator::make($questionData, [
                'question_text' => 'nullable|string',
                'correct_option' => 'required|numeric',
                'options' => 'nullable|array',
                'options.*' => 'nullable|string',
            ])->validate();

            $data = [
                'quiz_id' => $quiz->id,
                'question_text' => $questionData['question_text'] ?? null,
            ];

            // Tangani file & image
            if ($request->hasFile("questions.$index.question_file")) {
                $file = $request->file("questions.$index.question_file");
                $data['question_file'] = $file->store('questions/files', 'public');
                $data['file_type'] = $file->getClientOriginalExtension();
            }

            if ($request->hasFile("questions.$index.image")) {
                $image = $request->file("questions.$index.image");
                $data['image'] = $image->store('questions/images', 'public');
            }

            // Simpan options dan jawaban benar
            $options = $questionData['options'] ?? [];
            $correctIndex = $questionData['correct_option'];

            if (is_array($options) && isset($options[$correctIndex])) {
                $data['options'] = json_encode($options);
                $data['correct_answer'] = $options[$correctIndex];
            } else {
                return back()->withErrors([
                    "questions.$index.correct_option" => "Jawaban benar tidak valid pada soal ke-" . ($index + 1)
                ])->withInput();
            }

            // Simpan ke database
            Question::create($data);
        }

        return redirect()->route('admin.quiz.index')->with('success', 'Semua soal berhasil ditambahkan!');
    }
}