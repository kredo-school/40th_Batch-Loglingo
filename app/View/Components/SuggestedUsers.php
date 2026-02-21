<?php

namespace App\View\Components;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\Component;

class SuggestedUsers extends Component
{
    public $users;

    public function __construct()
    {
        $authUser = Auth::user();

        if (!$authUser) {
            $this->users = collect();
            return;
        }

        // except for：myself,follow,follower
        $excludedIds = collect()
            ->merge($authUser->followings->pluck('id'))
            ->merge($authUser->followers->pluck('id'))
            ->push($authUser->id)
            ->unique();

        $this->users = User::query()
            ->where('s_lang', $authUser->s_lang)
            ->whereNotIn('id', $excludedIds)
            // ->where('status', 'active') 
            ->limit(3)
            ->get();
    }

    public function render()
    {
        return view('components.suggested-users');
    }
}