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


    // Profile

    Route::post('/profile', [ProfileController::class, 'store'])->name('profile.add');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

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
    // Route::get('chatbot/chatbotz', [ChatController::class, 'index'])->name('chatbot.index');
    // // Rute untuk mengirim pesan admin dan memperbarui respon chatbot
    // Route::post('/chatbotz/chatbot/send', [ChatController::class, 'sendAndUpdateResponse'])->name('chatbot.send');
    // // Rute untuk menghapus percakapan berdasarkan ID
    // Route::delete('/chatbot/{id}', [ChatController::class, 'destroy'])->name('chatbot.destroy');
    // // Rute untuk mengedit percakapan berdasarkan ID (dengan form)
    // Route::get('/chatbot/{id}/edit', [ChatController::class, 'edit'])->name('chatbot.edit');
    // // Rute untuk memperbarui percakapan berdasarkan ID
    // Route::put('/chatbot/{id}', [ChatController::class, 'update'])->name('chatbot.update');
});

    Route::fallback(function () {
    return view('404page');
    });


// Rute untuk halaman utama (opsional)
Route::get('/', function () {
    return redirect()->route('chatbot.index');
});

// Rute untuk halaman riwayat chat (admin)
Route::get('admin/chatbot', [ChatController::class, 'index'])->name('chatbot.index'); // Pastikan controller return view('admin.index')

// Rute untuk mengirim pesan admin dan memperbarui respon chatbot
Route::post('admin/chatbot/send', [ChatController::class, 'sendAndUpdateResponse'])->name('admin.chatbot.send');

// Rute untuk menghapus percakapan berdasarkan ID (admin)
Route::delete('admin/chatbot/{id}', [ChatController::class, 'destroy'])->name('admin.chatbot.destroy');

// Rute untuk mengedit percakapan berdasarkan ID (admin)
Route::put('admin/chatbot/{id}', [ChatController::class, 'update'])->name('admin.chatbot.update');

//index user
Route::get('chatbot', [ChatController::class, 'user_index'])->name('user.chatbot.index');

//controller user
Route::post('/chatbot/store', [ChatController::class, 'store'])->name('chatbot.store');

//logika chatbot
Route::post('/chatbot', function (Request $request) {

    // Ambil input dari user
    $userInput = strtolower($request->input('user_input'));
    $response = Conversation::where('user_input','like','%'. $userInput.'%')->first();

    // Jika respons sudah ada di database
    if ($response) {
        $responseMessage = $response->bot_response;
    } else {
        // Jika respons belum ada di database
        $responseMessage = 'Maaf, saya tidak mengerti pertanyaan Anda.';
    }

    // Kembalikan respons JSON
    return response()->json(['response' => $responseMessage]);
});
require __DIR__.'/auth.php';
