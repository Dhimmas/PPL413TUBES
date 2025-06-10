<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ForumController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\Admin\QuizController;
use App\Http\Controllers\Admin\QuestionController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\UserQuizController;
use App\Http\Controllers\PomodoroController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\StudyGoalController;

// Redirect root ke dashboard
Route::get('/', function () {
    return redirect()->route('dashboard');
});

use Illuminate\Http\Request;
use App\Models\Conversation;
use App\Http\Controllers\TodoController;
use App\Http\Controllers\TaskController;


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


    // Profile routes
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'show'])->name('show');
        Route::get('/edit', [ProfileController::class, 'edit'])->name('edit');
        Route::post('/', [ProfileController::class, 'store'])->name('add');
        Route::patch('/', [ProfileController::class, 'update'])->name('update');
        Route::delete('/', [ProfileController::class, 'destroy'])->name('destroy');
    });

    // Route Chatbot
    //controller user
    Route::get('/chatbot', [ChatController::class, 'user_index'])->name('user.chatbot.index');
    Route::post('/chatbot', [ChatController::class, 'chat'])->name('chatbot.send_message');
    
    // To Do
    Route::get('/todos', [TodoController::class, 'index'])->name('todos.index');
    Route::post('/todos', [TodoController::class, 'store'])->name('todos.store');
    Route::put('/todos/{task}', [TodoController::class, 'update'])->name('todos.update');
    Route::delete('/todos/{task}', [TodoController::class, 'destroy'])->name('todos.destroy');
    Route::put('/todos/status/{task}', [TodoController::class, 'updateStatus'])->name('todos.updateStatus');
    Route::patch('/todos/completed/{task}', [TodoController::class, 'updateCompleted'])->name('todos.updateCompleted');
    Route::delete('/todos/{task}', [TodoController::class, 'destroy'])->name('todos.destroy');

    // Quiz Route
    Route::get('/quiz', [QuizController::class, 'index'])->name('quiz.index');
    Route::get('/quiz/{quiz}/attempt', [UserQuizController::class, 'attempt'])->name('quiz.attempt');
    Route::post('/quiz/{quiz}/submit-answer', [UserQuizController::class, 'submitAnswer'])->name('quiz.attempt.submitAnswer');
    Route::post('/quiz/result/{result}/finalize', [UserQuizController::class, 'finalizeQuiz'])->name('quiz.finalize');
    Route::get('/quiz/{quiz}/get-question/{questionNumber}', [UserQuizController::class, 'getQuestionByNumber'])->name('quiz.getQuestion');
    Route::get('/quiz/{quiz}/result', [UserQuizController::class, 'result'])->name('quiz.result');

    Route::get('/pomodoro', [PomodoroController::class, 'index'])->name('pomodoro.index');
    Route::post('/pomodoro', [PomodoroController::class, 'store'])->name('pomodoro.store');


    Route::get('/tasks', [TaskController::class, 'index'])->name('tasks.index');
    Route::post('/tasks', [TaskController::class, 'store']);
    Route::post('/tasks/{id}/status/{status}', [TaskController::class, 'updateStatus']);
});


//Route Admin
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::resource('quiz', QuizController::class);
    // Nested resource khusus untuk soal di dalam quiz
    Route::get('quiz/{quiz}/questions/create', [QuestionController::class, 'create'])->name('questions.create');
    Route::post('quiz/{quiz}/questions', [QuestionController::class, 'store'])->name('questions.store');
    // Rute untuk halaman riwayat chat
    Route::get('chatbot/chatbotz', [ChatController::class, 'index'])->name('chatbot.index');
    // Rute untuk mengirim pesan admin dan memperbarui respon chatbot
    Route::post('/chatbotz/chatbot/send', [ChatController::class, 'sendAndUpdateResponse'])->name('chatbot.send');
    // Rute untuk menghapus percakapan berdasarkan ID
    Route::delete('/chatbot/{id}', [ChatController::class, 'destroy'])->name('chatbot.destroy');
    // Rute untuk mengedit percakapan berdasarkan ID (dengan form)
    Route::get('/chatbot/{id}/edit', [ChatController::class, 'edit'])->name('chatbot.edit');
    // Rute untuk memperbarui percakapan berdasarkan ID
    Route::put('/chatbot/{id}', [ChatController::class, 'update'])->name('chatbot.update');
});

    Route::fallback(function () {
    return view('404page');
    });
// Autentikasi

require __DIR__.'/auth.php';

//studygoals
Route::get('study-goals', [StudyGoalController::class, 'index'])->name('study-goals.index');
Route::get('study-goals/create', [StudyGoalController::class, 'create'])->name('study-goals.create');
Route::post('study-goals', [StudyGoalController::class, 'store'])->name('study-goals.store');
Route::get('study-goals/{id}/edit', [StudyGoalController::class, 'edit'])->name('study-goals.edit');
Route::put('study-goals/{id}', [StudyGoalController::class, 'update'])->name('study-goals.update');
Route::delete('study-goals/{id}', [StudyGoalController::class, 'destroy'])->name('study-goals.destroy');
Route::get('study-goals/today', [StudyGoalController::class, 'today'])->name('study-goals.today');
Route::get('study-goals/upcoming', [StudyGoalController::class, 'upcoming'])->name('study-goals.upcoming');
Route::get('study-goals/completed', [StudyGoalController::class, 'completed'])->name('study-goals.completed');
Route::put('/study-goals/{id}/complete', [StudyGoalController::class, 'complete'])->name('study-goals.complete');
Route::put('study-goals/{goal}/updateProgress', [StudyGoalController::class, 'updateProgress'])->name('study-goals.updateProgress');
Route::delete('study-goals/{id}', [StudyGoalController::class, 'destroy'])->name('study-goals.destroy');

Route::get('study-goals/{id}/edit', [StudyGoalController::class, 'edit'])->name('study-goals.edit');

Route::put('study-goals/{id}', [StudyGoalController::class, 'update'])->name('study-goals.update');


require __DIR__.'/auth.php';

