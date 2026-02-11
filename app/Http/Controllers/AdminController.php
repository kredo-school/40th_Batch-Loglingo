<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Teacher;
use App\Models\Post;
use App\Models\Question;
use App\Models\Language;
use App\Models\Discussion;

class AdminController extends Controller
{
    public function indexUsers()
    {
        return view('admin.users.index');
    }

    public function indexTeachers()
    {
        return view('admin.teachers.index');
    }

    public function indexPosts()
    {
        return view('admin.posts.index');
    }

    public function indexQna()
    {
        $questions = Question::with(['user', 'tags'])->latest()->paginate(20);
        return view('admin.qna.index', compact('questions'));
    }

    // tags
    public function indexTags()
    {
        $languages = Language::withCount(['questions'])
            ->orderBy('id', 'asc')
            ->paginate(10);

        return view('admin.tags.index', compact('languages'));
    }

    public function storeTag(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:50|unique:languages,name',
        ]);

        Language::create([
            'name' => $validated['name'],
        ]);

        return back()->with('status', 'New tag added successfully!');
    }



    public function indexDiscussions()
    {
        return view('admin.discussions.index');
    }
}
