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
            // Validasi umum
            $validated = \Validator::make($questionData, [
                'question_type' => 'required|in:multiple_choice,essay,file_based',
                'question_text' => 'required|string',
                'correct_option' => 'nullable|numeric',
                'options' => 'nullable|array',
                'options.*' => 'nullable|string',
                'correct_answer' => 'nullable|string',
            ])->validate();

            $data = [
                'quiz_id' => $quiz->id,
                'question_type' => $questionData['question_type'],
                'question_text' => $questionData['question_text'] ?? null,
            ];

            // Tangani file soal (jika ada)
            if ($request->hasFile("questions.$index.question_file")) {
                $file = $request->file("questions.$index.question_file");
                $data['question_file'] = $file->store('questions/files', 'public');
                $data['file_type'] = $file->getClientOriginalExtension();
            }

            // Tangani gambar soal (jika ada)
            if ($request->hasFile("questions.$index.image")) {
                $image = $request->file("questions.$index.image");
                $data['image'] = $image->store('questions/images', 'public');
            }

            // Tangani sesuai tipe soal
            switch ($questionData['question_type']) {
                case 'multiple_choice':
                    $options = $questionData['options'] ?? [];
                    $correctIndex = $questionData['correct_option'];

                    if (!is_array($options) || !isset($options[$correctIndex])) {
                        return back()->withErrors([
                            "questions.$index.correct_option" => "Jawaban benar tidak valid pada soal ke-" . ($index + 1)
                        ])->withInput();
                    }

                    $data['options'] = $options;
                    $data['correct_answer'] = $options[$correctIndex];
                    break;

                case 'essay':
                case 'file_based':
                    $data['correct_answer'] = $questionData['correct_answer'] ?? null;
                    break;
            }

            // Simpan ke database
            Question::create($data);
        }

        return redirect()->route('admin.quiz.index')->with('success', 'Semua soal berhasil ditambahkan!');
    }
    public function Destroy(string $id)
    {
        $questions = Question::findOrFail($id);
        $questions -> delete();
        
        return redirect()->route('admin.quiz.index')->with('success', 'Soal berhasil dihapus!');
    }
}