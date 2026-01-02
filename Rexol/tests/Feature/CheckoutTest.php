<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use App\Services\Payment\PaymentGatewayInterface;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Session;
use Tests\TestCase;
use Mockery;

class CheckoutTest extends TestCase
{
    use RefreshDatabase;

    private $user;
    private $category;

    protected function setUp(): void
    {
        parent::setUp();
        // Create user
        $this->user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
            'email_verified_at' => now(), // Important for 'verified' middleware
        ]);

        // Create category
        $this->category = Category::create(['name' => 'Test Category', 'slug' => 'test-category']);
    }

    public function test_it_prevents_checkout_if_out_of_stock()
    {
        // 1. Create Product with stock 1
        $product = Product::create([
            'category_id' => $this->category->id,
            'title' => 'Low Stock Product',
            'slug' => 'low-stock-product',
            'price' => 100,
            'stock' => 1,
            'status' => true,
        ]);

        // 2. Add 2 items to session cart
        $cart = [
            $product->id => [
                'id' => $product->id,
                'name' => $product->title,
                'quantity' => 2, // Ordering more than stock
                'price' => $product->price,
            ]
        ];
        Session::put('cart', $cart);

        // 3. Act as User & Attempt Checkout
        $response = $this->actingAs($this->user)
            ->post(route('checkout.store'), [
                'name' => 'John Doe',
                'phone' => '01712345678', // Valid BD Phone to pass validation
                'address' => '123 Street Address Check', // Valid Length
                'payment_method' => 'cod', // COD to just test stock logic first
            ]);

        // 4. Assert Redirect Back with Error
        $response->assertStatus(302);
        $response->assertSessionHas('error');
    }

    public function test_it_processes_payment_and_decrements_stock()
    {
        // 1. Mock Payment Gateway
        $this->mock(PaymentGatewayInterface::class, function ($mock) {
            $mock->shouldReceive('charge')
                ->once()
                ->andReturn(['id' => 'ch_test_123']); // Mimic success
        });

        // 2. Create Product with stock 10
        $product = Product::create([
            'category_id' => $this->category->id,
            'title' => 'In Stock Product',
            'slug' => 'in-stock-product',
            'price' => 100,
            'stock' => 10,
            'status' => true,
        ]);

        // 3. Add 1 item to cart
        $cart = [
            $product->id => [
                'id' => $product->id,
                'name' => $product->title,
                'quantity' => 1,
                'price' => $product->price,
            ]
        ];
        Session::put('cart', $cart);

        // 4. Attempt Stripe Checkout
        $response = $this->actingAs($this->user)
            ->post(route('checkout.store'), [
                'name' => 'John Doe',
                'phone' => '01712345678', // Valid BD Phone
                'address' => '123 Street Address Check', // Valid Length > 10
                'payment_method' => 'stripe',
                'stripeToken' => 'tok_visa',
            ]);

        // 5. Assert Success
        $response->assertRedirect(route('checkout.pending', 1));

        // 6. Assert Stock Decremented
        $this->assertEquals(9, $product->fresh()->stock);

        // 7. Assert Order Created
        $this->assertDatabaseHas('orders', [
            'user_id' => $this->user->id,
            'total_amount' => 100,
            'status' => 'processing', // Should be 'processing' for Stripe
            'payment_method' => 'stripe'
        ]);
    }

    public function test_it_validates_phone_number_format()
    {
        // 1. Create Product
        $product = Product::create([
            'category_id' => $this->category->id,
            'title' => 'Product',
            'slug' => 'p-1',
            'price' => 100,
            'stock' => 10,
            'status' => true,
        ]);

        Session::put('cart', [$product->id => ['id' => $product->id, 'name' => 'P', 'quantity' => 1, 'price' => 100]]);

        // 2. Submit Invalid Phone
        $response = $this->actingAs($this->user)
            ->post(route('checkout.store'), [
                'name' => 'John',
                'phone' => '12345', // Invalid
                'address' => 'Valid Address Long Enough',
                'payment_method' => 'cod',
            ]);

        $response->assertSessionHasErrors('phone');

        // 3. Submit Valid Phone
        $response = $this->actingAs($this->user)
            ->post(route('checkout.store'), [
                'name' => 'John',
                'phone' => '01700000000', // Valid BD
                'address' => 'Valid Address Long Enough',
                'payment_method' => 'cod',
            ]);

        $response->assertRedirect();
        $response->assertSessionDoesntHaveErrors();
    }
}
