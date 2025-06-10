<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Poll extends Model
{
    use HasFactory;

    protected $fillable = [
        'forum_post_id',
        'question',
    ];

    public function forumPost()
    {
        return $this->belongsTo(ForumPost::class);
    }

    public function options()
    {
        return $this->hasMany(PollOption::class);
    }

    // Untuk mengecek apakah user sudah vote di poll ini
    public function hasVoted(User $user)
    {
        return $this->options()->whereHas('votes', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })->exists();
    }
}