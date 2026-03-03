<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Question;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Discussion>
 */
class DiscussionFactory extends Factory
{
    
    public function definition(): array
    {
        return [
        'user_id' => User::all()->random()->id,
        'question_id' => Question::all()->random()->id,
        'd_title' => $this->faker->sentence(6),
        'd_content' => $this->faker->paragraphs(3, true),
        'status' => true,
        'is_resolved' => $this->faker->boolean(30),
    ];
    }
}
