<?php

namespace App\Events;

use App\Models\Ingredient;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

abstract class IngredientStockEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(
        protected Ingredient $ingredient,
    ) {
    }

    public function getIngredient(): Ingredient
    {
        return $this->ingredient;
    }
}
