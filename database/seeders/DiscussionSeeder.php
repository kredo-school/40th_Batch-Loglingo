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

        // 1. generate normal 90discussions
        Discussion::factory(150)
            ->make()
            ->each(function ($discussion) use ($users, $languages) {

                // 30% without quoted question
                if (rand(1, 10) <= 3) {
                    $discussion->question_id = null;
                    // change title
                    $discussion->d_title = "Topic: " . $discussion->d_title;
                }
                $discussion->save();

                // link language tag
                $discussion->tags()->attach(
                    $languages->random(1)->pluck('id')->toArray()
                );

                // generate replies 1 to 5
                Reply::factory(rand(1, 5))->create([
                    'discussion_id' => $discussion->id,
                ]);

                // 20% with reports
                if (rand(1, 10) > 8) {
                    $discussion->reports()->create([
                        'user_id' => $users->random()->id,
                    ]);
                }
            });

        // 2. 10 discussions with report
        Discussion::factory(10)
            ->make(['d_title' => '⚠️ HIGH REPORT TEST'])
            ->each(function ($discussion) use ($users, $languages) {

                // 30% without quoted question
                if (rand(1, 10) <= 3) {
                    $discussion->question_id = null;
                }
                $discussion->save();

                $discussion->tags()->attach(
                    $languages->random(1)->pluck('id')->toArray()
                );

                // 5 people report
                $shuffledUsers = $users->shuffle();
                for ($i = 0; $i < min(5, $shuffledUsers->count()); $i++) {
                    $discussion->reports()->create([
                        'user_id' => $shuffledUsers[$i]->id,
                    ]);
                }

                // report its reply as well
                Reply::factory(3)->create([
                    'discussion_id' => $discussion->id,
                ])->each(function ($reply) use ($users) {
                    $replyUsers = $users->shuffle();
                    for ($j = 0; $j < min(2, $replyUsers->count()); $j++) {
                        $reply->reports()->create([
                            'user_id' => $replyUsers[$j]->id,
                        ]);
                    }
                });
            });

        $this->command->info("DiscussionSeeder: 100 discussions created (with 30% no-quote topics).");
    }
}
