<?php

namespace Database\Seeders;

use App\Models\Ingredient;
use Illuminate\Database\Seeder;

class IngredientsWithStockSeeder extends Seeder
{

    const INITIAL_SEED = [
        'Beef' => 20000,
        'Cheese' => 5000,
        'Onion' => 1000,
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        foreach(self::INITIAL_SEED as $ingredientName => $seedAmount) {
            Ingredient::factory()->state(function () use ($ingredientName, $seedAmount) {
                return [
                    'name'  =>  $ingredientName,
                    'stock' => $seedAmount,
                    'low_threshold' => (int) (0.5 * $seedAmount)
                ];
            })->afterCreating(function (Ingredient $ingredient) use ($seedAmount) {
                $ingredient->stock_activities()->create([
                    'in' => $seedAmount,
                    'remaining' => $seedAmount,
                    'comment' => 'Initial Seed'
                ]);
            })->createOne();
        }
    }
}
