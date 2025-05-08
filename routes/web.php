<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ForumController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\LmsController;
use Illuminate\Support\Facades\Route;

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
    Route::view('/to-do', 'to-do')->name('to_do');
    Route::view('/goals', 'goals')->name('goals');
    Route::view('/progress', 'progress')->name('progress');

    // Halaman index forum
    Route::get('/forum', [ForumController::class, 'index'])->name('forum.index');

    // Route lainnya untuk CRUD forum
    Route::get('/forum/create', [ForumController::class, 'create'])->name('forum.create');
    Route::post('/forum', [ForumController::class, 'store'])->name('forum.store'); // Perbaikan: Menggunakan '/forum' untuk store
    Route::get('/forum/{id}', [ForumController::class, 'show'])->name('forum.show');
    Route::get('/forum/{id}/edit', [ForumController::class, 'edit'])->name('forum.edit');
    Route::put('/forum/{id}', [ForumController::class, 'update'])->name('forum.update');
    Route::delete('/forum/{id}', [ForumController::class, 'destroy'])->name('forum.destroy');

    // Profile
    Route::middleware('auth')->group(function () {
        Route::post('/profile', [ProfileController::class, 'store'])->name('profile.add');
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });

    // Chatbot Route
    Route::get('/chatbot', function () {
        return view('chatbot.index'); // Pastikan view ini ada
    })->name('chatbot');

    // LMS Route
    Route::get('/lms', function () {
        return view('lms.index'); // Pastikan view ini ada
    })->name('lms');
    
});

// Autentikasi
require __DIR__.'/auth.php';
