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

        $query = Post::with(['user','tags'])
        ->where('status',true);

        if($request->filled('languages')){
            $query->whereIn('written_lang',$request->input('languages'));
        }

        $posts = $query->latest()->paginate(10);

        return view('search.index', compact('posts', 'languages'));
    }
}
