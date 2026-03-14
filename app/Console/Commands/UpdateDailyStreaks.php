<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class UpdateDailyStreaks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'streaks:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        foreach (\App\Models\User::all() as $user){
            \App\Services\StreakService::update($user);
        }
    }
}
