<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class FollowSeeder extends Seeder
{
public function run(): void
    {
        $users = User::all();

        foreach ($users as $user) {
            $others = $users->where('id', '!=', $user->id);

            if ($others->isEmpty()) {
                continue;
            }

            $count = rand(0, min(3, $others->count()));

            $others
                ->random($count)
                ->each(function ($other) use ($user) {
                    $user->followings()->syncWithoutDetaching($other->id);
                });
        }
    }
    

}
