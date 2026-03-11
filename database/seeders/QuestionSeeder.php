<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Question;
use App\Models\User;
use App\Models\Language;

class QuestionSeeder extends Seeder
{

    public function run(): void
    {
        // 1. 一般ユーザー（role_id = 2）のみを取得
        $students = User::where('role_id', 2)->get();
        $allLanguages = Language::all();

        if ($students->isEmpty() || $allLanguages->isEmpty()) {
            $this->command->error("Students or Languages are missing.");
            return;
        }

        // 2. 言語ごとのダミーデータセット
        $questionSamples = [
            'English' => [
                'title' => 'Natural way to say this?',
                'content' => 'I want to ask my boss for a day off. Is it natural to say "I want to rest tomorrow"?',
            ],
            'Japanese' => [
                'title' => '「お疲れ様」の使い分けについて',
                'content' => '仕事が終わった時と、誰かが何かに挑戦した時、どちらも「お疲れ様」でいいですか？',
            ],
            'Spanish' => [
                'title' => '¿Cuándo usar "Tú" y "Usted"?',
                'content' => 'Todavía tengo dificultades para diferenciar entre el trato formal e informal.',
            ],
            'Chinese' => [
                'title' => '关于“了解”和“理解”的区别',
                'content' => '在中文里，这两个词都有 to understand 的意思，请问用法有什么不同？',
            ],
        ];

        // 3. 100件の質問を作成
        for ($i = 1; $i <= 100; $i++) {
            $user = $students->random();

            // --- ロジック変更：50%の確率で「学習中の言語」を使って質問を書く ---
            $isAdvanced = (rand(1, 10) <= 5);
            $writingLangId = $isAdvanced ? $user->s_lang : $user->f_lang;

            // 言語モデルを取得して、中身の文章を決定
            $writingLang = $allLanguages->find($writingLangId);
            $sample = $questionSamples[$writingLang->name ?? 'English'] ?? $questionSamples['English'];

            // 質問データを作成
            $question = Question::create([
                'user_id' => $user->id,
                'written_lang' => $writingLangId, // 50%で母国語、50%で学習言語
                'q_title' => $sample['title'] . ($isAdvanced ? " (Advanced)" : "") . " #{$i}",
                'q_content' => $sample['content'],
            ]);

            // --- 質問の対象タグ（何語についての質問か） ---
            // 基本的には学習言語(s_lang)についての質問にする
            // ただし、稀に全く別の第3言語に興味を持つユーザーも混ぜる（遊び心）
            $targetLangId = (rand(1, 10) <= 8) ? $user->s_lang : $allLanguages->random()->id;

            $question->tags()->attach($targetLangId);
        }

        $this->command->info("QuestionSeeder: 25 hybrid questions created successfully.");
    }
}
