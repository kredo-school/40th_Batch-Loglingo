<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Comment;
use App\Models\Answer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    
    public function run(): void
    {
        $this->call([
            LanguageSeeder::class,
            UserSeeder::class,
            QuestionSeeder::class,
            PostSeeder::class,
            CommentSeeder::class,
            AnswerSeeder::class,
        ]);
    }
}
