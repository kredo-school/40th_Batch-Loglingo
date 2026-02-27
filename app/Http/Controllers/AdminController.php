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
    // Index pages
    public function indexUsers()
    {
        $users = User::where('role_id', 2)
            ->latest()
            ->paginate(20);

        return view('admin.users.index', compact('users'));
    }

    public function indexTeachers()
    {
        $teachers = User::where('role_id', 3)
            ->latest()
            ->paginate(20);

        return view('admin.teachers.index', compact('teachers'));
    }

    public function indexPosts()
    {
        $posts = Post::with(['user', 'tags', 'reports', 'comments.reports'])
            ->latest()
            ->paginate(20);

        return view('admin.posts.index', compact('posts'));
    }

    public function indexQna()
    {
        $questions = Question::with(['user', 'tags', 'reports', 'answers.reports'])
            ->latest()
            ->paginate(20);

        return view('admin.qna.index', compact('questions'));
    }

    public function indexDiscussions()
    {
        $discussions = Discussion::with(['user', 'question.user', 'question.tags', 'replies.user'])
            ->latest()
            ->paginate(20);

        return view('admin.discussions.index', compact('discussions'));
    }

    public function indexTags()
    {
        $languages = Language::withCount(['questions'])
            ->orderBy('id', 'asc')
            ->paginate(10);

        return view('admin.tags.index', compact('languages'));
    }

    // store tags
    public function storeTag(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:50|unique:languages,name',
            'code' => 'required|max:10|unique:languages,code',
        ]);

        Language::create([
            'name' => $validated['name'],
            'code' => $validated['code'],
        ]);

        return back()->with('status', 'New tag added successfully!');
    }


    // change status 
    public function toggleUserStatus(User $user)
    {
        $user->status = !$user->status;
        $user->save();

        return back()->with('status', 'User status has been updated successfully!');
    }

    public function toggleQuestionStatus(Question $question)
    {
        $question->status = !$question->status;
        $question->save();

        return back()->with('status', 'Question status has been updated successfully!');
    }

    public function togglePostStatus(Post $post)
    {
        $post->status = !$post->status;
        $post->save();

        return back()->with('status', 'Post status has been updated successfully!');
    }

    public function toggleLanguageStatus(Language $language)
    {
        $language->status = !$language->status;
        $language->save();

        return back()->with('status', 'Language status has been updated successfully!');
    }

    public function toggleDiscussionStatus(Discussion $discussion)
    {
        $discussion->status = !$discussion->status;
        $discussion->save();

        return back()->with('success', 'Discussion status has been updated successfully!');
    }
}
