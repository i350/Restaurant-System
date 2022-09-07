<?php

namespace App\Listeners;

use App\Events\IngredientLowStockEvent;
use App\Models\User;
use App\Notifications\IngredientLowStockNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;

class NotifyMerchantForIngredientLowStock implements ShouldQueue
{
    use Queueable;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  IngredientLowStockEvent  $event
     * @return void
     */
    public function handle(IngredientLowStockEvent $event)
    {
        User::query()->where('role', 'merchant')->each(function (User $user) use ($event) {
            $user->notify(new IngredientLowStockNotification($event->getIngredient()));
        });
    }
}
