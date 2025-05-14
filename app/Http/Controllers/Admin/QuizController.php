<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Quiz;
use App\Models\Category;

class QuizController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $quizzes = Quiz::with('category')->get();
        return view('quiz.index', compact('quizzes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('admin.quiz.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|url',
            'category_id' => 'nullable|exists:categories,id',
            'new_category' => 'nullable|string|max:255|unique:categories,name'
        ]);

        // Handle kategori baru
        if (!empty($validated['new_category'])) {
            $category = Category::create(['name' => $validated['new_category']]);
            $validated['category_id'] = $category->id;
        }

        // Pastikan category_id ada
        if (empty($validated['category_id'])) {
            return back()->withErrors(['category' => 'Pilih kategori atau buat baru'])->withInput();
        }

        Quiz::create($validated);
        
        return redirect()->route('admin.quiz.index')->with('success', 'Quiz berhasil dibuat!');
    } 

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $quiz = Quiz::findOrFail($id);
        $categories = Category::all();
        return view('admin.quiz.edit', compact('quiz', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'title' => 'required',
            'description' => 'nullable',
            'image' => 'nullable|url',
            'category_id' => 'required|exists:categories,id',
        ]);
        $quiz = Quiz::findOrFail($id);
        $quiz->update($validated);

        return redirect()->route('quiz.index')->with('success', 'quiz berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $quiz = Quiz::findOrFail($id);
        $quiz->delete();
        return redirect()->route('quiz.index')->with('success', 'Quiz berhasil dihapus');
    }
}
