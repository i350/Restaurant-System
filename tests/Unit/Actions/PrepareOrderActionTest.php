<?php

namespace Tests\Unit\Actions;

use App\Exceptions\NoEnoughIngredients;
use App\Models\Product;
use App\Models\ProductIngredient;
use Tests\CustomerTestCase;
use Tests\Traits\PrepareOrder;

class PrepareOrderActionTest extends CustomerTestCase
{
    use PrepareOrder;

    public function testPrepareNormalOrder()
    {
        // Arrange
        /** @var Product $product */
        $product = Product::first();
        $quantity = 2;
        $ingredientsStockExpectations = $product->product_ingredients()
            ->with('ingredient')
            ->get()
            ->mapWithKeys(function (ProductIngredient $productIngredient) use ($quantity) {
                $ingredient = $productIngredient->ingredient;
                $originalStock = $ingredient->stock;
                $expectedConsumption = $quantity * $productIngredient->amount;
                return [
                    $ingredient->id => $originalStock - $expectedConsumption
                ];
            });

        // Act
        $order = $this->prepareOrder($quantity, $product);

        // Assert
        $this->assertDatabaseHas('orders', ['id' => $order->id]);
        $product->product_ingredients()->with('ingredient')->each(function (ProductIngredient $productIngredient) use ($ingredientsStockExpectations) {
            $ingredient = $productIngredient->ingredient;
            $this->assertEquals($ingredient->stock, $ingredientsStockExpectations[$ingredient->getKey()]);
        });
    }

    public function testPrepareOrderMoreThanAvailableStock()
    {
        // Arrange
        /** @var Product $product */
        $product = Product::first();
        $quantity = 100;
        $this->expectException(NoEnoughIngredients::class);

        // Act
        $this->prepareOrder($quantity, $product);

        // Assert
        $this->assertDatabaseCount('orders', 0);
    }
}
