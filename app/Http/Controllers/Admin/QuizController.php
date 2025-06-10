<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Quiz;
use App\Models\UserQuizResult;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class QuizController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Quiz::with('category')->withCount('questions');

        // Filter berdasarkan kategori
        // Menggunakan slug untuk filter
        if ($request->has('category') && $request->category != '') {
            $categorySlug = $request->category;
            $category = Category::where('slug', $categorySlug)->first();

            if ($category) {
                $query->where('category_id', $category->id);
            } else {
                // Jika slug kategori tidak valid, kita bisa mengabaikan filter atau memberikan pesan error khusus.
                // Untuk kasus ini, kita biarkan query berjalan tanpa filter kategori.
            }
        }

        // Filter berdasarkan pencarian judul
        if ($request->has('search') && $request->search != '') {
            $searchTerm = $request->search;
            $query->where('title', 'like', '%' . $searchTerm . '%');
        }

        // Logika untuk admin dan user biasa
        if (Auth::check() && Auth::user()->is_admin) {
            // Admin melihat semua quiz (kecuali difilter di atas)
        } else {
            // User biasa hanya melihat quiz yang memiliki soal
            $query->has('questions');
        }

        $quizzes = $query->paginate(9)->withQueryString(); // Tambahkan withQueryString() agar filter tetap aktif saat navigasi pagination

        $UserQuizStatuses = [];
        if (Auth::check()) {
            $UserQuizStatuses = Auth::user()->quizResults()->pluck('status','quiz_id')->toArray();
        }

        $categories = Category::all(); // Ambil semua kategori untuk dropdown filter

        // Mendapatkan kategori yang sedang aktif (jika ada)
        $currentCategory = $request->category ? Category::where('slug', $request->category)->first() : null;

        return view('quiz.index', compact('quizzes', 'UserQuizStatuses', 'categories', 'currentCategory'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.quiz.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'category_id' => 'nullable|exists:categories,id',
            'new_category' => 'nullable|string|max:255|unique:categories,name',
            'time_limit_per_quiz' => 'nullable|integer|min:1'
        ]);

        // Handle kategori baru
        if (!empty($validated['new_category'])) {
            $category = Category::create([
                'name' => $validated['new_category'],
                'slug' => Str::slug($validated['new_category'])
            ]);
            $validated['category_id'] = $category->id;
        }

        // Pastikan category_id ada
        if (empty($validated['category_id'])) {
            return back()->withErrors(['category' => 'Pilih kategori atau buat baru'])->withInput();
        }

        // Handle upload gambar
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('quiz_images', 'public');
        }

        $quiz = Quiz::create([
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'image' => $imagePath,
            'category_id' => $validated['category_id'],
            'time_limit_per_quiz' => $validated['time_limit_per_quiz'] ?? null,
        ]);
        
        return redirect()->route('admin.questions.create', $quiz->id)->with('success', 'Quiz berhasil dibuat. Sekarang tambahkan soal!');
    }

    public function edit(string $id)
    {
        $quiz = Quiz::findOrFail($id);
        $categories = Category::all();
        return view('admin.quiz.edit', compact('quiz', 'categories'));
    }

    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'title' => 'required',
            'description' => 'nullable',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'category_id' => 'required|exists:categories,id',
            'time_limit_per_quiz' => 'required|integer|min:1'
        ]);
        $quiz = Quiz::findOrFail($id);
        $quiz->update($validated);

        return redirect()->route('quiz.index')->with('success', 'quiz berhasil diperbarui');
    }
    public function show($id)
    {
        $quiz = Quiz::with('questions')->findOrFail($id);
        return view('admin.quiz.show', compact('quiz'));
    }

    public function destroy(string $id)
    {
        $quiz = Quiz::findOrFail($id);
        $quiz->delete();
        return redirect()->route('quiz.index')->with('success', 'Quiz berhasil dihapus');
    }
}
