<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Question;
use App\Models\Language;

class QuestionController extends Controller
{

    public function index(Request $request)
    {
        $languages = Language::where('status', true)->get();

        // get s_lang of login user
        $authUser = auth()->user();

        $query = Question::with(['user', 'tags'])
            ->withCount('answers')
            ->where('status', true)
            ->whereHas('user', function ($q) use ($authUser) {
                $q->where('s_lang', $authUser->s_lang);
            });

        // 1. language filter
        $query->when($request->filled('languages'), function ($q) use ($request) {
            $q->whereIn('written_lang', $request->languages);
        });

        // 2. search by word
        $query->when($request->search, function ($q, $search) {
            $q->where(function ($sq) use ($search) {
                $sq->where('q_title', 'like', "%{$search}%")
                    ->orWhere('q_content', 'like', "%{$search}%");
            });
        });

        // 3. Answered filter
        $query->when($request->filled('resolved'), function ($q) use ($request) {
            if ($request->resolved === 'true') {
                $q->has('answers');
            } else {
                $q->doesntHave('answers');
            }
        });

        $questions = $query->latest()->take(5)->get();

        return view('questions.index', compact('questions', 'languages'));
    }

    public function all(Request $request)
    {
        $languages = Language::where('status', true)->get();

        // get s_lang of login user
        $authUser = auth()->user();

        $query = Question::with(['user', 'tags'])
            ->withCount('answers')
            ->where('status', true)
            ->whereHas('user', function ($q) use ($authUser) {
                $q->where('s_lang', $authUser->s_lang);
            });

        // 1. language filter
        $query->when($request->filled('languages'), function ($q) use ($request) {
            $q->whereIn('written_lang', $request->languages);
        });

        // 2. search by word
        $query->when($request->search, function ($q, $search) {
            $q->where(function ($sq) use ($search) {
                $sq->where('q_title', 'like', "%{$search}%")
                    ->orWhere('q_content', 'like', "%{$search}%");
            });
        });

        // 3. Answered filter
        $query->when($request->filled('resolved'), function ($q) use ($request) {
            if ($request->resolved === 'true') {
                $q->has('answers');
            } else {
                $q->doesntHave('answers');
            }
        });

        $questions = $query->latest()->paginate(20)->withQueryString();

        return view('questions.all', compact('questions', 'languages'));
    }

    public function create()
    {
        return view('questions.add-question', [
            'languages' => Language::where('status', true)->get(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'q_title' => 'required|max:255',
            'q_content' => 'required|string',
            'tag' => 'required|integer|exists:languages,id',
            'written_lang' => 'required|integer|exists:languages,id',
        ]);

        $question = Question::create([
            'user_id' => auth()->id(),
            'q_title' => $validated['q_title'],
            'q_content' => $validated['q_content'],
            'written_lang' => $validated['written_lang'],
        ]);

        if ($validated['tag']) {
            $question->tags()->attach($validated['tag']);
        }

        return redirect()->route('questions.index')->with('status', 'Question posted successfully!');
    }

    public function show($id)
    {
        $question = Question::with(['user', 'tags'])
            ->where('status', true)
            ->findOrFail($id);

        return view('questions.show', compact('question'));
    }

    public function destroy($id)
    {
        $question = Question::findOrFail($id);

        if (auth()->id() !== $question->user_id) {
            abort(403);
        }
        $question->delete();

        return redirect()->route('questions.index');
    }
}
