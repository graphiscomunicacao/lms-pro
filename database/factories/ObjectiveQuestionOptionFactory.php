<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use App\Models\ObjectiveQuestionOption;
use Illuminate\Database\Eloquent\Factories\Factory;

class ObjectiveQuestionOptionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ObjectiveQuestionOption::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'body' => $this->faker->text,
            'is_correct' => $this->faker->boolean,
            'objective_question_id' => \App\Models\ObjectiveQuestion::factory(),
        ];
    }
}
