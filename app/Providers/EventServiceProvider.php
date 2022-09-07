<?php

namespace App\Providers;

use App\Events\IngredientLowStockEvent;
use App\Events\IngredientOutOfStockEvent;
use App\Listeners\NotifyMerchantForIngredientLowStock;
use App\Listeners\NotifyMerchantForIngredientOutOfStock;
use App\Models\Ingredient;
use App\Observers\IngredientStockObserver;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],

        IngredientLowStockEvent::class => [
            NotifyMerchantForIngredientLowStock::class,
        ],

        IngredientOutOfStockEvent::class => [
            NotifyMerchantForIngredientOutOfStock::class,
        ],
    ];


    /**
     * The model observers for your application.
     *
     * @var array
     */
    protected $observers = [
        Ingredient::class => [IngredientStockObserver::class],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     *
     * @return bool
     */
    public function shouldDiscoverEvents()
    {
        return false;
    }
}
