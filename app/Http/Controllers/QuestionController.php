<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Question;
use App\Models\Language;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $languages = Language::where('status', true)->get();

        $query = Question::with(['user','tags'])
        ->where('status',true);

        if($request->has('languages')){
            $query->whereIn('written_lang',$request->input('languages'));
        }

        $questions = $query->latest()->take(5)->get();

        return view('questions.index', compact('questions', 'languages'));
    }

    public function all(Request $request)
    {
        $languages = Language::where('status', true)->get();

        $query = Question::with(['user', 'tags'])
        ->where('status', true);

        if ($request->has('languages')){
            $query->whereIn('written_lang',$request->input('languages'));
        }

        $questions = $query->latest()->paginate(20);
        
        return view('questions.all', compact('questions','languages'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('questions.add-question', [
        'languages' => Language::where('status', true)->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([ 
            'q_title' => 'required|max:255',
            'q_content' => 'required|string',
            'tag' => 'required|integer|exists:languages,id',
            'written_lang' => 'required|integer|exists:languages,id',
        ]);

        Question::create([
            'user_id' => auth()->id(),
            'q_title' =>$validated['q_title'],
            'q_content' => $validated['q_content'],
            'written_lang' => $validated['written_lang'],

            // TODO: add column later(in migration, put 'language_id' as foreign key)
            // 'language_id' => $validated['tag'],  
            // 'is_answered' => false, 
        ]);

        return redirect() ->route('questions.index')->with('status', 'Question posted successfully!');

    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $question = Question::with(['user','tags'])
        ->where('status', true)
        ->findOrFail($id);
        
        return view('questions.show',compact('question'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $question = Question::findOrFail($id);

        if (auth()->id() !== $question->user_id){
            abort(403);
        }
        $question->delete();

        return redirect()->route('questions.index');
    }
}
