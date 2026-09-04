<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrderTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function test_store_saves_valid_order() // Happy Path
    {
        // Arrange
        $payload = ['customer_id' => 1, 'product_id' => 2, 'quantity' => 3];

        // Act
        $response = $this->postJson('/api/orders', $payload);

        // Assert
        $response->assertStatus(201)
                 ->assertJsonPath('status', 201)
                 ->assertJsonPath('data.quantity', 3);
    }

    /** @test */
    public function test_store_rejects_zero_quantity() // Validation Failure
    {
        // Arrange
        $payload = ['customer_id' => 1, 'product_id' => 2, 'quantity' => 0];

        // Act
        $response = $this->postJson('/api/orders', $payload);

        // Assert
        $response->assertStatus(422)
                 ->assertJsonPath('status', 422)
                 ->assertJsonPath('field', 'quantity');
    }

    /** @test */
    public function test_store_rejects_missing_customer_id() // Edge Case
    {
        // Arrange
        $payload = ['product_id' => 2, 'quantity' => 1];

        // Act
        $response = $this->postJson('/api/orders', $payload);

        // Assert
        $response->assertStatus(422)
                 ->assertJsonPath('field', 'customer_id');
    }
}