<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\User;
use App\Models\Language;
use App\Models\Discussion;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ProfileController extends Controller
{
    private function getCalendarData()
    {
        $now = Carbon::now();

        $year = $now->year;
        $month = $now->month;

        $daysInMonth = $now->daysInMonth;

        $startOfMonth = Carbon::create($year, $month, 1);
        $startDayOfWeek = $startOfMonth->dayOfWeek;

        return [
            'year' => $year,
            'month' => $month,
            'daysInMonth' => $daysInMonth,
            'startDayOfWeek' => $startDayOfWeek
        ];
    }

    private function getActivityData($userId)
    {

        $posts = DB::table('posts')
            ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->where('user_id', $userId)
            ->groupBy('date');

        $comments = DB::table('comments')
            ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->where('user_id', $userId)
            ->groupBy('date');

        return $posts
            ->unionAll($comments)
            ->get()
            ->groupBy('date')
            ->map(fn($items) => $items->sum('count'));

    }



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
        $activityData = $this->getActivityData($user->id);

        return view('profile.profile', array_merge([
            'user' => $user,
            'posts' => $user->posts()->latest()->with('user')->get(),
            'questions' => $user->questions()->latest()->with('user')->get(),
            'activityData' => $activityData
        ], $this->getCalendarData()));
    }

    public function questions(User $user)
    {
        $user->loadCount(['posts', 'questions']);
        $activityData = $this->getActivityData($user->id);

        return view('profile.profile', array_merge([
            'user' => $user,
            'questions' => $user->questions()->latest()->get(),
            'activityData' => $activityData
        ], $this->getCalendarData()));
    }

    public function discussions(User $user)
    {
        if (auth()->user()->role_id !== 3) {
            abort(403, 'Unauthorized action.');
        }

        $user->loadCount(['posts', 'questions']);

        $discussions = $user->discussions()
            ->latest()
            ->paginate(10);

        $activityData = $this->getActivityData($user->id);

        return view('profile.profile', array_merge( [
            'user' => $user,
            'discussions' => $discussions,
            'activityData' => $activityData
        ], $this->getCalendarData()));
    }


    public function following(User $user)
    {
        $user->loadCount(['posts', 'questions', 'followings']);

        $activityData = $this->getActivityData($user->id);

        return view('profile.profile', array_merge( [
            'user' => $user,
            // 'tab' => 'following',
            'followings' => $user->followings()->get(),
            'activityData' => $activityData
        ], $this->getCalendarData()));
    }


    public function followers(User $user)
    {
        $user->loadCount(['posts', 'questions', 'followers']);

        $activityData = $this->getActivityData($user->id);

        return view('profile.profile', array_merge([
            'user' => $user,
            // 'tab' => 'followers',
            'followers' => $user->followers()->get(),
            'activityData' => $activityData
        ], $this->getCalendarData()));
    }

    public function bookmarks(User $user)
    {
        if (auth()->id() !== $user->id) {
            abort(403);
        }

        $bookmarks = $user->bookmarks()
            ->with('bookmarkable.user', 'bookmarkable.tags')
            ->latest()
            ->paginate(10);

        $activityData = $this->getActivityData($user->id);

        return view('profile.profile', array_merge([
            'user' => $user,
            'bookmarks' => $bookmarks,
            'activityData' => $activityData
        ], $this->getCalendarData()));
    }


    public function notifications(User $user)
    {
        $user->loadCount(['posts', 'questions']);

        // do not show others' notification
        if (Auth::id() !== $user->id) {
            abort(403);
        }

        $notifications = $user->notifications()
            ->orderByRaw('read_at IS NOT NULL')
            ->latest()
            ->get();

        $activityData = $this->getActivityData($user->id);

        return view('profile.profile',array_merge([
            'user' => $user,
            'notifications' => $notifications,
            'activeTab' => 'notifications',
            'activityData' => $activityData
        ], $this->getCalendarData()));
    }
}
