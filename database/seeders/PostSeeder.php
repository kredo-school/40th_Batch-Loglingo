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
                'content' => "Today I practiced coding with Laravel for a few hours.\nI reviewed validation, Blade components, and Alpine.js behavior.\nIt was challenging, but I felt happy because I could fix several bugs by myself.\nI want to keep improving little by little every day.",
            ],
            'Japanese' => [
                'title' => '今日の学習記録',
                'content' => "今日は Laravel の復習をしながら、投稿機能やバリデーションの確認をしました。\nエラーが出たところもありましたが、原因を一つずつ確認して修正できました。\n少しずつでも前に進んでいる感じがしてうれしかったです。\n明日も継続して頑張りたいです。",
            ],
            'Spanish' => [
                'title' => 'Mi comida favorita',
                'content' => "Me encanta comer pizza con mis amigos los fines de semana.\nEspecialmente me gusta la pizza con mucho queso y tomate fresco.\nCuando tenemos tiempo, también hablamos en español para practicar juntos.\nEs una manera divertida de aprender y disfrutar al mismo tiempo.",
            ],
            'Chinese' => [
                'title' => '学习汉语',
                'content' => "我觉得汉字很有意思，而且每个字看起来都很有特点。\n虽然发音对我来说有一点难,但是我想继续努力学习。\n今天我复习了几个新的单词,也练习了简单的句子。\n如果我每天坚持一点点,我一定会慢慢进步。",
            ],
        ];

        for ($i = 1; $i <= 500; $i++) {
            $user = $students->random();

            // --- 90% by s_lang 10& by f_lang ---
            $writingLangId = (rand(1, 10) <= 9) ? $user->s_lang : $user->f_lang;

            $writingLang = $allLanguages->find($writingLangId);
            $sample = $contentSamples[$writingLang->name ?? 'English'] ?? $contentSamples['English'];

            $post = Post::create([
                'user_id' => $user->id,
                'p_title' => $sample['title'] . " #{$i}",
                'p_content' => $sample['content'],
                'event_date' => now()->subDays(rand(0, 30))->format('Y-m-d'),
            ]);

            // its language tag accords with written_lang
            $post->tags()->attach($writingLangId);
        }

        $this->command->info("PostSeeder: 25 posts created (90% in study language).");
    }
}
