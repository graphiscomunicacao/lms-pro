<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use App\Models\LearningPathGroup;
use Illuminate\Database\Eloquent\Factories\Factory;

class LearningPathGroupFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = LearningPathGroup::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'cover_path' => $this->faker->text(255),
            'name' => $this->faker->name,
            'description' => $this->faker->sentence(15),
            'start_time' => $this->faker->dateTime,
            'end_time' => $this->faker->dateTime,
            'availability_time' => $this->faker->randomNumber(0),
            'tries' => $this->faker->randomNumber(0),
            'approval_goal' => $this->faker->randomNumber(0),
            'passing_score' => $this->faker->randomNumber(0),
        ];
    }
}
