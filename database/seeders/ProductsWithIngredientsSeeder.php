<?php

namespace Database\Seeders;

use App\Models\Ingredient;
use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductsWithIngredientsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Product::factory()->state(function () {
            return [
                'name'  =>  'Burger'
            ];
        })->afterCreating(function (Product $product) {
            $product->product_ingredients()->create([
                'ingredient_id' => Ingredient::query()->firstWhere(['name'=>'Beef'])->getKey(),
                'amount' => 150,
            ]);
            $product->product_ingredients()->create([
                'ingredient_id' => Ingredient::query()->firstWhere(['name'=>'Cheese'])->getKey(),
                'amount' => 30,
            ]);
            $product->product_ingredients()->create([
                'ingredient_id' => Ingredient::query()->firstWhere(['name'=>'Onion'])->getKey(),
                'amount' => 20,
            ]);
        })->createOne();

    }
}
