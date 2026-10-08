<?php

namespace Tests\Feature;

use App\Models\Customer;
use App\Models\Delivery;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthorizationTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;
    protected User $regularUser;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $this->regularUser = User::factory()->create([
            'role' => 'user',
        ]);
    }

    // ==========================================
    // A. CUSTOMER AUTHORIZATION
    // ==========================================

    public function test_admin_can_delete_customer(): void
    {
        $customer = Customer::create([
            'name' => 'Test Customer',
            'contact_number' => '09123456789',
        ]);

        $response = $this->actingAs($this->admin)
            ->deleteJson('/api/customers/' . $customer->id);

        $response->assertStatus(200)
            ->assertJsonPath('status', 200)
            ->assertJsonPath('message', 'Customer deleted successfully');

        $this->assertDatabaseMissing('customers', [
            'id' => $customer->id,
        ]);
    }

    public function test_regular_user_cannot_delete_customer(): void
    {
        $customer = Customer::create([
            'name' => 'Protected Customer',
            'contact_number' => '09123456789',
        ]);

        $response = $this->actingAs($this->regularUser)
            ->deleteJson('/api/customers/' . $customer->id);

        $response->assertStatus(403)
            ->assertJsonPath('status', 403)
            ->assertJsonPath('field', 'authorization')
            ->assertJsonPath('error', 'Forbidden: Only admins can delete customers');

        $this->assertDatabaseHas('customers', [
            'id' => $customer->id,
        ]);
    }

    public function test_guest_cannot_delete_customer(): void
    {
        $customer = Customer::create([
            'name' => 'Guest Target Customer',
            'contact_number' => '09123456789',
        ]);

        $response = $this->deleteJson('/api/customers/' . $customer->id);

        $response->assertStatus(403)
            ->assertJsonPath('status', 403)
            ->assertJsonPath('field', 'authorization');

        $this->assertDatabaseHas('customers', [
            'id' => $customer->id,
        ]);
    }

    // ==========================================
    // B. PRODUCT AUTHORIZATION
    // ==========================================

    public function test_admin_can_delete_product(): void
    {
        $product = Product::create([
            'name' => 'Mineral Water 500ml',
            'price' => 15.00,
            'stock' => 50,
        ]);

        $response = $this->actingAs($this->admin)
            ->deleteJson('/api/products/' . $product->id);

        $response->assertStatus(200)
            ->assertJsonPath('status', 200)
            ->assertJsonPath('message', 'Product deleted successfully');

        $this->assertDatabaseMissing('products', [
            'id' => $product->id,
        ]);
    }

    public function test_regular_user_cannot_delete_product(): void
    {
        $product = Product::create([
            'name' => 'Protected Product',
            'price' => 20.00,
            'stock' => 30,
        ]);

        $response = $this->actingAs($this->regularUser)
            ->deleteJson('/api/products/' . $product->id);

        $response->assertStatus(403)
            ->assertJsonPath('status', 403)
            ->assertJsonPath('field', 'authorization')
            ->assertJsonPath('error', 'Forbidden: Only admins can delete products');

        $this->assertDatabaseHas('products', [
            'id' => $product->id,
        ]);
    }

    public function test_guest_cannot_delete_product(): void
    {
        $product = Product::create([
            'name' => 'Guest Target Product',
            'price' => 25.00,
            'stock' => 10,
        ]);

        $response = $this->deleteJson('/api/products/' . $product->id);

        $response->assertStatus(403)
            ->assertJsonPath('status', 403)
            ->assertJsonPath('field', 'authorization');

        $this->assertDatabaseHas('products', [
            'id' => $product->id,
        ]);
    }

    // ==========================================
    // C. ORDER AUTHORIZATION
    // ==========================================

    public function test_admin_can_cancel_order_and_restore_stock(): void
    {
        $customer = Customer::create([
            'name' => 'Order Admin Customer',
            'contact_number' => '09123456789',
        ]);
        $product = Product::create([
            'name' => 'Order Admin Product',
            'price' => 25.00,
            'stock' => 5,
        ]);
        $order = Order::create([
            'customer_id' => $customer->id,
            'product_id' => $product->id,
            'quantity' => 3,
        ]);

        $response = $this->actingAs($this->admin)
            ->deleteJson('/api/orders/' . $order->id);

        $response->assertStatus(200)
            ->assertJsonPath('status', 200)
            ->assertJsonPath('message', 'Order cancelled successfully');

        $this->assertDatabaseMissing('orders', [
            'id' => $order->id,
        ]);

        $product->refresh();
        $this->assertEquals(8, $product->stock); // 5 initial + 3 restored
    }

    public function test_regular_user_cannot_cancel_order(): void
    {
        $customer = Customer::create([
            'name' => 'Order Regular Customer',
            'contact_number' => '09123456789',
        ]);
        $product = Product::create([
            'name' => 'Order Regular Product',
            'price' => 25.00,
            'stock' => 5,
        ]);
        $order = Order::create([
            'customer_id' => $customer->id,
            'product_id' => $product->id,
            'quantity' => 2,
        ]);

        $response = $this->actingAs($this->regularUser)
            ->deleteJson('/api/orders/' . $order->id);

        $response->assertStatus(403)
            ->assertJsonPath('status', 403)
            ->assertJsonPath('field', 'authorization')
            ->assertJsonPath('error', 'Forbidden: Only admins can cancel orders');

        $this->assertDatabaseHas('orders', [
            'id' => $order->id,
        ]);

        $product->refresh();
        $this->assertEquals(5, $product->stock);
    }

    public function test_guest_cannot_cancel_order(): void
    {
        $customer = Customer::create([
            'name' => 'Order Guest Customer',
            'contact_number' => '09123456789',
        ]);
        $product = Product::create([
            'name' => 'Order Guest Product',
            'price' => 25.00,
            'stock' => 5,
        ]);
        $order = Order::create([
            'customer_id' => $customer->id,
            'product_id' => $product->id,
            'quantity' => 1,
        ]);

        $response = $this->deleteJson('/api/orders/' . $order->id);

        $response->assertStatus(403)
            ->assertJsonPath('status', 403)
            ->assertJsonPath('field', 'authorization');

        $this->assertDatabaseHas('orders', [
            'id' => $order->id,
        ]);
    }

    // ==========================================
    // D. DELIVERY AUTHORIZATION
    // ==========================================

    public function test_admin_can_cancel_delivery(): void
    {
        $customer = Customer::create([
            'name' => 'Delivery Admin Customer',
            'contact_number' => '09123456789',
        ]);
        $product = Product::create([
            'name' => 'Delivery Admin Product',
            'price' => 30.00,
            'stock' => 10,
        ]);
        $order = Order::create([
            'customer_id' => $customer->id,
            'product_id' => $product->id,
            'quantity' => 2,
        ]);
        $delivery = Delivery::create([
            'customer_id' => $customer->id,
            'order_id' => $order->id,
            'delivery_date' => '2026-10-25',
            'status' => 'scheduled',
        ]);

        $response = $this->actingAs($this->admin)
            ->deleteJson('/api/deliveries/' . $delivery->id);

        $response->assertStatus(200)
            ->assertJsonPath('status', 200)
            ->assertJsonPath('message', 'Delivery status updated to cancelled');

        $delivery->refresh();
        $this->assertEquals('cancelled', $delivery->status);
    }

    public function test_regular_user_cannot_cancel_delivery(): void
    {
        $customer = Customer::create([
            'name' => 'Delivery User Customer',
            'contact_number' => '09123456789',
        ]);
        $product = Product::create([
            'name' => 'Delivery User Product',
            'price' => 30.00,
            'stock' => 10,
        ]);
        $order = Order::create([
            'customer_id' => $customer->id,
            'product_id' => $product->id,
            'quantity' => 1,
        ]);
        $delivery = Delivery::create([
            'customer_id' => $customer->id,
            'order_id' => $order->id,
            'delivery_date' => '2026-10-25',
            'status' => 'scheduled',
        ]);

        $response = $this->actingAs($this->regularUser)
            ->deleteJson('/api/deliveries/' . $delivery->id);

        $response->assertStatus(403)
            ->assertJsonPath('status', 403)
            ->assertJsonPath('field', 'authorization')
            ->assertJsonPath('error', 'Forbidden: Only admins can cancel deliveries');

        $delivery->refresh();
        $this->assertEquals('scheduled', $delivery->status);
    }

    public function test_guest_cannot_cancel_delivery(): void
    {
        $customer = Customer::create([
            'name' => 'Delivery Guest Customer',
            'contact_number' => '09123456789',
        ]);
        $product = Product::create([
            'name' => 'Delivery Guest Product',
            'price' => 30.00,
            'stock' => 10,
        ]);
        $order = Order::create([
            'customer_id' => $customer->id,
            'product_id' => $product->id,
            'quantity' => 1,
        ]);
        $delivery = Delivery::create([
            'customer_id' => $customer->id,
            'order_id' => $order->id,
            'delivery_date' => '2026-10-25',
            'status' => 'scheduled',
        ]);

        $response = $this->deleteJson('/api/deliveries/' . $delivery->id);

        $response->assertStatus(403)
            ->assertJsonPath('status', 403)
            ->assertJsonPath('field', 'authorization');

        $delivery->refresh();
        $this->assertEquals('scheduled', $delivery->status);
    }
}
