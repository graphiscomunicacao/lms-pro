<?php

namespace Database\Factories;

use App\Models\MenuItem;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class MenuItemFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = MenuItem::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'item_type' => $this->faker->text(255),
            'item_id' => $this->faker->randomNumber(0),
            'order' => $this->faker->randomNumber(0),
            'menu_id' => \App\Models\Menu::factory(),
        ];
    }
}
