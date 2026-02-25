<?php

namespace App\Http\Controllers;

use App\Models\Discussion;
use App\Models\Reply;
use Illuminate\Http\Request;

class ReplyController extends Controller
{
    public function store(Request $request, Discussion $discussion)
    {
        $request->validate([
            'r_content' => 'required|min:5',
        ]);

        Reply::create([
            'discussion_id' => $discussion->id,
            'user_id' => auth()->id(),
            'r_content' => $request->r_content,
        ]);

        return back()->with('success', 'Your reply has been posted!');
    }
}
