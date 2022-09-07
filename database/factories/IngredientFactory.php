<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Ingredient>
 */
class IngredientFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'stock' => $this->faker->randomDigitNotNull(),
            'low_threshold' => 0,
            'notified_low_stock' => false,
            'notified_out_of_stock' => false,
        ];
    }
}
