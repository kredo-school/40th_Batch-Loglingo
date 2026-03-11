<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Post;
use App\Models\User;
use App\Models\Language;

class PostSeeder extends Seeder
{

    public function run(): void
    {
        $students = User::where('role_id', 2)->get();
        $allLanguages = Language::all();

        if ($students->isEmpty() || $allLanguages->isEmpty()) {
            $this->command->error("Students or Languages are missing.");
            return;
        }

        $contentSamples = [
            'English' => [
                'title' => 'My Daily Life',
                'content' => 'Today I practiced coding in Laravel. It is challenging but fun!',
            ],
            'Japanese' => [
                'title' => '今日の学習記録',
                'content' => '今日は新しい単語を10個覚えました。継続は力なりですね。',
            ],
            'Spanish' => [
                'title' => 'Mi comida favorita',
                'content' => 'Me encanta comer pizza con mis amigos los fines de semana.',
            ],
            'Chinese' => [
                'title' => '学习汉语',
                'content' => '我觉得汉字很有意思，但是发音有点难。',
            ],
        ];

        for ($i = 1; $i <= 200; $i++) {
            $user = $students->random();
            
            // --- 9割の確率で学習言語(s_lang)、1割で母国語(f_lang)を選択 ---
            $writingLangId = (rand(1, 10) <= 9) ? $user->s_lang : $user->f_lang;
            
            $writingLang = $allLanguages->find($writingLangId);
            $sample = $contentSamples[$writingLang->name ?? 'English'] ?? $contentSamples['English'];

            $post = Post::create([
                'user_id' => $user->id,
                'p_title' => $sample['title'] . " #{$i}",
                'p_content' => $sample['content'],
                'event_date' => now()->subDays(rand(0, 30))->format('Y-m-d'),
            ]);

            // 日記に紐付く言語タグも、書いた言語と一致させる
            $post->tags()->attach($writingLangId);
        }

        $this->command->info("PostSeeder: 25 posts created (90% in study language).");
    }
}
