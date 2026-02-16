<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Language;
use App\Models\Comment;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
       
        $posts = Post::with(['user','tags'])->latest()->take(5)->get();
        return view('posts.index', compact('posts'));
        
    }
   
    public function all()
    {
        $posts = Post::with(['user', 'tags'])->latest()->paginate(20);
        return view('posts.all', compact('posts'));
    }
   
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
         return view('posts.post-log', [
        'languages' => Language::all(),
        ]);
    }
    


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
          $validated = $request->validate([
            'p_title' => 'required|max:255',
            'event_date' => 'required',
            'p_content' => 'required',
            'tag' => 'required|integer|exists:languages,id'
        ]);

         Post::create([
            'user_id' => auth()->id(),
            'event_date' => $validated['event_date'], 
            'p_title' =>$validated['p_title'],
            'p_content' => $validated['p_content'],
            

            // TODO: add column later(in migration, put 'language_id' as foreign key)
            // 'language_id' => $validated['tag'],  
            // 'is_answered' => false, 
        ]);

        return redirect() ->route('posts.index')->with('status', 'Your log posted successfully!');
    }
     

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
         $post = Post::with(['user', 'tags', 'reports','comments.user'])->findOrFail($id);
         return view('posts.show', compact('post'));        
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
        $post = Post::findOrFail($id);

        if (auth()->id() !== $post->user_id){
            abort(403);
        }
        $post->delete();

        return redirect()->route('posts.index');
    }
}
