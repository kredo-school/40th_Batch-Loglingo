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
        $user = User::first() ?? User::factory()->create();

        $japanese = Language::where('name', 'Japanese')->firstOrFail();
        $english = Language::where('name', 'English')->firstOrFail();

        for ($i = 1; $i <= 25; $i++) {
        $post = Post::create([
            'user_id' => $user->id,
            'p_title' => "Test Post Title No.{$i}",
            'p_content' => "This is the dummy content for Post number {$i}. It helps to check the layout and pagination.",
            'event_date' => "2026-02-09",
            ]);

            $post->tags()->attach($english->id); 

        }

        
    }
}
