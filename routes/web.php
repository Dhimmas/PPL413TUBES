<?php

<<<<<<< HEAD
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::post('/profile', [ProfileController::class, 'store'])->name('profile.add');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
=======
use Illuminate\Support\Facades\Route;
use Illuminate\View\View;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisteredUserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
*/

// Home (public)
Route::get('/', function (): View {
    return view('welcome');
})->name('home');

// ──────────────────────────────────────────────────────────────────────────────
// AUTH ROUTES
// ──────────────────────────────────────────────────────────────────────────────

// Show login form (only for guests)
Route::get('/login', [LoginController::class, 'showLoginForm'])
    ->middleware('guest')
    ->name('login');

// Process login submission (only for guests)
Route::post('/login', [LoginController::class, 'login'])
    ->middleware('guest');

// Logout (only for authenticated users)
Route::post('/logout', [LoginController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

// Show registration form (only for guests)
Route::get('/register', [RegisteredUserController::class, 'create'])
    ->middleware('guest')
    ->name('register');

// Process registration (only for guests)
Route::post('/register', [RegisteredUserController::class, 'store'])
    ->middleware('guest')
    ->name('register.store');

// ──────────────────────────────────────────────────────────────────────────────
// PROTECTED ROUTES (requires authentication)
// ──────────────────────────────────────────────────────────────────────────────

Route::middleware('auth')->group(function () {
    // Dashboard
    Route::get('/dashboard', function (): View {
        return view('dashboard');
    })->name('dashboard');
});
>>>>>>> 33a5f72 (test-regist)
