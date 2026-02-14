<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Report;
use App\Models\Question;
use App\Models\Answer;
use App\Models\Post;
use App\Models\Comment;
use App\Models\User;

class ReportSeeder extends Seeder
{
    public function run(): void
    {
        // 全ユーザーを取得（factoryで新規作成せず、既存のユーザーのみ使う）
        $users = User::all();

        // もしユーザーが極端に少ない場合はエラーになるので、
        // 少なくとも 15人 くらいは DB に登録されている状態で実行してください。
        if ($users->count() < 15) {
            $this->command->warn("Users table has only {$users->count()} users. Please register more users manually before seeding reports.");
            return;
        }

        // --- Question への通報 ---
        if ($question = Question::first()) {
            // 既存ユーザーからランダムに12人選んで通報作成
            foreach ($users->shuffle()->take(12) as $reporter) {
                Report::create([
                    'user_id' => $reporter->id,
                    'reportable_id' => $question->id,
                    'reportable_type' => Question::class,
                ]);
            }
        }

        // --- Answer への通報 ---
        if ($answer = Answer::first()) {
            foreach ($users->shuffle()->take(14) as $reporter) {
                Report::create([
                    'user_id' => $reporter->id,
                    'reportable_id' => $answer->id,
                    'reportable_type' => Answer::class,
                ]);
            }
        }

        // PostとCommentも同様のロジックで追加
        $this->seedSafeReports(Post::class, 11, $users);
        $this->seedSafeReports(Comment::class, 5, $users);
    }

    private function seedSafeReports($modelClass, $count, $users)
    {
        $target = $modelClass::first();
        if ($target && $users->count() >= $count) {
            foreach ($users->shuffle()->take($count) as $reporter) {
                Report::create([
                    'user_id' => $reporter->id,
                    'reportable_id' => $target->id,
                    'reportable_type' => $modelClass,
                ]);
            }
        }
    }
}