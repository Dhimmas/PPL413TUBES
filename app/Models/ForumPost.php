<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// use App\Models\ForumCategory; // Tidak perlu di-import jika sudah namespaced dengan benar dan hanya digunakan di method return type
// use App\Models\User; // Tidak perlu di-import jika sudah namespaced dengan benar dan hanya digunakan di method return type
// use App\Models\Comment; // Tidak perlu di-import jika sudah namespaced dengan benar dan hanya digunakan di method return type

class ForumPost extends Model
{
    use HasFactory;

    /**
     * Atribut yang dapat diisi secara massal.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'content',
        'user_id',
        'forum_category_id',
        'image',
        // 'slug', // Tambahkan jika Anda menggunakan slug untuk postingan
        // 'views_count' // Tambahkan jika Anda memiliki kolom untuk jumlah views
    ];

    /**
     * Mendapatkan pengguna yang membuat postingan ini.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Mendapatkan kategori dari postingan forum ini.
     */
    public function category()
    {
        return $this->belongsTo(ForumCategory::class, 'forum_category_id');
    }

    /**
     * Mendapatkan komentar untuk postingan forum ini.
     */
    public function comments()
    {
        return $this->hasMany(Comment::class, 'forum_post_id');
    }

    // Accessor untuk mendapatkan ringkasan konten (opsional, bisa juga di view)
    // public function getExcerptAttribute()
    // {
    //     return Str::limit(strip_tags($this->content), 150);
    // }

    // Accessor untuk tanggal yang mudah dibaca (opsional, bisa juga di view dengan $post->created_at->diffForHumans())
    // public function getPublishedDateAttribute()
    // {
    //     return $this->created_at->diffForHumans();
    // }
}