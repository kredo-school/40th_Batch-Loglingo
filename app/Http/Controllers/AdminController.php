<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
        return view('admin.qna.index');
    }

    public function indexTags()
    {
        return view('admin.tags.index');
    }

    public function indexDiscussions()
    {
        return view('admin.discussions.index');
    }
}
