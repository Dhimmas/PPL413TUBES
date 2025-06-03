<?php

use App\Http\Controllers\StudyGoalController;

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

