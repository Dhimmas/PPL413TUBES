<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CommentReaction extends Model
{
    protected $fillable = [
        'user_id',
        'comment_id',
        'reaction_type',
        'is_click',
    ];

    public static function toggleReaction($userId, $commentId, $reactionType)
    {
        $reaction = self::where([
            'user_id' => $userId,
            'comment_id' => $commentId,
            'reaction_type' => $reactionType,
        ])->first();

        if ($reaction) {
            // Toggle is_click
            $reaction->is_click = !$reaction->is_click;
            $reaction->save();
        } else {
            $reaction = self::create([
                'user_id' => $userId,
                'comment_id' => $commentId,
                'reaction_type' => $reactionType,
                'is_click' => true,
            ]);
        }

        return $reaction;
    }

    public static function isClicked($userId, $commentId, $reactionType)
    {
        return self::where([
            'user_id' => $userId,
            'comment_id' => $commentId,
            'reaction_type' => $reactionType,
            'is_click' => true,
        ])->exists();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comment()
    {
        return $this->belongsTo(Comment::class);
    }
}