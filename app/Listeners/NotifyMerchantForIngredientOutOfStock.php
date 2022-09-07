<?php

namespace App\Listeners;

use App\Events\IngredientOutOfStockEvent;
use App\Models\User;
use App\Notifications\IngredientOutOfStockNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;

class NotifyMerchantForIngredientOutOfStock implements ShouldQueue
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
     * @param  object  $event
     * @return void
     */
    public function handle(IngredientOutOfStockEvent $event)
    {
        User::query()->where('role', 'merchant')->each(function (User $user) use ($event) {
            $user->notify(new IngredientOutOfStockNotification($event->getIngredient()));
        });
    }
}
