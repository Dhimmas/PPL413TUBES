<?php

namespace App\Http\Controllers;

use App\Models\ForumPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Models\Comment;

class ForumController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        // Ambil semua post dengan relasi user dan paginate
        $forumPosts = ForumPost::with('user')
                               ->latest()
                               ->paginate(10);
        return view('forum.index', compact('forumPosts'));
    }

    public function show($id)
    {
        // Menampilkan detail post
        $post = ForumPost::with('user')->findOrFail($id);
        return view('forum.show', compact('post'));
    }

    public function create()
    {
        // Menampilkan form untuk membuat post baru
        return view('forum.create');
    }

    public function storeComment(Request $request, ForumPost $post)
    {
        $request->validate([
            'content' => 'required',
        ]);
    
        Comment::create([
            'user_id' => auth()->id(),
            'forum_post_id' => $post->id,
            'content' => $request->content,
        ]);
    
        return redirect()->route('forum.show', $post->id)->with('success', 'Komentar berhasil ditambahkan.');
    }

    public function store(Request $request)
{
    $request->validate([
        'title' => 'required|string|max:255',
        'content' => 'required|string',
        'image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
    ]);

    $imagePath = null;
    if ($request->hasFile('image')) {
        $imagePath = $request->file('image')->store('forum_images', 'public');
    }

    ForumPost::create([
        'user_id' => auth()->id(),
        'title' => $request->title,
        'content' => $request->content,
        'image' => $imagePath,
    ]);

    return redirect()->route('forum.index')->with('success', 'Postingan berhasil ditambahkan!');
}


    public function edit($id)
    {
        // Menampilkan form untuk edit post
        $post = ForumPost::findOrFail($id);
        $this->authorize('update', $post); // Verifikasi jika menggunakan policy
        return view('forum.edit', compact('post'));
    }

    public function update(Request $request, $id)
    {
        // Update post
        $post = ForumPost::findOrFail($id);
        $this->authorize('update', $post); // Verifikasi jika menggunakan policy

        // Validasi inputan
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        // Update konten post
        $post->update([
            'title' => $request->title,
            'content' => $request->content,
        ]);

        // Redirect ke halaman detail post setelah update
        return redirect()->route('forum.index')->with('success', 'Post berhasil diperbarui.');
    }

    public function destroy($id)
    {
        // Hapus post
        $post = ForumPost::findOrFail($id);
        $this->authorize('delete', $post); // Verifikasi jika menggunakan policy
        $post->delete();

        // Redirect ke halaman forum setelah delete
        return redirect()->route('forum.index')->with('success', 'Post berhasil dihapus.');
    }
}
