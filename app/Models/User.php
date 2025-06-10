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
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed', // Aktifkan jika menggunakan Laravel 10+
    ];

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