<?php

namespace App\Http\Controllers;

use App\Models\ForumPost;
use App\Models\ForumCategory;
use App\Models\CommentReaction;
use App\Models\Poll;
use App\Models\PollOption;
use App\Models\PollVote;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ForumController extends Controller
{
    use AuthorizesRequests;

    // ... (method index, show, create, store, edit, update, destroy, storeComment yang sudah ada) ...
    public function index(Request $request)
    {
        $keyword = $request->input('keyword');
        $categorySlug = $request->input('category');
        $sortOrder = $request->input('sort', 'newest');

        $query = ForumPost::query();

        if ($keyword) {
            $query->where(function ($q) use ($keyword) {
                $q->where('title', 'like', "%{$keyword}%")
                  ->orWhere('content', 'like', "%{$keyword}%");
            });
        }

        if ($categorySlug && $categorySlug !== 'all') {
            $categoryModel = ForumCategory::where('slug', $categorySlug)->first();
            if ($categoryModel) {
                $query->where('forum_category_id', $categoryModel->id);
            }
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
                            ->withQueryString();

        $categories = ForumCategory::orderBy('name')->get();

        return view('forum.index', compact(
            'forumPosts',
            'categories',
            'keyword',
            'categorySlug',
            'sortOrder'
        ));
    }

    // app/Http/Controllers/ForumController.php
    public function show($id)
    {
        $post = ForumPost::with([
            'user', 
            'category', 
            'comments' => function ($query) {
                $query->with(['user', 'reactions']) // <-- PASTIKAN INI ADA!
                    ->orderBy('created_at', 'asc');
            },
            'poll.options' => function ($query) {
                $query->withCount('votes'); 
            }
        ])->findOrFail($id);

            $post->incrementViews();
        

        return view('forum.show', compact('post'));
    }

    public function create()
    {
        $categories = ForumCategory::orderBy('name')->get();
        return view('forum.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'forum_category_id' => 'nullable|exists:forum_categories,id',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
            'poll_question' => 'nullable|string|max:255',
            'poll_options' => 'nullable|array', 
            'poll_options.*' => 'nullable|string|max:255', 
        ]);

        if (empty($validatedData['poll_question'])) {
            unset($validatedData['poll_options']); 
        } else {
            if (empty($validatedData['poll_options'])) { 
                return back()->withErrors(['poll_options' => 'Jika pertanyaan polling diisi, minimal harus ada 2 pilihan jawaban.'])->withInput();
            }
            $validatedData['poll_options'] = array_filter($validatedData['poll_options'], function($value) {
                return !is_null($value) && $value !== '';
            });
            if (count($validatedData['poll_options']) < 2) {
                 return back()->withErrors(['poll_options' => 'Jika pertanyaan polling diisi, minimal harus ada 2 pilihan jawaban yang valid.'])->withInput();
            }
        }

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('forum_images', 'public');
        }

        $post = ForumPost::create([
            'user_id' => Auth::id(), 
            'title' => $validatedData['title'],
            'content' => $validatedData['content'],
            'forum_category_id' => $validatedData['forum_category_id'],
            'image' => $imagePath,
        ]);

        if ($post && !empty($validatedData['poll_question']) && !empty($validatedData['poll_options'])) {
            $poll = $post->poll()->create([
                'question' => $validatedData['poll_question'],
            ]);

            if ($poll) {
                $optionsToInsert = [];
                foreach ($validatedData['poll_options'] as $optionText) {
                     $optionsToInsert[] = ['option_text' => $optionText];
                }
                $poll->options()->createMany($optionsToInsert);
            }
        }
        return redirect()->route('forum.index')->with('success', 'Postingan berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $post = ForumPost::with('poll.options')->findOrFail($id);
        $this->authorize('update', $post);
        $categories = ForumCategory::orderBy('name')->get();
        return view('forum.edit', compact('post', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $post = ForumPost::findOrFail($id);
        $this->authorize('update', $post);

        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'forum_category_id' => 'nullable|exists:forum_categories,id',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
            'remove_image' => 'nullable|boolean',
            'poll_question' => 'nullable|string|max:255',
            'poll_options' => 'nullable|array',
            'poll_options.*' => 'nullable|string|max:255',
        ]);
        
        $updateData = [
            'title' => $validatedData['title'],
            'content' => $validatedData['content'],
            'forum_category_id' => $validatedData['forum_category_id'],
        ];

        if ($request->boolean('remove_image') || $request->hasFile('image')) {
            if ($post->image) {
                Storage::disk('public')->delete($post->image);
                $updateData['image'] = null;
            }
        }

        if ($request->hasFile('image')) {
            $updateData['image'] = $request->file('image')->store('forum_images', 'public');
        }

        $post->update($updateData);

        $hasNewPollQuestion = $request->filled('poll_question');
        $newPollOptions = $request->input('poll_options', []);
        $validNewPollOptions = array_filter($newPollOptions, fn($opt) => !is_null($opt) && $opt !== '');

        if ($hasNewPollQuestion && count($validNewPollOptions) >= 2) {
            if ($post->poll) { 
                $post->poll->update(['question' => $request->input('poll_question')]);
                $post->poll->options()->delete(); 
                $optionsToInsert = [];
                foreach ($validNewPollOptions as $optionText) {
                    $optionsToInsert[] = ['option_text' => $optionText];
                }
                $post->poll->options()->createMany($optionsToInsert);
            } else { 
                $poll = $post->poll()->create(['question' => $request->input('poll_question')]);
                $optionsToInsert = [];
                foreach ($validNewPollOptions as $optionText) {
                    $optionsToInsert[] = ['option_text' => $optionText];
                }
                $poll->options()->createMany($optionsToInsert);
            }
        } elseif (!$hasNewPollQuestion && $post->poll) {
            $post->poll->options()->delete();
            $post->poll->delete();
        }
        return redirect()->route('forum.show', $post->id)->with('success', 'Post berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $post = ForumPost::findOrFail($id);
        $this->authorize('delete', $post);
        if ($post->image) {
            Storage::disk('public')->delete($post->image);
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
            'user_id' => Auth::id(),
            'forum_post_id' => $post->id,
            'content' => $request->content,
        ]);
    
        return redirect()->route('forum.show', $post->id)->with('success', 'Komentar berhasil ditambahkan.');
    }

    public function handlePollVote(Request $request, PollOption $pollOption)
    {
        $user = Auth::user();
        $poll = $pollOption->poll()->with('forumPost')->first(); // Eager load forumPost dari poll

        // Jika poll tidak ditemukan atau tidak memiliki relasi forumPost (seharusnya tidak terjadi)
        if (!$poll || !$poll->forumPost) {
            return redirect()->back()->with('error', 'Polling tidak valid atau tidak ditemukan.');
        }

        // CEK APAKAH USER YANG VOTE ADALAH PEMBUAT POSTINGAN
        if ($user->id === $poll->forumPost->user_id) {
            return redirect()->route('forum.show', $poll->forum_post_id)
                             ->with('error', 'Anda tidak dapat memberikan suara pada polling Anda sendiri.');
        }

        // Cek apakah user sudah pernah vote di poll ini sebelumnya
        if ($poll->hasVoted($user)) {
            return redirect()->route('forum.show', $poll->forum_post_id)
                             ->with('error', 'Kamu sudah memberikan suara untuk polling ini.');
        }

        PollVote::create([
            'poll_option_id' => $pollOption->id,
            'user_id' => $user->id,
        ]);

        return redirect()->route('forum.show', $poll->forum_post_id)
                         ->with('success', 'Terima kasih, suaramu telah dicatat!');
    }
}