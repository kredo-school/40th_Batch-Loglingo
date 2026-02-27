<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Question;
use App\Models\Discussion;
use App\Models\Language;

class DiscussionController extends Controller
{
    public function index()
    {
        $discussions = Discussion::with(['user', 'replies', 'question.tags'])
            ->where('status', true)
            ->latest()
            ->paginate(5);

        return view('discussions.index', compact('discussions'));
    }

    public function all()
    {
        $discussions = Discussion::with(['user', 'replies', 'question.tags'])
            ->where('status', true)
            ->latest()
            ->paginate(20);

        return view('discussions.all', compact('discussions'));
    }

    public function create(Request $request)
    {
        $question = null;

        if ($request->has('question_id')) {
            $question = Question::with('user','tags')->findOrFail($request->question_id);
        }

        $languages = Language::all();

        return view('discussions.create', compact('question','languages'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'd_title' => 'required|max:255',
            'd_content' => 'required',
            'question_id' => 'nullable|exists:questions,id',
            'language_ids' => 'required_without:question_id|array',
        ]);

        $discussion = Discussion::create([
            'user_id' => auth()->id(),
            'question_id' => $request->question_id,
            'd_title' => $request->d_title,
            'd_content' => $request->d_content,
            'is_resolved' => false,
            'status' => true,
        ]);

        if ($request->question_id) {
            $question = Question::findOrFail($request->question_id);
            $langIds = $question->tags->pluck('id')->toArray();
            $discussion->tags()->sync($langIds);
        } else {
            $discussion->tags()->sync($request->language_ids);
        }

        return redirect()->route('discussions.index')->with('success', 'Discussion started!');
    }

    public function show(Discussion $discussion)
    {
        $discussion->load(['user', 'question.user', 'question.tags', 'replies.user']);

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

    public function destroy(Discussion $discussion)
    {
        if (auth()->id() !== $discussion->user_id) {
            abort(403);
        }

        $discussion->delete();

        return redirect()->route('discussions.index');
    }
}
