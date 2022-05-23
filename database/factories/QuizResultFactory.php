<?php

namespace Database\Factories;

use App\Models\QuizResult;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class QuizResultFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = QuizResult::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'submited_at' => $this->faker->dateTime,
            'result' => $this->faker->randomNumber(0),
            'quiz_id' => \App\Models\Quiz::factory(),
            'user_id' => \App\Models\User::factory(),
        ];
    }
}
