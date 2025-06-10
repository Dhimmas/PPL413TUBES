<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CommentReaction;
use Illuminate\Support\Facades\Auth;

class CommentReactionController extends Controller
{
    public function toggleReaction(Request $request, $commentId)
    {
        $request->validate([
            'reaction_type' => 'required|string',
        ]);

        $userId = Auth::id();
        $reactionType = $request->reaction_type;

        $reaction = CommentReaction::toggleReaction($userId, $commentId, $reactionType);

        // Hitung ulang jumlah setiap reaction_type untuk komentar ini
        $counts = CommentReaction::where('comment_id', $commentId)
            ->where('is_click', true)
            ->selectRaw('reaction_type, count(*) as total')
            ->groupBy('reaction_type')
            ->pluck('total', 'reaction_type');

        return response()->json([
            'success' => true,
            'reaction_type' => $reactionType,
            'is_click' => $reaction->is_click,
            'reaction_counts' => $counts,
        ]);
    }
}