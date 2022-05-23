<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use App\Models\LearningPathGroupResult;
use Illuminate\Database\Eloquent\Factories\Factory;

class LearningPathGroupResultFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = LearningPathGroupResult::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'submited_at' => $this->faker->dateTime,
            'score' => $this->faker->randomNumber(0),
            'user_id' => \App\Models\User::factory(),
            'learning_path_group_id' => \App\Models\LearningPathGroup::factory(),
        ];
    }
}
