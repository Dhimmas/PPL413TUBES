<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;

class Comment extends Model
{
    use HasFactory;
    protected $fillable = ['forum_post_id', 'user_id', 'content'];

    public function user() { return $this->belongsTo(User::class); }
    public function forumPost() { return $this->belongsTo(ForumPost::class); }
    public function reactions() { return $this->hasMany(CommentReaction::class); }
    public function current_user_reaction() { return $this->hasOne(CommentReaction::class)->where('user_id', auth()->id()); }

    public function getGroupedReactionCountsAttribute()
    {
        return $this->reactions()
            ->selectRaw('reaction_type, count(*) as count')
            ->groupBy('reaction_type')
            ->pluck('count', 'reaction_type');
    }

    public function getCurrentUserReactionAttribute(): ?CommentReaction
    {
        if (!Auth::check()) {
            return null;
        }
        if (! $this->relationLoaded('reactions')) {
            $this->load('reactions');
        }
        if ($this->reactions instanceof EloquentCollection) {
            return $this->reactions->where('user_id', Auth::id())->first();
        }
        return null;
    }
}