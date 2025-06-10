<?php

namespace App\Http\Controllers;

use App\Models\ForumPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ForumBookmarkController extends Controller
{
    /**
     * Menampilkan daftar post yang sudah di-bookmark oleh user.
     */
    public function index()
    {
        // Menggunakan relasi yang sudah diperbaiki
        $bookmarkedPosts = Auth::user()
            ->bookmarkedPosts() // <-- Relasi yang bersih
            ->with(['user', 'category']) // Eager load relasi lain untuk performa
            ->withCount('comments') // Menghitung jumlah komentar
            ->latest('forum_bookmarks.created_at') // Urutkan berdasarkan kapan di-bookmark
            ->paginate(10);
            
        return view('forum.bookmark.index', compact('bookmarkedPosts'));
    }

    /**
     * Menambah atau menghapus bookmark (toggle).
     */
    public function toggle(Request $request, \App\Models\ForumPost $post)
    {
        $user = $request->user();

        if ($post->isBookmarkedBy($user)) {
            $user->bookmarks()->detach($post->id);
            $isBookmarked = false;
        } else {
            $user->bookmarks()->attach($post->id);
            $isBookmarked = true;
        }

        return response()->json([
            'success' => true,
            'isBookmarked' => $isBookmarked,
        ]);
    }
}