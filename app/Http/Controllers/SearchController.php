<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Language;
use App\Models\Post;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $languages = Language::where('status', true)->get();

        $query = Post::with(['user', 'tags'])
            ->where('status', true)
            ->where('user_id', '!=', auth()->id());

        // 1. filter by s_lang
        $query->when($request->filled('languages'), function ($q) use ($request) {
            $q->whereHas('user', function ($sq) use ($request) {
                $sq->whereIn('s_lang', $request->languages);
            });
        });

        // 2. search by word
        $query->when($request->search, function ($q, $search) {
            $q->where('p_content', 'like', "%{$search}%");
        });

        $posts = $query->latest()->paginate(10)->withQueryString();

        return view('search.index', compact('posts', 'languages'));
    }
}
