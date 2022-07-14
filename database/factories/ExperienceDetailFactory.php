<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use App\Models\ExperienceDetail;
use Illuminate\Database\Eloquent\Factories\Factory;

class ExperienceDetailFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ExperienceDetail::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'experience_amount' => $this->faker->randomNumber(0),
            'is_double' => $this->faker->boolean,
            'type' => 'LearningArtifact',
            'item_id' => $this->faker->randomNumber(0),
            'user_id' => \App\Models\User::factory(),
        ];
    }
}
