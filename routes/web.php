<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ForumController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\Admin\QuizController;
use App\Http\Controllers\Admin\QuestionController;
use App\Http\Controllers\UserQuizController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TodoController;

// Redirect root ke dashboard
Route::get('/', function () {
    return redirect()->route('dashboard');
});

// Redirect root ke welcome
Route::get('/', function () {
    return view('welcome');
});


// Semua route ini hanya bisa diakses setelah login & email terverifikasi
Route::middleware(['auth', 'verified'])->group(function () {

    // Dashboard saja, tanpa forum
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Halaman statis
    Route::view('/to-do', 'maintenance')->name('to_do');
    Route::view('/goals', 'maintenance')->name('goals');
    Route::view('/progress', 'maintenance')->name('progress');

    // Halaman index forum
    Route::get('/forum', [ForumController::class, 'index'])->name('forum.index');

    // Route lainnya untuk CRUD forum
    Route::get('/forum/create', [ForumController::class, 'create'])->name('forum.create');
    Route::post('/forum', [ForumController::class, 'store'])->name('forum.store'); // Perbaikan: Menggunakan '/forum' untuk store
    Route::get('/forum/{id}', [ForumController::class, 'show'])->name('forum.show');
    Route::get('/forum/{id}/edit', [ForumController::class, 'edit'])->name('forum.edit');
    Route::put('/forum/{id}', [ForumController::class, 'update'])->name('forum.update');
    Route::delete('/forum/{id}', [ForumController::class, 'destroy'])->name('forum.destroy');
    Route::post('/forum/{post}/comment', [ForumController::class, 'storeComment'])->name('forum.comment.store');


    // Profile
    Route::middleware('auth')->group(function () {
        Route::post('/profile', [ProfileController::class, 'store'])->name('profile.add');
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });

    // Chatbot Route
    Route::get('/chatbot', function () {
        return view('maintenance'); // Pastikan view ini ada
    })->name('chatbot');

    // Quiz Route
    Route::get('/quiz', [QuizController::class, 'index'])->name('quiz.index');
    Route::get('/quiz/{quiz}/attempt', [UserQuizController::class, 'attempt'])->name('quiz.attempt');
    Route::post('/quiz/{quiz}/attempt', [UserQuizController::class, 'submit'])->name('quiz.attempt.store');
    Route::post('/quiz/result', [QuizController::class, 'result'])->name('quiz.result');
    
    // To Do
    Route::prefix('todos')->group(function () {
        Route::get('/', [TodoController::class, 'index'])->name('todos.index');
        Route::post('/', [TodoController::class, 'store'])->name('todos.store');
        Route::put('/{task}', [TodoController::class, 'update'])->name('todos.update');
        Route::delete('/{task}', [TodoController::class, 'destroy'])->name('todos.destroy');
    });
});

//Route Admin
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::resource('quiz', QuizController::class);
    // Nested resource khusus untuk soal di dalam quiz
    Route::get('quiz/{quiz}/questions/create', [QuestionController::class, 'create'])->name('questions.create');
    Route::post('quiz/{quiz}/questions', [QuestionController::class, 'store'])->name('questions.store');
});

    Route::fallback(function () {
    return view('404page');
    });
// Autentikasi
require __DIR__.'/auth.php';
