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
        // 1. （role_id = 3）
        $teachers = User::where('role_id', 3)->get();
        $questions = Question::all();

        if ($teachers->isEmpty()) {
            $this->command->error("No teachers found. Please run UserSeeder first.");
            return;
        }

        foreach ($questions as $question) {
            // 2. 50% generate answer
            if (rand(1, 10) <= 5) {
                // 1 to 3 
                $answerCount = rand(1, 3);

                for ($i = 0; $i < $answerCount; $i++) {
                    Answer::create([
                        'question_id' => $question->id,
                        'user_id' => $teachers->random()->id, // choose teacher randomly
                        'a_content' => "This is a professional answer from a teacher regarding your question. Keep up the good work!\n
\n
I have carefully reviewed your inquiry and the progress you have shown so far. It is truly impressive to see such a dedicated approach to your studies; this level of curiosity is exactly what leads to academic excellence.\n
\n
In response to your specific question, please remember that mastering these concepts takes time and consistent practice. Do not be discouraged by complex challenges, as they are merely stepping stones toward a deeper understanding of the subject matter.\n
\n
I have provided some detailed feedback below to help guide your next steps. I encourage you to review the foundational principles we discussed in class and apply them to this new context. Your analytical skills are developing rapidly, and I am confident that you will reach your goals if you maintain this momentum.\n
\n
If you encounter any further roadblocks, please do not hesitate to reach out. I am here to support your intellectual growth every step of the way.\n
\n
Stay focused, stay curious, and most importantly, keep up the excellent work!"
                    ]);
                }
            }
        }

        $this->command->info("AnswerSeeder: Answers created (Only Teachers, 50% frequency).");
    }
}
