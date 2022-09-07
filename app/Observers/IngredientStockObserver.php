<?php

namespace App\Observers;

use App\Events\IngredientLowStockEvent;
use App\Events\IngredientOutOfStockEvent;
use App\Models\Ingredient;

class IngredientStockObserver
{
    /**
     * Handle the Ingredient "created" event.
     *
     * @param  \App\Models\Ingredient  $ingredient
     * @return void
     */
    public function created(Ingredient $ingredient)
    {
        //
    }

    /**
     * Handle the Ingredient "updated" event.
     *
     * @param  \App\Models\Ingredient  $ingredient
     * @return void
     */
    public function updated(Ingredient $ingredient)
    {
        // Low stock notification flag check
        if (!$ingredient->notified_low_stock) {
            // Fire low stock event if stock low
            if ($ingredient->stock < $ingredient->low_threshold) {
                event(new IngredientLowStockEvent($ingredient));
                $ingredient->updateQuietly(['notified_low_stock' => true]);
            }
        } else {
            // Clear low_stock_notified flag when stock being seeded
            if ($ingredient->stock > $ingredient->low_threshold) {
                $ingredient->updateQuietly(['notified_low_stock' => false]);
            }
        }

        // Out of stock flag check
        if (!$ingredient->notified_out_of_stock) {
            // Fire low stock event if stock low
            if ($ingredient->stock <= 0) {
                event(new IngredientOutOfStockEvent($ingredient));
                $ingredient->updateQuietly(['notified_out_of_stock' => true]);
            }
        } else {
            // Clear low_stock_notified flag when stock being seeded
            if ($ingredient->stock) {
                $ingredient->updateQuietly(['notified_out_of_stock' => false]);
            }
        }
    }

    /**
     * Handle the Ingredient "deleted" event.
     *
     * @param  \App\Models\Ingredient  $ingredient
     * @return void
     */
    public function deleted(Ingredient $ingredient)
    {
        //
    }

    /**
     * Handle the Ingredient "restored" event.
     *
     * @param  \App\Models\Ingredient  $ingredient
     * @return void
     */
    public function restored(Ingredient $ingredient)
    {
        //
    }

    /**
     * Handle the Ingredient "force deleted" event.
     *
     * @param  \App\Models\Ingredient  $ingredient
     * @return void
     */
    public function forceDeleted(Ingredient $ingredient)
    {
        //
    }
}
