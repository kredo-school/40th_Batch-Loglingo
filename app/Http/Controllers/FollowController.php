<?php

namespace App\Http\Controllers;

use App\Models\Follow;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Notifications\FollowedYou;

class FollowController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(User $user)
        {
            // avoid to follow myself
            if (Auth::id() === $user->id) {
                abort(403);
            }

            $me = Auth::user();
            $me->followings()->syncWithoutDetaching([$user->id]);

            if ($user->id !== $me->id) {
            $user->notify(
            new FollowedYou(
                $me->id,
                $me->name
            )
            );
            }

            return back();
        }

    /**
     * Display the specified resource.
     */
    public function show(Follow $follow)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Follow $follow)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Follow $follow)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
        {
            Auth::user()->followings()->detach($user->id);

            return back();
        }

}
