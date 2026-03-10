<?php

namespace App\Services;

use App\Models\User;
use App\Models\UserActivity;
use Carbon\Carbon;

class StreakService
{
    public static function update(User $user)
    {

        $today = Carbon::today();

        // activity保存
        UserActivity::firstOrCreate([
            'user_id' => $user->id,
            'activity_date' => $today
        ]);

        $last = $user->last_activity_date;

        if (!$last) {

            $user->current_streak = 1;

        } else {

            $diff = Carbon::parse($last)->diffInDays($today);

            if ($diff === 0) {
                return;
            }

            if ($diff === 1) {
                $user->current_streak += 1;
            } else {
                $user->current_streak = 1;
            }

        }

        if ($user->current_streak > $user->longest_streak) {
            $user->longest_streak = $user->current_streak;
        }

        $user->last_activity_date = $today;

        $user->save();
    }
}