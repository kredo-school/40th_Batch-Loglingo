<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Discussion;
use App\Models\Reply;
use App\Models\Language;
use App\Models\User;

class DiscussionSeeder extends Seeder
{

    public function run(): void
    {
        $users = User::all();
        $languages = Language::all();

        // 1. generate 10 normal data
        Discussion::factory(25)
            ->create()
            ->each(function ($discussion) use ($users,$languages) {
                //add languag
                $discussion->tags()->attach(
                    $languages->random(1)->pluck('id')->toArray()
                );

                // generate reply data to each discussion
                $replies = Reply::factory(rand(2, 3))->create([
                    'discussion_id' => $discussion->id,
                ]);

                // 20% add report
                if (rand(1, 10) > 8) {
                    $discussion->reports()->create([
                        'user_id' => $users->random()->id,
                    ]);
                }
            });

        // 2. generate 3 discussions with many reports 
        Discussion::factory(10)
            ->create(['d_title' => '⚠️ HIGH REPORT TEST'])
            ->each(function ($discussion) use ($users, $languages) {
                // --- add language ---
                $discussion->tags()->attach(
                    $languages->random(1)->pluck('id')->toArray()
                );

                // 5 reports to discussion
                $shuffledUsers = $users->shuffle();

                for ($i = 0; $i < 5; $i++) {
                    $discussion->reports()->create([
                        'user_id' => $shuffledUsers[$i]->id, // $i use user number
                    ]);
                }

                // reports to its reply
                Reply::factory(3)->create([
                    'discussion_id' => $discussion->id,
                ])->each(function ($reply) use ($users) {
                    // 2 reports each
                    $replyUsers = $users->shuffle();

                    for ($j = 0; $j < 2; $j++) {
                        $reply->reports()->create([
                            'user_id' => $replyUsers[$j]->id,
                        ]);
                    }
                });
            });
    }
}
