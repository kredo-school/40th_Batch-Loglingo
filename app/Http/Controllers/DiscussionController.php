<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Question;
use App\Models\Discussion;

class DiscussionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $discussions = Discussion::with(['user', 'replies', 'question.tags'])
            ->where('status', true)
            ->latest()
            ->paginate(10);

        return view('discussions.index', compact('discussions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $question = null;

        if ($request->has('question_id')) {
            $question = Question::with('user')->findOrFail($request->question_id);
        }

        return view('discussions.create', compact('question'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'd_title' => 'required|max:255',
            'd_content' => 'required',
            'question_id' => 'nullable|exists:questions,id',
        ]);

        Discussion::create([
            'user_id' => auth()->id(),
            'question_id' => $request->question_id,
            'd_title' => $request->d_title,
            'd_content' => $request->d_content,
            'is_resolved' => false,
            'status' => true,
        ]);

        return redirect()->route('discussions.index')->with('success', 'Discussion started!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Discussion $discussion)
    {
        $discussion->load(['user', 'question.user', 'replies.user']);

        return view('discussions.show', compact('discussion'));
    }

    public function resolve(Discussion $discussion)
    {
        if (auth()->id() !== $discussion->user_id) {
            abort(403);
        }

        $discussion->update(['is_resolved' => true]);

        return back()->with('success', 'Discussion marked as resolved!');
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Discussion $discussion)
    {
        if (auth()->id() !== $discussion->user_id) {
            abort(403);
        }

        $discussion->delete();

        return redirect()->route('discussions.index');
    }
}
