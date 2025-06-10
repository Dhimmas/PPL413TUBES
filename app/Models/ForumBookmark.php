<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ForumBookmark extends Model
{
    protected $fillable = ['user_id', 'forum_post_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function post()
    {
        return $this->belongsTo(ForumPost::class, 'forum_post_id');
    }
}