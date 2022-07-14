<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use App\Models\LearningArtifact;
use Illuminate\Database\Eloquent\Factories\Factory;

class LearningArtifactFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = LearningArtifact::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            // 'type' => 'audio',
            // 'size' => $this->faker->randomFloat(2, 0, 9999),
            // 'path' => $this->faker->text(255),
            'description' => $this->faker->sentence(15),
            'external' => $this->faker->boolean,
            'url' => $this->faker->url,
            'cover_path' => asset('img/covers/learning-artifact.svg'),
            'experience_amount' => $this->faker->randomNumber(0),
        ];
    }
}
