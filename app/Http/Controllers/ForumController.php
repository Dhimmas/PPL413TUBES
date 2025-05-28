<?php

namespace App\Http\Controllers;

use App\Models\ForumPost;
use App\Models\ForumCategory;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ForumController extends Controller
{
    use AuthorizesRequests;

    public function index(Request $request)
    {
        $keyword = $request->input('keyword');
        // Ini penting: mengambil 'category' dari request (yang dikirim oleh form)
        $categorySlug = $request->input('category');
        $sortOrder = $request->input('sort', 'newest');

        $query = ForumPost::query();

        if ($keyword) {
            $query->where(function ($q) use ($keyword) {
                $q->where('title', 'like', "%{$keyword}%")
                  ->orWhere('content', 'like', "%{$keyword}%");
            });
        }

        // Bagian ini yang menangani filter kategori
        if ($categorySlug && $categorySlug !== 'all') {
            $categoryModel = ForumCategory::where('slug', $categorySlug)->first();
            if ($categoryModel) {
                $query->where('forum_category_id', $categoryModel->id);
            }
            // Jika slug kategori dikirim tapi tidak ditemukan, idealnya ada penanganan khusus,
            // tapi untuk sekarang, jika tidak ditemukan, filter tidak akan diterapkan.
        }

        switch ($sortOrder) {
            case 'oldest':
                $query->oldest('created_at');
                break;
            case 'most-replied':
                $query->withCount('comments')->orderByDesc('comments_count');
                break;
            case 'newest':
            default:
                $query->latest('created_at');
                break;
        }
        
        if ($sortOrder !== 'most-replied') {
            $query->withCount('comments');
        }
        
        $forumPosts = $query->with(['user', 'category'])
                            ->paginate(10)
                            ->withQueryString(); // Agar parameter filter terbawa di paginasi

        $categories = ForumCategory::orderBy('name')->get();

        return view('forum.index', compact(
            'forumPosts',
            'categories',
            'keyword',
            'categorySlug', // Pastikan ini dikirim kembali ke view
            'sortOrder'
        ));
    }

    // ... (method lainnya tetap sama)
    // Pastikan method show, create, store, dsb. sudah ada dan benar
    public function show($id)
    {
        $post = ForumPost::with(['user', 'category', 'comments.user'])->findOrFail($id);
        return view('forum.show', compact('post'));
    }

    public function create()
    {
        $categories = ForumCategory::orderBy('name')->get();
        return view('forum.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'forum_category_id' => 'nullable|exists:forum_categories,id',
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
            'forum_category_id' => $request->forum_category_id,
            'image' => $imagePath,
        ]);

        return redirect()->route('forum.index')->with('success', 'Postingan berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $post = ForumPost::findOrFail($id);
        $this->authorize('update', $post);
        $categories = ForumCategory::orderBy('name')->get();
        return view('forum.edit', compact('post', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $post = ForumPost::findOrFail($id);
        $this->authorize('update', $post);

        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'forum_category_id' => 'nullable|exists:forum_categories,id',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
            'remove_image' => 'nullable|boolean',
        ]);

        $updateData = [
            'title' => $request->title,
            'content' => $request->content,
            'forum_category_id' => $request->forum_category_id,
        ];

        if ($request->boolean('remove_image') || $request->hasFile('image')) {
            if ($post->image) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($post->image);
                $updateData['image'] = null;
            }
        }

        if ($request->hasFile('image')) {
            $updateData['image'] = $request->file('image')->store('forum_images', 'public');
        }

        $post->update($updateData);
        return redirect()->route('forum.show', $post->id)->with('success', 'Post berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $post = ForumPost::findOrFail($id);
        $this->authorize('delete', $post);
        if ($post->image) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($post->image);
        }
        $post->delete();
        return redirect()->route('forum.index')->with('success', 'Post berhasil dihapus.');
    }
    
    public function storeComment(Request $request, ForumPost $post)
    {
        $request->validate([
            'content' => 'required|string',
        ]);
    
        \App\Models\Comment::create([ 
            'user_id' => auth()->id(),
            'forum_post_id' => $post->id,
            'content' => $request->content,
        ]);
    
        return redirect()->route('forum.show', $post->id)->with('success', 'Komentar berhasil ditambahkan.');
    }
}