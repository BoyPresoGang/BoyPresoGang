<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DeliveryTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function test_store_saves_valid_delivery() // Happy Path
    {
        // Arrange
        $payload = [
            'customer_id' => 1,
            'delivery_date' => '2026-10-15',
            'status' => 'scheduled'
        ];

        // Act
        $response = $this->postJson('/api/deliveries', $payload);

        // Assert
        $response->assertStatus(201)
                 ->assertJsonPath('status', 201)
                 ->assertJsonPath('data.status', 'scheduled');
    }

    /** @test */
    public function test_store_rejects_invalid_status_enum() // Validation Failure
    {
        // Arrange
        $payload = [
            'customer_id' => 1,
            'delivery_date' => '2026-10-15',
            'status' => 'shipped'
        ];

        // Act
        $response = $this->postJson('/api/deliveries', $payload);

        // Assert
        $response->assertStatus(422)
                 ->assertJsonPath('status', 422)
                 ->assertJsonPath('field', 'status');
    }

    /** @test */
    public function test_store_rejects_malformed_date() // Edge Case
    {
        // Arrange
        $payload = [
            'customer_id' => 1,
            'delivery_date' => 'not-a-date',
            'status' => 'scheduled'
        ];

        // Act
        $response = $this->postJson('/api/deliveries', $payload);

        // Assert
        $response->assertStatus(422)
                 ->assertJsonPath('field', 'delivery_date');
    }
}