<?php

namespace App\Actions\Orders;

use App\Exceptions\NoEnoughIngredients;
use App\Models\Ingredient;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductIngredient;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

class PrepareOrder
{
    public function __invoke(Collection $products, array $quantities): Order
    {
        DB::beginTransaction();

        /** @var Order $order */
        $order = auth()->user()->orders()->create();
        $products->each(function (Product $product) use ($quantities, &$order) {
            $quantity = $quantities[$product->getKey()];

            $product->product_ingredients->each(function (ProductIngredient $productIngredient) use ($product, $quantity, &$order) {
                /** @var Ingredient $ingredient */
                $ingredient = $productIngredient->ingredient;

                // Subtract consumed amount from stock
                try {
                    $ingredient->decrement('stock', $quantity*$productIngredient->amount);
                } catch (QueryException $e) {
                    throw new NoEnoughIngredients($product->name);
                }

                $remaining = $ingredient->stock;

                // Log stock activity
                $ingredient->stock_activities()->create([
                    'out' => $productIngredient->amount,
                    'remaining' => $remaining
                ]);
            });

            // Add product to order items
            $order->order_items()->create([
                'product_id' => $product->getKey(),
                'quantity' => $quantity,
            ]);
        });

        DB::commit();

        return $order;
    }
}
