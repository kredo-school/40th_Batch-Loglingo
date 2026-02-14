<?php

namespace Database\Factories;

use App\Models\Answer;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Answer>
 */
class AnswerFactory extends Factory
{
    protected $model = Answer::class; 
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'a_content' => $this->faker->sentence(50),
            'user_id' => User::inRandomOrder()->first()->id,
            // question_id は Seeder 側で指定する
        ];
    }
}
