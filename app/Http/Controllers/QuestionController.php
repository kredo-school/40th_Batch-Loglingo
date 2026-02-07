<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Question;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $questions = Question::latest()->take(5)->get();
        return view('questions.index', compact('questions'));
    }

    public function all()
    {
        $questions = \App\Models\Question::with(['user', 'language'])->latest()->paginate(20);
        return view('questions.all', compact('questions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('questions.add-question');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'q_title' => 'required|max:255',
            'q_content' => 'required',
            'tag' => 'required',
            'written_lang' => 'required'
        ]);

        // save (activate after create tables)
        // return redirect()->route('questions.index')->with('status', 'Question posted successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        return view('questions.show');
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
    public function destroy(string $id)
    {
        //
    }
}
