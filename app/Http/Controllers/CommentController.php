<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Comment;
use App\Models\Post;
use App\Notifications\CommentedOnYourPost;
use App\Services\StreakService;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
      
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'c_content' => 'required|string',
            'post_id' => 'required|exists:posts,id',
        ]);

        $post = Post::findOrFail($validated['post_id']);

        $comment = Comment::create([
        'c_content' => $validated['c_content'],
        'post_id' => $validated['post_id'],
        'user_id' => auth()->id(),
        ]);

        $post = $comment->post;
        $postOwner = $post->user;

        if ($postOwner->id !== auth()->id()) {
        $postOwner->notify(
            new CommentedOnYourPost(
                $post->id,
                $post->p_title,
                auth()->id(),
                auth()->user()->name
            )
        );
    }

    StreakService::update(auth()->user());
    
    return back();
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $comment = Comment::with(['user', 'reports'])->findOrFail($id);
         return view('comments.show', compact('comment'));  
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Comment $comment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Comment $comment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $comment = Comment::findOrFail($id);

        if (auth()->id() !== $comment->user_id){
            abort(403);
        }

        $postId = $comment->post_id;
        $comment->delete();

        return redirect()->route('posts.show', $postId);
    }

    
}
