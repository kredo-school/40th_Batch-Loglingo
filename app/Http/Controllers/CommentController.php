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
    public function store(Request $request)
    {
        $validated = $request->validate(
            [
                'c_content' => 'required|string|min:1|max:1000',
                'post_id' => 'required|exists:posts,id',
            ],
            [
                'c_content.max' => 'Comment must be within 1000 characters',
                'c_content.required' => 'Please enter a comment',
            ]

        );

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

        StreakService::update(auth()->user()->fresh());


        return back();
    }


    public function show($id)
    {
        $comment = Comment::with(['user', 'reports'])->findOrFail($id);
        return view('comments.show', compact('comment'));
    }

    public function destroy($id)
    {
        $comment = Comment::findOrFail($id);

        if (auth()->id() !== $comment->user_id) {
            abort(403);
        }

        $postId = $comment->post_id;
        $comment->delete();

        return redirect()->route('posts.show', $postId);
    }
}
