<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ForumCategory extends Model
{
    use HasFactory;

    /**
     * Atribut yang dapat diisi secara massal.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'slug',
        'description', // Pastikan ini digunakan atau hapus jika tidak
    ];

    /**
     * Boot method untuk model.
     * Digunakan untuk auto-generate slug jika kosong saat membuat atau memperbarui nama.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($forumCategory) {
            if (empty($forumCategory->slug)) {
                $forumCategory->slug = Str::slug($forumCategory->name);
            }
        });

        static::updating(function ($forumCategory) {
            // Hanya update slug jika nama berubah DAN slug sengaja dikosongkan (atau tidak ada)
            // Jika Anda ingin slug selalu update saat nama berubah, hilangkan kondisi empty($forumCategory->slug)
            if ($forumCategory->isDirty('name') && empty($forumCategory->slug)) {
                $forumCategory->slug = Str::slug($forumCategory->name);
            }
        });
    }

    /**
     * Relasi ke postingan forum.
     */
    public function forumPosts()
    {
        return $this->hasMany(ForumPost::class, 'forum_category_id');
    }
}