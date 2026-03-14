<?php

namespace App\Services;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use App\Models\UserActivity;
use Carbon\Carbon;

class StreakService
{
    public static function update(User $user)
    {

        $user = User::find($user->id);
        // $last = optional($user->last_activity_date)->toDateString();
        $streak = 0;
        $currentDate = Carbon::today();

        // activity保存
        UserActivity::firstOrCreate([
            'user_id' => $user->id,
            'activity_date' => $currentDate
        ]);

        while(true){

            Log::info('Checking date', [
                'checking' => $currentDate->toDateString()
            ]);

            $exists = UserActivity::where('user_id', $user->id)
                ->whereDate('activity_date', $currentDate)
                ->exists();

            Log::info('Exists?', [
                'date' => $currentDate->toDateString(),
                'exists' => $exists
            ]);

            if(!$exists){
                break;
            }

            $streak++;
            $currentDate = $currentDate->copy()->subDay();
        }

        Log::info('Final streak', ['streak' => $streak]);

        $user->current_streak = $streak;

        if ($streak > $user->longest_streak) {
            $user->longest_streak = $streak;
        }
        
        $user->last_activity_date = $currentDate;
        $user->save();

        Log::info('StreakService updated user', [
            'id' => $user->id,
            'current_streak' => $user->current_streak,
            'last_activity_date' => $user->last_activity_date,
        ]);
        // $last = $user->last_activity_date;
        // dd($last, $today, Carbon::parse($last)->diffInDays($today));
        // if (!$last) {

        //     $user->current_streak = 1;
        //     Log::info('Message');
        // } else {

        //     $diff = Carbon::parse($last)->diffInDays($today);

        //     if ($diff === 0) {
        //         return;
        //     }

        //     if ($diff === 1) {
        //         $user->current_streak += 1;
        //     } else {
        //         $user->current_streak = 1;
        //     }

        // }

        // if ($user->current_streak > $user->longest_streak) {
        //     $user->longest_streak = $user->current_streak;
        // }
    }
}