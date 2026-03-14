<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('streaks:update', function () {
    \App\Models\User::all()->each(function ($user) {
        \App\Services\StreakService::update($user);
    });
});

Schedule::command('streaks:update')->daily();