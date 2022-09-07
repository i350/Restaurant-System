<?php

namespace Tests\Feature\Models\Order;

use Tests\CustomerTestCase;

class ListOrdersTest extends CustomerTestCase
{
    public function testEmptyList(): void
    {
        // Act
        $response = $this->getJson('/api/orders/');

        // Assert
        $response->assertStatus(200);
        $response->assertJsonPath('meta.total', 0);
        $response->assertJsonPath('data', []);
    }
    public function testNonEmptyList(): void
    {
        // Arrange
        $order = auth()->user()->orders()->create();

        // Act
        $response = $this->getJson('/api/orders/');

        // Assert
        $response->assertStatus(200);
        $response->assertJsonPath('meta.total', 1);
        $response->assertJsonPath('data.0.id', $order->id);
    }
}
