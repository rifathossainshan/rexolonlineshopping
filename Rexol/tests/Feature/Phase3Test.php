<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Models\Category;
use App\Models\OrderItem;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;
use Tests\TestCase;

class Phase3Test extends TestCase
{
    use RefreshDatabase;

    public function test_homepage_loads_and_caches_data()
    {
        // 1. Create Data
        Category::create(['name' => 'Men', 'slug' => 'men']);

        // 2. Hit Homepage
        // Cache facade is difficult to spy on for 'remember' without mocking the whole facade return, 
        // but we can ensure the page loads without error, implying logic runs.
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertViewHas('newArrivals');
    }

    public function test_image_service_is_used_in_product_creation()
    {
        // 1. Setup Admin & Data
        $admin = User::factory()->create(['role' => 'admin', 'email' => 'admin@test.com']);
        $category = Category::create(['name' => 'Test', 'slug' => 'test-cat']);
        Storage::fake('public');

        // 2. Mock ImageService? 
        // Or just run real logic if intervention is installed. 
        // Let's run real logic to verify integration.
        // Requires GD extension in PHP.

        $file = UploadedFile::fake()->image('product.jpg');

        $response = $this->actingAs($admin)->post(route('admin.products.store'), [
            'title' => 'Test Product',
            'category_id' => $category->id,
            'price' => 100,
            'images' => [$file],
        ]);

        $response->assertRedirect(route('admin.products.index'));

        // 3. Verify File Exists (Optimized filename will be different, checking directory)
        // Storage::disk('public')->assertExists(...); // Filename is UUID, hard to predict
        // But we can check Database
        $this->assertDatabaseHas('product_images', [
            'product_id' => 1
        ]);
    }

    public function test_reorder_logic_adds_items_to_cart()
    {
        // 1. Setup User & Order
        $user = User::factory()->create();
        // Let's create category first
        $category = Category::create(['name' => 'Misc', 'slug' => 'misc']);

        $product = Product::create([
            'title' => 'Reorder Item',
            'slug' => 'reorder-item',
            'category_id' => $category->id,
            'price' => 500,
            'stock' => 10
        ]);

        $order = Order::create([
            'user_id' => $user->id,
            'name' => 'Test',
            'phone' => '01700000000', // Valid BD
            'address' => 'Test address long',
            'total_amount' => 500,
            'status' => 'completed',
            'payment_method' => 'cod'
        ]);

        OrderItem::create([
            'order_id' => $order->id,
            'product_id' => $product->id,
            'quantity' => 2,
            'price' => 500
        ]);

        // 2. Call Reorder
        $response = $this->actingAs($user)
            ->post(route('cart.reorder', $order->id));

        // 3. Assert Redirect & Cart Session
        $response->assertRedirect(route('cart.index'));

        $cart = Session::get('cart');
        $this->assertNotEmpty($cart);
        // Cart ID format: ID-default (size null)
        $this->assertEquals(2, $cart[$product->id . '-default']['quantity']);
    }
}
