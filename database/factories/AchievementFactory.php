<?php

namespace Database\Factories;

use App\Models\Achievement;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class AchievementFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Achievement::class;

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
            'image_path' => $this->faker->text(255),
            'requirements' => $this->faker->text(255),
        ];
    }
}
