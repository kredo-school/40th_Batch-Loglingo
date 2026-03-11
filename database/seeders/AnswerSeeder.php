<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Answer;
use App\Models\User;
use App\Models\Question;

class AnswerSeeder extends Seeder
{
    public function run(): void
    {
        // 1. 先生（role_id = 3）のユーザーだけを抽出
        $teachers = User::where('role_id', 3)->get();
        $questions = Question::all();

        if ($teachers->isEmpty()) {
            $this->command->error("No teachers found. Please run UserSeeder first.");
            return;
        }

        foreach ($questions as $question) {
            // 2. 50%の確率で回答を作成
            if (rand(1, 10) <= 5) {
                // 回答数を1〜3件でランダムに設定
                $answerCount = rand(1, 3);

                for ($i = 0; $i < $answerCount; $i++) {
                    Answer::create([
                        'question_id' => $question->id,
                        'user_id' => $teachers->random()->id, // ランダムに先生を一人選ぶ
                        'a_content' => "This is a professional answer from a teacher regarding your question. Keep up the good work!",
                    ]);
                }
            }
        }

        $this->command->info("AnswerSeeder: Answers created (Only Teachers, 50% frequency).");
    }
}
