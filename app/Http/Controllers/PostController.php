<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Language;
use App\Models\Comment;
use App\Services\StreakService;

class PostController extends Controller
{
    public function index(Request $request)
    {
        // get following users
        $followingIds = auth()->user()->followings()->pluck('users.id');
        // add my own ID
        $followingIds->push(auth()->id());

        $posts = Post::with(['user', 'tags'])
            ->whereIn('user_id', $followingIds)
            ->where('status', true)
            ->latest()
            ->take(5)
            ->get();

        return view('posts.index', compact('posts'));
    }

    public function all()
    {
        $followingIds = auth()->user()->followings()->pluck('users.id');
        $followingIds->push(auth()->id());

        $posts = Post::with(['user', 'tags'])
            ->whereIn('user_id', $followingIds)
            ->where('status', true)
            ->latest()
            ->paginate(20);

        return view('posts.all', compact('posts'));
    }

    public function create()
    {
        return view('posts.post-log', [
            'languages' => Language::where('status', true)->get(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate(
            [
                'p_title' => 'required|max:255',
                'event_date' => 'required',
                'p_content' => 'required|max:5000',
                'tag' => 'required|integer|exists:languages,id'
            ],
            [
                'p_content.required' => 'Please enter content',
                'p_content.max' => 'Content must be within 5000 characters',
            ]
        );

        $post = Post::create([
            'user_id' => auth()->id(),
            'event_date' => $validated['event_date'],
            'p_title' => $validated['p_title'],
            'p_content' => $validated['p_content'],
        ]);

        if ($validated['tag']) {
            $post->tags()->attach($validated['tag']);
        }

        StreakService::update(auth()->user()->fresh());


        return redirect()->route('posts.index')->with('status', 'Your log posted successfully!');
    }

    public function show($id)
    {
        $post = Post::with(['user', 'tags', 'reports', 'comments.user'])
            ->where('status', true)
            ->findOrFail($id);

        return view('posts.show', compact('post'));
    }

    public function destroy($id)
    {
        $post = Post::findOrFail($id);

        if (auth()->id() !== $post->user_id) {
            abort(403);
        }
        $post->delete();

        return redirect()->route('posts.index');
    }
}
