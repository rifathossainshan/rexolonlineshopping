<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FrontendTest extends TestCase
{
    use RefreshDatabase;

    private $product;

    protected function setUp(): void
    {
        parent::setUp();

        // Setup data needed for frontend
        $category = Category::create(['name' => 'Test Cat', 'slug' => 'test-cat', 'status' => 1]);
        $this->product = Product::create([
            'title' => 'Frontend Product',
            'slug' => 'frontend-product',
            'category_id' => $category->id,
            'price' => 100,
            'stock' => 10,
            'status' => 1
        ]);
    }

    public function test_homepage_loads()
    {
        $response = $this->get(route('home'));
        $response->assertStatus(200);
        $response->assertSee('Frontend Product'); // Should see the new arrival
    }

    public function test_product_listing_loads()
    {
        $response = $this->get(route('products.index'));
        $response->assertStatus(200);
        $response->assertSee('Frontend Product');
    }

    public function test_product_detail_loads()
    {
        $response = $this->get(route('products.show', $this->product->slug));
        $response->assertStatus(200);
        $response->assertSee('Frontend Product');
    }

    public function test_cart_page_loads()
    {
        $response = $this->get(route('cart.index'));
        $response->assertStatus(200);
    }

    public function test_checkout_page_loads_with_items_in_cart()
    {
        // Add item to session cart so checkout doesn't redirect
        $cart = [
            $this->product->id => [
                'id' => $this->product->id,
                'name' => $this->product->title,
                'price' => $this->product->price,
                'quantity' => 1,
                'image' => 'test.jpg'
            ]
        ];

        $response = $this->withSession(['cart' => $cart])->get(route('checkout.index'));
        $response->assertStatus(200);
    }
}
