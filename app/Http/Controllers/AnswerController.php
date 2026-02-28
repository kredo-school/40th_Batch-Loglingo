<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnswerController extends Controller
{
    
    public function store(Request $request)
    {
        $request->validate([
            'question_id' => 'required|exists:questions,id',
            'a_content' => 'required|string|max:2000',
        ]);

        Answer::create([
            'user_id' => Auth::id(),
            'question_id' => $request->question_id,
            'a_content' => $request->a_content,
        ]);

        return back()->with('success','Answer posted successfully!');

    }

    public function destroy(Answer $answer)
    {
        if (Auth::id() !== $answer->user_id){
         abort(403);
        }

        $answer->delete();
        return back()->with('success','Answer deleted.');

    }
}
