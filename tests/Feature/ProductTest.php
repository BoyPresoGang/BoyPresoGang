<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function test_store_saves_valid_product() // Happy Path
    {
        // Arrange
        $payload = ['name' => 'Keyboard', 'price' => 49.99, 'stock' => 10];

        // Act
        $response = $this->postJson('/api/products', $payload);

        // Assert
        $response->assertStatus(201)
                 ->assertJsonPath('status', 201)
                 ->assertJsonPath('data.name', 'Keyboard');
    }

    /** @test */
    public function test_store_rejects_string_price() // Validation Failure
    {
        // Arrange
        $payload = ['name' => 'Keyboard', 'price' => 'cake', 'stock' => 10];

        // Act
        $response = $this->postJson('/api/products', $payload);

        // Assert
        $response->assertStatus(422)
                 ->assertJsonPath('status', 422)
                 ->assertJsonPath('field', 'price');
    }

    /** @test */
    public function test_store_rejects_negative_stock() // Edge Case
    {
        // Arrange
        $payload = ['name' => 'Keyboard', 'price' => 49.99, 'stock' => -5];

        // Act
        $response = $this->postJson('/api/products', $payload);

        // Assert
        $response->assertStatus(422)
                 ->assertJsonPath('field', 'stock');
    }
}