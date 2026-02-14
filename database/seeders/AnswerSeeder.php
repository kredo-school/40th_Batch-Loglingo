<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Answer;
use App\Models\User;
use App\Models\Language;
use App\Models\Question;

class AnswerSeeder extends Seeder
{

    public function run(): void
    {
        $questions = Question::all();

        foreach ($questions as $question) {
            Answer::factory()
                ->count(3)
                ->create([
                    'question_id' => $question->id,
                ]);
        }
    }
    
}