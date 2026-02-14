<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Comment;
use App\Models\Post;
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

        Comment::create([
        'c_content' => $validated['c_content'],
        'post_id' => $validated['post_id'],
        'user_id' => auth()->id(),
    ]);

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
