<?php

namespace Tests\Feature\Models\Order;

use App\Models\Product;
use Tests\CustomerTestCase;

class CreateOrderTest extends CustomerTestCase
{
    public function testCreateOrder(): void
    {
        $response = $this->postJson('/api/orders/', [
            'products' => [
                [
                    'product_id' => Product::query()->first()->getKey(),
                    'quantity' => 2,
                ]
            ]
        ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('orders', [
            'id' => $response['data']['id']
        ]);
    }
    public function testOrderMoreThanAvailableStock(): void
    {
        // Act
        $response = $this->postJson('/api/orders/', [
            'products' => [
                [
                    'product_id' => Product::query()->first()->getKey(),
                    'quantity' => 100,
                ]
            ]
        ]);

        // Assert
        $response->assertStatus(500);
        $this->assertDatabaseCount('orders', 0);
    }
    public function testOrderNotExistProduct(): void
    {
        // Act
        $response = $this->postJson('/api/orders/', [
            'products' => [
                [
                    'product_id' => rand(1000, 2000),
                    'quantity' => 1,
                ]
            ]
        ]);

        // Assert
        $response->assertStatus(422);
    }
}
