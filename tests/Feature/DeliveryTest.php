<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Customer;
use App\Models\Delivery;
use App\Models\Order;
use App\Models\Product;

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

    /** @test */
    public function test_store_rejects_delivery_date_in_the_past() // Validation Failure
    {
        // Arrange
        $customer = Customer::create([
            'name' => 'Delivery Customer',
            'contact_number' => '09123456789',
        ]);
        $product = Product::create([
            'name' => 'Delivery Water',
            'price' => 25.00,
            'stock' => 10,
        ]);
        $order = Order::create([
            'customer_id' => $customer->id,
            'product_id' => $product->id,
            'quantity' => 1,
        ]);
        $payload = [
            'order_id' => $order->id,
            'delivery_date' => '2020-01-01',
            'status' => 'scheduled',
        ];

        // Act
        $response = $this->postJson('/api/deliveries', $payload);

        // Assert
        $response->assertStatus(422)
                 ->assertJsonPath('status', 422)
                 ->assertJsonPath('field', 'delivery_date');
    }

    /** @test */
    public function test_store_rejects_order_with_another_active_delivery() // Business Rule
    {
        // Arrange
        $customer = Customer::create([
            'name' => 'Delivery Customer',
            'contact_number' => '09123456789',
        ]);
        $product = Product::create([
            'name' => 'Delivery Water',
            'price' => 25.00,
            'stock' => 10,
        ]);
        $order = Order::create([
            'customer_id' => $customer->id,
            'product_id' => $product->id,
            'quantity' => 1,
        ]);
        Delivery::create([
            'order_id' => $order->id,
            'customer_id' => $customer->id,
            'delivery_date' => '2099-01-01',
            'status' => 'scheduled',
        ]);
        $payload = [
            'order_id' => $order->id,
            'delivery_date' => '2099-01-02',
            'status' => 'scheduled',
        ];

        // Act
        $response = $this->postJson('/api/deliveries', $payload);

        // Assert
        $response->assertStatus(422)
                 ->assertJsonPath('status', 422)
                 ->assertJsonPath('field', 'order_id')
                 ->assertJsonPath('error', 'This order already has an active delivery.');
    }
}
