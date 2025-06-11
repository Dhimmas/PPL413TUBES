<?php

namespace App\Http\Controllers\Admin;

use App\Models\Quiz;
use App\Models\Question;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

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
                'time_limit_per_question' => 'nullable|integer|min:0'
            ])->validate();

            $data = [
                'quiz_id' => $quiz->id,
                'question_type' => $questionData['question_type'],
                'question_text' => $questionData['question_text'] ?? null,
                'time_limit_per_question' => $questionData['time_limit_per_question'] ?? null,
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

        if ($quiz->time_limit_per_quiz === null) {
            $totalTimeFromQuestions = $quiz->questions->sum('time_limit_per_question');
            $quiz->update(['time_limit_per_quiz' => $totalTimeFromQuestions]);
        }
        return redirect()->route('admin.quiz.index')->with('success', 'Semua soal berhasil ditambahkan!');
    }
    public function Destroy(string $id)
    {
        $question = Question::findOrFail($id);
        $quiz = $question->quiz;
        $question->delete();

        if ($quiz->time_limit_per_quiz === null) {
            $totalTimeFromQuestions = $quiz->questions->sum('time_limit_per_question');
            $quiz->update(['time_limit_per_quiz' => $totalTimeFromQuestions]);
        }
        return redirect()->route('admin.quiz.index')->with('success', 'Soal berhasil dihapus!');
    }
    
    public function edit(Question $question)
    {
        return view('admin.questions.edit', compact('question'));
    }
    
    public function update(Request $request, Question $question)
    {
        $validated = $request->validate([
            'question_type' => 'required|in:multiple_choice,essay,file_based',
            'question_text' => 'required|string',
            'correct_option' => 'nullable|numeric',
            'options' => 'nullable|array',
            'options.*' => 'nullable|string',
            'correct_answer' => 'nullable|string',
            'time_limit_per_question' => 'nullable|integer|min:0'
        ]);

        $data = [
            'question_type' => $validated['question_type'],
            'question_text' => $validated['question_text'],
            'time_limit_per_question' => $validated['time_limit_per_question'] ?? null,
        ];

        // Handle file upload for question
        if ($request->hasFile('question_file')) {
            $file = $request->file('question_file');
            $data['question_file'] = $file->store('questions/files', 'public');
            $data['file_type'] = $file->getClientOriginalExtension();
        }

        // Handle image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $data['image'] = $image->store('questions/images', 'public');
        }

        // Handle based on question type
        switch ($validated['question_type']) {
            case 'multiple_choice':
                $options = $validated['options'] ?? [];
                $correctIndex = $validated['correct_option'];

                if (!is_array($options) || !isset($options[$correctIndex])) {
                    return back()->withErrors([
                        'correct_option' => 'Jawaban benar tidak valid'
                    ])->withInput();
                }

                $data['options'] = $options;
                $data['correct_answer'] = $options[$correctIndex];
                break;

            case 'essay':
            case 'file_based':
                $data['correct_answer'] = $validated['correct_answer'] ?? null;
                break;
        }

        $question->update($data);

        // Update quiz time limit if needed
        $quiz = $question->quiz;
        if ($quiz->time_limit_per_quiz === null) {
            $totalTimeFromQuestions = $quiz->questions->sum('time_limit_per_question');
            $quiz->update(['time_limit_per_quiz' => $totalTimeFromQuestions]);
        }

        return redirect()->route('admin.quiz.show', $quiz)->with('success', 'Soal berhasil diperbarui!');
    }
    
    public function bulkUpdate(Request $request, Quiz $quiz)
    {
        $questions = $request->input('questions', []);
        foreach ($questions as $index => $qData) {
            if (isset($qData['id'])) {
                $question = $quiz->questions()->find($qData['id']);
                if ($question) {
                    $question->update([
                        'question_text' => $qData['question_text'],
                        'question_type' => $qData['question_type'],
                        'correct_answer' => $qData['correct_answer'],
                        'options' => isset($qData['options']) ? explode(',', $qData['options']) : null,
                    ]);
                }
            } else {
                // Tambah pertanyaan baru jika tidak ada id
                $quiz->questions()->create([
                    'question_text' => $qData['question_text'],
                    'question_type' => $qData['question_type'],
                    'correct_answer' => $qData['correct_answer'],
                    'options' => isset($qData['options']) ? explode(',', $qData['options']) : null,
                ]);
            }
        }
        return back()->with('success', 'Pertanyaan berhasil diperbarui!');
    }
}