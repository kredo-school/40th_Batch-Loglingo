<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\User;
use App\Models\Language;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile edit form.
     */
     public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
            'languages' => Language::all(),
        ]);
    }

    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();

        // normal text data
        $user->fill($request->validated());

        // process only when avatar is uploaded
        if ($request->hasFile('avatar')) {
            $path = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = '/storage/' . $path;
        }

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        return Redirect::route('profile.show', $user);
    }


    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
   
    // tab controllers
        public function show(User $user)
        {
            $user->loadCount(['posts', 'questions']);

            return view('profile.profile', [
                'user' => $user,
                'posts' => $user->posts()->latest()->with('user')->get(),
                'questions' => $user->questions()->latest()->with('user')->get(),
            ]);

            
        }

        public function questions(User $user)
        {
            return view('profile.profile', [
                'user' => $user,
                'questions' => $user->questions()->latest()->get(),
            ]);
        }


        public function following(User $user)
        {
            $user->loadCount(['followings']);

            return view('profile.profile', [
                'user' => $user,
                // 'tab' => 'following',
                'followings' => $user->followings()->get(),
            ]);
        }
        

        public function followers(User $user)
        {
            $user->loadCount(['followers']);
            
            return view('profile.profile', [
                'user' => $user,
                // 'tab' => 'followers',
                'followers' => $user->followers()->get(),
            ]);
        }
    

}
