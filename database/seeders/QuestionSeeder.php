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
        $user = User::first();
        $japanese = Language::where('name', 'Japanese')->first();
        $english = Language::where('name', 'English')->first();

        for ($i = 1; $i <= 25; $i++) {
        $question = Question::create([
            'user_id' => $user->id,
            'written_lang' => ($i % 2 == 0) ? $english->id : $japanese->id,
            'q_title' => "Test Question Title No.{$i}",
            'q_content' => "This is the dummy content for question number {$i}. It helps to check the layout and pagination.",
            ]);

            $question->tags()->attach($english->id); 

        }

        
    }
}
