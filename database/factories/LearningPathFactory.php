<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use App\Models\LearningPath;
use Illuminate\Database\Eloquent\Factories\Factory;

class LearningPathFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = LearningPath::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'description' => $this->faker->sentence(15),
            'cover_path' => $this->faker->text(255),
            'start_time' => $this->faker->dateTime,
            'end_time' => $this->faker->dateTime,
            'availability_time' => $this->faker->randomNumber(0),
            'tries' => $this->faker->randomNumber(0),
            'passing_score' => $this->faker->randomNumber(0),
            'approval_goal' => $this->faker->randomNumber(0),
            'experience_amount' => $this->faker->randomNumber(0),
            'certificate_id' => \App\Models\Certificate::factory(),
        ];
    }
}
