<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Customer;

class CustomerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function test_store_saves_valid_customer() // Happy Path
    {
        // Arrange
        $payload = ['name' => 'John Doe', 'contact_number' => '1234567890'];

        // Act
        $response = $this->postJson('/api/customers', $payload);

        // Assert
        $response->assertStatus(201)
                 ->assertJsonPath('status', 201)
                 ->assertJsonPath('data.name', 'John Doe');
    }

    /** @test */
    public function test_store_rejects_short_name() // Validation Failure
    {
        // Arrange
        $payload = ['name' => 'A', 'contact_number' => '1234567890'];

        // Act
        $response = $this->postJson('/api/customers', $payload);

        // Assert
        $response->assertStatus(422)
                 ->assertJsonPath('status', 422)
                 ->assertJsonPath('field', 'name');
    }

    /** @test */
    public function test_show_returns_404_for_non_existent_customer() // Edge Case
    {
        // Act
        $response = $this->getJson('/api/customers/9999');

        // Assert
        $response->assertStatus(404);
    }
}