<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Teacher;
use App\Models\Post;
use App\Models\Question;
use App\Models\Language;
use App\Models\Discussion;
use App\Models\Answer;
use App\Models\Reply;

class AdminController extends Controller
{
    // Index pages
    public function indexUsers(Request $request)
    {
        $users = User::where('role_id', 2)
            // 1. search bar
            ->when($request->search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                });
            })
            // 2. status filter
            ->when($request->status, function ($query, $status) {
                if ($status === 'active') {
                    $query->where('status', true);
                } elseif ($status === 'inactive') {
                    $query->where('status', false);
                }
            })
            ->latest()
            ->paginate(20)
            ->withQueryString();

        return view('admin.users.index', compact('users'));
    }

    public function indexTeachers(Request $request)
    {
        $teachers = User::where('role_id', 3)
            // 1. search bar
            ->when($request->search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                });
            })
            // 2. status filter
            ->when($request->status, function ($query, $status) {
                if ($status === 'active') {
                    $query->where('status', true);
                } elseif ($status === 'inactive') {
                    $query->where('status', false);
                }
            })
            ->latest()
            ->paginate(20)
            ->withQueryString();

        return view('admin.teachers.index', compact('teachers'));
    }

    public function indexPosts(Request $request)
    {
        $query = Post::with(['user', 'tags', 'reports', 'comments.reports'])
            ->withCount('reports as p_reports_count')
            ->addSelect([
                'comments_reports_count' => \App\Models\Comment::selectRaw('count(*)')
                    ->join('reports', 'comments.id', '=', 'reports.reportable_id')
                    ->where('reports.reportable_type', \App\Models\Comment::class)
                    ->whereColumn('comments.post_id', 'posts.id')
            ]);

        // 1. search
        $query->when($request->search, function ($q, $search) {
            $q->where(function ($sub) use ($search) {
                $sub->where('p_title', 'like', "%{$search}%")
                    ->orWhere('p_content', 'like', "%{$search}%");
            });
        });

        // 2. status filter
        $query->when($request->status, function ($q, $status) {
            if ($status === 'active') {
                $q->where('status', true);
            } elseif ($status === 'inactive') {
                $q->where('status', false);
            }
        });

        // 3. sort by
        if ($request->sort === 'reports') {
            $query->orderByRaw('(p_reports_count + COALESCE(comments_reports_count, 0)) DESC');
        } else {
            $query->latest();
        }

        $posts = $query->paginate(20)->withQueryString();

        foreach ($posts as $post) {
            $post->total_reports_count =
                ($post->p_reports_count ?? 0) + ($post->comments_reports_count ?? 0);
        }

        return view('admin.posts.index', compact('posts'));
    }

    public function indexQna(Request $request)
    {
        $query = Question::with(['user', 'tags', 'reports', 'answers.reports'])
            ->withCount('reports as q_reports_count')
            ->addSelect([
                'answers_reports_count' => Answer::selectRaw('count(*)')
                    ->join('reports', 'answers.id', '=', 'reports.reportable_id')
                    ->where('reports.reportable_type', Answer::class)
                    ->whereColumn('answers.question_id', 'questions.id')
            ]);

        // 1. search
        $query->when($request->search, function ($q, $search) {
            $q->where(function ($sub) use ($search) {
                $sub->where('q_title', 'like', "%{$search}%")
                    ->orWhere('q_content', 'like', "%{$search}%");
            });
        });

        // 2. status filter
        $query->when($request->status, function ($q, $status) {
            if ($status === 'active') {
                $q->where('status', true);
            } elseif ($status === 'inactive') {
                $q->where('status', false);
            }
        });

        // 3. sort by
        if ($request->sort === 'reports') {
            $query->orderByRaw('(q_reports_count + COALESCE(answers_reports_count, 0)) DESC');
        } else {
            $query->latest();
        }

        $questions = $query->paginate(20)->withQueryString();

        foreach ($questions as $question) {
            $question->total_reports_count =
                ($question->q_reports_count ?? 0) + ($question->answers_reports_count ?? 0);
        }

        return view('admin.qna.index', compact('questions'));
    }

    public function indexDiscussions(Request $request)
    {
        $query = Discussion::with(['user', 'tags', 'question.user', 'question.tags', 'replies.user', 'replies.reports'])
            // 1. report count
            ->withCount('reports as d_reports_count')
            // 2. total report count
            ->addSelect([
                'replies_reports_count' => Reply::selectRaw('count(*)')
                    ->join('reports', 'replies.id', '=', 'reports.reportable_id')
                    ->where('reports.reportable_type', Reply::class)
                    ->whereColumn('replies.discussion_id', 'discussions.id')
            ]);

        // search bar
        $query->when($request->search, function ($q, $search) {
            $q->where(function ($sq) use ($search) {
                $sq->where('d_title', 'like', "%{$search}%")
                    ->orWhere('d_content', 'like', "%{$search}%");
            });
        });

        // status filter
        $query->when($request->status, function ($q, $status) {
            if ($status === 'active') $q->where('status', true);
            elseif ($status === 'inactive') $q->where('status', false);
        });

        // sort by 
        if ($request->sort === 'reports') {
            $query->orderByRaw('(d_reports_count + COALESCE(replies_reports_count, 0)) DESC');
        } else {
            $query->latest();
        }

        $discussions = $query->paginate(20)->withQueryString();

        return view('admin.discussions.index', compact('discussions'));
    }

    public function indexTags()
    {
        $languages = Language::withCount(['questions'])
            ->orderBy('id', 'asc')
            ->paginate(10);

        $allColors = [
            'red',
            'blue',
            'green',
            'yellow',
            'indigo',
            'purple',
            'pink',
            'orange',
            'teal',
            'cyan',
            'lime',
            'emerald',
            'sky',
            'amber',
            'rose',
            'gray'
        ];

        $usedColors = Language::pluck('color')->toArray();

        $availableColors = array_diff($allColors, $usedColors);
        if (!in_array('gray', $availableColors)) {
            $availableColors[] = 'gray';
        }

        return view('admin.tags.index', compact('languages', 'availableColors'));
    }

    // store tags
    public function storeTag(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:50|unique:languages,name',
            'code' => 'required|max:10|unique:languages,code',
            'color' => 'required|in:red,blue,green,yellow,indigo,purple,pink,orange,teal,cyan,lime,emerald,sky,amber,rose,gray',
        ]);

        Language::create([
            'name' => $validated['name'],
            'code' => $validated['code'],
            'color' => $validated['color'],
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
