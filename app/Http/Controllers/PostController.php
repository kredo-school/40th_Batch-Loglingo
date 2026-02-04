<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->routeIs('dashboard')) {
            return view('dashboard');
        }

        return view('posts.index');
    }
   
   
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('posts.post-log');
    }
    


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
         $request->validate([
            'p_title' => 'required|max:255',
            'event_date' => 'required',
            'p_content' => 'required',
            'tag' => 'required'
        ]);
    }
     

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        return view('posts.show');        
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
