<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

use App\Models\Customer;
use App\Models\Product;

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

    /** @test */
    public function test_store_rejects_nonexistent_customer_id() // Edge Case
    {
        // Arrange
        $product = Product::create([
            'name' => 'Test Water',
            'price' => 25.00,
            'stock' => 10,
        ]);
        $nonexistentCustomerId = (int) (Customer::max('id') ?? 0) + 1;
        $payload = [
            'customer_id' => $nonexistentCustomerId,
            'product_id' => $product->id,
            'quantity' => 1,
        ];

        // Act
        $response = $this->postJson('/api/orders', $payload);

        // Assert
        $response->assertStatus(422)
                 ->assertJsonPath('status', 422)
                 ->assertJsonPath('field', 'customer_id');
    }

    /** @test */
    public function test_store_rejects_quantity_above_product_stock() // Business Rule
    {
        // Arrange
        $customer = Customer::create([
            'name' => 'Order Customer',
            'contact_number' => '09123456789',
        ]);
        $product = Product::create([
            'name' => 'Limited Water',
            'price' => 25.00,
            'stock' => 1,
        ]);
        $payload = [
            'customer_id' => $customer->id,
            'product_id' => $product->id,
            'quantity' => 2,
        ];

        // Act
        $response = $this->postJson('/api/orders', $payload);

        // Assert
        $response->assertStatus(422)
                 ->assertJsonPath('status', 422)
                 ->assertJsonPath('field', 'quantity')
                 ->assertJsonPath('error', 'The requested quantity exceeds the available stock.');
    }

    /** @test */
    public function test_order_create_uses_visible_stock_feedback_for_over_stock_quantity() // UI Regression
    {
        // Act
        $response = $this->get('/orders/create');

        // Assert
        $response->assertOk()
                 ->assertSee('The requested quantity exceeds the available stock.')
                 ->assertSee("showFieldError(\n                    'quantity',")
                 ->assertDontSee('quantityInput.max = String(stock);');
    }
}
