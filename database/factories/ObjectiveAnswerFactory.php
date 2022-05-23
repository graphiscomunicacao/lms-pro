<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use App\Models\ObjectiveAnswer;
use Illuminate\Database\Eloquent\Factories\Factory;

class ObjectiveAnswerFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ObjectiveAnswer::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'is_correct' => $this->faker->boolean,
            'time_spent' => $this->faker->randomNumber(0),
            'user_id' => \App\Models\User::factory(),
            'objective_question_id' => \App\Models\ObjectiveQuestion::factory(),
            'objective_question_option_id' => \App\Models\ObjectiveQuestionOption::factory(),
        ];
    }
}
