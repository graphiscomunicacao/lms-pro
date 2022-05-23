<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'email' => $this->faker->unique->email,
            'total_experience' => $this->faker->randomNumber(0),
            'email_verified_at' => now(),
            'password' => \Hash::make('password'),
            'remember_token' => Str::random(10),
            'role_id' => \App\Models\Role::factory(),
            'job_id' => \App\Models\Job::factory(),
            'group_id' => \App\Models\Group::factory(),
            'user_id' => function () {
                return \App\Models\User::factory()->create([
                    'user_id' => null,
                ])->id;
            },
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }
}
