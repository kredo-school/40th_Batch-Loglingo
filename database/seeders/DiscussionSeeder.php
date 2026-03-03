<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Discussion;
use App\Models\Reply;

class DiscussionSeeder extends Seeder
{

    public function run(): void
    {
        $users = \App\Models\User::all();

        // 1. 普通のデータを10件作成（たまに通報が混じる）
        Discussion::factory(10)
            ->create()
            ->each(function ($discussion) use ($users) {
                // 各DiscussionにReplyを2〜3個作成
                $replies = Reply::factory(rand(2, 3))->create([
                    'discussion_id' => $discussion->id,
                ]);

                // 20%の確率で、Discussion本体に1件通報を入れる
                if (rand(1, 10) > 8) {
                    $discussion->reports()->create([
                        'user_id' => $users->random()->id,
                    ]);
                }
            });

        // 2. 【テスト用】通報が大量にある「危険な議論」を3件作成
        // これにより、Admin画面で背景が赤くなる（Reports >= 10）のを確認できます
        Discussion::factory(3)
            ->create(['d_title' => '⚠️ HIGH REPORT TEST'])
            ->each(function ($discussion) use ($users) {

                // 本体に5件通報
                $shuffledUsers = $users->shuffle();

                for ($i = 0; $i < 5; $i++) {
                    $discussion->reports()->create([
                        'user_id' => $shuffledUsers[$i]->id, // $i 番目のユーザーを使う
                    ]);
                }

                // 返信にも通報を散らす（合計が10を超えるように）
                Reply::factory(3)->create([
                    'discussion_id' => $discussion->id,
                ])->each(function ($reply) use ($users) {
                    // 各返信に2件ずつ通報
                    $replyUsers = $users->shuffle(); // 再度シャッフル

                    for ($j = 0; $j < 2; $j++) {
                        $reply->reports()->create([
                            'user_id' => $replyUsers[$j]->id,
                        ]);
                    }
                });
            });
    }
}
