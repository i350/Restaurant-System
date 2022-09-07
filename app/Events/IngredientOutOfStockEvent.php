<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class IngredientOutOfStockEvent extends IngredientStockEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
}
