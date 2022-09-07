<?php

namespace Tests\Traits;

use App\Exceptions\NoEnoughIngredients;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;

trait PrepareOrder
{
    /**
     * @throws NoEnoughIngredients
     */
    protected function prepareOrder(int $quantity = 1, Product $product = null ): Order
    {
        $product ??= Product::first();
        $prepareOrder = new \App\Actions\Orders\PrepareOrder();
        $products = new Collection([$product]);

        return $prepareOrder($products, [$product->getKey() => $quantity]);
    }
}
