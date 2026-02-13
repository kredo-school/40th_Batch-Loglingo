<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Comment;
use App\Models\User;
use App\Models\Language;
use App\Models\Post;

class CommentSeeder extends Seeder
{

    public function run(): void
    {
        $posts = Post::all();

        foreach ($posts as $post) {
            Comment::factory()
                ->count(3)
                ->create([
                    'post_id' => $post->id,
                ]);
        }
    }
    
}