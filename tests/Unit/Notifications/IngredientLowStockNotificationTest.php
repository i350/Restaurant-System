<?php

namespace Tests\Unit\Notifications;

use App\Models\Ingredient;
use App\Models\User;
use App\Notifications\IngredientLowStockNotification;
use Illuminate\Support\Facades\Notification;
use Tests\CustomerTestCase;
use Tests\Traits\PrepareOrder;

class IngredientLowStockNotificationTest extends CustomerTestCase
{
    use PrepareOrder;

    protected function setUp(): void
    {
        parent::setUp();
        Notification::fake();
    }

    public function testStockUpdateToMoreThan50()
    {
        // Arrange
        $ingredient = Ingredient::first();
        $originalStock = $ingredient->stock;

        // Act
        $ingredient->update([
            'stock' => 0.75 * $originalStock
        ]);

        // Assert
        Notification::assertNothingSent();
    }

    public function testStockUpdateToLessThan50()
    {
        // Arrange
        $ingredient = Ingredient::first();
        $originalStock = $ingredient->stock;

        // Act
        $ingredient->update([
            'stock' => 0.45 * $originalStock
        ]);

        // Assert
        Notification::assertSentToTimes(User::where('role', 'merchant')->first(), IngredientLowStockNotification::class, 1);
    }

    public function testStockUpdateToLessThan50MultipleTimes()
    {
        // Arrange
        $ingredient = Ingredient::first();
        $originalStock = $ingredient->stock;

        // Act
        $ingredient->update([
            'stock' => 0.45 * $originalStock
        ]);
        $ingredient->update([
            'stock' => 0.25 * $originalStock
        ]);
        $ingredient->update([
            'stock' => 0.1 * $originalStock
        ]);

        // Assert
        Notification::assertSentToTimes(User::where('role', 'merchant')->first(), IngredientLowStockNotification::class, 1);
    }

    public function testStockUpdateToLessThan50AgainAfterFeeding()
    {
        // Arrange
        $ingredient = Ingredient::first();
        $originalStock = $ingredient->stock;

        // Act
        $ingredient->update([
            'stock' => 0.45 * $originalStock    // Consume
        ]);
        $ingredient->update([
            'stock' => 0.75 * $originalStock    // Feed
        ]);
        $ingredient->update([
            'stock' => 0.45 * $originalStock     // Consume
        ]);

        // Assert
        Notification::assertSentToTimes(User::where('role', 'merchant')->first(), IngredientLowStockNotification::class, 2);
    }
}
