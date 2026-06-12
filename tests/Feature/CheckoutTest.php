<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Outlet;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CheckoutTest extends TestCase
{
    use RefreshDatabase;

    public function test_checkout_reduces_stock_when_tracked(): void
    {
        $outlet = Outlet::create([
            'name' => 'Test Outlet',
            'address' => 'Test Address',
            'phone' => '1234567890',
        ]);

        $user = User::create([
            'name' => 'Test User',
            'username' => 'testuser',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
            'role' => 'owner',
            'outlet_id' => $outlet->id,
        ]);

        $category = Category::create([
            'name' => 'Test Category',
            'outlet_id' => $outlet->id,
        ]);

        $product = Product::create([
            'outlet_id' => $outlet->id,
            'category_id' => $category->id,
            'sku' => 'PROD-100',
            'name' => 'Test Product Tracked',
            'unit' => 'Pcs',
            'cost_price' => 5000,
            'selling_price' => 10000,
            'stock' => 10,
            'is_stock_tracked' => true,
        ]);

        $this->actingAs($user);

        $response = $this->postJson(route('pos.checkout'), [
            'cart' => [
                [
                    'id' => $product->id,
                    'qty' => 3,
                ],
            ],
            'pay_amount' => 33000, // including 10% tax (30000 + 3000)
            'payment_method' => 'cash',
        ]);

        $response->assertStatus(200);
        $response->assertJsonPath('success', true);

        $product->refresh();
        $this->assertEquals(7, $product->stock);
    }

    public function test_checkout_does_not_reduce_stock_when_not_tracked(): void
    {
        $outlet = Outlet::create([
            'name' => 'Test Outlet',
            'address' => 'Test Address',
            'phone' => '1234567890',
        ]);

        $user = User::create([
            'name' => 'Test User',
            'username' => 'testuser2',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
            'role' => 'owner',
            'outlet_id' => $outlet->id,
        ]);

        $category = Category::create([
            'name' => 'Test Category',
            'outlet_id' => $outlet->id,
        ]);

        $product = Product::create([
            'outlet_id' => $outlet->id,
            'category_id' => $category->id,
            'sku' => 'PROD-200',
            'name' => 'Test Product Not Tracked',
            'unit' => 'Pcs',
            'cost_price' => 5000,
            'selling_price' => 10000,
            'stock' => 10,
            'is_stock_tracked' => false,
        ]);

        $this->actingAs($user);

        $response = $this->postJson(route('pos.checkout'), [
            'cart' => [
                [
                    'id' => $product->id,
                    'qty' => 3,
                ],
            ],
            'pay_amount' => 33000, // including 10% tax (30000 + 3000)
            'payment_method' => 'cash',
        ]);

        $response->assertStatus(200);
        $response->assertJsonPath('success', true);

        $product->refresh();
        $this->assertEquals(10, $product->stock);
    }

    public function test_product_store_saves_stock_tracked_if_checkbox_checked(): void
    {
        $outlet = Outlet::create([
            'name' => 'Test Outlet',
            'address' => 'Test Address',
            'phone' => '1234567890',
        ]);

        $user = User::create([
            'name' => 'Test User',
            'username' => 'testuser3',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
            'role' => 'owner',
            'outlet_id' => $outlet->id,
        ]);

        $category = Category::create([
            'name' => 'Test Category',
            'outlet_id' => $outlet->id,
        ]);

        $this->actingAs($user);

        $response = $this->post(route('produk.store'), [
            'name' => 'New Product',
            'category_id' => $category->id,
            'cost_price' => 5000,
            'selling_price' => 10000,
            'stock' => 10,
            'unit' => 'Pcs',
            'sku' => 'PROD-STORE-1',
            'is_stock_tracked' => '1',
        ]);

        $response->assertStatus(302); // Redirect back

        $product = Product::where('sku', 'PROD-STORE-1')->first();
        $this->assertNotNull($product);
        $this->assertTrue((bool)$product->is_stock_tracked);
    }

    public function test_product_store_disables_stock_tracked_if_checkbox_unchecked(): void
    {
        $outlet = Outlet::create([
            'name' => 'Test Outlet',
            'address' => 'Test Address',
            'phone' => '1234567890',
        ]);

        $user = User::create([
            'name' => 'Test User',
            'username' => 'testuser4',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
            'role' => 'owner',
            'outlet_id' => $outlet->id,
        ]);

        $category = Category::create([
            'name' => 'Test Category',
            'outlet_id' => $outlet->id,
        ]);

        $this->actingAs($user);

        $response = $this->post(route('produk.store'), [
            'name' => 'New Product Unchecked',
            'category_id' => $category->id,
            'cost_price' => 5000,
            'selling_price' => 10000,
            'stock' => 10,
            'unit' => 'Pcs',
            'sku' => 'PROD-STORE-2',
            // is_stock_tracked is omitted
        ]);

        $response->assertStatus(302); // Redirect back

        $product = Product::where('sku', 'PROD-STORE-2')->first();
        $this->assertNotNull($product);
        $this->assertFalse((bool)$product->is_stock_tracked);
    }

    public function test_product_update_keeps_stock_tracked_if_checkbox_checked(): void
    {
        $outlet = Outlet::create([
            'name' => 'Test Outlet',
            'address' => 'Test Address',
            'phone' => '1234567890',
        ]);

        $user = User::create([
            'name' => 'Test User',
            'username' => 'testuser5',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
            'role' => 'owner',
            'outlet_id' => $outlet->id,
        ]);

        $category = Category::create([
            'name' => 'Test Category',
            'outlet_id' => $outlet->id,
        ]);

        $product = Product::create([
            'outlet_id' => $outlet->id,
            'category_id' => $category->id,
            'sku' => 'PROD-300',
            'name' => 'Test Product',
            'unit' => 'Pcs',
            'cost_price' => 5000,
            'selling_price' => 10000,
            'stock' => 10,
            'is_stock_tracked' => true,
        ]);

        $this->actingAs($user);

        $response = $this->put(route('produk.update', $product->id), [
            'name' => 'Updated Name',
            'category_id' => $category->id,
            'cost_price' => 5000,
            'selling_price' => 10000,
            'stock' => 10,
            'unit' => 'Pcs',
            'sku' => 'PROD-300',
            'is_stock_tracked' => '1',
        ]);

        $response->assertStatus(302); // Redirect back

        $product->refresh();
        $this->assertTrue((bool)$product->is_stock_tracked);
    }

    public function test_product_update_disables_stock_tracked_if_checkbox_unchecked(): void
    {
        $outlet = Outlet::create([
            'name' => 'Test Outlet',
            'address' => 'Test Address',
            'phone' => '1234567890',
        ]);

        $user = User::create([
            'name' => 'Test User',
            'username' => 'testuser6',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
            'role' => 'owner',
            'outlet_id' => $outlet->id,
        ]);

        $category = Category::create([
            'name' => 'Test Category',
            'outlet_id' => $outlet->id,
        ]);

        $product = Product::create([
            'outlet_id' => $outlet->id,
            'category_id' => $category->id,
            'sku' => 'PROD-400',
            'name' => 'Test Product',
            'unit' => 'Pcs',
            'cost_price' => 5000,
            'selling_price' => 10000,
            'stock' => 10,
            'is_stock_tracked' => true,
        ]);

        $this->actingAs($user);

        $response = $this->put(route('produk.update', $product->id), [
            'name' => 'Updated Name',
            'category_id' => $category->id,
            'cost_price' => 5000,
            'selling_price' => 10000,
            'stock' => 10,
            'unit' => 'Pcs',
            'sku' => 'PROD-400',
            // is_stock_tracked is omitted (unchecked)
        ]);

        $response->assertStatus(302); // Redirect back

        $product->refresh();
        $this->assertFalse((bool)$product->is_stock_tracked);
    }
}
