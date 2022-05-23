<?php

namespace Database\Factories;

use App\Models\Quiz;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class QuizFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Quiz::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'slug' => $this->faker->slug,
            'description' => $this->faker->sentence(15),
            'time_limit' => $this->faker->time,
            'cover_path' => $this->faker->text(255),
            'experience_amount' => $this->faker->randomNumber(0),
        ];
    }
}
