<?php

namespace App\Http\Controllers;

use App\Models\Discussion;
use App\Models\Reply;
use Illuminate\Http\Request;
use App\Services\StreakService;
use App\Notifications\RepliedToDiscussion;


class ReplyController extends Controller
{
    public function store(Request $request, Discussion $discussion)
    {
        $request->validate([
            'r_content' => 'required',
        ]);

        $reply = Reply::create([
            'discussion_id' => $discussion->id,
            'user_id' => auth()->id(),
            'r_content' => $request->r_content,
        ]);

        $discussionOwner = $discussion->user;

        if ($discussionOwner->id !== auth()->id()) {
            $discussionOwner->notify(
                new RepliedToDiscussion(
                    $discussion->id,
                    $discussion->d_title, 
                    auth()->id(),
                    auth()->user()->name
                )
            );
        }


        StreakService::update(auth()->user()->fresh());

        return back()->with('success', 'Your reply has been posted!');
    }

    public function destroy(Reply $reply)
    {
        if (auth()->id() !== $reply->user_id) {
            abort(403);
        }

        $reply->delete();

        return back();
    }
}
