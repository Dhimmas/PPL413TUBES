<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'is_admin', // Tambahkan jika belum ada
        'is_super_admin', // Add this field
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'is_admin' => 'boolean', // Tambahkan jika belum ada
        'is_super_admin' => 'boolean', // Add this field
    ];

    // Tambahkan relasi profile
    public function profile()
    {
        return $this->hasOne(Profile::class);
    }

    // Relasi untuk Quiz Results
    public function quizResults()
    {
        return $this->hasMany(UserQuizResult::class);
    }

    // Relasi untuk mendapatkan quiz yang sudah diselesaikan
    public function completedQuizzes()
    {
        return $this->belongsToMany(Quiz::class, 'user_quiz_results')
                    ->wherePivot('status', 'completed')
                    ->withPivot('score', 'finished_at')
                    ->withTimestamps();
    }

    // Method untuk mengecek apakah user sudah mengerjakan quiz tertentu
    public function hasAttemptedQuiz($quizId)
    {
        return $this->quizResults()->where('quiz_id', $quizId)->exists();
    }

    // Method untuk mendapatkan hasil quiz tertentu
    public function getQuizResult($quizId)
    {
        return $this->quizResults()->where('quiz_id', $quizId)->latest()->first();
    }

    // Relasi lainnya (tidak diubah)
    public function forumPosts()
    {
        return $this->hasMany(ForumPost::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function commentReactions()
    {
        return $this->hasMany(CommentReaction::class);
    }

    // --- PERBAIKAN RELASI BOOKMARK ---
    // Satu relasi bersih untuk semua post yang di-bookmark oleh user ini.
    public function bookmarks()
    {
        return $this->belongsToMany(\App\Models\ForumPost::class, 'forum_bookmarks', 'user_id', 'forum_post_id')
            ->withTimestamps();
    }

    public function bookmarkedPosts()
    {
        return $this->belongsToMany(\App\Models\ForumPost::class, 'forum_bookmarks', 'user_id', 'forum_post_id')
            ->withTimestamps();
    }
}