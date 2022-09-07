<?php

namespace Tests\Unit\Notifications;

use App\Models\Ingredient;
use App\Models\User;
use App\Notifications\IngredientOutOfStockNotification;
use Illuminate\Support\Facades\Notification;
use Tests\CustomerTestCase;
use Tests\Traits\PrepareOrder;

class IngredientOutOfStockNotificationTest extends CustomerTestCase
{
    use PrepareOrder;

    protected function setUp(): void
    {
        parent::setUp();
        Notification::fake();
    }

    public function testStockUpdateToMoreThanZero()
    {
        // Arrange
        $ingredient = Ingredient::first();
        $originalStock = $ingredient->stock;

        // Act
        $ingredient->update([
            'stock' => 0.1 * $originalStock
        ]);

        // Assert
        Notification::assertNotSentTo(User::where('role', 'merchant')->first(), IngredientOutOfStockNotification::class);
    }

    public function testStockUpdateToZero()
    {
        // Arrange
        $ingredient = Ingredient::first();

        // Act
        $ingredient->update([
            'stock' => 0
        ]);

        // Assert
        Notification::assertSentToTimes(User::where('role', 'merchant')->first(), IngredientOutOfStockNotification::class, 1);
    }

    public function testStockUpdateToZeroMultipleTimes()
    {
        // Arrange
        $ingredient = Ingredient::first();

        // Act
        $ingredient->update([
            'stock' => 0
        ]);
        $ingredient->update([
            'stock' => 0
        ]);
        $ingredient->update([
            'stock' => 0
        ]);

        // Assert
        Notification::assertSentToTimes(User::where('role', 'merchant')->first(), IngredientOutOfStockNotification::class, 1);
    }

    public function testStockUpdateToZeroAgainAfterFeeding()
    {
        // Arrange
        $ingredient = Ingredient::first();
        $originalStock = $ingredient->stock;

        // Act
        $ingredient->update([
            'stock' => 0    // Consume All
        ]);
        $ingredient->update([
            'stock' => 0.75 * $originalStock    // Feed
        ]);
        $ingredient->update([
            'stock' => 0     // Consume All
        ]);

        // Assert
        Notification::assertSentToTimes(User::where('role', 'merchant')->first(), IngredientOutOfStockNotification::class, 2);
    }
}
