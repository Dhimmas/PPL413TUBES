<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth; // <-- TAMBAHKAN INI

class ForumPost extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'content',
        'user_id',
        'forum_category_id',
        'image',
        'views_count'
    ];

    // --- PROPERTI BARU UNTUK EFISIENSI ---
    // Menambahkan $with untuk selalu eager load relasi ini,
    // Ini akan mencegah N+1 problem saat mengecek status bookmark.
    protected $with = ['bookmarkingUsers'];

    // --- ACCESSOR BARU UNTUK VIEW ---
    // Ini cara modern dan bersih untuk mengecek status bookmark di view
    // Kita bisa memanggilnya dengan $post->is_bookmarked
    public function getIsBookmarkedAttribute()
    {
        // Jika user tidak login, tidak ada yang di-bookmark
        if (!Auth::check()) {
            return false;
        }
        
        // Cek apakah ID user yang sedang login ada di dalam koleksi user yang mem-bookmark post ini.
        // Ini sangat cepat karena relasi 'bookmarkingUsers' sudah di-load berkat $with.
        return $this->bookmarkingUsers->contains(Auth::id());
    }

    public function bookmarkedUsers()
    {
        return $this->belongsToMany(\App\Models\User::class, 'forum_bookmarks', 'forum_post_id', 'user_id')
            ->withTimestamps();
    }

    public function isBookmarkedBy($user)
    {
        if (!$user) return false;
        return $this->bookmarkedUsers()->where('user_id', $user->id)->exists();
    }

    // Relasi lainnya (tidak diubah)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(ForumCategory::class, 'forum_category_id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'forum_post_id');
    }
    
    public function poll()
    {
        return $this->hasOne(Poll::class);
    }

    public function incrementViews()
    {
        $this->views_count++;
        return $this->save();
    }
    
    // --- PERBAIKAN RELASI BOOKMARK ---
    // Satu relasi bersih untuk semua user yang mem-bookmark post ini.
    public function bookmarkingUsers()
    {
        return $this->belongsToMany(\App\Models\User::class, 'forum_bookmarks', 'forum_post_id', 'user_id')
                    ->withTimestamps();
    }
}