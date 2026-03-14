<?php

namespace App\Http\Controllers;

use App\Models\Follow;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Notifications\FollowedYou;

class FollowController extends Controller
{

    public function store(User $user)
    {
        // avoid to follow myself
        if (Auth::id() === $user->id) {
            if (request()->ajax()) {
                return response()->json(['message' => 'Cannot follow yourself'], 403);
            }
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

        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Followed ' . $user->name,
                'following' => true
            ]);
        }

        return back();
    }

    public function destroy(User $user)
    {
        Auth::user()->followings()->detach($user->id);

        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Unfollowed ' . $user->name,
                'following' => false
            ]);
        }

        return back();
    }
}
