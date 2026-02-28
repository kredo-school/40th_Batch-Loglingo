<?php

namespace App\View\Components;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\Component;

class SuggestedUsers extends Component
{
    public $users;
    public $isAll = false;

    public function __construct()
    {
        $authUser = Auth::user();

        if (!$authUser) {
            $this->users = collect();
            return;
        }

        $this->isAll = request('suggested') === 'all';
        $limit = $this->isAll ? 15 : 3;

        $excludedIds = collect()
            ->merge($authUser->followings->pluck('id'))
            ->merge($authUser->followers->pluck('id'))
            ->push($authUser->id)
            ->unique();

        $this->users = User::query()
            ->where('s_lang', $authUser->s_lang)
            ->whereNotIn('id', $excludedIds)
            ->limit($limit)
            ->get();
    }

    public function render()
    {
        return view('components.suggested-users');
    }

    
}