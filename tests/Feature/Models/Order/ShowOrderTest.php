<?php

namespace Tests\Feature\Models\Order;

use Illuminate\Foundation\Testing\WithFaker;
use Tests\CustomerTestCase;

class ShowOrderTest extends CustomerTestCase
{
    use WithFaker;

    public function testNotFoundOrder(): void
    {
        // Act
        $orderId = $this->faker->uuid();
        $response = $this->getJson("/api/orders/{$orderId}");

        // Assert
        $response->assertStatus(404);
    }
    public function testExistingOrder(): void
    {
        // Arrange
        $order = auth()->user()->orders()->create();

        // Act
        $response = $this->getJson("/api/orders/{$order->id}");

        // Assert
        $response->assertStatus(200);
        $response->assertJsonPath('data.id', $order->id);
    }
}
