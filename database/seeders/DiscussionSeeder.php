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

        // 1. 通常のディスカッションを 90件 生成（合計100にするため）
        Discussion::factory(90)
            ->make()
            ->each(function ($discussion) use ($users, $languages) {

                // 3割の確率で引用(question_id)をなしにする
                if (rand(1, 10) <= 3) {
                    $discussion->question_id = null;
                    // タイトルを少し変えて「一般トピック」感を出す
                    $discussion->d_title = "Topic: " . $discussion->d_title;
                }
                $discussion->save();

                // 言語タグの紐付け
                $discussion->tags()->attach(
                    $languages->random(1)->pluck('id')->toArray()
                );

                // 返信データの作成（1〜5件でバラけさせる）
                Reply::factory(rand(1, 5))->create([
                    'discussion_id' => $discussion->id,
                ]);

                // 20%の確率で通報
                if (rand(1, 10) > 8) {
                    $discussion->reports()->create([
                        'user_id' => $users->random()->id,
                    ]);
                }
            });

        // 2. 通報が多いテスト用データを 10件 生成
        Discussion::factory(10)
            ->make(['d_title' => '⚠️ HIGH REPORT TEST'])
            ->each(function ($discussion) use ($users, $languages) {

                // ここも3割の確率で引用なし
                if (rand(1, 10) <= 3) {
                    $discussion->question_id = null;
                }
                $discussion->save();

                $discussion->tags()->attach(
                    $languages->random(1)->pluck('id')->toArray()
                );

                // 5人から通報
                $shuffledUsers = $users->shuffle();
                for ($i = 0; $i < min(5, $shuffledUsers->count()); $i++) {
                    $discussion->reports()->create([
                        'user_id' => $shuffledUsers[$i]->id,
                    ]);
                }

                // 返信にも通報
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
