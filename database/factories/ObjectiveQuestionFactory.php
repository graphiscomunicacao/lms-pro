<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use App\Models\ObjectiveQuestion;
use Illuminate\Database\Eloquent\Factories\Factory;

class ObjectiveQuestionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ObjectiveQuestion::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'body' => $this->faker->text,
            'quiz_id' => \App\Models\Quiz::factory(),
            'answer_explanation' => $this->faker->text,
            'multi_option' => $this->faker->boolean,
            'randomize_options' => $this->faker->boolean,
        ];
    }
}
